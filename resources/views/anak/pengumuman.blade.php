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
    /* .pulse {
        animation: pulse 1s infinite ease-in-out alternate;
    }
    @keyframes pulse {
        from { transform: scale(0.8); }
        to { transform: scale(1.2); }
    } */
</style>
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.anaksidebar activePage="pengumuman"></x-navbars.anaksidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=""></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <input type="hidden" id="tglhariini" value="{{ date('Y-m-d') }}">
            <div class="row">
                <div class="col-12">
                    <div class="card-my-1">
                        <div class="card m-3 p-3">
                            <div class="container">
                                <div id='calendar'></div>
                            </div>
                        </div>
                        <div class="card m-3 p-3">
                            <div id="pengumuman"></div>
                        </div>
                    </div>
                    <div class="card my-2">
                        {{-- <div class="card-body p-3">
                            <div class="row" style="padding: 2%">
                                <div class="mb-3 col-md-12">
                                    <h4>Pengumuman</h4><br><br>
                                    @if (count($dataNotifikasi) == null)
                                        <p style="font-size: 20px">Tidak ada pengumuman</p>
                                    @else
                                        @foreach ($dataNotifikasi as $notif)
                                            <div class="kotak">
                                                <div class="d-flex">
                                                    <div class="mb-3 col-md-1">
                                                        <div style="border-radius: 50%; width: 50px; height: 50px; background: yellow">
                                                            <center><i class="material-icons" style="font-size: 25px; margin-top: 20%">assignment</i></center>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 col-md-8" style="margin-left: 2%; margin-top: 1%">
                                                        @if ($notif->status == 0)
                                                            <h4>{{ $notif->keterangan }}</h4>
                                                        @else
                                                            <p style="font-size: 22px">{{ $notif->keterangan }}</p>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3 col-md-3" style="margin-left: 6%; margin-top: 1.5%">
                                                        <p>{{ date('d F Y H:i', strtotime($notif->created_at)) }}</p>
                                                    </div>
                                                    <hr>
                                                </div>
                                                <div class="col-md-12" style="display: flex; justify-content: flex-end">
                                                    <form action="" method="post">
                                                        @csrf
                                                        <input type="hidden" name="jenis" value="{{ $notif->jenis }}">
                                                        <input type="hidden" name="id_reference" value="{{ $notif->id_reference }}">
                                                        @if ($notif->status == 0)
                                                            @if ($notif->jenis == 0)
                                                                <button type="submit" class="btn bg-gradient-info pulse">Lihat Materi</button>
                                                            @elseif ($notif->jenis == 1)
                                                                <button type="submit" class="btn bg-gradient-info pulse">Lihat Kuis</button>
                                                            @elseif ($notif->jenis == 2)
                                                                <button type="submit" class="btn bg-gradient-info pulse">Lihat Agenda Harian</button>
                                                            @endif
                                                        @else
                                                            @if ($notif->jenis == 0)
                                                                <button type="submit" class="btn bg-gradient-info">Lihat Materi</button>
                                                            @elseif ($notif->jenis == 1)
                                                                <button type="submit" class="btn bg-gradient-info">Lihat Kuis</button>
                                                            @elseif ($notif->jenis == 2)
                                                                <button type="submit" class="btn bg-gradient-info">Lihat Agenda Harian</button>
                                                            @endif
                                                        @endif
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div> --}}
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    var myurl = "<?php echo URL::to('/'); ?>";
    $(document).ready(function () {
        function showtanggal(start) {
            // alert(start);
            var getKalender = new Date(start);
            let getMonth = getKalender.toLocaleString('default', {
                month: 'long',
            });
            let getDate = getKalender.getUTCDate();
            let getYear = getKalender.getUTCFullYear();
            var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            var d = new Date(start);
            var getDay = days[d.getDay()];
            $.get(myurl + '/anak/isiPengumuman',
                {mode: start},
                function(result){
                    alert(result);
                    var arr = JSON.parse(result);
                    let getDate = getKalender.getUTCDate();
                    let getYear = getKalender.getUTCFullYear();
                    var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    var d = new Date(start);
                    var getDay = days[d.getDay()];
                    let isiDetail = '';
                    if (result == '[]') {
                        isiDetail += '<h4>Pengumuman ' + getDay + ', ' + getDate + ' ' + getMonth + ' ' + getYear + '</h4><br>';
                        isiDetail += 'tidak ada pengumuman';
                    }
                    else{
                        isiDetail += '<h4>Pengumuman ' + getDay + ', ' + getDate + ' ' + getMonth + ' ' + getYear + '</h4><br>';
                        for(var i = 0; i < arr.length; i++) {
                            isiDetail += '<div class="kotak"><div class="d-flex"><div class="mb-3 col-md-1"><div style="border-radius: 50%; width: 50px; height: 50px; background: yellow"><center><i class="material-icons" style="font-size: 25px; margin-top: 20%">assignment</i></center></div></div><div class="mb-3 col-md-8" style="margin-left: 2%; margin-top: 1%">';
                            if (arr[i].status == 0) {
                                isiDetail += '<h4>' + arr[i].keterangan + '</h4>';
                            }
                            else{
                                isiDetail += '<p style="font-size: 22px">' + arr[i].keterangan + '</p>';
                            }
                            var monthNames = [
                                "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober","November", "Desember"
                            ];
                            var dateObject = new Date(arr[i].created_at);
                            var day = dateObject.getDate();
                            var monthIndex = dateObject.getMonth();
                            var year = dateObject.getFullYear();
                            var hours = dateObject.getHours();
                            var minutes = dateObject.getMinutes();
                            isiDetail += '</div><div class="mb-3 col-md-3" style="margin-left: 6%; margin-top: 1.5%"><p>' + day + ' ' + monthNames[monthIndex] + ' ' + year + ' ' + hours + ':' + (minutes < 10 ? '0' : '') + minutes + '</p></div><hr></div><div class="col-md-12" style="display: flex; justify-content: flex-end"><form action="" method="post">@csrf<input type="hidden" name="jenis" value="' + arr[i].jenis + '"><input type="hidden" name="id_reference" value="' + arr[i].id_reference + '">';
                            if (arr[i].jenis == 0) {
                                isiDetail += '<button type="submit" class="btn bg-gradient-info">Lihat Materi</button>';
                            }
                            else if (arr[i].jenis == 1) {
                                isiDetail += '<button type="submit" class="btn bg-gradient-info">Lihat Kuis</button>';
                            }
                            else if (arr[i].jenis == 2) {
                                isiDetail += '<button type="submit" class="btn bg-gradient-info">Lihat Agenda Harian</button>';
                            }
                            isiDetail += '</form></div></div>';
                        }
                    }
                    $('#pengumuman').html(isiDetail);
                }
            );
        }

        var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
            initialView: 'dayGridMonth',
            initialDate: $("#tglhariini").val(),
            selectable: true,
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: 'today'
            },
            // eventRender: function(info) {
            //     info.el.innerHTML = "apa kabar";
            // },
            dayRender: function (info) {
                var t = info.date.getDate();
                if (t === 20) {
                    info.dayEl.style.backgroundColor = 'yellow';
                }
            },
            dateClick: function(info) {
                var start = info.dateStr;
                $("#tglKlik").val(start);
                showtanggal(start);
            },
        });

        calendar.render();
        showtanggal($('#tglhariini').val());
    });
</script>
