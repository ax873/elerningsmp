<script>
function confirmdelete(delUrl) {
if (confirm("Anda yakin ingin menghapus?")) {
document.location = delUrl;
}
}
</script>
<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href=../css/style.css rel=stylesheet type=text/css>";
  echo "<div class='error msg'>Untuk mengakses Modul anda harus login.</div>";
}
else{

$aksi="modul/mod_registrasi/aksi_registrasi.php";
switch($_GET[act]){
// Tampil Mata Pelajaran
  default:
    if ($_SESSION[leveluser]=='admin'){
         echo "<h2>Registrasi Siswa</h2><hr>";
          echo "<table id='table1' class='gtable sortable'><thead>
          <tr><th>No</th><th>Nis</th><th>Nama</th><th>Kelas</th><th>Nama Ayah</th><th>Aksi</th></tr></thead>";

          $registrasi = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM registrasi_siswa ORDER BY id_registrasi");
          $no=1;
          while ($r=mysqli_fetch_array($registrasi)){
              echo "<tr><td>$no.</td>
                        <td>$r[nis]</td>
                        <td>$r[nama_lengkap]</td>
                        ";
                        $kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas='$r[id_kelas]'");
                        $k=mysqli_fetch_array($kelas);
                        echo "<td>$k[nama]</td>
                        <td>$r[nama_ayah]</td>
                        <td><a href=javascript:confirmdelete('$aksi?module=registrasi&act=hapus&id=$r[id_registrasi]') title='Hapus'><img src='images/icons/cross.png' alt='Delete' /></a> |
                        <a href=?module=registrasi&act=detail&id=$r[id_registrasi]>Detail</a></td></tr>";
          }
          echo "</table>";
    }
    break;

    case "detail":
        if ($_SESSION[leveluser]=='admin'){
            $registrasi = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM registrasi_siswa WHERE id_registrasi = '$_GET[id]'");
            $r=mysqli_fetch_array($registrasi);
            $tgl_lahir = tgl_indo($r[tgl_lahir]);
            echo "<h2>Detail Siswa</h2><hr>";
            echo"<table id='table1' class='gtable sortable'>
                 <tr><td><b>Nis</b></td><td>$r[nis]</td><tr>
                 <tr><td><b>Nama Lengkap</b></td><td>$r[nama_lengkap]</td><tr>
                 <tr><td><b>Kelas</b></td>";
                    $kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas='$r[id_kelas]'");
                    $k=mysqli_fetch_array($kelas);
                 echo "<td>$k[nama]</td></tr>
                 <tr><td><b>Alamat</b></td><td>$r[alamat]</td><tr>
                 <tr><td><b>Tempat Lahir</b></td><td>$r[tempat_lahir]</td><tr>
                 <tr><td><b>Tanggal Lahir</b></td><td>$tgl_lahir</td><tr>
                 <tr><td><b>Jenis Kelamin</b></td>";
                    if ($r[jenis_kelamin]=='L'){
                        echo "<td>Laki - Laki</td></tr>";
                    }else{
                        echo "<td>Perempuan</td></tr>";
                    }
                 echo "<tr><td><b>Agama</b></td><td>$r[agama]</td><tr>
                 <tr><td><b>Nama Ayah</b></td><td>$r[nama_ayah]</td><tr>
                 <tr><td><b>Nama Ibu</b></td><td>$r[nama_ibu]</td><tr>
                 <tr><td><b>Tahun Masuk</b></td><td>$r[th_masuk]</td><tr>
                 <tr><td><b>Email</b></td><td>$r[email]</td><tr>
                 <tr><td><b>Aksi</b></td><td><input type=button class='button white' value='Terima' onclick=\"window.location.href='$aksi?module=registrasi&act=terima&id=$r[id_registrasi]';\">
                                         <input type=button class='button white' value='Kembali' onclick=\"window.location.href='?module=registrasi';\"></td><tr>
                 </table>";
        }

}
}
?>
