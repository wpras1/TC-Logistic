@extends('layouts.app')

@section('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<body id="page-top">

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
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    @include('components.topbar')

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                        <a href="#" id="generateReportBtn" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <!-- Most Stock of Goods -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Most Stock of Goods</div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                                {{ $mostStocked ? $mostStocked->product_name . ' (' . $mostStocked->quantity . ')' : 'No Data Available' }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-cubes fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Least Stock of Goods -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Least Stock of Goods</div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                                {{ $leastStocked ? $leastStocked->product_name . ' (' . $leastStocked->quantity . ')' : 'No Data Available' }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-cube fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Products in Warehouse -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Total Products in Warehouse</div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                                {{ $totalProducts }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-warehouse fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Quantity of Goods in Warehouse -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Total Quantity of Goods in Warehouse</div>
                                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                                {{ $totalQuantity }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <!-- Area Table -->
                        <div class="col-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Inventory of Goods</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="reportTable">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%;">No</th>
                                                    <th style="width: 23%;" >Name of Product
                                                        <button class="btn btn-link p-0 float-right" id="sortNameBtn" data-order="none">
                                                            <i class="fas fa-sort"></i>
                                                        </button>
                                                    </th>
                                                    <th style="width: 20%;">Incoming From</th>
                                                    <th style="width: 20%;">Last Outgoing To</th>
                                                    <th style="width: 16%;">Total Outgoing</th>
                                                    <th style="width: 16%;">Warehouse Stock
                                                        <button class="btn btn-link p-0 float-right" id="sortWarehouseStockBtn" data-order="none">
                                                            <i class="fas fa-sort"></i>
                                                        </button>
                                                    </th>
                                                    <th style="width: 5%;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="productTableBody">
                                                @foreach($products as $key => $product)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $product['product_name'] }}</td>
                                                        <td>{{ $product['incoming_from'] ?? 'Warehouse' }}</td>
                                                        <td>{{ $product['outcoming_to'] ?? '-' }}</td>
                                                        <td>{{ $product['total_outcoming'] }}</td>
                                                        <td>{{ $product['stock_in_warehouse'] }}</td>
                                                        <td class="text-center">
                                                            <a class="dropdown-toggle btn btn-sm btn-primary" href="#" role="button" id="dropdownMenuAction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fas fa-ellipsis-v"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuAction">
                                                                <a class="dropdown-item" href="{{ route('details.goods', ['productName' => $product['product_name']]) }}">Details</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Pagination Controls -->
                                    <div class="row">
                                        <div class="col-md-2">
                                            <select class="form-control" id="maxViewSelect">
                                                <option value="5">5</option>
                                                <option value="10">10</option>
                                                <option value="15">15</option>
                                                <option value="20">20</option>
                                                <option value="25">25</option>
                                            </select>
                                        </div>
                                        <div class="col-md-10 text-center">
                                            <nav>
                                                <ul class="pagination justify-content-end" id="paginationControls">
                                                    <!-- Pagination controls will be dynamically generated here -->
                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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

    {{-- css --}}
    <style>
        .hidden-for-report {
            display: none !important;
        }
    </style>


    {{-- Script Generate Report --}}
    <script>
        document.querySelector('#generateReportBtn').addEventListener('click', function () {
            const { jsPDF } = window.jspdf;

            // Sembunyikan kolom Action dan tombol sort
            const actionCells = document.querySelectorAll('td:nth-child(7), th:nth-child(7)');
            const sortButtons = document.querySelectorAll('#sortNameBtn, #sortWarehouseStockBtn');

            actionCells.forEach(cell => cell.classList.add('hidden-for-report'));
            sortButtons.forEach(button => button.classList.add('hidden-for-report'));

            setTimeout(() => {
                const reportTable = document.querySelector('#reportTable');

                html2canvas(reportTable, { scale: 2 }).then((canvas) => {
                    const imgData = canvas.toDataURL('image/png'); 
                    const pdf = new jsPDF('p', 'mm', 'a4'); 
                    
                    const pageWidth = pdf.internal.pageSize.getWidth();
                    const imgWidth = pageWidth - 20; 
                    const imgHeight = (canvas.height * imgWidth) / canvas.width;
                    
                    const marginX = 10; 
                    const marginY = 10; 
                    
                    pdf.addImage(imgData, 'PNG', marginX, marginY, imgWidth, imgHeight);
                    
                    pdf.save('Report.pdf');
                }).finally(() => {
                    actionCells.forEach(cell => cell.classList.remove('hidden-for-report'));
                    sortButtons.forEach(button => button.classList.remove('hidden-for-report'));
                });
            }, 100); 
        });
    </script>

    {{-- Script Search Bar --}}
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function () {
            const query = this.value.toLowerCase(); 
            const rows = document.querySelectorAll('#reportTable tbody tr'); 

            rows.forEach(row => {
                const cells = Array.from(row.querySelectorAll('td')); 
                const match = cells.some(cell => cell.textContent.toLowerCase().includes(query)); 
                row.style.display = match ? '' : 'none'; 
            });
        });
    </script>

    {{-- Script Sort Ascending Descending --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tableBody = document.querySelector('#reportTable tbody'); 
            const originalData = Array.from(tableBody.children); 
            let nameOrder = 'none';
            let quantityOrder = 'none';

            
            const resetTable = () => {
                tableBody.innerHTML = '';
                originalData.forEach(row => tableBody.appendChild(row));
            };
            
            const sortColumn = (rows, columnIndex, order) => {
                return rows.sort((a, b) => {
                    let valA = a.children[columnIndex].textContent.trim();
                    let valB = b.children[columnIndex].textContent.trim();

                    
                    if (columnIndex === 5) {  
                        valA = parseInt(valA, 10);
                        valB = parseInt(valB, 10);
                    } else {
                        valA = valA.toLowerCase();
                        valB = valB.toLowerCase();
                    }

                    if (order === 'asc') {
                        return valA > valB ? 1 : valA < valB ? -1 : 0;
                    } else {
                        return valA < valB ? 1 : valA > valB ? -1 : 0;
                    }
                });
            };
            
            const handleSort = (button, columnIndex, orderVariable) => {
                let currentOrder = window[orderVariable];
                let rows = Array.from(tableBody.children);

                if (currentOrder === 'none') {
                    rows = sortColumn(rows, columnIndex, 'asc');
                    window[orderVariable] = 'asc';
                    button.querySelector('i').className = 'fas fa-sort-up';
                } else if (currentOrder === 'asc') {
                    rows = sortColumn(rows, columnIndex, 'desc');
                    window[orderVariable] = 'desc';
                    button.querySelector('i').className = 'fas fa-sort-down';
                } else {
                    resetTable();
                    window[orderVariable] = 'none';
                    button.querySelector('i').className = 'fas fa-sort';
                    return; 
                }
                
                tableBody.innerHTML = '';
                rows.forEach(row => tableBody.appendChild(row));
            };
            
            document.getElementById('sortNameBtn').addEventListener('click', function () {
                handleSort(this, 1, 'nameOrder');
                quantityOrder = 'none'; 
                document.getElementById('sortWarehouseStockBtn').querySelector('i').className = 'fas fa-sort';
            });
            
            document.getElementById('sortWarehouseStockBtn').addEventListener('click', function () {
                handleSort(this, 5, 'quantityOrder'); 
                nameOrder = 'none'; 
                document.getElementById('sortNameBtn').querySelector('i').className = 'fas fa-sort';
            });
        });
    </script>    

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

    
</body>

@endsection