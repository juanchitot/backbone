<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $hidden = ['id','city_uid'];
    protected $fillable = ['name','city_uid'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function municipalities()
    {
        return $this->hasMany(Municipality::class,'city_id','id');
    }

    public function toArray()
    {
        return ['key' => $this->id, 'name' => $this->name];
    }
}
