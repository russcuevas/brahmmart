<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brahmmart</title>
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/auth/login.css') }}">
</head>

<body>

    <div class="login-container">
        <!-- Left Side: Visual Content -->
        <div class="login-visual-panel">
            <div class="fb-logo-placeholder">
                <a href="/">
                    <img src="{{ asset('favicon.png') }}" alt="BRAHMMART">
                </a>
            </div>

            <div class="visual-content">
                <h1>
                    <span>Empowering</span>
                    <span>Brahman</span>
                    <span class="accent">Excellence.</span>
                </h1>

                <div class="floating-images">
                    <img src="{{ asset('assets/auth/login-visual.png') }}" alt="University Life">
                </div>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="login-form-panel">
            <div class="meta-footer" style="margin-bottom: 50px">
                <img style="height: 50px; width: 50px;" src="{{ asset('favicon.png') }}" alt=""> <br>
                <span style="font-weight: 900">UNIVERSITY OF BATANGAS</span>
            </div>
            <div class="login-card">
                <h2>Log into BRAHMMART</h2>

                <form action="{{ route('auth.login.request') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <input type="text" name="email" placeholder="Email" required value="{{ old('email') }}">
                    </div>

                    <div class="form-group">
                        <input type="password" name="password" placeholder="Password" required>
                    </div>

                    <button type="submit" class="btn-login">Log in</button>

                    <a href="#" class="forgot-password">Forgot password?</a>

                    <div class="divider"></div>

                    <a href="{{ route('auth.register.page') }}" class="btn-create-account">Create new account</a>
                </form>
            </div>


        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if (session('success'))
            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            });
        @endif

        @if (session('error'))
            Toast.fire({
                icon: 'error',
                title: "{{ session('error') }}"
            });
        @endif

        @if ($errors->any())
            Toast.fire({
                icon: 'error',
                title: "{{ $errors->first() }}"
            });
        @endif
    </script>

</body>

</html>
