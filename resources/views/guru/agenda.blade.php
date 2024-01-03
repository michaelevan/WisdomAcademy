<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.gurusidebar activePage="agenda"></x-navbars.gurusidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=""></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <input type="hidden" id="tglhariini" value="{{ date('Y-m-d') }}">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex">
                        <div class="card my-1 col-md-8">
                            <div class="card-body p-3">
                                <div class="container">
                                    <div id='calendar'></div>
                                </div>
                            </div>
                        </div>
                        <div class="ml-1 col-md-3" style="margin-left: 5%">
                            <div class="card p-3">
                                <h4>Tambah Agenda</h4>
                                <form method='POST'>
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3">
                                            <label class="form-label">Tanggal</label>
                                            <input required type="date" name="tanggal" id="tanggal" class="form-control border border-2 p-2">
                                        </div>
                                        <div id="Isi"></div>
                                    </div>
                                    <button type="button" class="btn btn-icon bg-gradient-light add" style="float: right; width: 100%">
                                        <span class="btn-inner--icon"><i class="material-icons">add</i></span>
                                        <span class="btn-inner--text">Tambah Isi Agenda</span>
                                    </button><br><br><br>
                                    <input type="hidden" value="0" id="ctrIsi">
                                    <button type="submit" class="btn bg-gradient-dark form-control">Buat Agenda</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card my-2 col-md-8">
                        <div class="card-body p-3">
                            {{-- <h4>Detail Agenda</h4> --}}
                            <div id="detail"></div>
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
    var arr = [];
    function showlist() {
        $('#Isi').css('display', 'block');
        var ctrIsi = parseInt($('#ctrIsi').val()) + 1;
        console.log(ctrIsi);
        let ctr = $('#ctrIsi').val(ctrIsi);
        console.log(ctr);
        var kal = "";
        for(var i = 0; i < arr.length; i++) {
            let isi = '<div class="mb-3"><label class="form-label">Isi Agenda</label><button type="button" class="btn bg-gradient-danger" onclick=hapus("' + i + '") style="float: right">x</button><input required type="text" name="keterangan[]" id="keterangan' + i + '" value="' + arr[i] + '" maxlength="255" class="form-control border border-2 p-2"></div>';
            kal = kal + isi;
        }
        $('#Isi').html(kal);
    }

    function getalldata() {
        for(var i = 0; i < arr.length; i++) {
            arr[i] = $("#keterangan" + i).val();
        }
    }

    function hapus(idx) {
        getalldata();
        arr.splice(idx, 1);
        showlist();
    }

    $(document).ready(function () {
        $('.add').on('click', add);

        function add() {
            getalldata();
            arr.push("");
            showlist();
        }

        var myurl = "<?php echo URL::to('/'); ?>";

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
                $('#tanggal').val(start);
                var getKalender = new Date(start);
                let getMonth = getKalender.toLocaleString('default', {
                    month: 'long',
                });
                let getDate = getKalender.getUTCDate();
                let getYear = getKalender.getUTCFullYear();
                var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                var d = new Date(start);
                var getDay = days[d.getDay()];
                $.get(myurl + '/guru/detailAgenda',
                    {mode: start},
                    function(result){
                        var arrRes = JSON.parse(result);
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
                            isiDetail += '<th style="border: 1px solid; width: 99%">Keterangan</th>';
                            isiDetail += '</tr>';
                            isiDetail += '</thead>';
                            isiDetail += '<tbody style="border: 1px solid">';
                            for(var i = 0; i < arrRes.length; i++) {
                                isiDetail +='<tr>';
                                isiDetail +='<td style="border: 1px solid">' + (i+1) + '</td>';
                                isiDetail +='<td style="border: 1px solid; text-align: left">' + arrRes[i].isi + '</td>';
                                isiDetail +='</tr>';
                            }
                            isiDetail += '</tbody>';
                            isiDetail += '</table>';
                        }
                        $('#detail').html(isiDetail);
                    }
                );
            },
        });

        calendar.render();
    });
</script>
