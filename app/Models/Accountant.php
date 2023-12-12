<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accountant extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function accountantName(){
        return $this->belongsTo(User::class,'accountant_id','id');
    }
}
