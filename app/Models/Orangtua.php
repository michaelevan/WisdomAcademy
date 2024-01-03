<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orangtua extends Model
{
    // use HasFactory;
    protected $table = "orangtua";
    protected $primaryKey = "username";
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable =[
        'username',
        'nama',
        'no_hp',
        'alamat',
        'kota',
        'akte_lahir',
        'kartu_keluarga',
    ];

    function editProfileOrtu($param) {
        Users::where("username", session()->get('login')->username)->update([
            "email" => $param->email,
            "password" => $param->password,
        ]);
        Orangtua::where("username", session()->get('login')->username)->update([
            "nama" => $param->nama,
            "no_hp" => $param->no_hp,
            "alamat" => $param->alamat,
            "kota" => $param->kota,
        ]);
        if ($param->hasFile('akte_lahir')) {
            $akte_lahir = $param->file('akte_lahir')->getClientOriginalName();
            Orangtua::where("username", session()->get('login')->username)->update([
                "akte_lahir" => $akte_lahir,
            ]);
            $param->file('akte_lahir')->move('img/anak/', $akte_lahir);
        }
        if ($param->hasFile('kartu_keluarga')) {
            $kartu_keluarga = $param->file('kartu_keluarga')->getClientOriginalName();
            Orangtua::where("username", session()->get('login')->username)->update([
                "kartu_keluarga" => $kartu_keluarga,
            ]);
            $param->file('kartu_keluarga')->move('img/anak/', $kartu_keluarga);
        }

        return $param;
    }
}
