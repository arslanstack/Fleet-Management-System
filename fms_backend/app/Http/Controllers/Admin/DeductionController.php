<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admin\Deduction;
use Session, Validator, DB, Str;

class DeductionController extends Controller
{
	public function index()
	{
		$data['deductions'] = Deduction::orderBy('id', 'DESC')->get();
		$data['deduction_types'] = get_complete_table('deductions', '', '', '', '1', '', '');
		$data['drivers'] = get_complete_table('drivers', '', '', '', '1', '', '');
		return response()->json(array('msg' => 'success', 'response'=>'successfully', 'data' => $data));
	}
	public function store(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'driver_id' => 'required',
			'deduction_type' => 'required',
			'amount' => 'required',
			'effective_date' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response'=>$validator->errors()->all()));
		}
		$query = Deduction::create([
			'driver_id'=> $data['driver_id'],
			'deduction_id'=> $data['deduction_type'],
			'amount'=> $data['amount'],
			'effective_date'=> $data['effective_date'],
			'description'=> $data['description'],
			'created_by' => Auth()->user()->id,
			'created_at' => date('Y-m-d H:i:s')
		]);
		$response_status = $query->id;
		if($response_status > 0) {
			return response()->json(['msg' => 'success', 'response'=>'Deduction successfully added.']);
		} else {
			return response()->json(['msg' => 'error', 'response'=>'Something went wrong!']);
		}
	}
	public function edit($id, Request $request)
	{
		$data['deduction'] = Deduction::where('id', $id)->first();
		$data['deduction_types'] = get_complete_table('deductions', '', '', '', '1', '', '');
		$data['drivers'] = get_complete_table('drivers', '', '', '', '1', '', '');
		return response()->json(array('msg' => 'success', 'response'=>'successfully', 'data' => $data));
	}
	public function update(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'driver_id' => 'required',
			'deduction_type' => 'required',
			'amount' => 'required',
			'effective_date' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response'=>$validator->errors()->all()));
		}
		if(isset($data['status'])){
			$status = "1";
		}else {
			$status = "0";
		}
		$post_status = Deduction::where('id', $data['id'])->update([
			'driver_id'=> $data['driver_id'],
			'deduction_id'=> $data['deduction_type'],
			'amount'=> $data['amount'],
			'effective_date'=> $data['effective_date'],
			'description'=> $data['description'],
			'status' => $status,
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => Auth()->user()->id,
		]);

		if($post_status > 0) {
			return response()->json(['msg' => 'success', 'response'=>'Deduction successfully updated!']);
		} else {
			return response()->json(['msg' => 'error', 'response'=>'Something went wrong!']);
		}
	}
	public function destroy(Request $request)
	{
		$data = $request->all();
		$status = Deduction::where('id', $data['id'])->first();
		if($status) {
			Deduction::find($data['id'])->delete();
			return response()->json(['msg' => 'success', 'response'=>'Deduction successfully deleted.']);
		} else {
			return response()->json(['msg' => 'error', 'response'=>'Something went wrong!']);
		}
	}
}