<style type='text/css'>
    .resizeable {
        table-layout: fixed;
        width: 100%;
    }

    .resizeable th,
    .resizeable td {
        word-wrap: break-word;
        border: 1px solid #ccc;
        padding: 5px;
    }
    .resizeable th {
        background-color: #f2f2f2;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.gurusidebar activePage="kelas"></x-navbars.gurusidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=""></x-navbars.navs.auth>
        <a href="{{ url('/guru/kelas') }}" style="padding: 2%"><< Kembali</a>
        <!-- End Navbar -->
        <div class="card card-body mx-3 mx-md-4 mt-4">
            <div class="card-body p-3">
                <h3>Profil Anak</h3><br>
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Nama Lengkap Anak</label>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">: &nbsp;&nbsp;{{ $dataAnak->namaAnak }}</label>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Jenis Kelamin</label>
                    </div>
                    <div class="mb-3 col-md-6">
                        @if ($dataAnak->j_kelamin == 0)
                            <label class="form-label">: &nbsp;&nbsp;Laki - Laki</label>
                        @else
                            <label class="form-label">: &nbsp;&nbsp;Perempuan</label>
                        @endif
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Tanggal Lahir</label>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">: &nbsp;&nbsp;{{ $dataAnak->kota }},&nbsp;{{ date('d F Y', strtotime($dataAnak->tgl_lahir)) }}</label>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Pendidikan</label>
                    </div>
                    <div class="mb-3 col-md-6">
                        @if ($kelas->nama_kelas == '7A' || $kelas->nama_kelas == '7B')
                            <label class="form-label">: &nbsp;&nbsp;VII (Tujuh) SMP</label>
                        @elseif ($kelas->nama_kelas == '8A' || $kelas->nama_kelas == '8B')
                            <label class="form-label">: &nbsp;&nbsp;VIII (Delapan) SMP</label>
                        @elseif ($kelas->nama_kelas == '9A' || $kelas->nama_kelas == '9B')
                            <label class="form-label">: &nbsp;&nbsp;IX (Sembilan) SMP</label>
                        @endif
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Nama Orang Tua</label>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">: &nbsp;&nbsp;{{ $dataAnak->nama }}</label>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Alamat</label>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">: &nbsp;&nbsp;{{ $dataAnak->alamat }}</label>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Nomor Telepon</label>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">: &nbsp;&nbsp;{{ $dataAnak->no_hp }}</label>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Keterangan</label>
                    </div>
                    <div class="mb-3 col-md-6">
                        @if ($dataAnak->keterangan == null)
                            <label class="form-label">: &nbsp;&nbsp;-</label>
                        @else
                            <label class="form-label">: &nbsp;&nbsp;{{ $dataAnak->keterangan }}</label>
                        @endif
                    </div>
                </div>
            </div>
            <form action="" method="post">
                @csrf
                <div class="row">
                    <div class="mb-3 col-md-3">
                        <select class="form-select border border-2 p-2" aria-label="Default select example" name="pilihSemester" id="pilihSemester">
                            <option selected="true" disabled="disabled" style="text-align: center">--Pilih Semester--</option>
                            <option value="1" @if(old('pilihSemester') == 1) selected @endif style="text-align: center">Ganjil</option>
                            <option value="2" @if(old('pilihSemester') == 2) selected @endif style="text-align: center">Genap</option>
                        </select>
                    </div>
                    <div class="mb-3 col-md-3">
                        <button type="submit" class="btn bg-gradient-dark" name="btnSemester">Show</button>
                    </div>
                </div>
            </form>
            <input type='hidden' id='nis' value='{{ $dataAnak->nis }}'>
            <input type='hidden' id='kelas' value='{{ $dataAnak->kelas }}'>
            <input type='hidden' id='semester' value='{{ $semester }}'>
            @if ($semester != null)
                <input type='hidden' id='id_detailsiswa' value='{{ $id_detailsiswa }}'>
                @if ($semester == 1)
                    <h4>Semester Ganjil</h4>
                @else
                    <h4>Semester Genap</h4>
                @endif
                <nav>
                    <div class="nav nav-tabs" id="nav-tab-kelas" role="tablist">
                        <div class="nav-item nav-link active" id="nav-rapor">Nilai Rapor</div>
                        <div class="nav-item nav-link" id="nav-aktivitas">Nilai Aktivitas</div>
                    </div>
                </nav><br>
                <div class="card-body p-3" id="rapor">
                    <form action="" method="post">
                        @csrf
                        <div class="table-responsive p-0">
                            <table class="table table-striped" style="text-align: center" id="example2">
                                <thead>
                                    <tr>
                                        <th
                                            style="border: 1px solid; width: 1%">
                                            No
                                        </th>
                                        <th
                                            style="border: 1px solid; width: 84%; text-align: center">
                                            Komponen
                                        </th>
                                        <th
                                            style="border: 1px solid; width: 5%">
                                            Kkm
                                        </th>
                                        <th
                                        style="border: 1px solid; width: 10%">
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
                                                <input type="number" class="form-control border border-2 p-2" max="100" value="{{ $nilaiMapel->nilai }}" id="nilai_rapor{{ $nilaiMapel->id_mapel }}" onchange="simpanRapor({{ $nilaiMapel->id_mapel }})">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div><br><br>
                        <label class="form-label">Komentar Guru</label>
                        @if ($dataKomentar == null)
                            <textarea class="form-control border border-2 p-2" id="komentarNilai" onchange="simpanKomentarNilai()" placeholder="Berikan Komentar Anda"></textarea><br>
                        @else
                            <textarea class="form-control border border-2 p-2" id="komentarNilai" onchange="simpanKomentarNilai()">{{ $dataKomentar->komentar }}</textarea><br>
                        @endif
                    </form>
                </div>
                <div class="card-body p-3" id="aktivitas" style="display: none">
                    <h6>Achievement Rating :</h6>
                    <div class="table-responsive p-0">
                        <table class="table table-striped align-items-center mb-0 resizeable" id="tabelIndikator">
                            <thead>
                                <tr>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 col-md-3 resizeable">
                                        Rating Key
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 col-md-9 resizeable">
                                        Indicator
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <div style="display: none">{{$i = 1}}</div>
                                <tr>
                                    <td class="align-middle">
                                        WD = Well Development
                                    </td>
                                    <td class="align-middle resizeable">
                                        Menunjukkan pengetahuan dan keterampilan secara konsisten, Achievement melebihi tujuan, Independent 80-100% keberhasilan
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">
                                        D = Developed
                                    </td>
                                    <td class="align-middle resizeable">
                                        Menunjukkan sebagian besar pengetahuan dan keterampilan secara mandiri dengan kesalahan minimum yang diperlukan achievment memenuhi tujuan. Supervised 60-79% achievement
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">
                                        DG = Developing
                                    </td>
                                    <td class="align-middle resizeable">
                                        Menunjukkan beberapa pengetahuan dan keterampilan independent dengan beberapa pengawasan yang diperlukan, petunjuk, atau, <br>arahan. Belum konsisten benar dan sesuai dengan response kriteria. Achievement masih di bawah keterampilan yang dibutuhkan. <br>Minimal prompt, 40-59% achievement
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">
                                        NI = Needs Improvement
                                    </td>
                                    <td class="align-middle resizeable">
                                        Belum menunjukkan adanya pengetahuan dan keterampilan yang dibutuhkan, perlu modifikasi luas dalam strategi mengajar untuk <br>mencapai respon kriteria yang diharapkan. Intrusive prompt, 20-39% achievement
                                    </td>
                                </tr>
                                <tr>
                                    <td class="align-middle">
                                        NC = Not Capable
                                    </td>
                                    <td class="align-middle resizeable">
                                        Tidak memahami atau tidak mampu merespon instruksi yang diberikan. Merespon dengan bantuan penuh. Pengetahuan dan <br> keterampilan belum atau baru saja diperkenalkan. Full prompt, 0-19% achievement
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div><br><br>
                    <form action="" method="post">
                        @csrf
                        <div class="row">
                            <div class="mb-3">
                                <select class="form-select border border-2 p-2" aria-label="Default select example" name="pilihSubjek" id="pilihSubjek">
                                    <option selected="true" disabled="disabled" style="text-align: center">--Pilih Subjek--</option>
                                    @foreach ($listSubjek as $subjek)
                                        <option value="{{$subjek->id_subjek}}" style="text-align: center">{{$subjek->nama_subjek}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div><br><br>
                        <div id="isiTabel"></div>
                    </form>
                </div>
            @endif
        </div>
    </main>
    {{-- <x-plugins></x-plugins> --}}
</x-layout>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const navItems = document.querySelectorAll(".nav-item");
        navItems.forEach(item => {
            item.addEventListener("click", function() {
                // Remove 'active' class from all items
                navItems.forEach(i => i.classList.remove("active"));
                // Add 'active' class to the clicked item
                item.classList.add("active");
            });
        });
    });
    var myurl = "<?php echo URL::to('/'); ?>";

    function simpanRapor(id_mapel) {
        var nilai = $("#nilai_rapor" + id_mapel).val();
        var semester = $("#semester").val();
        var id_detailsiswa = $("#id_detailsiswa").val();
        var nis = $("#nis").val();
        $.get(myurl + `/guru/kelas/inputRapor/${nis}`,
            {nilai: nilai, id_mapel: id_mapel, semester: semester, id_detailsiswa: id_detailsiswa},
            function(result){
                // alert(result);
            }
        );
    }

    function simpanKomentarNilai() {
        var nis = $("#nis").val();
        var komentar = $("#komentarNilai").val();
        var semester = $("#semester").val();
        var id_detailsiswa = $("#id_detailsiswa").val();
        $.get(myurl + `/guru/kelas/komentarNilai/${nis}`,
            {komentar: komentar, semester: semester, id_detailsiswa: id_detailsiswa},
            function(result){
                // alert(result);
            }
        );
    }

    function simpanScoring(id_aktivitas) {
        var nilai = $("#scoring" + id_aktivitas).val();
        var nis = $("#nis").val();
        var pilihSubjek = $("#pilihSubjek").val();
        var semester = $("#semester").val();
        var id_detailsiswa = $("#id_detailsiswa").val();
        $.get(myurl + `/guru/kelas/inputScoring/${nis}`,
            {nilai: nilai, pilihSubjek: pilihSubjek, semester: semester, id_aktivitas: id_aktivitas, id_detailsiswa: id_detailsiswa},
            function(result){
                // alert(result);
            }
        );
    }

    function simpanKomentarSubjek() {
        var komentar = $("#komentarSubjek").val();
        var nis = $("#nis").val();
        var pilihSubjek = $("#pilihSubjek").val();
        var semester = $("#semester").val();
        var id_detailsiswa = $("#id_detailsiswa").val();
        $.get(myurl + `/guru/kelas/komentarSubjek/${nis}`,
            {pilihSubjek: pilihSubjek, semester: semester, komentar: komentar, id_detailsiswa: id_detailsiswa},
            function(result){
                // alert(result);
            }
        );
    }

    function simpanPerilaku(id_aktivitas, idx) {
        // alert(id_aktivitas);
        // alert(idx);
        var nilai = $('input[name="checkPerilaku' + idx + '"]:checked').val();
        // alert(nilai);
        var nis = $("#nis").val();
        var pilihSubjek = $("#pilihSubjek").val();
        var semester = $("#semester").val();
        var id_detailsiswa = $("#id_detailsiswa").val();
        $.get(myurl + `/guru/kelas/inputPerilaku/${nis}`,
            {id_aktivitas: id_aktivitas, nilai: nilai, pilihSubjek: pilihSubjek, semester: semester, id_detailsiswa: id_detailsiswa},
            function(result){
                // alert(result);
            }
        );
    }

    $(document).ready(function () {
        $('#example2').dataTable();
        $('#nav-rapor').on('click', rapor);
        $('#nav-aktivitas').on('click', aktivitas);

        function rapor() {
            $('#rapor').css('display', 'block');
            $('#aktivitas').css('display', 'none');
        }
        function aktivitas() {
            $('#rapor').css('display', 'none');
            $('#aktivitas').css('display', 'block');
        }
        function ubahcombo(id_subjek) {
            let nis = $('#nis').val();
            let kelas = $('#kelas').val();
            let semester = $('#semester').val();
            $.get(myurl + '/guru/pilihSubjek',
                {id_subjek: id_subjek, nis: nis, kelas: kelas, semester: semester},
                function(result){
                    var arr = JSON.parse(result);
                    let isiDetail = '';
                    if (result == '[]') {
                        isiDetail += '<p>Tidak ada isi subjek</p>';
                    }
                    else{
                        isiDetail += '<div class="table-responsive p-0">';
                        isiDetail += '<table class="table table-striped" style="text-align: center" id="example">';
                        isiDetail += '<thead>';
                        isiDetail += '<tr>';
                        var idx = false;
                        let cekKomentar = false;
                        let isiKomentar = "";
                        for (let i = 0; i < arr.length; i++) {
                            if (arr[i].id_subjek == 13) {
                                idx = true;
                            }
                            if (arr[i].komentar != null) {
                                cekKomentar = true;
                                isiKomentar = arr[i].komentar;
                            }
                        }
                        if (idx) {
                            isiDetail += '<th style="border: 1px solid; width: 1%">No.</th>';
                            isiDetail += '<th style="border: 1px solid; text-align: center; width: 89%">Perilaku</th>';
                            isiDetail += '<th style="border: 1px solid; width: 2%">Selalu</th>';
                            isiDetail += '<th style="border: 1px solid; width: 2%">Sering</th>';
                            isiDetail += '<th style="border: 1px solid; width: 2%">Jarang</th>';
                            isiDetail += '<th style="border: 1px solid; width: 2%">Kadang</th>';
                            isiDetail += '<th style="border: 1px solid; width: 2%">Tidak Ada</th>';
                            isiDetail += '</tr>';
                            isiDetail += '</thead>';
                            isiDetail += '<tbody style="border: 1px solid">';
                            for(var i = 0; i < arr.length; i++) {
                                isiDetail +='<tr>';
                                isiDetail +='<td style="border: 1px solid">' + (i+1) + '</td>';
                                isiDetail +='<td style="border: 1px solid; text-align: left">' + arr[i].aktivitas + '</td>';
                                if (arr[i].perilaku == "" || arr[i].perilaku == null) {
                                    isiDetail +='<td style="border: 1px solid"><input type="radio" value="1" name="checkPerilaku' + (i+1) + '" onchange="simpanPerilaku(' + arr[i].id_aktivitas + ', ' + (i+1) + ')"></td>';
                                    isiDetail +='<td style="border: 1px solid"><input type="radio" value="2" name="checkPerilaku' + (i+1) + '" onchange="simpanPerilaku(' + arr[i].id_aktivitas + ', ' + (i+1) + ')"></td>';
                                    isiDetail +='<td style="border: 1px solid"><input type="radio" value="3" name="checkPerilaku' + (i+1) + '" onchange="simpanPerilaku(' + arr[i].id_aktivitas + ', ' + (i+1) + ')"></td>';
                                    isiDetail +='<td style="border: 1px solid"><input type="radio" value="4" name="checkPerilaku' + (i+1) + '" onchange="simpanPerilaku(' + arr[i].id_aktivitas + ', ' + (i+1) + ')"></td>';
                                    isiDetail +='<td style="border: 1px solid"><input type="radio" value="5" name="checkPerilaku' + (i+1) + '" onchange="simpanPerilaku(' + arr[i].id_aktivitas + ', ' + (i+1) + ')"></td>';
                                }
                                else{
                                    if (arr[i].perilaku == 1) {
                                        isiDetail +='<td style="border: 1px solid"><input type="radio" value="1" checked="" name="checkPerilaku' + (i+1) + '" onchange="simpanPerilaku(' + arr[i].id_aktivitas + ', ' + (i+1) + ')"></td>';
                                        isiDetail +='<td style="border: 1px solid"><input type="radio" value="2" name="checkPerilaku' + (i+1) + '" onchange="simpanPerilaku(' + arr[i].id_aktivitas + ', ' + (i+1) + ')"></td>';
                                        isiDetail +='<td style="border: 1px solid"><input type="radio" value="3" name="checkPerilaku' + (i+1) + '" onchange="simpanPerilaku(' + arr[i].id_aktivitas + ', ' + (i+1) + ')"></td>';
                                        isiDetail +='<td style="border: 1px solid"><input type="radio" value="4" name="checkPerilaku' + (i+1) + '" onchange="simpanPerilaku(' + arr[i].id_aktivitas + ', ' + (i+1) + ')"></td>';
                                        isiDetail +='<td style="border: 1px solid"><input type="radio" value="5" name="checkPerilaku' + (i+1) + '" onchange="simpanPerilaku(' + arr[i].id_aktivitas + ', ' + (i+1) + ')"></td>';
                                    }
                                    else if(arr[i].perilaku == 2){
                                        isiDetail +='<td style="border: 1px solid"><input type="radio" value="1" name="checkPerilaku' + (i+1) + '" onchange="simpanPerilaku(' + arr[i].id_aktivitas + ', ' + (i+1) + ')"></td>';
                                        isiDetail +='<td style="border: 1px solid"><input type="radio" value="2" checked="" name="checkPerilaku' + (i+1) + '" onchange="simpanPerilaku(' + arr[i].id_aktivitas + ', ' + (i+1) + ')"></td>';
                                        isiDetail +='<td style="border: 1px solid"><input type="radio" value="3" name="checkPerilaku' + (i+1) + '" onchange="simpanPerilaku(' + arr[i].id_aktivitas + ', ' + (i+1) + ')"></td>';
                                        isiDetail +='<td style="border: 1px solid"><input type="radio" value="4" name="checkPerilaku' + (i+1) + '" onchange="simpanPerilaku(' + arr[i].id_aktivitas + ', ' + (i+1) + ')"></td>';
                                        isiDetail +='<td style="border: 1px solid"><input type="radio" value="5" name="checkPerilaku' + (i+1) + '" onchange="simpanPerilaku(' + arr[i].id_aktivitas + ', ' + (i+1) + ')"></td>';
                                    }
                                    else if(arr[i].perilaku == 3){
                                        isiDetail +='<td style="border: 1px solid"><input type="radio" value="1" name="checkPerilaku' + (i+1) + '" onchange="simpanPerilaku(' + arr[i].id_aktivitas + ', ' + (i+1) + ')"></td>';
                                        isiDetail +='<td style="border: 1px solid"><input type="radio" value="2" name="checkPerilaku' + (i+1) + '" onchange="simpanPerilaku(' + arr[i].id_aktivitas + ', ' + (i+1) + ')"></td>';
                                        isiDetail +='<td style="border: 1px solid"><input type="radio" value="3" checked="" name="checkPerilaku' + (i+1) + '" onchange="simpanPerilaku(' + arr[i].id_aktivitas + ', ' + (i+1) + ')"></td>';
                                        isiDetail +='<td style="border: 1px solid"><input type="radio" value="4" name="checkPerilaku' + (i+1) + '" onchange="simpanPerilaku(' + arr[i].id_aktivitas + ', ' + (i+1) + ')"></td>';
                                        isiDetail +='<td style="border: 1px solid"><input type="radio" value="5" name="checkPerilaku' + (i+1) + '" onchange="simpanPerilaku(' + arr[i].id_aktivitas + ', ' + (i+1) + ')"></td>';
                                    }
                                    else if(arr[i].perilaku == 4){
                                        isiDetail +='<td style="border: 1px solid"><input type="radio" value="1" name="checkPerilaku' + (i+1) + '" onchange="simpanPerilaku(' + arr[i].id_aktivitas + ', ' + (i+1) + ')"></td>';
                                        isiDetail +='<td style="border: 1px solid"><input type="radio" value="2" name="checkPerilaku' + (i+1) + '" onchange="simpanPerilaku(' + arr[i].id_aktivitas + ', ' + (i+1) + ')"></td>';
                                        isiDetail +='<td style="border: 1px solid"><input type="radio" value="3" name="checkPerilaku' + (i+1) + '" onchange="simpanPerilaku(' + arr[i].id_aktivitas + ', ' + (i+1) + ')"></td>';
                                        isiDetail +='<td style="border: 1px solid"><input type="radio" value="4" checked="" name="checkPerilaku' + (i+1) + '" onchange="simpanPerilaku(' + arr[i].id_aktivitas + ', ' + (i+1) + ')"></td>';
                                        isiDetail +='<td style="border: 1px solid"><input type="radio" value="5" name="checkPerilaku' + (i+1) + '" onchange="simpanPerilaku(' + arr[i].id_aktivitas + ', ' + (i+1) + ')"></td>';
                                    }
                                    else if(arr[i].perilaku == 5){
                                        isiDetail +='<td style="border: 1px solid"><input type="radio" value="1" name="checkPerilaku' + (i+1) + '" onchange="simpanPerilaku(' + arr[i].id_aktivitas + ', ' + (i+1) + ')"></td>';
                                        isiDetail +='<td style="border: 1px solid"><input type="radio" value="2" name="checkPerilaku' + (i+1) + '" onchange="simpanPerilaku(' + arr[i].id_aktivitas + ', ' + (i+1) + ')"></td>';
                                        isiDetail +='<td style="border: 1px solid"><input type="radio" value="3" name="checkPerilaku' + (i+1) + '" onchange="simpanPerilaku(' + arr[i].id_aktivitas + ', ' + (i+1) + ')"></td>';
                                        isiDetail +='<td style="border: 1px solid"><input type="radio" value="4" name="checkPerilaku' + (i+1) + '" onchange="simpanPerilaku(' + arr[i].id_aktivitas + ', ' + (i+1) + ')"></td>';
                                        isiDetail +='<td style="border: 1px solid"><input type="radio" value="5" checked="" name="checkPerilaku' + (i+1) + '" onchange="simpanPerilaku(' + arr[i].id_aktivitas + ', ' + (i+1) + ')"></td>';
                                    }
                                }
                                isiDetail +='</tr>';
                            }
                            isiDetail += '</tbody>';
                            isiDetail += '</table>';
                            isiDetail += '</div><br><br>';
                        }
                        else{
                            isiDetail += '<th style="border: 1px solid; width: 1%">No.</th>';
                            isiDetail += '<th style="border: 1px solid; text-align: center; width: 84%">Aktivitas</th>';
                            isiDetail += '<th style="border: 1px solid; width: 5%">Scoring</th>';
                            isiDetail += '<th style="border: 1px solid; width: 10%">%</th>';
                            isiDetail += '</tr>';
                            isiDetail += '</thead>';
                            isiDetail += '<tbody style="border: 1px solid">';
                            let cekKomentar = false;
                            let isiKomentar = "";
                            for(var i = 0; i < arr.length; i++) {
                                isiDetail +='<tr>';
                                isiDetail +='<td style="border: 1px solid">' + (i+1) + '</td>';
                                isiDetail +='<td style="border: 1px solid; text-align: left">' + arr[i].aktivitas + '</td>';
                                if (arr[i].nilai == '') {
                                    isiDetail +='<td style="border: 1px solid"></td>';
                                }
                                else if (arr[i].nilai >= 80) {
                                    isiDetail +='<td style="border: 1px solid">WD</td>';
                                }
                                else if (arr[i].nilai >= 60 && arr[i].nilai < 80) {
                                    isiDetail +='<td style="border: 1px solid">D</td>';
                                }
                                else if (arr[i].nilai >= 40 && arr[i].nilai < 60) {
                                    isiDetail +='<td style="border: 1px solid">DG</td>';
                                }
                                else if (arr[i].nilai >= 20 && arr[i].nilai < 40) {
                                    isiDetail +='<td style="border: 1px solid">NI</td>';
                                }
                                else {
                                    isiDetail +='<td style="border: 1px solid">NC</td>';
                                }
                                isiDetail +='<td style="border: 1px solid"><input type="number" class="form-control border border-2 p-2" max="100" value="' + arr[i].nilai + '" id="scoring' + arr[i].id_aktivitas + '" onchange="simpanScoring(' + arr[i].id_aktivitas + ')"></td>';
                                isiDetail +='</tr>';
                            }
                            isiDetail += '</tbody>';
                            isiDetail += '</table>';
                            isiDetail += '</div><br><br>';
                        }
                        isiDetail += '<label class="form-label">Komentar Guru</label>';
                        if (cekKomentar) {
                            isiDetail += '<textarea class="form-control border border-2 p-2" id="komentarSubjek" onchange="simpanKomentarSubjek()">' + isiKomentar + '</textarea><br>';
                        }
                        else{
                            isiDetail += '<textarea class="form-control border border-2 p-2" placeholder="Berikan Komentar Anda" id="komentarSubjek" onchange="simpanKomentarSubjek()"></textarea><br>';
                        }
                        $('#isiTabel').html(isiDetail);
                        $('#example').dataTable();
                    }
                }
            );
        }
        $('#pilihSubjek').change(function(){
            let id_subjek = $(this).val();
            ubahcombo(id_subjek);
        });

        ubahcombo($("#pilihSubjek").val());
    });


</script>

