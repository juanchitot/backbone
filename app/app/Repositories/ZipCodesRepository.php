<?php

namespace App\Repositories;

use App\Models\Municipality;

class ZipCodesRepository
{

    public function municipalityByZipCode($code): ?Municipality
    {
        $municipalityId = Municipality::query()
            ->join('settlements', 'settlements.municipality_id', 'municipalities.id')
            ->where('zip_code', (int)$code)
            ->pluck('municipalities.id')
            ->first();
        if ($municipalityId)
            return Municipality::query()->find($municipalityId);
    }
}