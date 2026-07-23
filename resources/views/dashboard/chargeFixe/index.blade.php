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
                                                <h5>Charges Fixe</h5>
                                                <!--<span>use class <code>table</code> inside table element</span>-->
                                                <div class="card-header-right">
                                                    <a href="" style="color: var(--primary); text-decoration: none; font-weight: 500;" data-bs-toggle="modal" data-bs-target="#chargeModal">Nouveau charge →</a>
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
                                                                <th>Intitulait</th>
                                                                <th>Montant</th>
                                                                <th>Periode</th>
                                                                <th>Date debut</th>
                                                                <th>Date fin</th>
                                                                <!-- <th>Statut</th> -->
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($charges as $c)
                                                                <tr>
                                                                    <td><strong>{{$c->designation}}</strong></td>
                                                                    <td>{{ $c->intitulait }}</td>
                                                                    <td>{{number_format($c->montant, 0, ',',' ')}} XOF</td>
                                                                    <td><strong>{{ $c->periode }}</strong></td>
                                                                    <td>{{$c->date_debut}}</td>
                                                                    <td>{{$c->date_fin}}</td>
                                                                    <!-- <td>
                                                                        <span class="badge bg-{{ $c->statut == 'active' ? 'success' : 'danger' }}">
                                                                            {{ ucfirst($c->statut) }}
                                                                        </span>
                                                                    </td> -->
                                                                    <td>
                                                                        <div class="row">
                                                                            <div class="col-4">
                                                                                <a href="" class="action-btn text-warning" data-bs-toggle="modal" data-id="{{ $c->id }}" data-designation="{{ $c->designation }}" data-intitulait="{{ $c->intitulait }}" data-periode="{{ $c->periode }}" data-montant="{{ $c->montant }}" data-date_debut="{{ $c->date_debut }}" data-date_fin="{{ $c->date_fin }}" data-description="{{$c->description }}" data-bs-target="#chargeEditModal" title="Modifier">
                                                                                    <i class="fas fa-edit"></i>
                                                                                </a>
                                                                            </div>
                                                                            <div class="col-4">
                                                                                <form action="{{route('chargefixe.destroy', $c->id)}}" type="button" method="post" onsubmit="return confirm('Supprimer ?')">
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
                                                    <div class="d-flex justify-content-center mt-4">
                                                        {{$charges->links()}}
                                                    </div>

                                                    <!-- Modal charge -->
                                                    <div class="modal fade" id="chargeModal" tabindex="-1">
                                                        <div class="modal-dialog">
                                                        <form action="{{ route('chargefixe.store') }}" method="POST" class="contact-form">
                                                                @csrf
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Charge</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">

                                                                            <!-- Designation -->
                                                                            <div class="col-12 mb-3">
                                                                                <label class="form-label">Designation</label>
                                                                                <input type="text" name="designation" class="form-control" placeholder="Ex : Paiement salaire" required>
                                                                            </div>

                                                                            <!-- Intitulait -->
                                                                            <div class="col-12 mb-3">
                                                                                <label class="form-label">Intitulait</label>
                                                                                <input type="text" name="intitulait" class="form-control" placeholder="Ex : Oumar Ndiaye" required>
                                                                            </div>

                                                                            <!-- Montant -->
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label">Montant (FCFA)</label>
                                                                                <input type="number" name="montant" class="form-control" step="0.01" required>
                                                                            </div>

                                                                            <!-- Periode -->
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label">Periode</label>
                                                                                <select name="periode" class="form-control" required>
                                                                                    <option value="">-- Choisir --</option>
                                                                                    <option value="journalier">Journalier</option>
                                                                                    <option value="Hebdomadaire">Hebdomadaire</option>
                                                                                    <option value="mensuel">Mensuel</option>
                                                                                    <option value="trimestriel">Trimestriel</option>
                                                                                    <option value="annuel">Annuel</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Date debut -->
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label">Date debut</label>
                                                                                <input type="date" name="date_debut" class="form-control">
                                                                            </div>

                                                                            <!-- Date fin -->
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label">Date fin</label>
                                                                                <input type="date" name="date_fin" class="form-control">
                                                                            </div>

                                                                            <!-- Description -->
                                                                            <div class="col-md-12 mb-3">
                                                                                <label class="form-label">Description (optionnelle)</label>
                                                                                <textarea name="description" class="form-control" rows="3" placeholder="Détails supplémentaires..."></textarea>
                                                                            </div>

                                                                        </div>
                                                                        <!-- Bouton -->
                                                                        <div class="text-end">
                                                                            <button type="submit" class="btn btn-primary">
                                                                                💾 Enregistrer la charge
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>  

                                                    <!-- Edit charge -->
                                                    <div class="modal fade" id="chargeEditModal" tabindex="-1">
                                                        <div class="modal-dialog">

                                                            <form action="" method="POST" id="editChargeForm" class="contact-form">
                                                                @csrf
                                                            @method('PUT')
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Modification Charge</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <input type="hidden" name="id" id="charge_id">
                                                                        <div class="row">

                                                                            <!-- Designation -->
                                                                            <div class="col-12 mb-3">
                                                                                <label class="form-label">Designation</label>
                                                                                <input type="text" name="designation" id="designation" class="form-control">
                                                                            </div>

                                                                            <!-- Intitulait -->
                                                                            <div class="col-12 mb-3">
                                                                                <label class="form-label">Intitulait</label>
                                                                                <input type="text" name="intitulait" id="intitulait" class="form-control">
                                                                            </div>

                                                                            <!-- Montant -->
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label">Montant (FCFA)</label>
                                                                                <input type="number" name="montant" id="montant" class="form-control">
                                                                            </div>

                                                                            <!-- Periode -->
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label">Periode</label>
                                                                                <select name="periode" id="periode" class="form-control">
                                                                                    <option value="journalier">Journalier</option>
                                                                                    <option value="Hebdomadaire">Hebdomadaire</option>
                                                                                    <option value="mensuel">Mensuel</option>
                                                                                    <option value="trimestriel">Trimestriel</option>
                                                                                    <option value="annuel">Annuel</option>
                                                                                </select>
                                                                            </div>

                                                                            <!-- Date debut -->
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label">Date debut</label>
                                                                                <input type="date" name="date_debut" id="date_debut" class="form-control">
                                                                            </div>

                                                                            <!-- Date fin -->
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label">Date fin</label>
                                                                                <input type="date" name="date_fin" id="date_fin" class="form-control">
                                                                            </div>

                                                                            <!-- Description -->
                                                                            <div class="col-md-12 mb-3">
                                                                                <label class="form-label">Description (optionnelle)</label>
                                                                                <textarea name="description" id="description" class="form-control" rows="3"></textarea>
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

    <!--Recuperation des donnees charges pour l'Edit -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('chargeEditModal');
            const form = document.getElementById('editChargeForm');

            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;

                // Récupération des données
                const id = button.getAttribute('data-id');
                const designation = button.getAttribute('data-designation');
                const intitulait = button.getAttribute('data-intitulait');
                const periode = button.getAttribute('data-periode');
                const montant = button.getAttribute('data-montant');
                const date_debut = button.getAttribute('data-date_debut');
                const date_fin = button.getAttribute('data-date_fin');
                const description = button.getAttribute('data-description');
                
                // Remplir le formulaire
                modal.querySelector('#charge_id').value = id;
                modal.querySelector('#designation').value = designation;
                modal.querySelector('#intitulait').value = intitulait;
                modal.querySelector('#periode').value = periode;
                modal.querySelector('#montant').value = montant;
                modal.querySelector('#date_debut').value = date_debut;
                modal.querySelector('#date_fin').value = date_fin;
                modal.querySelector('#description').value = description;
                
                // Mettre à jour l'action du formulaire avec l'ID récupéré
                const updateUrl = `/chargefixe/${id}`;
                form.action = updateUrl;
            });
        });
    </script>

    @include('partials.footer')
