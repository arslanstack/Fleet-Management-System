<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admin\Driver;
use App\Models\Admin\Trip;
use Session, Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Mail\MailPayroll;
use PDF;
use Mail;
use CURLFile;

class DriverController extends Controller
{
	public function index()
	{
		$drivers = Driver::orderBy('id', 'DESC')->get();
		return response()->json(array('msg' => 'success', 'response' => 'successfully', 'data' => $drivers));
	}
	public function available()
	{
		// Get the IDs of drivers who are part of incomplete trips
		$driversInIncompleteTrips = Trip::where('status', 0)->pluck('driver_id')->toArray();

		// Get the list of drivers who are not in incomplete trips
		$availableDrivers = Driver::whereNotIn('id', $driversInIncompleteTrips)->get();

		return response()->json([
			'msg' => 'success',
			'response' => 'successfully',
			'data' => $availableDrivers,
		]);
	}
	public function store(Request $request)
	{

		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'phone_no' => 'required',
			'email' => 'required|email|unique:drivers',
			'password' => 'required',
			'nric' => 'required',
			'address' => 'required',
			'dob' => 'required',
			'bank_account_no' => 'required',
			'licence_type' => 'required',
			'driver_status' => 'required',
			'joining_date' => 'required',
			'vehicle_rental_tatus' => 'required',
			'car_plateno' => 'required',
			'diesel_tag' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response' => $validator->errors()->all()));
		}
		$dobDate = new \DateTime($data['dob']);
		$joiningDate = new \DateTime($data['joining_date']);

		if ($joiningDate <= $dobDate) {
			return response()->json(array('msg' => 'lvl_error', 'response' => 'Joining date must be after date of birth.'));
		}
		$image_path1 = '';
		$image_path2 = '';
		$image_path3 = '';
		$image_path4 = '';
		$image_path5 = '';
		if ($request->hasFile('nric_front_side')) {
			$image = $request->file('nric_front_side');
			$file_name = explode('.', $image->getClientOriginalName())[0];
			$nric_front_side = $file_name . '_' . time() . '.' . $image->getClientOriginalExtension();
			$destinationPath = public_path('/assets/upload_images');
			$image->move($destinationPath, $nric_front_side);
			$image_path1 = asset('assets/upload_images') . '/' . $nric_front_side;
		}
		if ($request->hasFile('nric_back_side')) {
			$image = $request->file('nric_back_side');
			$file_name = explode('.', $image->getClientOriginalName())[0];
			$nric_back_side = $file_name . '_' . time() . '.' . $image->getClientOriginalExtension();
			$destinationPath = public_path('/assets/upload_images');
			$image->move($destinationPath, $nric_back_side);
			$image_path2 = asset('assets/upload_images') . '/' . $nric_back_side;
		} else {
		}
		if ($request->hasFile('licence_front_side')) {
			$image = $request->file('licence_front_side');
			$file_name = explode('.', $image->getClientOriginalName())[0];
			$licence_front_side = $file_name . '_' . time() . '.' . $image->getClientOriginalExtension();
			$destinationPath = public_path('/assets/upload_images');
			$image->move($destinationPath, $licence_front_side);
			$image_path3 = asset('assets/upload_images') . '/' . $licence_front_side;
		}
		if ($request->hasFile('licence_back_side')) {
			$image = $request->file('licence_back_side');
			$file_name = explode('.', $image->getClientOriginalName())[0];
			$licence_back_side = $file_name . '_' . time() . '.' . $image->getClientOriginalExtension();
			$destinationPath = public_path('/assets/upload_images');
			$image->move($destinationPath, $licence_back_side);
			$image_path4 = asset('assets/upload_images') . '/' . $licence_back_side;
		}
		if ($request->hasFile('profile_pic')) {
			$image = $request->file('profile_pic');
			$file_name = explode('.', $image->getClientOriginalName())[0];
			$profile_pic = $file_name . '_' . time() . '.' . $image->getClientOriginalExtension();
			$destinationPath = public_path('/assets/upload_images');
			$image->move($destinationPath, $profile_pic);
			$image_path5 = asset('assets/upload_images') . '/' . $profile_pic;
		}
		$query = Driver::create([
			'name' => $data['name'],
			'phone_no' => $data['phone_no'],
			'email' => $data['email'],
			'password' => $data['password'],
			'nric' => $data['nric'],
			'address' => $data['address'],
			'dob' => $data['dob'],
			'bank_account_no' => $data['bank_account_no'],
			'licence_type' => $data['licence_type'],
			'driver_status' => $data['driver_status'],
			'joining_date' => $data['joining_date'],
			'vehicle_rental_tatus' => $data['vehicle_rental_tatus'],
			'car_plateno' => $data['car_plateno'],
			'diesel_tag' => $data['diesel_tag'],

			'nric_front_side' => $image_path1,
			'nric_back_side' => $image_path2,
			'licence_front_side' => $image_path3,
			'licence_back_side' => $image_path4,
			'profile' => $image_path5,
			'created_by' => Auth()->user()->id,
			'created_at' => date('Y-m-d H:i:s')
		]);
		$response_status = $query->id;
		if ($response_status > 0) {
			return response()->json(['msg' => 'success', 'response' => 'Driver successfully added.', 'query' => $query]);
		} else {
			return response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
		}
	}
	public function edit($id, Request $request)
	{
		$driver = Driver::where('id', $id)->first();
		return response()->json(array('msg' => 'success', 'response' => 'successfully', 'data' => $driver));
	}
	public function update(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'phone_no' => 'required',
			'nric' => 'required',
			'address' => 'required',
			'dob' => 'required',
			'bank_account_no' => 'required',
			'licence_type' => 'required',
			'driver_status' => 'required',
			'joining_date' => 'required',
			'vehicle_rental_tatus' => 'required',
			'car_plateno' => 'required',
			'diesel_tag' => 'required',
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response' => $validator->errors()->all()));
		}
		$dobDate = new \DateTime($data['dob']);
		$joiningDate = new \DateTime($data['joining_date']);

		if ($joiningDate <= $dobDate) {
			return response()->json(array('msg' => 'lvl_error', 'response' => 'Joining date must be after date of birth.'));
		}
		if (isset($data['status'])) {
			$status = "1";
		} else {
			$status = "0";
		}
		if ($request->hasFile('nric_front_side')) {
			$image = $request->file('nric_front_side');
			$file_name = explode('.', $image->getClientOriginalName())[0];
			$data['nric_front_side'] = $file_name . '_' . time() . '.' . $image->getClientOriginalExtension();
			$destinationPath = public_path('/assets/upload_images');
			$image->move($destinationPath, $data['nric_front_side']);
			$image_path1 = asset('assets/upload_images') . '/' . $data['nric_front_side'];
			DB::table('drivers')
				->where('id', $data['id'])->update([
					'nric_front_side' => $image_path1
				]);
		}
		if ($request->hasFile('nric_back_side')) {
			$image = $request->file('nric_back_side');
			$file_name = explode('.', $image->getClientOriginalName())[0];
			$data['nric_back_side'] = $file_name . '_' . time() . '.' . $image->getClientOriginalExtension();
			$destinationPath = public_path('/assets/upload_images');
			$image->move($destinationPath, $data['nric_back_side']);
			$image_path2 = asset('assets/upload_images') . '/' . $data['nric_back_side'];
			DB::table('drivers')
				->where('id', $data['id'])->update([
					'nric_back_side' => $image_path2
				]);
		}
		if ($request->hasFile('licence_front_side')) {
			$image = $request->file('licence_front_side');
			$file_name = explode('.', $image->getClientOriginalName())[0];
			$data['licence_front_side'] = $file_name . '_' . time() . '.' . $image->getClientOriginalExtension();
			$destinationPath = public_path('/assets/upload_images');
			$image->move($destinationPath, $data['licence_front_side']);
			$image_path3 = asset('assets/upload_images') . '/' . $data['licence_front_side'];
			DB::table('drivers')
				->where('id', $data['id'])->update([
					'licence_front_side' => $image_path3
				]);
		}
		if ($request->hasFile('licence_back_side')) {
			$image = $request->file('licence_back_side');
			$file_name = explode('.', $image->getClientOriginalName())[0];
			$data['licence_back_side'] = $file_name . '_' . time() . '.' . $image->getClientOriginalExtension();
			$destinationPath = public_path('/assets/upload_images');
			$image->move($destinationPath, $data['licence_back_side']);
			$image_path4 = asset('assets/upload_images') . '/' . $data['licence_back_side'];
			DB::table('drivers')
				->where('id', $data['id'])->update([
					'licence_back_side' => $image_path4
				]);
		}
		if ($request->hasFile('profile_pic')) {
			$image = $request->file('profile_pic');
			$file_name = explode('.', $image->getClientOriginalName())[0];
			$data['profile_pic'] = $file_name . '_' . time() . '.' . $image->getClientOriginalExtension();
			$destinationPath = public_path('/assets/upload_images');
			$image->move($destinationPath, $data['profile_pic']);
			$image_path5 = asset('assets/upload_images') . '/' . $data['profile_pic'];
			DB::table('drivers')
				->where('id', $data['id'])->update([
					'profile' => $image_path5
				]);
		}

		$post_status = Driver::where('id', $data['id'])->update([
			'name' => $data['name'],
			'phone_no' => $data['phone_no'],
			'nric' => $data['nric'],
			'address' => $data['address'],
			'dob' => $data['dob'],
			'bank_account_no' => $data['bank_account_no'],
			'licence_type' => $data['licence_type'],
			'driver_status' => $data['driver_status'],
			'joining_date' => $data['joining_date'],
			'end_date' => $data['end_date'],
			'vehicle_rental_tatus' => $data['vehicle_rental_tatus'],
			'car_plateno' => $data['car_plateno'],
			'diesel_tag' => $data['diesel_tag'],
			'status' => $status,
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => Auth()->user()->id,
		]);

		if ($post_status > 0) {
			$updatedRecord = Driver::find($data['id']);
			return response()->json([
				'msg' => 'success',
				'response' => 'Driver successfully updated!',
				'query' => $updatedRecord, // Include the updated record in the response
			]);
		} else {
			return response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
		}
	}
	public function destroy(Request $request)
	{
		$data = $request->all();
		$status = Driver::where('id', $data['id'])->first();
		if ($status->id) {
			Driver::find($data['id'])->delete();
			return response()->json(['msg' => 'success', 'response' => 'Driver successfully deleted.']);
		} else {
			return response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
		}
	}

	public function salary(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'driver_id' => 'required',
			'salary_amount' => 'required'
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response' => $validator->errors()->all()));
		}
		$query = DB::table('driver_salaries')->insertGetId([
			'driver_id' => $data['driver_id'],
			'salary' => $data['salary_amount'],
			'created_by' => Auth()->user()->id,
			'created_at' => date('Y-m-d H:i:s'),
		]);

		if ($query > 0) {
			return response()->json(['msg' => 'success', 'response' => 'Driver salary successfully added.']);
		} else {
			return response()->json(['msg' => 'error', 'response' => 'Something went wrong!']);
		}
	}

	public function generate_payslip(Request $request)
	{
		$data = $request->all();
		$validator = Validator::make($request->all(), [
			'driver_id' => 'required',
			'notes' => 'required'
		]);
		if ($validator->fails()) {
			return response()->json(array('msg' => 'lvl_error', 'response' => $validator->errors()->all()));
		}

		$current_salary = get_single_row('driver_salaries', 'driver_id', $data['driver_id'], '', '', '', '');
		$data['basic_salary'] = $current_salary->salary;

		$data['allowance_amount'] = get_allowances($data['driver_id']);
		$deductionData = get_deductions($data['driver_id']);
		$data['deduction_amount'] = $deductionData['total_deductions'];
		$data['deduction_summary'] = $deductionData['deduction_summary'];
		$data['net_salary'] = (($data['allowance_amount'] + $data['basic_salary']) - $data['deduction_amount']);

		$query = DB::table('salary_payroll')->insertGetId([
			'driver_id' => $data['driver_id'],
			'basic_salary' => $data['basic_salary'],
			'allowance_amount' => $data['allowance_amount'],
			'deduction_amount' => $data['deduction_amount'],
			'net_salary' => $data['net_salary'],
			'salary_month' => date('Y-m-d'),
			'notes' => $data['notes'],
			'created_by' => Auth()->user()->id,
			'created_at' => date('Y-m-d H:i:s'),
		]);

		$date = \Carbon\Carbon::now();
		$monthYear = $date->format('F Y');


		$driver_details = Driver::where('id', $data['driver_id'])->first();

		$slipdata['monthYear'] = $monthYear;
		$slipdata['name'] = $driver_details->name;
		$slipdata['acc_no'] = substr($driver_details->bank_account_no, -4);
		$slipdata['basic'] = $data['basic_salary'];
		$slipdata['allowance'] = $data['allowance_amount'];
		$slipdata['deduction'] = $data['deduction_amount'];
		$slipdata['deduction_summary'] = $data['deduction_summary'];
		$slipdata['total_earning'] = ($data['allowance_amount'] + $data['basic_salary']);
		$slipdata['net_salary'] = $data['net_salary'];

		$pdf = PDF::loadView('pdf.payroll', $slipdata);
		$pdfPath = 'payslips/' . uniqid() . '.pdf'; // Updated path
		$pdf->save(public_path($pdfPath)); // Save to the public folder

		$mailData["pdf"] = $pdf;
		$mailData['email'] = $driver_details->email;
		$mailData["title"] = "Payslip for " . $monthYear;
		$mailData["body"] = "Please attached find your payslip for " . $monthYear . ".";

		Mail::to($mailData['email'])->send(new MailPayroll($mailData));

		// Prepare data for sending the payslip via WhatsApp
		$recipientPhone = $driver_details->phone_no;
		$senderPhoneId = env('WHATSAPP_SENDER_PHONE_ID');
		$apiToken = env('WHATSAPP_API_TOKEN');
		$pdfLink = asset($pdfPath);

		// Upload the PDF document to WhatsApp server
		$target = public_path($pdfPath); // Updated path
		$mime = mime_content_type($target);

		$file = new CURLFile($target);
		$file->setMimeType($mime);
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://graph.facebook.com/v17.0/".$senderPhoneId."/media",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => array("messaging_product" => "whatsapp", "type" => $mime, "file" => $file),
			CURLOPT_HTTPHEADER => array(
				"Authorization: Bearer " . $apiToken
			),
		));
		$resultWhatsAppMedia = json_decode(curl_exec($curl), true);
		$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

		$MEDIA_OBJECT_ID = $resultWhatsAppMedia['id']; // MEDIA OBJECT ID

		// Prepare the WhatsApp message with the document
		$FileName = "Pay Slip for " . $monthYear;

		$messageBody = [
			"messaging_product" => "whatsapp",
			"recipient_type" => "individual",
			"to" => $recipientPhone, // Replace with the recipient's phone number
			"type" => "document",
			"document" => [
				"id" => $MEDIA_OBJECT_ID,
				"caption" => $FileName,
				"filename" => "Pay_Slip.pdf",
			]
		];

		// Send the WhatsApp message
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://graph.facebook.com/v17.0/'.$senderPhoneId.'/messages',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => json_encode($messageBody),
			CURLOPT_HTTPHEADER => array(
				"Authorization: Bearer " . $apiToken,
				'Content-Type: application/json'
			),
		));
		$response = json_decode(curl_exec($curl), true);
		$status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		curl_close($curl);

		return response()->json(['URL api' => 'https://graph.facebook.com/v17.0/'.$senderPhoneId.'/messages', 'recipientPhone' => $recipientPhone, 'senderPhoneId' => $senderPhoneId, 'apiToken' => $apiToken, 'MEDIA_OBJECT_ID' => $MEDIA_OBJECT_ID, 'response' => $response]);
	}

	
}
