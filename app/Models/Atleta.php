<?php
namespace App\Models;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Atleta extends Model {
    protected $table = 'tbatleta';
    protected $fillable = array('id','nome', 'peso', 'altura', 'id_time');
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function listaAtletas() {
        return self::all();
    }

    public function getAtleta($id) {
        $ordem = Self::find($id);
        if (is_null($ordem)) {
            return false;
        }   
        return $ordem;
    }

    public function addAtleta($request) {
        $input = $request->all();
        $ordem = new Atleta($input);
        $ordem->save();
        return $ordem;
    }

    public function updateAtleta($request, $id) {
        $ordem = self::find($id);
        if (is_null($ordem)) {
            return false;
        }
        $input = $request->all();
        $ordem->fill($input);
        $ordem->save();
        return $ordem;
    }

    public function deleteAtleta($id) {
        $ordem = self::find($id);
        if (is_null($ordem)) {
            return false;
        }
        return $ordem->delete(); 
    }

}