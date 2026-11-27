<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Credencial Vehicular - {{ $vehiculo->numero_placa }}</title>
    <style>
        * {
            box-sizing: border-box;
        }

        @page {
            size: landscape;
            margin: 6mm;
        }

        body {
            font-family: "Times New Roman", Georgia, serif;
            background-color: #e9ecef;
            margin: 0;
            padding: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .barra-acciones {
            margin-bottom: 10px;
            display: flex;
            gap: 10px;
        }

        .btn-accion {
            font-family: Arial, Helvetica, sans-serif;
            padding: 7px 14px;
            border-radius: 6px;
            font-size: 12.5px;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
            border: none;
        }

        .btn-volver {
            background: #ffffff;
            color: #212529;
            border: 1px solid #ced4da;
        }

        .btn-imprimir {
            background: #198754;
            color: #ffffff;
        }

        .pliego-carnet {
            width: 24.4cm;
            height: 8.8cm;
            display: flex;
            gap: 8px;
            background: #ffffff;
            padding: 4px;
            border-radius: 5px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.14);
        }

        .cara-carnet {
            flex: 1;
            height: 100%;
            position: relative;
            overflow: hidden;
            border: 1px solid #2e7d32;
            padding: 4px 10px 6px 10px;
            background-image: url("{{ asset('images/carnet/fondo-verde.jpg.png') }}");
            background-size: 100% 100%;
            background-repeat: no-repeat;
            background-position: center;
        }

        .encabezado-cara {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 4px;
            min-height: 28px;
            gap: 4px;
        }

        .escudo-izq {
            width: 28px;
            height: 28px;
            object-fit: contain;
            flex-shrink: 0;
        }

        .escudo-der {
            width: 26px;
            height: 26px;
            object-fit: contain;
            flex-shrink: 0;
            margin-right: 10px;
        }

        .titulo-cara {
            flex: 1;
            text-align: center;
            font-size: 11.8px;
            font-weight: 700;
            color: #0b2e13;
            line-height: 1.12;
            letter-spacing: 0.2px;
            text-transform: uppercase;
        }

        .titulo-cara span {
            display: block;
        }

        /* Cara izquierda: Datos del vehículo con interlineado 2.5 y etiquetas en negrita */
        .cuerpo-vehiculo {
            display: flex;
            justify-content: space-between;
            margin-top: 24px;
            height: calc(100% - 70px);
            font-size: 8.5px;
            line-height: 2.5 !important;
            font-weight: 700;
            color: #111827;
            text-transform: uppercase;
        }

        .col-izq-vehiculo {
            width: 54%;
            line-height: 2.5 !important;
        }

        .col-der-vehiculo {
            width: 45%;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .fila-dato {
            display: flex;
            align-items: baseline;
            line-height: 2.5 !important;
            margin-bottom: 0;
        }

        .etiqueta {
            width: 47%;
            font-weight: 900 !important;
            color: #000000;
            padding-right: 6px;
            line-height: 2.5 !important;
        }

        .valor {
            width: 53%;
            font-weight: 600;
            word-break: break-word;
            line-height: 2.5 !important;
        }

        .bloque-logo-superior {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 8px;
            padding-left: 8px;
        }

        .logo-central-gam {
            display: block;
            width: 116px;
            height: 76px;
            object-fit: contain;
        }

        /* Placa ajustada debajo del logo */
        .placa-roja {
            position: absolute;
            bottom: 62px;
            right: 16px;
            width: 38%;
            text-align: center;
            color: #e51c23;
            font-family: Arial, Helvetica, sans-serif;
            font-weight: 900;
            font-size: 11.2px;
            line-height: 1.15;
            z-index: 2;
        }

        /* Leyenda roja subida un poco más hacia el rectángulo marcado */
        .leyenda-roja {
            position: absolute;
            bottom: 36px;
            left: 10px;
            width: 58%;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 6.3px;
            font-weight: 800;
            color: #e51c23;
            line-height: 1.15;
            text-transform: uppercase;
            z-index: 2;
        }

        /* Cara derecha: Datos del conductor / aporte con interlineado 2.5 y etiquetas en negrita */
        .cuerpo-conductor {
            display: flex;
            justify-content: space-between;
            margin-top: 24px;
            height: calc(100% - 56px);
            font-size: 9px;
            line-height: 2.5 !important;
            font-weight: 700;
            color: #111827;
            text-transform: uppercase;
            padding-top: 2px;
        }

        .col-datos-persona {
            width: 64%;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            padding-bottom: 4px;
        }

        .fila-persona {
            display: flex;
            align-items: baseline;
            line-height: 2.5 !important;
            margin-bottom: 0;
        }

        .fila-persona .etiqueta {
            width: 45%;
            font-weight: 900 !important;
            color: #000000;
            padding-right: 8px;
            line-height: 2.5 !important;
        }

        .fila-persona .valor {
            width: 55%;
            font-weight: 600;
            line-height: 2.5 !important;
        }

        /* Vigencia ampliada al tamaño del cuadro marcado */
        .vigencia-bloque {
            margin-top: 6px;
        }

        .vigencia-lbl,
        .vigencia-val {
            font-size: 13.5px !important;
            font-weight: 800;
            line-height: 1.3 !important;
            color: #000000;
        }

        .col-qr-persona {
            width: 35%;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: flex-start;
            gap: 10px;
            padding-left: 8px;
        }

        .folio-ci {
            font-size: 9.2px;
            font-weight: 700;
            line-height: 1.35;
            text-align: left;
            width: 100%;
        }

        .qr-caja {
            width: 86px;
            height: 86px;
            background: #ffffff;
            padding: 3px;
            border: 1px solid #1b5e20;
            display: flex;
            align-items: center;
            justify-content: center;
            align-self: center;
        }

        .qr-caja img,
        .qr-caja canvas {
            display: block;
            width: 78px !important;
            height: 78px !important;
        }

        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .barra-acciones {
                display: none !important;
            }
            .pliego-carnet {
                width: 100% !important;
                height: 8.8cm !important;
                box-shadow: none !important;
                padding: 0 !important;
                gap: 8px !important;
            }
            .cara-carnet {
                break-inside: avoid;
                page-break-inside: avoid;
            }
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>
<body>

    <div class="barra-acciones">
        <a href="{{ route('vehiculos.index') }}" class="btn-accion btn-volver">← Volver al listado</a>
        <button type="button" id="btn-imprimir-carnet" class="btn-accion btn-imprimir">🖨️ Imprimir Credencial</button>
    </div>

    <div class="pliego-carnet">
        <!-- IZQUIERDA: CERTIFICADO DE TRANSPORTE URBANO -->
        <div class="cara-carnet">
            <div class="encabezado-cara">
                <img src="{{ asset('images/carnet/escudo-izq.png.png') }}" alt="Escudo" class="escudo-izq">
                <div class="titulo-cara">
                    <span>Certificado de Transporte</span>
                    <span>Urbano</span>
                </div>
                <img src="{{ asset('images/carnet/escudo-der.png.png') }}" alt="Escudo" class="escudo-der">
            </div>

            <div class="cuerpo-vehiculo">
                <div class="col-izq-vehiculo">
                    <div class="fila-dato"><span class="etiqueta">MARCA.</span><span class="valor">{{ $vehiculo->marca }}</span></div>
                    <div class="fila-dato"><span class="etiqueta">CLASE</span><span class="valor">{{ $vehiculo->clase }}</span></div>
                    <div class="fila-dato"><span class="etiqueta">COLOR</span><span class="valor">{{ $vehiculo->color }}</span></div>
                    <div class="fila-dato"><span class="etiqueta">CHASIS</span><span class="valor">{{ $vehiculo->numero_chasis }}</span></div>
                    <div class="fila-dato"><span class="etiqueta">MOTOR</span><span class="valor">{{ $vehiculo->numero_motor }}</span></div>
                    <div class="fila-dato"><span class="etiqueta">CILINDRADA</span><span class="valor">{{ $vehiculo->cilindrada }}</span></div>
                    <div class="fila-dato"><span class="etiqueta">COMBUSTIBLE</span><span class="valor">{{ $vehiculo->tipo_combustible }}</span></div>
                    <div class="fila-dato"><span class="etiqueta">Nº DE PUERTAS</span><span class="valor">{{ $vehiculo->numero_puertas }}</span></div>
                </div>

                <div class="col-der-vehiculo">
                    <div>
                        <div class="fila-dato"><span class="etiqueta">TIPO</span><span class="valor">{{ $vehiculo->tipo_modelo }}</span></div>
                        <div class="fila-dato"><span class="etiqueta">MODELO</span><span class="valor">{{ $vehiculo->anio }}</span></div>
                        <div class="fila-dato"><span class="etiqueta">CAPACIDAD.</span><span class="valor">{{ $vehiculo->capacidad }}</span></div>
                    </div>

                    <div class="bloque-logo-superior">
                        <img src="{{ asset('images/carnet/logo-gam-pq.png.png') }}" alt="GAM Puerto Quijarro" class="logo-central-gam">
                    </div>
                </div>
            </div>

            <div class="placa-roja">
                <div>{{ $vehiculo->numero_placa }}</div>
                <div>{{ $vehiculo->tipo_documento }}</div>
            </div>

            <div class="leyenda-roja">
                ESTE DOCUMENTO, NO ACREDITA DERECHO PROPIETARIO, SOLO PARA EFECTOS DE CONTROL DE CIRCULACION.
            </div>
        </div>

        <!-- DERECHA: CERTIFICADO DE APORTE VOLUNTARIO DE CORRESPONSABILIDAD VIAL DEL CONDUCTOR -->
        <div class="cara-carnet">
            <div class="encabezado-cara">
                <div class="titulo-cara">
                    <span>Certificado de Aporte Voluntario de</span>
                    <span>Corresponsabilidad Vial del Conductor</span>
                </div>
            </div>

            <div class="cuerpo-conductor">
                <div class="col-datos-persona">
                    <div>
                        <div class="fila-persona"><span class="etiqueta">NOMBRE</span><span class="valor">{{ $vehiculo->nombre }}</span></div>
                        <div class="fila-persona"><span class="etiqueta">APELLIDO</span><span class="valor">{{ $vehiculo->apellido }}</span></div>
                        <div class="fila-persona"><span class="etiqueta">DOMICILIO</span><span class="valor">{{ $vehiculo->domicilio }}</span></div>
                        <div class="fila-persona"><span class="etiqueta">OCU. O PROF.</span><span class="valor">{{ $vehiculo->ocupacion }}</span></div>
                        <div class="fila-persona"><span class="etiqueta">LUGAR DE TRABAJO</span><span class="valor">{{ $vehiculo->lugar_trabajo }}</span></div>
                    </div>

                    <div class="vigencia-bloque">
                        <div class="vigencia-lbl">VIGENCIA</div>
                        <div class="vigencia-val">31 DE DICIEMBRE 2026</div>
                    </div>
                </div>

                <div class="col-qr-persona">
                    @php
                        $contadorActual = (int) ($vehiculo->nro_impresiones ?? 0);
                        $nroImpInicial = str_pad(max(1, $contadorActual), 6, '0', STR_PAD_LEFT);
                    @endphp
                    <div class="folio-ci">
                        <div>Nº IMP &nbsp;&nbsp;<span id="valor-nro-imp">{{ $nroImpInicial }}</span></div>
                        <div>CI.: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $vehiculo->ci }}</div>
                    </div>

                    <div class="qr-caja" id="qrcode-box" data-qr="{{ $vehiculo->codigo_qr }}"></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const box = document.getElementById("qrcode-box");
            const textoQr = box ? box.getAttribute("data-qr") : "";

            if (box && textoQr && typeof QRCode !== "undefined") {
                new QRCode(box, {
                    text: textoQr,
                    width: 78,
                    height: 78,
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.M
                });
            }

            const btnImprimir = document.getElementById("btn-imprimir-carnet");
            const spanNroImp = document.getElementById("valor-nro-imp");
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute("content");

            if (btnImprimir) {
                btnImprimir.addEventListener("click", function () {
                    fetch("{{ route('vehiculos.carnet.imprimir', $vehiculo->id) }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": csrfToken || "",
                            "Accept": "application/json",
                            "Content-Type": "application/json"
                        }
                    })
                    .then(response => response.ok ? response.json() : null)
                    .then(data => {
                        if (data && data.ok && spanNroImp && data.nro_imp_formateado) {
                            spanNroImp.textContent = data.nro_imp_formateado;
                        }
                    })
                    .catch(() => {})
                    .finally(() => {
                        window.print();
                    });
                });
            }
        });
    </script>

</body>
</html>