@extends('cms.parent')
@section('title',__('cms.dashbord'))
@section('page_name',__('create delivery'))
@section('main_name',__('cms.creates'))
@section('small_page_name',__('cms.cresate'))
@section('small_page_admin',__('cms.create delivery'))
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
                        <h3 class="card-title">{{(__('create delivery'))}}</h3>
                    </div>

                    <form id="forme_rest">
                        @csrf
                        <div class="card-body">

                            <div class="form-group">
                                <label>{{__('cms.Pharmaceutical')}}</label>
                                <select class="form-control roles" style="width: 100%;" id="pharmacists">
                                    @foreach ($pharmacists as $pharmacist)
                                        <option value="{{$pharmacist->id}}">{{$pharmacist->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="name">{{(__('cms.name'))}}</label>
                                <input type="text" class="form-control @if($errors->any()) is-invalid @endif " id="name"
                                    name="name" placeholder="{{__('cms.name')}}" value="{{old('name')}}">
                            </div>

                            <div class="form-group">
                                <label for="email">{{(__('cms.email'))}}</label>
                                <input type="email" class="form-control @if($errors->any()) is-invalid @endif "
                                    id="email" name="email" placeholder="{{__('cms.email')}}" value="{{old('email')}}">
                            </div>
                            <div class="form-group">
                                <label for="password">{{(__('cms.password'))}}</label>
                                <input type="password" class="form-control @if($errors->any()) is-invalid @endif "
                                    id="password" name="password" placeholder="{{__('cms.password')}}"
                                    value="{{old('password')}}">
                            </div>
                            <div class="form-group">
                                <label for="phone">{{(__('cms.phone'))}}</label>
                                <input type="phone" class="form-control @if($errors->any()) is-invalid @endif "
                                    id="phone" name="phone" placeholder="{{__('cms.phone')}}" value="{{old('phone')}}">
                            </div>
                            <div class="form-group">
                                <label for="TypeVehicle">{{(__('cms.TypeVehicle'))}}</label>
                                <input type="TypeVehicle" class="form-control @if($errors->any()) is-invalid @endif "
                                    id="TypeVehicle" name="TypeVehicle" placeholder="{{__('cms.TypeVehicle')}}"
                                    value="{{old('TypeVehicle')}}">
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


<script>
    function performstore(){
        let formData=new FormData ();
        formData.append('pharmacists',document.getElementById('pharmacists').value);
        formData.append('name',document.getElementById('name').value);
        formData.append('email',document.getElementById('email').value);
        formData.append('password',document.getElementById('password').value);
        formData.append('phone',document.getElementById('phone').value);
        formData.append('TypeVehicle',document.getElementById('TypeVehicle').value);

        axios.post('/cms/admin/deliveries', formData)
        .then(function (response) {
            console.log(response);
      toastr.success(response.data.message);
      document.getElementById('forme_rest').reset();
        })
        .catch(function (error) {
            console.log(error);
      toastr.error(error.response.data.message);
        });
    }



//

</script>

@endsection
