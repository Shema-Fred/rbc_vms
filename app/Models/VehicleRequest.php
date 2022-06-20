<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class VehicleRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vehicle_id',
        'destination',
        'deadline',
        'status',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setDeadlineAttribute($value)
    {
        $this->attributes['deadline'] = Carbon::parse($value)->format('Y-m-d H:i') ?: null;
    }

    public function getDeadlineAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y H:i');
    }
}
