<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Vehículos - PQ-Vehículo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h3 class="mb-0 fw-bold text-success">Registro y Carnetización de Vehículos</h3>
            <small class="text-muted">Gobierno Autónomo Municipal de Puerto Quijarro</small>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ url('/') }}" class="btn btn-outline-secondary">Inicio</a>
            <a href="{{ route('vehiculos.create') }}" class="btn btn-primary">+ Nuevo Registro</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle mb-0">
                    <thead class="table-success text-dark">
                        <tr>
                            <th>#</th>
                            <th>Placa</th>
                            <th>Propietario / Conductor</th>
                            <th>CI</th>
                            <th>Vehículo</th>
                            <th>Servicio</th>
                            <th>Código QR</th>
                            <th>Estado</th>
                            <th class="text-center" style="width: 250px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vehiculos as $vehiculo)
                            <tr>
                                <td>{{ $vehiculo->id }}</td>
                                <td class="fw-bold text-danger">{{ $vehiculo->numero_placa }}</td>
                                <td>{{ $vehiculo->nombre }} {{ $vehiculo->apellido }}</td>
                                <td>{{ $vehiculo->ci }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $vehiculo->marca }} - {{ $vehiculo->clase }}</div>
                                    <small class="text-muted">{{ $vehiculo->tipo_modelo }} ({{ $vehiculo->anio }})</small>
                                </td>
                                <td>{{ $vehiculo->tipo_documento }}</td>
                                <td><span class="badge bg-secondary">{{ $vehiculo->codigo_qr }}</span></td>
                                <td>
                                    <span class="badge {{ $vehiculo->estado === 'ACTIVO' ? 'bg-success' : 'bg-warning text-dark' }}">
                                        {{ $vehiculo->estado ?? 'ACTIVO' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center flex-wrap gap-1">
                                        <a href="{{ route('vehiculos.carnet', $vehiculo->id) }}" target="_blank" class="btn btn-success btn-sm">
                                            Carnet
                                        </a>
                                        <a href="{{ route('vehiculos.show', $vehiculo->id) }}" class="btn btn-info btn-sm text-white">
                                            Ver
                                        </a>
                                        <a href="{{ route('vehiculos.edit', $vehiculo->id) }}" class="btn btn-warning btn-sm">
                                            Editar
                                        </a>
                                        <form action="{{ route('vehiculos.destroy', $vehiculo->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Deseas eliminar este registro?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">
                                    No hay vehículos registrados todavía.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if (method_exists($vehiculos, 'links'))
                <div class="mt-3">
                    {{ $vehiculos->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>