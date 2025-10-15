<?php

namespace App\Http\Controllers;

use App\Http\Resources\PdfResource;
use Illuminate\Http\Request;
// use PDF;
use App\Models\Pdf as PdfModel;
use Barryvdh\DomPDF\Facade\Pdf;
// use Barryvdh\DomPDF\PDF;

class PdfController extends Controller
{
    public function createPdf(Request $request){

        // $data = new  PdfResource($request->all());
        $data = config('resume');

        $pdf = PDF::loadView('Pdf.pdf', ['data' => $data]);
        return PdfModel::storePdfDownload($pdf);

    }
}
