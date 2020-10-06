<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
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

// Input mapel
if ($module=='registrasi' AND $act=='hapus'){
   mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM registrasi_siswa WHERE id_registrasi='$_GET[id]'");
   header('location:../../media_admin.php?module='.$module);
}

elseif ($module=='registrasi' AND $act=='terima'){
    $registrasi = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM registrasi_siswa WHERE id_registrasi = '$_GET[id]'");
    $r=mysqli_fetch_array($registrasi);
    $pass = md5($r[nis]);
    mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO siswa(nis,nama_lengkap,username_login,password_login,id_kelas,alamat,tempat_lahir,
                                    tgl_lahir,jenis_kelamin,agama,nama_ayah,nama_ibu,th_masuk,email)
                             VALUES('$r[nis]','$r[nama_lengkap]','$r[nis]','$pass','$r[id_kelas]','$r[alamat]','$r[tempat_lahir]',
                                     '$r[tgl_lahir]','$r[jenis_kelamin]','$r[agama]','$r[nama_ayah]','$r[nama_ibu]','$r[th_masuk]',
                                     '$r[email]')");
    mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM registrasi_siswa WHERE id_registrasi = '$_GET[id]'");
    header('location:../../media_admin.php?module='.$module);
	
	

}

}
?>
