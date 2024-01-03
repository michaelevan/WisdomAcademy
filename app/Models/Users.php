<?php

namespace App\Models;

use App\Notifications\PasswordReset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;

class Users extends Model
{
    // use HasFactory;
    protected $table = "users";
    protected $primaryKey = "username";
    public $timestamps = true;
    public $incrementing = false;

    protected $fillable =[
        'username',
        'password',
        'email',
        'role',
        'status',
        'created_at',
        'updated_at',
    ];

    function updateProfilAdmin($param) {
        Users::where("username", session()->get('login')->username)->update([
            "password" => $param->password,
            "email" => $param->email,
        ]);
        return $param;
    }

    function tambahGuru($param) {
        $users = new Users();
        $users->username = $param->username;
        $users->password = $param->password;
        $users->email = $param->email;
        $users->role = "guru";
        $users->status = "1";
        $users->save();

        if ($users->role == "guru") {
            $guru = new Guru();
            $guru->username = $param->username;
            $guru->nik = $param->nik;
            $guru->nama = $param->nama;
            $guru->j_kelamin = $param->j_kelamin;
            $guru->tgl_lahir = $param->tgl_lahir;
            $guru->tgl_masuk = $param->tgl_masuk;
            $guru->spesialis = $param->spesialis;
            $guru->no_identitas = $param->no_identitas;
            $guru->no_hp = $param->no_hp;
            $foto = $param->file('foto');

            if ($foto == null) {
                $guru->foto = "profile.png";
                $guru->save();
            }
            else {
                $guru->foto = $foto->getClientOriginalName();
                $foto->move('img/guru/', $guru->foto);
                $guru->save();
            }
        }
        return $param;
    }

    function editGuru($param, $id_guru) {
        $listUsers = Users::all();
        $orangtua = Users::where('username', $id_guru)->first();
        $cekEmail = false;
        $cekNIK = false;
        $cekNoidentitas = false;
        foreach ($listUsers as $users) {
            if ($users->email == $param->email && $users->email != $orangtua->email) {
                $cekEmail = true;
            }
            if ($users->nik == $param->nik && $users->nik != $orangtua->nik) {
                $cekNIK = true;
            }
            if ($users->no_identitas == $param->no_identitas && $users->no_identitas != $orangtua->no_identitas) {
                $cekNoidentitas = true;
            }
        }

        if ($cekEmail == false && $cekNIK == false && $cekNoidentitas == false) {
            Users::join('guru', 'users.username', '=', 'guru.username')->where('guru.username', $id_guru)->update([
                "guru.nik" => $param->nik,
                "guru.j_kelamin" => $param->j_kelamin,
                "guru.tgl_lahir" => $param->tgl_lahir,
                "guru.no_identitas" => $param->no_identitas,
                "guru.no_hp" => $param->no_hp,
                "guru.tgl_masuk" => $param->tgl_masuk,
                "guru.spesialis" => $param->spesialis,
                "users.status" => $param->status,
            ]);
            return $param;
        }
        else{
            if ($cekEmail) {
                return back()->with('errors', 'email sudah dipakai');
            }
            if ($cekEmail) {
                return back()->with('errors', 'email sudah dipakai');
            }
            if ($cekEmail) {
                return back()->with('errors', 'email sudah dipakai');
            }
        }
    }

    function statusAnak($param) {
        $getStatus = Users::where('username', $param->idAnak)->value('status');
        if ($getStatus == 0) {
            Users::where('username', $param->idAnak)->update([
                "status" => 1,
            ]);
        }
        else{
            Users::where('username', $param->idAnak)->update([
                "status" => 0,
            ]);
        }
        return $param;
    }

    function ubahStatus($status) {
        Users::where("role", "guru")->update([
            "status" => $status,
        ]);
    }
}
