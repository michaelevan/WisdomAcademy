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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.gurusidebar activePage="mapel"></x-navbars.gurusidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=""></x-navbars.navs.auth>
        <a href="{{ url('/guru/mapel/'.$id.'/materi') }}" style="padding: 2%"><< Kembali</a>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-1">
                        <div class="card-body p-3">
                            @if ($detailMateri->status == 0)
                                <form method='POST' enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3">
                                            <label class="form-label">Judul Materi</label>
                                            <input required type="text" value="{{ $detailMateri->nama_materi }}" name="nama_materi" maxlength="50" class="form-control border border-2 p-2">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Deskripsi Materi</label>
                                            <textarea required class="form-control" name="deskripsi_materi" id="" cols="30" rows="10" style="border: 1px solid #dee2e6; padding: 1%">{{ $detailMateri->deskripsi_materi }}</textarea>
                                        </div>
                                        <div class="d-flex">
                                            @foreach ($gambarMateri as $gambar)
                                            <a href="" download="{{ $gambar->nama_file }}">
                                                <?php
                                                $arr = explode(".", $gambar->nama_file);
                                                $panj= count($arr);
                                                if($arr[$panj - 1] == "doc" || $arr[$panj - 1] == "docx"){
                                                ?>
                                                    <div class="mb-3 col-md-8 gambar">
                                                        <div class="isi"><i class="material-icons ikon">download</i></div>
                                                        <img src="{{ asset('img/word.jpg') }}" style="width: 150px" class="image">
                                                        <p class="">{{ $gambar->nama_file }}</p>
                                                    </div>
                                                <?php
                                                }
                                                elseif($arr[$panj - 1] == "ppt" || $arr[$panj - 1] == "pptx"){
                                                ?>
                                                    <div class="mb-3 col-md-8 gambar">
                                                        <div class="isi"><i class="material-icons ikon">download</i></div>
                                                        <img src="{{ asset('img/ppt.png') }}" style="width: 150px" class="image">
                                                        <p class="">{{ $gambar->nama_file }}</p>
                                                    </div>
                                                <?php
                                                }
                                                elseif($arr[$panj - 1] == "xls" || $arr[$panj - 1] == "xlsx"){
                                                ?>
                                                    <div class="mb-3 col-md-8 gambar">
                                                        <div class="isi"><i class="material-icons ikon">download</i></div>
                                                        <img src="{{ asset('img/excel.png') }}" style="width: 150px" class="image">
                                                        <p class="">{{ $gambar->nama_file }}</p>
                                                    </div>
                                                <?php
                                                }
                                                elseif($arr[$panj - 1] == "pdf"){
                                                ?>
                                                    <div class="mb-3 col-md-8 gambar">
                                                        <div class="isi"><i class="material-icons ikon">download</i></div>
                                                        <img src="{{ asset('img/pdf.png') }}" style="width: 150px" class="image">
                                                        <p class="">{{ $gambar->nama_file }}</p>
                                                    </div>
                                                <?php
                                                }
                                                elseif($arr[$panj - 1] == "png" || $arr[$panj - 1] == "jpg" || $arr[$panj - 1] == "tiff"){
                                                ?>
                                                    <div class="mb-3 col-md-8 gambar">
                                                        <div class="isi"><i class="material-icons ikon">download</i></div>
                                                        <img src="{{ asset('img/materi/'.$gambar->nama_file) }}" style="width: 150px" class="image">
                                                        <p class="">{{ $gambar->nama_file }}</p>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </a>
                                            @endforeach
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">File Materi</label>
                                            <input type="file" name="nama_file[]" class="form-control border dropzone" id="dropzone" multiple>
                                        </div>
                                    </div>
                                    <div style="float: right">
                                        <button type="submit" class="btn bg-gradient-dark">Ubah Data</button>
                                    </div>
                                </form>
                            @else
                                <div class="row">
                                    <div class="mb-3">
                                        <label class="form-label">Judul Materi</label>
                                        <input disabled type="text" value="{{ $detailMateri->nama_materi }}" name="nama_materi" maxlength="50" class="form-control border border-2 p-2">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Deskripsi Materi</label>
                                        <textarea disabled class="form-control" name="deskripsi_materi" id="" cols="30" rows="10" style="border: 1px solid #dee2e6; padding: 1%">{{ $detailMateri->deskripsi_materi }}</textarea>
                                    </div>
                                    <div class="d-flex">
                                        @foreach ($gambarMateri as $gambar)
                                        <a href="" download="{{ $gambar->nama_file }}">
                                            <?php
                                            $arr = explode(".", $gambar->nama_file);
                                            $panj= count($arr);
                                            if($arr[$panj - 1] == "doc" || $arr[$panj - 1] == "docx"){
                                            ?>
                                                <div class="mb-3 col-md-8 gambar">
                                                    <div class="isi"><i class="material-icons ikon">download</i></div>
                                                    <img src="{{ asset('img/word.jpg') }}" style="width: 150px" class="image">
                                                    <p class="">{{ $gambar->nama_file }}</p>
                                                </div>
                                            <?php
                                            }
                                            elseif($arr[$panj - 1] == "ppt" || $arr[$panj - 1] == "pptx"){
                                            ?>
                                                <div class="mb-3 col-md-8 gambar">
                                                    <div class="isi"><i class="material-icons ikon">download</i></div>
                                                    <img src="{{ asset('img/ppt.png') }}" style="width: 150px" class="image">
                                                    <p class="">{{ $gambar->nama_file }}</p>
                                                </div>
                                            <?php
                                            }
                                            elseif($arr[$panj - 1] == "xls" || $arr[$panj - 1] == "xlsx"){
                                            ?>
                                                <div class="mb-3 col-md-8 gambar">
                                                    <div class="isi"><i class="material-icons ikon">download</i></div>
                                                    <img src="{{ asset('img/excel.png') }}" style="width: 150px" class="image">
                                                    <p class="">{{ $gambar->nama_file }}</p>
                                                </div>
                                            <?php
                                            }
                                            elseif($arr[$panj - 1] == "pdf"){
                                            ?>
                                                <div class="mb-3 col-md-8 gambar">
                                                    <div class="isi"><i class="material-icons ikon">download</i></div>
                                                    <img src="{{ asset('img/pdf.png') }}" style="width: 150px" class="image">
                                                    <p class="">{{ $gambar->nama_file }}</p>
                                                </div>
                                            <?php
                                            }
                                            elseif($arr[$panj - 1] == "png" || $arr[$panj - 1] == "jpg" || $arr[$panj - 1] == "tiff"){
                                            ?>
                                                <div class="mb-3 col-md-8 gambar">
                                                    <img src="{{ asset('img/materi/'.$gambar->nama_file) }}" style="width: 150px" class="image">
                                                    <p class="">{{ $gambar->nama_file }}</p>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </a>
                                        @endforeach
                                    </div>
                                </div>
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
