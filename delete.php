<?php
include('controller.php');
if(isset($_GET['pengaduan'])){
    $query = $conn->prepare("SELECT * FROM pengaduan WHERE id_pengaduan = ? limit 1");
    $query->bind_param('i',$_GET['pengaduan']);
    $query->execute();
    $data = $query->get_result();
    $row = $data->fetch_object();
    if(hapus($row->foto)){
       if($conn->query("DELETE FROM pengaduan WHERE id_pengaduan='".$_GET['pengaduan']."'")){
        header('Location: pengaduan?msg=deleted');}else{header('Location: pengaduan?msg=deletegagal');}
    }else{
        header('Location: pengaduan?msg=deletegagal');
    }
}
if(isset($_GET['tanggapan'])){
   
       if($conn->query("DELETE FROM tanggapan WHERE id_tanggapan='".$_GET['tanggapan']."'")){
        header('Location: tanggapan?msg=deleted');}else{header('Location: tanggapan?msg=deletegagal');}
}
?>