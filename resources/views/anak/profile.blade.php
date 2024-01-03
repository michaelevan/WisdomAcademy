<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.anaksidebar activePage="profile"></x-navbars.anaksidebar>
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
                        <img src="{{ url('img/anak/'.$dataAnak->foto) }}" class="avatar avatar-xl" alt="profile_image">
                    </div>
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h5 class="mb-1">
                                {{ $dataAnak->nis }}
                            </h5>
                            <p class="mb-0 font-weight-normal text-sm">
                                {{ $dataAnak->nama }}
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
                                <div class="mb-3">
                                    <label class="form-label">nis</label>
                                    <input type="text" autocomplete="off" name="nis" class="form-control border border-2 p-2" value='{{ $dataAnak->nis }}' disabled>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nama</label>
                                    <input required type="text" autocomplete="off" name="nama" maxlength="50" class="form-control border border-2 p-2" value='{{ $dataAnak->nama }}' required autocomplete="off">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Foto Profil</label>
                                    <input type="file" accept="image/*" name="foto" class="form-control border border-2 p-2"'>
                                </div>
                            </div>
                            <button type="submit" style="float: right" class="btn bg-gradient-dark">Ubah Profil</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <x-plugins></x-plugins> --}}
</x-layout>
