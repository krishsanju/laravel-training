<?php

namespace App\Http\Controllers;

use App\Models\SendPdf;
use Illuminate\Http\Request;
use App\Http\Responses\ApiResponse;

class SendPdfController extends Controller
{
    public function sendMailWithPdf(Request $request){
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->input('email');

        SendPdf::grabPdfSendMail($email);

        return ApiResponse::setMessage('Mail sent successfully to '.$email)->retrunResponse(200);
    }
}
