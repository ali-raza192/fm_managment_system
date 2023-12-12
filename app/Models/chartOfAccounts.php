<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chartOfAccounts extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function ddoName(){
        return $this->belongsTo(User::class, 'ddo_id', 'id');
    }
}
