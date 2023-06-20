<?php 
include('header.php');
function title($title='default')
{
    echo '<title> APM | ' . $title . '</title>';
}
?>
</head>
    <!-- <nav class="navbar navbar-expand-sm navbar-light bg-primary fixed-top">
        <div class="container-fluid">
            <h2 style="color:white">APM</h2>
            <div class="collapse nav-item text-white mx-2 navbar-collapse" id="navbarID">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
            </div>
        </div>
    </nav> -->
    <nav class="navbar navbar-expand navbar-light bg-primary fixed-top">
        <div class="nav navbar-nav ">
        <h2 class="ps-3"style="color:white">APM</h2>
    </a>
    <?php if ($_SESSION['auth']['guard'] == 'petugas') {?>
        <a class=" ps-5 nav-item text-white nav-link ml-5" href="tanggapan">Tanggapan
            <a class="nav-item text-white nav-link ps-3" href="pengaduan">Pengaduan</a>
            <?php if($_SESSION['data']->level == 'admin'){ ?>
            <a class="nav-item text-white nav-link ps-3" href="pengaduan">Pengaduan</a>
            <a class="nav-item text-white nav-link ps-3" href="print">Print Laporan</a>
            <a class="nav-item text-white nav-link ps-3" href="register?petugas">Register</a>
            <?php }} ?>
            <a class=" ps-5 nav-item text-white nav-link ml-5" href="logout">Logout</a>
        </div>
    </nav>
