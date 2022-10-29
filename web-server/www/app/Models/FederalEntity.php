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
            get: fn ($value) => strtoupper(iconv('UTF-8','ASCII//TRANSLIT',$value)),
        );
    }
}
