<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.adminsidebar activePage="manajemenMapel"></x-navbars.adminsidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=""></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-1">
                        <div class="card-body p-3">
                            <h4>Tambah Mata Pelajaran</h4>
                            <form method='POST'>
                                @csrf
                                <div class="row">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Mata Pelajaran</label>
                                        <input required type="text" autocomplete="off" name="nama_mapel" maxlength="25" class="form-control border border-2 p-2">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">KKM</label>
                                        <input required type="number" autocomplete="off" name="kkm" min="0" max="99" class="form-control border border-2 p-2">
                                    </div>
                                </div>
                                <button type="submit" name="btnTambah" style="float: right;" class="btn bg-gradient-dark">Tambah Mata Pelajaran</button>
                            </form>
                        </div>

                        <div class="card-body px-3 pb-2">
                            <h4>List Mata Pelajaran</h4>
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
                                                Nama Mata Pelajaran
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                KKM
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
                                        <div style="display: none">{{$i = 1}}</div>
                                        @foreach ($dataMapel as $mapel)
                                            <tr>
                                                <td class="align-middle text-center col-md-1">
                                                    {{$i++}}
                                                </td>
                                                <td class="align-middle text-center">
                                                    {{$mapel->nama_mapel}}
                                                </td>
                                                <td class="align-middle text-center">
                                                    {{$mapel->kkm}}
                                                </td>
                                                <td class="align-middle text-center">
                                                    @if ($mapel->status == 1)
                                                        Aktif
                                                    @else
                                                        Tidak Aktif
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    @if ($mapel->status == 1)
                                                        <a rel="tooltip" class="btn btn-success btn-link"
                                                            href="{{ url("admin/manajemenMapel/".$mapel->id_mapel."") }}" data-original-title=""
                                                            title="">
                                                            <i class="material-icons">edit</i>
                                                            <div class="ripple-container"></div>
                                                        </a>
                                                        <button class="btn bg-gradient-danger" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="statusMapel({{$mapel->id_mapel}})"><i class="material-icons">delete</i></button>
                                                    @else
                                                        <button class="btn bg-gradient-warning" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="statusMapel({{$mapel->id_mapel}})"><i class="material-icons">restore_from_trash</i></button>
                                                    @endif
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title font-weight-normal" id="exampleModalLabel">
                                                    Apakah anda ingin mengubah status mata pelajaran?</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Tidak</button>
                                                <form method="post">
                                                    <input type="hidden" name="idMapel" id="idMapel">
                                                    @csrf
                                                    <button type="submit" name="btnStatus" class="btn bg-gradient-primary">Ya</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
    function statusMapel(id_mapel){
        $('#idMapel').val(id_mapel);
    }
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>
