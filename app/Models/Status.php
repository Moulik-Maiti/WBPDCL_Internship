<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    //
    protected $fillable=[
        'status', 'colour'
    ];

    public function report(){
        return $this->hasMany(Report::class);
    }
}
