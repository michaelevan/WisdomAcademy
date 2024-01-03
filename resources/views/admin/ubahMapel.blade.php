<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.adminsidebar activePage="manajemenMapel"></x-navbars.adminsidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=""></x-navbars.navs.auth>
        <a href="{{ url('/admin/manajemenMapel') }}" style="padding: 2%"><< Kembali</a>
        <!-- End Navbar -->
        <div class="card card-body mx-3 mx-md-4 mt-4">
            <div class="card-body p-3">
                <h3>Ubah Data Mata Pelajaran {{ $dataMapel->nama_mapel }}</h3><br>
                <div class="row">
                    <form action="" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Mata Pelajaran</label>
                            <input required type="text" autocomplete="off" maxlength="25" name="nama_mapel" class="form-control border border-2 p-2" value='{{ $dataMapel->nama_mapel }}'>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">KKM</label>
                            <input required type="number" autocomplete="off" max="100" name="kkm" class="form-control border border-2 p-2" value='{{ $dataMapel->kkm }}'>
                        </div>
                        <button type="submit" style="float: right" class="btn bg-gradient-dark">Ubah Data</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    {{-- <x-plugins></x-plugins> --}}
</x-layout>
