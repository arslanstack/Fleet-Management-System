<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admin\Driver;
use Session, Validator, DB, Str;

class DriverController extends Controller
{
	public function index()
	{
		$drivers = Driver::orderBy('id', 'DESC')->get();
		return response()->json(array('msg' => 'success', 'response'=>'successfully', 'data' => $drivers));
	}
	public function store(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'phone_no' => 'required',
			'email' => 'required|email|unique:drivers',
			'password' => 'required',
			'nric' => 'required',
			'address' => 'required',
			'dob' => 'required',
			'bank_account_no' => 'required',
			'licence_type' => 'required',
			'driver_status' => 'required',
			'joining_date' => 'required',
			'vehicle_rental_tatus' => 'required',
			'car_plateno' => 'required',
			'diesel_tag' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response'=>$validator->errors()->all()));
		}
		$nric_front_side = '';
		if(!empty($data['nric_front_side'])){
			$image = $request->file('nric_front_side');
			$file_name = explode('.', $image->getClientOriginalName())[0];
			$nric_front_side = $file_name.'_'.time().'.'.$image->getClientOriginalExtension();
			$destinationPath = public_path('/assets/drivers_img');
			$image->move($destinationPath, $nric_front_side);
		}$nric_back_side = '';
		if(!empty($data['nric_back_side'])){
			$image = $request->file('nric_back_side');
			$file_name = explode('.', $image->getClientOriginalName())[0];
			$nric_back_side = $file_name.'_'.time().'.'.$image->getClientOriginalExtension();
			$destinationPath = public_path('/assets/drivers_img');
			$image->move($destinationPath, $nric_back_side);
		}$licence_front_side = '';
		if(!empty($data['licence_front_side'])){
			$image = $request->file('licence_front_side');
			$file_name = explode('.', $image->getClientOriginalName())[0];
			$licence_front_side = $file_name.'_'.time().'.'.$image->getClientOriginalExtension();
			$destinationPath = public_path('/assets/drivers_img');
			$image->move($destinationPath, $licence_front_side);
		}$licence_back_side = '';
		if(!empty($data['licence_back_side'])){
			$image = $request->file('licence_back_side');
			$file_name = explode('.', $image->getClientOriginalName())[0];
			$licence_back_side = $file_name.'_'.time().'.'.$image->getClientOriginalExtension();
			$destinationPath = public_path('/assets/drivers_img');
			$image->move($destinationPath, $licence_back_side);
		}
		$query = Driver::create([
			'name'=> $data['name'],
			'phone_no'=> $data['phone_no'],
			'email'=> $data['email'],
			'password'=> $data['password'],
			'nric'=> $data['nric'],
			'address'=> $data['address'],
			'dob'=> $data['dob'],
			'bank_account_no'=> $data['bank_account_no'],
			'licence_type'=> $data['licence_type'],
			'driver_status'=> $data['driver_status'],
			'joining_date'=> $data['joining_date'],
			'end_date'=> $data['end_date'],
			'vehicle_rental_tatus'=> $data['vehicle_rental_tatus'],
			'car_plateno'=> $data['car_plateno'],
			'diesel_tag'=> $data['diesel_tag'],

			'nric_front_side' => $nric_front_side,
			'nric_back_side' => $nric_back_side,
			'licence_front_side' => $licence_front_side,
			'licence_back_side' => $licence_back_side,
			'created_by' => Auth()->user()->id,
			'created_at' => date('Y-m-d H:i:s')
		]);
		$response_status = $query->id;
		if($response_status > 0) {
			return response()->json(['msg' => 'success', 'response'=>'Driver successfully added.']);
		} else {
			return response()->json(['msg' => 'error', 'response'=>'Something went wrong!']);
		}
	}
	public function edit($id, Request $request)
	{
		$driver = Driver::where('id', $id)->first();
		return response()->json(array('msg' => 'success', 'response'=>'successfully', 'data' => $driver));
	}
	public function update(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'phone_no' => 'required',
			'nric' => 'required',
			'address' => 'required',
			'dob' => 'required',
			'bank_account_no' => 'required',
			'licence_type' => 'required',
			'driver_status' => 'required',
			'joining_date' => 'required',
			'vehicle_rental_tatus' => 'required',
			'car_plateno' => 'required',
			'diesel_tag' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response'=>$validator->errors()->all()));
		}
		if(isset($data['status'])){
			$status = "1";
		}else {
			$status = "0";
		}
		if(!empty($data['nric_front_side'])){
			$image = $request->file('nric_front_side');
			$file_name = explode('.', $image->getClientOriginalName())[0];
			$data['nric_front_side'] = $file_name.'_'.time().'.'.$image->getClientOriginalExtension();
			$destinationPath = public_path('/assets/drivers_img');
			$image->move($destinationPath, $data['nric_front_side']);
			DB::table('drivers')
			->where('id', $data['id'])->update([
				'nric_front_side' => $data['nric_front_side']
			]);
		}if(!empty($data['nric_back_side'])){
			$image = $request->file('nric_back_side');
			$file_name = explode('.', $image->getClientOriginalName())[0];
			$data['nric_back_side'] = $file_name.'_'.time().'.'.$image->getClientOriginalExtension();
			$destinationPath = public_path('/assets/drivers_img');
			$image->move($destinationPath, $data['nric_back_side']);
			DB::table('drivers')
			->where('id', $data['id'])->update([
				'nric_back_side' => $data['nric_back_side']
			]);
		}if(!empty($data['licence_front_side'])){
			$image = $request->file('licence_front_side');
			$file_name = explode('.', $image->getClientOriginalName())[0];
			$data['licence_front_side'] = $file_name.'_'.time().'.'.$image->getClientOriginalExtension();
			$destinationPath = public_path('/assets/drivers_img');
			$image->move($destinationPath, $data['licence_front_side']);
			DB::table('drivers')
			->where('id', $data['id'])->update([
				'licence_front_side' => $data['licence_front_side']
			]);
		}if(!empty($data['licence_back_side'])){
			$image = $request->file('licence_back_side');
			$file_name = explode('.', $image->getClientOriginalName())[0];
			$data['licence_back_side'] = $file_name.'_'.time().'.'.$image->getClientOriginalExtension();
			$destinationPath = public_path('/assets/drivers_img');
			$image->move($destinationPath, $data['licence_back_side']);
			DB::table('drivers')
			->where('id', $data['id'])->update([
				'licence_back_side' => $data['licence_back_side']
			]);
		}

		$post_status = Driver::where('id', $data['id'])->update([
			'name'=> $data['name'],
			'phone_no'=> $data['phone_no'],
			'nric'=> $data['nric'],
			'address'=> $data['address'],
			'dob'=> $data['dob'],
			'bank_account_no'=> $data['bank_account_no'],
			'licence_type'=> $data['licence_type'],
			'driver_status'=> $data['driver_status'],
			'joining_date'=> $data['joining_date'],
			'end_date'=> $data['end_date'],
			'vehicle_rental_tatus'=> $data['vehicle_rental_tatus'],
			'car_plateno'=> $data['car_plateno'],
			'diesel_tag'=> $data['diesel_tag'],
			'status' => $status,
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => Auth()->user()->id,
		]);

		if($post_status > 0) {
			return response()->json(['msg' => 'success', 'response'=>'Driver successfully updated!']);
		} else {
			return response()->json(['msg' => 'error', 'response'=>'Something went wrong!']);
		}
	}
	public function destroy(Request $request)
	{
		$data = $request->all();
		$status = Driver::where('id', $data['id'])->first();
		if($status > 0) {
			Driver::find($data['id'])->delete();
			return response()->json(['msg' => 'success', 'response'=>'Driver successfully deleted.']);
		} else {
			return response()->json(['msg' => 'error', 'response'=>'Something went wrong!']);
		}
	}
}