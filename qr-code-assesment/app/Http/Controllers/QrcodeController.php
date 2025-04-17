<?php

namespace App\Http\Controllers;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;

class QrcodeController extends Controller
{
   public function show(Request $request)
   {
      $string = $request->text;
      $imageData = QrCode::generate($string);
      return response($imageData);
   }
}
