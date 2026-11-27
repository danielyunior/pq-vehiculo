<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

    protected $table = 'vehiculos';

    protected $fillable = [
        'nombre',
        'apellido',
        'ci',
        'domicilio',
        'ocupacion',
        'lugar_trabajo',
        'marca',
        'clase',
        'color',
        'numero_chasis',
        'numero_motor',
        'cilindrada',
        'tipo_combustible',
        'numero_puertas',
        'tipo_modelo',
        'anio',
        'capacidad',
        'numero_placa',
        'tipo_documento',
        'codigo_qr',
        'estado'
    ];
}