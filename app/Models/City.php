<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    public function getactivestatusAttribute()
    {
        return $this->active == 1 ? 'Active' : 'InActive';
    }

    public function admins()
    {
        return $this->hasMany(Admin::class, 'city_id', 'id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'city_id', 'id');
    }
}
