<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pilot extends Model
{
    protected $table = 'pilots'; // nem kötelező, de egyértelmű

    protected $fillable = ['legacy_id','name','gender','birth_date','nationality'];

    protected $casts = [
        'legacy_id'  => 'integer',
        'birth_date' => 'date',
    ];

    public function results()
    {
        // App\Models\Result modellhez (ha van)
        return $this->hasMany(Result::class, 'pilot_id');
    }
}
