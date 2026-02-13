<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>National Forensics Agency | Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-success ">
            <div class="card-header text-center">
                {{-- <a href="{{ url('/dashboard') }}" class="brand-link "> --}}
                    <img src="{{ asset('img/NFA-logo.svg') }}" alt="NFA Logo" {{--
                        class=" brand-image elevation-3 my-logo-class" --}} style="opacity: .9;">
                    {{-- <span class="brand-text font-weight-light text-dark">NFA Portal</span> --}}
                    {{-- </a> --}}
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                @if(session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ session('success') }}
                </div>
                @endif

                @if(session('info'))
                <div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ session('info') }}
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif


                <form action="{{ url('/login') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" name="email"
                            value="{{ old('email') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                   <div class="input-group mb-3">
    <input type="password" class="form-control" placeholder="Password" name="password" id="password">
    <div class="input-group-append">
        <div class="input-group-text" style="cursor: pointer;" onclick="togglePassword()">
            <span class="fas fa-eye" id="toggleIcon"></span>
        </div>
    </div>
</div>

                    <div class="row">
                        <div class="col-8">
                            <div class="mb-3">
                                <div class="g-recaptcha" data-sitekey="6LdvsVksAAAAANmZeMW8av0KOkm4TLpGSa6Tw_jH">
                                </div>
                            </div>


                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn my-btn-color btn-primary btn-block">
                                Sign In
                            </button>
                        </div>

                    </div>
                </form>
                <!-- /.social-auth-links -->

                <p class="mb-1">
                    {{-- <a href="forgot-password.html">I forgot my password</a> --}}
                </p>
                <p class="mb-0">
                    <a href="{{ route('register') }}" class="text-center my-text-color">Register a new account</a>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
</body>
<script>
    function togglePassword() {
        const password = document.getElementById("password");
        const icon = document.getElementById("toggleIcon");

        if (password.type === "password") {
            password.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            password.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
</script>

</html>