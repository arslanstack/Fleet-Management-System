<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admin\AllowanceType;
use Session, Validator, DB, Str;

class AllowanceTypeController extends Controller
{
	public function index()
	{
		$allowance_types = AllowanceType::orderBy('id', 'DESC')->get();
		return response()->json(array('msg' => 'success', 'response'=>'successfully', 'data' => $allowance_types));
	}
	public function store(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'allowance_type' => 'required',
			'description' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response'=>$validator->errors()->all()));
		}
		$query = AllowanceType::create([
			'allowance_type'=> $data['allowance_type'],
			'description'=> $data['description'],
			'created_by' => Auth()->user()->id,
			'created_at' => date('Y-m-d H:i:s')
		]);
		$response_status = $query->id;
		if($response_status > 0) {
			return response()->json(['msg' => 'success', 'response'=>'Allowance type successfully added.', 'query' => $query]);
		} else {
			return response()->json(['msg' => 'error', 'response'=>'Something went wrong!']);
		}
	}
	public function edit($id, Request $request)
	{
		$allowance_type = AllowanceType::where('id', $id)->first();
		return response()->json(array('msg' => 'success', 'response'=>'successfully', 'data' => $allowance_type));
	}
	public function update(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'allowance_type' => 'required',
			'description' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response'=>$validator->errors()->all()));
		}
		if(isset($data['status'])){
			$status = "1";
		}else {
			$status = "0";
		}
		$post_status = AllowanceType::where('id', $data['id'])->update([
			'allowance_type'=> $data['allowance_type'],
			'description'=> $data['description'],
			'status' => $status,
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => Auth()->user()->id,
		]);

		if($post_status > 0) {
			return response()->json(['msg' => 'success', 'response'=>'Allowance type successfully updated!']);
		} else {
			return response()->json(['msg' => 'error', 'response'=>'Something went wrong!']);
		}
	}
	public function destroy(Request $request)
	{
		$data = $request->all();
		$status = AllowanceType::where('id', $data['id'])->first();
		if($status) {
			AllowanceType::find($data['id'])->delete();
			return response()->json(['msg' => 'success', 'response'=>'Allowance type successfully deleted.']);
		} else {
			return response()->json(['msg' => 'error', 'response'=>'Something went wrong!']);
		}
	}
}