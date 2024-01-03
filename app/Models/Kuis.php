<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuis extends Model
{
    // use HasFactory;
    protected $table = "kuis";
    protected $primaryKey = "id_kuis";
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable =[
        'id_kuis',
        'nama_kuis',
        'batas_waktu',
        'id_kelas',
        'id_mapel',
        'status',
        'created_at',
        'updated_at',
    ];

    function tambahKuis($param, $id) {
        $mapel = Mapel::where('nama_mapel', $id)->value('id_mapel');
        $daftarKelas = Kelas::join('tahun_ajaran', 'kelas.tahun_ajaran', '=', 'tahun_ajaran.tahun_ajaran')->where('wali_kelas', session()->get('login')->username)->where('tahun_ajaran.status', 1)->value('id_kelas');

        $kuis = new Kuis();
        $kuis->nama_kuis = $param->nama_kuis;
        $kuis->batas_waktu = $param->batas_waktu;
        $kuis->id_kelas = $daftarKelas;
        $kuis->id_mapel = $mapel;
        $kuis->status = 0;
        $kuis->save();

        return $param;
    }

    function publishKuis($param) {
        Kuis::where('id_kuis', $param->idKuis)->update([
            'status' => 1
        ]);

        $nama_guru = Guru::where('username', session()->get('login')->username)->value('nama');
        $nama_kuis = Kuis::where('id_kuis', $param->idKuis)->value('nama_kuis');
        $id_kelas = Kelas::join('tahun_ajaran', 'kelas.tahun_ajaran', '=', 'tahun_ajaran.tahun_ajaran')->where('kelas.wali_kelas', session()->get('login')->username)->where('tahun_ajaran.status', 1)->value('kelas.id_kelas');
        $dataAnak = detailKelas::join('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')->where('detail_kelas.id_kelas', $id_kelas)->get();
        foreach ($dataAnak as $anak) {
            $notifikasi = new Notifikasi();
            $notifikasi->id_anak = $anak->id_detailsiswa;
            $notifikasi->jenis = 1;
            $notifikasi->id_reference = $param->idKuis;
            $notifikasi->keterangan = $nama_guru.' telah membuat kuis baru : '.$nama_kuis;
            $notifikasi->status = 0;
            $notifikasi->save();
        }
        return $param;
    }
}
