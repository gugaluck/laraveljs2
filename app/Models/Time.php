<?php
namespace App\Models;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Time extends Model {
    protected $table = 'tbtime';
    protected $fillable = array('id','nome');
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function listaTimes() {
        return self::all();
    }

    public function getTime($id) {
        $ordem = Self::find($id);
        if (is_null($ordem)) {
            return false;
        }   
        return $ordem;
    }

    public function addTime($request) {
        $input = $request->all();
        $ordem = new Time($input);
        $ordem->save();
        return $ordem;
    }

    public function updateTime($request, $id) {
        $ordem = self::find($id);
        if (is_null($ordem)) {
            return false;
        }
        $input = $request->all();
        $ordem->fill($input);
        $ordem->save();
        return $ordem;
    }

    public function deleteTime($id) {
        $ordem = self::find($id);
        if (is_null($ordem)) {
            return false;
        }
        return $ordem->delete(); 
    }

}