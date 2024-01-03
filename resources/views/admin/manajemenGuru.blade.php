<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.adminsidebar activePage="manajemenGuru"></x-navbars.adminsidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=""></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-1">
                        <div class="me-3 my-3 text-end">
                            <a class="btn bg-gradient-dark mb-0" href="{{url('/admin/tambahGuru')}}">
                                <i class="material-icons text-sm">add</i>&nbsp;&nbsp;Tambah Guru Baru
                            </a>
                        </div>
                        <div class="card-body px-3 pb-2">
                            <h4>List Guru</h4>
                            <div class="table-responsive p-0">
                                <table class="table table-striped align-items-center mb-0" id="example">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                foto
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                nik <br> nama <br> jenis kelamin
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                no hp <br> email
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                spesialis <br> tanggal masuk
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                status
                                            </th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($listGuru as $guru)
                                            <tr>
                                                <td class="align-middle text-center text-sm">
                                                    <div>
                                                        <img src="{{ asset('img/guru/'.$guru->foto) }}"
                                                        class="avatar avatar-sm border-radius-lg" alt="user1">
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <p class="mb-0 text-sm">{{ $guru->nik }}</p>
                                                        <p style="font-size: 30px" class="mb-0">{{ $guru->nama }}</p>
                                                        @if ($guru->j_kelamin == 0)
                                                            <p class="mb-0 text-sm">laki-laki</p>
                                                        @else
                                                            <p class="mb-0 text-sm">perempuan</p>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <p class="mb-0 text-sm">{{ $guru->no_hp }}</p>
                                                    <p class="mb-0 text-sm">{{ $guru->email }}</p>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <p style="font-size: 20px" class="mb-0">{{ $guru->spesialis }}</p>
                                                    <p class="mb-0 text-sm">{{ date('d-m-Y', strtotime($guru->tgl_masuk)) }}</p>
                                                </td>
                                                <td class="align-middle text-center">
                                                    @if ($guru->status == 0)
                                                        <span class="text-secondary text-xs font-weight-bold">Tidak Aktif</span>
                                                    @elseif ($guru->status == 1)
                                                        <span class="text-secondary text-xs font-weight-bold">Aktif</span>
                                                    @elseif ($guru->status == 2)
                                                        <span class="text-secondary text-xs font-weight-bold">Cuti</span>
                                                    @elseif ($guru->status == 3)
                                                        <span class="text-secondary text-xs font-weight-bold">Lulus</span>
                                                    @elseif ($guru->status == 4)
                                                        <span class="text-secondary text-xs font-weight-bold">Berhenti</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <form method="post">
                                                        @csrf
                                                        <a rel="tooltip" class="btn btn-success btn-link"
                                                            href="{{ url("admin/ubahGuru/".$guru->username."") }}" data-original-title=""
                                                            title="">
                                                            <i class="material-icons">edit</i>
                                                            <div class="ripple-container"></div>
                                                        </a>
                                                        {{-- <a href="{{ url("admin/banGuru/".$guru->username."") }}" class="btn btn-danger btn-link"
                                                            data-original-title="" title="">
                                                            <i class="material-icons">close</i>
                                                            <div class="ripple-container"></div>
                                                        </a> --}}
                                                    </form>
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
