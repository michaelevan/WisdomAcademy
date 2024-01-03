<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subjek extends Model
{
    // use HasFactory;
    protected $table = "subjek";
    protected $primaryKey = "id_subjek";
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable =[
        'id_subjek',
        'nama_subjek',
    ];

    function tambahSubjek($param) {
        $subjek = new Subjek();
        $subjek->nama_subjek = $param->nama_subjek;
        $subjek->status = 1;
        $subjek->save();
        return $param;
    }

    function deleteSubjek($param) {
        $status = Subjek::where('id_subjek', $param->idSubjek)->value('status');
        if ($status == 1) {
            Subjek::where('id_subjek', $param->idSubjek)->update([
                "status" => 0,
            ]);
        }
        else{
            Subjek::where('id_subjek', $param->idSubjek)->update([
                "status" => 1,
            ]);
        }
        return $param;
    }
}
