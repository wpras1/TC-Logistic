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
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
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
                        <h1 class="h3 mb-0 text-gray-800">Warehouse</h1>
                        <a href="#" id="generateReportBtn" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->

                    <div class="row">
                        <!-- Area Table -->
                        <div class="col-12">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Warehouse Table</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="reportTable">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Product Name
                                                        <button id="sortNameBtn" class="btn btn-sm btn-link float-right">
                                                            <i class="fas fa-sort"></i>
                                                        </button>
                                                    </th>
                                                    <th>Incoming From</th>
                                                    <th>Stock Quantity
                                                        <button id="sortQuantityBtn" class="btn btn-sm btn-link float-right">
                                                            <i class="fas fa-sort"></i>
                                                        </button>
                                                    </th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($warehouses as $warehouse)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $warehouse->product_name }}</td>
                                                        <td>{{ $warehouse->incomingGoods->origin ?? '-' }}</td>
                                                        <td>{{ $warehouse->quantity }}</td>
                                                        <td class="text-center">
                                                            <a class="dropdown-toggle btn btn-sm btn-primary" href="#" role="button" id="dropdownMenuAction" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                <i class="fas fa-ellipsis-v"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuAction">
                                                                <form action="{{ route('warehouse.destroy', $warehouse->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                                                                </form>
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
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            @include('components.footer')

        </div>
        <!-- End of Content Wrapper -->

    </div>

    {{-- Script Sort Ascending dan Descending --}}
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
                    
                    if (columnIndex === 3) {
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
                document.getElementById('sortQuantityBtn').querySelector('i').className = 'fas fa-sort';
            });
            
            document.getElementById('sortQuantityBtn').addEventListener('click', function () {
                handleSort(this, 3, 'quantityOrder');
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
            const rows = document.querySelectorAll('#reportTable tbody tr'); 
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
            const rows = document.querySelectorAll('#reportTable tbody tr'); 
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

    {{-- Script Generate Report --}}
    <script>
        document.querySelector('#generateReportBtn').addEventListener('click', function () {
            const { jsPDF } = window.jspdf;
            
            const reportTable = document.querySelector('#reportTable');
            
            html2canvas(reportTable, { scale: 2 }).then((canvas) => {
                const imgData = canvas.toDataURL('image/png'); 
                const pdf = new jsPDF('p', 'mm', 'a4'); 
                
                const pageWidth = pdf.internal.pageSize.getWidth();
                const pageHeight = pdf.internal.pageSize.getHeight();
                const imgWidth = pageWidth - 20; 
                const imgHeight = (canvas.height * imgWidth) / canvas.width;
                
                const marginX = 10; 
                const marginY = 10; 
                
                pdf.addImage(imgData, 'PNG', marginX, marginY, imgWidth, imgHeight);

                pdf.save('Report.pdf');
            });
        });
    </script>