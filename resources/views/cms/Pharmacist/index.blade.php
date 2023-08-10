@extends('cms.parent')
@section('title',__('cms.pharmacist'))
@section('page_name',__('cms.pharmacist'))
@section('main_name',__('cms.creates'))
@section('small_page_name',__('cms.creatpharmacist'))
@section('small_page_admin',__('cms.createpharmacist'))
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
                        <h3 class="card-title ">{{(__('cms.pharmacist'))}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10px">{{__('cms.#')}}</th>
                                    <th>{{(__('cms.image'))}}</th>
                                    <th>{{(__('cms.name'))}}</th>
                                    <th>{{(__('cms.email'))}}</th>
                                    <th>{{(__('cms.phone'))}}</th>
                                    <th>{{(__('cms.location'))}}</th>
                                    <th>{{(__('cms.namepharmacy'))}}</th>
                                    <th>{{(__('cms.blocked'))}}</th>
                                    <th>{{(__('cms.created_at'))}}</th>
                                    @canany(['Update-Pharmacist','Delete-Pharmacist'])
                                        <th style="width: 15px">{{(__('cms.setting'))}}</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach ($data as $pharmacist)
                                    <td>{{$loop->index + 1 ?? ''}}</td>
                                    <td>
                                        <span>
                                            <img class="round" src="{{Storage::url($pharmacist->image)}}" alt="avatar" height="60" width="60"></span>
                                    </td>
                                    <td>{{$pharmacist->name ?? ''}}</td>
                                    <td>{{$pharmacist->email ?? ''}}</td>
                                    <td>{{$pharmacist->phone ?? ''}}</td>
                                    <td>{{$pharmacist->location ?? ''}}</td>
                                    <td>{{$pharmacist->namepharmacy ?? ''}}</td>
                                    <td>
                                        <span
                                            class="badge @if ($pharmacist->blocked)bg-danger @else bg-success @endif">{{$pharmacist->active_status }}
                                        </span>
                                    </td>
                                    <td>{{$pharmacist->created_at->diffForHumans()}}</td>

                                    @canany(['Update-Pharmacist','Delete-Pharmacist'])
                                        <td>
                                            <div class="btn-group">
                                                @can('Update-Pharmacist')
                                                    <a href="{{route('pharmacists.edit',[$pharmacist->id])}}" class="btn btn-success">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endcan

                                                @can('Delete-Pharmacist')
                                                    <a href="#" onclick="comforme('{{$pharmacist->id}}',this)" class="btn btn-danger">
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
        axios.delete('/cms/admin/pharmacists/'+id )
            .then(function (response) {
                    console.log(response);
                    toastr.success(response.data.message);
                    element.closest('tr').remove();
                 });
                 window.location.href = '/cms/admin/pharmacists'
         .catch(function (error) {
                    console.log(error);
                    toastr.error(error.response.data.message);
                });
        }



    }


</script>
@endsection
