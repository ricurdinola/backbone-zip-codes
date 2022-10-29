<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    use HasFactory;
    //No lo queremos recuperar siempre, a si que lo dejamos comentado.
    //protected $with = ['zoneType','settlementType'];


    //Siempre se devuelve en mayusculas
    protected function localityName(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strtoupper(iconv('UTF-8','ASCII//TRANSLIT',$value)),
        );
    }

    //Siempre se devuelve en mayusculas
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strtoupper(iconv('UTF-8','ASCII//TRANSLIT',$value)),
        );
    }

    /********* RELACIONES *********/
    public function zoneType()
    {
        return $this->belongsTo(ZoneType::class,'zone_id','id');
    }

    public function settlementType()
    {
        return $this->belongsTo(SettlementType::class,'settlement_type_id','id');
    }

    public function federalEntity()
    {
        return $this->belongsTo(FederalEntity::class,'federal_entity_id','id');
    }
}
