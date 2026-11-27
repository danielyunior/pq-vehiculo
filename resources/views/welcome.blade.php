<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Principal - PQ-Vehículo | GAM Puerto Quijarro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<div class="container-fluid py-4 px-4">
    <!-- Encabezado del Dashboard -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-success mb-0"><i class="fa-solid fa-chart-line me-2"></i> Panel de Control - PQ-Vehículo</h2>
            <p class="text-muted mb-0">Gobierno Autónomo Municipal de Puerto Quijarro | Sistema de Control y Carnetización</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('vehiculos.create') }}" class="btn btn-success fw-bold shadow-sm">
                <i class="fa-solid fa-plus me-1"></i> Registrar Vehículo
            </a>
            <a href="{{ route('vehiculos.index') }}" class="btn btn-primary fw-bold shadow-sm">
                <i class="fa-solid fa-car-side me-1"></i> Ver Listado Completo
            </a>
        </div>
    </div>

    <!-- Tarjetas de Estadísticas (Widgets) -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white border-start border-success border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small fw-bold">TOTAL REGISTRADOS</span>
                            <h3 class="fw-bold mb-0 text-dark">{{ \App\Models\Vehiculo::count() }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success">
                            <i class="fa-solid fa-car fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small fw-bold">SERVICIO PÚBLICO</span>
                            <h3 class="fw-bold mb-0 text-dark">{{ \App\Models\Vehiculo::where('tipo_documento', 'PÚBLICO')->count() }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                            <i class="fa-solid fa-taxi fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white border-start border-info border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small fw-bold">SERVICIO PARTICULAR</span>
                            <h3 class="fw-bold mb-0 text-dark">{{ \App\Models\Vehiculo::where('tipo_documento', 'PARTICULAR')->count() }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded-circle text-info">
                            <i class="fa-solid fa-id-card fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white border-start border-warning border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small fw-bold">VIGENCIA ACTUAL</span>
                            <h6 class="fw-bold mb-0 text-dark mt-1">31 DIC 2026</h6>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle text-warning">
                            <i class="fa-solid fa-calendar-days fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Accesos Rápidos y Últimos Registros -->
    <div class="row">
        <!-- Tabla de últimos vehículos agregados -->
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-0">
                    <h5 class="fw-bold mb-0 text-secondary"><i class="fa-solid fa-clock-rotate-left me-2"></i> Últimos Vehículos Registrados Recientemente</h5>
                    <a href="{{ route('vehiculos.index') }}" class="btn btn-sm btn-outline-secondary">Ver todos</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-uppercase" style="font-size: 0.85rem;">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Placa</th>
                                    <th>Servicio</th>
                                    <th>Propietario</th>
                                    <th>C.I.</th>
                                    <th>Marca / Modelo</th>
                                    <th>Color</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $ultimos = \App\Models\Vehiculo::latest()->take(5)->get();
                                @endphp

                                @forelse ($ultimos as $v)
                                    <tr>
                                        <td class="ps-3"><span class="badge bg-dark">{{ $v->numero_placa }}</span></td>
                                        <td>
                                            <span class="badge {{ $v->tipo_documento == 'PÚBLICO' ? 'bg-warning text-dark' : 'bg-info text-dark' }}">
                                                {{ $v->tipo_documento }}
                                            </span>
                                        </td>
                                        <td>{{ $v->nombre }} {{ $v->apellido }}</td>
                                        <td>{{ $v->ci }}</td>
                                        <td>{{ $v->marca }} / {{ $v->tipo_modelo }}</td>
                                        <td>{{ $v->color }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('vehiculos.show', $v->id) }}" class="btn btn-sm btn-outline-primary" title="Ver Carnet Plegable">
                                                <i class="fa-solid fa-id-card"></i> Ver Carnet
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">No hay registros recientes.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>