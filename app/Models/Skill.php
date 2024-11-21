<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
