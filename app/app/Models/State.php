<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable=['name','code'];
    public function toArray()
    {
        return ['key' => $this->id,
            'name' => $this->name,
            'code' => $this->code];
    }
}
