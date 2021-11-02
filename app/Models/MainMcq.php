<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainMcq extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = ['pivot'];

    public function packages()
    {
        return $this->belongsToMany('App\Models\Package')->withTimestamps();
    }
    public function mcq_answer()
    {
        return $this->hasMany('App\Models\McqAnswer', 'main_mcq_id');
    }
    public function mcq_user_answer()
    {
        return $this->hasMany('App\Models\McqUserAnswer', 'main_mcq_id');
    }
    public function live_exam()
    {
        return $this->hasMany('App\Models\LiveExam', 'main_mcq_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
