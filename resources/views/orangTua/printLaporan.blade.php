<style type="text/css">
.body{
    background-image: url('assets/img/wisdom-logo.png'); /* Ganti dengan path gambar Anda */
    /* background-repeat: repeat; Sesuaikan sesuai kebutuhan, misalnya repeat-x atau repeat-y */
}
.watermark {
    display: none;
}
@media print {
    body {
        background-image: url('assets/img/wisdom-logo.png');
    }

    .watermark {
        display: block;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        opacity: 0.5; /* Atur tingkat transparansi sesuai kebutuhan (0.0 - 1.0) */
    }
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.ortusidebar activePage="evaluasi"></x-navbars.ortusidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=""></x-navbars.navs.auth>
        <a href="{{url('/orangTua/evaluasi/')}}" style="margin-left: 2%"> << Kembali</a>
        <!-- End Navbar -->
        <div class="card card-body mx-3 mx-md-4 mt-4">
            <img src="assets/img/wisdom-logo.png" alt="Watermark" class="watermark">
            <div class="mb-3" style="display: flex; justify-content: flex-end">
                <button type="button" class="btn bg-gradient-danger" onclick="printDiv('printLaporan')">
                    <i class="material-icons">print</i>
                </button>
            </div>
            <input type="hidden" id="idKelas" value="{{ $kelas->id_kelas }}">
            <input type="hidden" id="idSemester" value="{{ $semester }}">
            <div id="printLaporan">
                <div class="card-body p-3">
                    <center>@if ($semester == 1)
                        <h3>Kelas {{ $kelas->nama_kelas }} Semester Ganjil Tahun Ajaran {{ $kelas->tahun_ajaran }}</h3>
                    @else
                        <h3>Kelas {{ $kelas->nama_kelas }} Semester Genap Tahun Ajaran {{ $kelas->tahun_ajaran }}</h3>
                    @endif</center><br><br>
                    <h4>Profil Anak</h4><br>
                    <div class="table-responsive p-0">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td style="border-bottom: none">Nama Lengkap Anak</td>
                                    <td style="border-bottom: none">: {{ $dataOrangtua->namaAnak }}</td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: none">Jenis Kelamin</td>
                                    <td style="border-bottom: none">:
                                        @if ($dataOrangtua->j_kelamin == 0)
                                            Laki - Laki
                                        @else
                                            Perempuan
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: none">Tanggal Lahir</td>
                                    <td style="border-bottom: none">: {{ $dataOrangtua->kota }},&nbsp;{{ date('d F Y', strtotime($dataOrangtua->tgl_lahir)) }}</td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: none">Pendidikan</td>
                                    <td style="border-bottom: none">:
                                        @if (substr($kelas->nama_kelas, 0, 1) == '7')
                                            VII (Tujuh) SMP
                                        @elseif (substr($kelas->nama_kelas, 0, 1) == '8')
                                            VIII (Delapan) SMP
                                        @elseif (substr($kelas->nama_kelas, 0, 1) == '9')
                                            IX (Sembilan) SMP
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: none">Nama Orang Tua</td>
                                    <td style="border-bottom: none">: {{ $dataOrangtua->nama }}</td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: none">Alamat</td>
                                    <td style="border-bottom: none">: {{ $dataOrangtua->alamat }}</td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: none">Nomor Telepon</td>
                                    <td style="border-bottom: none">: {{ $dataOrangtua->no_hp }}</td>
                                </tr>
                                <tr>
                                    <td style="border-bottom: none">Keterangan</td>
                                    <td style="border-bottom: none">:
                                        @if ($dataOrangtua->keterangan == null)
                                            -</span>
                                        @else
                                            {{ $dataOrangtua->keterangan }}</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-body p-3">
                    <center><h4>Nilai Rapor Kuantitatif</h4></center>
                    <div class="table-responsive p-0">
                        <table class="table table-striped" style="text-align: center">
                            <thead>
                                <tr>
                                    <th
                                        style="border: 1px solid; width: 1%">
                                        No
                                    </th>
                                    <th
                                        style="border: 1px solid; width: 89%">
                                        Komponen
                                    </th>
                                    <th
                                        style="border: 1px solid; width: 5%">
                                        KKM
                                    </th>
                                    <th
                                    style="border: 1px solid; width: 5%">
                                        Nilai
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <div style="display: none">{{ $i = 1 }}</div>
                                @foreach ($listMapel as $nilaiMapel)
                                    <tr>
                                        <td style="border: 1px solid">
                                            {{$i++}}
                                        </td>
                                        <td style="border: 1px solid; text-align: left">
                                            {{$nilaiMapel->nama_mapel}}
                                        </td>
                                        <td style="border: 1px solid">
                                            {{$nilaiMapel->kkm}}
                                        </td>
                                        <td style="border: 1px solid">
                                            {{$nilaiMapel->nilai}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div><br>
                    <label class="form-label">Komentar Guru</label>
                    @if ($komentarRapor == null)
                        <textarea class="form-control border border-2 p-2" disabled>Tidak Ada Komentar</textarea>
                    @else
                        <textarea class="form-control border border-2 p-2" disabled>{{ $komentarRapor->komentar }}</textarea>
                    @endif
                </div><br>
                <div class="card-body p-3">
                    <h6>Achievement Rating :</h6>
                    <div class="table-responsive p-0">
                        <table class="table table-striped">
                            <thead>
                                <tr style="text-align: center">
                                    <th>Rating Key</th>
                                    <th>Indicator</th>
                                </tr>
                            </thead>
                            <tbody>
                                <div style="display: none">{{$i = 1}}</div>
                                <tr>
                                    <td class="align-middle">
                                        WD = Well Development
                                    </td>
                                    <td class="align-middle">
                                        Menunjukkan pengetahuan dan keterampilan secara konsisten, Achievement melebihi tujuan, Independent 80-100% keberhasilan
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">
                                        D = Developed
                                    </td>
                                    <td class="align-middle">
                                        Menunjukkan sebagian besar pengetahuan dan keterampilan secara mandiri dengan kesalahan minimum yang diperlukan. <br>Achievment memenuhi tujuan. Supervised 60-79% achievement
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">
                                        DG = Developing
                                    </td>
                                    <td class="align-middle">
                                        Menunjukkan beberapa pengetahuan dan keterampilan independent dengan beberapa pengawasan yang diperlukan, petunjuk, atau, <br>arahan. Belum konsisten benar dan sesuai dengan response kriteria. Achievement masih di bawah keterampilan yang dibutuhkan. <br>Minimal prompt, 40-59% achievement
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">
                                        NI = Needs Improvement
                                    </td>
                                    <td class="align-middle">
                                        Belum menunjukkan adanya pengetahuan dan keterampilan yang dibutuhkan, perlu modifikasi luas dalam strategi mengajar untuk <br>mencapai respon kriteria yang diharapkan. Intrusive prompt, 20-39% achievement
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">
                                        NC = Not Capable
                                    </td>
                                    <td class="align-middle">
                                        Tidak memahami atau tidak mampu merespon instruksi yang diberikan. Merespon dengan bantuan penuh. Pengetahuan dan <br> keterampilan belum atau baru saja diperkenalkan. Full prompt, 0-19% achievement
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div><br><br>
                </div>
                <div class="card-body p-3">
                    @foreach ($listSubjek as $subjek)
                        <center><h4>Subjek : {{ $subjek->nama_subjek }}</h4></center>
                        <div class="table-responsive p-0">
                            @if ($subjek->id_subjek != 13)
                                <table class="table table-striped" style="text-align: center">
                                    <thead>
                                        <tr>
                                            <th style="border: 1px solid; width: 1%">
                                                No
                                            </th>
                                            <th style="border: 1px solid; width: 89%">
                                                Aktivitas
                                            </th>
                                            <th style="border: 1px solid; width: 5%">
                                                Scoring
                                            </th>
                                            <th style="border: 1px solid; width: 5%">
                                                %
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <div style="display: none">{{$i = 1}}</div>
                                        @foreach ($subjek->aktivitas as $listAktivitas)
                                            <tr>
                                                <td style="border: 1px solid">{{ $i++ }}</td>
                                                <td style="border: 1px solid; text-align: left">{{ $listAktivitas->aktivitas }}</td>
                                                    @if ($listAktivitas->nilai == "")
                                                        <td style="border: 1px solid"></td>
                                                    @elseif ($listAktivitas->nilai >= 80)
                                                        <td style="border: 1px solid">WD</td>
                                                    @elseif ($listAktivitas->nilai >= 60 && $listAktivitas->nilai < 80)
                                                        <td style="border: 1px solid">D</td>
                                                    @elseif ($listAktivitas->nilai >= 40 && $listAktivitas->nilai < 60)
                                                        <td style="border: 1px solid">DG</td>
                                                    @elseif ($listAktivitas->nilai >= 20 && $listAktivitas->nilai < 40)
                                                        <td style="border: 1px solid">NI</td>
                                                    @else
                                                        <td style="border: 1px solid">NC</td>
                                                    @endif
                                                <td style="border: 1px solid">{{ $listAktivitas->nilai }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table><br>
                                <label class="form-label">Komentar Guru</label>
                                @if ($subjek->komentar == null)
                                    <textarea class="form-control border border-2 p-2" disabled>Tidak Ada Komentar</textarea>
                                @else
                                    <textarea class="form-control border border-2 p-2" disabled>{{ $subjek->komentar }}</textarea>
                                @endif
                            @else
                                <table class="table table-striped" style="text-align: center">
                                    <thead>
                                        <tr>
                                            <th
                                                style="border: 1px solid; width: 1%">
                                                No
                                            </th>
                                            <th
                                                style="border: 1px solid; width: 89%">
                                                Perilaku
                                            </th>
                                            <th
                                                style="border: 1px solid; width: 2%">
                                                Selalu
                                            </th>
                                            <th
                                                style="border: 1px solid; width: 2%">
                                                Sering
                                            </th>
                                            <th
                                                style="border: 1px solid; width: 2%">
                                                Jarang
                                            </th>
                                            <th
                                                style="border: 1px solid; width: 2%">
                                                Kadang
                                            </th>
                                            <th
                                                style="border: 1px solid; width: 2%">
                                                Tidak Ada
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <div style="display: none">{{$i = 1}}</div>
                                        @foreach ($subjek->aktivitas as $listAktivitas)
                                            <tr>
                                                <td style="border: 1px solid">{{ $i++ }}</td>
                                                <td style="border: 1px solid; text-align: left">{{ $listAktivitas->aktivitas }}</td>
                                                @if ($listAktivitas->perilaku == ""|| $listAktivitas->perilaku == null)
                                                    <td style="border: 1px solid"></td>
                                                    <td style="border: 1px solid"></td>
                                                    <td style="border: 1px solid"></td>
                                                    <td style="border: 1px solid"></td>
                                                    <td style="border: 1px solid"></td>
                                                @elseif ($listAktivitas->perilaku == 1)
                                                    <td style="border: 1px solid">&#10004;</td>
                                                    <td style="border: 1px solid"></td>
                                                    <td style="border: 1px solid"></td>
                                                    <td style="border: 1px solid"></td>
                                                    <td style="border: 1px solid"></td>
                                                @elseif ($listAktivitas->perilaku == 2)
                                                    <td style="border: 1px solid"></td>
                                                    <td style="border: 1px solid">&#10004;</td>
                                                    <td style="border: 1px solid"></td>
                                                    <td style="border: 1px solid"></td>
                                                    <td style="border: 1px solid"></td>
                                                @elseif ($listAktivitas->perilaku == 3)
                                                    <td style="border: 1px solid"></td>
                                                    <td style="border: 1px solid"></td>
                                                    <td style="border: 1px solid">&#10004;</td>
                                                    <td style="border: 1px solid"></td>
                                                    <td style="border: 1px solid"></td>
                                                @elseif ($listAktivitas->perilaku == 4)
                                                    <td style="border: 1px solid"></td>
                                                    <td style="border: 1px solid"></td>
                                                    <td style="border: 1px solid"></td>
                                                    <td style="border: 1px solid">&#10004;</td>
                                                    <td style="border: 1px solid"></td>
                                                @elseif ($listAktivitas->perilaku == 5)
                                                    <td style="border: 1px solid"></td>
                                                    <td style="border: 1px solid"></td>
                                                    <td style="border: 1px solid"></td>
                                                    <td style="border: 1px solid"></td>
                                                    <td style="border: 1px solid">&#10004;</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table><br>
                                <label class="form-label">Komentar Guru</label>
                                @if ($subjek->komentar == null)
                                    <textarea class="form-control border border-2 p-2" disabled>Tidak Ada Komentar</textarea>
                                @else
                                    <textarea class="form-control border border-2 p-2" disabled>{{ $subjek->komentar }}</textarea>
                                @endif
                            @endif
                        </div><br><br>
                    @endforeach
                </div>
            </div>
        </div>
    </main>
</x-layout>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script>
    function printDiv(divName) {
        var id_kelas = $("#idKelas").val();
        var semester = $("#idSemester").val();
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        window.location = '/orangTua/printLaporan/' + id_kelas + '/' + semester;
    }

</script>
