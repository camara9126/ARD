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
                                                <h5>unites ( {{$unites->count() }} )</h5>
                                                <!--<span>use class <code>table</code> inside table element</span>-->
                                                <div class="card-header-right">
                                                    <a href="{{route('admin.index') }}" style="color: var(--danger); text-decoration: none; font-weight: 500;" >retour →</a>
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
                                                                <th><b>Logo</b></th>
                                                                <th><b>Nom</b></th>
                                                                <th><b>Contact</b></th>
                                                                <th><b>Adresse</b></th>
                                                                <th><b>Date de creation</b></th>
                                                                <th><b>Statut</b></th>
                                                                <!--<th><b>Action</b></th>-->
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($unites as $u)
                                                            <tr>
                                                                <td>
                                                                    <img class="img-50 img-radius" src="{{asset('storage/'.$u->logo)}}" alt="{{ $u->nom }}">
                                                                </td>
                                                                <td>{{$u->nom}}</td>
                                                                <td>{{$u->contact}}</td>
                                                                <td>{{$u->adresse ?? 'vide'}}</td>
                                                                <td>{{$u->created_at->format('d-m-y')}}</td>
                                                                <td>
                                                                    @if($u->statut)
                                                                        <span class="badge bg-success">Actif</span>
                                                                    @else
                                                                        <span class="badge bg-danger">Inactif</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
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
