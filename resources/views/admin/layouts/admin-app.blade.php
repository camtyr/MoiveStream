<!doctype html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield("title", config("app.name"))</title>
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset("admin_assets/plugins/fontawesome-free/css/all.min.css")}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset("admin_assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css")}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset("admin_assets/dist/css/adminlte.min.css")}}">

    <link href="{{asset("assets/css/bootstrap.css")}}" rel="stylesheet">
    @yield("styles")
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

    <body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-dark">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <div class="brand-link">
                    <img src="{{asset("assets/images/defaults/default_thumb.jpg")}}" alt="MovieStream" class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light">Movie Stream</span>
                </div>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="{{asset("assets/images/defaults/default_user.jpg")}}" class="img-circle elevation-2" alt="User Image">
                        </div>
                        <div class="info">
                            <span class="d-block">{{ ucfirst(auth()->user()->name) }}</span>
                            <a href="{{ route("admin.logout") }}"><i class="nav-icon fas fa-solid fa-door-open"> Logout</i></a>
                        </div>
                    </div>

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item">
                                <a href="{{ route("admin.dashboard") }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-solid fa-home"></i>
                                    <p>Dashboard</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route("genre.index") }}" class="nav-link {{ request()->routeIs('genre.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-solid fa-th"></i>
                                    <p>Genre</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route("movie.index") }}" class="nav-link {{ request()->routeIs('movie.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-solid fa-film"></i>
                                    <p>Movie</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route("episode.index") }}" class="nav-link {{ request()->routeIs('episode.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-solid fa-plus-square"></i>
                                    <p>Episode</p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
                @endif

                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">@yield("title")</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Dashboard v2</li>
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <section class="content">
                    @yield("content")
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->

            <!-- Main Footer -->
            <footer class="main-footer">
            </footer>
        </div>
        <!-- ./wrapper -->

        <!-- REQUIRED SCRIPTS -->
        <!-- jQuery -->
        <script src="{{asset("admin_assets/plugins/jquery/jquery.min.js")}}"></script>
        <!-- Bootstrap -->
        <script src="{{asset("admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
        <!-- overlayScrollbars -->
        <script src="{{asset("admin_assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js")}}"></script>
        <!-- AdminLTE App -->
        <script src="{{asset("admin_assets/dist/js/adminlte.js")}}"></script>

        <!-- PAGE PLUGINS -->
        <!-- jQuery Mapael -->
        <script src="{{asset("admin_assets/plugins/jquery-mousewheel/jquery.mousewheel.js")}}"></script>
        <script src="{{asset("admin_assets/plugins/raphael/raphael.min.js")}}"></script>
        <script src="{{asset("admin_assets/plugins/jquery-mapael/jquery.mapael.min.js")}}"></script>
        <script src="{{asset("admin_assets/plugins/jquery-mapael/maps/usa_states.min.js")}}"></script>
        <!-- ChartJS -->
        <script src="{{asset("admin_assets/plugins/chart.js/Chart.min.js")}}"></script>

        @yield("scripts")
    </body>

</html>