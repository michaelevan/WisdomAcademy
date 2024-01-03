<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
{{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" /> --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.ortusidebar activePage="agenda"></x-navbars.ortusidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=""></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <input type="hidden" id="tglhariini" value="{{ date('Y-m-d') }}">
            <div class="row">
                <div class="col-12">
                    <div class="card my-1">
                        <div class="d-flex">
                            <div class="card m-3 p-2 col-md-6">
                                <div class="container">
                                    <div id='calendar'></div>
                                </div>
                            </div>
                            <div class="card m-3 p-3 col-md-5">
                                <div id="detail"></div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    var myurl = "<?php echo URL::to('/'); ?>";
    var arr = [];

    $(document).ready(function () {
        function showtanggal(start){
            var getKalender = new Date(start);
            let getMonth = getKalender.toLocaleString('default', {
                month: 'long',
            });
            let getDate = getKalender.getUTCDate();
            let getYear = getKalender.getUTCFullYear();
            var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            var d = new Date(start);
            var getDay = days[d.getDay()];
            $.get(myurl + '/orangTua/detailAgenda',
                {mode: start},
                function(result){
                    // alert(result);
                    var arr = JSON.parse(result);
                    let isiDetail = '';
                    if (result == '[]') {
                        isiDetail += '<h4>Detail Agenda ' + getDay + ', ' + getDate + ' ' + getMonth + ' ' + getYear + '</h4><br>';
                        isiDetail += 'tidak ada agenda';
                    }
                    else{
                        isiDetail += '<h4>Detail Agenda ' + getDay + ', ' + getDate + ' ' + getMonth + ' ' + getYear + '</h4><br>';
                        isiDetail += '<table border="5" class="table table-striped" style="text-align: center" id="example">';
                        isiDetail += '<thead>';
                        isiDetail += '<tr>';
                        isiDetail += '<th style="border: 1px solid; width: 1%">No</th>';
                        isiDetail += '<th style="border: 1px solid; width: 89%">Keterangan</th>';
                        isiDetail += '<th style="border: 1px solid; width: 10%">Aksi</th>';
                        isiDetail += '</tr>';
                        isiDetail += '</thead>';
                        isiDetail += '<tbody style="border: 1px solid">';
                        for(var i = 0; i < arr.length; i++) {
                            isiDetail += '<tr>';
                            isiDetail += '<td style="border: 1px solid">' + (i+1) + '</td>';
                            isiDetail += '<td style="border: 1px solid; text-align: left">' + arr[i].isi + '</td>';
                            if (arr[i].checklist.length != 0) {
                                isiDetail += '<td>&#10004;</td>';
                            }
                            else{
                                isiDetail += '<td></td>';
                            }
                            isiDetail += '</tr>';
                        }
                        isiDetail += '</tbody>';
                        isiDetail += '</table>';
                    }
                    $('#detail').html(isiDetail);
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
            dayRender: function (date, cell) {
                var t = $.fullCalendar.formatDate(date, "DD");
                if(t == "20") {
                    cell.css("background-color", "yellow");
                }
            },
            dateClick: function(info) {
                // alert('clicked ' + info.dateStr);
                var start = info.dateStr;
                showtanggal(start);
            },
        });

        calendar.render();
        showtanggal($('#tglhariini').val());

    });
</script>
