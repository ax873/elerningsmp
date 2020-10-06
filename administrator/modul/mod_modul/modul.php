
<script>
function confirmdelete(delUrl) {
if (confirm("Anda yakin ingin menghapus?")) {
document.location = delUrl;
}
}
</script>

<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href=../css/style.css rel=stylesheet type=text/css>";
  echo "<div class='error msg'>Untuk mengakses Modul anda harus login.</div>";
}
else{
$aksi="modul/mod_modul/aksi_modul.php";
switch($_GET[act]){
  // Tampil Modul
  default:
    if ($_SESSION[leveluser]=='admin'){
    echo "<h2>Manajemen Modules</h2><hr>
          <input class='button blue' type=button value='Tambah Module' onclick=\"window.location.href='?module=modul&act=tambahmodul';\"><br /><br />
          <div class='information msg'>
          Apabila Publish = Y, maka Modul ditampilkan di halaman pengunjung.<br>
          Apabila Aktif = Y, maka Modul ditampilkan di halaman administrator pada daftar menu yang berada di bagian kiri.</div>

          <br><table id='table1' class='gtable sortable'><thead>
          <tr><th>No</th><th>Nama Modul</th><th>Link</th><th>Publish</th><th>Aktif</th><th>Status</th><th>Aksi</th></tr></thead>";
    $tampil=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM modul ORDER BY urutan");
    while ($r=mysqli_fetch_array($tampil)){
      echo "<tr><td>$r[urutan]</td>
            <td>$r[nama_modul]</td>
            <td><a href=$r[link]>$r[link]</a></td>
            <td align=center>$r[publish]</td>
            <td align=center>$r[aktif]</td>";
            if ($r[status]=='admin'){
                echo "<td>Administrator</td>";
            }else{
                echo "<td>Teacher</td>";
            }
            echo"<td><a href='?module=modul&act=editmodul&id=$r[id_modul]' title='Edit'><img src='images/icons/edit.png' alt='Edit' /></a> |
                <a href=javascript:confirmdelete('$aksi?module=modul&act=hapus&id=$r[id_modul]') title='Hapus'><img src='images/icons/cross.png' alt='Delete' /></a>
            </td></tr>";
    }
    echo "</table>";
    }else{
        echo "<link href=../css/style.css rel=stylesheet type=text/css>";
        echo "<div class='error msg'>Anda tidak berhak mengakses halaman ini.</div>";
    }
    break;

  case "tambahmodul":
    if ($_SESSION[leveluser]=='admin'){
    echo "<form  class='uniform' method=POST action='$aksi?module=modul&act=input'>
          <fieldset>
          <legend>Tambah Module</legend>
          <dl class='inline'>          
          <dt><label>Nama Modul</label></dt> <dd> : <input type=text name='nama_modul'></dd>
          <dt><label>Link</label></dt>       <dd> : <input type=text name='link' size=30></dd>
          <dt><label>Publish</label></dt>    <dd> : <label><input type=radio name='publish' value='Y' checked>Y </label>
                                                    <label><input type=radio name='publish' value='N'> N</label></dd>
          <dt><label>Aktif</label></dt>      <dd> : <label><input type=radio name='aktif' value='Y' checked>Y</label>
                                                    <label><input type=radio name='aktif' value='N'> N</label></dd>
          <dt><label>Status</label></dt>     <dd> : <label><input type=radio name='status' value='admin' checked>Administrator</label>
                                                    <label><input type=radio name='status' value='pengajar'>Pengajar</label></dd>
          </dl>
          <div class='buttons'>
          <input class='button blue' type=submit value=Simpan>
          <input class='button blue' type=button value=Batal onclick=self.history.back()>
          </div>
          </fieldset></form>";
    }else{
        echo "<link href=../css/style.css rel=stylesheet type=text/css>";
       echo "<div class='error msg'>Anda tidak berhak mengakses halaman ini.</div>";
    }
     break;
 
  case "editmodul":
    if ($_SESSION[leveluser]=='admin'){
    $edit = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM modul WHERE id_modul='$_GET[id]'");
    $r    = mysqli_fetch_array($edit);

    echo "<form class='uniform' method='POST' action='$aksi?module=modul&act=update'>
          <input type=hidden name=id value='$r[id_modul]'>
          <fieldset>
          <legend>Edit Module</legend>
          <dl class='inline'>
          <dt><label>Nama Modul</label></dt>     <dd> : <input type=text name='nama_modul' value='$r[nama_modul]'></dd>
          <dt><label>Link</label></dt>           <dd> : <input type=text name='link' size=30 value='$r[link]'></dd>";
    if ($r[publish]=='Y'){
      echo "<dt><label>Publish</label></dt>       <dd> : <label><input type=radio name='publish' value='Y' checked>Y</label>
                                                        <label><input type=radio name='publish' value='N'> N</label>
                                                 </dd>";
    }
    else{
      echo "<dt><label>Publish</label></dt>       <dd> : <label><input type=radio name='publish' value='Y'>Y</label>
                                                        <label><input type=radio name='publish' value='N' checked> N</label>
                                                 </dd>";
    }
    if ($r[aktif]=='Y'){
      echo "<dt><label>Aktif</label></dt>         <dd> : <lebel><input type=radio name='aktif' value='Y' checked>Y</label>
                                                        <label><input type=radio name='aktif' value='N'> N</label>
                                                 </dd>";
    }
    else{
       echo "<dt><label>Aktif</label></dt>        <dd> : <lebel><input type=radio name='aktif' value='Y'>Y</label>
                                                        <label><input type=radio name='aktif' value='N' checked> N</label>
                                                 </dd>";
    }
    if ($r[status]=='pengajar'){
      echo "<dt><label>Status</label></dt>       <dd> : <label><input type=radio name='status' value='pengajar' checked>Pengajar</label>
                                                        <label><input type=radio name='status' value='admin'> Administrator</label>
                                                 </dd>";
    }
    else{
      echo "<dt><label>Status</label></dt>       <dd> : <label><input type=radio name='status' value='pengajar'>Pengajar</label>
                                                        <label><input type=radio name='status' value='admin' checked>Administrator</label>
                                                 </dd>";
    }
    echo "<dt><label>Order</label></dt>         <dd> : <input type=text name='urutan' size=1 value='$r[urutan]'></dd>
          </dl>
          <div class='buttons'>
          <input class='button blue' type=submit value=Update>
          <input class='button blue' type=button value=Batal onclick=self.history.back()>
          </div>
          </fieldset></form>";
    }else{
        echo "<link href=../css/style.css rel=stylesheet type=text/css>";
        echo "<div class='error msg'>Anda tidak berhak mengakses halaman ini.</div>";
    }
    break;  
}
}
?>
