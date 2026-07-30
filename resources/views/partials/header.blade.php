<?php
    //Alert sotck

    use App\Models\Produit;
    use App\Models\Unite;

    $unite= Unite::Where('id', request()->user()->unite_id)->first(); 
    $alerte = Produit::produitsEnAlerte()->count();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <title>ARD GestioPro - Tableau de bord opérationnel</title>
   
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="keywords" content="bootstrap, bootstrap admin template, admin theme, admin dashboard, dashboard template, admin template, responsive" />
    <meta name="author" content="Codedthemes" />
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
    <!-- waves.css -->
    <link rel="stylesheet" href="{{ asset('assets/pages/waves/css/waves.min.css') }}" type="text/css" media="all">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap/css/bootstrap.min.css') }}">
    <!-- waves.css -->
    <link rel="stylesheet" href="{{ asset('assets/pages/waves/css/waves.min.css') }}" type="text/css" media="all">
    <!-- themify icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/icon/themify-icons/themify-icons.css') }}">
    <!-- font-awesome-n -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome-n.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <!-- scrollbar.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.mCustomScrollbar.css') }}"> 
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- AJOUTER CES BIBLIOTHÈQUES POUR LE TÉLÉCHARGEMENT -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="loader-track">
            <div class="preloader-wrapper">
                <div class="spinner-layer spinner-blue">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
                <div class="spinner-layer spinner-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-yellow">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-green">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pre-loader end -->
    <div id="pcoded" class="pcoded">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">
            @include('partials.navbar')

            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <nav class="pcoded-navbar">
                        <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
                        <div class="pcoded-inner-navbar main-menu">
                            <div class="">
                                <div class="main-menu-header mt-3">
                                    <img class="img-90 img-radius mx-auto" src="{{asset('storage/'.$unite->logo)}}" alt="{{ Auth::user()->unite->nom }}">
                                    @if($alerte)
                                        <p class="alert alert-danger">
                                            ⛔ Vous avez <b><?= $alerte ?></b> produit(s) en rupture de stock.
                                        </p>
                                    @endif
                                    <div class="user-details">
                                        <span id="more-details">{{ Auth::user()->unite->nom }}<i class="fa fa-caret-down"></i></span>
                                    </div>
                                </div>
                                <div class="main-menu-content">
                                    <ul>
                                        <li class="more-details">
                                            <a href="{{ route('profile.edit') }}"><i class="ti-user"></i>Profile</a>
                                            <a href="{{ route('assistance') }}"><i class="fas fa-cog"></i>Supports & Assistance</a>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf

                                                <a href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                                    <i class="ti-layout-sidebar-left"></i>Deconnexion
                                                </a>
                                            </form>
                                            <!--<a href="auth-normal-sign-in.html"><i class="ti-layout-sidebar-left"></i>Logout</a>-->
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!--<div class="p-15 p-b-0">
                                <form class="form-material">
                                    <div class="form-group form-primary">
                                        <input type="text" name="footer-email" class="form-control">
                                        <span class="form-bar"></span>
                                        <label class="float-label"><i class="fa fa-search m-r-10"></i>Search Friend</label>
                                    </div>
                                </form>
                            </div>-->
                            <div class="pcoded-navigation-label">Navigation</div>
                            <ul class="pcoded-item pcoded-left-item">
                                <li class="active">
                                    <a href="{{ route('dashboard') }}" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                                        <span class="pcoded-mtext">Dashboard</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                            </ul>
                            @if(Auth::user()->role == 'commercial')

                                @if($unite->categorie->slug == 'gos')
                                    <ul class="pcoded-item pcoded-left-item">
                                        <li class="">
                                            <a href="{{ route('abonne.index') }}" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="fas fa-users"></i></span>
                                                <span class="pcoded-mtext">Abonnees</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                    </ul>
                                @else
                                    <ul class="pcoded-item pcoded-left-item">
                                        <li class="pcoded-hasmenu ">
                                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="fas fa-shopping-cart"></i><b>A</b></span>
                                                <span class="pcoded-mtext">Commercial</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                @if($unite->categorie->slug == 'service')
                                                    <li class="">
                                                        <a href="{{ route('vente.index') }}" class="waves-effect waves-dark">
                                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                            <span class="pcoded-mtext">Prestation</span>
                                                            <span class="pcoded-mcaret"></span>
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="{{ route('vente.create') }}" class="waves-effect waves-dark">
                                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                            <span class="pcoded-mtext">Nouvelle prestation</span>
                                                            <span class="pcoded-mcaret"></span>
                                                        </a>
                                                    </li>
                                                @else
                                                    <li class="">
                                                        <a href="{{ route('vente.index') }}" class="waves-effect waves-dark">
                                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                            <span class="pcoded-mtext">Ventes</span>
                                                            <span class="pcoded-mcaret"></span>
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="{{ route('vente.create') }}" class="waves-effect waves-dark">
                                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                            <span class="pcoded-mtext">Nouvelle vente</span>
                                                            <span class="pcoded-mcaret"></span>
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="{{ route('client.index') }}" class="waves-effect waves-dark">
                                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                            <span class="pcoded-mtext">Clients</span>
                                                            <span class="pcoded-mcaret"></span>
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </li>
                                    </ul>
                                @endif

                                @if($unite->categorie->slug !== 'gos')
                                    <ul class="pcoded-item pcoded-left-item">
                                        <li class="pcoded-hasmenu">
                                            <a href="javascript:void(0)" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i><b>BC</b></span>
                                                <span class="pcoded-mtext">Inventaire</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                            <ul class="pcoded-submenu">
                                                
                                                <li class="">
                                                    <a href="{{ route('achat.index') }}" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">Achats</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>

                                                @if($unite->categorie->slug == 'service')
                                                    <li class=" ">
                                                        <a href="{{ route('service.index') }}" class="waves-effect waves-dark">
                                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                                <span class="pcoded-mtext">Services</span>
                                                            <span class="pcoded-mcaret"></span>
                                                        </a>
                                                    </li>
                                                @else
                                                
                                                    <li class=" ">
                                                        <a href="{{ route('produit.index') }}" class="waves-effect waves-dark">
                                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                            <span class="pcoded-mtext">Produits</span>
                                                            <span class="pcoded-mcaret"></span>
                                                        </a>
                                                    </li>
                                                @endif

                                                <li class=" ">
                                                    <a href="{{ route('fournisseur.index') }}" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">Fournisseurs</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                                <li class="">
                                                    <a href="{{ route('stock.index') }}" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">Mouvement Stock</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                                @if($unite->categorie->slug == 'service'  || $unite->categorie->slug == 'transformation')
                                                    <li class="">
                                                        <a href="{{ route('intrant.index') }}" class="waves-effect waves-dark">
                                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                            <span class="pcoded-mtext">Intrants</span>
                                                            <span class="pcoded-mcaret"></span>
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </li>
                                    </ul>  
                                @endif   

                                <ul class="pcoded-item pcoded-left-item">
                                    <li class="pcoded-hasmenu">
                                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="fas fa-right-left"></i><b>BC</b></span>
                                            <span class="pcoded-mtext">Finance</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            @if($unite->categorie->slug !== 'gos')
                                                <li class="">
                                                    <a href="{{ route('paiement.index') }}" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">Paiements</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            @endif
                                            
                                            <li class=" ">
                                                <a href="{{ route('recette.index') }}" class="waves-effect waves-dark">
                                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                    <span class="pcoded-mtext">Recettes</span>
                                                    <span class="pcoded-mcaret"></span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="{{ route('depense.index') }}" class="waves-effect waves-dark">
                                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                    <span class="pcoded-mtext">Depenses</span>
                                                    <span class="pcoded-mcaret"></span>
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="{{ route('chargefixe.index') }}" class="waves-effect waves-dark">
                                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                    <span class="pcoded-mtext">Charges Fixe</span>
                                                    <span class="pcoded-mcaret"></span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>     

                                <!-- <ul class="pcoded-item pcoded-left-item">
                                    <li class="">
                                        <a href="{{ route('produit.index') }}" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="fas fa-box"></i><b>FC</b></span>
                                            <span class="pcoded-mtext">Produits</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                </ul>-->
                                
                               
                                @if($unite->categorie->slug !== 'gos')
                                    <ul class="pcoded-item pcoded-left-item">
                                        <li class="">
                                            <a href="{{ route('vente.facture') }}" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="fas fa-file-invoice"></i><b>FC</b></span>
                                                <span class="pcoded-mtext">Factures</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                    </ul> 
                                    
                                    <ul class="pcoded-item pcoded-left-item">
                                        <li class="">
                                            <a href="{{ route('analyse') }}" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="fas fa-chart-bar"></i><b>FC</b></span>
                                                <span class="pcoded-mtext">Rapport & Analyse</span>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                    </ul>
                                @endif 

                                <ul class="pcoded-item pcoded-left-item">
                                    <li class="">
                                        <a href="{{ route('equipements.index') }}" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="fas fa-tools"></i><b>FC</b></span>
                                            <span class="pcoded-mtext">Equip/Amortissement</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                </ul> 

                            @elseif(Auth::user()->role == 'admin')
                                <ul class="pcoded-item pcoded-left-item">
                                    <li class="">
                                        <a href="{{ route('admin.unites') }}" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="fas fa-shop"></i><b>B</b></span>
                                            <span class="pcoded-mtext">Unites</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                </ul>

                                <ul class="pcoded-item pcoded-left-item">
                                    <li class="">
                                        <a href="{{ route('admin.users') }}" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="fas fa-users"></i><b>M</b></span>
                                            <span class="pcoded-mtext">Utilisateurs</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                </ul>

                                 <ul class="pcoded-item pcoded-left-item">
                                    <li class="">
                                        <a href="{{ route('categorie.index') }}" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="fas fa-right-left"></i><b>M</b></span>
                                            <span class="pcoded-mtext">Categorie Unite</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                </ul>

                                <ul class="pcoded-item pcoded-left-item">
                                    <li class="">
                                        <a href="{{ route('admin.directions') }}" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="fas fa-user"></i><b>M</b></span>
                                            <span class="pcoded-mtext">Superviseurs</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                </ul>

                                <ul class="pcoded-item pcoded-left-item">
                                    <li class="">
                                        <a href="{{ route('assistance') }}" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="fas fa-cog"></i><b>FC</b></span>
                                            <span class="pcoded-mtext">Supports & Assistance</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                </ul> 
                            @endif

                        </div>
                    </nav>