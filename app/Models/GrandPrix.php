<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrandPrix extends Model
{
    // fontos, mert a táblanév többes szám kivétel
    protected $table = 'grands_prix';

    protected $fillable = ['date','name','location'];

    public function results()
    {
        return $this->hasMany(Result::class);
    }
}
