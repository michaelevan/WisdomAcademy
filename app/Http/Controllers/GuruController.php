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
use Carbon\Carbon;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function tampilanProfile() {
        $dataGuru = Guru::join('users', 'users.username', '=', 'guru.username')->where('users.username', session()->get('login')->username)->first();
        return view("guru.profile", [
            "dataGuru" => $dataGuru,
        ]);
    }
    public function editProfile(Request $request) {
        if ($request->input("password") != $request->input("konfirmasiPassword")) {
            return back()->with('errors', 'Password harus sama dengan konfirmasi password');
        }
        else {
            $pesan = [
                'foto.max' => 'ukuran foto tidak boleh lebih dari 2MB',
            ];
            $request->validate([
                'foto' => 'max:2048'
            ], $pesan);
            $guru = new Guru();
            $result = $guru->updateProfile($request);

            if ($result){
                return back()->with('success', 'Berhasil Edit Profile');
            }
            else{
                return back()->withErrors('Gagal Edit Profile');
            }
        }
    }

    public function tampilanKelas() {
        $listKelas = Anak::join('kelas', 'anak.kelas', '=', 'kelas.id_kelas')->join('tahun_ajaran', 'kelas.tahun_ajaran', '=', 'tahun_ajaran.tahun_ajaran')->where('kelas.wali_kelas', session()->get('login')->username)->where('tahun_ajaran.status', 1)->get();
        $kelasBerapa = Kelas::join('tahun_ajaran', 'kelas.tahun_ajaran', '=', 'tahun_ajaran.tahun_ajaran')->where('wali_kelas', session()->get('login')->username)->where('tahun_ajaran.status', 1)->value('nama_kelas');


        return view("guru.kelas", [
            "kelasBerapa" => $kelasBerapa,
            "listKelas" => $listKelas,
        ]);
    }
    public function kelasData(Request $request) {
        if ($request->input("password") != $request->input("konfirmasiPassword")) {
            return back()->with('errors', 'Password harus sama dengan konfirmasi password');
        }
        else {
            $guru = new Guru();
            $result = $guru->updateProfile($request);

            if ($result){
                return back()->with('success', 'Berhasil Edit Profile');
            }
            else{
                return back()->withErrors('Gagal Edit Profile');
            }
        }
    }

    public function tampilanDetailKelas($id) {
        $kelas = Kelas::join('detail_kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')->join('tahun_ajaran', 'tahun_ajaran.tahun_ajaran', '=', 'kelas.tahun_ajaran')->where('detail_kelas.nis', $id)->where('tahun_ajaran.status', 1)->first();
        $dataAnak = Orangtua::join('anak', 'anak.orangtua', '=', 'orangtua.username')->select('anak.*', 'orangtua.*', 'anak.nama as namaAnak')->where('anak.nis', $id)->first();
        $semester = null;
        return view("guru.detailKelas", [
            "kelas" => $kelas,
            "dataAnak" => $dataAnak,
            "semester" => $semester,
        ]);
    }

    public function detailKelasData(Request $request, $id) {
        if ($request->has('btnSemester')) {
            $kelas = Kelas::join('detail_kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')->join('tahun_ajaran', 'tahun_ajaran.tahun_ajaran', '=', 'kelas.tahun_ajaran')->where('detail_kelas.nis', $id)->where('tahun_ajaran.status', 1)->first();
            $dataAnak = Orangtua::join('anak', 'anak.orangtua', '=', 'orangtua.username')->select('anak.*', 'orangtua.*', 'anak.nama as namaAnak')->where('anak.nis', $id)->first();
            $listSubjek = Subjek::all();
            $listMapel = Mapel::all();
            $id_detailsiswa = detailKelas::where('nis', $dataAnak->nis)->where('id_kelas', $dataAnak->kelas)->value('id_detailsiswa');
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
            return view("guru.detailKelas", [
                "id" => $id,
                "kelas" => $kelas,
                "dataAnak" => $dataAnak,
                "listSubjek" => $listSubjek,
                "listMapel" => $listMapel,
                "dataKomentar" => $dataKomentar,
                "id_detailsiswa" => $id_detailsiswa,
                "semester" => $request->pilihSemester,
            ]);
        }
    }

    public function listMapel() {
        $listMapel = Mapel::all();

        return view("guru.mapel", [
            "listMapel" => $listMapel,
        ]);
    }

    public function listMateri($id) {
        $fk_kelas = Kelas::join('tahun_ajaran', 'kelas.tahun_ajaran', '=', 'tahun_ajaran.tahun_ajaran')->where('tahun_ajaran.status', 1)->where('wali_kelas', session()->get('login')->username)->value('id_kelas');
        $mapel = Mapel::where('nama_mapel', $id)->value('id_mapel');
        $listMateri = Materi::where('fk_mapel', $mapel)->where('fk_kelas', $fk_kelas)->get();
        return view("guru.materi", [
            "listMateri" => $listMateri,
            "id" => $id,
        ]);
    }

    public function materiData(Request $request, $id) {
        if($request->has('btnPublish')) {
            $materi = new Materi();
            $result = $materi->publishMateri($request);
            if ($result){
                return redirect()->back()->with("success", "Berhasil Publish Materi!");
            }
            else{
                return redirect()->back()->withErrors("Gagal Publish Materi!");
            }
        }
        else {
            $pesan = [
                'nama_file.max' => 'ukuran tiap file tidak boleh lebih dari 5MB',
            ];
            $request->validate([
                'nama_file.*' => 'max:5048'
            ], $pesan);
            $materi = new Materi();
            $result = $materi->tambahMateri($request, $id);

            if ($result){
                return redirect()->back()->with("success", "Berhasil Buat Materi Baru!");
            }
            else{
                return redirect()->back()->withErrors("Gagal Buat Materi Baru!");
            }
        }
    }

    public function editMateri($id, $id_materi) {
        $detailMateri = detailMateri::join('materi', 'materi.id_materi', '=', 'detail_materi.id_materi')->where('materi.id_materi', $id_materi)->first();
        $gambarMateri = detailMateri::join('materi', 'detail_materi.id_materi', '=', 'materi.id_materi')->where('materi.id_materi', $id_materi)->get();

        return view("guru.ubahMateri", [
            "detailMateri" => $detailMateri,
            "gambarMateri" => $gambarMateri,
            "id" => $id,
        ]);
    }

    public function editMateriData(Request $request, $id, $id_materi) {
        $materi = new Materi();
        $result = $materi->editMateri($request, $id_materi);

        if ($result){
            return redirect()->back()->with("success", "Berhasil Ubah Materi!");
        }
        else{
            return redirect()->back()->withErrors("Gagal Ubah Materi!");
        }
    }

    public function listMateriLama($id) {
        $fk_kelas = Kelas::join('tahun_ajaran', 'kelas.tahun_ajaran', '=', 'tahun_ajaran.tahun_ajaran')->where('kelas.wali_kelas', session()->get('login')->username)->where('tahun_ajaran.status', 1)->value('kelas.id_kelas');
        $mapel = Mapel::where('nama_mapel', $id)->value('id_mapel');
        $listMateriLama = Materi::join('kelas', 'materi.fk_kelas', '=', 'kelas.id_kelas')->join('guru', 'kelas.wali_kelas', '=', 'guru.username')->where('materi.fk_mapel', $mapel)->orderByDesc('materi.updated_at')->get();
        $listKuis = Kuis::where('id_mapel', $mapel)->where('id_kelas', $fk_kelas)->get();

        return view("guru.materiLama", [
            "listMateriLama" => $listMateriLama,
            "listKuis" => $listKuis,
            "fk_kelas" => $fk_kelas,
            "id" => $id,
        ]);
    }

    public function detailMateriLama($id, $id_materi) {
        $detailMateri = detailMateri::join('materi', 'materi.id_materi', '=', 'detail_materi.id_materi')->where('materi.id_materi', $id_materi)->first();
        $gambarMateri = detailMateri::join('materi', 'detail_materi.id_materi', '=', 'materi.id_materi')->where('materi.id_materi', $id_materi)->get();

        return view("guru.detailMateriLama", [
            "detailMateri" => $detailMateri,
            "gambarMateri" => $gambarMateri,
            "id" => $id,
        ]);
    }

    public function detailMateriLamaData(Request $request, $id, $id_materi) {
        $materi = new Materi();
        $result = $materi->reuseMateri($request, $id, $id_materi);

        if ($result){
            return redirect('guru/mapel/'.$id.'/materiLama')->with("success", "Berhasil Reuse Materi!");
        }
        else{
            return redirect('guru/mapel/'.$id.'/materiLama')->withErrors("Gagal Reuse Materi!");
        }
    }

    public function listKuis($id) {
        $fk_kelas = Kelas::join('tahun_ajaran', 'kelas.tahun_ajaran', '=', 'tahun_ajaran.tahun_ajaran')->where('tahun_ajaran.status', 1)->where('wali_kelas', session()->get('login')->username)->value('id_kelas');
        $mapel = Mapel::where('nama_mapel', $id)->value('id_mapel');
        $listKuis = Kuis::where('id_mapel', $mapel)->where('id_kelas', $fk_kelas)->get();

        return view("guru.kuis", [
            "listKuis" => $listKuis,
            "id" => $id,
        ]);
    }

    public function kuisData(Request $request, $id) {
        if ($request->has('btnTambah')) {
            $kuis = new Kuis();
            $result = $kuis->tambahKuis($request, $id);

            if ($result){
                return redirect()->back()->with("success", "Berhasil Buat Kuis Baru!");
            }
            else{
                return redirect()->back()->withErrors("Gagal Buat Kuis Baru!");
            }
        }
        elseif ($request->has('btnPublish')) {
            $kuis = new Kuis();
            $result = $kuis->publishKuis($request);

            if ($result){
                return redirect()->back()->with("success", "Berhasil Publish Kuis!");
            }
            else{
                return redirect()->back()->withErrors("Gagal Publish Kuis!");
            }
        }
        elseif ($request->has('btnRetraksi')) {
            $kuis = new Kuis();
            $result = $kuis->retraksiKuis($request);

            if ($result){
                return redirect()->back()->with("success", "Berhasil Retraksi Kuis!");
            }
            else{
                return redirect()->back()->withErrors("Gagal Retraksi Kuis!");
            }
        }
    }

    public function listDetailKuis($id, $id_kuis) {
        $listKuis = Kuis::where('id_kuis', $id_kuis)->first();
        $listDetailKuis = detailKuis::where('id_kuis', $id_kuis)->get();
        return view("guru.detailKuis", [
            "listDetailKuis" => $listDetailKuis,
            "id" => $id,
            "id_kuis" => $id_kuis,
            "listKuis" => $listKuis,
        ]);
    }

    public function detailKuisData(Request $request, $id, $id_kuis) {
        $detailKuis = new detailKuis();
        $result = $detailKuis->tambahDetailKuis($request, $id_kuis);

        if ($result){
            return redirect()->back()->with("success", "Berhasil Tambah Soal Kuis!");
        }
        else{
            return redirect()->back()->withErrors("Gagal Tambah Soal Kuis!");
        }
    }

    public function ubahBatasWaktu(Request $request){
        $detailKuis = new detailKuis();
        $data = $detailKuis->ubahBatasWaktu($request);
        return json_encode($data);
    }

    public function hasilKuis($id, $id_kuis) {
        $listAnak = Kelas::join('detail_kelas', 'kelas.id_kelas', '=', 'detail_kelas.id_kelas')->join('anak', 'detail_kelas.nis', '=', 'anak.nis')->join('tahun_ajaran', 'kelas.tahun_ajaran', '=', 'tahun_ajaran.tahun_ajaran')->where('tahun_ajaran.status', 1)->where('kelas.wali_kelas', session()->get('login')->username)->get();
        $hasilKuis = nilaiKuis::join('detail_kelas', 'detail_kelas.id_detailsiswa', '=', 'nilai_kuis.id_detailsiswa')->join('anak', 'anak.nis', '=', 'detail_kelas.nis')->where('nilai_kuis.id_kuis', $id_kuis)->get();
        // dd($listAnak);
        $listNilaiAnak = '';
        for ($i=0; $i < count($listAnak); $i++) {
            $listNilaiAnak = [];
            $listAnak[$i]->status = 'not submitted';
            $listAnak[$i]->nilai = '-';
            for ($j=0; $j < count($hasilKuis); $j++) {
                if ($listAnak[$i]->id_detailsiswa == $hasilKuis[$j]->id_detailsiswa) {
                    if ($hasilKuis[$j]->nilai != null) {
                        $listAnak[$i]->status = 'submitted';
                        $listAnak[$i]->nilai = $hasilKuis[$j]->nilai;
                        $listAnak[$i]->id_nilai_kuis = $hasilKuis[$j]->id_nilai_kuis;
                    }
                }
            }
            array_push($listNilaiAnak, $listAnak);
        }
        // dd($listNilaiAnak[0]);

        return view("guru.hasilKuis", [
            "listNilaiAnak" => $listNilaiAnak[0],
            "id" => $id,
            "id_kuis" => $id_kuis,
        ]);
    }

    public function hasilKuisAnak($id, $id_kuis, $id_nilai_kuis) {
        $kuis = Kuis::where('id_kuis', $id_kuis)->first();
        $kelasAnak = Anak::where('nis', session()->get('login')->username)->value('kelas');
        $hasilKuis = nilaiKuis::where('nilai_kuis.id_nilai_kuis', $id_nilai_kuis)->first();
        $nilaiKuis = nilaiKuis::where('nilai_kuis.id_nilai_kuis', $id_nilai_kuis)->get();
        // dd($nilaiKuis);
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

        return view("guru.hasilKuisAnak", [
            "kuis" => $kuis,
            "id" => $id,
            "id_kuis" => $id_kuis,
            "hasilKuis" => $hasilKuis,
            "listDetailKuis" => $listDetailKuis,
        ]);
    }

    public function editDetailKuis($id, $id_kuis, $id_detail_kuis) {
        $listDetailKuis = detailKuis::where('id_detail_kuis', $id_detail_kuis)->first();
        $option_value = detailKuis::where('id_detail_kuis', $id_detail_kuis)->value('option_value');
        $soal_img = detailKuis::where('id_detail_kuis', $id_detail_kuis)->value('soal_img');
        $arr_option_value = json_decode($option_value);
        $arr_soal_img = json_decode($soal_img);
        return view("guru.editDetailKuis", [
            "option_value" => $option_value,
            "arr_soal_img" => $arr_soal_img,
            "arr_option_value" => $arr_option_value,
            "listDetailKuis" => $listDetailKuis,
            "id" => $id,
            "id_kuis" => $id_kuis,
        ]);
    }

    public function editDetailKuisData(Request $request, $id, $id_kuis, $id_detail_kuis) {
        $detailKuis = new detailKuis();
        $result = $detailKuis->editDetailKuis($request, $id_detail_kuis);

        if ($result){
            return redirect()->back()->with("success", "Berhasil Ubah Kuis!");
        }
        else{
            return redirect()->back()->withErrors("Gagal Ubah Kuis!");
        }
    }

    public function ubahgroupkey(Request $request) {
        $idx = $request->idx;
        $value = $request->value;
        $det = detailKuis::find($idx);
        $det->groupkey = $value;
        $det->save();
        return "sukses";
    }

    public function deleteDetailKuis($id, $id_kuis, $id_detail_kuis){
        $detailKuis = new detailKuis();
        $result = $detailKuis->deleteDetailKuis($id_detail_kuis);

        if ($result){
            return redirect()->back()->with("success", "Berhasil Hapus Kuis!");
        }
        else{
            return redirect()->back()->withErrors("Gagal Hapus Kuis!");
        }
    }

    public function tampilanAgenda() {
        $listAgenda = Agenda::where('id_guru', session()->get('login')->username)->get();
        return view("guru.agenda", [
            "listAgenda" => $listAgenda,
        ]);
    }

    public function agendaData(Request $request) {
        if ($request->input('keterangan') == null) {
            return redirect()->back()->withErrors("Masukkan Isi Agenda Terlebih Dahulu!");
        }
        else{
            $agenda = new Agenda();
            $result = $agenda->tambahAgenda($request);

            if ($result){
                return redirect()->back()->with("success", "Berhasil Buat Agenda Baru!");
            }
            else{
                return redirect()->back()->withErrors("Gagal Buat Agenda Baru!");
            }
        }

    }

    public function tampilanChat() {
        $kelas = Kelas::join('tahun_ajaran', 'kelas.tahun_ajaran', '=', 'tahun_ajaran.tahun_ajaran')->where('tahun_ajaran.status', 1)->where('wali_kelas', session()->get('login')->username)->value('id_kelas');
        $listOrtu = Anak::select('anak.*', 'orangtua.nama as namaortu')->join('orangtua', 'anak.orangtua', '=', 'orangtua.username')->where('anak.kelas', $kelas)->get();
        // dd($listOrtu);
        return view("guru.chat", [
            "listOrtu" => $listOrtu,
        ]);
    }

    public function getchatting($nis) {
        $guru = session()->get('login')->username;
        $listChat = Chat::select('chat.*')
        ->orWhere(function($query) use ($guru, $nis){
        $query->where('username1', '=', $nis);
        $query->where('username2', '=', $guru);
        })
        ->orWhere(function($query) use ($guru, $nis){
        $query->where('username1', '=', $guru);
        $query->where('username2', '=', $nis);
        })
        ->get();
        return json_encode($listChat);
    }

    public function sendchatting($nis, Request $request) {
        $chat = new Chat();
        $result = $chat->chatGuru($nis, $request);

        if ($result) {
            return 'berhasil tambah chat';
        }
        else{
            return 'gagal tambah chat';
        }
    }

    public function detailAgenda(Request $request) {
        // dd($request->mode);
        $dataAgenda = Agenda::where('tanggal', $request->mode)->where('id_guru', session()->get('login')->username)->get();
        $arr = [];
        foreach($dataAgenda as $agenda){
            array_push($arr, $agenda);
        }
        return json_encode($arr);
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

    public function inputRapor(Request $request, $nis) {
        $nilai = new nilaiRapor();
        $result = $nilai->tambahNilaiRapor($request, $nis);

        if ($result){
            return 'Berhasil tambah nilai rapor';
        }
        else{
            return 'Gagal tambah nilai rapor';
        }
    }

    public function inputScoring(Request $request, $nis) {
        $nilai = new nilaiSubjek();
        $result = $nilai->tambahNilaiSubjek($request, $nis);

        if ($result){
            return 'Berhasil tambah nilai subjek';
        }
        else{
            return 'Gagal tambah nilai subjek';
        }
    }

    public function inputPerilaku(Request $request, $nis) {
        $nilai = new nilaiSubjek();
        $result = $nilai->tambahNilaiPerilaku($request, $nis);

        if ($result){
            return 'Berhasil tambah nilai perilaku';
        }
        else{
            return 'Gagal tambah nilai perilaku';
        }
    }

    public function komentarNilai(Request $request, $nis) {
        $komentar = new komentarNilai();
        $result = $komentar->tambahKomentarNilai($request, $nis);

        if ($result){
            return 'Berhasil tambah komentar rapor';
        }
        else{
            return 'Gagal tambah komentar rapor';
        }
    }

    public function komentarSubjek(Request $request, $nis) {
        $komentar = new komentarSubjek();
        $result = $komentar->tambahKomentarSubjek($request, $nis);

        if ($result){
            return 'Berhasil tambah komentar subjek';
        }
        else{
            return 'Gagal tambah komentar subjek';
        }
    }
}
