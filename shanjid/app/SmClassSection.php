<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\StatusAcademicSchoolScope;

class SmClassSection extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();
  
        static::addGlobalScope(new StatusAcademicSchoolScope);
    }
    
    
    public function sectionName()
    {
        return $this->belongsTo('App\SmSection', 'section_id', 'id')->withDefault();
    }
    public function students()
    {
        return $this->hasMany('App\SmStudent', 'section_id', 'section_id');
    }
    public function sectionWithoutGlobal()
    {
        return $this->belongsTo('App\SmSection', 'section_id', 'id')->withoutGlobalScopes()->withDefault();
    }
}
