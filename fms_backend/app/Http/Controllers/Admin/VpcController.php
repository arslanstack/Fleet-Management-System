<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admin\Vpc;
use Session, DB, Str;
use Illuminate\Support\Facades\Validator;

class VpcController extends Controller
{
	public function index()
	{
		// $data['vehicles'] = get_complete_table('vehicles', '', '', '', '1', '', '');
		// $data['vpcs'] = Vpc::orderBy('id', 'DESC')->get();
		// return response()->json(array('msg' => 'success', 'response'=>'successfully', 'data' => $data));

		try {
			$vpcs = Vpc::orderBy('id', 'DESC')->get();
			return response()->json(['msg' => 'success', 'response' => 'successfully retrieved all vpcs.', 'data' => $vpcs]);
		} catch (\Exception $e) {
			return response()->json(['msg' => 'error', 'response' => $e->getMessage()], 500);
		}
	}
	public function store(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'vehicle_id' => 'required',
			'plate_expiry_date' => 'required',
			'license_plate' => 'required',
			'plate_registration_status' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response' => $validator->errors()->all()));
		}
		$query = Vpc::create([
			'vehicle_id' => $data['vehicle_id'],
			'plate_expiry_date' => $data['plate_expiry_date'],
			'license_plate' => $data['license_plate'],
			'plate_registration_status' => $data['plate_registration_status'],
			'created_by' => Auth()->user()->id,
			'created_at' => date('Y-m-d H:i:s')
		]);
		$response_status = $query->id;
		if ($response_status > 0) {
			return response()->json(['msg' => 'success', 'response' => 'Vehicle plate check successfully added.']);
		} else {
			return response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
		}
	}
	public function edit($id, Request $request)
	{
		$data['vehicles'] = get_complete_table('vehicles', '', '', '', '1', '', '');
		$data['vpcs'] = Vpc::where('id', $id)->first();
		return response()->json(array('msg' => 'success', 'response' => 'successfully', 'data' => $data));
	}
	public function update(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'vehicle_id' => 'required',
			'plate_expiry_date' => 'required',
			'license_plate' => 'required',
			'plate_registration_status' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response' => $validator->errors()->all()));
		}
		if (isset($data['status'])) {
			$status = "1";
		} else {
			$status = "0";
		}
		$post_status = Vpc::where('id', $data['id'])->update([
			'vehicle_id' => $data['vehicle_id'],
			'plate_expiry_date' => $data['plate_expiry_date'],
			'license_plate' => $data['license_plate'],
			'plate_registration_status' => $data['plate_registration_status'],
			'status' => $status,
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => Auth()->user()->id,
		]);

		if ($post_status > 0) {
			return response()->json(['msg' => 'success', 'response' => 'Vehicle plate check successfully updated!']);
		} else {
			return response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
		}
	}
	public function destroy(Request $request)
	{
		$data = $request->all();
		$status = Vpc::where('id', $data['id'])->first();
		if ($status) {
			Vpc::find($data['id'])->delete();
			return response()->json(['msg' => 'success', 'response' => 'Vehicle plate check successfully deleted.']);
		} else {
			return response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
		}
	}
}
