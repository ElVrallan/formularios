<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class respuestasModel extends Model
{
    protected $table = 'respuestas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'pregunta_id',
        'respuesta'
    ];
    public $timestamps = false;

    public function pregunta()
    {
        return $this->belongsTo(PreguntasModel::class, 'pregunta_id');
    }
}
