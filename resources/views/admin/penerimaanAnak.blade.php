<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.adminsidebar activePage="listPendaftaran"></x-navbars.adminsidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=""></x-navbars.navs.auth>
        <!-- End Navbar -->
        <a href="{{url('/admin/listPendaftaran')}}" style="margin-left: 2%"> << Kembali</a>
        <div class="card card-body mx-3 mx-md-4 mt-4">
            <div class="card-body p-3">
                <h4>Nama Anak : {{ $username }}</h4>
                <form method='POST'>
                    @csrf
                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label">NIS</label>
                            <input type="text" maxlength="10" name="nis" class="form-control border border-2 p-2">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kelas</label>
                            <select class="form-select border border-2 p-2" aria-label="Default select example" name="kelas" id="">
                                <option selected="true" disabled="disabled" style="text-align: center">--Pilih Kelas--</option>
                                @foreach ($listKelas as $kelas)
                                    <option value="{{ $kelas->id_kelas }}">{{ $kelas->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" style="float: right" class="btn bg-gradient-dark">Terima Anak</button>
                </form>
            </div>
        </div>
    </main>
    {{-- <x-plugins></x-plugins> --}}
</x-layout>
