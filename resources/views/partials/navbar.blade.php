
            <nav class="navbar header-navbar pcoded-header">
                <div class="navbar-wrapper">
                    <div class="navbar-logo">
                        <a class="mobile-menu waves-effect waves-light" id="mobile-collapse" href="#!">
                            <i class="ti-menu"></i>
                        </a>
                        <div class="mobile-search waves-effect waves-light">
                            <div class="header-search">
                                <div class="main-search morphsearch-search">
                                    <div class="input-group">
                                        <span class="input-group-prepend search-close"><i class="ti-close input-group-text"></i></span>
                                        <input type="text" class="form-control" placeholder="Enter Keyword">
                                        <span class="input-group-append search-btn"><i class="ti-search input-group-text"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <img class="img-fluid" src="{{ asset('assets/images/logo-b.png') }}" alt="Theme-Logo" />
                        </a>
                        <a class="mobile-options waves-effect waves-light">
                            <i class="ti-more"></i>
                        </a>
                    </div>
                    <div class="navbar-container container-fluid">
                        <ul class="nav-left">
                            <li>
                                <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
                            </li>
                            <li>
                                <a href="#!" onclick="javascript:toggleFullScreen()" class="waves-effect waves-light">
                                    <i class="ti-fullscreen"></i>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav-right">
                           
                            <li class="header-notification">
                                <a href="#!" class="waves-effect waves-light">
                                    <i class="ti-bell"></i>
                                    @if($alerte)
                                        <span class="badge bg-c-red"></span>
                                    @endif
                                </a>
                                <ul class="show-notification">
                                    
                                    @if($alerte)
                                        <li>
                                            <h6>Notifications</h6>
                                            <label class="label label-danger">New</label>
                                        </li>
                                        <li class="waves-effect waves-light">
                                            <div class="media">
                                                <div class="media-body">
                                                    <h5 class="notification-user">⛔Alerte</h5>
                                                    <p class="notification-msg">Vous avez <b><?= $alerte ?></b> produit(s) en rupture de stock..</p>
                                                    <span class="notification-time"><a href="{{ route('produit.index') }}">Mettre a jour</a></span>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                   
                                </ul>
                            </li>
                            <li class="user-profile header-notification">
                                <a href="#!" class="waves-effect waves-light">
                                    <!--<img src="assets/images/avatar-4.jpg" class="img-radius" alt="User-Profile-Image">-->
                                    <span>{{ Auth::user()->name }}</span>
                                    <i class="ti-angle-down"></i>
                                </a>
                                <ul class="show-notification profile-notification">
                                    <li class="waves-effect waves-light">
                                        <a href="{{ route('profile.edit') }}">
                                            <i class="ti-user"></i> Profile
                                        </a>
                                    </li>
                                    <li class="waves-effect waves-light">
                                        <a href="{{ route('assistance') }}">
                                            <i class="fas fa-cog"></i> Supports & Assistance
                                        </a>
                                    </li>
                                
                                    <li class="waves-effect waves-light">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf

                                            <a href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                                <i class="ti-layout-sidebar-left"></i>Deconnexion
                                            </a>
                                        </form>
                                      
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>