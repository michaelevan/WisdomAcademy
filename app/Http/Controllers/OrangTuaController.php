<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\aktivitasSubjek;
use App\Models\Anak;
use App\Models\Chat;
use App\Models\detailKelas;
use App\Models\detailKuis;
use App\Models\detailMateri;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\komentarNilai;
use App\Models\komentarSubjek;
use App\Models\Kuis;
use App\Models\Mapel;
use App\Models\Materi;
use App\Models\nilaiKuis;
use App\Models\nilaiRapor;
use App\Models\nilaiSubjek;
use App\Models\Orangtua;
use App\Models\Subjek;
use App\Models\Users;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrangTuaController extends Controller
{
    public function listMapel() {
        $listMapel = Mapel::all();
        $bulanSekarang = Carbon::now()->format('m');

        return view("orangTua.mapel", [
            "listMapel" => $listMapel,
            "bulanSekarang" => $bulanSekarang,
        ]);
    }

    public function listMateri($id) {
        $bulanSekarang = Carbon::now()->format('m');
        $mapel = Mapel::where('nama_mapel', $id)->value('id_mapel');
        $nis = Anak::where('orangtua', session()->get('login')->username)->value('nis');
        $listMateri = Materi::join('anak', 'materi.fk_kelas', '=', 'anak.kelas')->where('materi.fk_mapel', $mapel)->where('anak.nis', $nis)->where('materi.status', 1)->whereMonth('created_at', $bulanSekarang)->get();
        $arrNoBulan = ['7', '8', '9', '10', '11', '12', '1', '2', '3', '4', '5', '6'];
        $arrNamaBulan = ['Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'];

        return view("orangTua.materi", [
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
        return view("orangTua.detailMateri", [
            "id" => $id,
            "materi" => $materi,
            "detailMateri" => $detailMateri,
        ]);
    }

    public function listKuis($id) {
        $bulanSekarang = Carbon::now()->format('m');
        $mapel = Mapel::where('nama_mapel', $id)->value('id_mapel');
        $nis = Anak::where('orangtua', session()->get('login')->username)->value('nis');
        $listKuis = Kuis::join('anak', 'kuis.id_kelas', '=', 'anak.kelas')->where('kuis.id_mapel', $mapel)->where('anak.nis', $nis)->where('kuis.status', 1)->whereMonth('created_at', $bulanSekarang)->get();
        $arrNoBulan = ['7', '8', '9', '10', '11', '12', '1', '2', '3', '4', '5', '6'];
        $arrNamaBulan = ['Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'];

        return view("orangTua.kuis", [
            "listKuis" => $listKuis,
            "id" => $id,
            "bulan" => $bulanSekarang,
            "arrNoBulan" => $arrNoBulan,
            "arrNamaBulan" => $arrNamaBulan,
        ]);
    }

    public function listDetailKuis($id, $id_kuis) {
        $kuis = Kuis::where('id_kuis', $id_kuis)->first();
        $nis = Anak::where('orangtua', session()->get('login')->username)->value('nis');
        $kelasAnak = Anak::where('nis', $nis)->value('kelas');
        $hasilKuis = nilaiKuis::join('detail_kelas', 'nilai_kuis.id_detailsiswa', '=', 'detail_kelas.id_detailsiswa')->where('detail_kelas.nis', $nis)->where('detail_kelas.id_kelas', $kelasAnak)->where('nilai_kuis.id_kuis', $id_kuis)->first();
        $nilaiKuis = nilaiKuis::join('detail_kelas', 'nilai_kuis.id_detailsiswa', '=', 'detail_kelas.id_detailsiswa')->where('detail_kelas.nis', $nis)->where('detail_kelas.id_kelas', $kelasAnak)->where('nilai_kuis.id_kuis', $id_kuis)->get();
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
        return view("orangTua.detailKuis", [
            "kuis" => $kuis,
            "id" => $id,
            "hasilKuis" => $hasilKuis,
            "listDetailKuis" => $listDetailKuis,
        ]);
    }

    public function filterBulanMateri($id, $bulan) {
        $arrNoBulan = ['7', '8', '9', '10', '11', '12', '1', '2', '3', '4', '5', '6'];
        $arrNamaBulan = ['Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'];
        $mapel = Mapel::where('nama_mapel', $id)->value('id_mapel');
        $nis = Anak::where('orangtua', session()->get('login')->username)->value('nis');
        $listMateri = Materi::join('anak', 'materi.fk_kelas', '=', 'anak.kelas')->where('materi.fk_mapel', $mapel)->where('anak.nis', $nis)->where('materi.status', 1)->whereMonth('created_at', $bulan)->get();
        // dd($listMateri);

        return view("orangTua.materi", [
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
        $nis = Anak::where('orangtua', session()->get('login')->username)->value('nis');
        $listKuis = Kuis::join('anak', 'kuis.id_kelas', '=', 'anak.kelas')->where('kuis.id_mapel', $mapel)->where('anak.nis', $nis)->where('kuis.status', 1)->whereMonth('created_at', $bulan)->get();
        // dd($listKuis);

        return view("orangTua.kuis", [
            "listKuis" => $listKuis,
            "bulan" => $bulan,
            "id" => $id,
            "arrNoBulan" => $arrNoBulan,
            "arrNamaBulan" => $arrNamaBulan,
        ]);
    }

    public function tampilanAgenda() {
        $listAgenda = Agenda::all();
        return view("orangTua.agenda", [
            "listAgenda" => $listAgenda,
        ]);
    }

    public function detailAgenda(Request $request) {
        $getAnakData = Anak::where('orangtua', session()->get('login')->username)->first();
        $kelas = detailKelas::where('nis', $getAnakData->nis)->where('id_kelas', $getAnakData->kelas)->value('id_kelas');
        $ag = new Agenda();
        $dataAgenda = $ag->getAgendaByTanggalAndKelas($request->mode, $kelas);
        $arr = [];
        foreach($dataAgenda as $agenda){
            $centang = $agenda->getSpecificAgendaOrtu;
            $agenda->checklist = $centang;
            array_push($arr, $agenda);
        }
        return json_encode($arr);
    }

    public function tampilanEvaluasi() {
        $dataOrangtua = Anak::join('orangtua', 'anak.orangtua', '=', 'orangtua.username')->select('anak.*', 'orangtua.*', 'anak.nama as namaAnak')->where('orangtua.username', session()->get('login')->username)->first();
        $nama_kelas = Kelas::where('id_kelas', $dataOrangtua->kelas)->value('nama_kelas');
        $listKelas = detailKelas::join('anak', 'detail_kelas.nis', '=', 'anak.nis')->join('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')->where('detail_kelas.nis', $dataOrangtua->nis)->get();
        $semester = null;

        return view("orangTua.evaluasi", [
            "dataOrangtua" => $dataOrangtua,
            "nama_kelas" => $nama_kelas,
            "listKelas" => $listKelas,
            "semester" => $semester,
        ]);
    }

    public function evaluasiData(Request $request) {
        if ($request->has('btnFilter')) {
            if ($request->pilihKelas != null && $request->pilihSemester != null) {
                $dataOrangtua = Anak::join('orangtua', 'anak.orangtua', '=', 'orangtua.username')->select('anak.*', 'orangtua.*', 'anak.nama as namaAnak')->where('orangtua.username', session()->get('login')->username)->first();
                $kelas = Kelas::where('id_kelas', $dataOrangtua->kelas)->value('nama_kelas');
                $listKelas = detailKelas::join('anak', 'detail_kelas.nis', '=', 'anak.nis')->join('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')->where('detail_kelas.nis', $dataOrangtua->nis)->get();
                $listKelasNow = Kelas::where('id_kelas', $request->pilihKelas)->first();
                $listSubjek = Subjek::all();
                $listMapel = Mapel::all();
                $id_detailsiswa = detailKelas::where('nis', $dataOrangtua->nis)->where('id_kelas', $request->pilihKelas)->value('id_detailsiswa');
                $nama_kelas = detailKelas::join('anak', 'detail_kelas.nis', '=', 'anak.nis')->join('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')->where('detail_kelas.nis', $dataOrangtua->nis)->where('id_detailsiswa', $request->pilihKelas)->value('kelas.nama_kelas');
                // dd($nama_kelas);
                foreach ($listMapel as $mapel) {
                    $mapel->nilai = '';
                    if ($request->pilihSemester == 1) {
                        $nilaiRapor = nilaiRapor::where('id_mapel', $mapel->id_mapel)->where('id_detailsiswa', $id_detailsiswa)->where('semester', 1)->get();
                    }
                    else if ($request->pilihSemester == 2){
                        $nilaiRapor = nilaiRapor::where('id_mapel', $mapel->id_mapel)->where('id_detailsiswa', $id_detailsiswa)->where('semester', 2)->get();
                    }
                    foreach($nilaiRapor as $rapor) {
                        $mapel->nilai = $rapor->nilai;
                    }
                }
                $dataKomentar = komentarNilai::where('id_detailsiswa', $id_detailsiswa)->where('semester', $request->pilihSemester)->first();
                return view("orangTua.evaluasi", [
                    "kelas" => $kelas,
                    "nama_kelas" => $nama_kelas,
                    "listKelas" => $listKelas,
                    "listKelasNow" => $listKelasNow,
                    "dataOrangtua" => $dataOrangtua,
                    "listSubjek" => $listSubjek,
                    "listMapel" => $listMapel,
                    "dataKomentar" => $dataKomentar,
                    "semester" => $request->pilihSemester,
                ]);
            }
            else{
                return back()->withErrors('Pilih Kelas dan Semester Terlebih Dahulu');
            }
        }
    }

    public function tampilanProfile() {
        $dataOrangtua = Orangtua::join('users', 'orangtua.username', '=', 'users.username')->where('users.username', session()->get('login')->username)->first();
        return view("orangTua.profile", [
            "dataOrangtua" => $dataOrangtua
        ]);
    }
    public function editProfile(Request $request) {
        $listUsers = Users::all();
        $orangtua = Users::where('username', session()->get('login')->username)->value('email');
        $idx = false;
        foreach ($listUsers as $users) {
            if ($users->email == $request->email && $users->email != $orangtua) {
                $idx = true;
            }
        }
        if ($idx) {
            return back()->with('errors', 'email sudah dipakai dan tidak boleh sama');
        }
        else if($request->password != $request->konfirmasiPassword) {
            return back()->with('errors', 'password harus sama dengan konfirmasi password');
        }
        else{
            $pesan = [
                'akte_lahir.max' => 'ukuran foto tidak boleh lebih dari 2MB',
                'kartu_keluarga.max' => 'ukuran foto tidak boleh lebih dari 2MB',
                'no_hp.numeric' => 'nomor hp harus berisikan angka',
            ];
            $request->validate([
                "nik" => "unique:guru,nik|numeric",
                "no_identitas" => "nullable|unique:guru,no_identitas|numeric",
                "no_hp" => "numeric",
                "akte_lahir" => "max:2048",
                "kartu_keluarga" => "max:2048",
            ], $pesan);
            $orangTua = new Orangtua();
            $result = $orangTua->editProfileOrtu($request);

            if ($result){
                return back()->with('success', 'Berhasil Edit Profile');
            }
            else{
                return back()->withErrors('Gagal Edit Profile');
            }
        }
    }

    public function tampilanChat() {
        $usernameGuru = Kelas::join('anak', 'kelas.id_kelas', '=', 'anak.kelas')->where('anak.orangtua', session()->get('login')->username)->value('kelas.wali_kelas');
        $dataGuru = Guru::where('username', $usernameGuru)->first();
        $userLogin = Anak::where('orangtua', session()->get('login')->username)->value('nis');
        // dd($dataGuru);
        return view("orangTua.chat", [
            "dataGuru" => $dataGuru,
            "userLogin" => $userLogin,
        ]);
    }

    public function getchatting($usernameGuru) {
        $nis = Anak::where('orangtua', session()->get('login')->username)->value('nis');
        $listChat = Chat::select('chat.*')
        ->orWhere(function($query) use ($nis, $usernameGuru){
        $query->where('username1', '=', $usernameGuru);
        $query->where('username2', '=', $nis);
        })
        ->orWhere(function($query) use ($nis, $usernameGuru){
        $query->where('username1', '=', $nis);
        $query->where('username2', '=', $usernameGuru);
        })
        ->get();
        return json_encode($listChat);
    }

    public function sendchatting(Request $request) {
        $chat = new Chat();
        $result = $chat->chatOrtu($request);

        if ($result) {
            return 'berhasil tambah chat';
        }
        else{
            return 'gagal tambah chat';
        }
    }

    public function pilihSubjek(Request $request) {
        $nis = $request->nis;
        $kelas = $request->kelas;
        $id_detailsiswa = detailKelas::where('nis', $nis)->where('id_kelas', $kelas)->value('id_detailsiswa');
        $dataAktivitasSubjek = aktivitasSubjek::where('id_subjek', $request->id_subjek)->get();
        $arr = [];
        foreach($dataAktivitasSubjek as $aktivitas){
            $aktivitas->nilai = '';
            $aktivitas->perilaku = '';
            $dataNilai = nilaiSubjek::where('id_detailsiswa', $id_detailsiswa)->where('id_aktivitas', $aktivitas->id_aktivitas)->where('semester', $request->semester)->get();
            $aktivitas->komentar = komentarSubjek::where('id_detailsiswa', $id_detailsiswa)->where('id_subjek', $request->id_subjek)->where('semester', $request->semester)->value('komentar');
            foreach($dataNilai as $rowNilai) {
                $aktivitas->nilai = $rowNilai->scoring;
                $aktivitas->perilaku = $rowNilai->behaviour;
            }
            array_push($arr, $aktivitas);
        }
        return json_encode($arr);
    }

    public function printLaporan($id_kelas, $semester)
    {
        $dataOrangtua = Anak::join('orangtua', 'anak.orangtua', '=', 'orangtua.username')->select('anak.*', 'orangtua.*', 'anak.nama as namaAnak')->where('orangtua.username', session()->get('login')->username)->first();
        $kelas = Kelas::where('id_kelas', $id_kelas)->first();
        $listSubjek = Subjek::all();
        $listMapel = Mapel::all();
        $id_detailsiswa = detailKelas::where('nis', $dataOrangtua->nis)->where('id_kelas', $id_kelas)->value('id_detailsiswa');
        foreach ($listMapel as $mapel) {
            $mapel->nilai = '';
            $nilaiRapor = nilaiRapor::where('id_mapel', $mapel->id_mapel)->where('id_detailsiswa', $id_detailsiswa)->where('semester', $semester)->get();
            foreach($nilaiRapor as $rapor) {
                $mapel->nilai = $rapor->nilai;
            }
        }
        $arr = [];
        foreach ($listSubjek as $subjek) {
            $subjek->komentar = komentarSubjek::where('id_detailsiswa', $id_detailsiswa)->where('semester', $semester)->where('id_subjek', $subjek->id_subjek)->value('komentar');
            $listAktivitas = aktivitasSubjek::where('id_subjek', $subjek->id_subjek)->get();
            $arrAktivitas = [];
            foreach ($listAktivitas as $aktivitas) {
                $dataNilai = nilaiSubjek::where('id_detailsiswa', $id_detailsiswa)->where('id_aktivitas', $aktivitas->id_aktivitas)->where('semester', $semester)->get();
                $aktivitas->nilai = '';
                $aktivitas->perilaku = '';
                foreach ($dataNilai as $rowNilai) {
                    $aktivitas->nilai = $rowNilai->scoring;
                    $aktivitas->perilaku = $rowNilai->behaviour;
                }
                array_push($arrAktivitas, $aktivitas);
            }
            $subjek->aktivitas = $arrAktivitas;
            array_push($arr, $subjek);
        }
        // dd($arr);
        $komentarRapor = komentarNilai::where('id_detailsiswa', $id_detailsiswa)->where('semester', $semester)->first();
        return view("orangTua.printLaporan", [
            "kelas" => $kelas,
            "dataOrangtua" => $dataOrangtua,
            "listSubjek" => $listSubjek,
            "listMapel" => $listMapel,
            "komentarRapor" => $komentarRapor,
            "semester" => $semester,
        ]);

    }
}
