<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admin\FineType;
use Session, Validator, DB, Str;

class FineTypeController extends Controller
{
	public function index()
	{
		$fine_types = FineType::orderBy('id', 'DESC')->get();
		return response()->json(array('msg' => 'success', 'response'=>'successfully', 'data' => $fine_types));
	}
	public function store(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'fine_type' => 'required',
			'description' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response'=>$validator->errors()->all()));
		}
		$query = FineType::create([
			'fine_type'=> $data['fine_type'],
			'description'=> $data['description'],
			'created_by' => Auth()->user()->id,
			'created_at' => date('Y-m-d H:i:s')
		]);
		$response_status = $query->id;
		if($response_status > 0) {
			return response()->json(['msg' => 'success', 'response'=>'Fine type successfully added.']);
		} else {
			return response()->json(['msg' => 'error', 'response'=>'Something went wrong!']);
		}
	}
	public function edit($id, Request $request)
	{
		$fine_type = FineType::where('id', $id)->first();
		return response()->json(array('msg' => 'success', 'response'=>'successfully', 'data' => $fine_type));
	}
	public function update(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'fine_type' => 'required',
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
		$post_status = FineType::where('id', $data['id'])->update([
			'fine_type'=> $data['fine_type'],
			'description'=> $data['description'],
			'status' => $status,
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => Auth()->user()->id,
		]);

		if($post_status > 0) {
			return response()->json(['msg' => 'success', 'response'=>'Fine type successfully updated!']);
		} else {
			return response()->json(['msg' => 'error', 'response'=>'Something went wrong!']);
		}
	}
	public function destroy(Request $request)
	{
		$data = $request->all();
		$status = FineType::where('id', $data['id'])->first();
		if($status) {
			FineType::find($data['id'])->delete();
			return response()->json(['msg' => 'success', 'response'=>'Fine type successfully deleted.']);
		} else {
			return response()->json(['msg' => 'error', 'response'=>'Something went wrong!']);
		}
	}
}