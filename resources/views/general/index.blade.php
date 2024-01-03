<!DOCTYPE html>
<html>
<head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>@yield("title")</title>
    <link rel="shortcut icon" type="image" href="{{url("assets/img/wisdom-logo.png")}}">

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    <link rel="stylesheet" href="{{url("assets/fontawesome/css/all.css")}}">
    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="{{url("assets/css/bootstrap.css")}}" />
    <!-- progress barstle -->
    <link rel="stylesheet" href="{{url("assets/css/css-circular-prog-bar.css")}}">
    <!-- Custom styles for this template -->
    <link href="{{url("assets/css/style.css")}}" rel="stylesheet" />
    <!-- responsive style -->
    <link href="{{url("assets/css/responsive.css")}}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<style>
    .nav-link:hover{
        opacity: 25%;
        transition-duration: calc(1s * 0.5);
    }
    .fa-solid .fa-child-reaching::before {
        width: 200px
    }
    .call_to-btn {
        text-decoration: none;
    }
    .kontener2 {
        margin: 50px 10% 0% 10%;
        box-shadow: 0px 0px 5px 0px rgba(163, 158, 163, 1);
        box-sizing: border-box;
        border: 0;
    }
    .layanan {
        margin-top: -20px;
    }
    .service{
        /* margin-bottom: 50px; */
        background: #082465;
        border: 0;
        padding: 5%
    }
    .icons {
        width: 120px;
        height: 120px;
        color: #fff;
        margin: auto;
        text-align: center;
        -ms-border-radius: 50%;
        -moz-border-radius: 50%;
        -webkit-border-radius: 50%;
        border-radius: 0;
        display: inline-table;
        border: 2px solid #fec913;
        color: #fec913;
        background: transparent;
        border-radius: 50%;
        background: #ffffff;
        z-index: 1;
    }
    .isi-layanan {
        background-color: white;
        border: 2px solid #fec913;
        padding: 15px;
        margin-top: -21px;
        text-align: center;
    }
    .acc {
        margin: 5%
    }
    .btn-link {
        padding: 15px 20px 15px 20px;
        color: #1b2336;
        background-color: #f5f3f4;
        border-radius: 5px 5px 5px 5px;
        display: flex;
        align-items: center;
        font-size: 20px;
        line-height: 30px;
        cursor: pointer;
        transition: 0.4s;
        text-align: center;
        text-decoration: none;
    }
    .btn-link:hover {
        background: #082465;
        text-decoration: none;
        color: white;
        box-sizing: border-box;
        box-shadow: 0px 0px 5px 0px #082465;
    }
    .desc {
        border: 0;
    }
    .accordion {
        max-width: 500px;
    }
    .accordion .contentBx {
        position: relative;
        margin: 10px 20px;
    }
    .accordion .contentBx .label {
        position: relative;
        padding: 15px 20px 15px 20px;
        background-color: #f5f3f4;
        border-radius: 5px 5px 5px 5px;
        display: flex;
        font-size: 20px;
        line-height: 30px;
        cursor: pointer;
        transition: 0.4s;
    }
    .accordion .contentBx .label:hover {
        background: #082465;
        color: white;
        box-sizing: border-box;
        box-shadow: 0px 0px 5px 0px #082465;
    }
    .accordion .contentBx .label::before {
        content: '+';
        position: absolute;
        top: 50%;
        right: 20px;
        transform: translateY(-50%);
        font-size: 1.5rem;
    }
    .accordion .contentBx.active .label::before {
        -webkit-transition: opacity 3s ease-in-out;
        -moz-transition: opacity 3s ese-in-out;
        -ms-transition: opacity 3s ease-in-out;
        -o-transition: opacity 3s ease-in-out;
        opacity: 1;
        content: '-';
    }
    .accordion .contentBx .content {
        position: relative;
        height: 0;
        overflow: hidden;
        transition: 0.5s;
        overflow-y: auto;
    }
    .accordion .contentBx.active .content {
        height: auto;
        padding: 10px;
    }
    .accordion .contentBx.active .label {
        background: #082465;
        color: white;
        box-sizing: border-box;
        box-shadow: 0px 0px 5px 0px #082465;
    }
</style>
<body>
  <div class="top_container">
    <!-- header section strats -->
        <header class="header_section">
            <div class="container">
                <nav class="navbar navbar-expand-lg custom_nav-container" id="navbar">
                    <a class="navbar-brand" href="/">
                        <img src="{{("assets/img/wisdom-logo.png")}}" alt="" style="width: 100px">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="d-flex ml-auto flex-column flex-lg-row align-items-center">
                      <ul class="navbar-nav">
                          <li class="nav-item active">
                              <a class="nav-link" href="/tentangKami"> Tentang Kami</span></a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="/pendaftaran"> Pendaftaran </a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="/login">Login</a>
                          </li>
                      </ul>
                  </div>
                </nav>
            </div>
        </header>
    <section class="hero_section ">
      <div class="hero-container container">
        <div class="hero_detail-box">
          <h3>
            Welcome to <br>
          </h3>
          <h1>
            Wisdom Academy
          </h1>
          <p>
            Pusat Pendidikan Dan Pelatihan
            Bagi Anak Berkebutuhan Khusus
          </p>
          <div class="hero_btn-continer">
            <a href="/pendaftaran" class="call_to-btn btn_white-border" style="text-decoration: none">
              <span>
                Daftarkan anak anda
              </span>
              <i class="fa-solid fa-arrow-right ml-2" style="color: #ffffff;"></i>
            </a>
          </div>
        </div>
        <div class="hero_img-container">
          <div>
            <img src="{{url("assets/img/wisdom.png")}}" alt="" class="img-fluid">
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- end header section -->
  <!-- vehicle section -->
    <div class="container2">
        <div class="kontener1">
            <h2 class="main-heading ">
                Layanan Kami.
            </h2>
        </div>
        <div class="kontener2">
            <div class="card-group layanan">
                <div class="card service">
                    <span class="icons c1">
                        <i class="fa-4x fa-solid fa-child-reaching mt-4"></i>
                    </span>
                    <div class="card-body isi-layanan">
                        <h5 class="card-title">Konsultasi Anak</h5>
                        <p class="card-text">Metode Pemeriksaan menyeluruh terkait kondisi psikologis seorang anak berkebutuhan khusus yang mencakup perilaku anak, emosi anak serta tumbuh kembangnya anak tersebut.</p>
                    </div>
                </div>
                <div class="card service">
                    <span class="icons c2">
                        <i class="fa-4x fa-regular fa-face-angry mt-4"></i>
                    </span>
                    <div class="card-body isi-layanan">
                        <h5 class="card-title">Terapi Perilaku</h5>
                        <p class="card-text">Terapi perilaku merupakan salah satu terapi yang diberikan kepada Anak Berkebutuhan Khusus dimana terapi ini difokuskan kepada kemampuan anak untuk merespon terhadap lingkungan.</p>
                    </div>
                </div>
                <div class="card service">
                    <span class="icons c3">
                        <i class="fa-4x fa-regular fa-comments mt-4"></i>
                    </span>
                    <div class="card-body isi-layanan">
                        <h5 class="card-title">Terapi Wicara</h5>
                        <p class="card-text">Meningkatkan kemampuan bicara, memahami, dan mengekspresikan bahasa. Selain bahasa yang bersifat verbal, terapi ini juga melatih bentuk bahasa nonverbal.</p>
                    </div>
                </div>
            </div>
            <div class="card-group layanan">
                <div class="card service">
                    <span class="icons c4">
                        <i class="fa-4x fa-solid fa-baby mt-4"></i>
                    </span>
                    <div class="card-body isi-layanan">
                        <h5 class="card-title">Terapi Okupasi</h5>
                        <p class="card-text">Terapan medis yang terarah untuk anak berkebutuhan khusus baik fisik maupun mental dengan menggunakan aktivitas sebagai media terapi dalam memulihkan fungsi semaksimal mungkin.</p>
                    </div>
                </div>
                <div class="card service">
                    <span class="icons c5">
                        <i class="fa-4x fa-solid fa-person-walking mt-4"></i>
                    </span>
                    <div class="card-body isi-layanan">
                        <h5 class="card-title">Fisioterapi</h5>
                        <p class="card-text">Menstabilkan atau memperbaiki gangguan fungsi alat gerak, fungsi tubuh yang terganggu pada anak berkebutuhan khusus yang kemudian diikuti dengan proses metode terapi gerak.</p>
                    </div>
                </div>
                <div class="card service">
                    <span class="icons c6">
                        <i class="fa-4x fa-regular fa-handshake mt-4"></i>
                    </span>
                    <div class="card-body isi-layanan">
                        <h5 class="card-title">Sensor Integrasi</h5>
                        <p class="card-text">Mengamati cara anak bereaksi menerima input sensorik berupa sentuhan, gerakan, kesadaran tubuh dan grafitasinya, penciuman, pengecapan, penglihatan dan pendengaran.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<br><br><br>
</div>
  <!-- admission section -->
  <section class="admission_section ">
    <div class="container-fluid position-relative">
      <div class="row h-100">
        <div id="map" class="h-100 w-100 ">
        </div>
        <div class="container">
          <div class="admission_container position-absolute">
            <div class="admission_img-box">
              <img src="img/kidss.jpg" alt="">
            </div>
            <div class="admission_detail">
              <h3>
                Temukan Kami
              </h3>
              <p class="mt-3 mb-4">
                Galaxy Bumi Permai Blok H5 No 31 Surabaya.
              </p>
              <div class="">
                <a href="" class="call_to-btn btn_on-hover" style="text-decoration: none">
                  Read More
                </a>
              </div>
              {{-- <a href="" class="call_to-btn btn_white-border" style="text-decoration: none"> --}}

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- admission section -->

  <!-- footer section -->
  <section class="container-fluid footer_section">
    <p>
      Copyright &copy; <script>document.write(new Date().getFullYear())</script> All Rights Reserved By Wisdom Academy
    </p>

  </section>
  @include('sweetalert::alert')

  <!-- footer section -->
  {{-- <script src="https://kit.fontawesome.com/1887e2132f.js" crossorigin="anonymous"></script> --}}
  <script type="text/javascript" src="{{url("assets/js/jquery-3.4.1.min.js")}}"></script>
  <script type="text/javascript" src="{{url("assets/js/bootstrap.js")}}"></script>

  <script>
    const accordion = document.getElementsByClassName('contentBx');
    for (i = 0; i < accordion.length; i++) {
        accordion[i].addEventListener('click', function(){
            this.classList.toggle('active');
        });

    }
    // This example adds a marker to indicate the position of Bondi Beach in Sydney,
    // Australia.
    function initMap() {
      var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 11,
        center: {
          lat: -7.2790514,
          lng: 112.8034399
        },
      });

      var image = 'img/maps-and-flags.png';
      var beachMarker = new google.maps.Marker({
        position: {
          lat: -7.2790514,
          lng: 112.8034399
        },
        map: map,
        icon: image
      });
    }
  </script>
  <!-- google map js -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8eaHt9Dh5H57Zh0xVTqxVdBFCvFMqFjQ&callback=initMap">
  </script>
  <!-- end google map js -->
</body>

</html>
