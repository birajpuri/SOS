<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'user_id',
        'availability', // online, offline
        'address',    // optional if tracking location
        'vehicle_id',          // foreign key for vehicle
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function vehicle()
    {
        return $this->hasOne(Vehicle::class,'id', 'vehicle_id');
    }
}
