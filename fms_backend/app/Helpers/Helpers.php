<?php

use Carbon\Carbon;
use App\Models\Admin\Role;

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
		$year = date('Y');
		$month = date('m');
		$query = DB::table('driver_deductions');
		$query->where('driver_id', $driver_id);
		$query->whereYear('effective_date', '=', $year);
		$query->whereMonth('effective_date', '=', $month);
		$data = $query->sum('amount');
		return $data;
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



