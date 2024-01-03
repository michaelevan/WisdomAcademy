<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.gurusidebar activePage="mapel"></x-navbars.gurusidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=""></x-navbars.navs.auth>
        <a href="{{ url('/guru/mapel/'.$id.'/kuis/'.$id_kuis) }}" style="padding: 2%"><< Kembali</a>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-1">
                        <div class="card-body p-3">
                            <div class="row" style="padding: 2%">
                                <div>
                                    @if ($listDetailKuis->jenis == 1)
                                        <form method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row" id="kotak1">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="d-flex">
                                                                <div class="mb-3 col-md-9">
                                                                    <textarea placeholder="Isi Soal Pilihan Ganda" required name="pertanyaan_1" id="" cols="95" rows="5" spellcheck="false" style="border: 1px solid black; padding: 2%">{{ $listDetailKuis->pertanyaan }}</textarea>
                                                                </div>
                                                                <div class="mb-3 col-md-2">
                                                                    @if ($arr_soal_img[0] == "")
                                                                        <input type="file" name="soal_img_1[]" accept="image/*" id="" multiple>
                                                                    @else
                                                                        <div class="row">
                                                                            @foreach ($arr_soal_img as $arr)
                                                                                <div class="col-md-2">
                                                                                    <input type="hidden" name="old_soal_pilgan" value="{{ $arr }}">
                                                                                    <img src="{{ asset('img/kuis/soal/'.$arr) }}" style="width: 100px; alt="...">
                                                                                </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                            @endforeach
                                                                        </div>
                                                                        <input type="file" name="soal_img_1[]" accept="image/*" id="" multiple>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div><br>
                                                        <div class="row">
                                                            <div class="mb-3">
                                                                <input required type="text" placeholder="a. Isi Jawaban Yang Benar Disini" name="option_value_1[]" value="{{ $arr_option_value[0] }}" class="form-control border border-2 p-2">
                                                            </div>
                                                            <div class="mb-3">
                                                                <input required type="text" placeholder="b. " name="option_value_1[]" value="{{ $arr_option_value[1] }}" class="form-control border border-2 p-2">
                                                            </div>
                                                            <div class="mb-3">
                                                                <input required type="text" placeholder="c. " name="option_value_1[]" value="{{ $arr_option_value[2] }}" class="form-control border border-2 p-2">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" name="btnPilgan" class="btn bg-gradient-dark">Edit Kuis Pilihan Ganda</button>
                                            </div>
                                        </form>
                                    @elseif ($listDetailKuis->jenis == 2)
                                        <form method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row" id="kotak2">
                                                <div class="mb-3">
                                                    <div class="d-flex">
                                                        <div class="mb-3 col-md-9">
                                                            <textarea placeholder="Isi Soal Mengurutkan" required name="pertanyaan_2" id="" cols="95" rows="5" spellcheck="false" style="border: 1px solid black; padding: 2%">{{ $listDetailKuis->pertanyaan }}</textarea>
                                                        </div>
                                                        <div class="mb-3 col-md-2">
                                                            @if ($arr_soal_img[0] == "")
                                                                <input type="file" name="soal_img_2[]" accept="image/*" id="" multiple>
                                                            @else
                                                                <div class="row">
                                                                    @foreach ($arr_soal_img as $arr)
                                                                        <div class="col-md-2">
                                                                            <img src="{{ asset('img/kuis/soal/'.$arr) }}" style="width: 100px; alt="...">
                                                                        </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    @endforeach
                                                                </div>
                                                                <input type="file" name="soal_img_2[]" accept="image/*" id="" multiple>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <input type='hidden' id='txtoption' value='{{ $option_value }}'>
                                                    <input type='hidden' id='urlgambar' value='{{ asset('img/kuis/jawaban/') }}'>
                                                    <div id="Isi"></div>
                                                    <input type="hidden" value="0" id="ctrIsi">
                                                    <button type="button" class="btn btn-icon bg-gradient-light add" style="float: right; width: 100%">
                                                        <span class="btn-inner--icon"><i class="material-icons">add</i></span>
                                                        <span class="btn-inner--text">Tambah Urutan Jawaban</span>
                                                    </button><br><br><br>
                                                </div>
                                                <button type="submit" name="btnUrut" class="btn bg-gradient-dark">Edit Kuis Mengurutkan</button>
                                            </div>
                                        </form>
                                    @elseif ($listDetailKuis->jenis == 3)
                                        <form method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row" id="kotak3">
                                                <div class="mb-3">
                                                    <div class="d-flex">
                                                        <div class="mb-3 col-md-9">
                                                            <textarea placeholder="Isi Soal Menyamakan" required name="pertanyaan_3" id="" cols="95" rows="5"  spellcheck="false" style="border: 1px solid black; padding: 2%">{{ $listDetailKuis->pertanyaan }}</textarea>
                                                        </div>
                                                        <div class="mb-3 col-md-2">
                                                            @if ($arr_soal_img[0] == "")
                                                                <input type="file" name="soal_img_3[]" accept="image/*" id="" multiple>
                                                            @else
                                                                <div class="row">
                                                                    @foreach ($arr_soal_img as $arr)
                                                                        <div class="col-md-2">
                                                                            <img src="{{ asset('img/kuis/soal/'.$arr) }}" style="width: 100px; alt="...">
                                                                        </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    @endforeach
                                                                </div>
                                                                <input type="file" name="soal_img_3[]" accept="image/*" id="" multiple>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <input required type="text" placeholder="Isi Jawaban" name="option_value_3" id="" value="{{ $listDetailKuis->option_value }}" class="form-control border border-2 p-2"><br>
                                                </div>
                                                <button type="submit" name="btnSama" class="btn bg-gradient-dark">Edit Kuis Menyamakan</button>
                                            </div>
                                        </form>
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
    var arr = [];
    function showlist() {
        $('#Isi').css('display', 'block');
        var ctrIsi = parseInt($('#ctrIsi').val()) + 1;
        console.log(ctrIsi);
        let ctr = $('#ctrIsi').val(ctrIsi);
        console.log(ctr);
        var kal = "";
        var urlgambar = $("#urlgambar").val();
        for(var i = 0; i < arr.length; i++) {
            let isi = '<div class="d-flex"><div class="mb-3 col-md-11"><input type="text" placeholder="Isi Urutan Jawaban ke ' + (i+1) + '" name="option_value_2[]" id="option_value' + i + '" value="' + arr[i] + '" class="form-control border border-2 p-2"></div><button type="button" style="margin-left: 1%" class="btn bg-gradient-danger" onclick=hapus("' + i + '")>x</button></div><br>';
            kal = kal + isi;
        }
        $('#Isi').html(kal);
    }

    function getalldata() {
        for(var i = 0; i < arr.length; i++) {
            arr[i] = $("#option_value" + i).val();
        }
    }

    function add() {
        getalldata();
        arr.push("");
        gbr.push("");
        showlist();
    }

    function initlist() {
        var option = JSON.parse($("#txtoption").val());
        var gambar = JSON.parse($("#txtgambar").val());
        for(var i = 0; i < option.length; i++) {
            arr.push(option[i]);
            gbr.push(gambar[i]);
        }

        showlist();
    }

    function hapus(idx) {
        getalldata();
        arr.splice(idx, 1);
        showlist();
    }
    $(document).ready(function () {
        $('.add').on('click', add);
        $('#example').DataTable();

        initlist();
    });
</script>
