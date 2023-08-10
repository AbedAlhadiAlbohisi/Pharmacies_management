@extends('cms.parent')
@section('title',__('cms.dashbord'))
@section('page_name',__('cms.create order'))
@section('main_name',__('cms.create order'))
@section('small_page_name',__('cms.create order'))
@section('small_page_admin',__('cms.create admin'))

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
                        <h3 class="card-title">{{(__('cms.create order'))}}</h3>
                    </div>

                    <form id="forme_rest">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>{{__('cms.pharmacist')}}</label>
                                <select class="form-control pharmacist" style="width: 100%;" id="pharmacist_id">
                                    @foreach ($pharmacists as $pharmacist)
                                    <option value="{{$pharmacist->id}}">{{$pharmacist->name}}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="totle">الكمية:</label>
                                <input type="number" class="form-control" id="totle" name="totle"
                                    oninput="updatePrice()">
                            </div>

                            <div class="form-group">
                                <label>{{__('cms.Pharmaceutical')}}</label>
                                <select class="form-control citys" style="width: 100%;" id="Pharmaceutical_id">
                                    @foreach ($pharmaceuticals as $pharmaceuticals)
                                    <option value="{{$pharmaceuticals->id}}">{{$pharmaceuticals->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{__('cms.user')}}</label>
                                <select class="form-control citys" style="width: 100%;" id="user_id">
                                    @foreach ($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="price">{{(__('cms.price'))}}:</label>
                                <span class="form-control" id="price">{{$order->price}}</span>
                            </div>

                            <div class="form-group">
                                <label for="location">{{(__('cms.location'))}}</label>
                                <input type="text" class="form-control @if($errors->any()) is-invalid @endif "
                                    id="location" name="location" placeholder="{{__('cms.location')}}"
                                    value="{{$order->location}}">
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
    $('#Pharmaceutical_id').on('change',function(){
        if(this.value != -1){
            getsubcategories(this.value);
        }else{
         controlFormstatus(true);
        }
    });

    function getsubcategories(categoryId) {
        axios.get('/cms/admin/pharmaceuticals/' + categoryId)
            .then(function(response) {
              var  pricePerUnit = response.data.data.price; // تحديث قيمة المتغير pricePerUnit
                updatePrice(pricePerUnit); // استدعاء الدالة updatePrice() بعد تحديث القيمة
            })
            .catch(function(error) {
            });
    } // تعريف المتغير في النطاق العام ليكون متاحاً للدالة updatePrice()
    function updatePrice(pricePerUnit) {
        var citySelect = document.getElementById("Pharmaceutical_id");
        var selectedOption = citySelect.options[citySelect.selectedIndex];
        var quantity = document.getElementById("totle").value;

         totalPrice = quantity * pricePerUnit;
        document.getElementById("price").innerText = totalPrice;
    }

    
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
        formData.append('totle',document.getElementById('totle').value);
        formData.append('pharmacist_id',document.getElementById('pharmacist_id').value);
        formData.append('user_id',document.getElementById('user_id').value);
        formData.append('Pharmaceutical_id',document.getElementById('Pharmaceutical_id').value);
        formData.append('price',document.getElementById('price').value);
        formData.append('location',document.getElementById('location').value);
        formData.append('image',document.getElementById('image_file').files[0]);
        axios.post('/cms/admin/orders', formData)
        .then(function (response) {
            toastr.success(response.data.message);
            window.location.href='/cms/admin/orders'
            document.getElementById('forme_rest').reset();
        })
        .catch(function (error) {
            toastr.error(error.response.data.message);
        });
    }



//

</script>

@endsection