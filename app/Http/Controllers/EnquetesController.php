<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enquete;
class EnquetesController extends Controller
{
    public function nova_enquete(){
        $enquete = new Enquete;
        
    }
}
