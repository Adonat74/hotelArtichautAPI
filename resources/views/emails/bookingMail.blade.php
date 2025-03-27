<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Welcome to Our Platform</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cardo:ital,wght@0,400;0,700;1,400&family=Montserrat:ital,wght@0,100..900;1,100..900&family=MuseoModerno:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cardo:ital,wght@0,400;0,700;1,400&family=Lora:ital,wght@0,400..700;1,400..700&family=Montserrat:ital,wght@0,100..900;1,100..900&family=MuseoModerno:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
{{--    <style>--}}
{{--        body {--}}
{{--            font-family: Lora, Arial, sans-serif;--}}
{{--            width: 100%;--}}
{{--            height: 100%;--}}
{{--            margin: 0;--}}
{{--            padding: 0;--}}
{{--            background-color: #FBF9F4;--}}
{{--            color: #273425;--}}
{{--        }--}}
{{--        h1, h2, h3, h4, h5, h6 {--}}
{{--            font-family: Cardo, Arial, sans-serif;--}}
{{--            font-weight: 300;--}}
{{--            margin: 0;--}}
{{--        }--}}
{{--        header{--}}
{{--            font-family: Cardo, Arial, sans-serif;--}}
{{--            color: #EAC684;--}}
{{--            background-color: #4B6547;--}}
{{--            font-size: 4rem;--}}
{{--            text-align: center;--}}
{{--            padding: 60px 0 0 40px;--}}
{{--        }--}}
{{--        .title {--}}
{{--            font-size: 3rem;--}}
{{--            margin: 20px 0;--}}
{{--        }--}}
{{--        h3{--}}
{{--            font-size: 2rem;--}}
{{--        }--}}
{{--        main {--}}
{{--            width: 100%;--}}
{{--            height: 100%;--}}
{{--            text-align: center;--}}
{{--        }--}}
{{--        .piscine {--}}
{{--            width: 100%;--}}
{{--            height: 500px;--}}
{{--            object-fit: cover;--}}
{{--            border-top: 25px solid #EAC684;--}}
{{--            border-bottom: 25px solid #EAC684;--}}
{{--        }--}}
{{--        .info_container {--}}
{{--            width: 100%;--}}
{{--            display: flex;--}}
{{--            flex-direction: row;--}}

{{--        }--}}
{{--        .info {--}}
{{--            width: 100%;--}}
{{--            background-color: #F1EBD9;--}}
{{--            margin: 10px;--}}
{{--            font-size: 1.3rem;--}}
{{--            padding: 50px;--}}
{{--            text-align: start;--}}
{{--        }--}}
{{--        .cocktail {--}}
{{--            width: 100%;--}}
{{--            height: 500px;--}}
{{--            object-fit: cover;--}}
{{--        }--}}
{{--        .logo {--}}
{{--            text-align: center;--}}
{{--            width: 50%;--}}
{{--        }--}}
{{--        .message {--}}
{{--            font-size: 3rem;--}}
{{--        }--}}
{{--        footer {--}}
{{--            text-align: center;--}}
{{--            margin-top: 20px;--}}
{{--        }--}}
{{--    </style>--}}
    <style type="text/css">
        /* Styles de base */
        body {
            font-family: Lora, Arial, sans-serif;
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #FBF9F4;
            color: #273425;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: Cardo, Arial, sans-serif;
            font-weight: 300;
            margin: 0;
        }
        header {
            font-family: Cardo, Arial, sans-serif;
            color: #EAC684;
            background-color: #4B6547;
            font-size: 4rem;
            text-align: center;
            padding: 60px 0 0 40px;
        }
        .title {
            font-size: 3rem;
            margin: 20px 0;
        }
        h3 {
            font-size: 2rem;
        }
        main {
            width: 100%;
            height: 100%;
            text-align: center;
        }
        .piscine {
            width: 100%;
            height: 500px;
            object-fit: cover;
            border-top: 25px solid #EAC684;
            border-bottom: 25px solid #EAC684;
        }
        .info_container {
            width: 100%;
            display: flex;
            flex-direction: row;
        }
        .info {
            width: 100%;
            background-color: #F1EBD9;
            margin: 10px;
            font-size: 1.3rem;
            padding: 50px;
            text-align: start;
        }
        .cocktail {
            width: 100%;
            height: 500px;
            object-fit: cover;
        }
        .logo {
            text-align: center;
            width: 50%;
        }
        .message {
            font-size: 3rem;
        }
        footer {
            text-align: center;
            margin-top: 20px;
        }

        @media only screen and (max-width: 600px) {
            header {
                font-size: 2.5rem;
                padding: 40px 0 0 20px;
            }
            .title {
                font-size: 2rem;
                margin: 10px 0;
            }
            h3 {
                font-size: 1.5rem;
            }
            .info_container {
                flex-direction: column;
            }
            .info {
                padding: 20px;
                font-size: 1rem;
                margin: 5px;
            }
            .piscine,
            .cocktail {
                height: auto;
            }
            .logo {
                width: 80%;
            }
            .message {
                font-size: 2rem;
            }
        }

        @media only screen and (min-width: 601px) and (max-width: 900px) {
            header {
                font-size: 3rem;
                padding: 50px 0 0 30px;
            }
            .title {
                font-size: 2.5rem;
                margin: 15px 0;
            }
            h3 {
                font-size: 1.8rem;
            }
            .info {
                padding: 30px;
                font-size: 1.1rem;
                margin: 10px;
            }
            .logo {
                width: 60%;
            }
            .message {
                font-size: 2.5rem;
            }
        }
    </style>
</head>

<body>
<header>
    <div>
        <h1>L'Artichaut</h1>
        <h2>* * *</h2>
    </div>
</header>
<main>
    <img class="piscine" src="{{ url('images/piscine.png') }}" alt="piscine">

    <h2 class="title">Prenez place, votre aventure va commencer...</h2>
    <div class="info_container">

        <div class="info">
            <h3>Vos informations</h3>
            <p>Nom : {{ $user_lastname }}</p>
            <p>Prénom : {{ $user_firstname }}</p>
            <p>Adresse : {{ $user_address }}</p>
            <p>Code postal : {{ $user_postal_code }}</p>
            <p>Ville : {{ $user_city }}</p>
            <p>Téléphone : {{ $user_phone }}</p>
            <p>Email : {{ $user_email }}</p>
        </div>

        <div class="info">
            <h3>Mon séjour</h3>
            <p>Date de début : {{ $booking_check_in }}</p>
            <p>Date de fin : {{ $booking_check_out }}</p>
            <p>Prix total : {{ $booking_price }}</p>
            <p>Nombre de personnes : {{ $booking_number_person }}</p>
            <p>Services :</p>
            @foreach ($services as $service)
                <p>  -  {{ $service->title }}</p>
            @endforeach
        </div>
    </div>

    <img src="{!! $message->embedData((string) QrCode::format('png')->size(300)->generate('http://192.168.1.245:8000/qr/reservation/'.$booking_id), 'QrCode.png', 'image/png') !!}" alt="qr code">

    <h2 class="title">Cadeau de bienvenue</h2>
    <img class="cocktail" src="{{ url('images/cocktail.png') }}" alt="cocktail">
    <p class="message">A votre arrivée vous aurez un cocktail de votre choix offert de notre barman.</p>
</main>
<footer>
    <img class="logo" src="{{ url('images/logo.png') }}" alt="logo">
</footer>
</body>
</html>
