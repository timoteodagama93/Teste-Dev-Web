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

    public function listar_enquetes()
    {
        //$enquetes = Enquete::select('nome, created_at')->paginate();
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
    public function guardar_enquete()
    {
        $enquete_id = request()->enquete_id; 
        $nome       = request()->nome_enquete;
        $enquete = Enquete::find($enquete_id);
        $enquete->nome = $nome;
        $enquete->save();
        return 'Ok';
    }

    public function respondendo_enquete()
    {
        $enquete_id = request()->enquete_id; 
        $opcao       = request()->opcao_respondida;
        $enquete = Enquete::find($enquete_id);
        $resposta_certa = $enquete->resposta;

        $enquete->tentativas = $enquete->tentativas +1;
        if($resposta_certa == $opcao){
            $enquete->acertos = $enquete->acertos +1;
            $enquete->save();
            return response()->json(array(
                'resposta_certa'
            ));
        }
        $enquete->erros = $enquete->erros +1;
        $enquete->save();
        return response()->json(array(
            'resposta_errada'
        ));
    }

    public function apagar_enquete($enquete_id)
    {
        /*
        TODO: DELE????O/DELETAR/APAGAR/13:07 min
        DB::table('enquetes')->where('id', '=', $enquete_id)->delete();*/
        $deletado = Enquete::where('id', $enquete_id)->delete();
        return response()->json($deletado);
    }
}
