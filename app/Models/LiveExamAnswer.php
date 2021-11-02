<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveExamAnswer extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function liveExam()
    {
        return $this->belongsTo(LiveExam::class, 'live_exam_id', 'id');
    }
}
