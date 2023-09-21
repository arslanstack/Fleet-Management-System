<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleMaintenance extends Model
{
    use HasFactory;

    protected $table = 'vehicle_maintenance';
    // protected $guard = 'admin';
    protected $fillable = ['id', 'driver_id', 'vehicle_id','company_id', 'maintenance_type_id', 'maintenance_date', 'location', 'description', 'driver_id', 'meter_reading', 'amount', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'];
}
