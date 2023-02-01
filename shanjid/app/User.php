<?php

namespace App;

use App\Traits\UserChatMethods;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, UserChatMethods, HasFactory;

    public static $email = "info@spondonit.com";  //23876323 //22014245 //23876323
    public static $item = "23876323";  //23876323 //22014245 //23876323
    public static $api = "https://sp.uxseven.com/api/system-details";
    public static $apiModule = "https://sp.uxseven.com/api/module/";



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'phone', 'password','is_administrator','device_token'
    ];

    protected $appends = [
        'first_name', 'avatar_url', 'blocked_by_me'
    ];

    // protected $with=['staff','student','parent'];

    public function getFirstNameAttribute()
    {
        return $this->full_name;
    }

    public function apiKey()
    {
        if (moduleStatusCheck('Zoom') == true) {
            $apiCheck= \Modules\Zoom\Entities\ZoomSetting::first();

            if ($apiCheck->api_use_for==1) {
                return $this->zoom_api_key_of_user;
            } else {
                return env('ZOOM_CLIENT_KEY');

            }
        }
    }

    public function apiSecret()
    {
        if (moduleStatusCheck('Zoom') == true) {
            $apiCheck= \Modules\Zoom\Entities\ZoomSetting::first();
            if ($apiCheck->api_use_for==1) {
                return $this->zoom_api_serect_of_user;
            } else {
                return env('ZOOM_CLIENT_SECRET');
            }
        }
    }
    protected static function boot()
    {
        parent::boot();

        static::created(function (User $model) {
            if (Schema::hasTable('users')){
                userStatusChange($model->id, 0);
            }
        });
    }


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function student()
    {
        return $this->belongsTo('App\SmStudent', 'id', 'user_id')->withoutGlobalScopes();
    }

    public function staff()
    {
        return $this->belongsTo('App\SmStaff', 'id', 'user_id')->withoutGlobalScopes();
    }

    public function category()
    {
        return $this->belongsTo(SmStudentCategory::class,'category_id','id');
    }
    public function group()
    {
        return $this->belongsTo(SmStudentGroup::class,'group_id','id');
    }

    public function parent()
    {
        return $this->belongsTo('App\SmParent', 'id', 'user_id');
    }

    public function school()
    {
        return $this->belongsTo('App\SmSchool', 'school_id', 'id');
    }

    public function roles()
    {
        return $this->belongsTo('Modules\RolePermission\Entities\InfixRole', 'role_id', 'id');
    }

    /**
     * Route notifications for the FCM channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForFcm($notification)
    {
        return $this->device_token;
    }

    public function getProfileAttribute()
    {
        $role_id = Auth::user()->role_id;

        if ($role_id == 2)
            $profile = $this->student ? $this->student->student_photo : 'public/backEnd/img/admin/message-thumb.png';
        elseif ($role_id == 3)
            $profile = $this->parent ? $this->parent->fathers_photo : 'public/backEnd/img/admin/message-thumb.png';
        else
            $profile = $this->staff ? $this->staff->staff_photo : 'public/backEnd/img/admin/message-thumb.png';

        return $profile;
    }

    public static function checkAuth()
    {
        return true;
        // $gcc = new SmGeneralSettings;
        // $php_extension_dll = SmGeneralSettings::where('id',auth()->user()->school_id)->first();
        // $str = $gcc::$students;
        // $php_extension_ssl = Envato::aci($php_extension_dll->$str);
        // if (isset($php_extension_ssl[$gcc::$users][$gcc::$parents])) {
        //     return User::$item == $php_extension_ssl[$gcc::$users][$gcc::$parents];
        // } else {
        //     return FALSE;
        // }

    }



    public static function checkPermission($name)
    {
        return true;
        // $time_limit = 101;
        // $is_data = InfixModuleManager::where('name', $name)->where('purchase_code', '!=', '')->first();
        // if (!empty($is_data) && $is_data->email != null && $is_data->purchase_code != null) {
        //     $code = @$is_data->purchase_code;
        //     $email = @$is_data->email;
        //     $is_verify = SmGeneralSettings::where($name, 1)->first();
        //     if (!empty($is_verify)) {
        //         if (Config::get('app.app_pro')) {
        //             try {
        //                 $client = new Client();
        //                 $product_info = $client->request('GET', User::$apiModule  . $code . '/' . $email);
        //                 $product_info = $product_info->getBody()->getContents();
        //                 $product_info = json_decode($product_info);
        //                 if (!empty($product_info->products[0])) {
        //                     $time_limit = 100;
        //                 } else {
        //                     $time_limit = 101;
        //                 }
        //             } catch (\Exception $e) {
        //                 $time_limit = 102;
        //             }
        //         } else {
        //             $php_extension_ssl = Envato::aci($is_data->purchase_code);
        //             if (!empty($php_extension_ssl['verify-purchase'])) {
        //                 $time_limit = 100;
        //             } else {
        //                 $time_limit = 103;
        //             }
        //         }
        //     }
        // }
        // return $time_limit;
    }


    public function courses()
    {
        return $this->hasMany('Modules\Lms\Entities\Course','instructor_id','id');
    }

    public function enrolledCourses()
    {
        return $this->hasMany('Modules\Lms\Entities\CoursePurchaseLog', 'student_id', 'id')->where('active_status','=', 'approve');
    }

    public function enrolls()
    {
        return $this->hasMany('Modules\Lms\Entities\CoursePurchaseLog','instructor_id','id')->where('active_status','=', 1);
    }

    public function googleAccounts():HasMany
    {
        return $this->hasMany(\Modules\Gmeet\Entities\GoogleAccount::class);
    }
    public function googleAccount():BelongsTo
    {
        return $this->belongsTo(\Modules\Gmeet\Entities\GoogleAccount::class, 'user_id', 'id');
    }
    public function loginAccount():BelongsTo
    {
        return $this->belongsTo(\Modules\Gmeet\Entities\GoogleAccount::class, 'user_id', 'id')->where('login_at', 1)->withDefault();
    }

}