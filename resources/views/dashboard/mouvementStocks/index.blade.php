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
                                                <h5>Mouvements Stock</h5>
                                                <!--<span>use class <code>table</code> inside table element</span>-->
                                                <div class="card-header-right">
                                                    <a href="" style="color: var(--primary); text-decoration: none; font-weight: 500;" data-bs-toggle="modal"  data-bs-target="#exampleModal">Nouveau Mouvement →</a>
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
                                                                <th>Produit</th>
                                                                <th>type</th>
                                                                <th>Quantite</th>
                                                                <th>Date</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($mouvements as $m)
                                                            <tr>
                                                                <td>
                                                                    <div class="product-info">
                                                                        <div>
                                                                            <div style="font-weight: 600;">{{$m->reference}}</div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>{{$m->produit->nom ?? $m->designation}}</td>
                                                                <td>{{$m->type}}</td>
                                                                <td><strong>{{$m->quantite}}</strong></td>
                                                                <td>{{$m->created_at->format('d/m/Y')}}</td>
                                                            </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="7" align="center">Donnee vide !</td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>

                                                    <!-- Modal Nouveau mouvement stck-->
                                                    <div class="modal fade" id="exampleModal" tabindex="-1">
                                                        <div class="modal-dialog">
                                                            <form method="post" action="{{route('stock.store')}}">
                                                                @csrf
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Mouvement Stock</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label>Produit</label>
                                                                            <select class="form-control" name="produit_id" id="exampleFormControlSelect1">
                                                                                <option value="">-- Veuillez choisir un produit --</option>
                                                                                @foreach($produits as $a)
                                                                                <option value="{{$a->id}}">{{$a->nom}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label>Type</label>
                                                                            <select class="form-control" name="type" id="exampleFormControlSelect1">
                                                                                <option value="">-- Veuillez choisir le type de mouvement --</option>
                                                                                <option value="entree">Entree</option>
                                                                                <option value="sortie">Sortie</option>
                                                                            </select>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label>Quantite</label>
                                                                            <input type="number" name="quantite" min="1" class="form-control" id="exampleInputquantity1">
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
                     </div>
            </div>
        </div>
    </div>

    @include('partials.footer')
