<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FederalEntity extends Model
{
    use HasFactory;

    //Siempre se devuelve en mayusculas
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strtoupper(transliterator_transliterate('Any-Latin; Latin-ASCII; [\u0080-\u7fff] remove',$value)),
        );
    }
}
