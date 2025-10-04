<!DOCTYPE html>
<html lang="en">
<<<<<<< HEAD

=======
>>>>>>> ec031a190c7dd3a7601fa865f2938e0b916bb5b3
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
<<<<<<< HEAD
        body,
        html {
            height: 100%;
            margin: 0;
        }

        .login-wrapper {
            display: flex;
            height: 100vh;
            flex-direction: row;
        }

        .login-left {
            background-color: #1f2a44;
            /* Dark navy */
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            flex: 1;
            padding: 2rem;
        }

        .login-left img {
            max-width: 250px;
            width: 100%;
            height: auto;
        }

        .login-right {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #fff;
            padding: 2rem;
        }

        .login-box {
            width: 100%;
            max-width: 380px;
        }

        .login-box h3 {
            margin-bottom: 1.5rem;
            font-weight: 600;
            text-align: left;
        }

        .form-control {
            background: #f1f5fb;
            border: none;
            border-radius: 6px;
            padding: 10px 12px;
        }

        .btn-primary {
            background-color: #5ca2f5;
            border: none;
            border-radius: 6px;
            padding: 10px;
        }

        .login-box .alert {
            position: relative;
            font-size: 14px;
            padding: 10px 12px;
            padding-right: 48px;
            margin-bottom: 1rem;
            border-radius: 6px;
        }

        .login-box .alert .btn-close {
            position: absolute;
            top: 10px;
            right: 12px;
            width: 1.25rem;
            height: 1.25rem;
            opacity: 0.8;
        }

        @media (max-width: 420px) {
            .login-box .alert {
                padding-right: 56px;
            }

            .login-box .alert .btn-close {
                right: 8px;
                top: 8px;
            }
        }

        /* Mobile view (stacked layout) */
        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
            }

            .login-left {
                flex: none;
                height: 250px;
            }
        }
    </style>
</head>

<body>
    <div class="login-wrapper">

        <!-- Left Side (Logo) -->
        <div class="login-left">
            <img src="{{ asset('assets/images/dotsquareLogo.png') }}" alt="Logo">
        </div>

        <!-- Right Side (Form) -->
        <div class="login-right">
            <div class="login-box">
                <!-- Success message  -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Validation Errors  -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                <h3>Login</h3>
                <form method="POST" action="{{ url('admin/login') }}">
                    @csrf
                    <div class="mb-3">
                        <input type="text" class="form-control" name="username" placeholder="Email address" value="{{ old('username') }}" autofocus>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

=======
        body {
            background: #f7f9fc;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-container {
            background: white;
            padding: 2rem 3rem;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-container h2 {
            margin-bottom: 1.5rem;
            text-align: center;
            font-weight: 600;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form method="POST" action="{{url('admin/login')}}">
            <!-- CSRF token for Laravel -->
            @csrf

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="username" 
                    name="username" 
                    placeholder="Enter username" 
                    required
                    autofocus
                >
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input 
                    type="password" 
                    class="form-control" 
                    id="password" 
                    name="password" 
                    placeholder="Enter password" 
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>

    <!-- Bootstrap JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
>>>>>>> ec031a190c7dd3a7601fa865f2938e0b916bb5b3
</html>
