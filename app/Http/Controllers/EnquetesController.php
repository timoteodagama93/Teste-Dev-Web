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
        $user = auth()->user();
        $id = auth()->user()->id;

        $enquete->id_usuario = $id;
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
    public function listar_enquetes()
    {
        $user = auth()->user();
        $id = auth()->user()->id;
        $enquetes = Enquete::where('id_usuario', $id)->paginate();;

        return response()->json($enquetes);
    }
    public function editar_enquete($enquete_id)
    {
        $saida = array_merge(array('enquete' => Enquete::find($enquete_id)), Resposta::where('enquete_id', $enquete_id)->get());

        $saida = response()->json($saida);
    }
}
