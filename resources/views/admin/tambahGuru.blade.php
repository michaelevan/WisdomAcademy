<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.adminsidebar activePage="manajemenGuru"></x-navbars.adminsidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=""></x-navbars.navs.auth>
        <a href="{{ url('/admin/manajemenGuru') }}" style="padding: 2%"><< Kembali</a>
        <!-- End Navbar -->
        <div class="card card-body mx-3 mx-md-4 mt-4">
            <div class="card-body p-3">
                <form method='POST' enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Username</label>
                            <input required type="text" autocomplete="off" name="username" maxlength="10" class="form-control border border-2 p-2">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Password</label>
                            <input required type="password" name="password" maxlength="15" class="form-control border border-2 p-2">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">NIK</label>
                            <input required type="text" autocomplete="off" name="nik" maxlength="16" class="form-control border border-2 p-2">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Nama</label>
                            <input required type="text" autocomplete="off" name="nama" maxlength="50" class="form-control border border-2 p-2">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Email</label>
                            <input required type="email" name="email" autocomplete="email" maxlength="50" class="form-control border border-2 p-2">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Jenis Kelamin</label>
                            <select class="form-select border border-2 p-2" aria-label="Default select example" name="j_kelamin" id="">
                                <option selected="true" disabled="disabled" style="text-align: center">--Pilih Jenis Kelamin--</option>
                                <option value="0" style="text-align: center">laki-laki</option>
                                <option value="1" style="text-align: center">perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Tanggal Masuk</label>
                            <input required type="date" autocomplete="off" name="tgl_masuk" class="form-control border border-2 p-2">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Tanggal Lahir</label>
                            <input required type="date" autocomplete="off" name="tgl_lahir" class="form-control border border-2 p-2">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Spesialis</label>
                            <input required type="text" autocomplete="off" name="spesialis" maxlength="25" class="form-control border border-2 p-2">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Nomor Identitas</label>
                            <input type="text" autocomplete="off" name="no_identitas" maxlength="16" class="form-control border border-2 p-2">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Nomor HP</label>
                            <input required type="text" autocomplete="off" name="no_hp" maxlength="15" class="form-control border border-2 p-2">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Foto</label>
                            <input type="file" name="foto" class="form-control border border-2 p-2" accept="image/*">
                        </div>
                    </div>
                    <button type="submit" style="float: right" class="btn bg-gradient-dark">Tambah Guru</button>
                </form>
            </div>
        </div>
    </main>
    {{-- <x-plugins></x-plugins> --}}
</x-layout>
