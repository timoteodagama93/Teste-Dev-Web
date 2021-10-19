<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Enquete;
use App\Resposta;

class EnquetesController extends Controller
{
    public function nova_enquete()
    {
        $enquete = new Enquete();
        $user = auth()->user();
        $id = auth()->user()->id;

        $enquete->id_usuario = $id;
        $enquete->nome = request()->nome_enquete;
        $enquete->resposta = request()->resposta;
        $enquete->save();
        for ($i = 0; $i < 2; $i++) {
            $resposta = new Resposta();
            $resposta->enquete_id = $enquete->id;
            if ($i == 0)
                $resposta->alternativa = request()->alternativa_1;
            if ($i == 1)
                $resposta->alternativa = request()->alternativa_2;
            $resposta->save();
        }
        return 'ok';
    }

    public function nova_alternativa()
    {
        $num_alternativas = request()->num_respostas;
        $resposta = new Resposta();
        $resposta->enquete_id = request()->enquete_id;
        if ($num_alternativas == 2)
            $resposta->alternativa = request()->nova_alternativa;

        $resposta->save();

        return 'ok';
    }

    public function listar_enquetes()
    {
        $enquetes = Enquete::paginate();;
        return response()->json($enquetes);
    }
    public function user_enquetes()
    {
        $id = auth()->user()->id;
        $enquetes = Enquete::where('id_usuario', $id)->paginate();
        return response()->json($enquetes);
    }
    public function editar_enquete($enquete_id)
    {
        $enquete = Enquete::find($enquete_id);
        return response()->json($enquete);
    }
    public function respostas_enquete($enquete_id)
    {
        $respostas = DB::table('respostas')->where('enquete_id', '=', $enquete_id)->get();
        return response()->json($respostas);
    }
}
