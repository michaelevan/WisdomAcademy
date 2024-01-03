<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnakController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrangTuaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// TAMPILAN AWAL
Route::get('/', [HomeController::class, "index"])->middleware('logout');
Route::get('/tentangKami', [HomeController::class, "tentangKami"])->middleware('logout');
Route::get('/hubungiKami', [HomeController::class, "hubungiKami"])->middleware('logout');
Route::post('/hubungiKami', [HomeController::class, "kirimEmail"]);
Route::get('/pendaftaran', [HomeController::class, "formPendaftaran"])->middleware('logout');
Route::post('/pendaftaran', [HomeController::class, "pendaftaran"]);
Route::get('/login', [HomeController::class, "formLogin"])->middleware('logout');
Route::post('/login', [HomeController::class, "login"]);
Route::get('/logout', [HomeController::class, "logout"]);

// ADMIN
Route::prefix('/admin')->middleware("login", "userAdmin")->group(function(){
    Route::get('/profile', [AdminController::class, "tampilanProfile"]);
    Route::post('/profile', [AdminController::class, "editProfile"]);

    // guru
    Route::get('/manajemenGuru', [AdminController::class, "tampilanPengelolaanGuru"]);
    Route::post('/manajemenGuru', [AdminController::class, "pengelolaanGuruData"]);
    Route::get('/tambahGuru', [AdminController::class, "tampilantambahGuru"]);
    Route::post('/tambahGuru', [AdminController::class, "tambahGuruData"]);
    Route::get('/ubahGuru/{id}', [AdminController::class, "tampilanUbahGuru"]);
    Route::post('/ubahGuru/{id}', [AdminController::class, "ubahGuruData"]);

    // anak
    Route::get('/manajemenAnak', [AdminController::class, "tampilanManajemenAnak"]);
    Route::post('/manajemenAnak', [AdminController::class, "manajemenAnakData"]);
    Route::get('/tambahAnak', [AdminController::class, "tampilantambahAnak"]);
    Route::post('/tambahAnak', [AdminController::class, "tambahAnakData"]);
    Route::get('/ubahAnak/{id}', [AdminController::class, "ubahAnak"]);
    Route::get('/laporanAnak/{id}', [AdminController::class, "tampilanLaporanAnak"]);
    Route::post('/laporanAnak/{id}', [AdminController::class, "laporanAnakData"]);
    Route::get('/pilihSubjek', [AdminController::class, "pilihSubjek"]);

    // list pendaftaran
    Route::prefix('/listPendaftaran')->group(function(){
        Route::get('/', [AdminController::class, "tampilanListPendaftaran"]);
        Route::post('/', [AdminController::class, "listPendaftaranData"]);
        Route::get('/{id}', [AdminController::class, "tampilanDetailPendaftar"]);
        Route::post('/{id}', [AdminController::class, "detailPendaftarData"]);
        Route::get('/tolakPendaftaran/{id}', [AdminController::class, "tolakPendaftaran"]);
        Route::get('/terimaPendaftaran/{id}', [AdminController::class, "tampilanTerimaPendaftaran"]);
        Route::post('/terimaPendaftaran/{id}', [AdminController::class, "terimaPendaftaranData"]);
    });

    // tahun ajaran
    Route::get('/manajemenTahunAjaran', [AdminController::class, "tampilanTahunAjaran"]);
    Route::post('/manajemenTahunAjaran', [AdminController::class, "TahunAjaranData"]);
    Route::get('/manajemenTahunAjaran/{thnAwal}-{thnAkhir}', [AdminController::class, "tampilanUbahTahunAjaran"]);
    Route::post('/manajemenTahunAjaran/{thnAwal}-{thnAkhir}', [AdminController::class, "ubahTahunAjaranData"]);

    // kelas
    Route::get('/manajemenKelas', [AdminController::class, "tampilanKelas"]);
    Route::post('/manajemenKelas', [AdminController::class, "kelasData"]);

    // mapel
    Route::get('/manajemenMapel', [AdminController::class, "tampilanMapel"]);
    Route::post('/manajemenMapel', [AdminController::class, "mapelData"]);
    Route::get('/manajemenMapel/{id_mapel}', [AdminController::class, "tampilanUbahMapel"]);
    Route::post('/manajemenMapel/{id_mapel}', [AdminController::class, "ubahMapelData"]);

    // evaluasi
    Route::prefix('/manajemenEvaluasi')->group(function(){
        Route::get('/', [AdminController::class, "tampilanEvaluasi"]);
        Route::post('/', [AdminController::class, "evaluasiData"]);
        Route::get('/{id}', [AdminController::class, "tampilanAktivitasSubjek"]);
        Route::post('/{id}', [AdminController::class, "aktivitasSubjekData"]);
        Route::get('/{id}/{id_aktivitas}', [AdminController::class, "deleteAktivitasSubjek"]);
    });

    // laporan
    Route::prefix('/laporan')->group(function(){
        Route::get('/', [AdminController::class, "tampilanLaporan"]);
        Route::post('/', [AdminController::class, "laporanData"]);
        Route::get('/materi/{id}', [AdminController::class, "laporanDetailMateri"]);
        Route::get('/kuis/{id}', [AdminController::class, "laporanDetailKuis"]);
        Route::get('/agenda/{tgl}', [AdminController::class, "laporanDetailAgenda"]);
        Route::get('/getKelas', [AdminController::class, "getKelasFromTahunAjaran"]);
    });

});

// GURU
Route::prefix('/guru')->middleware("login", "userGuru")->group(function(){
    Route::get('/profile', [GuruController::class, "tampilanProfile"]);
    Route::post('/profile', [GuruController::class, "editProfile"]);

    // kelas
    Route::prefix('/kelas')->group(function(){
        Route::get('/', [GuruController::class, "tampilanKelas"]);
        Route::post('/', [GuruController::class, "kelasData"]);
        Route::get('/{id}', [GuruController::class, "tampilanDetailKelas"]);
        Route::post('/{id}', [GuruController::class, "detailKelasData"]);
        Route::get('/inputRapor/{id}', [GuruController::class, "inputRapor"]);
        Route::get('/inputScoring/{id}', [GuruController::class, "inputScoring"]);
        Route::get('/inputPerilaku/{id}', [GuruController::class, "inputPerilaku"]);
        Route::get('/komentarNilai/{id}', [GuruController::class, "komentarNilai"]);
        Route::get('/komentarSubjek/{id}', [GuruController::class, "komentarSubjek"]);
    });
    Route::get('/ubahgroupkey', [GuruController::class, "ubahgroupkey"]);
    Route::get('/pilihSubjek', [GuruController::class, "pilihSubjek"]);

    Route::prefix('/mapel')->group(function(){
        Route::get('/', [GuruController::class, "listMapel"]);
        Route::prefix('/{id}')->group(function(){
            Route::prefix('/materi')->group(function(){
                Route::get('/', [GuruController::class, "listMateri"]);
                Route::post('/', [GuruController::class, "materiData"]);
                Route::get('/{id_materi}', [GuruController::class, "editMateri"]);
                Route::post('/{id_materi}', [GuruController::class, "editMateriData"]);
                // Route::post('/deleteMateri/{id_materi}', [GuruController::class, "editMateriData"]);
            });
            Route::get('/materiLama', [GuruController::class, "listMateriLama"]);
            Route::get('/materiLama/{id_materi}', [GuruController::class, "detailMateriLama"]);
            Route::post('/materiLama/{id_materi}', [GuruController::class, "detailMateriLamaData"]);
            Route::prefix('/kuis')->group(function(){
                Route::get('/', [GuruController::class, "listKuis"]);
                Route::post('/', [GuruController::class, "kuisData"]);
                Route::prefix('/{id_kuis}')->group(function(){
                    Route::get('/', [GuruController::class, "listDetailKuis"]);
                    Route::post('/', [GuruController::class, "DetailKuisData"]);
                    Route::get('/hasilKuis', [GuruController::class, "hasilKuis"]);
                    Route::get('/hasilKuis/{id_nilai_kuis}', [GuruController::class, "hasilKuisAnak"]);
                    Route::get('/editDetailKuis/{id_detail_kuis}', [GuruController::class, "editDetailKuis"]);
                    Route::post('/editDetailKuis/{id_detail_kuis}', [GuruController::class, "editDetailKuisData"]);
                    Route::get('/deleteDetailKuis/{id_detail_kuis}', [GuruController::class, "deleteDetailKuis"]);
                });
            });
        });
    });
    Route::get('/ubahBatasWaktu', [GuruController::class, "ubahBatasWaktu"]);
    Route::get('/agenda', [GuruController::class, "TampilanAgenda"]);
    Route::post('/agenda', [GuruController::class, "AgendaData"]);
    Route::get('/chat', [GuruController::class, "tampilanChat"]);
    Route::post('/chat', [GuruController::class, "chatData"]);
    Route::get('/detailAgenda', [GuruController::class, "detailAgenda"]);
    Route::get('/getchatting/{nis}', [GuruController::class, "getchatting"]);
    Route::get('/sendchatting/{nis}', [GuruController::class, "sendchatting"]);
});

// ANAK
Route::prefix('/anak')->middleware("login", "userAnak")->group(function(){
    Route::get('/isiPengumuman', [AnakController::class, "isiPengumuman"]);
    Route::get('/pengumuman', [AnakController::class, "pengumuman"]);
    Route::post('/pengumuman', [AnakController::class, "statusPengumuman"]);

    Route::get('/kelas', [AnakController::class, "tampilanKelas"]);
    Route::post('/kelas', [AnakController::class, "kelasData"]);
    Route::prefix('/mapel')->group(function(){
        Route::get('/', [AnakController::class, "listMapel"]);
        Route::prefix('/{id}')->group(function(){
            Route::prefix('/materi')->group(function(){
                Route::get('/', [AnakController::class, "listMateri"]);
                Route::post('/', [AnakController::class, "materiData"]);
                Route::get('/{id_materi}', [AnakController::class, "detailMateri"]);
                Route::get('/bulan/{bulan}', [AnakController::class, "filterBulanMateri"]);
            });

            Route::prefix('/kuis')->group(function(){
                Route::get('/', [AnakController::class, "listKuis"]);
                Route::post('/', [AnakController::class, "KuisData"]);
                Route::prefix('/{id_kuis}')->group(function(){
                    Route::get('/', [AnakController::class, "listDetailKuis"]);
                    Route::get('/isiKuis', [AnakController::class, "ambilKuis"]);
                    Route::post('/isiKuis', [AnakController::class, "jawabKuis"]);
                });
                Route::get('/bulan/{bulan}', [AnakController::class, "filterBulanKuis"]);
            });
        });
    });
    Route::get('/agenda', [AnakController::class, "TampilanAgenda"]);
    Route::get('/detailAgenda', [AnakController::class, "detailAgenda"]);
    Route::get('/checklist', [AnakController::class, "checklist"]);
    Route::get('/checkCondition', [AnakController::class, "checkCondition"]);
    Route::get('/profile', [AnakController::class, "tampilanProfile"]);
    Route::post('/profile', [AnakController::class, "editProfile"]);
});

// ORANG TUA
Route::prefix('/orangTua')->middleware("login", "userOrangtua")->group(function(){
    Route::prefix('/mapel')->group(function(){
        Route::get('/', [OrangTuaController::class, "listMapel"]);
        Route::prefix('/{id}')->group(function(){
            Route::prefix('/materi')->group(function(){
                Route::get('/', [OrangTuaController::class, "listMateri"]);
                Route::post('/', [OrangTuaController::class, "materiData"]);
                Route::get('/{id_materi}', [OrangTuaController::class, "detailMateri"]);
                Route::get('/bulan/{bulan}', [OrangTuaController::class, "filterBulanMateri"]);
            });

            Route::prefix('/kuis')->group(function(){
                Route::get('/', [OrangTuaController::class, "listKuis"]);
                Route::post('/', [OrangTuaController::class, "KuisData"]);
                Route::prefix('/{id_kuis}')->group(function(){
                    Route::get('/', [OrangTuaController::class, "listDetailKuis"]);
                    Route::get('/isiKuis', [OrangTuaController::class, "ambilKuis"]);
                    Route::post('/isiKuis', [OrangTuaController::class, "jawabKuis"]);
                });
                Route::get('/bulan/{bulan}', [OrangTuaController::class, "filterBulanKuis"]);
            });
        });
    });
    Route::get('/agenda', [OrangTuaController::class, "TampilanAgenda"]);
    Route::get('/detailAgenda', [OrangTuaController::class, "detailAgenda"]);
    Route::get('/profile', [OrangTuaController::class, "tampilanProfile"]);
    Route::post('/profile', [OrangTuaController::class, "editProfile"]);
    Route::get('/evaluasi', [OrangTuaController::class, "tampilanEvaluasi"]);
    Route::post('/evaluasi', [OrangTuaController::class, "evaluasiData"]);
    Route::get('/chat', [OrangTuaController::class, "tampilanChat"]);
    Route::post('/chat', [OrangTuaController::class, "chatData"]);
    Route::get('/getchatting/{usernameGuru}', [OrangTuaController::class, "getchatting"]);
    Route::get('/sendchatting', [OrangTuaController::class, "sendchatting"]);
    Route::get('/pilihSubjek', [OrangTuaController::class, "pilihSubjek"]);
    Route::get('/printLaporan/{id_kelas}/{semester}', [OrangTuaController::class, "printLaporan"]);
});
