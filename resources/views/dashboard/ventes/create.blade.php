@include('partials.header')

<style>
    /* Styles spécifiques à la caisse */
    .pos-dashboard {
        display: flex;
        background: #f0f2f5;
        min-height: 100vh;
    }

    .pos-main {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
    }

    .pos-content {
        max-width: 1600px;
        margin: 0 auto;
    }

    /* Layout deux colonnes */
    .pos-two-columns {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .pos-left {
        flex: 2;
        min-width: 300px;
    }

    .pos-right {
        flex: 1;
        min-width: 280px;
    }

    /* Cartes */
    .pos-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 20px;
        overflow: hidden;
    }

    .pos-card-header {
        background: #2c3e50;
        color: white;
        padding: 15px 20px;
        font-weight: 600;
        font-size: 18px;
    }

    .pos-card-body {
        padding: 20px;
    }

    /* Catégories produits */
    .category-header {
        background: #e7f3ff;
        padding: 10px 15px;
        border-radius: 8px;
        margin: 15px 0 10px 0;
        font-weight: 600;
        color: #0066cc;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .product-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 20px;
    }

    .product-card {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 10px 15px;
        cursor: pointer;
        transition: all 0.2s;
        text-align: center;
        min-width: 120px;
    }

    .product-card:hover {
        background: #e9ecef;
        transform: translateY(-2px);
        border-color: #0066cc;
    }

    .product-name {
        font-weight: 600;
        font-size: 14px;
    }

    .product-price {
        font-size: 12px;
        color: #e67e22;
        font-weight: 600;
    }

    .product-ref {
        font-size: 10px;
        color: #6c757d;
    }

    .form-control-sm {
        padding: 6px 10px;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        font-size: 14px;
        width: 100%;
    }

    select.form-control-sm {
        cursor: pointer;
    }

    .btn-icon {
        background: none;
        border: none;
        color: #dc3545;
        cursor: pointer;
        font-size: 18px;
        padding: 5px 8px;
        border-radius: 6px;
    }

    .btn-icon:hover {
        background: #fee2e2;
    }

    /* Résumé */
    .summary-line {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #e9ecef;
    }

    .summary-total {
        font-size: 22px;
        font-weight: 700;
        color: #2c3e50;
        padding: 15px 0;
        border-top: 2px solid #dee2e6;
        margin-top: 10px;
    }

    .tax-box {
        background: #f8f9fa;
        padding: 12px;
        border-radius: 8px;
        margin: 15px 0;
    }

    /* Pavé client */
    .client-pad {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 15px;
        margin-top: 20px;
    }

    .numpad {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
        margin: 15px 0;
    }

    .num-btn {
        background: white;
        border: 1px solid #dee2e6;
        padding: 12px;
        text-align: center;
        font-weight: 600;
        font-size: 16px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .num-btn:hover {
        background: #e9ecef;
        border-color: #0066cc;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }

    .btn-custom {
        flex: 1;
        padding: 12px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-primary-custom {
        background: #0066cc;
        color: white;
    }

    .btn-secondary-custom {
        background: #6c757d;
        color: white;
    }

    .text-muted-small {
        font-size: 11px;
        color: #6c757d;
        text-align: center;
        margin-top: 12px;
    }

    .badge-combo {
        background: #e7f3ff;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        display: inline-block;
        margin: 3px;
    }

    @media (max-width: 900px) {
        .pos-two-columns {
            flex-direction: column;
        }
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
                                                <a href="#"> <i class="fa fa-home"></i> </a>
                                            </li>
                                            <li class="breadcrumb-item"><a href="#!">{{  Auth::user()->unite->categorie->nom }}</a>
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
                                        <!-- Basic table card start -->
                                        <div class="card">
                                            <!--<div class="card-header">
                                                <h5>Ventes</h5>
                                                <span>use class <code>table</code> inside table element</span>
                                                <div class="card-header-right">
                                                    <a href="{{route('vente.create') }}" style="color: var(--primary); text-decoration: none; font-weight: 500;" >Nouvelle commande →</a>
                                                    <ul class="list-unstyled card-option">
                                                        <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                                        <li><i class="fa fa-window-maximize full-card"></i></li>
                                                        <li><i class="fa fa-minus minimize-card"></i></li>
                                                        <li><i class="fa fa-refresh reload-card"></i></li>
                                                        <li><i class="fa fa-trash close-card"></i></li>
                                                    </ul>
                                                </div>
                                            </div>-->
                                            <div class="card-block table-border-style">
                                                @if($errors->any())
                                                    <div style="color: red; margin-bottom: 10px;">
                                                        @foreach ($errors->all() as $error)
                                                            <p>{{ $error }}</p>
                                                        @endforeach
                                                    </div>
                                                @endif

                                                @if(Session::has('success'))
                                                    <div class="alert alert-success text-center" role="alert">
                                                        {{ Session::get('success') }}
                                                    </div>
                                                @elseif(Session::has('danger'))
                                                    <div class="alert alert-danger" role="alert">
                                                        {{ Session::get('danger') }}
                                                    </div>
                                                @endif
                                                
                                                <h2 class="text-center mb-3">Nouvelle vente</h2>
                                                <br>
                                                <form action="{{ route('vente.store') }}" method="POST">
                                                    @csrf
                                                    
                                                    <div class="pos-two-columns">

                                                        <!-- COLONNE GAUCHE : Produits + Panier -->
                                                        <div class="pos-left">
                                                            <div class="pos-card">
                                                                <div class="pos-card-header">
                                                                    <i class="fas fa-box" style="margin-right: 8px;"></i> Caisserie · {{request()->user()->unite->nom}}
                                                                </div>
                                                                <div class="pos-card-body">
                                                                    
                                                                    <!-- Sélection client et dépôt -->
                                                                    <div style="display: flex; gap: 15px; margin-bottom: 20px; flex-wrap: wrap;">
                                                                        <div style="flex: 1;">
                                                                            <label style="font-size: 12px; color: #6c757d;">Client</label>
                                                                            <select name="client_id" class="form-control-sm" style="width: 100%;">
                                                                                <option value="">-- Sélectionner un client --</option>
                                                                                @foreach($clients as $c)
                                                                                    <option value="{{ $c->id }}">{{ ucfirst($c->nom) }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div style="display: flex; align-items: end;">
                                                                            <div style="flex: 1;">
                                                                                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#clientModal" style="padding: 6px 12px;">
                                                                                    + Nouveau client
                                                                                </button>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Recherche produit -->
                                                                        <div style="flex: 1;">
                                                                            <label style="font-size: 12px; color: #6c757d;">Recherche</label>
                                                                            <input type="text" id="search" class="form-control" placeholder="rechercher produit...">
                                                                        </div>         
                                                                    </div>

                                                                    <!-- Produit recherchee -->
                                                                    <div class="category-header">
                                                                        <i class="fas fa-box"></i> Resultat recherche
                                                                    </div>
                                                                    <div class="list-group" id="results">
                                                                        
                                                                    </div>

                                                                    <!-- Produits par catégorie (exemple statique, adaptez selon vos données) -->
                                                                    <!-- <div class="category-header">
                                                                        <i class="fas fa-box"></i> produits
                                                                    </div> -->
                                                                    <div class="product-grid" id="productGridShoes">
                                                                        @if($unite->categorie->slug == 'service')
                                                                            @foreach($services->take(15) as $service)
                                                                                <div class="product-card" data-id="{{ $service->id }}" data-prix_vente="{{ $service->prix_vente }}" data-nom="{{ $service->nom }}">
                                                                                    <!--<div class="product-image">
                                                                                        <img src="{{ asset('storage/'.$service->image) }}" width="20">
                                                                                    </div>-->
                                                                                    <div class="product-name">{{ $service->nom }}</div>
                                                                                    <div class="product-price">{{ number_format($service->prix, 0, ',', ' ') }} CFA</div>
                                                                                    <!-- <div class="product-price"><b>{{ $service->stock }}</b> en Stock</div> -->
                                                                                </div>
                                                                            @endforeach
                                                                        @else
                                                                            @foreach($produits->take(15) as $produit)
                                                                                <div class="product-card" data-id="{{ $produit->id }}" data-prix_vente="{{ $produit->prix_vente }}" data-nom="{{ $produit->nom }}">
                                                                                    <!--<div class="product-image">
                                                                                        <img src="{{ asset('storage/'.$produit->image) }}" width="20">
                                                                                    </div>-->
                                                                                    <div class="product-name">{{ $produit->nom }}</div>
                                                                                    <!-- <div class="product-price">{{ number_format($produit->prix_vente, 0, ',', ' ') }} CFA</div> -->
                                                                                    <div class="product-price"><b>{{ $produit->stock }}</b> en Stock</div>
                                                                                </div>
                                                                            @endforeach
                                                                        @endif
                                                                    </div>

                                                                    <div class="category-header">
                                                                        <i class="fas fa-shopping-cart"></i> Panier
                                                                    </div>

                                                                    <!-- Tableau des produits du panier -->
                                                                    <table class="produits-table" id="produitsTable">
                                                                        @if($unite->categorie->slug == 'service')
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Service</th>
                                                                                <th>prix unit.</th>
                                                                                <th>unite de mesure</th>
                                                                                <!-- <th>Categorie</th> -->
                                                                                <th></th>
                                                                            </tr>
                                                                        </thead>
                                                                            <tbody id="panierRows">
                                                                                <tr id="row-0">
                                                                                    <td>
                                                                                        <select name="s_id" class="form-control produit-select">
                                                                                            <option value="">Choisir un produit</option>
                                                                                            @foreach($services as $service)
                                                                                                <option value="{{ $service->id }}" data-prix_vente="{{ $service->prix }}" data-nom="{{ $service->nom }}">
                                                                                                    {{ $service->nom }}
                                                                                                </option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="number" name="s_prix" class="form-control prix_vente" step="any">
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="text" name="s_unite_de_mesure" class="form-control unite_de_mesure">
                                                                                    </td>
                                                                                    <!-- <td>
                                                                                        <input type="number" name="services[0][categorie]" class="form-control-sm categorie" readonly>
                                                                                    </td> -->
                                                                                    <td>
                                                                                        <button type="button" class="btn-icon remove-row">🗑️</button>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        @else
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Produit</th>
                                                                                <th>prix unit.</th>
                                                                                <th>Qté</th>
                                                                                <th>Total</th>
                                                                                <th></th>
                                                                            </tr>
                                                                        </thead>
                                                                            <tbody id="panierRows">
                                                                                <tr id="row-0">
                                                                                    <td>
                                                                                        <select name="produits[0][produit_id]" class="form-control produit-select">
                                                                                            <option value="">Choisir un produit</option>
                                                                                            @foreach($produits as $produit)
                                                                                                <option value="{{ $produit->id }}" data-prix_vente="{{ $produit->prix_vente }}" data-nom="{{ $produit->nom }}">
                                                                                                    {{ $produit->nom }}
                                                                                                </option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="number" name="produits[0][prix_vente]" class="form-control-sm prix_vente" step="any">
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="number" name="produits[0][quantite]" class="form-control-sm quantite" value="1">
                                                                                    </td>
                                                                                    <td>
                                                                                        <input type="number" class="form-control-sm total-ligne" readonly style="background:#f8f9fa;">
                                                                                    </td>
                                                                                    <td>
                                                                                        <button type="button" class="btn-icon remove-row">🗑️</button>
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        @endif
                                                                    </table>

                                                                    @if(!$unite->categorie->slug == 'service')
                                                                        <button type="button" id="addRowBtn" class="btn btn-primary" style="margin-top: 15px; width: 100%;">
                                                                            + Ajouter un produit
                                                                        </button>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- COLONNE DROITE : Résumé et Paiement -->
                                                        <div class="pos-right">
                                                            <div class="pos-card">
                                                                <div class="pos-card-header">Récapitulatif</div>
                                                                <div class="pos-card-body">
                                                                    <div class="summary-line">
                                                                        <span>Sous-total</span>
                                                                        <span id="subtotal">0</span> CFA
                                                                    </div>
                                                                    <!-- <div class="tax-box">
                                                                        <div class="summary-line">
                                                                            <span>Taxes (TVA 18%)</span>
                                                                            <span id="taxAmount">0</span> CFA
                                                                        </div>
                                                                    </div> -->
                                                                    <div class="summary-total">
                                                                        <span>TOTAL TTC</span>
                                                                        <span id="totalGlobal">0</span> CFA
                                                                    </div>

                                                                    <!-- Suggestions combos -->
                                                                    <!-- <div style="margin-top: 20px;">
                                                                        <div class="category-header" style="margin-bottom: 10px;">🔥 Combos populaires</div>
                                                                        <div>
                                                                            @foreach($produits->take(4) as $combo)
                                                                                <span class="badge-combo">{{ $combo->nom }}</span>
                                                                            @endforeach
                                                                        </div>
                                                                    </div> -->

                                                                    <!-- Module client / Paiement -->
                                                                    <div class="client-pad">
                                                                        <div style="font-weight: 600; margin-bottom: 10px;">👤 Paiement</div>
                                                                        <div class="numpad" id="numpad">
                                                                            <div class="num-btn" data-value="1">1</div>
                                                                            <div class="num-btn" data-value="2">2</div>
                                                                            <div class="num-btn" data-value="3">3</div>
                                                                            <div class="num-btn" data-value="4">4</div>
                                                                            <div class="num-btn" data-value="5">5</div>
                                                                            <div class="num-btn" data-value="6">6</div>
                                                                            <div class="num-btn" data-value="7">7</div>
                                                                            <div class="num-btn" data-value="8">8</div>
                                                                            <div class="num-btn" data-value="9">9</div>
                                                                            <div class="num-btn" data-value="0">0</div>
                                                                            <div class="num-btn" data-value=".">.</div>
                                                                            <div class="num-btn" data-value="clear">⌫</div>
                                                                        </div>
                                                                        <input type="text" id="montantPaye" name="montant" class="form-control-sm" placeholder="Montant reçu" style="width: 100%; margin-bottom: 10px;">
                                                                        
                                                                        <div class="action-buttons">
                                                                            <a href="{{ route('vente.index') }}" class="btn-custom btn-secondary-custom" style="text-align: center; text-decoration: none;">Annuler</a>
                                                                            <button type="submit" class="btn-custom btn-primary-custom">Valider ✅</button>
                                                                        </div>
                                                                        <div class="text-muted-small">
                                                                        montant calcule automatiquement
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                
                                                <!-- Nouveau client -->
                                                <div class="modal fade" id="clientModal" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <form method="post" action="{{route('client.store')}}">
                                                            @csrf
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Nouveau client</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label>Nom du client</label>
                                                                        <input type="text" name="nom" class="form-control" required>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label>Téléphone</label>
                                                                        <input type="text" name="telephone" class="form-control">
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label>Email</label>
                                                                        <input type="email" name="email" class="form-control">
                                                                    </div>

                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<script>
    let rowIndex = 1;

    // Ajout produit via clic sur carte produit
    document.querySelectorAll('.product-card').forEach(card => {
        card.addEventListener('click', function() {
            let productId = this.dataset.id;
            let productName = this.dataset.nom;
            let productPrice = this.dataset.prix_vente;

            // Chercher une ligne vide ou ajouter une nouvelle ligne
            let selectElement = document.querySelector('#panierRows select');
            if(selectElement && selectElement.value === "") {
                // Remplir la première ligne vide
                let row = selectElement.closest('tr');
                selectElement.value = productId;
                row.querySelector('.prix_vente').value = productPrice;
                row.querySelector('.quantite').value = 1;
                calculLigne(row);
            } else {
                // Ajouter une nouvelle ligne
                addNewRow(productId, productPrice);
            }
        });
    });

    // Ajouter une nouvelle ligne
    function addNewRow(produitId = null, price = null) {
        let options = `{!! $produits->map(function($p) { return '<option value="'.$p->id.'" data-prix_vente="'.$p->prix_vente.'" data-nom="'.$p->nom.'">'.$p->nom.'</option>'; })->implode('') !!}`;
        
        let rowHtml = `
            @if($unite->categorie->slug == 'service')
                <tr id="row-${rowIndex}">
                    <td>
                        <select name="produits[${rowIndex}][service_id]" class="form-control produit-select">
                            <option value="">Choisir un produit</option>
                            ${options}
                        </select>
                    </td>
                    <td>
                        <input type="number" name="services[${rowIndex}][prix]" class="form-control-sm prix_vente" step="any">
                    </td>
                    <td>
                        <input type="text" name="services[${rowIndex}][unite_de_mesure]" class="form-control-sm quantite">
                    </td>
                    <td>
                        <input type="number" class="form-control-sm total-ligne" readonly style="background:#f8f9fa;">
                    </td>
                    <td>
                        <button type="button" class="btn-icon remove-row">🗑️</button>
                    </td>
                </tr>
            @else
                <tr id="row-${rowIndex}">
                    <td>
                        <select name="produits[${rowIndex}][produit_id]" class="form-control-sm produit-select">
                            <option value="">Choisir un produit</option>
                            ${options}
                        </select>
                    </td>
                    <td>
                        <input type="number" name="produits[${rowIndex}][prix_vente]" class="form-control-sm prix_vente" step="any">
                    </td>
                    <td>
                        <input type="number" name="produits[${rowIndex}][quantite]" class="form-control-sm quantite" value="1">
                    </td>
                    <td>
                        <input type="number" class="form-control-sm total-ligne" readonly style="background:#f8f9fa;">
                    </td>
                    <td>
                        <button type="button" class="btn-icon remove-row">🗑️</button>
                    </td>
                </tr>
            @endif
        `;
        document.querySelector('#panierRows').insertAdjacentHTML('beforeend', rowHtml);
        
        if(produitId && price) {
            let newRow = document.querySelector(`#row-${rowIndex}`);
            let select = newRow.querySelector('.produit-select');
            select.value = produitId;
            newRow.querySelector('.prix_vente').value = price;
            calculLigne(newRow);
        }
        
        rowIndex++;
    }

    // Suppression de ligne
    document.addEventListener('click', function(e) {
        if(e.target.classList.contains('remove-row')) {
            e.target.closest('tr').remove();
            calculTotalGlobal();
        }
    });

    // Auto-remplissage prix_vente
    document.addEventListener('change', function(e) {
        if(e.target.classList.contains('produit-select')) {
            let selected = e.target.selectedOptions[0];
            let prix_vente = selected.dataset.prix_vente;
            let row = e.target.closest('tr');
            row.querySelector('.prix_vente').value = prix_vente;
            calculLigne(row);
        }
    });

    // Calcul à la saisie de quantité
    document.addEventListener('input', function(e) {
        if(e.target.classList.contains('quantite')) {
            let row = e.target.closest('tr');
            calculLigne(row);
        }
    });

    function calculLigne(row) {
        let prix_vente = parseFloat(row.querySelector('.prix_vente').value) || 0;
        let qte = parseFloat(row.querySelector('.quantite').value) || 0;
        let total = prix_vente * qte;
        row.querySelector('.total-ligne').value = total.toFixed(0);
        calculTotalGlobal();
    }

    function calculTotalGlobal() {
        let totalHT = 0;
        document.querySelectorAll('.total-ligne').forEach(input => {
            totalHT += parseFloat(input.value) || 0;
        });
        
        let tva = totalHT * 0;
        let totalTTC = totalHT + tva;
        
        document.getElementById('subtotal').innerText = totalHT.toLocaleString();
        document.getElementById('totalGlobal').innerText = totalTTC.toLocaleString();
    }

    // Bouton ajouter ligne
    document.getElementById('addRowBtn').addEventListener('click', function() {
        addNewRow();
    });

    // Numpad virtuel
    let montantInput = document.getElementById('montantPaye');
    document.querySelectorAll('.num-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            let value = this.dataset.value;
            if(value === 'clear') {
                montantInput.value = montantInput.value.slice(0, -1);
            } else {
                montantInput.value += value;
            }
        });
    });
</script>

<!--Recheche produit-->
<script>
    document.getElementById('search').addEventListener('keyup', function() {

        let query = this.value;

        if (query.length < 2) return;

        fetch(`/caisseSearch?q=${query}`)
            .then(res => res.json())
            .then(data => {

                let results = document.getElementById('results');
                results.innerHTML = '';

                data.forEach(produit => {
                    results.innerHTML += `
                        <a href="#" class="list-group-item" onclick="selectproduit(${produit.id}, '${produit.nom}', ${produit.prix_vente})">
                            ${produit.nom} - ${produit.prix_vente} FCFA
                        </a>
                    `;
                });
            });
    });
</script>

<script>
    function selectproduit(id, nom, prix_vente) {
        console.log("Produit sélectionné :", nom);
        
        // Chercher une ligne vide ou la première ligne avec un select vide
        let selectElement = document.querySelector('#panierRows select');
        let existingRow = null;
        
        // Vérifier s'il existe une ligne avec un select vide
        if(selectElement && selectElement.value === "") {
            // Remplir la première ligne vide
            let row = selectElement.closest('tr');
            selectElement.value = id;
            row.querySelector('.prix_vente').value = prix_vente;
            row.querySelector('.quantite').value = 1;
            calculLigne(row);
        } else {
            // Vérifier si le produit existe déjà dans le panier
            let existingProductRow = null;
            document.querySelectorAll('.produit-select').forEach(select => {
                if(select.value == id) {
                    existingProductRow = select.closest('tr');
                }
            });
            
            if(existingProductRow) {
                // Si le produit existe déjà, augmenter la quantité
                let qteInput = existingProductRow.querySelector('.quantite');
                let nouvelleQte = (parseFloat(qteInput.value) || 0) + 1;
                qteInput.value = nouvelleQte;
                calculLigne(existingProductRow);
            } else {
                // Ajouter une nouvelle ligne avec le produit
                addNewRow(id, prix_vente);
            }
        }
        
        // Masquer les résultats après la sélection
        document.getElementById('results').innerHTML = '';
        document.getElementById('search').value = '';
    }
</script>
    @include('partials.footer')
