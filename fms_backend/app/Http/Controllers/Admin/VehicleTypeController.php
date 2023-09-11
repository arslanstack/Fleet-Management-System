<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admin\VehicleType;
use Session, Validator, DB, Str;

class VehicleTypeController extends Controller
{
	public function index()
	{
		try {
			$vehicle_types = VehicleType::orderBy('id', 'DESC')->get();
			return response()->json(array('msg' => 'success', 'response'=>'successfully', 'data' => $vehicle_types));
		} catch (Exception $e) {
			return response()->json(array('msg' => 'error', 'response'=>$e->getMessage() ));
		}
	}
	public function store(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'vehicle_type' => 'required',
			'capacity' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response'=>$validator->errors()->all()));
		}
		$query = VehicleType::create([
			'vehicle_type'=> $data['vehicle_type'],
			'capacity'=> $data['capacity'],
			'created_by' => Auth()->user()->id,
			'created_at' => date('Y-m-d H:i:s')
		]);
		$response_status = $query->id;
		if($response_status > 0) {
			return response()->json(['msg' => 'success', 'response'=>'Vehicle type successfully added.']);
		} else {
			return response()->json(['msg' => 'error', 'response'=>'Something went wrong!']);
		}
	}
	public function edit($id, Request $request)
	{
		$vehicle_type = VehicleType::where('id', $id)->first();
		return response()->json(array('msg' => 'success', 'response'=>'successfully', 'data' => $vehicle_type));
	}
	public function update(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'vehicle_type' => 'required',
			'capacity' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response'=>$validator->errors()->all()));
		}
		if(isset($data['status'])){
			$status = "1";
		}else {
			$status = "0";
		}
		$post_status = VehicleType::where('id', $data['id'])->update([
			'vehicle_type'=> $data['vehicle_type'],
			'capacity'=> $data['capacity'],
			'status' => $status,
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => Auth()->user()->id,
		]);

		if($post_status > 0) {
			return response()->json(['msg' => 'success', 'response'=>'Vehicle type successfully updated!']);
		} else {
			return response()->json(['msg' => 'error', 'response'=>'Something went wrong!']);
		}
	}
	public function destroy(Request $request)
	{
		try {
			$data = $request->all();
			$status = VehicleType::where('id', $data['id'])->first();
			if($status) {
				VehicleType::find($data['id'])->delete();
				return response()->json(['msg' => 'success', 'response'=>'Vehicle type successfully deleted.']);
			} else {
				return response()->json(['msg' => 'error', 'response'=>'Something went wrong!']);
			}
		} catch (Exception $e) {
			return response()->json(array('msg' => 'error', 'response'=>$e->getMessage() ));
		}
	}
}