<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Solution EXPRESS</title>

    <!-- Scripts -->

   <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>-->
<script src="{{ asset('js/app.js') }}" defer></script>
   <script src=" {{ asset('jquery/dist/jquery.min.js') }} " ></script>

    <script src="{{ asset('dist/js/adminlte.js')}}"></script>
    


    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">

    <!-- alertas sweet -->
    
    <script src="{{ asset('sweetalert2/sweetalert2.js')}}"></script>

  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

    <!-- Styles -->
    <link href="{{ asset('dist/css/adminlte.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/checkbox.css') }}" rel="stylesheet">



</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div id="app">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

<!--
    Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>

        </a>

      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <!--<span class="badge badge-warning navbar-badge">15</span> -->
        </a>

      </li>
      <li class="nav-item">
        <a class="nav-link"  title="Salir" onclick="event.preventDefault();
                                           document.getElementById('logout-form').submit();" role="button"><i class="fa fa-power-off" aria-hidden="true" ></i></a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
      <img src="{{asset('dist/img/SolutionExpLogo.png')}}" alt="SolutionExpress" class="brand-image img-circle elevation-3"
           >
      <span class="brand-text font-weight-light">SolutionExpress</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <a href="#" class="d-block">
            @guest
            <a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar Sesión') }}</a>
            @else
            <div class="image">
            @if(Auth::user()->imagen!="")  
                <img src=" {{ asset('imagenes/'.Auth::user()->imagen) }} " class="img-circle elevation-2" alt="User Image">
            @else
                 <img src=" {{ asset('dist/img/usuario.png') }} " class="img-circle elevation-2" alt="User Image">
             @endif               
            </div>
            {{ Auth::user()->name }}



            @endguest
        </a>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        @can('administrador')
        <li class="nav-item">
            <a href="{{url('administrador')}}" class="{{ Request::path() === 'administrador' ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard Admin
                
              </p>
            </a>
          </li>
          @endcan

        @can('administrador')
        <li class="nav-item">
            <a href="{{url('enviosoficina')}}" class="{{ Request::path() === 'enviosoficina' ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fa fa-shopping-bag"></i>
              <p>
                Generación de envíos
              </p>
            </a>
          </li>
          @endcan

        @can('administrador')
        <li class="nav-item">
            <a href="{{url('enviosrecepcion')}}" class="{{ Request::path() === 'enviosrecepcion' ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fas fa-concierge-bell"></i>
              <p>
                Recepción envíos
              </p>
            </a>
          </li>
          @endcan

        @can('pendiente')
        <li class="nav-item">
            <a href="{{url('enviosasignacion')}}" class="{{ Request::path() === 'enviosasignacion' ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fa fa-id-card"></i>
              <p>
                Asignación envíos
              </p>
            </a>
          </li>
          @endcan

        @can('administrador')
        <li class="nav-item">
            <a href="{{url('asignacionguias')}}" class="{{ Request::path() === 'asignacionguias' ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fa fa-id-card"></i>
              <p>
                Asignación de guías
              </p>
            </a>
          </li>
          @endcan

        @can('pendiente')
        <li class="nav-item">
            <a href="{{url('liquidaciones')}}" class="{{ Request::path() === 'liquidaciones' ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fa fa-money-bill-alt"></i>
              <p>
                Liquidación por envíos
              </p>
            </a>
          </li>
          @endcan

        @can('administrador')
        <li class="nav-item">
            <a href="{{url('liquidacionespiloto')}}" class="{{ Request::path() === 'liquidacionespiloto' ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fa fa-money-bill-alt"></i>
              <p>
                Liquidación por piloto
              </p>
            </a>
          </li>
          @endcan

        @can('administrador')
        <li class="nav-item">
            <a href="{{url('liquidacionclientes')}}" class="{{ Request::path() === 'liquidacionclientes' ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fa fa-money-bill-alt"></i>
              <p>
                Liquidación por Clientes
              </p>
            </a>
          </li>
          @endcan

        @can('administrador')
        <li class="nav-item">
            <a href="{{url('depositos')}}" class="{{ Request::path() === 'depositos' ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fa fa-money-bill-alt"></i>
              <p>
                Depósitos
              </p>
            </a>
          </li>
          @endcan

          @can('administrador')
          <li class="{{ Request::is('reportgeneral','rastreador')   ? 'nav-item menu-open' : 'nav-item has-treeview' }}  ">
            <a href="#" class="nav-link  ">
              <i class="nav-icon fas fa-chart-bar"></i>  
              <p>
                Reportes
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

          <li class="nav-item">
            <a href="{{url('reportgeneral')}}" class="{{ Request::path() === 'reportgeneral' ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fas fa-bars"></i>
              <p>
                General
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('rastreador')}}" class="{{ Request::path() === 'rastreador' ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fas fa-location-arrow"></i>
              <p>
                Rastradeor de guías
              </p>
            </a>
          </li>
            </ul>
          </li>
          @endcan

          @can('administrador')
          <li class="{{ Request::is('clientes','rutas','tarifas','cuentaclientes') ? 'nav-item menu-open' : 'nav-item has-treeview' }}  ">
            <a href="#" class="nav-link  ">
              <i class="fas fa-wrench"></i>
              <p>
                Mantenimiento
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

          <li class="nav-item">
            <a href="{{url('clientes')}}" class="{{ Request::path() === 'clientes' ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Clientes
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('cuentaclientes')}}" class="{{ Request::path() === 'cuentaclientes' ? 'nav-link active' : 'nav-link' }}">
              <i class="fas fa-university"></i>
              <p>
                Cuentas - Clientes
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('rutas')}}" class="{{ Request::path() === 'rutas' ? 'nav-link active' : 'nav-link' }}">
              <i class="fas fa-route"></i>
              <p>
                Rutas
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('tarifas')}}" class="{{ Request::path() === 'tarifas' ? 'nav-link active' : 'nav-link' }}">
              <i class="fas fa-hand-holding-usd"></i>
              <p>
                Tarifas
              </p>
            </a>
          </li>
            </ul>
          </li>
          @endcan

          @can('administrador')
          <li class="{{ Request::is('usuarios','usuarios/*/edit', 'usuarios/create'  )? 'nav-item menu-open' : 'nav-item has-treeview' }}  ">
            <a href="#" class="nav-link  ">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Configuración
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

          <li class="nav-item">
            <a href="{{url('usuarios')}}" class="{{ Request::is('usuarios','usuarios/*/edit','usuarios/create'  )  ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Usuarios
              </p>
            </a>
          </li>
            </ul>
          </li>
          @endcan




        @can('mensajero')
        <li class="nav-item">
            <a href="{{url('mensajero')}}" class="{{ Request::path() === 'mensajero' ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard mensajero
                
              </p>
            </a>
          </li>
          @endcan

        @can('mensajero')
        <li class="nav-item">
            <a href="{{url('envios')}}" class="{{ Request::path() === 'envios' ? 'nav-link active' : 'nav-link' }}">
              <i class="nav-icon fa fa-shopping-bag"></i>
              <p>
                Envíos
              </p>
            </a>
          </li>
          @endcan

        @can('mensajero')
        <li class="nav-item">
            <a href="{{url('revision')}}" class="{{ Request::path() === 'revision' ? 'nav-link active' : 'nav-link' }}">
              <i class="fas fa-check"></i>
              <p>
                Revisión
              </p>
            </a>
          </li>
          @endcan


        @can('mensajero')
        <li class="nav-item">
            <a href="{{url('entregas')}}" class="{{ Request::path() === 'entregas' ? 'nav-link active' : 'nav-link' }}">
              <i class="fas fa-shipping-fast"></i>
              <p>
                Entregas
              </p>
            </a>
          </li>
          @endcan



          <!--
          <li class="nav-item has-treeview ">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Active Page</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inactive Page</p>
                </a>
              </li>
            </ul>
          </li>
          -->

<!--
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Simple Link
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
-->
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">


    <!-- Main content -->
    <div class="content">
      @yield('content')
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      V1.0
    </div>
    <!-- Default to the left -->
    <strong>&copy;  <a href="http://stik502.com/">Eztranet</a>.</strong> 2020
  </footer>
</div>
<!-- ./wrapper -->




</div>
  @include('sweetalert::alert')
  @yield('scripts')
</body>
</html>

