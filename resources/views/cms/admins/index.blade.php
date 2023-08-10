@extends('cms.parent')
@section('title',__('cms.admins'))
@section('page_name',__('cms.adminindex'))
@section('main_name',__('cms.creates'))
@section('small_page_name',__('cms.creatuser'))
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
                        <h3 class="card-title ">{{(__('cms.admins'))}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10px">{{__('cms.#')}}</th>
                                    <th>{{(__('cms.image'))}}</th>
                                    <th>{{(__('cms.name'))}}</th>
                                    <th>{{(__('cms.emaill'))}}</th>
                                    <th>{{(__('cms.city'))}}</th>
                                    <th>{{(__('cms.roles'))}}</th>
                                    <th>{{(__('cms.phone'))}}</th>
                                    <th>{{(__('cms.created_at'))}}</th>
                                    <th style="width: 15px">{{(__('cms.setting'))}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($data as $admins)
                                    <td>{{$loop->index + 1 ?? ''}}</td>
                                    <td>
                                        <span>
                                            <img class="round" src="{{Storage::url($admins->image)}}" alt="avatar"
                                                height="60" width="60"></span>
                                    </td>
                                    <td>{{$admins->name ?? ''}}</td>
                                    <td>{{$admins->email ?? ''}}</td>
                                    <td>{{$admins->cities->name_ar ?? ''}}</td>
                                    <td>{{$admins->roles[0]->name ?? ''}}</td>
                                    <td>{{$admins->phone ?? ''}}</td>
                                    <td>{{$admins->created_at->diffForHumans()}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{route('admins.edit',[$admins->id])}}" class="btn btn-success">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                                @if (auth('admin')->user()->id !=$admins->id)
                                                    <a href="#" onclick="comforme('{{$admins->id}}',this)"
                                                        class="btn btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                @endif
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
        axios.delete('/cms/admin/admins/'+id )
            .then(function (response) {
                    console.log(response);
                    toastr.success(response.data.message);
                    element.closest('tr').remove();
                 });
                 window.location.href = '/cms/admin/admins'
         .catch(function (error) {
                    console.log(error);
                    toastr.error(error.response.data.message);
                });
        }



    }


</script>
@endsection
