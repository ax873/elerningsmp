<script>
function confirmdelete(delUrl) {
if (confirm("Anda yakin ingin menghapus?")) {
document.location = delUrl;
}
}
</script>

<script language="JavaScript" type="text/JavaScript">

 function showpel()
 {
 <?php

 // membaca semua kelas
 $query = "SELECT * FROM kelas";
 $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $query);

 // membuat if untuk masing-masing pilihan kelas beserta isi option untuk combobox kedua
 while ($data = mysqli_fetch_array($hasil))
 {
   $idkelas = $data['id_kelas'];

   // membuat IF untuk masing-masing kelas
   echo "if (document.form_topik.id_kelas.value == \"".$idkelas."\")";
   echo "{";

   // membuat option mata pelajaran untuk masing-masing kelas
   $query2 = "SELECT * FROM mata_pelajaran WHERE id_kelas = '$idkelas'";
   $hasil2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2);
   $content = "document.getElementById('pelajaran').innerHTML = \"<select name='".id_matapelajaran."'>";
   while ($data2 = mysqli_fetch_array($hasil2))
   {
       $content .= "<option value='".$data2['id_matapelajaran']."'>".$data2['nama']."</option>";
   }
   $content .= "</select>\";";
   echo $content;
   echo "}\n";
 }

 ?>
 }

 function showpel_pengajar()
 {
 <?php

 // membaca semua kelas
 $query = "SELECT * FROM kelas";
 $hasil = mysqli_query($GLOBALS["___mysqli_ston"], $query);

 // membuat if untuk masing-masing pilihan kelas beserta isi option untuk combobox kedua
 while ($data = mysqli_fetch_array($hasil))
 {
   $idkelas = $data['id_kelas'];

   // membuat IF untuk masing-masing kelas
   echo "if (document.form_topik.id_kelas.value == \"".$idkelas."\")";
   echo "{";

   // membuat option mata pelajaran untuk masing-masing kelas
   $query2 = "SELECT * FROM mata_pelajaran WHERE id_kelas = '$idkelas' AND id_pengajar ='$_SESSION[idpengajar]'";
   $hasil2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2);
   $content = "document.getElementById('pelajaran').innerHTML = \"<select name='".id_matapelajaran."'>";
   while ($data2 = mysqli_fetch_array($hasil2))
   {
       $content .= "<option value='".$data2['id_matapelajaran']."'>".$data2['nama']."</option>";
   }
   $content .= "</select>\";";
   echo $content;
   echo "}\n";
 }

 ?>
 }
</script>

<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
   echo "<link href=../css/style.css rel=stylesheet type=text/css>";
   echo "<div class='error msg'>Untuk mengakses Modul anda harus login.</div>";
}
else{

$aksi="modul/mod_quiz/aksi_quiz.php";
include "../../../configurasi/class_paging.php";

switch($_GET[act]){
  // Tampil topik quiz
  default:
      
      if ($_SESSION[leveluser]=='admin'){    
        echo "<h2>Manajemen Tugas/Quiz</h2><hr>
          <input type=button class='button blue' value='Tambah Topik' onclick=\"window.location.href='?module=quiz&act=tambahtopikquiz';\">";

        echo "<br><br><table id='table1' class='gtable sortable'><thead>
          <tr><th>no</th><th>judul</th><th>kelas</th><th>pelajaran</th><th>tgl buat</th><th>pembuat</th><th>waktu</th><th>Info</th><th>terbit</th><th>aksi</th></tr></thead>";
        
        $tampil_topik = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM topik_quiz ORDER BY id_kelas");
        
    $no=1;
    while ($r=mysqli_fetch_array($tampil_topik)){
      $wpengerjaan = $r[waktu_pengerjaan] / 60;
      $tgl_buat   = tgl_indo($r[tgl_buat]);
       echo "<tr><td>$no</td>
             <td>$r[judul]</td>";
             $kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas = '$r[id_kelas]'");
             $cek_kelas = mysqli_num_rows($kelas);
             if(!empty($cek_kelas)){
             while($k=mysqli_fetch_array($kelas)){
                 echo "<td><a href=?module=kelas&act=detailkelas&id=$r[id_kelas] title='Detail Kelas'>$k[nama]</td>";
             }
             }else{
                 echo"<td></td>";
             }
             $pelajaran = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$r[id_matapelajaran]'");
             $cek_pelajaran = mysqli_num_rows($pelajaran);
             if(!empty($cek_pelajaran)){
             $p=mysqli_fetch_array($pelajaran);
             echo "<td><a href=?module=matapelajaran&act=detailpelajaran&id=$r[id_matapelajaran] title='Detail pelajaran'>$p[nama]</a></td>";
             }else{
                 echo"<td></td>";
             }
             echo"<td>$tgl_buat</td>";
             $pelajaran2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$r[id_matapelajaran]'");
             $p2=mysqli_fetch_array($pelajaran2);
             $pembuat = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM pengajar WHERE id_pengajar = '$p2[id_pengajar]'");
             $cek_pembuat = mysqli_num_rows($pembuat);
             if (!empty($cek_pembuat)){
                 $data_pembuat = mysqli_fetch_array($pembuat);
                 echo "<td><a href=?module=admin&act=detailpengajar&id=$data_pembuat[id_pengajar] title='Detail pengajar'>$data_pembuat[nama_lengkap]</a></td>";
             }else{                 
                 echo"<td>$r[pembuat]</td>";
             }
             echo"<td>$wpengerjaan menit</td>
             <td>$r[info]</td>
             <td><p align='center'>$r[terbit]</p></td>
             <td><ul><li><a href='?module=quiz&act=edittopikquiz&id=$r[id_tq]' title='Edit'><img src='images/icons/edit.png' alt='Edit' /></a> | 
                 <a href=javascript:confirmdelete('$aksi?module=quiz&act=hapustopikquiz&id=$r[id_tq]') title='Hapus'><img src='images/icons/cross.png' alt='Delete' /></a></li>
                 <li><a href=?module=buatquiz&act=buatquiz&id=$r[id_tq]>Buat Quiz</a></li>
                 <li><a href=?module=daftarquiz&act=daftarquiz&id=$r[id_tq]>Daftar Quiz</a></li>
                 <li><a href=?module=quiz&act=daftarsiswayangtelahmengerjakan&id=$r[id_tq]>Daftar Peserta & Koreksi</a></li></ul></td></tr>";
      $no++;
    }
    echo "</table>";
    
    }    
    elseif ($_SESSION[leveluser]=='pengajar'){
    $tampil_topik = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM topik_quiz WHERE pembuat = '$_SESSION[idpengajar]'");
        echo "<h2>Daftar Topik Quiz</h2><hr>
          <input class='button blue' type=button value='Tambah Topik' onclick=\"window.location.href='?module=quiz&act=tambahtopikquiz';\">";
        echo "<br><br><table id='table1' class='gtable sortable'><thead>
          <tr><th>No</th><th>Judul</th><th>Kelas</th><th>Pelajaran</th><th>Tgl Buat</th><th>Lama Pengerjaan</th><th>Info</th><th>Terbit</th><th>Aksi</th></tr></thead>";
        
        
        $no=1;
        while ($r=mysqli_fetch_array($tampil_topik)){
        $wpengerjaan = $r[waktu_pengerjaan] / 60;
        $tgl_buat   = tgl_indo($r[tgl_buat]);
        echo "<tr><td>$no</td>
             <td>$r[judul]</td>";
             $kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas = '$r[id_kelas]'");
             $cek_kelas = mysqli_num_rows($kelas);
             if(!empty($cek_kelas)){
             while($k=mysqli_fetch_array($kelas)){
                 echo "<td><a href=?module=kelas&act=detailkelas&id=$r[id_kelas] title='Detail Kelas'>$k[nama]</td>";
             }
             }else{
                 echo "<td></td>";
             }
             $pelajaran = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$r[id_matapelajaran]'");
             $cek_pelajaran = mysqli_num_rows($pelajaran);
             if(!empty($cek_pelajaran)){
             while($p=mysqli_fetch_array($pelajaran)){
             echo "<td><a href=?module=matapelajaran&act=detailpelajaran&id=$r[id_matapelajaran] title='Detail pelajaran'>$p[nama]</a></td>";
             }
             }else{
                 echo "<td></td>";
             }
             echo "<td>$tgl_buat</td>
             <td>$wpengerjaan menit</td>
             <td>$r[info]</td>
             <td><p align='center'>$r[terbit]</p></td>
             <td><a href='?module=quiz&act=edittopikquiz&id=$r[id_tq]' title='Edit'><img src='images/icons/edit.png' alt='Edit' /> | 
                         <a href=javascript:confirmdelete('$aksi?module=quiz&act=hapustopikquiz&id=$r[id_tq]') title='Hapus'><img src='images/icons/cross.png' alt='Delete' /></a><br><br>
                 <input type=button class='button small white' value='Buat Quiz' onclick=\"window.location.href='?module=buatquiz&act=buatquiz&id=$r[id_tq]';\"></input><br>
                <input type=button class='button small white' value='Daftar Quiz' onclick=\"window.location.href='?module=daftarquiz&act=daftarquiz&id=$r[id_tq]';\"></input><br>
                <input type=button class='button small white' value='Peserta & koreksi' onclick=\"window.location.href='?module=quiz&act=daftarsiswayangtelahmengerjakan&id=$r[id_tq]';\"></input></td></tr>";
      $no++;
    }
    echo "</table>";      
    }
    elseif ($_SESSION[leveluser]=='siswa'){
        $siswa = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa WHERE id_siswa = '$_SESSION[idsiswa]'");
        $data_siswa = mysqli_fetch_array($siswa);
        $mapel = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mata_pelajaran WHERE id_kelas = '$data_siswa[id_kelas]'");
        $cek_mapel = mysqli_num_rows($mapel);        
        if (!empty($cek_mapel)){
            echo"<br><b class='judul'>Tugas / Quiz</b><br><p class='garisbawah'></p>
            <table>
            <tr><th>No</th><th>Mata Pelajaran</th><th>Aksi</th></tr>";
            $no=1;
            while ($t=mysqli_fetch_array($mapel)){                
                echo "<tr><td>$no</td>
                        <td>$t[nama]</td>";                   
                        
                        echo"<td><input type=button class='tombol' value='Lihat Tugas / Quiz'
                       onclick=\"window.location.href='?module=quiz&act=daftartopik&id=$t[id_matapelajaran]&id_kelas=$data_siswa[id_kelas]';\"></td></tr>";
            $no++;
            }
            echo"</table>";
        }else{
            echo "<script>window.alert('Belum ada mata pelajaran di kelas anda.');
                    window.location=(href='media.php?module=home')</script>";
        }
    }
    break;


case "daftarsiswayangtelahmengerjakan":
    if ($_SESSION[leveluser]=='admin'){
        $siswa_yangmengerjakan = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa_sudah_mengerjakan WHERE id_tq = '$_GET[id]'");
        $cek_siswa = mysqli_num_rows($siswa_yangmengerjakan);

        if (!empty($cek_siswa)){
        echo "<h3>Daftar Siswa Yang Telah Mengikuti Ujian</h3><hr>";
        echo "<br><div class='information msg'>
         Pilih Aksi <b>Hapus Siswa</b> jika ingin mereset Siswa yang telah mengikuti ujian.<br>
        Hanya jawaban soal Essay yang bisa di koreksi.<br>
        Penilaian Soal Pilihan Ganda Sistem yang mengerjakan.</div>";

        $siswa_yangmengerjakan2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa_sudah_mengerjakan WHERE id_tq = '$_GET[id]'");
        echo "<br><table id='table1' class='gtable sortable'><thead>
          <tr><th>No</th><th>Nama</th><th>Kelas</th><th>Status</th><th>aksi</th></tr></thead>";
        
        $no=1;
        while ($t=mysqli_fetch_array($siswa_yangmengerjakan2)){
            $siswa = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa WHERE id_siswa = '$t[id_siswa]'");
            $s = mysqli_fetch_array($siswa);
            $kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas = '$s[id_kelas]'");
            $k = mysqli_fetch_array($kelas);
            $nilai = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM nilai_soal_esay WHERE id_tq='$_GET[id]' AND id_siswa ='$t[id_siswa]'");
            $n = mysqli_fetch_array($nilai);
            $nilai2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM nilai WHERE id_tq='$_GET[id]' AND id_siswa = '$t[id_siswa]'");
            $n2 = mysqli_fetch_array($nilai2);
            echo "<tr><td>$no</td>                      
                      <td><a href=?module=siswa&act=detailsiswa&id=$s[id_siswa] title='Detail siswa'>$s[nama_lengkap]</a></td>
                      <td>$k[nama]</td>";
                      if ($t[dikoreksi]=='B'){
                          echo "<td>Jawaban soal essay <b>belum di koreksi</b>
                                    <br>Nilai Tugas/Quiz Pilihan Ganda : $n2[persentase]</td>";
                          echo "
                          <td><a href=$aksi?module=quiz&act=editsiswayangtelahmengerjakan&id=$t[id]&id_siswa=$s[id_siswa]&id_tq=$_GET[id]>Hapus Siswa</a> |
                          <a href=?module=quiz&act=koreksi&id=$t[id_tq]&id_siswa=$s[id_siswa]>Koreksi Jawaban Esay</a></td></tr>";
                      }else{
                          echo "<td>Jawaban soal essay <b>sudah di koreksi</b><br>Nilai Tugas/Quiz Pilihan Ganda : $n2[persentase]<br>
                                                         Nilai Tugas/Quiz Essay: $n[nilai]</td>";
                          echo "
                          <td><a href=$aksi?module=quiz&act=editsiswayangtelahmengerjakan&id=$t[id]&id_siswa=$s[id_siswa]&id_tq=$_GET[id]>Hapus Siswa</a> |
                          <a href=?module=quiz&act=editkoreksi&id=$t[id_tq]&id_siswa=$s[id_siswa]>Edit Koreksi</a></td></tr>";
                      }
                      
            $no++;
        }
        echo "</table>";
        echo "<br><input class='button blue' type=button value=Kembali onclick=\"window.location.href='?module=quiz';\">";
        
        }else{
            echo "<script>window.alert('Belum ada siswa yang mengikuti ujian.');
                    window.location=(href='media_admin.php?module=quiz')</script>";
        }
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
        $siswa_yangmengerjakan = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT id_siswa FROM siswa_sudah_mengerjakan WHERE id_tq = '$_GET[id]'");
        $cek_siswa = mysqli_num_rows($siswa_yangmengerjakan);

        if (!empty($cek_siswa)){

        $soal_pilganda = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_pilganda WHERE id_tq='$_GET[id]'");
        $pilganda = mysqli_num_rows($soal_pilganda);
        $soal_esay = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_esay WHERE id_tq='$_GET[id]'");
        $esay = mysqli_num_rows($soal_esay);
        if (!empty($pilganda) AND !empty($esay)){
        echo "<form><fieldset>
              <legend>siswa yang telah mengikuti ujian</legend>
              <dl class='inline'>";
         echo "<br><div class='information msg'>
        Pilih Aksi <b>Hapus Siswa</b> jika ingin mereset Siswa yang telah mengikuti ujian.<br>
        Hanya jawaban soal Essay yang bisa di koreksi.<br>
        Penilaian Soal Pilihan Ganda Sistem yang mengerjakan.</div>";

        $siswa_yangmengerjakan2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa_sudah_mengerjakan WHERE id_tq = '$_GET[id]'");
        echo "<br><table id='table1' class='gtable sortable'><thead>
          <tr><th>No</th><th>Nis</th><th>Nama</th><th>Kelas</th><th>Status</th><th>Aksi</th></tr></thead>";
        $no=1;
        while ($t=mysqli_fetch_array($siswa_yangmengerjakan2)){
            $siswa = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa WHERE id_siswa = '$t[id_siswa]'");
            $s = mysqli_fetch_array($siswa);
            $kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas = '$s[id_kelas]'");
            $k = mysqli_fetch_array($kelas);
            $nilai = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM nilai_soal_esay WHERE id_tq='$_GET[id]' AND id_siswa ='$t[id_siswa]'");
            $n = mysqli_fetch_array($nilai);
            $nilai2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM nilai WHERE id_tq='$_GET[id]' AND id_siswa = '$t[id_siswa]'");
            $n2 = mysqli_fetch_array($nilai2);
            echo "<tr><td>$no</td>
                      <td>$s[nis]</td>
                      <td><a href=?module=siswa&act=detailsiswa&id=$s[id_siswa] title='Detail siswa'>$s[nama_lengkap]</a></td>
                      <td>$k[nama]</td>";
                      if ($t[dikoreksi]=='B'){
                          echo "<td>Jawaban soal essay <b>belum di koreksi</b>
                                    <br>Nilai Tugas/Quiz Pilihan Ganda : $n2[persentase]</td>";
                          echo "
                          <td><a href=$aksi?module=quiz&act=editsiswayangtelahmengerjakan&id=$t[id]&id_siswa=$s[id_siswa]&id_tq=$_GET[id]>Hapus Siswa</a> |
                          <a href=?module=quiz&act=koreksi&id=$t[id_tq]&id_siswa=$s[id_siswa]>Koreksi Jawaban Esay</a></td></tr>";
                      }else{
                          echo "<td>Jawaban soal essay <b>sudah di koreksi</b><br>Nilai Tugas/Quiz Pilihan Ganda : $n2[persentase]<br>
                                                         Nilai Tugas/Quiz Essay: $n[nilai]</td>";
                          echo "
                          <td><a href=javascript:confirmdelete('$aksi?module=quiz&act=editsiswayangtelahmengerjakan&id=$t[id]&id_siswa=$s[id_siswa]&id_tq=$_GET[id]')>Hapus Siswa</a> |
                          <a href=?module=quiz&act=editkoreksi&id=$t[id_tq]&id_siswa=$s[id_siswa]>Edit Koreksi</a></td></tr>";
                      }
            $no++;
        }
        echo "</table>
              <br><input class='button blue' type=button value=Kembali onclick=self.history.back()>";
        }
        elseif (empty($pilganda) AND !empty($esay)){
         echo"<form><fieldset>
              <legend>siswa yang telah mengikuti ujian</legend>
              <dl class='inline'>";
         echo "<br><div class='information msg'>
        Pilih Aksi <b>Hapus Siswa</b> jika ingin mereset Siswa yang telah mengikuti ujian.<br>
        Hanya jawaban soal Essay yang bisa di koreksi.<br>
        Penilaian Soal Pilihan Ganda Sistem yang mengerjakan.</div>";

        $siswa_yangmengerjakan2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa_sudah_mengerjakan WHERE id_tq = '$_GET[id]'");
        echo "<br><table id='table1' class='gtable sortable'><thead>
          <tr><th>No</th><th>Nis</th><th>Nama</th><th>Kelas</th><th>Status</th><th>Aksi</th></tr></thead>";
        $no=1;
        while ($t=mysqli_fetch_array($siswa_yangmengerjakan2)){
            $siswa = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa WHERE id_siswa = '$t[id_siswa]'");
            $s = mysqli_fetch_array($siswa);
            $kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas = '$s[id_kelas]'");
            $k = mysqli_fetch_array($kelas);
            $nilai = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM nilai_soal_esay WHERE id_tq='$_GET[id]' AND id_siswa ='$t[id_siswa]'");
            $n = mysqli_fetch_array($nilai);
            echo "<tr><td>$no</td>
                      <td>$s[nis]</td>
                      <td><a href=?module=siswa&act=detailsiswa&id=$s[id_siswa] title='Detail siswa'>$s[nama_lengkap]</a></td>
                      <td>$k[nama]</td>";
                      if ($t[dikoreksi]=='B'){
                          echo "<td>Jawaban soal essay <b>belum di koreksi</b></td>";
                          echo "
                          <td><a href=$aksi?module=quiz&act=editsiswayangtelahmengerjakan&id=$t[id]&id_siswa=$s[id_siswa]&id_tq=$_GET[id]>Hapus Siswa</a> |
                          <a href=?module=quiz&act=koreksi&id=$t[id_tq]&id_siswa=$s[id_siswa]>Koreksi Jawaban Esay</a></td></tr>";
                      }else{
                          echo "<td>Jawaban soal essay <b>sudah di koreksi</b><br>Nilai Tugas/Quiz Essay: $n[nilai]</td>";
                          echo "
                          <td><a href=$aksi?module=quiz&act=editsiswayangtelahmengerjakan&id=$t[id]&id_siswa=$s[id_siswa]&id_tq=$_GET[id]>Hapus Siswa</a> |
                          <a href=?module=quiz&act=editkoreksi&id=$t[id_tq]&id_siswa=$s[id_siswa]>Edit Koreksi</a></td></tr>";
                      }
            $no++;
        }
        echo "</table>
        <br><input class='button blue' type=button value=Kembali onclick=self.history.back()>";
        }
        elseif (!empty($pilganda) AND empty($esay)){
         echo "<form><fieldset>
              <legend>siswa yang telah mengikuti ujian</legend>
              <dl class='inline'>";
         echo "<br><div class='information msg'>
        Pilih Aksi <b>Hapus Siswa</b> jika ingin mereset Siswa yang telah mengikuti ujian.<br>
        Hanya jawaban soal Essay yang bisa di koreksi.<br>
        Penilaian Soal Pilihan Ganda Sistem yang mengerjakan.</div>";


        $siswa_yangmengerjakan2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa_sudah_mengerjakan WHERE id_tq = '$_GET[id]'");
        echo "<br><table id='table1' class='gtable sortable'><thead>
          <tr><th>No</th><th>Nis</th><th>Nama</th><th>Kelas</th><th>Status</th><th>Aksi</th></tr></thead>";
        $no=1;
        while ($t=mysqli_fetch_array($siswa_yangmengerjakan2)){
            $siswa = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa WHERE id_siswa = '$t[id_siswa]'");
            $s = mysqli_fetch_array($siswa);
            $kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas = '$s[id_kelas]'");
            $k = mysqli_fetch_array($kelas);
            $nilai = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM nilai_soal_esay WHERE id_tq='$_GET[id]' AND id_siswa ='$t[id_siswa]'");
            $n = mysqli_fetch_array($nilai);
            $nilai2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM nilai WHERE id_tq='$_GET[id]' AND id_siswa = '$t[id_siswa]'");
            $n2 = mysqli_fetch_array($nilai2);
            echo "<tr><td>$no</td>
                      <td>$s[nis]</td>
                      <td><a href=?module=siswa&act=detailsiswa&id=$s[id_siswa] title='Detail siswa'>$s[nama_lengkap]</a></td>
                      <td>$k[nama]</td>";
                      if ($t[dikoreksi]=='B'){
                          echo "<td>Nilai Tugas/Quiz Pilihan Ganda : $n2[persentase]</td>";
                          echo "
                          <td><a href=$aksi?module=quiz&act=editsiswayangtelahmengerjakan&id=$t[id]&id_siswa=$s[id_siswa]&id_tq=$_GET[id]>Hapus Siswa</a>
                          </td></tr>";
                      }else{
                          echo "<td>Nilai Tugas/Quiz Pilihan Ganda : $n2[persentase]</td>";
                          echo "
                          <td><a href=$aksi?module=quiz&act=editsiswayangtelahmengerjakan&id=$t[id]&id_siswa=$s[id_siswa]&id_tq=$_GET[id]>Hapus Siswa</a>
                          </td></tr>";
                      }
            $no++;
        }
        echo "</table>
              <br><input class='button blue' type=button value=Kembali onclick=self.history.back()>";
        }
        elseif (empty($pilganda) AND empty($esay)){
            echo "<script>window.alert('Tidak Ada Soal.');
                    window.location=(href='media_admin.php?module=quiz')</script>";
        }
        }else{
            echo "<script>window.alert('Belum ada siswa yang mengikuti ujian.');
                    window.location=(href='media_admin.php?module=quiz')</script>";
        }
    }
    break;

case "koreksi":
    if ($_SESSION[leveluser]=='admin'){
        $cek = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa_sudah_mengerjakan WHERE id_siswa='$_GET[id_siswa]'");
        $c = mysqli_fetch_array($cek);
        if ($c[dikoreksi]=='B'){
        $soal_pilganda = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_pilganda WHERE id_tq='$_GET[id]'");
        $pilganda = mysqli_num_rows($soal_pilganda);
        $soal_esay = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_esay WHERE id_tq='$_GET[id]'");
        $esay = mysqli_num_rows($soal_esay);
        if (!empty($pilganda) AND !empty($esay)){
            $siswa = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa WHERE id_siswa='$_GET[id_siswa]'");
            $s = mysqli_fetch_array($siswa);
            $jawaban = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM jawaban WHERE id_tq='$_GET[id]' AND id_siswa='$_GET[id_siswa]'");
            $cek=mysqli_num_rows($jawaban);
            if (!empty($cek)){
                echo "<h2>Jawaban Soal Essay Siswa <b>$s[nama_lengkap]</b></h2><hr>";
                $no=1;
                while ($j=mysqli_fetch_array($jawaban)){
                    $soal_esay2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_esay WHERE id_tq='$j[id_tq]' AND id_quiz='$j[id_quiz]'");
                    $quiz = mysqli_fetch_array($soal_esay2);
                    echo "<table id='table1' class='gtable sortable'>
                          <form method=POST action='?module=quiz&act=hasilkoreksi'>";
                            if (!empty($quiz[gambar])){
                            echo "<tr><td rowspan=7><b>$no.</b></td><td><b>Pertanyaan :</b></td></tr>
                                  <tr><td>$quiz[pertanyaan]</td></tr>
                                  <tr><td><img src='../foto_soal/medium_$quiz[gambar]'></td></tr>
                                  <tr><td><b>Jawaban:</b></td></tr>
                                  <tr><td>$j[jawaban]</td></tr>
                                  <tr><td><b>Nilai:</b></td></tr>
                                  <tr><td><input type=radio name='nilai".$no."' value='10'>10</input>
                                          <input type=radio name='nilai".$no."' value='20'>20</input>
                                          <input type=radio name='nilai".$no."' value='30'>30</input>
                                          <input type=radio name='nilai".$no."' value='40'>40</input>
                                          <input type=radio name='nilai".$no."' value='50'>50</input>
                                          <input type=radio name='nilai".$no."' value='60'>60</input>
                                          <input type=radio name='nilai".$no."' value='70'>70</input>
                                          <input type=radio name='nilai".$no."' value='80'>80</input>
                                          <input type=radio name='nilai".$no."' value='90'>90</input>
                                          <input type=radio name='nilai".$no."' value='100'>100</input></td></tr>
                                  <input type=hidden name='jawab".$no."' value='$j[jawaban]'>
                                  </table>";

                            }
                            else{
                                echo "<tr><td rowspan=6><b>$no.</b></td><td><b>Pertanyaan :</b></td></tr>
                                  <tr><td>$quiz[pertanyaan]</td></tr>
                                  <tr><td><b>Jawaban:</b></td></tr>
                                  <tr><td>$j[jawaban]</td></tr>
                                  <tr><td><b>Nilai:</b></td></tr>
                                  <tr><td><input type=radio name='nilai".$no."' value='10'>10</input>
                                          <input type=radio name='nilai".$no."' value='20'>20</input>
                                          <input type=radio name='nilai".$no."' value='30'>30</input>
                                          <input type=radio name='nilai".$no."' value='40'>40</input>
                                          <input type=radio name='nilai".$no."' value='50'>50</input>
                                          <input type=radio name='nilai".$no."' value='60'>60</input>
                                          <input type=radio name='nilai".$no."' value='70'>70</input>
                                          <input type=radio name='nilai".$no."' value='80'>80</input>
                                          <input type=radio name='nilai".$no."' value='90'>90</input>
                                          <input type=radio name='nilai".$no."' value='100'>100</input></td></tr>
                                  <input type=hidden name='jawab".$no."' value='$j[jawaban]'>
                                  </table>";
                            }
                    $no++;                 
                }
                $jum = $no - 1;
                    echo "<input type=hidden name=jumlah_soal value='$jum'>
                          <input type=hidden name=id_topik value='$_GET[id]'>

                          <input type=hidden name=id_siswa value='$_GET[id_siswa]'>";
                echo "<br>
                          <input class='button blue' type=submit value=Simpan>
                          <input class='button blue' type=button value=Batal onclick=self.history.back()>";
            }else{
                 echo "<script>window.alert('Jawaban siswa kosong.');
                       window.location=(href='?module=quiz')</script>";
            }

        }
        elseif (empty($pilganda) AND !empty($esay)){
            $siswa = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa WHERE id_siswa='$_GET[id_siswa]'");
            $s = mysqli_fetch_array($siswa);
            $jawaban = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM jawaban WHERE id_tq='$_GET[id]' AND id_siswa='$_GET[id_siswa]'");
            $cek=mysqli_num_rows($jawaban);
            if (!empty($cek)){
                echo "<h2>Jawaban Soal Essay Siswa <b>$s[nama_lengkap]</b></h2>";
                $no=1;
                while ($j=mysqli_fetch_array($jawaban)){
                    $soal_esay2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_esay WHERE id_tq='$j[id_tq]' AND id_quiz='$j[id_quiz]'");
                    $quiz = mysqli_fetch_array($soal_esay2);
                    echo "<table id='table1' class='gtable sortable'>
                          <form method=POST action='?module=quiz&act=hasilkoreksi'>";
                            if (!empty($quiz[gambar])){
                            echo "<tr><td rowspan=7><b>$no.</b></td><td><b>Pertanyaan :</b></td></tr>
                                  <tr><td>$quiz[pertanyaan]</td></tr>
                                  <tr><td><img src='../foto_soal/medium_$quiz[gambar]'></td></tr>
                                  <tr><td><b>Jawaban:</b></td></tr>
                                  <tr><td>$j[jawaban]</td></tr>
                                  <tr><td><b>Nilai:</b></td></tr>
                                  <tr><td><input type=radio name='nilai".$no."' value='10'>10</input>
                                          <input type=radio name='nilai".$no."' value='20'>20</input>
                                          <input type=radio name='nilai".$no."' value='30'>30</input>
                                          <input type=radio name='nilai".$no."' value='40'>40</input>
                                          <input type=radio name='nilai".$no."' value='50'>50</input>
                                          <input type=radio name='nilai".$no."' value='60'>60</input>
                                          <input type=radio name='nilai".$no."' value='70'>70</input>
                                          <input type=radio name='nilai".$no."' value='80'>80</input>
                                          <input type=radio name='nilai".$no."' value='90'>90</input>
                                          <input type=radio name='nilai".$no."' value='100'>100</input></td></tr>
                                  <input type=hidden name='jawab".$no."' value='$j[jawaban]'>
                                  </table>";

                            }
                            else{
                                echo "<tr><td rowspan=6><b>$no.</b></td><td><b>Pertanyaan :</b></td></tr>
                                  <tr><td>$quiz[pertanyaan]</td></tr>
                                  <tr><td><b>Jawaban:</b></td></tr>
                                  <tr><td>$j[jawaban]</td></tr>
                                  <tr><td><b>Nilai:</b></td></tr>
                                  <tr><td><input type=radio name='nilai".$no."' value='10'>10</input>
                                          <input type=radio name='nilai".$no."' value='20'>20</input>
                                          <input type=radio name='nilai".$no."' value='30'>30</input>
                                          <input type=radio name='nilai".$no."' value='40'>40</input>
                                          <input type=radio name='nilai".$no."' value='50'>50</input>
                                          <input type=radio name='nilai".$no."' value='60'>60</input>
                                          <input type=radio name='nilai".$no."' value='70'>70</input>
                                          <input type=radio name='nilai".$no."' value='80'>80</input>
                                          <input type=radio name='nilai".$no."' value='90'>90</input>
                                          <input type=radio name='nilai".$no."' value='100'>100</input></td></tr>
                                  <input type=hidden name='jawab".$no."' value='$j[jawaban]'>
                                  </table>";
                            }
                    $no++;
                }
                $jum = $no - 1;
                    echo "<input type=hidden name=jumlah_soal value='$jum'>
                          <input type=hidden name=id_topik value='$_GET[id]'>

                          <input type=hidden name=id_siswa value='$_GET[id_siswa]'>";
                echo "<br>
                          <input class='button blue' type=submit value=Simpan>
                          <input class='button blue' type=button value=Batal onclick=self.history.back()>";
            }
            else{
                 echo "<script>window.alert('Jawaban siswa kosong.');
                        window.location=(href='?module=quiz')</script>";
            }
        }
        elseif (!empty($pilganda) AND empty($esay)){
            echo "<script>window.alert('Soal hanya pilihan ganda, sudah di koreksi oleh system.');
            window.location=(href='?module=quiz')</script>";
        }
        elseif (empty($pilganda) AND empty($esay)){
            echo "<script>window.alert('Tidak ada soal pilihan ganda atau essay.');
            window.location=(href='?module=quiz')</script>";
        }
    }
    elseif ($c[dikoreksi]=='S'){
         echo "<script>window.alert('Sudah Di Koreksi');
         window.location=(href='?module=quiz')</script>";
    }
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
        $cek = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa_sudah_mengerjakan WHERE id_siswa='$_GET[id_siswa]'");
        $c = mysqli_fetch_array($cek);
        if ($c[dikoreksi]=='B'){
        $soal_pilganda = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_pilganda WHERE id_tq='$_GET[id]'");
        $pilganda = mysqli_num_rows($soal_pilganda);
        $soal_esay = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_esay WHERE id_tq='$_GET[id]'");
        $esay = mysqli_num_rows($soal_esay);
        if (!empty($pilganda) AND !empty($esay)){
            $siswa = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa WHERE id_siswa='$_GET[id_siswa]'");
            $s = mysqli_fetch_array($siswa);
            $jawaban = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM jawaban WHERE id_tq='$_GET[id]' AND id_siswa='$_GET[id_siswa]'");
            $cek=mysqli_num_rows($jawaban);
            if (!empty($cek)){
                echo "<h2>Jawaban Soal Essay Siswa <b>$s[nama_lengkap]</b></h2><hr>";
                $no=1;
                while ($j=mysqli_fetch_array($jawaban)){
                    $soal_esay2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_esay WHERE id_tq='$j[id_tq]' AND id_quiz='$j[id_quiz]'");
                    $quiz = mysqli_fetch_array($soal_esay2);
                    echo "<table id='table1' class='gtable sortable'>
                          <form method=POST action='?module=quiz&act=hasilkoreksi'>";
                            if (!empty($quiz[gambar])){
                            echo "<tr><td rowspan=7><b>$no.</b></td><td><b>Pertanyaan :</b></td></tr>
                                  <tr><td>$quiz[pertanyaan]</td></tr>
                                  <tr><td><img src='../foto_soal/medium_$quiz[gambar]'></td></tr>
                                  <tr><td><b>Jawaban:</b></td></tr>
                                  <tr><td>$j[jawaban]</td></tr>
                                  <tr><td><b>Nilai:</b></td></tr>
                                  <tr><td><input type=radio name='nilai".$no."' value='10'>10</input>
                                          <input type=radio name='nilai".$no."' value='20'>20</input>
                                          <input type=radio name='nilai".$no."' value='30'>30</input>
                                          <input type=radio name='nilai".$no."' value='40'>40</input>
                                          <input type=radio name='nilai".$no."' value='50'>50</input>
                                          <input type=radio name='nilai".$no."' value='60'>60</input>
                                          <input type=radio name='nilai".$no."' value='70'>70</input>
                                          <input type=radio name='nilai".$no."' value='80'>80</input>
                                          <input type=radio name='nilai".$no."' value='90'>90</input>
                                          <input type=radio name='nilai".$no."' value='100'>100</input></td></tr>
                                  <input type=hidden name='jawab".$no."' value='$j[jawaban]'>
                                  </table>";

                            }
                            else{
                                echo "<tr><td rowspan=6><b>$no.</b></td><td><b>Pertanyaan :</b></td></tr>
                                  <tr><td>$quiz[pertanyaan]</td></tr>
                                  <tr><td><b>Jawaban:</b></td></tr>
                                  <tr><td>$j[jawaban]</td></tr>
                                  <tr><td><b>Nilai:</b></td></tr>
                                  <tr><td><input type=radio name='nilai".$no."' value='10'>10</input>
                                          <input type=radio name='nilai".$no."' value='20'>20</input>
                                          <input type=radio name='nilai".$no."' value='30'>30</input>
                                          <input type=radio name='nilai".$no."' value='40'>40</input>
                                          <input type=radio name='nilai".$no."' value='50'>50</input>
                                          <input type=radio name='nilai".$no."' value='60'>60</input>
                                          <input type=radio name='nilai".$no."' value='70'>70</input>
                                          <input type=radio name='nilai".$no."' value='80'>80</input>
                                          <input type=radio name='nilai".$no."' value='90'>90</input>
                                          <input type=radio name='nilai".$no."' value='100'>100</input></td></tr>
                                  <input type=hidden name='jawab".$no."' value='$j[jawaban]'>
                                  </table>";
                            }
                    $no++;
                }
                $jum = $no - 1;
                    echo "<input type=hidden name=jumlah_soal value='$jum'>
                          <input type=hidden name=id_topik value='$_GET[id]'>

                          <input type=hidden name=id_siswa value='$_GET[id_siswa]'>";
                echo "<br>
                          <input class='button blue' type=submit value=Simpan>
                          <input class='button blue' type=button value=Batal onclick=self.history.back()>";
            }else{
                 echo "<script>window.alert('Jawaban siswa kosong.');
                       window.location=(href='?module=quiz')</script>";
            }

        }
        elseif (empty($pilganda) AND !empty($esay)){
            $siswa = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa WHERE id_siswa='$_GET[id_siswa]'");
            $s = mysqli_fetch_array($siswa);
            $jawaban = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM jawaban WHERE id_tq='$_GET[id]' AND id_siswa='$_GET[id_siswa]'");
            $cek=mysqli_num_rows($jawaban);
            if (!empty($cek)){
                echo "<h2>Jawaban Soal Essay Siswa <b>$s[nama_lengkap]</b></h2>";
                $no=1;
                while ($j=mysqli_fetch_array($jawaban)){
                    $soal_esay2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_esay WHERE id_tq='$j[id_tq]' AND id_quiz='$j[id_quiz]'");
                    $quiz = mysqli_fetch_array($soal_esay2);
                    echo "<table id='table1' class='gtable sortable'>
                          <form method=POST action='?module=quiz&act=hasilkoreksi'>";
                            if (!empty($quiz[gambar])){
                            echo "<tr><td rowspan=7><b>$no.</b></td><td><b>Pertanyaan :</b></td></tr>
                                  <tr><td>$quiz[pertanyaan]</td></tr>
                                  <tr><td><img src='../foto_soal/medium_$quiz[gambar]'></td></tr>
                                  <tr><td><b>Jawaban:</b></td></tr>
                                  <tr><td>$j[jawaban]</td></tr>
                                  <tr><td><b>Nilai:</b></td></tr>
                                  <tr><td><input type=radio name='nilai".$no."' value='10'>10</input>
                                          <input type=radio name='nilai".$no."' value='20'>20</input>
                                          <input type=radio name='nilai".$no."' value='30'>30</input>
                                          <input type=radio name='nilai".$no."' value='40'>40</input>
                                          <input type=radio name='nilai".$no."' value='50'>50</input>
                                          <input type=radio name='nilai".$no."' value='60'>60</input>
                                          <input type=radio name='nilai".$no."' value='70'>70</input>
                                          <input type=radio name='nilai".$no."' value='80'>80</input>
                                          <input type=radio name='nilai".$no."' value='90'>90</input>
                                          <input type=radio name='nilai".$no."' value='100'>100</input></td></tr>
                                  <input type=hidden name='jawab".$no."' value='$j[jawaban]'>
                                  </table>";

                            }
                            else{
                                echo "<tr><td rowspan=6><b>$no.</b></td><td><b>Pertanyaan :</b></td></tr>
                                  <tr><td>$quiz[pertanyaan]</td></tr>
                                  <tr><td><b>Jawaban:</b></td></tr>
                                  <tr><td>$j[jawaban]</td></tr>
                                  <tr><td><b>Nilai:</b></td></tr>
                                  <tr><td><input type=radio name='nilai".$no."' value='10'>10</input>
                                          <input type=radio name='nilai".$no."' value='20'>20</input>
                                          <input type=radio name='nilai".$no."' value='30'>30</input>
                                          <input type=radio name='nilai".$no."' value='40'>40</input>
                                          <input type=radio name='nilai".$no."' value='50'>50</input>
                                          <input type=radio name='nilai".$no."' value='60'>60</input>
                                          <input type=radio name='nilai".$no."' value='70'>70</input>
                                          <input type=radio name='nilai".$no."' value='80'>80</input>
                                          <input type=radio name='nilai".$no."' value='90'>90</input>
                                          <input type=radio name='nilai".$no."' value='100'>100</input></td></tr>
                                  <input type=hidden name='jawab".$no."' value='$j[jawaban]'>
                                  </table>";
                            }
                    $no++;
                }
                $jum = $no - 1;
                    echo "<input type=hidden name=jumlah_soal value='$jum'>
                          <input type=hidden name=id_topik value='$_GET[id]'>

                          <input type=hidden name=id_siswa value='$_GET[id_siswa]'>";
                echo "<br>
                          <input class='button blue' type=submit value=Simpan>
                          <input class='button blue' type=button value=Batal onclick=self.history.back()>";
            }
            else{
                 echo "<script>window.alert('Jawaban siswa kosong.');
                        window.location=(href='?module=quiz')</script>";
            }
        }
        elseif (!empty($pilganda) AND empty($esay)){
            echo "<script>window.alert('Soal hanya pilihan ganda, sudah di koreksi oleh system.');
            window.location=(href='?module=quiz')</script>";
        }
        elseif (empty($pilganda) AND empty($esay)){
            echo "<script>window.alert('Tidak ada soal pilihan ganda atau essay.');
            window.location=(href='?module=quiz')</script>";
        }
    }
    elseif ($c[dikoreksi]=='S'){
         echo "<script>window.alert('Sudah Di Koreksi');
         window.location=(href='?module=quiz')</script>";
    }
    }
    break;

case "editkoreksi":
    if ($_SESSION[leveluser]=='admin'){
        $soal_pilganda = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_pilganda WHERE id_tq='$_GET[id]'");
        $pilganda = mysqli_num_rows($soal_pilganda);
        $soal_esay = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_esay WHERE id_tq='$_GET[id]'");
        $esay = mysqli_num_rows($soal_esay);
        if (!empty($pilganda) AND !empty($esay)){
            $siswa = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa WHERE id_siswa='$_GET[id_siswa]'");
            $s = mysqli_fetch_array($siswa);
            $jawaban = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM jawaban WHERE id_tq='$_GET[id]' AND id_siswa='$_GET[id_siswa]'");
            $cek=mysqli_num_rows($jawaban);
            if (!empty($cek)){
                echo "<h2>Jawaban Soal Essay Siswa <b>$s[nama_lengkap]</b></h2><hr>";
                $no=1;
                while ($j=mysqli_fetch_array($jawaban)){
                    $soal_esay2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_esay WHERE id_tq='$j[id_tq]' AND id_quiz='$j[id_quiz]'");
                    $quiz = mysqli_fetch_array($soal_esay2);
                    echo "<table id='table1' class='gtable sortable'>
                          <form method=POST action='?module=quiz&act=hasileditkoreksi'>";
                            if (!empty($quiz[gambar])){
                            echo "<tr><td rowspan=7><b>$no.</b></td><td><b>Pertanyaan :</b></td></tr>
                                  <tr><td>$quiz[pertanyaan]</td></tr>
                                  <tr><td><img src='../foto_soal/medium_$quiz[gambar]'></td></tr>
                                  <tr><td><b>Jawaban:</b></td></tr>
                                  <tr><td>$j[jawaban]</td></tr>
                                  <tr><td><b>Nilai:</b></td></tr>
                                  <tr><td><input type=radio name='nilai".$no."' value='10'>10</input>
                                          <input type=radio name='nilai".$no."' value='20'>20</input>
                                          <input type=radio name='nilai".$no."' value='30'>30</input>
                                          <input type=radio name='nilai".$no."' value='40'>40</input>
                                          <input type=radio name='nilai".$no."' value='50'>50</input>
                                          <input type=radio name='nilai".$no."' value='60'>60</input>
                                          <input type=radio name='nilai".$no."' value='70'>70</input>
                                          <input type=radio name='nilai".$no."' value='80'>80</input>
                                          <input type=radio name='nilai".$no."' value='90'>90</input>
                                          <input type=radio name='nilai".$no."' value='100'>100</input></td></tr>
                                  <input type=hidden name='jawab".$no."' value='$j[jawaban]'>
                                  </table>";

                            }
                            else{
                                echo "<tr><td rowspan=6><b>$no.</b></td><td><b>Pertanyaan :</b></td></tr>
                                  <tr><td>$quiz[pertanyaan]</td></tr>
                                  <tr><td><b>Jawaban:</b></td></tr>
                                  <tr><td>$j[jawaban]</td></tr>
                                  <tr><td><b>Nilai:</b></td></tr>
                                  <tr><td><input type=radio name='nilai".$no."' value='10'>10</input>
                                          <input type=radio name='nilai".$no."' value='20'>20</input>
                                          <input type=radio name='nilai".$no."' value='30'>30</input>
                                          <input type=radio name='nilai".$no."' value='40'>40</input>
                                          <input type=radio name='nilai".$no."' value='50'>50</input>
                                          <input type=radio name='nilai".$no."' value='60'>60</input>
                                          <input type=radio name='nilai".$no."' value='70'>70</input>
                                          <input type=radio name='nilai".$no."' value='80'>80</input>
                                          <input type=radio name='nilai".$no."' value='90'>90</input>
                                          <input type=radio name='nilai".$no."' value='100'>100</input></td></tr>
                                  <input type=hidden name='jawab".$no."' value='$j[jawaban]'>
                                  </table>";
                            }
                    $no++;
                }
                $jum = $no - 1;
                    echo "<input type=hidden name=jumlah_soal value='$jum'>
                          <input type=hidden name=id_topik value='$_GET[id]'>

                          <input type=hidden name=id_siswa value='$_GET[id_siswa]'>";
                echo "<br>
                          <input class='button blue' type=submit value=Simpan>
                          <input class='button blue' type=button value=Batal onclick=self.history.back()>";
            }
        }
        elseif (empty($pilganda) AND !empty($esay)){
            $siswa = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa WHERE id_siswa='$_GET[id_siswa]'");
            $s = mysqli_fetch_array($siswa);
            $jawaban = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM jawaban WHERE id_tq='$_GET[id]' AND id_siswa='$_GET[id_siswa]'");
            $cek=mysqli_num_rows($jawaban);
            if (!empty($cek)){
                echo "<h2>Jawaban Soal Essay Siswa <b>$s[nama_lengkap]</b></h2><hr>";
                $no=1;
                while ($j=mysqli_fetch_array($jawaban)){
                    $soal_esay2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_esay WHERE id_tq='$j[id_tq]' AND id_quiz='$j[id_quiz]'");
                    $quiz = mysqli_fetch_array($soal_esay2);
                    echo "<table id='table1' class='gtable sortable'>
                          <form method=POST action='?module=quiz&act=hasileditkoreksi'>";
                            if (!empty($quiz[gambar])){
                            echo "<tr><td rowspan=7><b>$no.</b></td><td><b>Pertanyaan :</b></td></tr>
                                  <tr><td>$quiz[pertanyaan]</td></tr>
                                  <tr><td><img src='../foto_soal/medium_$quiz[gambar]'></td></tr>
                                  <tr><td><b>Jawaban:</b></td></tr>
                                  <tr><td>$j[jawaban]</td></tr>
                                  <tr><td><b>Nilai:</b></td></tr>
                                  <tr><td><input type=radio name='nilai".$no."' value='10'>10</input>
                                          <input type=radio name='nilai".$no."' value='20'>20</input>
                                          <input type=radio name='nilai".$no."' value='30'>30</input>
                                          <input type=radio name='nilai".$no."' value='40'>40</input>
                                          <input type=radio name='nilai".$no."' value='50'>50</input>
                                          <input type=radio name='nilai".$no."' value='60'>60</input>
                                          <input type=radio name='nilai".$no."' value='70'>70</input>
                                          <input type=radio name='nilai".$no."' value='80'>80</input>
                                          <input type=radio name='nilai".$no."' value='90'>90</input>
                                          <input type=radio name='nilai".$no."' value='100'>100</input></td></tr>
                                  <input type=hidden name='jawab".$no."' value='$j[jawaban]'>
                                  </table>";

                            }
                            else{
                                echo "<tr><td rowspan=6><b>$no.</b></td><td><b>Pertanyaan :</b></td></tr>
                                  <tr><td>$quiz[pertanyaan]</td></tr>
                                  <tr><td><b>Jawaban:</b></td></tr>
                                  <tr><td>$j[jawaban]</td></tr>
                                  <tr><td><b>Nilai:</b></td></tr>
                                  <tr><td><input type=radio name='nilai".$no."' value='10'>10</input>
                                          <input type=radio name='nilai".$no."' value='20'>20</input>
                                          <input type=radio name='nilai".$no."' value='30'>30</input>
                                          <input type=radio name='nilai".$no."' value='40'>40</input>
                                          <input type=radio name='nilai".$no."' value='50'>50</input>
                                          <input type=radio name='nilai".$no."' value='60'>60</input>
                                          <input type=radio name='nilai".$no."' value='70'>70</input>
                                          <input type=radio name='nilai".$no."' value='80'>80</input>
                                          <input type=radio name='nilai".$no."' value='90'>90</input>
                                          <input type=radio name='nilai".$no."' value='100'>100</input></td></tr>
                                  <input type=hidden name='jawab".$no."' value='$j[jawaban]'>
                                  </table>";
                            }
                    $no++;
                }
                $jum = $no - 1;
                    echo "<input type=hidden name=jumlah_soal value='$jum'>
                          <input type=hidden name=id_topik value='$_GET[id]'>

                          <input type=hidden name=id_siswa value='$_GET[id_siswa]'>";
                echo "<br>
                          <input class='button blue' type=submit value=Simpan>
                          <input class='button blue' type=button value=Batal onclick=self.history.back()>";
            }
        }
        elseif (!empty($pilganda) AND empty($esay)){
            echo "<script>window.alert('Soal hanya pilihan ganda, sudah di koreksi oleh system.');
            window.location=(href='?module=quiz')</script>";
        }
        elseif (empty($pilganda) AND empty($esay)){
            echo "<script>window.alert('Tidak ada soal pilihan ganda atau essay.');
            window.location=(href='?module=quiz')</script>";
        }
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
        $soal_pilganda = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_pilganda WHERE id_tq='$_GET[id]'");
        $pilganda = mysqli_num_rows($soal_pilganda);
        $soal_esay = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_esay WHERE id_tq='$_GET[id]'");
        $esay = mysqli_num_rows($soal_esay);
        if (!empty($pilganda) AND !empty($esay)){
            $siswa = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa WHERE id_siswa='$_GET[id_siswa]'");
            $s = mysqli_fetch_array($siswa);
            $jawaban = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM jawaban WHERE id_tq='$_GET[id]' AND id_siswa='$_GET[id_siswa]'");
            $cek=mysqli_num_rows($jawaban);
            if (!empty($cek)){
                echo "<h2>Jawaban Soal Essay Siswa <b>$s[nama_lengkap]</b></h2><hr>";
                $no=1;
                while ($j=mysqli_fetch_array($jawaban)){
                    $soal_esay2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_esay WHERE id_tq='$j[id_tq]' AND id_quiz='$j[id_quiz]'");
                    $quiz = mysqli_fetch_array($soal_esay2);
                    echo "<table id='table1' class='gtable sortable'>
                          <form method=POST action='?module=quiz&act=hasileditkoreksi'>";
                            if (!empty($quiz[gambar])){
                            echo "<tr><td rowspan=7><b>$no.</b></td><td><b>Pertanyaan :</b></td></tr>
                                  <tr><td>$quiz[pertanyaan]</td></tr>
                                  <tr><td><img src='../foto_soal/medium_$quiz[gambar]'></td></tr>
                                  <tr><td><b>Jawaban:</b></td></tr>
                                  <tr><td>$j[jawaban]</td></tr>
                                  <tr><td><b>Nilai:</b></td></tr>
                                  <tr><td><input type=radio name='nilai".$no."' value='10'>10</input>
                                          <input type=radio name='nilai".$no."' value='20'>20</input>
                                          <input type=radio name='nilai".$no."' value='30'>30</input>
                                          <input type=radio name='nilai".$no."' value='40'>40</input>
                                          <input type=radio name='nilai".$no."' value='50'>50</input>
                                          <input type=radio name='nilai".$no."' value='60'>60</input>
                                          <input type=radio name='nilai".$no."' value='70'>70</input>
                                          <input type=radio name='nilai".$no."' value='80'>80</input>
                                          <input type=radio name='nilai".$no."' value='90'>90</input>
                                          <input type=radio name='nilai".$no."' value='100'>100</input></td></tr>
                                  <input type=hidden name='jawab".$no."' value='$j[jawaban]'>
                                  </table>";

                            }
                            else{
                                echo "<tr><td rowspan=6><b>$no.</b></td><td><b>Pertanyaan :</b></td></tr>
                                  <tr><td>$quiz[pertanyaan]</td></tr>
                                  <tr><td><b>Jawaban:</b></td></tr>
                                  <tr><td>$j[jawaban]</td></tr>
                                  <tr><td><b>Nilai:</b></td></tr>
                                  <tr><td><input type=radio name='nilai".$no."' value='10'>10</input>
                                          <input type=radio name='nilai".$no."' value='20'>20</input>
                                          <input type=radio name='nilai".$no."' value='30'>30</input>
                                          <input type=radio name='nilai".$no."' value='40'>40</input>
                                          <input type=radio name='nilai".$no."' value='50'>50</input>
                                          <input type=radio name='nilai".$no."' value='60'>60</input>
                                          <input type=radio name='nilai".$no."' value='70'>70</input>
                                          <input type=radio name='nilai".$no."' value='80'>80</input>
                                          <input type=radio name='nilai".$no."' value='90'>90</input>
                                          <input type=radio name='nilai".$no."' value='100'>100</input></td></tr>
                                  <input type=hidden name='jawab".$no."' value='$j[jawaban]'>
                                  </table>";
                            }
                    $no++;
                }
                $jum = $no - 1;
                    echo "<input type=hidden name=jumlah_soal value='$jum'>
                          <input type=hidden name=id_topik value='$_GET[id]'>

                          <input type=hidden name=id_siswa value='$_GET[id_siswa]'>";
                echo "<br>
                          <input class='button blue' type=submit value=Simpan>
                          <input class='button blue' type=button value=Batal onclick=self.history.back()>";
            }
        }
        elseif (empty($pilganda) AND !empty($esay)){
            $siswa = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa WHERE id_siswa='$_GET[id_siswa]'");
            $s = mysqli_fetch_array($siswa);
            $jawaban = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM jawaban WHERE id_tq='$_GET[id]' AND id_siswa='$_GET[id_siswa]'");
            $cek=mysqli_num_rows($jawaban);
            if (!empty($cek)){
                echo "<h2>Jawaban Soal Essay Siswa <b>$s[nama_lengkap]</b></h2><hr>";
                $no=1;
                while ($j=mysqli_fetch_array($jawaban)){
                    $soal_esay2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_esay WHERE id_tq='$j[id_tq]' AND id_quiz='$j[id_quiz]'");
                    $quiz = mysqli_fetch_array($soal_esay2);
                    echo "<table id='table1' class='gtable sortable'>
                          <form method=POST action='?module=quiz&act=hasileditkoreksi'>";
                            if (!empty($quiz[gambar])){
                            echo "<tr><td rowspan=7><b>$no.</b></td><td><b>Pertanyaan :</b></td></tr>
                                  <tr><td>$quiz[pertanyaan]</td></tr>
                                  <tr><td><img src='../foto_soal/medium_$quiz[gambar]'></td></tr>
                                  <tr><td><b>Jawaban:</b></td></tr>
                                  <tr><td>$j[jawaban]</td></tr>
                                  <tr><td><b>Nilai:</b></td></tr>
                                  <tr><td><input type=radio name='nilai".$no."' value='10'>10</input>
                                          <input type=radio name='nilai".$no."' value='20'>20</input>
                                          <input type=radio name='nilai".$no."' value='30'>30</input>
                                          <input type=radio name='nilai".$no."' value='40'>40</input>
                                          <input type=radio name='nilai".$no."' value='50'>50</input>
                                          <input type=radio name='nilai".$no."' value='60'>60</input>
                                          <input type=radio name='nilai".$no."' value='70'>70</input>
                                          <input type=radio name='nilai".$no."' value='80'>80</input>
                                          <input type=radio name='nilai".$no."' value='90'>90</input>
                                          <input type=radio name='nilai".$no."' value='100'>100</input></td></tr>
                                  <input type=hidden name='jawab".$no."' value='$j[jawaban]'>
                                  </table>";

                            }
                            else{
                                echo "<tr><td rowspan=6><b>$no.</b></td><td><b>Pertanyaan :</b></td></tr>
                                  <tr><td>$quiz[pertanyaan]</td></tr>
                                  <tr><td><b>Jawaban:</b></td></tr>
                                  <tr><td>$j[jawaban]</td></tr>
                                  <tr><td><b>Nilai:</b></td></tr>
                                  <tr><td><input type=radio name='nilai".$no."' value='10'>10</input>
                                          <input type=radio name='nilai".$no."' value='20'>20</input>
                                          <input type=radio name='nilai".$no."' value='30'>30</input>
                                          <input type=radio name='nilai".$no."' value='40'>40</input>
                                          <input type=radio name='nilai".$no."' value='50'>50</input>
                                          <input type=radio name='nilai".$no."' value='60'>60</input>
                                          <input type=radio name='nilai".$no."' value='70'>70</input>
                                          <input type=radio name='nilai".$no."' value='80'>80</input>
                                          <input type=radio name='nilai".$no."' value='90'>90</input>
                                          <input type=radio name='nilai".$no."' value='100'>100</input></td></tr>
                                  <input type=hidden name='jawab".$no."' value='$j[jawaban]'>
                                  </table>";
                            }
                    $no++;
                }
                $jum = $no - 1;
                    echo "<input type=hidden name=jumlah_soal value='$jum'>
                          <input type=hidden name=id_topik value='$_GET[id]'>

                          <input type=hidden name=id_siswa value='$_GET[id_siswa]'>";
                echo "<br>
                          <input class='button blue' type=submit value=Simpan>
                          <input class='button blue' type=button value=Batal onclick=self.history.back()>";
            }
        }
        elseif (!empty($pilganda) AND empty($esay)){
            echo "<script>window.alert('Soal hanya pilihan ganda, sudah di koreksi oleh system.');
            window.location=(href='?module=quiz')</script>";
        }
        elseif (empty($pilganda) AND empty($esay)){
            echo "<script>window.alert('Tidak ada soal pilihan ganda atau essay.');
            window.location=(href='?module=quiz')</script>";
        }
    }
    break;


case "hasilkoreksi":
    if ($_SESSION[leveluser]=='admin'){
        echo "<form method=POST action='$aksi?module=quiz&act=inputnilai'><fieldset>
             <legend>Koreksi Nilai</legend>
             <dl class='inline'>";
        $jum_soal = $_POST['jumlah_soal'];
        
                    echo "<table id='table1' class='gtable sortable'><thead>
                          <input type=hidden name=id_tq value='$_POST[id_topik]'>
                          <input type=hidden name=id_siswa value='$_POST[id_siswa]'>";
                    echo "<tr><th>No Soal</th><th>Jawaban</th><th>Nilai</th></tr></thead>";
                    for ($i=1; $i<=$jum_soal; $i++){
                        $nilai = $_POST['nilai'.$i];
                        $jawaban = $_POST['jawab'.$i];
                        if (!empty($jawaban)){
                        echo "<tr><td>$i.</td><td>$jawaban</td><td>$nilai</td></tr>";
                        }else{
                            echo "<tr><td>$i.</td><td></td><td>$nilai</td></tr>";
                        }
                        
                    }
                    echo "</table>";
                    
                    $jumlah = 0;
                    for ($i=1; $i<=$jum_soal; $i++){                        
                        $bil = array($_POST['nilai'.$i]);
                        for ($j=0; $j<=count($bil)-1; $j++){
                        $jumlah = $jumlah + $bil[$j];
                        }                        
                    }                   
                    $nilai = $jumlah / 100;
                    $nilai2 = $nilai / $jum_soal;
                    $nilai3 = $nilai2 * 100;
                echo "<h2>Nilai Keseluruhan = $nilai3</h2>";
                echo "<input type=hidden name=nilai value='$nilai3'>";
                echo "
                      <input class='button blue' type=submit value=Simpan>
                      <input class='button blue' type=button value=Kembali onclick=self.history.back()>
                      ";
                    echo "</dl></div>
                          </fieldset></form>";
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
        echo "<form method=POST action='$aksi?module=quiz&act=inputnilai'><fieldset>
             <legend>Koreksi Nilai</legend>
             <dl class='inline'>";
        $jum_soal = $_POST['jumlah_soal'];

                    echo "<table id='table1' class='gtable sortable'><thead>
                          <input type=hidden name=id_tq value='$_POST[id_topik]'>
                          <input type=hidden name=id_siswa value='$_POST[id_siswa]'>";
                    echo "<tr><th>No Soal</th><th>Jawaban</th><th>Nilai</th></tr></thead>";
                    for ($i=1; $i<=$jum_soal; $i++){
                        $nilai = $_POST['nilai'.$i];
                        $jawaban = $_POST['jawab'.$i];
                        if (!empty($jawaban)){
                        echo "<tr><td>$i.</td><td>$jawaban</td><td>$nilai</td></tr>";
                        }else{
                            echo "<tr><td>$i.</td><td></td><td>$nilai</td></tr>";
                        }

                    }
                    echo "</table>";

                    $jumlah = 0;
                    for ($i=1; $i<=$jum_soal; $i++){
                        $bil = array($_POST['nilai'.$i]);
                        for ($j=0; $j<=count($bil)-1; $j++){
                        $jumlah = $jumlah + $bil[$j];
                        }
                    }
                    $nilai = $jumlah / 100;
                    $nilai2 = $nilai / $jum_soal;
                    $nilai3 = $nilai2 * 100;
                echo "<h2>Nilai Keseluruhan = $nilai3</h2>";
                echo "<input type=hidden name=nilai value='$nilai3'>";
                echo "
                      <input class='button blue' type=submit value=Simpan>
                      <input class='button blue' type=button value=Kembali onclick=self.history.back()>
                      ";
                    echo "</dl></div>
                          </fieldset></form>";
    }
    else{
        echo "anda tidak ber hak mengakses ini.";
    }
    break;

case "hasileditkoreksi":
    if ($_SESSION[leveluser]=='admin'){
        echo "<form method=POST action='$aksi?module=quiz&act=inputeditnilai'><fieldset>
              <legend>Koreksi Nilai</legend>
              <dl class='inline'>";
        $jum_soal = $_POST['jumlah_soal'];

                    echo "<table id='table1' class='gtable sortable'><thead>
                          <input type=hidden name=id_tq value='$_POST[id_topik]'>
                          <input type=hidden name=id_siswa value='$_POST[id_siswa]'>";
                    echo "<tr><th>No Soal</th><th>Jawaban</th><th>Nilai</th></tr></thead>";
                    for ($i=1; $i<=$jum_soal; $i++){
                        $nilai = $_POST['nilai'.$i];
                        $jawaban = $_POST['jawab'.$i];
                        if (!empty($jawaban)){
                        echo "<tr><td>$i</td><td>$jawaban</td><td>$nilai</td></tr>";
                        }else{
                            echo "<tr><td>$i</td><td></td><td>$nilai</td></tr>";
                        }

                    }
                    echo "</table>";
                    $jumlah = 0;
                    for ($i=1; $i<=$jum_soal; $i++){
                        $bil = array($_POST['nilai'.$i]);
                        for ($j=0; $j<=count($bil)-1; $j++){
                        $jumlah = $jumlah + $bil[$j];
                        }
                    }
                    $nilai = $jumlah / 100;
                    $nilai2 = $nilai / $jum_soal;
                    $nilai3 = $nilai2 * 100;
                echo "<h2>Nilai Keseluruhan = $nilai3</h2>";
                echo "<input type=hidden name=nilai value='$nilai3'>";
                echo "
                            <input class='button blue' type=submit value=Simpan>
                            <input class='button blue' type=button value=Kembali onclick=self.history.back()>
                            ";
                    echo " </dl></fieldset></form>";
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
         echo "<form method=POST action='$aksi?module=quiz&act=inputeditnilai'><fieldset>
              <legend>Koreksi Nilai</legend>
              <dl class='inline'>";
        $jum_soal = $_POST['jumlah_soal'];

                    echo "<table id='table1' class='gtable sortable'><thead>
                          <input type=hidden name=id_tq value='$_POST[id_topik]'>
                          <input type=hidden name=id_siswa value='$_POST[id_siswa]'>";
                    echo "<tr><th>No Soal</th><th>Jawaban</th><th>Nilai</th></tr></thead>";
                    for ($i=1; $i<=$jum_soal; $i++){
                        $nilai = $_POST['nilai'.$i];
                        $jawaban = $_POST['jawab'.$i];
                        if (!empty($jawaban)){
                        echo "<tr><td>$i</td><td>$jawaban</td><td>$nilai</td></tr>";
                        }else{
                            echo "<tr><td>$i</td><td></td><td>$nilai</td></tr>";
                        }

                    }
                    echo "</table>";
                    $jumlah = 0;
                    for ($i=1; $i<=$jum_soal; $i++){
                        $bil = array($_POST['nilai'.$i]);
                        for ($j=0; $j<=count($bil)-1; $j++){
                        $jumlah = $jumlah + $bil[$j];
                        }
                    }
                    $nilai = $jumlah / 100;
                    $nilai2 = $nilai / $jum_soal;
                    $nilai3 = $nilai2 * 100;
                echo "<h2>Nilai Keseluruhan = $nilai3</h2>";
                echo "<input type=hidden name=nilai value='$nilai3'>";
                echo "
                            <input class='button blue' type=submit value=Simpan>
                            <input class='button blue' type=button value=Kembali onclick=self.history.back()>
                            ";
                    echo " </dl></fieldset></form>";
    }
    break;

case "tambahtopikquiz":
    if ($_SESSION[leveluser]=='admin'){
    echo "
    <form name='form_topik' method=POST action='$aksi?module=quiz&act=input_topikquiz'>
    <fieldset>
    <legend>Tambah Topik</legend>
    <dl class='inline'>
    <dt><label>Judul</label></dt>              <dd> <input type=text name='judul' size='50'></dd>
    <dt><label>Kelas</label></dt>              <dd> <select name='id_kelas' onChange='showpel()'>
                                          <option value=''>-pilih-</option>";
                                          $pilih="SELECT * FROM kelas ORDER BY nama";
                                          $query=mysqli_query($GLOBALS["___mysqli_ston"], $pilih);
                                          while($row=mysqli_fetch_array($query)){
                                          echo"<option value='".$row[id_kelas]."'>".$row[nama]."</option>";
                                          }
                                          echo"</select></dd>
    <dt><label>Pelajaran</label></dt>          <dd> <div id='pelajaran'></div></dd>
    <dt><label>Waktu pengerjaan</label></dt>   <dd> <input type=text name='waktu' size='10'>
                                                    <small>Dalam Menit</small></dd>
    <dt><label>Info</label></dt>              <dd> <textarea name='info' id='wysiwyg' class='medium' rows='6'></textarea></td></tr>
    <dt><label>Terbit</label></dt>            <dd> <label><input type=radio name='terbit' value='Y'>Y</input></label>
                                              <label><input type=radio name='terbit' value='N'>N</input></label></dd>
    </dl>

          <p align=center><input class='button blue' type=submit value=Simpan>
          <input class='button blue' type=button value=Batal onclick=self.history.back()></p>

          </fieldset></form>";
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
    echo "<form name='form_topik' method=POST action='$aksi?module=quiz&act=input_topikquiz'>
    <fieldset>
    <legend>Tambah Topik</legend>
    <dl class='inline'>
    <dt><label>Judul</label></dt>               <dd> <input type=text name='judul' size='50'></dd>
    <dt><label>Kelas</label></dt>               <dd> <select name='id_kelas' onChange='showpel_pengajar()'>
                                          <option value=''>-pilih-</option>";
                                          $pilih= mysqli_query($GLOBALS["___mysqli_ston"], "SELECT DISTINCT id_kelas FROM mata_pelajaran WHERE id_pengajar ='$_SESSION[idpengajar]'");
                                          while($row=mysqli_fetch_array($pilih)){
                                          $cari_kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas = '$row[id_kelas]'");
                                          while ($k=mysqli_fetch_array($cari_kelas)){
                                          echo"<option value='".$k[id_kelas]."'>".$k[nama]."</option>";
                                          }
                                          }
                                          echo"</select></dd>
    <dt><label>Pelajaran</label></dt>           <dd> <div id='pelajaran'></div></dd>
    <dt><label>Lama pengerjaan</label></dt>   <dd> <input type=text name='waktu' size='10'><small>Dalam Menit</small></dd>
    <dt><label>Info Quiz</label></dt>                <dd> <textarea name='info' id='wysiwyg' class='medium' rows='6'></textarea></dd>
    <dt><label>Terbit</label></dt>             <dd> <label><input type=radio name='terbit' value='Y'>Y</input></label>
                                           <label><input type=radio name='terbit' value='N'>N</input></label></dd>
    </dl>

          <p align=center><input class='button blue' type=submit value=Simpan>
          <input class='button blue' type=button value=Batal onclick=self.history.back()></p>

          </fieldset></form>";
    }
    break;

case "edittopikquiz":
    if ($_SESSION[leveluser]=='admin'){

    $edit=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM topik_quiz WHERE id_tq = '$_GET[id]'");
    $t=mysqli_fetch_array($edit);
    $isikelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas = '$t[id_kelas]'");
    $k=mysqli_fetch_array($isikelas);
    $pelajaran = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$t[id_matapelajaran]'");
    $p=mysqli_fetch_array($pelajaran);

    $waktu = $t['waktu_pengerjaan']/60;

    echo "<form name='form_topik' method=POST action='$aksi?module=quiz&act=edit_topikquiz'>
    <input type=hidden name=id value='$t[id_tq]'>
    <fieldset>
    <legend>Edit Topik</legend>
    <dl class='inline'>
    <dt><label>Judul</label></dt>              <dd>: <input type=text name='judul' value='$t[judul]' size='50'></dd>
    <dt><label>Kelas</label></dt>            <dd>: <select name='id_kelas' onChange='showpel()'>
                                          <option value='".$k[id_kelas]."' selected>".$k[nama]."</option>";
                                          $pilih="SELECT * FROM kelas ORDER BY nama";
                                          $query=mysqli_query($GLOBALS["___mysqli_ston"], $pilih);
                                          while($row=mysqli_fetch_array($query)){
                                          echo"<option value='".$row[id_kelas]."'>".$row[nama]."</option>";
                                          }
                                          echo"</select></dd>
    <dt><label>Pelajaran</label></dt>         <dd>: <select id='pelajaran' name='id_matapelajaran'>
                                          <option value='".$p[id_matapelajaran]."' selected>".$p[nama]."</option>
                                          </select></dd>
    <dt><label>Waktu Pengerjaan</label></dt>   <dd>: <input type=text name='waktu' size='10' value='$waktu'>
                                                     <small>Dalam Menit</small></dd>
    <dt><label>Info Quiz</label></dt>               <dd> <textarea name='info' id='wysiwyg' class='medium' rows='6'>$t[info]</textarea></td></tr>";
    if ($t[terbit]=='N'){
      echo "<dt><label>Terbit</label></dt>     <dd> : <label><input type=radio name='terbit' value='Y'> Y</label>
                                           <label><input type=radio name='terbit' value='N' checked> N </label></dd>";
    }
    else{
      echo "<dt><label>Terbit</label></dt>     <dd> : <label><input type=radio name='terbit' value='Y' checked> Y</label>
                                          <label><input type=radio name='terbit' value='N'> N </label></dd>";
    }
    echo "</dl>

          <p align=center><input class='button blue' type=submit value=Update>
          <input class='button blue' type=button value=Batal onclick=self.history.back()></p>

          </fieldset></form>";
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
    $edit=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM topik_quiz WHERE id_tq = '$_GET[id]'");
    $t=mysqli_fetch_array($edit);
    $isikelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas = '$t[id_kelas]'");
    $k=mysqli_fetch_array($isikelas);
    $pelajaran = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$t[id_matapelajaran]'");
    $p=mysqli_fetch_array($pelajaran);

    $waktu = $t['waktu_pengerjaan']/60;

    echo "<form name='form_topik' method=POST action='$aksi?module=quiz&act=edit_topikquiz'>
    <input type=hidden name=id value='$t[id_tq]'>
    <fieldset>
    <legend>Edit Topik</legend>
    <dl class='inline'>
    <dt><label>Judul</label></dt>              <dd>: <input type=text name='judul' value='$t[judul]' size='50'></dd>
    <dt><label>Kelas</label></dt>               <dd>: <select name='id_kelas' onChange='showpel_pengajar()'>
                                          <option value='".$k[id_kelas]."' selected>".$k[nama]."</option>";
                                          $pilih= mysqli_query($GLOBALS["___mysqli_ston"], "SELECT DISTINCT id_kelas FROM mata_pelajaran WHERE id_pengajar ='$_SESSION[idpengajar]'");
                                          while($row=mysqli_fetch_array($pilih)){
                                          $cari_kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas = '$row[id_kelas]'");
                                          while ($k=mysqli_fetch_array($cari_kelas)){
                                          echo"<option value='".$k[id_kelas]."'>".$k[nama]."</option>";
                                          }
                                          }
                                          echo"</select></dd>
    <dt><label>Pelajaran</label></dt>           <dd>: <select id='pelajaran' name='id_matapelajaran'>
                                          <option value='".$p[id_matapelajaran]."' selected>".$p[nama]."</option>
                                          </select></dd>
    <dt><label>Lama Pengerjaan</label></dt>    <dd>: <input type=text name='waktu' size='10' value='$waktu'><small>Dalam Menit</small></dd>
    <dt><label>Info Quiz</label></dt>                <dd> <textarea name='info' id='wysiwyg' class='medium' rows='6'>$t[info]</textarea></dd>";
    if ($t[terbit]=='N'){
      echo "<dt><label>Terbit</label></dt>      <dd> : <label><input type=radio name='terbit' value='Y'> Y</label>
                                           <label><input type=radio name='terbit' value='N' checked> N </label></dd>";
    }
    else{
      echo "<dt><label>Terbit</label></dt>      <dd> : <label><input type=radio name='terbit' value='Y' checked> Y</label>
                                          <label><input type=radio name='terbit' value='N'> N </label></dd>";
    }
    echo "</dl>

          <p align=center><input class='button blue' type=submit value=Update>
          <input class='button blue' type=button value=Batal onclick=self.history.back()></p>

          </fieldset></form>";
    }
    break;

case "daftartopik":
    if ($_SESSION[leveluser]=='siswa'){
        $mapel = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$_GET[id]'");
        $data_mapel = mysqli_fetch_array($mapel);
        $topik = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM topik_quiz WHERE id_kelas = '$_GET[id_kelas]' AND id_matapelajaran = '$_GET[id]' AND terbit='Y'");
        $cek_topik = mysqli_num_rows($topik);

        if (!empty($cek_topik)){
            echo"<br><b class='judul'>Daftar Tugas / Quiz Mata Pelajaran $data_mapel[nama]</b><br><p class='garisbawah'></p>
              <table>
              <tr><th>No</th><th>Deskripsi Tugas/Quiz </th><th></th></tr>";
              $no=1;
              while($t=mysqli_fetch_array($topik)){
                  $tgl_posting   = tgl_indo($t[tgl_buat]);
                  $pengajar =  mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM pengajar WHERE id_pengajar = '$t[pembuat]'");
                  $cek_pengajar = mysqli_num_rows($pengajar);
                  $waktu = $t[waktu_pengerjaan] / 60;
                  echo"<tr><td rowspan=6>$no</td><td><b>Judul</b></td><td><b>: $t[judul]</b></td></tr>
                       <tr><td><b>Tanggal Posting</b></td><td><b>: $tgl_posting</b></td></tr>";
                       if(!empty($cek_pengajar)){

                       $p = mysqli_fetch_array($pengajar);
                       echo"<tr><td><b>Pembuat</b></td><td><b>: $p[nama_lengkap]</b></td></tr>";
                       }else{
                           echo"<tr><td><b>Pembuat</b></td><td><b>: $t[pembuat]</b></td></tr>";
                       }
                       echo"<tr><td><b>Waktu Pengerjaan</b></td><td><b>: $waktu menit</b></td></tr>
                            <tr><td><b>Info Soal/Quiz</b></td><td><b>: $t[info]</b></td></tr>
                            <tr><td></td><td><input type=button class='tombol' value='Kerjakan Tugas/Quiz'
                       onclick=\"window.location.href='?module=quiz&act=infokerjakan&id=$t[id_tq]';\"></td></tr>";
              $no++;
              }
              echo"</table>
                    <p class='garisbawah'></p><input type=button class='tombol' value='Kembali' onclick=self.history.back()>";
        }else{
            echo "<script>window.alert('Belum ada Tugas atau Quiz di mata pelajaran ini.');
                    window.location=(href='media.php?module=quiz')</script>";
        }
    }
    break;

case "daftarnilai":
    if ($_SESSION[leveluser]=='siswa'){
        $mapel = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$_GET[id]'");
        $data_mapel = mysqli_fetch_array($mapel);
        $topik = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM topik_quiz WHERE id_kelas = '$_GET[id_kelas]' AND id_matapelajaran = '$_GET[id]' AND terbit='Y'");
        $cek_topik = mysqli_num_rows($topik);
        
        if (!empty($cek_topik)){
            echo"<br><b class='judul'>Daftar Nilai Tugas / Quiz Mata Pelajaran $data_mapel[nama]</b><br><p class='garisbawah'></p>
              <table>
              <tr><th>No</th><th>Deskripsi Tugas/Quiz </th><th></th></tr>";
              $no=1;
               while($t=mysqli_fetch_array($topik)){
                  $tgl_posting   = tgl_indo($t[tgl_buat]);
                  $pengajar =  mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM pengajar WHERE id_pengajar = '$t[pembuat]'");
                  $cek_pengajar = mysqli_num_rows($pengajar);
                  $waktu = $t[waktu_pengerjaan] / 60;
                  echo"<tr><td rowspan=6>$no</td><td><b>Judul</b></td><td><b>: $t[judul]</b></td></tr>
                       <tr><td><b>Tanggal Posting</b></td><td><b>: $tgl_posting</b></td></tr>";
                       if(!empty($cek_pengajar)){

                       $p = mysqli_fetch_array($pengajar);
                       echo"<tr><td><b>Pembuat</b></td><td><b>: $p[nama_lengkap]</b></td></tr>";
                       }else{
                           echo"<tr><td><b>Pembuat</b></td><td><b>: $t[pembuat]</b></td></tr>";
                       }
                       echo"<tr><td><b>Waktu Pengerjaan</b></td><td><b>: $waktu menit</b></td></tr>
                            <tr><td><b>Info Soal/Quiz</b></td><td><b>: $t[info]</b></td></tr>
                            <tr><td></td><td><input type=button class='tombol' value='Lihat Nilai'
                       onclick=\"window.location.href='?module=quiz&act=nilaisiswa&id_topik=$t[id_tq]';\"></td></tr>";
                       
              $no++;
              }
              echo"</table>
                   <p class='garisbawah'></p><input type=button class='tombol' value='Kembali' onclick=self.history.back()>";
        }else{
            echo "<script>window.alert('Belum ada Tugas atau Quiz di mata pelajaran ini, jadi tidak ada nilai.');
                    window.location=(href='media.php?module=nilai')</script>";
        }
    }
    break;

case "nilaisiswa":
    if ($_SESSION[leveluser]=='siswa'){
        $quiz_pilganda = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_pilganda WHERE id_tq = '$_GET[id_topik]'");
        $quiz_esay = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_esay WHERE id_tq = '$_GET[id_topik]'");
        $c_pilganda = mysqli_num_rows($quiz_pilganda);
        $c_esay = mysqli_num_rows($quiz_esay);

        if (!empty($c_pilganda) AND !empty($c_esay)){
        $pilganda = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM nilai WHERE id_tq = '$_GET[id_topik]' AND id_siswa = '$_SESSION[idsiswa]'");
        $cek_pilganda = mysqli_num_rows($pilganda);
        $esay = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM nilai_soal_esay WHERE id_tq = '$_GET[id_topik]' AND id_siswa = '$_SESSION[idsiswa]'");
        $cek_esay = mysqli_num_rows($esay);

                if (!empty($cek_pilganda) AND !empty($cek_esay)){
                    echo"<br><b class='judul'>Nilai Anda</b><br><p class='garisbawah'></p>
                      <table>
                      <tr><th>Deskripsi Tugas/Quiz </th><th>Nilai</th></tr>";
                      $n_pilganda = mysqli_fetch_array($pilganda);
                      $n_esay = mysqli_fetch_array($esay);
                      echo "<tr><td>Tugas Pilihan Ganda</td><td>$n_pilganda[persentase]</td></tr>
                            <tr><td>Tugas Essay</td><td>$n_esay[nilai]</td></tr>
                            </table>
                            <p class='garisbawah'></p><input type=button class='tombol' value='Kembali' onclick=self.history.back()>";
                }
                elseif (empty($cek_pilganda) AND !empty($cek_esay)){
                    echo"<br><b class='judul'>Nilai Anda</b><br><p class='garisbawah'></p>
                      <table>
                      <tr><th>Deskripsi Tugas/Quiz </th><th>Nilai</th></tr>";
                      $n_pilganda = mysqli_fetch_array($pilganda);
                      $n_esay = mysqli_fetch_array($esay);
                      echo "<tr><td>Tugas Pilihan Ganda</td><td>Anda belum mengerjakan</td></tr>
                            <tr><td>Tugas Essay</td><td>$n_esay[nilai]</td></tr>
                            </table>
                            <p class='garisbawah'></p><input type=button class='tombol' value='Kembali' onclick=self.history.back()>";
                }
                elseif (!empty($cek_pilganda) AND empty($cek_esay)){
                    echo"<br><b class='judul'>Nilai Anda</b><br><p class='garisbawah'></p>
                      <table>
                      <tr><th>Deskripsi Tugas/Quiz </th><th>Nilai</th></tr>";
                      $n_pilganda = mysqli_fetch_array($pilganda);
                      $n_esay = mysqli_fetch_array($esay);
                      echo "<tr><td>Tugas Pilihan Ganda</td><td>$n_pilganda[persentase]</td></tr>
                            <tr><td>Tugas Essay</td><td>Belum di koreksi</td></tr>
                            </table>
                            <p class='garisbawah'></p><input type=button class='tombol' value='Kembali' onclick=self.history.back()>";
                }
                elseif (empty($cek_pilganda) AND empty($cek_esay)){
                    echo"<br><b class='judul'>Nilai Anda</b><br><p class='garisbawah'></p>
                      <table>
                      <tr><th>Deskripsi Tugas/Quiz </th><th>Nilai</th></tr>";
                      $n_pilganda = mysqli_fetch_array($pilganda);
                      $n_esay = mysqli_fetch_array($esay);
                      echo "<tr><td>Tugas Pilihan Ganda</td><td>Anda Belum mengerjakan</td></tr>
                            <tr><td>Tugas Essay</td><td>Anda Belum mengerjakan</td></tr>
                            </table>
                            <p class='garisbawah'></p><input type=button class='tombol' value='Kembali' onclick=self.history.back()>";
                }

        }
        elseif (empty($c_pilganda) AND !empty($c_esay)){
        $esay = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM nilai_soal_esay WHERE id_tq = '$_GET[id_topik]' AND id_siswa = '$_SESSION[idsiswa]'");
        $cek_esay = mysqli_num_rows($esay);
                //jika nilai tidak kosong
                if (!empty($cek_esay)){
                    
                          echo"<br><b class='judul'>Nilai Anda</b><br><p class='garisbawah'></p>
                          <table>
                          <tr><th>Deskripsi Tugas/Quiz </th><th>Nilai</th></tr>";
                          $n_esay = mysqli_fetch_array($esay);
                          echo "<tr><td>Tugas Essay</td><td>$n_esay[nilai]</td></tr>
                          </table>
                                <p class='garisbawah'></p><input type=button class='tombol' value='Kembali' onclick=self.history.back()>";
                        
                }
                elseif (empty($cek_esay)) {
                    $kerjakan = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa_sudah_mengerjakan WHERE id_tq='$_GET[id_topik]' AND id_siswa = '$_SESSION[idsiswa]'");
                    $c_kerjakan = mysqli_num_rows($kerjakan);
                    if (!empty($c_kerjakan)){
                        $cek_kerjakan = mysqli_fetch_array($kerjakan);
                        if ($cek_kerjakan['dikoreksi']=='B'){
                        echo"<br><b class='judul'>Nilai Anda</b><br><p class='garisbawah'></p>
                          <table>
                          <tr><th>Deskripsi Tugas/Quiz </th><th>Nilai</th></tr>";
                          echo "<tr><td>Tugas Essay</td><td>Belum Dikoreksi</td></tr>
                          </table>
                                <p class='garisbawah'></p><input type=button class='tombol' value='Kembali' onclick=self.history.back()>";

                    }
                    elseif (empty($c_kerjakan)){
                            echo"<br><b class='judul'>Nilai Anda</b><br><p class='garisbawah'></p>
                              <table>
                              <tr><th>Deskripsi Tugas/Quiz </th><th>Nilai</th></tr>";
                              echo "<tr><td>Tugas Essay</td><td>Anda belum mengerjakan</td></tr>
                              </table>
                                    <p class='garisbawah'></p><input type=button class='tombol' value='Kembali' onclick=self.history.back()>";


                    }
                    }
                }
                
        }
        elseif (!empty($c_pilganda) AND empty($c_esay)){
        $pilganda = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM nilai WHERE id_tq = '$_GET[id_topik]' AND id_siswa = '$_SESSION[idsiswa]'");
        $cek_pilganda = mysqli_num_rows($pilganda);
                if (!empty($cek_pilganda)){
                    echo"<br><b class='judul'>Nilai Anda</b><br><p class='garisbawah'></p>
                      <table>
                      <tr><th>Deskripsi Tugas/Quiz </th><th>Nilai</th></tr>";
                      $n_pilganda = mysqli_fetch_array($pilganda);
                      echo "<tr><td>Tugas Pilihan Ganda</td><td>$n_pilganda[persentase]</td></tr>
                            </table>
                            <p class='garisbawah'></p><input type=button class='tombol' value='Kembali' onclick=self.history.back()>";
                }
                else {
                    echo"<br><b class='judul'>Nilai Anda</b><br><p class='garisbawah'></p>
                      <table>
                      <tr><th>Deskripsi Tugas/Quiz </th><th>Nilai</th></tr>";
                      $n_pilganda = mysqli_fetch_array($pilganda);
                      echo "<tr><td>Tugas Pilihan Ganda</td><td>Anda Belum mengerjakan</td></tr>
                            </table>
                            <p class='garisbawah'></p><input type=button class='tombol' value='Kembali' onclick=self.history.back()>";
                }
        }
        elseif (!empty($c_pilganda) AND !empty($c_esay)){
            echo "<script>window.alert('Belum ada Nilai di tugas/quiz ini.');
            window.location=(href='?module=nilai')</script>";
        }
    }
    break;

case "infokerjakan":
    if ($_SESSION[leveluser]=='siswa'){
        $cek = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa_sudah_mengerjakan WHERE id_tq='$_GET[id]' AND id_siswa = '$_SESSION[idsiswa]'");
        $data = mysqli_fetch_array($cek);
        
        if ($data[hits]<=0){
        $topik = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM topik_quiz WHERE id_tq = '$_GET[id]'");
        $t = mysqli_fetch_array($topik);

        echo"<br><b class='judul'>Informasi</b><br><p class='garisbawah'></p>
            <form method=POST action='soal.php?' target='_blank'>
            <input type=hidden name='waktu' value='$t[waktu_pengerjaan]'>
            <input type=hidden name='id' value='$_GET[id]'>
            <h3>Baca dengan seksama dan teliti sebelum mengerjakan Tugas / Quiz<p class='garisbawah'></p><b>
            1. Pastikan koneksi anda terjamin dan bagus.<br>
            2. Pilih browser yang suport dengan Website E-Learning SMP Muhammadiyah 04 Kertanegara.<br>
            3. Jika mati lampu hubungi Pengajar Mata Pelajaran terkait untuk bisa Ujian Kembali.</h3><br>";
        echo"<p class='garisbawah'></p>
            <input type=submit class='tombol' value='Mulai Mengerjakan' onclick='window.location.reload()'>
            <input type=button class='tombol' value='Kembali' onclick=self.history.back()>";
        }
        elseif ($data[hits] >= 1){
            echo"<br><b class='judul'>Informasi</b><br><p class='garisbawah'></p>";
            echo "<h3>Anda Sudah mengerjakan tugas / Quiz ini</h3>";
            echo "<p class='garisbawah'></p>
                <input type=button class='tombol' value='Kembali'
                onclick=self.history.back()>";
        }
    }
    break;

case "buatquiz":
    if ($_SESSION[leveluser]=='admin'){
        $topik=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM topik_quiz WHERE id_tq = '$_GET[id]'");
        $t=mysqli_fetch_array($topik);
        echo "<form><fieldset>
            <legend>Jenis Kuis</legend>
            <dl class='inline'>
            </dl>
          <p align=center'>
          <input class='button white' type=button value='Buat Quiz Esay' onclick=\"window.location.href='?module=buatquizesay&act=buatquizesay&id=$t[id_tq]';\">
          <input class='button white' type=button value='Buat Quiz Pilihan Ganda' onclick=\"window.location.href='?module=buatquizpilganda&act=buatquizpilganda&id=$t[id_tq]';\">
          </p>
          <br><input class='button blue' type=button value=Kembali onclick=self.history.back()>
          </fieldset></form>";
    }
    else{
        $topik=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM topik_quiz WHERE id_tq = '$_GET[id]'");
        $t=mysqli_fetch_array($topik);
        echo "<form><fieldset>
            <legend>Jenis Kuis</legend>
            <dl class='inline'>
            </dl>
          <p align=center'>
          <input class='button white' type=button value='Buat Quiz Esay' onclick=\"window.location.href='?module=buatquizesay&act=buatquizesay&id=$t[id_tq]';\">
          <input class='button white' type=button value='Buat Quiz Pilihan Ganda' onclick=\"window.location.href='?module=buatquizpilganda&act=buatquizpilganda&id=$t[id_tq]';\">
          </p>
          <br><input class='button blue' type=button value=Kembali onclick=self.history.back()>
          </fieldset></form>";
    }
    break;

case "buatquizesay":
    if ($_SESSION[leveluser]=='admin'){
        $jum = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT COUNT(quiz_esay.id_quiz) as jml FROM quiz_esay WHERE id_tq = '$_GET[id]'");
        $j = mysqli_fetch_array($jum);
        $jumlah = $j[jml] + 1;
        
        echo "<form method=POST action='$aksi?module=quiz&act=input_quizesay' enctype='multipart/form-data'>        
        <input type=hidden name=id value='$_GET[id]'>
        <fieldset>
        <legend>Buat Tugas/Quiz Essay</legend>
        <dl class='inline'>
        <dt><label>Pertanyaan ".$jumlah." </label></dt> <dd><textarea name='pertanyaan' id='wysiwyg' cols='75' rows='3'></textarea></dd>
        <dt><label>Gambar </label></dt>                 <dd><input type=file name='fupload'>
                                                            <small>Jika tidak ada gambar dikosongkann saja.</small>
        <small>Tipe yang di ijinkan JPG dan JPEG</small>
        <small>Jumlah soal esay di database :";
                    if ($j[jml] == 0){
                        echo "<a href='?module=quiz&act=daftarquizesay&id=$_GET[id]' target='_blank' title='Lihat Daftar Soal'><blink> 0</blink></a></small>";
                    }else{
                        echo "<a href='?module=quiz&act=daftarquizesay&id=$_GET[id]' target='_blank' title='Lihat Daftar Soal'><blink> $j[jml]</blink></a></small>";
                    }
        echo"</dd>
        </dl>
          <div class='buttons'>
          <input class='button blue' type=submit value=Simpan>
          <input class='button blue' type=button value=Batal onclick=self.history.back()>
          </div>
          </fieldset></form>";
    }
    else{
        $jum = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT COUNT(quiz_esay.id_quiz) as jml FROM quiz_esay WHERE id_tq = '$_GET[id]'");
        $j = mysqli_fetch_array($jum);
        $jumlah = $j[jml] + 1;

        echo "<form method=POST action='$aksi?module=quiz&act=input_quizesay' enctype='multipart/form-data'>
        <input type=hidden name=id value='$_GET[id]'>
        <fieldset>
        <legend>Buat Tugas/Quiz Essay</legend>
        <dl class='inline'>
        <dt><label>Pertanyaan ".$jumlah." </label></dt> <dd><textarea name='pertanyaan' id='wysiwyg' cols='75' rows='3'></textarea></dd>
        <dt><label>Gambar </label></dt>                 <dd><input type=file name='fupload'>
                                                            <small>Jika tidak ada gambar dikosongkann saja.</small>
        <small>Tipe yang di ijinkan JPG dan JPEG</small>
        <small>Jumlah soal esay di database :";
                    if ($j[jml] == 0){
                        echo "<a href='?module=quiz&act=daftarquizesay&id=$_GET[id]' target='_blank' title='Lihat Daftar Soal'><blink> 0</blink></a></small>";
                    }else{
                        echo "<a href='?module=quiz&act=daftarquizesay&id=$_GET[id]' target='_blank' title='Lihat Daftar Soal'><blink> $j[jml]</blink></a></small>";
                    }
        echo"</dd>
        </dl>
          <div class='buttons'>
          <input class='button blue' type=submit value=Simpan>
          <input class='button blue' type=button value=Batal onclick=self.history.back()>
          </div>
          </fieldset></form>";
    }
    break;

case "buatquizpilganda":
    if ($_SESSION[leveluser]=='admin'){
        $jum = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT COUNT(quiz_pilganda.id_quiz) as jml FROM quiz_pilganda WHERE id_tq = '$_GET[id]'");
        $j = mysqli_fetch_array($jum);
        $jumlah = $j[jml] + 1;
        echo"<form method=POST action='$aksi?module=quiz&act=input_quizpilganda' enctype='multipart/form-data'>";
        echo"<fieldset>
             <legend>Buat Tugas/Quiz Pilihan Ganda</legend>
             <dl class='inline'>
             <dt><label>Pertanyaan ".$jumlah." </label></dt> <dd><textarea name='pertanyaan' id='wysiwyg' cols='75' rows='3'></textarea></dd>
             <dt><label>Gambar Pertanyaan</label></dt>            <dd><input type=file name='fupload' size=40>
                                                                     <small>Apabila tidak ada gambar pertanyaan, di kosongkan saja</small>
                                                                     <small>Tipe gambar yang di ijinkan JPG dan JPEG</small></dd>
             <dt><label>Pilihan A </label></dt>        <dd><textarea name='pila' id='wysiwyg2' cols='75' rows='3'></textarea></dd>
             
             <dt><label>Pilihan B </label></dt>        <dd><textarea name='pilb' id='wysiwyg' cols='75' rows='3'></textarea></dd>
             
             <dt><label>Pilihan C </label></dt>        <dd><textarea name='pilc' id='wysiwyg' cols='75' rows='3'></textarea></dd>
             
             <dt><label>Pilihan D </label></dt>        <dd><textarea name='pild' id='wysiwyg' cols='75' rows='3'></textarea></dd>
             
             <dt><label>Kunci Jawaban</td>  <dd><label><input type=radio name='kunci' value=A>A</input><label>
                                            <label><input type=radio name='kunci' value=B>B</input><label>
                                            <label><input type=radio name='kunci' value=C>C</input><label>
                                            <label><input type=radio name='kunci' value=D>D</input><label>

             <small>Jumlah soal pilihan ganda di database :";
                    if ($j[jml] == 0){
                        echo "<a href='?module=quiz&act=daftarquizpilganda&id=$_GET[id]' target='_blank' title='Lihat Daftar Soal'><blink> 0</blink></a></small>";
                    }else{
                        echo "<a href='?module=quiz&act=daftarquizpilganda&id=$_GET[id]' target='_blank' title='Lihat Daftar Soal'><blink> $j[jml]</blink></a></small>";
                    }
        echo"</dd><input type=hidden name=id value='$_GET[id]'>
         </dl>
          <div class='buttons'>
          <input class='button blue' type=submit value=Simpan>
          <input class='button blue' type=button value=Batal onclick=self.history.back()>
          </div>
          </fieldset></form>";
    }
    else{
        $jum = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT COUNT(quiz_pilganda.id_quiz) as jml FROM quiz_pilganda WHERE id_tq = '$_GET[id]'");
        $j = mysqli_fetch_array($jum);
        $jumlah = $j[jml] + 1;
  
        echo"<form method=POST action='$aksi?module=quiz&act=input_quizpilganda' enctype='multipart/form-data'>";
        echo"<fieldset>
             <legend>Buat Tugas/Quiz Pilihan Ganda</legend>
             <dl class='inline'>
             <dt><label>Pertanyaan ".$jumlah." </label></dt> <dd><textarea name='pertanyaan' id='wysiwyg' cols='75' rows='3'></textarea></dd>
             <dt><label>Gambar Pertanyaan</label></dt>            <dd><input type=file name='fupload' size=40>
                                                                     <small>Apabila tidak ada gambar pertanyaan, di kosongkan saja</small>
                                                                     <small>Tipe gambar yang di ijinkan JPG dan JPEG</small></dd>
             <dt><label>Pilihan A </label></dt>        <dd><textarea name='pila' id='wysiwyg2' cols='75' rows='3'></textarea></dd>

             <dt><label>Pilihan B </label></dt>        <dd><textarea name='pilb' id='wysiwyg' cols='75' rows='3'></textarea></dd>

             <dt><label>Pilihan C </label></dt>        <dd><textarea name='pilc' id='wysiwyg' cols='75' rows='3'></textarea></dd>

             <dt><label>Pilihan D </label></dt>        <dd><textarea name='pild' id='wysiwyg' cols='75' rows='3'></textarea></dd>

             <dt><label>Kunci Jawaban</td>  <dd><label><input type=radio name='kunci' value=A>A</input><label>
                                            <label><input type=radio name='kunci' value=B>B</input><label>
                                            <label><input type=radio name='kunci' value=C>C</input><label>
                                            <label><input type=radio name='kunci' value=D>D</input><label>

             <small>Jumlah soal pilihan ganda di database :";
                    if ($j[jml] == 0){
                        echo "<a href='?module=quiz&act=daftarquizpilganda&id=$_GET[id]' target='_blank' title='Lihat Daftar Soal'><blink> 0</blink></a></small>";
                    }else{
                        echo "<a href='?module=quiz&act=daftarquizpilganda&id=$_GET[id]' target='_blank' title='Lihat Daftar Soal'><blink> $j[jml]</blink></a></small>";
                    }
        echo"</dd><input type=hidden name=id value='$_GET[id]'>
         </dl>
          <div class='buttons'>
          <input class='button blue' type=submit value=Simpan>
          <input class='button blue' type=button value=Batal onclick=self.history.back()>
          </div>
          </fieldset></form>";
    }
    break;

case "daftarquiz":
    if ($_SESSION[leveluser]=='admin'){
        $topik=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM topik_quiz WHERE id_tq = '$_GET[id]'");
        $t=mysqli_fetch_array($topik);
        echo "<form><fieldset>
            <legend>Jenis Kuis</legend>
            <dl class='inline'>
            </dl>
          <p align=center'>
          <input type=button class='button white' value='Daftar Quiz Esay' onclick=\"window.location.href='?module=daftarquizesay&act=daftarquizesay&id=$t[id_tq]';\"> 
          <input type=button class='button white' value='Daftar Quiz Pilihan Ganda' onclick=\"window.location.href='?module=daftarquizpilganda&act=daftarquizpilganda&id=$t[id_tq]';\">
          </p>
          <br><input type=button class='button blue' value=Kembali onclick=self.history.back()>
          </fieldset></form>";
    }
    else{
        $topik=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM topik_quiz WHERE id_tq = '$_GET[id]'");
        $t=mysqli_fetch_array($topik);
        echo "<form><fieldset>
            <legend>Jenis Kuis</legend>
            <dl class='inline'>
            </dl>
          <p align=center'>
          <input class='button white' type=button value='Daftar Quiz Esay' onclick=\"window.location.href='?module=daftarquizesay&act=daftarquizesay&id=$t[id_tq]';\">
          <input class='button white' type=button value='Daftar Quiz Pilihan Ganda' onclick=\"window.location.href='?module=daftarquizpilganda&act=daftarquizpilganda&id=$t[id_tq]';\">
          </p>
          <br><input type=button class='button blue' value=Kembali onclick=self.history.back()>
          </fieldset></form>";
    }
    break;

case "daftarquizesay":
    if ($_SESSION[leveluser]=='admin'){
        $cek = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT COUNT(quiz_esay.id_quiz) as jml FROM quiz_esay WHERE id_tq = '$_GET[id]'");
        $c = mysqli_fetch_array($cek);
        if ($c[jml] != 0){
        $quiz=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_esay WHERE id_tq = '$_GET[id]'");        
        $jquiz = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_esay WHERE id_tq = '$_GET[id]'");
        $jq = mysqli_fetch_array($jquiz);
        $topik = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM topik_quiz WHERE id_tq = '$jq[id_tq]'");
        $t=mysqli_fetch_array($topik);
        $kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas = '$t[id_kelas]'");
        $k=mysqli_fetch_array($kelas);
        $pelajaran = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$t[id_matapelajaran]'");
        $p = mysqli_fetch_array($pelajaran);

        echo "<div class='information msg'><b>Daftar Soal Quiz Esay</b></div>
              <form><fieldset>
              <legend>Info Tugas/Quiz</legend>
              <dl class='inline'>
              <dt><label>Judul</label></dt>           <dd>: $t[judul]</dd>
              <dt><label>Kelas</label></dt>           <dd>: $k[nama]</dd>
              <dt><label>Mata Pelajaran</label></dt>  <dd>: $p[nama]</dd>
              </dl></fieldset></form>";
        echo "<input class='button blue' type=button value='Tambah Quiz Esay' onclick=\"window.location.href='?module=quiz&act=buatquizesay&id=$jq[id_tq]';\">
              <input class='button blue' type=button value=Kembali onclick=\"window.location.href='?module=quiz';\">";

        echo "<br><br><table id='table1' class='gtable sortable'><thead>
          <tr><th>No</th><th>Pertanyaan</th><th>Gambar</th><th>Tgl Buat</th><th>Aksi</th></tr></thead>";
    $no=1;
    while ($q=mysqli_fetch_array($quiz)){
       $tgl_buat   = tgl_indo($q[tgl_buat]);
       echo "<tr><td>$no</td>
             <td>$q[pertanyaan]</td>
             <td>$q[gambar]</td>
             <td>$tgl_buat</td>
             <td><a href='?module=quiz&act=editquizesay&id=$q[id_quiz]&id_topik=$q[id_tq]' title='Edit'><img src='images/icons/edit.png' alt='Edit' /></a> |
                 <a href=javascript:confirmdelete('$aksi?module=quiz&act=hapusquizesay&id=$q[id_quiz]&id_topik=$q[id_tq]') title='Hapus' ><img src='images/icons/cross.png' alt='Delete' /></a>
                 </td></tr>";
      $no++;
    }
    echo "</table>";
        }else{
            echo "<script>window.alert('Quiz esay masih kosong');
            window.location=(href='?module=quiz')</script>";
        }
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
        $cek = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT COUNT(quiz_esay.id_quiz) as jml FROM quiz_esay WHERE id_tq = '$_GET[id]'");
        $c = mysqli_fetch_array($cek);
        if ($c[jml] != 0){
        $quiz=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_esay WHERE id_tq = '$_GET[id]'");
        $jquiz = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_esay WHERE id_tq = '$_GET[id]'");
        $jq = mysqli_fetch_array($jquiz);
        $topik = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM topik_quiz WHERE id_tq = '$jq[id_tq]'");
        $t=mysqli_fetch_array($topik);
        $kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas = '$t[id_kelas]'");
        $k=mysqli_fetch_array($kelas);
        $pelajaran = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$t[id_matapelajaran]'");
        $p = mysqli_fetch_array($pelajaran);

        echo "<div class='information msg'><b>Daftar Soal Quiz Esay</b></div>
              <form><fieldset>
              <legend>Info Tugas/Quiz</legend>
              <dl class='inline'>
              <dt><label>Judul</label></dt>           <dd>: $t[judul]</dd>
              <dt><label>Kelas</label></dt>           <dd>: $k[nama]</dd>
              <dt><label>Mata Pelajaran</label></dt>  <dd>: $p[nama]</dd>
              </dl></fieldset></form>";
        echo "<input class='button blue' type=button value='Tambah Quiz Esay' onclick=\"window.location.href='?module=buatquizesay&act=buatquizesay&id=$jq[id_tq]';\">
              <input class='button blue' type=button value=Kembali onclick=\"window.location.href='?module=quiz';\">";

        echo "<br><br><table id='table1' class='gtable sortable'><thead>
          <tr><th>No</th><th>Pertanyaan</th><th>Gambar</th><th>Tgl Buat</th><th>Aksi</th></tr></thead>";
    $no=1;
    while ($q=mysqli_fetch_array($quiz)){
       $tgl_buat   = tgl_indo($q[tgl_buat]);
       echo "<tr><td>$no.</td>
             <td>$q[pertanyaan]</td>
             <td>$q[gambar]</td>
             <td>$tgl_buat</td>
             <td><a href='?module=quiz&act=editquizesay&id=$q[id_quiz]&id_topik=$q[id_tq]' title='Edit'><img src='images/icons/edit.png' alt='Edit' /></a> |
                 <a href=javascript:confirmdelete('$aksi?module=quiz&act=hapusquizesay&id=$q[id_quiz]&id_topik=$q[id_tq]') title='Hapus' ><img src='images/icons/cross.png' alt='Delete' /></a>
                 </td></tr>";
      $no++;
    }
    echo "</table>";
        }else{
            echo "<script>window.alert('Quiz esay masih kosong');
            window.location=(href='?module=quiz')</script>";
        }
    }
    break;

case "daftarquizpilganda":
    if ($_SESSION[leveluser]=='admin'){
        $cek = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT COUNT(quiz_pilganda.id_quiz) as jml FROM quiz_pilganda WHERE id_tq = '$_GET[id]'");
        $c = mysqli_fetch_array($cek);
        if ($c[jml] != 0){
        $quiz=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_pilganda WHERE id_tq = '$_GET[id]'");
        $jquiz = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_pilganda WHERE id_tq = '$_GET[id]'");
        $jq = mysqli_fetch_array($jquiz);
        $topik = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM topik_quiz WHERE id_tq = '$jq[id_tq]'");
        $t=mysqli_fetch_array($topik);
        $kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas = '$t[id_kelas]'");
        $k=mysqli_fetch_array($kelas);
        $pelajaran = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$t[id_matapelajaran]'");
        $p = mysqli_fetch_array($pelajaran);

        echo "<div class='information msg'><b>Daftar Soal Tugas/Quiz Pilihan Ganda</b></div>
              <form><fieldset>
              <legend>Info Tugas/Quiz</legend>
              <dl class='inline'>
              <dt><label>Judul</label></dt>          <dd>: $t[judul]</dd>
              <dt><label>Kelas</label></dt>          <dd>: $k[nama]</dd>
              <dt><label>Mata Pelajaran</label></dt> <dd>: $p[nama]</dd></dl></fieldset></form>";
        echo "<input type=button class='button blue' value='Tambah Quiz Pilihan ganda' onclick=\"window.location.href='?module=quiz&act=buatquizpilganda&id=$jq[id_tq]';\">
              <input type=button class='button blue' value=Kembali onclick=\"window.location.href='?module=quiz';\">";
    echo "<br><br><table id='table1' class='gtable sortable'>";
    $no=1;
    while ($q=mysqli_fetch_array($quiz)){
       echo "<tr><td rowspan=8><b>$no.</b></td>
             <td><b>Pertanyaan</b></td><td>: $q[pertanyaan]</td></tr>";
             if (empty($q[gambar])){
                 echo "<tr><td>Gambar</td><td>: Tidak ada gambar.</td></tr>";
             }else{
                 echo "<tr><td>Gambar</td><td>: <ul class='photos sortable'>
                    <li>
                    <img src='../foto_soal_pilganda/medium_$q[gambar]'>
                    <div class='links'>
                    <a href='../foto_soal_pilganda/medium_$q[gambar]' rel='facebox'>View</a>
		    <div>
                    </li>
                    </ul></td></tr>";
             }
             echo"<tr><td>Pilihan A</td><td>: $q[pil_a]</td></tr>
             <tr><td>Pilihan B</td><td>: $q[pil_b]</td></tr>
             <tr><td>Pilihan C</td><td>: $q[pil_c]</td></tr>
             <tr><td>Pilihan D</td><td>: $q[pil_d]</td></tr>
             <tr><td>Kunci Jawaban</td><td>: $q[kunci]</td></tr>
             <tr><td>Aksi</td><td>: <a href='?module=quiz&act=editquizpilganda&id=$q[id_quiz]&id_topik=$q[id_tq]' title='Edit'><img src='images/icons/edit.png' alt='Edit' /></a> |
                 <a href=javascript:confirmdelete('$aksi?module=quiz&act=hapusquizpilganda&id=$q[id_quiz]&id_topik=$q[id_tq]') title='Hapus'><img src='images/icons/cross.png' alt='Delete' /></a></td></tr>
             ";
      $no++;
    }
    echo "</table>";
    echo "<br><input type=button class='button blue' value='Tambah Quiz Pilihan ganda' onclick=\"window.location.href='?module=quiz&act=buatquizpilganda&id=$jq[id_tq]';\">
              <input type=button class='button blue' value=Kembali onclick=\"window.location.href='?module=quiz';\">";
    }else{
            echo "<script>window.alert('Quiz pilihan ganda masih kosong');
            window.location=(href='?module=quiz')</script>";
        }
    }
    else{
        $cek = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT COUNT(quiz_pilganda.id_quiz) as jml FROM quiz_pilganda WHERE id_tq = '$_GET[id]'");
        $c = mysqli_fetch_array($cek);
        if ($c[jml] != 0){
        $quiz=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_pilganda WHERE id_tq = '$_GET[id]'");
        $jquiz = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_pilganda WHERE id_tq = '$_GET[id]'");
        $jq = mysqli_fetch_array($jquiz);
        $topik = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM topik_quiz WHERE id_tq = '$jq[id_tq]'");
        $t=mysqli_fetch_array($topik);
        $kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas = '$t[id_kelas]'");
        $k=mysqli_fetch_array($kelas);
        $pelajaran = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$t[id_matapelajaran]'");
        $p = mysqli_fetch_array($pelajaran);

        echo "<div class='information msg'><b>Daftar Soal Tugas/Quiz Pilihan Ganda</b></div>
              <form><fieldset>
              <legend>Info Tugas/Quiz</legend>
              <dl class='inline'>
              <dt><label>Judul</label></dt>          <dd>: $t[judul]</dd>
              <dt><label>Kelas</label></dt>          <dd>: $k[nama]</dd>
              <dt><label>Mata Pelajaran</label></dt> <dd>: $p[nama]</dd></dl></fieldset></form>";
        echo "<input type=button class='button blue' value='Tambah Quiz Pilihan ganda' onclick=\"window.location.href='?module=quiz&act=buatquizpilganda&id=$jq[id_tq]';\">
              <input type=button class='button blue' value=Kembali onclick=\"window.location.href='?module=quiz';\">";

       echo "<br><br><table id='table1' class='gtable sortable'>";
    $no=1;
    while ($q=mysqli_fetch_array($quiz)){
       echo "<tr><td rowspan=8><b>$no.</b></td>
             <td><b>Pertanyaan</b></td><td>: $q[pertanyaan]</td></tr>";
             if (empty($q[gambar])){
                 echo "<tr><td>Gambar</td><td>: Tidak ada gambar.</td></tr>";
             }else{
                 echo "<tr><td>Gambar</td><td>: <ul class='photos sortable'>
                    <li>
                    <img src='../foto_soal_pilganda/medium_$q[gambar]'>
                    <div class='links'>
                    <a href='../foto_soal_pilganda/medium_$q[gambar]' rel='facebox'>View</a>
		    <div>
                    </li>
                    </ul></td></tr>";
             }
             echo"<tr><td>Pilihan A</td><td>: $q[pil_a]</td></tr>
             <tr><td>Pilihan B</td><td>: $q[pil_b]</td></tr>
             <tr><td>Pilihan C</td><td>: $q[pil_c]</td></tr>
             <tr><td>Pilihan D</td><td>: $q[pil_d]</td></tr>
             <tr><td>Kunci Jawaban</td><td>: $q[kunci]</td></tr>
             <tr><td>Aksi</td><td>: <a href='?module=quiz&act=editquizpilganda&id=$q[id_quiz]&id_topik=$q[id_tq]' title='Edit'><img src='images/icons/edit.png' alt='Edit' /></a> |
                 <a href=javascript:confirmdelete('$aksi?module=quiz&act=hapusquizpilganda&id=$q[id_quiz]&id_topik=$q[id_tq]') title='Hapus'><img src='images/icons/cross.png' alt='Delete' /></a></td></tr>
             ";
      $no++;
    }
    echo "</table>";
    }else{
            echo "<script>window.alert('Quiz pilihan ganda masih kosong');
            window.location=(href='?module=quiz')</script>";
        }
    }
    break;

case "editquizesay":
    if ($_SESSION[leveluser]=='admin'){
        $quiz=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_esay WHERE id_quiz = '$_GET[id]'");
        $q = mysqli_fetch_array($quiz);     

        echo "<form method=POST action='$aksi?module=quiz&act=edit_quizesay' enctype='multipart/form-data'>
        <input type=hidden name=id value='$q[id_quiz]'>
        <input type=hidden name=topik value='$_GET[id_topik]'>
        <fieldset>
         <legend>Edit Tugas/Quiz</legend>
         <dl class='inline'>
          <dt><label>Pertanyaan</label></dt> <dd><textarea name='pertanyaan' id='wysiwyg' cols=75 rows=3>$q[pertanyaan]</textarea></dd>
          <dt><label>Gambar</label></dt>     <dd>";
                    if ($q[gambar]!=''){
                        echo "<ul class='photos sortable'>
                    <li>
                    <img src='../foto_soal/medium_$q[gambar]'></td></tr>
                    <div class='links'>
                    <a href='../foto_soal/medium_$q[gambar]' rel='facebox'>View</a>
		    <div>
                    </li>
                    </ul></dd>";
                    }else{
                        echo "Tidak Ada Gambar</dd>";
                    }
          echo"<dt><label>Ganti Gambar</label></dt> <dd> <input type=file name='fupload'>
          <small>Jika gambar tidak diganti, dikosongkan saja.</small>
          <small>Tipe yang di ijinkan JPG dan JPEG</small></dd>
          </dl>
          <div class='buttons'>
          <input class='button blue' type=submit value=Simpan>
          <input class='button blue' type=button value=Batal onclick=self.history.back()>
          </div>
          </fieldset></form>";
    }
    else{
        $quiz=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_esay WHERE id_quiz = '$_GET[id]'");
        $q = mysqli_fetch_array($quiz);

       echo "<form method=POST action='$aksi?module=quiz&act=edit_quizesay' enctype='multipart/form-data'>
        <input type=hidden name=id value='$q[id_quiz]'>
        <input type=hidden name=topik value='$_GET[id_topik]'>
        <fieldset>
         <legend>Edit Tugas/Quiz</legend>
         <dl class='inline'>
          <dt><label>Pertanyaan</label></dt> <dd><textarea name='pertanyaan' id='wysiwyg' cols=75 rows=3>$q[pertanyaan]</textarea></dd>
          <dt><label>Gambar</label></dt>     <dd>";
                    if ($q[gambar]!=''){
                        echo "<ul class='photos sortable'>
                    <li>
                    <img src='../foto_soal/medium_$q[gambar]'></td></tr>
                    <div class='links'>
                    <a href='../foto_soal/medium_$q[gambar]' rel='facebox'>View</a>
		    <div>
                    </li>
                    </ul></dd>";
                    }else{
                        echo "Tidak Ada Gambar</dd>";
                    }
          echo"<dt><label>Ganti Gambar</label></dt> <dd> <input type=file name='fupload'>
          <small>Jika gambar tidak diganti, dikosongkan saja.</small>
          <small>Tipe yang di ijinkan JPG dan JPEG</small></dd>
          </dl>
          <div class='buttons'>
          <input class='button blue' type=submit value=Simpan>
          <input class='button blue' type=button value=Batal onclick=self.history.back()>
          </div>
          </fieldset></form>";
    }
    break;

case "editquizpilganda":
    if ($_SESSION[leveluser]=='admin'){
        $quiz=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_pilganda WHERE id_quiz = '$_GET[id]'");
        $q = mysqli_fetch_array($quiz);
        echo "<form method=POST action='$aksi?module=quiz&act=edit_quizpilganda' enctype='multipart/form-data'>
        <input type=hidden name=id value='$q[id_quiz]'>
        <input type=hidden name=topik value='$_GET[id_topik]'>
        <fieldset>
        <legend>Edit Tugas/Quiz Pilihan Ganda</legend>
        <dl class='inline'>
          <dt><label>Pertanyaan </label></dt> <dd><textarea name='pertanyaan' id='wysiwyg' cols='75' rows='3'>$q[pertanyaan]</textarea></dd>
             <dt><label>Gambar</label></dt>  <dd>";
                    if ($q[gambar]!=''){
              echo "<ul class='photos sortable'>
                    <li>
                    <img src='../foto_soal_pilganda/medium_$q[gambar]'>
                    <div class='links'>
                    <a href='../foto_soal_pilganda/medium_$q[gambar]' rel='facebox'>View</a>
		    <div>
                    </li>
                    </ul>";
             }else{
                 echo "Tidak ada gambar.";
             }
             echo "</dd>
             <dt><label>Ganti Gambar</label></dt>            <dd><input type=file name='fupload'>
             <small>Apabila gambar pertanyaan tidak diganti, di kosongkan saja</small>
             <small>Tipe gambar jang di ijinkan JPG dan JPEG</small></dd>

             <dt><label>Pilihan A </label></dt>        <dd><textarea name='pila' id='wysiwyg2' cols='75' rows='3'>$q[pil_a]</textarea></dd>

             <dt><label>Pilihan B </label></dt>        <dd><textarea name='pilb' id='wysiwyg2' cols='75' rows='3'>$q[pil_b]</textarea></dd>

             <dt><label>Pilihan C </label></dt>        <dd><textarea name='pilc' id='wysiwyg2' cols='75' rows='3'>$q[pil_c]</textarea></dd>

             <dt><label>Pilihan D </label></dt>        <dd><textarea name='pild' id='wysiwyg2' cols='75' rows='3'>$q[pil_d]</textarea></dd>
             <dt><label>Kunci     </label></dt>        <dd>: ";
                    if($q[kunci]=='A'){
                        echo"<label><input type=radio name='kunci' value=A checked>A</input></label>
                             <label><input type=radio name='kunci' value=B>B</input></label>
                             <label><input type=radio name='kunci' value=C>C</input></label>
                             <label><input type=radio name='kunci' value=D>D</input></label></dd>";
                    }
                    elseif($q[kunci]=='B'){
                        echo"<label><input type=radio name='kunci' value=A>A</input></label>
                             <label><input type=radio name='kunci' value=B checked>B</input></label>
                             <label><input type=radio name='kunci' value=C>C</input></label>
                             <label><input type=radio name='kunci' value=D>D</input></label></dd>";
                    }
                    elseif($q[kunci]=='C'){
                        echo"<label><input type=radio name='kunci' value=A>A</input></label>
                             <label><input type=radio name='kunci' value=B>B</input></label>
                             <label><input type=radio name='kunci' value=C checked>C</input></label>
                             <label><input type=radio name='kunci' value=D>D</input></label></dd>";
                    }
                    else{
                        echo"<label><input type=radio name='kunci' value=A>A</input></label>
                             <label><input type=radio name='kunci' value=B>B</input></label>
                             <label><input type=radio name='kunci' value=C>C</input></label>
                             <label><input type=radio name='kunci' value=D checked>D</input></label></dd>";
                    }
          echo "</dl>
          <div class='buttons'>
          <input class='button blue' type=submit value=Update>
          <input class='button blue' type=button value=Batal onclick=self.history.back()>
          </div>
          </fieldset></form>";
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
         $quiz=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_pilganda WHERE id_quiz = '$_GET[id]'");
        $q = mysqli_fetch_array($quiz);
        echo "<form method=POST action='$aksi?module=quiz&act=edit_quizpilganda' enctype='multipart/form-data'>
        <input type=hidden name=id value='$q[id_quiz]'>
        <input type=hidden name=topik value='$_GET[id_topik]'>
        <fieldset>
        <legend>Edit Tugas/Quiz Pilihan Ganda</legend>
        <dl class='inline'>
          <dt><label>Pertanyaan </label></dt> <dd><textarea name='pertanyaan' id='wysiwyg' cols='75' rows='3'>$q[pertanyaan]</textarea></dd>
             <dt><label>Gambar</label></dt>  <dd>";
                    if ($q[gambar]!=''){
              echo "<ul class='photos sortable'>
                    <li>
                    <img src='../foto_soal_pilganda/medium_$q[gambar]'>
                    <div class='links'>
                    <a href='../foto_soal_pilganda/medium_$q[gambar]' rel='facebox'>View</a>
		    <div>
                    </li>
                    </ul>";
             }else{
                 echo "Tidak ada gambar.";
             }
             echo "</dd>
             <dt><label>Ganti Gambar</label></dt>            <dd><input type=file name='fupload'>
             <small>Apabila gambar pertanyaan tidak diganti, di kosongkan saja</small>
             <small>Tipe gambar jang di ijinkan JPG dan JPEG</small></dd>

             <dt><label>Pilihan A </label></dt>        <dd><textarea name='pila' id='wysiwyg2' cols='75' rows='3'>$q[pil_a]</textarea></dd>

             <dt><label>Pilihan B </label></dt>        <dd><textarea name='pilb' id='wysiwyg2' cols='75' rows='3'>$q[pil_b]</textarea></dd>

             <dt><label>Pilihan C </label></dt>        <dd><textarea name='pilc' id='wysiwyg2' cols='75' rows='3'>$q[pil_c]</textarea></dd>

             <dt><label>Pilihan D </label></dt>        <dd><textarea name='pild' id='wysiwyg2' cols='75' rows='3'>$q[pil_d]</textarea></dd>
             <dt><label>Kunci     </label></dt>        <dd>: ";
                    if($q[kunci]=='A'){
                        echo"<label><input type=radio name='kunci' value=A checked>A</input></label>
                             <label><input type=radio name='kunci' value=B>B</input></label>
                             <label><input type=radio name='kunci' value=C>C</input></label>
                             <label><input type=radio name='kunci' value=D>D</input></label></dd>";
                    }
                    elseif($q[kunci]=='B'){
                        echo"<label><input type=radio name='kunci' value=A>A</input></label>
                             <label><input type=radio name='kunci' value=B checked>B</input></label>
                             <label><input type=radio name='kunci' value=C>C</input></label>
                             <label><input type=radio name='kunci' value=D>D</input></label></dd>";
                    }
                    elseif($q[kunci]=='C'){
                        echo"<label><input type=radio name='kunci' value=A>A</input></label>
                             <label><input type=radio name='kunci' value=B>B</input></label>
                             <label><input type=radio name='kunci' value=C checked>C</input></label>
                             <label><input type=radio name='kunci' value=D>D</input></label></dd>";
                    }
                    else{
                        echo"<label><input type=radio name='kunci' value=A>A</input></label>
                             <label><input type=radio name='kunci' value=B>B</input></label>
                             <label><input type=radio name='kunci' value=C>C</input></label>
                             <label><input type=radio name='kunci' value=D checked>D</input></label></dd>";
                    }
          echo "</dl>
          <div class='buttons'>
          <input class='button blue' type=submit value=Update>
          <input class='button blue' type=button value=Batal onclick=self.history.back()>
          </div>
          </fieldset></form>";
    }
    break;

}
}
?>
