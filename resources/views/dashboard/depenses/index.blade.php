    @include('partials.header')

                    <div class="pcoded-content">
                        <!-- Page-header start -->
                        <div class="page-header">
                            <div class="page-block">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="page-header-title">
                                            <h5 class="m-b-10">Dashboard</h5>
                                            <p class="m-b-0">Welcome to Material Able</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="index.html"> <i class="fa fa-home"></i> </a>
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
                                                <h5>Ventes</h5>
                                                <span>use class <code>table</code> inside table element</span>
                                                <div class="card-header-right">
                                                    <a href="" style="color: var(--primary); text-decoration: none; font-weight: 500;" data-bs-toggle="modal" data-bs-target="#depenseModal">Nouveau depense →</a>
                                                    <ul class="list-unstyled card-option">
                                                        <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                                        <li><i class="fa fa-window-maximize full-card"></i></li>
                                                        <li><i class="fa fa-minus minimize-card"></i></li>
                                                        <li><i class="fa fa-refresh reload-card"></i></li>
                                                        <li><i class="fa fa-trash close-card"></i></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-block table-border-style">
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
                                                                <th>Reference</th>
                                                                <th>Date</th>
                                                                <th>Libelle</th>
                                                                <th>Montant</th>
                                                                <th>Statut</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($depenses as $d)
                                                                <tr>
                                                                    <td>{{$d->reference}}</td>
                                                                    <td>{{$d->date_depense}}</td>
                                                                    <td>{{$d->libelle}}</td>
                                                                    <td>{{number_format($d->montant, 0, ',',' ')}} XOF</td>
                                                                    <td>
                                                                        <span class="badge bg-{{ $d->statut == 'payee' ? 'success' : 'danger' }}">
                                                                            {{ ucfirst($d->statut) }}
                                                                        </span>
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
                                                        {{$depenses->links()}}
                                                    </div>
                                                    <!-- Modal paiement -->
                                                    <div class="modal fade" id="depenseModal" tabindex="-1">
                                                        <div class="modal-dialog">
                                                        <form action="{{ route('depense.store') }}" method="POST" class="contact-form">
                                                                @csrf
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Depense</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">

                                                                            <!-- Libellé -->
                                                                            <div class="col-12 mb-3">
                                                                                <label class="form-label">Libellé de la dépense</label>
                                                                                <input type="text" name="libelle" class="form-control" placeholder="Ex : Achat marchandises" required>
                                                                            </div>

                                                                            <!-- Montant -->
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label">Montant (FCFA)</label>
                                                                                <input type="number" name="montant" class="form-control" step="0.01" required>
                                                                            </div>

                                                                            <!-- Date -->
                                                                            <div class="col-6 mb-3">
                                                                                <label class="form-label">Date de la dépense</label>
                                                                                <input type="date" name="date_depense" class="form-control" value="{{ date('Y-m-d') }}" required>
                                                                            </div>

                                                                            <!-- Mode de paiement -->
                                                                            <div class="col-12 mb-3">
                                                                                <label class="form-label">Mode de paiement</label>
                                                                                <select name="mode_paiement" class="form-control" required>
                                                                                    <option value="">-- Choisir --</option>
                                                                                    <option value="cash">Cash</option>
                                                                                    <option value="orange_money">Orange Money</option>
                                                                                    <option value="wave">wave</option>
                                                                                    <option value="cheque">Cheque</option>
                                                                                    <option value="autre">Autre</option>
                                                                                </select>
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
                                                                                💾 Enregistrer la dépense
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


    @include('partials.footer')
