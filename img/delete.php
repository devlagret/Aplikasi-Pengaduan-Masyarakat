<?php
$root = $_SERVER["DOCUMENT_ROOT"];
if(isset($_GET['id'])){
    unlink($root.'\ukk-native\img\\'.$_GET['id']);
}
function hapus($name=null)
{
    $root = $_SERVER["DOCUMENT_ROOT"];
    return unlink($root.'\ukk-native\img\\'.$name);
}