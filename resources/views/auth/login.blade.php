@extends('layouts.guest')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="card card-md border-0 shadow-sm">
    <div class="card-body">
        <h2 class="h2 text-center mb-4">Ingresa a tu cuenta</h2>
        <form action="{{ route('login') }}" method="post" autocomplete="off" novalidate>
            @csrf
            <div class="mb-3">
                <label class="form-label">Correo Electrónico</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="tu@email.com" value="{{ old('email') }}" required autofocus>
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-2">
                <label class="form-label">
                    Contraseña
                    {{-- <span class="form-label-description">
                        <a href="./forgot-password.html">Olvidé mi contraseña</a>
                    </span> ----}}
                </label>
                <div class="input-group input-group-flat">
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Tu contraseña" autocomplete="off" required>
                    <span class="input-group-text">
                        <a href="javascript:void(0)" id="toggle-password" class="link-secondary" title="Mostrar contraseña" data-bs-toggle="tooltip">
                            <i class="ti ti-eye" id="toggle-icon"></i>
                        </a>
                    </span>
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="mb-2">
                <label class="form-check">
                    <input type="checkbox" name="remember" class="form-check-input" />
                    <span class="form-check-label">Recordarme en este equipo</span>
                </label>
            </div>
            <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100 py-2">
                    <i class="ti ti-login me-2"></i> Iniciar Sesión
                </button>
            </div>
        </form>
    </div>

</div>
{{-- <div class="text-center text-secondary mt-3">
    ¿Aún no tienes cuenta? <a href="./sign-up.html" tabindex="-1">Regístrate</a>
</div> --}}
@endsection

@push('js')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const togglePassword = document.querySelector('#toggle-password');
        const passwordInput = document.querySelector('#password');
        const toggleIcon = document.querySelector('#toggle-icon');

        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function() {
                // toggle the type attribute
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // toggle the eye / eye-off icon
                if (type === 'text') {
                    toggleIcon.classList.remove('ti-eye');
                    toggleIcon.classList.add('ti-eye-off');
                } else {
                    toggleIcon.classList.remove('ti-eye-off');
                    toggleIcon.classList.add('ti-eye');
                }
            });
        }
    });
</script>
@endpush