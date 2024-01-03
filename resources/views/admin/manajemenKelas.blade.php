<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.adminsidebar activePage="manajemenKelas"></x-navbars.adminsidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=""></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-1">
                        <div class="card-body p-3">
                            <h4>Tambah Kelas</h4>
                            <form method='POST'>
                                @csrf
                                <div class="row">
                                    <div class="mb-3">
                                        <label class="form-label">Tahun Ajaran</label>
                                        <select class="form-select border border-2 p-2" aria-label="Default select example" name="tahun_ajaran" id="">
                                            <option selected="true" disabled="disabled" style="text-align: center">--Pilih Tahun Ajaran--</option>
                                            @foreach ($listTahunAjaran as $tahunAjaran)
                                                <option value="{{$tahunAjaran->tahun_ajaran}}" style="text-align: center">{{$tahunAjaran->tahun_ajaran}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Kelas (contoh penulisan 7A)</label>
                                        <input required type="text" autocomplete="off" name="nama_kelas" maxlength="2" pattern="[7-9]{1}[A-Z]{1}" class="form-control border border-2 p-2">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Wali Kelas</label>
                                        <select class="form-select border border-2 p-2" aria-label="Default select example" name="wali_kelas" id="">
                                            <option selected="true" disabled="disabled" style="text-align: center">--Pilih Guru Wali--</option>
                                            @foreach ($listGuru as $guru)
                                                <option value="{{$guru->username}}" style="text-align: center">{{$guru->nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" name="btnKelas" style="float: right" class="btn bg-gradient-dark">Tambah Kelas</button>
                            </form>
                        </div>
                        <div class="card-body px-3 pb-2">
                            <h4>List Kelas</h4>
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
                                                Nama Kelas
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Wali Kelas
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($listKelas as $kelas)
                                            <tr>
                                                <td class="align-middle text-center text-sm">
                                                    {{$kelas->tahun_ajaran}}
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    {{$kelas->nama_kelas}}
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    {{$kelas->nama}}
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
