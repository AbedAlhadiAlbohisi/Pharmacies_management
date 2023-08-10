@extends('cms.parent')
@section('title',__('cms.roles'))
@section('page_name',__('cms.roles'))
@section('main_name',__('cms.roles'))
@section('small_page_name',__('cms.cresate'))
@section('small_page_admin',__('cms.createadmin'))

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
                        <h3 class="card-title ">{{(__('cms.roles'))}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10px">{{__('cms.#')}}</th>
                                    <th>{{(__('cms.name'))}}</th>
                                    <th>{{(__('cms.usertype'))}}</th>
                                    <th>{{(__('cms.permissions'))}}</th>
                                    <th>{{(__('cms.updated_at'))}}</th>
                                    {{-- <th>{{(__('cms.created_at'))}}</th> --}}
                                    <th style="width: 15px">{{(__('cms.setting'))}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($roles as $role)
                                    <td>{{$loop->index + 1 ?? ''}}</td>
                                    <td>{{$role->name}}</td>
                                    <td> <span class="badge bg-info ">{{$role->guard_name }}</span></td>
                                    <td>
                                        <a href="{{route('roles.show',$role->id)}}" class="btn btn-app bg-info">
                                            <span class="badge bg-danger">{{$role->permissions_count}}</span>
                                            <i class="fas fa-heart"></i> {{(__('cms.permissions'))}}
                                        </a>
                                    </td>
                                    {{-- <td>{{$role->created_at->diffForHumans()}}</td> --}}
                                    <td>{{$role->updated_at->diffForHumans()}}</td>


                                    <td>
                                        <div class="btn-group">
                                            <a href="{{route('roles.edit',[$role->id])}}" class="btn btn-success">
                                                <i class="fas fa-edit"></i>
                                            </a>



                                            <a href="#" onclick="comforme('{{$role->id}}',this)" class="btn btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </a>

                                            </form>
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
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('cms/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="{{asset('cms/plugins/toastr/toastr.min.js')}}"></script>
<script>
    function  comforme(id, element){
       Swal.fire({
        title: "{{__('cms.Are you sure?')}}",
        text: "{{__('cms.Youwon')}}",
        icon: 'warning',
        // showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "{{__('cms.Yes')}}"
        }).then((result) => {
        if (result.isConfirmed) {
        performdtore(id, element)
        }
        })
         function performdtore(id,element){
        axios.delete('/cms/admin/roles/'+id )
            .then(function (response) {
                    console.log(response);
                    toastr.success(response.data.message);
                    element.closest('tr').remove();

                 })
         .catch(function (error) {
                    console.log(error);
                    toastr.error(error.response.data.message);
                });
        }



    }


</script>
@endsection
