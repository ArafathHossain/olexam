<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function classes()
    {
        return $this->belongsToMany('App\Models\StudentClass')->withTimestamps();
    }

    public function packages()
    {
        return $this->hasMany('App\Models\Package');
    }

    public function mcqs()
    {
        return $this->hasMany(MainMcq::class, 'subject_id');
    }
}
