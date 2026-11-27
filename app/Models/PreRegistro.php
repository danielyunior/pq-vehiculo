<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreRegistro extends Model
{
    protected $table = 'pre_registros';

    protected $fillable = [
        'nombre',
        'apellido',
        'ci',
        'domicilio',
        'ocupacion',
        'lugar_trabajo',
        'telefono',
        'tipo_documento',
        'numero_placa',
        'clase',
        'marca',
        'tipo_modelo',
        'anio',
        'color',
        'numero_chasis',
        'numero_motor',
        'cilindrada',
        'tipo_combustible',
        'numero_puertas',
        'capacidad',
        'estado',
        'observacion',
        'doc_ci',
        'doc_propiedad',
        'doc_diprove',
    ];
}