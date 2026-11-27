<?php

namespace App\Http\Controllers;

use App\Models\PreRegistro;
use App\Models\Vehiculo;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PreRegistroController extends Controller
{
    public function create(): View
    {
        return view('pre-registro.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre'           => ['required', 'string', 'max:120'],
            'apellido'         => ['required', 'string', 'max:120'],
            'ci'               => ['required', 'string', 'max:30'],
            'domicilio'        => ['required', 'string', 'max:255'],
            'ocupacion'        => ['required', 'string', 'max:100'],
            'lugar_trabajo'    => ['required', 'string', 'max:150'],
            'telefono'         => ['nullable', 'string', 'max:30'],
            'tipo_documento'   => ['nullable', 'string', 'max:50'],
            'numero_placa'     => ['required', 'string', 'max:30'],
            'clase'            => ['required', 'string', 'max:50'],
            'marca'            => ['required', 'string', 'max:80'],
            'tipo_modelo'      => ['required', 'string', 'max:80'],
            'anio'             => ['required', 'integer', 'min:1950', 'max:2030'],
            'color'            => ['required', 'string', 'max:40'],
            'numero_chasis'    => ['required', 'string', 'max:100'],
            'numero_motor'     => ['required', 'string', 'max:100'],
            'cilindrada'       => ['nullable', 'string', 'max:50'],
            'tipo_combustible' => ['required', 'string', 'max:50'],
            'numero_puertas'   => ['nullable', 'integer', 'min:0', 'max:10'],
            'capacidad'        => ['nullable', 'string', 'max:50'],
            'doc_ci'           => ['required', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:5120'],
            'doc_propiedad'    => ['required', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:5120'],
            'doc_diprove'      => ['required', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:5120'],
        ], [
            'nombre.required'           => 'El nombre es obligatorio.',
            'apellido.required'         => 'El apellido es obligatorio.',
            'ci.required'               => 'El C.I. es obligatorio.',
            'domicilio.required'        => 'El domicilio es obligatorio.',
            'ocupacion.required'        => 'La ocupación es obligatoria.',
            'lugar_trabajo.required'    => 'El lugar de trabajo es obligatorio.',
            'numero_placa.required'     => 'El número de placa es obligatorio.',
            'clase.required'            => 'La clase de vehículo es obligatoria.',
            'marca.required'            => 'La marca es obligatoria.',
            'tipo_modelo.required'      => 'El tipo o modelo es obligatorio.',
            'anio.required'             => 'El año es obligatorio.',
            'color.required'            => 'El color es obligatorio.',
            'numero_chasis.required'    => 'El número de chasis es obligatorio.',
            'numero_motor.required'     => 'El número de motor es obligatorio.',
            'tipo_combustible.required' => 'El tipo de combustible es obligatorio.',
            'doc_ci.required'           => 'Debes adjuntar fotocopia legible del Carnet de Identidad.',
            'doc_ci.mimes'              => 'El Carnet de Identidad debe ser PDF, JPG, JPEG, PNG o WEBP.',
            'doc_ci.max'                => 'El Carnet de Identidad no debe superar los 5 MB.',
            'doc_propiedad.required'    => 'Debes adjuntar fotocopia legible del Carnet de Propiedad del Vehículo.',
            'doc_propiedad.mimes'       => 'El Carnet de Propiedad debe ser PDF, JPG, JPEG, PNG o WEBP.',
            'doc_propiedad.max'         => 'El Carnet de Propiedad no debe superar los 5 MB.',
            'doc_diprove.required'      => 'Debes adjuntar fotocopia legible de la Hoja de DIPROVE.',
            'doc_diprove.mimes'         => 'La Hoja de DIPROVE debe ser PDF, JPG, JPEG, PNG o WEBP.',
            'doc_diprove.max'           => 'La Hoja de DIPROVE no debe superar los 5 MB.',
        ]);

        $validated['numero_placa'] = strtoupper(trim($validated['numero_placa']));
        $validated['numero_chasis'] = strtoupper(trim($validated['numero_chasis']));
        $validated['numero_motor'] = strtoupper(trim($validated['numero_motor'])) === 'N/D'
            ? 'N/D'
            : strtoupper(trim($validated['numero_motor']));
        $validated['estado'] = 'pendiente';

        $validated['doc_ci'] = $request->file('doc_ci')->store('pre-registros/ci', 'public');
        $validated['doc_propiedad'] = $request->file('doc_propiedad')->store('pre-registros/propiedad', 'public');
        $validated['doc_diprove'] = $request->file('doc_diprove')->store('pre-registros/diprove', 'public');

        PreRegistro::create($validated);

        return redirect()
            ->route('pre-registro.create')
            ->with('success', '¡Pre-inscripción enviada con sus 3 requisitos adjuntos! El administrador revisará tu solicitud.');
    }

    public function consultaTecnica(Request $request): RedirectResponse
    {
        $request->validate([
            'buscar' => ['required', 'string', 'max:50'],
        ], [
            'buscar.required' => 'Ingresa el número de placa o C.I. para consultar.',
        ]);

        $termino = strtoupper(trim($request->input('buscar')));
        $raw = trim($request->input('buscar'));

        $vehiculo = Vehiculo::whereRaw('UPPER(numero_placa) = ?', [$termino])
            ->orWhere('ci', $raw)
            ->first();

        if (!$vehiculo) {
            return back()
                ->withInput()
                ->with('consulta_error', "No se encontraron datos técnicos registrados para «{$raw}».");
        }

        return back()
            ->withInput()
            ->with('vehiculo_tecnico', [
                'numero_placa'     => $vehiculo->numero_placa,
                'clase'            => $vehiculo->clase,
                'marca'            => $vehiculo->marca,
                'tipo_modelo'      => $vehiculo->tipo_modelo,
                'color'            => $vehiculo->color,
                'anio'             => $vehiculo->anio ?? 'N/D',
                'cilindrada'       => $vehiculo->cilindrada ?? 'N/D',
                'tipo_combustible' => $vehiculo->tipo_combustible ?? 'N/D',
                'capacidad'        => $vehiculo->capacidad ?? 'N/D',
                'estado'           => $vehiculo->estado ?? 'Activo',
                'vigencia'         => $vehiculo->vigencia ?? '31 DIC 2026',
            ]);
    }

    private function chasisUnicoSeguro(string $valor): string
    {
        $limpio = strtoupper(trim($valor));

        if ($limpio === '' || in_array($limpio, ['N/D', 'S/N', 'NO ESPECIFICADO', 'PENDIENTE'], true)) {
            return 'CHS-' . strtoupper(Str::random(7));
        }

        if (!Schema::hasColumn('vehiculos', 'numero_chasis')) {
            return $limpio;
        }

        $existe = Vehiculo::whereRaw('UPPER(numero_chasis) = ?', [$limpio])->exists();
        if (!$existe) {
            return $limpio;
        }

        return $limpio . '-' . strtoupper(Str::random(4));
    }

    public function aprobar(PreRegistro $preRegistro): RedirectResponse
    {
        if ($preRegistro->estado !== 'pendiente') {
            return back()->with('success', 'Este pre-registro ya fue procesado anteriormente.');
        }

        try {
            DB::transaction(function () use ($preRegistro) {
                $placaLimpia = strtoupper(trim($preRegistro->numero_placa));
                $motorIngresado = strtoupper(trim((string) $preRegistro->numero_motor));
                $motorFinal = $motorIngresado === '' ? 'N/D' : $motorIngresado;
                $chasisSeguro = $this->chasisUnicoSeguro((string) $preRegistro->numero_chasis);

                $candidatos = [
                    'nombre'           => $preRegistro->nombre,
                    'apellido'         => $preRegistro->apellido,
                    'ci'               => $preRegistro->ci,
                    'domicilio'        => $preRegistro->domicilio ?: 'Puerto Quijarro',
                    'ocupacion'        => $preRegistro->ocupacion ?: 'No especificado',
                    'lugar_trabajo'    => $preRegistro->lugar_trabajo ?: 'No especificado',
                    'telefono'         => $preRegistro->telefono ?? 'S/N',
                    'tipo_documento'   => $preRegistro->tipo_documento ?: 'C.I.',
                    'numero_placa'     => $placaLimpia,
                    'clase'            => $preRegistro->clase,
                    'marca'            => $preRegistro->marca,
                    'tipo_modelo'      => $preRegistro->tipo_modelo,
                    'anio'             => $preRegistro->anio ?: (int) date('Y'),
                    'color'            => $preRegistro->color,
                    'numero_chasis'    => $chasisSeguro,
                    'numero_motor'     => $motorFinal,
                    'cilindrada'       => $preRegistro->cilindrada ?: 'N/D',
                    'tipo_combustible' => $preRegistro->tipo_combustible ?: 'Gasolina',
                    'numero_puertas'   => $preRegistro->numero_puertas ?? 0,
                    'capacidad'        => $preRegistro->capacidad ?: 0,
                    'codigo_qr'        => 'PQV-' . preg_replace('/\s+/', '', $placaLimpia) . '-' . strtoupper(Str::random(5)),
                    'estado'           => 'Activo',
                    'vigencia'         => '31 DIC 2026',
                ];

                $datosVehiculo = [];
                foreach ($candidatos as $columna => $valor) {
                    if (Schema::hasColumn('vehiculos', $columna)) {
                        $datosVehiculo[$columna] = $valor;
                    }
                }

                foreach (Schema::getColumns('vehiculos') as $col) {
                    $nombreCol = $col['name'] ?? null;
                    if (!$nombreCol || in_array($nombreCol, ['id', 'created_at', 'updated_at'], true)) {
                        continue;
                    }

                    $esNullable = (bool) ($col['nullable'] ?? true);
                    $tieneDefault = !is_null($col['default'] ?? null);
                    $esAutoIncrement = (bool) ($col['auto_increment'] ?? false);

                    if (!$esNullable && !$tieneDefault && !$esAutoIncrement && !array_key_exists($nombreCol, $datosVehiculo)) {
                        $tipo = strtolower((string) ($col['type_name'] ?? ''));

                        if (str_contains($tipo, 'int') || str_contains($tipo, 'dec') || str_contains($tipo, 'float') || str_contains($tipo, 'double')) {
                            $datosVehiculo[$nombreCol] = 0;
                        } elseif (str_contains($tipo, 'bool')) {
                            $datosVehiculo[$nombreCol] = false;
                        } elseif ($tipo === 'date') {
                            $datosVehiculo[$nombreCol] = now()->toDateString();
                        } elseif (str_contains($tipo, 'datetime') || $tipo === 'timestamp') {
                            $datosVehiculo[$nombreCol] = now()->toDateTimeString();
                        } else {
                            $datosVehiculo[$nombreCol] = 'No especificado';
                        }
                    }
                }

                Vehiculo::create($datosVehiculo);

                $preRegistro->update(['estado' => 'aprobado']);
            });
        } catch (UniqueConstraintViolationException $e) {
            return back()->with('error', 'No se pudo aprobar: ya existe un vehículo registrado con un dato único duplicado.');
        }

        return back()->with('success', "Pre-registro de placa {$preRegistro->numero_placa} aprobado y registrado en vehículos.");
    }

    public function rechazar(Request $request, PreRegistro $preRegistro): RedirectResponse
    {
        $preRegistro->update([
            'estado'      => 'rechazado',
            'observacion' => $request->input('observacion', 'Rechazado por administración.'),
        ]);

        return back()->with('success', "Pre-registro de placa {$preRegistro->numero_placa} marcado como rechazado.");
    }
}