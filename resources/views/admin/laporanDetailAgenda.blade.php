<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.anaksidebar activePage="mapel"></x-navbars.anaksidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=""></x-navbars.navs.auth>
        <a href="{{url('/admin/laporan')}}" style="margin-left: 2%"> << Kembali</a>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-1">
                        <div class="card-body p-3">
                            <div class="table-responsive">
                                <table class="table table-striped align-items-center" id="example">
                                    <h4>Tanggal {{date('d F Y', strtotime($tgl_agenda))}}</h4>
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                No
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Isi
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
                                                <td class="align-middle text-center text-sm">
                                                    {{ $agenda->isi }}
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
