<?php

use App\Models\CompteBancaires;
use App\Models\Achat;
use App\Models\ChargeFixe;
use App\Models\Depense;
use App\Models\Recette;
use App\Models\Vente;
use App\Models\MouvementStock;
use App\Models\Produit;
use App\Models\Unite;

use Illuminate\Support\Carbon;

    $mouvements = MouvementStock::Where('unite_id', $unite->id)->latest()->get();

    $factures = Vente::Where('unite_id', $unite->id)->with('client')->latest()->get();

    $amortissements= $unite->equipements->sum('amortissement_mensuel');

    $chargeFixes= ChargeFixe::Where('unite_id', $unite->id)->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('montant');
    
    // chiffre d'affaire mois actuel
    $caMoisActuel = Recette::where('statut', 'recu')->Where('unite_id', $unite->id)->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('montant');
   
    // chiffre d'affaire global actuel ttc
    $caGlobal= Recette::where('statut', 'recu')->Where('unite_id', $unite->id)->whereYear('created_at', now()->year)->sum('montant');

    $achatGlobal = Achat::where('statut', 'recu')->Where('unite_id', $unite->id)->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('total');

    $depenseGlobal = Depense::where('statut', 'payee')->Where('unite_id', $unite->id)->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('montant');

    $banque = CompteBancaires::where('unite_id', $unite->id)->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('solde_initial');

    $resultatGlobal = $caMoisActuel - $depenseGlobal -  $chargeFixes - $amortissements;

   
        // ===== SECTION PRODUCTION UNITE =====

        // ===== MENSUEL =====

        $months = [];
        $revenues = [];

        for ($i = 1; $i <= 12; $i++) {

            $recette = Recette::whereMonth('created_at', $i)->where('statut', 'recu')->where('unite_id', $unite->id)->whereYear('created_at', now()->year)->sum('montant');

            $months[] = Carbon::create()->month($i)->translatedFormat('F');
            $revenues[] = round($recette, 2);
        }

        $monthlyData = [
            'months' => $months,
            'revenues' => $revenues,
        ];

?>
    @include('partials.header')

<style>
    /* Chart Container */
        .chart-container {
            position: relative;
            height: 250px;
            width: 100%;
        }

        canvas {
            width: 100% !important;
            height: 100% !important;
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
                                                <!-- <a href="#"> <i class="fa fa-home"></i> </a> -->
                                                 Categorie
                                            </li>
                                            <li class="breadcrumb-item">{{ $unite->categorie->nom ?? 'Non spécifiée' }}</li>
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
                                        <div class="row">
                                            <!-- Material statustic card start -->
                                            <div class="col-xl-12 col-md-12">
                                                <div class="card mat-stat-card">
                                                    <div class="card-block">
                                                        <div class="row align-items-center b-b-default">
                                                            <div class="col-sm-3 b-r-default p-b-20 p-t-20" style="background-color: #ffd8f2;">
                                                                <div class="row align-items-center text-center">
                                                                    <div class="col-4 p-r-0">
                                                                        <i class="fas fa-money-bill-wave text-c-purple f-24"></i>
                                                                    </div>
                                                                    <div class="col-8 p-l-0">
                                                                        <h5>{{ number_format($caMoisActuel, '0', ',', ' ') }} FCFA</h5>
                                                                        <p class="text-muted m-b-0">CA Glogal </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3 b-r-default p-b-20 p-t-20" style="background-color: #ffabab;">
                                                                <div class="row align-items-center text-center">
                                                                    <div class="col-4 p-r-0">
                                                                        <i class="fas fa-tools text-c-green f-24"></i>
                                                                    </div>
                                                                    <div class="col-8 p-l-0">
                                                                        <h5>{{ number_format($amortissements, '0', ',', ' ') }} FCFA</h5>
                                                                        <p class="text-muted m-b-0">Amortissements</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3 p-b-20 p-t-20 b-r-default" style="background-color: #aeffc8;">
                                                                <div class="row align-items-center text-center">
                                                                    <div class="col-4 p-r-0">
                                                                        <i class="fas fa-arrow-down text-c-red f-24"></i>
                                                                    </div>
                                                                    <div class="col-8 p-l-0">
                                                                        <h5>{{ number_format($depenseGlobal, '0', ',', ' ') }} FCFA</h5>
                                                                        <p class="text-muted m-b-0">Depense Global</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3 p-b-20 p-t-20" style="background-color: #d9c7ff;">
                                                                <div class="row align-items-center text-center">
                                                                    <div class="col-4 p-r-0">
                                                                        <i class="fas fa-chart-line text-c-blue f-24"></i>
                                                                    </div>
                                                                    <div class="col-8 p-l-0">
                                                                        <h5>{{ number_format($banque, '0', ',', ' ') }} FCFA</h5>
                                                                        <p class="text-muted m-b-0">Solde Bancaire</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-3 mx-auto mt-2 p-b-20 p-t-20" style="background-color: #6ae678;">
                                                                <div class="row mt-2 align-items-center text-center">
                                                                    <div class="col-4 p-r-0">
                                                                        <i class="fas fa-money-bill-alt text-c-blue f-24"></i>
                                                                    </div>
                                                                    <div class="col-8 p-l-0">
                                                                        <h5 class="text-white">{{ number_format($resultatGlobal, '0', ',', ' ') }} FCFA</h5>
                                                                        <p class="text-white m-b-0">Caisse</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <div class="row">
                                            <div class="col-md-5 col-lg-5">
                                                <div class="card table-card">
                                                    <div class="card-header">
                                                        <h5>TABLEAU DE SYNTHESE DE L'UNITE</h5>
                                                    </div>
                                                    <div class="card-block">
                                                        <div class="table-responsive">
                                                            <table class="table table-hover m-b-0 without-header">
                                                                <thead>
                                                                    <tr>
                                                                        <th><b>Indicateur</b></th>
                                                                        <th><b>Montant</b></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>Chiffre d'affaires</td>
                                                                        <td>{{ number_format($caMoisActuel, 0, ',', ' ') }} XOF</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Depenses</td>
                                                                        <td>{{ number_format($depenseGlobal, 0, ',', ' ') }} XOF</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Charges fixes</td>
                                                                        <td>{{ number_format($chargeFixes, 0, ',', ' ') }} XOF</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Amortissements</td>
                                                                        <td>{{ number_format($amortissements, 0, ',', ' ') }} XOF</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Resultats net</strong></td>
                                                                        <td><strong>{{ number_format($resultatGlobal, 0, ',', ' ') }} XOF</strong></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="7" align="center">
                                                                            @if($resultatGlobal > 0)
                                                                                <span class="text-success fw-bold">L'unité est Beneficiaire ce mois-ci.</span>
                                                                            @elseif($resultatGlobal < 0)
                                                                                <span class="text-danger fw-bold"> L'unité est Déficitaire (en Perte) ce mois-ci.</span>
                                                                            @else
                                                                                <span class="text-primary fw-bold">L'unité est Equilibrée ce mois-ci.</span>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-7 col-lg-7">
                                                <div class="card">
                                                    <div class="card-block">
                                                        <canvas id="evolutionChart"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 col-lg-6">
                                                <div class="card table-card">
                                                    <div class="card-header">
                                                        <h5>LISTE DES FACTURES</h5>
                                                        <!-- <a href="{{ route('vente.facture') }}" style="color: var(--secondary); text-decoration: none; font-weight: 500;">Voir plus →</a> -->
                                                    </div>
                                                    <div class="card-block">
                                                        <div class="table-responsive">
                                                            <table class="table table-hover m-b-0 without-header">
                                                                <thead>
                                                                    <tr>
                                                                        <th><b>Reference</b></th>
                                                                        <th><b>Client</b></th>
                                                                        <th><b>Montant TVA</b></th>
                                                                        <th><b>Montant Total</b></th>
                                                                        <th><b>Montant Payer</b></th>
                                                                        <th><b>Montant Restant</b></th>
                                                                        <th><b>Date</b></th>
                                                                        <th><b>Statut</b></th>
                                                                        <!--<th><b>Actions</b></th>-->
                                                                        <th><b>Facture</b></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @forelse($factures->take(5) as $v)
                                                                    @if($v->montant_restant == 0)
                                                                    <tr>
                                                                        <td><strong>{{$v->reference}}</strong></td>
                                                                        <td>{{$v->client->nom ?? 'Vide'}}</td>
                                                                        <td>{{number_format($v->total_tva, 0, ',',' ')}} XOF</td>
                                                                        <td>{{number_format($v->total_ttc, 0, ',',' ')}} XOF</td>
                                                                        <td>{{number_format($v->montant_paye, 0, ',', ' ')}} XOF</td>
                                                                        <td>{{number_format($v->montant_restant, 0, ',',' ')}} XOF</td>
                                                                        <td>{{$v->created_at->format('d/m/y')}}</td>
                                                                        <td>
                                                                            @if($v->statut == 'payee')
                                                                                <span class="status-badge badge bg-success">{{$v->statut}}</span>
                                                                            @elseif($v->statut == 'partielle')
                                                                                <span class="status-badge badge-pending">{{$v->statut}}</span>
                                                                            @else
                                                                                <span class="status-badge badge bg-danger">{{$v->statut}}</span>
                                                                            @endif
                                                                        </td>
                                                                        <!--<td>
                                                                            @if($v->montant_restant == 0)
                                                                                <button type="button" class="status-badge badge bg-secondary">
                                                                                    Payée
                                                                                </button>
                                                                            @else
                                                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-id="{{$v->id}}" data-bs-target="#paiementModal">Payer
                                                                            </button>
                                                                            @endif
                                                                        </td>-->
                                                                        <td>
                                                                            <div class="row">
                                                                                <div class="col-6">
                                                                                    <a href="{{route('vente.show', $v->id)}}" class="action-btn text-primary mr-2" title="afficher la facture">
                                                                                        <i class="fas fa-file-invoice"></i>
                                                                                    </a>
                                                                                </div>  
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    @endif
                                                                    @empty
                                                                        <tr>
                                                                            <td colspan="7" align="center">Donnee vide !</td>
                                                                        </tr>
                                                                    @endforelse
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            <div class="col-md-12 col-lg-6">
                                                <div class="card table-card">
                                                    <div class="card-header">
                                                        <h5>MOUVEMENT DE STOCK</h5>
                                                        <!-- <a href="{{ route('stock.index') }}" style="color: var(--secondary); text-decoration: none; font-weight: 500;">Voir plus →</a> -->
                                                    </div>
                                                    <div class="card-block">
                                                        <div class="table-responsive">
                                                            <table class="table table-hover m-b-0 without-header">
                                                                <thead>
                                                                    <tr>
                                                                        <th><b>Reference</b></th>
                                                                        <th><b>Produit</b></th>
                                                                        <th><b>type</b></th>
                                                                        <th><b>Quantite</b></th>
                                                                        <th><b>Date</b></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @forelse($mouvements->take(5) as $m)
                                                                    <tr>
                                                                        <td>
                                                                            <div class="product-info">
                                                                                <div>
                                                                                    <div style="font-weight: 600;">{{$m->reference}}</div>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>{{$m->produit->nom ?? $m->designation}}</td>
                                                                        <td>{{$m->type}}</td>
                                                                        <td><strong>{{$m->quantite}}</strong></td>
                                                                        <td>{{$m->created_at->format('d/m/Y')}}</td>
                                                                    </tr>
                                                                    @empty
                                                                        <tr>
                                                                            <td colspan="7" align="center">Donnee vide !</td>
                                                                        </tr>
                                                                    @endforelse
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
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
   
    <script>

        const colors = {
            primary: '#3949ab',
            secondary: '#5c6bc0',
            success: '#4caf50',
            danger: '#f44336',
            warning: '#ff9800',
            info: '#2196f3',
            purple: '#9c27b0',
            teal: '#009688',
            orange: '#ff5722',
            pink: '#e91e63',
            categories: [
                '#4caf50', '#f44336', '#2196f3', '#ff9800', 
                '#9c27b0', '#009688', '#ff5722', '#e91e63',
                '#3f51b5', '#00bcd4', '#8bc34a', '#ffc107'
            ]
        };

         // ============================================
        // DONNÉES MENSUELLES - ANNÉE EN COURS
        // ============================================
        const monthlyData = @json($monthlyData);

        
        document.addEventListener('DOMContentLoaded', function() {
            // Initialiser les graphiques
            initEvolutionChart('mensuel');
            initRepartitionChart('mois');
            
            // Mettre à jour les valeurs du dashboard
            updateDashboardValues();
            
            // Gestionnaires d'événements pour les boutons de période
            setupPeriodButtons();
        });

                let evolutionChart;
        
        function initEvolutionChart(period) {
            const ctx = document.getElementById('evolutionChart').getContext('2d');
            
            let labels, revenueData, expenseData, profitData, title;
            
            switch(period) {
                case 'mensuel':
                    labels = monthlyData.months;
                    revenueData = monthlyData.revenues;
                    expenseData = monthlyData.expenses;
                    profitData = monthlyData.profits;
                    title = 'ANALYSE & RECETTE UNITÉS  (<?= now()->year ?>)';
                    break;
            }
            
            // Détruire le graphique existant s'il y en a un
            if (evolutionChart) {
                evolutionChart.destroy();
            }
            
            evolutionChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Recettes',
                            data: revenueData,
                            borderColor: colors.info,
                            backgroundColor: colors.info,
                            borderWidth: 3,
                            pointBackgroundColor: colors.info,
                            pointBorderColor: 'white',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            tension: 0.3,
                            fill: false
                        },
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: title,
                            font: {
                                size: 14,
                                weight: '500'
                            },
                            padding: {
                                bottom: 20
                            }
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    let value = context.raw || 0;
                                    return `${label}: ${value.toLocaleString('fr-FR')} XOF`;
                                }
                            }
                        },
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                boxWidth: 6
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: false,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return  value.toLocaleString('fr-FR') + 'XOF ';
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

    </script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

 @include('partials.footer')
