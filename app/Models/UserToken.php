<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserToken extends Model
{
    use SoftDeletes;
    protected $fillable=[
        'user_id',
        'token',
        'expire_time'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
