<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Potwierdzenie rejestracji konta na Land of Shadows</title>
    <style>
        /* Inline styles for simplicity, consider using CSS classes for larger templates */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f1f1f1;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            max-width: 200px;
        }

        .message {
            padding: 20px;
            background-color: #ffffff;
        }

        .message p {
            margin-bottom: 10px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        
        <div class="message">
            <p>Dear {{ $name }}, Witaj w Land of Shadows</p>
            <p>Aby potwierdzić rejestrację konta na LoS kliknij w link poniżej:<br><br></p>
            <p><a href="https://los.vigames.eu/aktywacja/{{$aktywacja}}"> aktywuj konto </a></p>
            <p><br><br>Dziękujemy, że zdecydowałeś się do nas dołączyć.<br><br></p>
            <p>Zespół Land of Shadows<br><br></p>
            <p>Jesli bedziesz mial jakiekolwiek pytania, watpliwosci do Twojej dyspozycji  pozostaje nasz support jak i karta
               spolecznosci na naszej stronie Facebook. Nie wachaj sie przed kontaktem, jestesmy do Twojej dyspozycji<br><br></p>
            <p>Mineły dziesiątki lat. Kraje które władały kontynentem rozpadły się. Wędrowni 
                bardowie tworzą o nich barwne , prawdziwe bardziej lub mniej opowieści.
                Ale świat nie znosi pustki. Pewnie sami bogowie ciekawi są jak teraz ukształtuje
                się kontynent i kto założy pierwszy koronę. No i jaką .....</p>
        </div>
        
    </div>
</body>

</html>