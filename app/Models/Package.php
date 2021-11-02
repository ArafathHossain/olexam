<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function mcqs()
    {
        return $this->belongsToMany('App\Models\MainMcq')->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function class()
    {
        return $this->belongsTo('App\Models\StudentClass', 'class_id');
    }
    public function subject()
    {
        return $this->belongsTo('App\Models\Subject');
    }
    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }
    public function wishlist_user()
    {
        return $this->belongsToMany('App\Models\User')->withTimestamps();
    }
    public function enrolls()
    {
        return $this->belongsToMany('App\Models\Enroll')->withTimestamps();
    }
    public function enrolls_many()
    {
        return $this->hasMany('App\Models\Enroll');
    }
    public function user_answer()
    {
        return $this->hasMany(McqUserAnswer::class, 'package_id');
    }
    public function manage()
    {
        return $this->hasMany(McqManage::class, 'package_id');
    }

}
