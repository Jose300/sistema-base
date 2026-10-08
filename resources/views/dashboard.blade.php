@extends('layouts.app')

@section('title', 'Resumen general')

@section('content')
<div class="row row-deck row-cards">
    <!-- Welcome Card -->
    <div class="col-12">
        <div class="card card-md border-0 shadow-sm overflow-hidden">
            <div class="row g-0">
                <div class="col-8">
                    <div class="card-body">
                        <h2 class="h1 mb-3">¡Bienvenido de nuevo, {{ auth()->user()->name }}!</h2>
                        <p class="text-secondary">Tu tienda tiene movimientos hoy. Tienes <span class="text-primary fw-bold">12 nuevas ventas</span> y <span class="text-primary fw-bold">5 productos con stock bajo</span>. Revisa los últimos detalles abajo.</p>
                        <div class="mt-4">
                            <a href="#" class="btn btn-primary">Ver Reporte Diario</a>
                        </div>
                    </div>
                </div>
                <div class="col-4 d-none d-md-block text-center bg-primary-lt">
                    <div class="p-4">
                        <i class="ti ti-brand-tabler text-primary" style="font-size: 8rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats widgets -->
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Usuarios Totales</div>
                </div>
                <div class="h1 mb-3">75,782</div>
                <div id="chart-users" class="chart-sm"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Ventas Hoy</div>
                </div>
                <div class="h1 mb-3">6,782 <span class="text-green h4 fw-bold">+7%</span></div>
                <div id="chart-sales" class="chart-sm"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Ganancia</div>
                </div>
                <div class="h1 mb-3">$4,300 <span class="text-green h4 fw-bold">+8%</span></div>
                <div id="chart-revenue" class="chart-sm"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="subheader">Clientes Activos</div>
                </div>
                <div class="h1 mb-3">2,986 <span class="text-red h4 fw-bold">-1%</span></div>
                <div id="chart-clients" class="chart-sm"></div>
            </div>
        </div>
    </div>

    <!-- Main Charts -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h3 class="card-title">Resumen de Tráfico</h3>
                <div id="traffic-summary" style="height: 300px;"></div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header border-0 pb-0">
                <h3 class="card-title">Actividades Recientes</h3>
            </div>
            <div class="card-body pt-2">
                <div class="list-group list-group-flush list-group-hoverable">
                    <div class="list-group-item px-0">
                        <div class="row align-items-center">
                            <div class="col-auto"><span class="badge bg-green"></span></div>
                            <div class="col text-truncate">
                                <a href="#" class="text-body d-block">Nueva venta #324</a>
                                <div class="d-block text-secondary text-truncate mt-n1">
                                    Hace 15 minutos
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item px-0">
                        <div class="row align-items-center">
                            <div class="col-auto"><span class="badge bg-yellow"></span></div>
                            <div class="col text-truncate">
                                <a href="#" class="text-body d-block">Stock bajo: Arroz 1kg</a>
                                <div class="d-block text-secondary text-truncate mt-n1">
                                    Hace 1 hora
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item px-0">
                        <div class="row align-items-center">
                            <div class="col-auto"><span class="badge bg-blue"></span></div>
                            <div class="col text-truncate">
                                <a href="#" class="text-body d-block">Nuevo cliente registrado</a>
                                <div class="d-block text-secondary text-truncate mt-n1">
                                    Hace 3 horas
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item px-0 text-center">
                        <a href="#" class="btn btn-ghost-primary btn-sm mt-2">Ver todas las actividades</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Sparklines configurations
        const sparklineOptions = {
            chart: { type: 'area', height: 40, sparkline: { enabled: true }, animations: { enabled: true } },
            stroke: { width: 2, curve: 'smooth' },
            fill: { opacity: 0.1 },
            tooltip: { enabled: false },
            colors: ['#206bc4']
        };

        // Users Chart
        new ApexCharts(document.querySelector("#chart-users"), {
            ...sparklineOptions,
            series: [{ data: [15, 10, 20, 18, 25, 30, 20, 35] }]
        }).render();

        // Sales Chart
        new ApexCharts(document.querySelector("#chart-sales"), {
            ...sparklineOptions,
            colors: ['#2fb344'],
            series: [{ data: [5, 10, 8, 15, 10, 12, 18, 20] }]
        }).render();

        // Revenue Chart
        new ApexCharts(document.querySelector("#chart-revenue"), {
            ...sparklineOptions,
            colors: ['#206bc4'],
            series: [{ data: [30, 45, 35, 50, 40, 60, 55, 70] }]
        }).render();

        // Clients Chart
        new ApexCharts(document.querySelector("#chart-clients"), {
            ...sparklineOptions,
            colors: ['#d63939'],
            series: [{ data: [20, 15, 18, 10, 15, 12, 10, 8] }]
        }).render();

        // Traffic Summary Table/Chart
        new ApexCharts(document.querySelector("#traffic-summary"), {
            chart: { type: 'bar', height: 300, toolbar: { show: false } },
            plotOptions: { bar: { columnWidth: '50%', borderRadius: 4 } },
            colors: ['#206bc4'],
            series: [{ name: 'Ventas', data: [44, 55, 57, 56, 61, 58, 63, 60, 66] }],
            xaxis: { categories: ['Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom'] },
            grid: { strokeDashArray: 4 },
        }).render();
    });
</script>
@endpush
