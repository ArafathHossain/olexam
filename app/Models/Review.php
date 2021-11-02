<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function packages()
    {
        return $this->belongsTo('App\Models\Package');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
