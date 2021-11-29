<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Campeonato;
use Illuminate\Support\Facades\DB;
use Log;
   
class CampeonatoController extends Controller
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

    private $campeonato = null;

    public function __construct(Campeonato $campeonato) {
        $this->campeonato = $campeonato;
    }

    public function listaCampeonatos() {
        DB::connection()->enableQueryLog();
        
        $campeonato = Campeonato::all();
        Log::info(
            DB::getQueryLog()
        );

        return response()->json($campeonato, 200)
                ->header('Content-Type', 'application/json');
    }

    public function getCampeonato($id) {
        $campeonato = $this->campeonato->getCampeonato($id);
        if (!$campeonato) {
            return response()->json(['response', 'Campeonato não encontrado'], 400)
                ->header('Content-Type', 'application/json');
        }
        return response()->json($campeonato, 200)
            ->header('Content-Type', 'application/json');
    }

    public function addCampeonato(Request $request) {
        response()->json($this->campeonato->addCampeonato($request), 201)->header('Content-Type', 'application/json');
        return redirect('/api/campeonato/formulario');
    }

    public function updateCampeonato(Request $request, $id) {
        $campeonato = $this->campeonato->updateCampeonato($request, $id);
        if (!$campeonato) {
            return response()->json(['response', 'Campeonato não encontrado'], 400)
                ->header('Content-Type', 'application/json');
        }
        return response()->json($campeonato, 200)
            ->header('Content-Type', 'application/json');
    }

    public function deleteCampeonato($id) {
        $campeonato = $this->campeonato->deleteCampeonato($id);
        if (!$campeonato) {
            return response()->json(['response', 'jogo não encontrado'], 400)
                ->header('Content-Type', 'application/json');
        }
        return response()->json(['response' => 'jogo deletado'], 200)
            ->header('Content-Type', 'application/json');
    }

    public function detalhe($id) {
        $campeonato = Campeonato::findOrFail($id);
        return view("campeonato.detalhe", ['campeonato' => $campeonato]);
    }

    public function getFormulario () {
        return view('campeonato.cadastro');
    }

    public function update($id) {
        $campeonato = Campeonato::findOrFail($id);
        return view("campeonato.update", ['campeonato' => $campeonato]);
    }
}
