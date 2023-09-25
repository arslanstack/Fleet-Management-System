<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admin\Allowance;
use Session, Validator, DB, Str;

class AllowanceController extends Controller
{
	public function index()
	{
		// $data['deductions'] = Allowance::orderBy('id', 'DESC')->get();
		// $data['allowance_types'] = get_complete_table('allowances', '', '', '', '1', '', '');
		// $data['drivers'] = get_complete_table('drivers', '', '', '', '1', '', '');
		// return response()->json(array('msg' => 'success', 'response'=>'successfully', 'data' => $data));
		$allowances = Allowance::orderBy('id', 'DESC')->get();
		return response()->json(array('msg' => 'success', 'response'=>'successfully', 'data' => $allowances));
	}
	public function store(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'driver_id' => 'required',
			'allowance_type' => 'required',
			'amount' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response'=>$validator->errors()->all()));
		}
		$query = Allowance::create([
			'driver_id'=> $data['driver_id'],
			'allowance_id'=> $data['allowance_type'],
			'amount'=> $data['amount'],
			'created_by' => Auth()->user()->id,
			'created_at' => date('Y-m-d H:i:s')
		]);
		$response_status = $query->id;
		if($response_status > 0) {
			return response()->json(['msg' => 'success', 'response'=>'Allowance successfully added.']);
		} else {
			return response()->json(['msg' => 'error', 'response'=>'Something went wrong!']);
		}
	}
	public function edit($id, Request $request)
	{
		$data['deduction'] = Allowance::where('id', $id)->first();
		$data['allowance_types'] = get_complete_table('allowances', '', '', '', '1', '', '');
		$data['drivers'] = get_complete_table('drivers', '', '', '', '1', '', '');
		return response()->json(array('msg' => 'success', 'response'=>'successfully', 'data' => $data));
	}
	public function update(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'driver_id' => 'required',
			'allowance_type' => 'required',
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
		$post_status = Allowance::where('id', $data['id'])->update([
			'driver_id'=> $data['driver_id'],
			'allowance_id'=> $data['allowance_type'],
			'amount'=> $data['amount'],
			'status' => $status,
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => Auth()->user()->id,
		]);

		if($post_status > 0) {
			return response()->json(['msg' => 'success', 'response'=>'Allowance successfully updated!']);
		} else {
			return response()->json(['msg' => 'error', 'response'=>'Something went wrong!']);
		}
	}
	public function destroy(Request $request)
	{
		$data = $request->all();
		$status = Allowance::where('id', $data['id'])->first();
		if($status) {
			Allowance::find($data['id'])->delete();
			return response()->json(['msg' => 'success', 'response'=>'Allowance successfully deleted.']);
		} else {
			return response()->json(['msg' => 'error', 'response'=>'Something went wrong!']);
		}
	}
}