@props(['activePage'])

<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0 d-flex text-wrap align-items-center">
            <img src="{{ asset('assets') }}/img/wisdom-logo.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-2 font-weight-bold text-white">Wisdom Academy</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Pages</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'listPendaftaran' ? 'active bg-gradient-warning' : '' }} "
                    href="{{url('/admin/listPendaftaran')}}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-users ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">List Pendaftaran</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'manajemenTahunAjaran' ? ' active bg-gradient-warning' : '' }} "
                    href="{{url('/admin/manajemenTahunAjaran')}}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-list-ul ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Manajemen Tahun Ajaran</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'manajemenKelas' ? ' active bg-gradient-warning' : '' }} "
                    href="{{url('/admin/manajemenKelas')}}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-list-ul ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Manajemen Kelas</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'manajemenMapel' ? ' active bg-gradient-warning' : '' }} "
                    href="{{url('/admin/manajemenMapel')}}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-list-ul ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Manajemen Mata Pelajaran</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'manajemenGuru' ? ' active bg-gradient-warning' : '' }} "
                    href="{{url('/admin/manajemenGuru')}}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-list-ul ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Manajemen Guru</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'manajemenAnak' ? ' active bg-gradient-warning' : '' }} "
                        href="{{url('/admin/manajemenAnak')}}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-list-ul ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Manajemen Anak</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'manajemenEvaluasi' ? ' active bg-gradient-warning' : '' }} "
                    href="{{url('/admin/manajemenEvaluasi')}}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-list-ul ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Manajemen Subjek</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'laporan' ? ' active bg-gradient-warning' : '' }} "
                    href="{{url('/admin/laporan')}}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-scroll ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Laporan</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'profile' ? 'active bg-gradient-warning' : '' }} "
                    href="{{url('/admin/profile')}}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-user ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Profil User</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
