<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Settlement extends Model
{
    protected $fillable = ['name', 'zip_code', 'settlement_uid'];
    protected $hidden = ['id', 'municipality_id', 'zone_type_id', 'settlement_type_id', 'zip_code', 'created_at', 'updated_at', 'settlement_uid'];

    //

    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }

    public function zoneType()
    {
        return $this->belongsTo(ZoneType::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }


    public function settlementType()
    {
        return $this->belongsTo(SettlementType::class);
    }

    public function toArray()
    {
        $data = [];
        $data['key'] = $this->settlement_uid;
        $data['name'] = strtoupper(Str::ascii($this->name));
        $data['zone_type'] = strtoupper($this->zoneType->name);
        $data['settlement_type'] = $this->settlementType->toArray();
        return $data;
    }
}
