<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Anak;
use App\Models\detailAgenda;
use App\Models\detailKelas;
use App\Models\detailKuis;
use App\Models\detailMateri;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Kuis;
use App\Models\Mapel;
use App\Models\Materi;
use App\Models\nilaiKuis;
use App\Models\Notifikasi;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnakController extends Controller
{
    public function pengumuman() {
        $dataNotifikasi = [];
        $getAnakData = Anak::where('nis', session()->get('login')->username)->first();
        $getID = detailKelas::where('nis', $getAnakData->nis)->where('id_kelas', $getAnakData->kelas)->value('id_detailsiswa');
        $listNotifikasi = Notifikasi::join('detail_kelas', 'notifikasi.id_anak', '=', 'detail_kelas.id_detailsiswa')->select('notifikasi.*')->where('detail_kelas.id_detailsiswa', $getID)->get();

        foreach ($listNotifikasi as $notif) {
            if ($notif->jenis == 0) {
                $status = Materi::where('id_materi', $notif->id_reference)->value('status');
                if ($status == 1) {
                    $dataNotifikasi = Notifikasi::join('detail_kelas', 'notifikasi.id_anak', '=', 'detail_kelas.id_detailsiswa')->select('notifikasi.*')->where('detail_kelas.id_detailsiswa', $getID)->orderByDesc('created_at')->get();
                }
            }
            else if ($notif->jenis == 1) {
                $status = Kuis::where('id_kuis', $notif->id_reference)->value('status');
                if ($status == 1) {
                    $dataNotifikasi = Notifikasi::join('detail_kelas', 'notifikasi.id_anak', '=', 'detail_kelas.id_detailsiswa')->select('notifikasi.*')->where('detail_kelas.id_detailsiswa', $getID)->orderByDesc('created_at')->get();
                }
            }
            else if ($notif->jenis == 2) {
                $dataNotifikasi = Notifikasi::join('detail_kelas', 'notifikasi.id_anak', '=', 'detail_kelas.id_detailsiswa')->select('notifikasi.*')->where('detail_kelas.id_detailsiswa', $getID)->orderByDesc('created_at')->get();
            }
        }
        return view("anak.pengumuman", [
            "dataNotifikasi" => $dataNotifikasi,
        ]);
    }

    public function isiPengumuman(Request $request){
        $getAnakData = Anak::where('nis', session()->get('login')->username)->first();
        $getID = detailKelas::where('nis', $getAnakData->nis)->where('id_kelas', $getAnakData->kelas)->value('id_detailsiswa');
        $listNotifikasi = Notifikasi::join('detail_kelas', 'notifikasi.id_anak', '=', 'detail_kelas.id_detailsiswa')->select('notifikasi.*')->where('detail_kelas.id_detailsiswa', $getID)->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"), '=', $request->mode)->get();
        $arr = [];
        foreach ($listNotifikasi as $notif) {
            array_push($arr, $notif);
        }
        return json_encode($arr);
    }

    public function statusPengumuman(Request $request) {
        $notifikasi = new Notifikasi();
        $notifikasi->linkNotifikasi($request);

        $listNotifikasi = Notifikasi::where('id_reference', $request->id_reference)->where('jenis', $request->jenis)->get();
        foreach ($listNotifikasi as $notif) {
            // dd($notif->jenis);
            $notif->mapel = '';
            if ($notif->jenis == 0) {
                $id_mapel = Materi::where('id_materi', $notif->id_reference)->value('fk_mapel');
                $notif->mapel = Mapel::where('id_mapel', $id_mapel)->value('nama_mapel');
                return redirect('/anak/mapel/'.$notif->mapel.'/materi/'.$notif->id_reference);
            }
            else if ($notif->jenis == 1){
                $id_mapel = Kuis::where('id_kuis', $notif->id_reference)->value('id_mapel');
                $notif->mapel = Mapel::where('id_mapel', $id_mapel)->value('nama_mapel');
                return redirect('/anak/mapel/'.$notif->mapel.'/kuis/'.$notif->id_reference);
            }
            else if ($notif->jenis == 2){
                $tglAktif = Agenda::where('id_agenda', $notif->id_reference)->value('tanggal');
                $listAgenda = Agenda::all();
                return redirect("anak/agenda")->with([
                    "listAgenda" => $listAgenda,
                    "tglAktif" => $tglAktif,
                ]);
            }
        }
    }

    public function tampilanKelas() {
        $dataAnak = Anak::where('nis', session()->get('login')->username)->first();
        $dataKelas = Anak::where('kelas', $dataAnak->kelas)->get();
        $guru = Kelas::join('guru', 'guru.username', '=', 'kelas.wali_kelas')->select('guru.*')->where('kelas.id_kelas', $dataAnak->kelas)->first();
        $namaKelas = Kelas::where('id_kelas', $dataAnak->kelas)->value('nama_kelas');
        $tahunSekarang = (int)Carbon::now()->format('Y');
        $getTahun = $guru->tgl_lahir;
        $tahunLahir = (int)substr($getTahun, 0, 4);
        $umur =$tahunSekarang - $tahunLahir;

        return view("anak.kelas", [
            "dataAnak" => $dataAnak,
            "dataKelas" => $dataKelas,
            "namaKelas" => $namaKelas,
            "guru" => $guru,
            "umur" => $umur,
        ]);
    }

    public function listMapel() {
        $listMapel = Mapel::all();
        $bulanSekarang = Carbon::now()->format('m');

        return view("anak.mapel", [
            "listMapel" => $listMapel,
            "bulanSekarang" => $bulanSekarang,
        ]);
    }

    public function listMateri($id) {
        $bulanSekarang = Carbon::now()->format('m');
        $mapel = Mapel::where('nama_mapel', $id)->value('id_mapel');
        $listMateri = Materi::join('anak', 'materi.fk_kelas', '=', 'anak.kelas')->where('materi.fk_mapel', $mapel)->where('anak.nis', session()->get('login')->username)->where('materi.status', 1)->whereMonth('created_at', $bulanSekarang)->get();
        $arrNoBulan = ['7', '8', '9', '10', '11', '12', '1', '2', '3', '4', '5', '6'];
        $arrNamaBulan = ['Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'];

        return view("anak.materi", [
            "listMateri" => $listMateri,
            "id" => $id,
            "bulan" => $bulanSekarang,
            "arrNoBulan" => $arrNoBulan,
            "arrNamaBulan" => $arrNamaBulan,
        ]);
    }

    public function detailMateri($id, $id_materi) {
        $materi = Materi::where('id_materi', $id_materi)->first();
        $detailMateri = detailMateri::join('materi', 'detail_materi.id_materi', '=', 'materi.id_materi')->where('materi.id_materi', $id_materi)->get();

        // dd($detailMateri);
        return view("anak.detailMateri", [
            "id" => $id,
            "materi" => $materi,
            "detailMateri" => $detailMateri,
        ]);
    }

    public function listKuis($id) {
        $bulanSekarang = Carbon::now()->format('m');
        $mapel = Mapel::where('nama_mapel', $id)->value('id_mapel');
        $listKuis = Kuis::join('anak', 'kuis.id_kelas', '=', 'anak.kelas')->where('kuis.id_mapel', $mapel)->where('anak.nis', session()->get('login')->username)->where('kuis.status', 1)->whereMonth('created_at', $bulanSekarang)->get();
        $arrNoBulan = ['7', '8', '9', '10', '11', '12', '1', '2', '3', '4', '5', '6'];
        $arrNamaBulan = ['Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'];

        return view("anak.kuis", [
            "listKuis" => $listKuis,
            "id" => $id,
            "bulan" => $bulanSekarang,
            "arrNoBulan" => $arrNoBulan,
            "arrNamaBulan" => $arrNamaBulan,
        ]);
    }

    public function listDetailKuis($id, $id_kuis) {
        $kuis = Kuis::where('id_kuis', $id_kuis)->first();
        $kelasAnak = Anak::where('nis', session()->get('login')->username)->value('kelas');
        $hasilKuis = nilaiKuis::join('detail_kelas', 'nilai_kuis.id_detailsiswa', '=', 'detail_kelas.id_detailsiswa')->where('detail_kelas.nis', session()->get('login')->username)->where('detail_kelas.id_kelas', $kelasAnak)->where('nilai_kuis.id_kuis', $id_kuis)->first();
        $nilaiKuis = nilaiKuis::join('detail_kelas', 'nilai_kuis.id_detailsiswa', '=', 'detail_kelas.id_detailsiswa')->where('detail_kelas.nis', session()->get('login')->username)->where('detail_kelas.id_kelas', $kelasAnak)->where('nilai_kuis.id_kuis', $id_kuis)->get();
        // dd($kuis);
        $listDetailKuis = '';
        for ($i=0; $i < count($nilaiKuis); $i++) {
            $arrSoal = json_decode($nilaiKuis[$i]->urutan_soal);
            $arrJwb = json_decode($nilaiKuis[$i]->jawaban);
            $listDetailKuis = [];
            for($j = 0; $j < count($arrSoal); $j++) {
                $detailKuis = detailKuis::where('id_detail_kuis', $arrSoal[$j])->get();
                foreach($detailKuis as $rowKuis) {
                    $rowKuis->jwbnAnak = $arrJwb[$j];
                    array_push($listDetailKuis, $rowKuis);
                }
            }
        }

        return view("anak.detailKuis", [
            "kuis" => $kuis,
            "id" => $id,
            "hasilKuis" => $hasilKuis,
            "listDetailKuis" => $listDetailKuis,
        ]);
    }

    public function ambilKuis($id, $id_kuis) {
        $detailKuis     = detailKuis::where('id_kuis', $id_kuis)->get();
        // $ambilJawaban   = detailKuis::where('id_kuis', $id_kuis)->value('option_value');
        // $soal_img       = detailKuis::where('id_kuis', $id_kuis)->value('soal_img');

        // random urutan soal
        for($i = 0; $i < 10000; $i++) {
            $pos1 = rand(1, count($detailKuis)) - 1;
            $pos2 = rand(1, count($detailKuis)) - 1;

            $temp = $detailKuis[$pos1];
            $detailKuis[$pos1] = $detailKuis[$pos2];
            $detailKuis[$pos2] = $temp;
        }

        // random jawaban
        for($i = 0; $i < count($detailKuis); $i++) {
            if($detailKuis[$i]->jenis == 1) {
                $detailKuis[$i]->jawabanAsli = 0;
                $arrJwb = json_decode($detailKuis[$i]->option_value);
                for($j = 0; $j < 10000; $j++) {
                    $pos1 = rand(1, count($arrJwb)) - 1;
                    $pos2 = rand(1, count($arrJwb)) - 1;
                    if($pos1 == $detailKuis[$i]->jawabanAsli) { $detailKuis[$i]->jawabanAsli = $pos2; }
                    else if($pos2 == $detailKuis[$i]->jawabanAsli) { $detailKuis[$i]->jawabanAsli = $pos1; }

                    $temp = $arrJwb[$pos1];
                    $arrJwb[$pos1] = $arrJwb[$pos2];
                    $arrJwb[$pos2] = $temp;
                }
                $detailKuis[$i]->option_value = json_encode($arrJwb);
            }
            else if($detailKuis[$i]->jenis == 2) {
                $detailKuis[$i]->jawabanAsli = $detailKuis[$i]->option_value;
                $arrJwb = json_decode($detailKuis[$i]->option_value);
                for($j = 0; $j < 10000; $j++) {
                    $pos1 = rand(1, count($arrJwb)) - 1;
                    $pos2 = rand(1, count($arrJwb)) - 1;
                    $temp = $arrJwb[$pos1];
                    $arrJwb[$pos1] = $arrJwb[$pos2];
                    $arrJwb[$pos2] = $temp;
                }
                $detailKuis[$i]->option_value = json_encode($arrJwb);
            }
            else if($detailKuis[$i]->jenis == 3) {
                $detailKuis[$i]->jawabanAsli = $detailKuis[$i]->option_value;
            }
        }
        // random jawaban untuk yg jenis = 3
        for($i = 0; $i < count($detailKuis); $i++) {
            if($detailKuis[$i]->jenis == 3) {
                for($j = 0; $j < 1000; $j++) {
                    $pos1 = rand(1, count($detailKuis)) - 1;
                    if($detailKuis[$pos1]->jenis == 3) {
                        $temp = $detailKuis[$i]->option_value;
                        $detailKuis[$i]->option_value = $detailKuis[$pos1]->option_value;
                        $detailKuis[$pos1]->option_value = $temp;
                    }
                }
            }
        }

        // bentuk string utk urutansoal dan urutanjawaban
        $urutanSoal = array();
        $urutanJawaban = array();
        $urutanJenis = array();
        for($i = 0; $i < count($detailKuis); $i++) {
            array_push($urutanSoal, $detailKuis[$i]->id_detail_kuis);
            array_push($urutanJawaban, $detailKuis[$i]->jawabanAsli);
            array_push($urutanJenis, $detailKuis[$i]->jenis);
        }
        return view("anak.ambilKuis", [
            "id" => $id,
            "id_kuis" => $id_kuis,
            "urutanSoal" => json_encode($urutanSoal),
            "urutanJawaban" => json_encode($urutanJawaban),
            "urutanJenis" => json_encode($urutanJenis),
            "detailKuis" => $detailKuis,
        ]);
    }

    public function jawabKuis($id, $id_kuis, Request $request) {
        $urutanSoal     = json_decode($request->urutanSoal);
        $urutanJawaban  = json_decode($request->urutanJawaban);
        $urutanJenis    = json_decode($request->urutanJenis);
        $jumlah_soal = detailKuis::where('id_kuis', $id_kuis)->count('id_detail_kuis');
        $nilai_soal = 100 / $jumlah_soal;

        print_r("<h5>".$request->urutanSoal."</h5>");
        print_r(count($urutanSoal));
        $jumMenyamakan = 0;
        $jumMengurutkan = 0;
        $jumBenar = 0;
        $jawabanUser = array();
        for($i = 0; $i < count($urutanSoal); $i++) {
            $id_detail_kuis = $urutanSoal[$i];
            $jawabanAsli = $urutanJawaban[$i];
            $jenisSoal = $urutanJenis[$i];
            // echo "<h2>".$detailKuis[$i]->jenis."</h2>";
            if($jenisSoal == 1) {
                $nodejwb     = explode("**", $request->input('jawabanKamu'.$id_detail_kuis));
                $jawabanKamu = intval($nodejwb[0]) - 1;
                if ($nodejwb[0] == "") {
                    $labelJawaban = '';
                }
                else{
                    $labelJawaban = $nodejwb[1];
                }
                echo "<h5>".$i."--- Jenis soal:".$jenisSoal."--- Jawaban Asli".$jawabanAsli."--- jawabanKamu".$jawabanKamu."</h5>";

                if($jawabanAsli == $jawabanKamu) {
                    $jumBenar+=1;
                }

                // dd($jawabanKamu);
                array_push($jawabanUser, $labelJawaban);
            }
            else if($jenisSoal == 2) {
                $jawabanKamu = $request->input('jwbUrut'.$jumMengurutkan);
                $jwbUrutanArray = $request->input('jwbUrutanArray'.$jumMengurutkan);
                echo "<h3> jawabanAsli".$jawabanAsli."---".$jawabanKamu."---".$jwbUrutanArray."</h3>";

                $arrjawabanKamu = explode(',',$jawabanKamu);
                $arrjwbUrutanArray = json_decode($jwbUrutanArray);
                $arrjawabanAsli = json_decode($jawabanAsli);
                $arr3 = array();
                for($k = 0; $k < count($arrjawabanKamu); $k++) {
                    array_push($arr3, $arrjwbUrutanArray[$arrjawabanKamu[$k]]);
                }

                $nilai_urutan = $nilai_soal / count($arrjwbUrutanArray);
                $urutanBenar = 0;
                $jawabanKamu = json_encode($arr3);
                echo "<h3>".$jawabanAsli."---".$jawabanKamu."</h3>";
                for ($k=0; $k < count($arrjwbUrutanArray); $k++) {
                    if ($arrjawabanAsli[$k] == $arrjwbUrutanArray[$k]) {
                        $urutanBenar++;
                    }
                }
                $totalNilaiUrutan = (float)number_format($nilai_urutan, 2) * $urutanBenar;
                if($jawabanAsli == $jawabanKamu) {
                    $jumBenar+=1;
                }
                array_push($jawabanUser, $jawabanKamu);
                $jumMengurutkan+=1;
            }
            else if($jenisSoal == 3) {
                $jawabanKamu = $request->input('jwb'.$jumMenyamakan);
                echo "<h3>".$jawabanAsli."---".$jawabanKamu."</h3>";

                if($jawabanAsli == $jawabanKamu) {
                    $jumBenar+=1;
                }

                array_push($jawabanUser, $jawabanKamu);
                $jumMenyamakan+=1;
            }
        }

        $nilaiKuis = new nilaiKuis();
        $result = $nilaiKuis->result($id_kuis, $jumBenar, $jawabanUser, $urutanSoal);

        if ($result){
            return redirect('anak/mapel/'.$id.'/kuis/'.$id_kuis)->with('success', 'Berhasil Mengerjakan Kuis');
        }
        else{
            return redirect('anak/mapel/'.$id.'/kuis/'.$id_kuis)->withErrors('Gagal Mengerjakan Kuis');
        }
    }

    public function filterBulanMateri($id, $bulan) {
        $arrNoBulan = ['7', '8', '9', '10', '11', '12', '1', '2', '3', '4', '5', '6'];
        $arrNamaBulan = ['Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'];
        $mapel = Mapel::where('nama_mapel', $id)->value('id_mapel');
        $listMateri = Materi::join('anak', 'materi.fk_kelas', '=', 'anak.kelas')->where('materi.fk_mapel', $mapel)->where('anak.nis', session()->get('login')->username)->where('materi.status', 1)->whereMonth('created_at', $bulan)->get();
        // dd($listMateri);

        return view("anak.materi", [
            "listMateri" => $listMateri,
            "bulan" => $bulan,
            "id" => $id,
            "arrNoBulan" => $arrNoBulan,
            "arrNamaBulan" => $arrNamaBulan,
        ]);
    }

    public function filterBulanKuis($id, $bulan) {
        $arrNoBulan = ['7', '8', '9', '10', '11', '12', '1', '2', '3', '4', '5', '6'];
        $arrNamaBulan = ['Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'];
        $mapel = Mapel::where('nama_mapel', $id)->value('id_mapel');
        $listKuis = Kuis::join('anak', 'kuis.id_kelas', '=', 'anak.kelas')->where('kuis.id_mapel', $mapel)->where('anak.nis', session()->get('login')->username)->where('kuis.status', 1)->whereMonth('created_at', $bulan)->get();

        return view("anak.kuis", [
            "listKuis" => $listKuis,
            "bulan" => $bulan,
            "id" => $id,
            "arrNoBulan" => $arrNoBulan,
            "arrNamaBulan" => $arrNamaBulan,
        ]);
    }

    public function tampilanAgenda() {
        $listAgenda = Agenda::all();
        $tglAktif = date('Y-m-d');
        return view("anak.agenda", [
            "listAgenda" => $listAgenda,
            "tglAktif" => $tglAktif,
        ]);
    }

    public function detailAgenda(Request $request) {
        $getAnakData = Anak::where('nis', session()->get('login')->username)->first();
        $kelas = detailKelas::where('nis', $getAnakData->nis)->where('id_kelas', $getAnakData->kelas)->value('id_kelas');
        $ag = new Agenda();
        $dataAgenda = $ag->getAgendaByTanggalAndKelas($request->mode, $kelas);
        $arr = [];
        foreach($dataAgenda as $agenda){
            $centang = $agenda->getSpecificAgenda;
            $agenda->checklist = $centang;
            array_push($arr, $agenda);
        }
        return json_encode($arr);
    }

    public function checklist(Request $request){
        $detailAgenda = new detailAgenda();
        $result = $detailAgenda->checklist($request);
        return $result;
    }

    public function checkCondition(Request $request){
        $detailAgenda = detailAgenda::join('agenda', 'detail_agenda.id_agenda', '=', 'agenda.id_agenda')
        ->where('agenda.id_agenda', $request->mode)->get();
        return $detailAgenda;
    }

    public function tampilanProfile() {
        $dataAnak = Anak::join('users', 'anak.nis', '=', 'users.username')->select('anak.*')
        ->where('users.username', session()->get('login')->username)->first();

        // dd($dataAnak);
        return view("anak.profile", [
            "dataAnak" => $dataAnak,
        ]);
    }
    public function editProfile(Request $request) {
        $anak = new Anak();
        $result = $anak->editProfileAnak($request);
        // dd($result);

        if ($result){
            return back()->with('success', 'Berhasil Edit Profile');
        }
        else{
            return back()->withErrors('Gagal Edit Profile');
        }
    }
}
