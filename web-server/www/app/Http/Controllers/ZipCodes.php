<?php

namespace App\Http\Controllers;

use App\Models\Municipality;
use App\Models\Settlement;
use stdClass;

class ZipCodes extends Controller
{
    //La complejidad del controlador no va a crecer, la lógica puede quedar acá
    public function getInfo($zipcode)
    {
        $response['zip_code']=$zipcode;

        //Buscamos los asentamientos, pero con sus relaciones.
        $settlements = Settlement::with('zoneType','settlementType','federalEntity')
            ->where('zip_code','=',$zipcode)
            ->get();

        if (!$settlements->isEmpty()) {

            // Según analisis de datos, no hay asentamientos de distintas localidades. Tomamos el primero.
            $response['locality'] = $settlements[0]['locality_name'];

            // Según analisis de datos, no hay asentamientos de distintos estados. Tomamos el primero.
            // Armamos el formato del JSON del ejemplo.
            $response['federal_entity'] = new stdClass();
            $response['federal_entity']->key = $settlements[0]->federalEntity->id;
            $response['federal_entity']->name = $settlements[0]->federalEntity->name;
            $response['federal_entity']->code = $settlements[0]->federalEntity->code;

            // A Municipalidades le dejamos clave compuesta. No podemos recuperar la relación con Eloquent.
            // Buscamos manualmente.
            $municipality = Municipality::where('federal_entity_id', '=', $settlements[0]->federal_entity_id)
                ->where('id', '=', $settlements[0]->municipality_id)
                ->select('id as key', 'name')
                ->first();

            //El objeto recuperado ya tiene el formato del JSON definido.
            $response['municipality'] = $municipality;

            //Armamos la sección de asentamientos según el JSON definido.
            $response['settlements'] = array();
            foreach ($settlements as $item) {
                $settlement['key'] = $item['id'];
                $settlement['name'] = $item['name'];
                $settlement['zone_type'] = $item->zoneType->name;
                $settlement['settlement_type'] = $item->settlementType->setHidden(['id', 'created_at', 'updated_at', 'deleted_at']);
                array_push($response['settlements'], $settlement);
            }

        }else{
            $response['msg'] = 'No se han encontrado resultados para el código postal recibido';
        }

        return response($response, 200);
    }
}
