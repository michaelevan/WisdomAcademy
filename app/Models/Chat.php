<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    // use HasFactory;
    protected $table = "chat";
    protected $primaryKey = "id_chat";
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable =[
        'id_chat',
        'tanggal',
        'username1',
        'username2',
        'teks',
    ];

    function chatGuru($nis, $param) {
        $chat = new Chat();
        $chat->username1 = session()->get('login')->username;
        $chat->username2 = $nis;
        $chat->teks = $param->teks;
        $chat->save();

        return $nis;
    }

    function chatOrtu($param) {
        $nis = Anak::where('orangtua', session()->get('login')->username)->value('nis');
        $chat = new Chat();
        $chat->username1 = $nis;
        $chat->username2 = $param->usernameGuru;
        $chat->teks = $param->teks;
        $chat->save();

        return $param;
    }
}
