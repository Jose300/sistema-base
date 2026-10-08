@extends('layouts.app')

@section('title', 'Gestión de Permisos')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Gestión de Permisos por Rol
                </h2>
                <div class="text-secondary mt-1">Configuración / Permisos</div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="card border-0 shadow-sm">
            <div class="card-body border-bottom py-3">
                <div class="d-flex">
                    <div class="text-secondary">
                        Mostrar
                        <div class="mx-2 d-inline-block">
                            <input type="text" class="form-control form-control-sm" value="10" size="3">
                        </div>
                        registros
                    </div>
                    <div class="ms-auto text-secondary">
                        Buscar:
                        <div class="ms-2 d-inline-block">
                            <input type="text" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap datatable table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-bottom-0 text-start fw-bold ps-3">PERMISO</th>
                            @foreach($roles as $role)
                            <th class="border-bottom-0 text-center fw-bold">{{ strtoupper($role->name) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permissions as $permission)
                        <tr>
                            <td class="text-start ps-3">
                                <span class="text-body fw-medium">{{ $permission->name }}</span>
                            </td>
                            @foreach($roles as $role)
                            <td class="text-center">
                                <label class="form-check form-switch d-inline-block">
                                    <input class="form-check-input permission-toggle" type="checkbox" 
                                           data-role-id="{{ $role->id }}" 
                                           data-permission-id="{{ $permission->id }}"
                                           {{ $role->hasPermissionTo($permission) ? 'checked' : '' }}>
                                    <span class="form-check-label">{{ $role->hasPermissionTo($permission) ? 'ON' : 'OFF' }}</span>
                                </label>
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex align-items-center">
                <p class="m-0 text-secondary">Mostrando registros del <span>1</span> al <span>{{ $permissions->count() }}</span> de un total de <span>{{ $permissions->total() }}</span> registros</p>
                <div class="pagination m-0 ms-auto">
                    {{ $permissions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast for feedback -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
    <div id="permission-toast" class="toast align-items-center border-0 shadow-lg bg-white" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex p-2">
            <div class="toast-icon me-3 d-flex align-items-center justify-content-center bg-success-lt rounded-circle" style="width: 40px; height: 40px;">
                <i class="ti ti-check text-success fs-2"></i>
            </div>
            <div class="toast-body d-flex align-items-center fw-bold text-dark" id="toast-message" style="font-size: 0.95rem;">
                Permiso actualizado correctamente.
            </div>
            <button type="button" class="btn-close ms-auto me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="progress progress-sm">
            <div class="progress-bar bg-success" id="toast-progress" style="width: 100%"></div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggles = document.querySelectorAll('.permission-toggle');
        const toastEl = document.getElementById('permission-toast');
        const toastMsg = document.getElementById('toast-message');
        const toast = new bootstrap.Toast(toastEl);

        toggles.forEach(toggle => {
            toggle.addEventListener('change', function() {
                const roleId = this.dataset.roleId;
                const permissionId = this.dataset.permissionId;
                const isChecked = this.checked;
                const label = this.nextElementSibling;
                
                // Temporary visual update
                label.textContent = isChecked ? 'ON' : 'OFF';

                fetch("{{ route('permisos.toggle') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        role_id: roleId,
                        permission_id: permissionId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    const iconBox = document.querySelector('.toast-icon');
                    const icon = iconBox.querySelector('i');
                    const progressBar = document.getElementById('toast-progress');

                    if (data.success) {
                        iconBox.className = 'toast-icon me-3 d-flex align-items-center justify-content-center bg-success-lt rounded-circle';
                        icon.className = 'ti ti-check text-success fs-2';
                        progressBar.className = 'progress-bar bg-success';
                        toastMsg.textContent = data.message;
                    } else {
                        iconBox.className = 'toast-icon me-3 d-flex align-items-center justify-content-center bg-danger-lt rounded-circle';
                        icon.className = 'ti ti-x text-danger fs-2';
                        progressBar.className = 'progress-bar bg-danger';
                        toastMsg.textContent = data.message;
                        // Revert visual
                        this.checked = !isChecked;
                        label.textContent = !isChecked ? 'ON' : 'OFF';
                    }
                    
                    // Simple progress bar animation
                    progressBar.style.width = '100%';
                    toast.show();
                    
                    setTimeout(() => {
                        progressBar.style.transition = 'width 3s linear';
                        progressBar.style.width = '0%';
                    }, 100);
                })
                .catch(error => {
                    const iconBox = document.querySelector('.toast-icon');
                    const icon = iconBox.querySelector('i');
                    const progressBar = document.getElementById('toast-progress');

                    iconBox.className = 'toast-icon me-3 d-flex align-items-center justify-content-center bg-danger-lt rounded-circle';
                    icon.className = 'ti ti-alert-triangle text-danger fs-2';
                    progressBar.className = 'progress-bar bg-danger';
                    toastMsg.textContent = 'Error de conexión.';
                    this.checked = !isChecked;
                    label.textContent = !isChecked ? 'ON' : 'OFF';
                    toast.show();
                });
            });
        });
    });
</script>
@endpush
