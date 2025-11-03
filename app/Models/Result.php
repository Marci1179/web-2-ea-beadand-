<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = ['pilot_id','grand_prix_id','place','issue','team','chassis','engine'];

    public function pilot()
    {
        return $this->belongsTo(Pilot::class);
    }

    public function grandPrix()
    {
        return $this->belongsTo(GrandPrix::class);
    }
}
