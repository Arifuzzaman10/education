<?php

namespace App;

use App\Scopes\AcademicSchoolScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SmBankPaymentSlip extends Model
{
    use HasFactory;
    protected static function boot(){
        parent::boot();
        static::addGlobalScope(new AcademicSchoolScope);
    }
    public function studentInfo(){
    	return $this->belongsTo('App\SmStudent', 'student_id', 'id');
    }

    public function feesType(){
    	return $this->belongsTo('App\SmFeesType', 'fees_type_id', 'id');
    }
    public function bank(){
    	return $this->belongsTo('App\SmBankAccount', 'bank_id', 'id');
    }
    public function feesInstallment(){
    	return $this->belongsTo('Modules\University\Entities\UnFeesInstallmentAssign', 'un_fees_installment_id', 'id');
    }
}
