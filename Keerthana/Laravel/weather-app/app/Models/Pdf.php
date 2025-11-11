<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Pdf extends Model
{
    public static function storePdfDownload($pdf){
        
        $filename = 'Pdfs/resume_' . Str::uuid() . '.pdf';
        $pdfContent = $pdf->output();
        Storage::disk('public')->put($filename, $pdfContent);

        return $pdf->download('Resume.pdf');

    }
}
