<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class komentarSubjek extends Model
{
    // use HasFactory;
    protected $table = "komentar_subjek";
    protected $primaryKey = "id_komentar";
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable =[
        'id_komentar',
        'id_subjek',
        'id_detailsiswa',
        'semester',
        'komentar',
    ];

    function tambahKomentarSubjek($param, $id) {
        $id_subjek = Subjek::where('id_subjek', $param->pilihSubjek)->value('id_subjek');
        $komentar = komentarSubjek::where('id_detailsiswa', $param->id_detailsiswa)->where('semester', $param->semester)->where('id_subjek', $id_subjek)->value('komentar');
        if ($komentar != null) {
            komentarSubjek::where('id_detailsiswa', $param->id_detailsiswa)->where('semester', $param->semester)->update([
                "komentar" => $param->komentar
            ]);
        }
        else{
            $komentarSubjek = new komentarSubjek();
            $komentarSubjek->id_subjek = $id_subjek;
            $komentarSubjek->id_detailsiswa = $param->id_detailsiswa;
            $komentarSubjek->semester = $param->semester;
            $komentarSubjek->komentar = $param->komentar;
            $komentarSubjek->save();
        }
        return $id;
    }
}
