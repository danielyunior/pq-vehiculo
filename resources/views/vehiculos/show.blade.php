<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carnet de Circulación | {{ $vehiculo->numero_placa }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media print {
            @page {
                size: A4 portrait;
                margin: 10mm;
            }
            .no-print {
                display: none !important;
            }
            body {
                background-color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                margin: 0 !important;
                padding: 0 !important;
            }
            .sheet-container {
                box-shadow: none !important;
                border: 1px dashed #000 !important;
                margin: 0 auto !important;
                background: white !important;
            }
        }
        body {
            background-color: #f0f2f5;
            font-family: Arial, sans-serif;
        }
        /* Contenedor principal vertical uniendo ambas caras (9cm + 9cm = 18cm de ancho) */
        .sheet-container {
            width: 18.5cm;
            background: #ffffff;
            border: 1px dashed #999;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            margin: 0 auto;
            padding: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 6px;
        }
        /* Medidas exactas ajustadas: 9 cm de largo x 6.30 cm de alto por tarjeta */
        .credential-card {
            width: 9cm;
            height: 6.3cm;
            background: #ffffff;
            border-radius: 6px;
            border: 1px solid #b0bec5;
            position: relative;
            overflow: hidden;
            box-sizing: border-box;
        }
        .card-header-custom {
            background: linear-gradient(135deg, #2e7d32 0%, #1b5e20 100%);
            color: #ffffff;
            text-align: center;
            padding: 4px 6px;
        }
        .card-header-custom h6 {
            font-size: 8.5px;
            font-weight: bold;
            margin: 0;
            letter-spacing: 0.3px;
        }
        .card-body-custom {
            padding: 6px 8px;
            font-size: 7.5px;
        }
        .field-label {
            font-weight: bold;
            color: #37474f;
        }
        .field-value {
            color: #000000;
        }
        .fold-line {
            border-left: 2px dashed #b0bec5;
            height: 6.3cm;
            margin: 0 4px;
        }
    </style>
</head>
<body class="py-4">

<div class="container text-center">
    <!-- Botones de navegación (No se imprimen) -->
    <div class="mb-4 no-print">
        <a href="{{ route('vehiculos.index') }}" class="btn btn-outline-secondary btn-sm me-2">
            <i class="fa-solid fa-arrow-left me-1"></i> Volver al listado
        </a>
        <button onclick="window.print()" class="btn btn-success btn-sm fw-bold px-4">
            <i class="fa-solid fa-print me-1"></i> Imprimir Credencial (9x6.3 cm Plegable)
        </button>
    </div>

    <!-- ================= HOJA UNIDA VERTICAL PARA DOBLAR ================= -->
    <div class="sheet-container">
        
        <!-- CARNET - ANVERSO -->
        <div class="credential-card">
            <div class="card-header-custom">
                <h6>CERTIFICADO DE APORTE VOLUNTARIO DE CORRESPONSABILIDAD VIAL DEL CONDUCTOR</h6>
            </div>
            <div class="card-body-custom text-uppercase">
                <div class="row gx-1">
                    <div class="col-8">
                        <table class="w-100" style="line-height: 1.3;">
                            <tr>
                                <td class="field-label" style="width: 38%;">NOMBRE:</td>
                                <td class="field-value">{{ $vehiculo->nombre }}</td>
                            </tr>
                            <tr>
                                <td class="field-label">APELLIDO:</td>
                                <td class="field-value">{{ $vehiculo->apellido }}</td>
                            </tr>
                            <tr>
                                <td class="field-label">DOMICILIO:</td>
                                <td class="field-value">{{ $vehiculo->domicilio }}</td>
                            </tr>
                            <tr>
                                <td class="field-label">OCU. O PROF.:</td>
                                <td class="field-value">{{ $vehiculo->ocupacion }}</td>
                            </tr>
                            <tr>
                                <td class="field-label">LUGAR DE TRABAJO:</td>
                                <td class="field-value">{{ $vehiculo->lugar_trabajo }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-4 text-end">
                        <div style="font-size: 7px; line-height: 1.1;">
                            <span class="field-label">N° IMP:</span> <span class="field-value">{{ $vehiculo->id + 2000 }}</span><br>
                            <span class="field-label">C.I.:</span> <span class="field-value">{{ $vehiculo->ci }}</span>
                        </div>
                        <div class="mt-1 d-inline-block p-1 bg-white border rounded">
                            <!-- QR actualizado con Nombre, Apellido y Placa -->
                            @php
                                $qrData = "PROPIETARIO: {$vehiculo->nombre} {$vehiculo->apellido} | PLACA: {$vehiculo->numero_placa} | COD: {$vehiculo->codigo_qr}";
                            @endphp
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ urlencode($qrData) }}" alt="QR Code" width="48" height="48">
                        </div>
                    </div>
                </div>

                <div class="mt-1 pt-1 border-top d-flex justify-content-between align-items-center">
                    <div>
                        <span class="fw-bold text-success" style="font-size: 7px;">VIGENCIA</span>
                        <div class="fw-bold" style="font-size: 8px;">31 DE DICIEMBRE 2026</div>
                    </div>
                    <div class="text-center">
                        <div class="badge bg-success text-white" style="font-size: 6px; padding: 2px 4px;">GAM-PQ / AVC</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- GUÍA DE DOBLEZ CENTRAL -->
        <div class="fold-line no-print"></div>

        <!-- CARNET - REVERSO -->
        <div class="credential-card">
            <div class="card-header-custom">
                <h6>CERTIFICADO DE TRANSPORTE URBANO</h6>
            </div>
            <div class="card-body-custom text-uppercase">
                <div class="row gx-1">
                    <div class="col-7">
                        <table class="w-100" style="line-height: 1.25;">
                            <tr>
                                <td class="field-label" style="width: 40%;">MARCA:</td>
                                <td class="field-value">{{ $vehiculo->marca }}</td>
                            </tr>
                            <tr>
                                <td class="field-label">CLASE:</td>
                                <td class="field-value">{{ $vehiculo->clase }}</td>
                            </tr>
                            <tr>
                                <td class="field-label">COLOR:</td>
                                <td class="field-value">{{ $vehiculo->color }}</td>
                            </tr>
                            <tr>
                                <td class="field-label">CHASIS:</td>
                                <td class="field-value font-monospace" style="font-size: 6.5px;">{{ $vehiculo->numero_chasis }}</td>
                            </tr>
                            <tr>
                                <td class="field-label">MOTOR:</td>
                                <td class="field-value font-monospace" style="font-size: 6.5px;">{{ $vehiculo->numero_motor }}</td>
                            </tr>
                            <tr>
                                <td class="field-label">CILINDRADA:</td>
                                <td class="field-value">{{ $vehiculo->cilindrada }}</td>
                            </tr>
                            <tr>
                                <td class="field-label">COMBUSTIBLE:</td>
                                <td class="field-value">{{ $vehiculo->tipo_combustible }}</td>
                            </tr>
                            <tr>
                                <td class="field-label">Nº DE PUERTAS:</td>
                                <td class="field-value">{{ $vehiculo->numero_puertas }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-5 text-end">
                        <table class="w-100 mb-1" style="line-height: 1.25;">
                            <tr>
                                <td class="field-label text-end">TIPO:</td>
                                <td class="field-value text-start">{{ $vehiculo->tipo_modelo }}</td>
                            </tr>
                            <tr>
                                <td class="field-label text-end">MODELO:</td>
                                <td class="field-value text-start">{{ $vehiculo->anio }}</td>
                            </tr>
                            <tr>
                                <td class="field-label text-end">CAPACIDAD:</td>
                                <td class="field-value text-start">{{ $vehiculo->capacidad }}</td>
                            </tr>
                        </table>
                        <div class="text-center bg-light p-1 rounded border">
                            <span class="fw-bold text-dark" style="font-size: 10px;">{{ $vehiculo->numero_placa }}</span>
                            <div class="fw-bold text-primary" style="font-size: 7px;">{{ $vehiculo->tipo_documento }}</div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-1 pt-1 border-top" style="font-size: 5.5px; color: #555;">
                    ESTE DOCUMENTO, NO ACREDITA DERECHO PROPIETARIO, SOLO PARA EFECTOS DE CONTROL DE CIRCULACIÓN.
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>