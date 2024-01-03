<style>
    .image{
        opacity: 1;
        display: block;
        width: 100%;
        height: auto;
        transition: .5s ease;
        backface-visibility: hidden;
    }
    .isi{
        transition: .5s ease;
        opacity: 0;
        position: absolute;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        text-align: center;
        margin: 35px 0px 0px 75px;

    }
    .gambar:hover .image{
        opacity : 0.3;
    }
    .gambar:hover .isi{
        opacity: 3;
    }
    .ikon{
        border-radius: 50%;
        padding: 10px;
        width: 100%;
        color: black;
        background-color: grey;
    }
</style>
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.ortusidebar activePage="mapel"></x-navbars.ortusidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=""></x-navbars.navs.auth>
        <a href="{{url('/orangTua/mapel/'.$id.'/kuis')}}" style="margin-left: 2%"> << Kembali</a>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-1">
                        <div class="card-body p-3">
                            <div class="row" style="padding: 2%">
                                <div class="mb-3 col-md-12">
                                    <div class="d-flex">
                                        <div class="mb-0 col-md-1">
                                            <div style="border-radius: 50%; width: 50px; height: 50px; background: #bbb">
                                                <center><i class="fas fa-tasks" style="font-size: 25px; margin-top: 20%"></i></center>
                                            </div>
                                        </div>
                                        <div class="mb-0 col-md-7">
                                            <h4>{{ $kuis->nama_kuis }}</h4>
                                            <div class="d-flex">
                                                <div class="col-md-4" style="margin-top: 1%">
                                                    <p>{{ date('d F Y H:i', strtotime($kuis->updated_at)) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($hasilKuis == null)
                                            <div class="mb-0 col-md-4" style="display: flex; justify-content: flex-end">
                                                <div style="background-color: red; border-radius: 50%; margin-top: 1%; height: 20px;">
                                                    <i class="material-icons" style="color: white">close</i>
                                                </div>&nbsp;&nbsp; Not Submited
                                            </div>
                                        @else
                                            <div class="mb-0 col-md-4" style="text-align: right">
                                                <span style="background-color: yellowgreen; border-radius: 50%">
                                                    <i class="material-icons" style="color: white">check</i>
                                                </span>&nbsp; Submited
                                                <div class="col-md-12" style="margin-top: 1%">
                                                    @if (substr($hasilKuis->nilai, 3, 1) >= '5')
                                                        Grade : {{ ceil($hasilKuis->nilai) }} / 100
                                                    @else
                                                        Grade : {{ floor($hasilKuis->nilai) }} / 100
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div><hr>
                                    @if ($hasilKuis != null)
                                        <h6>Jawaban Kuis</h6>
                                        <div style="display: none">{{ $i = 1 }}</div>
                                        @foreach ($listDetailKuis as $list)
                                            <?php
                                                $opsiJawaban = json_decode($list->option_value);
                                                $gambarSoal = json_decode($list->soal_img);
                                                $jwbnAnakTipe2 = json_decode($list->jwbnAnak);
                                            ?>
                                            {{ $i++ . '. ' . $list->pertanyaan }}<br>
                                            @for ($k=0; $k < count($gambarSoal); $k++)
                                                @if ($gambarSoal[$k] != null || $gambarSoal[$k] != "")
                                                    <img src="{{ asset('img/kuis/soal/'.$gambarSoal[$k]) }}" width="150vw" alt="" style="padding: 2%">
                                                @endif
                                            @endfor
                                            @if ($list->jenis != 3)
                                                @if (substr($list->option_value, 0, 1) == '[')
                                                    @for ($j=0; $j < count($opsiJawaban); $j++)
                                                        @if ($list->jenis == 1)
                                                            @if ($j == 0)
                                                                <div style="background-color: greenyellow; margin-left: 1vw; padding: 1%" class="border-radius-lg">
                                                            @else
                                                                @if ($opsiJawaban[$j] == $list->jwbnAnak)
                                                                    <div style="background-color: #ff2c2c; margin-left: 1vw; color: white; padding: 1%" class="border-radius-lg">
                                                                @else
                                                                    <div style="margin-left: 1vw">
                                                                @endif
                                                            @endif
                                                            {{chr(65+$j)}}. {{ $opsiJawaban[$j] }}
                                                            @if ($opsiJawaban[$j] == $list->jwbnAnak)
                                                                @if ($j == 0)
                                                                    <span style="background-color: greenyellow; padding: 1%" class="border-radius-lg">
                                                                @else
                                                                    <span style="background-color: #ff2c2c; color: white; padding: 1%" class="border-radius-lg">
                                                                @endif
                                                                // Jawaban Anda </span>
                                                            @endif
                                                            </div><br>
                                                        @elseif ($list->jenis == 2)
                                                            <div class="row" style="margin-left: 1vw">
                                                                <span>Urutan ke {{ $j+1 }}</span>
                                                                <div style="background-color: greenyellow; margin-left: 1vw; padding: 1%" class="col-md-5 border-radius-lg">
                                                                    {{ $opsiJawaban[$j] }}
                                                                </div>
                                                                @if (substr($list->jwbnAnak, 0, 1) == '[')
                                                                    @if ($opsiJawaban[$j] == $jwbnAnakTipe2[$j])
                                                                        <div style="background-color: greenyellow; margin-left: 1vw; padding: 1%" class="col-md-5 border-radius-lg">
                                                                            {{ $jwbnAnakTipe2[$j] }}
                                                                        </div>
                                                                    @else
                                                                        <div style="background-color: #ff2c2c; margin-left: 1vw; padding: 1%; color: white" class="col-md-5 border-radius-lg">
                                                                            {{ $jwbnAnakTipe2[$j] }}
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            </div><br>
                                                        @endif
                                                    @endfor
                                                @endif
                                            @else
                                                <br>
                                                @if ($list->option_value == $list->jwbnAnak)
                                                    <span style="background-color: greenyellow; margin-left: 1vw; padding: 1%" class="col-md-5 border-radius-lg"> {{$list->jwbnAnak}}</span>
                                                @else
                                                    @if ($list->jwbnAnak != '')
                                                        <span style="background-color: #ff2c2c; margin-left: 1vw; padding: 1%; color: white" class="col-md-5 border-radius-lg">{{$list->jwbnAnak}}</span>
                                                    @endif
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Jawaban Yang Benar->
                                                    <span style="background-color: greenyellow; padding: 1%;" class="col-md-5 border-radius-lg">{{ $list->option_value }}</span>
                                                @endif
                                                <br><br>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
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
