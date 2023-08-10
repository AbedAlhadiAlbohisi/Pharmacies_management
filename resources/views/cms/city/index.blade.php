@extends('cms.parent')
@section('title',__('cms.dashbord'))
@section('page_name',__('cms.indexcity'))
@section('main_name',__('cms.creates'))
@section('small_page_name',__('cms.creatuser'))
@section('small_page_admin',__('cms.createadmin'))
@section('style')

@endsection

@section('main-content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title ">{{(__('cms.city'))}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10px">{{__('cms.#')}}</th>
                                    <th>{{(__('cms.name_en'))}}</th>
                                    <th>{{(__('cms.name_ar'))}}</th>
                                    <th style="width: 15px">{{(__('cms.active'))}}</th>
                                    <th>{{(__('cms.updated_at'))}}</th>
                                    <th>{{(__('cms.created_at'))}}</th>
                                    <th style="width: 15px">{{(__('cms.setting'))}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($Citys as $city)
                                    <td>{{$loop->index + 1 ?? ''}}</td>
                                    <td>{{$city->name_en}}</td>
                                    <td>{{$city->name_ar}}</td>
                                    <td> <span
                                            class="badge @if ($city->active) bg-success @else bg-danger @endif">{{$city->active_status
                                            }}</span>
                                    </td>
                                    <td>{{$city->updated_at->diffForHumans()}}</td>
                                    <td>{{$city->created_at->diffForHumans()}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{route('cities.edit',[$city->id])}}" class="btn btn-success">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                          


                                        </div>
                                    </td>


                                </tr>
                                @endforeach
                                <tr>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">

                    </div>
                </div>

                <!-- /.card -->
            </div>


        </div><!-- /.container-fluid -->
</section>

@endsection


@section('script')

@endsection
