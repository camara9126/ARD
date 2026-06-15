<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portail SPI - Connexion</title>
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #0d1117;
            display: flex;
            flex-direction: column; /* Aligne le bandeau en haut et centre le reste en dessous */
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }

        /* ==========================================================================
        STYLE DU BANDEAU DÉFILANT TOP (Ajouté)
        ========================================================================== */
        .top-ticker {
            position: absolute;
            top: 40px;
            left: 10px;
            width: 100%;
            height: 60px;
            background-color: #0c1524;
            border-bottom: 2px solid #448aff;
            border-top: 2px solid #448aff; /* Ligne sous le bandeau couleur BCM */
            display: flex;
            align-items: center;
            overflow: hidden; /* Cache tout ce qui dépasse */
            z-index: 1000;
        }

        .ticker-wrap {
            display: flex;
            width: max-content;
            white-space: nowrap;
        }

        .ticker-item {
            display: inline-block;
            padding-right: 50px; /* Espace entre les deux blocs de texte répétés */
            font-size: 14px;
            color: #ffffff;
            font-weight: 500;
            letter-spacing: 0.5px;
            /* Lance l'animation de défilement infini */
            animation: tickerMarquee 25s linear infinite; 
        }

        /* Lien email à l'intérieur du bandeau */
        .ticker-item a {
            color: #448aff;
            text-decoration: none;
            font-weight: bold;
        }

        /* Animation CSS pour le défilement fluide de droite à gauche */
        @keyframes tickerMarquee {
            0% {
                transform: translate3d(0, 0, 0);
            }
            100% {
                transform: translate3d(-50%, 0, 0);
            }
        }

        /* Met l'animation en pause lorsque la souris survole le texte */
        .top-ticker:hover .ticker-item {
            animation-play-state: paused;
        }

        /* ==========================================================================
        STRUCTURE DE LA CARTE DE CONNEXION (CONTAINER)
        ========================================================================== */
        .container {
            position: relative;
            width: 768px;
            height: 450px;
            background: transparent;
            border: 2px solid #448aff; /* Bleu BCM-GROUPE */
            box-shadow: 0 0 25px rgba(0, 74, 173, 0.4);
            border-radius: 12px;
            overflow: hidden;
            margin-top: 40px; /* Compense la hauteur du bandeau */
        }

        /* Formulaires */
        .form-container {
            position: absolute;
            top: 0;
            height: 100%;
            transition: all 0.6s ease-in-out;
            background-color: #0d1117;
        }

        .sign-in-container {
            left: 0;
            width: 50%;
            z-index: 2;
        }

        .sign-up-container {
            left: 0;
            width: 50%;
            opacity: 0;
            z-index: 1;
        }

        form {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 0 40px;
            height: 100%;
            text-align: center;
        }

        h2 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 25px;
            text-transform: capitalize;
        }

        /* Champs de saisie */
        .input-group {
            position: relative;
            width: 100%;
            margin: 10px 0;
            border-bottom: 2px solid #454f5b;
        }

        .input-group input {
            width: 100%;
            padding: 10px 0 10px 10px;
            background: transparent;
            border: none;
            outline: none;
            color: #ffffff;
            font-size: 15px;
        }

        .input-group i {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #448aff;
            font-size: 16px;
        }

        /* Boutons d'action */
        .btn-main {
            border-radius: 20px;
            border: 1px solid #448aff;
            background-color: #448aff;
            color: #ffffff;
            font-size: 14px;
            font-weight: bold;
            padding: 12px 45px;
            letter-spacing: 1px;
            text-transform: capitalize;
            cursor: pointer;
            margin-top: 20px;
            transition: transform 80ms ease-in, background-color 0.3s ease;
        }

        .btn-main:hover {
            background-color: #002855;
            border-color: #002855;
        }

        .btn-main:active {
            transform: scale(0.95);
        }

        .switch-text {
            color: #a3b3c2;
            font-size: 12px;
            margin-top: 15px;
        }

        .switch-text span {
            color: #448aff;
            font-weight: bold;
            cursor: pointer;
            text-transform: capitalize;
        }

        /* Overlay Diagonal */
        .overlay-container {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: transform 0.6s ease-in-out;
            z-index: 100;
        }

        .overlay {
            background: linear-gradient(135deg, #002855 0%, #448aff 100%);
            background-repeat: no-repeat;
            background-size: cover;
            color: #ffffff;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }

        .overlay-panel {
            position: absolute;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 0 40px;
            text-align: center;
            top: 0;
            height: 100%;
            width: 50%;
            transform: translateX(0);
            transition: transform 0.6s ease-in-out;
        }

        .overlay-left {
            transform: translateX(-200%);
        }

        .overlay-right {
            right: 0;
            transform: translateX(0);
        }

        .overlay-panel h1 {
            font-size: 32px;
            margin-bottom: 15px;
        }

        .overlay-panel p {
            font-size: 14px;
            line-height: 20px;
            opacity: 0.8;
        }

        /* Déclenchements de l'animation */
        .container.right-panel-active .sign-in-container {
            transform: translateX(100%);
            opacity: 0;
        }

        .container.right-panel-active .sign-up-container {
            transform: translateX(100%);
            opacity: 1;
            z-index: 5;
            animation: show 0.6s;
        }

        .container.right-panel-active .overlay-container {
            transform: translateX(-100%);
        }

        .container.right-panel-active .overlay {
            transform: translateX(50%);
        }

        .container.right-panel-active .overlay-left {
            transform: translateX(0);
        }

        .container.right-panel-active .overlay-right {
            transform: translateX(200%);
        }

        @keyframes show {
            0%, 49.99% {
                opacity: 0;
                z-index: 1;
            }
            50%, 100% {
                opacity: 1;
                z-index: 5;
            }
        }
    </style>
</head>
<body>

    <div class="top-ticker">
        <div class="ticker-wrap">
            <div class="ticker-item">
                Bienvenue sur le SPI (Système de Pilotage Intégré) de l'ARD Saint-Louis. Votre ERP 360 conçu et développé par BCM-GROUPE. Pour toute assistance, contactez-nous à : contact@bcmgroupe.com
            </div>
            <div class="ticker-item">
                Bienvenue sur le SPI (Système de Pilotage Intégré) de l'ARD Saint-Louis. Votre ERP 360 conçu et développé par BCM-GROUPE. Pour toute assistance, contactez-nous à : contact@bcmgroupe.com
            </div>
        </div>
    </div>

    <div class="container" id="container">
         @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif 

        @if(Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
        @elseif(Session::has('danger'))
            <div class="alert alert-danger" role="alert">
                {{ Session::get('danger') }}
            </div>
        @endif

        <div class="form-container sign-up-container">
            <form method="post" action="{{ route('register') }}">
                @csrf
                <h2>S'inscrire</h2>
                <div class="input-group">
                    <input type="text" name="name" placeholder="Nom utilisateur" required>
                    <i class="fas fa-user"></i>
                </div>
                <div class="input-group">
                    <input type="email" name="email" placeholder="Votre Email" required>
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Mot de Passe" required>
                    <i class="fas fa-lock"></i>
                </div>
                <div class="input-group">
                    <input type="password" name="password_comfirmation" placeholder="Confirmez le mot de passe" required>
                    <i class="fas fa-lock"></i>
                </div>
                <button type="submit" class="btn-main">S'inscrire</button>
                <p class="switch-text">Vous avez déjà un compte ?  <span id="to-login">Se connecter</span></p>
            </form>
        </div>

       

        <div class="form-container sign-in-container">
            <form method="post" action="{{ route('login') }}">
                @csrf
                <h2>Se Connecter</h2>
                <div class="input-group">
                    <input type="email" name="email" placeholder="Email" required>
                    <i class="fas fa-user"></i>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Mot de passe" required>
                    <i class="fas fa-lock"></i>
                </div>
                <button type="submit" class="btn-main">Se Connecter</button>
                <p class="switch-text">Vous n'avez pas de compte ? <span id="to-signup"> Inscrivez-vous</span></p>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>CONTENT DE VOUS REVOIR !</h1>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ut provident dolorem, error</p>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>CONTENT DE VOUS REVOIR !</h1>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ut provident dolorem, error</p>
                </div>
            </div>
        </div>

    </div>

    <script>
        const container = document.getElementById('container');
        const toSignUp = document.getElementById('to-signup');
        const toLogin = document.getElementById('to-login');

        toSignUp.addEventListener('click', () => {
            container.classList.add("right-panel-active");
        });

        toLogin.addEventListener('click', () => {
            container.classList.remove("right-panel-active");
        });
    </script>
</body>
</html>
