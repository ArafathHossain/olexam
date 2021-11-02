<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class McqManage extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function teacher()
    {
        return $this->belongsTo(User::class, 'admin_id', 'id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }
    public function mcq()
    {
        return $this->belongsTo(MainMcq::class, 'main_mcq_id');
    }
}
