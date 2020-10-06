<?php
include "configurasi/koneksi.php";
 
echo "<li><a href='media.php?module=siswa&act=detailprofilsiswa&id=$_SESSION[idsiswa]'><b>Edit Profil</b></a></li>";
echo "<li><a href='media.php?module=siswa&act=detailaccount'><b>Edit Username & Password</b></a></li>";
?>
