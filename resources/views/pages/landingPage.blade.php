<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plateforme Régionale ARD Saint-Louis | ERP & SPI Connecté</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Icones Logo -->
    <link rel="icon" href="{{ asset('assets/images/images/logoard.jpg.webp') }}" type="image/x-icon">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ardGreen: '#15803d',
                        ardDark: '#064e3b',
                        ardGold: '#d97706',
                        ardSand: '#f8fafc',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }
        /* Carousel animation styles */
        .hero-slide {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            z-index: 1;
        }
        .hero-slide.active {
            opacity: 1;
        }
        .hero-overlay {
        position: absolute;
        inset: 0;
        /* Passez l'opacité de 0.6 / 0.7 à 0.3 ou 0.4 pour éclaircir */
        background-color: rgba(0, 0, 0, 0.3); 
        z-index: 1;
        }

        /* Styles pour le bouton hamburger */
        .hamburger-btn.active .bar:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .hamburger-btn.active .bar:nth-child(2) {
            opacity: 0;
        }

        .hamburger-btn.active .bar:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -6px);
        }

        /* Styles pour le menu mobile */
        .mobile-menu {
            padding-top: 80px;
            box-shadow: 4px 0 30px rgba(0, 0, 0, 0.1);
        }

        .mobile-menu .nav-link {
            position: relative;
            padding-left: 0;
            transition: all 0.3s ease;
        }

        .mobile-menu .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 0;
            background: #059669;
            transition: height 0.3s ease;
            border-radius: 0 3px 3px 0;
        }

        .mobile-menu .nav-link:hover::before,
        .mobile-menu .nav-link:active::before {
            height: 60%;
        }

        .mobile-menu .nav-link:hover {
            padding-left: 12px;
            color: #059669;
        }

        /* Animation d'entrée des éléments */
        .mobile-menu .nav-link {
            opacity: 0;
            transform: translateX(-20px);
            animation: slideInMobile 0.4s ease forwards;
        }

        .mobile-menu .nav-link:nth-child(1) { animation-delay: 0.05s; }
        .mobile-menu .nav-link:nth-child(2) { animation-delay: 0.1s; }
        .mobile-menu .nav-link:nth-child(3) { animation-delay: 0.15s; }
        .mobile-menu .nav-link:nth-child(4) { animation-delay: 0.2s; }
        .mobile-menu .nav-link:nth-child(5) { animation-delay: 0.25s; }
        .mobile-menu .nav-link:nth-child(6) { animation-delay: 0.3s; }

        .mobile-menu .mt-6 {
            opacity: 0;
            transform: translateY(20px);
            animation: slideUpMobile 0.4s ease forwards;
            animation-delay: 0.35s;
        }

        @keyframes slideInMobile {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideUpMobile {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Désactiver l'animation quand le menu est fermé */
        .mobile-menu.-translate-x-full .nav-link,
        .mobile-menu.-translate-x-full .mt-6 {
            animation: none;
            opacity: 0;
        }

        /* Scroll du menu mobile */
        .mobile-menu .overflow-y-auto {
            scroll-behavior: smooth;
        }

        .mobile-menu .overflow-y-auto::-webkit-scrollbar {
            width: 4px;
        }

        .mobile-menu .overflow-y-auto::-webkit-scrollbar-track {
            background: transparent;
        }

        .mobile-menu .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 2px;
        }

        /* Responsive fine-tuning */
        @media (max-width: 767px) {
            .mobile-menu {
                width: 100%;
                max-width: 100%;
            }
            
            .mobile-menu .flex.flex-col {
                padding-left: 20px;
                padding-right: 20px;
            }
        }

        /* Overlay optionnel */
        .mobile-menu-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 39;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .mobile-menu-overlay.active {
            opacity: 1;
            visibility: visible;
        }
    </style>
</head>
<body class="antialiased">

    <!-- Navbar -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md shadow-sm border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('assets/images/images/logoard.jpg.webp') }}" alt="Logo ARD Saint-Louis" class="h-12 w-auto object-contain">
                <div>
                    <span class="text-lg font-bold text-slate-900 block leading-tight">ARD Saint-Louis</span>
                    <span class="text-xs font-medium text-ardGreen">Plateforme Régionale SPI & ERP</span>
                </div>
            </div>
            <nav class="hidden md:flex items-center space-x-8 text-sm font-semibold text-slate-600">
                <a href="#accueil" class="hover:text-ardGreen transition">Accueil</a>
                <a href="#apropos" class="hover:text-ardGreen transition">Le Projet</a>
                <a href="#branches" class="hover:text-ardGreen transition">Les 4 Branches</a>
                <a href="#unites" class="hover:text-ardGreen transition">Unités & Vitrines</a>
                <a href="#supervision" class="hover:text-ardGreen transition">Supervision ARD</a>
                <a href="#contact" class="hover:text-ardGreen transition">Contact</a>
            </nav>
            <div class="flex items-center space-x-4">
                <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold text-white bg-ardGreen rounded-xl shadow-lg shadow-ardGreen/20 hover:bg-ardDark transition">
                    Accéder à la Plateforme
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section with 3 Image Slideshow -->
    <section id="accueil" class="relative pt-32 pb-24 md:pt-40 md:pb-32 text-white overflow-hidden min-h-[600px] flex items-center">
        <!-- Background Slides -->
        <div class="hero-slide active" style="background-image: url('{{ asset('assets/images/images/Diougopmaman.jpg.webp') }}');"></div>
        <div class="hero-slide" style="background-image: url('{{ asset('assets/images/images/diougop.jpg.jpeg') }}');"></div>
        <div class="hero-slide" style="background-image: url('{{ asset('assets/images/images/Guetndar.jpg.webp') }}');"></div>
        <div class="hero-overlay"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <div class="max-w-3xl">
                <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold bg-ardGold/20 border border-ardGold/30 text-amber-200 mb-6 backdrop-blur-sm">
                    <i class="fa-solid fa-bolt mr-2"></i> Solution Institutionnelle Officielle — Zone Nord
                </span>
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold tracking-tight leading-tight mb-6">
                    La Transformation Digitale au Cœur du Développement Régional
                </h1>
                <p class="text-lg sm:text-xl text-slate-200 mb-8 font-normal leading-relaxed">
                    Développée par <strong class="text-white font-semibold">BCM-GROUPE</strong> pour l'<strong>Agence Régionale de Développement (ARD) de Saint-Louis</strong>, cette plateforme ERP & SPI connecte, structure et pilote l'économie locale à travers 4 branches métiers et un réseau d'unités autonomes.
                </p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="#branches" class="inline-flex items-center justify-center px-8 py-4 text-base font-bold text-ardDark bg-white rounded-xl shadow-xl hover:bg-slate-100 transition">
                        Explorer les 4 Branches <i class="fa-solid fa-arrow-right ml-2"></i>
                    </a>
                    <a href="#unites" class="inline-flex items-center justify-center px-8 py-4 text-base font-bold text-white bg-white/10 border border-white/20 rounded-xl hover:bg-white/20 transition backdrop-blur-sm">
                        Voir les Unités
                    </a>
                </div>
            </div>
            <!-- Slide Indicators -->
            <div class="absolute bottom-6 right-8 z-20 flex space-x-2">
                <button onclick="currentSlide(0)" class="slide-dot w-3 h-3 rounded-full bg-white transition"></button>
                <button onclick="currentSlide(1)" class="slide-dot w-3 h-3 rounded-full bg-white/50 transition"></button>
                <button onclick="currentSlide(2)" class="slide-dot w-3 h-3 rounded-full bg-white/50 transition"></button>
            </div>
        </div>
    </section>

    <!-- Stats Bar -->
    <div class="bg-ardDark text-white py-8 border-t border-emerald-900/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div>
                <div class="text-3xl font-extrabold text-amber-400 mb-1">4 Branches</div>
                <div class="text-xs text-slate-300 uppercase tracking-wider">Métiers structurés</div>
            </div>
            <div>
                <div class="text-3xl font-extrabold text-amber-400 mb-1">Unités</div>
                <div class="text-xs text-slate-300 uppercase tracking-wider">Vitrines et services actifs</div>
            </div>
            <div>
                <div class="text-3xl font-extrabold text-amber-400 mb-1">Zone Nord</div>
                <div class="text-xs text-slate-300 uppercase tracking-wider">Couverture régionale</div>
            </div>
            <div>
                <div class="text-3xl font-extrabold text-amber-400 mb-1">SPI Intégré</div>
                <div class="text-xs text-slate-300 uppercase tracking-wider">Pilotage & Amortissement</div>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <section id="apropos" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <span class="text-ardGreen font-bold text-sm tracking-widest uppercase mb-3 block">Vision Stratégique</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-6">
                        Du Projet Pilote de Diougop à une Solution Régionale Pérenne
                    </h2>
                    <p class="text-slate-600 mb-6 leading-relaxed">
                        Initialement conçu comme un outil local centré sur le pôle de <strong>Diougop</strong>, le projet a évolué sous l'impulsion conjointe de l'ARD et de BCM-GROUPE pour devenir une infrastructure numérique globale. 
                    </p>
                    <p class="text-slate-600 mb-8 leading-relaxed">
                        Cette plateforme ERP intègre désormais un système de pilotage unifié (SPI), permettant à l'ARD de superviser l'ensemble des activités économiques, de gérer les immobilisations et d'offrir à chaque unité de production ou service une vitrine web dédiée et autonome.
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="flex items-start space-x-3 bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <div class="w-10 h-10 rounded-lg bg-ardGreen/10 text-ardGreen flex items-center justify-center shrink-0 font-bold"><i class="fa-solid fa-check"></i></div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">Contrôle Hiérarchique</h4>
                                <p class="text-xs text-slate-500 mt-1">Supervision granulaire pour l'ARD.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3 bg-slate-50 p-4 rounded-xl border border-slate-100">
                            <div class="w-10 h-10 rounded-lg bg-ardGreen/10 text-ardGreen flex items-center justify-center shrink-0 font-bold"><i class="fa-solid fa-shield-halved"></i></div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">Sécurité & Fiabilité</h4>
                                <p class="text-xs text-slate-500 mt-1">Hébergement robuste et bases isolées.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl border-4 border-white">
                        <img src="{{ asset('assets/images/images/pont-faidherbe.jpg.jpg') }}" alt="Projet Diougop ARD" class="w-full h-auto object-cover">
                    </div>
                    <div class="absolute -bottom-6 -left-6 bg-ardDark text-white p-6 rounded-2xl shadow-xl hidden sm:block max-w-xs border border-emerald-800">
                        <div class="text-amber-400 font-bold text-xl mb-1">Impact Régional</div>
                        <p class="text-xs text-slate-300">Un outil clé en main conçu pour accompagner durablement les entrepreneurs de la Zone Nord.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4 Branches Section -->
    <section id="branches" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-ardGreen font-bold text-sm tracking-widest uppercase mb-3 block">Architecture Multi-Branches</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-4">
                    Les 4 Piliers de l'Écosystème Économique
                </h2>
                <p class="text-slate-600">
                    Chaque commerce ou unité est rattaché à sa branche spécifique, disposant d'une logique de gestion adaptée à ses flux opérationnels.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Branche 1 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg border border-slate-100 hover:shadow-xl transition flex flex-col">
                    <div class="h-48 overflow-hidden relative">
                        <img src="{{ asset('assets/images/images/Halieutique.png') }}" alt="Négoce direct" class="w-full h-full object-cover">
                        <span class="absolute top-3 left-3 bg-ardDark/90 text-white text-xs font-bold px-3 py-1 rounded-full backdrop-blur-sm">Branche 01</span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-slate-900 mb-3">Négoce Direct</h3>
                            <p class="text-slate-600 text-sm leading-relaxed mb-4">
                                Gestion des activités d'achat et de revente directe de marchandises, suivi des stocks en temps réel et facturation automatisée.
                            </p>
                        </div>
                        <div class="text-xs font-semibold text-ardGreen flex items-center">
                            <i class="fa-solid fa-circle-check mr-2"></i> Flux optimisés
                        </div>
                    </div>
                </div>

                <!-- Branche 2 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg border border-slate-100 hover:shadow-xl transition flex flex-col">
                    <div class="h-48 overflow-hidden relative">
                        <img src="{{ asset('assets/images/images/transformation.png') }}" alt="Transformation" class="w-full h-full object-cover">
                        <span class="absolute top-3 left-3 bg-ardDark/90 text-white text-xs font-bold px-3 py-1 rounded-full backdrop-blur-sm">Branche 02</span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-slate-900 mb-3">Transformation</h3>
                            <p class="text-slate-600 text-sm leading-relaxed mb-4">
                                Suivi des matières premières, valorisation locale des produits agricoles et alimentaires, et traçabilité des lots transformés.
                            </p>
                        </div>
                        <div class="text-xs font-semibold text-ardGreen flex items-center">
                            <i class="fa-solid fa-circle-check mr-2"></i> Traçabilité des lots
                        </div>
                    </div>
                </div>

                <!-- Branche 3 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg border border-slate-100 hover:shadow-xl transition flex flex-col">
                    <div class="h-48 overflow-hidden relative">
                        <img src="{{ asset('assets/images/images/dechets.jpg.png') }}" alt="Gestion des Déchets" class="w-full h-full object-cover">
                        <span class="absolute top-3 left-3 bg-ardDark/90 text-white text-xs font-bold px-3 py-1 rounded-full backdrop-blur-sm">Branche 03</span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-slate-900 mb-3">Gestion des Déchets / Ordures</h3>
                            <p class="text-slate-600 text-sm leading-relaxed mb-4">
                                Module spécifique dédié à la collecte, au traitement des ordures et aux pics d'activité environnementale dans la région.
                            </p>
                        </div>
                        <div class="text-xs font-semibold text-ardGreen flex items-center">
                            <i class="fa-solid fa-circle-check mr-2"></i> Suivi environnemental
                        </div>
                    </div>
                </div>

                <!-- Branche 4 -->
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg border border-slate-100 hover:shadow-xl transition flex flex-col">
                    <div class="h-48 overflow-hidden relative">
                        <img src="{{ asset('assets/images/images/esthetique.png') }}" alt="Prestations de Services" class="w-full h-full object-cover">
                        <span class="absolute top-3 left-3 bg-ardDark/90 text-white text-xs font-bold px-3 py-1 rounded-full backdrop-blur-sm">Branche 04</span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-slate-900 mb-3">Prestations de Services</h3>
                            <p class="text-slate-600 text-sm leading-relaxed mb-4">
                                Gestion des entreprises prestataires, planification des interventions et suivi des contrats de services aux usagers.
                            </p>
                        </div>
                        <div class="text-xs font-semibold text-ardGreen flex items-center">
                            <i class="fa-solid fa-circle-check mr-2"></i> Planification avancée
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Unités & Vitrines Slider/Grid Section -->
    <section id="unites" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-ardGreen font-bold text-sm tracking-widest uppercase mb-3 block">Réseau Opérationnel</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-4">
                    Unités et Vitrines Connectées à la Plateforme
                </h2>
                <p class="text-slate-600">
                    Découvrez un aperçu des différentes unités professionnelles locales gérées et supervisées à travers l'écosystème ARD.
                </p>
            </div>

            <!-- Unités Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Unité 1 -->
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition">
                    <div class="h-40 rounded-xl overflow-hidden mb-4 relative">
                        <img src="{{ asset('assets/images/images/transf.jpg.png') }}" alt="Unité de transformation" class="w-full h-full object-cover">
                        <span class="absolute top-3 right-3 bg-ardGreen text-white text-xs font-bold px-2.5 py-1 rounded-md">Transformation</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Unité de Transformation</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Valorisation locale des produits agroalimentaires, conditionnement et traçabilité rigoureuse des lots.
                    </p>
                </div>

                <!-- Unité 2 -->
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition">
                    <div class="h-40 rounded-xl overflow-hidden mb-4 relative">
                        <img src="{{ asset('assets/images/images/dechets.jpg.png') }}" alt="Pic collecte de déchet" class="w-full h-full object-cover">
                        <span class="absolute top-3 right-3 bg-amber-600 text-white text-xs font-bold px-2.5 py-1 rounded-md">Environnement</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Pic Collecte de Déchets</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Gestion logistique et suivi en temps réel des pics de collecte et du traitement des ordures urbaines.
                    </p>
                </div>

                <!-- Unité 3 -->
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition">
                    <div class="h-40 rounded-xl overflow-hidden mb-4 relative">
                        <img src="{{ asset('assets/images/images/coif.jpg.png') }}" alt="Salon de coiffure" class="w-full h-full object-cover">
                        <span class="absolute top-3 right-3 bg-blue-600 text-white text-xs font-bold px-2.5 py-1 rounded-md">Services</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Salon de Coiffure</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Unité de prestation de services de proximité connectée au module de réservation et gestion financière.
                    </p>
                </div>

                <!-- Unité 4 -->
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition">
                    <div class="h-40 rounded-xl overflow-hidden mb-4 relative">
                        <img src="{{ asset('assets/images/images/tail.jpg.png') }}" alt="Atelier tailleur" class="w-full h-full object-cover">
                        <span class="absolute top-3 right-3 bg-purple-600 text-white text-xs font-bold px-2.5 py-1 rounded-md">Artisanat</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Atelier Tailleur</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Gestion des commandes sur mesure, des stocks de tissus et de la vitrine e-commerce de l'artisan.
                    </p>
                </div>

                <!-- Unité 5 -->
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition md:col-span-2 lg:col-span-2">
                    <div class="h-40 rounded-xl overflow-hidden mb-4 relative">
                        <img src="{{ asset('assets/images/images/halieu.jpg.png') }}" alt="Halieutique" class="w-full h-full object-cover">
                        <span class="absolute top-3 right-3 bg-teal-600 text-white text-xs font-bold px-2.5 py-1 rounded-md">Halieutique</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Pôle Halieutique & Pêche</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Suivi des activités liées à la filière pêche, débarquements, transformation locale et circuits de distribution de la Zone Nord.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Supervision ARD & Amortissement -->
    <section id="supervision" class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <span class="text-ardGreen font-bold text-sm tracking-widest uppercase mb-3 block">Gouvernance & Pilotage</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-6">
                        Solution de Pilotage Intégré (SPI) & Module d'Amortissement
                    </h2>
                    <p class="text-slate-600 mb-6 leading-relaxed">
                        La plateforme offre à l'ARD un tableau de bord de supervision global et granulaire. Suivez en temps réel la santé financière des structures, les volumes d'activité par branche et les indicateurs clés du développement régional.
                    </p>
                    <ul class="space-y-4 text-slate-700 text-sm font-medium">
                        <li class="flex items-center">
                            <i class="fa-solid fa-shield-check text-ardGreen text-lg mr-3"></i>
                            Suivi automatisé des équipements et calcul des amortissements
                        </li>
                        <li class="flex items-center">
                            <i class="fa-solid fa-shield-check text-ardGreen text-lg mr-3"></i>
                            Rapports consolidés pour la direction de l'ARD
                        </li>
                        <li class="flex items-center">
                            <i class="fa-solid fa-shield-check text-ardGreen text-lg mr-3"></i>
                            Traçabilité complète des flux de trésorerie et d'inventaire
                        </li>
                    </ul>
                </div>
                <div class="relative">
                    <div class="rounded-2xl overflow-hidden shadow-2xl border-4 border-white bg-slate-900">
                        <img src="{{ asset('assets/images/images/interface.jpg.png') }}" alt="Vue aérienne du site et de la zone" class="w-full h-auto object-cover opacity-90">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact & Footer -->
    <footer id="contact" class="bg-ardDark text-white pt-20 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                <div>
                    <div class="flex items-center space-x-3 mb-6">
                        <img src="{{ asset('assets/images/images/logoard.jpg.webp') }}" alt="Logo ARD" class="h-10 w-auto bg-white p-1 rounded">
                        <span class="text-lg font-bold">ARD Saint-Louis</span>
                    </div>
                    <p class="text-slate-300 text-sm leading-relaxed mb-6">
                        Plateforme numérique institutionnelle officielle pour le développement économique et la digitalisation de la Zone Nord.
                    </p>
                </div>
                <div>
                    <h4 class="text-base font-bold mb-6 text-amber-400">Navigation Rapide</h4>
                    <ul class="space-y-3 text-sm text-slate-300">
                        <li><a href="#accueil" class="hover:text-white transition">Accueil</a></li>
                        <li><a href="#apropos" class="hover:text-white transition">Le Projet</a></li>
                        <li><a href="#branches" class="hover:text-white transition">Les 4 Branches</a></li>
                        <li><a href="#unites" class="hover:text-white transition">Unités & Vitrines</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-base font-bold mb-6 text-amber-400">Partenaires & Réalisation</h4>
                    <p class="text-sm text-slate-300 mb-4">
                        Conception, ingénierie et développement réalisés par :
                    </p>
                    <div class="bg-white/10 p-4 rounded-xl border border-white/10">
                        <strong class="block text-white font-bold mb-1">BCM-GROUPE SÉNÉGAL</strong>
                        <span class="text-xs text-slate-300">Solutions Digitales & Ingénierie Informatique</span>
                        <div class="text-xs text-amber-300 mt-2"><i class="fa-solid fa-phone mr-1"></i> +221 76 207 87 27</div>
                    </div>
                </div>
                <div>
                    <h4 class="text-base font-bold mb-6 text-amber-400">Contact Institutionnel</h4>
                    <ul class="space-y-3 text-sm text-slate-300">
                        <li><i class="fa-solid fa-location-dot mr-2 text-ardGreen"></i> Route de Khor, Saint-Louis, Sénégal</li>
                        <li><i class="fa-solid fa-envelope mr-2 text-ardGreen"></i> contact@ardsaintlouis.com</li>
                        <li><i class="fa-solid fa-phone mr-2 text-ardGreen"></i> +221 78 352 08 78</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-emerald-900/60 pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400">
                <p>&copy; 2026 ARD Saint-Louis & BCM-GROUPE. Tous droits réservés.</p>
                <p class="mt-4 sm:mt-0">Plateforme SPI & ERP — Version Officielle Régionale</p>
            </div>
        </div>
    </footer>


    <!-- JavaScript for Mobile Menu Toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sélectionner la navigation
            const header = document.querySelector('header');
            const nav = header.querySelector('nav');
            const navContainer = nav.parentElement;
            const loginBtn = navContainer.querySelector('.flex.items-center.space-x-4');
            
            // Créer le bouton hamburger pour mobile
            const hamburgerBtn = document.createElement('button');
            hamburgerBtn.className = 'md:hidden flex flex-col items-center justify-center w-10 h-10 rounded-lg hover:bg-slate-100 transition-colors';
            hamburgerBtn.setAttribute('aria-label', 'Menu');
            hamburgerBtn.innerHTML = `
                <span class="block w-6 h-0.5 bg-slate-700 transition-all duration-300"></span>
                <span class="block w-6 h-0.5 bg-slate-700 transition-all duration-300 mt-1.5"></span>
                <span class="block w-6 h-0.5 bg-slate-700 transition-all duration-300 mt-1.5"></span>
            `;
            
            // Insérer le bouton avant le bouton de connexion
            loginBtn.parentNode.insertBefore(hamburgerBtn, loginBtn);
            
            // Créer le menu mobile
            const mobileMenu = document.createElement('div');
            mobileMenu.className = 'mobile-menu fixed inset-0 z-40 bg-white transform -translate-x-full transition-transform duration-300 ease-in-out md:hidden';
            mobileMenu.id = 'mobile-menu';
            mobileMenu.innerHTML = `
                <div class="flex flex-col h-full pt-20 px-6 overflow-y-auto">
                    <!-- Liens de navigation -->
                    <a href="#accueil" class="nav-link py-4 text-base font-semibold text-slate-700 border-b border-slate-100 hover:text-ardGreen transition-colors">Accueil</a>
                    <a href="#apropos" class="nav-link py-4 text-base font-semibold text-slate-700 border-b border-slate-100 hover:text-ardGreen transition-colors">Le Projet</a>
                    <a href="#branches" class="nav-link py-4 text-base font-semibold text-slate-700 border-b border-slate-100 hover:text-ardGreen transition-colors">Les 4 Branches</a>
                    <a href="#unites" class="nav-link py-4 text-base font-semibold text-slate-700 border-b border-slate-100 hover:text-ardGreen transition-colors">Unités & Vitrines</a>
                    <a href="#supervision" class="nav-link py-4 text-base font-semibold text-slate-700 border-b border-slate-100 hover:text-ardGreen transition-colors">Supervision ARD</a>
                    <a href="#contact" class="nav-link py-4 text-base font-semibold text-slate-700 border-b border-slate-100 hover:text-ardGreen transition-colors">Contact</a>
                    
                    <!-- Bouton de connexion mobile -->
                    <div class="mt-6">
                        <a href="{{ route('login') }}" class="flex items-center justify-center w-full px-6 py-3.5 text-base font-semibold text-white bg-ardGreen rounded-xl shadow-lg shadow-ardGreen/20 hover:bg-ardDark transition">
                            Accéder à la Plateforme
                        </a>
                    </div>
                    
                    <!-- Footer du menu mobile -->
                    <div class="mt-auto pt-6 pb-8 text-center">
                        <p class="text-xs text-slate-400">ARD Saint-Louis &copy; {{ date('Y') }}</p>
                    </div>
                </div>
            `;
            
            // Insérer le menu mobile après le header
            document.body.appendChild(mobileMenu);
            
            // Gérer l'ouverture/fermeture du menu mobile
            hamburgerBtn.addEventListener('click', function() {
                this.classList.toggle('active');
                mobileMenu.classList.toggle('-translate-x-full');
                document.body.classList.toggle('overflow-hidden');
                
                // Animation du hamburger
                const spans = this.querySelectorAll('span');
                if (this.classList.contains('active')) {
                    spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
                    spans[1].style.opacity = '0';
                    spans[2].style.transform = 'rotate(-45deg) translate(7px, -6px)';
                    spans[0].style.background = '#059669';
                    spans[2].style.background = '#059669';
                } else {
                    spans[0].style.transform = 'rotate(0) translate(0, 0)';
                    spans[1].style.opacity = '1';
                    spans[2].style.transform = 'rotate(0) translate(0, 0)';
                    spans[0].style.background = '#334155';
                    spans[2].style.background = '#334155';
                }
            });
            
            // Fermer le menu lors du clic sur un lien
            const navLinks = mobileMenu.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    closeMobileMenu();
                    
                    // Scroll vers la section
                    if (targetId && targetId.startsWith('#')) {
                        const target = document.querySelector(targetId);
                        if (target) {
                            setTimeout(() => {
                                const headerHeight = document.querySelector('header').offsetHeight;
                                const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - headerHeight;
                                window.scrollTo({ top: targetPosition, behavior: 'smooth' });
                            }, 300);
                        }
                    }
                });
            });
            
            // Fermer le menu lors du clic sur le bouton de connexion
            const mobileLoginBtn = mobileMenu.querySelector('a[href*="login"]');
            if (mobileLoginBtn) {
                mobileLoginBtn.addEventListener('click', function() {
                    closeMobileMenu();
                });
            }
            
            // Fermer le menu avec la touche Echap
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !mobileMenu.classList.contains('-translate-x-full')) {
                    closeMobileMenu();
                }
            });
            
            // Fermer le menu lors du clic en dehors
            document.addEventListener('click', function(e) {
                if (!mobileMenu.classList.contains('-translate-x-full')) {
                    const isClickInsideMenu = mobileMenu.contains(e.target);
                    const isClickOnHamburger = hamburgerBtn.contains(e.target);
                    
                    if (!isClickInsideMenu && !isClickOnHamburger) {
                        closeMobileMenu();
                    }
                }
            });
            
            // Fonction pour fermer le menu
            function closeMobileMenu() {
                hamburgerBtn.classList.remove('active');
                mobileMenu.classList.add('-translate-x-full');
                document.body.classList.remove('overflow-hidden');
                
                const spans = hamburgerBtn.querySelectorAll('span');
                spans[0].style.transform = 'rotate(0) translate(0, 0)';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'rotate(0) translate(0, 0)';
                spans[0].style.background = '#334155';
                spans[2].style.background = '#334155';
            }
            
            // Gérer le redimensionnement de la fenêtre
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    if (window.innerWidth >= 768 && !mobileMenu.classList.contains('-translate-x-full')) {
                        closeMobileMenu();
                    }
                }, 250);
            });
        });
    </script>

    <!-- JavaScript for Hero Slideshow -->
    <script>
        let currentSlideIndex = 0;
        const slides = document.querySelectorAll('.hero-slide');
        const dots = document.querySelectorAll('.slide-dot');

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.remove('active');
                dots[i].classList.remove('bg-white');
                dots[i].classList.add('bg-white/50');
            });
            slides[index].classList.add('active');
            dots[index].classList.remove('bg-white/50');
            dots[index].classList.add('bg-white');
        }

        function nextSlide() {
            currentSlideIndex = (currentSlideIndex + 1) % slides.length;
            showSlide(currentSlideIndex);
        }

        function currentSlide(index) {
            currentSlideIndex = index;
            showSlide(currentSlideIndex);
        }

        // Auto slide every 5 seconds
        setInterval(nextSlide, 5000);
    </script>
</body>
</html>