<?php

namespace App\Models;
use App\Models\History;
use App\Models\Status;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    //
    protected $fillable = [
        'username',
        'report',
        'status',
        'user_id',
        'additional_information',
        'status_id'
    ];

    public function histories(){
        return $this->hasMany(History::class, 'rep_id', 'id');
    }

    public function status(){
        return $this->belongsTo(Status::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
