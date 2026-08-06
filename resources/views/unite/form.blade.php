<!DOCTYPE html>
<html lang="en">

<head>
    <title>ARD GestioPro - Tableau de bord opérationnel</title>
    
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="keywords" content="bootstrap, bootstrap admin template, admin theme, admin dashboard, dashboard template, admin template, responsive" />
    <meta name="author" content="Codedthemes" />
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
    <!-- waves.css -->
    <link rel="stylesheet" href="{{ asset('assets/pages/waves/css/waves.min.css') }}" type="text/css" media="all">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap/css/bootstrap.min.css') }}">
    <!-- waves.css -->
    <link rel="stylesheet" href="{{ asset('assets/pages/waves/css/waves.min.css') }}" type="text/css" media="all">
    <!-- themify icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/icon/themify-icons/themify-icons.css') }}">
    <!-- font-awesome-n -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome-n.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <!-- scrollbar.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/jquery.mCustomScrollbar.css') }}">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <!-- Icones Logo -->
    <link rel="icon" href="{{ asset('assets/images/images/logoard.jpg.webp') }}" type="image/x-icon">
</head>

<body>
    <!-- Pre-loader start -->
    <div class="theme-loader">
        <div class="loader-track">
            <div class="preloader-wrapper">
                <div class="spinner-layer spinner-blue">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
                <div class="spinner-layer spinner-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-yellow">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>

                <div class="spinner-layer spinner-green">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div id="pcoded" class="pcoded">
            <div class="pcoded-overlay-box"></div>
                <div class="pcoded-container navbar-wrapper">
                        <div class="pcoded-content">
                            <!-- Page-header start -->
                            <div class="page-header">
                                <div class="page-block">
                                    <div class="row align-items-center">
                                        <div class="col-md-12">
                                            <div class="page-header-title">
                                                <h5 class="m-b-10">Creation Unite</h5>
                                                <p class="m-b-0">Veuillez renseigner les informations de votre business</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <ul class="breadcrumb">
                                                <li class="breadcrumb-item">
                                                    <a href="index.html"> <i class="fa fa-home"></i> </a>
                                                </li>
                                                <li class="breadcrumb-item"><a href="#!">Formulaire Unite</a>
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

                                        <!-- Page body start -->
                                        <div class="page-body">
                                            <div class="row">
                                                <div class="col-md-6 mx-auto">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5>Creation d'Unite</h5>
                                                        </div>
                                                       
                                                        <div class="card-block">
                                                            @if ($errors->any())
                                                                <div class="alert alert-danger">
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
                                                            <form class="form-material" method="post" action="{{ route('unite.store') }}" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="form-group form-default">
                                                                            <input type="text" name="nom" class="form-control">
                                                                            <span class="form-bar"></span>
                                                                            <label class="float-label">Nom Unite</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group form-default">
                                                                            <select name="categorie_id" class="form-control">
                                                                                    <option value="">-- Selectionner une categorie --</option>
                                                                                @foreach($categories as $c)
                                                                                    <option value="{{ $c->id }}">{{ $c->nom }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                            <span class="form-bar"></span>
                                                                            <label>Categorie Unite</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="form-group form-primary">
                                                                    <input type="text" name="adresse" class="form-control">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Adresse</label>
                                                                </div>
                                                                <div class="form-group form-success">
                                                                    <input type="text" name="contact" class="form-control">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Contact</label>
                                                                </div>
                                                                <div class="form-group form-danger">
                                                                    <input type="file" name="logo" class="form-control">
                                                                    <span class="form-bar"></span>
                                                                    <label class="float-label">Logo</label>
                                                                </div>
                                                                
                                                                <button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Enregister</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Page body end -->
                                    </div>
                                </div>                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



@include('partials.footer')