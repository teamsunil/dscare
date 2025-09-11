    
    <style>
        .main-logo{
            width: 170px !important;
            margin-top: 25px;
        }
        .img_small
        {
            width: 40px !important;
        }
    </style>
    <div class="left-sidebar-pro">
        <nav id="sidebar" class="">
            <div class="sidebar-header">
                <a href="{{ route('index') }}"><img class="main-logo" src="{{ asset('admin/img/logo/logo.png')}}" alt="" /></a>
                <strong><a href="{{ route('index') }}"><img class="img_small" src="{{ asset('admin/img/logo/logosn.png')}}" alt="" /></a></strong>
            </div>
            <div class="left-custom-menu-adp-wrap comment-scrollbar mg-t-15">
                <nav class="sidebar-nav left-sidebar-menu-pro">
                    <ul class="metismenu" id="menu1">
                        
                        <li>
                            <a title="Landing Page" href="{{ route('index') }}" aria-expanded="false"><span class="educate-icon educate-home icon-wrap" aria-hidden="true"></span> <span class="mini-click-non">Dashboard</span></a>
                        </li>
                        <li>
                            <a title="Landing Page" href="{{ route('dashboard') }}" aria-expanded="false"><span class="educate-icon educate-event icon-wrap sub-icon-mg" aria-hidden="true"></span> <span class="mini-click-non">Website List</span></a>
                        </li>
                        <li>
                            <a title="Landing Page" href="{{ route('download') }}" aria-expanded="false"><span class="educate-icon educate-course  icon-wrap sub-icon-mg" aria-hidden="true"></span> <span class="mini-click-non">Download Plugins</span></a>
                        </li>
                       
                    
                    </ul>
                </nav>
            </div>
        </nav>
    </div>
    <!-- End Left menu area -->
    <!-- Start Welcome area -->
    <div class="all-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="logo-pro">
                      <img class="main-logo" src="{{ asset('admin/img/logo/logo.png')}}" alt="" />
                    </div>
                </div>
            </div>
        </div>
        <div class="header-advance-area ">
            <div class="header-top-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="header-top-wraper">
                                <div class="row">
                                    <div class="col-lg-1 col-md-0 col-sm-1 col-xs-12">
                                        <div class="menu-switcher-pro">
                                            <button type="button" id="sidebarCollapse" class="btn bar-button-pro header-drl-controller-btn btn-info navbar-btn">
													<i class="educate-icon educate-nav"></i>
												</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-7 col-sm-6 col-xs-12">
                                     
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                        <div class="header-right-info">
                                            <ul class="nav navbar-nav mai-top-nav header-right-menu">
                                               
                                              
                                                 @php
                                                    $user = auth()->user();
                                                    $initials = $user
                                                        ? strtoupper(
                                                            substr($user->name, 0, 1) .
                                                                (isset(explode(' ', $user->name)[1])
                                                                    ? substr(explode(' ', $user->name)[1], 0, 1)
                                                                    : ''),
                                                        )
                                                        : '';
                                                @endphp
                                                
                                                <li class="nav-item">
                                                    <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle">
														
															<span class="admin-name">{{ optional(auth()->user())->name }}</span>
															<i class="fa fa-angle-down edu-icon edu-down-arrow"></i>
														</a>
                                                    <ul role="menu" class="dropdown-header-top author-log dropdown-menu animated zoomIn">
                                                      
                                                        <li><a href="{{ route('logout') }}"><span class="edu-icon edu-locked author-log-ic"></span>Log Out</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                             
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu start -->
            <div class="mobile-menu-area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="mobile-menu">
                                <nav id="dropdown">
                                    <ul class="mobile-menu-nav">
                                       
                                        <li><a href="{{ route('index') }}">Dashboard</a></li>
                                        <li><a href="{{ route('dashboard') }}">Website List</a></li>
                                        <li><a href="{{ route('download') }}">Download Plugins</a></li>
                                       
                                        
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu end -->
        
        </div>
		
		