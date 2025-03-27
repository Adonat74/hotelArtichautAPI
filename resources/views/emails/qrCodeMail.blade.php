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
    <style>
        /* Inline styles for simplicity, consider using CSS classes for larger templates */
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
        header{
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
        h3{
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

    <h2 class="title">Chère {{ $user_firstname }}, voici votre QR code pour votre séjour chez nous. Il vous servira à ajouter automatiquement des services aux bornes dédiées à cet effet en le scannant.</h2>
    <img src="{!! $message->embedData((string) QrCode::format('png')->size(300)->generate($user_id), 'QrCode.png', 'image/png') !!}" alt="qr code">
</main>

<footer>
    <img class="logo" src="{{ url('images/logo.png') }}" alt="logo">
</footer>
</body>
</html>
