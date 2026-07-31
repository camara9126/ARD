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
                                        <div class="card col-8 mx-auto">
                                            <div class="card-header">
                                                <h5>Nouveau Unite</h5>
                                                <!--<span>use class <code>table</code> inside table element</span>-->
                                                <div class="card-header-right">
                                                    <a href="{{route('admin.index') }}" style="color: var(--danger); text-decoration: none; font-weight: 500;" >Retour →</a>
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
                                                <form method="post" action="{{route('admin.store')}}" class="contact-form">
                                                    @csrf

                                                    <!-- Info Utilisateur -->
                                                    <h1 class="fw-bold text-center">Information Utilisateur</h1>

                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="mb-3">
                                                                <label for="name" class="form-label">Nom Complet</label>
                                                                <input type="text" class="form-control" name="name" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="mb-3">
                                                                <label for="email" class="form-label">Email</label>
                                                                <input type="email" class="form-control" name="email" required>
                                                            </div>
                                                           
                                                        </div>
                                                        <!-- <div class="col-6">
                                                            <div class="mb-3">
                                                                <label for="name" class="form-label">Telephone</label>
                                                                <input type="text" class="form-control" name="telephone" required>
                                                            </div>
                                                        </div> -->
                                                    </div>

                                                    <h1 class="text-center fw-bold mb-3 mt-3">Information Unite</h1>

                                                    <div class="row mt-2">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="role" class="form-label">Nom Unite</label>
                                                                <input type="text" class="form-control" name="nom" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label>Categorie Unite</label>
                                                                <select name="categorie_id" class="form-control">
                                                                        <option value="">-- Selectionner --</option>
                                                                    @foreach($categories as $c)
                                                                        <option value="{{ $c->id }}">{{ $c->nom }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div> 
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="mb-3">
                                                                <label for="name" class="form-label">Contact</label>
                                                                <input type="text" class="form-control" name="contact" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="mb-3">
                                                                <label for="email" class="form-label">Adresse</label>
                                                                <input type="text" class="form-control" name="adresse" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="mb-3">
                                                                <label for="logo" class="form-label">Logo</label>
                                                                <input type="file" class="form-control" name="logo">
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="mb-3">
                                                                <label for="password_confirmation" class="form-label">TVA</label>
                                                                <input type="number" class="form-control" name="taux_tva">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="mb-3">
                                                                <label for="name" class="form-label">Mod de Passe</label>
                                                                <input type="password" class="form-control" name="password" require>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="mb-3">
                                                                <label for="email" class="form-label">Confirmation Mot de Passe</label>
                                                                <input type="password" class="form-control" name="password_confirmation" require>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-3">
                                                        <div class="d-grid">
                                                            <button type="submit" class="btn btn-primary btn-lg">Ajouter</button>
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

    @include('partials.footer')
