<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detailKuis extends Model
{
    // use HasFactory;
    protected $table = "detail_kuis";
    protected $primaryKey = "id_detail_kuis";
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable =[
        'id_detail_kuis',
        'id_kuis',
        'nomor_kuis',
        'jenis',
        'pertanyaan',
        'option_value',
        'soal_img',
        'groupkey',
    ];

    function tambahDetailKuis($param, $id_kuis){
        if ($param->has('btnPilgan')) {
            $countDetailKuis = detailKuis::where('id_kuis', $id_kuis)->count('id_detail_kuis');
            $detailKuis = new detailKuis();
            $detailKuis->id_kuis = $id_kuis;
            $detailKuis->nomor_kuis = $countDetailKuis + 1;
            $detailKuis->jenis = 1;
            $detailKuis->pertanyaan = $param->pertanyaan_1;
            $detailKuis->option_value = json_encode($param->option_value_1);

            $arrSoal = [];
            if ($param->hasFile('soal_img_1')) {
                foreach ($param->file('soal_img_1') as $soal) {
                    array_push($arrSoal, $soal->getClientOriginalName());
                    $nama_file = $soal->getClientOriginalName();
                    $soal->move('img/kuis/soal/', $nama_file);
                }
            }
            else{
                array_push($arrSoal, "");
            }
            $detailKuis->soal_img = json_encode($arrSoal);
            $detailKuis->save();
        }
        else if ($param->has('btnUrut')) {
            $countDetailKuis = detailKuis::where('id_kuis', $id_kuis)->count('id_detail_kuis');
            $detailKuis = new detailKuis();
            $detailKuis->id_kuis = $id_kuis;
            $detailKuis->nomor_kuis = $countDetailKuis + 1;
            $detailKuis->jenis = 2;
            $detailKuis->pertanyaan = $param->pertanyaan_2;
            $detailKuis->option_value = json_encode($param->option_value_2);

            $arrSoal = [];
            if ($param->hasFile('soal_img_2')) {
                foreach ($param->file('soal_img_2') as $soal) {
                    array_push($arrSoal, $soal->getClientOriginalName());
                    $nama_file = $soal->getClientOriginalName();
                    $soal->move('img/kuis/soal/', $nama_file);
                }
            }
            else{
                array_push($arrSoal, "");
            }

            $detailKuis->soal_img = json_encode($arrSoal);
            $detailKuis->save();
        }
        else if ($param->has('btnSama')) {
            $countDetailKuis = detailKuis::where('id_kuis', $id_kuis)->count('id_detail_kuis');
            $detailKuis = new detailKuis();
            $detailKuis->id_kuis = $id_kuis;
            $detailKuis->nomor_kuis = $countDetailKuis + 1;
            $detailKuis->jenis = 3;
            $detailKuis->pertanyaan = $param->pertanyaan_3;
            $detailKuis->option_value = $param->option_value_3;

            $arrSoal = [];
            if ($param->hasFile('soal_img_3')) {
                foreach ($param->file('soal_img_3') as $soal) {
                    array_push($arrSoal, $soal->getClientOriginalName());
                    $nama_file = $soal->getClientOriginalName();
                    $soal->move('img/kuis/soal/', $nama_file);
                }
            }
            else{
                array_push($arrSoal, "");
            }
            $detailKuis->soal_img = json_encode($arrSoal);
            $detailKuis->groupkey = 1;
            $detailKuis->save();
        }
        return $id_kuis;
    }

    function editDetailKuis($param, $id_detail_kuis) {
        $tipeSoal = detailKuis::where("id_detail_kuis", $id_detail_kuis)->value('jenis');

        // dd($old_jawaban_urut);
        if ($tipeSoal == 1) {
            $arrSoal = [];
            if ($param->hasFile('soal_img_1')) {
                foreach ($param->file('soal_img_1') as $soal) {
                    array_push($arrSoal, $soal->getClientOriginalName());
                    $nama_file = $soal->getClientOriginalName();
                    $soal->move('img/kuis/soal/', $nama_file);
                }
                detailKuis::where("id_detail_kuis", $id_detail_kuis)->update([
                    "soal_img" => json_encode($arrSoal),
                ]);
            }

            detailKuis::where("id_detail_kuis", $id_detail_kuis)->update([
                "pertanyaan" => $param->pertanyaan_1,
                "option_value" => json_encode($param->option_value_1),
            ]);
        }
        elseif ($tipeSoal == 2) {
            $arrSoal = [];
            if ($param->hasFile('soal_img_2')) {
                foreach ($param->file('soal_img_2') as $soal) {
                    array_push($arrSoal, $soal->getClientOriginalName());
                    $nama_file = $soal->getClientOriginalName();
                    $soal->move('img/kuis/soal/', $nama_file);
                }
                detailKuis::where("id_detail_kuis", $id_detail_kuis)->update([
                    "soal_img" => json_encode($arrSoal),
                ]);
            }

            detailKuis::where("id_detail_kuis", $id_detail_kuis)->update([
                "pertanyaan" => $param->pertanyaan_2,
                "option_value" => json_encode($param->option_value_2),
            ]);
        }
        elseif ($tipeSoal == 3) {
            $arrSoal = [];
            if ($param->hasFile('soal_img_3')) {
                foreach ($param->file('soal_img_3') as $soal) {
                    array_push($arrSoal, $soal->getClientOriginalName());
                    $nama_file = $soal->getClientOriginalName();
                    $soal->move('img/kuis/soal/', $nama_file);
                }
                detailKuis::where("id_detail_kuis", $id_detail_kuis)->update([
                    "soal_img" => json_encode($arrSoal),
                ]);
            }
            detailKuis::where("id_detail_kuis", $id_detail_kuis)->update([
                "pertanyaan" => $param->pertanyaan_3,
                "option_value" => $param->option_value_3,
                "groupkey" => 1,
            ]);
        }
        return $id_detail_kuis;
    }

    function ubahBatasWaktu($param){
        Kuis::where('id_kuis', $param->id_kuis)->update([
            "batas_waktu" => $param->batas_waktu
        ]);
    }

    function deleteDetailKuis($id_detail_kuis) {
        detailKuis::where('id_detail_kuis', $id_detail_kuis)->delete();
        return $id_detail_kuis;
    }
}
