<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Atleta;
use Illuminate\Support\Facades\DB;
use Log;

class AtletaController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //
    }

    private $atleta = null;

    public function __construct(Atleta $atleta) {
        $this->atleta = $atleta;
    }

    public function listaAtletas() {
        DB::connection()->enableQueryLog();
        
  
            $atletas = DB::select('select tbatleta.id,
                                          tbatleta.nome,
                                          tbatleta.peso,
                                          tbatleta.altura,
                                          tbtime.id as time_id,
                                          tbtime.nome as time_nome
                                     from tbatleta
                                     join tbtime
                                       on tbatleta.id_time = tbtime.id');
            Log::info(
                DB::getQueryLog()
            );
            
          
        return response()->json($atletas, 200)
        ->header('Content-Type', 'application/json');
    }

    public function getAtleta($id) {
        $atleta = $this->atleta->getAtleta($id);
        if (!$atleta) {
            return response()->json(['response', 'Atleta não encontrado'], 400)
                ->header('Content-Type', 'application/json');
        }
        return response()->json($atleta, 200)
            ->header('Content-Type', 'application/json');
    }

    public function addAtleta(Request $request) {
        return response()->json($this->atleta->addAtleta($request), 201)
            ->header('Content-Type', 'application/json');
    }

    public function updateAtleta(Request $request, $id) {
        $atleta = $this->atleta->updateAtleta($request, $id);
        if (!$atleta) {
            return response()->json(['response', 'Atleta não encontrado'], 400)
                ->header('Content-Type', 'application/json');
        }
        return response()->json($atleta, 200)
            ->header('Content-Type', 'application/json');
    }

    public function deleteAtleta($id) {
        $atleta = $this->atleta->deleteAtleta($id);
        if (!$atleta) {
            return response()->json(['response', 'Atleta não encontrado'], 400)
                ->header('Content-Type', 'application/json');
        }
        return response()->json(['response' => 'Atleta deletado com sucesso!'], 200)
            ->header('Content-Type', 'application/json');
    }

    public function getFormulario () {
        return view('atleta.cadastro');
    }


    public function update($id) {
        $atleta = Atleta::findOrFail($id);
        return view("atleta.update", ['atleta' => $atleta]);
    }

    public function detalhe($id) {
        $atleta = DB::select('select tbatleta.id,
                                    tbatleta.nome,
                                    tbatleta.peso,
                                    tbatleta.altura,
                                    tbtime.nome as time_nome
                            from tbatleta
                            join tbtime
                                on tbatleta.id_time = tbtime.id
                            where tbatleta.id = '.$id.'');

        return view("atleta.detalhe", ['atleta' => $atleta[0]]);
    }

}
