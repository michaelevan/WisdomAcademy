<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.anaksidebar activePage="kelas"></x-navbars.anaksidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=''></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="card-deck">
            <div class="row">
                <div class="d-flex">
                    <div class="mb-2 col-md-8">
                        <h3 style="margin: 3%">Daftar Kelas {{ $guru->nama_kelas }}</h3>
                        <div class="card" style="margin: 3%; background-color: lightgrey;">
                            <div class="card-body" style="padding: 2%">
                                <div class="d-flex">
                                    <div class="mb-2 col-md-1">
                                        <img src="{{ asset('img/anak/'.$dataAnak->foto) }}" class="avatar avatar-xl w-100 border-radius"
                                        alt="user1">
                                    </div>
                                    <div class="mb-2 col-md-7" style="margin-left: 5%">
                                        <h5 class="card-title px-3">{{ $dataAnak->nama }}</h5>
                                        @if ($dataAnak->j_kelamin == 0)
                                            <p class="card-text px-3">Laki - Laki</p>
                                        @else
                                            <p class="card-text px-3">Perempuan</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @foreach ($dataKelas as $anak)
                        @if ($anak->nis != session()->get('login')->username)
                            <div class="card" style="margin: 3%">
                                <div class="card-body" style="padding: 2%">
                                    <div class="d-flex">
                                        <div class="mb-2 col-md-1">
                                            <img src="{{ asset('img/anak/'.$anak->foto) }}" class="avatar avatar-xl w-100 border-radius"
                                            alt="user1">
                                        </div>
                                        <div class="mb-2 col-md-7" style="margin-left: 5%">
                                            <h5 class="card-title px-3">{{ $anak->nama }}</h5>
                                            @if ($anak->j_kelamin == 0)
                                                <p class="card-text px-3">Laki - Laki</p>
                                            @else
                                                <p class="card-text px-3">Perempuan</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @endforeach
                    </div>&nbsp;&nbsp;&nbsp;
                    <div class="card mb-2 col-md-2" style=" margin-top: 7%; padding-top: 2%; height: 50vh">
                        <h5 class="card-title" style="text-align: center">Wali Kelas</h5>
                        <img class="card-img-top" style="width: 50%; height: 100%; margin: auto; display: block;" src="{{ asset('img/guru/'.$guru->foto) }}" alt="Card image cap">
                        <div class="card-body" style="text-align: center;">
                            <h5 class="card-title">{{ $guru->nama }}</h5>
                            @if ($guru->j_kelamin == 0)
                                <p class="card-text">Laki - Laki</p>
                            @else
                                <p class="card-text">Perempuan</p>
                            @endif
                            <p class="card-text">{{ $umur }} tahun</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
