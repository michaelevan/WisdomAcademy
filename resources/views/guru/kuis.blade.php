<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.gurusidebar activePage="mapel"></x-navbars.gurusidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=''></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-300 border-radius-xl mt-4"
                style="background-image: url('https://images.unsplash.com/photo-1510070112810-d4e9a46d9e91?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=869&q=80');">
                <span class="mask  bg-gradient-primary  opacity-6">
                    <h1 class="text-white font-weight-bolder" style="padding: 3%">{{ $id }}</h1>
                </span>
            </div>
            <div class="card card-body mx-3 mx-md-4 mt-n6">
                <div class="row">
                    <div class="nav-wrapper position-relative end-0">
                        <ul class="nav nav-pills nav-justified">
                            <li class="nav-item">
                                <a class="nav-item nav-link" href="{{url('/guru/mapel/'.$id.'/materi')}}">
                                    <i class="material-icons text-lg position-relative">home</i>
                                    <span class="ms-1">Materi</span>
                                </a>
                            </li>
                            <li class="nav-item" style="background-color: white; box-shadow: -2px -2px 3px #ffffff, 2px 2px 3px #a0a0a0; border-radius: 8px">
                                <a class="nav-item nav-link" href="{{url('/guru/mapel/'.$id.'/kuis')}}">
                                    <i class="material-icons text-lg position-relative">email</i>
                                    <span class="ms-1">Kuis</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12"><br>
                        <div class="card-body p-3">
                            <h4>Tambah kuis Baru</h4>
                            <form method='POST'>
                                @csrf
                                <div class="row">
                                    <div class="mb-3">
                                        <label class="form-label">Judul kuis</label>
                                        <input required type="text" autocomplete="off" name="nama_kuis" maxlength="50" class="form-control border border-2 p-2">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Batas Pengumpulan Kuis</label>
                                        <input required type="datetime-local" autocomplete="off" name="batas_waktu" class="form-control border border-2 p-2">
                                    </div>
                                </div>
                                <button type="submit" name="btnTambah" style="float: right" class="btn bg-gradient-dark">Buat kuis</button>
                            </form>
                        </div>

                        <div class="card-body px-3 pb-2">
                            <h4>Daftar kuis</h4>
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
                                                Nama kuis
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Tanggal
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Status
                                            </th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <div style="display: none;">{{$i = 1}}</div>
                                        @foreach ($listKuis as $kuis)
                                            <tr>
                                                <td class="align-middle text-center text-sm col-md-1">
                                                    {{$i++}}
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    {{$kuis->nama_kuis}}
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    {{date('d F Y', strtotime($kuis->updated_at))}}
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    @if ($kuis->status == 0)
                                                        draft
                                                    @else
                                                        publish
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center text-sm col-md-4"><center>
                                                    <input type="hidden" name="idKuis" value="{{ $kuis->id_kuis }}">
                                                    @if ($kuis->status == 0)
                                                        <a rel="tooltip" class="btn btn-info btn-link"
                                                        href="{{ url('/guru/mapel/'.$id.'/kuis/'.$kuis->id_kuis) }}" data-original-title=""
                                                        title="">
                                                        <i class="material-icons">edit</i>
                                                        <div class="ripple-container"></div>
                                                        </a>
                                                        <button class="btn bg-gradient-success" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="publish({{$kuis->id_kuis}})"><i class="material-icons">publish</i></button>
                                                    @else
                                                        <a rel="tooltip" class="btn btn-warning btn-link"
                                                        href="{{ url('/guru/mapel/'.$id.'/kuis/'.$kuis->id_kuis.'/hasilKuis') }}" data-original-title=""
                                                        title="">
                                                        <i class="material-icons">bar_chart</i>
                                                        <div class="ripple-container"></div>
                                                        </a>
                                                    @endif
                                                </center></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title font-weight-normal" id="exampleModalLabel">Apakah anda ingin publish kuis?</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Tidak</button>
                                            <form method="post">
                                                <input type="hidden" name="idKuis" id="idKuis">
                                                @csrf
                                                <button type="submit" name="btnPublish" class="btn bg-gradient-primary">Ya</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <x-plugins></x-plugins> --}}
</x-layout>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
    function publish(id_kuis){
        $('#idKuis').val(id_kuis);
    }
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>
