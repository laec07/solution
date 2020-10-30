@extends('layouts.app')

@section('content')
 <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">

          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

<div class="container-fluid">
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$count_envio}}</h3>

                <p>Guías sin repeción</p>
              </div>
              <div class="icon">
                <i class="ion ion-android-list"></i>
              </div>
              <a href="{{url('enviosrecepcion')}}" class="small-box-footer">Más Info. <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><sup style="font-size: 20px"></sup>{{$count_pendientesasg}}</h3>

                <p>Guías sin asignar</p>
              </div>
              <div class="icon">
                <i class="ion ion-ios-compose"></i>
              </div>
              <a href="{{url('asignacionguias')}}" class="small-box-footer">Más Info. <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><sup style="font-size: 20px"></sup>{{$count_liq}}</h3>

                <p>Liquidaciones sin cierre</p>
              </div>
              <div class="icon">
                <i class="ion ion-cash"></i>
              </div>
              <a href="{{url('depositos')}}" class="small-box-footer">Más Info. <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{$count_pendientesent}}</h3>

                <p>Entregas pendientes</p>
              </div>
              <div class="icon">
                <i class="ion ion-android-bicycle"></i>
              </div>
              <a href="#" onclick="EntregasPendientes()" class="small-box-footer">Más Info. <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->	
</div>
<div id="show_datas" ></div>
@endsection

@section('scripts')
<script>
function EntregasPendientes() {

  $.ajax({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    type:'GET',
    url:"{{ route('administrador.show','id') }}",
    data:{},
    success:function(data){
      $("#show_datas").html(data);

    }
  })
}
</script>
@endsection