<style type='text/css'>
    .kotak{
        margin: 0;
        padding: 2%;
        transition: 0.3s;
    }
    .kotak:hover {
        background: lightgrey;
        border-radius: 0.375rem;
    }
    .kotakBulan {
        background: lightgrey;
        border-radius: 0.375rem;
    }
    .kotakBulan:hover {
        background: lightgrey;
        border-radius: 0.375rem;
    }
    .bukanKotakBulan:hover {
        background: lightgrey;
        border-radius: 0.375rem;
    }
</style>
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.ortusidebar activePage="mapel"></x-navbars.ortusidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=""></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-300 border-radius-xl mt-4"
                style="background-image: url('https://images.unsplash.com/photo-1510070112810-d4e9a46d9e91?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=869&q=80');">
                <span class="mask bg-gradient-primary opacity-6">
                    <h1 class="text-white font-weight-bolder" style="padding: 3%">{{ $id }}</h1>
                </span>
            </div>
            <div class="card card-body mx-3 mx-md-4 mt-n6">
                <div class="nav-wrapper position-relative end-0">
                    <ul class="nav nav-pills nav-fill p-1" role="tablist">
                        <li class="nav-item" style="background-color: white; box-shadow: -2px -2px 3px #ffffff, 2px 2px 3px #a0a0a0; border-radius: 8px">
                            <a class="nav-item nav-link" href="{{url('/orangTua/mapel/'.$id.'/materi')}}">
                                <i class="material-icons text-lg position-relative">school</i>
                                <span class="ms-1">Materi</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-item nav-link"  href="{{url('/orangTua/mapel/'.$id.'/kuis')}}">
                                <i class="material-icons text-lg position-relative">quiz</i>
                                <span class="ms-1">Kuis</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-3"><br>
                    <div class="row" style="padding: 2%">
                        <div class="mb-3 col-md-2">
                            <h4>Pilih Bulan</h4><br>
                            @for ($i=0; $i < count($arrNoBulan); $i++)
                                @if ($arrNoBulan[$i] == $bulan)
                                    <div class="kotakBulan">
                                        <a href="{{url('/orangTua/mapel/'.$id.'/materi/bulan/'.$arrNoBulan[$i])}}">
                                            <p style="margin: 5%">{{ $arrNamaBulan[$i] }}</p>
                                        </a><hr>
                                    </div>
                                @else
                                <div class="bukanKotakBulan">
                                    <a href="{{url('/orangTua/mapel/'.$id.'/materi/bulan/'.$arrNoBulan[$i])}}">
                                        <p style="margin: 5%">{{ $arrNamaBulan[$i] }}</p>
                                    </a><hr>
                                </div>
                                @endif
                            @endfor
                        </div>
                        <div style="height: auto; width: 1px; padding: 0%; background-color: silver"></div>
                        <div class="mb-3 col-md-8" style="margin-left: 10%">
                            <h4>List Materi</h4><br><br>
                            @if (count($listMateri) == null)
                                <p style="font-size: 20px">Tidak ada materi</p>
                            @else
                                @foreach ($listMateri as $materi)
                                    <a href="{{ url('/orangTua/mapel/'.$id.'/materi/'.$materi->id_materi) }}">
                                        <div class="d-flex col-md-12 kotak">
                                            <div class="mb-3 col-md-1">
                                                <div style="border-radius: 50%; width: 50px; height: 50px; background: yellow">
                                                    <center><i class="fas fa-tasks" style="font-size: 25px; margin-top: 20%; color: darkblue"></i></center>
                                                </div>
                                            </div>
                                            <div class="mb-3 col-md-7" style="margin-left: 2%; margin-top: 1%">
                                                <h4>{{ $materi->nama_materi }}</h4>
                                            </div>
                                            <div class="mb-3 col-md-3" style="margin-top: 1%">
                                                <p>{{ date('d F Y', strtotime($materi->updated_at)) }}</p>
                                            </div>
                                            <div class="mb-3 col-md-1" style="margin-top: 1%">
                                                <p>{{ date('H:i', strtotime($materi->updated_at)) }}</p>
                                            </div>
                                            <hr>
                                        </div>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    {{-- <x-plugins></x-plugins> --}}

</x-layout>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>
