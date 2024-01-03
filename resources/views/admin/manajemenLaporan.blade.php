<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.adminsidebar activePage="laporan"></x-navbars.adminsidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=""></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-1">
                        <div class="card-body p-3">
                            <div>
                                <form method='POST'>
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Tahun Ajaran</label>
                                        <select class="form-select border border-2 p-2" aria-label="Default select example" name="pilihTahunAjaran" id="pilihTahunAjaran" onchange="ubah()">
                                            <option selected="true" disabled="disabled" style="text-align: center">--Pilih Tahun Ajaran--</option>
                                            @foreach ($listTahunAjaran as $tahunAjaran)
                                                <option value="{{$tahunAjaran->tahun_ajaran}}" style="text-align: center">{{$tahunAjaran->tahun_ajaran}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Kelas</label>
                                        <select class="form-select border border-2 p-2" aria-label="Default select example" name="pilihKelas" id="pilihKelas">
                                            <option selected="true" disabled="disabled" style="text-align: center">--Pilih Kelas--</option>
                                        </select>
                                    </div>
                                    <button type="submit" name="btnFilter" style="float: right" class="btn bg-gradient-dark">Show Laporan</button>
                                </form><br><br>
                                @if ($dataMateri != null && $dataKuis != null && $dataAgenda != null)
                                    <div class="isiLaporan">
                                        <h3>Tahun Ajaran {{$getTahun_Kelas->tahun_ajaran}}  Kelas {{$getTahun_Kelas->nama_kelas}}</h3><br>
                                        <div class="form-check mb-3">
                                            <label for="">Pilih Data :</label>
                                            <input class="form-check-input" type="radio" name="jenis" id="jenis1" checked>&nbsp;
                                            <label class="custom-control-label" for="jenis1">Materi</label>
                                            <input class="form-check-input" type="radio" name="jenis" id="jenis2">
                                            <label class="custom-control-label" for="jenis2">Kuis</label>
                                            <input class="form-check-input" type="radio" name="jenis" id="jenis3">
                                            <label class="custom-control-label" for="jenis3">Agenda</label>
                                        </div>
                                        <div id="laporanMateri">
                                            <div class="table-responsive">
                                                <table class="table table-striped align-items-center" id="example">
                                                    <h4>List Laporan Materi</h4>
                                                    <thead>
                                                        <tr>
                                                            <th
                                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                No
                                                            </th>
                                                            <th
                                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                Nama Materi
                                                            </th>
                                                            <th
                                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                Tanggal
                                                            </th>
                                                            <th
                                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                                Aksi
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <div style="display: none">{{ $i = 1 }}</div>
                                                        @foreach ($dataMateri as $materi)
                                                            <tr>
                                                                <td class="align-middle text-center text-sm">
                                                                    {{ $i++ }}
                                                                </td>
                                                                <td class="align-middle text-center text-sm">
                                                                    {{$materi->nama_materi}}
                                                                </td>
                                                                <td class="align-middle text-center">
                                                                    {{date('d F Y', strtotime($materi->created_at))}}
                                                                </td>
                                                                <td class="align-middle text-center text-sm">
                                                                    <center>
                                                                        <a rel="tooltip" class="btn btn-info btn-link"
                                                                            href="{{ url("admin/laporan/materi/".$materi->id_materi) }}" data-original-title=""
                                                                            title="">
                                                                            <i class="material-icons">info</i>
                                                                            <div class="ripple-container"></div>
                                                                        </a>
                                                                    </center>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div id="laporanKuis">
                                            <div class="table-responsive">
                                                <table class="table table-striped align-items-center" id="example2">
                                                    <h4>List Laporan Kuis</h4>
                                                    <thead>
                                                        <tr>
                                                            <th
                                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                No
                                                            </th>
                                                            <th
                                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                Nama Kuis
                                                            </th>
                                                            <th
                                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                Tanggal
                                                            </th>
                                                            <th
                                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                                Aksi
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <div style="display: none">{{ $i = 1 }}</div>
                                                        @foreach ($dataKuis as $kuis)
                                                            <tr>
                                                                <td class="align-middle text-center text-sm">
                                                                    {{ $i++ }}
                                                                </td>
                                                                <td class="align-middle text-center text-sm">
                                                                    {{$kuis->nama_kuis}}
                                                                </td>
                                                                <td class="align-middle text-center">
                                                                    {{date('d F Y', strtotime($kuis->created_at))}}
                                                                </td>
                                                                <td class="align-middle text-center text-sm">
                                                                    <center>
                                                                        <a rel="tooltip" class="btn btn-info btn-link"
                                                                            href="{{ url("admin/laporan/kuis/".$kuis->id_kuis) }}" data-original-title=""
                                                                            title="">
                                                                            <i class="material-icons">info</i>
                                                                            <div class="ripple-container"></div>
                                                                        </a>
                                                                    </center>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div id="laporanAgenda">
                                            <div class="table-responsive">
                                                <table class="table table-striped align-items-center" id="example3">
                                                    <h4>List Laporan Agenda</h4>
                                                    <thead>
                                                        <tr>
                                                            <th
                                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                No
                                                            </th>
                                                            <th
                                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                                Tanggal
                                                            </th>
                                                            <th
                                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                                Aksi
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <div style="display: none">{{ $i = 1 }}</div>
                                                        @foreach ($dataAgenda as $agenda)
                                                            <tr>
                                                                <td class="align-middle text-center text-sm">
                                                                    {{ $i++ }}
                                                                </td>
                                                                <td class="align-middle text-center">
                                                                    {{date('d F Y', strtotime($agenda->tanggal))}}
                                                                </td>
                                                                <td class="align-middle text-center text-sm">
                                                                    <center>
                                                                        <a rel="tooltip" class="btn btn-info btn-link"
                                                                            href="{{ url("admin/laporan/agenda/".$agenda->tanggal) }}" data-original-title=""
                                                                            title="">
                                                                            <i class="material-icons">info</i>
                                                                            <div class="ripple-container"></div>
                                                                        </a>
                                                                    </center>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    {{-- <x-plugins></x-plugins> --}}

</x-layout>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
    var myurl = "<?php echo URL::to('/'); ?>";
    function ubah() {
        var tahunAjaran = $('#pilihTahunAjaran').val();
        $.get(myurl + `/admin/laporan/getKelas`,
            {tahunAjaran: tahunAjaran},
            function(result) {
                var arr = JSON.parse(result);
                $("#pilihKelas").html("");
                for (let i = 0; i < arr.length; i++) {
                    $('#pilihKelas').append('<option value="' + arr[i].id_kelas + '">' + arr[i].nama_kelas + '</option>');
                }
            }
        );
    }
    $(document).ready(function () {
        $('#example').DataTable();
        $('#example2').DataTable();
        $('#example3').DataTable();

        $('#laporanKuis').css('display', 'none');
        $('#laporanAgenda').css('display', 'none');

        $('#jenis1').on('click', laporanMateri);
        $('#jenis2').on('click', laporanKuis);
        $('#jenis3').on('click', laporanAgenda);

        function laporanMateri() {
            $('#laporanMateri').css('display', 'block');
            $('#laporanKuis').css('display', 'none');
            $('#laporanAgenda').css('display', 'none');
        }
        function laporanKuis() {
            $('#laporanMateri').css('display', 'none');
            $('#laporanKuis').css('display', 'block');
            $('#laporanAgenda').css('display', 'none');
        }
        function laporanAgenda() {
            $('#laporanMateri').css('display', 'none');
            $('#laporanKuis').css('display', 'none');
            $('#laporanAgenda').css('display', 'block');
        }
    });
</script>
