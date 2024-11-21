<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function profiles()
    {
        return $this->hasMany(Profile::class, 'template_id', 'id');
    }
}
