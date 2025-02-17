<?php
    $user = Auth::user();
    $user = json_encode($user);
    //$siteurl = 'http://localhost/migration/granamericasusme.co';
    $siteurl = 'http://www.granamericasusme.co';
    $endpoint = $siteurl.'/laravelinterface/middleware_auth.php';
    $endpoint = $endpoint."?token=".base64_encode($user);
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Laravel SB Admin 2">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">


    <!-- Favicon -->
    <link href="{{ asset('img/favicon.png') }}" rel="icon" type="image/png">
    <link href="{{ asset('vendor/datatables/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="//cdn.datatables.net/searchpanes/2.3.2/css/searchPanes.dataTables.css" rel="stylesheet">
    <link href="//cdn.datatables.net/select/2.0.5/css/select.dataTables.css" rel="stylesheet">
    

    <link href="{{ asset('css/custom.css') }}?cache=<?php echo( uniqid() ); ?>" rel="stylesheet">

    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('vendor/ckeditor/adapters/jquery.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        hr.sidebar-divider.d-none.d-md-block {
            margin-top: 14px !important;
        }
    </style>

</head>
<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon">
                <img style="height:80px;" src="/img/logo_big.jpg" >
            </div>
           <div class="sidebar-brand-text mx-1">Service Tool</div>
        </a>
        @if(Auth::user()->type == 1)
            <hr class="sidebar-divider d-none d-md-block">
            <li class="nav-item {{ Nav::isRoute('companies') }}">
                <a class="nav-link" href="{{ route('companies.index') }}">
                    <i class="fas fa-fw fa-building"></i>
                    <span>{{ __('Compañías') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('systems.index') }}">
                    <i class="fas fa-fw fa-desktop"></i>
                    <span>{{ __('Sistemas') }}</span>
                </a>
            </li>
               <li class="nav-item">
                    <a class="nav-link" href="{{ route('forms.index') }}">
                        <i class="fas fa-fw fa-th-list"></i>
                        <span>{{ __('Formularios') }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('fields.index') }}">
                        <i class="fas fa-fw fa-grip-lines"></i>
                        <span>{{ __('Campos') }}</span>
                    </a>
                </li>
        @endif
        @if(Auth::user()->type == 1 || Auth::user()->type == 5  || Auth::user()->type == 6)
            <li class="nav-item">
                <a class="nav-link" href="/users/all">
                    <i class="fas fa-chart-pie"></i>
                    <span>{{ __('Resumen') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('users.index') }}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>{{ __('Usuarios') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('registers.index') }}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>{{ __('Registros') }}</span>
                </a>
            </li>
        @endif
        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">
                    <div class="topbar-divider d-none d-sm-block"></div>
                    <!--<UserMenu>-->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }} | {{ Auth::user()->store }}</span>
                            <figure class="img-profile rounded-circle avatar font-weight-bold" data-initial="{{ Auth::user()->name[0] }}"></figure>
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('profile') }}"">
                                <i class="fas fa-user-edit fa-sm fa-fw mr-2 text-gray-400"></i>
                                {{ __('Mi perfil') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                {{ __('Salir') }}
                            </a>
                        </div>
                    </li>
                    <!--</UserMenu>-->
                </ul>

            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                @yield('main-content')

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy;</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Ready to Leave?') }}</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-link" type="button" data-dismiss="modal">{{ __('Cancel') }}</button>
                <a class="btn btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->

<script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

<script type="text/javascript" src="//cdn.datatables.net/2.1.5/js/dataTables.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/searchpanes/2.3.2/js/dataTables.searchPanes.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/searchpanes/2.3.2/js/searchPanes.dataTables.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/plug-ins/preview/searchPane/dataTables.searchPane.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/select/2.0.5/js/dataTables.select.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/select/2.0.5/js/select.dataTables.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>


<script src="{{ asset('js/core/utils/DataTablesUtils.js?cache=') }}{{ uniqid(); }}"></script>
<script src="{{ asset('js/core/utils/Translator.js') }}?cache={{uniqid()}}"></script>
<script src="{{ asset('js/core/utils/FiltersUtils.js') }}?cache={{uniqid()}}"></script>
<script src="{{ asset('js/core/utils/ReportBuilder.js') }}?cache=1E"></script>
<script src="{{ asset('js/core/views/CreateFieldView.js') }}"></script>
<script src="{{ asset('js/core/views/Registers.js?cache=') }}{{ uniqid(); }}"></script>
<script src="{{ asset('js/core/views/UserProfile.js?cache=') }}{{ uniqid(); }}"></script>
<script src="{{ asset('js/core/views/ProfileModalView.js?cache=') }}{{ uniqid(); }}"></script>
<script src="{{ asset('js/core/modules/PurchasePlanning.js') }}"></script>
</body>
</html>
