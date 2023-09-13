<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admin\Vehicle;
use Session, Validator, DB, Str;

class VehicleController extends Controller
{
	public function index()
	{
		$data['vehicle_types'] =  get_complete_table('vehicle_types', '', '', '', '1', '', '');
		$data['drivers'] =  get_complete_table('drivers', '', '', '', '1', '', '');
		return response()->json(array('msg' => 'success', 'response'=>'successfully', 'data' => $data));
	}
	public function store(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'vehicle_type' => 'required',
			'fuel_type' => 'required',
			'registration_no' => 'required',
			'chassis_no' => 'required',
			'engine_no' => 'required',
			'current_mileage' => 'required',
			'make' => 'required',
			'model' => 'required',
			'year' => 'required',
			'color' => 'required',
			'registration_date' => 'required',
			'vehicle_location' => 'required',
			'driver' => 'required',
			'plate_no_photo' => 'required',
			'vehicle_photo' => 'required',
			'additional_notes' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response'=>$validator->errors()->all()));
		}
		$query = Vehicle::create([
			'vehicle_type'=> $data['vehicle_type'],
			'fuel_type'=> $data['fuel_type'],
			'registration_no'=> $data['registration_no'],
			'chassis_no'=> $data['chassis_no'],
			'engine_no'=> $data['engine_no'],
			'current_mileage'=> $data['current_mileage'],
			'make'=> $data['make'],
			'model'=> $data['model'],
			'year'=> $data['year'],
			'color'=> $data['color'],
			'registration_date'=> $data['registration_date'],
			'vehicle_location'=> $data['vehicle_location'],
			'driver_id'=> $data['driver'],
			'plate_no_photo'=> $data['plate_no_photo'],
			'vehicle_photo'=> $data['vehicle_photo'],
			'additional_notes'=> $data['additional_notes'],
			'created_by' => Auth()->user()->id,
			'created_at' => date('Y-m-d H:i:s')
		]);
		$response_status = $query->id;
		if($response_status > 0) {
			return response()->json(['msg' => 'success', 'response'=>'Vehicle successfully added.']);
		} else {
			return response()->json(['msg' => 'error', 'response'=>'Something went wrong!']);
		}
	}
	public function edit($id, Request $request)
	{
		$data['vehicles'] = Vehicle::where('id', $id)->first();
		$data['vehicle_types'] =  get_complete_table('vehicle_types', '', '', '', '1', '', '');
		$data['drivers'] =  get_complete_table('drivers', '', '', '', '1', '', '');
		return response()->json(array('msg' => 'success', 'response'=>'successfully', 'data' => $data));
	}
	public function update(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'vehicle_type' => 'required',
			'fuel_type' => 'required',
			'registration_no' => 'required',
			'chassis_no' => 'required',
			'engine_no' => 'required',
			'current_mileage' => 'required',
			'make' => 'required',
			'model' => 'required',
			'year' => 'required',
			'color' => 'required',
			'registration_date' => 'required',
			'vehicle_location' => 'required',
			'driver_id' => 'required',
			'plate_no_photo' => 'required',
			'vehicle_photo' => 'required',
			'additional_notes' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response'=>$validator->errors()->all()));
		}
		if(isset($data['status'])){
			$status = "1";
		}else {
			$status = "0";
		}
		$post_status = Vehicle::where('id', $data['id'])->update([
			'vehicle_type'=> $data['vehicle_type'],
			'fuel_type'=> $data['fuel_type'],
			'registration_no'=> $data['registration_no'],
			'chassis_no'=> $data['chassis_no'],
			'engine_no'=> $data['engine_no'],
			'current_mileage'=> $data['current_mileage'],
			'make'=> $data['make'],
			'model'=> $data['model'],
			'year'=> $data['year'],
			'color'=> $data['color'],
			'registration_date'=> $data['registration_date'],
			'vehicle_location'=> $data['vehicle_location'],
			'driver_id'=> $data['driver'],
			'plate_no_photo'=> $data['plate_no_photo'],
			'vehicle_photo'=> $data['vehicle_photo'],
			'additional_notes'=> $data['additional_notes'],
			'status' => $status,
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => Auth()->user()->id,
		]);

		if($post_status > 0) {
			return response()->json(['msg' => 'success', 'response'=>'Vehicle successfully updated!']);
		} else {
			return response()->json(['msg' => 'error', 'response'=>'Something went wrong!']);
		}
	}
	public function destroy(Request $request)
	{
		$data = $request->all();
		$status = Vehicle::where('id', $data['id'])->first();
		if($status) {
			Vehicle::find($data['id'])->delete();
			return response()->json(['msg' => 'success', 'response'=>'Vehicle successfully deleted.']);
		} else {
			return response()->json(['msg' => 'error', 'response'=>'Something went wrong!']);
		}
	}
}