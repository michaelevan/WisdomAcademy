<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.adminsidebar activePage="manajemenEvaluasi"></x-navbars.adminsidebar>
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
                                <h4>Tambah Subjek</h4>
                                <form method='POST'>
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3">
                                            <label class="form-label">Nama Subjek</label>
                                            <input required type="text" autocomplete="off" name="nama_subjek" maxlength="50" class="form-control border border-2 p-2">
                                        </div>
                                    </div>
                                    <button type="submit" name="btnTambah" style="float: right" class="btn bg-gradient-dark">Tambah Subjek</button>
                                </form><br><br>
                                <h4>List Subjek</h4>
                                <div class="table-responsive">
                                    <table class="table table-striped align-items-center" id="example">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    No
                                                </th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Nama Subjek
                                                </th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Status
                                                </th>
                                                <th
                                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Aksi
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <div style="display: none">{{ $i = 1 }}</div>
                                            @foreach ($dataSubjek as $subjek)
                                                <tr>
                                                    <td class="align-middle text-center text-sm">
                                                        {{ $i++ }}
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        {{$subjek->nama_subjek}}
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        @if ($subjek->status == 1)
                                                            Aktif
                                                        @else
                                                            Tidak Aktif
                                                        @endif
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        <center>
                                                            @if ($subjek->status == 1)
                                                                <a rel="tooltip" class="btn btn-success btn-link"
                                                                    href="{{ url("admin/manajemenEvaluasi/".$subjek->id_subjek) }}" data-original-title=""
                                                                    title="">
                                                                    <i class="material-icons">edit</i>
                                                                    <div class="ripple-container"></div>
                                                                </a>
                                                                <button class="btn bg-gradient-danger" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="statusEvaluasi({{$subjek->id_subjek}})"><i class="material-icons">delete</i></button>
                                                            @else
                                                                <button class="btn bg-gradient-warning" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="statusEvaluasi({{$subjek->id_subjek}})"><i class="material-icons">restore_from_trash</i></button>
                                                            @endif
                                                        </center>
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
                                                        Apakah anda ingin mengubah status subjek?</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Tidak</button>
                                                    <form method="post">
                                                        <input type="hidden" name="idSubjek" id="idSubjek">
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
        </div>
    </main>
    {{-- <x-plugins></x-plugins> --}}

</x-layout>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
    function statusEvaluasi(id_subjek){
        $('#idSubjek').val(id_subjek);
    }
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>
