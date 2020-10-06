<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../../configurasi/koneksi.php";

$module=$_GET[module];
$act=$_GET[act];

// Input kelas
if ($module=='kelas' AND $act=='input_kelas'){
  mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO kelas(id_kelas,
                                 nama,
                                 id_pengajar,
                                 id_siswa)
	                       VALUES('$_POST[id_kelas]',
                                '$_POST[nama]',
                                '$_POST[id_pengajar]',
                                '$_POST[id_siswa]')");
  header('location:../../media_admin.php?module='.$module);
}

elseif ($module=='kelas' AND $act=='hapuskelas'){
  mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM kelas WHERE id = '$_GET[id]'");
  header('location:../../media_admin.php?module='.$module);
}

elseif ($module=='kelas' AND $act=='hapuswalikelas'){
  $kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa WHERE id_kelas = '$_GET[id]'");
  $r = mysqli_fetch_array($kelas);

  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE siswa SET jabatan = 'Siswa'
                                WHERE id_siswa = '$r[id_siswa]'");
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE kelas SET id_pengajar  = '0',
                                id_siswa  = '0'
                        WHERE id = '$_GET[id]'");
  header('location:../../media_admin.php?module='.$module);
}

elseif ($module=='kelas' AND $act=='update_kelas'){
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE kelas SET id_kelas = '$_POST[id_kelas]',
                                nama = '$_POST[nama]',
                                id_pengajar  = '$_POST[id_pengajar]',
                                id_siswa  = '$_POST[id_siswa]'
                        WHERE id = '$_POST[id]'");
  header('location:../../media_admin.php?module='.$module);
}
elseif ($module=='kelas' AND $act=='input_walikelas'){
  $cari = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas = '$_POST[kelas]'");
  $r = mysqli_fetch_array($cari);
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE kelas SET id_pengajar  = '$_SESSION[idpengajar]',
                                id_siswa  = '$_POST[ketua]'
                        WHERE id = '$r[id]'");
  mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE siswa SET jabatan = 'Ketua Kelas'
                                WHERE id_siswa = '$_POST[ketua]'");
  header('location:../../media_admin.php?module=home');
}

elseif ($module=='kelas' AND $act=='update_walikelas'){
  $cek = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id = '$_POST[id]'");
  $c = mysqli_fetch_array($cek);
  $cek_siswa = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_siswa FROM kelas WHERE id = '$_POST[id]'");
  $s=mysqli_num_rows($cek_siswa);
  $cari = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas = '$_POST[kelas]'");
  $r = mysqli_fetch_array($cari);

  if ($_POST['kelas']==$c[id_kelas]){

    if(!empty($s)){
         mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE siswa SET jabatan = 'siswa'
                                WHERE id_siswa = '$c[id_siswa]'");
         mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE kelas SET id_siswa  = '$_POST[ketua]'
                        WHERE id = '$_POST[id]'");
         mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE siswa SET jabatan = 'Ketua Kelas'
                                WHERE id_siswa = '$_POST[ketua]'");
    }else{
        mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE kelas SET id_siswa  = '$_POST[ketua]'
                        WHERE id = '$_POST[id]'");
    }
  }else{
      if (!empty($s)){
      mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE siswa SET jabatan = 'siswa'
                                WHERE id_siswa = '$c[id_siswa]'");
      mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE kelas SET id_pengajar  = '0',
                                id_siswa  = '0'
                        WHERE id = '$_POST[id]'");

      mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE kelas SET id_pengajar  = '$_SESSION[idpengajar]',
                                id_siswa  = '$_POST[ketua]'
                        WHERE id = '$r[id]'");
      mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE siswa SET jabatan = 'Ketua Kelas'
                                WHERE id_siswa = '$_POST[ketua]'");
      }else{
          mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE kelas SET id_pengajar  = '0',
                                id_siswa  = '0'
                        WHERE id = '$_POST[id]'");

          mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE kelas SET id_pengajar  = '$_SESSION[idpengajar]',
                                id_siswa  = '$_POST[ketua]'
                        WHERE id = '$r[id]'");
          mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE siswa SET jabatan = 'Ketua Kelas'
                                WHERE id_siswa = '$_POST[ketua]'");
      }
  }
  header('location:../../media_admin.php?module='.$module);
}

elseif ($module=='kelas' AND $act=='update_kelas_siswa'){
    mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE siswa SET id_kelas         = '$_POST[id_kelas]'
                                WHERE  id_siswa    = '$_SESSION[idsiswa]'");

header('location:../../../media.php?module=kelas');
}

}
?>
