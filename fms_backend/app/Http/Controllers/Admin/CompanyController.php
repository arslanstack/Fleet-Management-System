<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admin\Company;
use Session, Validator, DB, Str;

class CompanyController extends Controller
{
	public function index()
	{
		$companies = Company::orderBy('id', 'DESC')->get();
		return response()->json(array('msg' => 'success', 'response' => 'successfully', 'data' => $companies));
	}
	public function store(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'company_name' => 'required',
			'uen' => 'required',
			'email' => 'required|email|unique:companies',
			'password' => 'required',
			'company_address' => 'required',
			'bank_account_no' => 'required',
			'pic_name' => 'required',
			'pic_mobile_no' => 'required',
			'pic_nric' => 'required',
			'pic_address' => 'required',
			'vehicle_rental_tatus' => 'required',
			'car_plateno' => 'required',
			'diesel_tag' => 'required',
			'driver_project' => 'required'
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response' => $validator->errors()->all()));
		}

		$image_path1 = '';
		$image_path2 = '';
		$image_path3 = '';
		if ($request->hasFile('nric_front_side')) {
			$image = $request->file('nric_front_side');
			$file_name = explode('.', $image->getClientOriginalName())[0];
			$nric_front_side = $file_name . '_' . time() . '.' . $image->getClientOriginalExtension();
			$destinationPath = public_path('/assets/upload_images');
			$image->move($destinationPath, $nric_front_side);
			$image_path1 = asset('assets/upload_images') . '/' . $nric_front_side;
		}
		if ($request->hasFile('nric_back_side')) {
			$image = $request->file('nric_back_side');
			$file_name = explode('.', $image->getClientOriginalName())[0];
			$nric_back_side = $file_name . '_' . time() . '.' . $image->getClientOriginalExtension();
			$destinationPath = public_path('/assets/upload_images');
			$image->move($destinationPath, $nric_back_side);
			$image_path2 = asset('assets/upload_images') . '/' . $nric_back_side;
		}
		$query = Company::create([
			'company_name' => $data['company_name'],
			'uen' => $data['uen'],
			'email' => $data['email'],
			'password' => $data['password'],
			'company_address' => $data['company_address'],
			'bank_account_no' => $data['bank_account_no'],
			'pic_name' => $data['pic_name'],
			'pic_mobile_no' => $data['pic_mobile_no'],
			'pic_nric' => $data['pic_nric'],
			'pic_address' => $data['pic_address'],
			'vehicle_rental_tatus' => $data['vehicle_rental_tatus'],
			'car_plateno' => $data['car_plateno'],
			'diesel_tag' => $data['diesel_tag'],
			'driver_project' => $data['driver_project'],
			'nric_front_side' => $image_path1,
			'nric_back_side' => $image_path2,
			'created_by' => Auth()->user()->id,
			'created_at' => date('Y-m-d H:i:s')
		]);
		$response_status = $query->id;
		if ($response_status > 0) {
			return response()->json(['msg' => 'success', 'response' => 'Company successfully added.', 'query' => $query]);
		} else {
			return response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
		}
	}
	public function edit($id, Request $request)
	{
		$company = Company::where('id', $id)->first();
		return response()->json(array('msg' => 'success', 'response' => 'successfully', 'data' => $company));
	}
	public function update(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'company_name' => 'required',
			'uen' => 'required',
			'company_address' => 'required',
			'bank_account_no' => 'required',
			'pic_name' => 'required',
			'pic_mobile_no' => 'required',
			'pic_nric' => 'required',
			'pic_address' => 'required',
			'vehicle_rental_tatus' => 'required',
			'car_plateno' => 'required',
			'diesel_tag' => 'required',
			'driver_project' => 'required'
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response' => $validator->errors()->all()));
		}
		if (isset($data['status'])) {
			$status = "1";
		} else {
			$status = "0";
		}
		if ($request->hasFile('nric_front_side')) {
			$image = $request->file('nric_front_side');
			$file_name = explode('.', $image->getClientOriginalName())[0];
			$data['nric_front_side'] = $file_name . '_' . time() . '.' . $image->getClientOriginalExtension();
			$destinationPath = public_path('/assets/upload_images');
			$image->move($destinationPath, $data['nric_front_side']);
			$image_path1 = asset('assets/upload_images') . '/' . $data['nric_front_side'];
			DB::table('companies')
				->where('id', $data['id'])->update([
					'nric_front_side' => $image_path1
				]);
		}
		if ($request->hasFile('nric_back_side')) {
			$image = $request->file('nric_back_side');
			$file_name = explode('.', $image->getClientOriginalName())[0];
			$data['nric_back_side'] = $file_name . '_' . time() . '.' . $image->getClientOriginalExtension();
			$destinationPath = public_path('/assets/upload_images');
			$image->move($destinationPath, $data['nric_back_side']);
			$image_path2 = asset('assets/upload_images') . '/' . $data['nric_back_side'];
			DB::table('companies')
				->where('id', $data['id'])->update([
					'nric_back_side' => $image_path2
				]);
		}

		$post_status = Company::where('id', $data['id'])->update([
			'company_name' => $data['company_name'],
			'uen' => $data['uen'],
			'company_address' => $data['company_address'],
			'bank_account_no' => $data['bank_account_no'],
			'pic_name' => $data['pic_name'],
			'pic_mobile_no' => $data['pic_mobile_no'],
			'pic_nric' => $data['pic_nric'],
			'pic_address' => $data['pic_address'],
			'vehicle_rental_tatus' => $data['vehicle_rental_tatus'],
			'car_plateno' => $data['car_plateno'],
			'diesel_tag' => $data['diesel_tag'],
			'driver_project' => $data['driver_project'],
			'status' => $status,
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => Auth()->user()->id,
		]);

		if ($post_status > 0) {
			$updatedRecord = Company::find($data['id']);
			return response()->json([
				'msg' => 'success',
				'response' => 'Company successfully updated!',
				'query' => $updatedRecord, // Include the updated record in the response
			]);
		} else {
			return response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
		}
	}
	public function destroy(Request $request)
	{
		$data = $request->all();
		$status = Company::where('id', $data['id'])->first();
		if ($status->id) {
			Company::find($data['id'])->delete();
			return response()->json(['msg' => 'success', 'response' => 'Company successfully deleted.']);
		} else {
			return response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
		}
	}
}
