<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class aktivitasSubjek extends Model
{
    // use HasFactory;
    protected $table = "aktivitas_subjek";
    protected $primaryKey = "id_aktivitas";
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable =[
        'id_aktivitas',
        'id_subjek',
        'aktivitas',
    ];

    function tambahAktivitasSubjek($param, $id) {
        $aktivitas = new aktivitasSubjek();
        $aktivitas->id_subjek = $id;
        $aktivitas->aktivitas = $param->aktivitas;
        $aktivitas->save();
        return $param;
    }

    function deleteAktivitasSubjek($id_aktivitas) {
        aktivitasSubjek::where('id_aktivitas', $id_aktivitas)->delete();
        return $id_aktivitas;
    }
}
