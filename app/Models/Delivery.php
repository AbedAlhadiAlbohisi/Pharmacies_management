<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    public function pharmacists()
    {
        return $this->belongsTo(Pharmacist::class, 'pharmacist_id', 'id');
    }
}
