<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admin\Role;
use Session, DB, Str;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index()
    {
        try {
            $roles = Role::orderBy('id', 'DESC')->get();
            return response()->json(['msg' => 'success', 'response' => 'successfully', 'data' => $roles]);
        } catch (\Exception $e) {
            return response()->json(['msg' => 'error', 'response' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'role_name' => 'required | unique:roles,role_name',
            'permissions' => 'required',
            'full_access' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'validation_error', 'errors' => $validator->errors()], 400);
        }
        if ($data['full_access']) {
            $full_access = 1;
        } else {
            $full_access = 0;
        }
        try {
            $query = Role::create([
                'role_name' => $data['role_name'],
                'permissions' => $data['permissions'],
                'full_access' => $full_access,
                'created_by' => Auth::user()->id,
            ]);

            if ($query) {
                return response()->json(['msg' => 'success', 'response' => 'Role successfully added.']);
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
            $role = Role::find($id);

            if (!$role) {
                return response()->json(['msg' => 'error', 'response' => 'Role not found.'], 404);
            }

            return response()->json(['msg' => 'success', 'response' => 'successfully', 'data' => $role]);
        } catch (\Exception $e) {
            return response()->json(['msg' => 'error', 'response' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'role_name' => 'required | unique:roles,role_name',
            'permissions' => 'required',
            'full_access' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'validation_error', 'errors' => $validator->errors()], 400);
        }

        try {
            $role = Role::find($data['id']);

            if (!$role) {
                return response()->json(['msg' => 'error', 'response' => 'Role not found.'], 404);
            }

            $status = isset($data['status']) ? "1" : "0";

            $post_status = $role->update([
                'role_name' => $data['role_name'],
                'permissions' => $data['permissions'],
                'full_access' => $data['full_access'],
                'status' => $status,
                'updated_at' => now(),
                'updated_by' => Auth::user()->id,
            ]);

            if ($post_status) {
                return response()->json(['msg' => 'success', 'response' => 'Role successfully updated!']);
            } else {
                return response()->json(['msg' => 'error', 'response' => 'Something went wrong!'], 500);
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
            $role = Role::find($data['id']);

            if (!$role) {
                return response()->json(['msg' => 'error', 'response' => 'Role not found.'], 404);
            }

            $role->delete();
            return response()->json(['msg' => 'success', 'response' => 'Role successfully deleted.']);
        } catch (\Exception $e) {
            return response()->json(['msg' => 'error', 'response' => $e->getMessage()], 500);
        }
    }
}
