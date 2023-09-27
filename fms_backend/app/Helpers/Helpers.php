<?php

use Carbon\Carbon;
use App\Models\Admin\Role;
use Illuminate\Support\Facades\DB;

if (!function_exists('admin_url')) {
	function admin_url()
	{
		return url('admin');
	}
}

if (!function_exists('formated_date')) {
	function formated_date($datee)
	{
		return date("d/m/Y", strtotime($datee));
	}
}
if (!function_exists('date_formated')) {
	function date_formated($datee)
	{
		return date("d-m-Y", strtotime($datee));
	}
}
if (!function_exists('date_with_month')) {
	function date_with_month($datee)
	{
		return date("F d, Y", strtotime($datee));
	}
}
if (!function_exists('db_date')) {
	function db_date($datee)
	{
		return date("Y-m-d", strtotime($datee));
	}
}
if (!function_exists('js_date_formate')) {
	function js_date_formate()
	{
		return "dd/mm/yyyy";
	}
}
if (!function_exists('date_time')) {
	function date_time($time)
	{
		return $newDateTime = formated_date($time) . " " . date('h:i A', strtotime($time));
	}
}

if (!function_exists('month_date_time')) {
	function month_date_time($time)
	{
		return $newDateTime = date_with_month($time) . " " . date('h:i A', strtotime($time));
	}
}

if (!function_exists('get_complete_table')) {
	function get_complete_table($table = '', $primary_key = '', $where_value = '', $type = '', $status = '', $orderby = '', $sorted = '')
	{
		$query = DB::table($table);
		if ($primary_key) {
			$query->where($primary_key, $where_value);
		}
		if ($type) {
			$query->where('type', $type);
		}
		if ($status) {
			$query->where('status', $status);
		}
		if ($sorted) {
			$query->orderBy($orderby, $sorted);
		} else {
			$query->orderBy('id', 'DESC');
		}
		$data = $query->get();
		return $data;
	}
}

if (!function_exists('get_single_value')) {
	function get_single_value($table, $value, $id)
	{
		$query = DB::table($table)
			->select($value)
			->where('id', $id)
			->first();
		return $query->$value;
	}
}

if (!function_exists('get_section_content')) {
	function get_section_content($meta_tag, $meta_key)
	{
		$query = DB::table('settings')
			->select('meta_value')
			->where('meta_tag', $meta_tag)
			->where('meta_key', $meta_key)
			->first();
		return $query->meta_value;
	}
}

if (!function_exists('permanently_deleted')) {
	function permanently_deleted($table, $primary_key, $where_id)
	{
		$query = DB::table($table)->where($primary_key, $where_id)->delete();
		return true;
	}
}

if (!function_exists('softly_deleted')) {
	function softly_deleted($table, $primary_key, $where_id, $set_column, $value)
	{
		$query = DB::table($table)
			->where($primary_key, $where_id)
			->update([
				$set_column => $value
			]);
		return $query;
	}
}

if (!function_exists('get_single_row')) {
	function get_single_row($table, $primary_key, $where_id, $primary_key2 = '', $where_id2 = '', $type = '', $type_value = '')
	{
		$query = DB::table($table);
		$query->where($primary_key, $where_id);
		if ($primary_key2) {
			$query->where($primary_key2, $where_id2);
		}
		if ($type) {
			$query->where($type, $type_value);
		}
		$query->orderBy('id', 'DESC');
		$data = $query->first();
		return $data;
	}
}

if (!function_exists('get_deductions')) {
	function get_deductions($driver_id)
	{
		// $year = date('Y');
		// $month = date('m');
		// $query = DB::table('driver_deductions');
		// $query->where('driver_id', $driver_id);
		// $query->whereYear('effective_date', '=', $year);
		// $query->whereMonth('effective_date', '=', $month);
		// $data = $query->sum('amount');
		// return $data;

		$year = date('Y');
		$month = date('m');

		$deductions = DB::table('driver_deductions')
			->where('driver_id', $driver_id)
			->whereYear('effective_date', '=', $year)
			->whereMonth('effective_date', '=', $month)
			->where('amount', '>', 0) // Only select deductions with a non-zero amount
			->get();

		$totalDeductions = 0;
		$deductionSummary = [];

		foreach ($deductions as $deduction) {
			$installmentMonths = $deduction->installment_months;
			$paidMonths = $deduction->paid_months;
			$remainingAmount = $deduction->remaining_amount;
			$paidAmount = $deduction->paid_amount;

			if ($paidMonths < $installmentMonths) {
				$installmentAmount = $remainingAmount / ($installmentMonths - $paidMonths);
				$totalDeductions += $installmentAmount;

				// Update the deduction columns
				$paidMonths += 1;
				$paidAmount += $installmentAmount;
				$remainingAmount -= $installmentAmount;

				// $remainingAmount == 0 ? $deductionStatus = 1 : $deductionStatus = 0;

				// Update the deduction record in the database
				DB::table('driver_deductions')
					->where('id', $deduction->id)
					->update([
						'paid_months' => $paidMonths,
						'paid_amount' => $paidAmount,
						'remaining_amount' => $remainingAmount,
					]);

				// Add deduction details to the summary
				$deductionSummary[] = [
					'deduction_description' => $deduction->description,
					'current_month' => $paidMonths,
					'total_months' => $installmentMonths,
					'total_amount' => $deduction->amount,
					'amount_for_installment' => $installmentAmount,
					'remaining_amount' => $remainingAmount,
				];
			}
		}

		return [
			'total_deductions' => $totalDeductions,
			'deduction_summary' => $deductionSummary,
		];
	}
}

if (!function_exists('get_installment_report')) {
	function get_installment_report($deduction_id)
	{
		// Get the deduction information
		$deduction = DB::table('driver_deductions')->where('id', $deduction_id)->first();

		// Check if the deduction exists
		if (!$deduction) {
			return null; // Return null if deduction not found
		}

		$installmentReport = [];

		$installmentMonths = $deduction->installment_months;
		$paidMonths = $deduction->paid_months;
		$remainingAmount = $deduction->remaining_amount;
		$totalAmount = $deduction->amount;

		for ($i = 1; $i <= $installmentMonths; $i++) {
			$installmentAmount = $totalAmount / $installmentMonths;

			if ($i <= $paidMonths) {
				$amountPaid = $installmentAmount;
				$amountLeft = 0;
				$paid = true;
			} else {
				$amountPaid = 0;
				$amountLeft = $installmentAmount;
				$paid = false;
			}

			$installmentReport[] = [
				'month' => $i,
				'paid' => $paid,
				'amount_paid' => $amountPaid,
				'remaining_amount' => $totalAmount - ($installmentAmount * $i),
			];
		}

		// Filter out unpaid months
		$installmentReport = array_filter($installmentReport, function ($item) {
			return $item['paid'];
		});

		return $installmentReport;
	}
}

if (!function_exists('get_allowances')) {
	function get_allowances($driver_id)
	{
		$query = DB::table('driver_allowances');
		$query->where('driver_id', $driver_id);
		$data = $query->sum('amount');
		return $data;
	}
}

if (!function_exists('get_photos')) {
	function get_photos($table, $user_id, $type, $status)
	{
		$query = DB::table($table);
		$query->where('user_id', $user_id);
		$query->where('type', $type);
		$query->whereIn('status', $status);
		$query->orderBy('id', 'DESC');
		$data = $query->get();
		return $data;
	}
}

if (!function_exists('add_login_logs')) {
	function add_login_logs($id)
	{
		DB::table('user_login_logs')->insertGetId([
			'user_id' => $id,
			'ip' => request()->ip(),
			'login_time' => date('Y-m-d H:i:s'),
			'created_at' => date('Y-m-d H:i:s')
		]);

		$query = DB::table('users')
			->where('id', $id)
			->update([
				'last_login' => date('Y-m-d H:i:s')
			]);
		return true;
	}
}

if (!function_exists('update_login_logs')) {
	function update_login_logs($id)
	{
		$last_id = DB::table('user_login_logs')->where('user_id', $id)->orderBy('id', 'DESC')->first();

		$query = DB::table('user_login_logs')
			->where('id', $last_id->id)
			->update([
				'logout_time' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s')
			]);
		return true;
	}
}

if (!function_exists('hasPermission')) {
	function hasPermission($user, $permission)
	{
		$roleType = $user->role_type;
		$role = Role::where('id', $roleType)->first();
		if (!$role) {
			return false;
		}
		$permissionsString = $role->permissions;
		$role->permissions = explode(', ', $permissionsString);
		return in_array($permission, $role->permissions);
	}
}
if (!function_exists('calculateTripProfitLoss')) {
	function calculateTripProfitLoss($trip_id)
	{
		$trip = DB::table('trips')->where('id', $trip_id)->first();

		// Get refuelings for the trip
		$refuelings = DB::table('fuel_management')->where('trip_id', $trip_id)->get();

		// Calculate the total refueling cost for the trip and create refuelment breakdown
		$totalRefuelingCost = 0;
		$refuelmentBreakdown = [];
		foreach ($refuelings as $refueling) {
			$totalRefuelingCost += $refueling->fuel_cost;
			$refuelmentBreakdown[] = [
				'id' => $refueling->id,
				'driver_id' => $refueling->driver_id,
				'vehicle_id' => $refueling->vehicle_id,
				'fuel_cost' => $refueling->fuel_cost,
				'location' => $refueling->location,
			];
		}

		// Get maintenances for the trip
		$maintenances = DB::table('vehicle_maintenance')->where('trip_id', $trip_id)->get();

		// Calculate the total maintenance cost for the trip and create maintenance breakdown
		$totalMaintenanceCost = 0;
		$maintenanceBreakdown = [];
		foreach ($maintenances as $maintenance) {
			$totalMaintenanceCost += $maintenance->amount;
			$maintenanceBreakdown[] = [
				'id' => $maintenance->id,
				'driver_id' => $maintenance->driver_id,
				'vehicle_id' => $maintenance->vehicle_id,
				'amount' => $maintenance->amount,
			];
		}

		// Calculate the trip fee
		$tripFee = $trip->amount;

		// Calculate the profit or loss amount for the trip
		$amount = $tripFee - ($totalRefuelingCost + $totalMaintenanceCost);

		// Create a summary array
		$summary = [
			'trip_id' => $trip_id,
			'project_id' => $trip->project_id,
			'driver_id' => $trip->driver_id,
			'trip_from_location' => $trip->from_location,
			'trip_end_location' => $trip->end_location,
			'trip_distance' => $trip->distance,
			'trip_start_date_time' => $trip->start_date_time,
			'trip_start_date_time' => $trip->start_date_time,
			'trip_fee' => $tripFee,
			'refuelment_cost' => $totalRefuelingCost,
			'refuelment_breakdown' => $refuelmentBreakdown,
			'maintenance_cost' => $totalMaintenanceCost,
			'maintenance_breakdown' => $maintenanceBreakdown,
		];

		return [
			'amount' => $amount,
			'summary' => $summary,
		];
	}
}
if (!function_exists('calculateDriverProfitLoss')) {
	function calculateDriverProfitLoss($driver_id)
	{
		// Initialize variables to store overall statistics
		$overallStatus = 'profit';
		$overallAmount = 0;
		$overallSummary = [];
		$totalDistance = 0;
		$totalFuelConsumption = 0;

		// Get all trips made by the driver
		$trips = DB::table('trips')->where('driver_id', $driver_id)->get();

		// Iterate through each trip
		foreach ($trips as $trip) {
			// Calculate profit or loss for the trip using the existing helper function
			$tripData = calculateTripProfitLoss($trip->id);
			$tripStatus = $tripData['amount'] >= 0 ? 'profit' : 'loss';
			$tripAmount = abs($tripData['amount']);

			// Update overall statistics
			$overallAmount += $tripAmount;
			$totalDistance += $trip->distance;
			$totalFuelConsumption += $tripData['summary']['refuelment_cost'];

			// Create a summary for the trip and add it to the overall summary
			$tripSummary = [
				'trip_id' => $trip->id,
				'trip_status' => $tripStatus,
				'trip_amount' => $tripAmount,
				'trip_summary' => $tripData['summary'],
			];
			$overallSummary[] = $tripSummary;

			// Update overall status (if any trip is a loss, overall status will be a loss)
			if ($tripStatus === 'loss') {
				$overallStatus = 'loss';
			}
		}

		// Create the overall summary
		$driverSummary = [
			'driver_id' => $driver_id,
			'overall_status' => $overallStatus,
			'overall_profit/loss_amount' => $overallAmount,
			'total_distance' => $totalDistance,
			'total_fuel_consumption' => $totalFuelConsumption,
			'overall_summary' => $overallSummary,
		];

		return $driverSummary;
	}
}

if (!function_exists('calculateProjectProfitLoss')) {
    function calculateProjectProfitLoss($project_id)
    {
        // Initialize variables to store overall statistics for the project
        $overallStatus = 'profit';
        $overallAmount = 0;
        $overallSummary = [];
        $totalDistance = 0;
        $totalFuelConsumption = 0;

        // Get all trips associated with the project
        $trips = DB::table('trips')->where('project_id', $project_id)->get();

        // Iterate through each trip
        foreach ($trips as $trip) {
            // Calculate profit or loss for the trip using the existing helper function
            $tripData = calculateTripProfitLoss($trip->id);
            $tripStatus = $tripData['amount'] >= 0 ? 'profit' : 'loss';
            $tripAmount = abs($tripData['amount']);

            // Update overall statistics
            $overallAmount += $tripAmount;
            $totalDistance += $trip->distance;
            $totalFuelConsumption += $tripData['summary']['refuelment_cost'];

            // Create a summary for the trip and add it to the overall summary
            $tripSummary = [
                'trip_id' => $trip->id,
                'trip_status' => $tripStatus,
                'trip_amount' => $tripAmount,
                'trip_summary' => $tripData['summary'],
            ];
            $overallSummary[] = $tripSummary;

            // Update overall status (if any trip is a loss, overall status will be a loss)
            if ($tripStatus === 'loss') {
                $overallStatus = 'loss';
            }
        }

        // Create the overall summary for the project
        $projectSummary = [
            'project_id' => $project_id,
            'overall_status' => $overallStatus,
            'overall_profit/loss_amount' => $overallAmount,
            'total_distance' => $totalDistance,
            'total_fuel_consumption' => $totalFuelConsumption,
            'overall_summary' => $overallSummary,
        ];

        return $projectSummary;
    }
}
if (!function_exists('calculateCompanyProfitLoss')) {
    function calculateCompanyProfitLoss($company_id)
    {
        // Initialize variables to store overall statistics for the company
        $overallStatus = 'profit';
        $overallAmount = 0;
        $overallSummary = [];
        $totalDistance = 0;
        $totalFuelConsumption = 0;

        // Get all trips associated with the company
        $trips = DB::table('trips')->where('company_id', $company_id)->get();

        // Iterate through each trip
        foreach ($trips as $trip) {
            // Calculate profit or loss for the trip using the existing helper function
            $tripData = calculateTripProfitLoss($trip->id);
            $tripStatus = $tripData['amount'] >= 0 ? 'profit' : 'loss';
            $tripAmount = abs($tripData['amount']);

            // Update overall statistics
            $overallAmount += $tripAmount;
            $totalDistance += $trip->distance;
            $totalFuelConsumption += $tripData['summary']['refuelment_cost'];

            // Create a summary for the trip and add it to the overall summary
            $tripSummary = [
                'trip_id' => $trip->id,
                'trip_status' => $tripStatus,
                'trip_amount' => $tripAmount,
                'trip_summary' => $tripData['summary'],
            ];
            $overallSummary[] = $tripSummary;

            // Update overall status (if any trip is a loss, overall status will be a loss)
            if ($tripStatus === 'loss') {
                $overallStatus = 'loss';
            }
        }

        // Create the overall summary for the company
        $companySummary = [
            'company_id' => $company_id,
            'overall_status' => $overallStatus,
            'overall_profit/loss_amount' => $overallAmount,
			'total_distance' => $totalDistance,
            'total_fuel_consumption' => $totalFuelConsumption,
            'overall_summary' => $overallSummary,
        ];

        return $companySummary;
    }
}