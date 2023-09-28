<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admin\VehicleInspection;
use Session, DB, Str;
use Illuminate\Support\Facades\Validator;

class VehicleInspectionController extends Controller
{
	public function index()
	{
		// $data['vehicles'] = get_complete_table('vehicles', '', '', '', '1', '', '');
		// $data['inspections'] = VehicleInspection::orderBy('id', 'DESC')->get();
		// return response()->json(array('msg' => 'success', 'response'=>'successfully', 'data' => $data));

		try {
			$vehicleInspection = VehicleInspection::orderBy('id', 'DESC')->get();
			return response()->json(['msg' => 'success', 'response' => 'successfully retrieved all vehicleInspection.', 'data' => $vehicleInspection]);
		} catch (\Exception $e) {
			return response()->json(['msg' => 'error', 'response' => $e->getMessage()], 500);
		}
	}
	public function store(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'vehicle_id' => 'required',
			'inspection_date' => 'required',
			'next_inspection_date' => 'required',
			'maintenance_recommendation' => 'required',
			'inspection_status' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response' => $validator->errors()->all()));
		}
		$query = VehicleInspection::create([
			'vehicle_id' => $data['vehicle_id'],
			'inspection_date' => $data['inspection_date'],
			'next_inspection_date' => $data['next_inspection_date'],
			'maintenance_recommendation' => $data['maintenance_recommendation'],
			'inspection_status' => $data['inspection_status'],
			'created_by' => Auth()->user()->id,
			'created_at' => date('Y-m-d H:i:s')
		]);
		$response_status = $query->id;
		if ($response_status > 0) {
			return response()->json(['msg' => 'success', 'response' => 'Vehicle inspection successfully added.', 'query' => $query]);
		} else {
			return response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
		}
	}
	public function edit($id, Request $request)
	{
		$data['vehicles'] = get_complete_table('vehicles', '', '', '', '1', '', '');
		$data['inspection'] = VehicleInspection::where('id', $id)->first();
		return response()->json(array('msg' => 'success', 'response' => 'successfully', 'data' => $data));
	}
	public function update(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'vehicle_id' => 'required',
			'inspection_date' => 'required',
			'next_inspection_date' => 'required',
			'maintenance_recommendation' => 'required',
			'inspection_status' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response' => $validator->errors()->all()));
		}
		if (isset($data['status'])) {
			$status = "1";
		} else {
			$status = "0";
		}
		$post_status = VehicleInspection::where('id', $data['id'])->update([
			'vehicle_id' => $data['vehicle_id'],
			'inspection_date' => $data['inspection_date'],
			'next_inspection_date' => $data['next_inspection_date'],
			'maintenance_recommendation' => $data['maintenance_recommendation'],
			'inspection_status' => $data['inspection_status'],
			'status' => $status,
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => Auth()->user()->id,
		]);

		if ($post_status > 0) {
			$updatedRecord = VehicleInspection::find($data['id']);
			return response()->json([
				'msg' => 'success',
				'response' => 'VehicleInspection successfully updated!',
				'query' => $updatedRecord, // Include the updated record in the response
			]);
		} else {
			return response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
		}
	}
	public function destroy(Request $request)
	{
		$data = $request->all();
		$status = VehicleInspection::where('id', $data['id'])->first();
		if ($status) {
			VehicleInspection::find($data['id'])->delete();
			return response()->json(['msg' => 'success', 'response' => 'Vehicle inspection successfully deleted.']);
		} else {
			return response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
		}
	}
}
