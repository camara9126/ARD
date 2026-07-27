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
                                                <h5>Ventes</h5>
                                                <!--<span>use class <code>table</code> inside table element</span>-->
                                                <div class="card-header-right">
                                                    <a href="{{route('vente.create') }}" style="color: var(--primary); text-decoration: none; font-weight: 500;" >Nouvelle commande →</a>
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
                                                                <!-- <th>Client</th> -->
                                                                <th>Montant TVA</th>
                                                                <th>Montant Total</th>
                                                                <th>Montant Payer</th>
                                                                <th>Montant Restant</th>
                                                                <th>Date</th>
                                                                <th>Statut</th>
                                                                <th>Actions</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($ventes as $v)
                                                            <tr>
                                                                <td><strong>{{$v->reference}}</strong></td>
                                                                <!-- <td>{{$v->client->nom ?? 'Anonyme'}}</td> -->
                                                                <td>{{number_format($v->total_tva, 0, ',',' ')}} XOF</td>
                                                                <td>{{number_format($v->total_ttc, 0, ',',' ')}} XOF</td>
                                                                <td>{{number_format($v->montant_paye, 0, ',', ' ')}} XOF</td>
                                                                <td>{{number_format($v->montant_restant, 0, ',',' ')}} XOF</td>
                                                                <td>{{$v->created_at->format('d/m/y')}}</td>
                                                                <td>
                                                                    @if($v->statut == 'payee')
                                                                        <span class="status-badge badge bg-success">{{$v->statut}}</span>
                                                                    @elseif($v->statut == 'partielle')
                                                                        <span class="status-badge badge bg-warning">{{$v->statut}}</span>
                                                                    @else
                                                                        <span class="status-badge badge bg-danger">{{$v->statut}}</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($v->montant_restant == 0)
                                                                        <button type="button" class="status-badge badge bg-secondary">
                                                                            Payée
                                                                        </button>
                                                                    @else
                                                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-id="{{$v->id}}" data-bs-target="#paiementModal">Payer
                                                                    </button>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <a href="{{route('vente.edit', $v->id)}}" class="action-btn text-warning mr-2" title="modifier la vente">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>
                                                                    <!-- Supprimer -->
                                                                    <form action="{{ route('vente.destroy', $v->id) }}" 
                                                                        method="POST" 
                                                                        onsubmit="return confirm('Supprimer la vente ?')">
                                                                        @csrf
                                                                        @method('DELETE')

                                                                        <button class="action-btn text-danger ml-2">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </form>
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
                                                    {{$ventes->links()}}
                                                </div>
                                            </div>                                                                    
                                        </div>
                                    </div>
                                    
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
<script>
    // Recuperation de l'ID de la vente
    document.addEventListener('DOMContentLoaded', function () {

        const modal = document.getElementById('paiementModal');

        modal.addEventListener('show.bs.modal', function (event) {

            const button = event.relatedTarget;

            const id = button.getAttribute('data-id');

            modal.querySelector('#vente_id').value = id;
        });
    });

    
</script>


    @include('partials.footer')
