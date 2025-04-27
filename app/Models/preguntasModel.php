<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class preguntasModel extends Model
{
    protected $table = 'preguntas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'formulario_id',
        'pregunta',
        'tipo',
        'opciones'
    ];
    public $timestamps = false;

    public function respuestas()
    {
        return $this->hasMany(RespuestasModel::class, 'pregunta_id');
    }
}
