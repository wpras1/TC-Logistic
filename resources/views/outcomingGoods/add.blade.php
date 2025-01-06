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
                        <h1 class="h3 mb-0 text-gray-800">Add Outgoing Goods</h1>
                    </div>

                    <!-- Content Row -->

                    <div class="row">
                        <!-- Area Form -->
                        <div class="col-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Goods Outgoing Form</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <form action="{{ route('outcomingGoods.store') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="product_name">Product Name</label>
                                                    <select name="product_name" id="product_name" class="form-control" required>
                                                        <option value="" disabled selected>-- Select Product --</option>
                                                        @foreach ($products as $id => $product_name)
                                                            <option value="{{ $product_name }}">{{ $product_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <small id="stock-info" class="form-text text-danger"></small> <!-- Teks stok -->
                                                </div>                                                                                               
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="date_out">Date Out</label>
                                                    <input type="date" name="date_out" id="date_out" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="quantity">Quantity</label>
                                                    <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Enter quantity" required>
                                                    @error('quantity')
                                                        <div class="text-danger">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="destination">Destination of Goods</label>
                                                    <input type="text" name="destination" id="destination" class="form-control" placeholder="Enter destination of goods" required>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
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

{{-- Script Pagination --}}
<script>
    let currentPage = 1;
    let maxView = 5; 
    
    function renderPagination() {
        const rows = document.querySelectorAll('#productTableBody tr');
        const pageCount = Math.ceil(rows.length / maxView);
        const paginationControls = document.getElementById('paginationControls');
        paginationControls.innerHTML = '';

        const prevButton = document.createElement('li');
        prevButton.classList.add('page-item');
        prevButton.innerHTML = `<a class="page-link" href="#" onclick="changePage(currentPage - 1)" aria-disabled="true">&laquo; Previous</a>`;
        prevButton.classList.toggle('disabled', currentPage === 1);
        paginationControls.appendChild(prevButton);

        for (let i = 1; i <= pageCount; i++) {
            const pageButton = document.createElement('li');
            pageButton.classList.add('page-item');
            pageButton.innerHTML = `<a class="page-link" href="#" onclick="changePage(${i})">${i}</a>`;
            pageButton.classList.toggle('active', i === currentPage);
            paginationControls.appendChild(pageButton);
        }

        const nextButton = document.createElement('li');
        nextButton.classList.add('page-item');
        nextButton.innerHTML = `<a class="page-link" href="#" onclick="changePage(currentPage + 1)">Next &raquo;</a>`;
        nextButton.classList.toggle('disabled', currentPage === pageCount);
        paginationControls.appendChild(nextButton);
    }

    function changePage(page) {
        const rows = document.querySelectorAll('#productTableBody tr');
        const startIndex = (page - 1) * maxView;
        const endIndex = startIndex + maxView;
        
        rows.forEach((row, index) => {
            row.style.display = (index >= startIndex && index < endIndex) ? '' : 'none';
        });

        currentPage = page;
        renderPagination();
    }
    
    function changeMaxView() {
        maxView = parseInt(document.getElementById('maxViewSelect').value);
        currentPage = 1; 
        changePage(currentPage);
    }
    
    document.getElementById('maxViewSelect').addEventListener('change', changeMaxView);
    changePage(currentPage);
</script>

<script>
    document.getElementById('product_name').addEventListener('change', function () {
        const productName = this.value;
        const stockInfo = document.getElementById('stock-info');
        
        stockInfo.textContent = '';

        if (productName) {
            
            fetch('{{ route("getProductStock") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ product_name: productName })
            })
            .then(response => response.json())
            .then(data => {
                if (data.stock !== undefined) {
                    stockInfo.textContent = `Stock in Warehouse: ${data.stock}`;
                } else {
                    stockInfo.textContent = 'Stock information unavailable.';
                }
            })
            .catch(error => {
                stockInfo.textContent = 'Failed to fetch stock information.';
                console.error('Error fetching stock data:', error);
            });
        }
    });
    document.querySelector('form').addEventListener('submit', function (e) {
    const quantity = parseInt(document.getElementById('quantity').value);
    const stockInfo = document.getElementById('stock-info').textContent;
    const stock = parseInt(stockInfo.replace(/\D/g, '')); 
    
    if (!isNaN(quantity) && quantity > stock) {
        
        alert('The quantity entered exceeds the stock available in the warehouse!');
        
        e.preventDefault();
    }
});


</script>


@endsection
