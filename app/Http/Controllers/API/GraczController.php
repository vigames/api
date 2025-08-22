<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\gracz;
use DB;


class GraczController extends Controller
{


    public function setPostac(Request $request){

        $user = Auth::user();
        $panstwo[1] = array(
                        '75',
                        '125',
                        '100',
                        '200'
                    );
        $panstwo[2] = array(
                        '1',
                        '75',
                        '100',
                        '200'
                    );
        $panstwo[3] = array(
                        '1',
                        '100',
                        '1',
                        '100'
                    );
        $panstwo[4] = array(
                        '125',
                        '200',
                        '100',
                        '200'
                    );
        $panstwo[5] = array(
                        '100',
                        '200',
                        '1',
                        '100'
                    );

        $validator = Validator::make($request->all(), [
            'postac' => 'required|min:5',
            'nacja' => 'required|min:1'
        ]);            

        if ($validator->fails()) {
            $errors = $validator->errors();
            $errors = json_decode($errors, true);
            return response('{"message": "'.$errors.'"}', 400);
        }

        if ($validator->passes()) { 

        Gracz::insert(
            [   'id' => $user->id, 
                'postac' => $request->postac,
                'nacja' => $request->narodowosc,
            ]
        );
        
        $wioska = DB::table('mapas')->where('wioska', 0)->where('x', '>', $panstwo[$request->narodowosc][0])->where('x', '<', $panstwo[$request->narodowosc][1])
        ->where('y', '>', $panstwo[$request->narodowosc][2])->where('y', '<', $panstwo[$request->narodowosc][3])->inRandomOrder()->first();

        DB::table('mapas')->where('id', $wioska->id )->update(['wioska' => 1]);

        $powitaj = $this->komunikatPowitalny();
        $this->poczta(1,$powitaj[0],$powitaj[1],0,$user->id, $request);

        $wioskaId = DB::table('wioskas')->insertGetId(
                ['gracz' => $user->id,
                 'x' => $wioska->x, 
                 'y' => $wioska->y,
                 'nazwa' => 'Wioska ' . $request->postac,
                 'produkcja' => time(),
                 'zalozenie'=> time(),
                 'glowna' => 1
                ]
            );

        DB::table('budowas')->insert(['id_gracz' => $user->id , 'id_wioski' => $wioskaId ,'id_budynku' => 1, 'poziom' => 1, 'czas' =>  time(), 'zakonczona' => time()]);
        DB::table('towar_wioskis')->insert(['id_wioski' => $wioskaId ]);
        DB::table('budynki_wioskis')->insert(['id_wioski' => $wioskaId , 'budynek' => 1, 'poziom' => 1 ]);    
        DB::table('poziomy_graczas')->insert(['gracz' => $user->id]);         


        $user->first_login = 1;
        $user->save();

        return response()->json($wioska); 
        
        }

    }

    private function komunikatPowitalny(){
        $komunikat[0] = 'Witaj w cieniu zwanym Virlandią';
        $komunikat[1] = 'Witaj na ziemiach kontynentu Virlandia.<br><br>
                        Najistotniejszym posunięciem jest zabezpieczenie sobie produkcji surowców.<br>

                        Żywności (mięso,pieczywo)<br> <br>
                        * gospodarstwo -> młyn -> piekarnia : pieczywo<br>
                        * gospodarstwo -> hodowla bydła -> rzeźnia : mięso<br><br>
                        Surowców (drewno,kamień,narzędzia)<br><br>
                        * tartak : drewno<br>
                        * kamieniołom : kamień<br>
                        * warsztat : narzędzia<br><br>

                        Są to podstawowe potrzeby wioski by była wstanie rozwijać dalej budynki <br>
                        i nie ponosiła strat związanych z nie zadowoleniem jej mieszkańców.<br><br>
                        Uwaga! Raporty produkcyjne do 15 poziomu budynku gospodarczego pierwszej wioski
                        tylko raportują wystąpienie niezadowolenia w wiosce. Natomiast w momencie gdy posiadasz
                        budynek gospodarczy na poziomi 16 i większym niezadowolenie będzie faktem i wpłynie na
                        produkcję wioski. Pamiętaj więc że budując budynek gospodarczy na poziom 16 powineneś 
                        już starannie zadbać o zbilansowanie potrzeb i produkcji wioski<br> 
                        Każda następna wioska musi być balansowana od postawienia pierwszego budynku<br><br>
                        Wykorzystaj również pierwsze dni na rozpoznanie terenu, <br> 
                        nawiązanie kontaktów z sąsiadami. Zapoznanie się z najbliższą <br>
                        okolicą może być nieocenione.<br><br>
                        Mamy nadzięję iż odnajdziesz się w naszym świecie i to właśnie Tobie uda się doprowadzić kontynent
                        do kolejnych dni chwały.<br><br>
                        Zespół LoS';
        return  $komunikat;               
    }

    public function poczta($typ = null,$temat,$tresc,$od,$do,Request $request){ //$typ=1 - system

        if ($typ==1){
            DB::table('pocztas')->insert( ['od' => $od, 'do' => $do, 'temat' => $temat, 'tresc' => $tresc]);
        } else {

        }

    }



}
?>