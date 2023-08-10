@extends('cms.parent')
@section('title',__('cms.dashbord'))
@section('page_name',__('cms.updatapharmaceutical'))
@section('main_name',__('cms.pharmaceutical'))
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
                        <h3 class="card-title">{{(__('cms.updata pharmaceutical'))}}</h3>
                    </div>

                    <form id="forme_rest">

                        @csrf
                        <div class="card-body">



                            <div class="form-group">
                                <label for="name">{{(__('cms.name'))}}</label>
                                <input type="text" class="form-control @if($errors->any()) is-invalid @endif " id="name"
                                    name="name" placeholder="{{__('cms.name')}}" value="{{$pharmaceutical->name}}">
                            </div>


                            <div class="form-group">
                                <label for="price">{{(__('cms.price'))}}</label>
                                <input type="price" class="form-control @if($errors->any()) is-invalid @endif "
                                    id="price" name="price" placeholder="{{__('cms.price')}}"
                                    value="{{$pharmaceutical->price}}">
                            </div>

                            <div class="form-group">
                                <label>content</label>
                                <textarea id="content" class="form-control" rows="3"
                                    placeholder="Enter ...">{{$pharmaceutical->content}}</textarea>
                            </div>

                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" name="active" id="active"
                                    @checked($pharmaceutical->active)>
                                <label class="custom-control-label" for="active">{{(__('cms.active'))}}</label>
                            </div>


                            <div class="form-group">
                                <label for="image_file">Image</label>
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
        formData.append('name',document.getElementById('name').value);
        formData.append('price',document.getElementById('price').value);
        formData.append('active',document.getElementById('active').checked?1:0);
        formData.append('content',document.getElementById('content').value);
        if(document.getElementById('image_file').files[0] != undefined){
        formData.append('image',document.getElementById('image_file').files[0]);
        }
        axios.post('/cms/admin/pharmaceuticals/{{$pharmaceutical->id}}', formData)
        .then(function (response) {
            console.log(response);
      toastr.success(response.data.message);
            window.location.href='/cms/admin/pharmaceuticals'
        })
        .catch(function (error) {
            console.log(error);
      toastr.error(error.response.data.message);
        });
    }





//

</script>

@endsection