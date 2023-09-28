<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admin\MaintenanceType;
use Session, Validator, DB, Str;

class MaintenanceTypeController extends Controller
{
	public function index()
	{
		$types = MaintenanceType::orderBy('id', 'DESC')->get();
		return response()->json(array('msg' => 'success', 'response' => 'successfully', 'data' => $types));
	}
	public function store(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'maintenance_type' => 'required',
			'description' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response' => $validator->errors()->all()));
		}
		$query = MaintenanceType::create([
			'maintenance_type' => $data['maintenance_type'],
			'description' => $data['description'],
			'created_by' => Auth()->user()->id,
			'created_at' => date('Y-m-d H:i:s')
		]);
		$response_status = $query->id;
		if ($response_status > 0) {
			return response()->json(['msg' => 'success', 'response' => 'Vehicle maintenance type successfully added.', 'query' => $query]);
		} else {
			return response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
		}
	}
	public function edit($id, Request $request)
	{
		$type = MaintenanceType::where('id', $id)->first();
		return response()->json(array('msg' => 'success', 'response' => 'successfully', 'data' => $type));
	}
	public function update(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'maintenance_type' => 'required',
			'description' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response' => $validator->errors()->all()));
		}
		if (isset($data['status'])) {
			$status = "1";
		} else {
			$status = "0";
		}
		$post_status = MaintenanceType::where('id', $data['id'])->update([
			'maintenance_type' => $data['maintenance_type'],
			'description' => $data['description'],
			'status' => $status,
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => Auth()->user()->id,
		]);

		if ($post_status > 0) {
			$updatedRecord = MaintenanceType::find($data['id']);
			return response()->json([
				'msg' => 'success',
				'response' => 'MaintenanceType successfully updated!',
				'query' => $updatedRecord, // Include the updated record in the response
			]);
		} else {
			return response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
		}
	}
	public function destroy(Request $request)
	{
		$data = $request->all();
		$status = MaintenanceType::where('id', $data['id'])->first();
		if ($status) {
			MaintenanceType::find($data['id'])->delete();
			return response()->json(['msg' => 'success', 'response' => 'Vehicle maintenance type successfully deleted.']);
		} else {
			return response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
		}
	}
}
