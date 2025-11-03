<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pilot extends Model
{
    protected $fillable = ['legacy_id','name','gender','birth_date','nationality'];

    public function results()
    {
        return $this->hasMany(Result::class);
    }
}
