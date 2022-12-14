<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoneType extends Model
{
    use HasFactory;

    protected $table = 'zones_types';

    //Siempre se devuelve en mayusculas. Nos ahorramos poner strtoupper en todas las respuestas
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strtoupper(transliterator_transliterate('Any-Latin; Latin-ASCII; [\u0080-\u7fff] remove',$value)),
        );
    }
}
