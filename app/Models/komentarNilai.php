<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class komentarNilai extends Model
{
    // use HasFactory;
    protected $table = "komentar_nilai";
    protected $primaryKey = "id_komentar";
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable =[
        'id_komentar',
        'id_detailsiswa',
        'semester',
        'komentar',
    ];

    function tambahKomentarNilai($param, $id) {
        $komentar = komentarNilai::where('id_detailsiswa', $param->id_detailsiswa)->where('semester', $param->semester)->value('komentar');
        if ($komentar != null) {
            komentarNilai::where('id_detailsiswa', $param->id_detailsiswa)->where('semester', $param->semester)->update([
                "komentar" => $param->komentar
            ]);
        }
        else{
            $komentarNilai = new komentarNilai();
            $komentarNilai->id_detailsiswa = $param->id_detailsiswa;
            $komentarNilai->semester = $param->semester;
            $komentarNilai->komentar = $param->komentar;
            $komentarNilai->save();
        }
        return $id;
    }
}
