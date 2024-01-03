<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detailKelas extends Model
{
    // use HasFactory;
    protected $table = "detail_kelas";
    protected $primaryKey = "id_detailsiswa";
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable =[
        'id_detailsiswa',
        'id_kelas',
        'nis',
    ];

    function tidakNaikKelas($param, $id) {
        $detailKelas = new detailKelas();
        $detailKelas->id_kelas = $param->pilihKelasTinggal;
        $detailKelas->nis = $id;
        $detailKelas->save();

        Anak::where('nis', $id)->update([
            "kelas" => $param->pilihKelasTinggal
        ]);
        return $id;
    }

    function naikKelas($param, $id) {
        $kelasAnak = Kelas::join('anak', 'kelas.id_kelas', '=', 'anak.kelas')->where('anak.nis', $id)->value('nama_kelas');
        if (substr($kelasAnak, 0, 1) == '9') {
            Users::where('username', $id)->update([
                "status" => 2
            ]);
        }
        else{
            $detailKelas = new detailKelas();
            $detailKelas->id_kelas = $param->pilihKelasBaru;
            $detailKelas->nis = $id;
            $detailKelas->save();
            Anak::where('nis', $id)->update([
                "kelas" => $param->pilihKelasBaru
            ]);
        }
        return $id;
    }
}
