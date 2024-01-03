<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anak extends Model
{
    // use HasFactory;
    protected $table = "anak";
    protected $primaryKey = "nis";
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable =[
        'nis',
        'orangtua',
        'nama',
        'j_kelamin',
        'tgl_lahir',
        'kelas',
        'keterangan',
        'anak_ke',
        'jumlah_saudara',
        'foto',
    ];

    function tambahAnak($param, $id) {
        $listPendaftaran = Pendaftaran::where('id', $id)->first();
        $userOrangtua = Pendaftaran::join('users', 'pendaftaran.email', '=', 'users.email')->where('pendaftaran.id', $id)->value('users.username');
        $users = new Users();
        $users->username = $param->nis;
        $users->password = $param->nis;
        $users->email = $listPendaftaran->email;
        $users->role = "anak";
        $users->status = "1";
        $users->save();

        $anak = new Anak;
        $anak->nis = $param->nis;
        $anak->orangtua = $userOrangtua;
        $anak->nama = $listPendaftaran->nama_siswa;
        $anak->j_kelamin = $listPendaftaran->j_kelamin;
        $anak->tgl_lahir = $listPendaftaran->tgl_lahir;
        $anak->kelas = $param->kelas;
        $anak->keterangan = $listPendaftaran->keterangan;
        $anak->anak_ke = $listPendaftaran->anak_ke;
        $anak->jumlah_saudara = $listPendaftaran->jumlah_saudara;
        if ($listPendaftaran->foto == "default.jpg") {
            $anak->foto = "profile.png";
        }
        else{
            $anak->foto = $listPendaftaran->foto;
        }
        $anak->save();

        Pendaftaran::where("id", $id)->update([
            "status" => 2
        ]);

        $detail_kelas = new detailKelas();
        $detail_kelas->id_kelas = $param->kelas;
        $detail_kelas->nis = $param->nis;
        $detail_kelas->save();

        return $param;
    }

    function editProfileAnak($param) {
        Anak::where('nis', session()->get('login')->username)->update([
            "nama" => $param->nama,
        ]);
        if ($param->hasFile('foto')) {
            $foto = $param->file('foto')->getClientOriginalName();
            Anak::where("nis", session()->get('login')->username)->update([
                "foto" => $foto,
            ]);
            $param->file('foto')->move('img/anak/', $foto);
        }
        return $param;
    }
}
