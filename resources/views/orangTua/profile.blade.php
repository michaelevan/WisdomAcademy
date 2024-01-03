<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<x-layout bodyClass="g-sidenav-show bg-gray-200">

    <x-navbars.ortusidebar activePage="profile"></x-navbars.ortusidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=''></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-300 border-radius-xl mt-4"
                style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
                <span class="mask  bg-gradient-primary  opacity-6"></span>
            </div>
            <div class="card card-body mx-3 mx-md-4 mt-n6">
                <div class="row gx-4 mb-2">
                    <div class="col-auto">
                        <img src="{{ asset('img/profile.png') }}" class="avatar avatar-xl" alt="profile_image">
                    </div>
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h5 class="mb-1">
                                {{ $dataOrangtua->username }}
                            </h5>
                            <p class="mb-0 font-weight-normal text-sm">
                                {{ $dataOrangtua->nama }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card card-plain h-100">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-md-8 d-flex align-items-center">
                                <h6 class="mb-3">Informasi Profil</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <form method='POST' enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Username</label>
                                    <input type="text" autocomplete="off" name="username" class="form-control border border-2 p-2" value='{{ $dataOrangtua->username }}' disabled>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Alamat Email</label>
                                    <input required type="email" required autocomplete="email" name="email" class="form-control border border-2 p-2" value='{{ $dataOrangtua->email }}'>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Nama</label>
                                    <input required type="text" required autocomplete="off" name="nama" class="form-control border border-2 p-2" value='{{ $dataOrangtua->nama }}'>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">No. HP</label>
                                    <input required type="text" required autocomplete="off" name="no_hp" class="form-control border border-2 p-2" value='{{ $dataOrangtua->no_hp }}'>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Alamat</label>
                                    <input required type="text" required autocomplete="off" name="alamat" class="form-control border border-2 p-2" value='{{ $dataOrangtua->alamat }}'>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Kota</label>
                                    <input required type="text" required autocomplete="off" name="kota" class="form-control border border-2 p-2" value='{{ $dataOrangtua->kota }}'>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Akte Lahir</label><br>
                                    <img src="{{ asset('img/anak/'.$dataOrangtua->akte_lahir) }}" alt="" style="width: 100px; margin-bottom: 3%">
                                    <input type="file" accept="image/*" name="akte_lahir" class="form-control border border-2 p-2">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Kartu Keluarga</label><br>
                                    <img src="{{ asset('img/anak/'.$dataOrangtua->kartu_keluarga) }}" alt="" style="width: 100px; margin-bottom: 3%">
                                    <input type="file" accept="image/*" name="kartu_keluarga" class="form-control border border-2 p-2"'>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Password</label>
                                    <input required type="password" required name="password" class="form-control border border-2 p-2" value='{{ $dataOrangtua->password }}'>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Konfirmasi Password</label>
                                    <input required type="password" required name="konfirmasiPassword" class="form-control border border-2 p-2">
                                </div>
                            </div>
                            <div style="float: right">
                                <button type="submit" class="btn bg-gradient-dark">Edit Profil</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <x-plugins></x-plugins> --}}

</x-layout>
