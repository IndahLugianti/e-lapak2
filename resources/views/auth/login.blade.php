<!-- resources/views/auth/login.blade.php -->
@extends('layouts.app')

@section('content')
<div class="login-container">
    <!-- Interactive Background -->
    <div class="animated-background">
        <div class="floating-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
            <div class="shape shape-4"></div>
            <div class="shape shape-5"></div>
            <div class="shape shape-6"></div>
        </div>
        <div class="particles-container" id="particles"></div>
        <div class="gradient-overlay"></div>
    </div>

    <!-- Login Content -->
    <div class="login-content">
        <div class="login-card">
            <!-- Logo Section -->
            <div class="login-header">
                <div class="header-decoration"></div>
                <img src="{{ asset('storage/logo-kemenag.png') }}" alt="Logo Kemenag" class="login-logo">
                <h4 class="login-title">E-Lapak Konut</h4>
                <p class="login-subtitle">Elektronik Layanan Kepegawaian</p>
                <div class="header-badge">
                    <i class="fas fa-shield-alt me-1"></i>
                    Kemenag Konawe Utara
                </div>
            </div>

            <!-- Login Form -->
            <div class="login-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- NIP Dropdown -->
                    <div class="mb-3">
                        <label for="nip" class="form-label mb-2">
                            <i class="fas fa-id-card me-2"></i>NIP
                        </label>
                        <select class="form-select custom-select @error('nip') is-invalid @enderror"
                                id="nip"
                                name="nip"
                                required
                                autofocus>
                            <option value="" disabled selected></option>
                            @foreach($users as $user)
                                <option value="{{ $user->nip }}"
                                        data-name="{{ $user->name }}"
                                        {{ old('nip') == $user->nip ? 'selected' : '' }}>
                                    <span class="nip-code">{{ $user->nip }}</span> - <span class="user-name">{{ $user->name }}</span>
                                </option>
                            @endforeach
                        </select>
                        @error('nip')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="form-floating mb-3">
                        <input type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               id="password"
                               name="password"
                               placeholder="Password"
                               required>
                        <label for="password">
                            <i class="fas fa-lock me-2"></i>Password
                        </label>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="form-check mb-3">
                        <input class="form-check-input"
                               type="checkbox"
                               name="remember"
                               id="remember"
                               {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            Ingat Saya
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary btn-login w-100 mb-3">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        Masuk
                    </button>

                    <!-- Forgot Password Link -->
                    @if (Route::has('password.request'))
                        <div class="text-center">
                            <a href="{{ route('password.request') }}" class="forgot-link">
                                Lupa Password?
                            </a>
                        </div>
                    @endif
                </form>
            </div>

            <!-- Footer -->
            <div class="login-footer">
                <small class="text-muted">
                    © {{ date('Y') }} Kemenag Konawe Utara
                </small>
            </div>
        </div>
    </div>
</div>

<style>
/* Interactive Login Container */
.login-container {
    height: 85vh;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    padding: 10px;
    background: linear-gradient(135deg,
        rgba(6, 95, 70, 0.1) 0%,
        rgba(16, 185, 129, 0.05) 50%,
        rgba(6, 95, 70, 0.1) 100%);
}

/* Animated Background */
.animated-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}

.gradient-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg,
        rgba(6, 95, 70, 0.03) 0%,
        rgba(255, 255, 255, 0.02) 50%,
        rgba(16, 185, 129, 0.03) 100%);
    z-index: 2;
}

/* Floating Shapes */
.floating-shapes {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}

.shape {
    position: absolute;
    border-radius: 50%;
    background: linear-gradient(135deg,
        rgba(6, 95, 70, 0.1) 0%,
        rgba(16, 185, 129, 0.15) 100%);
    animation: float 6s ease-in-out infinite;
    backdrop-filter: blur(10px);
}

.shape-1 {
    width: 80px;
    height: 80px;
    top: 10%;
    left: 10%;
    animation-delay: 0s;
    animation-duration: 8s;
}

.shape-2 {
    width: 120px;
    height: 120px;
    top: 60%;
    left: 85%;
    animation-delay: 1s;
    animation-duration: 10s;
    background: linear-gradient(135deg,
        rgba(16, 185, 129, 0.08) 0%,
        rgba(6, 95, 70, 0.12) 100%);
}

.shape-3 {
    width: 60px;
    height: 60px;
    top: 80%;
    left: 15%;
    animation-delay: 2s;
    animation-duration: 7s;
}

.shape-4 {
    width: 100px;
    height: 100px;
    top: 20%;
    left: 80%;
    animation-delay: 3s;
    animation-duration: 9s;
    background: linear-gradient(135deg,
        rgba(34, 197, 94, 0.06) 0%,
        rgba(6, 95, 70, 0.1) 100%);
}

.shape-5 {
    width: 70px;
    height: 70px;
    top: 50%;
    left: 5%;
    animation-delay: 4s;
    animation-duration: 11s;
}

.shape-6 {
    width: 90px;
    height: 90px;
    top: 30%;
    left: 70%;
    animation-delay: 5s;
    animation-duration: 8s;
    background: linear-gradient(135deg,
        rgba(6, 95, 70, 0.07) 0%,
        rgba(16, 185, 129, 0.09) 100%);
}

@keyframes float {
    0%, 100% {
        transform: translateY(0px) rotate(0deg);
        opacity: 0.7;
    }
    25% {
        transform: translateY(-20px) rotate(90deg);
        opacity: 0.8;
    }
    50% {
        transform: translateY(-40px) rotate(180deg);
        opacity: 0.6;
    }
    75% {
        transform: translateY(-20px) rotate(270deg);
        opacity: 0.9;
    }
}

/* Particles Container */
.particles-container {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}

.particle {
    position: absolute;
    background: rgba(6, 95, 70, 0.3);
    border-radius: 50%;
    pointer-events: none;
    animation: particle-float 4s linear infinite;
}

@keyframes particle-float {
    0% {
        opacity: 0;
        transform: translateY(0px) scale(0);
    }
    10% {
        opacity: 1;
        transform: translateY(-10px) scale(1);
    }
    90% {
        opacity: 1;
        transform: translateY(-90vh) scale(1);
    }
    100% {
        opacity: 0;
        transform: translateY(-100vh) scale(0);
    }
}

/* Login Content */
.login-content {
    position: relative;
    z-index: 10;
    width: 100%;
    max-width: 400px;
    padding: 20px;
}

/* Interactive Login Card */
.login-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    box-shadow: 0 15px 45px rgba(6, 95, 70, 0.15);
    overflow: hidden;
    border: 1px solid rgba(6, 95, 70, 0.1);
    position: relative;
    backdrop-filter: blur(20px);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    animation: cardFloat 3s ease-in-out infinite alternate;
}

.login-card:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 25px 60px rgba(6, 95, 70, 0.2);
}

@keyframes cardFloat {
    0% {
        transform: translateY(0px);
    }
    100% {
        transform: translateY(-10px);
    }
}


/* Login Header with Soft Green Theme */
.login-header {
    background: linear-gradient(135deg,
        rgba(6, 95, 70, 0.9) 0%,
        #065f46 50%,
        #064e3b 100%);
    color: white;
    padding: 30px 30px;
    text-align: center;
    position: relative;
    backdrop-filter: blur(10px);
}

.login-logo {
    height: 60px;
    margin-bottom: 15px;
    background: white;
    padding: 8px;
    border-radius: 8px;
    transition: transform 0.3s ease;
}

.login-logo:hover {
    transform: scale(1.05);
}

.login-title {
    font-weight: 700;
    margin-bottom: 8px;
    font-size: 24px;
    text-shadow: 0 1px 3px rgba(0,0,0,0.3);
}

.login-subtitle {
    opacity: 0.9;
    font-size: 14px;
    margin-bottom: 10px;
    font-weight: 400;
    text-shadow: 0 1px 2px rgba(0,0,0,0.2);
}

/* Simple Header Badge */
.header-badge {
    background: rgba(255, 255, 255, 0.25);
    padding: 6px 12px;
    border-radius: 15px;
    font-size: 12px;
    font-weight: 500;
    display: inline-block;
    margin-top: 8px;
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* Login Body */
.login-body {
    padding: 35px;
    position: relative;
}

/* Form Controls with Green Focus */
.form-floating > .form-control,
.form-floating > .form-select,
.form-select {
    border-radius: 8px;
    border: 1px solid #ced4da;
    padding: 1rem 0.75rem;
    height: calc(3.5rem + 2px);
    transition: all 0.3s ease;
    background-color: #fff;
}

.form-floating > .form-control:focus,
.form-floating > .form-select:focus,
.form-select:focus {
    border-color: #065f46 !important;
    box-shadow: 0 0 0 0.2rem rgba(6, 95, 70, 0.25) !important;
    background-color: rgba(255, 255, 255, 1) !important;
    outline: none !important;
}

/* Override default Bootstrap blue colors */
.form-select:focus,
.form-control:focus {
    border-color: #065f46 !important;
    box-shadow: 0 0 0 0.2rem rgba(6, 95, 70, 0.25) !important;
}

.form-select:focus option:checked,
.form-select:focus option[selected] {
    background-color: #065f46 !important;
    color: white !important;
}

/* Custom Select Styling */
.custom-select {
    background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(248,250,252,0.95) 100%) !important;
    color: #1f2937 !important;
    font-weight: 500;
    cursor: pointer;
    appearance: none !important;
    background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='%23065f46' d='M8 11.5l-4-4h8z'/%3E%3C/svg%3E") !important;
    background-repeat: no-repeat !important;
    background-position: right 0.75rem center !important;
    background-size: 16px !important;
    position: relative;
    z-index: 1;
    border: 2px solid #e5e7eb !important;
}

.custom-select:hover {
    background: linear-gradient(135deg, rgba(248,250,252,0.98) 0%, rgba(241,245,249,0.98) 100%) !important;
    border-color: #065f46 !important;
    box-shadow: 0 4px 12px rgba(6, 95, 70, 0.15) !important;
    transform: translateY(-1px);
}

.custom-select:focus {
    background: linear-gradient(135deg, rgba(255,255,255,1) 0%, rgba(248,250,252,1) 100%) !important;
    color: #065f46 !important;
    font-weight: 600;
    border-color: #065f46 !important;
    box-shadow: 0 0 0 3px rgba(6, 95, 70, 0.25) !important;
    transform: translateY(-1px);
    outline: none !important;
}

/* Enhanced Option Styling */
.custom-select option {
    background: linear-gradient(135deg, rgba(255,255,255,0.98) 0%, rgba(248,250,252,0.98) 100%);
    color: #1f2937;
    padding: 14px 18px;
    font-weight: 500;
    font-size: 14px;
    border: none;
    text-shadow: 0 1px 3px rgba(0,0,0,0.08);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    line-height: 1.4;
}

.custom-select option:first-child {
    color: #9ca3af;
    font-style: italic;
    background: linear-gradient(135deg, rgba(243,244,246,0.95) 0%, rgba(229,231,235,0.95) 100%);
    border-bottom: 2px solid rgba(6, 95, 70, 0.1);
    font-weight: 400;
}

.custom-select option:not(:first-child) {
    background: linear-gradient(135deg, rgba(255,255,255,0.98) 0%, rgba(248,250,252,0.98) 100%);
    border-top: 1px solid rgba(6, 95, 70, 0.08);
    position: relative;
}

.custom-select option:not(:first-child):hover {
    background: linear-gradient(135deg, rgba(6, 95, 70, 0.12) 0%, rgba(16, 185, 129, 0.12) 100%);
    color: #065f46;
    font-weight: 600;
    text-shadow: 0 1px 3px rgba(6, 95, 70, 0.2);
    box-shadow: inset 3px 0 0 #065f46;
}

.custom-select option:not(:first-child):focus,
.custom-select option:not(:first-child):active {
    background: linear-gradient(135deg, rgba(6, 95, 70, 0.15) 0%, rgba(16, 185, 129, 0.15) 100%);
    color: #065f46;
    font-weight: 600;
    box-shadow: inset 3px 0 0 #065f46, 0 0 0 2px rgba(6, 95, 70, 0.2);
    outline: none;
}

.custom-select option:not(:first-child):checked,
.custom-select option:not(:first-child)[selected] {
    background: linear-gradient(135deg, rgba(6, 95, 70, 0.18) 0%, rgba(16, 185, 129, 0.18) 100%);
    color: #065f46;
    font-weight: 700;
    text-shadow: 0 1px 3px rgba(6, 95, 70, 0.3);
    box-shadow: inset 4px 0 0 #065f46, 0 2px 8px rgba(6, 95, 70, 0.15);
    border-left: 4px solid #065f46;
}

/* Add subtle animation for options */
.custom-select option:not(:first-child)::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 0;
    background: linear-gradient(90deg, #065f46 0%, #10b981 100%);
    transition: width 0.3s ease;
}

.custom-select option:not(:first-child):hover::before {
    width: 3px;
}

/* NIP Code and Name Styling */
.custom-select option .nip-code {
    font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
    font-weight: 600;
    color: #065f46;
    background: rgba(6, 95, 70, 0.1);
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 13px;
    margin-right: 8px;
}

.custom-select option .user-name {
    color: #374151;
    font-weight: 500;
}

.custom-select option:hover .nip-code {
    background: rgba(6, 95, 70, 0.2);
    color: #064e3b;
}

.custom-select option:hover .user-name {
    color: #065f46;
    font-weight: 600;
}

.custom-select option:checked .nip-code,
.custom-select option[selected] .nip-code {
    background: rgba(6, 95, 70, 0.3);
    color: #064e3b;
    font-weight: 700;
}

.custom-select option:checked .user-name,
.custom-select option[selected] .user-name {
    color: #065f46;
    font-weight: 700;
}

/* Global override for all focus states to use green */
*:focus {
    outline: none !important;
    box-shadow: none !important;
}

.form-control:focus,
.form-select:focus,
.custom-select:focus {
    border-color: #065f46 !important;
    box-shadow: 0 0 0 0.25rem rgba(6, 95, 70, 0.25) !important;
    background-color: rgba(255, 255, 255, 1) !important;
}

/* Remove any blue focus rings */
input:focus,
select:focus,
textarea:focus,
button:focus {
    outline: none !important;
    box-shadow: 0 0 0 0.25rem rgba(6, 95, 70, 0.25) !important;
}

/* Ensure options use green highlight */
option:checked,
option[selected] {
    background-color: #065f46 !important;
    color: white !important;
}

.form-floating > label {
    color: #6c757d;
    padding: 1rem 0.75rem;
}

.form-floating > .form-control:focus ~ label,
.form-floating > .form-control:not(:placeholder-shown) ~ label {
    color: #065f46;
    transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
}

/* Regular form label styling */
.form-label {
    color: #065f46;
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 8px;
    display: block;
}

/* Soft Green Login Button */
.btn-login {
    background: linear-gradient(135deg,
        rgba(6, 95, 70, 0.9) 0%,
        #065f46 50%,
        #064e3b 100%);
    border: none;
    border-radius: 8px;
    padding: 12px;
    font-weight: 600;
    font-size: 16px;
    color: white;
    text-shadow: 0 1px 2px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(6, 95, 70, 0.2);
}

.btn-login:hover {
    background: linear-gradient(135deg,
        #065f46 0%,
        #064e3b 50%,
        #052e08 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(6, 95, 70, 0.3);
    color: white;
}

/* Soft Green Checkbox */
.form-check-input {
    border-radius: 4px;
}

.form-check-input:checked {
    background-color: #065f46;
    border-color: #065f46;
}

.form-check-input:focus {
    border-color: #065f46;
    box-shadow: 0 0 0 0.2rem rgba(6, 95, 70, 0.2);
}

.form-check-label {
    color: #6c757d;
}

/* Soft Green Forgot Link */
.forgot-link {
    color: #065f46;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.forgot-link:hover {
    color: #064e3b;
    text-decoration: underline;
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

/* Simple Login Footer */
.login-footer {
    background: #f8f9fa;
    padding: 20px;
    text-align: center;
    border-top: 1px solid #dee2e6;
}

/* Error Messages */
.invalid-feedback {
    font-size: 13px;
    margin-top: 5px;
}

/* Responsive */
@media (max-width: 576px) {
    .login-content {
        max-width: 95%;
        padding: 10px;
    }

    .login-header {
        padding: 20px;
    }

    .login-body {
        padding: 20px;
    }

    .login-logo {
        height: 50px;
    }

    .login-title {
        font-size: 20px;
    }
}

/* Very small screens */
@media (max-width: 350px) {
    .login-logo {
        height: 45px;
    }

    .login-title {
        font-size: 20px;
    }
}

/* Interactive Form Effects */
.form-control {
    transition: all 0.3s ease;
}

.form-control:focus {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(6, 95, 70, 0.15);
}

.btn-login {
    position: relative;
    overflow: hidden;
}

.btn-login::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.btn-login:hover::before {
    left: 100%;
}

/* Responsive Animations */
@media (max-width: 768px) {
    .shape {
        display: none;
    }

    .login-card {
        animation: none;
    }

    .login-card:hover {
        transform: none;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Create floating particles
    const particlesContainer = document.getElementById('particles');
    const particleCount = 50;

    function createParticle() {
        const particle = document.createElement('div');
        particle.className = 'particle';

        // Random size
        const size = Math.random() * 4 + 2;
        particle.style.width = size + 'px';
        particle.style.height = size + 'px';

        // Random position
        particle.style.left = Math.random() * window.innerWidth + 'px';
        particle.style.bottom = '-10px';

        // Random opacity and delay
        particle.style.opacity = Math.random() * 0.6 + 0.2;
        particle.style.animationDelay = Math.random() * 4 + 's';
        particle.style.animationDuration = (Math.random() * 6 + 4) + 's';

        particlesContainer.appendChild(particle);

        // Remove particle after animation
        setTimeout(() => {
            if (particlesContainer.contains(particle)) {
                particlesContainer.removeChild(particle);
            }
        }, 8000);
    }

    // Create initial particles
    for (let i = 0; i < particleCount; i++) {
        setTimeout(() => createParticle(), i * 200);
    }

    // Continuously create particles
    setInterval(createParticle, 800);

    // Mouse interaction with floating shapes
    const shapes = document.querySelectorAll('.shape');
    let mouseX = 0, mouseY = 0;

    document.addEventListener('mousemove', function(e) {
        mouseX = e.clientX;
        mouseY = e.clientY;

        shapes.forEach((shape, index) => {
            const rect = shape.getBoundingClientRect();
            const centerX = rect.left + rect.width / 2;
            const centerY = rect.top + rect.height / 2;

            const deltaX = mouseX - centerX;
            const deltaY = mouseY - centerY;
            const distance = Math.sqrt(deltaX * deltaX + deltaY * deltaY);

            // Repel effect when mouse is close
            if (distance < 200) {
                const force = (200 - distance) / 200;
                const moveX = (deltaX / distance) * force * -30;
                const moveY = (deltaY / distance) * force * -30;

                shape.style.transform = `translate(${moveX}px, ${moveY}px) rotate(${force * 360}deg)`;
                shape.style.opacity = 0.8 + force * 0.2;
            } else {
                shape.style.transform = '';
                shape.style.opacity = '';
            }
        });
    });

    // Login card tilt effect
    const loginCard = document.querySelector('.login-card');

    loginCard.addEventListener('mousemove', function(e) {
        const rect = this.getBoundingClientRect();
        const centerX = rect.left + rect.width / 2;
        const centerY = rect.top + rect.height / 2;

        const deltaX = e.clientX - centerX;
        const deltaY = e.clientY - centerY;

        const tiltX = (deltaY / rect.height) * -10;
        const tiltY = (deltaX / rect.width) * 10;

        this.style.transform = `perspective(1000px) rotateX(${tiltX}deg) rotateY(${tiltY}deg) translateY(-5px)`;
    });

    loginCard.addEventListener('mouseleave', function() {
        this.style.transform = '';
    });

    // Form input focus effects
    const inputs = document.querySelectorAll('.form-control');

    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.02)';
        });

        input.addEventListener('blur', function() {
            this.parentElement.style.transform = '';
        });
    });

    // Animated login button
    const loginBtn = document.querySelector('.btn-login');

    loginBtn.addEventListener('mouseenter', function() {
        // Create ripple effect
        const ripple = document.createElement('div');
        ripple.style.position = 'absolute';
        ripple.style.borderRadius = '50%';
        ripple.style.background = 'rgba(255,255,255,0.3)';
        ripple.style.transform = 'scale(0)';
        ripple.style.animation = 'ripple 0.6s linear';
        ripple.style.left = '50%';
        ripple.style.top = '50%';
        ripple.style.width = '20px';
        ripple.style.height = '20px';
        ripple.style.marginLeft = '-10px';
        ripple.style.marginTop = '-10px';

        this.appendChild(ripple);

        setTimeout(() => {
            if (this.contains(ripple)) {
                this.removeChild(ripple);
            }
        }, 600);
    });
});

// Add CSS for ripple animation
const style = document.createElement('style');
style.textContent = `
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
</script>
@endsection
