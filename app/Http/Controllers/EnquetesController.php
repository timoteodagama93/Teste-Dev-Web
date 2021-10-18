<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enquete;
use App\Resposta;

class EnquetesController extends Controller
{
    public function nova_enquete()
    {
        $enquete = new Enquete();

        $enquete->nome = request()->nome_enquete;
        $enquete->resposta = request()->resposta;
        $enquete->save();
        for ($i = 0; $i < 2; $i++) {
            $resposta = new Resposta();
            $resposta->enquete_id = $enquete->id;
            $resposta->alternativa1 = request()->alternativa_1;
            $resposta->alternativa2 = request()->alternativa_2;
            $resposta->save();
        }
        return 'ok';
    }
}
