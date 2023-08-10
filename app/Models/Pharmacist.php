<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Pharmacist extends   Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    use HasFactory;
    public function getactivestatusAttribute()
    {
        return $this->blocked == 1 ? 'blocked' : 'Inblocked';
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class, 'pharmacist_id', 'id');
    }

    public function order()
    {
        return $this->hasMany(Order::class, 'pharmacist_id', 'id');
    }

    public function pharmaceuticals()
    {
        return $this->hasMany(pharmaceutical::class, 'pharmacist_id', 'id');
    }
}
