@extends('cms.parent')
@section('title',__('cms.dashbord'))
@section('page_name',__('cms.pharmacist'))
@section('main_name',__('cms.pharmacist'))
@section('small_page_name',__('cms.cresate'))
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
                        <h3 class="card-title">{{(__('cms.updata pharmacist'))}}</h3>
                    </div>

                    <form id="forme_rest">

                        @csrf
                        <div class="card-body">

                            <div class="form-group">
                                <label>{{__('cms.roles')}}</label>
                                <select class="form-control roles" style="width: 100%;" id="role_id">
                                    <option>اختر مما يلي </option>
                                    @foreach ($roles as $role)
                                    <option value="{{$role->id}}" @selected($role->id == $adminRole->id ??
                                        '')>{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="name">{{(__('cms.name'))}}</label>
                                <input type="text" class="form-control @if($errors->any()) is-invalid @endif " id="name"
                                    name="name" placeholder="{{__('cms.name')}}" value="{{$Pharmacist->name}}">
                            </div>

                            <div class="form-group">
                                <label for="email">{{(__('cms.email'))}}</label>
                                <input type="email" class="form-control @if($errors->any()) is-invalid @endif "
                                    id="email" name="email" placeholder="{{__('cms.email')}}"
                                    value="{{$Pharmacist->email}}">
                            </div>

                            <div class="form-group">
                                <label for="name">{{(__('cms.location'))}}</label>
                                <input type="text" class="form-control @if($errors->any()) is-invalid @endif "
                                    id="location" name="location" placeholder="{{__('cms.location')}}"
                                    value="{{$Pharmacist->location}}">
                            </div>

                            <div class="form-group">
                                <label for="namepharmacy">{{(__('cms.namepharmacy'))}}</label>
                                <input type="namepharmacy" class="form-control @if($errors->any()) is-invalid @endif "
                                    id="namepharmacy" name="namepharmacy" placeholder="{{__('cms.namepharmacy')}}"
                                    value="{{$Pharmacist->namepharmacy}}">
                            </div>


                            <div class="form-group">
                                <label for="phone">{{(__('cms.phone'))}}</label>
                                <input type="phone" class="form-control @if($errors->any()) is-invalid @endif "
                                    id="phone" name="phone" placeholder="{{__('cms.phone')}}"
                                    value="{{$Pharmacist->phone}}">
                            </div>

                            <div class="form-group">
                                <label for="image_file">{{__('cms.image')}}</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image_file">
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Upload</span>
                                    </div>
                                </div>
                            </div>

                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" name="blocked" id="blocked"
                                    @checked($Pharmacist->blocked)>
                                <label class="custom-control-label" for="blocked">{{(__('cms.blocked'))}}</label>
                            </div>




                        </div>


                </div>
                <div class="card-footer">
                    <button type="button" onclick="performupdate()" class="btn btn-primary">{{__('cms.sends')}}</button>
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
    $('.Roles').select2({
        theme: 'bootstrap4'
    });
        function performupdate(){
        let formData=new FormData ();
        formData.append('_method','PUT');
        formData.append('role_id',document.getElementById('role_id').value);
        formData.append('name',document.getElementById('name').value);
        formData.append('email',document.getElementById('email').value);
        formData.append('phone',document.getElementById('phone').value);
        formData.append('location',document.getElementById('location').value);
        formData.append('blocked',document.getElementById('blocked').checked?1:0);
        formData.append('namepharmacy',document.getElementById('namepharmacy').value);
        if(document.getElementById('image_file').files[0] != undefined){
            formData.append('image',document.getElementById('image_file').files[0]);
        }
        axios.post('/cms/admin/pharmacists/{{$Pharmacist->id}}', formData)
        .then(function (response) {
            console.log(response);
      toastr.success(response.data.message);
            window.location.href='/cms/admin/pharmacists'
        })
        .catch(function (error) {
            console.log(error);
      toastr.error(error.response.data.message);
        });
    }





//

</script>

@endsection