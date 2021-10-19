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
        $enquete_id = Resposta::find($resposta_id)->enquete_id;
        $enquete = Enquete::find($enquete_id);
        $num_respostas = $enquete->num_respostas;
        $enquete->num_respostas = $num_respostas - 1;
        if ($num_respostas > 2 && $enquete->save()) {
            $deletado = Resposta::where('id', $resposta_id)->delete();
            if ($num_respostas == 3 && ($enquete->resposta != '1' && $enquete->respost != '2')) {
                $enquete->resposta = '1';
            }
            return response()->json($deletado);
        }
        return 'Não apagado!';
    }

    public function nova_alternativa()
    {
        $num_alternativas = request()->num_respostas;
        if ($num_alternativas < 10) {
            $enquete_id = request()->enquete_id;
            $resposta_certa = request()->opcao_certa;
            $resposta = new Resposta();
            $enquete = Enquete::find($enquete_id);
            $enquete->num_respostas = $num_alternativas + 1;

            if ($resposta_certa == 'true') {
                $enquete->resposta = $num_alternativas + 1;
            }
            $resposta->enquete_id = $enquete_id;
            $resposta->alternativa = request()->nova_alternativa;
            if ($resposta->save()) {
                $enquete->save();
                return 'Ok=> Alternativas: ' . ($num_alternativas + 1);
            }
        }
        return 'Alternativas';
    }


    public function respostas_enquete($enquete_id)
    {
        $respostas = DB::table('respostas')->where('enquete_id', '=', $enquete_id)->get();
        return response()->json($respostas);
    }
}
