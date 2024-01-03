<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\detailAgenda;

class Agenda extends Model
{
    // use HasFactory;
    protected $table = "agenda";
    protected $primaryKey = "id_agenda";
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable =[
        'id_agenda',
        'tanggal',
        'id_guru',
        'id_kelas',
        'isi',
    ];

    function getDetailAgenda() {
        return $this->hasMany(detailAgenda::class,'id_agenda');
    }

    function getSpecificAgenda() {
        $kelas = Anak::where('nis', session()->get('login')->username)->value('kelas');
        $id_detailsiswa = detailKelas::where('id_kelas', $kelas)->where('nis', session()->get('login')->username)->value('id_detailsiswa');
        return $this->hasMany(detailAgenda::class, 'id_agenda', 'id_agenda')->where('id_detailsiswa', $id_detailsiswa);
    }

    function getSpecificAgendaOrtu() {
        $nis = Anak::where('orangtua', session()->get('login')->username)->value('nis');
        $kelas = Anak::where('nis', $nis)->value('kelas');
        $id_detailsiswa = detailKelas::where('id_kelas', $kelas)->where('nis', $nis)->value('id_detailsiswa');
        return $this->hasMany(detailAgenda::class, 'id_agenda', 'id_agenda')->where('id_detailsiswa', $id_detailsiswa);
    }

    function getAgendaByTanggalAndKelas($tanggal, $kelas) {
        return Agenda::where('tanggal', $tanggal)->where('id_kelas', $kelas)->get();
    }

    function tambahAgenda($param) {
        $id_kelas = Kelas::join('tahun_ajaran', 'kelas.tahun_ajaran', '=', 'tahun_ajaran.tahun_ajaran')->where('kelas.wali_kelas', session()->get('login')->username)->where('tahun_ajaran.status', 1)->value('kelas.id_kelas');
        foreach ($param->input('keterangan') as $keterangan) {
            $agenda = new Agenda();
            $agenda->tanggal = $param->tanggal;
            $agenda->id_guru = session()->get('login')->username;
            $agenda->id_kelas = $id_kelas;
            $agenda->isi = $keterangan;
            $agenda->save();
        }

        $id_agenda = Agenda::where('tanggal', $param->tanggal)->value('id_agenda');
        $nama_guru = Guru::where('username', session()->get('login')->username)->value('nama');
        $dataAnak = detailKelas::join('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')->where('detail_kelas.id_kelas', $id_kelas)->get();
        foreach ($dataAnak as $anak) {
            $notifikasi = new Notifikasi();
            $notifikasi->id_anak = $anak->id_detailsiswa;
            $notifikasi->jenis = 2;
            $notifikasi->id_reference = $id_agenda;
            $notifikasi->keterangan = $nama_guru.' telah membuat agenda baru pada tanggal: '.date('d F Y', strtotime($param->tanggal));
            $notifikasi->status = 0;
            $notifikasi->save();
        }
        // dd($agenda);
        return $param;
    }
}
