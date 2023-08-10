@extends('cms.parent')
@section('title',__('cms.dashbord'))
@section('main-content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">

            @can('Read-AllAdmin')
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{$admins}}</h3>
                        <p>{{__('cms.admintotells')}}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{route('admins.index')}}" class="small-box-footer">{{__('cms.More_info')}} <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endcan



            <!-- ./col -->
            @can('Read-AllUser')
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{$users}}<sup style="font-size: 20px"></sup></h3>

                        <p>{{__('cms.usertotells')}}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{route('users.index')}}" class="small-box-footer">{{__('cms.More_info')}} <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endcan


            <!-- ./col -->
            @can('Read-AllPharmacist')
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{$pharmacist}}</h3>

                        <p>{{__('cms.Pharmacist')}}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{route('pharmacists.index')}}" class="small-box-footer">{{__('cms.More_info')}} <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endcan


            <!-- ./col -->
            @can('Read-AllPharmaceutical')
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{$pharmaceuticals}}</h3>

                        <p>{{__('cms.Pharmaceutical')}}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="{{route('pharmaceuticals.index')}}" class="small-box-footer">{{__('cms.More_info')}} <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endcan
            <!-- ./col -->


            <!-- ./col -->
            @can('Read-AllCities')
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{$cities}}<sup style="font-size: 20px"></sup></h3>

                        <p>{{__('cms.city')}}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{route('cities.index')}}" class="small-box-footer">{{__('cms.More_info')}} <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            @endcan
        </div>
</section>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>

                        <p class="card-text">
                            Some quick example text to build on the card title and make up the bulk of the card's
                            content.
                        </p>

                        <a href="#" class="card-link">Card link</a>
                        <a href="#" class="card-link">Another link</a>
                    </div>
                </div>

                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>

                        <p class="card-text">
                            Some quick example text to build on the card title and make up the bulk of the card's
                            content.
                        </p>
                        <a href="#" class="card-link">Card link</a>
                        <a href="#" class="card-link">Another link</a>
                    </div>
                </div><!-- /.card -->
            </div>
            <!-- /.col-md-6 -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="m-0">Featured</h5>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title">Special title treatment</h6>

                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>

                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h5 class="m-0">Featured</h5>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title">Special title treatment</h6>

                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection