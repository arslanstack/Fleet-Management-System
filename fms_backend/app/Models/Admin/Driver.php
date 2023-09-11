<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $table = 'drivers';
    // protected $guard = 'admin';
    protected $fillable = ['id', 'name', 'phone_no', 'email', 'password', 'nric', 'address', 'dob', 'bank_account_no', 'licence_type', 'driver_status', 'joining_date', 'end_date', 'vehicle_rental_tatus', 'car_plateno', 'diesel_tag', 'driver_project', 'nric_front_side', 'nric_back_side', 'licence_front_side', 'licence_back_side', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'];

    // public function getNextAttribute(){
    //     return static::where('id', '>', $this->id)->orderBy('id','asc')->first();
    // }
    // public  function getPreviousAttribute(){
    //     return static::where('id', '<', $this->id)->orderBy('id','desc')->first();
    // }
}
