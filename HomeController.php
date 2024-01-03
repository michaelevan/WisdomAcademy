<?php

namespace App\Http\Controllers;

use App\Mail\MailableName;
use App\Models\Notifikasi;
use App\Models\passwordReset;
use App\Models\Pendaftaran;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Revolution\Google\Sheets\Facades\Sheets;

class HomeController extends Controller
{
    public function index() {
        return view("general.index");
    }

    public function hubungiKami() {
        return view("general.hubungi-kami");
    }

    public function tentangKami() {
        return view("general.tentang-kami");
    }

    // PENDAFTARAN
    public function formPendaftaran() {
        return view("general.pendaftaran");
    }
    public function pendaftaran(Request $request) {
        if ($request->j_kelamin == null) {
            return back()->withErrors('pilih jenis kelamin terlebih dahulu');
        }
        else{
            $pesan = [
                'email.unique' => 'email sudah dipakai dan tidak boleh sama',
                'foto.max' => 'ukuran foto tidak boleh lebih dari 2MB',
                'akte_lahir.max' => 'ukuran foto tidak boleh lebih dari 2MB',
                'kartu_keluarga.max' => 'ukuran foto tidak boleh lebih dari 2MB',
                'no_hp.numeric' => 'nomor handphone harus berisikan angka',
            ];
            $request->validate([
                "email" => "unique:pendaftaran,email",
                "email" => "unique:users,email",
                'foto' => 'max:2048',
                'akte_lahir' => 'max:2048',
                'kartu_keluarga' => 'max:2048',
                "no_hp" => "numeric",
            ], $pesan);
            // $pendaftaran = new Pendaftaran();
            // $result = $pendaftaran->daftarAnak($request);
            // if ($result) {
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'wisdomacademy.my.id';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'admin@wisdomacademy.my.id';
                    $mail->Password = 'WisdomAcademy';
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;
                    $mail->setFrom('admin@wisdomacademy.my.id', 'Wisdom Academy');
                    $mail->addAddress($request->email);
                    $mail->isHTML(true);
                    $mail->Subject = 'PENDAFTARAN ONLINE';
                    $mail->Body = 'Terima kasih kepada Bapak/Ibu yang telah melakukan pendaftaran online pada sekolah kami Wisdom Academy.<br>
                    Kami akan segera melakukan proses evaluasi terhadap data yang anda berikan.<br>
                    Mohon menunggu kabar dari kami dalam beberapa hari kedepan';
                    $mail->send();
                    return back()->with('success', 'pendaftaran berhasil!');

                } catch (Exception $e) {
                    return back()->withErrors('pendaftaran gagal!');
                }
            // }
        }
    }

    // LOGIN
    public function formLogin() {
        session()->forget("login");
        return view("general.login");
    }

    public function Login(Request $request)
    {
        $username = $request->input("username");
        $password = $request->input("password");

        if($username == null || $password == null){
            return response(view("general.login", ["msg" => "username atau password kosong! cek kembali inputan anda!"]));
        }
        else {
            $listUsers = Users::all();
            $idx = -1;
            for ($i=0; $i < count($listUsers); $i++) {
                if ($username == $listUsers[$i]->username) {
                    $idx = $i;
                }
            }

            if ($idx == -1) {
                return response(view("general.login", ["msg" => "username / password tidak ada!"]));
            }
            else {
                if ($listUsers[$idx]->status == 0) {
                    return response(view("general.login", ["msg" => "akun anda tidak aktif!"]));
                }
                else if ($listUsers[$idx]->status == 2) {
                    return response(view("general.login", ["msg" => "anak telah lulus!"]));
                }
                else if ($listUsers[$idx]->status == 1) {
                    if ($password == $listUsers[$idx]->password) {
                    // if (Hash::check($password, $listUsers[$idx]->password)) {
                        session()->put("login", $listUsers[$idx]);
                        if ($listUsers[$idx]->role == "admin") {
                            return redirect("/admin/listPendaftaran");
                        }
                        else if ($listUsers[$idx]->role == "anak") {
                            $countNotif = Notifikasi::join('anak', 'notifikasi.id_anak', '=', 'anak.nis')->where('notifikasi.status', 0)
                            ->where('anak.nis', session()->get('login')->username)->count();
                            session()->put("jumNotif", $countNotif);
                            return redirect("/anak/pengumuman");
                        }
                        else if ($listUsers[$idx]->role == "guru") {
                            return redirect("/guru/kelas");
                        }
                        else if ($listUsers[$idx]->role == "orangtua") {
                            return redirect("/orangTua/agenda");
                        }
                    }
                    else {
                        return response(view("general.login", ["msg" => "username / password salah!"]));
                    }
                }
            }
        }
    }

    public function logout(){
        session()->forget("login");
        session()->forget("jumNotif");
        return redirect('/');
    }
}
