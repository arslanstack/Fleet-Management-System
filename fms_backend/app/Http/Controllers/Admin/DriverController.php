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
		$image_path1 = '';
		if($request->hasFile('nric_front_side'))
			$image = $request->file('nric_front_side');
			$file_name = explode('.', $image->getClientOriginalName())[0];
			$nric_front_side = $file_name.'_'.time().'.'.$image->getClientOriginalExtension();
			$destinationPath = public_path('/assets/upload_images');
			$image->move($destinationPath, $nric_front_side);
			$image_path1 = asset('assets/upload_images').'/'.$nric_front_side;
		}
		$image_path2 = '';
		if($request->hasFile('nric_back_side')){
			$image = $request->file('nric_back_side');
			$file_name = explode('.', $image->getClientOriginalName())[0];
			$nric_back_side = $file_name.'_'.time().'.'.$image->getClientOriginalExtension();
			$destinationPath = public_path('/assets/upload_images');
			$image->move($destinationPath, $nric_back_side);
			$image_path2 = asset('assets/upload_images').'/'.$nric_back_side;
		}
		$image_path3 = '';
		if($request->hasFile('licence_front_side')){
			$image = $request->file('licence_front_side');
			$file_name = explode('.', $image->getClientOriginalName())[0];
			$licence_front_side = $file_name.'_'.time().'.'.$image->getClientOriginalExtension();
			$destinationPath = public_path('/assets/upload_images');
			$image->move($destinationPath, $licence_front_side);
			$image_path3 = asset('assets/upload_images').'/'.$licence_front_side;
		}
		$image_path4 = '';
		if($request->hasFile('licence_back_side')){
			$image = $request->file('licence_back_side');
			$file_name = explode('.', $image->getClientOriginalName())[0];
			$licence_back_side = $file_name.'_'.time().'.'.$image->getClientOriginalExtension();
			$destinationPath = public_path('/assets/upload_images');
			$image->move($destinationPath, $licence_back_side);
			$image_path4 = asset('assets/upload_images').'/'.$licence_back_side;
		}
		$image_path5 = '';
		if($request->hasFile('profile_pic')){
			$image = $request->file('profile_pic');
			$file_name = explode('.', $image->getClientOriginalName())[0];
			$profile_pic = $file_name.'_'.time().'.'.$image->getClientOriginalExtension();
			$destinationPath = public_path('/assets/upload_images');
			$image->move($destinationPath, $profile_pic);
			$image_path5 = asset('assets/upload_images').'/'.$profile_pic;
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
			'vehicle_rental_tatus'=> $data['vehicle_rental_tatus'],
			'car_plateno'=> $data['car_plateno'],
			'diesel_tag'=> $data['diesel_tag'],

			'nric_front_side' => $image_path1,
			'nric_back_side' => $image_path2,
			'licence_front_side' => $image_path3,
			'licence_back_side' => $image_path4,
			'profile' => $image_path5,
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
		if($request->hasFile('nric_front_side')){
			$image = $request->file('nric_front_side');
			$file_name = explode('.', $image->getClientOriginalName())[0];
			$data['nric_front_side'] = $file_name.'_'.time().'.'.$image->getClientOriginalExtension();
			$destinationPath = public_path('/assets/upload_images');
			$image->move($destinationPath, $data['nric_front_side']);
			$image_path1 = asset('assets/upload_images').'/'.$data['nric_front_side'];
			DB::table('drivers')
			->where('id', $data['id'])->update([
				'nric_front_side' => $image_path1
			]);
		}if($request->hasFile('nric_back_side')){
			$image = $request->file('nric_back_side');
			$file_name = explode('.', $image->getClientOriginalName())[0];
			$data['nric_back_side'] = $file_name.'_'.time().'.'.$image->getClientOriginalExtension();
			$destinationPath = public_path('/assets/upload_images');
			$image->move($destinationPath, $data['nric_back_side']);
			$image_path2 = asset('assets/upload_images').'/'.$data['nric_back_side'];
			DB::table('drivers')
			->where('id', $data['id'])->update([
				'nric_back_side' => $image_path2
			]);
		}if($request->hasFile('licence_front_side')){
			$image = $request->file('licence_front_side');
			$file_name = explode('.', $image->getClientOriginalName())[0];
			$data['licence_front_side'] = $file_name.'_'.time().'.'.$image->getClientOriginalExtension();
			$destinationPath = public_path('/assets/upload_images');
			$image->move($destinationPath, $data['licence_front_side']);
			$image_path3 = asset('assets/upload_images').'/'.$data['licence_front_side'];
			DB::table('drivers')
			->where('id', $data['id'])->update([
				'licence_front_side' => $image_path3
			]);
		}if($request->hasFile('licence_back_side')){
			$image = $request->file('licence_back_side');
			$file_name = explode('.', $image->getClientOriginalName())[0];
			$data['licence_back_side'] = $file_name.'_'.time().'.'.$image->getClientOriginalExtension();
			$destinationPath = public_path('/assets/upload_images');
			$image->move($destinationPath, $data['licence_back_side']);
			$image_path4 = asset('assets/upload_images').'/'.$data['licence_back_side'];
			DB::table('drivers')
			->where('id', $data['id'])->update([
				'licence_back_side' => $image_path4
			]);
		}if($request->hasFile('profile_pic')){
			$image = $request->file('profile_pic');
			$file_name = explode('.', $image->getClientOriginalName())[0];
			$data['profile_pic'] = $file_name.'_'.time().'.'.$image->getClientOriginalExtension();
			$destinationPath = public_path('/assets/upload_images');
			$image->move($destinationPath, $data['profile_pic']);
			$image_path5 = asset('assets/upload_images').'/'.$data['profile_pic'];
			DB::table('drivers')
			->where('id', $data['id'])->update([
				'profile' => $image_path5
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

	public function salary(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'driver_id' => 'required',
			'salary_amount' => 'required'
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response'=>$validator->errors()->all()));
		}
		$query = DB::table('driver_salaries')->insertGetId([
			'driver_id' => $data['driver_id'],
			'salary' => $data['salary_amount'],
			'created_by' => Auth()->user()->id,
			'created_at' => date('Y-m-d H:i:s'),
		]);

		if($query > 0) {
			return response()->json(['msg' => 'success', 'response'=>'Driver salary successfully added.']);
		} else {
			return response()->json(['msg' => 'error', 'response'=>'Something went wrong!']);
		}
	}

	public function generate_payslip(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'driver_id' => 'required'
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response'=>$validator->errors()->all()));
		}

		$current_salary = get_single_row('driver_salaries', 'driver_id', $data['driver_id'], '', '', '', '');
		$data['basic_salary'] = $current_salary->salary;

		$data['allowance_amount'] = get_allowances($data['driver_id']);
		$data['deduction_amount'] = get_deductions($data['driver_id']);
		$data['net_salary'] = ( ($data['allowance_amount'] + $data['basic_salary']) - $data['deduction_amount']);

		$query = DB::table('salary_payroll')->insertGetId([
			'driver_id' => $data['driver_id'],
			'basic_salary'=> $data['basic_salary'],
			'allowance_amount'=> $data['allowance_amount'],
			'deduction_amount'=> $data['deduction_amount'],
			'net_salary'=> $data['net_salary'],
			'salary_month'=> date('Y-m-d'),
			'notes'=> $data['notes'],
			'created_by' => Auth()->user()->id,
			'created_at' => date('Y-m-d H:i:s'),
		]);

		if($query > 0) {
			return response()->json(['msg' => 'success', 'response'=>'Payslip generated successfully.']);
		} else {
			return response()->json(['msg' => 'error', 'response'=>'Something went wrong!']);
		}
	}
}