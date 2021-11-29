<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\TimeCampeonato;
use Illuminate\Support\Facades\DB;
use Log;

class TimeCampeonatoController extends Controller
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

    private $timecampeonato = null;

    public function __construct(TimeCampeonato $timecampeonato) {
        $this->timecampeonato = $timecampeonato;
    }

    public function listaTimeCampeonatos() {
        DB::connection()->enableQueryLog();
        

            $time_c =   DB::select('select tbtimecampeonato.id,
                                            tbcampeonato.id as campeonato_id,
                                            tbcampeonato.nome as campeonato_nome,
                                            tbtime.id as time_id,
                                            tbtime.nome as time_nome
                                    from tbtimecampeonato
                                    join tbtime
                                        on tbtimecampeonato.timcodigo = tbtime.id
                                    join tbcampeonato
                                        on tbtimecampeonato.camcodigo = tbcampeonato.id');
            Log::info(
                DB::getQueryLog()
            );
            
            return response()->json($time_c, 200)
            ->header('Content-Type', 'application/json');
      
    }

    public function getCampeonato($id) {
        $timecampeonato = $this->timecampeonato->getTimeCampeonato($id);
        if (!$timecampeonato) {
            return response()->json(['response', 'Time x Campeonato não encontrado'], 400)
                ->header('Content-Type', 'application/json');
        }
        return response()->json($timecampeonato, 200)
            ->header('Content-Type', 'application/json');
    }

    public function addTimeCampeonato(Request $request) {
        response()->json($this->timecampeonato->addTimeCampeonato($request), 201)
            ->header('Content-Type', 'application/json');
        return redirect('/api/timecampeonato/formulario');
    }

    public function updateTimeCampeonato(Request $request, $id) {
        $timecampeonato = $this->timecampeonato->updateTimeCampeonato($request, $id);
        if (!$timecampeonato) {
            return response()->json(['response', 'Time x jogo não encontrado'], 400)
                ->header('Content-Type', 'application/json');
        }
        return response()->json($timecampeonato, 200)
            ->header('Content-Type', 'application/json');
    }

    public function deleteTimeCampeonato($id) {
        $timecampeonato = $this->timecampeonato->deleteTimeCampeonato($id);
        if (!$timecampeonato) {
            return response()->json(['response', 'Time x Campeonato não encontrado'], 400)
                ->header('Content-Type', 'application/json');
        }
        return response()->json(['response' => 'Time x Campeonato deletado com sucesso!'], 200)
            ->header('Content-Type', 'application/json');
    }

    public function detalhe($id) {
        $time_c =   DB::select('select tbtimecampeonato.id,
                                        tbcampeonato.nome as campeonato_nome,
                                        tbtime.nome as time_nome
                                from tbtimecampeonato
                                join tbtime
                                    on tbtimecampeonato.timcodigo = tbtime.id 
                                join tbcampeonato
                                    on tbtimecampeonato.camcodigo = tbcampeonato.id  where tbtimecampeonato.id = '.$id);

        return view("time_campeonato.detalhe", ['time_campeonato' => $time_c[0]]);
    }

    public function getFormulario () {
        return view('time_campeonato.cadastro');
    }

    public function update($id) {
        $campeonato = TimeCampeonato::findOrFail($id);
        return view("time_campeonato.update", ['time_campeonato' => $tcampeonato]);
    }
}
