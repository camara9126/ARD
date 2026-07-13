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
                                                <h5>Clients</h5>
                                                <!--<span>use class <code>table</code> inside table element</span>-->
                                                <div class="card-header-right">
                                                    <a href="" style="color: var(--primary); text-decoration: none; font-weight: 500;" data-bs-toggle="modal"  data-bs-target="#clientModal">Nouveau client →</a>
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
                                                                <th>Telephone</th>
                                                                <th>Email</th>
                                                                <th>Adresse</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($clients as $c)
                                                            <tr>
                                                                <td>{{$c->nom}}</td>
                                                                <td>{{$c->telephone ?? 'Vide'}}</td>
                                                                <td>{{$c->email ?? 'Vide'}}</td>
                                                                <td>{{$c->adresse ?? 'Vide'}}</td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <a href="" class="action-btn text-warning" data-bs-toggle="modal" data-id="{{ $c->id }}" data-name="{{ $c->nom }}" data-phone="{{ $c->telephone }}" data-email="{{ $c->email }}" data-adress="{{$c->adresse }}" data-bs-target="#clientEditModal" title="Modifier">
                                                                                <i class="fas fa-edit"></i>
                                                                            </a>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <form action="{{route('client.destroy', $c->id)}}" type="button" method="post" onsubmit="return confirm('Supprimer ?')">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                                <button type="submit" class="text-danger" title="Supprimer">
                                                                                    <i class="fa fa-trash"></i>
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


                                                @if ($errors->any())
                                                    <div class="alert alert-danger">
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif 

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

                                                <!-- Edit client -->
                                                <div class="modal fade" id="clientEditModal" tabindex="-1">
                                                    <div class="modal-dialog">

                                                        <form method="post" id="editClientForm" action="">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Modification client</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <input type="hidden" name="id" id="client_id">

                                                                    <div class="mb-3">
                                                                        <label>Nom du client</label>
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
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>

    <!--Recuperation des donnees client pour l'Edit -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('clientEditModal');
            const form = document.getElementById('editClientForm');

            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;

                // Récupération des données
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const email = button.getAttribute('data-email');
                const phone = button.getAttribute('data-phone');
                const adress = button.getAttribute('data-adress');
                
                // Remplir le formulaire
                modal.querySelector('#client_id').value = id;
                modal.querySelector('#name').value = name;
                modal.querySelector('#phone').value = phone;
                modal.querySelector('#email').value = email;
                modal.querySelector('#adress').value = adress;
                
                // Mettre à jour l'action du formulaire avec l'ID récupéré
                const updateUrl = `/client/${id}`;
                form.action = updateUrl;
            });
        });
    </script>


    @include('partials.footer')
