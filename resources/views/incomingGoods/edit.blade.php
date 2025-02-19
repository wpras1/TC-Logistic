@extends('layouts.app')

@section('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

{{-- <body id="page-top"> --}}

    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('components.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        {{-- <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div> --}}
                    </form>

                    @include('components.topbar')

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Edit Incoming Goods</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <!-- Area Form -->
                        <div class="col-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Goods Incoming Form</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <form action="{{ route('incomingGoods.update', $incomingGoods->id) }}" method="POST">
                                        @csrf
                                        @method('PUT') <!-- Menggunakan method PUT untuk update -->
                                    
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="product_name">Product Name</label>
                                                    <select class="form-control" id="product_name" name="product_name" disabled required>
                                                        <option value="">Select Product</option>
                                                        @foreach ($products as $id => $productName)
                                                            <option value="{{ $productName }}" {{ $incomingGoods->product_name == $productName ? 'selected' : '' }}>
                                                                {{ $productName }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="quantity">Quantity</label>
                                                    <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', $incomingGoods->quantity) }}" required>
                                                </div>
                                            </div>
                                        </div>
                                    
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="date_in">Date In</label>
                                                    <input type="date" class="form-control" id="date_in" name="date_in" value="{{ old('date_in', $incomingGoods->date_in) }}" required>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="origin">Origin</label>
                                                    <input type="text" class="form-control" id="origin" name="origin" value="{{ old('origin', $incomingGoods->origin) }}" required>
                                                </div>
                                            </div>
                                        </div>
                                    
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </form>                                                                                                     
                                </div>
                            </div>
                        </div>
                    </div>                                       

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            @include('components.footer')

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

{{-- </body> --}}


@endsection




