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
                                        <!-- Basic table card start -->
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Produits</h5>
                                                <!--<span>use class <code>table</code> inside table element</span>-->
                                                <div class="card-header-right">
                                                    <a href="" style="color: var(--primary); text-decoration: none; font-weight: 500;" data-bs-toggle="modal"  data-bs-target="#produitModal">Nouveau produit →</a>
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
                                                                <th>Fournisseur</th>
                                                                <th>Prix d'achat</th>
                                                                <th>Prix de vente</th>
                                                                <th>Stock</th>
                                                                <th>Statut</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($produits as $p)
                                                            <tr>
                                                                <td><strong>{{$p->code}}</strong></td>
                                                                <td>{{$p->nom}}</td>
                                                                <td>{{$p->fournisseur->nom ?? 'vide'}}</td>
                                                                <td>{{number_format($p->prix_achat, 0,'',' ')}} XOF</td>
                                                                <td>{{number_format($p->prix_vente, 0,'',' ')}} XOF</td>
                                                                <td>
                                                                    @if($p->stock_min >= $p->stock)
                                                                        <span class="badge bg-danger">Stock faible</span>
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
                                                                            @if($p->statut)
                                                                                <form action="{{route('produit.destroy', $p->id)}}" type="button" method="post" onsubmit="return confirm('Desactiver ?')">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit" class="badge bg-danger" title="desactiver">
                                                                                        <i class="fa fa-times" aria-hidden="true"></i>
                                                                                    </button>
                                                                                </form>
                                                                            @else
                                                                                <form action="{{route('produit.destroy', $p->id)}}" type="button" method="post" onsubmit="return confirm('Activer ?')">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit" class="badge bg-success" title="activer">
                                                                                        <i class="fa-solid fa-check" aria-hidden="true"></i>
                                                                                    </button>
                                                                                </form>
                                                                                @endif 
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
                                                                            <label>Prix d'achat</label>
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
                                                                    <div class="col-6">
                                                                        <div class="mb-3">
                                                                            <label>Categorie</label>
                                                                            <select name="categorie_id" class="form-control">
                                                                                <option value="">-- Selectionner une categorie --</option>
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
                                                                                <option value="">-- Selectionner un fournisseur --</option>
                                                                                @foreach($fournisseur as $f)
                                                                                    <option value="{{ $f->id }}">{{ $f->nom }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div> 
                                                                    </div>
                                                                </div>                                                  

                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label>Quantite de stock</label>
                                                                            <input type="number" name="stock" class="form-control" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label>Stock Minimu,</label>
                                                                            <select name="stock_min" id="" class="form-control">
                                                                                <option value="5">5</option>
                                                                                <option value="10">10</option>
                                                                                <option value="15">15</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

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

                                                                <div class="row">
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
                                                                </div>
                                                                
                                                                <div class="mb-3">
                                                                    <label>Prix</label>
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


    @include('partials.footer')
