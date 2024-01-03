<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<style type='text/css'>
    #kotak{
        margin: 0;
        padding: 2%;
        transition: 0.3s;
        margin-bottom: 5%
    }
    #kotak:hover {
        cursor: pointer;
        background: lightgrey;
        border-radius: 0.375rem;
    }
</style>
<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.gurusidebar activePage="chat"></x-navbars.gurusidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=""></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="card card-body mx-3 mx-md-4 mt-4" style="overflow-y: hidden">
            <input type="hidden" id="userLogin" value="{{ session()->get('login')->username }}">
            <div class="card-body p-3">
                <div class="row">
                    <div class="mb-3 col-md-3 card p-3" style="height: 520px; overflow-y: scroll;">
                        @foreach($listOrtu as $ortu)
                            <div id="kotak{{$ortu->nis}}" onclick=getchatting("{{ $ortu->nis }}")>
                                <img src="{{ asset('img/anak/'.$ortu->foto) }}"
                                class="avatar avatar-sm border-radius-lg" alt="user1">&nbsp;&nbsp;
                                {{ $ortu->nama }}<hr>
                                nama orangtua: {{ $ortu->namaortu }}
                            </div>
                        @endforeach
                    </div>
                    <div class="mb-3 col-md-8 card p-3 m-3">
                        <div id='isichat' style="height: 400px; overflow-y: scroll; background-color: #F5F5DC"></div><hr>
                        <div class="row" style="display: flex; flex-direction: row; justify-content: flex-end">
                            <div class="col-md-10">
                                <input required type="text" name="teks" id="teks" class="form-control border p-2 p-2">
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn bg-gradient-dark" onclick="sendchatting()">
                                    <i class="material-icons">send</i>
                                </button>
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
<script language='javascript'>
var myurl = "<?php echo URL::to('/'); ?>";
var picknis = "";

function getchatting(nis) {
    if (picknis != "") {
        $('#kotak'+picknis).css('background-color', '');
    }
    picknis = nis;
    $('#kotak'+picknis).css('background-color', 'lightgrey');
    userLogin = $('#userLogin').val();
    $.get(myurl + `/guru/getchatting/${nis}`,
        {},
        function(result){
            // alert(result);
            var arr = JSON.parse(result);
            let isiDetail = '';
            for(var i = 0; i < arr.length; i++) {
                const date = new Date(arr[i].tanggal);
                isiDetail +='<br>';
                if (arr[i].username1 == userLogin) {
                    isiDetail +='<div style="display: flex; justify-content: flex-end; margin-right: 3%">';
                    isiDetail +='<div style="padding: 10px; width: 65%; background: #DFF2A7;" class="border-radius-lg">';
                    isiDetail += arr[i].teks;
                    if (date.getMinutes() < 10) {
                        isiDetail += '<div style="float: right; font-size: 10px;">' + date.getDate() + '/' + date.getMonth() + '/' + date.getFullYear() + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + date.getHours() + ':0' + date.getMinutes() + '</div>'
                    }
                    else{
                        isiDetail += '<div style="float: right; font-size: 10px;">' + date.getDate() + '/' + date.getMonth() + '/' + date.getFullYear() + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + date.getHours() + ':' + date.getMinutes() + '</div>'
                    }
                    isiDetail +='</div>';
                    isiDetail +='</div>';
                }
                else{
                    isiDetail +='<div style="display: flex; margin-left: 3%">';
                    isiDetail +='<div style="padding: 10px; width: 65%; background: #EAEAEA;" class="border-radius-lg">';
                    isiDetail += arr[i].teks;
                    if (date.getMinutes() < 10) {
                        isiDetail += '<div style="float: right; font-size: 10px;">' + date.getDate() + '/' + date.getMonth() + '/' + date.getFullYear() + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + date.getHours() + ':0' + date.getMinutes() + '</div>'
                    }
                    else{
                        isiDetail += '<div style="float: right; font-size: 10px;">' + date.getDate() + '/' + date.getMonth() + '/' + date.getFullYear() + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + date.getHours() + ':' + date.getMinutes() + '</div>'
                    }
                    isiDetail +='</div>';
                    isiDetail +='</div>';
                }
            }
            isiDetail += '</tbody>';
            isiDetail += '</table>';
            $('#isichat').html(isiDetail);
            // $('#kotak').css('background-color', 'lightgrey');
            $("#isichat").scrollTop($("#isichat")[0].scrollHeight);
        }
    );
}

function sendchatting() {
    if(picknis == "") { alert('pilih dulu orang yang diajak chatting'); }
    else {
        var teks = $("#teks").val();
        $.get(myurl + `/guru/sendchatting/${picknis}`,
            { teks: teks },
            function(result){
                // alert(result);
                getchatting(picknis);
                $('#teks').val('');
            }
        );
    }
}
</script>
