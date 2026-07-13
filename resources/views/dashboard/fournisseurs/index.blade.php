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
                                                <h5>Fournisseurs</h5>
                                                <!--<span>use class <code>table</code> inside table element</span>-->
                                                <div class="card-header-right">
                                                    <a href="" style="color: var(--primary); text-decoration: none; font-weight: 500;" data-bs-toggle="modal"  data-bs-target="#fournisseurModal">Nouveau fournisseur →</a>
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
                                                                <th>Nom</th>
                                                                <th>Telephone</th>
                                                                <th>Adresse</th>
                                                                <th>Email</th>
                                                                <th>Statut</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($fournisseurs as $f)
                                                            <tr>
                                                                <td>{{$f->nom}}</td>
                                                                <td>{{$f->telephone ?? 'Vide'}}</td>
                                                                <td>{{$f->email ?? 'Vide'}}</td>
                                                                <td>{{$f->adresse ?? 'Vide'}}</td>
                                                                <td>
                                                                    @if($f->statut)
                                                                        <span class="badge bg-success">Activé</span>
                                                                        @else
                                                                        <span class="badge bg-danger">Desactivé</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <div class="action-buttons">
                                                                        <a href="" class="action-btn text-info" data-bs-toggle="modal" data-id="{{ $f->id }}" data-name="{{ $f->nom }}" data-phone="{{ $f->telephone }}" data-email="{{ $f->email }}" data-adress="{{$f->adresse }}" data-bs-target="#fournisseurEditModal" title="Modifier">
                                                                            <i class="fas fa-edit"></i>
                                                                        </a>
                                                                        @if($f->statut)
                                                                            <form action="{{route('fournisseur.destroy', $f->id)}}" type="button" method="post" onsubmit="return confirm('Desactiver ?')">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="text-success" title="Desactiver">
                                                                                    <i class="fa fa-toggle-on "></i>
                                                                                </button>
                                                                            </form>
                                                                        @else
                                                                            <form action="{{route('fournisseur.destroy', $f->id)}}" type="button" method="post" onsubmit="return confirm('Activer ?')">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit" class="text-danger" title="Activer">
                                                                                    <i class="fa fa-toggle-off"></i>
                                                                                </button>
                                                                            </form>
                                                                        @endif
                                                                        <!--<a href="" class="action-btn" title="Dupliquer"><i class="fas fa-copy"></i></a>-->
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


                                                    @if ($errors->any())
                                                        <div class="alert alert-danger">
                                                            <ul>
                                                                @foreach ($errors->all() as $error)
                                                                    <li>{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif 

                                                    <!-- Nouveau fournisseur -->
                                                    <div class="modal fade" id="fournisseurModal" tabindex="-1">
                                                        <div class="modal-dialog">
                                                            <form method="post" action="{{route('fournisseur.store')}}">
                                                                @csrf
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Nouveau fournisseur</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label>Nom du fournisseur</label>
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

                                                                        <div class="mb-3">
                                                                            <label>Adresse</label>
                                                                            <textarea name="adresse" id="" class="form-control"></textarea>
                                                                        </div>
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                    <!-- Edit founisseur -->
                                                    <div class="modal fade" id="fournisseurEditModal" tabindex="-1">
                                                        <div class="modal-dialog">

                                                            <form method="post" id="editFournisseurForm" action="">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Modification fournisseur</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <input type="hidden" name="id" id="founisseur_id">

                                                                        <div class="mb-3">
                                                                            <label>Nom du founisseur</label>
                                                                            <input type="text" name="nom" id="name" class="form-control" required>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label>Téléphone</label>
                                                                            <input type="text" name="telephone" id="phone" class="form-control">
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label>Email</label>
                                                                            <input type="email" name="email" id="email" class="form-control">
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label>Adresse</label>
                                                                            <textarea name="adresse" id="adress" class="form-control" rows="3"></textarea>
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

    <!--Recuperation des donnees founisseur pour l'Edit -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('fournisseurEditModal');
            const form = document.getElementById('editFournisseurForm');

            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;

                // Récupération des données
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const email = button.getAttribute('data-email');
                const phone = button.getAttribute('data-phone');
                const adress = button.getAttribute('data-adress');
                
                // Remplir le formulaire
                modal.querySelector('#founisseur_id').value = id;
                modal.querySelector('#name').value = name;
                modal.querySelector('#phone').value = phone;
                modal.querySelector('#email').value = email;
                modal.querySelector('#adress').value = adress;
                
                // Mettre à jour l'action du formulaire avec l'ID récupéré
                const updateUrl = `/fournisseur/${id}`;
                form.action = updateUrl;
            });
        });
    </script>


    @include('partials.footer')
