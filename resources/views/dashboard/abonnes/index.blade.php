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
                                                <h5>abonnes</h5>
                                                <!--<span>use class <code>table</code> inside table element</span>-->
                                                <div class="card-header-right">
                                                    <a href="" style="color: var(--primary); text-decoration: none; font-weight: 500;" data-bs-toggle="modal"  data-bs-target="#abonneModal">Nouveau abonne →</a>
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
                                                                <th>Reference</th>
                                                                <th>Nom</th>
                                                                <th>Telephone</th>
                                                                <th>Mois</th>
                                                                <th>Statut</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($abonnes as $a)
                                                            <tr>
                                                                <td>{{$a->reference}}</td>
                                                                <td>{{$a->nom_complet}}</td>
                                                                <td>{{$a->telephone ?? 'Vide'}}</td>
                                                                <td>{{$a->paiements->first()->mois ?? 'Vide'}}</td>
                                                                <td>
                                                                    @if($a->paiements->first()->statut == 'payé')
                                                                        <span class="badge bg-success">Payé</span>
                                                                    @else
                                                                        <span class="badge bg-danger">
                                                                            <a href="" data-bs-toggle="modal" data-id="{{$a->id}}" data-bs-target="#paiementModal">Non Payé</a>
                                                                        </span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <a href="" class="action-btn text-warning" data-bs-toggle="modal" data-id="{{ $a->id }}" data-name="{{ $a->nom_complet }}" data-phone="{{ $a->telephone }}" data-adresse="{{$a->adresse }}" data-bs-target="#abonneEditModal" title="Modifier">
                                                                                <i class="fas fa-edit"></i>
                                                                            </a>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <form action="{{route('abonne.destroy', $a->id)}}" type="button" method="post" onsubmit="return confirm('Supprimer ?')">
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


                                                <!-- Modal paiement -->
                                                <div class="modal fade" id="paiementModal" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <form action="{{ route('paiement.abonne') }}" method="POST">
                                                            @csrf
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Paiement</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="abonne_id" id="abonne_id">

                                                                    <div class="mb-3">
                                                                        <label>Montant à payer</label>
                                                                        <input type="number" name="montant" class="form-control" required>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label>Mode de paiement</label>
                                                                        <select name="mode_paiement" class="form-select" required>
                                                                            <option value="cash">Cash</option>
                                                                            <option value="wave">Wave</option>
                                                                            <option value="orange_money">Orange Money</option>
                                                                            <option value="banque">Banque</option>
                                                                        </select>
                                                                    </div>

                                                                    <button class="btn btn-success">
                                                                        Enregistrer le paiement
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            
                                                        </form>
                                                    </div>
                                                </div>

                                                <!-- Nouveau abonne -->
                                                <div class="modal fade" id="abonneModal" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <form method="post" action="{{route('abonne.store')}}">
                                                            @csrf
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Nouveau abonne</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label>Nom de l'abonné</label>
                                                                        <input type="text" name="nom_complet" class="form-control" required>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label>Téléphone</label>
                                                                        <input type="text" name="telephone" class="form-control">
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label>Adresse</label>
                                                                        <textarea name="adresse" class="form-control"></textarea>
                                                                    </div>
                                                                    
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                                <!-- Edit abonne -->
                                                <div class="modal fade" id="abonneEditModal" tabindex="-1">
                                                    <div class="modal-dialog">

                                                        <form method="post" id="editabonneForm" action="">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Modification abonne</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <input type="hidden" name="id" id="abonne_id">

                                                                    <div class="mb-3">
                                                                        <label>Nom de l'abonne</label>
                                                                        <input type="text" name="nom_complet" id="name" class="form-control" required>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label>Téléphone</label>
                                                                        <input type="text" name="telephone" id="phone" class="form-control">
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label>Adresse</label>
                                                                        <textarea name="adresse" id="adresse" class="form-control" rows="3"></textarea>
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

    <!--Recuperation des donnees abonne pour l'Edit -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('abonneEditModal');
            const form = document.getElementById('editabonneForm');

            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;

                // Récupération des données
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const phone = button.getAttribute('data-phone');
                const adresse = button.getAttribute('data-adresse');
                
                // Remplir le formulaire
                modal.querySelector('#abonne_id').value = id;
                modal.querySelector('#name').value = name;
                modal.querySelector('#phone').value = phone;
                modal.querySelector('#adresse').value = adresse;
                
                // Mettre à jour l'action du formulaire avec l'ID récupéré
                const updateUrl = `/abonne/${id}`;
                form.action = updateUrl;
            });
        });
    </script>

    <script>
    // Recuperation de l'ID de la vente
    document.addEventListener('DOMContentLoaded', function () {

        const modal = document.getElementById('paiementModal');

        modal.addEventListener('show.bs.modal', function (event) {

            const button = event.relatedTarget;

            const id = button.getAttribute('data-id');

            modal.querySelector('#abonne_id').value = id;
        });
    });

    
</script>


    @include('partials.footer')
