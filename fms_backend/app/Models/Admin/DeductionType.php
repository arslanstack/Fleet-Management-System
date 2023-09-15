<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeductionType extends Model
{
    use HasFactory;

    protected $table = 'deductions';
    // protected $guard = 'admin';
    protected $fillable = ['id', 'deduction_type', 'description', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'];
}
