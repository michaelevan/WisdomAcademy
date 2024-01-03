<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    // use HasFactory;
    protected $table = "pendaftaran";
    protected $primaryKey = "id";
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable =[
        'id',
        'asal_sekolah',
        'nama_siswa',
        'tgl_lahir',
        'j_kelamin',
        'kelas',
        'nama_orangtua',
        'no_hp',
        'email',
        'alamat',
        'kota',
        'anak_ke',
        'jumlah_saudara',
        'janji_temu',
        'akte_lahir',
        'kartu_keluarga',
        'foto',
        'keterangan',
        'status',
        'created_at',
        'updated_at',
    ];

    function daftarAnak($param) {
        $pendaftaran                = new Pendaftaran();
        $pendaftaran->asal_sekolah  = $param->asal_sekolah;
        $pendaftaran->nama_siswa    = $param->nama_siswa;
        $pendaftaran->tgl_lahir     = $param->tgl_lahir;
        $pendaftaran->j_kelamin     = $param->j_kelamin;
        $pendaftaran->kelas         = $param->kelas;
        $pendaftaran->nama_orangtua = $param->nama_orangtua;
        $pendaftaran->no_hp         = $param->no_hp;
        $pendaftaran->email         = $param->email;
        $pendaftaran->alamat        = $param->alamat;
        $pendaftaran->kota          = $param->kota;
        $pendaftaran->anak_ke       = $param->anak_ke;
        $pendaftaran->jumlah_saudara= $param->jumlah_saudara;
        $pendaftaran->janji_temu    = $param->janji_temu;
        $pendaftaran->keterangan    = $param->keterangan;
        $pendaftaran->foto          = "default.jpg";
        $pendaftaran->akte_lahir    = "default.jpg";
        $pendaftaran->kartu_keluarga= "default.jpg";
        $pendaftaran->status= "0";
        $foto                       = $param->file('foto');
        $akte_lahir                 = $param->file('akte_lahir');
        $kartu_keluarga             = $param->file('kartu_keluarga');

        if($foto != null) {
            $pendaftaran->foto      = $foto->getClientOriginalName();
            $foto->move('img/anak/', $pendaftaran->foto);
        }
        if($akte_lahir != null) {
            $pendaftaran->akte_lahir= $akte_lahir->getClientOriginalName();
            $akte_lahir->move('img/anak/', $pendaftaran->akte_lahir);
        }
        if($kartu_keluarga != null) {
            $pendaftaran->kartu_keluarga= $kartu_keluarga->getClientOriginalName();
            $kartu_keluarga->move('img/anak/', $pendaftaran->kartu_keluarga);
        }
        $pendaftaran->save();

        $users = new Users();
        $arr = explode('@', $param->email);
        $un = $arr[0];
        $no_acak = (string)(random_int(1000, 9999));
        $username = substr($un, 0, 5).$no_acak;
        $users->username = $username;
        $users->password = $username;
        $users->email = $param->email;
        $users->role = "orangtua";
        $users->status = "1";
        $users->save();

        $orangtua = new Orangtua();
        $orangtua->username = $username;
        $orangtua->nama = $param->nama_orangtua;
        $orangtua->no_hp = $param->no_hp;
        $orangtua->alamat = $param->alamat;
        $orangtua->kota = $param->kota;
        $orangtua->akte_lahir = $pendaftaran->akte_lahir;
        $orangtua->kartu_keluarga = $pendaftaran->kartu_keluarga;
        $orangtua->save();

        return $param;
    }

    function updateJanjiTemu($param) {
        Pendaftaran::where("id", $param->id)->update([
            "janji_temu" => $param->janji_temu,
            "status" => 1,
        ]);
        return $param;
    }

    function deleteListPendaftaran($id) {
        Pendaftaran::where("id", $id)->update([
            "status" => 3
        ]);
        $username = Pendaftaran::join('users', 'pendaftaran.nama_orangtua', '=', 'users.username')->where('pendaftaran.id', $id)->value('users.username');
        $orangtua = Pendaftaran::join('orangtua', 'pendaftaran.nama_orangtua', '=', 'orangtua.nama')->where('pendaftaran.id', $id)->value('orangtua.username');
        Orangtua::where('username', $orangtua)->delete();
        Users::where('username', $username)->delete();
        return $id;
    }
}
