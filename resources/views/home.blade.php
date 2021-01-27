@extends('layouts.master')
@section('content')
<!-- Main content -->
<section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$waarmeking}}</h3>

              <p>Waarmeking</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-copy-outline"></i>
            </div>
            <a href="{{route('waarmeking')}}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$covernot}}</h3>

              <p>Covernot</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-copy-outline"></i>
            </div>
            <a href="{{route('covernot')}}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{$legalisasi}}</h3>

              <p>Legalisasi</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-copy-outline"></i>
            </div>
            <a href="{{route('legalisasi')}}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{$aktaNotaris}}</h3>

              <p>Akta Notaris</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-copy-outline"></i>
            </div>
            <a href="{{route('akta-notaris')}}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$aktaJaminanFidusia}}</h3>

              <p>Akta Jaminan Fidusia</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-copy-outline"></i>
            </div>
            <a href="{{route('akta-jaminan-fidusia')}}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$tandaTerimav2}}</h3>

              <p>Tanda Terima</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-copy-outline"></i>
            </div>
            <a href="{{route('tandaterima')}}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{$ppat}}</h3>

              <p>PPAT</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-copy-outline"></i>
            </div>
            <a href="{{route('ppat')}}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{$kwitansi}}</h3>

              <p>Kwitansi</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-copy-outline"></i>
            </div>
            <a href="{{route('kwitansi')}}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$reporforium}}</h3>

              <p>Reporforium</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-copy-outline"></i>
            </div>
            <a href="{{route('reporforium')}}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$user}}</h3>

              <p>User</p>
            </div>
            <div class="icon">
              <i class="ion ion-android-person"></i>
            </div>
            <a href="{{route('user')}}" class="small-box-footer">Detail <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
</section>
@endsection