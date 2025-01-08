<!-- app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Tech Logistic</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- POP UP --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Add your custom styles for status in stock and out of stock -->
    <style>
        .status.in-stock {
            color: green;
            font-weight: bold;
        }

        .status.out-of-stock {
            color: red;
            font-weight: bold;
        }
    @media print {
        #reportTable .text-center {
            display: none;
        }
        #reportTable {
            border-collapse: collapse;
            margin: 20px;
        }
        #reportTable th, #reportTable td {
            border: 1px solid black;
            padding: 8px;
        }
        .hidden-for-report {
            display: none !important;
        }
    }
    </style>

    @yield('styles') <!-- For page specific styles -->
</head>

<body id="page-top">
    @yield('content')
</body>
</html>
