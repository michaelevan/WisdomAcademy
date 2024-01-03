<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nilaiSubjek extends Model
{
    // use HasFactory;
    protected $table = "nilai_subjek";
    protected $primaryKey = "id_nilai_subjek";
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable =[
        'id_nilai_subjek',
        'id_aktivitas',
        'id_detailsiswa',
        'semester',
        'scoring',
        'behaviour',
    ];

    function tambahNilaiSubjek($param, $id) {
        $scoring = nilaiSubjek::where('id_aktivitas', $param->id_aktivitas)->where('id_detailsiswa', $param->id_detailsiswa)->value('scoring');
        if($scoring != "" || $scoring != null) {
            nilaiSubjek::where('id_aktivitas', $param->id_aktivitas)->where('id_detailsiswa', $param->id_detailsiswa)->where('semester', $param->semester)->delete();
        }
        $nilai = new nilaiSubjek();
        $nilai->id_aktivitas = $param->id_aktivitas;
        $nilai->id_detailsiswa = $param->id_detailsiswa;
        $nilai->semester = $param->semester;
        $nilai->scoring = $param->nilai;
        $nilai->save();

        return $id;
    }

    function tambahNilaiPerilaku($param, $id) {
        $behaviour = nilaiSubjek::where('id_aktivitas', $param->id_aktivitas)->where('id_detailsiswa', $param->id_detailsiswa)->value('behaviour');
        if($behaviour != "") {
            nilaiSubjek::where('id_aktivitas', $param->id_aktivitas)->where('id_detailsiswa', $param->id_detailsiswa)->where('semester', $param->semester)->delete();
        }
        $nilai = new nilaiSubjek();
        $nilai->id_aktivitas = $param->id_aktivitas;
        $nilai->id_detailsiswa = $param->id_detailsiswa;
        $nilai->semester = $param->semester;
        $nilai->scoring = -1;
        $nilai->behaviour = $param->nilai;
        $nilai->save();

        return $id;
    }
}
