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
                <a class="nav-link text-white {{ $activePage == 'kelas' ? 'active bg-gradient-warning' : '' }} "
                    href="{{url('/guru/kelas')}}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-door-open ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Kelas</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'mapel' ? ' active bg-gradient-warning' : '' }} "
                    href="{{url('/guru/mapel')}}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-book-open ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Mata Pelajaran</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'agenda' ? ' active bg-gradient-warning' : '' }} "
                    href="{{url('/guru/agenda')}}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem" class="fa fa-calendar ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Agenda Harian</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'chat' ? ' active bg-gradient-warning' : '' }} "
                    href="{{url('/guru/chat')}}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem" class="fas fa-comment ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Chat</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'profile' ? ' active bg-gradient-warning' : '' }} "
                    href="{{url('/guru/profile')}}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem" class="fas fa-user-circle ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Profil User</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
