<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allowance extends Model
{
    use HasFactory;

    protected $table = 'driver_allowances';
    // protected $guard = 'admin';
    protected $fillable = ['id', 'driver_id', 'allowance_id', 'deduction_id', 'amount', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'];
}
