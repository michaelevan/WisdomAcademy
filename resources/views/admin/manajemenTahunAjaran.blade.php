<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.adminsidebar activePage="manajemenTahunAjaran"></x-navbars.adminsidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=""></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-1">
                        <div class="card-body p-3">
                            <h4>Tambah Tahun Ajaran</h4>
                            <form method='POST'>
                                @csrf
                                <div class="row">
                                    <label>Tahun Ajaran</label>
                                    <div class="mb-3 col-md-5">
                                        <input required type="text" autocomplete="off" name="thnAwal" maxlength="4" class="form-control border border-2 p-2">
                                    </div>
                                    <div class="mb-3 col-md-2">
                                        <center><span style="font-size: 30px">/</span></center>
                                    </div>
                                    <div class="mb-3 col-md-5">
                                        <input required type="text" autocomplete="off" name="thnAkhir" maxlength="4" class="form-control border border-2 p-2">
                                    </div>
                                </div>
                                <button type="submit" name="btnTambah" style="float: right" class="btn bg-gradient-dark">Tambah Tahun Ajaran</button>
                            </form>
                        </div>

                        <div class="card-body px-3 pb-2">
                            <h4>List Tahun Ajaran</h4>
                            <div class="table-responsive p-0">
                                <table class="table table-striped align-items-center mb-0" id="example">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Tahun Ajaran
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Tanggal Mulai
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Tanggal Selesai
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Status
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($listTahunAjaran as $tahunAjaran)
                                            <tr>
                                                <td class="align-middle text-center text-sm">
                                                    {{$tahunAjaran->tahun_ajaran}}
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    @if ($tahunAjaran->tgl_mulai == null)
                                                        -
                                                    @else
                                                        {{date('d F Y', strtotime($tahunAjaran->tgl_mulai))}}
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    @if ($tahunAjaran->tgl_akhir == null)
                                                        -
                                                    @else
                                                        {{date('d F Y', strtotime($tahunAjaran->tgl_akhir))}}
                                                    @endif
                                                </td>
                                                <form method="post">
                                                    @csrf
                                                    <input type="hidden" name="id_tahun_ajaran" value="{{$tahunAjaran->tahun_ajaran}}">
                                                    @if ($tahunAjaran->status == 0)
                                                        <td class="align-middle text-center text-sm">
                                                            Tidak Aktif
                                                        </td>
                                                        <td class="align-middle text-center text-sm">
                                                            <?php
                                                                $getTahun = explode('/', $tahunAjaran->tahun_ajaran);
                                                                $getThnAwal = $getTahun[0];
                                                                $getThnAkhir = $getTahun[1];
                                                            ?>
                                                            <a rel="tooltip" class="btn btn-info btn-link"
                                                                href="{{ url('/admin/manajemenTahunAjaran/'.$getThnAwal.'-'.$getThnAkhir) }}" data-original-title=""
                                                                title="">
                                                                <i class="material-icons">edit</i>
                                                                <div class="ripple-container"></div>
                                                            </a>
                                                            @if ((int)substr($tahunAjaranAktif, 0, 4) < (int)substr($tahunAjaran->tahun_ajaran, 0, 4))
                                                                <button type="submit" name="btnStatus" class="btn bg-gradient-danger">Aktifkan</button>
                                                            @endif
                                                        </td>
                                                    @else
                                                        <td class="align-middle text-center text-sm">
                                                            Aktif
                                                        </td>
                                                        <td></td>
                                                    @endif
                                                </form>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>
