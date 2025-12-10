<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link href="{{ asset('dashboard/assets/images/logoporlempika.png') }}" rel="icon">

    <!-- Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('dashboard/assets/plugins/simplebar/css/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/plugins/metismenu/css/metisMenu.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}">

    <!-- Loader CSS -->
    {{-- <link rel="stylesheet" href="{{ asset('dashboard/assets/css/pace.min.css') }}">
    <script src="{{ asset('dashboard/assets/js/pace.min.js') }}"></script> --}}

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/bootstrap-extended.css') }}">

    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap">

    <!-- Main App CSS -->
    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/icons.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css"> --}}


    <style>
        .foto-hover.enlarged {
            transform: scale(5);
            /* bisa disesuaikan */
            z-index: 999;
            position: relative;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.7);

        }

        #typing-text {
            border-right: 2px solid black;
            white-space: nowrap;
            overflow: hidden;
            animation: blink-caret 0.75s step-end infinite;
        }

        @keyframes blink-caret {

            from,
            to {
                border-color: transparent;
            }

            50% {
                border-color: black;
            }
        }
    </style>

    


    <title>Backend-Porlempika</title>
</head>

<body class="bg-theme bg-theme2">
    <!--wrapper-->
    <div class="wrapper">


        <!--sidebar wrapper -->
        @include('backend.layouts.sidebar')
        <!--end sidebar wrapper -->

        <!--start header -->
        @include('backend.layouts.header')
        <!--end header -->

        <!--start page wrapper -->
        <div class="page-wrapper">
            <div class="page-content">

                <div class="card radius-10">
                    <div class="card-body">

                        <div>
                            @yield('content')
                        </div>

                    </div>
                </div>

                <div class="card radius-10">
                    <div class="card-body">

                        <div class="text-center">
                            <p>© <span>Copyright</span> <strong class="px-1 sitename">Porlempika</strong> <span>Kota
                                    Padang</span>
                            </p>
                            <div class="credits">

                                Designed by <a href="#">Kel 2</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--end page wrapper -->
    <!--start overlay-->
    <div class="overlay toggle-icon"></div>
    <!--end overlay-->
    <!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
    <!--End Back To Top Button-->

    </div>
    <!--end wrapper-->
    <!--start switcher-->
    {{-- <div class="switcher-wrapper">
        <div class="switcher-btn"> <i class='bx bx-cog bx-spin'></i>
        </div>
        <div class="switcher-body">
            <div class="d-flex align-items-center">
                <h5 class="mb-0 text-uppercase">Theme Customizer</h5>
                <button type="button" class="btn-close ms-auto close-switcher" aria-label="Close"></button>
            </div>
            <hr />
            <p class="mb-0">Gaussian Texture</p>
            <hr>
            <ul class="switcher">
                <li id="theme1"></li>
                <li id="theme2"></li>
                <li id="theme3"></li>
                <li id="theme4"></li>
                <li id="theme5"></li>
                <li id="theme6"></li>
            </ul>
            <hr>
            <p class="mb-0">Gradient Background</p>
            <hr>
            <ul class="switcher">
                <li id="theme7"></li>
                <li id="theme8"></li>
                <li id="theme9"></li>
                <li id="theme10"></li>
                <li id="theme11"></li>
                <li id="theme12"></li>
                <li id="theme13"></li>
                <li id="theme14"></li>
                <li id="theme15"></li>
            </ul>
        </div>
    </div> --}}
    <!--end switcher-->
    <!-- Bootstrap JS -->
    <!-- Bootstrap Bundle JS -->
    <!-- jQuery (wajib sebelum plugin lain yang bergantung pada jQuery) -->
    {{-- <script src="{{ asset('dashboard/assets/js/jquery.min.js') }}"></script>

    <!-- Bootstrap Bundle -->
    <script src="{{ asset('dashboard/assets/js/bootstrap.bundle.min.js') }}"></script> --}}

    <!-- Plugins -->
    <script src="{{ asset('dashboard/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('dashboard/assets/plugins/apexcharts-bundle/js/apexcharts.min.js') }}"></script>
    {{-- <script src="{{ asset('dashboard/assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script> --}}

    <!-- Custom JS -->
    <script src="{{ asset('dashboard/assets/js/app.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/index.js') }}"></script>

    <!-- Inline Script -->
    <script>
        $(document).ready(function() {
            $('#Transaction-History').DataTable({
                lengthMenu: [
                    [6, 10, 20, -1],
                    [6, 10, 20, 'Todos']
                ]
            });

            new PerfectScrollbar('.product-list');
            new PerfectScrollbar('.customers-list');
        });
    </script>

    <script>
        const text = "Berbeda | Bersatu | Berjaya | Porlempika Kota Padang";
        const typingSpeed = 200; // ms per karakter
        const delayBetweenLoops = 3000; // delay 2 detik setelah selesai
        const typingElement = document.getElementById('typing-text');

        let index = 0;

        function typeWriter() {
            if (index < text.length) {
                typingElement.innerHTML += text.charAt(index);
                index++;
                setTimeout(typeWriter, typingSpeed);
            } else {
                // Setelah selesai ketik, tunggu 2 detik lalu hapus teks dan mulai ulang
                setTimeout(() => {
                    typingElement.innerHTML = '';
                    index = 0;
                    typeWriter();
                }, delayBetweenLoops);
            }
        }

        document.addEventListener('DOMContentLoaded', typeWriter);
    </script>
    <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>


    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>
    <script>
        new DataTable('#example');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/metismenu/dist/metisMenu.min.js"></script>
    <script>
        $('#menu').metisMenu(); // aktifkan metismenu
    </script>


</body>

</html>
