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
            $rolesWithPermissionsArray = $roles->map(function ($role) {
                $permissionsString = $role->permissions;
                $permissionsArray = explode(', ', $permissionsString);
                $role->permissions = $permissionsArray;
                return $role;
            });
            return response()->json(['msg' => 'success', 'response' => 'successfully', 'data' => $rolesWithPermissionsArray]);
        } catch (\Exception $e) {
            return response()->json(['msg' => 'error', 'response' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        // return response()->json(['msg' => 'success', 'request' => $request->all()]);
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'role_name' => 'required | unique:roles,role_name',
            'permissions' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'validation_error', 'errors' => $validator->errors()], 400);
        }
        $permissionsArray = $data['permissions'];
        $permissionsString = implode(', ', $permissionsArray);
        try {
            $query = Role::create([
                'role_name' => $data['role_name'],
                'permissions' => $permissionsString,
                'created_by' => Auth::user()->id,
            ]);

            if ($query) {
                return response()->json(['msg' => 'success', 'response' => 'Role successfully added.', 'query' => $query]);
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
            $permissionsString = $role->permissions;
            $role->permissions = explode(', ', $permissionsString);

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
            'role_name' => 'required',
            'permissions' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'validation_error', 'errors' => $validator->errors()], 400);
        }
        $permissionsArray = $data['permissions'];
        $permissionsString = implode(', ', $permissionsArray);
        try {
            $role = Role::find($data['id']);

            if (!$role) {
                return response()->json(['msg' => 'error', 'response' => 'Role not found.'], 404);
            }

            $status = isset($data['status']) ? "1" : "0";

            $post_status = $role->update([
                'role_name' => $data['role_name'],
                'permissions' => $permissionsString,
                'status' => $status,
                'updated_at' => now(),
                'updated_by' => Auth::user()->id,
            ]);

            if ($post_status > 0) {
                $updatedRecord = Role::find($data['id']);
                return response()->json([
                    'msg' => 'success',
                    'response' => 'Role successfully updated!',
                    'query' => $updatedRecord, // Include the updated record in the response
                ]);
            } else {
                return response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
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
