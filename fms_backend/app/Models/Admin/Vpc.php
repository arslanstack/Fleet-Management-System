<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vpc extends Model
{
    use HasFactory;

    protected $table = 'vehicle_plate_check';
    // protected $guard = 'admin';
    protected $fillable = ['id', 'vehicle_id', 'plate_expiry_date', 'license_plate', 'plate_registration_status',  'created_at', 'created_by', 'updated_at', 'updated_by', 'status'];
}