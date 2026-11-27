<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'PQ-Vehículo') | G.A.M. Puerto Quijarro</title>

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
            --pq-bg: #f4f6fb;
        }

        body {
            background-color: var(--pq-bg);
            font-family: 'Nunito', system-ui, -apple-system, sans-serif;
            overflow-x: hidden;
        }

        .sidebar {
            width: 245px;
            min-height: 100vh;
            background: linear-gradient(180deg, var(--pq-navy) 0%, var(--pq-navy-dark) 100%);
            color: #ffffff;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 1.5rem 0;
            position: sticky;
            top: 0;
            height: 100vh;
        }

        .sidebar-brand {
            padding: 0 1.4rem 1.5rem 1.4rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        }

        .sidebar-nav .nav-link {
            color: rgba(255, 255, 255, 0.82);
            padding: 0.75rem 1.5rem;
            font-size: 0.95rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            position: relative;
            transition: all 0.2s ease;
        }

        .sidebar-nav .nav-link:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.08);
        }

        .sidebar-nav .nav-link.active {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.12);
        }

        .sidebar-nav .nav-link.active::before {
            content: "";
            position: absolute;
            left: 0;
            top: 8px;
            bottom: 8px;
            width: 4px;
            border-radius: 0 4px 4px 0;
            background-color: #ffffff;
        }

        .sidebar-footer {
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.12);
        }

        .main-wrapper {
            flex-grow: 1;
            min-width: 0;
            padding: 1.75rem 2.25rem;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                position: fixed;
                left: -245px;
                z-index: 1050;
                transition: left 0.25s ease;
            }
            .sidebar.show {
                left: 0;
            }
            .main-wrapper {
                padding: 1.25rem;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    @php
        $authUser = Auth::user();
        $avatarUrl = ($authUser && $authUser->avatar) ? asset('storage/' . $authUser->avatar) : null;
        $inicialAdmin = strtoupper(substr($authUser->name ?? 'A', 0, 1));
        $preRegistrosPendientes = \App\Models\PreRegistro::where('estado', 'pendiente')->latest()->get();
        $totalPrePendientes = $preRegistrosPendientes->count();
    @endphp

    <div id="app" class="d-flex">
        <aside id="sidebarMenu" class="sidebar">
            <div>
                <div class="sidebar-brand">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <i class="bi bi-car-front-fill fs-3 text-white"></i>
                        <span class="fs-4 fw-bold">PQ-Vehículo</span>
                    </div>
                    <div class="small text-white-50 lh-sm">
                        Gobierno Autónomo Municipal de Puerto Quijarro
                    </div>
                </div>

                <nav class="sidebar-nav nav flex-column mt-3">
                    <a href="{{ route('home') }}"
                       class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="bi bi-house-door fs-5"></i>
                        <span>Panel de Control</span>
                    </a>

                    <a href="{{ route('vehiculos.create') }}"
                       class="nav-link {{ request()->routeIs('vehiculos.create') ? 'active' : '' }}">
                        <i class="bi bi-car-front fs-5"></i>
                        <span>Registrar Vehículo</span>
                    </a>

                    <a href="{{ route('vehiculos.index') }}"
                       class="nav-link {{ request()->routeIs('vehiculos.index') ? 'active' : '' }}">
                        <i class="bi bi-list-ul fs-5"></i>
                        <span>Listado Completo</span>
                    </a>

                    <a href="{{ route('reportes.index') }}"
                       class="nav-link {{ request()->routeIs('reportes.*') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-bar-graph fs-5"></i>
                        <span>Reportes</span>
                    </a>

                    <a href="{{ route('vehiculos.index') }}" class="nav-link">
                        <i class="bi bi-calendar-check fs-5"></i>
                        <span>Vigencias</span>
                    </a>

                    <a href="#"
                       class="nav-link justify-content-between"
                       data-bs-toggle="modal"
                       data-bs-target="#modalNotificaciones">
                        <span class="d-flex align-items-center gap-3">
                            <i class="bi bi-bell fs-5"></i>
                            <span>Notificaciones</span>
                        </span>
                        @if ($totalPrePendientes > 0)
                            <span class="badge rounded-pill bg-danger">{{ $totalPrePendientes }}</span>
                        @endif
                    </a>
                </nav>
            </div>

            <div class="sidebar-footer">
                @auth
                    <div class="px-4 pb-2 small text-white-50 d-flex align-items-center gap-2">
                        @if ($avatarUrl)
                            <img src="{{ $avatarUrl }}" alt="Foto de perfil"
                                 class="rounded-circle object-fit-cover flex-shrink-0"
                                 style="width: 24px; height: 24px;">
                        @else
                            <i class="bi bi-person-circle fs-6"></i>
                        @endif
                        <span class="text-truncate">{{ $authUser->name }}</span>
                    </div>
                @endauth

                <nav class="sidebar-nav nav flex-column">
                    <a href="#" class="nav-link">
                        <i class="bi bi-question-circle fs-5"></i>
                        <span>Ayuda</span>
                    </a>

                    <a href="{{ route('logout') }}" class="nav-link"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right fs-5"></i>
                        <span>Cerrar Sesión</span>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </nav>
            </div>
        </aside>

        <main class="main-wrapper">
            <div class="d-lg-none mb-3">
                <button class="btn btn-dark btn-sm" type="button" onclick="document.getElementById('sidebarMenu').classList.toggle('show')">
                    <i class="bi bi-list fs-5"></i> Menú
                </button>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Modal: Notificaciones y Pre-registros Pendientes -->
    <div class="modal fade" id="modalNotificaciones" tabindex="-1" aria-labelledby="modalNotificacionesLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow">
                <div class="modal-header text-white" style="background-color: var(--pq-navy);">
                    <h5 class="modal-title d-flex align-items-center gap-2" id="modalNotificacionesLabel">
                        <i class="bi bi-bell-fill"></i>
                        Notificaciones y Pre-registros ({{ $totalPrePendientes }})
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    @forelse ($preRegistrosPendientes as $pre)
                        <div class="border rounded-3 p-3 mb-3 bg-light">
                            <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-2">
                                <div>
                                    <span class="badge bg-dark me-1">{{ $pre->numero_placa }}</span>
                                    <span class="badge bg-info text-dark">{{ $pre->clase }}</span>
                                    <strong class="ms-1 text-uppercase">{{ $pre->nombre }} {{ $pre->apellido }}</strong>
                                    <span class="text-muted small ms-1">· C.I. {{ $pre->ci }}</span>
                                </div>
                                <small class="text-muted">{{ $pre->created_at->diffForHumans() }}</small>
                            </div>

                            <div class="small text-secondary mb-2">
                                Vehículo: <strong class="text-uppercase">{{ $pre->marca }} / {{ $pre->tipo_modelo }}</strong> ·
                                Color: <strong class="text-uppercase">{{ $pre->color }}</strong>
                                @if ($pre->telefono)
                                    · Tel: <strong>{{ $pre->telefono }}</strong>
                                @endif
                            </div>

                            <div class="d-flex flex-wrap gap-2 mb-3">
                                @if ($pre->doc_ci)
                                    <a href="{{ asset('storage/' . $pre->doc_ci) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-file-earmark-person me-1"></i> Carnet de Identidad
                                    </a>
                                @endif
                                @if ($pre->doc_propiedad)
                                    <a href="{{ asset('storage/' . $pre->doc_propiedad) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-file-earmark-richtext me-1"></i> Carnet de Propiedad
                                    </a>
                                @endif
                                @if ($pre->doc_diprove)
                                    <a href="{{ asset('storage/' . $pre->doc_diprove) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-file-earmark-check me-1"></i> Hoja de DIPROVE
                                    </a>
                                @endif
                                @if (!$pre->doc_ci && !$pre->doc_propiedad && !$pre->doc_diprove)
                                    <span class="text-muted small fst-italic">Sin documentos adjuntos en esta solicitud.</span>
                                @endif
                            </div>

                            <div class="d-flex gap-2">
                                <form action="{{ route('pre-registros.aprobar', $pre->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm fw-semibold">
                                        <i class="bi bi-check-circle me-1"></i> Aprobar y Registrar
                                    </button>
                                </form>

                                <form action="{{ route('pre-registros.rechazar', $pre->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-x-circle me-1"></i> Rechazar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">
                            <i class="bi bi-bell-slash fs-2 d-block mb-2"></i>
                            No hay pre-registros pendientes por revisar en este momento.
                        </div>
                    @endforelse
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Administrador de Cuentas y Datos del Administrador -->
    <div class="modal fade" id="modalAdminCuenta" tabindex="-1" aria-labelledby="modalAdminCuentaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header text-white" style="background-color: var(--pq-navy);">
                    <h5 class="modal-title d-flex align-items-center gap-2" id="modalAdminCuentaLabel">
                        <i class="bi bi-person-gear"></i>
                        Administrador de Cuentas
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <form action="{{ route('admin.cuenta.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        @if ($errors->any())
                            <div class="alert alert-danger small py-2">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="d-flex align-items-center gap-3 mb-3 p-3 bg-light rounded-3">
                            @if ($avatarUrl)
                                <img id="avatarPreview" src="{{ $avatarUrl }}" alt="Foto de perfil"
                                     class="rounded-circle object-fit-cover flex-shrink-0 border"
                                     style="width: 56px; height: 56px;">
                            @else
                                <div id="avatarFallback"
                                     class="rounded-circle text-white d-flex align-items-center justify-content-center fw-bold fs-4 flex-shrink-0"
                                     style="width: 56px; height: 56px; background-color: var(--pq-navy);">
                                    {{ $inicialAdmin }}
                                </div>
                                <img id="avatarPreview" src="" alt="Vista previa"
                                     class="rounded-circle object-fit-cover flex-shrink-0 border d-none"
                                     style="width: 56px; height: 56px;">
                            @endif

                            <div class="min-w-0">
                                <div class="fw-bold fs-6 text-dark text-truncate">
                                    {{ $authUser->name ?? 'Administrador PQ' }}
                                </div>
                                <div class="text-muted small text-truncate">
                                    {{ $authUser->email ?? 'admin@puertoquijarro.gob.bo' }}
                                </div>
                                <span class="badge bg-success mt-1">G.A.M. Puerto Quijarro · ID {{ $authUser->id ?? '—' }}</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="admin_avatar" class="form-label small fw-bold">Foto de perfil (opcional)</label>
                            <input
                                type="file"
                                id="admin_avatar"
                                name="avatar"
                                class="form-control form-control-sm"
                                accept="image/jpeg,image/png,image/webp"
                            >
                            <div class="form-text">Formatos permitidos: JPG, PNG o WEBP (máximo 2 MB).</div>
                        </div>

                        <div class="mb-3">
                            <label for="admin_name" class="form-label small fw-bold">Nombre completo</label>
                            <input
                                type="text"
                                id="admin_name"
                                name="name"
                                class="form-control"
                                value="{{ old('name', $authUser->name ?? '') }}"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="admin_email" class="form-label small fw-bold">Correo electrónico</label>
                            <input
                                type="email"
                                id="admin_email"
                                name="email"
                                class="form-control"
                                value="{{ old('email', $authUser->email ?? '') }}"
                                required
                            >
                        </div>

                        <hr class="my-3">
                        <div class="small text-muted mb-2 fw-semibold">Cambiar contraseña (opcional)</div>

                        <div class="row g-2">
                            <div class="col-md-6">
                                <label for="admin_password" class="form-label small fw-bold">Nueva contraseña</label>
                                <input
                                    type="password"
                                    id="admin_password"
                                    name="password"
                                    class="form-control"
                                    placeholder="Dejar en blanco para mantener"
                                >
                            </div>
                            <div class="col-md-6">
                                <label for="admin_password_confirmation" class="form-label small fw-bold">Confirmar contraseña</label>
                                <input
                                    type="password"
                                    id="admin_password_confirmation"
                                    name="password_confirmation"
                                    class="form-control"
                                    placeholder="Repetir contraseña"
                                >
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer bg-light d-flex justify-content-between">
                        <a href="{{ route('vehiculos.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-list-ul me-1"></i> Listado Completo
                        </a>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary btn-sm fw-semibold">
                                <i class="bi bi-check-lg me-1"></i> Guardar Cambios
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS y Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const inputAvatar = document.getElementById('admin_avatar');
            const previewImg = document.getElementById('avatarPreview');
            const fallbackDiv = document.getElementById('avatarFallback');

            if (inputAvatar && previewImg) {
                inputAvatar.addEventListener('change', function (e) {
                    const file = e.target.files[0];
                    if (!file) return;

                    const reader = new FileReader();
                    reader.onload = function (event) {
                        previewImg.src = event.target.result;
                        previewImg.classList.remove('d-none');
                        if (fallbackDiv) {
                            fallbackDiv.classList.add('d-none');
                        }
                    };
                    reader.readAsDataURL(file);
                });
            }

            @if ($errors->any())
            const modalEl = document.getElementById('modalAdminCuenta');
            if (modalEl && typeof bootstrap !== 'undefined') {
                const modal = new bootstrap.Modal(modalEl);
                modal.show();
            }
            @endif
        });
    </script>

    @stack('scripts')
</body>
</html>