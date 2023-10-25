<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admin\DeductionType;
use Session, DB, Str;
use Illuminate\Support\Facades\Validator;

class DeductionTypeController extends Controller
{
	public function index()
	{
		$data['deduction_types'] = DeductionType::orderBy('id', 'DESC')->get();
		return response()->json(array('msg' => 'success', 'response' => 'successfully', 'data' => $data));
	}
	public function store(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'deduction_type' => 'required',
			'description' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response' => $validator->errors()->all()));
		}
		$query = DeductionType::create([
			'deduction_type' => $data['deduction_type'],
			'description' => $data['description'],
			'created_by' => Auth()->user()->id,
			'created_at' => date('Y-m-d H:i:s')
		]);
		$response_status = $query->id;
		if ($response_status > 0) {
			return response()->json(['msg' => 'success', 'response' => 'Deduction type successfully added.', 'query' => $query]);
		} else {
			return response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
		}
	}
	public function edit($id, Request $request)
	{
		$data['deduction_type'] = DeductionType::where('id', $id)->first();
		return response()->json(array('msg' => 'success', 'response' => 'successfully', 'data' => $data));
	}
	public function update(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'deduction_type' => 'required',
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
		$post_status = DeductionType::where('id', $data['id'])->update([
			'deduction_type' => $data['deduction_type'],
			'description' => $data['description'],
			'status' => $status,
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => Auth()->user()->id,
		]);

		if ($post_status > 0) {
			$updatedRecord = DeductionType::find($data['id']);
			return response()->json([
				'msg' => 'success',
				'response' => 'DeductionType successfully updated!',
				'query' => $updatedRecord, // Include the updated record in the response
			]);
		} else {
			return response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
		}
	}
	public function destroy(Request $request)
	{
		$data = $request->all();
		$status = DeductionType::where('id', $data['id'])->first();
		if ($status) {
			DeductionType::find($data['id'])->delete();
			return response()->json(['msg' => 'success', 'response' => 'Deduction type successfully deleted.']);
		} else {
			return response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
		}
	}
}
