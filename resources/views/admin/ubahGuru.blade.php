<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.adminsidebar activePage="manajemenGuru"></x-navbars.adminsidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=""></x-navbars.navs.auth>
        <a href="{{ url('/admin/manajemenGuru') }}" style="padding: 2%"><< Kembali</a>
        <!-- End Navbar -->
        <div class="card card-body mx-3 mx-md-4 mt-4">
            <div class="card-body p-3">
                <form method='POST'>
                    @csrf
                    <h3>Data Guru</h3><br>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Username</label>
                            <input required type="text" disabled name="username" class="form-control border border-2 p-2" value='{{ $listGuru->username }}'>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Nama</label>
                            <input required type="text" name="nama" class="form-control border border-2 p-2" value='{{ $listGuru->nama }}'>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Email</label>
                            <input required type="email" name="email" class="form-control border border-2 p-2" value='{{ $listGuru->email }}'>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">NIK</label>
                            <input required autocomplete="off" type="text" name="nik" class="form-control border border-2 p-2" value='{{ $listGuru->nik }}'>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Jenis Kelamin</label>
                            <select class="form-select border border-2 p-2" aria-label="Default select example" name="j_kelamin" id="">
                                @if ($listGuru->j_kelamin == 0)
                                    <option value="0" selected="true" style="text-align: center">laki-laki</option>
                                    <option value="1" style="text-align: center">perempuan</option>
                                @else
                                    <option value="1" selected="true" style="text-align: center">perempuan</option>
                                    <option value="0" style="text-align: center">laki-laki</option>
                                @endif
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Tanggal Lahir</label>
                            <input required type="date" name="tgl_lahir" class="form-control border border-2 p-2" value='{{ $listGuru->tgl_lahir }}'>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Tanggal Masuk</label>
                            <input required type="date" name="tgl_masuk" class="form-control border border-2 p-2" value='{{ $listGuru->tgl_masuk }}'>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">No. Identitas</label>
                            <input autocomplete="off" type="text" name="no_identitas" class="form-control border border-2 p-2" value='{{ $listGuru->no_identitas }}'>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">No. HP</label>
                            <input required autocomplete="off" type="text" name="no_hp" class="form-control border border-2 p-2" value='{{ $listGuru->no_hp }}'>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Spesialis</label>
                            <input required autocomplete="off" type="text" name="spesialis" class="form-control border border-2 p-2" value='{{ $listGuru->spesialis }}'>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select border border-2 p-2" aria-label="Default select example" name="status" id="">
                                @if ($listGuru->status == 0)
                                    <option value="0" selected="true" style="text-align: center">Tidak aktif</option>
                                    <option value="1" style="text-align: center">Aktif</option>
                                @elseif ($listGuru->status == 1)
                                    <option value="0" style="text-align: center">Tidak aktif</option>
                                    <option value="1" selected="true" style="text-align: center">Aktif</option>
                                @elseif ($listGuru->status == 2)
                                    <option value="0" style="text-align: center">Tidak aktif</option>
                                    <option value="1" style="text-align: center">Aktif</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <button type="submit" style="float: right" class="btn bg-gradient-dark">Ubah Data Guru</button>
                </form>
            </div>
        </div>
    </main>
    {{-- <x-plugins></x-plugins> --}}
</x-layout>
