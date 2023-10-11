<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';
    // protected $guard = 'admin';
    protected $fillable = ['id', 'company_name', 'uen', 'email', 'password', 'company_address', 'bank_account_no', 'pic_name', 'pic_mobile_no', 'pic_nric', 'pic_address', 'vehicle_rental_tatus', 'car_plateno', 'diesel_tag', 'driver_project', 'nric_front_side', 'nric_back_side', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status'];

    // public function getNextAttribute(){
    //     return static::where('id', '>', $this->id)->orderBy('id','asc')->first();
    // }
    // public  function getPreviousAttribute(){
    //     return static::where('id', '<', $this->id)->orderBy('id','desc')->first();
    // }
}
