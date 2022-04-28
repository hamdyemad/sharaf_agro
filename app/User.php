<?php

namespace App;

use App\Models\Branch;
use App\Models\CustomerBalance;
use App\Models\CustomerResponsible;
use App\Models\Role;
use App\Models\UserCategory;
use App\Models\UserSubCategory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','type','phone','address','email','username','avatar','banned' ,'password',
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
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function roles() {
        return $this->belongsToMany(Role::class, 'users_roles', 'user_id')->withTimestamps();
    }

    public function main_categories() {
        return $this->hasMany(UserCategory::class);
    }

    public function sub_categories() {
        return $this->hasMany(UserSubCategory::class);
    }

    public function responsibles() {
        return $this->hasMany(CustomerResponsible::class);
    }

    public function balance() {
        return $this->hasOne(CustomerBalance::class);
    }



}
