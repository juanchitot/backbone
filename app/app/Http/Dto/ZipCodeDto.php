<?php

namespace App\Http\Dto;

use App\Models\Municipality;
use App\Models\Settlement;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ZipCodeDto
{

    public static function createFromMunicipality($zipCode, Municipality $municipality): array
    {
        /* @var $settlements Collection */
        $settlements = $municipality->settlements()
            ->where('zip_code', $zipCode)
            ->orderBy('settlement_uid')
            ->get();
        $locality = '';
        /* @var $firstSettlement Settlement */
        $firstSettlement = $settlements->first();
        if ($firstSettlement->city) {
            $locality = strtoupper(Str::ascii($firstSettlement->city->name));
        }

        $result = array(
            'zip_code' => $zipCode,
            'locality' => $locality,
            'federal_entity' => $municipality->state,
            'settlements' => $settlements->toArray(),
            'municipality' => $municipality->toArray());
        return $result;
    }
}