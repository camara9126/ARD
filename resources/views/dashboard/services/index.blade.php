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
                                                <h5>Service</h5>
                                                <!--<span>use class <code>table</code> inside table element</span>-->
                                                <div class="card-header-right">
                                                    <a href="" style="color: var(--primary); text-decoration: none; font-weight: 500;" data-bs-toggle="modal"  data-bs-target="#serviceModal">Nouveau →</a>
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
                                                                <th>Nom</th>
                                                                <th>Prix</th>
                                                                <th>Quantité</th>
                                                                <!-- <th>Statut</th> -->
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($services as $p)
                                                            <tr>
                                                                <td>{{$p->nom}}</td>
                                                                <td>{{number_format($p->prix, 0,'',' ')}} XOF</td>
                                                                <td>{{$p->unite_de_mesure}}</td>
                                                                <!-- <td>
                                                                    @if($p->statut)
                                                                        <span class="badge bg-success">Actif</span>
                                                                        @else
                                                                        <span class="badge bg-danger">Inactif</span>
                                                                    @endif
                                                                </td> -->
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <a href="" class="action-btn" title="Modifier"  data-bs-toggle="modal" data-id="{{ $p->id }}" data-name="{{ $p->nom }}" data-description="{{ $p->description }}" data-price="{{ $p->prix }}" data-unite_de_mesure="{{ $p->unite_de_mesure }}" data-categorie="{{ $p->categorie }}" data-bs-target="#serviceEditModal">
                                                                                <i class="fa fa-edit"></i>
                                                                            </a>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <form action="{{route('service.destroy', $p->id)}}" type="button" method="post" onsubmit="return confirm('Supprimer ?')">
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


                                            <!-- Nouveau service -->
                                            <div class="modal fade" id="serviceModal" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <form method="post" action="{{route('service.store')}}">
                                                        @csrf
                                                        
                                                        <div class="modal-content">

                                                            
                                                            <!-- Categorie Unite Service -->
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
                                                                            <input type="text" name="prix" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                <hr>

                                                                <!-- TABLE services -->
                                                                <table class="table mb-3" id="table-intrants">
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
                                                                </table>

                                                                <button type="button" id="addRow" class="btn btn-primary text-center">+ Ajout intrant</button>
                                                                
                                                                <hr>

                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label>Unite de mesure</label>
                                                                            <input type="text" name="unite_de_mesure" class="form-control" placeholder="Ex: heure/jour">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label>Categorie</label>
                                                                            <input type="text" name="categorie" class="form-control" placeholder="Ex: heure/jour">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            
                                                                <div class="mb-3">
                                                                    <label>Description</label>
                                                                    <textarea name="description" class="form-control" rows="3"></textarea>
                                                                </div>
                                                                
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                                <!-- Edit service -->
                                            <div class="modal fade" id="serviceEditModal" tabindex="-1">
                                                <div class="modal-dialog">

                                                    <form method="post" id="editserviceForm" action="">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Modification service</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>

                                                            <div class="modal-body">

                                                                <input type="hidden" name="id" id="service_id">
                                                                <div class="mb-3">
                                                                    <label>Nom service</label>
                                                                    <input type="text" name="nom" id="name" class="form-control" required>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label>Prix</label>
                                                                    <input type="text" name="prix" id="price" class="form-control">
                                                                </div>
                                                            
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label>Unite de mesure</label>
                                                                            <input type="text" name="unite_de_mesure" id="unite_de_mesure" class="form-control" placeholder="Ex: heure/jour">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <label>Categorie</label>
                                                                            <input type="text" name="categorie" id="categorie" class="form-control" placeholder="Ex: heure/jour">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            
                                                                <div class="mb-3">
                                                                    <label>Description</label>
                                                                    <textarea name="description" id="description" class="form-control" rows="3"></textarea>
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
            const modal = document.getElementById('serviceEditModal');
            const form = document.getElementById('editserviceForm');

            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;

                // Récupération des données
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const price = button.getAttribute('data-price');
                const description = button.getAttribute('data-description');
                const unite_de_mesure = button.getAttribute('data-unite_de_mesure');
                const categorie = button.getAttribute('data-categorie');
                
                // Remplir le formulaire
                modal.querySelector('#service_id').value = id;
                modal.querySelector('#name').value = name;
                modal.querySelector('#price').value = price;
                modal.querySelector('#description').value = description;
                modal.querySelector('#unite_de_mesure').value = unite_de_mesure;
                modal.querySelector('#categorie').value = categorie;
                
                // Mettre à jour l'action du formulaire avec l'ID récupéré
                const updateUrl = `/service/${id}`;
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
