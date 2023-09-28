<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admin\Deduction;
use Session, DB, Str;
use Illuminate\Support\Facades\Validator;

class DeductionController extends Controller
{
	public function index()
	{
		// $data['deductions'] = Deduction::orderBy('id', 'DESC')->get();
		// $data['deduction_types'] = get_complete_table('deductions', '', '', '', '1', '', '');
		// $data['drivers'] = get_complete_table('drivers', '', '', '', '1', '', '');
		// return response()->json(array('msg' => 'success', 'response'=>'successfully', 'data' => $data));

		try {
			$deductions = Deduction::orderBy('id', 'DESC')->get();
			return response()->json(['msg' => 'success', 'response' => 'successfully retrieved all deductions.', 'data' => $deductions]);
		} catch (\Exception $e) {
			return response()->json(['msg' => 'error', 'response' => $e->getMessage()], 500);
		}
	}
	public function store(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'driver_id' => 'required',
			'deduction_type' => 'required',
			'amount' => 'required',
			'effective_date' => 'required',
			'installment_months' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response' => $validator->errors()->all()));
		}
		$query = Deduction::create([
			'driver_id' => $data['driver_id'],
			'deduction_id' => $data['deduction_type'],
			'amount' => $data['amount'],
			'effective_date' => $data['effective_date'],
			'description' => $data['description'],
			'created_by' => Auth()->user()->id,
			'created_at' => date('Y-m-d H:i:s'),
			'installment_months' => $data['installment_months'],
			'paid_months' => 0,
			'paid_amount' => 0.00,
			'remaining_amount' => $data['amount'],
		]);
		$response_status = $query->id;
		if ($response_status > 0) {
			return response()->json(['msg' => 'success', 'response' => 'Deduction successfully added.', 'query' => $query]);
		} else {
			return response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
		}
	}
	public function edit($id, Request $request)
	{
		$data['deduction'] = Deduction::where('id', $id)->first();
		$data['deduction_types'] = get_complete_table('deductions', '', '', '', '1', '', '');
		$data['drivers'] = get_complete_table('drivers', '', '', '', '1', '', '');
		return response()->json(array('msg' => 'success', 'response' => 'successfully', 'data' => $data));
	}
	public function driver_deduction($id)
	{
		$deduction = Deduction::where('driver_id', $id)->orderBy('id', 'DESC')->get();
		return response()->json(array('msg' => 'success', 'response' => 'successfully', 'data' => $deduction));
	}
	public function update(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'id' => 'required',
			'driver_id' => 'required',
			'deduction_type' => 'required',
			'amount' => 'required',
			'effective_date' => 'required',
			'installment_months' => 'required',
			'paid_months' => 'required',
			'paid_amount' => 'required',
			'remaining_amount' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response' => $validator->errors()->all()));
		}
		if (isset($data['status'])) {
			$status = "1";
		} else {
			$status = "0";
		}
		$post_status = Deduction::where('id', $data['id'])->update([
			'driver_id' => $data['driver_id'],
			'deduction_id' => $data['deduction_type'],
			'amount' => $data['amount'],
			'effective_date' => $data['effective_date'],
			'description' => $data['description'],
			'status' => $status,
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => Auth()->user()->id,
			'installment_months' => $data['installment_months'],
			'paid_months' => $data['paid_months'],
			'paid_amount' => $data['paid_amount'],
			'remaining_amount' => $data['remaining_amount'],
		]);

		if ($post_status > 0) {
			$updatedRecord = Deduction::find($data['id']);
			return response()->json([
				'msg' => 'success',
				'response' => 'Deduction successfully updated!',
				'query' => $updatedRecord, // Include the updated record in the response
			]);
		} else {
			return response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
		}
	}
	public function active_deductions($id)
	{
		// Use Eloquent to query the deductions table
		$activeDeductionsCount = Deduction::where('driver_id', $id)
			->where('remaining_amount', '>', 0)
			->count();

		return response()->json([
			'msg' => 'success',
			'response' => 'Successfully retrieved active deductions count',
			'active_deductions_count' => $activeDeductionsCount,
		]);
	}
	public function installmentReport($id)
	{
		$data['deduction'] = Deduction::where('id', $id)->first();
		$data['report'] = get_installment_report($id);
		return response()->json(array('msg' => 'success', 'response' => 'successfully', 'data' => $data));
	}
	public function destroy(Request $request)
	{
		$data = $request->all();
		$status = Deduction::where('id', $data['id'])->first();
		if ($status) {
			Deduction::find($data['id'])->delete();
			return response()->json(['msg' => 'success', 'response' => 'Deduction successfully deleted.']);
		} else {
			return response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
		}
	}
}
