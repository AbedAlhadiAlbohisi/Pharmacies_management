<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{__('cms.SB Admin 2 - Forgot Password')}}</title>

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
                   <div class="col-lg-6 d-none d-lg-block "><img style="width: 450px; Height:450px"
                                       src="{{asset('cms/dist/img/logo3.jpeg')}}"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">{{__('cms.Forgot Your Password?')}}</h1>
                                        <p class="mb-4">{{__('cms.passwordtype')}}</p>
                                    </div>
                                    <form class="user">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                             aria-describedby="emailHelp"
                                                placeholder="{{__('cms.Enter Email Address...')}}"  id="email">
                                        </div>
                                        <button   type="button" onclick="performForgotpassword()" href="login.html"   class="btn btn-primary btn-user btn-block">
                                            {{__('cms.sendem')}}
                                        </button>
                                    </form>
                                    <hr>
                                    {{-- <div class="text-center">
                                        <a class="small" href="register.html">Create an Account!</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="login.html">Already have an account? Login!</a>
                                    </div> --}}
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
        function performForgotpassword(){
            axios.post('/cms/forgot-password', {
                email: document.getElementById('email').value,

            })
            .then(function (response) {
                console.log(response);
                toastr.success(response.data.message);
                // window.location.href = '/cms/admin'
            })
            .catch(function (error) {
                console.log(error);
                toastr.error(error.response.data.message);
            });
        }
    </script>

</body>

</html>
