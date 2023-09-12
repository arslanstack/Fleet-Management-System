<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceType extends Model
{
    use HasFactory;

    protected $table = 'maintenance_types';
    // protected $guard = 'admin';
    protected $fillable = ['id', 'maintenance_type', 'description', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'];
}
