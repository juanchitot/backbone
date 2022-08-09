<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    protected $hidden = ['id'];
    protected $fillable = ['name'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function settlements()
    {
        return $this->hasMany(Settlement::class,'municipality_id','id');
    }

    public function toArray()
    {
        return ['key' => $this->id, 'name' => $this->name];
    }
}
