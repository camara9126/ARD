<?php
    use App\Models\Recette;
    $unite = request()->user()->unite;

    // chiffre d'affaire mois actuel ttc
    $caMoisActuel = Recette::where('unite_id', request()->user()->unite_id)->where('statut', 'recu')->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('montant');

    //Chiffre d'affaire HT + montant TVA
    $montant_tva = $caMoisActuel * ($unite->taux_tva / 100) /(1 + ($unite->taux_tva / 100));
    $ca_ht = $caMoisActuel - $montant_tva;

?>
    @include('partials.header')
    <style>
        
        /* Overlay for mobile */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }
        
        .overlay.active {
            display: block;
        }
        
        /* Chart Container */
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
        
        /* Table Styles */
        .data-table {
            width: 100%;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        
        .data-table th {
            background: #f8f9fa;
            border: none;
            padding: 15px;
            font-weight: 600;
            color: #495057;
        }
        
        .data-table td {
            padding: 15px;
            border-top: 1px solid #e9ecef;
            vertical-align: middle;
        }
        
        /* Badge Styles */
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .badge-paid {
            background: #d4edda;
            color: #155724;
        }
        
        .badge-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .badge-canceled {
            background: #f8d7da;
            color: #721c24;
        }
        
        /* Button Styles */
        .btn-action {
            width: 35px;
            height: 35px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
        }
        
        /* Footer */
        .footer {
            background: white;
            padding: 20px 0;
            margin-top: 40px;
            border-top: 1px solid #e9ecef;
        }

        /* rapport */
        .dashboard-container {
            max-width: 1000px;
            margin: 0 auto;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e1e5eb;
        }

        h1 {
            color: #2c3e50;
            font-size: 28px;
        }

        .period-selector {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .period-selector select {
            padding: 8px 15px;
            border-radius: 6px;
            border: 1px solid #ddd;
            background-color: white;
            font-weight: 500;
        }

        .stats-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 24px;
        }

        .orders .stat-icon {
            background-color: #e3f2fd;
            color: #1976d2;
        }

        .revenue .stat-icon {
            background-color: #e8f5e9;
            color: #388e3c;
        }

        .products .stat-icon {
            background-color: #fff3e0;
            color: #f57c00;
        }

        .customers .stat-icon {
            background-color: #f3e5f5;
            color: #7b1fa2;
        }

        .stat-info h3 {
            font-size: 14px;
            color: #7f8c8d;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-change {
            font-size: 13px;
        }

        .positive {
            color: #27ae60;
        }

        .negative {
            color: #e74c3c;
        }

        .charts-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
            margin-bottom: 30px;
        }

        @media (max-width: 1100px) {
            .charts-container {
                grid-template-columns: 1fr;
            }
        }

        .chart-card {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .chart-header h2 {
            font-size: 18px;
            color: #2c3e50;
        }

        .chart-wrapper {
            position: relative;
            height: 300px;
        }

        footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e1e5eb;
            color: #7f8c8d;
            font-size: 14px;
        }

        .export-buttons {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        .btn-primary {
            background-color: #3498db;
            color: white;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .btn-secondary {
            background-color: #ecf0f1;
            color: #2c3e50;
        }

        .btn-secondary:hover {
            background-color: #d5dbdb;
        }
                /* Dashboard */
        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }
        
        .dashboard-card {
            background-color: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .card-title {
            font-size: 15px;
            color: var(--gray-color);
            font-weight: 400;
        }
        
        .card-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
        }
        
        .icon-income {
            background: linear-gradient(135deg, #4caf50, #8bc34a);
        }
        
        .icon-expense {
            background: linear-gradient(135deg, #f44336, #ff9800);
        }

        .icon-amort {
            background: linear-gradient(135deg, #f2d810, #e88017);
        }
        
        .icon-profit {
            background: linear-gradient(135deg, #2196f3, #03a9f4);
        }
        
        .icon-cash {
            background: linear-gradient(135deg, #9c27b0, #673ab7);
        }
        
        .card-value {
            font-size: 15px;
            font-weight: 250;
            margin-bottom: 10px;
        }
        
        .card-value.positive {
            color: var(--success-color);
        }
        
        .card-value.negative {
            color: var(--danger-color);
        }
        
        .card-trend {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
        }
        
        .trend-up {
            color: var(--success-color);
        }
        
        .trend-down {
            color: var(--danger-color);
        }
        
        /* Charts Section */
        .charts-section {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
            margin-bottom: 40px;
        }
        
        .chart-card {
            background-color: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .chart-title {
            font-size: 20px;
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .period-selector {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .period-btn {
            padding: 8px 15px;
            border-radius: 6px;
            border: 1px solid #448aff;
            background-color: white;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        
        .period-btn.active {
            background-color: var(--secondary-color);
            color: green;
            border-color: var(--secondary-color);
        }
            
        canvas {
            width: 100% !important;
            height: 100% !important;
        }

        
        @media (max-width: 992px) {
            .charts-section {
                grid-template-columns: 1fr;
            }
        }
    </style>

 <!-- Barre d'outils de téléchargement  -->
    <style>

        .download-toolbar {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            flex-wrap: wrap;
            align-items: center;
        }

        .download-toolbar .btn-download {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .download-toolbar .btn-download:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .btn-download-png {
            background: #4CAF50;
            color: white;
        }

        .btn-download-pdf {
            background: #f44336;
            color: white;
        }

        .btn-download-all {
            background: #2196F3;
            color: white;
        }

        /* Indicateur de chargement */
        #loading-indicator {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            flex-direction: column;
        }

        #loading-indicator.active {
            display: flex;
        }

        .loading-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Zone à capturer */
        #dashboard-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
        }
    </style>
        <div class="pcoded-content">
           
            <!-- INDICATEUR DE CHARGEMENT -->
            <div id="loading-indicator">
                <div class="loading-content">
                    <div class="spinner"></div>
                    <p style="font-size: 16px; margin: 0;" id="loading-message">Génération en cours...</p>
                    <p style="font-size: 13px; color: #7f8c8d; margin-top: 5px;">Veuillez patienter</p>
                </div>
            </div>


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
                                    <a href="#"> <i class="fa fa-home"></i> </a>
                                </li>
                                <li class="breadcrumb-item"><a href="#!">{{  Auth::user()->unite->categorie->nom }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FICHIER A TELECHARGER -->
            <div id="dashboard-content">
                <!-- BARRE D'OUTILS DE TÉLÉCHARGEMENT -->
                <div class="download-toolbar">
                    <span style="font-weight: 600; color: #495057; margin-right: auto;">
                        📊 Rapport {{ strtoupper(Auth::user()->unite->nom) }}
                    </span>
                    <button onclick="downloadPageAsPNG()" class="btn-download btn-download-png">
                        📸 PNG
                    </button>
                    <button onclick="downloadPageAsPDF()" class="btn-download btn-download-pdf">
                        📄 PDF
                    </button>
                    <button onclick="downloadAllCharts()" class="btn-download btn-download-all">
                        📊 Tous les graphiques
                    </button>
                </div>
                <!-- Page-header end -->
                <div class="pcoded-inner-content">
                    <!-- Main-body start -->
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- Page-body start -->
                            <div class="page-body">
                                <!-- Basic table card start -->
                                    
                                <div class="row">
                                    <!-- SITE VISIT CHART start -->
                                    <div class="col-md-2 col-lg-2">      
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Total Recettes</h3>
                                                <div class="card-icon icon-income">
                                                    <i class="fas fa-arrow-up"></i>
                                                </div>
                                            </div>
                                            <div class="card-value" id="total-revenus">XOF 124,850.00</div>
                                            <!-- <div class="card-trend trend-up">
                                                <i class="fas fa-arrow-up"></i>
                                                <span id="revenus-trend">+12% vs mois précédent</span>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-lg-2">      
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Total Dépenses</h3>
                                                <div class="card-icon icon-expense">
                                                    <i class="fas fa-arrow-down"></i>
                                                </div>
                                            </div>
                                            <div class="card-value" id="total-depenses">XOF 78,430.00</div>
                                            <!-- <div class="card-trend trend-down">
                                                <i class="fas fa-arrow-down"></i>
                                                <span id="depenses-trend">-5% vs mois précédent</span>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-lg-2">      
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Total Amortissement</h3>
                                                <div class="card-icon icon-amort">
                                                    <i class="fas fa-tools"></i>
                                                </div>
                                            </div>
                                            <div class="card-value">{{ number_format($amortissements, 0, ',', ' ')}} XOF</div>
                                            <!-- <div class="card-trend trend-down">
                                                <i class="fas fa-arrow-down"></i>
                                                <span id="depenses-trend">-5% vs mois précédent</span>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-lg-3">     
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Résultat Net</h3>
                                                <div class="card-icon icon-profit">
                                                    <i class="fas fa-chart-line"></i>
                                                </div>
                                            </div>
                                            <div class="card-value positive" id="resultat-net">XOF 46,420.00</div>
                                            <div class="card-trend trend-up">
                                                <i class="fas fa-arrow-up"></i>
                                                <span>Bénéfice ce mois</span>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="col-md-3 col-lg-3">          
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Trésorerie Actuelle</h3>
                                                <div class="card-icon icon-cash">
                                                    <i class="fas fa-wallet"></i>
                                                </div>
                                            </div>
                                            <div class="card-value" id="tresorerie">XOF 89,250.00</div>
                                            <div class="card-trend trend-up">
                                                <i class="fas fa-arrow-up"></i>
                                                <span>Solde disponible</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                      
                                <div class="row">
                                    <!-- SITE VISIT CHART start -->
                                    <div class="col-md-12 col-lg-8">
                                        
                                        <div class="card">
                                            <!-- Graphique 1: Évolution des Recettes et Dépenses -->
                                            <div class="chart-card">
                                                <div class="chart-header">
                                                    <h3 class="chart-title">Évolution des Recettes et Dépenses</h3>
                                                    <div class="period-selector" id="period-selector-1">
                                                        <button class="period-btn active" data-period="mensuel">Mensuel</button>
                                                        <button class="period-btn" data-period="trimestriel">Trimestriel</button>
                                                        <button class="period-btn" data-period="annuel">Annuel</button>
                                                    </div>
                                                    <!-- BOUTON DE TÉLÉCHARGEMENT POUR GRAPHIQUE 1 -->
                                                    <button onclick="downloadChart('evolutionChart', 'evolution_recettes_depenses')" 
                                                            class="download-btn" 
                                                            style="margin-left: 10px; padding: 6px 12px; background: #4CAF50; color: white; 
                                                                border: none; border-radius: 4px; cursor: pointer; font-size: 13px;">
                                                        ⬇️ Télécharger
                                                    </button>
                                                </div>
                                                <div class="chart-container">
                                                    <canvas id="evolutionChart"></canvas>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                
                                    <div class="col-md-12 col-lg-4">      
                                        <div class="card"> 
                                            <!-- Graphique 2: Répartition des Dépenses -->
                                            <div class="chart-card">
                                                <div class="chart-header">
                                                    <h3 class="chart-title">Répartition des Top Produits</h3>
                                                    <div class="period-selector" id="period-selector-2">
                                                        <button class="period-btn active" data-period="mois">Ce mois</button>
                                                        <button class="period-btn" data-period="annee">Cette année</button>
                                                    </div>
                                                    <!-- BOUTON DE TÉLÉCHARGEMENT POUR GRAPHIQUE 2 -->
                                                    <button onclick="downloadChart('repartitionChart', 'repartition_top_produits')" 
                                                            class="download-btn" 
                                                            style="margin-left: 10px; padding: 6px 12px; background: #2196F3; color: white; 
                                                                border: none; border-radius: 4px; cursor: pointer; font-size: 13px;">
                                                        ⬇️ Télécharger
                                                    </button>
                                                </div>
                                                <div class="chart-container">
                                                    <canvas id="repartitionChart"></canvas>
                                                </div>
                                            </div>  
                                        </div>
                                    </div>
                                    
                                </div>  
                                @if(request()->user()->unite->taux_tva > 0)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="stat-card">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <p class="text-muted mb-1">Montant TVA</p>
                                                        <h3 class="value fw-bold">{{ number_format($montant_tva, 0, ',', ' ') }} XOF</h3>
                                                    </div>
                                                    <div class="icon bg-primary bg-opacity-10 text-primary">
                                                        <!--<i class="fas fa-franc-sign"></i>-->
                                                        <span>💰</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif  
                                
                                <div class="card">
                                    <div class="card-header">
                                        <h1 class="text-center">Solvabilité de l’unite</h1>
                                    </div>
                                    <div class="card-body">
                                        @if( $unite->statut_solvabilite == 'solvable')
                                            <div class="card-value text-success"> L'Unite est solvable </div>
                                        @else
                                            <div class="card-value text-danger"> L'Unite est insolvable </div>
                                        @endif
                                    </div>
                                </div>
                                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
                

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    


    <!-- Donnee graphique recette, depense et benefice -->
    <script>

        // ============================================
        // DONNÉES COMPTABLES POUR LES GRAPHIQUES
        // ============================================

        // Configuration des couleurs
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
        

        // ============================================
        // DONNÉES TRIMESTRIELLES
        // ============================================
        const quarterlyData = @json($quarterlyData);


        // ============================================
        // DONNÉES ANNUELLES
        // ============================================

        const yearlyData = @json($yearlyData);

        // ============================================
        // DONNÉES DE RÉPARTITION DES DÉPENSES - MOIS
        // ============================================
        
        const expensesDistributionMonth = {
            categories: @json($categories),
            amounts: @json($amounts),
            colors: ['#4caf50', '#2196f3', '#ff9800', '#f44336', 
                     '#9c27b0', '#009688', '#ff5722', '#e91e63']
        };

        // ============================================
        // DONNÉES DE RÉPARTITION DES DÉPENSES - ANNÉE
        // ============================================
        
       const expensesDistributionYear = {
            categories: @json($yearCategories),
            amounts: @json($yearAmounts),
             
        };

        // ============================================
        // INITIALISATION DES GRAPHIQUES
        // ============================================
        
        document.addEventListener('DOMContentLoaded', function() {
            // Initialiser les graphiques
            initEvolutionChart('mensuel');
            initRepartitionChart('mois');
            
            // Mettre à jour les valeurs du dashboard
            updateDashboardValues();
            
            // Gestionnaires d'événements pour les boutons de période
            setupPeriodButtons();
        });

        // ============================================
        // GRAPHIQUE 1: ÉVOLUTION DES RECETTES ET DÉPENSES
        // ============================================
        
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
                    title = 'Évolution mensuelle <?= now()->year ?>';
                    break;
                case 'trimestriel':
                    labels = quarterlyData.quarters;
                    revenueData = quarterlyData.revenues;
                    expenseData = quarterlyData.expenses;
                    profitData = quarterlyData.profits;
                    title = 'Évolution trimestrielle <?= now()->year ?>';
                    break;
                case 'annuel':
                    labels = yearlyData.years;
                    revenueData = yearlyData.revenues;
                    expenseData = yearlyData.expenses;
                    profitData = yearlyData.profits;
                    title = 'Évolution annuelle de 2 ans à <?= now()->year ?>';
                    break;
            }
            
            // Détruire le graphique existant s'il y en a un
            if (evolutionChart) {
                evolutionChart.destroy();
            }
            
            evolutionChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Recettes',
                            data: revenueData,
                            borderColor: colors.success,
                            backgroundColor: 'rgba(76, 175, 80, 0.1)',
                            borderWidth: 3,
                            pointBackgroundColor: colors.success,
                            pointBorderColor: 'white',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            tension: 0.3,
                            fill: false
                        },
                        {
                            label: 'Dépenses',
                            data: expenseData,
                            borderColor: colors.danger,
                            backgroundColor: 'rgba(244, 67, 54, 0.1)',
                            borderWidth: 3,
                            pointBackgroundColor: colors.danger,
                            pointBorderColor: 'white',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            tension: 0.3,
                            fill: false
                        },
                        {
                            label: 'Bénéfice',
                            data: profitData,
                            borderColor: colors.info,
                            backgroundColor: 'rgba(33, 150, 243, 0.1)',
                            borderWidth: 2,
                            borderDash: [5, 5],
                            pointBackgroundColor: colors.info,
                            pointBorderColor: 'white',
                            pointBorderWidth: 2,
                            pointRadius: 3,
                            pointHoverRadius: 5,
                            tension: 0.3,
                            fill: false,
                            hidden: false // Caché par défaut, peut être activé
                        }
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

        // ============================================
        // GRAPHIQUE 2: RÉPARTITION DES DÉPENSES
        // ============================================
        
        let repartitionChart;
        
        function initRepartitionChart(period) {
            const ctx = document.getElementById('repartitionChart').getContext('2d');
            
            let labels, data, backgroundColors, title;
            
            if (period === 'mois') {
                labels = expensesDistributionMonth.categories;
                data = expensesDistributionMonth.amounts;
                backgroundColors = expensesDistributionMonth.colors;
                title =  new Date().toLocaleDateString('fr-FR', { month: 'long' }) ;
            } else {
                labels = expensesDistributionYear.categories;
                data = expensesDistributionYear.amounts;
                backgroundColors = colors.categories;
                title = 'Top Produits Annuelles - <?= now()->year ?>';
            }
            
            // Détruire le graphique existant
            if (repartitionChart) {
                repartitionChart.destroy();
            }
            
            repartitionChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: backgroundColors,
                        borderColor: 'white',
                        borderWidth: 2,
                        hoverOffset: 15
                    }]
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
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    let value = context.raw || 0;
                                    let total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    let percentage = ((value / total) * 100).toFixed(1);
                                    return `${label}: XOF ${value.toLocaleString('fr-FR')} (${percentage} %)`;
                                }
                            }
                        },
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                padding: 15,
                                font: {
                                    size: 11
                                }
                            }
                        }
                    },
                    cutout: '60%',
                    layout: {
                        padding: {
                            top: 20,
                            bottom: 20
                        }
                    }
                }
            });
        }

        // ============================================
        // GESTIONNAIRES DE PÉRIODE
        // ============================================
        
        function setupPeriodButtons() {
            // Boutons pour le graphique d'évolution
            document.querySelectorAll('#period-selector-1 .period-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    // Retirer la classe active de tous les boutons
                    document.querySelectorAll('#period-selector-1 .period-btn').forEach(b => {
                        b.classList.remove('active');
                    });
                    // Ajouter la classe active au bouton cliqué
                    this.classList.add('active');
                    
                    // Mettre à jour le graphique avec la période sélectionnée
                    const period = this.getAttribute('data-period');
                    initEvolutionChart(period);
                    
                    // Mettre à jour les valeurs du dashboard en fonction de la période
                    updateDashboardValuesForPeriod(period);
                });
            });
            
            // Boutons pour le graphique de répartition
            document.querySelectorAll('#period-selector-2 .period-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('#period-selector-2 .period-btn').forEach(b => {
                        b.classList.remove('active');
                    });
                    this.classList.add('active');
                    
                    const period = this.getAttribute('data-period');
                    initRepartitionChart(period);
                });
            });
        }

        // ============================================
        // MISE À JOUR DES VALEURS DU DASHBOARD
        // ============================================
        
        function updateDashboardValues() {
            // Utiliser les données du mois actuel (index 10)
            const currentMonth = new Date().getMonth(); // Mois (0-indexed)
            
            document.getElementById('total-revenus').textContent = 
                `${monthlyData.revenues[currentMonth].toLocaleString('fr-FR')} XOF`;
            
            document.getElementById('total-depenses').textContent = 
                `${monthlyData.expenses[currentMonth].toLocaleString('fr-FR')} XOF`;
            
            document.getElementById('resultat-net').textContent = 
                `${monthlyData.profits[currentMonth].toLocaleString('fr-FR')} XOF`;
            
            // Trésorerie (cumul des bénéfices)
            let tresorerie = 0;
            for(let i = 0; i <= currentMonth; i++) {
                tresorerie += monthlyData.profits[i];
            }
            document.getElementById('tresorerie').textContent = 
                `${tresorerie.toLocaleString('fr-FR')} XOF`;
        }
        
        function updateDashboardValuesForPeriod(period) {
            if (period === 'mensuel') {
                updateDashboardValues();
            } else if (period === 'trimestriel') {
                // Utiliser les données du T4
                document.getElementById('total-revenus').textContent = 
                    `${quarterlyData.revenues[3].toLocaleString('fr-FR')} XOF`;
                document.getElementById('total-depenses').textContent = 
                    `${quarterlyData.expenses[3].toLocaleString('fr-FR')} XOF`;
                document.getElementById('resultat-net').textContent = 
                    `${quarterlyData.profits[3].toLocaleString('fr-FR')} XOF`;
                document.getElementById('tresorerie').textContent = 
                    `${quarterlyData.profits[3].toLocaleString('fr-FR')} XOF`;
            } else if (period === 'annuel') {
                // Utiliser les données actuelles
                document.getElementById('total-revenus').textContent = 
                    `${yearlyData.revenues[4].toLocaleString('fr-FR')} XOF`;
                document.getElementById('total-depenses').textContent = 
                    `${yearlyData.expenses[4].toLocaleString('fr-FR')} XOF`;
                document.getElementById('resultat-net').textContent = 
                    `${yearlyData.profits[4].toLocaleString('fr-FR')} XOF`;
                document.getElementById('tresorerie').textContent = 
                    `${yearlyData.profits[4].toLocaleString('fr-FR')} XOF`;
            }
        }

 
        // Exécuter les calculs
        const yearlyStats = calculateYearlyStats();
    </script>

   <!-- ============================================
    SCRIPT DE TÉLÉCHARGEMENT COMPLET
    ============================================ -->
    <script>
        /**
         * Afficher/masquer l'indicateur de chargement
         */
        function showLoading(message = 'Génération en cours...') {
            const indicator = document.getElementById('loading-indicator');
            const msg = document.getElementById('loading-message');
            if (indicator) {
                indicator.classList.add('active');
                if (msg) msg.textContent = message;
            }
        }

        function hideLoading() {
            const indicator = document.getElementById('loading-indicator');
            if (indicator) {
                indicator.classList.remove('active');
            }
        }

        /**
         * Télécharger toute la page en PNG
         */
        function downloadPageAsPNG() {
            const element = document.getElementById('dashboard-content');
            
            if (!element) {
                alert('Contenu introuvable !');
                return;
            }
            
            showLoading('Génération du PNG en cours...');
            
            // Attendre un peu que tout soit bien chargé
            setTimeout(() => {
                html2canvas(element, {
                    scale: 2, // Qualité haute
                    useCORS: true,
                    allowTaint: true,
                    backgroundColor: '#ffffff',
                    logging: false,
                    width: element.scrollWidth,
                    height: element.scrollHeight,
                    windowWidth: element.scrollWidth,
                    windowHeight: element.scrollHeight
                }).then(canvas => {
                    hideLoading();
                    const link = document.createElement('a');
                    const date = new Date().toISOString().slice(0,10);
                    link.download = `dashboard_${date}.png`;
                    link.href = canvas.toDataURL('image/png', 1.0);
                    link.click();
                }).catch(error => {
                    hideLoading();
                    console.error('Erreur PNG:', error);
                    alert('Erreur lors de la génération du PNG : ' + error.message);
                });
            }, 500);
        }

        /**
         * Télécharger toute la page en PDF
         */
        function downloadPageAsPDF() {
            const element = document.getElementById('dashboard-content');
            
            if (!element) {
                alert('Contenu introuvable !');
                return;
            }
            
            showLoading('Génération du PDF en cours...');
            
            setTimeout(() => {
                html2canvas(element, {
                    scale: 2,
                    useCORS: true,
                    allowTaint: true,
                    backgroundColor: '#ffffff',
                    logging: false,
                    width: element.scrollWidth,
                    height: element.scrollHeight,
                    windowWidth: element.scrollWidth,
                    windowHeight: element.scrollHeight
                }).then(canvas => {
                    const imgData = canvas.toDataURL('image/png');
                    const { jsPDF } = window.jspdf;
                    const pdf = new jsPDF('p', 'mm', 'a4');
                    
                    const pdfWidth = pdf.internal.pageSize.getWidth();
                    const pdfHeight = (canvas.height * pdfWidth) / canvas.width;
                    
                    let heightLeft = pdfHeight;
                    let position = 0;
                    
                    // Ajouter la première page
                    pdf.addImage(imgData, 'PNG', 0, position, pdfWidth, pdfHeight);
                    heightLeft -= pdf.internal.pageSize.getHeight();
                    
                    // Ajouter des pages supplémentaires si nécessaire
                    let pageCount = 1;
                    while (heightLeft > 0) {
                        position = heightLeft - pdfHeight;
                        pdf.addPage();
                        pdf.addImage(imgData, 'PNG', 0, position, pdfWidth, pdfHeight);
                        heightLeft -= pdf.internal.pageSize.getHeight();
                        pageCount++;
                    }
                    
                    hideLoading();
                    const date = new Date().toISOString().slice(0,10);
                    pdf.save(`dashboard_${date}.pdf`);
                }).catch(error => {
                    hideLoading();
                    console.error('Erreur PDF:', error);
                    alert('Erreur lors de la génération du PDF : ' + error.message);
                });
            }, 500);
        }

        /**
         * Télécharger tous les graphiques individuellement
         */
        function downloadAllCharts() {
            const charts = [
                { id: 'evolutionChart', name: 'evolution_recettes_depenses' },
                { id: 'repartitionChart', name: 'repartition_top_produits' }
            ];
            
            let downloaded = 0;
            let errors = 0;
            
            charts.forEach((chart, index) => {
                setTimeout(() => {
                    const canvas = document.getElementById(chart.id);
                    if (canvas) {
                        try {
                            const link = document.createElement('a');
                            const date = new Date().toISOString().slice(0,10);
                            link.download = `${chart.name}_${date}.png`;
                            link.href = canvas.toDataURL('image/png', 1.0);
                            link.click();
                            downloaded++;
                        } catch (e) {
                            errors++;
                            console.error(`Erreur pour ${chart.id}:`, e);
                        }
                    } else {
                        errors++;
                        console.warn(`Graphique ${chart.id} introuvable`);
                    }
                    
                    // Afficher un résumé quand tous sont traités
                    if (index === charts.length - 1) {
                        setTimeout(() => {
                            if (errors > 0) {
                                alert(`⚠️ ${downloaded} graphiques téléchargés, ${errors} erreur(s)`);
                            } else {
                                alert(`✅ ${downloaded} graphiques téléchargés avec succès !`);
                            }
                        }, 300);
                    }
                }, index * 400);
            });
        }

        /**
         * Version améliorée de downloadChart pour les boutons individuels
         * (Garder la fonction existante et l'améliorer)
         */
        function downloadChart(chartId, fileName) {
            const canvas = document.getElementById(chartId);
            
            if (!canvas) {
                alert('Graphique introuvable !');
                return;
            }
            
            try {
                const link = document.createElement('a');
                const date = new Date().toISOString().slice(0,10);
                link.download = `${fileName}_${date}.png`;
                link.href = canvas.toDataURL('image/png', 1.0);
                link.click();
            } catch (error) {
                alert('Erreur lors du téléchargement : ' + error.message);
            }
        }

        // Ajouter un raccourci clavier (Ctrl+P pour PDF, Ctrl+Shift+P pour PNG)
        document.addEventListener('keydown', function(e) {
            // Ctrl+Shift+P = PNG
            if (e.ctrlKey && e.shiftKey && e.key === 'P') {
                e.preventDefault();
                downloadPageAsPNG();
            }
            // Ctrl+P = PDF (si pas déjà pris par l'impression)
            if (e.ctrlKey && !e.shiftKey && e.key === 'p') {
                // Laisser le comportement par défaut (impression)
                // mais on pourrait aussi proposer le PDF
            }
        });

        console.log('📊 Dashboard avec téléchargement prêt !');
        console.log('📸 Ctrl+Shift+P pour PNG');
        console.log('📄 Ctrl+P pour impression (ou PDF)');
    </script>
    
    <script src="{{asset('asset/main.js')}}"></script>


@include('partials.footer')