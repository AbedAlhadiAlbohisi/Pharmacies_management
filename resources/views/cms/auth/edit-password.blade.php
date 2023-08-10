@extends('cms.parent')
@section('title',__('cms.dashbord'))
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
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{(__('cms.edit-password'))}}</h3>
                    </div>
                    <!-- /.card-header -->
                                        <!-- form start -->


                    <!-- form start -->
                        <form>
                            @csrf
                            <div class="card-body">

                       <div class="form-group">
                            <label for="current_password">{{(__('cms.current_password'))}}</label>
                            <input type="password" class="form-control" id="current_password"
                                placeholder="{{(__('cms.current_password'))}}">
                        </div>


                           <div
                           class="form-group">
                            <label for="new_password">{{(__('cms.new_password'))}}</label>
                            <input type="password" class="form-control " id="new_password"
                           placeholder="{{(__('cms.new_password'))}}"  >
                        </div>


                        <div class="form-group">
                            <label for="new_password_confirmation">{{(__('cms.new_password_confirmation'))}}</label>
                            <input type="password" class="form-control" id="new_password_confirmation"
                                placeholder="{{(__('cms.new_password_confirmation'))}}" >
                        </div>






                        </div>
                        <div class="card-footer">
                            <button type="button" onclick="performupdatepassword()" class="btn btn-primary">{{(__('cms.ubdate'))}}</button>
                        </div>
                    </form>
                </div>

           </div>
    </div>
</section>
@endsection
@section('script')
<script>
    function performupdatepassword(){
        axios.post('/cms/admin/update-password', {
            password: document.getElementById('current_password').value,
            new_password: document.getElementById('new_password').value,
            new_password_confirmation: document.getElementById('new_password_confirmation').value,
        })
        .then(function (response) {
            console.log(response);
            toastr.success(response.data.message);
        })
        .catch(function (error) {
            console.log(error);
            toastr.error(error.response.data.message);
        });
    }
</script>
@endsection
