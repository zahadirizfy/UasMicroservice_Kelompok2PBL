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




    <title>Aplikasi-Porlempika</title>
</head>

<body class="bg-theme bg-theme2">
    <!--wrapper-->
    <div class="wrapper container mt-4">
        @yield('content')

    </div>
    <!--end switcher-->
    <!-- Bootstrap JS -->
    <!-- Bootstrap Bundle JS -->
    <!-- jQuery (wajib sebelum plugin lain yang bergantung pada jQuery) -->
    <script src="{{ asset('dashboard/assets/js/jquery.min.js') }}"></script>

    <!-- Bootstrap Bundle -->
    <script src="{{ asset('dashboard/assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Plugins -->
    <script src="{{ asset('dashboard/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('dashboard/assets/plugins/apexcharts-bundle/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ asset('dashboard/assets/js/app.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/index.js') }}"></script>

  
   <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>
    <script>
        new DataTable('#example');
    </script>

</body>

</html>
