<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.gurusidebar activePage="kelas"></x-navbars.gurusidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=''></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="card-deck">
            <div class="row">
                <h3 style="margin-left: 5%">Daftar Anak Kelas {{ $kelasBerapa }}</h3>
                @foreach ($listKelas as $kelas)
                    <div class="card mb-2 col-md-3" style="margin: 2% 2% 2% 5%; padding-top: 2%">
                        <a href="{{ '/guru/kelas/'.$kelas->nis }}">
                            <img class="card-img-top" style="width: 50%; margin: auto; display: block;" src="{{ asset('img/anak/'.$kelas->foto) }}" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title" style="text-align: center">{{ $kelas->nama }}</h5>
                                @if ($kelas->keterangan == null)
                                    <p class="card-text" style="text-align: center">Tidak ada keterangan tambahan</p>
                                @else
                                    <p class="card-text" style="text-align: center">{{ $kelas->keterangan }}</p>
                                @endif
                                <?php
                                    $tahunSekarang = (int)date('Y');
                                    $tahunLahir = (int)substr($kelas->tgl_lahir, 0, 4);
                                    $umur = $tahunSekarang - $tahunLahir;
                                ?>
                                <p class="text-muted" style="text-align: center; font-weight: bolder">{{ $umur }} tahun</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    {{-- <x-plugins></x-plugins> --}}
</x-layout>
