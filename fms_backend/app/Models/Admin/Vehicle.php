<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $table = 'vehicles';
    // protected $guard = 'admin';
    protected $fillable = ['id', 'vehicle_type', 'fuel_type', 'registration_no', 'chassis_no', 'engine_no', 'current_mileage', 'make', 'model', 'year', 'color', 'registration_date', 'vehicle_location', 'driver_id', 'plate_no_photo', 'vehicle_photo', 'additional_notes', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'];
}
