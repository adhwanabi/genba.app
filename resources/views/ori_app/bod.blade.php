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
        
        th, td {
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
        }
        
        .photo-cell img:hover {
            transform: scale(1.8);
            z-index: 10;
            position: relative;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
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
            
            th, td {
                padding: 10px;
                min-width: 120px;
            }
            
            .photo-cell img {
                max-width: 100px;
            }
        }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
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
            <button class="btn btn-primary" id="downloadPdf">
                <i class="fas fa-download"></i> Download PDF
            </button>
            <button class="btn btn-outline">
                <i class="fas fa-share-alt"></i> Share Report
            </button>
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
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong>Cluster 1</strong>
                            <div style="font-size: 12px; color: #6c757d;">Zone A-12</div>
                        </td>
                        <td class="photo-cell">
                            <div class="photo-tooltip" data-tooltip="Click to enlarge">
                                <img src="{{ asset('img/ngadep_belakang.webp') }}" alt="Area photo">
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 500; margin-bottom: 5px;">Exposed Electrical Wiring</div>
                            <div style="font-size: 13px; color: #6c757d;">Electrical wiring exposed near wet area poses significant shock hazard. Immediate attention required.</div>
                        </td>
                        <td>
                            <span class="risk-high">
                                <i class="fas fa-exclamation-triangle"></i> High
                            </span> 
                        </td>
                        <td>
                            <div style="font-weight: 500;">Adhwa Cantik</div>
                            <div style="font-size: 12px; color: #6c757d;">Technical   Support Dept.</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Cluster 2</strong>
                            <div style="font-size: 12px; color: #6c757d;">Main Hallway</div>
                        </td>
                        <td class="photo-cell">
                            <div class="photo-tooltip" data-tooltip="Click to enlarge">
                                <img src="{{ asset('img/example2.jpg') }}" alt="Area photo">
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 500; margin-bottom: 5px;">Slippery Floor Surface</div>
                            <div style="font-size: 13px; color: #6c757d;">Recent cleaning has left residue that increases slip potential in high traffic area.</div>
                        </td>
                        <td>
                            <span class="risk-medium">
                                <i class="fas fa-exclamation-circle"></i> Medium
                            </span>
                        </td>
                        <td>
                            <div style="font-weight: 500;">John Doe</div>
                            <div style="font-size: 12px; color: #6c757d;">Facilities</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Warehouse</strong>
                            <div style="font-size: 12px; color: #6c757d;">Storage Area B</div>
                        </td>
                        <td class="photo-cell">
                            <div class="photo-tooltip" data-tooltip="Click to enlarge">
                                <img src="{{ asset('img/example3.jpg') }}" alt="Area photo">
                            </div>
                        </td>
                        <td>
                            <div style="font-weight: 500; margin-bottom: 5px;">Improper Material Stacking</div>
                            <div style="font-size: 13px; color: #6c757d;">Maximum height exceeded without proper securing, creating fall hazards.</div>
                        </td>
                        <td>
                            <span class="risk-high">
                                <i class="fas fa-exclamation-triangle"></i> High
                            </span>
                        </td>
                        <td>
                            <div style="font-weight: 500;">Jane Smith</div>
                            <div style="font-size: 12px; color: #6c757d;">Warehouse</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </main>
        
        <div class="footer">
            <div class="footer-time" id="footerTime"></div>
            <p><span id="footerDate"></span>  © Created By Digitalization 2025.</p>
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
            const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            const monthName = months[now.getMonth()];
            const date = now.getDate();
            const year = now.getFullYear();
            const dateString = `${dayName}, ${monthName} ${date}, ${year}`;
            
            // Update elements
            document.getElementById('currentTime').textContent = timeString;
            document.getElementById('currentDate').textContent = dateString;
        }
        
        // Initialize and update every second
        updateDateTime();
        setInterval(updateDateTime, 1000);
        
        // Make images clickable to view larger
        document.querySelectorAll('.photo-cell img').forEach(img => {
            img.addEventListener('click', function() {
                if (this.style.transform === 'scale(1.8)') {
                    this.style.transform = 'scale(1)';
                } else {
                    this.style.transform = 'scale(1.8)';
                    this.style.zIndex = '100';
                }
            });
            
            // Close enlarged image when clicking elsewhere
            document.addEventListener('click', function(e) {
                if (!img.contains(e.target)) {
                    img.style.transform = 'scale(1)';
                    img.style.zIndex = '1';
                }
            });
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
        
        // PDF Download Functionality
        document.getElementById('downloadPdf').addEventListener('click', function() {
            // Show loading state
            const btn = this;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Generating PDF...';
            btn.disabled = true;
            
            // Use html2canvas and jsPDF to generate PDF
            const { jsPDF } = window.jspdf;
            
            // Get the report content element
            const element = document.getElementById('report-content');
            
            // Options for html2canvas
            const options = {
                scale: 2, // Higher scale for better quality
                useCORS: true, // To handle external images if any
                allowTaint: true, // To handle external images if any
                scrollX: 0,
                scrollY: 0,
                windowWidth: document.documentElement.scrollWidth,
                windowHeight: document.documentElement.scrollHeight
            };
            
            // Generate the PDF
            html2canvas(element, options).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const pdf = new jsPDF({
                    orientation: 'portrait',
                    unit: 'mm'
                });
                
                // Calculate the PDF dimensions
                const imgWidth = pdf.internal.pageSize.getWidth() - 20; // 10mm margin on each side
                const imgHeight = (canvas.height * imgWidth) / canvas.width;
                
                let heightLeft = imgHeight;
                let position = 10; // Start 10mm from top
                
                // Add first page
                pdf.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
                heightLeft -= pdf.internal.pageSize.getHeight() - 30; // 20mm margin on bottom
                
                // Add additional pages if content is too long
                while (heightLeft >= 0) {
                    position = heightLeft - imgHeight;
                    pdf.addPage();
                    pdf.addImage(imgData, 'PNG', 10, position, imgWidth, imgHeight);
                    heightLeft -= pdf.internal.pageSize.getHeight() - 20;
                }
                
                // Save the PDF
                pdf.save('Safety_Inspection_Report_' + new Date().toISOString().slice(0, 10) + '.pdf');
                
                // Restore button state
                btn.innerHTML = originalText;
                btn.disabled = false;
            }).catch(error => {
                console.error('Error generating PDF:', error);
                alert('Error generating PDF. Please try again.');
                
                // Restore button state
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        });
    </script>
</body>
</html>