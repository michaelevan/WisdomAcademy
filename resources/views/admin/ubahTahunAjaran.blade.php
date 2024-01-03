<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.adminsidebar activePage="manajemenTahunAjaran"></x-navbars.adminsidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=""></x-navbars.navs.auth>
        <a href="{{ url('/admin/manajemenTahunAjaran') }}" style="padding: 2%"><< Kembali</a>
        <!-- End Navbar -->
        <div class="card card-body mx-3 mx-md-4 mt-4">
            <div class="card-body p-3">
                <h3>Ubah Data Tahun Ajaran {{ $thnAwal . '/' . $thnAkhir }}</h3><br>
                <form action="" method="post">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Tahun Ajaran Awal</label>
                            <input required type="text" autocomplete="off" maxlength="4" name="thnAwal" class="form-control border border-2 p-2" value='{{ $thnAwal }}'>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Tahun Ajaran Akhir</label>
                            <input required type="text" autocomplete="off" maxlength="4" name="thnAkhir" class="form-control border border-2 p-2" value='{{ $thnAkhir }}'>
                        </div>
                        <button type="submit" style="float: right" class="btn bg-gradient-dark">Ubah Data Tahun Ajaran</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    {{-- <x-plugins></x-plugins> --}}
</x-layout>
