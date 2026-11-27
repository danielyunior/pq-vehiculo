<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class VehiculoController extends Controller
{
    public function index(Request $request)
    {
        $query = Vehiculo::query();

        if ($request->filled('buscar')) {
            $buscar = trim($request->input('buscar'));
            $query->where(function ($q) use ($buscar) {
                $q->where('numero_placa', 'like', "%{$buscar}%")
                  ->orWhere('nombre', 'like', "%{$buscar}%")
                  ->orWhere('apellido', 'like', "%{$buscar}%")
                  ->orWhere('ci', 'like', "%{$buscar}%")
                  ->orWhere('marca', 'like', "%{$buscar}%")
                  ->orWhere('numero_motor', 'like', "%{$buscar}%");
            });
        }

        if ($request->filled('clase')) {
            $query->where('clase', $request->input('clase'));
        }

        $vehiculos = $query->latest()->paginate(15)->withQueryString();

        return view('vehiculos.index', compact('vehiculos'));
    }

    public function create()
    {
        return view('vehiculos.create');
    }

    public function store(Request $request)
    {
        $motorNormalizado = strtoupper(trim((string) $request->input('numero_motor', '')));
        $esMotorND = in_array($motorNormalizado, ['', 'N/D', 'S/N'], true);

        $rules = [
            'nombre'           => ['required', 'string', 'max:120'],
            'apellido'         => ['required', 'string', 'max:120'],
            'ci'               => ['required', 'string', 'max:30'],
            'domicilio'        => ['required', 'string', 'max:255'],
            'ocupacion'        => ['required', 'string', 'max:100'],
            'lugar_trabajo'    => ['required', 'string', 'max:150'],
            'marca'            => ['required', 'string', 'max:80'],
            'clase'            => ['required', 'string', 'max:50'],
            'color'            => ['required', 'string', 'max:40'],
            'numero_chasis'    => ['required', 'string', 'max:100'],
            'numero_motor'     => $esMotorND
                ? ['required', 'string', 'max:100']
                : ['required', 'string', 'max:100', Rule::unique('vehiculos', 'numero_motor')],
            'cilindrada'       => ['nullable', 'string', 'max:50'],
            'tipo_combustible' => ['required', 'string', 'max:50'],
            'numero_puertas'   => ['nullable', 'integer', 'min:0', 'max:10'],
            'tipo_modelo'      => ['required', 'string', 'max:80'],
            'anio'             => ['required', 'integer', 'min:1950', 'max:2030'],
            'capacidad'        => ['nullable', 'string', 'max:50'],
            'numero_placa'     => ['required', 'string', 'max:30', Rule::unique('vehiculos', 'numero_placa')],
            'tipo_documento'   => ['nullable', 'string', 'max:50'],
            'estado'           => ['nullable', 'string', 'max:30'],
        ];

        $validated = $request->validate($rules);

        $validated['numero_placa'] = strtoupper(trim($validated['numero_placa']));
        $validated['numero_chasis'] = strtoupper(trim($validated['numero_chasis']));
        $validated['numero_motor'] = $esMotorND ? 'N/D' : strtoupper(trim($validated['numero_motor']));
        $validated['codigo_qr'] = 'PQV-' . preg_replace('/\s+/', '', $validated['numero_placa']) . '-' . strtoupper(Str::random(5));
        $validated['estado'] = $validated['estado'] ?? 'Activo';

        Vehiculo::create($validated);

        return redirect()->route('vehiculos.index')->with('success', 'Vehículo registrado correctamente.');
    }

    public function show(Vehiculo $vehiculo)
    {
        return view('vehiculos.show', compact('vehiculo'));
    }

    public function edit(Vehiculo $vehiculo)
    {
        return view('vehiculos.edit', compact('vehiculo'));
    }

    public function update(Request $request, Vehiculo $vehiculo)
    {
        $motorNormalizado = strtoupper(trim((string) $request->input('numero_motor', '')));
        $esMotorND = in_array($motorNormalizado, ['', 'N/D', 'S/N'], true);

        $rules = [
            'nombre'           => ['required', 'string', 'max:120'],
            'apellido'         => ['required', 'string', 'max:120'],
            'ci'               => ['required', 'string', 'max:30'],
            'domicilio'        => ['required', 'string', 'max:255'],
            'ocupacion'        => ['required', 'string', 'max:100'],
            'lugar_trabajo'    => ['required', 'string', 'max:150'],
            'marca'            => ['required', 'string', 'max:80'],
            'clase'            => ['required', 'string', 'max:50'],
            'color'            => ['required', 'string', 'max:40'],
            'numero_chasis'    => ['required', 'string', 'max:100'],
            'numero_motor'     => $esMotorND
                ? ['required', 'string', 'max:100']
                : ['required', 'string', 'max:100', Rule::unique('vehiculos', 'numero_motor')->ignore($vehiculo->id)],
            'cilindrada'       => ['nullable', 'string', 'max:50'],
            'tipo_combustible' => ['required', 'string', 'max:50'],
            'numero_puertas'   => ['nullable', 'integer', 'min:0', 'max:10'],
            'tipo_modelo'      => ['required', 'string', 'max:80'],
            'anio'             => ['required', 'integer', 'min:1950', 'max:2030'],
            'capacidad'        => ['nullable', 'string', 'max:50'],
            'numero_placa'     => ['required', 'string', 'max:30', Rule::unique('vehiculos', 'numero_placa')->ignore($vehiculo->id)],
            'tipo_documento'   => ['nullable', 'string', 'max:50'],
            'estado'           => ['nullable', 'string', 'max:30'],
        ];

        $validated = $request->validate($rules);

        $validated['numero_placa'] = strtoupper(trim($validated['numero_placa']));
        $validated['numero_chasis'] = strtoupper(trim($validated['numero_chasis']));
        $validated['numero_motor'] = $esMotorND ? 'N/D' : strtoupper(trim($validated['numero_motor']));

        $vehiculo->update($validated);

        return redirect()->route('vehiculos.index')->with('success', 'Datos del vehículo actualizados correctamente.');
    }

    public function destroy(Vehiculo $vehiculo)
    {
        $vehiculo->delete();

        return redirect()->route('vehiculos.index')->with('success', 'Vehículo eliminado correctamente.');
    }

    public function carnet(Vehiculo $vehiculo)
    {
        return view('vehiculos.carnet', compact('vehiculo'));
    }

    public function registrarImpresion(Vehiculo $vehiculo)
    {
        return back()->with('success', 'Impresión de carnet registrada.');
    }
}