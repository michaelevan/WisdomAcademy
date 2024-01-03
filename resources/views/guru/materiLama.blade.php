<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.gurusidebar activePage="mapel"></x-navbars.gurusidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=""></x-navbars.navs.auth>
        <a href="{{ url('/guru/mapel/'.$id.'/materi') }}" style="padding: 2%"><< Kembali</a>
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4">
            <div class="card card-body mx-3 mx-md-4 mt-4">
                <div class="card-body p-3">
                    <h4>Daftar Semua Materi</h4>
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
                                        Nama Materi
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Tanggal
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Guru
                                    </th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <div style="display: none">{{ $i = 1 }}</div>
                                @foreach ($listMateriLama as $materi)
                                    @if ($materi->fk_kelas != $fk_kelas)
                                        <tr>
                                            <td class="align-middle text-center text-sm">
                                                {{$i++}}
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                {{$materi->nama_materi}}
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                {{date('d F Y', strtotime($materi->updated_at))}}
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                {{$materi->nama}}
                                            </td>
                                            <td class="align-middle">
                                                <center>
                                                    <a rel="tooltip" class="btn btn-info btn-link"
                                                    href="{{ url('/guru/mapel/'.$id.'/materiLama/'.$materi->id_materi) }}">
                                                        <i class="material-icons">visibility</i>
                                                        <div class="ripple-container"></div>
                                                    </a>
                                                </center>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
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
