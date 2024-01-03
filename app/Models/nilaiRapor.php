<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nilaiRapor extends Model
{
    // use HasFactory;
    protected $table = "nilai_rapor";
    protected $primaryKey = "id_rapor";
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable =[
        'id_rapor',
        'id_detailsiswa',
        'id_mapel',
        'semester',
        'nilai',
    ];

    function tambahNilaiRapor($param, $id){
        $nilai = nilaiRapor::where('id_mapel', $param->id_mapel)->where('id_detailsiswa', $param->id_detailsiswa)->value('nilai');
        if($nilai != "" || $nilai != null) {
            nilaiRapor::where('id_mapel', $param->id_mapel)->where('id_detailsiswa', $param->id_detailsiswa)->where('semester', $param->semester)->delete();
        }
        $nilaiRapor = new nilaiRapor();
        $nilaiRapor->id_detailsiswa = $param->id_detailsiswa;
        $nilaiRapor->id_mapel = $param->id_mapel;
        $nilaiRapor->semester = $param->semester;
        $nilaiRapor->nilai = $param->nilai;
        $nilaiRapor->save();
        return $id;
    }
}
