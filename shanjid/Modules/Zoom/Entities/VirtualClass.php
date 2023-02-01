<?php

namespace Modules\Zoom\Entities;

use App\SmClass;
use App\SmGeneralSettings;
use App\SmSection;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class VirtualClass extends Model
{
    protected $table = 'zoom_virtual_class';
    protected $guarded = ['id'];
    protected $dates = ['end_time'];

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'zoom_virtual_class_teachers', 'meeting_id', 'user_id');
    }

    public function class()
    {
        return $this->hasOne(SmClass::class, 'id', 'class_id')->withDefault();
    }

    public function section()
    {
        return $this->hasOne(SmSection::class, 'id', 'section_id')->withDefault();
    }

    public function getTeachersNameAttribute()
    {
        return implode(', ', $this->teachers->pluck('full_name')->toArray());
    }

    public function getMeetingDateTimeAttribute()
    {
        return Carbon::parse($this->date_of_meeting . ' ' . $this->time_of_meeting)->format('m-d-Y h:i A');
    }

    public function getCurrentStatusAttribute()
    {
        $GSetting = SmGeneralSettings::where('school_id', Auth::user()->school_id)->first();
         date_default_timezone_set($GSetting->timeZone->time_zone);
        $now = Carbon::now()->setTimezone($GSetting->timeZone->time_zone);

        if($this->time_before_start==null){
            $meeting_start=10;
        }else{
            $meeting_start=$this->time_before_start;
        }

        if ($this->is_recurring == 1) {
            if ($now->between(Carbon::parse($this->start_time)->addMinute(-$meeting_start)->format('Y-m-d H:i:s'), Carbon::parse($this->recurring_end_date)->endOfDay()->format('Y-m-d H:i:s'))) {
                return 'started';
                // $today = Carbon::now()->setTimezone($GSetting->timeZone->time_zone)->format('Y-m-d');
                // $start_time = Carbon::parse($today.' '. date("H:i:s", strtotime($this->time_of_meeting)))->addMinute(-10)->setTimezone($GSetting->timeZone->time_zone)->format('Y-m-d H:i:s');
                // $end_time = Carbon::parse($today.' '. date("H:i:s", strtotime($this->time_of_meeting)))->setTimezone($GSetting->timeZone->time_zone)->addMinute($this->meeting_duration + 10 )->format('Y-m-d H:i:s');
                // return  $this->end_time;
                // if($now->between($start_time,$end_time)){
                //     return 'started';
                // }

                // return '00';
                // return 'waiting';
            }
            if (!$now->gt(Carbon::parse($this->recurring_end_date)->addMinute(-$meeting_start))) {
                return 'waiting';
            }
            return 'closed';
        } else {
            if ($now->between(Carbon::parse($this->start_time)->addMinute(-$meeting_start)->format('Y-m-d H:i:s'), Carbon::parse($this->end_time)->format('Y-m-d H:i:s'))) {
                return 'started';
            }

            if (!$now->gt(Carbon::parse($this->end_time)->addMinute(-$meeting_start))) {
                return 'waiting';
            }
            return 'closed';
        }
    }

    public function getMeetingEndTimeAttribute()
    {
        return Carbon::parse($this->date_of_meeting . ' ' . $this->time_of_meeting)->addMinute($this->meeting_duration);
    }

    public function getUrlAttribute()
    {
        if (Auth::user()->role_id == 4 || Auth::user()->role_id == 1) {
            return 'https://zoom.us/wc/' . $this->meeting_id . '/start';
        } else {
            return 'https://zoom.us/wc/' . $this->meeting_id . '/join';
        }
    }

    // public static function boot()
    // {
    //     parent::boot();

    //     self::creating(function ($model) {
    //         $model->created_by = Auth::user()->id;
    //         $model->school_id = Auth::user()->school_id;
    //     });

    //     self::updating(function ($model) {
    //         $model->updated_by = Auth::user()->id;
    //     });
    // }
}
