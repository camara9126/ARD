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
                                                <h5>Equipements</h5>
                                                <!--<span>use class <code>table</code> inside table element</span>-->
                                                <div class="card-header-right">
                                                    <a href="" style="color: var(--primary); text-decoration: none; font-weight: 500;" data-bs-toggle="modal" data-bs-target="#equipementModal">Nouveau equipement →</a>
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
                                                                <th>nom</th>
                                                                <th>Valeur achat</th>
                                                                <th>Duree de vie</th>
                                                                <th>Date de service</th>
                                                                <th>Amortissement</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($equipements as $e)
                                                                <tr>
                                                                    <td><strong>{{$e->nom}}</strong></td>
                                                                    <td>{{number_format($e->valeur_achat, 0, ',',' ')}} XOF</td>
                                                                    <td><strong>{{$e->duree_vie_annees}} ans</strong></td>
                                                                    <td>{{ $e->date_mise_service }}</td>
                                                                    <td>{{number_format($e->amortissement_mensuel, 0, ',',' ')}} XOF/mois</td>
                                                                   
                                                                    <td>
                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <a href="" class="action-btn text-warning" data-bs-toggle="modal" data-id="{{ $e->id }}" data-nom="{{ $e->nom }}" data-valeur_achat="{{ $e->valeur_achat }}" data-duree_vie_annees="{{ $e->duree_vie_annees }}" data-date_mise_service="{{ $e->date_mise_service }}"  data-bs-target="#equipementEditModal" title="Modifier">
                                                                                    <i class="fas fa-edit"></i>
                                                                                </a>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <form action="{{route('equipements.destroy', $e->id)}}" type="button" method="post" onsubmit="return confirm('Supprimer ?')">
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
                                                    </div>

                                                    <!-- Modal equipement -->
                                                    <div class="modal fade" id="equipementModal" tabindex="-1">
                                                        <div class="modal-dialog">
                                                        <form action="{{ route('equipements.store') }}" method="POST" class="contact-form">
                                                                @csrf
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Equipement</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">

                                                                            <!-- Nom -->
                                                                            <div class="col-12 mb-3">
                                                                                <label class="form-label">Nom equipement</label>
                                                                                <input type="text" name="nom" class="form-control" placeholder="Ex : Machine a laver" required>
                                                                            </div>

                                                                            <!-- Valeur Achat -->
                                                                            <div class="col-12 mb-3">
                                                                                <label class="form-label">Valeur Achat (FCFA)</label>
                                                                                <input type="number" name="valeur_achat" class="form-control" step="0.01" required>
                                                                            </div>

                                                                            <!-- Duree vie annee -->
                                                                            <div class="col-12 mb-3">
                                                                                <label class="form-label">Duree de vie (Annee)</label>
                                                                                <input type="number" name="duree_vie_annees" class="form-control" step="0.01" required>
                                                                            </div>

                                                                            <!-- Date service -->
                                                                            <div class="col-12 mb-3">
                                                                                <label class="form-label">Date service</label>
                                                                                <input type="date" name="date_mise_service" class="form-control">
                                                                            </div>

                                                                        </div>
                                                                        <!-- Bouton -->
                                                                        <div class="text-end">
                                                                            <button type="submit" class="btn btn-primary">
                                                                                💾 Enregistrer l'equipement
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>  

                                                    <!-- Edit equipement -->
                                                    <div class="modal fade" id="equipementEditModal" tabindex="-1">
                                                        <div class="modal-dialog">

                                                            <form action="" method="POST" id="editEquipementForm" class="contact-form">
                                                                @csrf
                                                            @method('PUT')
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Modification Equipement</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <input type="hidden" name="id" id="equipement_id">
                                                                        <div class="row">

                                                                            <!-- Nom -->
                                                                            <div class="col-12 mb-3">
                                                                                <label class="form-label">Nom equipement</label>
                                                                                <input type="text" name="nom" id="nom" class="form-control">
                                                                            </div>

                                                                            <!-- Valeur Achat -->
                                                                            <div class="col-12 mb-3">
                                                                                <label class="form-label">Valeur achat (FCFA)</label>
                                                                                <input type="number" name="valeur_achat" id="valeur_achat" class="form-control">
                                                                            </div>

                                                                            <!-- Duree vie annee -->
                                                                            <div class="col-12 mb-3">
                                                                                <label class="form-label">Duree de vie (Annee)</label>
                                                                                <input type="number" name="duree_vie_annees" id="duree_vie_annees"  class="form-control" step="0.01" required>
                                                                            </div>

                                                                            <!-- Date service -->
                                                                            <div class="col-12 mb-3">
                                                                                <label class="form-label">Date service</label>
                                                                                <input type="date" name="date_mise_service" id="date_mise_service" class="form-control">
                                                                            </div>

                                                                        </div>
                                                                        <!-- Bouton -->
                                                                        <div class="text-end">
                                                                            <button type="submit" class="btn btn-primary">
                                                                                💾 Enregistrer
                                                                            </button>
                                                                        </div>
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
    </div>    

    <!--Recuperation des donnees equipements pour l'Edit -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('equipementEditModal');
            const form = document.getElementById('editEquipementForm');

            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;

                // Récupération des données
                const id = button.getAttribute('data-id');
                const nom = button.getAttribute('data-nom');
                const valeur_achat = button.getAttribute('data-valeur_achat');
                const duree_vie_annees = button.getAttribute('data-duree_vie_annees');
                const date_mise_service = button.getAttribute('data-date_mise_service');
                
                // Remplir le formulaire
                modal.querySelector('#equipement_id').value = id;
                modal.querySelector('#nom').value = nom;
                modal.querySelector('#valeur_achat').value = valeur_achat;
                modal.querySelector('#duree_vie_annees').value = duree_vie_annees;
                modal.querySelector('#date_mise_service').value = date_mise_service;
                
                // Mettre à jour l'action du formulaire avec l'ID récupéré
                const updateUrl = `/equipements/${id}`;
                form.action = updateUrl;
            });
        });
    </script>

    @include('partials.footer')
