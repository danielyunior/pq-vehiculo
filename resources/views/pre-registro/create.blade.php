<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pre-inscripción | PQ-Vehículo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #072258 0%, #04173d 100%);
            min-height: 100vh;
            padding: 2rem 1rem;
        }
        .card-pre {
            border: none;
            border-radius: 16px;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.25);
        }
        .section-title {
            font-size: 0.9rem;
            font-weight: 800;
            color: #072258;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            border-bottom: 2px solid #eef2f7;
            padding-bottom: 0.35rem;
            margin-top: 1.25rem;
            margin-bottom: 0.85rem;
        }
        .req-footer-note {
            margin-top: 1rem;
            padding: 0.65rem 0.9rem;
            border-radius: 10px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            font-size: 0.82rem;
            color: #475569;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card card-pre p-4 p-md-5 bg-white">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h3 class="fw-bold text-dark mb-1">
                                <i class="bi bi-card-checklist text-primary me-2"></i>Pre-inscripción Vehicular
                            </h3>
                            <p class="text-muted small mb-0">
                                PQ-Vehículo · Gobierno Autónomo Municipal de Puerto Quijarro
                            </p>
                        </div>
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left me-1"></i> Volver al Login
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger small">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('pre-registro.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="section-title mt-2">1. Datos del Propietario</div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Nombre *</label>
                                <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Apellido *</label>
                                <input type="text" name="apellido" class="form-control" value="{{ old('apellido') }}" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small fw-bold">Tipo Doc.</label>
                                <select name="tipo_documento" class="form-select">
                                    <option value="C.I." {{ old('tipo_documento', 'C.I.') == 'C.I.' ? 'selected' : '' }}>C.I.</option>
                                    <option value="Pasaporte" {{ old('tipo_documento') == 'Pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                                    <option value="NIT" {{ old('tipo_documento') == 'NIT' ? 'selected' : '' }}>NIT</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label small fw-bold">N° Documento / C.I. *</label>
                                <input type="text" name="ci" class="form-control" value="{{ old('ci') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Domicilio *</label>
                                <input type="text" name="domicilio" class="form-control" value="{{ old('domicilio') }}" placeholder="Barrio / Calle / N°" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold">Ocupación *</label>
                                <input type="text" name="ocupacion" class="form-control" value="{{ old('ocupacion') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold">Teléfono / Celular</label>
                                <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label small fw-bold">Lugar de Trabajo *</label>
                                <input type="text" name="lugar_trabajo" class="form-control" value="{{ old('lugar_trabajo') }}" required>
                            </div>
                        </div>

                        <div class="section-title">2. Datos del Vehículo</div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Número de Placa *</label>
                                <input type="text" name="numero_placa" class="form-control text-uppercase" value="{{ old('numero_placa') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Clase *</label>
                                <select name="clase" class="form-select" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Particular" {{ old('clase') == 'Particular' ? 'selected' : '' }}>Particular</option>
                                    <option value="Público" {{ old('clase') == 'Público' ? 'selected' : '' }}>Público</option>
                                    <option value="Motocicleta" {{ old('clase') == 'Motocicleta' ? 'selected' : '' }}>Motocicleta</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Marca *</label>
                                <input type="text" name="marca" class="form-control" value="{{ old('marca') }}" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Tipo / Modelo *</label>
                                <input type="text" name="tipo_modelo" class="form-control" value="{{ old('tipo_modelo') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Año *</label>
                                <input type="number" name="anio" class="form-control" value="{{ old('anio', date('Y')) }}" min="1950" max="2030" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold">Color *</label>
                                <input type="text" name="color" class="form-control" value="{{ old('color') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Número de Chasis *</label>
                                <input type="text" name="numero_chasis" class="form-control text-uppercase" value="{{ old('numero_chasis') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Número de Motor *</label>
                                <input type="text" name="numero_motor" class="form-control text-uppercase" value="{{ old('numero_motor') }}" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label small fw-bold">Cilindrada</label>
                                <input type="text" name="cilindrada" class="form-control" value="{{ old('cilindrada') }}" placeholder="Ej. 1600 cc">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold">Combustible *</label>
                                <select name="tipo_combustible" class="form-select" required>
                                    <option value="Gasolina" {{ old('tipo_combustible', 'Gasolina') == 'Gasolina' ? 'selected' : '' }}>Gasolina</option>
                                    <option value="Diésel" {{ old('tipo_combustible') == 'Diésel' ? 'selected' : '' }}>Diésel</option>
                                    <option value="GNV" {{ old('tipo_combustible') == 'GNV' ? 'selected' : '' }}>GNV</option>
                                    <option value="Eléctrico" {{ old('tipo_combustible') == 'Eléctrico' ? 'selected' : '' }}>Eléctrico</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold">N° Puertas</label>
                                <input type="number" name="numero_puertas" class="form-control" value="{{ old('numero_puertas', 0) }}" min="0" max="10">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label small fw-bold">Capacidad</label>
                                <input type="text" name="capacidad" class="form-control" value="{{ old('capacidad') }}" placeholder="Ej. 5 pasajeros">
                            </div>
                        </div>

                        <div class="section-title">3. Requisitos Documentales (Fotocopias Legibles)</div>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="doc_ci" class="form-label small fw-bold">
                                    <i class="bi bi-person-vcard text-primary me-1"></i>Carnet de Identidad *
                                </label>
                                <input type="file" id="doc_ci" name="doc_ci" class="form-control form-control-sm" accept=".pdf,image/jpeg,image/png,image/webp" required>
                                <div class="form-text">PDF, JPG, PNG o WEBP (máx. 5 MB).</div>
                            </div>
                            <div class="col-md-4">
                                <label for="doc_propiedad" class="form-label small fw-bold">
                                    <i class="bi bi-file-earmark-text text-primary me-1"></i>Carnet de Propiedad del Vehículo *
                                </label>
                                <input type="file" id="doc_propiedad" name="doc_propiedad" class="form-control form-control-sm" accept=".pdf,image/jpeg,image/png,image/webp" required>
                                <div class="form-text">PDF, JPG, PNG o WEBP (máx. 5 MB).</div>
                            </div>
                            <div class="col-md-4">
                                <label for="doc_diprove" class="form-label small fw-bold">
                                    <i class="bi bi-shield-check text-primary me-1"></i>Hoja de DIPROVE *
                                </label>
                                <input type="file" id="doc_diprove" name="doc_diprove" class="form-control form-control-sm" accept=".pdf,image/jpeg,image/png,image/webp" required>
                                <div class="form-text">PDF, JPG, PNG o WEBP (máx. 5 MB).</div>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary fw-semibold py-2">
                                <i class="bi bi-send me-1"></i> Enviar Pre-inscripción
                            </button>
                        </div>

                        <div class="req-footer-note d-flex align-items-center gap-2">
                            <i class="bi bi-info-circle-fill text-primary fs-6 flex-shrink-0"></i>
                            <span>
                                <strong>Requisitos claves obligatorios:</strong> Fotocopia legible de su <strong>Carnet de Identidad</strong>, del <strong>Carnet de Propiedad del Vehículo</strong> y <strong>Hoja de DIPROVE</strong>.
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>