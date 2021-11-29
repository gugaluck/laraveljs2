<?php
namespace App\Models;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Campeonato extends Model {
    protected $table = 'tbcampeonato';
    protected $fillable = array('id','nome');
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function listaCampeonatos() {
        return self::all();
    }

    public function getCampeonato($id) {
        $ordem = Self::find($id);
        if (is_null($ordem)) {
            return false;
        }   
        return $ordem;
    }

    public function addCampeonato($request) {
        $input = $request->all();
        $ordem = new Campeonato($input);
        $ordem->save();
        return $ordem;
    }

    public function updateCampeonato($request, $id) {
        $ordem = self::find($id);
        if (is_null($ordem)) {
            return false;
        }
        $input = $request->all();
        $ordem->fill($input);
        $ordem->save();
        return $ordem;
    }

    public function deleteCampeonato($id) {
        $ordem = self::find($id);
        if (is_null($ordem)) {
            return false;
        }
        return $ordem->delete(); 
    }

}