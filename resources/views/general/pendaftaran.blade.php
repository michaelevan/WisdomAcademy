<!DOCTYPE html>
<html lang="en">
<head>
	<title>Pendaftaran</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="assets/fonts/iconic/css/material-design-iconic-font.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/util.css">
	<link rel="stylesheet" type="text/css" href="assets/css/main.css">
    <link rel="shortcut icon" type="image" href="{{url("assets/img/wisdom-logo.png")}}">
</head>
<body>

	<div class="limiter">
		<div class="container-login100" style="background-image: url('assets/img/regis.jpg')">
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54" style="">
				<form class="login100-form validate-form" method="POST" enctype="multipart/form-data">
                    @csrf
					<span class="login100-form-title p-b-49">
						Pendaftaran Online
					</span>

                    <h3>|| JENJANG PENDIDIKAN ||</h3><br>
                    <span class="label-input100" style="font-size: 10px">hanya untuk jenjang smp</span>
					<div class="wrap-input100 validate-input m-b-23">
						<span class="label-input100">Asal Sekolah </span>
						<input required autocomplete="off" class="input100" maxlength="50" type="text" name="asal_sekolah">
					</div>
                    <div class="wrap-input100 validate-input m-b-23">
						<span class="label-input100">Kelas Terakhir</span>
						<input required autocomplete="off" class="input100" min="6" max="9" maxlength="1" type="number" name="kelas">
					</div>

                    <h3>|| DATA SISWA ||</h3><br>
					<div class="wrap-input100 validate-input m-b-23">
						<span class="label-input100">Nama Siswa</span>
						<input required autocomplete="off" class="input100" maxlength="50" type="text" name="nama_siswa">
					</div>
                    <div class="wrap-input100 validate-input m-b-23">
						<span class="label-input100">Tanggal Lahir</span>
						<input required autocomplete="off" class="input100" type="date" name="tgl_lahir">
					</div>
                    <div class="wrap-input100 validate-input m-b-23">
						<span class="label-input100">Jenis Kelamin</span>
						<select class="input100" type="text" name="j_kelamin">
                            <option selected="true" disabled="disabled" style="text-align: center">--Pilih Jenis Kelamin--</option>
                            <option value="0" style="text-align: center">laki-laki</option>
                            <option value="1" style="text-align: center">perempuan</option>
                        </select>
					</div>

                    <h3>|| DATA ORANG TUA ||</h3>
                    <div class="wrap-input100 validate-input m-b-23">
						<span class="label-input100">Nama Orang Tua</span>
						<input required autocomplete="off" class="input100" maxlength="50" type="text" name="nama_orangtua">
					</div>
                    <div class="wrap-input100 validate-input m-b-23">
						<span class="label-input100">No. HP</span>
						<input required autocomplete="off" class="input100" maxlength="15" type="text" name="no_hp">
					</div>
                    <div class="wrap-input100 validate-input m-b-23">
						<span class="label-input100">Email</span>
						<input required autocomplete="off" class="input100" maxlength="50" type="email" name="email">
					</div>
                    <div class="wrap-input100 validate-input m-b-23">
						<span class="label-input100">Alamat Domisili</span>
						<input required autocomplete="off" class="input100" maxlength="255" type="text" name="alamat">
					</div>
                    <div class="wrap-input100 validate-input m-b-23">
						<span class="label-input100">Kota Asal</span>
						<input required autocomplete="off" class="input100" maxlength="50" type="text" name="kota">
					</div>

                    <h3>|| DATA TAMBAHAN ||</h3><br>
                    <div class="wrap-input100 validate-input m-b-23">
						<span class="label-input100">Anak Ke</span>
						<input required autocomplete="off" class="input100" maxlength="2" type="number" name="anak_ke">
					</div>
                    <div class="wrap-input100 validate-input m-b-23">
						<span class="label-input100">Jumlah Saudara</span>
						<input required autocomplete="off" class="input100" maxlength="2" type="number" name="jumlah_saudara">
					</div>
                    <div class="wrap-input100 validate-input m-b-23">
						<span class="label-input100">Keterangan (permasalahan anak)</span>
                        <textarea class="input100" maxlength="255" name="keterangan" placeholder="Kosongi apabila tidak ada"></textarea>
					</div>
                    <div class="wrap-input100 validate-input m-b-23">
						<span class="label-input100">Tanggal Janji Temu</span>
                        <input required autocomplete="off" class="input100" type="datetime-local" name="janji_temu">
					</div>
					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button class="login100-form-btn" type="submit">
								Submit
							</button>
						</div>
					</div><br>
                    <div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn2"></div>
							<a href="{{url('/')}}" style="text-decoration: none">
                                <button class="login100-form-btn" type="button">
                                    Kembali
                                </button>
                            </a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script src="assets/js/main.js"></script>
    @include('sweetalert::alert')
</body>
</html>
