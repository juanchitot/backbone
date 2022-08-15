<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class State extends Model
{
    protected $fillable=['name','code','state_uid'];
    public function toArray()
    {
        return ['key' => $this->state_uid,
            'name' => strtoupper(Str::ascii($this->name)),
            'code' => $this->code];
    }
}
