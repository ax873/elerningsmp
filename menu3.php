<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
?>



<?php

$bataswaktu       = time("U") - 300;
$user = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM online WHERE online ='Y'");
while ($r=mysqli_fetch_array($user)){
    $siswa = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa WHERE id_siswa = '$r[id_siswa]'");
    $s = mysqli_fetch_array($siswa);
    if ($s[id_siswa] != $_SESSION[idsiswa]){
    if (!empty($s[foto])){       
        echo "<a href='javascript:void(0)' onclick='javascript:chatWith($s[nama_lengkap])'><img src='foto_siswa/small_$s[foto]' title='$s[nama_lengkap]'></a><br>";
    }
    else{
        echo "<a href='javascript:void(0)' onclick='javascript:chatWith($s[nama_lengkap])'><img src='foto_siswa/foto_kosong.png' title='$s[nama_lengkap]'></a><br>";
    }
    }
    else{
       if (!empty($s[foto])){
        echo "<img src='foto_siswa/small_$s[foto]' title='$s[nama_lengkap]'><br>";
        }
        else{
            echo "<img src='foto_siswa/foto_kosong.png' title='$s[nama_lengkap]'><br>";
        }
    }
    
}
?>
