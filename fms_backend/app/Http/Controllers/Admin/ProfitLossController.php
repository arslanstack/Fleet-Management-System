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
    public function maintenance_report(Request $request)
    {
        // Validate the input parameters
        $validator = Validator::make($request->all(), [
            'from_date' => 'required|date',
            'to_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'lvl_error', 'response' => $validator->errors()->all()]);
        }

        // Retrieve the 'from_date' and 'to_date' from the request
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        // Use Eloquent to query the 'vehicle_maintenance' model
        $maintenanceRecords = VehicleMaintenance::whereBetween('maintenance_date', [$fromDate, $toDate])
            ->get();

        // Calculate the total maintenance cost
        $totalMaintenanceCost = $maintenanceRecords->sum('amount');

        // Create an array to store the individual maintenance records in the date range
        $maintenanceSummary = [];

        // Populate the maintenance summary with individual records
        foreach ($maintenanceRecords as $record) {
            $maintenanceSummary[] = [
                'maintenance_id' => $record->id,
                'maintenance_date' => $record->maintenance_date,
                'amount' => $record->amount,
                'description' => $record->description,
                // Add any other fields you want to include in the summary
            ];
        }

        // Return the maintenance report as a JSON response
        return response()->json([
            'msg' => 'success',
            'response' => 'successfully',
            'data' => [
                'total_maintenance_cost' => $totalMaintenanceCost,
                'maintenance_summary' => $maintenanceSummary,
            ],
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

    public function monthly_dm_driver(Request $request)
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

        // Calculate fuel consumption and total fuel cost using FuelConsumption Model
        $fuelConsumption = FuelManagement::where('driver_id', $driver_id)
            ->whereBetween('fuel_datetime', [$from_date, $to_date])
            ->sum('quantity');

        $totalFuelCost = FuelManagement::where('driver_id', $driver_id)
            ->whereBetween('fuel_datetime', [$from_date, $to_date])
            ->sum('fuel_cost');

        // Calculate maintenance cost and get a summary using VehicleMaintenance Model
        $maintenanceCost = VehicleMaintenance::where('driver_id', $driver_id)
            ->whereBetween('maintenance_date', [$from_date, $to_date])
            ->sum('amount');

        $maintenanceSummary = VehicleMaintenance::where('driver_id', $driver_id)
            ->whereBetween('maintenance_date', [$from_date, $to_date])
            ->get(['id', 'maintenance_date', 'amount', 'description']); // Adjust the fields as needed

        // Calculate fuel consumption summary by grouping records by date
        $fuelConsumptionSummary = FuelManagement::where('driver_id', $driver_id)
            ->whereBetween('fuel_datetime', [$from_date, $to_date])
            ->groupBy('fuel_date')
            ->selectRaw('DATE(fuel_datetime) as fuel_date, SUM(quantity) as total_quantity')
            ->get();

        return response()->json([
            'msg' => 'success',
            'response' => 'Successfully retrieved driver monthly data',
            'data' => [
                'driver_id' => $driver_id,
                'fuel_consumption' => $fuelConsumption,
                'total_fuel_cost' => $totalFuelCost,
                'maintenance_cost' => $maintenanceCost,
                'fuel_consumption_summary' => $fuelConsumptionSummary,
                'maintenance_summary' => $maintenanceSummary,
            ],
        ]);
    }

    public function monthly_dm_vehicle(Request $request)
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

        // Calculate fuel consumption and total fuel cost using FuelManagement Model
        $fuelConsumption = FuelManagement::where('vehicle_id', $vehicle_id)
            ->whereBetween('fuel_datetime', [$from_date, $to_date])
            ->sum('quantity');

        $totalFuelCost = FuelManagement::where('vehicle_id', $vehicle_id)
            ->whereBetween('fuel_datetime', [$from_date, $to_date])
            ->sum('fuel_cost');

        // Calculate maintenance cost and get a summary using VehicleMaintenance Model
        $maintenanceCost = VehicleMaintenance::where('vehicle_id', $vehicle_id)
            ->whereBetween('maintenance_date', [$from_date, $to_date])
            ->sum('amount');

        $maintenanceSummary = VehicleMaintenance::where('vehicle_id', $vehicle_id)
            ->whereBetween('maintenance_date', [$from_date, $to_date])
            ->get(['id', 'maintenance_date', 'amount', 'description']); // Adjust the fields as needed

        // Calculate fuel consumption summary by grouping records by date
        $fuelConsumptionSummary = FuelManagement::where('vehicle_id', $vehicle_id)
            ->whereBetween('fuel_datetime', [$from_date, $to_date])
            ->groupBy(DB::raw('DATE(fuel_datetime)'))
            ->selectRaw('DATE(fuel_datetime) as fuel_date, SUM(quantity) as total_quantity')
            ->get();

        return response()->json([
            'msg' => 'success',
            'response' => 'Successfully retrieved vehicle monthly data',
            'data' => [
                'vehicle_id' => $vehicle_id,
                'fuel_consumption' => $fuelConsumption,
                'total_fuel_cost' => $totalFuelCost,
                'maintenance_cost' => $maintenanceCost,
                'fuel_consumption_summary' => $fuelConsumptionSummary,
                'maintenance_summary' => $maintenanceSummary,
            ],
        ]);
    }
}
