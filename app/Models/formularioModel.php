<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class formularioModel extends Model
{
    protected $table = 'formularios';
    protected $primaryKey = 'id';
    protected $fillable = [
        'titulo'
    ];
    public $timestamps = false;

    public function preguntas()
    {
        return $this->hasMany(PreguntasModel::class, 'formulario_id');
    }
}
