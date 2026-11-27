<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $tipo = strtoupper($request->get('tipo', 'TODOS'));

        $query = Vehiculo::query()->orderBy('created_at', 'desc');

        if ($tipo === 'MOTOCICLETA') {
            $query->where('clase', 'LIKE', '%MOTO%');
        } elseif ($tipo === 'VAGONETA') {
            $query->where('clase', 'LIKE', '%VAGONETA%');
        } elseif ($tipo === 'CAMIONETA') {
            $query->where('clase', 'LIKE', '%CAMIONETA%');
        } elseif ($tipo === 'AUTOMOVIL') {
            $query->where(function ($q) {
                $q->where('clase', 'LIKE', '%AUTOMOVIL%')
                  ->orWhere('clase', 'LIKE', '%AUTOMÓVIL%')
                  ->orWhere('clase', 'LIKE', '%AUTO%');
            });
        }

        $vehiculos = $query->get();

        // Contadores rápidos para los botones
        $totalTodos = Vehiculo::count();
        $totalMotocicletas = Vehiculo::where('clase', 'LIKE', '%MOTO%')->count();
        $totalVagonetas = Vehiculo::where('clase', 'LIKE', '%VAGONETA%')->count();
        $totalCamionetas = Vehiculo::where('clase', 'LIKE', '%CAMIONETA%')->count();
        $totalAutomoviles = Vehiculo::where(function ($q) {
            $q->where('clase', 'LIKE', '%AUTOMOVIL%')
              ->orWhere('clase', 'LIKE', '%AUTOMÓVIL%')
              ->orWhere('clase', 'LIKE', '%AUTO%');
        })->count();

        return view('reportes.index', compact(
            'vehiculos',
            'tipo',
            'totalTodos',
            'totalMotocicletas',
            'totalVagonetas',
            'totalCamionetas',
            'totalAutomoviles'
        ));
    }
}