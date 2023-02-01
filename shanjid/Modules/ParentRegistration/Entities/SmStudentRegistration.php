<?php

namespace Modules\ParentRegistration\Entities;

use Illuminate\Database\Eloquent\Model;

class SmStudentRegistration extends Model
{
    protected $fillable = [];

     public function class(){
        return $this->belongsTo('App\SmClass', 'class_id', 'id');
    }

	public function section(){
		return $this->belongsTo('App\SmSection', 'section_id', 'id');
	}

	public function academicYear(){
		return $this->belongsTo('App\SmAcademicYear', 'academic_year', 'id');
	}

	public function gender(){
		return $this->belongsTo('App\SmBaseSetup', 'gender_id', 'id');
	}
	public function school(){
		return $this->belongsTo('App\SmSchool', 'school_id', 'id');
	}

	
}
