<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link href="{{ asset('dashboard/assets/images/logoporlempika.png') }}" rel="icon">
    <!--plugins-->
    <link href="{{ asset('dashboard/assets/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('dashboard/assets/css/perfect-scrollbar.css') }}" rel="stylesheet" />


    <link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <!-- loader-->
    <!-- Pace CSS & JS -->
    <link href="{{ asset('dashboard/assets/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('dashboard/assets/js/pace.min.js') }}"></script>

    <!-- Bootstrap CSS -->
    <link href="{{ asset('dashboard/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/assets/css/bootstrap-extended.css') }}" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    <!-- App CSS -->
    <link href="{{ asset('dashboard/assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('dashboard/assets/css/icons.css') }}" rel="stylesheet">

    {{-- link awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <title>SignUp-Porlempika</title>
</head>

<body class="bg-theme bg-theme2">
    <!--wrapper-->
    <div class="wrapper">
        <div class="d-flex align-items-center justify-content-center my-5">
            <div class="container-fluid">
                <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                    <div class="col mx-auto">
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="p-4">
                                    <div class="mb-3 text-center">
                                        <img src="{{ asset('dashboard/assets/images/logoporlempika.png') }}"
                                            class="logo-icon" alt="logo icon" width="60">
                                    </div>
                                    <div class="text-center mb-4">
                                        <h5 class="">Porlempika Admin</h5>
                                        <p class="mb-0">Please fill the below details to create your account</p>
                                    </div>

                                    @if ($errors->any())
                                        <div
                                            style="background-color: #d4edda; color: #ff0000; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    @if (session('success'))
                                        <div
                                            style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    <div class="form-body">
                                        <form class="row g-3" method="POST"
                                            action="{{ route('authentikasi.register.post') }}">
                                            @csrf

                                            <div class="col-12">
                                                <label for="name" class="form-label">Nama</label>
                                                <input type="text" class="form-control" name="name" id="name"
                                                    placeholder="Zahadi Rizfy">
                                            </div>

                                            <div class="col-12">
                                                <label for="phone_number" class="form-label">Nomor HP</label>
                                                <input type="number" class="form-control" name="phone_number"
                                                    id="phone_number" placeholder="0822****3862">
                                            </div>

                                            <div class="col-12">
                                                <label for="inputEmailAddress" class="form-label">Email Address</label>
                                                <input type="email" class="form-control" name="email"
                                                    id="inputEmailAddress" placeholder="porlempika@gmail.com">
                                            </div>
                                            <div class="col-12">
                                                <label for="inputChoosePassword" class="form-label">Password</label>
                                                <div class="input-group" id="show_hide_password">
                                                    <input type="password" class="form-control border-end-0"
                                                        name="password" id="inputChoosePassword"
                                                        placeholder="Enter Password"> <a href="javascript:;"
                                                        class="input-group-text bg-transparent"><i
                                                            class='bx bx-hide'></i></a>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label for="inputConfirmPassword" class="form-label">Confirm
                                                    Password</label>
                                                <div class="input-group" id="show_hide_password">
                                                    <input type="password" class="form-control border-end-0"
                                                        name="password_confirmation" id="inputChoosePassword"
                                                        placeholder="Enter Password">
                                                    <a href="javascript:;" class="input-group-text bg-transparent"><i
                                                            class='bx bx-hide'></i></a>
                                                </div>
                                            </div>


                                            <div class="col-12">
                                                <label for="inputSelectCountry" class="form-label">Register as</label>
                                                <select class="form-select" name="role" id="inputSelectCountry"
                                                    aria-label="Default select example">
                                                    <option value="atlet">Atlet</option>
                                                    <option value="juri">Juri</option>
                                                    <option value="penyelenggara">Penyelenggara Event</option>
                                                    <option value="klub">Klub</option>
                                                    <option value="anggota">Anggota</option>
                                                </select>
                                            </div>

                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-light">Sign up</button>
                                                </div>
                                            </div>


                                            <div class="col-12">
                                                <div>
                                                    <span>*setelah mengisi data dan sebelum klik button signup, silahkan
                                                        di screenshoot, kemudian dikirim ke wa admin</span>
                                                    <!-- Button WhatsApp -->
                                                    <a href="https://wa.me/6282170657217" target="_blank">
                                                        <div class=""><i class='bx bxl-whatsapp'></i> admin</div>
                                                    </a>

                                                </div>
                                            </div>


                                            <div class="col-12">
                                                <div class="text-center ">
                                                    <p class="mb-0">Already have an account? <a
                                                            href="{{ route('login') }}">Sign in here</a>
                                                    </p>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
    </div>
    <!--end wrapper-->

    <!-- Bootstrap JS -->
    <!-- Bootstrap Bundle JS -->
    <script src="{{ asset('dashboard/assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- jQuery -->
    <script src="{{ asset('dashboard/assets/js/jquery.min.js') }}"></script>

    <!-- Password show & hide js -->
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
            }), $(".close-switcher").on("click", function() {
                $(".switcher-wrapper").removeClass("switcher-toggled")
            }),


            $('#theme1').click(theme1);
        $('#theme2').click(theme2);
        $('#theme3').click(theme3);
        $('#theme4').click(theme4);
        $('#theme5').click(theme5);
        $('#theme6').click(theme6);
        $('#theme7').click(theme7);
        $('#theme8').click(theme8);
        $('#theme9').click(theme9);
        $('#theme10').click(theme10);
        $('#theme11').click(theme11);
        $('#theme12').click(theme12);
        $('#theme13').click(theme13);
        $('#theme14').click(theme14);
        $('#theme15').click(theme15);

        function theme1() {
            $('body').attr('class', 'bg-theme bg-theme1');
        }

        function theme2() {
            $('body').attr('class', 'bg-theme bg-theme2');
        }

        function theme3() {
            $('body').attr('class', 'bg-theme bg-theme3');
        }

        function theme4() {
            $('body').attr('class', 'bg-theme bg-theme4');
        }

        function theme5() {
            $('body').attr('class', 'bg-theme bg-theme5');
        }

        function theme6() {
            $('body').attr('class', 'bg-theme bg-theme6');
        }

        function theme7() {
            $('body').attr('class', 'bg-theme bg-theme7');
        }

        function theme8() {
            $('body').attr('class', 'bg-theme bg-theme8');
        }

        function theme9() {
            $('body').attr('class', 'bg-theme bg-theme9');
        }

        function theme10() {
            $('body').attr('class', 'bg-theme bg-theme10');
        }

        function theme11() {
            $('body').attr('class', 'bg-theme bg-theme11');
        }

        function theme12() {
            $('body').attr('class', 'bg-theme bg-theme12');
        }

        function theme13() {
            $('body').attr('class', 'bg-theme bg-theme13');
        }

        function theme14() {
            $('body').attr('class', 'bg-theme bg-theme14');
        }

        function theme15() {
            $('body').attr('class', 'bg-theme bg-theme15');
        }
    </script>
</body>

</html>
