<style type='text/css'>
    .opsiJawab{
        margin: 0;
        padding: 2%;
        transition: 0.3s;
    }
    .opsiJawab:hover {
        background: lightgrey;
        border-radius: 0.375rem;
        cursor: pointer;
    }
</style>

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-1">
                        <div class="card-body p-3">
                            <div class="row" style="padding: 2%">
                                <div class="form-check">
                                    Pilih Tipe Soal : &nbsp;&nbsp;
                                    <input class="form-check-input" type="radio" name="jenis" id="jenis1" checked>
                                    <label class="custom-control-label" for="jenis1">Pilihan Ganda</label>&nbsp;&nbsp;&nbsp;
                                    <input class="form-check-input" type="radio" name="jenis" id="jenis2">
                                    <label class="custom-control-label" for="jenis2">Mengurutkan</label>&nbsp;&nbsp;&nbsp;
                                    <input class="form-check-input" type="radio" name="jenis" id="jenis3">
                                    <label class="custom-control-label" for="jenis3">Menyamakan</label>
                                </div>
                                <div><br><br>
                                    <form method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type='hidden' name='urutanSoal' id='urutanSoal' value='{{ $urutanSoal }}' style='width: 100%;'>
                                        <input type='hidden' name='urutanJawaban' id='urutanJawaban' value='{{ $urutanJawaban }}' style='width: 100%;'>
                                        <input type='hidden' name='urutanJenis' id='urutanJenis' value='{{ $urutanJenis }}' style='width: 100%;'>
                                        <!-- PILGAN -->
                                        <div class="row" id="kotak1">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="d-flex">
                                                            <div class="mb-3 col-md-12">
                                                                @foreach ($detailKuis as $kuis)
                                                                    @if ($kuis->jenis == 1)
                                                                        <p style="margin-top: 2%; font-weight: bold; font-size: 20px;">{{ $kuis->pertanyaan }}
                                                                        </p>
                                                                        @for ($i = 0; $i < count(json_decode($kuis->soal_img)); $i++)
                                                                            @if (json_decode($kuis->soal_img)[$i] != "")
                                                                                <img src="{{ asset('img/kuis/soal/'.json_decode($kuis->soal_img)[$i]) }}" width="100px" alt="">
                                                                            @endif
                                                                        @endfor
                                                                        <hr><br>
                                                                        @for ($i = 0; $i < count(json_decode($kuis->option_value)); $i++)
                                                                            <p class="opsiJawab" id="opsiJawab">{{ chr(65+$i) }}.&nbsp;&nbsp;&nbsp;&nbsp;<label><input type='radio' value='{{$i + 1}}**{{json_decode($kuis->option_value)[$i]}}' name='jawabanKamu{{ $kuis->id_detail_kuis }}'>&nbsp; {{ json_decode($kuis->option_value)[$i] }}</label></p>
                                                                        @endfor<br><br><br>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div><br>
                                                </div>
                                           </div>
                                        </div>
                                        <!-- MENGURUTKAN -->
                                        <div class="row" id="kotak2">
                                            <div class="mb-3">
                                                <div class="d-flex">
                                                    <div class="mb-3 col-md-12">
                                                        {{-- <div style="float: right">
                                                            <textarea disabled cols="50" rows="3" style="border: 1px solid black; padding: 1%; background-color: lightblue">Cara menjawab untuk soal mengurutkan adalah tekan dan tarik baris yang ingin dipilih lalu letakkan pada baris yang diinginkan untuk mengurutkannya</textarea>
                                                        </div>
                                                       <br><br><br> --}}
                                                        @php $jummengurutkan = 0; @endphp
                                                        @foreach ($detailKuis as $kuis)
                                                            @if ($kuis->jenis == 2)
                                                            <p style="margin-top: 2%; font-weight: bold; font-size: 20px;">{{ $kuis->pertanyaan }}</p>
                                                                @for ($i = 0; $i < count(json_decode($kuis->soal_img)); $i++)
                                                                    @if (json_decode($kuis->soal_img)[$i] != "")
                                                                        <img src="{{ asset('img/kuis/soal/'.json_decode($kuis->soal_img)[$i]) }}" width="100px" alt="">
                                                                    @endif
                                                                @endfor
                                                                <hr><br>
                                                                <input type='hidden' name='jwbUrut{{ $jummengurutkan }}' id='jwbUrut{{ $jummengurutkan }}'>
                                                                <input type='hidden' name='jwbUrutanArray{{ $jummengurutkan }}' id='jwbUrutanArray{{ $jummengurutkan }}' value='{{ $kuis->option_value }}'>
                                                                <ul id="sortable{{ $jummengurutkan }}">
                                                                @for ($i = 0; $i < count(json_decode($kuis->option_value)); $i++)
                                                                    <li id="{{ $i }}" class="ui-state-default">
                                                                        <p class="opsiJawab" id="opsiJawab">{{ json_decode($kuis->option_value)[$i] }}</p>
                                                                    </li>
                                                                @endfor
                                                                </ul>
                                                                @php $jummengurutkan+=1; @endphp
                                                            @endif
                                                        @endforeach
                                                        <input type='hidden' name='txtjumpengurutan' id='txtjumpengurutan' value='{{ $jummengurutkan }}'>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- MENYAMAKAN -->
                                        <div class="row" id="kotak3">
                                            <div class="mb-3">
                                                <div class="mb-3 col-md-12">
                                                    @php $jummenyamakan = 0; @endphp
                                                    @foreach ($detailKuis as $kuis)
                                                        @if ($kuis->jenis == 3)
                                                            <div class="d-flex">
                                                                <div class="mb-3 col-md-7">
                                                                    {{-- abc --}}
                                                                    <p style="margin-top: 2%; font-weight: bold; font-size: 20px;">{{ $kuis->pertanyaan }}</p>
                                                                    <input type='hidden' name='jwb{{ $jummenyamakan }}' id='jwb{{ $jummenyamakan }}'>
                                                                    <div id="droppable{{ $jummenyamakan }}" class="ui-widget-header" style="background-color: #F5F4D3; height: 50px; width: 90%; box-sizing: border-box; padding-top: 10px; padding-left: 10px; border: 2px solid black;">
                                                                      <p style="font-size: 14px;">tarik jawaban kesini</p>
                                                                    </div>
                                                                        @for ($i = 0; $i < count(json_decode($kuis->soal_img)); $i++)
                                                                            @if (json_decode($kuis->soal_img)[$i] != "")
                                                                                <img src="{{ asset('img/kuis/soal/'.json_decode($kuis->soal_img)[$i]) }}" width="100px" alt="">
                                                                            @endif
                                                                        @endfor
                                                                        <br>
                                                                </div>
                                                                <div class="mb-3 col-md-5">
                                                                    <div class="ui-widget-header" style="background-color: #FAAD24; height: 50px; width: 50%; box-sizing: border-box; text-align: center; float: right;">
                                                                        <div id="divopsi{{ $jummenyamakan }}" class="ui-widget-header" style="background-color: #D4F024; height: 50px; width: 100%; box-sizing: border-box; padding-top: 5px; padding-left: 10px; text-align: center; float: right;" ondblclick="resetPosition({{ $jummenyamakan }})">
                                                                            <input type='hidden' value="{{ $kuis->option_value }}">
                                                                            <p class="opsiJawab" id="opsiJawab" style="font-weight: bold;">{{ $kuis->option_value }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @php $jummenyamakan+=1; @endphp
                                                        @endif
                                                    @endforeach
                                                    <input type='hidden' name='txtjummenyamakan' id='txtjummenyamakan' value='{{ $jummenyamakan }}'>
                                                </div>
                                            </div>
                                        </div>
                                        <input type='submit' style="float: right" class='btn bg-gradient-success' value='Submit Jawaban' onclick='beforeSend()'>
                                    </form>
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
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>

    // abc
    function resetInput(kt) {
        var jummenyamakan = $("#txtjummenyamakan").val();
        for(var i = 0; i < jummenyamakan; i++) {
            // var isi = $("#droppable" + i).html();
            var isi = $("#jwb" + i).val();
            if(isi == kt) {
                $("#droppable" + i).find("p").html("tarik jawaban kesini");
                $("#jwb" + i).val("");
            }
        }
    }

    function resetPosition(idx) {
        $("#divopsi" + idx).animate({
            top: "0px",
            left: "0px"
        });

        var reseted = $("#divopsi" + idx).find("input").val();
        resetInput(reseted);
    };


    $(document).ready(function () {
        $('#example').DataTable();

        $('#kotak2').css('display', 'none');
        $('#kotak3').css('display', 'none');

        $('#jenis1').on('click', multiple);
        $('#jenis2').on('click', mengurutkan);
        $('#jenis3').on('click', menyamakan);

        function multiple() {
            $('#kotak1').css('display', 'block');
            $('#kotak2').css('display', 'none');
            $('#kotak3').css('display', 'none');
        }
        function mengurutkan() {
            $('#kotak1').css('display', 'none');
            $('#kotak2').css('display', 'block');
            $('#kotak3').css('display', 'none');
        }
        function menyamakan() {
            $('#kotak1').css('display', 'none');
            $('#kotak2').css('display', 'none');
            $('#kotak3').css('display', 'block');
        }

        var jummengurutkan = $("#txtjumpengurutan").val();
        for(var i = 0; i < jummengurutkan; i++) {
            $("#sortable" + i).sortable({
                change: function(event, ui) {
                    var idsInOrder = $("#sortable" + i).sortable("toArray");
                    console.log(idsInOrder.data);
                }
            });
        }

        var jummenyamakan = $("#txtjummenyamakan").val();
        for(var i = 0; i < jummenyamakan; i++) {
            $("#divopsi" + i).draggable();
            $("#droppable" + i).droppable({
                drop: function(event, ui) {
                    var obj = ui.draggable;
                    var teks = $(obj).find("input").val();

                    resetInput(teks);

                    $(this).addClass("ui-state-highlight").find("p").html(teks);
                    var namadrag = obj.attr("id");
                    var namaobj = $(this).attr("id");
                    var index = namaobj.substr(9);
                    // alert(namadrag + "-" + namaobj + "-" + index);

                    $("#jwb" + index).val(teks);
                }
            });
        }
    });

    function beforeSend() {
        var jummengurutkan = $("#txtjumpengurutan").val();
        for(var i = 0; i < jummengurutkan; i++) {
            var idsInOrder = $("#sortable" + i).sortable("toArray");
            $("#jwbUrut" + i).val(idsInOrder);
        }
    }

    function getorder() {
        var jummengurutkan = $("#txtjumpengurutan").val();
        for(var i = 0; i < jummengurutkan; i++) {
            var idsInOrder = $("#sortable" + i).sortable("toArray");
            alert(idsInOrder);
        }
    }
</script>
