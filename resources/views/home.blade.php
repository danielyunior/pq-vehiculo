@extends('layouts.app')

@section('title', 'Panel de Control')

@push('styles')
<style>
    .dashboard-card {
        background: #ffffff;
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.05);
        transition: transform 0.2s ease;
    }

    .dashboard-card:hover {
        transform: translateY(-2px);
    }

    .card-accent-green {
        border-left: 4px solid #10b981 !important;
    }

    .card-accent-cyan {
        border-left: 4px solid #06b6d4 !important;
    }

    .card-accent-amber {
        border-left: 4px solid #f59e0b !important;
    }

    .icon-box {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
    }

    .table-pq {
        background: #ffffff;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.05);
    }

    .table-pq thead th {
        background-color: #072258;
        color: #ffffff;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        padding: 0.9rem 1.1rem;
        border: none;
    }

    .table-pq tbody td {
        padding: 0.9rem 1.1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.9rem;
        color: #1e293b;
    }

    .table-pq tbody tr:last-child td {
        border-bottom: none;
    }

    .badge-placa {
        background-color: #1e293b;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.8rem;
        padding: 0.35rem 0.7rem;
        border-radius: 6px;
        letter-spacing: 0.03em;
        display: inline-block;
    }

    .badge-servicio {
        background-color: #06b6d4;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.72rem;
        padding: 0.32rem 0.65rem;
        border-radius: 6px;
        text-transform: uppercase;
    }
</style>
@endpush

@section('content')
    <!-- Encabezado Superior -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">Panel de Control - PQ-Vehículo</h2>
            <p class="text-muted mb-0">Sistema de Control y Carnetización de Puerto Quijarro</p>
        </div>

        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('vehiculos.create') }}" class="btn btn-success fw-semibold px-3 py-2 rounded-3 shadow-sm">
                <i class="bi bi-plus-lg me-1"></i> Registrar Vehículo
            </a>
            <button
                type="button"
                class="btn btn-outline-secondary rounded-circle p-2"
                data-bs-toggle="modal"
                data-bs-target="#modalAdminCuenta"
                title="Administrador de Cuentas"
                aria-label="Administrador de Cuentas"
            >
                <i class="bi bi-gear fs-5"></i>
            </button>
        </div>
    </div>

    <!-- Tarjetas de Indicadores con Gráficos -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="dashboard-card card-accent-green p-4 h-100 d-flex flex-column justify-content-between">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="fw-semibold text-secondary small">Total Registrados</span>
                        <h2 class="fw-bold text-dark mb-0 mt-1">{{ $totalRegistrados }}</h2>
                    </div>
                    <div class="icon-box bg-success-subtle text-success">
                        <i class="bi bi-car-front-fill"></i>
                    </div>
                </div>

                <div class="my-3" style="height: 115px;">
                    <canvas id="chartGeneral"></canvas>
                </div>

                <div class="text-center text-muted small fw-semibold">Registro General</div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="dashboard-card card-accent-cyan p-4 h-100 d-flex flex-column justify-content-between">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="fw-semibold text-secondary small">Vehículos Activos</span>
                        <h2 class="fw-bold text-dark mb-0 mt-1">{{ $totalActivos }}</h2>
                    </div>
                    <div class="icon-box bg-info-subtle text-info">
                        <i class="bi bi-person-vcard-fill"></i>
                    </div>
                </div>

                <div class="my-3" style="height: 115px;">
                    <canvas id="chartActivos"></canvas>
                </div>

                <div class="text-center text-muted small fw-semibold">
                    {{ $totalRegistrados > 0 ? round(($totalActivos / $totalRegistrados) * 100) : 0 }}% de la flota actual
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="dashboard-card card-accent-amber p-4 h-100 d-flex flex-column justify-content-between">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <span class="fw-semibold text-secondary small">Con Código / Carnet</span>
                        <h2 class="fw-bold text-dark mb-0 mt-1">{{ $conCarnet }}</h2>
                    </div>
                    <div class="icon-box bg-primary-subtle text-primary">
                        <i class="bi bi-qr-code"></i>
                    </div>
                </div>

                <div class="my-3 d-flex justify-content-center" style="height: 115px;">
                    <canvas id="chartCarnet"></canvas>
                </div>

                <div class="text-center text-muted small fw-semibold">
                    {{ $totalRegistrados > 0 ? round(($conCarnet / $totalRegistrados) * 100) : 0 }}% del total
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla 1: Estadísticas del Parque Automotor -->
    <div class="mb-4">
        <h5 class="fw-bold text-dark mb-3">Estadísticas del Parque Automotor</h5>
        <div class="table-responsive table-pq">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Clasificación</th>
                        <th>Registrados</th>
                        <th>Activos</th>
                        <th>Con Carnet</th>
                        <th>Vigencia</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="fw-semibold">Particular / Livianos</td>
                        <td>{{ $totalParticular }}</td>
                        <td>{{ $totalParticular }}</td>
                        <td>{{ $totalParticular }}</td>
                        <td>31 DIC 2026</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold">Público / Transporte</td>
                        <td>{{ $totalPublico }}</td>
                        <td>{{ $totalPublico }}</td>
                        <td>{{ $totalPublico }}</td>
                        <td>31 DIC 2026</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabla 2: Últimos Vehículos Registrados Recientemente -->
    <div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold text-dark mb-0">Últimos Vehículos Registrados Recientemente</h5>
            <a href="{{ route('vehiculos.index') }}" class="btn btn-sm btn-outline-secondary rounded-3">Ver todos</a>
        </div>

        <div class="table-responsive table-pq">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Placa</th>
                        <th>Clase</th>
                        <th>Propietario</th>
                        <th>C.I.</th>
                        <th>Marca / Modelo</th>
                        <th>Color</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ultimosVehiculos as $vehiculo)
                        <tr>
                            <td>
                                <span class="badge-placa">{{ $vehiculo->numero_placa }}</span>
                            </td>
                            <td>
                                <span class="badge-servicio">{{ $vehiculo->clase }}</span>
                            </td>
                            <td class="fw-semibold text-uppercase">
                                {{ $vehiculo->nombre }} {{ $vehiculo->apellido }}
                            </td>
                            <td>{{ $vehiculo->ci }}</td>
                            <td class="text-uppercase">{{ $vehiculo->marca }} / {{ $vehiculo->tipo_modelo }}</td>
                            <td class="text-uppercase">{{ $vehiculo->color }}</td>
                            <td class="text-center">
                                <a href="{{ route('vehiculos.show', $vehiculo->id) }}" class="btn btn-sm btn-outline-primary fw-semibold px-3 rounded-2">
                                    <i class="bi bi-person-badge me-1"></i> VER CARNET
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Aún no hay vehículos registrados en el sistema.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mesesLabels = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        const registrosPorMes = @json($registrosPorMes);

        const datosMensuales = mesesLabels.map((_, index) => {
            const mesNumero = index + 1;
            return registrosPorMes[mesNumero] ?? 0;
        });

        new Chart(document.getElementById('chartGeneral'), {
            type: 'bar',
            data: {
                labels: mesesLabels,
                datasets: [{
                    data: datosMensuales,
                    backgroundColor: '#072258',
                    borderRadius: 6,
                    barThickness: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { display: false }, border: { display: false } },
                    y: { display: false, beginAtZero: true }
                }
            }
        });

        new Chart(document.getElementById('chartActivos'), {
            type: 'line',
            data: {
                labels: ['Inicio', 'Progreso', 'Actual'],
                datasets: [{
                    data: [0, Math.ceil({{ $totalActivos }} / 2), {{ $totalActivos }}],
                    borderColor: '#072258',
                    backgroundColor: 'rgba(7, 34, 88, 0.14)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.45,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { display: false },
                    y: { display: false, beginAtZero: true }
                }
            }
        });

        const conCarnet = {{ $conCarnet }};
        const sinCarnet = {{ max($totalRegistrados - $conCarnet, 0) }};
        const dataDona = (conCarnet === 0 && sinCarnet === 0) ? [0, 1] : [conCarnet, sinCarnet];

        new Chart(document.getElementById('chartCarnet'), {
            type: 'doughnut',
            data: {
                labels: ['Con Carnet', 'Pendientes'],
                datasets: [{
                    data: dataDona,
                    backgroundColor: ['#2563eb', '#dbeafe'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '72%',
                plugins: { legend: { display: false } }
            }
        });
    });
</script>
@endpush