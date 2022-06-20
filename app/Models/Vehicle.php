<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'plate',
        'driver_id',
    ];

    public function driver()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicleRequests()
    {
        return $this->hasMany(VehicleRequest::class, 'vehicle_id');
    }
}
