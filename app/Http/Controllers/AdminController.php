<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\aktivitasSubjek;
use App\Models\Anak;
use App\Models\detailKelas;
use App\Models\detailKuis;
use App\Models\detailMateri;
use App\Models\detailSubjek;
use App\Models\Evaluasi;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\komentarNilai;
use App\Models\komentarSubjek;
use App\Models\Kuis;
use App\Models\Mapel;
use App\Models\Materi;
use App\Models\nilaiRapor;
use App\Models\nilaiSubjek;
use App\Models\Orangtua;
use App\Models\Pendaftaran;
use App\Models\Subjek;
use App\Models\tahunAjaran;
use App\Models\Users;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PHPMailer\PHPMailer\PHPMailer;

class AdminController extends Controller
{
    public function dashboard() {
        return view("admin.dashboard");
    }
    public function tampilanProfile() {
        $listAdmin = Users::where('role', 'admin')->first();
        // dd($listAdmin);
        return view("admin.profile", [
            "listAdmin" => $listAdmin,
        ]);
    }
    public function editProfile(Request $request) {
        $listUsers = Users::all();
        $admin = Users::where('username', session()->get('login')->username)->value('email');
        $idx = false;
        foreach ($listUsers as $users) {
            if ($users->email == $request->email && $users->email != $admin) {
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
            $users = new Users();
            $result = $users->updateProfilAdmin($request);

            if ($result){
                return back()->with('success', 'Berhasil Edit Profile');
            }
            else{
                return back()->withErrors('Gagal Edit Profile');
            }
        }
    }
    public function tampilanPengelolaanGuru() {
        $listGuru = Users::join('guru', 'users.username', '=', 'guru.username')->get();
        return view("admin.manajemenGuru", [
            "listGuru" => $listGuru,
        ]);
    }

    public function tampilantambahGuru() {
        return view("admin.tambahGuru");
    }
    public function tambahGuruData(Request $request) {
        if ($request->j_kelamin == null) {
            return back()->withErrors('pilih jenis kelamin terlebih dahulu');
        }
        else{
            $pesan = [
                'username.unique' => 'username sudah dipakai dan tidak boleh sama',
                'email.unique' => 'email sudah dipakai dan tidak boleh sama',
                'nik.unique' => 'nik sudah dipakai dan tidak boleh sama',
                'no_identitas.unique' => 'no_identitas sudah dipakai dan tidak boleh sama',
                'foto.max' => 'ukuran foto tidak boleh lebih dari 2MB',
                'nik.numeric' => 'nik harus berisikan angka',
                'no_identitas.numeric' => 'nomor identitas harus berisikan angka',
                'no_hp.numeric' => 'nomor handphone harus berisikan angka',
            ];
            $request->validate([
                "username" => "unique:users,username",
                "email" => "unique:users,email",
                "nik" => "unique:guru,nik|numeric",
                "no_identitas" => "nullable|unique:guru,no_identitas|numeric",
                "no_hp" => "numeric",
                'foto' => 'max:2048'
            ], $pesan);
            $users = new Users();
            $result = $users->tambahGuru($request);

            if ($result){
                return redirect()->back()->with("success", "Berhasil Tambah Guru!");
            }
            else{
                return redirect()->back()->withErrors("Gagal Tambah Guru!");
            }
        }
    }

    public function tampilanUbahGuru($id_guru) {
        $listGuru = Users::join('guru', 'users.username', '=', 'guru.username')->where('guru.username', $id_guru)->first();
        // dd($listGuru);
        return view("admin.ubahGuru", [
            "listGuru" => $listGuru,
        ]);
    }

    public function ubahGuruData(Request $request, $id_guru) {
        if ($request->j_kelamin == null) {
            return back()->withErrors('pilih jenis kelamin terlebih dahulu');
        }
        else{
            $listUsers = Users::all();
            $userGuru = Users::where('username', $id_guru)->first();
            $cekEmail = false;
            $cekNIK = false;
            $cekNoIdentitas = false;
            foreach ($listUsers as $users) {
                if ($users->email == $request->email && $users->email != $userGuru->email) {
                    $cekEmail = true;
                }
                if ($users->nik == $request->nik && $users->nik != $userGuru->nik) {
                    $cekNIK = true;
                }
                if ($users->no_identitas == $request->no_identitas && $users->no_identitas != $userGuru->no_identitas) {
                    $cekNoIdentitas = true;
                }
            }
            if ($cekEmail) {
                return back()->with('errors', 'email sudah dipakai dan tidak boleh sama');
            }
            else if ($cekNIK) {
                return back()->with('errors', 'nik sudah dipakai dan tidak boleh sama');
            }
            else if ($cekNoIdentitas) {
                return back()->with('errors', 'nomor identitas sudah dipakai dan tidak boleh sama');
            }
            else{
                $pesan = [
                    'nik.numeric' => 'nik harus berisikan angka',
                    'no_identitas.numeric' => 'nomor identitas harus berisikan angka',
                    'no_hp.numeric' => 'nomor handphone harus berisikan angka',
                ];
                $request->validate([
                    "nik" => "numeric",
                    "no_identitas" => "nullable|numeric",
                    "no_hp" => "numeric",
                ], $pesan);
                $users = new Users();
                $result = $users->editGuru($request, $id_guru);

                if ($result){
                    return back()->with('success', 'Berhasil Edit Data Guru');
                }
                else{
                    return back()->withErrors('Gagal Edit Data Guru');
                }
            }
        }
    }

    public function tampilanManajemenAnak() {
        $listAnak = Anak::join('users', 'anak.nis', '=', 'users.username')->join('orangtua', 'anak.orangtua', '=', 'orangtua.username')->join('kelas', 'anak.kelas', '=', 'kelas.id_kelas')->select('users.*', 'anak.*', 'orangtua.*', 'kelas.*', 'anak.nama as namaAnak')->get();
        // dd($listAnak);
        return view("admin.manajemenAnak", [
            "listAnak" => $listAnak,
        ]);
    }

    public function manajemenAnakData(Request $request) {
        $users = new Users();
        $result = $users->statusAnak($request);

        if ($result){
            return back()->with('success', 'Berhasil Ubah Status Anak');
        }
        else{
            return back()->withErrors('Gagal Ubah Status Anak');
        }
    }

    public function TampilanLaporanAnak($id) {
        $dataAnak = Anak::join('orangtua', 'anak.orangtua', '=', 'orangtua.username')->select('anak.*', 'orangtua.*', 'anak.nama as namaAnak')->where('anak.nis', $id)->first();
        $userAnak = Users::where('username', $id)->first();
        $nama_kelas = Kelas::where('id_kelas', $dataAnak->kelas)->value('nama_kelas');
        $listKelas = detailKelas::join('anak', 'detail_kelas.nis', '=', 'anak.nis')->join('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')->where('detail_kelas.nis', $id)->get();
        $semester = null;
        // dd(substr($nama_kelas, 0, 1));
        if (substr($nama_kelas, 0, 1) == '7') {
            $listKelasTinggal = Kelas::join('tahun_ajaran', 'kelas.tahun_ajaran', '=', 'tahun_ajaran.tahun_ajaran')->select('kelas.*')->where(DB::raw('substr(kelas.nama_kelas, 1, 1)'), '7')->where('tahun_ajaran.status', 1)->get();
            $listKelasBaru = Kelas::join('tahun_ajaran', 'kelas.tahun_ajaran', '=', 'tahun_ajaran.tahun_ajaran')->select('kelas.*')->where(DB::raw('substr(kelas.nama_kelas, 1, 1)'), '8')->where('tahun_ajaran.status', 1)->get();
        }
        else if(substr($nama_kelas, 0, 1) == '8') {
            $listKelasTinggal = Kelas::join('tahun_ajaran', 'kelas.tahun_ajaran', '=', 'tahun_ajaran.tahun_ajaran')->select('kelas.*')->where(DB::raw('substr(kelas.nama_kelas, 1, 1)'), '8')->where('tahun_ajaran.status', 1)->get();
            $listKelasBaru = Kelas::join('tahun_ajaran', 'kelas.tahun_ajaran', '=', 'tahun_ajaran.tahun_ajaran')->select('kelas.*')->where(DB::raw('substr(kelas.nama_kelas, 1, 1)'), '9')->where('tahun_ajaran.status', 1)->get();
        }
        else if(substr($nama_kelas, 0, 1) == '9') {
            $listKelasTinggal = Kelas::join('tahun_ajaran', 'kelas.tahun_ajaran', '=', 'tahun_ajaran.tahun_ajaran')->select('kelas.*')->where(DB::raw('substr(kelas.nama_kelas, 1, 1)'), '9')->where('tahun_ajaran.status', 1)->get();
            $listKelasBaru = [];
        }

        return view("admin.laporanAnak", [
            "dataAnak" => $dataAnak,
            "userAnak" => $userAnak,
            "nama_kelas" => $nama_kelas,
            "listKelas" => $listKelas,
            "semester" => $semester,
            "listKelasTinggal" => $listKelasTinggal,
            "listKelasBaru" => $listKelasBaru,
        ]);
    }

    public function laporanAnakData(Request $request, $id) {
        if ($request->has('btnFilter')) {
            if ($request->pilihKelas != null && $request->pilihSemester != null) {
                $dataAnak = Anak::join('orangtua', 'anak.orangtua', '=', 'orangtua.username')->select('anak.*', 'orangtua.*', 'orangtua.nama as namaOrtu')->where('anak.nis', $id)->first();
                $listKelas = detailKelas::join('anak', 'detail_kelas.nis', '=', 'anak.nis')->join('kelas', 'detail_kelas.id_kelas', '=', 'kelas.id_kelas')->where('detail_kelas.nis', $id)->get();
                $listKelasNow = Kelas::where('id_kelas', $request->pilihKelas)->first();
                $listSubjek = Subjek::all();
                $listMapel = Mapel::all();
                $id_detailsiswa = detailKelas::where('nis', $dataAnak->nis)->where('id_kelas', $request->pilihKelas)->value('id_detailsiswa');
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

                $userAnak = Users::where('username', $id)->first();
                $nama_kelas = Kelas::where('id_kelas', $dataAnak->kelas)->value('nama_kelas');
                if (substr($nama_kelas, 0, 1) == '7') {
                    $listKelasTinggal = Kelas::join('tahun_ajaran', 'kelas.tahun_ajaran', '=', 'tahun_ajaran.tahun_ajaran')->select('kelas.*')->where(DB::raw('substr(kelas.nama_kelas, 1, 1)'), '7')->where('tahun_ajaran.status', 1)->get();
                    $listKelasBaru = Kelas::join('tahun_ajaran', 'kelas.tahun_ajaran', '=', 'tahun_ajaran.tahun_ajaran')->select('kelas.*')->where(DB::raw('substr(kelas.nama_kelas, 1, 1)'), '8')->where('tahun_ajaran.status', 1)->get();
                }
                else if(substr($nama_kelas, 0, 1) == '8') {
                    $listKelasTinggal = Kelas::join('tahun_ajaran', 'kelas.tahun_ajaran', '=', 'tahun_ajaran.tahun_ajaran')->select('kelas.*')->where(DB::raw('substr(kelas.nama_kelas, 1, 1)'), '8')->where('tahun_ajaran.status', 1)->get();
                    $listKelasBaru = Kelas::join('tahun_ajaran', 'kelas.tahun_ajaran', '=', 'tahun_ajaran.tahun_ajaran')->select('kelas.*')->where(DB::raw('substr(kelas.nama_kelas, 1, 1)'), '9')->where('tahun_ajaran.status', 1)->get();
                }
                else if(substr($nama_kelas, 0, 1) == '9') {
                    $listKelasTinggal = Kelas::join('tahun_ajaran', 'kelas.tahun_ajaran', '=', 'tahun_ajaran.tahun_ajaran')->select('kelas.*')->where(DB::raw('substr(kelas.nama_kelas, 1, 1)'), '9')->where('tahun_ajaran.status', 1)->get();
                    $listKelasBaru = [];
                }

                return view("admin.laporanAnak", [
                    "dataAnak" => $dataAnak,
                    "userAnak" => $userAnak,
                    "listKelasNow" => $listKelasNow,
                    "nama_kelas" => $nama_kelas,
                    "listKelas" => $listKelas,
                    "listSubjek" => $listSubjek,
                    "listMapel" => $listMapel,
                    "dataKomentar" => $dataKomentar,
                    "semester" => $request->pilihSemester,
                    "listKelasTinggal" => $listKelasTinggal,
                    "listKelasBaru" => $listKelasBaru,
                ]);
            }
            else {
                return back()->withErrors('Pilih Kelas dan Semester Terlebih Dahulu');
            }
        }
        else if($request->has('btnTidakNaik')) {
            $detailKelas = new detailKelas();
            $result = $detailKelas->tidakNaikKelas($request, $id);

            if ($result){
                return redirect()->back()->with('success', 'Berhasil Mengubah Kelas Anak');
            }
            else{
                return redirect()->back()->withErrors('Gagal Mengubah Kelas Anak');
            }
        }
        else if($request->has('btnNaik')) {
            $detailKelas = new detailKelas();
            $result = $detailKelas->naikKelas($request, $id);

            if ($result){
                return redirect()->back()->with('success', 'Berhasil Menaikkan Kelas Anak');
            }
            else{
                return redirect()->back()->withErrors('Gagal Menaikkan Kelas Anak');
            }
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

    public function tampilanListPendaftaran() {
        $listPendaftaran = Pendaftaran::orderByDesc('created_at')->get();
        $getYear = Pendaftaran::select(DB::raw('YEAR(created_at) as year'))->distinct()->get()->sortByDesc('year');
        $filterTahun = null;
        return view('admin.listPendaftaran', [
            "listPendaftaran" => $listPendaftaran,
            "getYear" => $getYear,
            "filterTahun" => $filterTahun,
        ]);
    }

    public function listPendaftaranData(Request $request) {
        if ($request->has('btnFilter')) {
            if ($request->filterTahun == null) {
                if ($request->filterStatus == null) {
                    $date = Carbon::now()->format('Y');
                    $listPendaftaran = Pendaftaran::whereYear('created_at',$date)->get();
                }
                else {
                    $listPendaftaran = Pendaftaran::where('status', $request->filterStatus)->get();
                }
            }
            else {
                if ($request->filterStatus == null) {
                    $listPendaftaran = Pendaftaran::whereYear('created_at', $request->filterTahun)->get();
                }
                else {
                    $listPendaftaran = Pendaftaran::whereYear('created_at', $request->filterTahun)->where('status', $request->filterStatus)->get();
                }
            }
            $getYear = Pendaftaran::select(DB::raw('YEAR(created_at) as year'))->distinct()->get()->sortByDesc('year');
            return view('admin.listPendaftaran', [
                "listPendaftaran" => $listPendaftaran,
                "getYear" => $getYear,
                "filterTahun" => $request->filterTahun,
            ]);
        }
        elseif ($request->has('btnKirim')) {
            $pendaftaran = new Pendaftaran();
            $result = $pendaftaran->updateJanjiTemu($request);
            $emailTujuan = Pendaftaran::where('id', $request->id)->value('email');

            if ($result) {
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'wisdomacademy.my.id';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'admin@wisdomacademy.my.id';
                    $mail->Password = 'WisdomAcademy';
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;
                    $mail->setFrom('admin@wisdomacademy.my.id', 'Wisdom Academy');
                    $mail->addAddress($emailTujuan);
                    $mail->isHTML(true);
                    $mail->Subject = 'PENDAFTARAN ONLINE';
                    $mail->Body = '<html><body>Halo Bapak/Ibu orang tua sekalian, diberitaukan bahwa berikut merupakan jadwal janji temu di sekolah Wisdom Academy yang bisa Bapak/Ibu hadiri<br><h3>Tanggal : ' .date('d F Y', strtotime($request->janji_temu)). '<br>Waktu : ' .date('H.i A', strtotime($request->janji_temu)). '<br>Tempat : Wisdom Academy</h3></body></html>';
                    $mail->send();
                    return back()->with('success', 'Berhasil Kirim Undangan!');
                } catch (Exception $e) {
                    return back()->withErrors('Gagal Kirim Undangan!');
                }
            }
        }
    }

    public function tampilanDetailPendaftar($id) {
        $pendaftaran = Pendaftaran::where('id', $id)->first();
        return view('admin.detailPendaftar', [
            "pendaftaran" => $pendaftaran,
        ]);
    }

    public function detailPendaftarData(Request $request) {
        if ($request->has('btnKirim')) {
            $pendaftaran = new Pendaftaran();
            $result = $pendaftaran->updateJanjiTemu($request);
            $emailTujuan = Pendaftaran::where('id', $request->id)->value('email');

            if ($result) {
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'wisdomacademy.my.id';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'admin@wisdomacademy.my.id';
                    $mail->Password = 'WisdomAcademy';
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;
                    $mail->setFrom('admin@wisdomacademy.my.id', 'Wisdom Academy');
                    $mail->addAddress($emailTujuan);
                    $mail->isHTML(true);
                    $mail->Subject = 'PENDAFTARAN ONLINE';
                    $mail->Body = '<html><body>Halo Bapak/Ibu orang tua sekalian, diberitaukan bahwa berikut merupakan jadwal janji temu di sekolah Wisdom Academy yang bisa Bapak/Ibu hadiri<br><h3>Tanggal : ' .date('d F Y', strtotime($request->janji_temu)). '<br>Waktu : ' .date('H.i A', strtotime($request->janji_temu)). '<br>Tempat : Wisdom Academy</h3></body></html>';
                    $mail->send();
                    return back()->with('success', 'Berhasil Kirim Undangan!');
                } catch (Exception $e) {
                    return back()->withErrors('Gagal Kirim Undangan!');
                }
            }
        }
    }

    public function tampilanTerimaPendaftaran($id) {
        $getKelasBefore = Pendaftaran::where('id', $id)->value('kelas');
        $kelasBefore = (string)($getKelasBefore + 1);
        if ($kelasBefore == 7) {
           $listKelas = Kelas::join('tahun_ajaran', 'kelas.tahun_ajaran', '=', 'tahun_ajaran.tahun_ajaran')->where('tahun_ajaran.status', 1)->where(DB::raw('substr(kelas.nama_kelas, 1, 1)'), '7')->get();
        }
        else if ($kelasBefore == 8) {
           $listKelas = Kelas::join('tahun_ajaran', 'kelas.tahun_ajaran', '=', 'tahun_ajaran.tahun_ajaran')->where('tahun_ajaran.status', 1)->where(DB::raw('substr(kelas.nama_kelas, 1, 1)'), '8')->get();
        }
        else if ($kelasBefore == 9) {
           $listKelas = Kelas::join('tahun_ajaran', 'kelas.tahun_ajaran', '=', 'tahun_ajaran.tahun_ajaran')->where('tahun_ajaran.status', 1)->where(DB::raw('substr(kelas.nama_kelas, 1, 1)'), '9')->get();
        }
        // dd($listKelas);
        $username = Pendaftaran::where('id', $id)->value('nama_siswa');
        return view("admin.penerimaanAnak", [
            "listKelas" => $listKelas,
            "username" => $username,
        ]);
    }

    public function terimaPendaftaranData(Request $request, $id) {
        $anak = new Anak();
        $result = $anak->tambahAnak($request, $id);
        $emailOrangtua = Pendaftaran::where('id', $request->id)->value('email');
        $dataOrangtua = Users::where('email', $emailOrangtua)->where('role', 'orangtua')->first();
        $mail = new PHPMailer(true);
        if ($result) {
            try {
                $mail->isSMTP();
                $mail->Host = 'wisdomacademy.my.id';
                $mail->SMTPAuth = true;
                $mail->Username = 'admin@wisdomacademy.my.id';
                $mail->Password = 'WisdomAcademy';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;
                $mail->setFrom('admin@wisdomacademy.my.id', 'Wisdom Academy');
                $mail->addAddress($emailOrangtua);
                $mail->isHTML(true);
                $mail->Subject = 'PENDAFTARAN ONLINE';
                $mail->Body = 'Selamat Bapak/Ibu orang tua sekalian, anak anda telah diterima di sekolah Wisdom Academy Surabaya.<br>
                berikut username dan password untuk login sebagai anak<br>
                <h3>Username : '.$request->nis.'<br>Password : '.$request->nis.'</h3><br>
                berikut username dan password untuk login sebagai orangtua<br>
                <h3>Username : '.$dataOrangtua->username.'<br>Password : '.$dataOrangtua->username.'</h3><br>';
                $mail->send();
                return redirect('/admin/listPendaftaran')->with('success', 'Berhasil Terima Anak!');
            } catch (Exception $e) {
                return back()->withErrors('Gagal Terima Anak!');
            }
        }
    }

    public function tolakPendaftaran(Request $request, $id) {
        $listPendaftaran = new Pendaftaran();
        $result = $listPendaftaran->deleteListPendaftaran($id);
        $emailTujuan = Pendaftaran::where('id', $request->id)->value('email');
        $mail = new PHPMailer(true);
        if ($result) {
            try {
                $mail->isSMTP();
                $mail->Host = 'wisdomacademy.my.id';
                $mail->SMTPAuth = true;
                $mail->Username = 'admin@wisdomacademy.my.id';
                $mail->Password = 'WisdomAcademy';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;
                $mail->setFrom('admin@wisdomacademy.my.id', 'Wisdom Academy');
                $mail->addAddress($emailTujuan);
                $mail->isHTML(true);
                $mail->Subject = 'PENDAFTARAN ONLINE';
                $mail->Body = 'Halo Bapak/Ibu orang tua sekalian, sebelumnya kami memohon maaf dan ingin menginfokan bahwa anak dari Bapak/Ibu sekalian tidak lulus dalam pendaftaran di sekolah kami. Oleh karena itu jangan berkecil hati, terus hubungi kami jika memerlukan bantuan. Sekian pengumumannya terima kasih';
                $mail->send();
                return back()->with('success', 'Berhasil Tolak Pendaftaran Anak!');
            } catch (Exception $e) {
                return back()->withErrors('Gagal Tolak Pendaftaran Anak!');
            }
        }
    }

    public function tampilanTahunAjaran() {
        $listTahunAjaran = tahunAjaran::all();
        $tahunAjaranAktif = tahunAjaran::where('status', 1)->value('tahun_ajaran');
        // dd(substr($tahunAjaranAktif, 0, 4));
        return view("admin.manajemenTahunAjaran", [
            "listTahunAjaran" => $listTahunAjaran,
            "tahunAjaranAktif" => $tahunAjaranAktif,
        ]);
    }

    public function tahunAjaranData(Request $request) {
        if ($request->has('btnTambah')) {
            $inputTahunAjaran = $request->thnAwal.'/'.$request->thnAkhir;
            $intThnAwal = (int)$request->thnAwal;
            $intThnAkhir = (int)$request->thnAkhir;
            $listTahunAjaran = tahunAjaran::all();
            $cekTahunAjaran = false;
            foreach ($listTahunAjaran as $list) {
                if ($inputTahunAjaran == $list->tahun_ajaran) {
                    $cekTahunAjaran = true;
                }
            }
            if ($cekTahunAjaran) {
                return back()->withErrors('Tahun Ajaran Tidak Boleh Sama');
            }
            else if($intThnAkhir <= $intThnAwal){
                return back()->withErrors('Tahun Akhir Harus Lebih Besar dari Tahun Awal');
            }
            else{
                $tahunAjaran = new tahunAjaran();
                $result = $tahunAjaran->tambahtahunAjaran($request);

                if ($result){
                    return back()->with('success', 'Berhasil Tambah Tahun Ajaran');
                }
                else{
                    return back()->withErrors('Gagal Tambah Tahun Ajaran');
                }
            }
        }
        else if ($request->has('btnStatus')) {
            $ubah = new tahunAjaran();
            $result = $ubah->ubahTahunAjaran($request);
            if ($result){
                return back()->with('success', 'Berhasil Aktifkan Tahun Ajaran');
            }
            else{
                return back()->withErrors('Gagal Aktifkan Tahun Ajaran');
            }
        }
    }

    public function tampilanUbahTahunAjaran($thnAwal, $thnAkhir) {
        return view("admin.ubahTahunAjaran", [
            "thnAwal" => $thnAwal,
            "thnAkhir" => $thnAkhir,
        ]);
    }

    public function ubahTahunAjaranData(Request $request, $id) {
        $inputTahunAjaran = $request->thnAwal.'/'.$request->thnAkhir;
        $intThnAwal = (int)$request->thnAwal;
        $intThnAkhir = (int)$request->thnAkhir;
        $listTahunAjaran = tahunAjaran::all();
        $cekTahunAjaran = false;
        foreach ($listTahunAjaran as $list) {
            if ($inputTahunAjaran == $list->tahun_ajaran) {
                $cekTahunAjaran = true;
            }
        }
        if ($cekTahunAjaran) {
            return back()->withErrors('Tahun Ajaran Tidak Boleh Sama');
        }
        else if($intThnAkhir <= $intThnAwal){
            return back()->withErrors('Tahun Akhir Harus Lebih Besar dari Tahun Awal');
        }
        else{
            $tahunAjaran = new tahunAjaran();
            $result = $tahunAjaran->ubahTahunAjaran($request, $id);

            if ($result){
                return back()->with('success', 'Berhasil Tambah Tahun Ajaran');
            }
            else{
                return back()->withErrors('Gagal Tambah Tahun Ajaran');
            }
        }
    }

    public function tampilanKelas() {
        $listGuru = Guru::all();
        $listKelas = Kelas::join('guru', 'kelas.wali_kelas', '=', 'guru.username')->orderByDesc('kelas.tahun_ajaran')->orderBy('kelas.nama_kelas')->get();
        $listTahunAjaran = tahunAjaran::where('status', 1)->get();

        return view("admin.manajemenKelas", [
            "listKelas" => $listKelas,
            "listGuru" => $listGuru,
            "listTahunAjaran" => $listTahunAjaran,
        ]);
    }

    public function kelasData(Request $request) {
        if ($request->tahun_ajaran == null) {
            return back()->withErrors('pilih tahun ajaran terlebih dahulu');
        }
        else if($request->wali_kelas == null) {
            return back()->withErrors('pilih wali kelas terlebih dahulu');
        }
        else{
            $kelas = new Kelas();
            $result = $kelas->tambahKelas($request);

            if ($result){
                return back()->with('success', 'Berhasil Tambah Kelas');
            }
            else{
                return back()->withErrors('Gagal Tambah Kelas');
            }
        }
    }

    public function tampilanMapel() {
        $dataMapel = Mapel::all();
        return view("admin.manajemenMapel", [
            "dataMapel" => $dataMapel,
        ]);
    }

    public function mapelData(Request $request) {
        if ($request->has('btnTambah')) {
            $mapel = new Mapel();
            $result = $mapel->tambahMapel($request);

            if ($result){
                return back()->with('success', 'Berhasil Tambah Mata Pelajaran');
            }
            else{
                return back()->withErrors('Gagal Tambah Mata Pelajaran');
            }
        }
        else if($request->has('btnStatus')) {
            $mapel = new Mapel();
            $result = $mapel->deleteMapel($request);

            if ($result){
                return back()->with('success', 'Berhasil Ubah Status Mata Pelajaran');
            }
            else{
                return back()->withErrors('Gagal Ubah Status Mata Pelajaran');
            }
        }
    }

    public function tampilanUbahMapel($id_mapel) {
        $dataMapel = Mapel::where('id_mapel', $id_mapel)->first();
        return view("admin.ubahMapel", [
            "dataMapel" => $dataMapel,
        ]);
    }

    public function ubahMapelData(Request $request, $id_mapel) {
        $mapel = new Mapel();
        $result = $mapel->ubahMapel($request, $id_mapel);

        if ($result){
            return back()->with('success', 'Berhasil Ubah Data Mata Pelajaran');
        }
        else{
            return back()->withErrors('Gagal Ubah Data Mata Pelajaran');
        }
    }

    public function tampilanEvaluasi() {
        $dataSubjek = Subjek::all();
        return view("admin.manajemenEvaluasi", [
            "dataSubjek" => $dataSubjek,
        ]);
    }

    public function EvaluasiData(Request $request) {
        if ($request->has('btnTambah')) {
            $subjek = new Subjek();
            $result = $subjek->tambahSubjek($request);

            if ($result){
                return back()->with('success', 'Berhasil Tambah Subjek');
            }
            else{
                return back()->withErrors('Gagal Tambah Subjek');
            }
        }
        else{
            $subjek = new Subjek();
            $result = $subjek->deleteSubjek($request);

            if ($result){
                return back()->with('success', 'Berhasil Ubah Status Subjek');
            }
            else{
                return back()->withErrors('Gagal Ubah Status Subjek');
            }
        }
    }

    public function tampilanAktivitasSubjek($id) {
        $nama_subjek = Subjek::where('id_subjek', $id)->value('nama_subjek');
        $dataAktivitasSubjek = aktivitasSubjek::where('id_subjek', $id)->get();
        // dd($dataAktivitasSubjek->id_aktivitas);
        return view("admin.aktivitasSubjek", [
            "id" => $id,
            "nama_subjek" => $nama_subjek,
            "dataAktivitasSubjek" => $dataAktivitasSubjek,
        ]);
    }

    public function aktivitasSubjekData(Request $request, $id) {
        $aktivitasSubjek = new aktivitasSubjek();
        $result = $aktivitasSubjek->tambahAktivitasSubjek($request, $id);

        if ($result){
            return back()->with('success', 'Berhasil Tambah Aktivitas Baru');
        }
        else{
            return back()->withErrors('Gagal Tambah Aktivitas Baru');
        }
    }

    public function deleteAktivitasSubjek($id, $id_aktivitas) {
        $aktivitasSubjek = new aktivitasSubjek();
        $result = $aktivitasSubjek->deleteAktivitasSubjek($id_aktivitas);

        if ($result){
            return redirect()->back()->with("success", "Berhasil Hapus Aktivitas!");
        }
        else{
            return redirect()->back()->withErrors("Gagal Hapus Aktivitas!");
        }
    }

    public function tampilanLaporan() {
        $listTahunAjaran = tahunAjaran::all();
        $listKelas = Kelas::all();
        $dataMateri = null;
        $dataKuis = null;
        $dataAgenda = null;
        return view('admin.manajemenLaporan', [
            "listTahunAjaran" => $listTahunAjaran,
            "listKelas" => $listKelas,
            "dataMateri" => $dataMateri,
            "dataKuis" => $dataKuis,
            "dataAgenda" => $dataAgenda,
        ]);
    }

    public function laporanData(Request $request) {
        if ($request->has('btnFilter')) {
            if ($request->pilihTahunAjaran != null && $request->pilihKelas != null) {
                $getTahun_Kelas = Kelas::where('id_kelas', $request->pilihKelas)->first();
                $dataMateri = Materi::join('kelas', 'materi.fk_kelas', '=', 'kelas.id_kelas')->where('kelas.tahun_ajaran', $request->pilihTahunAjaran)->where('kelas.id_kelas', $request->pilihKelas)->orderByDesc('materi.updated_at')->get();
                $dataKuis = Kuis::join('kelas', 'kuis.id_kelas', '=', 'kelas.id_kelas')->where('kelas.tahun_ajaran', $request->pilihTahunAjaran)->where('kelas.id_kelas', $request->pilihKelas)->orderByDesc('kuis.updated_at')->get();
                $dataAgenda = Agenda::join('kelas', 'agenda.id_kelas', '=', 'kelas.id_kelas')->where('kelas.tahun_ajaran', $request->pilihTahunAjaran)->where('kelas.id_kelas', $request->pilihKelas)->groupBy('agenda.tanggal')->select('agenda.tanggal')->orderByDesc('agenda.tanggal')->get();
                $listTahunAjaran = tahunAjaran::all();
                $listKelas = Kelas::all();
                return view("admin.manajemenLaporan", [
                    "listTahunAjaran" => $listTahunAjaran,
                    "getTahun_Kelas" => $getTahun_Kelas,
                    "listKelas" => $listKelas,
                    "dataMateri" => $dataMateri,
                    "dataKuis" => $dataKuis,
                    "dataAgenda" => $dataAgenda,
                ]);
            }
            else{
                return back()->withErrors('Pilih Tahun Ajaran dan Kelas Terlebih Dahulu');
            }
        }
    }

    public function getKelasFromTahunAjaran(Request $request)
    {
        $data = Kelas::where('tahun_ajaran', $request->tahunAjaran)->distinct()->get();
        return json_encode($data);
    }

    public function laporanDetailMateri($id_materi){
        $materi = Materi::where('id_materi', $id_materi)->first();
        $detailMateri = detailMateri::join('materi', 'detail_materi.id_materi', '=', 'materi.id_materi')->where('materi.id_materi', $id_materi)->get();

        // dd($detailMateri);
        return view("admin.laporanDetailMateri", [
            "materi" => $materi,
            "detailMateri" => $detailMateri,
        ]);
    }

    public function laporanDetailKuis($id_kuis){
        $namaKuis = Kuis::where('id_kuis', $id_kuis)->value('nama_kuis');
        $listDetailKuis = detailKuis::where('id_kuis', $id_kuis)->get();
        return view("admin.laporanDetailKuis", [
            "listDetailKuis" => $listDetailKuis,
            "id_kuis" => $id_kuis,
            "namaKuis" => $namaKuis,
        ]);
    }

    public function laporanDetailAgenda($tgl_agenda){
        $dataAgenda = Agenda::where('tanggal', $tgl_agenda)->get();
        return view("admin.laporanDetailAgenda", [
            "tgl_agenda" => $tgl_agenda,
            "dataAgenda" => $dataAgenda,
        ]);
    }
}
