<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleInspection extends Model
{
    use HasFactory;

    protected $table = 'vehicle_inspection';
    // protected $guard = 'admin';
    protected $fillable = ['id', 'vehicle_id',  'inspection_date', 'next_inspection_date', 'maintenance_recommendation', 'inspection_status',  'created_at', 'created_by', 'updated_at', 'updated_by', 'status'];
}
