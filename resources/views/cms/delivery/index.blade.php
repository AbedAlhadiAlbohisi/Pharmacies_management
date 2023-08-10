@extends('cms.parent')
@section('title',__('cms.Delivery'))
@section('page_name',__('cms.Delivery'))
@section('main_name',__('cms.Delivery'))
@section('small_page_name',__('cms.creat Delivery'))
@section('small_page_admin',__('cms.create Delivery'))
@section('style')

@endsection
@section('style')
<link rel="stylesheet" href="{{asset('cms/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('cms/plugins/toastr/toastr.min.css')}}">
@endsection
@section('main-content')

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title ">{{(__('cms.Delivery'))}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10px">{{__('cms.#')}}</th>
                                    <th>{{(__('cms.name'))}}</th>
                                    <th>{{(__('cms.email'))}}</th>
                                    <th>{{(__('cms.phone'))}}</th>
                                    <th>{{(__('cms.TypeVehicle'))}}</th>
                                    <th>{{(__('cms.pharmacists'))}}</th>
                                    <th>{{(__('cms.created_at'))}}</th>
                                    @canany(['Update-Delivery', 'Delete-Delivery'])
                                        <th style="width: 15px">{{(__('cms.setting'))}}</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($data as $delivery)
                                    <td>{{$loop->index + 1 ?? ''}}</td>

                                    <td>{{$delivery->name ?? ''}}</td>
                                    <td>{{$delivery->email ?? ''}}</td>
                                    <td>{{$delivery->phone ?? ''}}</td>
                                    <td>{{$delivery->TypeVehicle ?? ''}}</td>
                                    <td>{{$delivery->pharmacists->name ?? ''}}</td>
                                    <td>{{$delivery->created_at->diffForHumans()}}</td>
                                    @canany(['Update-Delivery', 'Delete-Delivery'])
                                        <td>
                                            <div class="btn-group">
                                                @can('Update-Delivery')
                                                    <a href="{{route('deliveries.edit',[$delivery->id])}}" class="btn btn-success">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endcan

                                                @can('Delete-Delivery')
                                                    <a href="#" onclick="comforme('{{$delivery->id}}',this)" class="btn btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                @endcan

                                                </form>
                                            </div>
                                        </td>
                                    @endcanany


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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('cms/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="{{asset('cms/plugins/toastr/toastr.min.js')}}"></script>
<script>
    function  comforme(id, element){

        Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
        if (result.isConfirmed) {
            performdtore(id, element)
        }
        })


         function performdtore(id,element){
        axios.delete('/cms/admin/deliveries/'+id )
            .then(function (response) {
                    console.log(response);
                    toastr.success(response.data.message);
                    element.closest('tr').remove();
                 });
                 window.location.href = '/cms/admin/deliveries'
         .catch(function (error) {
                    console.log(error);
                    toastr.error(error.response.data.message);
                });
        }



    }


</script>
@endsection
