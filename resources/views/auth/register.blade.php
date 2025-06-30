<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register | Autoplastik Indonesia</title>
    <!-- Bootstrap 5 CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="{{ asset('css/bootstrap-icons.css') }}" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-hover: #3a56d4;
            --text-color: #2b2d42;
            --light-text: #8d99ae;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(207, 205, 205, 0.8);
            z-index: -1;
        }

        body {
            position: relative;
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            align-items: center;
            background-image: url('{{ asset("img/Gemba_Walk.jpg") }}');
            background-size: cover;
            background-position: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 100%;
        }

        .register-card {
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .register-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }

        .card-header {
            background-color: var(--primary-color);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .company-logo {
            width: 80px;
            height: 80px;
            object-fit: contain;
            margin-bottom: 1rem;
            border-radius: 50%;
            background: white;
            padding: 5px;
        }

        .register-title {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .register-subtitle {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 0;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #e0e3eb;
            background-color: #f9fafc;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
            background-color: white;
        }

        .form-control::placeholder {
            color: #b8bcc8;
        }

        .input-group-text {
            background-color: transparent;
            border-right: none;
        }

        .form-floating>label {
            padding: 0.8rem 1rem;
        }

        .form-floating>.form-control:not(:placeholder-shown)~label {
            transform: scale(0.85) translateY(-0.8rem) translateX(0.15rem);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 12px;
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
            color: var(--light-text);
            font-size: 0.85rem;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #e0e3eb;
        }

        .divider::before {
            margin-right: 10px;
        }

        .divider::after {
            margin-left: 10px;
        }

        @media (max-width: 576px) {
            .card-header {
                padding: 1.5rem;
            }

            .register-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="overlay"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card register-card">
                    <div class="card-header">
                        <img src="{{ asset('img/company-logo.png') }}" alt="Company Logo" class="company-logo">
                        <h1 class="register-title">Create Account</h1>
                        <p class="register-subtitle">Register to access the system</p>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif

                        <form method="POST" action="{{ route('register.post') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent"><i class="fas fa-user"></i></span>
                                    <input type="text" name="name" id="name" class="form-control ps-3" required
                                        placeholder="Enter your full name" value="{{ old('name') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="npk" class="form-label">Employee ID</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent"><i class="fas fa-id-card"></i></span>
                                    <input type="text" name="npk" id="npk" class="form-control ps-3" required
                                        placeholder="Enter your employee ID" value="{{ old('npk') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password" id="password" class="form-control ps-3" required
                                        placeholder="Create a password">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent"><i class="fas fa-lock"></i></span>
                                    <input type="password" name="password_confirmation" id="password_confirmation" 
                                        class="form-control ps-3" required placeholder="Confirm your password">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-3">Register</button>
                        </form>

                        <div class="divider">or</div>

                        <div class="text-center">
                            <p class="mb-0">Already have an account? <a href="{{ route('login') }}" class="text-decoration-none">Sign in</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>