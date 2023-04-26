<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'code_user',
        'address',
        'phone',
        'sex',
        'avatar',
        'date_of_birth'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['url_avatar'];
    /**
     * @return string
     */
//    public function getAvatarAttribute($value)
//    {
//        return $value ? asset('storage/' . $value) : 'https://res.cloudinary.com/dsh5japr1/image/upload/v1672136942/cld-sample-4.jpg';
//    }

    public function getUrlAvatarAttribute()
    {
        return $this->avatar ? asset('storage/' . $this->avatar) : 'https://res.cloudinary.com/dsh5japr1/image/upload/v1681369552/Web/FB_IMG_1606633099895_nmbqlo.jpg';
    }

    public function notifications()
    {
        return $this->belongsToMany(Notification::class, 'notification_users', 'id_user', 'id_notification');
    }

    public function classes()
    {
        return $this->belongsToMany(Class_HP::class, 'class_users', 'id_user', 'id_class');
    }

    public function points()
    {
        return $this->hasMany(Point::class, 'id_user');
    }

}
