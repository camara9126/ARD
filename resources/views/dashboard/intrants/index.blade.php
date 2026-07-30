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
                                                <h5>intrants</h5>
                                                <!--<span>use class <code>table</code> inside table element</span>-->
                                                <div class="card-header-right">
                                                    <a href="{{ route('produit.index') }}" style="color: var(--danger); text-decoration: none; font-weight: 500;" >Retour →</a>
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
                                                                <th>Designation</th>
                                                                <th>Prix unitaire</th>
                                                                <th>Quantité</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($intrants as $i)
                                                            <tr>
                                                                <td>{{$i->designation ?? $i->produit->nom}}</td>
                                                                <td>{{number_format($i->prix_unitaire, 0,'',' ')}} XOF</td>
                                                                <td>{{number_format($i->quantite, 0,'',' ')}}</td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <a href="" class="action-btn" title="Modifier"  data-bs-toggle="modal" data-id="{{ $i->id }}" data-name="{{ $i->designation }}" data-price="{{ $i->prix_unitaire }}" data-bs-target="#intrantEditModal">
                                                                                <i class="fa fa-edit"></i>
                                                                            </a>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <form action="{{route('intrant.destroy', $i->id)}}" type="button" method="post" onsubmit="return confirm('Supprimer ?')">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="badge bg-danger" title="Supprimer">
                                                                                    <i class="fa fa-trash" aria-hidden="true"></i>
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

                                            <!-- Edit intrant -->
                                            <div class="modal fade" id="intrantEditModal" tabindex="-1">
                                                <div class="modal-dialog">

                                                    <form method="post" id="editintrantForm" action="">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Modification intrant</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>

                                                            <div class="modal-body">

                                                                <input type="hidden" name="id" id="intrant_id">
                                                                <input type="hidden" name="stock" id="stock" class="form-control" required>

                                                                <div class="mb-3">
                                                                    <label>Nom intrant</label>
                                                                    <input type="text" name="nom" id="name" class="form-control" required>
                                                                </div>

                                                                
                                                                <div class="mb-3">
                                                                    <label>Prix vente</label>
                                                                    <input type="text" name="prix_unitaire" id="price" class="form-control">
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
            const modal = document.getElementById('intrantEditModal');
            const form = document.getElementById('editintrantForm');

            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;

                // Récupération des données
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const price = button.getAttribute('data-price');
                
                // Remplir le formulaire
                modal.querySelector('#intrant_id').value = id;
                modal.querySelector('#name').value = name;
                modal.querySelector('#price').value = price;
                
                // Mettre à jour l'action du formulaire avec l'ID récupéré
                const updateUrl = `/intrant/${id}`;
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
