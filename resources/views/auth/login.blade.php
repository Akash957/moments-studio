<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $siteName = \App\Models\Setting::get('site_name', 'Moments Studio');
        $siteLogo = \App\Models\Setting::get('site_logo', asset('assets/images/logo.png'));
        $words = explode(' ', $siteName);
        $initials = '';
        foreach($words as $w) { $initials .= strtoupper($w[0] ?? ''); }
    @endphp
    <title>Admin Login — {{ $siteName }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --color-gold: #c9a96e;
            --color-gold-light: #e8c98a;
            --color-gold-dark: #a07840;
            --bg-dark: #070708;
            --card-bg: rgba(18, 18, 22, 0.9);
        }

        * {
            box-sizing: border-box;
        }

        body {
            background-color: #050505;
            background-image: linear-gradient(rgba(0, 0, 0, 0.55), rgba(0, 0, 0, 0.65)), url("{{ asset('assets/images/admin-bg.jpg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            color: #ffffff;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
            padding: 1.5rem;
            position: relative;
            overflow-x: hidden;
        }

        /* Ambient Radial Background */
        .ambient-glow-1 {
            position: absolute;
            top: 30%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 550px;
            height: 550px;
            background: radial-gradient(circle, rgba(201, 169, 110, 0.15) 0%, rgba(0,0,0,0) 70%);
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
            animation: pulseAura 7s infinite alternate ease-in-out;
        }

        @keyframes pulseAura {
            0% { transform: translate(-50%, -50%) scale(0.85); opacity: 0.7; }
            100% { transform: translate(-50%, -50%) scale(1.1); opacity: 1; }
        }

        /* Login Card */
        .login-card {
            position: relative;
            z-index: 1;
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(201, 169, 110, 0.3);
            border-radius: 20px;
            padding: 2.5rem 2.25rem;
            width: 100%;
            max-width: 430px;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.85), 0 0 45px rgba(201, 169, 110, 0.12);
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-img-wrapper {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            padding: 3px;
            background: linear-gradient(135deg, var(--color-gold-light), var(--color-gold-dark));
            box-shadow: 0 8px 25px rgba(201, 169, 110, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.2rem auto;
        }

        .logo-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            background: #000;
        }

        .logo-fallback {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: #111;
            color: var(--color-gold);
            font-family: 'Cormorant Garamond', serif;
            font-weight: 700;
            font-size: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.8rem;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin: 0 0 0.25rem 0;
            line-height: 1.2;
        }

        .brand-subtitle {
            font-size: 0.75rem;
            color: var(--color-gold);
            letter-spacing: 3px;
            text-transform: uppercase;
            font-weight: 600;
        }

        /* Flex Input Groups (Prevents text overlap) */
        .form-group-custom {
            margin-bottom: 1.25rem;
        }

        .form-label-custom {
            font-size: 0.825rem;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            margin-bottom: 0.45rem;
            display: block;
        }

        .custom-input-group {
            display: flex;
            align-items: center;
            background: rgba(28, 28, 34, 0.85);
            border: 1px solid rgba(201, 169, 110, 0.25);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .custom-input-group:focus-within {
            border-color: var(--color-gold);
            box-shadow: 0 0 0 3px rgba(201, 169, 110, 0.2);
            background: rgba(34, 34, 42, 0.95);
        }

        .input-group-icon {
            padding: 0 0.75rem 0 1rem;
            color: var(--color-gold);
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .custom-input-field {
            flex: 1;
            background: transparent !important;
            border: none !important;
            outline: none !important;
            color: #ffffff !important;
            padding: 0.8rem 1rem 0.8rem 0;
            font-size: 0.925rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            box-shadow: none !important;
        }

        .custom-input-field::placeholder {
            color: rgba(255, 255, 255, 0.35);
        }

        /* Custom Checkbox */
        .custom-check-wrapper {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.825rem;
            color: rgba(255, 255, 255, 0.7);
            cursor: pointer;
            user-select: none;
        }

        .custom-checkbox {
            width: 16px;
            height: 16px;
            border: 1px solid rgba(201, 169, 110, 0.4);
            border-radius: 4px;
            accent-color: var(--color-gold);
            cursor: pointer;
        }

        /* Gold Submit Button */
        .btn-submit-gold {
            background: linear-gradient(135deg, #d4b478, #a07840);
            color: #070708;
            font-weight: 700;
            font-size: 0.9rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            border: none;
            border-radius: 12px;
            padding: 0.9rem;
            width: 100%;
            margin-top: 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(201, 169, 110, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-submit-gold:hover {
            background: linear-gradient(135deg, #e8c98a, #c9a96e);
            box-shadow: 0 10px 28px rgba(201, 169, 110, 0.45);
            transform: translateY(-1px);
            color: #000000;
        }

        .back-link {
            text-align: center;
            margin-top: 1.5rem;
        }

        .back-link a {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.825rem;
            text-decoration: none;
            transition: color 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .back-link a:hover {
            color: var(--color-gold);
        }

        /* Alerts */
        .alert-gold-error {
            background: rgba(220, 53, 69, 0.12);
            border: 1px solid rgba(220, 53, 69, 0.35);
            color: #ff7575;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 0.85rem;
            margin-bottom: 1.25rem;
        }

        .alert-gold-success {
            background: rgba(40, 167, 69, 0.12);
            border: 1px solid rgba(40, 167, 69, 0.35);
            color: #5dd885;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 0.85rem;
            margin-bottom: 1.25rem;
        }
    </style>
</head>
<body>

    <div class="ambient-glow-1"></div>

    <div class="login-card">
        <div class="login-header">
            <div class="logo-img-wrapper">
                <img src="{{ $siteLogo }}" alt="{{ $siteName }}" class="logo-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="logo-fallback" style="display:none;">{{ $initials ?: 'MS' }}</div>
            </div>
            <h1 class="brand-title">{{ $siteName }}</h1>
            <div class="brand-subtitle"><i class="fas fa-crown me-1" style="font-size:0.65rem;"></i> Admin Portal</div>
        </div>

        @if(session('success'))
            <div class="alert-gold-success">
                <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert-gold-error">
                <i class="fas fa-exclamation-circle me-1"></i> {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            
            <div class="form-group-custom">
                <label class="form-label-custom" for="email">Email Address</label>
                <div class="custom-input-group">
                    <span class="input-group-icon"><i class="fas fa-envelope"></i></span>
                    <input type="email" name="email" id="email" class="custom-input-field" placeholder="admin@momentsstudio.in" value="{{ old('email') }}" required autofocus>
                </div>
            </div>

            <div class="form-group-custom">
                <label class="form-label-custom" for="password">Password</label>
                <div class="custom-input-group">
                    <span class="input-group-icon"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" id="password" class="custom-input-field" placeholder="••••••••" required>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <label class="custom-check-wrapper" for="remember">
                    <input class="custom-checkbox" type="checkbox" name="remember" id="remember">
                    Remember Me
                </label>
            </div>

            <button type="submit" class="btn-submit-gold">
                <i class="fas fa-sign-in-alt me-1"></i> Sign In to Dashboard
            </button>
        </form>

        <div class="back-link">
            <a href="{{ url('/') }}">
                <i class="fas fa-arrow-left"></i> Back to Website
            </a>
        </div>
    </div>

</body>
</html>
