<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Driver;
use App\Models\Admin\Vehicle;
use App\Models\Admin\FuelManagement;
use App\Models\Admin\Project;
use App\Models\Admin\Trip;
use App\Models\Admin\Company;
use App\Models\Admin\VehicleMaintenance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ProfitLossController extends Controller
{
    public function project_profit_loss_range(Request $request)
    {
        // Validate the request parameters
        $validator = Validator::make($request->all(), [
            'project_id' => 'required',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'lvl_error', 'response' => $validator->errors()->all()]);
        }

        // Extract the input parameters
        $projectId = $request->input('project_id');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        // Call a helper function to calculate profit and loss for the project within the date range
        $projectData = calculateProjectProfitLossInRange($projectId, $fromDate, $toDate);

        return response()->json([
            'msg' => 'success',
            'response' => 'successfully',
            'data' => $projectData,
        ]);
    }
    public function driver_profit_loss_range(Request $request)
    {
        // Validate the request parameters
        $validator = Validator::make($request->all(), [
            'driver_id' => 'required',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'lvl_error', 'response' => $validator->errors()->all()]);
        }

        // Extract the input parameters
        $driverId = $request->input('driver_id');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        // Call a helper function to calculate profit and loss for the driver within the date range
        $driverData = calculateDriverProfitLossInRange($driverId, $fromDate, $toDate);

        return response()->json([
            'msg' => 'success',
            'response' => 'successfully',
            'data' => $driverData,
        ]);
    }
    public function company_profit_loss_range(Request $request)
    {
        // Validate the request parameters
        $validator = Validator::make($request->all(), [
            'company_id' => 'required',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'lvl_error', 'response' => $validator->errors()->all()]);
        }

        // Extract the input parameters
        $companyId = $request->input('company_id');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        // Call a helper function to calculate profit and loss for the company within the date range
        $companyData = calculateCompanyProfitLossInRange($companyId, $fromDate, $toDate);

        return response()->json([
            'msg' => 'success',
            'response' => 'successfully',
            'data' => $companyData,
        ]);
    }
    public function trip_profit_loss_range(Request $request)
    {
        // Validate the request parameters
        $validator = Validator::make($request->all(), [
            'from_date' => 'required|date',
            'to_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'lvl_error', 'response' => $validator->errors()->all()]);
        }

        // Extract the input parameters
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        // Call a helper function to calculate profit and loss statistics for all trips within the date range
        $tripData = calculateTripProfitLossInRange($fromDate, $toDate);

        return response()->json([
            'msg' => 'success',
            'response' => 'successfully',
            'data' => $tripData,
        ]);
    }
    public function project_profit_loss($project_id)
    {
        $projectData = calculateProjectProfitLoss($project_id);

        return response()->json([
            'msg' => 'success',
            'response' => 'successfully',
            'data' => $projectData,
        ]);
    }
    public function driver_profit_loss($driver_id)
    {
        $driverData = calculateDriverProfitLoss($driver_id);

        return response()->json([
            'msg' => 'success',
            'response' => 'successfully',
            'data' => $driverData,
        ]);
    }
    public function company_profit_loss($company_id)
    {
        $companyData = calculateCompanyProfitLoss($company_id);

        return response()->json([
            'msg' => 'success',
            'response' => 'successfully',
            'data' => $companyData,
        ]);
    }
    public function trip_profit_loss($trip_id)
    {
        $profitLossData = calculateTripProfitLoss($trip_id);

        $status = $profitLossData['amount'] >= 0 ? 'profit' : 'loss';
        $amount = abs($profitLossData['amount']);
        $data = [
            'status' => $status,
            'profit/loss amount' => $amount,
            'summary' => isset($profitLossData['summary']) ? $profitLossData['summary'] : null, // Include the summary if available
        ];
        return response()->json([
            'msg' => 'success',
            'response' => 'successfully',
            'data' => $data,
        ]);
    }

    public function diesel_usage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from_date' => 'required|date',
            'to_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'lvl_error', 'response' => $validator->errors()->all()]);
        }

        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');

        // Use Eloquent to query the FuelManagement model
        $usageAndCost = FuelManagement::whereBetween('fuel_datetime', [$from_date, $to_date])
            ->selectRaw('SUM(quantity) as total_diesel_usage, SUM(fuel_cost) as total_fuel_cost')
            ->first();

        return response()->json([
            'msg' => 'success',
            'response' => 'successfully',
            'data' => [
                'total_diesel_usage' => $usageAndCost->total_diesel_usage,
                'total_fuel_cost' => $usageAndCost->total_fuel_cost,
            ],
        ]);
    }
    public function diesel_driver(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'driver_id' => 'required',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'lvl_error', 'response' => $validator->errors()->all()]);
        }

        $driver_id = $request->input('driver_id');
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');

        // Use Eloquent to query the FuelManagement model
        $driverData = FuelManagement::where('driver_id', $driver_id)
            ->whereBetween('fuel_datetime', [$from_date, $to_date])
            ->selectRaw('SUM(quantity) as total_diesel_usage_by_driver, SUM(fuel_cost) as total_fuel_cost_by_driver')
            ->first();

        return response()->json([
            'msg' => 'success',
            'response' => 'successfully',
            'data' => [
                'total_diesel_usage_by_driver' => $driverData->total_diesel_usage_by_driver,
                'total_fuel_cost_by_driver' => $driverData->total_fuel_cost_by_driver,
            ],
        ]);
    }
    public function diesel_vehicle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vehicle_id' => 'required',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'lvl_error', 'response' => $validator->errors()->all()]);
        }

        $vehicle_id = $request->input('vehicle_id');
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');

        // Use Eloquent to query the FuelManagement model
        $vehicleData = FuelManagement::where('vehicle_id', $vehicle_id)
            ->whereBetween('fuel_datetime', [$from_date, $to_date])
            ->selectRaw('SUM(quantity) as total_diesel_usage_by_vehicle, SUM(fuel_cost) as total_fuel_cost_by_vehicle')
            ->first();

        return response()->json([
            'msg' => 'success',
            'response' => 'successfully',
            'data' => [
                'total_diesel_usage_by_vehicle' => $vehicleData->total_diesel_usage_by_vehicle,
                'total_fuel_cost_by_vehicle' => $vehicleData->total_fuel_cost_by_vehicle,
            ],
        ]);
    }
    public function idle_vehicle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from_date' => 'required|date',
            'to_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'lvl_error', 'response' => $validator->errors()->all()]);
        }

        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');

        // Find all vehicles that are not part of any trip during the specified date range
        $idle_vehicles = Vehicle::whereNotIn('id', function ($query) use ($from_date, $to_date) {
            $query->select('vehicle_id')
                ->from('trips')
                ->where(function ($query) use ($from_date, $to_date) {
                    $query->whereBetween('start_date_time', [$from_date, $to_date])
                        ->orWhereBetween('end_date_time', [$from_date, $to_date]);
                });
        })->get();

        return response()->json([
            'msg' => 'success',
            'response' => 'successfully',
            'data' => $idle_vehicles,
        ]);
    }
}
