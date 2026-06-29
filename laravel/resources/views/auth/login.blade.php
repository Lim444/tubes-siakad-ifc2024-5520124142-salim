<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Mahasiswa - SIAK</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <!-- Card Header -->
            <div class="login-card-header">
                <div class="lock-icon-svg">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                </div>
                <h1>Login Mahasiswa</h1>
            </div>

            <!-- Card Body -->
            <div class="login-card-body">
                <!-- Logo Section -->
                <div class="login-logo">
                    <div class="logo-image">
                        <img src="{{ asset('images/siakad.png') }}" alt="SIAK Logo">
                    </div>
                </div>

                <!-- Error Messages -->
                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <div class="alert alert-error">
                            <span>⚠️</span>
                            <span>{{ $error }}</span>
                        </div>
                    @endforeach
                @endif

                <!-- Form -->
                <form action="{{ route('login.post') }}" method="POST">
                    @csrf

                    <!-- Username -->
                    <div class="form-group">
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            placeholder="Username" 
                            value="{{ old('username') }}"
                            required
                        >
                        @error('username')
                            <div class="error-message">
                                <span>✕</span>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="••••••••" 
                            required
                        >
                        @error('password')
                            <div class="error-message">
                                <span>✕</span>
                                <span>{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="login-btn">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
