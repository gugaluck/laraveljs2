<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Time;
use Illuminate\Support\Facades\DB;
use Log;

class TimeController extends Controller
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

    private $time = null;

    public function __construct(Time $time) {
        $this->time = $time;
    }

    public function listaTimes() {
        DB::connection()->enableQueryLog();
        
        $time = Time::all();
        Log::info(
            DB::getQueryLog()
        );

        return response()->json($time, 200)
                ->header('Content-Type', 'application/json');
    }

    public function detalhe($id) {
        $time = Time::findOrFail($id);
        return view("time.detalhe", ['time' => $time]);
    }

    public function getTime($id) {
        $time = $this->time->getTime($id);
        if (!$time) {
            return response()->json(['response', 'Time não encontrado'], 400)
                ->header('Content-Type', 'application/json');
        }
        return response()->json($time, 200)
            ->header('Content-Type', 'application/json');
    }

    public function addTime(Request $request) {
        response()->json($this->time->addTime($request), 201)
            ->header('Content-Type', 'application/json');
        return redirect('/api/time/formulario');
    }

    public function updateTime(Request $request, $id) {
        $time = $this->time->updateTime($request, $id);
        if (!$time) {
            return response()->json(['response', 'Time não encontrado'], 400)
                ->header('Content-Type', 'application/json');
        }
        return redirect('/api/time/');
    }

    public function deleteTime($id) {
        $time = $this->time->deleteTime($id);
        if (!$time) {
            return response()->json(['response', 'Time não encontrado'], 400)
                ->header('Content-Type', 'application/json');
        }
        return response()->json(['response' => 'Time deletado'], 200)
        ->header('Content-Type', 'application/json');
        //return redirect('/api/time/');
    }

    public function getFormulario () {
        return view('time.cadastro');
    }

    public function update($id) {
        $time = Time::findOrFail($id);
        return view("time.update", ['time' => $time]);
    }
}
