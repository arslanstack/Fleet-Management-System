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

            // Loop through $trips and convert string date times to date format
            foreach ($trips as $trip) {
                $trip->start_date_time = date('Y-m-d', strtotime($trip->start_date_time));
                $trip->end_date_time = date('Y-m-d', strtotime($trip->end_date_time));
            }

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
                return response()->json(['msg' => 'success', 'response' => 'Trip successfully added.', 'query' => $query]);
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
            $trip->start_date_time = date('Y-m-d', strtotime($trip->start_date_time));
            $trip->end_date_time = date('Y-m-d', strtotime($trip->end_date_time));

            return response()->json(['msg' => 'success', 'response' => 'successfully', 'data' => $trip]);
        } catch (\Exception $e) {
            return response()->json(['msg' => 'error', 'response' => $e->getMessage()], 500);
        }
    }
    public function driver_trips($id)
    {
        try {
            $trips = Trip::where('driver_id', $id)->orderBy('id', 'DESC')->get();
            foreach ($trips as $trip) {
                $trip->start_date_time = date('Y-m-d', strtotime($trip->start_date_time));
                $trip->end_date_time = date('Y-m-d', strtotime($trip->end_date_time));
            }
            return response()->json(['msg' => 'success', 'response' => 'successfully', 'data' => $trips]);
        } catch (\Exception $e) {
            return response()->json(['msg' => 'error', 'response' => $e->getMessage()], 500);
        }
    }
    public function update(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required',
            'vehicle_id' => 'required',
            'driver_id' => 'required',
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

            $post_status = $trip->update([
                'vehicle_id' => $data['vehicle_id'],
                'driver_id' => $data['driver_id'],
                'company_id' => $data['company_id'],
                'start_date_time' => $data['start_date_time'],
                'end_date_time' => $data['end_date_time'],
                'from_location' => $data['from_location'],
                'end_location' => $data['end_location'],
                'distance' => $data['distance'],
                'description' => $data['description'],
                'notes' => $data['notes'],
                'amount' => $data['amount'],
                'status' => $data['status'],
                'updated_at' => now(),
                'updated_by' => Auth::user()->id,
            ]);

            if ($post_status > 0) {
                $updatedRecord = Trip::find($data['id']);
                return response()->json([
                    'msg' => 'success',
                    'response' => 'Trip successfully updated!',
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
