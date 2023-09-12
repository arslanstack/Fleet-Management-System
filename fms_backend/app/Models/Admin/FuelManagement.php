<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuelManagement extends Model
{
    use HasFactory;

    protected $table = 'fuel_management';
    // protected $guard = 'admin';
    protected $fillable = ['id', 'vehicle_id', 'driver_id', 'fuel_type', 'quantity', 'cost_per_liter', 'fuel_cost', 'current_meter_reading', 'previous_meter_reading', 'fuel_cost', 'fuel_avg', 'per_liter_avg', 'fuel_datetime', 'location', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'];
}

