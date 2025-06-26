<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GENBA Walk - PT Autoplastik Indonesia</title>
    <!-- Bootstrap 5 CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #005BAA;
            --secondary-color: #00A859;
            --accent-color: #FFC107;
            --dark-color: #343A40;
            --light-color: #F8F9FA;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: #333;
        }
        
        .container {
            max-width: 800px;
            padding-bottom: 2rem;
        }
        
        .genba-header {
            background: linear-gradient(135deg, var(--primary-color), #003A6E);
            color: white;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 4px 12px rgba(0, 91, 170, 0.2);
            padding: 1.2rem 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-color), #003A6E);
            padding: 1rem 1.5rem;
            border-bottom: none;
            color:white;
        }
        
        .photo-preview {
            border: 2px dashed var(--primary-color);
            background-color: var(--light-color);
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
            min-height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }
        
        .photo-preview:hover {
            border-color: var(--secondary-color);
            background-color: rgba(0, 168, 89, 0.05);
        }
        
        .photo-preview i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .btn-camera {
            background-color: var(--primary-color);
            color: white;
            border: none;
            transition: all 0.3s ease;
        }
        
        .btn-camera:hover {
            background-color: #00458C;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 91, 170, 0.2);
        }
        
        .btn-gallery {
            background-color: var(--dark-color);
            color: white;
            border: none;
            transition: all 0.3s ease;
        }
        
        .btn-gallery:hover {
            background-color: #495057;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(108, 117, 125, 0.2);
        }
        
        .btn-submit {
            background: linear-gradient(135deg, var(--secondary-color), #00874A);
            opacity: 1 !important;
            color: white;
            font-weight: 600;
            border: none;
            padding: 0.75rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 168, 89, 0.2);
            margin-top: -20px;
            margin-bottom: 20px;
            width: 100%;
        }
        
        .btn-submit:hover {
            background: linear-gradient(135deg, #00874A, var(--secondary-color));
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 168, 89, 0.3);
            color: white;
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 1px solid #ced4da;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(0, 91, 170, 0.25);
        }
        
        .form-label {
            font-weight: 600;
            color: var(--dark-color);
        }
        
        .badge-version {
            background-color: var(--accent-color);
            color: var(--dark-color);
            font-weight: 600;
        }
        
        .footer {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .photo-actions {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 10;
        }
        
        .photo-actions .btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }
        
        @media (max-width: 576px) {
            .btn-group-responsive {
                flex-direction: column;
            }
            
            .btn-group-responsive .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }
            
            .btn-group-responsive .btn:last-child {
                margin-bottom: 0;
            }
        }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .card {
            animation: fadeIn 0.5s ease-out forwards;
        }
        
        /* Loading spinner */
        .spinner-container {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }
        
        .spinner {
            width: 3rem;
            height: 3rem;
        }
    </style>
</head>
<body>
    <!-- Loading Spinner -->
    <div class="spinner-container">
        <div class="spinner-border text-light spinner" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="container py-4">
        <!-- Header -->
        <div class="genba-header shadow">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h4 mb-1">
                        <i class="fas fa-industry me-2"></i>GENBA WALK - PT AUTOPLASTIK INDONESIA
                    </h1>
                    <p class="small mb-0 opacity-75">Continuous Improvement Through Direct Observation</p>
                </div>
                <img src="{{ asset('img/company-logo.png') }}" style="width:10%; background:white; border-radius:20px; padding:10px;" alt="">
            </div>
        </div>

        <!-- Form Temuan -->
        <div class="card shadow-lg">
            <div class="card-header">
                <h2 class="h5 mb-0"><i class="fas fa-clipboard-check me-2"></i>Form Temuan GENBA</h2>
            </div>
            <div class="card-body">
                <form id="genbaForm" action="{{ route('form.repair.update' ,['id' => $data->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Nama PIC -->
                    <div class="mb-4">
                        <label for="area" class="form-label">ID FORM TEMUAN</label>
                        <input type="text" name="id" id="id" class="form-control" placeholder="Isi dengan nama lengkap" readonly value="{{ $data->id }}">
                    </div>

                    <!-- Foto Perbaikan -->
                    <div class="mb-4">
                        <label class="form-label">FOTO PERBAIKAN</label>
                        <div class="photo-preview p-3 mb-3" id="photoPreviewContainer">
                            <img id="photoPreview" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='300' viewBox='0 0 400 300'%3E%3Crect width='400' height='300' fill='%23f8f9fa'/%3E%3Ctext x='50%' y='50%' font-family='Arial' font-size='16' fill='%236c757d' text-anchor='middle'%3EKlik untuk menambahkan foto%3C/text%3E%3C/svg%3E" 
                                 class="img-fluid mb-2 d-none" style="max-height: 300px; width: 100%; object-fit: cover;">
                            <div id="photoPlaceholder" class="text-center">
                                <i class="fas fa-camera"></i>
                                <p class="text-muted mb-0 mt-2">Klik untuk menambahkan foto</p>
                            </div>
                            
                            <div class="photo-actions" id="photoActions" style="display: none;">
                                <button type="button" class="btn btn-danger btn-sm" id="btnRemovePhoto" title="Hapus foto">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="btn-group btn-group-responsive w-100" role="group">
                            <button type="button" class="btn btn-camera" id="btnCamera">
                                <i class="fas fa-camera me-2"></i>Ambil Foto
                            </button>
                            <button type="button" class="btn btn-gallery" id="btnGallery">
                                <i class="fas fa-images me-2"></i>Dari Galeri
                            </button>
                        </div>
                        <input type="file" id="photoInput" name="img_path_repair" accept="image/*" class="d-none" capture="environment">
                    </div>

                    <!-- Deskripsi Perbaikan -->
                    <div class="mb-4">
                        <label for="findingDescription" class="form-label">DESKRIPSI PERBAIKAN</label>
                        <textarea class="form-control" id="findingDescription" name="deskripsi_repair" rows="3" placeholder="Deskripsi lengkap temuan..." required></textarea>
                        <div class="form-text">Jelaskan secara rinci apa yang diperbaiki</div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-submit btn-lg w-100f">
                        <i class="fas fa-paper-plane me-2"></i>SUBMIT PERBAIKAN
                    </button>
                </form>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center footer">
            <p class="mb-1">© 2025 PT Autoplastik Indonesia</p>
            <p class="small mb-0">Created by Digitalization</p>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    
    <!-- Custom JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const photoInput = document.getElementById('photoInput');
            const photoPreview = document.getElementById('photoPreview');
            const photoPlaceholder = document.getElementById('photoPlaceholder');
            const photoPreviewContainer = document.getElementById('photoPreviewContainer');
            const photoActions = document.getElementById('photoActions');
            const btnCamera = document.getElementById('btnCamera');
            const btnGallery = document.getElementById('btnGallery');
            const btnRemovePhoto = document.getElementById('btnRemovePhoto');
            const spinnerContainer = document.querySelector('.spinner-container');
            
            // Click on photo container to trigger file input
            photoPreviewContainer.addEventListener('click', function() {
                photoInput.click();
            });
            
            // Handler Kamera
            btnCamera.addEventListener('click', function(e) {
                e.stopPropagation();
                photoInput.setAttribute('capture', 'environment');
                photoInput.click();
            });
            
            // Handler Galeri
            btnGallery.addEventListener('click', function(e) {
                e.stopPropagation();
                photoInput.removeAttribute('capture');
                photoInput.click();
            });
            
            // Handler Remove Photo
            btnRemovePhoto.addEventListener('click', function(e) {
                e.stopPropagation();
                photoInput.value = '';
                photoPreview.src = '';
                photoPreview.classList.add('d-none');
                photoPlaceholder.classList.remove('d-none');
                photoActions.style.display = 'none';
            });
            
            // Preview Foto
            photoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Validate file type
                    if (!file.type.match('image.*')) {
                        alert('Hanya file gambar yang diperbolehkan!');
                        return;
                    }
                    
                    // Validate file size (max 5MB)
                    if (file.size > 5 * 1024 * 1024) {
                        alert('Ukuran file maksimal 5MB!');
                        return;
                    }
                    
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        photoPreview.src = event.target.result;
                        photoPreview.classList.remove('d-none');
                        photoPlaceholder.classList.add('d-none');
                        photoActions.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                }
            });
            
            // Form Submission
            // Tampilkan notifikasi dari session (success/error) jika ada
            @if(session('success'))
                setTimeout(function() {
                    const successHtml = `
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>{{ session('success') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `;
                    document.getElementById('genbaForm').insertAdjacentHTML('beforebegin', successHtml);
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }, 300);
            @endif

            @if($errors->any())
                setTimeout(function() {
                    const errorHtml = `
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-times-circle me-2"></i>
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `;
                    document.getElementById('genbaForm').insertAdjacentHTML('beforebegin', errorHtml);
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }, 300);
            @endif

            // Spinner hanya untuk submit form (opsional, jika ingin tetap ada)
            document.getElementById('genbaForm').addEventListener('submit', function() {
                spinnerContainer.style.display = 'flex';
            });
            
            // Add animation to form elements on scroll
            const animateOnScroll = function() {
                const elements = document.querySelectorAll('.form-control, .form-select, .btn');
                elements.forEach(element => {
                    const elementPosition = element.getBoundingClientRect().top;
                    const screenPosition = window.innerHeight / 1.3;
                    
                    if (elementPosition < screenPosition) {
                        element.style.opacity = '1';
                        element.style.transform = 'translateY(0)';
                    }
                });
            };
            
            // Set initial state for animation
            document.querySelectorAll('.form-control, .form-select, .btn').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            });
            
            window.addEventListener('scroll', animateOnScroll);
            // Trigger once on load
            animateOnScroll();
        });
    </script>
</body>
</html>