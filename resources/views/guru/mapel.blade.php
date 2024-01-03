<style type="text/css">
    .tossing:hover {
        animation-name: tossing;
        -webkit-animation-name: tossing;
        animation-duration: 2.5s;
        -webkit-animation-duration: 2.5s;
        animation-iteration-count: infinite;
        -webkit-animation-iteration-count: infinite;
    }

    @keyframes tossing {
        0% {
            transform: rotate(-1deg);
        }
        50% {
            transform: rotate(1deg);
        }
        100% {
            transform: rotate(-1deg);
        }
    }

    @-webkit-keyframes tossing {
        0% {
            -webkit-transform: rotate(-1deg);
        }
        50% {
            -webkit-transform: rotate(1deg);
        }
        100% {
            -webkit-transform: rotate(-1deg);
        }
    }
</style>
<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.gurusidebar activePage="mapel"></x-navbars.gurusidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=''></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="card-deck">
            @foreach ($listMapel as $mapel)
                @if ($mapel->status == 1)
                    <a href="{{url('guru/mapel/'.$mapel->nama_mapel.'/materi')}}">
                        <div class="card" style="margin: 2%">
                            <div class="card-body tossing" style="padding: 2%">
                                <p class="card-text">Mata Pelajaran</p>
                                <h5 class="card-title">{{ $mapel->nama_mapel }}</h5>
                            </div>
                        </div>
                    </a>
                @endif
            @endforeach
        </div>
    </div>
    {{-- <x-plugins></x-plugins> --}}
</x-layout>
