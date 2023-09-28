<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admin\FuelManagement;
use Session, DB, Str;
use Illuminate\Support\Facades\Validator;

class FuelManagementController extends Controller
{
	public function index()
	{
		// $data['vehicles'] = get_complete_table('vehicles', '', '', '', '1', '', '');
		// $data['drivers'] = get_complete_table('drivers', '', '', '', '1', '', '');
		// return response()->json(array('msg' => 'success', 'response'=>'successfully', 'data' => $data));

		try {
			$feul = FuelManagement::orderBy('id', 'DESC')->get();
			return response()->json(['msg' => 'success', 'response' => 'successfully retrieved all feul.', 'data' => $feul]);
		} catch (\Exception $e) {
			return response()->json(['msg' => 'error', 'response' => $e->getMessage()], 500);
		}
	}
	public function store(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'vehicle_id' => 'required',
			'driver_id' => 'required',
			'trip_id' => 'required',
			'fuel_type' => 'required',
			'quantity' => 'required',
			'cost_per_liter' => 'required',
			'fuel_cost' => 'required',
			'current_meter_reading' => 'required',
			'fuel_datetime' => 'required',
			'location' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response' => $validator->errors()->all()));
		}
		$previous_data = get_single_row('fuel_management', 'vehicle_id', $data['vehicle_id'], '', '', '', '');
		if ($previous_data) {
			$data['previous_meter_reading'] = $previous_data->current_meter_reading;
			$data['fuel_avg'] = ($data['current_meter_reading'] - $data['previous_meter_reading']);
			$data['per_liter_avg'] = ($data['fuel_avg'] / $data['quantity']);
		} else {
			$data['previous_meter_reading'] = 0;
			$data['fuel_avg'] = 0;
			$data['per_liter_avg'] = 0;
		}


		$query = FuelManagement::create([
			'vehicle_id' => $data['vehicle_id'],
			'driver_id' => $data['driver_id'],
			'trip_id' => $data['trip_id'],
			'fuel_type' => $data['fuel_type'],
			'quantity' => $data['quantity'],
			'cost_per_liter' => $data['cost_per_liter'],
			'fuel_cost' => $data['fuel_cost'],
			'previous_meter_reading' => $data['previous_meter_reading'],
			'current_meter_reading' => $data['current_meter_reading'],
			'fuel_avg' => $data['fuel_avg'],
			'per_liter_avg' => $data['per_liter_avg'],
			'fuel_datetime' => $data['fuel_datetime'],
			'location' => $data['location'],
			'created_by' => Auth()->user()->id,
			'created_at' => date('Y-m-d H:i:s')
		]);
		$response_status = $query->id;
		if ($response_status > 0) {
			return response()->json(['msg' => 'success', 'response' => 'Fuel management successfully added.', 'query' => $query]);
		} else {
			return response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
		}
	}
	public function edit($id, Request $request)
	{
		$data['vehicles'] = FuelManagement::where('id', $id)->first();
		$data['vehicles'] = get_complete_table('vehicles', '', '', '', '1', '', '');
		$data['drivers'] = get_complete_table('drivers', '', '', '', '1', '', '');
		return response()->json(array('msg' => 'success', 'response' => 'successfully', 'data' => $data));
	}
	public function update(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'vehicle_id' => 'required',
			'driver_id' => 'required',
			'trip_id' => 'required',
			'fuel_type' => 'required',
			'quantity' => 'required',
			'cost_per_liter' => 'required',
			'fuel_cost' => 'required',
			'current_meter_reading' => 'required',
			'fuel_datetime' => 'required',
			'location' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response' => $validator->errors()->all()));
		}
		if (isset($data['status'])) {
			$status = "1";
		} else {
			$status = "0";
		}

		$previous_data = get_single_row('fuel_management', 'id', $data['id'], '', '', '', '');
		if ($previous_data) {
			$data['previous_meter_reading'] = $previous_data->current_meter_reading;
			$data['fuel_avg'] = ($data['current_meter_reading'] - $data['previous_meter_reading']);
			$data['per_liter_avg'] = ($data['fuel_avg'] / $data['quantity']);
		} else {
			$data['previous_meter_reading'] = 0;
			$data['fuel_avg'] = 0;
			$data['per_liter_avg'] = 0;
		}
		$post_status = FuelManagement::where('id', $data['id'])->update([
			'vehicle_id' => $data['vehicle_id'],
			'driver_id' => $data['driver_id'],
			'trip_id' => $data['trip_id'],
			'fuel_type' => $data['fuel_type'],
			'quantity' => $data['quantity'],
			'cost_per_liter' => $data['cost_per_liter'],
			'fuel_cost' => $data['fuel_cost'],
			'previous_meter_reading' => $data['previous_meter_reading'],
			'current_meter_reading' => $data['current_meter_reading'],
			'fuel_avg' => $data['fuel_avg'],
			'per_liter_avg' => $data['per_liter_avg'],
			'fuel_datetime' => $data['fuel_datetime'],
			'location' => $data['location'],
			'status' => $status,
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => Auth()->user()->id,
		]);

		if ($post_status > 0) {
			$updatedRecord = FuelManagement::find($data['id']);
			return response()->json([
				'msg' => 'success',
				'response' => 'Allowance successfully updated!',
				'query' => $updatedRecord, // Include the updated record in the response
			]);
		} else {
			return response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
		}
	}
	public function destroy(Request $request)
	{
		$data = $request->all();
		$status = FuelManagement::where('id', $data['id'])->first();
		if ($status) {
			FuelManagement::find($data['id'])->delete();
			return response()->json(['msg' => 'success', 'response' => 'Fuel management successfully deleted.']);
		} else {
			return response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
		}
	}
}
