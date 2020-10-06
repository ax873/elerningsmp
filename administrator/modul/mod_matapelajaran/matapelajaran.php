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
   echo "if (document.form_materi.id_kelas.value == \"".$idkelas."\")";
   echo "{";

   // membuat option matapelajaran untuk masing-masing kelas
   $query2 = "SELECT * FROM mata_pelajaran WHERE id_kelas = '$idkelas' AND id_pengajar = '0'";
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

$aksi="modul/mod_matapelajaran/aksi_matapelajaran.php";
switch($_GET[act]){
// Tampil Mata Pelajaran
  default:
    if ($_SESSION[leveluser]=='admin'){
      $tampil_pelajaran = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mata_pelajaran ORDER BY id_kelas");
      echo "<h2>Manajemen Mata Pelajaran</h2><hr>
          <input class='button blue' type=button value='Tambah mata pelajaran' onclick=\"window.location.href='?module=matapelajaran&act=tambahmatapelajaran';\">";
          echo "<br><br><table id='table1' class='gtable sortable'><thead>
          <tr><th>No</th><th>Id Mapel</th><th>Nama</th><th>Kelas</th><th>Pengajar</th><th>Deskripsi</th><th>Aksi</th></tr></thead>";
    $no=1;
    while ($r=mysqli_fetch_array($tampil_pelajaran)){
       echo "<tr><td>$no</td>
             <td>$r[id_matapelajaran]</td>
             <td>$r[nama]</td>";
             $kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas = '$r[id_kelas]'");
             $cek = mysqli_num_rows($kelas);
             if(!empty($cek)){
             while($k=mysqli_fetch_array($kelas)){
                 echo "<td><a href=?module=kelas&act=detailkelas&id=$r[id_kelas] title='Detail Kelas'>$k[nama]</td>";
             }
             }else{
                 echo"<td></td>";
             }
             $pengajar = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM pengajar WHERE id_pengajar = '$r[id_pengajar]'");
             $cek_pengajar = mysqli_num_rows($pengajar);
             if(!empty($cek_pengajar)){
             while($p=mysqli_fetch_array($pengajar)){
             echo "<td><a href=?module=admin&act=detailpengajar&id=$r[id_pengajar] title='Detail Pengajar'>$p[nama_lengkap]</a></td>";
             }
             }else{
                 echo"<td></td>";
             }
             echo "<td>$r[deskripsi]</td>
             <td><a href='?module=matapelajaran&act=editmatapelajaran&id=$r[id]' title='Edit'><img src='images/icons/edit.png' alt='Edit' /></a> |
                 <a href=javascript:confirmdelete('$aksi?module=matapelajaran&act=hapus&id=$r[id]') title='Hapus'><img src='images/icons/cross.png' alt='Delete' /></a></td></tr>";
      $no++;
    }
    echo "</table>";
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
     //mata pelajaran

  $tampil_pelajaran = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mata_pelajaran WHERE id_pengajar = '$_SESSION[idpengajar]'");
  $cek_mapel = mysqli_num_rows($tampil_pelajaran);
  if (!empty($cek_mapel)){
    echo"<h2>Mata Pelajaran Yang Anda Ampu</h2><hr>
    <input type=button class='button blue' value='Tambah' onclick=\"window.location.href='?module=matapelajaran&act=tambahmatapelajaran';\">";
    echo "<br><br><table id='table1' class='gtable sortable'><thead>
          <tr><th>No</th><th>Nama</th><th>Kelas</th><th>Pengajar</th><th>Deskripsi</th><th>Aksi</th></tr></thead>";
    $no=1;
    while ($r=mysqli_fetch_array($tampil_pelajaran)){
       echo "<tr><td>$no</td>             
             <td>$r[nama]</td>";
             $kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas = '$r[id_kelas]'");
             $cek = mysqli_num_rows($kelas);
             if(!empty($cek)){
             while($k=mysqli_fetch_array($kelas)){
                 echo "<td><a href=?module=kelas&act=detailkelas&id=$r[id_kelas] title='Detail Kelas'>$k[nama]</td>";
             }
             }else{
                 echo"<td></td>";
             }
             $pengajar = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM pengajar WHERE id_pengajar = '$r[id_pengajar]'");
             $cek_pengajar = mysqli_num_rows($pengajar);
             if(!empty($cek_pengajar)){
             while($p=mysqli_fetch_array($pengajar)){
             echo "<td><a href=?module=admin&act=detailpengajar&id=$r[id_pengajar] title='Detail Pengajar'>$p[nama_lengkap]</a></td>";
             }
             }else{
                 echo"<td></td>";
             }
             echo "<td>$r[deskripsi]</td>
             <td><a href='?module=matapelajaran&act=editmatapelajaran&id=$r[id]' title='Edit'><img src='images/icons/edit.png' alt='Edit' /></a> |
                <a href=javascript:confirmdelete('$aksi_mapel?module=matapelajaran&act=hapus_mapel_pengajar&id=$r[id]') title='Hapus'><img src='images/icons/cross.png' alt='Delete' /></a>";
      $no++;
    }
    echo "</table>";
        }else{
            echo "<script>window.alert('Tidak ada mata pelajaran yang anda ampu, Kembali ke home untuk menambah mata pelajaran yang diampu');
            window.location=(href='?module=home')</script>";
        }
    }
    elseif ($_SESSION[leveluser]=='siswa'){
        $siswa = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa WHERE id_siswa = $_SESSION[idsiswa]");
        $data_siswa = mysqli_fetch_array($siswa);
        $tampil_pelajaran = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mata_pelajaran WHERE id_kelas = '$data_siswa[id_kelas]'");
        echo"<br><b class='judul'>Daftar Mata Pelajaran di Kelas Anda</b><br><p class='garisbawah'></p>";
        echo "<table>
          <tr><th>No</th><th>Nama</th><th>Pengajar</th><th>Deskripsi</th></tr>";
        $no=1;
        while ($r=mysqli_fetch_array($tampil_pelajaran)){
        echo "<tr><td>$no</td>
             <td>$r[nama]</td>";             
             $pengajar = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM pengajar WHERE id_pengajar = '$r[id_pengajar]'");
             $cek_pengajar = mysqli_num_rows($pengajar);
             if(!empty($cek_pengajar)){
             while($p=mysqli_fetch_array($pengajar)){
             echo "<td><a href=?module=admin&act=detailpengajar&id=$r[id_pengajar] title='Detail Pengajar'>$p[nama_lengkap]</a></td>";
             }
             }else{
                 echo"<td></td>";
             }
             echo "<td>$r[deskripsi]</td>";
        $no++;
        }
        echo "</table>";
    }
    break;

case "tambahmatapelajaran":
    if ($_SESSION[leveluser]=='admin'){
        echo "<form method=POST action='$aksi?module=matapelajaran&act=input_matapelajaran'>
          <fieldset>
          <legend>Tambah Mata Pelajaran</legend>
          <dl class='inline'>
          <dt><label>Id Matapelajaran</label></dt>     <dd>: <input type=text name='id_matapelajaran' size=10></dd>
          <dt><label>Nama</label></dt>                <dd>: <input type=text name='nama' size=30></dd>
          <dt><label>Kelas</label></dt>                <dd>: <select name='id_kelas'>
                                                  <option value=0 selected>--pilih--</option>";
                                                  $tampil=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas ORDER BY nama");
                                                  while($r=mysqli_fetch_array($tampil)){
                                                  echo "<option value=$r[id_kelas]>$r[nama]</option>";
                                                  }echo "</select></dd>
         <dt><label>Pengajar</label></dt>              <dd>: <select name='id_pengajar'>
                                                  <option value=0 selected>--pilih--</option>";
                                                  $tampil_pengajar=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM pengajar ORDER BY nama_lengkap");
                                                  while($p=mysqli_fetch_array($tampil_pengajar)){
                                                  echo "<option value=$p[id_pengajar]>$p[nama_lengkap]</option>";
                                                  }echo "</select></dd>
        <dt><label>Deskripsi</label></dt>             <dd>: <textarea name='deskripsi' id='wysiwyg' class='medium' rows='6'></textarea></td><tr>
          </dl>
          <div class='buttons'>
          <input class='button blue' type=submit value=Simpan>
          <input class='button blue' type=button value=Batal onclick=self.history.back()>
          </div>
          </fieldset></form>";
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
        echo "<form method=POST name='form_materi' action='$aksi?module=matapelajaran&act=input_matapelajaran_pengajar'>          
          <fieldset>
          <legend>Mata Pelajaran yang di ampu</legend>
          <dl class='inline'>
          <dt><label>Kelas </label></dt>             <dd><select name='id_kelas' onChange='showpel()'>
                                          <option value=''>-pilih-</option>";
                                          $pilih="SELECT * FROM kelas ORDER BY id_kelas";
                                          $query=mysqli_query($GLOBALS["___mysqli_ston"], $pilih);
                                          while($row=mysqli_fetch_array($query)){
                                          echo"<option value='".$row[id_kelas]."'>".$row[nama]."</option>";
                                          }
                                          echo"</select></dd>
          <dt><label>Pelajaran </label></dt>          <dd><div id='pelajaran'><select name='id_matapelajaran'></select></div></dd>
          <dt><label>Deskripsi </label></dt>             <dd><textarea name='deskripsi' id='wysiwyg' class='medium' rows='6'></textarea></dd>
          <p align=center><input type=submit class='button blue' value=Simpan>
                      <input type=button class='button blue' value=Batal onclick=self.history.back()></p>
          </dl></fieldset></form>";
    }
    break;

case "editmatapelajaran":
    if ($_SESSION[leveluser]=='admin'){
        $mapel=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mata_pelajaran WHERE id = '$_GET[id]'");
        $m=mysqli_fetch_array($mapel);
        $kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas = '$m[id_kelas]'");
        $k = mysqli_fetch_array($kelas);
        $pengajar = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM pengajar WHERE id_pengajar = '$m[id_pengajar]'");
        $d = mysqli_fetch_array($pengajar);
        
        echo "
          <form method=POST action='$aksi?module=matapelajaran&act=update_matapelajaran'>
          <input type=hidden name=id value='$m[id]'>
          <fieldset>
          <legend>Edit Mata Pelajaran</legend>
          <dl class='inline'>
          <dt><label>Id Matapelajaran</label></dt>     <dd>: <input type=text name='id_matapelajaran' size=10 value='$m[id_matapelajaran]'></dd>
          <dt><label>Nama</label></dt>                 <dd>: <input type=text name='nama' size=30 value='$m[nama]'></dd>
          <dt><label>Kelas</label></dt>                <dd>: <select name='id_kelas'>
                                                  <option value='$k[id_kelas]' selected>$k[nama]</option>";
                                                  $tampil=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas ORDER BY nama");
                                                  while($r=mysqli_fetch_array($tampil)){
                                                  echo "<option value=$r[id_kelas]>$r[nama]</option>";
                                                  }echo "</select></dd>
         <dt><label>Pengajar</label></dt>              <dd>: <select name='id_pengajar'>
                                                  <option value='$d[id_pengajar]' selected>$d[nama_lengkap]</option>";
                                                  $tampil_pengajar=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM pengajar ORDER BY nama_lengkap");
                                                  while($p=mysqli_fetch_array($tampil_pengajar)){
                                                  echo "<option value=$p[id_pengajar]>$p[nama_lengkap]</option>";
                                                  }echo "</select></dd>
        <dt><label>Deskripsi</label></dt>            <dd>: <textarea name='deskripsi' id='wysiwyg' class='medium' rows='6'>$m[deskripsi]</textarea></dd>
        </dl>
          <div class='buttons'>
          <input class='button blue' type=submit value=Update>
          <input class='button blue' type=button value=Batal onclick=self.history.back()>
          </div>
          </fieldset></form>";
    }else{
        $mapel=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mata_pelajaran WHERE id = '$_GET[id]'");
        $m=mysqli_fetch_array($mapel);
        $kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas = '$m[id_kelas]'");
        $k = mysqli_fetch_array($kelas);
        $pengajar = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM pengajar WHERE id_pengajar = '$m[id_pengajar]'");
        $d = mysqli_fetch_array($pengajar);

        echo "<form method=POST name='form_materi' action='$aksi?module=matapelajaran&act=update_matapelajaran_pengajar'>
          <input type=hidden name=id value='$m[id]'>
          <fieldset>
          <legend>Edit Mata Pelajaran</legend>
          <dl class='inline'>
          <dt><label>Kelas </label></dt>             <dd><select name='id_kelas' onChange='showpel()'>
                                          <option value='$k[id_kelas]' selected>$k[nama]</option>";
                                          $pilih="SELECT * FROM kelas ORDER BY nama";
                                          $query=mysqli_query($GLOBALS["___mysqli_ston"], $pilih);
                                          while($row=mysqli_fetch_array($query)){
                                          echo"<option value='".$row[id_kelas]."'>".$row[nama]."</option>";
                                          }
                                          echo"</select></dd>
          <dt><label>Pelajaran </label></dt>         <dd><select id='pelajaran' name='id_matapelajaran'>
                                          <option value='".$m[id_matapelajaran]."' selected>".$m[nama]."</option>
                                          </select></dd>
          <dt><label>Deskripsi </label></dt>         <dd><textarea name='deskripsi' id='wysiwyg' class='medium' rows='6'>$m[deskripsi]</textarea></dd>
          <p align=center><input class='button blue' type=submit value=Simpan>
                      <input class='button blue' type=button value=Batal onclick=self.history.back()></p>
          </dl></fieldset></form>";
    }
    break;
case "detailpelajaran":
    if ($_SESSION[leveluser]=='admin'){
        $detail =mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$_GET[id]'");
        echo "<div class='information msg'>Detail Mata Pelajaran</div>
          <br><table id='table1' class='gtable sortable'><thead>
          <tr><th>No</th><th>Id Mapel</th><th>Nama</th><th>Kelas</th><th>Pengajar</th><th>Deskripsi</th><th>Aksi</th></tr></thead>";
        $no=1;
    while ($r=mysqli_fetch_array($detail)){
       echo "<tr><td>$no</td>
             <td>$r[id_matapelajaran]</td>
             <td>$r[nama]</td>";
             $kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas = '$r[id_kelas]'");
             $cek_kelas = mysqli_num_rows($kelas);
             if(!empty($cek_kelas)){
             while($k=mysqli_fetch_array($kelas)){
                 echo "<td><a href=?module=kelas&act=detailkelas&id=$r[id_kelas] title='Detail Kelas'>$k[nama]</td>";
             }
             }else{
                 echo"<td></td>";
             }
             $pengajar = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM pengajar WHERE id_pengajar = '$r[id_pengajar]'");
             $cek_pengajar = mysqli_num_rows($pengajar);
             if(!empty($cek_pengajar)){
             while($p=mysqli_fetch_array($pengajar)){
             echo "<td><a href=?module=admin&act=detailpengajar&id=$r[id_pengajar] title='Detail Pengajar'>$p[nama_lengkap]</a></td>";
             }
             }else{
                 echo"<td></td>";
             }
             echo "<td>$r[deskripsi]</td>
             <td><a href='?module=matapelajaran&act=editmatapelajaran&id=$r[id]' title='Edit'><img src='images/icons/edit.png' alt='Edit' /></a> |
                 <a href=javascript:confirmdelete('$aksi?module=matapelajaran&act=hapus&id=$r[id]') title='Hapus'><img src='images/icons/cross.png' alt='Delete' /></a></td></tr>";
      $no++;
    }
    echo "</table>
    <div class='buttons'>
    <br><input class='button blue' type=button value=Kembali onclick=self.history.back()>
    </div>";
    }else{
      $detail =mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$_GET[id]'");
        echo "<span class='judulhead'><p class='garisbawah'>Detail Mata Pelajaran</p></span>
          <table>
          <tr><th>no</th><th>nama</th><th>kelas</th><th>pengajar</th><th>deskripsi</th></tr>";
                    $no=1;
    while ($r=mysqli_fetch_array($detail)){
       echo "<tr><td>$no</td>             
             <td>$r[nama]</td>";
             $kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas = '$r[id_kelas]'");
             $cek_kelas = mysqli_num_rows($kelas);
             if(!empty($cek_kelas)){
             while($k=mysqli_fetch_array($kelas)){
                 echo "<td><a href=?module=kelas&act=detailkelas&id=$r[id_kelas] title='Detail Kelas'>$k[nama]</td>";
             }
             }else{
                 echo"<td></td>";
             }
             $pengajar = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM pengajar WHERE id_pengajar = '$r[id_pengajar]'");
             $cek_pengajar = mysqli_num_rows($pengajar);
             if(!empty($cek_pengajar)){
             while($p=mysqli_fetch_array($pengajar)){
             echo "<td><a href=?module=admin&act=detailpengajar&id=$r[id_pengajar] title='Detail Pengajar'>$p[nama_lengkap]</a></td>";
             }
             }else{
                 echo"<td></td>";
             }
             echo "<td>$r[deskripsi]</td></tr>";
             
      $no++;
    }
    echo "</table>
    <input type=button value=Kembali onclick=self.history.back()>";
    }
    break;
}
}
?>
