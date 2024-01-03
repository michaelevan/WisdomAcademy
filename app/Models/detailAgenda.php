<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Agenda;

class detailAgenda extends Model
{
    // use HasFactory;
    protected $table = "detail_agenda";
    protected $primaryKey = "id_detail_agenda";
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable =[
        'id_detail_agenda',
        'id_agenda',
        'nis',
        'tanggal_centang',
    ];

    function getAgenda() {
        return $this->belongsTo(Agenda::class, 'id_agenda');
    }

    function checklist($param){
        $kelas = Anak::where('nis', session()->get('login')->username)->value('kelas');
        $id_detailsiswa = detailKelas::where('nis', session()->get('login')->username)->where('id_kelas', $kelas)->value('id_detailsiswa');
        $dt = detailAgenda::where('id_agenda', $param->id_agenda)->where('id_detailsiswa', $id_detailsiswa)->get();
        if(count($dt) == 0) {
            $detailAgenda = new detailAgenda();
            $detailAgenda->id_agenda = $param->id_agenda;
            $detailAgenda->id_detailsiswa = $id_detailsiswa;
            $detailAgenda->tanggal_centang = $param->nilaiTanggal;
            $detailAgenda->save();
        }
        else {
            detailAgenda::where('id_agenda', $param->id_agenda)->where('id_detailsiswa', $id_detailsiswa)->delete();
        }
        return $param;
    }
}
