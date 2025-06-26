<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Safety Inspection Report</title>
    <!-- Bootstrap 5 CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <!-- Sweetalert2 -->
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.css') }}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #ebedfd;
            --secondary: #3f37c9;
            --danger: #f72585;
            --warning: #f8961e;
            --success: #4cc9f0;
            --dark: #212529;
            --light: #f8f9fa;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            min-height: 100vh;
            padding: 20px;
            color: var(--dark);
            line-height: 1.6;
        }

        .report-container {
            background: white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 16px;
            position: relative;
            overflow: hidden;
            border: none;
        }

        .report-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg, var(--primary), var(--success));
            border-radius: 16px 16px 0 0;
        }

        .report-header {
            padding: 25px 30px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        }

        .report-title {
            color: var(--primary);
            font-weight: 700;
            position: relative;
            font-size: 1.75rem;
        }

        .date-time {
            font-size: 1rem;
            color: #6c757d;
            font-weight: 400;
        }

        .current-time {
            font-size: 1.15rem;
            font-weight: 500;
            color: var(--primary);
        }

        .risk-high {
            color: var(--danger);
            font-weight: 600;
            background: rgba(247, 37, 133, 0.1);
        }

        .risk-medium {
            color: var(--warning);
            font-weight: 600;
            background: rgba(248, 150, 30, 0.1);
        }

        .risk-low {
            color: var(--success);
            font-weight: 600;
            background: rgba(76, 201, 240, 0.1);
        }

        .badge-risk {
            border-radius: 12px;
            padding: 6px 12px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
        }

        .photo-cell img {
            max-width: 150px;
            height: auto;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            cursor: pointer;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .photo-cell img:hover {
            transform: scale(1.03);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }

        .report-footer {
            border-top: 1px solid rgba(0, 0, 0, 0.08);
            padding: 20px;
            background: var(--primary-light);
            border-radius: 0 0 16px 16px;
        }

        .footer-time {
            font-weight: 500;
            color: var(--primary);
        }

        .search-highlight {
            background-color: rgba(255, 230, 0, 0.4);
            font-weight: bold;
            padding: 2px 4px;
            border-radius: 4px;
        }

        /* Button styles */
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            border-radius: 10px;
            padding: 8px 16px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--secondary);
            border-color: var(--secondary);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.25);
        }

        .btn-outline-primary {
            border-radius: 10px;
            padding: 8px 16px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background-color: rgba(67, 97, 238, 0.1);
        }

        /* Table styles */
        .table {
            border-collapse: separate;
            border-spacing: 0;
            margin: 0;
        }

        .table thead th {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: sticky;
            top: 0;
            border: none;
            padding: 12px 16px;
            font-size: 0.85rem;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background: rgba(67, 97, 238, 0.05);
            transform: translateX(4px);
        }

        .table tbody td {
            padding: 14px 16px;
            vertical-align: middle;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        /* Modal styles */
        .modal-content {
            border-radius: 16px;
            overflow: hidden;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            padding: 20px 25px;
            background: var(--primary-light);
        }

        .modal-body {
            padding: 25px;
        }

        .modal-image-container {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .modal-image-container img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Form styles */
        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 10px 15px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .report-header {
                padding: 20px;
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .report-title {
                font-size: 1.5rem;
                order: 2;
            }

            .date-time {
                order: 3;
                text-align: center !important;
            }

            .photo-cell img {
                max-width: 120px;
            }

            .table thead th,
            .table tbody td {
                padding: 10px 12px;
            }
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(67, 97, 238, 0.3);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(67, 97, 238, 0.5);
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
    <div class="container-fluid report-container my-4" id="report-content">
        <header class="report-header d-flex flex-column flex-md-row justify-content-between align-items-center">
            <img src="{{ asset('img/company-logo.png') }}" alt="Company Logo" style="height: 80px;" class="order-md-1">
            <h1 class="report-title order-md-2 text-center my-3 my-md-0">Repair Safety Inspection Report</h1>
            <div class="date-time text-center text-md-end order-md-3">
                <div class="current-time" id="currentTime"></div>
                <div class="current-date" id="currentDate"></div>
            </div>
        </header>

        <div class="px-4 pt-3 pb-2">
            <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-center mb-4 gap-3">
                <div class="d-flex gap-2 order-md-1 w-100 w-md-auto">
                    <button class="btn btn-primary shadow-sm" id="downloadPdf" onclick="exportData()">
                        <i class="fas fa-download me-2"></i> Download CSV
                    </button>
                    <a href="{{ route('form') }}" class="btn btn-primary shadow-sm">
                        <i class="fas fa-plus me-2"></i> Tambah Data
                    </a>
                </div>

                <div class="order-md-0 w-100">
                    <div class="position-relative">
                        <input type="text" id="searchInput" class="form-control shadow-none ps-5"
                            placeholder="Search inspections..." style="border-radius: 10px;">
                        <i
                            class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    </div>
                </div>
                <a href="javascript:history.back()" class="btn btn-outline-primary shadow-sm">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
        </div>

        <main class="fade-in px-4 pb-4">
            <div class="table-responsive rounded-4 shadow-sm"
                style="border: 1.5px solid var(--primary-light); background: linear-gradient(120deg, #f8faff 80%, #e4e8f0 100%);">
                <table class="table table-hover align-middle mb-0"
                    style="border-radius: 16px; overflow: hidden; font-size: 1.15rem; table-layout: fixed; width: 100%;">
                    <colgroup>
                        <col style="width: 19%;">
                        <col style="width: 20%;">
                        <col style="width: 17%;">
                        <col style="width: 14%;">
                        <col style="width: 15%;">
                        <col style="width: 15%;">
                    </colgroup>
                    <thead>
                        <tr
                            style="background: linear-gradient(90deg, var(--primary), var(--success)); font-size:1.1rem;">
                            <th class="rounded-start" style="font-size:1.1rem; letter-spacing:0.5px;">Area</th>
                            <th class="text-center" style="font-size:1.1rem;">Photo</th>
                            <th style="font-size:1.1rem;">Description</th>
                            <th style="font-size:1.1rem;">Risk Level</th>
                            <th style="font-size:1.1rem;">DD</th>
                            <th class="rounded-end" style="font-size:1.1rem;">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </main>
        <div class="d-flex justify-content-center mt-4" id="pagination-container">
        </div>
        <footer class="report-footer text-center">
            <div class="footer-time mb-2" id="footerTime"></div>
            <p class="mb-0"><span id="footerDate"></span> © Created By Digitalization 2025.</p>
        </footer>
    </div>

    <!-- Image Preview Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content overflow-hidden shadow-lg" style="border-radius: 20px;">
                <div class="modal-header"
                    style="background: linear-gradient(90deg, var(--primary), var(--success)); color: #fff; border-bottom: 2px solid var(--success);">
                    <div class="d-flex align-items-center gap-3">
                        <i class="fas fa-map-marker-alt fa-lg"></i>
                        <h5 class="modal-title mb-0" id="modalArea" style="font-weight: 600;"></h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" style="background: var(--primary-light);">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-6">
                            <div class="modal-image-container mb-3 shadow"
                                style="background: #f8faff; border-radius: 16px;">
                                <img id="modalImage" class="img-fluid rounded-4 border border-2 border-light"
                                    src="" alt="Inspection Photo"
                                    style="object-fit:cover; max-height:400px; width:100%;">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <div class="fw-bold text-secondary mb-2" style="font-size:1.1rem;">
                                    <i class="fas fa-align-left me-2"></i> Description
                                </div>
                                <div id="modalDescription" class="ps-2" style="font-size:1.08rem;"></div>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="p-3 rounded-3 shadow-sm h-100" style="background: var(--light);">
                                        <div class="fw-bold small text-muted mb-1">
                                            <i class="fas fa-bolt me-1 text-danger"></i> Risk Level
                                        </div>
                                        <div id="modalRisk"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 rounded-3 shadow-sm h-100" style="background: var(--light);">
                                        <div class="fw-bold small text-muted mb-1">
                                            <i class="fas fa-user-tie me-1 text-primary"></i> Person In Charge
                                        </div>
                                        <div id="modalPic"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"
                    style="background: var(--primary-light); border: none; border-radius: 0 0 20px 20px;">
                    <small class="text-muted ms-auto">
                        <i class="fas fa-info-circle me-1"></i>
                        Click outside or press <kbd>ESC</kbd> to close
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Inspection Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content overflow-hidden shadow-lg" style="border-radius: 20px;">
                <div class="modal-header"
                    style="background: linear-gradient(90deg, var(--primary), var(--success)); color: #fff; border-bottom: 2px solid var(--success);">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-edit fa-lg"></i>
                        <h5 class="modal-title mb-0 fw-bold">Edit Inspection</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body" style="background: var(--primary-light);">
                    <form id="editInspectionForm" method="POST" action="{{ route('form-answer.update') }}">
                        @csrf
                        <div class="row g-4 align-items-center mb-3">
                            <div class="col-lg-5">
                                <div class="modal-image-container shadow-sm mb-2"
                                    style="background: #f8faff; border-radius: 16px;">
                                    <img id="editModalImage" class="img-fluid rounded-4 border border-2 border-light"
                                        src="" alt="Inspection Photo"
                                        style="object-fit:cover; max-height:300px; width:100%;">
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="editModalArea" class="form-label fw-semibold">Area</label>
                                        <input type="text" class="form-control shadow-sm" id="editModalArea"
                                            name="area" autocomplete="off">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="editModalDetailArea" class="form-label fw-semibold">Detail
                                            Area</label>
                                        <input type="text" class="form-control shadow-sm" id="editModalDetailArea"
                                            name="detail_area" autocomplete="off">
                                    </div>
                                    <div class="col-12">
                                        <label for="editModalPotensiBahaya" class="form-label fw-semibold">Potential
                                            Hazard</label>
                                        <input type="text" class="form-control shadow-sm"
                                            id="editModalPotensiBahaya" name="potensi_bahaya" autocomplete="off">
                                    </div>
                                    <div class="col-12">
                                        <label for="editModalDescription"
                                            class="form-label fw-semibold">Description</label>
                                        <textarea class="form-control shadow-sm" id="editModalDescription" name="deskripsi" rows="2"></textarea>
                                    </div>
                                    <div class="col-12">
                                        <label for="editModalMasukan"
                                            class="form-label fw-semibold">Suggestion</label>
                                        <input type="text" class="form-control shadow-sm" id="editModalMasukan"
                                            name="masukan" autocomplete="off">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="editModalRisk" class="form-label fw-semibold">Risk Level</label>
                                        <select class="form-select shadow-sm" id="editModalRisk"
                                            name="tingkat_prioritas">
                                            <option value="critical">Critical</option>
                                            <option value="high">High</option>
                                            <option value="medium">Medium</option>
                                            <option value="low">Low</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="editModalPic" class="form-label fw-semibold">Person In
                                            Charge</label>
                                        <input type="text" class="form-control shadow-sm" id="editModalPic"
                                            name="pic" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="editModalId" name="id">
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary px-4 shadow-sm"
                                style="border-radius: 10px;">
                                <i class="fas fa-save me-2"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer"
                    style="background: var(--primary-light); border: none; border-radius: 0 0 20px 20px;">
                    <small class="text-muted ms-auto">
                        <i class="fas fa-info-circle me-1"></i>
                        Click outside or press <kbd>ESC</kbd> to close
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <!-- jQuery -->
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>

    <script>
        // Initialize modals
        const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
        const editModal = new bootstrap.Modal(document.getElementById('editModal'));

        // Update date and time
        function updateDateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString();
            const dateString = now.toLocaleDateString('en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            document.getElementById('currentTime').textContent = timeString;
            document.getElementById('currentDate').textContent = dateString;
            document.getElementById('footerDate').textContent = dateString;
        }

        updateDateTime();
        setInterval(updateDateTime, 1000);

        // Image modal functionality
        document.querySelectorAll('.photo-cell img').forEach(img => {
            img.addEventListener('click', function() {
                document.getElementById('modalImage').src = this.src;
                document.getElementById('modalArea').textContent = this.dataset.area;
                document.getElementById('modalDescription').textContent = this.dataset.description;

                const risk = this.dataset.risk.toLowerCase();
                const riskBadge = document.createElement('span');
                riskBadge.className = 'badge-risk';

                if (risk === 'critical') {
                    riskBadge.classList.add('risk-high');
                    riskBadge.style.background = 'rgba(220,53,69,0.15)';
                    riskBadge.style.color = '#dc3545';
                    riskBadge.innerHTML = '<i class="fas fa-skull-crossbones me-1"></i> Critical';
                } else if (risk === 'high') {
                    riskBadge.classList.add('risk-high');
                    riskBadge.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i> High';
                } else if (risk === 'medium') {
                    riskBadge.classList.add('risk-medium');
                    riskBadge.innerHTML = '<i class="fas fa-exclamation-circle me-1"></i> Medium';
                } else {
                    riskBadge.classList.add('risk-low');
                    riskBadge.innerHTML = '<i class="fas fa-check-circle me-1"></i> Low';
                }

                document.getElementById('modalRisk').innerHTML = '';
                document.getElementById('modalRisk').appendChild(riskBadge);
                document.getElementById('modalPic').textContent = this.dataset.pic;
            });
        });

        // Edit modal functionality
        document.querySelectorAll('.btn-edit-inspection').forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('editModalImage').src = this.dataset.img;
                document.getElementById('editModalArea').value = this.dataset.area || '';
                document.getElementById('editModalDetailArea').value = this.dataset.detail_area || '';
                document.getElementById('editModalPotensiBahaya').value = this.dataset.potensi_bahaya || '';
                document.getElementById('editModalDescription').value = this.dataset.deskripsi || '';
                document.getElementById('editModalMasukan').value = this.dataset.masukan || '';
                document.getElementById('editModalRisk').value = (this.dataset.risk || '').toLowerCase();
                document.getElementById('editModalPic').value = this.dataset.pic || '';
                document.getElementById('editModalId').value = this.dataset.id || '';
            });
        });

        // Export data function
        function exportData() {
            $.ajax({
                url: '{{ route('export') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response) {
                    const blob = new Blob([response]);
                    const link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    const now = new Date();
                    const dateStr = now.toISOString().slice(0, 10).replace(/-/g, '');
                    link.download = `export_data_${dateStr}.xlsx`;
                    link.click();
                },
                error: function(xhr) {
                    Swal.fire('Error!', 'Gagal mengekspor data', 'error');
                    console.error(xhr.responseText);
                }
            });
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.inspection-row');

            rows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                row.style.display = rowText.includes(searchTerm) ? '' : 'none';

                if (searchTerm.length > 0 && rowText.includes(searchTerm)) {
                    highlightSearchMatches(row, searchTerm);
                } else {
                    removeSearchHighlights(row);
                }
            });
        });

        function highlightSearchMatches(row, searchTerm) {
            const cells = row.querySelectorAll('td:not(.photo-cell)');
            cells.forEach(cell => {
                const originalText = cell.textContent;
                const highlightedText = originalText.replace(
                    new RegExp(searchTerm, 'gi'),
                    match => `<span class="search-highlight">${match}</span>`
                );

                if (highlightedText !== originalText) {
                    cell.innerHTML = highlightedText;
                }
            });
        }

        function removeSearchHighlights(row) {
            const highlights = row.querySelectorAll('.search-highlight');
            highlights.forEach(highlight => {
                highlight.replaceWith(highlight.textContent);
            });
        }

        $(document).ready(function() {
            // Load initial data
            loadData(1);

            // Function to load data via AJAX
            function loadData(page) {
                $.ajax({
                    url: '{{ route('bod.repair.data') }}',
                    type: 'GET',
                    data: {
                        page: page
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Update table body
                        console.log('data respone', response.data);
                        updateTableBody(response.data);

                        // Update pagination links
                        updatePaginationLinks(response);
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                    }
                });
            }

            // Function to update table body
            function updateTableBody(data) {
                let tbody = $('tbody');
                tbody.empty();

                if (data.length === 0) {
                    tbody.append(`
                <tr>
                    <td colspan="7" class="text-center text-muted py-5" style="font-size:1.15rem;">
                        <i class="fas fa-info-circle fa-2x mb-3" style="color:#4361ee;"></i>
                        <div class="fs-5">Tidak ada data inspeksi ditemukan.</div>
                    </td>
                </tr>
            `);
                    return;
                }

                data.forEach(item => {
                    let riskBadge = '';
                    const risk = item.tingkat_prioritas.toLowerCase();

                    if (risk === 'critical') {
                        riskBadge = `<span class="badge-risk risk-high d-inline-flex align-items-center px-3 py-2"
                    style="background:rgba(220,53,69,0.15);color:#dc3545;font-size:1.05rem;">
                    <i class="fas fa-skull-crossbones me-1"></i> Critical
                </span>`;
                    } else if (risk === 'high') {
                        riskBadge = `<span class="badge-risk risk-high d-inline-flex align-items-center px-3 py-2"
                    style="font-size:1.05rem;">
                    <i class="fas fa-exclamation-triangle me-1"></i> High
                </span>`;
                    } else if (risk === 'medium') {
                        riskBadge = `<span class="badge-risk risk-medium d-inline-flex align-items-center px-3 py-2"
                    style="font-size:1.05rem;">
                    <i class="fas fa-exclamation-circle me-1"></i> Medium
                </span>`;
                    } else {
                        riskBadge = `<span class="badge-risk risk-low d-inline-flex align-items-center px-3 py-2"
                    style="font-size:1.05rem;">
                    <i class="fas fa-check-circle me-1"></i> Low
                </span>`;
                    }

                    let row = `
                <tr class="inspection-row" style="transition: box-shadow 0.2s; font-size:1.08rem;">
                    <td style="word-break:break-word;">
                        <div class="fw-bold" style="font-size:1.15rem; color:var(--primary);">
                            <i class="fas fa-map-marker-alt me-1 text-success"></i> ${item.area}
                        </div>
                        ${item.detail_area ? `
                                                        <div class="text-muted small mt-1 ps-4" style="font-size:1.05rem;">
                                                            <i class="fas fa-location-arrow me-1"></i> ${item.detail_area}
                                                        </div>` : ''}
                    </td>
                    <td class="photo-cell text-center" style="word-break:break-word;">
                        <div class="position-relative d-inline-block">
                            <img src="/storage/${item.img_path_repair}" alt="Area photo"
                                data-bs-toggle="modal" data-bs-target="#imageModal"
                                data-area="${item.area}${item.detail_area ? ' - ' + item.detail_area : ''}"
                                data-description="${item.deskripsi_repair}"
                                data-risk="${item.tingkat_prioritas}" data-pic="${item.pic}"
                                class="shadow-sm border border-2 border-light"
                                style="max-width: 180px; max-height: 120px; border-radius: 12px; background: #fff; object-fit: cover; object-position: center;">
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary shadow-sm"
                                style="font-size:0.8rem;">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                    </td>
                    <td style="word-break:break-word;">
                        <div class="fw-medium mb-1" style="color:var(--secondary); font-size:0.95rem;">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            ${item.potensi_bahaya ? item.potensi_bahaya.substring(0, 30) + (item.potensi_bahaya.length > 30 ? '...' : '') : 'Detail'}
                        </div>
                        <div class="text-muted small" style="font-size:0.92rem;">
                            ${item.deskripsi_repair ? item.deskripsi_repair.substring(0, 30) + (item.deskripsi_repair.length > 30 ? '...' : '') : ''}
                        </div>
                    </td>
                    <td style="word-break:break-word;">
                        ${riskBadge}
                    </td>
                    <td class="fw-medium" style="font-size:1.05rem; word-break:break-word;">
                        <span class="badge bg-light text-dark px-2 py-1 shadow-sm"
                            style="font-size:1.03rem;">
                            <i class="fas fa-calendar-alt me-1 text-primary"></i>
                            ${new Date(item.updated_at).toLocaleDateString()}
                        </span>
                    </td>
                    <td style="word-break:break-word;">
                        <div class="d-flex justify-content-center gap-2">
                            <button
                                class="btn btn-outline-primary btn-sm btn-edit-inspection shadow-sm px-2 py-1"
                                data-bs-toggle="modal" data-bs-target="#editModal"
                                data-id="${item.id}" data-area="${item.area}"
                                data-detail_area="${item.detail_area}"
                                data-potensi_bahaya="${item.potensi_bahaya}"
                                data-deskripsi="${item.deskripsi_repair}"
                                data-risk="${item.tingkat_prioritas}"
                                data-img="/storage/${item.img_path_repair}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm shadow-sm px-2 py-1 btn-delete" data-id="${item.id}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
                    tbody.append(row);
                });

                // Re-attach event listeners to new elements
                attachEventListeners();
            }

            $(document).on('click', '.btn-delete', function() {
                if (confirm('Are you sure you want to delete this inspection?')) {
                    const id = $(this).data('id');
                    $.ajax({
                        url: '{{ route('bod.repair.delete', ['id' => '___ID___']) }}'.replace(
                            '___ID___', id),
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            loadData(1);
                        }
                    });
                }
            });

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
                    loadData(page);
                }
            });

            // Function to re-attach event listeners after AJAX load
            function attachEventListeners() {
                // Image modal click handler
                $('.photo-cell img').on('click', function() {
                    $('#modalImage').attr('src', $(this).attr('src'));
                    $('#modalArea').text($(this).data('area'));
                    $('#modalDescription').text($(this).data('description'));

                    const risk = $(this).data('risk').toLowerCase();
                    let riskBadge = '';

                    if (risk === 'critical') {
                        riskBadge = `<span class="badge-risk risk-high d-inline-flex align-items-center px-3 py-2"
                    style="background:rgba(220,53,69,0.15);color:#dc3545;font-size:1.05rem;">
                    <i class="fas fa-skull-crossbones me-1"></i> Critical
                </span>`;
                    } else if (risk === 'high') {
                        riskBadge = `<span class="badge-risk risk-high d-inline-flex align-items-center px-3 py-2"
                    style="font-size:1.05rem;">
                    <i class="fas fa-exclamation-triangle me-1"></i> High
                </span>`;
                    } else if (risk === 'medium') {
                        riskBadge = `<span class="badge-risk risk-medium d-inline-flex align-items-center px-3 py-2"
                    style="font-size:1.05rem;">
                    <i class="fas fa-exclamation-circle me-1"></i> Medium
                </span>`;
                    } else {
                        riskBadge = `<span class="badge-risk risk-low d-inline-flex align-items-center px-3 py-2"
                    style="font-size:1.05rem;">
                    <i class="fas fa-check-circle me-1"></i> Low
                </span>`;
                    }

                    $('#modalRisk').html(riskBadge);
                    $('#modalPic').text($(this).data('pic'));
                });

                // Edit modal click handler
                $('.btn-edit-inspection').on('click', function() {
                    $('#editModalImage').attr('src', $(this).data('img'));
                    $('#editModalArea').val($(this).data('area') || '');
                    $('#editModalDetailArea').val($(this).data('detail_area') || '');
                    $('#editModalPotensiBahaya').val($(this).data('potensi_bahaya') || '');
                    $('#editModalDescription').val($(this).data('deskripsi') || '');
                    $('#editModalMasukan').val($(this).data('masukan') || '');
                    $('#editModalRisk').val(($(this).data('risk') || '').toLowerCase());
                    $('#editModalPic').val($(this).data('pic') || '');
                    $('#editModalId').val($(this).data('id') || '');
                });
            }
        });

        // Auto refresh page every 5 minutes
        setTimeout(function() {
            window.location.reload();
        }, 300000);
    </script>
</body>

</html>
