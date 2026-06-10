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
                                                    <a href="{{route('vente.create') }}" style="color: var(--primary); text-decoration: none; font-weight: 500;" >Nouvelle commande →</a>
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
                                                                <th>Client</th>
                                                                <th>Montant</th>
                                                                <th>Date de paiement</th>
                                                                <!--<th>Mode de paiement</th>-->
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($paiements as $p)
                                                            <tr>
                                                                <td>{{$p->reference}}</td>
                                                                <td>{{optional($p->vente->client)->nom ?? '-'}}</td>
                                                                <td>{{max(0, number_format($p->montant, 0, ',',' '))}} XOF</td>
                                                                <td>{{$p->date_paiement}}</td>
                                                                <!--<td>{{$p->mode_paiement}}</td>-->
                                                                <td>
                                                                    @if($p->statut === 'valide')
                                                                        <form action="{{ route('paiement.update', $p->id) }}" method="POST" onsubmit="return confirm('Confirmer l’annulation du paiement ?')">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <button class="action-btn text-danger btn-sm" title="Annuler le paiement">
                                                                                <i class="fas fa-times"></i>
                                                                            </button>
                                                                        </form>
                                                                    @else
                                                                            <button class="action-btn text-secondary btn-sm" title="Paiement annule">
                                                                                <i class="fas fa-times"></i>
                                                                            </button>
                                                                    @endif                                    
                                                                </td>                                                        
                                                            </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="7" align="center">Donnee vide !</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                    <div class="d-flex justify-content-center mt-4">
                                                        {{$paiements->links()}}
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
