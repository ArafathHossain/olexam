<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveExam extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $dates = ['start_time', 'end_time'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function resultPublished()
    {
        return !$this->end_time->gt(now());
    }

    public function mcq()
    {
        return $this->belongsTo('App\Models\MainMcq', 'main_mcq_id');
    }
    public function class()
    {
        return $this->belongsTo(StudentClass::class, 'student_class_id');
    }

    public function enroll()
    {
        return $this->hasMany(LiveEnroll::class, 'live_exam_id');
    }
}
