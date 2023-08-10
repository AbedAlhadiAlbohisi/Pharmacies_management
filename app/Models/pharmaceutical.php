<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pharmaceutical extends Model
{
    use HasFactory;
    public function getactivestatusAttribute()
    {
        return $this->active == 1 ? 'Active' : 'InActive';
    }

    public function order()
    {
        return $this->hasMany(Order::class, 'pharmaceutical_id', 'id');
    }

    public function pharmacist()
    {
        return $this->belongsTo(Pharmacist::class, 'pharmacist_id', 'id');
    }
}
