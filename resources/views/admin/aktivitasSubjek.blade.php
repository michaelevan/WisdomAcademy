<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.adminsidebar activePage="manajemenEvaluasi"></x-navbars.adminsidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=""></x-navbars.navs.auth>
        <!-- End Navbar -->
        <a href="{{url('/admin/manajemenEvaluasi')}}" style="margin-left: 2%"> << Kembali</a>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-1">
                        <div class="card-body p-3">
                            <h4>Tambah Aktivitas {{ $nama_subjek }}</h4>
                            <form method='POST'>
                                @csrf
                                <div class="row">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Aktivitas</label>
                                        <input required autocomplete="off" type="text" name="aktivitas" maxlength="255" class="form-control border border-2 p-2">
                                    </div>
                                </div>
                                <button type="submit" style="float: right" name="btnDetailSubjek" class="btn bg-gradient-dark">Tambah Aktivitas</button>
                            </form><br><br>
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
                                                Aktivitas
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <h4>List Aktivitas {{ $nama_subjek }}</h4>
                                        <div style="display: none">{{ $i = 1 }}</div>
                                        @foreach ($dataAktivitasSubjek as $aktivitas)
                                            <tr>
                                                <td class="align-middle text-center text-sm">
                                                    {{ $i++ }}
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    {{$aktivitas->aktivitas}}
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <center><form method="post">
                                                        @csrf
                                                        {{-- <a rel="tooltip" class="btn btn-success btn-link"
                                                            href="{{ url("admin/manajemenEvaluasi/".$id."/".$aktivitas->id_aktivitas) }}" data-original-title=""
                                                            title="">
                                                            <i class="material-icons">edit</i>
                                                            <div class="ripple-container"></div>
                                                        </a> --}}
                                                        <a href="{{ url("admin/manajemenEvaluasi/".$id."/".$aktivitas->id_aktivitas) }}" class="btn btn-danger btn-link"
                                                            data-original-title="" title="">
                                                            <i class="material-icons">close</i>
                                                            <div class="ripple-container"></div>
                                                        </a>
                                                    </form></center>
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
