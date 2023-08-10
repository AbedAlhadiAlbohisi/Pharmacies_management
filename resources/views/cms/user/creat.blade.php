@extends('cms.parent')
@section('title',__('cms.dashbord'))
@section('page_name',__('cms.cresate'))
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
                        <h3 class="card-title">{{(__('cms.cresate'))}}</h3>
                    </div>

                    <form id="forme_rest">

                        @csrf
                        <div class="card-body">



                            <div class="form-group">
                                <label for="name">{{(__('cms.name'))}}</label>
                                <input type="text" class="form-control @if($errors->any()) is-invalid @endif " id="name"
                                    name="name" placeholder="{{__('cms.name')}}" value="{{old('name')}}">
                            </div>


                            <div class="form-group">
                                <label>{{__('cms.roles')}}</label>
                                <select class="form-control roles" style="width: 100%;" id="role_id">
                                    <option>اختر مما يلي </option>
                                    @foreach ($roles as $role)
                                    <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="email">{{(__('cms.emaill'))}}</label>
                                <input type="email" class="form-control @if($errors->any()) is-invalid @endif "
                                    id="email" name="email" placeholder="{{__('cms.emaill')}}" value="{{old('email')}}">
                            </div>

                            <div class="form-group">
                                <label>{{__('cms.city')}}</label>
                                <select class="form-control citys" style="width: 100%;" id="city_id">
                                    <option>اختر مما يلي </option>
                                    @foreach ($citys as $citys)
                                    <option value="{{$citys->id}}">{{$citys->name_en}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="phone">{{(__('cms.phone'))}}</label>
                                <input type="number" class="form-control @if($errors->any()) is-invalid @endif "
                                    id="phoneNumper" name="phone" placeholder="{{__('cms.phone')}}"
                                    value="{{old('phone')}}">
                            </div>

                            <div class="form-group">
                                <label for="password">{{(__('cms.password'))}}</label>
                                <input type="password" class="form-control @if($errors->any()) is-invalid @endif "
                                    id="password" name="password" placeholder="{{__('cms.password')}}"
                                    value="{{old('password')}}">
                            </div>


                            <div class="form-group">
                                <label for="age">{{(__('cms.age'))}}</label>
                                <input type="number" class="form-control @if($errors->any()) is-invalid @endif "
                                    id="age" name="age" placeholder="{{__('cms.age')}}" value="{{old('age')}}">
                            </div>


                            <div class="form-group">
                                <label>{{__('cms.gender')}}</label>
                                <select class="form-control gender" style="width: 100%;" id="gender">
                                    <option>اختر مما يلي </option>
                                    <option value="M">{{__('cms.male')}}</option>
                                    <option value="F">{{__('cms.female')}}</option>
                                </select>
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

                        </div>
                        <div class="card-footer">
                            <button type="button" onclick="performstore()"
                                class="btn btn-primary">{{__('cms.send')}}</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
</section>
@endsection
@section('script')
<script src="{{asset('cms/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('cms/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<script>
    $(function () {
  bsCustomFileInput.init();
                    });
</script>
<script>
    $('.citys').select2({
        theme: 'bootstrap4'
    });
    $('.gender').select2({
        theme: 'bootstrap4'
    })

    function performstore(){
        let formData=new FormData ();
        formData.append('name',document.getElementById('name').value);
        formData.append('role_id',document.getElementById('role_id').value);
        formData.append('email',document.getElementById('email').value);
        formData.append('city_id',document.getElementById('city_id').value);
        formData.append('phoneNumper',document.getElementById('phoneNumper').value);
        formData.append('age',document.getElementById('age').value);
        formData.append('gender',document.getElementById('gender').value);
        formData.append('password',document.getElementById('password').value);
        formData.append('image',document.getElementById('image_file').files[0]);
        axios.post('/cms/admin/users', formData)
        .then(function (response) {
            toastr.success(response.data.message);
            document.getElementById('forme_rest').reset();
        })
        .catch(function (error) {
            toastr.error(error.response.data.message);
        });
    }



//

</script>

@endsection