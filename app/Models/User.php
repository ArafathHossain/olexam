<?php

namespace App\Models;

use Laravel\Paddle\Billable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Billable;
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'photo',
        'status',
        'about',
        'address',
        'city',
        'zip',
        'grad',
        'favourite_subject',
        'github',
        'linkedin',
        'google_id',
        'facebook_id',
        'github_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function packages()
    {
        return $this->hasMany('App\Models\Package');
    }

    public function my_wishlist()
    {
        return $this->belongsToMany('App\Models\Package')->withTimestamps();
    }

    public function enrolls()
    {
        return $this->hasMany('App\Models\Enroll');
    }
    public function mcq_answer()
    {
        return $this->hasMany('App\Models\MainMcq', 'main_mcq_id');
    }

    public function enrolls_packages()
    {

        return $this->hasManyThrough(Enroll::class, Package::class)->pivot(['enroll_package']);
    }

    public function live_exams()
    {
        return $this->hasMany('App\Models\LiveExam');
    }

    public function live_enroll()
    {
        return $this->hasMany(LiveEnroll::class, 'user_id');
    }
}
