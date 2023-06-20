<?php
include('navbar.php');
if ($_SESSION['auth']['level'] == 'masyarakat') {
if (isset($_GET['edit'])) {
?>
<div class="container">
<div class="row-md m-auto mt-5 pt-3">
<h3> Halo <?= $_SESSION['data']->nama ?>!</h2>
<div class="col  ">
<div class="card text-center w-750 ">
<div class="card-body">
<h4 class="card-title">Edit Pengaduan</h4>
<?php $query = $conn->prepare("SELECT * from pengaduan where id_pengaduan = ? limit 1");
$query->bind_param('s', $_GET['edit']);
$query->execute();
$data = $query->get_result();
$row = $data->fetch_object() ?>
<form class="form" action="controller" enctype="multipart/form-data" method="post">
<input type="hidden" name="nik" value="<?= $_SESSION['data']->nik ?>" />
<div class="row m-2">
<input id="lap" required type="text" class="form-control" placeholder="masukan laporan anda..." row="10" value="<?= $row->isi_laporan ?>" name="laporan"></input>
</div>
<div class="row m-2">
<input type="hidden" name="id" value="<?= $_GET['edit'] ?>" class="form-control mx-1"></input>
<input type="hidden" name="foto" value="<?= $row->foto ?>" class="form-control mx-1"></input>
<input type="file" name="foto" class="form-control mx-1" placeholder="Masukan foto"></input>

</div>
<div class="row m-2">
<button type="submit" class="btn btn-primary" name="ubah-aduan" value="1"> Laporkan </button>
</div>

</form>
</div>
</div>

</div>
</div>
</div>
<?php } else { ?>
<div class="container">
<div class="row-md m-auto mt-5 pt-3">
<h2> Halo <?= $_SESSION['data']->nama ?>!</h2>
<div class="col  ">
<div class="card text-center w-750 ">
<div class="card-body">
<h4 class="card-title">Tambah Pengaduan</h4>
<form class="form" action="controller" enctype="multipart/form-data" method="post">
<input type="hidden" name="nik" value="<?= $_SESSION['data']->nik ?>" />
<div class="row m-2">
<textarea id="lap" required type="text" class="form-control" placeholder="masukan laporan anda..." row="10" name="laporan"></textarea>
</div>
<div class="row m-2">
<input type="file" name="foto" class="form-control mx-1" required placeholder="Masukan foto"></input>
</div>
<div class="row m-2">
<button type="submit" class="btn btn-primary" name="adukan" value="1"> Laporkan </button>
</div>

</form>
</div>
</div>

</div>
</div>
<div class="row-md m-auto mt-3">

<div class="col">
<div class="card">
<div class="card-header">
<h3 class="card-title">Daftar Pengaduan</h3>
</div>
<!-- /.card-header -->
<div class="card-body">
<table id="example1" class="table table-bordered table-striped text-center">
<thead>
<tr>
<th>No</th>
<th>Tanggal Pengaduan</th>
<th>Isi aduan</th>
<th>Gambar</th>
<th>status</th>
<th>Aksi</th>
</tr>
</thead>
<tbody>
<?php
$n = 1;
$query = $conn->prepare("SELECT * from pengaduan where nik = ?");
$query->bind_param('s', $_SESSION['data']->nik);
$query->execute();
$data = $query->get_result();
while ($row = $data->fetch_object()) {
?>
<tr>
<td scope="row">
<?= $n++ ?>
</td>
<td><?= $row->tgl_pengaduan ?></td>
<td><?= $row->isi_laporan ?></td>
<td><img alt="gambar laporan" height="250px" src="img/<?= $row->foto ?>"></img></td>
<td>
<?php
if ($row->status == 0) {
echo ('Terkirim');
} elseif ($row->status == 1) {
echo ('Sudah Ditanggapi');
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
if ($row->status == 0) {
echo ('<a href="pengaduan?edit=' . $row->id_pengaduan . '"><btn class="btn btn-warning"><i class="fa fa-pencil"></i>&ensp;Ubah</btn></a>
<button type="button" class="btn m-1 btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete-' . $n . '" ><i class="fa fa-trash"></i>&ensp;Hapus</button>
');
} elseif ($row->status == 1) {
echo ('<a href="tanggapan?view=' . $row->id_pengaduan . '"><btn class="btn btn-sm btn-primary"><i class="fa fa-info-circle"></i>&ensp;Lihat Tanggapan</btn></a>');
} elseif ($row->status == 'ditolak') {
echo ('<a href="tanggapan?view=' . $row->id_pengaduan . '"><btn class="btn btn-sm btn-primary"><i class="fa fa-info-circle"></i>&ensp;Lihat Tanggapan</btn></a>
<button type="button" class="btn m-1 btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete-' . $n . '" ><i class="fa fa-trash"></i>&ensp;Hapus</button>');
} else {
echo ('no action');
}
?>
<div class="modal fade" id="delete-<?= $n ?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="modalTitleId">Perhatian !!</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
Yakin Ingin Menghapus Laporan ? <br /> <small class="text-secondary">(Laporan akan dihapus selamanya)</small>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Close</button>
<a href="delete?pengaduan=<?= $row->id_pengaduan ?>">
<btn class="btn btn-sm btn-danger">&ensp;Hapus</btn>
</a>
</div>
</div>
</div>
</div>
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
<?php }
} elseif ($_SESSION['auth']['guard'] == 'petugas') { ?>
<div class="container">
<div class="row-md m-auto mt-5 pt-3">
<h3> Halo <?= $_SESSION['data']->nama ?>!</h2>
<div class="col">
<div class="card mt-3">
<div class="card-header">
<h3 class="card-title">Daftar Pengaduan</h3>
</div>
<!-- /.card-header -->
<div class="card-body">
<table id="example1"" class=" table table-bordered table-striped text-center">
<thead>
<tr>
<th>No</th>
<th>Tanggal Pengaduan</th>
<th>Pengadu</th>
<th>Isi aduan</th>
<th>Gambar</th>
<th>status</th>
<th>Aksi</th>
</tr>
</thead>
<tbody>
<?php
$n = 1;
if ($_SESSION['data']->level == 'petugas') {
$query = $conn->query("SELECT pengaduan.id_pengaduan,tgl_pengaduan,nama,isi_laporan,foto,status FROM pengaduan join masyarakat on masyarakat.nik = pengaduan.nik");
}
if ($_SESSION['data']->level == 'admin') {
$query = $conn->query("SELECT id_pengaduan,tgl_pengaduan,nama,isi_laporan,foto,status FROM pengaduan join masyarakat on masyarakat.nik = pengaduan.nik");
}
while ($row = $query->fetch_object()) {
?>
<tr>
<td scope="row">
<?= $n++ ?>
</td>
<td><?= $row->tgl_pengaduan ?></td>
<td><?= $row->nama ?></td>
<td><?= $row->isi_laporan ?></td>
<td><img alt="gambar laporan" height="250px" src="img/<?= $row->foto ?>"></img></td>
<td>
<?php
if ($row->status == 0) {
echo ('Belum Ditanggapi');
} elseif ($row->status == 1) {
echo ('Ditanggapi');
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
if ($row->status == 0) {
echo ('<a href="tanggapan?make=' . $row->id_pengaduan . '"><btn class="btn btn-sm btn-success"><i class="fa fa-pencil"></i>&ensp;Tanggapi</btn></a>');
echo ('<button type="button" class="btn m-1 btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#blockId-' . $n . '" ><i class="fa fa-ban"></i>&ensp;tolak</button>');
} elseif ($row->status == 1) {
echo ('<a href="tanggapan?view=' . $row->id_pengaduan . '"><btn class="btn m-1 btn-sm btn-primary"><i class="fa fa-info-circle"></i>&ensp;Detail</btn></a>');
echo ('<button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalId-' . $n . '">
<i class="fa fa-clock"></i>&ensp;Proses
</button>');
} elseif ($row->status == 'proses') {
echo ('<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#selesai-' . $n . '">
<i class="fa  fa-thumbs-up"></i>&ensp;Selesai
</button>');
} else {
echo ('no action');
}
?>
<!-- Modal trigger button -->


<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
<div class="modal fade" id="modalId-<?= $n ?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="modalTitleId">Perhatian !!</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
Yakin Ingin Menandai Bahwa Laporan Telah Diroses? <br /> <small class="text-secondary">(Status laporan tidak bisa dikembalikan)</small>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Close</button>
<a href="controler?proses=<?= $row->id_pengaduan ?>">
<btn class="btn m-1 btn-sm btn-success">&ensp;Ya</btn>
</a>
</div>
</div>
</div>
</div>
<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
<div class="modal fade" id="selesai-<?= $n ?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="modalTitleId">Perhatian !!</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
Yakin Ingin Menandai Bahwa Laporan Telah Diselesaikan? <br /> <small class="text-secondary">(Status laporan tidak bisa dikembalikan)</small>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Close</button>
<a href="controller?selesai=<?= $row->id_pengaduan ?>">
<btn class="btn m-1 btn-sm btn-success">&ensp;Ya</btn>
</a>
</div>
</div>
</div>
</div>
<div class="modal fade" id="blockId-<?= $n ?>" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="modalTitleId">Perhatian !!</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<form class="form" action="controller" enctype="multipart/form-data" method="post">
<div class="form-group row my-2">
<label for="level" required class="col-sm-2 col-form-label">Alasan Penolakan</label>
<label for="level" required class="col-sm-1 col-form-label">:</label>
<div class="col-sm-9">
<div class="input-group">
<input type="hidden" name="id" value="<?= $row->id_pengaduan ?>"></input>
<input class="form-control" placeholde="Masukan Alasan Penolakan" name="alasan"></input>
</div>
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Close</button>
<button type="submit" class="btn btn-sm btn-danger" name="tolak" value="1"> Tolak </button>
</form>
</div>
</div>
</div>
</div>
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
<?php }
include('footer.php'); ?>