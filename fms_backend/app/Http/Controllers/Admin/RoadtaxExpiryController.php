<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admin\Roadtax;
use Session, DB, Str;
use Illuminate\Support\Facades\Validator;

class RoadtaxExpiryController extends Controller
{
	public function index()
	{
		// $data['vehicles'] = get_complete_table('vehicles', '', '', '', '1', '', '');
		// $data['roadtax'] = Roadtax::orderBy('id', 'DESC')->get();
		// return response()->json(array('msg' => 'success', 'response'=>'successfully', 'data' => $data));
		try {
			$roadtax = Roadtax::orderBy('id', 'DESC')->get();
			return response()->json(['msg' => 'success', 'response' => 'successfully retrieved all roadtax.', 'data' => $roadtax]);
		} catch (\Exception $e) {
			return response()->json(['msg' => 'error', 'response' => $e->getMessage()], 500);
		}
	}
	public function store(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'vehicle_id' => 'required',
			'expiry_date' => 'required',
			'renewal_date' => 'required',
			'description' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response' => $validator->errors()->all()));
		}
		$query = Roadtax::create([
			'vehicle_id' => $data['vehicle_id'],
			'expiry_date' => $data['expiry_date'],
			'renewal_date' => $data['renewal_date'],
			'description' => $data['description'],
			'created_by' => Auth()->user()->id,
			'created_at' => date('Y-m-d H:i:s')
		]);
		$response_status = $query->id;
		if ($response_status > 0) {
			return response()->json(['msg' => 'success', 'response' => 'Roadtax successfully added.', 'query' => $query]);
		} else {
			return response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
		}
	}
	public function edit($id, Request $request)
	{
		$data['vehicles'] = get_complete_table('vehicles', '', '', '', '1', '', '');
		$data['roadtax'] = Roadtax::where('id', $id)->first();
		return response()->json(array('msg' => 'success', 'response' => 'successfully', 'data' => $data));
	}
	public function update(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'vehicle_id' => 'required',
			'expiry_date' => 'required',
			'renewal_date' => 'required',
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
		$post_status = Roadtax::where('id', $data['id'])->update([
			'vehicle_id' => $data['vehicle_id'],
			'expiry_date' => $data['expiry_date'],
			'renewal_date' => $data['renewal_date'],
			'description' => $data['description'],
			'status' => $status,
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => Auth()->user()->id,
		]);

		if ($post_status > 0) {
			return response()->json(['msg' => 'success', 'response' => 'Roadtax successfully updated!']);
		} else {
			return response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
		}
	}
	public function destroy(Request $request)
	{
		$data = $request->all();
		$status = Roadtax::where('id', $data['id'])->first();
		if ($status) {
			Roadtax::find($data['id'])->delete();
			return response()->json(['msg' => 'success', 'response' => 'Roadtax successfully deleted.']);
		} else {
			return response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
		}
	}
}
