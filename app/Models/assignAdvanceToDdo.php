<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class assignAdvanceToDdo extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function ddoName(){
        return $this->belongsTo(User::class, 'ddo_id', 'id');
    }

    public function BudgetData(){
        return $this->belongsTo(assignBudgetToDdo::class, 'ddo_id', 'ddo_id');
    }
}
