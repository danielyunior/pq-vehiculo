<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Registro Técnico | PQ-vehiculo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <div class="mb-3">
                <a href="{{ route('vehiculos.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fa-solid fa-arrow-left me-1"></i> Volver al listado
                </a>
            </div>

            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-warning text-dark p-4 rounded-top-4">
                    <h3 class="mb-0 fw-bold"><i class="fa-solid fa-pen-to-square me-2"></i> Editar Registro Técnico Vehicular</h3>
                    <small>Gobierno Autónomo Municipal de Puerto Quijarro</small>
                </div>

                <div class="card-body p-4">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('vehiculos.update', $vehiculo->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- SECCIÓN 1: DATOS DEL PROPIETARIO -->
                        <h5 class="text-primary fw-bold border-bottom pb-2 mb-3">
                            <i class="fa-solid fa-user me-2"></i> 1. Datos del Propietario
                        </h5>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label for="nombre" class="form-label fw-bold">Nombre <span class="text-danger">*</span></label>
                                <input type="text" name="nombre" id="nombre" class="form-control text-uppercase" value="{{ old('nombre', $vehiculo->nombre) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="apellido" class="form-label fw-bold">Apellido <span class="text-danger">*</span></label>
                                <input type="text" name="apellido" id="apellido" class="form-control text-uppercase" value="{{ old('apellido', $vehiculo->apellido) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="ci" class="form-label fw-bold">C.I. <span class="text-danger">*</span></label>
                                <input type="text" name="ci" id="ci" class="form-control text-uppercase" value="{{ old('ci', $vehiculo->ci) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="domicilio" class="form-label fw-bold">Domicilio <span class="text-danger">*</span></label>
                                <input type="text" name="domicilio" id="domicilio" class="form-control text-uppercase" value="{{ old('domicilio', $vehiculo->domicilio) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="ocupacion" class="form-label fw-bold">Ocupación / Profesión <span class="text-danger">*</span></label>
                                <input type="text" name="ocupacion" id="ocupacion" class="form-control text-uppercase" value="{{ old('ocupacion', $vehiculo->ocupacion) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="lugar_trabajo" class="form-label fw-bold">Lugar de Trabajo <span class="text-danger">*</span></label>
                                <input type="text" name="lugar_trabajo" id="lugar_trabajo" class="form-control text-uppercase" value="{{ old('lugar_trabajo', $vehiculo->lugar_trabajo) }}" required>
                            </div>
                        </div>

                        <!-- SECCIÓN 2: DATOS TÉCNICOS DEL VEHÍCULO -->
                        <h5 class="text-primary fw-bold border-bottom pb-2 mb-3">
                            <i class="fa-solid fa-car-side me-2"></i> 2. Datos Técnicos del Vehículo
                        </h5>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label for="numero_placa" class="form-label fw-bold">Número de Placa <span class="text-danger">*</span></label>
                                <input type="text" name="numero_placa" id="numero_placa" class="form-control text-uppercase" value="{{ old('numero_placa', $vehiculo->numero_placa) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="tipo_documento" class="form-label fw-bold">Tipo de Servicio <span class="text-danger">*</span></label>
                                <select name="tipo_documento" id="tipo_documento" class="form-select text-uppercase" required>
                                    <option value="PARTICULAR" {{ old('tipo_documento', $vehiculo->tipo_documento) == 'PARTICULAR' ? 'selected' : '' }}>PARTICULAR</option>
                                    <option value="PÚBLICO" {{ old('tipo_documento', $vehiculo->tipo_documento) == 'PÚBLICO' ? 'selected' : '' }}>PÚBLICO</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="clase" class="form-label fw-bold">Clase <span class="text-danger">*</span></label>
                                <input type="text" name="clase" id="clase" class="form-control text-uppercase" value="{{ old('clase', $vehiculo->clase) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="marca" class="form-label fw-bold">Marca <span class="text-danger">*</span></label>
                                <input type="text" name="marca" id="marca" class="form-control text-uppercase" value="{{ old('marca', $vehiculo->marca) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="tipo_modelo" class="form-label fw-bold">Tipo o Modelo <span class="text-danger">*</span></label>
                                <input type="text" name="tipo_modelo" id="tipo_modelo" class="form-control text-uppercase" value="{{ old('tipo_modelo', $vehiculo->tipo_modelo) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="anio" class="form-label fw-bold">Año <span class="text-danger">*</span></label>
                                <input type="number" name="anio" id="anio" class="form-control" value="{{ old('anio', $vehiculo->anio) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="color" class="form-label fw-bold">Color <span class="text-danger">*</span></label>
                                <input type="text" name="color" id="color" class="form-control text-uppercase" value="{{ old('color', $vehiculo->color) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="cilindrada" class="form-label fw-bold">Cilindrada <span class="text-danger">*</span></label>
                                <input type="text" name="cilindrada" id="cilindrada" class="form-control text-uppercase" value="{{ old('cilindrada', $vehiculo->cilindrada) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="tipo_combustible" class="form-label fw-bold">Tipo de Combustible <span class="text-danger">*</span></label>
                                <select name="tipo_combustible" id="tipo_combustible" class="form-select text-uppercase" required>
                                    <option value="GASOLINA" {{ old('tipo_combustible', $vehiculo->tipo_combustible) == 'GASOLINA' ? 'selected' : '' }}>GASOLINA</option>
                                    <option value="DIÉSEL" {{ old('tipo_combustible', $vehiculo->tipo_combustible) == 'DIÉSEL' ? 'selected' : '' }}>DIÉSEL</option>
                                    <option value="GNV" {{ old('tipo_combustible', $vehiculo->tipo_combustible) == 'GNV' ? 'selected' : '' }}>GNV</option>
                                    <option value="HÍBRIDO / ELÉCTRICO" {{ old('tipo_combustible', $vehiculo->tipo_combustible) == 'HÍBRIDO / ELÉCTRICO' ? 'selected' : '' }}>HÍBRIDO / ELÉCTRICO</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="numero_puertas" class="form-label fw-bold">Número de Puertas <span class="text-danger">*</span></label>
                                <input type="number" name="numero_puertas" id="numero_puertas" class="form-control" value="{{ old('numero_puertas', $vehiculo->numero_puertas) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="capacidad" class="form-label fw-bold">Capacidad <span class="text-danger">*</span></label>
                                <input type="text" name="capacidad" id="capacidad" class="form-control text-uppercase" value="{{ old('capacidad', $vehiculo->capacidad) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="numero_chasis" class="form-label fw-bold">Número de Chasis <span class="text-danger">*</span></label>
                                <input type="text" name="numero_chasis" id="numero_chasis" class="form-control text-uppercase" value="{{ old('numero_chasis', $vehiculo->numero_chasis) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="numero_motor" class="form-label fw-bold">Número de Motor <span class="text-danger">*</span></label>
                                <input type="text" name="numero_motor" id="numero_motor" class="form-control text-uppercase" value="{{ old('numero_motor', $vehiculo->numero_motor) }}" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4 border-top pt-3">
                            <a href="{{ route('vehiculos.index') }}" class="btn btn-light px-4">Cancelar</a>
                            <button type="submit" class="btn btn-warning px-4 fw-bold text-dark">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Actualizar Registro
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>