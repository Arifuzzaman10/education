<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Saas\Entities\SmSubscriptionPayment;

class SmSchool extends Model
{
    use HasFactory;
    public function subscription()
    {
        return $this->hasOne(SmSubscriptionPayment::class, 'school_id')->latest();
    }

    public function academicYears()
    {
        return $this->hasMany(SmAcademicYear::class, 'school_id', 'id');
    }

    public function sections()
    {
        return $this->hasMany(SmSection::class, 'school_id');
    }

    public function classes()
    {
        return $this->hasMany(SmClass::class, 'school_id');
    }

    public function classTimes()
    {
        return $this->hasMany(SmClassTime::class, 'school_id')->where('type', 'class');
    }
    public function weekends()
    {
        return $this->hasMany(SmWeekend::class, 'school_id')->where('active_status', 1);
    }
    public function routineUpdates()
    {
        return $this->hasMany(SmClassRoutineUpdate::class, 'school_id')->where('active_status', 1);
    }
}
