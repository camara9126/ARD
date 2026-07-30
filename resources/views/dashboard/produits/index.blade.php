    @include('partials.header')

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
                                            <div class="card-header">
                                                <h5>Produits</h5>
                                                <!--<span>use class <code>table</code> inside table element</span>-->
                                                <div class="card-header-right">
                                                    <a href="" style="color: var(--primary); text-decoration: none; font-weight: 500;" data-bs-toggle="modal"  data-bs-target="#produitModal">Nouveau →</a>
                                                    <!--<ul class="list-unstyled card-option">
                                                        <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                                        <li><i class="fa fa-window-maximize full-card"></i></li>
                                                        <li><i class="fa fa-minus minimize-card"></i></li>
                                                        <li><i class="fa fa-refresh reload-card"></i></li>
                                                        <li><i class="fa fa-trash close-card"></i></li>
                                                    </ul>-->
                                                </div>
                                            </div>
                                            <div class="card-block table-border-style">

                                                @if ($errors->any())
                                                    <div class="alert alert-danger text-center">
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif

                                                @if(Session::has('success'))
                                                    <div class="alert alert-success text-center" role="alert">
                                                        {{ Session::get('success') }}
                                                    </div>
                                                @elseif(Session::has('danger'))
                                                    <div class="alert alert-danger text-center" role="alert">
                                                        {{ Session::get('danger') }}
                                                    </div>
                                                @endif
                                                <div class="table-responsive">
                                                    <table class="table">
                                                         <thead>
                                                            <tr>
                                                                <th>Code</th>
                                                                <th>Nom</th>
                                                                @if(!$unite->categorie->slug == 'service' || !$unite->categorie->slug == 'transformation')
                                                                    <th>Fournisseur</th>
                                                                    <th>Prix d'achat</th>
                                                                @endif
                                                                <th>Prix de vente</th>
                                                                <th>Quantité</th>
                                                                <th>Statut</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($produits as $p)
                                                            <tr>
                                                                <td><strong>{{$p->code}}</strong></td>
                                                                <td>{{$p->nom}}</td>
                                                                @if(!$unite->categorie->slug == 'service' || !$unite->categorie->slug == 'transformation')
                                                                    <td>{{$p->fournisseur->nom ?? 'vide'}}</td>
                                                                    <td>{{number_format($p->prix_achat, 0,'',' ')}} XOF</td>
                                                                @endif
                                                                <td>{{number_format($p->prix_vente, 0,'',' ')}} XOF</td>
                                                                <td>
                                                                    @if($p->stock_min >= $p->stock)
                                                                        <span class="badge bg-danger">Stock faible ({{$p->stock}})</span>
                                                                    @else
                                                                        {{$p->stock}}
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($p->statut)
                                                                        <span class="badge bg-success">Actif</span>
                                                                        @else
                                                                        <span class="badge bg-danger">Inactif</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <a href="" class="action-btn" title="Modifier"  data-bs-toggle="modal" data-id="{{ $p->id }}" data-name="{{ $p->nom }}" data-categorie="{{ $p->categorie_id }}" data-price="{{ $p->prix_vente }}" data-stock="{{ $p->stock }}" data-bs-target="#produitEditModal">
                                                                                <i class="fa fa-edit"></i>
                                                                            </a>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <form action="{{route('produit.destroy', $p->id)}}" type="button" method="post" onsubmit="return confirm('Supprimer ?')">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="badge bg-danger" title="desactiver">
                                                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                    </div>       
                                                                </td>                                                       
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


                                            <!-- Nouveau produit -->
                                            <div class="modal fade" id="produitModal" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <form method="post" action="{{route('produit.store')}}">
                                                        @csrf
                                                        
                                                        <div class="modal-content">

                                                            <!-- Categorie Unite Transformation -->
                                                            @if($unite->categorie->slug == 'transformation')
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Nouvelle transformation</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <div class="modal-body">

                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="mb-3">
                                                                                <label>Nom produit</label>
                                                                                <input type="text" name="nom" class="form-control" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="mb-3">
                                                                                <label>Prix vente</label>
                                                                                <input type="text" name="prix_vente" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <hr>

                                                                    <!-- TABLE produits -->
                                                                    <table class="table mb-3" id="table-intrants">
                                                                        <h1 class="text-center fw-bold h4">Les intrant</h1>
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Type intrant</th>
                                                                                <th>Quantité utilisé</th>
                                                                                <th></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>
                                                                                    <select name="intrants[0][id]" class="form-control">
                                                                                        <option value="">Choisir</option>
                                                                                        @foreach($intrants as $i)
                                                                                            <option value="{{ $i->id }}">
                                                                                                {{ $i->designation }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </td>

                                                                                <td>
                                                                                    <input type="number" name="intrants[0][quantite]" class="form-control"  style="width: 100px;">
                                                                                </td>

                                                                                <td>
                                                                                    <button type="button" class="btn btn-danger remove">X</button>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>

                                                                    <button type="button" id="addRow" class="btn btn-primary text-center">+ Ajout intrant</button>
                                                                    
                                                                    <hr>

                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="mb-3">
                                                                                <label>Nombre produit</label>
                                                                                <input type="number" name="stock" class="form-control" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="mb-3">
                                                                                <label>Stock Minimum</label>
                                                                                <select name="stock_min" id="" class="form-control">
                                                                                    <option value="5">5</option>
                                                                                    <option value="10">10</option>
                                                                                    <option value="15">15</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>

                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Nouveau service</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <div class="modal-body">

                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="mb-3">
                                                                                <label>Nom service</label>
                                                                                <input type="text" name="nom" class="form-control" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="mb-3">
                                                                                <label>Prix</label>
                                                                                <input type="text" name="prix_vente" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <hr>

                                                                    <!-- TABLE produits -->
                                                                    <!-- <table class="table mb-3" id="table-intrants">
                                                                        <h1 class="text-center fw-bold h4">Les consommables</h1>
                                                                        <thead>
                                                                            <tr>
                                                                                <th>designation</th>
                                                                                <th>Quantité utilisé</th>
                                                                                <th></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>
                                                                                    <select name="intrants[0][id]" class="form-control">
                                                                                        <option value="">Choisir</option>
                                                                                        @foreach($intrants as $c)
                                                                                            <option value="{{ $c->id }}">
                                                                                                {{ $c->designation }}
                                                                                            </option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </td>

                                                                                <td>
                                                                                    <input type="number" name="intrants[0][quantite]" class="form-control"  style="width: 100px;">
                                                                                </td>

                                                                                <td>
                                                                                    <button type="button" class="btn btn-danger remove">X</button>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table> -->

                                                                    <!-- <button type="button" id="addRow" class="btn btn-primary text-center">+ Ajout intrant</button> -->
                                                                    
                                                                    <hr>

                                                                    <!-- <div class="mb-3">
                                                                        <label>Unite de mesure</label>
                                                                        <input type="text" name="unite_de_mesure" class="form-control" placeholder="Ex: heure/jour">
                                                                    </div> -->
                                                                
                                                                    <!-- <div class="mb-3">
                                                                        <label>Description</label>
                                                                        <textarea name="description" class="form-control" rows="3"></textarea>
                                                                    </div> -->
                                                                    
                                                                </div>
                                                            <!-- Categorie Unite Vente Direct -->
                                                            @elseif($unite->categorie->slug == 'b2c')
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Nouveau produit</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <div class="modal-body">

                                                                    <div class="mb-3">
                                                                        <label>Nom produit</label>
                                                                        <input type="text" name="nom" class="form-control" required>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="mb-3">
                                                                                <label>Prix achat</label>
                                                                                <input type="text" name="prix_achat" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="mb-3">
                                                                                <label>Prix vente</label>
                                                                                <input type="text" name="prix_vente" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="mb-3">
                                                                                <label>Nombre produit</label>
                                                                                <input type="number" name="stock" class="form-control" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="mb-3">
                                                                                <label>Stock Minimum</label>
                                                                                <select name="stock_min" class="form-control">
                                                                                    <option value="5">5</option>
                                                                                    <option value="10">10</option>
                                                                                    <option value="15">15</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label>Fournisseur</label>
                                                                        <input type="text" name="fournisseur" class="form-control" placeholder="Nouveau fournisseur">
                                                                        <select name="fournisseur_id" class="form-control">
                                                                                <option value="">-- Selectionner --</option>
                                                                            @foreach($fournisseur as $f)
                                                                                <option value="{{ $f->id }}">{{ $f->nom }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>  

                                                                </div>
                                                            @endif
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                                <!-- Edit produit -->
                                            <div class="modal fade" id="produitEditModal" tabindex="-1">
                                                <div class="modal-dialog">

                                                    <form method="post" id="editProduitForm" action="">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Modification produit</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>

                                                            <div class="modal-body">

                                                                <input type="hidden" name="id" id="produit_id">
                                                                <input type="hidden" name="categorie_id" id="categorie_id">
                                                                <input type="hidden" name="stock" id="stock" class="form-control" required>

                                                                <div class="mb-3">
                                                                    <label>Nom produit</label>
                                                                    <input type="text" name="nom" id="name" class="form-control" required>
                                                                </div>

                                                                <!-- <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="mb-3">
                                                                            <label>Categorie</label>
                                                                            <select name="categorie_id" class="form-control">
                                                                                    <option value="">Categorie</option>
                                                                                @foreach($categorie as $m)
                                                                                    <option value="{{ $m->id }}">{{ $m->nom }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>  
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="mb-3">
                                                                            <label>Fournisseur</label>
                                                                            <select name="fournisseur_id" class="form-control">
                                                                                    <option value="">Fournisseur</option>
                                                                                @foreach($fournisseur as $f)
                                                                                    <option value="{{ $f->id }}">{{ $f->nom }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div> 
                                                                    </div>
                                                                </div> -->
                                                                
                                                                <div class="mb-3">
                                                                    <label>Prix vente</label>
                                                                    <input type="text" name="prix_vente" id="price" class="form-control">
                                                                </div>
                                                            
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary">Modifier</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>                                            
                                        </div>
                                        <!-- Basic table card end -->
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
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('produitEditModal');
            const form = document.getElementById('editProduitForm');

            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;

                // Récupération des données
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const price = button.getAttribute('data-price');
                const stock = button.getAttribute('data-stock');
                const categorie_id = button.getAttribute('data-categorie');
                
                // Remplir le formulaire
                modal.querySelector('#produit_id').value = id;
                modal.querySelector('#name').value = name;
                modal.querySelector('#price').value = price;
                modal.querySelector('#stock').value = stock;
                modal.querySelector('#categorie_id').value = categorie_id;
                
                // Mettre à jour l'action du formulaire avec l'ID récupéré
                const updateUrl = `/produit/${id}`;
                form.action = updateUrl;
            });
        });
    </script>

    <!-- Ajout ligne table -->
    <script>

        let index = 1;

        // Ajouter ligne
        document.getElementById('addRow').addEventListener('click', function () {

            let row = `
                <tr>
                    <td>
                        <select name="intrants[${index}][id]" class="form-control">
                            <option value="">Choisir</option>
                            @foreach($intrants as $i)
                                <option value="{{ $i->id }}">
                                    {{ $i->designation }}
                                </option>
                            @endforeach
                        </select>
                    </td>

                    <td>
                        <input type="number" name="intrants[${index}][quantite]" class="form-control" style="width: 100px;">
                    </td>

                    <td>
                        <button type="button" class="btn btn-danger remove">X</button>
                    </td>
                </tr>
            `;

            document.querySelector('#table-intrants tbody').insertAdjacentHTML('beforeend', row);
            index++;
        });

        // Supprimer ligne
        document.addEventListener('click', function(e){
            if(e.target.classList.contains('remove')){
                e.target.closest('tr').remove();
                calculTotal();
            }
        });
    
    </script>


    @include('partials.footer')
