<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = ['id'];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
