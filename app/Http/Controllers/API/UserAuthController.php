<?php

namespace App\Http\Controllers\API;

use App\Mail\WelcomeEmail;
use App\Mail\PasswordReset;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Crypt;
use DB;


class UserAuthController extends Controller
{
    

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|unique:users',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $errors = json_decode($errors, true);
            return response('{"message": "'.$errors['email'][0].'"}', 400);
        }

        if ($validator->passes()) {
            $registerUserData = $request->validate([
                'email' => 'required|string|email|unique:users',
                'password' => 'required|min:8'
            ]);
            $user = User::create([
                'name' => '',
                'last_name' => '',
                'email' => $registerUserData['email'],
                'password' => Hash::make($registerUserData['password']),
            ]);
            $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;
            [$id, $token] = explode('|', $token, 2);
            Mail::to($registerUserData['email'])->send(new WelcomeEmail($registerUserData['email'], $token ));
            return response('{"message": "register_ok"}', 201);
        }
    }

    public function aktywacja(Request $request){

        $check_token = DB::table('personal_access_tokens')->where('token', hash('sha256', $request->token))->first();

        if (!$check_token){
            $return['message'] = 'token_error';
            return response()->json($return);
        }

        $check_user = DB::table('users')->where('id', $check_token->tokenable_id)->get()->first();

        if ($check_user->email_verified_at == null){
            $return['message'] = 'verify'; 
            $check_user = DB::table('users')->where('id', $check_token->tokenable_id)->update(['email_verified_at' => date("Y-m-d H:i:s")]);
            return response()->json($return);
        } else {
            $return['message'] = 'verify_already';
            return response()->json($return);
        }

    }


    public function login(Request $request)
    {
        $loginUserData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|min:8'
        ]);
        $user = User::where('email', $loginUserData['email'])->first();
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response('{"message": "login_error"}', 401);
        }
        if($user->email_verified_at == null){
            return response('{"message": "not_active"}', 401);
        }
        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;
        $return['message'] = $token;
        $return['user'] = $user;
        return response()->json($return);
    }
    public function profileUpdate(Request $request)
    {
        $user = Auth::user();
        $user->name = $request->firstName;
        $user->last_name = $request->LastName;
        $user->email = $request->email;
        $user->save();
        return $this->response($user, "Profile updated successfully", 200);
    }

    public function settingsUpdate(Request $request)
    {
        $user = Auth::user();
        $user->settings = $request->settings;
        $user->save();
        return $this->response($user, "Profile settings updated successfully", 200);
    }

    public function changePassword(Request $request)
    {
        $user = User::whereEmail($request->email)->first();
        if (Hash::check($request->oldPassword, $user->password)) {
            $user->password = Hash::make($request->newPassword);
            return $this->response(null, "Password change successfully", 200);
        }
        return $this->error('Password do not match our records.', 400);
    }

    public function forget(Request $request)
    {
        $user = User::whereEmail($request->email)->first();
        if ($user) {
            $token = Password::getRepository()->create($user);
            $user->remember_token = $token;
            $user->save();
            Mail::to($request->email)->send(new PasswordReset($request->email, $token ));
            return response('{"message": "email_sended"}', 200);
        }
        return response('{"message": "email_error"}', 400);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'password' => 'required|min:8'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $errors = json_decode($errors, true);
            return response($errors['email'][0], 400);
        }

        if ($validator->passes()) {
            $user = User::where('remember_token', $request->token)->first();
            if ($user){
                $user->password = Hash::make($request->password);
                $user->remember_token = null;
                $user->save();
                return response('{"message": "password_reset"}', 200);
            } else {
                return response('{"message": "reset_error"}', 400);
            }
        }
        
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return $this->response(null, 'logged out', 200);

    }

    public function accountDelete(Request $request)
    {

        $user = Auth::user();
        $user->each->delete();
        return $this->response(null, 'Account Delete successfully', 200);

    }

}