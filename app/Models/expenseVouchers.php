<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class expenseVouchers extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function expenseName(){
        return $this->belongsTo(chartOfAccountsDetails::class, 'expense_id', 'id');
    }

    public function ddoName(){
        return $this->belongsTo(User::class, 'ddo_id', 'id');
    }
}
