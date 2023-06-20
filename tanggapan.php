<?php
include('navbar.php');
if ($_SESSION['auth']['level'] == 'masyarakat') {
if (isset($_GET['view'])) {
$query = $conn->prepare("SELECT pengaduan.id_pengaduan,id_tanggapan,tgl_pengaduan,nama,isi_laporan,foto,tanggapan,status FROM pengaduan join masyarakat on masyarakat.nik = pengaduan.nik join tanggapan on tanggapan.id_pengaduan = pengaduan.id_pengaduan  where pengaduan.id_pengaduan = ? and masyarakat.nik = ?");
$query->bind_param('ii',$_GET['view'],$_SESSION['data']->nik);
$query->execute();
$dat = $query->get_result();
$row = $dat->fetch_object();
?>
<div class="container">
<div class="row-md m-auto mt-5 pt-3">
<h2> Halo
<?= $_SESSION['data']->nama ?>!</h2>
<div class="col  ">
<div class="card text-center w-750 ">
<div class="card-body">
<h4 class="card-title">Lihat Tanggapan</h4>
<form class="form" action="controller" enctype="multipart/form-data" method="post">
<div class="form-group row my-2">
<label for="level" required class="col-sm-2 col-form-label">Tanggal</label>
<label for="level" required class="col-sm-1 col-form-label">:</label>
<div class="col-sm-9">
<div class="input-group">
<input type="hidden" name="id" value="<?=$_GET['view']?>"></input>
<input disabled type="date" value='<?=$row->tgl_pengaduan?>' class ="form-control" name = "name" value="" readonly></input>
</div>
</div>
</div>    
<div class="form-group row my-2">
<label for="level" required class="col-sm-2 col-form-label">Pembuat Aduan</label>
<label for="level" required class="col-sm-1 col-form-label">:</label>
<div class="col-sm-9">
<div class="input-group">
<input disabled class ="form-control" value="<?=$row->nama?>"name = "name" value="" readonly></input>
</div>
</div>
</div>
<div class="form-group row my-2">
<label for="level" required class="col-sm-2 col-form-label">Isi Laporan</label>
<label for="level" required class="col-sm-1 col-form-label">:</label>
<div class="col-sm-9">
<div class="input-group">
<input disabled class ="form-control" value="<?=$row->isi_laporan?>" name = "name" value="" readonly></input>
</div>
</div>
</div>
<div class="form-group row my-2">
<label for="level" required class="col-sm-2 col-form-label">Gambar Pendukung</label>
<label for="level" required class="col-sm-1 col-form-label">:</label>
<div class="col-sm-9">
<img alt="gambar laporan" height="350px" src="img/<?= $row->foto ?>"></img>
</div>
</div>
<div class="form-group row my-2">
<label for="level" required class="col-sm-2 col-form-label">Isi Tanggapan</label>
<label for="level" required class="col-sm-1 col-form-label">:</label>
<div class="col-sm-9">
<div class="input-group">
<input disabled readonly class ="form-control" value="<?=$row->tanggapan?>" name = "name" value="" readonly></input>
</div>
</div>
</div>

<div class="row m-2">
<a class="col" href="pengaduan"><button type="button" class="btn col btn-primary" name="tanggapi" value="1"><i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp; Kembali</button></a>

</div>

</form>
</div>
</div>

</div>
</div>
</div>
<?php }{?>


<?php 
}} elseif ($_SESSION['auth']['level'] == 'petugas' || $_SESSION['auth']['level'] == 'admin') {
if (isset($_GET['make'])) {
$query = $conn->prepare("SELECT id_pengaduan,tgl_pengaduan,nama,isi_laporan,foto,status FROM pengaduan join masyarakat on masyarakat.nik = pengaduan.nik where id_pengaduan = ?");
$query->bind_param('i', $_GET['make']);
$query->execute();
$dat = $query->get_result();
$row = $dat->fetch_object();
?>
<div class="container">
<div class="row-md m-auto mt-5 pt-3">
<h3> Halo
<?= $_SESSION['data']->nama ?>!</h2>
<div class="col  ">
<div class="card text-center w-750 ">
<div class="card-body">
<h4 class="card-title">Lihat Tanggapan</h4>
<form class="form" action="controller" enctype="multipart/form-data" method="post">
<div class="form-group row my-2">
<label for="level"  class="col-sm-2 col-form-label">Tanggal</label>
<label for="level"  class="col-sm-1 col-form-label">:</label>
<div class="col-sm-9">
<div class="input-group">
<input type="hidden" name="id" value="<?= $_GET['make'] ?>"></input>
<input type="date" value='<?= $row->tgl_pengaduan ?>' class="form-control"
disabled readonly></input>
</div>
</div>
</div>
<div class="form-group row my-2">
<label for="level" required class="col-sm-2 col-form-label">Pembuat Aduan</label>
<label for="level" required class="col-sm-1 col-form-label">:</label>
<div class="col-sm-9">
<div class="input-group">
<input class="form-control" value="<?= $row->nama ?>" disabled name="name" value=""
readonly></input>
</div>
</div>
</div>
<div class="form-group row my-2">
<label for="level" required class="col-sm-2 col-form-label">Isi Laporan</label>
<label for="level" required class="col-sm-1 col-form-label">:</label>
<div class="col-sm-9">
<div class="input-group">
<input class="form-control" disabled value="<?= $row->isi_laporan ?>" name="name" value=""
readonly></input>
</div>
</div>
</div>
<div class="form-group row my-2">
<label for="level" required class="col-sm-2 col-form-label">Gambar Pendukung</label>
<label for="level" required class="col-sm-1 col-form-label">:</label>
<div class="col-sm-9">
<img alt="gambar laporan" height="350px" src="img/<?= $row->foto ?>"></img>
</div>
</div>
<div class="row m-2">
<textarea id="lap" required type="text" class="form-control"
placeholder="masukan Tanggapan anda..." style="height:100px"
name="tanggapan"></textarea>
</div>

<div class="row m-2">
<button type="submit" class="btn btn-primary" name="tanggapi" value="1"> Tanggapi
</button>
</div>

</form>
</div>
</div>

</div>
</div>
</div>
<?php } elseif (isset($_GET['view'])) {
$query = $conn->prepare("SELECT pengaduan.id_pengaduan,id_tanggapan,tgl_pengaduan,nama,isi_laporan,foto,tanggapan,status FROM pengaduan join masyarakat on masyarakat.nik = pengaduan.nik join tanggapan on tanggapan.id_pengaduan = pengaduan.id_pengaduan  where pengaduan.id_pengaduan = ?");
$query->bind_param('i', $_GET['view']);
$query->execute();
$dat = $query->get_result();
$row = $dat->fetch_object();
?>
<div class="container">
<div class="row-md m-auto mt-5 pt-3">
<h2> Halo
<?= $_SESSION['data']->nama ?>!</h2>
<div class="col  ">
<div class="card text-center w-750 ">
<div class="card-body">
<h4 class="card-title">Detail Tanggapan</h4>
<form class="form" action="controller" enctype="multipart/form-data" method="post">
<div class="form-group row my-2">
<label for="level" required class="col-sm-2 col-form-label">Tanggal</label>
<label for="level" required class="col-sm-1 col-form-label">:</label>
<div class="col-sm-9">
<div class="input-group">
<input type="hidden" name="id" value="<?= $_GET['view'] ?>"></input>
<input disabled type="date" value='<?= $row->tgl_pengaduan ?>'
class="form-control" name="name" value="" readonly></input>
</div>
</div>
</div>
<div class="form-group row my-2">
<label for="level" required class="col-sm-2 col-form-label">Pembuat Aduan</label>
<label for="level" required class="col-sm-1 col-form-label">:</label>
<div class="col-sm-9">
<div class="input-group">
<input disabled class="form-control" value="<?= $row->nama ?>" name="name"
value="" readonly></input>
</div>
</div>
</div>
<div class="form-group row my-2">
<label for="level" required class="col-sm-2 col-form-label">Isi Laporan</label>
<label for="level" required class="col-sm-1 col-form-label">:</label>
<div class="col-sm-9">
<div class="input-group">
<input disabled class="form-control" value="<?= $row->isi_laporan ?>" name="name"
value="" readonly></input>
</div>
</div>
</div>
<div class="form-group row my-2">
<label for="level" required class="col-sm-2 col-form-label">Gambar Pendukung</label>
<label for="level" required class="col-sm-1 col-form-label">:</label>
<div class="col-sm-9">
<img alt="gambar laporan" height="350px" src="img/<?= $row->foto ?>"></img>
</div>
</div>
<div class="form-group row my-2">
<label for="level" required class="col-sm-2 col-form-label">Isi Tanggapan</label>
<label for="level" required class="col-sm-1 col-form-label">:</label>
<div class="col-sm-9">
<div class="input-group">
<input disabled readonly class="form-control" value="<?= $row->tanggapan ?>"
name="name" value="" readonly></input>
</div>
</div>
</div>

<div class="row m-2">
<a class="col" href="pengaduan"><button type="button" class="btn col btn-primary"
name="tanggapi" value="1"><i class="fa fa-arrow-left" aria-hidden="true"></i>
&nbsp; Kembali</button></a>
<?php if ($row->status == 1 && $_SESSION['auth']['level']=='petugas') { ?>
<a class="col" href="tanggapan?edit=<?= $row->id_pengaduan ?>"><button type="button"
class="btn col btn-warning" name="tanggapi" value="1"><i class="fa fa-pencil"
aria-hidden="true"></i> &nbsp; Edit</button></a>
<div class="col">
<button type="button" class="btn  m-1 btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete" ><i class="fa fa-trash"></i>&ensp;Hapus</button>'
</div>
<?php } ?>
</div>

</form>
<div class="modal fade" id="delete" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="modalTitleId">Perhatian !!</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
Yakin Ingin Menghapus Tanggapan ? <br/> <small class="text-secondary">(Tanggapan akan dihapus selamanya)</small>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Close</button>
<a href="delete?tanggapan=<?= $row->id_tanggapan ?>"><btn class="btn btn-sm btn-danger">&ensp;Hapus</btn></a>
</div>
</div>
</div>
</div>
</div>
</div>

</div>
</div>
</div>
<?php } elseif (isset($_GET['edit'])) {
$query = $conn->prepare("SELECT pengaduan.id_pengaduan,id_tanggapan,tgl_pengaduan,nama,isi_laporan,foto,tanggapan,status FROM pengaduan join masyarakat on masyarakat.nik = pengaduan.nik join tanggapan on tanggapan.id_pengaduan = pengaduan.id_pengaduan  where pengaduan.id_pengaduan = ?");
$query->bind_param('i', $_GET['edit']);
$query->execute();
$dat = $query->get_result();
$row = $dat->fetch_object();
?>
<div class="container">
<div class="row-md m-auto mt-5 pt-3">
<h3> Halo
<?= $_SESSION['data']->nama ?>!</h2>
<div class="col  ">
<div class="card text-center w-750 ">
<div class="card-body">
<h4 class="card-title">Ubah Tanggapan</h4>
<form class="form" action="controller" enctype="multipart/form-data" method="post">
<div class="form-group row my-2">
<label for="level" required class="col-sm-2 col-form-label">Tanggal</label>
<label for="level" required class="col-sm-1 col-form-label">:</label>
<div class="col-sm-9">
<div class="input-group">
<input type="hidden" name="id" value="<?= $row->id_tanggapan ?>"></input>
<input disabled type="date" value='<?= $row->tgl_pengaduan ?>'
class="form-control" name="name" value="" readonly></input>
</div>
</div>
</div>
<div class="form-group row my-2">
<label for="level" required class="col-sm-2 col-form-label">Pembuat Aduan</label>
<label for="level" required class="col-sm-1 col-form-label">:</label>
<div class="col-sm-9">
<div class="input-group">
<input disabled class="form-control" value="<?= $row->nama ?>" name="name"
value="" readonly></input>
</div>
</div>
</div>
<div class="form-group row my-2">
<label for="level" required class="col-sm-2 col-form-label">Isi Laporan</label>
<label for="level" required class="col-sm-1 col-form-label">:</label>
<div class="col-sm-9">
<div class="input-group">
<input disabled class="form-control" value="<?= $row->isi_laporan ?>" name="name"
value="" readonly></input>
</div>
</div>
</div>
<div class="form-group row my-2">
<label for="level" required class="col-sm-2 col-form-label">Gambar Pendukung</label>
<label for="level" required class="col-sm-1 col-form-label">:</label>
<div class="col-sm-9">
<img alt="gambar laporan" height="350px" src="img/<?= $row->foto ?>"></img>
</div>
</div>
<!-- <div class="row m-2">
<textarea id="lap" required type="text" class="form-control"
placeholder="masukan Tanggapan anda..." style="height:100px" name="tanggapan"></textarea>
</div> -->
<div class="form-group row my-2">
<label for="level" required class="col-sm-2 col-form-label">Isi Tanggapan</label>
<label for="level" required class="col-sm-1 col-form-label">:</label>
<div class="col-sm-9">
<div class="input-group">
<input placeholder="Masukan Tanggapan Adna.." class="form-control"
value="<?= $row->tanggapan ?>" name="tanggapan"></input>
</div>
</div>
</div>
<div class="row m-2">
<a class="col" href="pengaduan"><button type="button" class="btn col btn-primary"
name="tanggapi" value="1"><i class="fa fa-arrow-left" aria-hidden="true"></i>
&nbsp; Kembali</button></a>
<button type="submit" class="btn col btn-primary" name="ubah-tanggapan" value="1"> Ubah
</button>
</div>

</form>
</div>
</div>

</div>
</div>
</div>
<?php } else { ?>
<div class="container">
<div class="container">
<div class="row-md m-auto mt-3">
<div class="col">
<div class="card">
<div class="card-header">
<h3 class="card-title">Daftar Tanggapan</h3>
</div>
<!-- /.card-header -->
<div class="card-body">
<table id="example1" class="table table-bordered table-striped text-center">
<thead>
<tr>
<th>No</th>
<th>Tanggal Tanggapan</th>
<th>Isi Tangapan</th>
<th>status</th>
<th>Aksi</th>
</tr>
</thead>
<tbody>
<?php

$n = 1;
if ($_SESSION['data']->level == 'petugas') {
$query = $conn->prepare("SELECT * from tanggapan where id_petugas = ?");
$query->bind_param('i', $_SESSION['data']->id);
$query->execute();
$data = $query->get_result();
} elseif ($_SESSION['data']->level == 'admin') {
$data = $conn->query("call gettgp()");
}
while ($row = $data->fetch_object()) {
?>
<tr>
<td scope="row">
<?= $n++ ?>
</td>
<td>
<?= $row->tgl_tanggapan ?>
</td>
<td>
<?= $row->tanggapan ?>
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
<td>
<?php
if ($row->status == 0 ) {
echo ('<a href="ubah-pengaduan?id=' . $row->id_pengaduan . '"><btn class="btn btn-warning"><i class="fa fa-pencil"></i>&ensp;Ubah</btn></a>
<a href="delete?pengaduan=' . $row->id_pengaduan . '"><btn class="btn btn-danger"><i class="fa fa-trash"></i>&ensp;Hapus</btn></a>');
} else {
echo ('no action');
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
<?php }
} else {
echo '<h1>LAH</h1>';
}
?>
<?php include('footer.php'); ?>