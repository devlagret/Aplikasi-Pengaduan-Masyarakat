<?php
session_start();
include('img/delete.php');
$hostname = 'localhost';
$username = 'root';
$db = 'pengaduans';
$connP = mysqli_connect($hostname, $username, '', $db);
$conn = new mysqli($hostname, $username, '', $db);
if ($conn->connect_errno) {
    die('Error : ' . $conn->connect_errno);
}
/**Escape given string
 * @param $string
 */
function escape($string)
{
    $hostname = 'localhost';
    $username = 'root';
    $db = 'pengaduans';
    $connP = mysqli_connect($hostname, $username, '', $db);
    return mysqli_real_escape_string($connP, $string);
}
if (isset($_POST['login'])) {
    $usr = mysqli_real_escape_string($connP, $_POST['username']);
    $pswd = sha1($_POST['password']);
    $q = mysqli_query($connP, "Select nik, nama, username, telp from masyarakat where username = '" . $usr . "' and password = '" . $pswd . "' limit 1");
    if (mysqli_num_rows($q) != 0) {
        $data = mysqli_fetch_object($q);
        var_dump($data);
        $_SESSION['data'] = $data;
        $_SESSION['auth'] = ['level' => 'masyarakat', 'status' => 1, 'guard' => 'masyarakat'];
        header('Location: /ukk-native/polos/pengaduan');
    } else {
        $q2 = mysqli_query($connP, "Select id_petugas as id, nama_petugas as nama, username, telp,level from petugas where username = '" . $usr . "' and password = '" . $pswd . "' limit 1");
        if (mysqli_num_rows($q2) != 0) {
            $data = mysqli_fetch_object($q2);
            $_SESSION['data'] = $data;
            $_SESSION['auth'] = ['level' => 'petugas', 'status' => 1, 'guard' => 'petugas'];
            header('Location: /ukk-native/polos/pengaduan');
        } else {
            header('Location: login?not-found');
        }
    }

}
if (isset($_POST['register'])) {
    $usr = escape($_POST['username']);
    $pswd = sha1($_POST['password']);
    $name = escape($_POST['nama']);
    if (!isset($_SESSION['auth'])) {
        $q = mysqli_query($connP, "select username from masyarakat where username = '" . $usr . "'");
        if (mysqli_num_rows($q) >= '1') {
            header('Location: register?exist');
        }
        mysqli_next_result($connP);
        $in = $conn->prepare("INSERT INTO masyarakat (nik,nama,username,password,telp) VALUES (?,?,?,?,?)");
        $in->bind_param('isssi', $_POST['nik'], $_POST['nama'], $_POST['username'], $pswd, $_POST['telp']);
        if ($in->execute()) {
            header('Location: login?register-success');
        } else {
            header('Location: register?gagal');
        }
    } elseif (isset($_SESSION['auth'])) {
        if ($_SESSION['auth']['level'] == 'admin') {
            $q = mysqli_query($connP, "select username from petugas where username = '" . $usr . "'");
            if (mysqli_num_rows($q) >= '1') {
                header('Location: register?exist');
            }
            mysqli_next_result($connP);
        }
        $in = $conn->prepare("INSERT INTO petugas (nama_petugas,username,password,telp,`level`) VALUES (?,?,?,?,?)");
        $in->bind_param('sssis', $_POST['nama'], $_POST['username'], $pswd, $_POST['telp'], $_POST['level']);
        if ($in->execute()) {
            header('Location: pengaduan?register-success');
        } else {
            header('Location: register?gagal');
        }
    }

}
if (isset($_POST['adukan'])) {
    $tmp = $_FILES['foto']['tmp_name'];
    $filename = date("YmdHis") . '_' . $_FILES['foto']['name'];
    if (!move_uploaded_file($tmp, 'img/' . $filename)) {
        header('Location: pengaduan?err=upload-error', true, 500);
    }
    $query = $conn->prepare("insert into pengaduan (tgl_pengaduan,nik,isi_laporan,foto,status) VALUES (?,?,?,?,?)");
    $date = date('Y-m-d');
    $status = '0';
    $query->bind_param('sisss', $date, $_POST['nik'], $_POST['laporan'], $filename, $status);
    if ($query->execute()) {
        header('Location: pengaduan?sucess=sukses');
    } else {
        header('Location: pengaduan?err=gagal');
    }
}
if (isset($_POST['ubah-aduan'])) {
    if ($_FILES['foto']['size'] <= 0) {
        var_dump($_FILES['foto']);
        $query = $conn->prepare("UPDATE pengaduan.pengaduan SET isi_laporan = ? WHERE id_pengaduan = ?");
        $date = date('Y-m-d');
        $status = '0';
        $query->bind_param('si', $_POST['laporan'], $_POST['id']);
        if ($query->execute()) {
            header('Location: pengaduan?sucess=sukses');
        } else {
            header('Location: pengaduan?err=gagal');
        }
    }elseif($_FILES['foto']['size'] > 0){

        $tmp = $_FILES['foto']['tmp_name'];
        $filename = date("YmdHis").'_'.$_FILES['foto']['name'];
        
        if(!move_uploaded_file($tmp,'img/'.$filename)){
                header('Location: pengaduan?err=upload-error',true,500);
            }
hapus($_POST['foto']);
            $query = $conn->prepare("UPDATE pengaduan.pengaduan SET foto = ? , isi_laporan = ? WHERE id_pengaduan = ?");
            $date = date('Y-m-d');$status='0';
            $query->bind_param('ssi',$filename,$_POST['laporan'],$_POST['id']);
            if($query->execute()){
                    header('Location: pengaduan?sucess=sukses');
                }else{
                    header('Location: pengaduan?err=gagal');}
                }
}
if (isset($_POST['tanggapi'])) {
    $query = $conn->prepare("INSERT INTO tanggapan (id_pengaduan,tgl_tanggapan,tanggapan,id_petugas) VALUES (?,?,?,?)");
    $date = date('Y-m-d');
    $status = '0';
    $query->bind_param('issi', $_POST['id'], $date, $_POST['tanggapan'], $_SESSION['data']->id);
    if ($query->execute()) {
        header('Location: pengaduan?tanggap=sukses');
    } else {
        header('Location: pengaduan?tanggap=gagal');
    }
}
if (isset($_POST['ubah-tanggapan'])) {
    $query = $conn->prepare("UPDATE tanggapan SET tanggapan = ? WHERE id_tanggapan = ?");
    $query->bind_param('si', $_POST['tanggapan'], $_POST['id']);
    if ($query->execute()) {
        header('Location: pengaduan?ubahtanggap=sukses');
    } else {
        header('Location: pengaduan?ubahtanggap=gagal');
    }
}
if (isset($_GET['proses'])) {
    $query = $conn->prepare("UPDATE pengaduan SET status='proses' WHERE id_pengaduan = ?");
    $query->bind_param('s', $_GET['proses']);
    if ($query->execute()) {
        header('Location: pengaduan?proses=sukses');
    } else {
        header('Location: pengaduan?proses=gagal');
    }
}
if (isset($_GET['selesai'])) {
    $query = $conn->prepare("UPDATE pengaduan SET status='selesai' WHERE id_pengaduan = ?");
    $query->bind_param('s', $_GET['selesai']);
    if ($query->execute()) {
        header('Location: pengaduan?selesai=sukses');
    } else {
        header('Location: pengaduan?selesai=gagal');
    }
}
if (isset($_POST['tolak'])) {
    $query = $conn->prepare("UPDATE pengaduan SET status='ditolak' WHERE id_pengaduan = ?");
    $query->bind_param('s', $_POST['id']);
    if ($query->execute()) {
        $queryy = $conn->prepare("INSERT INTO tanggapan (id_pengaduan,tgl_tanggapan,tanggapan,id_petugas) VALUES (?,?,?,?)");
        $date = date('Y-m-d');
        $status = '0';
        $queryy->bind_param('issi', $_POST['id'], $date, $_POST['alasan'], $_SESSION['data']->id);
        if ($queryy->execute()) {
            $query->execute();
            header('Location: pengaduan?tolak=sukses');
        } else {
            header('Location: pengaduan?tolak=gagal');
        }
    } else {
        header('Location: pengaduan?tolak=gagal');
    }
}