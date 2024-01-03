<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detailMateri extends Model
{
    // use HasFactory;
    protected $table = "detail_materi";
    protected $primaryKey = "id_detail_materi";
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable =[
        'id_detail_materi',
        'id_materi',
        'tanggal',
        'file',
    ];
}
