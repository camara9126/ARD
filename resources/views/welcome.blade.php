<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Portail SPI - Connexion</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Icones Logo -->
    <link rel="icon" href="{{ asset('assets/images/images/logoard.jpg.webp') }}" type="image/x-icon">
    <style>
        /* ========== RESET & BASE ========== */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #0d1117;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 0 12px 30px 12px;
            overflow-x: hidden;
        }

        /* ========== BANDEAU DÉFILANT (TOP) ========== */
        .top-ticker {
            width: 100%;
            /*max-width: 768px;*/
            height: 54px;
            background-color: #0c1524;
            border-top: 2px solid #448aff;
            border-bottom: 2px solid #448aff;
            display: flex;
            align-items: center;
            overflow: hidden;
            margin: 16px auto 12px auto;
            border-radius: 8px;
            flex-shrink: 0;
            position: relative;
        }

        .ticker-wrap {
            display: flex;
            white-space: nowrap;
            animation: tickerMarquee 22s linear infinite;
        }

        .top-ticker:hover .ticker-wrap {
            animation-play-state: paused;
        }

        .ticker-item {
            display: inline-block;
            padding-right: 45px;
            font-size: 13px;
            color: #ffffff;
            font-weight: 500;
            letter-spacing: 0.3px;
            line-height: 1.4;
        }

        .ticker-item a {
            color: #448aff;
            text-decoration: none;
            font-weight: 600;
        }

        @keyframes tickerMarquee {
            0% { transform: translate3d(0, 0, 0); }
            100% { transform: translate3d(-50%, 0, 0); }
        }

        /* ========== CARTE PRINCIPALE ========== */
        .container {
            position: relative;
            width: 100%;
            max-width: 780px;
            min-height: 520px;
            background: transparent;
            border: 2px solid #448aff;
            box-shadow: 0 0 25px rgba(0, 74, 173, 0.3);
            border-radius: 16px;
            overflow: hidden;
            margin-top: 150px;
            transition: height 0.3s ease;
        }

        /* ========== FORMULAIRES ========== */
        .form-container {
            position: absolute;
            top: 0;
            height: 100%;
            transition: all 0.6s ease-in-out;
            background-color: #0d1117;
            padding: 20px 0;
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
            padding: 0 20px;
            height: 100%;
            width: 100%;
            text-align: center;
        }

        h2 {
            color: #ffffff;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 16px;
            letter-spacing: 0.5px;
        }

        .input-group {
            position: relative;
            width: 100%;
            max-width: 280px;
            margin: 6px 0;
            border-bottom: 2px solid #454f5b;
        }

        .input-group input {
            width: 100%;
            padding: 10px 34px 10px 10px;
            background: transparent;
            border: none;
            outline: none;
            color: #ffffff;
            font-size: 14px;
        }

        .input-group input::placeholder {
            color: #8b9aab;
            font-weight: 300;
        }

        .input-group i {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            color: #448aff;
            font-size: 15px;
        }

        .btn-main {
            border-radius: 30px;
            border: 1px solid #448aff;
            background-color: #448aff;
            color: #ffffff;
            font-size: 14px;
            font-weight: 600;
            padding: 11px 35px;
            letter-spacing: 0.5px;
            cursor: pointer;
            margin-top: 18px;
            transition: all 0.25s ease;
            min-width: 160px;
        }

        .btn-main:hover {
            background-color: #002855;
            border-color: #002855;
            transform: scale(1.02);
        }

        .btn-main:active {
            transform: scale(0.95);
        }

        .switch-text {
            color: #a3b3c2;
            font-size: 12px;
            margin-top: 14px;
        }

        .switch-text span {
            color: #448aff;
            font-weight: 700;
            cursor: pointer;
            transition: color 0.2s;
        }

        .switch-text span:hover {
            color: #6aafff;
        }

        /* ========== OVERLAY DIAGONAL ========== */
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
            padding: 0 20px;
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
            font-size: 26px;
            margin-bottom: 12px;
            font-weight: 600;
        }

        .overlay-panel p {
            font-size: 13px;
            line-height: 1.5;
            opacity: 0.9;
            max-width: 260px;
        }

        /* ========== ANIMATIONS ========== */
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
            0%, 49.99% { opacity: 0; z-index: 1; }
            50%, 100% { opacity: 1; z-index: 5; }
        }

        /* ========== ALERTES ========== */
        .alert {
            width: 100%;
            max-width: 768px;
            margin: 6px auto 0 auto;
            border-radius: 10px;
            font-size: 13px;
            padding: 10px 14px;
            background-color: #1e2a3a;
            color: #e0e9f5;
            border-left: 4px solid #448aff;
        }

        .alert-danger {
            border-left-color: #e74c3c;
        }

        .alert-success {
            border-left-color: #2ecc71;
        }

        .alert ul {
            margin: 0;
            padding-left: 18px;
        }

        /* ============================================================
                   RESPONSIVE MOBILE (tout ce qui change sur petits écrans)
                   ============================================================ */
        @media (max-width: 640px) {
            body {
                padding: 0 8px 20px 8px;
                justify-content: flex-start;
                height: auto;
                min-height: 100vh;
                overflow-y: auto;
            }

            .top-ticker {
                height: 48px;
                margin: 10px auto 8px auto;
                border-radius: 6px;
            }

            .ticker-item {
                font-size: 11px;
                padding-right: 28px;
            }

            /* La carte passe en hauteur automatique et colonne */
            .container {
                min-height: 580px;
                height: auto;
                max-width: 100%;
                border-radius: 14px;
                margin-top: 4px;
                border-width: 1.5px;
                display: flex;
                flex-direction: column;
                background: #0d1117;
            }

            /* On désactive le positionnement absolu pour passer en flex column */
            .form-container {
                position: relative;
                width: 100% !important;
                height: auto !important;
                opacity: 1 !important;
                transform: none !important;
                transition: none !important;
                padding: 18px 10px 14px 10px;
                display: block;
                background: #0d1117;
                border-bottom: 1px solid #1e2a3a;
            }

            .sign-in-container {
                order: 1;
                display: block;
            }

            .sign-up-container {
                order: 2;
                display: block;
                opacity: 1 !important;
                z-index: 1 !important;
                animation: none !important;
            }

            /* On cache le conteneur overlay en mobile */
            .overlay-container {
                display: none !important;
            }

            /* On ajuste les formulaires */
            form {
                padding: 0 6px;
                width: 100%;
            }

            h2 {
                font-size: 20px;
                margin-bottom: 10px;
            }

            .input-group {
                max-width: 100%;
                margin: 4px 0;
            }

            .input-group input {
                font-size: 15px; /* plus grand pour éviter le zoom iOS */
                padding: 12px 34px 12px 12px;
            }

            .btn-main {
                padding: 12px 28px;
                font-size: 15px;
                min-width: 140px;
                margin-top: 14px;
                width: 100%;
                max-width: 260px;
            }

            .switch-text {
                font-size: 13px;
                margin-top: 12px;
            }

            /* Séparation visuelle entre les deux formulaires */
            .form-container:last-of-type {
                border-bottom: none;
            }

            /* ===== GESTION DES ALERTES ===== */
            .alert {
                max-width: 100%;
                font-size: 12px;
                padding: 8px 12px;
                margin: 4px auto 0 auto;
            }

            /* ===== PETIT ASTUCE : on affiche les deux formulaires ===== */
            /* On cache le formulaire "sign-up" par défaut, on le montre via JS */
            .sign-up-container {
                display: none;
            }

            .sign-up-container.active-mobile {
                display: block !important;
            }

            .sign-in-container {
                display: block;
            }

            .sign-in-container.hide-mobile {
                display: none !important;
            }

            /* Bouton de bascule mobile */
            .mobile-toggle {
                display: block;
                width: 100%;
                text-align: center;
                padding: 12px 0 6px 0;
                color: #448aff;
                font-weight: 600;
                font-size: 14px;
                cursor: pointer;
                background: transparent;
                border: none;
                border-top: 1px solid #1e2a3a;
                margin-top: 6px;
                letter-spacing: 0.3px;
            }

            .mobile-toggle i {
                margin-right: 6px;
            }

            .mobile-toggle:hover {
                color: #6aafff;
            }
        }

        /* pour très petits écrans */
        @media (max-width: 400px) {
            .top-ticker {
                height: 44px;
            }
            .ticker-item {
                font-size: 10px;
                padding-right: 20px;
            }
            h2 {
                font-size: 18px;
            }
            .btn-main {
                font-size: 14px;
                padding: 10px 20px;
            }
        }

        /* desktop / tablette : on garde le comportement original */
        @media (min-width: 641px) {
            .mobile-toggle {
                display: none !important;
            }

            .sign-up-container {
                display: block !important;
                opacity: 0;
                z-index: 1;
            }

            .container.right-panel-active .sign-up-container {
                opacity: 1;
                z-index: 5;
            }

            .sign-in-container {
                display: block !important;
                opacity: 1;
                z-index: 2;
            }

            .container.right-panel-active .sign-in-container {
                opacity: 0;
            }
        }
    </style>
</head>
<body>

    <!-- ====== BANDEAU DÉFILANT ====== -->
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

    <!-- ====== ALERTES ====== -->
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

    <!-- ====== CARTE PRINCIPALE ====== -->
    <div class="container" id="container">

        <!-- ====== FORMULAIRE INSCRIPTION ====== -->
        <div class="form-container sign-up-container" id="signUpContainer">
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
                    <input type="password" name="password_confirmation" placeholder="Confirmez le mot de passe" required>
                    <i class="fas fa-lock"></i>
                </div>
                <button type="submit" class="btn-main">S'inscrire</button>
                <p class="switch-text">Vous avez déjà un compte ? <span id="to-login-mobile">Se connecter</span></p>
            </form>
        </div>

        <!-- ====== FORMULAIRE CONNEXION ====== -->
        <div class="form-container sign-in-container" id="signInContainer">
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
                <p class="switch-text">Vous n'avez pas de compte ? <span id="to-signup-mobile">Inscrivez-vous</span></p>
            </form>
        </div>

        <!-- ====== OVERLAY (uniquement desktop) ====== -->
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>CONTENT DE VOUS REVOIR !</h1>
                    <p>Bienvenue sur le portail ARD DIGITAL CENTER. Contacter le support technique en cas de besoin: contact@bcmgroupe.com / +221 78 752 40 26</p>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>CONTENT DE VOUS REVOIR !</h1>
                    <p>Bienvenue sur le portail ARD DIGITAL CENTER. Contacter le support technique en cas de besoin: contact@bcmgroupe.com / +221 78 752 40 26</p>
                </div>
            </div>
        </div>

        <!-- ====== BOUTON DE BASCULE MOBILE ====== -->
        <button class="mobile-toggle" id="mobileToggle">
            <i class="fas fa-exchange-alt"></i> Basculer vers <span id="toggleLabel">Inscription</span>
        </button>

    </div>

    <script>
        (function() {
            const container = document.getElementById('container');
            const signIn = document.getElementById('signInContainer');
            const signUp = document.getElementById('signUpContainer');
            const toggleBtn = document.getElementById('mobileToggle');
            const toggleLabel = document.getElementById('toggleLabel');

            // Éléments de bascule dans les formulaires
            const toLoginMobile = document.getElementById('to-login-mobile');
            const toSignupMobile = document.getElementById('to-signup-mobile');

            // Variables d'état
            let isMobile = window.innerWidth <= 640;
            let showSignUp = false; // false = connexion visible, true = inscription visible

            // Fonction pour mettre à jour l'affichage mobile
            function updateMobileUI(forceState) {
                if (typeof forceState === 'boolean') {
                    showSignUp = forceState;
                }

                if (window.innerWidth <= 640) {
                    // Mode mobile : on cache/affiche les blocs
                    if (showSignUp) {
                        signUp.style.display = 'block';
                        signIn.style.display = 'none';
                        toggleLabel.textContent = 'Connexion';
                    } else {
                        signUp.style.display = 'none';
                        signIn.style.display = 'block';
                        toggleLabel.textContent = 'Inscription';
                    }
                } else {
                    // Mode desktop : on remet tout en display block et on laisse l'overlay gérer
                    signUp.style.display = 'block';
                    signIn.style.display = 'block';
                    // On reset l'état de l'overlay si besoin
                    if (showSignUp) {
                        container.classList.add('right-panel-active');
                    } else {
                        container.classList.remove('right-panel-active');
                    }
                }
            }

            // Bascule manuelle (clic sur le bouton)
            function toggleMobile() {
                showSignUp = !showSignUp;
                updateMobileUI();
            }

            // Événements de clic sur les liens "Se connecter" / "Inscrivez-vous"
            function goToSignIn(e) {
                e.preventDefault();
                if (window.innerWidth <= 640) {
                    showSignUp = false;
                    updateMobileUI();
                } else {
                    container.classList.remove('right-panel-active');
                }
            }

            function goToSignUp(e) {
                e.preventDefault();
                if (window.innerWidth <= 640) {
                    showSignUp = true;
                    updateMobileUI();
                } else {
                    container.classList.add('right-panel-active');
                }
            }

            // Gestion du redimensionnement
            function handleResize() {
                const wasMobile = isMobile;
                isMobile = window.innerWidth <= 640;

                if (isMobile && !wasMobile) {
                    // On passe en mobile : on cache l'overlay et on affiche les blocs en fonction de showSignUp
                    updateMobileUI();
                } else if (!isMobile && wasMobile) {
                    // On passe en desktop : on réaffiche tout et on synchronise l'overlay
                    signUp.style.display = 'block';
                    signIn.style.display = 'block';
                    if (showSignUp) {
                        container.classList.add('right-panel-active');
                    } else {
                        container.classList.remove('right-panel-active');
                    }
                }
            }

            // Attacher les événements
            toggleBtn.addEventListener('click', toggleMobile);

            toLoginMobile.addEventListener('click', goToSignIn);
            toSignupMobile.addEventListener('click', goToSignUp);

            // Synchroniser aussi les liens desktop (qui existent dans le code original)
            const toSignUpDesktop = document.getElementById('to-signup');
            const toLoginDesktop = document.getElementById('to-login');
            if (toSignUpDesktop) {
                toSignUpDesktop.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (window.innerWidth <= 640) {
                        showSignUp = true;
                        updateMobileUI();
                    } else {
                        container.classList.add('right-panel-active');
                    }
                });
            }
            if (toLoginDesktop) {
                toLoginDesktop.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (window.innerWidth <= 640) {
                        showSignUp = false;
                        updateMobileUI();
                    } else {
                        container.classList.remove('right-panel-active');
                    }
                });
            }

            // Initialisation
            window.addEventListener('resize', handleResize);
            // Lancement au chargement
            setTimeout(() => {
                isMobile = window.innerWidth <= 640;
                if (isMobile) {
                    showSignUp = false;
                    updateMobileUI();
                } else {
                    // Desktop : on s'assure que l'overlay est cohérent
                    signUp.style.display = 'block';
                    signIn.style.display = 'block';
                    container.classList.remove('right-panel-active');
                }
            }, 50);

        })();
    </script>

</body>
</html>