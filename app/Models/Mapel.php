<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    // use HasFactory;
    protected $table = "mapel";
    protected $primaryKey = "id_mapel";
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable =[
        'id_mapel',
        'nama_mapel',
        'kkm',
    ];

    function materiLogin(){
        $kelas = Anak::where('nis', session()->get('login')->username)->value('kelas');
        return $this->hasMany(Materi::class, 'fk_mapel')->where('fk_kelas', $kelas);
    }

    function kuisLogin(){
        $kelas = Anak::where('nis', session()->get('login')->username)->value('kelas');
        return $this->hasMany(Kuis::class, 'id_mapel')->where('id_kelas', $kelas);
    }

    function tambahMapel($param) {
        $mapel = new Mapel();
        $mapel->nama_mapel = $param->nama_mapel;
        $mapel->kkm = $param->kkm;
        $mapel->status = 1;
        $mapel->save();
        return $param;
    }

    function ubahMapel($param, $id) {
        Mapel::where('id_mapel', $id)->update([
            "nama_mapel" => $param->nama_mapel,
            "kkm" => $param->kkm,
        ]);
        return $id;
    }

    function deleteMapel($param) {
        $status = Mapel::where('id_mapel', $param->idMapel)->value('status');
        if ($status == 1) {
            Mapel::where('id_mapel', $param->idMapel)->update([
                "status" => 0,
            ]);
        }
        else{
            Mapel::where('id_mapel', $param->idMapel)->update([
                "status" => 1,
            ]);
        }
        return $param;
    }
}
