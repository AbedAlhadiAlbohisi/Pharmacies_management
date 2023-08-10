@extends('cms.parent')
@section('title',__('cms.users'))
@section('page_name',__('cms.indexuser'))
@section('main_name',__('cms.creates'))
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
                        <h3 class="card-title ">{{(__('cms.users'))}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10px">{{__('cms.#')}}</th>
                                    <th>{{__('cms.image')}}</th>
                                    <th>{{(__('cms.name'))}}</th>
                                    <th>{{(__('cms.roles'))}}</th>
                                    <th>{{(__('cms.email'))}}</th>
                                    <th>{{(__('cms.age'))}}</th>
                                    <th>{{(__('cms.phone'))}}</th>
                                    <th>{{__('cms.city')}}</th>
                                    {{-- <th>حاله الحساب</th> --}}
                                    <th style="width: 15px">{{(__('cms.setting'))}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($user as $user)
                                    <td>{{$loop->index + 1}}</td>
                                    <td><img width="60" height="60" src="{{Storage::url($user->image)}}"></td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->roles[0]->name ?? ''}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->age}}</td>
                                    <td>{{$user->phone}}</td>
                                    <td>{{$user->city->name_en ?? ''}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{route('users.edit',[$user->id])}}" class="btn btn-success">
                                                <i class="fas fa-edit"></i>
                                            </a>



                                            <a href="#" onclick="comforme('{{$user->id}}',this)" class="btn btn-danger">
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
        axios.delete('/cms/admin/users/'+id )
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