<?php

namespace App\Http\Dto;

use App\Models\Municipality;

class ZipCodeDto
{

    public static function createFromMunicipality($zipCode, Municipality $municipality): array
    {
        $settlements = $municipality->settlements()->where('zip_code',$zipCode)->get();
        $result = array('municipality' => $municipality->toArray(),
            'zip_code' => $zipCode,
            'locality' => $municipality->name,
            'federal_entity' => $municipality->state,
            'settlements' => $settlements->toArray());
        return $result;
    }
}