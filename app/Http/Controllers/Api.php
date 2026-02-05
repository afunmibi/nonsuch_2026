<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Enrolment; // Adjust to your actual model name
use Illuminate\Http\Request;

class EnrolmentController extends Controller
{
    public function showByPolicy($policy_no)
    {
        // We use urldecode in case there are slashes or special characters in the policy number
        $policy_no = urldecode($policy_no);

        $enrolment = Enrolment::where('policy_no', $policy_no)->first();

        if (!$enrolment) {
            return response()->json(['message' => 'Policy not found'], 404);
        }

        // Ensure the keys here match the 'enrolment.xxx' keys in your Alpine.js code
        return response()->json([
            'full_name'    => $enrolment->full_name,
            'phone_no'     => $enrolment->phone_no,
            'dob'          => $enrolment->dob, // Format: YYYY-MM-DD for the date input
            'package_code' => $enrolment->package_code,
            'pry_hcp'      => $enrolment->pry_hcp,
            'sec_hcp'      => $enrolment->secondary_hcp,
        ]);
    }
}
