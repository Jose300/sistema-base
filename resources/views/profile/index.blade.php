@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
<div class="page-header d-print-none mb-3">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    <i class="ti ti-user me-2 text-primary"></i>Mi Perfil
                </h2>
                <div class="text-secondary mt-1">Administra tu información personal y ajustes de seguridad</div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="ti ti-check fs-2 me-2"></i>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="ti ti-alert-triangle fs-2 me-2"></i>
                    <div>
                        <strong>Ha ocurrido un error con los datos ingresados:</strong>
                        <ul class="mb-0 mt-1 ps-3">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row row-cards">
            <!-- Summary card -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm text-center p-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <span class="avatar avatar-xl rounded-circle fw-bold text-primary border border-primary border-2 bg-primary-lt mx-auto" style="font-size: 1.8rem; width: 80px; height: 80px; line-height: 80px;">
                                {{ collect(explode(' ', $user->name))->map(fn($n) => $n[0])->take(2)->join('') }}
                            </span>
                        </div>
                        <h3 class="card-title mb-1 fs-2">{{ $user->name }}</h3>
                        <p class="text-secondary mb-3">{{ $user->email }}</p>
                        
                        <div class="d-flex justify-content-center gap-2 mb-3">
                            <span class="badge bg-blue-lt text-uppercase px-3 py-2 fw-bold">
                                {{ $user->getRoleNames()->first() ?? 'Usuario' }}
                            </span>
                            <span class="badge {{ $user->status === 'Activo' ? 'bg-success-lt' : 'bg-danger-lt' }} px-3 py-2 fw-bold">
                                {{ $user->status ?? 'Activo' }}
                            </span>
                        </div>

                        <hr class="my-3">

                        <div class="text-start small text-secondary">
                            <div class="d-flex align-items-center mb-2">
                                <i class="ti ti-calendar me-2 fs-2 text-muted"></i>
                                <span>Miembro desde: <strong>{{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}</strong></span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="ti ti-shield-check me-2 fs-2 text-muted"></i>
                                <span>Estado de cuenta: <strong>{{ $user->status ?? 'Activo' }}</strong></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit profile form -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h3 class="card-title fw-bold">
                            <i class="ti ti-edit me-2 text-primary"></i>Editar Información
                        </h3>
                    </div>
                    <form action="{{ route('perfil.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="card-body">
                            <h4 class="text-uppercase text-secondary fw-bold mb-3" style="font-size: 0.75rem; letter-spacing: 0.05em;">
                                Datos Personales
                            </h4>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label required">Nombre Completo</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-user"></i>
                                        </span>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label required">Correo Electrónico</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-mail"></i>
                                        </span>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <hr class="my-4">

                            <h4 class="text-uppercase text-secondary fw-bold mb-2" style="font-size: 0.75rem; letter-spacing: 0.05em;">
                                Cambiar Contraseña <span class="text-muted font-normal">(Opcional)</span>
                            </h4>
                            <p class="text-secondary small mb-3">Deja estos campos en blanco si no deseas cambiar tu contraseña actual.</p>

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label">Contraseña Actual</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-lock"></i>
                                        </span>
                                        <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Ingresa tu contraseña actual">
                                    </div>
                                    @error('current_password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Nueva Contraseña</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-key"></i>
                                        </span>
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Mínimo 8 caracteres">
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Confirmar Nueva Contraseña</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <i class="ti ti-key"></i>
                                        </span>
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="Repite la nueva contraseña">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-light text-end py-3">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="ti ti-device-floppy me-1"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
