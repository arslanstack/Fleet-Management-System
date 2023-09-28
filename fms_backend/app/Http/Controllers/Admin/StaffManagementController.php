<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Admin;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Session, Str;
use Illuminate\Support\Facades\DB;

class StaffManagementController extends Controller
{
    public function index()
    {
        try {
            $admins = Admin::where('id', '!=', Auth::user()->id)->orderBy('id', 'DESC')->get();
            return response()->json(['msg' => 'success', 'response' => 'successfully', 'data' => $admins]);
        } catch (\Exception $e) {
            return response()->json(['msg' => 'error', 'response' => $e->getMessage()], 500);
        }
    }
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role_type' => 'required',
            'phone_no' => 'required',
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'validation_error', 'errors' => $validator->errors()], 400);
        }
        
        try {
            if ($request->hasFile('image')) {
                $imageFile = $request->file('image');
                $file_name = explode('.', $imageFile->getClientOriginalName())[0];
                $image = $file_name . '_' . time() . '.' . $imageFile->getClientOriginalExtension();
                $destinationPath = public_path('/assets/upload_images');
                $imageFile->move($destinationPath, $image);
                $image_path1 = asset('assets/upload_images') . '/' . $image;
            }
            $query = Admin::create([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'role_type' => $data['role_type'],
                'phone_no' => $data['phone_no'],
                'image' => $image_path1,
                'created_by' => Auth::user()->id,
                'created_at' => now(),
            ]);

            if ($query) {
                return response()->json(['msg' => 'success', 'response' => 'Admin successfully added.', 'query' => $query]);
            } else {
                return response()->json(['msg' => 'error', 'response' => 'Something went wrong!'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['msg' => 'error', 'response' => $e->getMessage()], 500);
        }
    }

    public function edit($id, Request $request)
    {
        try {
            $admin = Admin::where('id', $id)->first();
            return response()->json(['msg' => 'success', 'response' => 'successfully', 'data' => $admin]);
        } catch (\Exception $e) {
            return response()->json(['msg' => 'error', 'response' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'username' => 'required',
            'email' => 'required',
            'role_type' => 'required',
            'phone_no' => 'required',
            'view_all_data' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'validation_error', 'errors' => $validator->errors()], 400);
        }

        try {
            if (isset($data['status'])) {
                $status = "1";
            } else {
                $status = "0";
            }
            if ($request->hasFile('image')) {
                $imageFile = $request->file('image');
                $file_name = explode('.', $imageFile->getClientOriginalName())[0];
                $image = $file_name . '_' . time() . '.' . $imageFile->getClientOriginalExtension();
                $destinationPath = public_path('/assets/upload_images');
                $imageFile->move($destinationPath, $image);
                $image_path1 = asset('assets/upload_images') . '/' . $image;
                DB::table('admin_users')
                    ->where('id', $data['id'])->update([
                        'image' => $image_path1
                    ]);
            }
            if (isset($data['password'])) {
                DB::table('admin_users')
                    ->where('id', $data['id'])->update([
                        'password' => bcrypt($data['password'])
                    ]);
            }
            $post_status = Admin::where('id', $data['id'])->update([
                'username' => $data['username'],
                'email' => $data['email'],
                'role_type' => $data['role_type'],
                'phone_no' => $data['phone_no'],
                'view_all_data' => $data['view_all_data'],
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => Auth()->user()->id,
            ]);

            if ($post_status > 0) {
                return response()->json(['msg' => 'success', 'response' => 'Admin successfully updated!']);
            } else {
                return response()->json(['msg' => 'error', 'response' => 'Something went wrong! Probably Inavlid id given.']);
            }
        } catch (\Exception $e) {
            return response()->json(['msg' => 'error', 'response' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'validation_error', 'errors' => $validator->errors()], 400);
        }

        try {

            $admin = Admin::find($data['id']);
            if ($admin->type == 0 && Auth::user()->type != 0) {
                return response()->json(['msg' => 'error', 'response' => 'You can not delete super admin.'], 404);
            }
            if (!$admin) {
                return response()->json(['msg' => 'error', 'response' => 'Admin not found.'], 404);
            }
            $admin->delete();
            return response()->json(['msg' => 'success', 'response' => 'Admin successfully deleted.']);
        } catch (\Exception $e) {
            return response()->json(['msg' => 'error', 'response' => $e->getMessage()], 500);
        }
    }
}
