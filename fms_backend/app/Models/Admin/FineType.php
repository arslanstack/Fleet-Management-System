<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FineType extends Model
{
    use HasFactory;

    protected $table = 'deductions';
    // protected $guard = 'admin';
    protected $fillable = ['id', 'fine_type', 'description', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'];
}
