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
                                            <li class="breadcrumb-item"><a href="#!">{{  Auth::user()->unite->nom }}</a>
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
                                                <h5>comptes</h5>
                                                <!--<span>use class <code>table</code> inside table element</span>-->
                                                <div class="card-header-right">
                                                    <a href="" style="color: var(--primary); text-decoration: none; font-weight: 500;" data-bs-toggle="modal" data-bs-target="#compteModal">Nouveau comptes →</a>
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
                                                    <div class="alert alert-success" role="alert">
                                                        {{ Session::get('success') }}
                                                    </div>
                                                @elseif(Session::has('danger'))
                                                    <div class="alert alert-danger" role="alert">
                                                        {{ Session::get('danger') }}
                                                    </div>
                                                @endif
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Banque</th>
                                                                <th>N° Compte</th>
                                                                <th>Solde Initial</th>
                                                                <th>Date Ouverture</th>
                                                                <th>Statut</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($compteBancaires as $c)
                                                                <tr>
                                                                    <td>{{$c->banque}}</td>
                                                                    <td>{{$c->numero_compte}}</td>
                                                                    <td>{{number_format($c->solde_initial, 0, ',',' ')}} XOF</td>
                                                                    <td>{{$c->date_ouverture}}</td>
                                                                    <td>
                                                                        <span class="badge bg-{{ $c->statut == 'actif' ? 'success' : 'danger' }}">
                                                                            {{ ucfirst($c->statut) }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        <a href="" class="action-btn text-warning" data-bs-toggle="modal" data-id="{{ $c->id }}" data-banque="{{ $c->banque }}" data-numero_compte="{{ $c->numero_compte }}" data-bs-target="#compteEditModal" title="Modifier">
                                                                            <i class="fas fa-edit"></i>
                                                                        </a>
                                                                        <a href="" class="action-btn text-success" data-bs-toggle="modal" data-id="{{ $c->id }}" data-bs-target="#mouvementModal" title="Mouvements">
                                                                            <i class="fas fa-repeat"></i>
                                                                        </a>
                                                                </tr>
                                                                @empty
                                                                <tr>
                                                                    <td colspan="7" align="center">Donnee vide !</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                        </table>    
                                                    </div>
                                                    
                                                    <!-- Modal compte -->
                                                    <div class="modal fade" id="compteModal" tabindex="-1">
                                                        <div class="modal-dialog">
                                                        <form action="{{ route('compteBancaire.store') }}" method="POST" class="contact-form">
                                                                @csrf
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Nouveau Compte Bancaire</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">

                                                                            <!-- Libellé -->
                                                                            <div class="col-12 mb-3">
                                                                                <label class="form-label">Nom de la Banque</label>
                                                                                <input type="text" name="banque" class="form-control" placeholder="Ex : Banque du Sénégal" required>
                                                                            </div>

                                                                            <!-- N° Compte -->
                                                                            <div class="col-12 mb-3">
                                                                                <label class="form-label">Numéro de Compte</label>
                                                                                <input type="text" name="numero_compte" class="form-control" placeholder="Ex : 123456789" required>
                                                                            </div>

                                                                            <!-- Titulaire -->
                                                                            <div class="col-12 mb-3">
                                                                                <label class="form-label">Titulaire</label>
                                                                                <input type="text" name="titulaire" class="form-control" placeholder="Ex : John Doe" required>
                                                                            </div>

                                                                            <!-- Solde Initial -->
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label">Solde Initial (FCFA)</label>
                                                                                <input type="number" name="solde_initial" class="form-control" step="0.01" required>
                                                                            </div>

                                                                            <!-- Date -->
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label">Date d'ouverture</label>
                                                                                <input type="date" name="date_ouverture" class="form-control" value="{{ date('Y-m-d') }}" required>
                                                                            </div>

                                                                            <!-- Statut -->
                                                                            <div class="col-12 mb-3">
                                                                                <label class="form-label">Statut</label>
                                                                                <select name="statut" class="form-control" required>
                                                                                    <option value="actif">Actif</option>
                                                                                    <option value="inactif">Inactif</option>
                                                                                </select>
                                                                            </div>


                                                                        </div>
                                                                        <!-- Bouton -->
                                                                        <div class="text-end">
                                                                            <button type="submit" class="btn btn-primary">
                                                                                💾 Enregistrer le compte
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div> 

                                                    <!-- Modal Edition -->
                                                    <div class="modal fade" id="compteEditModal" tabindex="-1">
                                                        <div class="modal-dialog">
                                                            <form action="" method="POST" class="contact-form" id="editCompteForm">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Modifier le Compte Bancaire</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <input type="hidden" name="compte_id" id="compte_id">

                                                                        <!-- Libellé -->
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Nom de la Banque</label>
                                                                            <input type="text" name="banque" id="banque" class="form-control" placeholder="Ex : Banque du Sénégal" required>
                                                                        </div>

                                                                        <!-- N° Compte -->
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Numéro de Compte</label>
                                                                            <input type="text" name="numero_compte" id="numero_compte" class="form-control" placeholder="Ex : 123456789" required>
                                                                        </div>

                                                                        <!-- Bouton -->
                                                                        <div class="text-end">
                                                                            <button type="submit" class="btn btn-primary">
                                                                                💾 Enregistrer le compte
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Modal mouvement -->
                                                    <div class="modal fade" id="mouvementModal" tabindex="-1">
                                                        <div class="modal-dialog modal-lg">
                                                            <form action="" method="POST" class="contact-form">
                                                                @csrf
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Mouvements du Compte Bancaire</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                    </div>
                                                                    <div class="modal-body">

                                                                            <input type="hidden" name="compte_id" id="compte_id">

                                                                            <!-- Type -->
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Type de Mouvement</label>
                                                                                <select name="type" class="form-control" required>
                                                                                    <option value="virement">Virement</option>
                                                                                    <option value="retrait">Retrait</option>
                                                                                    <option value="depot">Dépôt</option>
                                                                                    <option value="versement">Versement</option>
                                                                                    <option value="encaissement">Encaissement</option>
                                                                                    <option value="autre">Autre</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Montant -->
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Montant (FCFA)</label>
                                                                                <input type="number" name="montant" class="form-control" step="0.01" required>
                                                                            </div>

                                                                            <!-- Frais -->
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Frais (FCFA)</label>
                                                                                <input type="number" name="frais" class="form-control" step="0.01" required>
                                                                            </div>

                                                                            <!-- Date operation -->
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Date d'opération</label>
                                                                                <input type="date" name="date_operation" class="form-control" value="{{ date('Y-m-d') }}" required>
                                                                            </div>

                                                                            <!-- Motif -->
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Motif</label>
                                                                                <input type="text" name="motif" class="form-control" placeholder="Ex : Versement de salaire" required>
                                                                            </div>

                                                                        <!-- Bouton -->
                                                                        <div class="text-end">
                                                                            <button type="submit" class="btn btn-primary">
                                                                                💾 Enregistrer le compte
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


        <!--Recuperation des donnees compte bancaire pour l'Edit -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('compteEditModal');
            const form = document.getElementById('editCompteForm');

            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;

                // Récupération des données
                const id = button.getAttribute('data-id');
                const banque = button.getAttribute('data-banque');
                const numero_compte = button.getAttribute('data-numero_compte');

                // Remplir le formulaire
                modal.querySelector('#compte_id').value = id;
                modal.querySelector('#banque').value = banque;
                modal.querySelector('#numero_compte').value = numero_compte;
                
                // Mettre à jour l'action du formulaire avec l'ID récupéré
                const updateUrl = `/compteBancaire/${id}`;
                form.action = updateUrl;
            });
        });
    </script>

    <!-- Mouvements -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('mouvementModal');
            const form = document.getElementById('mouvementForm');

            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;

                // Récupération des données
                const id = button.getAttribute('data-id');

                // Remplir le formulaire
                modal.querySelector('#compte_id').value = id;
                
                // Mettre à jour l'action du formulaire avec l'ID récupéré
                const updateUrl = `/compteBancaire/${id}/mouvements`;
                form.action = updateUrl;
            });
        });
    </script>
    
    @include('partials.footer')
