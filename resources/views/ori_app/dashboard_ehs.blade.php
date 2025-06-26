<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap 5 CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Google Material Icons -->
    <link href="{{ asset('css/material-icons.css') }}" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <!-- Chart.js -->
    <script src="{{ asset('js/chart.umd.min.js') }}"></script>
    <title>Dashboard Laporan Temuan</title>
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #ebedfd;
            --secondary: #3f37c9;
            --danger: #f72585;
            --warning: #3cff00;
            --success: #4cc9f0;
            --dark: #212529;
            --light: #f8f9fa;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            background: white;
            width: 280px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sidebar-brand {
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--primary);
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .sidebar-menu li {
            list-style: none;
            margin-bottom: 0.5rem;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 0.8rem 1.5rem;
            color: #555;
            text-decoration: none;
            transition: all 0.3s;
        }

        .sidebar-menu a:hover {
            background-color: var(--primary-light);
            color: var(--primary);
        }

        .sidebar-menu a.active {
            background-color: var(--primary-light);
            color: var(--primary);
            border-left: 4px solid var(--primary);
        }

        .sidebar-menu .material-icons {
            margin-right: 0.8rem;
            font-size: 1.2rem;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            transition: all 0.3s;
        }

        /* Navbar */
        .navbar {
            background: white;
            padding: 1rem 1.5rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .navbar .material-icons {
            cursor: pointer;
        }

        .search-bar {
            position: relative;
            width: 300px;
        }

        .search-bar input {
            padding-left: 2.5rem;
            border-radius: 20px;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
        }

        .search-bar .material-icons {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #777;
        }

        .user-profile {
            display: flex;
            align-items: center;
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 0.8rem;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #eee;
            font-weight: 600;
            padding: 1rem 1.5rem;
            border-radius: 10px 10px 0 0 !important;
        }

        .stat-card {
            padding: 1.5rem;
            border-left: 4px solid;
        }

        .stat-card.primary {
            border-left-color: var(--primary);
        }

        .stat-card.success {
            border-left-color: var(--success);
        }

        .stat-card.warning {
            border-left-color: var(--warning);
        }

        .stat-card.danger {
            border-left-color: var(--danger);
        }

        .stat-card h5 {
            color: #777;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .stat-card h2 {
            font-weight: 700;
            color: #333;
        }

        /* Chart Container */
        .chart-container {
            position: relative;
            height: 300px;
            padding: 1rem;
        }

        .material-icons {
            font-family: 'Material Icons';
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
        }

        /* Mobile View */
        @media (max-width: 992px) {
            .sidebar {
                left: -280px;
            }

            .sidebar.active {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            .search-bar {
                width: 200px;
            }
        }

        /* Priority Badges */
        .badge-priority {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.8rem;
        }

        .badge-critical {
            background-color: rgba(247, 37, 133, 0.1);
            color: var(--danger);
        }

        .badge-high {
            background-color: rgba(248, 150, 30, 0.1);
            color: var(--warning);
        }

        .badge-medium {
            background-color: rgba(67, 97, 238, 0.1);
            color: var(--primary);
        }

        .badge-low {
            background-color: rgba(76, 201, 240, 0.1);
            color: var(--success);
        }

        .pagination {
            --bs-pagination-color: #4361ee;
            --bs-pagination-hover-color: #3a56d4;
            --bs-pagination-focus-color: #3a56d4;
            --bs-pagination-active-bg: #4361ee;
            --bs-pagination-active-border-color: #4361ee;
            --bs-pagination-focus-box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
        }

        .pagination-sm .page-link {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-radius: 8px;
            margin: 0 2px;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <img src="{{ asset('img/company-logo.png') }}" alt="logo API" class="w-25 me-2">
                <span class="sidebar-brand">GENBA APP</span>
            </div>
            <span class="material-icons d-lg-none" id="sidebarClose">close</span>
        </div>
        <ul class="sidebar-menu">
            <li>
                <a href="#" class="active">
                    <i class="fas fa-tachometer-alt me-2" style="font-size: 1.2rem;"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('bod') }}">
                    <i class="fas fa-tasks me-2" style="font-size: 1.2rem;"></i>
                    <span>BOD</span>
                </a>
            </li>
            <li>
                <a href="{{ route('form') }}" class="d-flex align-items-center">
                    <i class="fas fa-plus-circle me-2" style="font-size: 1.2rem;"></i>
                    <span>Buat Temuan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('genba.add') }}">
                    <i class="fas fa-calendar-plus me-2" style="font-size: 1.2rem;"></i>
                    <span>Tambah Genba Event</span>
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}">
                    <img src="{{ asset('img/icon/logout.png') }}" alt="Dashboard" style="width:24px;height:24px;"
                        class="me-2">
                    <span>Keluar</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <span class="material-icons d-lg-none" id="sidebarToggle">menu</span>

                <div class="ms-auto d-flex align-items-center">
                    <div class="user-profile">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="User">
                        <span>Admin</span>
                    </div>
                </div>
            </div>
        </nav>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show m-4" role="alert">
                <span class="material-icons align-middle me-2">check_circle</span>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show m-4" role="alert">
                <span class="material-icons align-middle me-2">error</span>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Content -->
        <div class="container-fluid p-4">
            <h4 class="mb-4">Dashboard Laporan Temuan</h4>

            <!-- Stats Cards -->
            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <div class="card stat-card primary">
                        <h5>Total Temuan</h5>
                        <h2>{{ $sum_temuan }}</h2>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card stat-card success">
                        <h5>Terselesaikan</h5>
                        <h2>{{ $sum_done_temuan }}</h2>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card stat-card warning">
                        <h5>Dalam Proses</h5>
                        <h2>{{ $sum_ongoing_temuan }}</h2>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card stat-card danger">
                        <h5>Belum Diproses</h5>
                        <h2>{{ $sum_none_temuan }}</h2>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row mt-4">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <span>Distribusi Temuan Berdasarkan Prioritas</span>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="priorityChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <span>Distribusi Prioritas</span>
                        </div>
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="donutChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Findings -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>Temuan Terbaru</span>
                            <button class="btn btn-sm btn-outline-primary">Lihat Semua</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Deskripsi</th>
                                            <th>Prioritas</th>
                                            <th>Status</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($temuan->take(5) as $item)
                                            <tr>
                                                <td>#{{ $item->id }}</td>
                                                <td>{{ Str::limit($item->deskripsi, 30) }}</td>
                                                <td>
                                                    @if ($item->tingkat_prioritas == 'a')
                                                        <span class="badge badge-priority badge-critical">Grade A</span>
                                                    @elseif($item->tingkat_prioritas == 'b')
                                                        <span class="badge badge-priority badge-high">Grade B</span>
                                                    @elseif($item->tingkat_prioritas == 'c')
                                                        <span class="badge badge-priority badge-medium">Grade C</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->status == 'done')
                                                        <span class="badge bg-success">Selesai</span>
                                                    @elseif($item->status == 'on going')
                                                        <span class="badge bg-warning">Proses</span>
                                                    @else
                                                        <span class="badge bg-danger">Belum</span>
                                                    @endif
                                                </td>
                                                <td>{{ $item->created_at->format('d M Y') }}</td>
                                                <td>
                                                    <a href="{{ route('form.repair', ['id' => $item->id]) }}"
                                                        class="text-primary" title="Perbaikan">
                                                        <img src="{{ asset('img/icon/build.png') }}" alt="Perbaikan"
                                                            style="width:24px;height:24px;">
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center mt-4" id="pagination-container">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery (Wajib sebelum Bootstrap JS jika pakai jQuery di bawah) -->
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <script>
        // Sidebar Toggle
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });

        document.getElementById('sidebarClose').addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('active');
        });

        // Global chart variables
        let priorityChart, donutChart;
        let currentPage = 1;
        let refreshInterval;

        // Chart Data - Using PHP data passed from controller
        const priorityData = {
            labels: @json($priorityData['labels']),
            datasets: [{
                    label: 'Grade A',
                    data: @json($priorityData['datasets']['critical']),
                    backgroundColor: 'rgba(247, 37, 133, 0.2)',
                    borderColor: 'rgba(247, 37, 133, 1)',
                    borderWidth: 2,
                    tension: 0.4
                },
                {
                    label: 'Grade B',
                    data: @json($priorityData['datasets']['high']),
                    backgroundColor: 'rgba(248, 150, 30, 0.2)',
                    borderColor: 'rgba(248, 150, 30, 1)',
                    borderWidth: 2,
                    tension: 0.4
                },
                {
                    label: 'Grade C',
                    data: @json($priorityData['datasets']['medium']),
                    backgroundColor: 'rgba(60, 255, 0, 0.2)',
                    borderColor: 'rgba(60, 255, 0, 1)',
                    borderWidth: 2,
                    tension: 0.4
                },
            ]
        };

        const donutData = {
            labels: @json($donutData['labels']),
            datasets: [{
                data: @json($donutData['data']),
                backgroundColor: [
                    'rgba(247, 37, 133, 0.7)',
                    'rgba(248, 150, 30, 0.7)',
                    'rgba(60, 255, 0, 0.7)',
                ],
                borderColor: [
                    'rgba(247, 37, 133, 1)',
                    'rgba(248, 150, 30, 1)',
                    'rgba(60, 255, 0, 1)',
                ],
                borderWidth: 1
            }]
        };

        // Chart Config
        const priorityConfig = {
            type: 'line',
            data: priorityData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                }
            }
        };

        const donutConfig = {
            type: 'doughnut',
            data: donutData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                    }
                },
                cutout: '70%'
            }
        };

        $(document).ready(function() {
            // Initialize Charts
            priorityChart = new Chart(
                document.getElementById('priorityChart').getContext('2d'),
                priorityConfig
            );

            donutChart = new Chart(
                document.getElementById('donutChart').getContext('2d'),
                donutConfig
            );

            // Load initial data
            loadData(currentPage);

            // Set up auto-refresh every 10 seconds
            setupAutoRefresh();

            // Function to set up auto-refresh
            function setupAutoRefresh() {
                // Clear existing interval if any
                if (refreshInterval) {
                    clearInterval(refreshInterval);
                }

                // Set new interval
                refreshInterval = setInterval(function() {
                    loadData(currentPage);
                }, 16000); //  3 Menit
            }

            // Function to load data via AJAX
            function loadData(page) {
                currentPage = page;
                $.ajax({
                    url: '{{ route('bod.data') }}',
                    type: 'GET',
                    data: {
                        page: page
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Update table body
                        updateTableBody(response.data);

                        // Update pagination links
                        updatePaginationLinks(response);

                        // Update charts if chart data is provided
                        if (response.chartData) {
                            updateCharts(response.chartData);
                        }
                    },
                    error: function(xhr) {
                        console.error('Error loading data:', xhr.responseText);
                    }
                });
            }

            // Function to update charts
            function updateCharts(chartData) {
                // Update priority chart
                priorityChart.data.labels = chartData.priority.labels;
                priorityChart.data.datasets[0].data = chartData.priority.datasets.critical;
                priorityChart.data.datasets[1].data = chartData.priority.datasets.high;
                priorityChart.data.datasets[2].data = chartData.priority.datasets.medium;
                priorityChart.update();

                // Update donut chart
                donutChart.data.labels = chartData.donut.labels;
                donutChart.data.datasets[0].data = chartData.donut.data;
                donutChart.update();
            }

            // Function to update table body
            function updateTableBody(data) {
                let tbody = $('tbody');
                tbody.empty();

                if (data.length === 0) {
                    tbody.append(`
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5" style="font-size:1.15rem;">
                            <i class="fas fa-info-circle fa-2x mb-3" style="color:#4361ee;"></i>
                            <div class="fs-5">Tidak ada data temuan ditemukan.</div>
                        </td>
                    </tr>
                `);
                    return;
                }

                data.forEach(item => {
                    // Priority badge
                    let priorityBadge = '';
                    const priority = (item.tingkat_prioritas ?? '').toLowerCase();

                    if (priority === 'a') {
                        priorityBadge = '<span class="badge badge-priority badge-critical">Grade A</span>';
                    } else if (priority === 'b') {
                        priorityBadge = '<span class="badge badge-priority badge-high">Grade B</span>';
                    } else if (priority === 'c') {
                        priorityBadge = '<span class="badge badge-priority badge-medium">Grade C</span>';
                    }

                    // Status badge
                    let statusBadge = '';
                    const status = (item.status ?? '').toLowerCase();

                    if (status === 'done') {
                        statusBadge = '<span class="badge bg-success">Selesai</span>';
                    } else if (status === 'on going') {
                        statusBadge = '<span class="badge bg-warning">Proses</span>';
                    } else {
                        statusBadge = '<span class="badge bg-danger">Belum</span>';
                    }

                    // Format date
                    let createdAt = '';
                    if (item.created_at) {
                        const date = new Date(item.created_at);
                        const options = {
                            day: 'numeric',
                            month: 'short',
                            year: 'numeric'
                        };
                        createdAt = date.toLocaleDateString('id-ID', options);
                    } else {
                        createdAt = '-';
                    }

                    // Create row
                    let row = `
                    <tr>
                        <td>#${item.id ?? '-'}</td>
                        <td>${item.deskripsi ? (item.deskripsi.length > 30 ? item.deskripsi.substring(0, 30) + '...' : item.deskripsi) : '-'}</td>
                        <td>${priorityBadge}</td>
                        <td>${statusBadge}</td>
                        <td>${createdAt}</td>
                        <td>
                            <a href="${item.id ? '/form/repair/' + item.id : '#'}" class="text-primary" title="Perbaikan">
                                <img src="{{ asset('img/icon/build.png') }}" alt="Perbaikan" style="width:24px;height:24px;">
                            </a>
                        </td>
                    </tr>
                `;

                    tbody.append(row);
                });
            }

            // Function to update pagination links
            function updatePaginationLinks(pagination) {
                let paginationContainer = $('#pagination-container');
                paginationContainer.empty();

                if (pagination.last_page <= 1) return;

                let html = `<nav aria-label="Page navigation">
                <ul class="pagination pagination-sm">`;

                // Previous page link
                if (pagination.current_page > 1) {
                    html += `<li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous" data-page="${pagination.current_page - 1}">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>`;
                } else {
                    html += `<li class="page-item disabled">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>`;
                }

                // Page links
                for (let i = 1; i <= pagination.last_page; i++) {
                    html += `<li class="page-item ${i === pagination.current_page ? 'active' : ''}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>`;
                }

                // Next page link
                if (pagination.current_page < pagination.last_page) {
                    html += `<li class="page-item">
                    <a class="page-link" href="#" aria-label="Next" data-page="${pagination.current_page + 1}">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>`;
                } else {
                    html += `<li class="page-item disabled">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>`;
                }

                html += `</ul></nav>`;
                paginationContainer.html(html);
            }

            // Handle pagination clicks
            $(document).on('click', '.page-link', function(e) {
                e.preventDefault();
                let page = $(this).data('page');
                if (page) {
                    currentPage = page;
                    loadData(page);
                }
            });

            // Handle delete button clicks
            $(document).on('click', '.btn-delete', function() {
                if (confirm('Are you sure you want to delete this inspection?')) {
                    const id = $(this).data('id');
                    $.ajax({
                        url: '{{ route('form-answer.delete', ['id' => '___ID___']) }}'.replace(
                            '___ID___', id),
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            loadData(currentPage);
                        }
                    });
                }
            });

            // Clean up interval when page is unloaded
            $(window).on('beforeunload', function() {
                clearInterval(refreshInterval);
            });
        });
    </script>
</body>

</html>
