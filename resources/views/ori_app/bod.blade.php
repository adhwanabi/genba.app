<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Safety Inspection Report</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Add jsPDF library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <!-- Add jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Add SweetAlert2 library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --danger: #f72585;
            --warning: #f8961e;
            --success: #4cc9f0;
            --dark: #212529;
            --light: #f8f9fa;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            color: var(--dark);
            line-height: 1.6;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            position: relative;
            overflow: hidden;
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--success));
        }

        header {
            display: flex;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            position: relative;
            text-align: center;
        }

        .header-content {
            width: 100%;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }

        .date-time {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            font-size: 16px;
            color: #6c757d;
            font-weight: 400;
        }

        .current-time {
            font-size: 18px;
            font-weight: 500;
            color: var(--primary);
            margin-bottom: 5px;
        }

        .current-date {
            font-size: 14px;
        }

        header img {
            height: 80px;
            margin: 15px 0;
            transition: transform 0.3s ease;
        }

        header img:hover {
            transform: scale(1.05);
        }

        h1 {
            color: var(--primary);
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            position: relative;
            display: inline-block;
        }

        .report-actions {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
            gap: 10px;
        }

        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--secondary);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.3);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline:hover {
            background: rgba(67, 97, 238, 0.1);
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 20px 0;
            font-size: 14px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        th,
        td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            word-break: break-word;
        }

        thead th {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            position: sticky;
            top: 0;
        }

        tbody tr {
            transition: all 0.3s ease;
        }

        tbody tr:hover {
            background: rgba(67, 97, 238, 0.05);
            transform: translateX(5px);
        }

        .risk-high {
            color: var(--danger);
            font-weight: 600;
            text-align: center;
            background: rgba(247, 37, 133, 0.1);
            border-radius: 20px;
            padding: 5px 10px;
            display: inline-block;
        }

        .risk-medium {
            color: var(--warning);
            font-weight: 600;
            text-align: center;
            background: rgba(248, 150, 30, 0.1);
            border-radius: 20px;
            padding: 5px 10px;
            display: inline-block;
        }

        .risk-low {
            color: var(--success);
            font-weight: 600;
            text-align: center;
            background: rgba(76, 201, 240, 0.1);
            border-radius: 20px;
            padding: 5px 10px;
            display: inline-block;
        }

        .photo-cell {
            text-align: center;
        }

        .photo-cell img {
            width: 100%;
            max-width: 150px;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .photo-cell img:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            text-align: center;
            font-size: 14px;
            color: #6c757d;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .footer-time {
            margin-bottom: 10px;
            font-size: 15px;
            font-weight: 500;
            color: var(--primary);
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }

        .social-links a {
            color: var(--primary);
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            color: var(--secondary);
            transform: translateY(-3px);
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            overflow: auto;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal.show {
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 1;
        }

        .modal-content {
            background-color: white;
            margin: auto;
            padding: 25px;
            border-radius: 10px;
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            position: relative;
            animation: modalFadeIn 0.3s ease-out;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .close-modal {
            position: absolute;
            top: 15px;
            right: 15px;
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s;
        }

        .close-modal:hover {
            color: var(--danger);
        }

        .modal-image-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .modal-image {
            max-width: 100%;
            max-height: 60vh;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .modal-details {
            padding: 0 10px;
        }

        .modal-title {
            color: var(--primary);
            margin-bottom: 15px;
            font-size: 22px;
            font-weight: 600;
        }

        .modal-description {
            margin-bottom: 15px;
            line-height: 1.6;
        }

        .modal-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 15px;
        }

        .modal-meta-item {
            flex: 1;
            min-width: 150px;
        }

        .modal-meta-label {
            font-size: 13px;
            color: #6c757d;
            margin-bottom: 5px;
        }

        .modal-meta-value {
            font-weight: 500;
            font-size: 15px;
        }

        /* Mobile styles */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
                border-radius: 0;
            }

            .header-content {
                flex-direction: column;
                gap: 15px;
            }

            .date-time {
                align-items: center;
                margin-top: 10px;
            }

            h1 {
                font-size: 24px;
            }

            .current-time {
                font-size: 16px;
            }

            .current-date {
                font-size: 13px;
            }

            .report-actions {
                justify-content: center;
                flex-wrap: wrap;
            }

            table {
                display: block;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                white-space: nowrap;
                font-size: 13px;
            }

            th,
            td {
                padding: 10px;
                min-width: 120px;
            }

            .photo-cell img {
                max-width: 100px;
            }

            .modal-content {
                width: 95%;
                padding: 15px;
            }

            .modal-meta {
                flex-direction: column;
                gap: 10px;
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

        main {
            animation: fadeIn 0.6s ease-out;
        }

        /* Badge for status */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        /* Tooltip for images */
        .photo-tooltip {
            position: relative;
            display: inline-block;
        }

        .photo-tooltip:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 100;
        }

        .search-container {
            margin-left: auto;
        }

        #searchInput {
            transition: all 0.3s ease;
            outline: none;
        }

        #searchInput:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        }

        @media (max-width: 768px) {
            .search-container {
                width: 100%;
                margin-top: 10px;
            }

            #searchInput {
                width: 100% !important;
            }
        }

        .search-highlight {
            background-color: rgba(255, 255, 0, 0.5);
            font-weight: bold;
            padding: 1px 2px;
            border-radius: 3px;
        }
    </style>
</head>

<body>
    <div class="container" id="report-content">
        <header>
            <div class="header-content">
                <img src="{{ asset('img/company-logo.png') }}" alt="Company Logo">
                <h1>Safety Inspection Report</h1>
                <div class="date-time">
                    <div class="current-time" id="currentTime"></div>
                    <div class="current-date" id="currentDate"></div>
                </div>
            </div>
        </header>

        <div class="report-actions">
            <button class="btn btn-primary" id="downloadPdf" onclick="exportData()">
                <i class="fas fa-download"></i> Download CSV
            </button>
            <button onclick="window.location.href='{{ route('form') }}'" class="btn btn-primary"
                style="text-decoration: none;">
                <i class="fas fa-plus"></i> Tambah Data
            </button>

            <!-- Add search container here -->
            <div class="search-container" style="margin-left: auto;">
                <div style="position: relative;">
                    <input type="text" id="searchInput" placeholder="Search inspections..."
                        style="padding: 8px 15px 8px 35px; border: 1px solid #ddd; border-radius: 5px; width: 250px; font-size: 14px;">
                    <i class="fas fa-search"
                        style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #6c757d;"></i>
                </div>
            </div>
        </div>

        <main>
            <table class="table">
                <thead>
                    <tr>
                        <th>Area</th>
                        <th>Photo</th>
                        <th>Description</th>
                        <th>Risk Level</th>
                        <th>PIC</th>
                        <th>DD</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                        <tr>
                            <td>
                                <strong>{{ $item->area }}</strong>
                                @if (!empty($item->detail_area))
                                    <div style="font-size: 12px; color: #6c757d;">{{ $item->detail_area }}</div>
                                @endif
                            </td>
                            <td class="photo-cell">
                                <div class="photo-tooltip" data-tooltip="Click to view details">
                                    <img src="{{ asset('storage/' . $item->img_path) }}" alt="Area photo"
                                        data-area="{{ $item->area }}{{ !empty($item->detail_area) ? ' - ' . $item->detail_area : '' }}"
                                        data-description="{{ $item->deskripsi }}"
                                        data-risk="{{ $item->tingkat_prioritas }}" data-pic="{{ $item->pic }}">
                                </div>
                            </td>
                            <td>
                                <div style="font-weight: 500; margin-bottom: 5px;">
                                    {{ $item->potensi_bahaya ?? 'Detail' }}</div>
                                <div style="font-size: 13px; color: #6c757d;">{{ $item->deskripsi }}</div>
                                @if (!empty($item->masukan))
                                    <div style="font-size: 12px; color: #198754; margin-top: 5px;">
                                        <i class="fas fa-lightbulb"></i> {{ $item->masukan }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if (strtolower($item->tingkat_prioritas) == 'critical')
                                    <span class="risk-high" style="background:rgba(220,53,69,0.15);color:#dc3545;">
                                        <i class="fas fa-skull-crossbones"></i> Critical
                                    </span>
                                @elseif(strtolower($item->tingkat_prioritas) == 'high')
                                    <span class="risk-high">
                                        <i class="fas fa-exclamation-triangle"></i> High
                                    </span>
                                @elseif(strtolower($item->tingkat_prioritas) == 'medium')
                                    <span class="risk-medium">
                                        <i class="fas fa-exclamation-circle"></i> Medium
                                    </span>
                                @else
                                    <span class="risk-low">
                                        <i class="fas fa-check-circle"></i> Low
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div style="font-weight: 500;">{{ $item->pic }}</div>
                            </td>
                            <td>
                                <div style="font-weight: 500;">
                                    {{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center; color:#888; padding:40px 0;">
                                <i class="fas fa-info-circle" style="font-size:22px; color:#4361ee;"></i>
                                <div style="margin-top:8px; font-size:16px;">Tidak ada data inspeksi ditemukan.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </main>

        <div class="footer">
            <div class="footer-time" id="footerTime"></div>
            <p><span id="footerDate"></span> © Created By Digitalization 2025.</p>
        </div>
    </div>

    <!-- Modal for image preview -->
    <div id="imageModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <div class="modal-image-container">
                <img id="modalImage" class="modal-image" src="" alt="Inspection Photo">
            </div>
            <div class="modal-details">
                <h3 class="modal-title" id="modalArea"></h3>
                <div class="modal-description" id="modalDescription"></div>
                <div class="modal-meta">
                    <div class="modal-meta-item">
                        <div class="modal-meta-label">Risk Level</div>
                        <div class="modal-meta-value" id="modalRisk"></div>
                    </div>
                    <div class="modal-meta-item">
                        <div class="modal-meta-label">Person In Charge</div>
                        <div class="modal-meta-value" id="modalPic"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to update time and date
        function updateDateTime() {
            const now = new Date();

            // Format time (HH:MM:SS)
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');
            const timeString = `${hours}:${minutes}:${seconds}`;

            // Format day
            const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const dayName = days[now.getDay()];

            // Format date (Month Day, Year)
            const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
                'October', 'November', 'December'
            ];
            const monthName = months[now.getMonth()];
            const date = now.getDate();
            const year = now.getFullYear();
            const dateString = `${dayName}, ${monthName} ${date}, ${year}`;

            // Update elements
            document.getElementById('currentTime').textContent = timeString;
            document.getElementById('currentDate').textContent = dateString;
            document.getElementById('footerDate').textContent = dateString;
        }

        // Initialize and update every second
        updateDateTime();
        setInterval(updateDateTime, 1000);

        // Image Modal Functionality
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        const modalArea = document.getElementById('modalArea');
        const modalDescription = document.getElementById('modalDescription');
        const modalRisk = document.getElementById('modalRisk');
        const modalPic = document.getElementById('modalPic');
        const closeModal = document.querySelector('.close-modal');

        // Add click event to all inspection images
        document.querySelectorAll('.photo-cell img').forEach(img => {
            img.addEventListener('click', function() {
                // Set modal content
                modalImg.src = this.src;
                modalImg.alt = this.alt;
                modalArea.textContent = this.dataset.area;
                modalDescription.textContent = this.dataset.description;
                modalPic.textContent = this.dataset.pic;

                // Set risk level with appropriate styling
                const risk = this.dataset.risk.toLowerCase();
                modalRisk.innerHTML = '';
                const riskBadge = document.createElement('span');

                if (risk === 'critical') {
                    riskBadge.className = 'risk-high';
                    riskBadge.style.background = 'rgba(220,53,69,0.15)';
                    riskBadge.style.color = '#dc3545';
                    riskBadge.innerHTML = '<i class="fas fa-skull-crossbones"></i> Critical';
                } else if (risk === 'high') {
                    riskBadge.className = 'risk-high';
                    riskBadge.innerHTML = '<i class="fas fa-exclamation-triangle"></i> High';
                } else if (risk === 'medium') {
                    riskBadge.className = 'risk-medium';
                    riskBadge.innerHTML = '<i class="fas fa-exclamation-circle"></i> Medium';
                } else {
                    riskBadge.className = 'risk-low';
                    riskBadge.innerHTML = '<i class="fas fa-check-circle"></i> Low';
                }

                modalRisk.appendChild(riskBadge);

                // Show modal
                modal.classList.add('show');
                document.body.style.overflow = 'hidden'; // Prevent scrolling
            });
        });

        // Close modal when clicking X
        closeModal.addEventListener('click', function() {
            modal.classList.remove('show');
            document.body.style.overflow = 'auto'; // Re-enable scrolling
        });

        // Close modal when clicking outside content
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.classList.remove('show');
                document.body.style.overflow = 'auto'; // Re-enable scrolling
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.classList.contains('show')) {
                modal.classList.remove('show');
                document.body.style.overflow = 'auto'; // Re-enable scrolling
            }
        });

        // Make table horizontally scrollable on mobile
        if (window.innerWidth <= 768) {
            const tableWrapper = document.createElement('div');
            tableWrapper.style.overflowX = 'auto';
            tableWrapper.style.width = '100%';
            const table = document.querySelector('table');
            table.parentNode.insertBefore(tableWrapper, table);
            tableWrapper.appendChild(table);
        }

        // CSV Download Functionality
        function exportData() {
            // Kirim data via AJAX
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
                    // Buat link untuk download file
                    const blob = new Blob([response]);
                    const link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    const now = new Date();
                    const yyyy = now.getFullYear();
                    const mm = String(now.getMonth() + 1).padStart(2, '0');
                    const dd = String(now.getDate()).padStart(2, '0');
                    const dateStr = `${yyyy}${mm}${dd}`;
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
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                // Get all text content from the row (except images)
                const rowText = Array.from(row.querySelectorAll('td:not(.photo-cell)'))
                    .map(td => td.textContent.toLowerCase())
                    .join(' ');

                // Show/hide row based on search match
                if (rowText.includes(searchTerm)) {
                    row.style.display = '';
                    row.classList.add('search-match');
                } else {
                    row.style.display = 'none';
                }
            });

            // Highlight search matches (optional)
            if (searchTerm.length > 0) {
                highlightSearchMatches(searchTerm);
            } else {
                removeSearchHighlights();
            }
        });

        // Function to highlight search matches in the visible rows
        function highlightSearchMatches(searchTerm) {
            const visibleRows = document.querySelectorAll('tbody tr:not([style*="display: none"])');

            visibleRows.forEach(row => {
                const cells = row.querySelectorAll('td:not(.photo-cell)');

                cells.forEach(cell => {
                    const originalText = cell.textContent;
                    const highlightedText = originalText.replace(
                        new RegExp(searchTerm, 'gi'),
                        match => `<span class="search-highlight">${match}</span>`
                    );

                    // Only update if there's actually a match to avoid unnecessary DOM updates
                    if (highlightedText !== originalText) {
                        cell.innerHTML = highlightedText;
                    }
                });
            });
        }

        // Function to remove search highlights
        function removeSearchHighlights() {
            const highlights = document.querySelectorAll('.search-highlight');

            highlights.forEach(highlight => {
                const parent = highlight.parentNode;
                parent.textContent = parent.textContent; // This effectively removes all HTML tags
            });
        }
    </script>
    <script>
    // Auto refresh page every 5 minutes (300000 ms)
    setTimeout(function() {
        window.location.reload();
    }, 300000);
</script>
</body>

</html>
