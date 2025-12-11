<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link href="{{ asset('dashboard/assets/images/logoporlempika.png') }}" rel="icon">
    <!-- loader-->
    <link href="{{ asset('dashboard/assets/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('dashboard/assets/js/pace.min.js') }}"></script>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('dashboard/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{ asset('dashboard/assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/assets/css/icons.css') }}" rel="stylesheet">
    <title>Porlempika - Lupa Password</title>
</head>

<body class="bg-theme bg-theme2">
    <!-- wrapper -->
    <div class="wrapper">
        <div class="authentication-forgot d-flex align-items-center justify-content-center">
            <div class="card forgot-box">
                <div class="card-body">
                    <div class="p-3">
                        <div class="text-center">

                            <img src= "{{ asset('dashboard/assets/images/lupa-2.png') }}" width="100"
                                alt="" />
                        </div>
                        <h4 class="mt-5 font-weight-bold">Lupa Password?</h4>
                        <p class="mb-0">Masukkan email dan nomor hp untuk mereset password</p>
                        <form action="{{ route('password.handle') }}" method="POST">
                            @csrf
                            <div class="my-4">
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

                            <div class="my-4">
                                <label for="phone_number" class="form-label">Nomor hp</label>
                                <input type="number" class="form-control" id="phone_number" name="phone"
                                    placeholder="0822****3862" required>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-white">Kirim</button>
                                <a href="{{ route('login') }}" class="btn btn-light"><i
                                        class='bx bx-arrow-back me-1'></i>Back to Login</a>
                            </div>

                        </form>

                        <div class="mt-3">
                            <h5>
                        @if ($errors->any())
                            <div style="color:red;">
                                {{ $errors->first() }}
                            </div>
                        @endif
                        </h5>
                        </div>

                        @if (isset($resetLink))
                            <div>
                                <a href="{{ $resetLink }}">Klik di sini untuk reset password</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end wrapper -->
    <!--plugins-->
    <script src="assets/js/jquery.min.js"></script>
</body>
</html>


