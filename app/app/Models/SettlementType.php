<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettlementType extends Model
{
    protected $fillable=['name'];
    protected $hidden=['id','created_at','updated_at'];
}
