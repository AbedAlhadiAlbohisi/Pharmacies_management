@extends('cms.parent')
@section('title',__('cms.dashbord'))
@section('page_name',__('cms.Delivery'))
@section('main_name',__('cms.Delivery'))
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
                        <h3 class="card-title">{{(__('cms.updata Delivery'))}}</h3>
                    </div>

                    <form id="forme_rest">

                        @csrf
                        <div class="card-body">

                            <div class="form-group">
                                <label>{{__('cms.Pharmaceutical')}}</label>
                                <select class="form-control roles" style="width: 100%;" id="pharmacists">
                                    <option value="-1">اختر مما يلي</option>
                                    @foreach ($pharmacists as $pharmacist)
                                    <option value="{{$pharmacist->id}}" @selected($pharmacist->id == $Delivery->pharmacist_id)>{{$pharmacist->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="name">{{(__('cms.name'))}}</label>
                                <input type="text" class="form-control @if($errors->any()) is-invalid @endif " id="name"
                                    name="name" placeholder="{{__('cms.name')}}" value="{{$Delivery->name}}">
                            </div>

                            <div class="form-group">
                                <label for="email">{{(__('cms.email'))}}</label>
                                <input type="email" class="form-control @if($errors->any()) is-invalid @endif "
                                    id="email" name="email" placeholder="{{__('cms.email')}}"
                                    value="{{$Delivery->email}}">
                            </div>

                            <div class="form-group">
                                <label for="TypeVehicle">{{(__('cms.TypeVehicle'))}}</label>
                                <input type="text" class="form-control @if($errors->any()) is-invalid @endif "
                                    id="TypeVehicle" name="TypeVehicle" placeholder="{{__('cms.TypeVehicle')}}"
                                    value="{{$Delivery->TypeVehicle}}">
                            </div>
                            <div class="form-group">
                                <label for="phone">{{(__('cms.phone'))}}</label>
                                <input type="phone" class="form-control @if($errors->any()) is-invalid @endif "
                                    id="phone" name="phone" placeholder="{{__('cms.phone')}}"
                                    value="{{$Delivery->phone}}">
                            </div>

                            {{-- <div class="form-group">
                                <label for="password">{{(__('cms.password'))}}</label>
                                <input type="password" class="form-control @if($errors->any()) is-invalid @endif "
                                    id="password" name="password" placeholder="{{__('cms.password')}}"
                                    value="{{old('password')}}">
                            </div> --}}




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
        formData.append('pharmacists',document.getElementById('pharmacists').value);
        formData.append('name',document.getElementById('name').value);
        formData.append('email',document.getElementById('email').value);
        formData.append('phone',document.getElementById('phone').value);
        formData.append('TypeVehicle',document.getElementById('TypeVehicle').value);
        axios.post('/cms/admin/deliveries/{{$Delivery->id}}', formData)
        .then(function (response) {
            console.log(response);
      toastr.success(response.data.message);
            window.location.href='/cms/admin/deliveries'
        })
        .catch(function (error) {
            console.log(error);
      toastr.error(error.response.data.message);
        });
    }





//

</script>

@endsection
