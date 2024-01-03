<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.adminsidebar activePage="listPendaftaran"></x-navbars.adminsidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=""></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-1">
                        <div class="card-body px-0 pb-2">
                            <form action="" method="post">
                                @csrf
                                <div class="row" style="padding: 2%">
                                    <div class="mb-3 col-md-5">
                                        <label>Tahun</label>
                                        <select class="form-select border border-2 p-2 filterTahun" aria-label="Default select example" name="filterTahun" id="filterTahun">
                                            <option selected="true" disabled="disabled" style="text-align: center">--Pilih Tahun--</option>
                                            @foreach ($getYear as $year)
                                                <option value="{{ $year->year }}" style="text-align: center">{{ $year->year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-5">
                                        <label>Status</label>
                                        <select class="form-select border border-2 p-2 filterStatus" aria-label="Default select example" name="filterStatus" id="filterStatus">
                                            <option selected="true" disabled="disabled" style="text-align: center">--Pilih Status Pendaftaran--</option>
                                            <option value="0" style="text-align: center">Pendaftar Baru</option>
                                            <option value="1" style="text-align: center">Menunggu Konfirmasi</option>
                                            <option value="2" style="text-align: center">Diterima</option>
                                            <option value="3" style="text-align: center">Ditolak</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-2" style="padding-top: 2.5%">
                                        <button class="btn bg-gradient-dark" type="submit" name="btnFilter">Filter</button>
                                    </div>
                                </div>
                                <div style="padding: 1vh 0vw 0vh 2vw">
                                    @if ($filterTahun != null)
                                        <h3>Tahun {{ $filterTahun }}</h3>
                                    @endif
                                </div>
                            </form>
                            <div class="card-body px-3 pb-2">
                                <div class="table-responsive p-0">
                                    <table class="table table-striped align-items-center mb-0" id="example">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    No.
                                                </th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Tanggal Daftar
                                                </th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Nama Siswa
                                                </th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Nama Orangtua
                                                </th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Email
                                                </th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Status
                                                </th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Aksi
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <div style="display: none">{{ $i = 1 }}</div>
                                            @foreach ($listPendaftaran as $daftar)
                                                <tr>
                                                    <td class="align-middle text-center text-sm">
                                                        {{$i++}}
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        {{date('d F Y', strtotime($daftar->updated_at))}}
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        {{$daftar->nama_siswa}}
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        {{$daftar->nama_orangtua}}
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        {{$daftar->email}}
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        @if ($daftar->status == 0)
                                                            Pendaftar Baru
                                                        @elseif ($daftar->status == 1)
                                                            Menunggu Konfirmasi
                                                        @elseif ($daftar->status == 2)
                                                            Diterima
                                                        @elseif ($daftar->status == 3)
                                                            Ditolak
                                                        @endif
                                                    </td>
                                                    <td class="align-middle">
                                                        <center>
                                                        <a rel="tooltip" class="btn btn-info btn-link"
                                                            href="{{ url('/admin/listPendaftaran/'.$daftar->id) }}">
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
                    </div>
                </div>
            </div>
        </div>
    </main>

</x-layout>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>
