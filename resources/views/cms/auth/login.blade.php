<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{__('cms.app_namelogin')}}</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('cms/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('cms/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('cms/plugins/toastr/toastr.min.css')}}">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block "><img style="width: 500px; Height:500px"
                                    src="{{asset('cms/dist/img/تعليق توضيحي 2023-06-01 182049.png')}}"></div>

                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4" style="width: 300px; Height:30px">
                                            {{__('cms.app_name')}}</h1>
                                    </div>
                                    <form>
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" id="email"
                                                aria-describedby="emailHelp" placeholder="Enter Email Address...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="password"
                                                placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="remember">
                                                <label class="custom-control-label"
                                                    for="remember">{{__('cms.remember')}}</label>
                                            </div>

                                            <div>
                                                <button type="button" onclick="performstore()"
                                                    class="btn btn-primary btn-user btn-block">{{__('cms.login')}}</button>
                                            </div>



                                        </div>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="#">{{__('cms.Forgot')}}</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('cms/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('cms/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('cms/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('cms/js/sb-admin-2.min.js')}}"></script>
    <script src="https://unpkg.com/axios@0.27.2/dist/axios.min.js"></script>
    <script src="{{asset('cms/plugins/toastr/toastr.min.js')}}"></script>
    <script>
        function performstore(){
        axios.post('/cms/login', {
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
            remember: document.getElementById('remember').checked,
        })
        .then(function (response) {
            console.log(response);
            window.location.href = '/cms/admin',
            toastr.success(response.data.message);
        })
        .catch(function (error) {
            console.log(error);
            toastr.error(error.response.data.message);
        });
    }
    </script>
</body>