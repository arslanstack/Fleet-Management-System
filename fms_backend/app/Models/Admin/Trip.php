<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $table = 'trips';

    /**
     * The attributes that are mass assignable.
     */

    protected $fillable = [
        'vehicle_id',
        'driver_id',
        'project_id',
        'company_id',
        'start_date_time',
        'end_date_time',
        'from_location',
        'end_location',
        'distance',
        'description',
        'notes',
        'amount',
        'status',
        'created_by',
        'updated_by',
    ];
}
