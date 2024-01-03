<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.anaksidebar activePage="mapel"></x-navbars.anaksidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=""></x-navbars.navs.auth>
        <a href="{{url('/orangTua/mapel/'.$id.'/materi')}}" style="margin-left: 2%"> << Kembali</a>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-1">
                        <div class="card-body p-3">
                            <div class="row" style="padding: 2%">
                                <div class="mb-3 col-md-12">
                                    <div class="d-flex">
                                        <div class="mb-3 col-md-1">
                                            <div style="border-radius: 50%; width: 50px; height: 50px; background: #bbb">
                                                <center><i class="fas fa-tasks" style="font-size: 25px; margin-top: 20%"></i></center>
                                            </div>
                                        </div>
                                        <div class="mb-0 col-md-7">
                                            <h4>{{ $materi->nama_materi }}</h4>
                                            <div class="d-flex">
                                                <div class="mb-3 col-md-3" style="margin-top: 1%">
                                                    <p>{{ date('d F Y H:i', strtotime($materi->created_at)) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div><hr>
                                    <div style="border: 1px">
                                        <p style="font-size: 20px; font-weight: bold">{{ $materi->deskripsi_materi }}</p>
                                    </div><br><br>
                                    <div class="d-flex">
                                        <p style="font-size: 22px">Attachments
                                        <i class="material-icons">attach_file</i></p>
                                    </div><br>
                                    <div class="d-flex">
                                        @foreach ($detailMateri as $detail)
                                            <div style="margin-left: 5%">
                                                <?php
                                                $arr = explode(".", $detail->nama_file);
                                                $panj= count($arr);
                                                if($arr[$panj - 1] == "doc" || $arr[$panj - 1] == "docx"){
                                                ?>
                                                    <div class="mb-3 col-md-8 gambar">
                                                        <img src="{{ asset('img/word.jpg') }}" style="width: 150px" class="image">
                                                        <p class="">{{ $detail->nama_file }}</p>
                                                    </div>
                                                <?php
                                                }
                                                elseif($arr[$panj - 1] == "ppt" || $arr[$panj - 1] == "pptx"){
                                                ?>
                                                    <div class="mb-3 col-md-8 gambar">
                                                        <img src="{{ asset('img/ppt.png') }}" style="width: 150px" class="image">
                                                        <p class="">{{ $detail->nama_file }}</p>
                                                    </div>
                                                <?php
                                                }
                                                elseif($arr[$panj - 1] == "xls" || $arr[$panj - 1] == "xlsx"){
                                                ?>
                                                    <div class="mb-3 col-md-8 gambar">
                                                        <img src="{{ asset('img/excel.png') }}" style="width: 150px" class="image">
                                                        <p class="">{{ $detail->nama_file }}</p>
                                                    </div>
                                                <?php
                                                }
                                                elseif($arr[$panj - 1] == "pdf"){
                                                ?>
                                                    <div class="mb-3 col-md-8 gambar">
                                                        <img src="{{ asset('img/pdf.png') }}" style="width: 150px" class="image">
                                                        <p class="">{{ $detail->nama_file }}</p>
                                                    </div>
                                                <?php
                                                }
                                                elseif($arr[$panj - 1] == "png" || $arr[$panj - 1] == "jpg" || $arr[$panj - 1] == "tiff"){
                                                ?>
                                                    <div class="mb-3 col-md-8 gambar">
                                                        <img src="{{ asset('img/materi/'.$detail->nama_file) }}" style="width: 150px" class="image">
                                                        <p class="">{{ $detail->nama_file }}</p>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        @endforeach
                                    </div>
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
