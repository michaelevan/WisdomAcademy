<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nilaiKuis extends Model
{
    // use HasFactory;
    protected $table = "nilai_kuis";
    protected $primaryKey = "id_nilai_kuis";
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable =[
        'id_nilai_kuis',
        'tanggal',
        'id_detailsiswa',
        'id_kuis',
        'jumlah_soal',
        'jumlah_benar',
        'jumlah_salah',
        'jawaban',
        'nilai',
    ];

    function result($id_kuis, $jumBenar, $jawabanUser, $urutanSoal) {
        $nilaiKuis = new nilaiKuis();

        $kelas = Anak::where('nis', session()->get('login')->username)->value('kelas');
        $id_detailsiswa = detailKelas::join('anak', 'detail_kelas.nis', '=', 'anak.nis')->where('detail_kelas.id_kelas', $kelas)->where('detail_kelas.nis', session()->get('login')->username)->value('id_detailsiswa');
        $jumlah_soal = detailKuis::where('id_kuis', $id_kuis)->count('id_detail_kuis');

        $nilaiKuis->tanggal = Carbon::now();
        $nilaiKuis->id_detailsiswa = $id_detailsiswa;
        $nilaiKuis->id_kuis = $id_kuis;
        $nilaiKuis->jumlah_soal = $jumlah_soal;
        $nilaiKuis->jumlah_benar = $jumBenar;
        $nilaiKuis->jumlah_salah = $jumlah_soal - $jumBenar;
        $nilaiKuis->urutan_soal = json_encode($urutanSoal);
        $nilaiKuis->jawaban = json_encode($jawabanUser);
        $nilaiKuis->nilai = number_format($jumBenar / $jumlah_soal * 100, 2);
        $nilaiKuis->save();

        return $id_kuis;
    }
}
