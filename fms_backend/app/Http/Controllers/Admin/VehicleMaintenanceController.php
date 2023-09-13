<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admin\VehicleMaintenance;
use Session, Validator, DB, Str;

class VehicleMaintenanceController extends Controller
{
	public function index()
	{
		$data['vehicle_maintenance'] = VehicleMaintenance::orderBy('id', 'DESC')->get();
		$data['maintenance_types'] =  get_complete_table('maintenance_types', '', '', '', '1', '', '');
		$data['vehicles'] =  get_complete_table('vehicles', '', '', '', '1', '', '');
		return response()->json(array('msg' => 'success', 'response'=>'successfully', 'data' => $data));
	}
	public function store(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'vehicle_id' => 'required',
			'maintenance_type_id' => 'required',
			'maintenance_date' => 'required',
			'location' => 'required',
			'description' => 'required',
			'meter_reading' => 'required',
			'amount' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response'=>$validator->errors()->all()));
		}
		$query = VehicleMaintenance::create([
			'vehicle_id'=> $data['vehicle_id'],
			'maintenance_type_id'=> $data['maintenance_type_id'],
			'maintenance_date'=> $data['maintenance_date'],
			'location'=> $data['location'],
			'description'=> $data['description'],
			'meter_reading'=> $data['meter_reading'],
			'amount'=> $data['amount'],
			'created_by' => Auth()->user()->id,
			'created_at' => date('Y-m-d H:i:s')
		]);
		$response_status = $query->id;
		if($response_status > 0) {
			return response()->json(['msg' => 'success', 'response'=>'Vehicle maintenance successfully added.']);
		} else {
			return response()->json(['msg' => 'error', 'response'=>'Something went wrong!']);
		}
	}
	public function edit($id, Request $request)
	{
		$data['vehicle_maintenance'] = VehicleMaintenance::where('id', $id)->first();
		$data['maintenance_types'] =  get_complete_table('maintenance_types', '', '', '', '1', '', '');
		$data['vehicles'] =  get_complete_table('vehicles', '', '', '', '1', '', '');
		return response()->json(array('msg' => 'success', 'response'=>'successfully', 'data' => $data));
	}
	public function update(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'vehicle_id' => 'required',
			'maintenance_type_id' => 'required',
			'maintenance_date' => 'required',
			'location' => 'required',
			'description' => 'required',
			'meter_reading' => 'required',
			'amount' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response'=>$validator->errors()->all()));
		}
		if(isset($data['status'])){
			$status = "1";
		}else {
			$status = "0";
		}
		$post_status = VehicleMaintenance::where('id', $data['id'])->update([
			'vehicle_id'=> $data['vehicle_id'],
			'maintenance_type_id'=> $data['maintenance_type_id'],
			'maintenance_date'=> $data['maintenance_date'],
			'location'=> $data['location'],
			'description'=> $data['description'],
			'meter_reading'=> $data['meter_reading'],
			'amount'=> $data['amount'],
			'status' => $status,
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => Auth()->user()->id,
		]);

		if($post_status > 0) {
			return response()->json(['msg' => 'success', 'response'=>'Vehicle maintenance successfully updated!']);
		} else {
			return response()->json(['msg' => 'error', 'response'=>'Something went wrong!']);
		}
	}
	public function destroy(Request $request)
	{
		$data = $request->all();
		$status = VehicleMaintenance::where('id', $data['id'])->first();
		if($status) {
			VehicleMaintenance::find($data['id'])->delete();
			return response()->json(['msg' => 'success', 'response'=>'Vehicle maintenance successfully deleted.']);
		} else {
			return response()->json(['msg' => 'error', 'response'=>'Something went wrong!']);
		}
	}
}