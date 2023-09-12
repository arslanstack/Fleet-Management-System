<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roadtax extends Model
{
    use HasFactory;

    protected $table = 'road_tax_expiry';
    // protected $guard = 'admin';
    protected $fillable = ['id', 'vehicle_id', 'expiry_date', 'renewal_date', 'description',  'created_at', 'created_by', 'updated_at', 'updated_by', 'status'];
}
