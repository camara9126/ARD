<?php

use App\Models\Achat;
use App\Models\Depense;
use App\Models\Recette;
use App\Models\Unite;
use App\Models\User;
use Illuminate\Support\Carbon;

    // chiffre d'affaire mois actuel ttc
    $caMoisActuel = Recette::where('statut', 'recu')->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('montant');
    $achatGlobal = Achat::where('statut', 'recu')->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('total');
    $depenseGlobal = Depense::where('statut', 'payee')->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('montant');

    $resultatGlobal = $achatGlobal - $depenseGlobal;

    // Nombre d'unite
    $nbrUnites= Unite::where('nom', '!=', 'ARD')->latest()->get();
    // Nombre Utilisateurs
    $users= User::where('role', 'commercial')->latest()->get();
            
?>
    
    @include('partials.header')
    <style>
        .chart-container {
            width: 80%;
            margin: 0 auto;
            padding: 5px;
        }
        canvas {
            max-height: 300px;
        }
    </style>
                    <div class="pcoded-content">
                        <!-- Page-header start -->
                        <div class="page-header">
                            <div class="page-block">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="page-header-title">
                                            <h5 class="m-b-10">Tableau de Bord {{ strtoupper(Auth::user()->role) }}</h5>
                                            <p class="m-b-0">Bienvenue</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="index.html"> <i class="fa fa-home"></i> </a>
                                            </li>
                                            <li class="breadcrumb-item"><a href="#!">Dashboard</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Page-header end -->
                        <div class="pcoded-inner-content">
                            <!-- Main-body start -->
                            <div class="main-body">
                                <div class="page-wrapper">
                                    <!-- Page-body start -->
                                    <div class="page-body">
                                        <div class="card">
                                            <div class="card-header">
                                                <span><i class="fas fa-tools" style="color: var(--primary); margin-right: 0.5rem;"></i> Support client</span>
                                            </div>
                                            <div class="card-body">
                                            <div class="stat-card">         
                                                <div class="px-2 py-2 mt-0">
                                                    <h4 class="fw-bold mb-2">Bienvenue sur votre SPI.</h4> 
                                                    <p>Contacter le support technique en cas de besoin .</p>  
                                                    <h2 class="fw-bold mt-2">Nos Contacts</h2>
                                                    <ul class="nav flex-column pb-2">
                                                        <li>Email : contact@bcmgroupe.com</li>
                                                        <li>Telephone : +221 78 752 40 26</li>
                                                        <li>Whatsapp : <a href="https://wa.me/+221787524026" class="" target="_blank"><i class="fa-brands fa-whatsapp text-success" ></i>&nbsp;78 752 40 26</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Page-body end -->
                                </div>
                                <div id="styleSelector"> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 

 @include('partials.footer')
