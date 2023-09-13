<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllowanceType extends Model
{
    use HasFactory;

    protected $table = 'allowances';
    // protected $guard = 'admin';
    protected $fillable = ['id', 'allowance_type', 'description', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'];
}
