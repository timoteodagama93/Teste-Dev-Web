<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Enquete;
use App\Resposta;

class RespostasController extends Controller
{
    public function apagar_resposta($resposta_id)
    {
        /*
        TODO: DELEÇÂO/DELETAR/APAGAR/13:07 min
        DB::table('enquetes')->where('id', '=', $enquete_id)->delete();*/
        $deletado = Resposta::where('id', $resposta_id)->delete();
        return response()->json($deletado);
    }
}