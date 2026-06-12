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
                                                <h5>Achats</h5>
                                                <!--<span>use class <code>table</code> inside table element</span>-->
                                                <div class="card-header-right">
                                                    <a href="{{ route('achat.create') }}" style="color: var(--primary); text-decoration: none; font-weight: 500;">Nouvelle achat →</a>
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
                                                                <th>Référence</th>
                                                                <th>Fournisseur</th>
                                                                <th>Date</th>
                                                                <th>Total</th>
                                                                <th>Statut</th>
                                                                <th>Facture</th>
                                                                <th>Details</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            @forelse($achats as $a)
                                                                <tr>
                                                                    <td><strong>{{ $a->reference }}</strong></td>

                                                                    <td>{{ $a->fournisseur->nom ?? '-' }}</td>

                                                                    <td>{{ $a->created_at->format('d/m/y') }}</td>

                                                                    <td>{{ number_format($a->total, 0, ',', ' ') }} FCFA</td>

                                                                    <td>
                                                                        @if($a->statut == 'annule')
                                                                            <span class="badge bg-danger">Impayé</span>
                                                                        @elseif($a->statut == 'recu')
                                                                            <span class="badge bg-success">Payé</span>
                                                                        @else
                                                                            <span class="badge bg-info">Partiel</span>
                                                                        @endif
                                                                    </td>

                                                                    <td>
                                                                        <!-- Facture -->
                                                                        <a href="{{route('achat.edit', $a->id)}}" class="label bg-warning mr-2" title="afficher la facture">
                                                                            <i class="fas fa-file-alt"></i>&nbsp;Afficher
                                                                        </a>
                                                                    </td>

                                                                    <td>
                                                                        <!-- Supprimer -->
                                                                        <form action="{{ route('achat.destroy', $a->id) }}" 
                                                                            method="POST" 
                                                                            onsubmit="return confirm('Supprimer ?')">
                                                                            @csrf
                                                                            @method('DELETE')

                                                                            <button class="label bg-danger">
                                                                                Supprimer
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="6" class="text-center">
                                                                        Aucun bon de commande trouvé
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>                                           
                                        </div>
                                        <!-- Basic table card end -->
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
