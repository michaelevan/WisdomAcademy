<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    // use HasFactory;
    protected $table = "materi";
    protected $primaryKey = "id_materi";
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable =[
        'id_materi',
        'nama_materi',
        'fk_mapel',
        'fk_guru',
        'tahun_ajaran',
        'file',
        'deskripsi_materi',
        'created_at',
        'updated_at',
    ];

    function tambahMateri($param, $id) {
        $mapel = Mapel::where('nama_mapel', $id)->value('id_mapel');
        $daftarKelas = Kelas::join('tahun_ajaran', 'kelas.tahun_ajaran', '=', 'tahun_ajaran.tahun_ajaran')->where('wali_kelas', session()->get('login')->username)->where('tahun_ajaran.status', 1)->value('id_kelas');
        $anak = detailKelas::join('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')->select('detail_kelas.nis')
        ->where('kelas.id_kelas', $daftarKelas)->get();

        $materi = new Materi();
        $materi->nama_materi = $param->nama_materi;
        $materi->fk_kelas = $daftarKelas;
        $materi->fk_mapel = $mapel;
        $materi->deskripsi_materi = $param->deskripsi_materi;
        if ($param->has('btnSimpan')) {
            $materi->status = 0;
        }
        elseif ($param->has('btnSubmit')) {
            $materi->status = 1;
        }
        $materi->save();
        $id = $materi->id_materi;

        foreach ($param->file('nama_file') as $file) {
            $detailMateri = new detailMateri();
            $detailMateri->id_materi = $id;
            $detailMateri->tanggal = Carbon::now();
            $detailMateri->nama_file = $file->getClientOriginalName();
            $file->move('img/materi/', $file->getClientOriginalName());
            $detailMateri->save();
        }

        if ($param->has('btnSubmit')) {
            foreach ($anak as $nis) {
                $notifikasi = new Notifikasi();
                $notifikasi->id_anak = $nis->nis;
                $notifikasi->jenis = 0;
                $notifikasi->id_reference = $id;
                $notifikasi->keterangan = session()->get('login')->username.' telah membuat materi baru : '.$materi->nama_materi;
                $notifikasi->status = 0;
                $notifikasi->save();
            }
        }

        return $param;
    }

    function publishMateri($param) {
        Materi::where('id_materi', $param->idMateri)->update([
            'status' => 1
        ]);

        $nama_guru = Guru::where('username', session()->get('login')->username)->value('nama');
        $nama_materi = Materi::where('id_materi', $param->idMateri)->value('nama_materi');
        $id_kelas = Kelas::join('tahun_ajaran', 'kelas.tahun_ajaran', '=', 'tahun_ajaran.tahun_ajaran')->where('kelas.wali_kelas', session()->get('login')->username)->where('tahun_ajaran.status', 1)->value('kelas.id_kelas');
        $dataAnak = detailKelas::join('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')->where('detail_kelas.id_kelas', $id_kelas)->get();
        foreach ($dataAnak as $anak) {
            $notifikasi = new Notifikasi();
            $notifikasi->id_anak = $anak->id_detailsiswa;
            $notifikasi->jenis = 0;
            $notifikasi->id_reference = $param->idMateri;
            $notifikasi->keterangan = $nama_guru.' telah membuat materi baru : '.$nama_materi;
            $notifikasi->status = 0;
            $notifikasi->save();
        }
        return $param;
    }

    function editMateri($param, $id_materi) {
        Materi::where('id_materi', $id_materi)->update([
            "nama_materi" => $param->nama_materi,
            "deskripsi_materi" => $param->deskripsi_materi,
        ]);

        if ($param->hasFile('nama_file')) {
            detailMateri::where('id_materi', $id_materi)->delete();

            foreach ($param->file('nama_file') as $file) {
                $detailMateri = new detailMateri();
                $detailMateri->id_materi = $id_materi;
                $detailMateri->tanggal = Carbon::now();
                $detailMateri->nama_file = $file->getClientOriginalName();
                $file->move('img/materi/', $file->getClientOriginalName());
                $detailMateri->save();
            }
        }
        return $id_materi;
    }

    function reuseMateri($param, $id, $id_materi) {
        $mapel = Mapel::where('nama_mapel', $id)->value('id_mapel');
        $id_kelas = Kelas::join('tahun_ajaran', 'kelas.tahun_ajaran', '=', 'tahun_ajaran.tahun_ajaran')->where('kelas.wali_kelas', session()->get('login')->username)->where('tahun_ajaran.status', 1)->value('kelas.id_kelas');
        $listMateri = Materi::where('id_materi', $id_materi)->first();
        $listDetailMateri = detailMateri::join('materi', 'detail_materi.id_materi', '=', 'materi.id_materi')->where('detail_materi.id_materi', $id_materi)->get();
        $materi = new Materi();
        $materi->nama_materi = $listMateri->nama_materi;
        $materi->fk_kelas = $id_kelas;
        $materi->fk_mapel = $mapel;
        $materi->deskripsi_materi = $listMateri->deskripsi_materi;
        $materi->status = 0;
        $materi->save();
        $idBaru = $materi->id_materi;
        foreach ($listDetailMateri as $detailMateriLama) {
            $detailMateri = new detailMateri();
            $detailMateri->id_materi = $idBaru;
            $detailMateri->tanggal = Carbon::now();
            $detailMateri->nama_file = $detailMateriLama->nama_file;
            // $file->move('img/materi/', $detailMateriLama->nama_file);
            $detailMateri->save();
        }
        return $param;
    }
}
