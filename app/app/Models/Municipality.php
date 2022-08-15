<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Municipality extends Model
{
    protected $hidden = ['id'];
    protected $fillable = ['name', 'municipality_uid'];


    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function settlements()
    {
        return $this->hasMany(Settlement::class, 'municipality_id', 'id');
    }

    public function toArray()
    {
        return ['key' => $this->municipality_uid, 'name' => strtoupper(Str::ascii($this->name))];
    }
}
