<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include "configurasi/koneksi.php";

session_start();
error_reporting(0);

if (empty($_SESSION['username']) AND empty($_SESSION['passuser']) AND $_SESSION['login']==0){
  echo "<link href='css/screen.css' rel='stylesheet' type='text/css'><link href='css/reset.css' rel='stylesheet' type='text/css'>


 <center><br><br><br><br><br><br>Maaf, untuk masuk <b>Halaman</b><br>
  <center>anda harus <b>Login</b> dahulu!<br><br>";
 echo "<div> <a href='index.php'><img src='images/kunci.png'  height=176 width=143></a>
             </div>";
  echo "<input type=button class=simplebtn value='LOGIN DI SINI' onclick=location.href='index.php'></a></center>";
}
else{
        $siswa = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa WHERE id_siswa = '$_SESSION[idsiswa]'");
        $data_siswa = mysqli_fetch_array($siswa);
        $mapel = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mata_pelajaran WHERE id_kelas = '$data_siswa[id_kelas]'");
        $cek_mapel = mysqli_num_rows($mapel);
        if (!empty($cek_mapel)){
            echo"<br><b class='judul'>Lihat Nilai</b><br><p class='garisbawah'></p>
            <table>
            <tr><th>No</th><th>Mata Pelajaran</th><th>Aksi</th></tr>";
            $no=1;
            while ($t=mysqli_fetch_array($mapel)){
                echo "<tr><td>$no</td>
                        <td>$t[nama]</td>";

                        echo"<td><input type=button class='tombol' value='Lihat Nilai'
                       onclick=\"window.location.href='?module=quiz&act=daftarnilai&id=$t[id_matapelajaran]&id_kelas=$data_siswa[id_kelas]';\"></td></tr>";
            $no++;
            }
            echo"</table>";
        }else{
            echo "<script>window.alert('Belum ada mata pelajaran di kelas anda.');
                    window.location=(href='media.php?module=home')</script>";
        }
    
}
?>
