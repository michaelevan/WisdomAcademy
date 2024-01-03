<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.gurusidebar activePage="mapel"></x-navbars.gurusidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=""></x-navbars.navs.auth>
        <a href="{{ url('/admin/laporan') }}" style="padding: 2%"><< Kembali</a>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-1">
                        <div class="card-body px-3 pb-2">
                            <h4>List Soal Kuis {{ $namaKuis }}</h4>
                            <div class="table-responsive p-0">
                                <table class="table table-striped align-items-center mb-0" id="example">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                No
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                tipe soal
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                pertanyaan
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($listDetailKuis as $detailKuis)
                                            <tr>
                                                <td class="align-middle text-center text-sm">
                                                    {{$detailKuis->nomor_kuis}}
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    @if ($detailKuis->jenis == 1)
                                                        Pilihan Ganda
                                                    @elseif ($detailKuis->jenis == 2)
                                                        Mengurutkan
                                                    @elseif ($detailKuis->jenis == 3)
                                                        Menyamakan
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    {{$detailKuis->pertanyaan}}
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

</x-layout>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>
