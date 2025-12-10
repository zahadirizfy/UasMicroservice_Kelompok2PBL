<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('dashboard/assets/images/logoporlempika.png') }}" rel="icon">
    <link href="{{ asset('dashboard/assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('dashboard/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('dashboard/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dashboard/assets/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('dashboard/assets/js/pace.min.js') }}"></script>
    <link href="{{ asset('dashboard/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{ asset('dashboard/assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/assets/css/icons.css') }}" rel="stylesheet">
    <title>Login - Porlempika</title>
</head>

<body class="bg-theme bg-theme2">
    <div class="wrapper">
        <div class="section-authentication-cover">
            <div class="row g-0">
                <div
                    class="col-12 col-xl-7 col-xxl-8 auth-cover-left align-items-center justify-content-center d-none d-xl-flex">
                    <div class="card shadow-none bg-transparent shadow-none rounded-0 mb-0">
                        <div class="card-body">
                            <img src="{{ asset('dashboard/assets/images/login-images/login-cover.svg') }}"
                                class="img-fluid auth-img-cover-login" width="650" alt="" />
                        </div>
                    </div>
                </div>
                <div
                    class="col-12 col-xl-5 col-xxl-4 auth-cover-right bg-light align-items-center justify-content-center">
                    <div class="card rounded-0 m-3 shadow-none bg-transparent mb-0">
                        <div class="card-body p-sm-5">
                            <div class="text-center mb-4">
                                <img src="{{ asset('dashboard/assets/images/logoporlempika.png') }}" class="logo-icon"
                                    alt="logo icon" width="60">
                                <h5 class="">Porlempika Admin</h5>
                                <p class="mb-0">Please log in to your account</p>
                            </div>

                            @if (session('status'))
                                <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
                                    {{ session('status') }}
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="alert alert-success"
                                    style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
                                    {{ session('success') }}
                                </div>
                            @endif


                            <!-- Form login -->
                            <form method="POST" action="{{ route('login.process') }}" class="row g-3">
                                @csrf

                                <!-- Email Input -->
                                <div class="col-12">
                                    <label for="inputEmailAddress" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="inputEmailAddress" name="email" placeholder="Porlempika@gmail.com"
                                        value="{{ old('email') }}" required autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Password Input -->
                                <div class="col-12">
                                    <label for="inputChoosePassword" class="form-label">Password</label>
                                    <div class="input-group" id="show_hide_password">
                                        <input type="password"
                                            class="form-control border-end-0 @error('password') is-invalid @enderror"
                                            id="inputChoosePassword" name="password" placeholder="Enter Password"
                                            required>
                                        <a href="javascript:;" class="input-group-text bg-transparent"><i
                                                class="bx bx-hide"></i></a>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Remember Me -->
                                <div class="col-md-6">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked">
                                        <label class="form-check-label" for="flexSwitchCheckChecked">Remember Me</label>
                                    </div>
                                </div>
                                <div class="col-md-6 text-end">
                                    <a href="{{ route('password.request') }}">Forgot Password?</a>
                                </div>


                                <!-- Submit Button -->
                                <div class="col-12">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-light">Sign in</button>
                                    </div>
                                </div>

                                <!-- Sign Up Link -->
                                <div class="col-12">
                                    <div class="text-center">
                                        <p class="mb-0">Don't have an account yet? <a
                                                href="{{ route('authentikasi.register') }}">Sign up here</a></p>
                                    </div>
                                </div>
                            </form>
                            <!-- End Form login -->
                        </div>
                    </div>
                </div>
            </div><!--end row-->
        </div>
    </div><!--end wrapper-->

    <script src="{{ asset('dashboard/assets/js/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bx-hide");
                    $('#show_hide_password i').removeClass("bx-show");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bx-hide");
                    $('#show_hide_password i').addClass("bx-show");
                }
            });
        });
    </script>

    <script>
        $(".switcher-btn").on("click", function() {
            $(".switcher-wrapper").toggleClass("switcher-toggled")
        });
        $(".close-switcher").on("click", function() {
            $(".switcher-wrapper").removeClass("switcher-toggled")
        });
    </script>
</body>

</html>
