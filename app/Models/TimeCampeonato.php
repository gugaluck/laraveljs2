<?php
namespace App\Models;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TimeCampeonato extends Model {
    protected $table = 'tbtimecampeonato';
    protected $fillable = array('id', 'timcodigo','camcodigo');
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function listaTimeCampeonatos() {
        return self::all();
    }

    public function getTimeCampeonato($id) {
        $ordem = Self::find($id);
        if (is_null($ordem)) {
            return false;
        }   
        return $ordem;
    }

    public function addTimeCampeonato($request) {
        $input = $request->all();
        $ordem = new TimeCampeonato($input);
        $ordem->save();
        return $ordem;
    }

    public function updateTimeCampeonato($request, $id) {
        $ordem = self::find($id);
        if (is_null($ordem)) {
            return false;
        }
        $input = $request->all();
        $ordem->fill($input);
        $ordem->save();
        return $ordem;
    }

    public function deleteTimeCampeonato($id) {
        $ordem = self::find($id);
        if (is_null($ordem)) {
            return false;
        }
        return $ordem->delete(); 
    }

}