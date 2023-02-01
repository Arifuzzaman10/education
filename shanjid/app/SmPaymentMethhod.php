<?php

namespace App;

use App\Scopes\ActiveStatusSchoolScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmPaymentMethhod extends Model
{
    use HasFactory;
    protected Static function boot(){
        parent::boot();
        static::addGlobalScope(new ActiveStatusSchoolScope);
    }
    
    public function incomeAmounts()
    {
        return $this->hasMany('App\SmAddIncome', 'payment_method_id');
    }

    public function getIncomeAmountAttribute()
    {
        return $this->incomeAmounts->sum('amount');
    }

    public function expenseAmounts()
    {
        return $this->hasMany('App\SmAddExpense', 'payment_method_id');
    }

    public function getExpenseAmountAttribute()
    {
        return $this->expenseAmounts->sum('amount');
    }

}
