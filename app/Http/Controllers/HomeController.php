<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $totalRegistrados = Vehiculo::count();
        $totalActivos     = Vehiculo::where('estado', 'ACTIVO')->count();

        $totalParticular = Vehiculo::whereIn('clase', [
            'PARTICULAR', 'AUTOMOVIL', 'AUTOMÓVIL', 'VAGONETA', 'MOTOCICLETA', 'MOTO', 'CAMIONETA'
        ])->count();

        $totalPublico = Vehiculo::whereIn('clase', [
            'PÚBLICO', 'PUBLICO', 'TAXI', 'TRANSPORTE', 'BUS', 'MINIBUS', 'MICRO'
        ])->count();

        $conCarnet = Vehiculo::whereNotNull('codigo_qr')->count();

        $registrosPorMes = Vehiculo::selectRaw('MONTH(created_at) as mes, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('mes')
            ->orderBy('mes')
            ->pluck('total', 'mes')
            ->toArray();

        $ultimosVehiculos = Vehiculo::latest()->take(5)->get();

        return view('home', compact(
            'totalRegistrados',
            'totalActivos',
            'totalParticular',
            'totalPublico',
            'conCarnet',
            'registrosPorMes',
            'ultimosVehiculos'
        ));
    }
}