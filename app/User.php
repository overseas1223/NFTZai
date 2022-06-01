<?php

namespace App;

use App\Model\Service;
use App\Model\Wallet;
use App\Model\UserSocialMedia;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name', 'email','g2f_enabled', 'password','role','photo','phone','status',
        'is_verified','country_code','country','phone_verified','google2fa_secret','reset_code','gender', 'birth_date',
        'language', 'device_id', 'device_type', 'push_notification_status', 'email_notification_status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }

    public function social_media()
    {
        return $this->hasOne(UserSocialMedia::class, 'user_id');
    }

    public function top_sellers()
    {
        return $this->hasMany(User::class, 'user_id');
    }

    public function service_sells()
    {
        return $this->hasMany(Service::class, 'created_by');
    }
}
