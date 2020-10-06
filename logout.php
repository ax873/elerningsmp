<?php
  include "configurasi/koneksi.php";
  session_start();
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE online SET online='T' WHERE id_siswa = '$_SESSION[idsiswa]'");
  session_destroy();
  header ('location:index.php');
?>
