<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    // use HasFactory;
    protected $table = "kelas";
    protected $primaryKey = "id_kelas";
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable =[
        'id_kelas',
        'nama_kelas',
        'tahun_ajaran',
        'wali_kelas',
    ];

    function tambahKelas($param) {
        $pesan = [
            'thnAwal.numeric' => 'tahun ajaran harus berisikan angka',
            'thnAkhir.numeric' => 'tahun ajaran harus berisikan angka',
        ];
        $param->validate([
            "thnAwal" => "numeric",
            "thnAkhir" => "numeric",
        ], $pesan);

        $kelas = new Kelas;
        $kelas->nama_kelas = $param->nama_kelas;
        $kelas->wali_kelas = $param->wali_kelas;
        $kelas->tahun_ajaran = $param->tahun_ajaran;
        $kelas->save();
        return $param;
    }
}
