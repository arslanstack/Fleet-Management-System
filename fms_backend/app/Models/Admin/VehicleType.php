<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    use HasFactory;

    protected $table = 'vehicle_types';
    // protected $guard = 'admin';
    protected $fillable = ['id', 'vehicle_type', 'capacity', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'];
}
