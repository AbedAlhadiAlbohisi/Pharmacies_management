@extends('cms.parent')
@section('title',__('cms.dashbord'))
@section('page_name',__('cms.create cite'))
@section('main_name',__('cms.create cite'))
@section('small_page_name',__('cms.creatuser'))
@section('small_page_admin',__('cms.createadmin'))
@section('style')

@endsection
@section('main-content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{(__('cms.create cite'))}}</h3>
                    </div>
                    <!-- /.card-header -->
                    {{-- رسالة الخطأ --}}
                    <!-- form start -->


                    <!-- form start -->
                    <form method="POST" action="{{route('cities.store')}}">
                        @csrf
                        <div class="card-body">
                            @if($errors->any())
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-exclamation-triangle"></i> {{__('cms.error')}}!</h5>
                                <ul>
                                    @foreach ($errors->all() as $error )
                                    <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            {{-- رسالة النجاح --}}
                            @if(session()->has('message'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h5><i class="icon fas fa-check"></i> {{__('cms.successfully')}}!</h5>
                                {{session('message')}}
                            </div>
                            @endif
                            <div class="form-group">
                                <label for="name_en_input">{{(__('cms.name_ar'))}}</label>
                                <input type="text" class="form-control @if($errors->any()) is-invalid @endif "
                                    id="name_en_input" name="name_en" placeholder="{{(__('cms.name_ar'))}}"
                                    value="{{old('')}}">
                            </div>


                            <div class="form-group">
                                <label for="name_ar_input">{{(__('cms.name_en'))}}</label>
                                <input type="text" class="form-control @if($errors->any()) is-invalid @endif "
                                    id="name_ar_input" name="name_ar" placeholder="{{(__('cms.name_en'))}}"
                                    value="{{old('name_ar')}}">
                            </div>





                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" name="active" id="active_chickbox">
                                <label class="custom-control-label" for="active_chickbox">{{(__('cms.active'))}}</label>
                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">{{(__('cms.send'))}}</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
</section>
@endsection
@section('script')

@endsection