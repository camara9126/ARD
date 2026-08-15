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
                                                <h5>Mouvements Stock</h5>
                                                <!--<span>use class <code>table</code> inside table element</span>-->
                                                <div class="card-header-right">
                                                    <a href="" style="color: var(--primary); text-decoration: none; font-weight: 500;" data-bs-toggle="modal"  data-bs-target="#mouvementModal">Nouveau Mouvement →</a>
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
                                                                <th>Compte</th>
                                                                <th>type</th>
                                                                <th>Montant</th>
                                                                <th>Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($mouvementsBancaires as $m)
                                                            <tr>
                                                                <td>{{$m->reference}}</td>
                                                                </td>
                                                                <td>{{$m->compte->banque ?? $m->compte_bancaires_id}}</td>
                                                                <td>{{$m->type}}</td>
                                                                <td><strong>{{ number_format($m->montant, 0, ',',' ')}} XOF</strong></td>
                                                                <td>{{$m->date_operation}}</td>
                                                            </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="7" align="center">Donnee vide !</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                   
                                                    <!-- Modal Nouveau mouvement stck-->
                                                    <div class="modal fade" id="mouvementModal" tabindex="-1">
                                                        <div class="modal-dialog">
                                                            <form method="post" action="{{route('mouvement.store')}}">
                                                                @csrf
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Mouvements Financiers</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label>Compte Bancaire</label>
                                                                            <select class="form-control" name="compte_bancaires_id" id="exampleFormControlSelect1" required>
                                                                                <option value="">-- Veuillez choisir un compte bancaire --</option>
                                                                                @foreach($compteBancaires as $compte)
                                                                                    <option value="{{ $compte->id }}">{{ $compte->banque }} - {{ $compte->numero_compte }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>

                                                                        <!-- Type -->
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Type de Mouvement</label>
                                                                            <select name="type" class="form-control" required>
                                                                                <option value="">-- Veuillez choisir un type de mouvement --</option>
                                                                                <option value="virement">Virement</option>
                                                                                <option value="retrait">Retrait</option>
                                                                                <option value="depot">Dépôt</option>
                                                                                <option value="versement">Versement</option>
                                                                                <option value="encaissement">Encaissement</option>
                                                                                <option value="autre">Autre</option>
                                                                            </select>
                                                                        </div>

                                                                        <div class="row mb-3">

                                                                            <!-- Montant -->
                                                                            <div class="col-6">
                                                                                <div class="">
                                                                                    <label class="form-label">Montant (FCFA)</label>
                                                                                    <input type="number" name="montant" class="form-control" step="0.01" required>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Frais -->
                                                                            <div class="col-6">
                                                                                <div class="">
                                                                                    <label class="form-label">Frais (FCFA)</label>
                                                                                    <input type="number" name="frais" class="form-control" step="0.01">
                                                                                </div>
                                                                            </div>
                                                                        </div> 

                                                                        <!-- Date operation -->
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Date d'opération</label>
                                                                            <input type="date" name="date_operation" class="form-control" value="{{ date('Y-m-d') }}" required>
                                                                        </div>

                                                                        <!-- Reference -->
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Référence</label>
                                                                            <input type="text" name="reference" class="form-control" placeholder="Ex : REF-001">
                                                                        </div>

                                                                        <!-- Motif -->
                                                                        <div class="mb-3">
                                                                            <label class="form-label">Motif</label>
                                                                            <input type="text" name="motif" class="form-control" placeholder="Ex : Versement de salaire">
                                                                        </div>

                                                                        <!-- Bouton -->
                                                                        <div class="text-end">
                                                                            <button type="submit" class="btn btn-primary">
                                                                                💾 Enregistrer le mouvement
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
