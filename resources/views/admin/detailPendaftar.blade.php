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
                        <div class="card-body px-0 pb-2 m-3">
                            <div class="row card-body">
                                <h5 class="card-title">Nama Siswa: {{ $pendaftaran->nama_siswa }}</h5><br><br>
                                <div class="col-sm-4">
                                    <p class="card-text">Asal Sekolah</p>
                                    <p class="card-text">Tanggal Lahir</p>
                                    <p class="card-text">Jenis Kelamin</p>
                                    <p class="card-text">Kelas</p>
                                    <p class="card-text">Nama Orang Tua</p>
                                    <p class="card-text">No HP</p>
                                    <p class="card-text">Email</p>
                                    <p class="card-text">Alamat</p>
                                    <p class="card-text">Anak Ke</p>
                                    <p class="card-text">Jumlah Saudara</p>
                                    @if ($pendaftaran->status == 0)
                                        <form method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $pendaftaran->id }}">
                                            <p> Tanggal Janji Temu : <input type="datetime-local" name="janji_temu" id="" value="{{ $pendaftaran->janji_temu }}"></p>
                                            <button class="btn bg-gradient-info" type="submit" name="btnKirim">
                                                <i class="material-icons">send</i>&nbsp;&nbsp;&nbsp;Kirim Undangan
                                            </button>
                                        </form>
                                    @elseif ($pendaftaran->status == 1)
                                        <div class="d-flex justify-content-center">
                                            <a class="btn btn-success btn-link"
                                                href="{{ url("admin/listPendaftaran/terimaPendaftaran/".$pendaftaran->id."") }}">
                                                <i class="material-icons">check</i>
                                                <div class="ripple-container">Terima</div>
                                            </a>&nbsp;&nbsp;
                                            <a class="btn btn-danger btn-link"
                                                href="{{ url("admin/listPendaftaran/tolakPendaftaran/".$pendaftaran->id."") }}">
                                                <i class="material-icons">close</i>
                                                <div class="ripple-container">Tolak</div>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-4">
                                    <p class="card-text">{{ $pendaftaran->asal_sekolah }}</p>
                                    <p class="card-text">{{ date('d F Y', strtotime($pendaftaran->tgl_lahir)) }}</p>
                                    @if ($pendaftaran->j_kelamin == 0)
                                        <p class="card-text">laki-laki</p>
                                    @else
                                        <p class="card-text">perempuan</p>
                                    @endif
                                    <p class="card-text">{{ $pendaftaran->kelas }}</p>
                                    <p class="card-text">{{ $pendaftaran->nama_orangtua }}</p>
                                    <p class="card-text">{{ $pendaftaran->no_hp }}</p>
                                    <p class="card-text">{{ $pendaftaran->email }}</p>
                                    <p class="card-text">{{ $pendaftaran->alamat }}</p>
                                    <p class="card-text">{{ $pendaftaran->anak_ke }}</p>
                                    <p class="card-text">{{ $pendaftaran->jumlah_saudara }}</p><br><br><br>
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
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>
