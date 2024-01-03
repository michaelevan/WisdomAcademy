<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.gurusidebar activePage="mapel"></x-navbars.gurusidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=""></x-navbars.navs.auth>
        <a href="{{ url('/guru/mapel/'.$id.'/kuis') }}" style="padding: 2%"><< Kembali</a>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-1">
                        <div class="card-body p-3">
                            <div class="row" style="padding: 2%">
                                <div class="d-flex">
                                    <div class="mb-3 col-md-8" style="margin-top: 2%">
                                        <h4>Buat Soal Kuis {{ $listKuis->nama_kuis }}</h4>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label">Batas Pengumpulan Kuis</label>
                                        <input required type="datetime-local" autocomplete="off" id="batas_waktu" class="form-control border border-2 p-2" value="{{ $listKuis->batas_waktu }}" onchange="ubahBatasWaktu()">
                                        <input type="hidden" id="id_kuis" value="{{ $id_kuis }}">
                                    </div>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="jenis" id="jenis1" checked>&nbsp;
                                    <label class="custom-control-label" for="jenis1">Pilihan Ganda</label>
                                    <input class="form-check-input" type="radio" name="jenis" id="jenis2">
                                    <label class="custom-control-label" for="jenis2">Mengurutkan</label>
                                    <input class="form-check-input" type="radio" name="jenis" id="jenis3">
                                    <label class="custom-control-label" for="jenis3">Menyamakan</label>
                                </div>
                                <div>
                                    <form method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row" id="kotak1">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="mb-3 col-md-9">
                                                        <textarea required name="pertanyaan_1" id="" cols="95" rows="5" placeholder="Isi Soal Pilihan Ganda" spellcheck="false" style="border: 1px solid black; padding: 2%; width: 100%"></textarea>
                                                    </div>
                                                    <div class="mb-3 col-md-3">
                                                        <input type="file" name="soal_img_1[]" accept="image/*" id="" multiple>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="mb-3">
                                                        <input required type="text" name="option_value_1[]" placeholder="a. Isi Jawaban Yang Benar Disini" class="form-control border border-2 p-2">
                                                    </div>
                                                    <div class="mb-3">
                                                        <input required type="text" name="option_value_1[]" placeholder="b. " class="form-control border border-2 p-2">
                                                    </div>
                                                    <div class="mb-3">
                                                        <input required type="text" name="option_value_1[]" placeholder="c. " class="form-control border border-2 p-2">
                                                    </div>
                                                </div>
                                           </div>
                                           <button type="submit" name="btnPilgan" class="btn bg-gradient-dark">Buat Kuis Pilihan Ganda</button>
                                        </div>
                                    </form>
                                    <form method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row" id="kotak2">
                                            <div class="mb-3">
                                                <div class="d-flex">
                                                    <div class="mb-3 col-md-9">
                                                        <textarea required name="pertanyaan_2" id="" cols="95" rows="5" placeholder="Isi Soal Mengurutkan" spellcheck="false" style="border: 1px solid black; padding: 2%; width: 100%"></textarea>
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <input type="file" name="soal_img_2[]" accept="image/*" id="" multiple>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div id="Isi"></div>
                                                <input type="hidden" value="0" id="ctrIsi">
                                                <button type="button" class="btn btn-icon bg-gradient-light add" style="float: right; width: 100%">
                                                    <span class="btn-inner--icon"><i class="material-icons">add</i></span>
                                                    <span class="btn-inner--text">Tambah Urutan Jawaban</span>
                                                </button><br><br><br>
                                            </div>
                                            <button type="submit" name="btnUrut" class="btn bg-gradient-dark">Buat Kuis Mengurutkan</button>
                                        </div>
                                    </form>
                                    <form method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row" id="kotak3">
                                            <div class="mb-3">
                                                <div class="d-flex">
                                                    <div class="mb-3 col-md-9">
                                                        <textarea required name="pertanyaan_3" id="" cols="95" rows="5" placeholder="Isi Soal Menyamakan" spellcheck="false" style="border: 1px solid black; padding: 2%; width: 100%"></textarea>
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <input type="file" name="soal_img_3[]" accept="image/*" id="" multiple>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <input required type="text" name="option_value_3" id="" placeholder="Isi Jawaban Disini" class="form-control border border-2 p-2"><br>
                                            </div>
                                            <button type="submit" name="btnSama" class="btn bg-gradient-dark">Buat Kuis Menyamakan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body px-3 pb-2">
                            <h4>List Soal Kuis {{ $listKuis->nama_kuis }}</h4>
                            <div class="table-responsive p-0">
                                <table class="table table-striped align-items-center mb-0" id="example">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                No
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Group Key
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Tipe Soal
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($listDetailKuis as $detailKuis)
                                            <tr>
                                                <td class="align-middle text-center text-sm">
                                                    {{$detailKuis->nomor_kuis}}
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    @if ($detailKuis->jenis == 1)
                                                        &nbsp;
                                                    @elseif ($detailKuis->jenis == 3)
                                                        <select onChange='ubahcombo({{$detailKuis->id_detail_kuis}})' class='btn-success' id='GroupKey{{$detailKuis->id_detail_kuis}}'>
                                                            @for ($i = 1; $i < 10; $i++)
                                                                @if($detailKuis->groupkey == $i)
                                                                    <option value='{{ $i }}' selected>{{ $i }}</option>
                                                                @else
                                                                    <option value='{{ $i }}'>{{ $i }}</option>
                                                                @endif
                                                            @endfor
                                                        </select>
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    @if ($detailKuis->jenis == 1)
                                                        Pilihan Ganda
                                                    @elseif ($detailKuis->jenis == 2)
                                                        Mengurutkan
                                                    @elseif ($detailKuis->jenis == 3)
                                                        Menyamakan
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    <center><form method="post">
                                                        @csrf
                                                        <a rel="tooltip" class="btn btn-success btn-link"
                                                            href="{{ url('/guru/mapel/'.$id.'/kuis/'.$id_kuis.'/editDetailKuis/'.$detailKuis->id_detail_kuis) }}" data-original-title=""
                                                            title="">
                                                            <i class="material-icons">edit</i>
                                                            <div class="ripple-container"></div>
                                                        </a>
                                                        <a href="{{ url('/guru/mapel/'.$id.'/kuis/'.$id_kuis.'/deleteDetailKuis/'.$detailKuis->id_detail_kuis."") }}" class="btn btn-danger btn-link"
                                                            data-original-title="" title="">
                                                            <i class="material-icons">close</i>
                                                            <div class="ripple-container"></div>
                                                        </a>
                                                    </form></center>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
    var myurl = "<?php echo URL::to('/'); ?>";
    var arr = [];

    function ubahBatasWaktu() {
        var id_kuis = $("#id_kuis").val();
        var batas_waktu = $("#batas_waktu").val();
        $.get(myurl + `/guru/ubahBatasWaktu`,
            {id_kuis: id_kuis, batas_waktu: batas_waktu},
            function(result){
                alert(result);
            }
        );
    }

    function ubahcombo(idx) {
        var value = $("#GroupKey" + idx).val();
        $.get(myurl + '/guru/ubahgroupkey',
            {idx: idx, value: value},
            function(result){
            }
        );
    }

    function showlist() {
        $('#Isi').css('display', 'block');
        var ctrIsi = parseInt($('#ctrIsi').val()) + 1;
        console.log(ctrIsi);
        let ctr = $('#ctrIsi').val(ctrIsi);
        console.log(ctr);
        var kal = "";
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
    });
</script>
