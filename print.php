<?php include('controller.php'); 
if(isset($_SESSION['auth'])){
if($_SESSION['auth']['status']!=1){
header('Location: login');
}
if($_SESSION['auth']['level']=='petugas'||$_SESSION['auth']['level']=='admin'){
    if($_SESSION['data']->level != 'admin'){
header('Location: login');
    }
}else{
header('Location: login');}
}else{
  header('Location: login');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
  <script>window.print();window.onafterprint = function(event) {
    window.location.href = 'pengaduan'
}; </script>
  <div class="container">
            <div class="container">
                <div class="row-md m-auto mt-3">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Laporan</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal Laporan</th>
                                            <th>Tanggal Tanggapan</th>
                                            <th>Laporan</th>
                                            <th>Tangapan</th>
                                            <th>Gambar</th>
                                            <th>status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $n = 1;
                                            $data = $conn->query("SELECT * from pengaduan join tanggapan on tanggapan.id_pengaduan = pengaduan.id_pengaduan");
                                        while ($row = $data->fetch_object()) {
                                            ?>
                                            <tr>
                                                <td scope="row">
                                                    <?= $n++ ?>
                                                </td>
                                                <td>
                                                    <?= $row->tgl_pengaduan ?>
                                                </td>
                                                <td>
                                                    <?= $row->tgl_tanggapan ?>
                                                </td>
                                                <td>
                                                    <?= $row->isi_laporan ?>
                                                </td>
                                                <td>
                                                    <?= $row->tanggapan?>
                                                </td>
                                                <td><img alt="gambar laporan" height="250px" src="img/<?= $row->foto ?>"></img>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($row->status == 0) {
                                                        echo ('Terkirim');
                                                    } elseif ($row->status == 1) {
                                                        echo ('Diverivikasi');
                                                    } elseif ($row->status == 'proses') {
                                                        echo ('Aduan Sedang Diproses');
                                                    } elseif ($row->status == 'selesai') {
                                                        echo ('Aduan Sudah Diselesaikan');
                                                    } elseif ($row->status == 'ditolak') {
                                                        echo ('Aduan Ditolak / tidak valid');
                                                    } else {
                                                        echo 'err';
                                                    }
                                                    ?>
                                                </td>
                                            
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <?php header('pengaduan');?>