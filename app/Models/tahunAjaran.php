<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tahunAjaran extends Model
{
    // use HasFactory;
    protected $table = "tahun_ajaran";
    protected $primaryKey = "tahun_ajaran";
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable =[
        'tahun_ajaran',
        'tgl_mulai',
        'tgl_akhir',
        'status',
    ];

    function tambahtahunAjaran($param) {
        $pesan = [
            'thnAwal.numeric' => 'tahun ajaran harus berisikan angka',
            'thnAkhir.numeric' => 'tahun ajaran harus berisikan angka',
        ];
        $param->validate([
            "thnAwal" => "numeric",
            "thnAkhir" => "numeric",
        ], $pesan);

        $tahunAjaran = new tahunAjaran;
        $tahunAjaran->tahun_ajaran = $param->thnAwal.'/'.$param->thnAkhir;
        $tahunAjaran->tgl_mulai = Carbon::now();
        $tahunAjaran->status = 0;
        $tahunAjaran->save();
        return $param;
    }

    function ubahTahunAjaran($param) {
        $today = Carbon::now();
        $tglAkhirAktif = $today->subDay();
        tahunAjaran::where('status', 1)->update([
            "status" => 0,
            "tgl_akhir" => $tglAkhirAktif->format('Y-m-d'),
        ]);
        tahunAjaran::where('tahun_ajaran', $param->id_tahun_ajaran)->update([
            "status" => 1,
            "tgl_mulai" => Carbon::now(),
        ]);
        return $param;
    }
}
