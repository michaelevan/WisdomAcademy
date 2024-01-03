<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    // use HasFactory;
    protected $table = "notifikasi";
    protected $primaryKey = "id_notifikasi";
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable =[
        'id_notifikasi',
        'tanggal',
        'id_anak',
        'jenis',
        'id_reference',
        'keterangan',
        'status',
    ];

    function linkNotifikasi($param) {
        $getAnakData = Anak::where('nis', session()->get('login')->username)->first();
        $getID = detailKelas::where('nis', $getAnakData->nis)->where('id_kelas', $getAnakData->kelas)->value('id_detailsiswa');
        $statusNotif = Notifikasi::where('id_reference', $param->id_reference)->where('jenis', $param->jenis)->where('id_anak', $getID)->value('status');
        if ($statusNotif == 0) {
            $countNotif = session()->get('jumNotif') - 1;
            session()->forget('jumNotif');
            session()->put("jumNotif", $countNotif);
            Notifikasi::where('id_reference', $param->id_reference)->where('jenis', $param->jenis)->where('id_anak', $getID)->update([
                "status" => 1
            ]);
        }
        return $param;
    }
}
