<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResetPassword extends Model
{
    use SoftDeletes;

    protected $table="reset_passwords";

    protected $fillable= ['token','user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
