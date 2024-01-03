<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.adminsidebar activePage="manajemenAnak"></x-navbars.adminsidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=""></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-1">
                        {{-- <div class=" me-3 my-3 text-end">
                            <a class="btn bg-gradient-dark mb-0" href="{{url('/admin/tambahAnak')}}"><i
                                    class="material-icons text-sm">add</i>&nbsp;&nbsp;Tambah Anak Baru</a>
                        </div> --}}
                        <div class="card-body px-3 pb-2">
                            <h4>List Anak</h4>
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
                                                NIS <br> nama <br> jenis kelamin
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                tanggal lahir <br> kelas
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                no hp <br> alamat <br> kota
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                anak ke <br> jumlah saudara
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
                                        @if (count($listAnak) <= 0)
                                            <tr>
                                                <td colspan="7">Tidak ada data user</td>
                                            </tr>
                                        @else
                                        @foreach ($listAnak as $anak)
                                            <tr>
                                                <td class="align-middle text-center text-sm">
                                                    <div>
                                                        <img src="{{ asset('img/anak/'.$anak->foto) }}"
                                                        class="avatar avatar-sm border-radius-lg" alt="user1">
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <p class="mb-0 text-sm">{{ $anak->nis }}</p>
                                                        <p style="font-size: 30px" class="mb-0">{{ $anak->namaAnak }}</p>
                                                        @if ($anak->j_kelamin == 0)
                                                            <p class="mb-0 text-sm">laki-laki</p>
                                                        @else
                                                            <p class="mb-0 text-sm">perempuan</p>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <p class="mb-0 text-sm">{{ $anak->tgl_lahir }}</p>
                                                        <p class="mb-0 text-sm">{{ $anak->nama_kelas }}</p>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <p class="mb-0 text-sm">{{ $anak->no_hp }}</p>
                                                        <p class="mb-0 text-sm">{{ $anak->alamat }}</p>
                                                        <p class="mb-0 text-sm">{{ $anak->kota }}</p>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <p class="mb-0 text-sm">{{ $anak->anak_ke }}</p>
                                                        <p class="mb-0 text-sm">{{ $anak->jumlah_saudara }}</p>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-center">
                                                    @if ($anak->status == 0)
                                                        <span class="text-secondary text-xs font-weight-bold">Tidak Aktif</span>
                                                    @elseif ($anak->status == 1)
                                                        <span class="text-secondary text-xs font-weight-bold">Aktif</span>
                                                    @elseif ($anak->status == 2)
                                                        <span class="text-secondary text-xs font-weight-bold">Lulus</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    @if ($anak->status == 1)
                                                        <a href="{{ url("admin/laporanAnak/".$anak->nis."") }}" class="btn btn-info btn-link"
                                                            data-original-title="" title="">
                                                            <i class="material-icons">summarize</i>
                                                            <div class="ripple-container"></div>
                                                        </a>
                                                        <button class="btn bg-gradient-danger" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="statusAnak({{$anak->nis}})"><i class="material-icons">delete</i></button>
                                                    @elseif ($anak->status == 0)
                                                        <button class="btn bg-gradient-warning" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="statusAnak({{$anak->nis}})"><i class="material-icons">restore_from_trash</i></button>
                                                    @elseif ($anak->status == 2)
                                                        <a href="{{ url("admin/laporanAnak/".$anak->nis."") }}" class="btn btn-info btn-link"
                                                            data-original-title="" title="">
                                                            <i class="material-icons">summarize</i>
                                                            <div class="ripple-container"></div>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title font-weight-normal" id="exampleModalLabel">
                                                    Apakah anda ingin mengubah status anak?</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Tidak</button>
                                                <form method="post">
                                                    <input type="hidden" name="idAnak" id="idAnak">
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
    function statusAnak(nis){
        $('#idAnak').val(nis);
    }
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>
