<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McqAnswer extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function mcq()
    {
        return $this->belongsTo('App\Models\MainMcq', 'main_mcq_id');
    }

}
