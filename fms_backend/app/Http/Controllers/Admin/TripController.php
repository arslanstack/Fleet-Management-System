<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\Trip;
use Illuminate\Support\Facades\Validator;

class TripController extends Controller
{
    public function index()
    {
        try {
            $trips = Trip::orderBy('id', 'DESC')->get();
            return response()->json(['msg' => 'success', 'response' => 'successfully', 'data' => $trips]);
        } catch (\Exception $e) {
            return response()->json(['msg' => 'error', 'response' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'vehicle_id' => 'required',
            'driver_id' => 'required',
            'project_id' => 'required',
            'company_id' => 'required',
            'start_date_time' => 'required',
            'end_date_time' => 'required',
            'from_location' => 'required',
            'end_location' => 'required',
            'distance' => 'required',
            'description' => 'required',
            'notes' => 'required',
            'amount' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'validation_error', 'errors' => $validator->errors()], 400);
        }

        try {
            $query = Trip::create([
                'vehicle_id' => $data['vehicle_id'],
                'driver_id' => $data['driver_id'],
                'project_id' => $data['project_id'],
                'company_id' => $data['company_id'],
                'start_date_time' => $data['start_date_time'],
                'end_date_time' => $data['end_date_time'],
                'from_location' => $data['from_location'],
                'end_location' => $data['end_location'],
                'distance' => $data['distance'],
                'description' => $data['description'],
                'notes' => $data['notes'],
                'amount' => $data['amount'],
                'created_by' => Auth::user()->id,
                'created_at' => now(),
            ]);

            if ($query) {
                return response()->json(['msg' => 'success', 'response' => 'Trip successfully added.']);
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
            $trip = Trip::find($id);
            
            if (!$trip) {
                return response()->json(['msg' => 'error', 'response' => 'Trip not found.'], 404);
            }

            return response()->json(['msg' => 'success', 'response' => 'successfully', 'data' => $trip]);
        } catch (\Exception $e) {
            return response()->json(['msg' => 'error', 'response' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'vehicle_id' => 'required',
            'driver_id' => 'required',
            'project_id' => 'required',
            'company_id' => 'required',
            'start_date_time' => 'required',
            'end_date_time' => 'required',
            'from_location' => 'required',
            'end_location' => 'required',
            'distance' => 'required',
            'description' => 'required',
            'notes' => 'required',
            'amount' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'validation_error', 'errors' => $validator->errors()], 400);
        }

        try {
            $trip = Trip::find($data['id']);
            
            if (!$trip) {
                return response()->json(['msg' => 'error', 'response' => 'Trip not found.'], 404);
            }

            $status = isset($data['status']) ? "1" : "0";
            
            $post_status = $trip->update([
                'vehicle_id' => $data['vehicle_id'],
                'driver_id' => $data['driver_id'],
                'project_id' => $data['project_id'],
                'company_id' => $data['company_id'],
                'start_date_time' => $data['start_date_time'],
                'end_date_time' => $data['end_date_time'],
                'from_location' => $data['from_location'],
                'end_location' => $data['end_location'],
                'distance' => $data['distance'],
                'description' => $data['description'],
                'notes' => $data['notes'],
                'amount' => $data['amount'],
                'status' => $status,
                'updated_at' => now(),
                'updated_by' => Auth::user()->id,
            ]);

            if ($post_status) {
                return response()->json(['msg' => 'success', 'response' => 'Trip successfully updated!']);
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
            $trip = Trip::find($data['id']);
            
            if (!$trip) {
                return response()->json(['msg' => 'error', 'response' => 'Trip not found.'], 404);
            }

            $trip->delete();
            return response()->json(['msg' => 'success', 'response' => 'Trip successfully deleted.']);
        } catch (\Exception $e) {
            return response()->json(['msg' => 'error', 'response' => $e->getMessage()], 500);
        }
    }
}
