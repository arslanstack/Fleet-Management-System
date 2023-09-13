<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
    use HasFactory;

    protected $table = 'driver_deductions';
    // protected $guard = 'admin';
    protected $fillable = ['id', 'driver_id', 'deduction_id', 'amount', 'effective_date', 'description', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'];
}
