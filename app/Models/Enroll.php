<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enroll extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo("App\Models\User");
    }

    public function packages_to()
    {
        return $this->belongsTo("App\Models\Package");
    }
    public function packages()
    {
        return $this->belongsToMany("App\Models\Package")->withTimestamps();
    }
}
