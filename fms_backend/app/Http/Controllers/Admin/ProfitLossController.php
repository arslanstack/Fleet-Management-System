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

class ProfitLossController extends Controller
{
    public function project_profit_loss($project_id)
    {
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
    }
    public function trip_profit_loss($trip_id)
    {
        $profitLossData = calculateTripProfitLoss($trip_id);

        $status = $profitLossData['amount'] >= 0 ? 'profit' : 'loss';

        // Get the absolute value of the amount
        $amount = abs($profitLossData['amount']);

        $data = [
            'status' => $status,
            'amount' => $amount,
            'summary' => isset($profitLossData['summary']) ? $profitLossData['summary'] : null, // Include the summary if available
        ];

        return response()->json([
            'msg' => 'success',
            'response' => 'successfully',
            'data' => $data,
        ]);
    }

    public function diesel_monthly()
    {
    }
    public function diesel_weekly()
    {
    }
    public function diesel_yearly()
    {
    }
    public function diesel_driver($driver_id)
    {
    }
    public function diesel_vehicle($vehicle_id)
    {
    }
    public function idle_vehicle()
    {
    }
}
