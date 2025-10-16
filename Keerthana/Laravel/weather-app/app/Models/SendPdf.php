<?php

namespace App\Models;

use App\Events\SendResumeMailEvent;
use App\Http\Responses\ApiResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;

class SendPdf extends Model
{
    public static function grabPdfSendMail($email){
        $files = File::files(storage_path('app\public\Pdfs'));
        if (empty($files)) {
            return ApiResponse::setMessage('No files found in the public storage.')->retrunResponse(404);
        }
        $firstPdf = $files[0]->getRealPath();


        event(new SendResumeMailEvent($email, $firstPdf));
    }
}
