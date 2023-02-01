<?php

namespace App;

use App\Models\StudentRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\StatusAcademicSchoolScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SmClass extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
  
        static::addGlobalScope(new StatusAcademicSchoolScope);
    }


    public function classSection()
    {
      return $this->hasMany('App\SmClassSection', 'class_id')->with('sectionName');

      
    }
    public function classSectionAll(){
        return $this->belongsToMany('App\SmSection','sm_class_sections','class_id','section_id');
    }

    public function sectionName()
    {
        return $this->belongsTo('App\SmSection', 'section_id');
    }

    public function sections()
    {
        return $this->hasMany('App\SmSection', 'id', 'section_id');
    }

    public function records()
    {
        return $this->hasMany(StudentRecord::class, 'class_id', 'id')->where('is_promote', 0)->whereHas('student');
    }

    public function classSections()
    {
        return $this->hasMany('App\SmClassSection', 'class_id', 'id');
    }
    public function groupclassSections()
    {
        return $this->hasMany('App\SmClassSection', 'class_id', 'id')->groupBy(['class_id','section_id'])->with('sectionName');
    }
    public function students()
    {
        return $this->hasMany('App\SmStudent', 'user_id', 'id');
    }

    public function subjects()
    {
        return $this->hasMany(SmAssignSubject::class, 'class_id');
    }

    public function routineUpdates()
    {
        return $this->hasMany(SmClassRoutineUpdate::class, 'class_id')->where('active_status', 1);
    }
}