@extends('layouts.app')

@section('title', 'Reportes de Vehículos')

@push('styles')
<style>
    .report-card {
        background: #ffffff;
        border: none;
        border-radius: 14px;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.05);
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
        padding: 0.9rem 1rem;
        border: none;
    }

    .table-pq tbody td {
        padding: 0.85rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.9rem;
        color: #1e293b;
    }

    .badge-placa {
        background-color: #1e293b;
        color: #ffffff;
        font-weight: 700;
        font-size: 0.8rem;
        padding: 0.32rem 0.65rem;
        border-radius: 6px;
        display: inline-block;
    }

    @media print {
        .sidebar, .no-print, .d-lg-none {
            display: none !important;
        }
        .main-wrapper {
            padding: 0 !important;
        }
        body {
            background: #ffffff !important;
        }
    }
</style>
@endpush

@section('content')
    <!-- Encabezado -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-0">Reportes - PQ-Vehículo</h2>
            <p class="text-muted mb-0">
                Gobierno Autónomo Municipal de Puerto Quijarro —
                <strong>
                    @if ($tipo === 'MOTOCICLETA')
                        Reporte de Motocicletas Registradas
                    @elseif ($tipo === 'VAGONETA')
                        Reporte de Vagonetas Registradas
                    @elseif ($tipo === 'CAMIONETA')
                        Reporte de Camionetas Registradas
                    @elseif ($tipo === 'AUTOMOVIL')
                        Reporte de Automóviles Registrados
                    @else
                        Reporte General de Vehículos Registrados
                    @endif
                </strong>
            </p>
        </div>

        <div class="d-flex gap-2 no-print">
            <button type="button" onclick="window.print()" class="btn btn-outline-dark fw-semibold rounded-3">
                <i class="bi bi-printer me-1"></i> Imprimir Reporte
            </button>
            <a href="{{ route('home') }}" class="btn btn-outline-secondary rounded-3">
                <i class="bi bi-arrow-left me-1"></i> Volver
            </a>
        </div>
    </div>

    <!-- Botones de Filtro por Tipo -->
    <div class="report-card p-3 mb-4 no-print">
        <div class="d-flex flex-wrap align-items-center gap-2">
            <a href="{{ route('reportes.index', ['tipo' => 'TODOS']) }}"
               class="btn {{ $tipo === 'TODOS' ? 'btn-primary' : 'btn-outline-primary' }} fw-semibold rounded-3"
               style="{{ $tipo === 'TODOS' ? 'background-color:#072258;border-color:#072258;' : '' }}">
                <i class="bi bi-collection me-1"></i> Todos ({{ $totalTodos }})
            </a>

            <a href="{{ route('reportes.index', ['tipo' => 'MOTOCICLETA']) }}"
               class="btn {{ $tipo === 'MOTOCICLETA' ? 'btn-dark' : 'btn-outline-dark' }} fw-semibold rounded-3">
                <i class="bi bi-bicycle me-1"></i> Motocicletas ({{ $totalMotocicletas }})
            </a>

            <a href="{{ route('reportes.index', ['tipo' => 'VAGONETA']) }}"
               class="btn {{ $tipo === 'VAGONETA' ? 'btn-info text-white' : 'btn-outline-info' }} fw-semibold rounded-3">
                <i class="bi bi-car-front-fill me-1"></i> Vagonetas ({{ $totalVagonetas }})
            </a>

            <a href="{{ route('reportes.index', ['tipo' => 'CAMIONETA']) }}"
               class="btn {{ $tipo === 'CAMIONETA' ? 'btn-success' : 'btn-outline-success' }} fw-semibold rounded-3">
                <i class="bi bi-truck me-1"></i> Camionetas ({{ $totalCamionetas }})
            </a>

            <a href="{{ route('reportes.index', ['tipo' => 'AUTOMOVIL']) }}"
               class="btn {{ $tipo === 'AUTOMOVIL' ? 'btn-warning text-dark' : 'btn-outline-warning text-dark' }} fw-semibold rounded-3">
                <i class="bi bi-car-front me-1"></i> Automóviles ({{ $totalAutomoviles }})
            </a>
        </div>
    </div>

    <!-- Tabla Enumerada con Fecha -->
    <div class="table-responsive table-pq">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th style="width: 60px;">#</th>
                    <th>Fecha Registro</th>
                    <th>Placa</th>
                    <th>Clase</th>
                    <th>Propietario</th>
                    <th>C.I.</th>
                    <th>Marca / Modelo</th>
                    <th>Color</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($vehiculos as $index => $vehiculo)
                    <tr>
                        <td class="fw-bold text-muted">{{ $index + 1 }}</td>
                        <td>{{ $vehiculo->created_at ? $vehiculo->created_at->format('d/m/Y H:i') : '-' }}</td>
                        <td><span class="badge-placa">{{ $vehiculo->numero_placa }}</span></td>
                        <td class="fw-semibold text-uppercase">{{ $vehiculo->clase }}</td>
                        <td class="text-uppercase">{{ $vehiculo->nombre }} {{ $vehiculo->apellido }}</td>
                        <td>{{ $vehiculo->ci }}</td>
                        <td class="text-uppercase">{{ $vehiculo->marca }} / {{ $vehiculo->tipo_modelo }}</td>
                        <td class="text-uppercase">{{ $vehiculo->color }}</td>
                        <td>
                            <span class="badge bg-success-subtle text-success fw-semibold">
                                {{ $vehiculo->estado ?? 'ACTIVO' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            No hay vehículos registrados para este filtro.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection