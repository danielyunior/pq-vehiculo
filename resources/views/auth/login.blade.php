<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Iniciar Sesión | PQ-Vehículo - G.A.M. Puerto Quijarro</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700,800" rel="stylesheet">

    <!-- Bootstrap 5 CSS y Bootstrap Icons (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --pq-navy: #072258;
            --pq-navy-dark: #04173d;
            --pq-teal: #0d8a72;
            --pq-portal-top: #0b5d8a;
        }

        body {
            background: linear-gradient(180deg, #f3f7fb 0%, #e1ebf5 100%);
            color: #1e293b;
            font-family: 'Nunito', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            margin: 0;
        }

        .top-portal-bar {
            background-color: var(--pq-portal-top);
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
            padding: 0.5rem 1.5rem;
        }

        .top-portal-bar .nav-link-portal {
            color: #ffffff;
            font-weight: 700;
            font-size: 0.95rem;
            padding: 0.35rem 0.85rem;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            text-decoration: none;
        }

        .top-portal-bar .nav-link-portal:hover,
        .top-portal-bar .nav-link-portal:focus {
            background-color: rgba(255, 255, 255, 0.16);
            color: #ffffff;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            border: 1px solid #cbd8e6;
            border-radius: 16px;
            box-shadow: 0 12px 28px rgba(7, 34, 88, 0.12);
            overflow: hidden;
        }

        .login-header {
            background-color: var(--pq-navy);
            color: #ffffff;
            padding: 1.5rem;
            text-align: center;
        }

        .login-body {
            padding: 1.5rem 1.75rem 1.75rem 1.75rem;
        }

        .btn-pq-primary {
            background-color: var(--pq-navy);
            border-color: var(--pq-navy);
            color: #ffffff;
            font-weight: 700;
        }

        .btn-pq-primary:hover,
        .btn-pq-primary:focus {
            background-color: var(--pq-navy-dark);
            border-color: var(--pq-navy-dark);
            color: #ffffff;
        }

        .consulta-card-btn {
            background: #ffffff;
            border: 1px solid #bfd0e2;
            border-radius: 16px;
            padding: 1.35rem 1.6rem;
            color: var(--pq-navy);
            text-align: center;
            cursor: pointer;
            box-shadow: 0 10px 24px rgba(7, 34, 88, 0.1);
            min-width: 220px;
        }

        .consulta-card-btn:hover {
            background: #f8fafc;
            border-color: var(--pq-teal);
        }

        .consulta-icon-circle {
            width: 74px;
            height: 74px;
            border-radius: 50%;
            background-color: var(--pq-teal);
            color: #ffffff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            position: relative;
            margin-bottom: 0.65rem;
        }

        .consulta-icon-circle .lupa-badge {
            position: absolute;
            right: -2px;
            bottom: -2px;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background-color: #ffffff;
            color: var(--pq-teal);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            border: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <!-- Barra superior con menú Vehículo -> Pre-inscripción -->
    <header class="top-portal-bar d-flex align-items-center justify-content-between">
        <div class="dropdown">
            <a class="nav-link-portal dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-house-door-fill"></i>
                <span>Vehículo</span>
            </a>
            <ul class="dropdown-menu shadow border-0 mt-1">
                <li>
                    <a class="dropdown-item d-flex align-items-center gap-2 py-2 fw-semibold" href="{{ route('pre-registro.create') }}">
                        <i class="bi bi-card-checklist text-primary"></i>
                        <span>Pre-inscripción</span>
                    </a>
                </li>
            </ul>
        </div>

        <span class="text-white small d-none d-sm-inline">
            PQ-Vehículo · G.A.M. Puerto Quijarro
        </span>
    </header>

    <div class="container py-5">
        <div class="row justify-content-center align-items-center g-4">
            <div class="col-auto">
                <div class="login-card">
                    <div class="login-header">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-white bg-opacity-10 mb-2"
                             style="width: 54px; height: 54px;">
                            <i class="bi bi-car-front-fill fs-2 text-white"></i>
                        </div>
                        <h4 class="fw-bold mb-1">PQ-Vehículo</h4>
                        <div class="small text-white-50 lh-sm">
                            Gobierno Autónomo Municipal de Puerto Quijarro
                        </div>
                    </div>

                    <div class="login-body">
                        @if (session('status'))
                            <div class="alert alert-info small py-2" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if ($errors->has('email') || $errors->has('password'))
                            <div class="alert alert-danger small py-2" role="alert">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->get('email') as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                    @foreach ($errors->get('password') as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label small fw-bold text-dark">
                                    <i class="bi bi-envelope me-1 text-secondary"></i> Correo electrónico
                                </label>
                                <input
                                    id="email"
                                    type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="admin@puertoquijarro.gob.bo"
                                    required
                                    autocomplete="email"
                                    autofocus
                                >
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label small fw-bold text-dark">
                                    <i class="bi bi-lock me-1 text-secondary"></i> Contraseña
                                </label>
                                <input
                                    id="password"
                                    type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password"
                                    placeholder="Ingresa tu contraseña"
                                    required
                                    autocomplete="current-password"
                                >
                            </div>

                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label small text-muted" for="remember">
                                        Recordar sesión
                                    </label>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-pq-primary py-2 rounded-3 shadow-sm">
                                    <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar Sesión
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-auto">
                <button type="button"
                        class="consulta-card-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#modalConsultaTecnica">
                    <div class="consulta-icon-circle mx-auto">
                        <i class="bi bi-car-front-fill"></i>
                        <span class="lupa-badge"><i class="bi bi-search"></i></span>
                    </div>
                    <div class="fw-bold fs-6">Consulta Datos Técnicos</div>
                    <div class="small text-muted">Verificar por placa o C.I.</div>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal: Consulta Datos Técnicos -->
    <div class="modal fade" id="modalConsultaTecnica" tabindex="-1" aria-labelledby="modalConsultaTecnicaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow">
                <div class="modal-header text-white" style="background-color: var(--pq-navy);">
                    <h5 class="modal-title d-flex align-items-center gap-2" id="modalConsultaTecnicaLabel">
                        <i class="bi bi-search"></i>
                        Consulta Datos Técnicos
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('consulta.tecnica') }}" method="POST" class="row g-2 mb-3">
                        @csrf
                        <div class="col-sm-9">
                            <input
                                type="text"
                                name="buscar"
                                class="form-control text-uppercase"
                                value="{{ old('buscar') }}"
                                placeholder="Ingresa número de placa o C.I."
                                required
                            >
                        </div>
                        <div class="col-sm-3 d-grid">
                            <button type="submit" class="btn btn-success fw-semibold">
                                <i class="bi bi-search me-1"></i> Consultar
                            </button>
                        </div>
                    </form>

                    @if ($errors->has('buscar'))
                        <div class="alert alert-danger small py-2">{{ $errors->first('buscar') }}</div>
                    @endif

                    @if (session('consulta_error'))
                        <div class="alert alert-warning small py-2 mb-0">
                            <i class="bi bi-exclamation-triangle me-1"></i> {{ session('consulta_error') }}
                        </div>
                    @endif

                    @if (session('vehiculo_tecnico'))
                        @php $vt = session('vehiculo_tecnico'); @endphp
                        <div class="border rounded-3 p-3 bg-light">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <span class="badge bg-dark fs-6">{{ $vt['numero_placa'] }}</span>
                                    <span class="badge bg-info text-dark ms-1">{{ $vt['clase'] }}</span>
                                </div>
                                <span class="badge bg-success">{{ $vt['estado'] }}</span>
                            </div>

                            <div class="row g-2 small">
                                <div class="col-sm-6"><strong>Marca:</strong> <span class="text-uppercase">{{ $vt['marca'] }}</span></div>
                                <div class="col-sm-6"><strong>Tipo / Modelo:</strong> <span class="text-uppercase">{{ $vt['tipo_modelo'] }}</span></div>
                                <div class="col-sm-6"><strong>Color:</strong> <span class="text-uppercase">{{ $vt['color'] }}</span></div>
                                <div class="col-sm-6"><strong>Año:</strong> {{ $vt['anio'] }}</div>
                                <div class="col-sm-6"><strong>Cilindrada:</strong> {{ $vt['cilindrada'] }}</div>
                                <div class="col-sm-6"><strong>Combustible:</strong> {{ $vt['tipo_combustible'] }}</div>
                                <div class="col-sm-6"><strong>Capacidad:</strong> {{ $vt['capacidad'] }}</div>
                                <div class="col-sm-6"><strong>Vigencia:</strong> {{ $vt['vigencia'] }}</div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @if ($errors->has('buscar') || session('consulta_error') || session('vehiculo_tecnico'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modalEl = document.getElementById('modalConsultaTecnica');
            if (modalEl && typeof bootstrap !== 'undefined') {
                new bootstrap.Modal(modalEl).show();
            }
        });
    </script>
    @endif
</body>
</html>