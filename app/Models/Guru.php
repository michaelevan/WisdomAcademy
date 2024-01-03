<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    // use HasFactory;
    protected $table = "guru";
    protected $primaryKey = "username";
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable =[
        'username',
        'NIK',
        'nama',
        'j_kelamin',
        'tgl_lahir',
        'tgl_masuk',
        'spesialis',
        'no_identitas',
        'no_hp',
        'img',
    ];

    function updateProfile($param) {
        Users::where("username", session()->get('login')->username)->update([
            "password" => $param->password,
        ]);
        if ($param->hasFile('foto')) {
            $foto = $param->file('foto')->getClientOriginalName();
            Guru::where("username", session()->get('login')->username)->update([
                "foto" => $foto,
            ]);
            $param->file('foto')->move('img/guru/', $foto);
        }
        return $param;
    }
}
