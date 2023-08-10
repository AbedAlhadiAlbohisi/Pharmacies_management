@extends('cms.parent')
@section('title',__('cms.dashbord'))
@section('page_name',__('cms.update_permission'))
@section('main_name',__('cms.creates'))
@section('small_page_name',__('cms.cresate'))
@section('small_page_admin',__('cms.createadmin'))

@section('style')
<link rel="stylesheet" href="{{asset('cms/plugins/select2/css/select2.min.css')}}">

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
                        <h3 class="card-title">{{(__('cms.update_permission'))}}</h3>
                    </div>

                        <form>

                            @csrf
                            <div class="card-body">



                       <div class="form-group">
                            <label for="name">{{(__('cms.name'))}}</label>
                            <input type="text" class="form-control @if($errors->any()) is-invalid @endif "  id="name"
                            name="name" placeholder="{{__('cms.name')}}" value="{{$permission->name}}">
                        </div>
                        <div class="form-group">
                            <label>{{__('cms.roles')}}</label>
                            <select class="form-control usertype" style="width: 100%;" id="guard_name">
                                <option value="admin" @if($permission->guard_name=='admin') selected @endif >{{__('cms.admin')}}</option>
                                <option value="user"  @if($permission->guard_name=='user') selected @endif>{{__('cms.user')}}</option>

                            </select>
                        </div>

                        </div>
                        <div class="card-footer">
                            <button type="button" onclick="performupdate()"
                            class="btn btn-primary">{{__('cms.sends')}}</button>
                        </div>

                    </form>
                </div>

           </div>
    </div>
</section>
@endsection
@section('script')
<script src="{{asset('cms/plugins/select2/js/select2.full.min.js')}}"></script>


<script>
    $('.guard_name').select2({
        theme: 'bootstrap4'
    });


    function performupdate(){
        axios.put('/cms/admin/permissions/{{$permission->id}}', {
            name: document.getElementById('name').value,
            guard_name: document.getElementById('guard_name').value,
        })
        .then(function (response) {
            console.log(response);
      toastr.success(response.data.message);
      window.location.href='/cms/admin/permissions'
        })
        .catch(function (error) {
            console.log(error);
      toastr.error(error.response.data.message);
        });
    }



//

</script>

@endsection
