<?php

namespace App\Models;
use App\Models\User;
use App\Models\Report;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    //
    protected $fillable = [
        'rep_id',
        'user_id',
        'username',
        'status',
        'remark',
        'action'
    ];

    public function report(){
        return $this->belongsTo(Report::class,'rep_id','id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
