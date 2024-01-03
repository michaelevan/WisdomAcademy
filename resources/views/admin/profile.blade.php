<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.adminsidebar activePage="profile"></x-navbars.adminsidebar>
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
                        <div class="avatar avatar-xl position-relative">
                            <img src="{{ url('/img/profile.png') }}" alt="profile_image">
                        </div>
                    </div>
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h5 class="mb-1">
                                {{ $listAdmin->username }}
                            </h5>
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
                        <form method='POST'>
                            @csrf
                            <div class="row">
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control border border-2 p-2" value='{{ $listAdmin->username }}' disabled>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input required type="email" name="email" maxlength="50" class="form-control border border-2 p-2" value='{{ $listAdmin->email }}' required autocomplete="off">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input required type="password" name="password" maxlength="10" class="form-control border border-2 p-2">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Konfirmasi Password</label>
                                    <input required type="password" name="konfirmasiPassword" maxlength="10" class="form-control border border-2 p-2">
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
