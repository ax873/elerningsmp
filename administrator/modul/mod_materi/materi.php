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
 $query1 = "SELECT * FROM kelas";
 $hasil1 = mysqli_query($GLOBALS["___mysqli_ston"], $query1);

 // membuat if untuk masing-masing pilihan kelas beserta isi option untuk combobox kedua
 while ($data1 = mysqli_fetch_array($hasil1))
 {
   $idkelas = $data1['id_kelas'];

   // membuat IF untuk masing-masing kelas
   echo "if (document.form_materi_pengajar.id_kelas.value == \"".$idkelas."\")";
   echo "{";

   // membuat option matapelajaran untuk masing-masing kelas
   $query2 = "SELECT * FROM mata_pelajaran WHERE  id_kelas = '$idkelas' AND id_pengajar ='$_SESSION[idpengajar]' ";
   $hasil2 = mysqli_query($GLOBALS["___mysqli_ston"], $query2);
   $content = "document.getElementById('pelajaran_pengajar').innerHTML = \"<select name='".id_matapelajaran."'>";
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
function fsize($file){
                            $a = array("B", "KB", "MB", "GB", "TB", "PB");
                            $pos = 0;
                            $size = filesize($file);
                            while ($size >= 1024)
                            {
                            $size /= 1024;
                            $pos++;
                            }
                            return round ($size,2)." ".$a[$pos];
                            }
?>

<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href=../css/style.css rel=stylesheet type=text/css>";
  echo "<div class='error msg'>Untuk mengakses Modul anda harus login.</div>";
}
else{



$aksi="modul/mod_materi/aksi_materi.php";
switch($_GET[act]){
  // Tampil kelas
  default:
    if ($_SESSION[leveluser]=='admin'){
                
        $tampil_materi = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM file_materi ORDER BY id_kelas");
        $cek_materi = mysqli_num_rows($tampil_materi);
        if(!empty($cek_materi)){
        echo "<h2>Manajemen Materi</h2><hr>
          <input class='button blue' type=button value='Tambah Materi' onclick=\"window.location.href='?module=materi&act=tambahmateri';\">";

        echo "<br><br><table id='table1' class='gtable sortable'><thead>
          <tr><th>No</th><th>Judul</th><th>Kelas</th><th>Pelajaran</th><th>Nama File</th><th>Tgl Posting</th><th>Pembuat</th><th>Hits</th><th>Aksi</th></tr></thead>";
       $no=1;
    while ($r=mysqli_fetch_array($tampil_materi)){
      $tgl_posting   = tgl_indo($r[tgl_posting]);
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
             while($p=mysqli_fetch_array($pelajaran)){
                echo "<td><a href=?module=matapelajaran&act=detailpelajaran&id=$r[id_matapelajaran] title='Detail pelajaran'>$p[nama]</a></td>";
             }
             }else{
                 echo"<td></td>";
             }

             echo "<td>$r[nama_file]</td>
             <td>$tgl_posting</td>";
             $pelajaran2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$r[id_matapelajaran]'");
             $p2 = mysqli_fetch_array($pelajaran2);
             $pengajar2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM pengajar WHERE id_pengajar = '$p2[id_pengajar]'");
             $cek_pengajar2 = mysqli_num_rows($pengajar2);
             if(!empty($cek_pengajar2)){
                 while ($p3= mysqli_fetch_array($pengajar2)){
                 echo "<td><a href=?module=admin&act=detailpengajar&id=$p3[id_pengajar] title='Detail Pengajar'>$p3[nama_lengkap]</a></td>";
             }
             }else{
                 echo "<td>$r[pembuat]</td>";
             }
             echo"<td>$r[hits]</td>
             <td><a href='?module=materi&act=editmateri&id=$r[id_file]' title='Edit'><img src='images/icons/edit.png' alt='Edit' /></a> |
                 <a href=javascript:confirmdelete('$aksi?module=materi&act=hapus&id=$r[id_file]') title='Hapus'><img src='images/icons/cross.png' alt='Delete' /></a></td></tr>";
      $no++;
    }
    echo "</table>";
 
    }else{
        echo "<script>window.alert('Tidak ada materi');
            window.location=(href='?module=home')</script>";
    }
    }
   
 elseif ($_SESSION[leveluser]=='pengajar'){        

    $cek_materi = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM file_materi WHERE pembuat = '$_SESSION[idpengajar]'");
    
     echo "<h2>Daftar Materi Yang Anda Upload</h2><hr>
          <input class='button blue' type=button value='Tambah Materi' onclick=\"window.location.href='?module=materi&act=tambahmateri';\">";
     echo "<br><br><table id='table1' class='gtable sortable'><thead>
          <tr><th>No</th><th>Judul</th><th>Kelas</th><th>Pelajaran</th><th>Nama File</th><th>Tgl Upload</th><th>Hits</th><th>Aksi</th></tr></thead>";

    $no=1;
    while ($r=mysqli_fetch_array($cek_materi)){
      $tgl_posting   = tgl_indo($r[tgl_posting]);
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
             while($p=mysqli_fetch_array($pelajaran)){
                echo "<td><a href=?module=matapelajaran&act=detailpelajaran&id=$r[id_matapelajaran] title='Detail pelajaran'>$p[nama]</a></td>";
             }
             }else{
                 echo"<td></td>";
             }

             echo "<td>$r[nama_file]</td>
             <td>$tgl_posting</td>             
             <td>$r[hits]</td>
             <td><a href='?module=materi&act=editmateri&id=$r[id_file]' title='Edit'><img src='images/icons/edit.png' alt='Edit' /></a>  |
            <a href=javascript:confirmdelete('$aksi?module=materi&act=hapus&id=$r[id_file]') title='Hapus'><img src='images/icons/cross.png' alt='Delete' /></a></td></tr>";
                 

     $no++;
    }
    echo"</table>";   
    
    }
    
    else{
        echo"<br><b class='judul'>Materi</b><br><p class='garisbawah'></p>";

        $ambil_siswa = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa WHERE id_siswa = '$_SESSION[idsiswa]'");
        $data_siswa = mysqli_fetch_array($ambil_siswa);

        $mapel = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mata_pelajaran WHERE id_kelas = '$data_siswa[id_kelas]'");
       echo "<table>
          <tr><th>No</th><th>Mata Pelajaran</th><th>Materi</th></tr>";
        $no=1;
        while ($r=mysqli_fetch_array($mapel)){
        echo "<tr><td>$no</td>
             <td>$r[nama]</td>";
             echo "<td><input type=button class='tombol' value='Lihat File Materi'
                       onclick=\"window.location.href='?module=materi&act=daftarmateri&id=$r[id_matapelajaran]';\"></td></tr>";
        $no++;
        }
        echo "</table>";


    }
    break;


case "daftarmateri":
    if ($_SESSION[leveluser] == 'siswa'){
        
        $p      = new Paging;
        $batas  = 5;
        $posisi = $p->cariPosisi($batas);

        $mapel = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$_GET[id]'");
        $data_mapel = mysqli_fetch_array($mapel);
        $materi = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM file_materi WHERE id_matapelajaran = '$_GET[id]' LIMIT $posisi,$batas ");
        $cek_materi = mysqli_num_rows($materi);
        if (!empty($cek_materi)){
        echo"<br><b class='judul'>Daftar File Materi $data_mapel[nama] </b><br><p class='garisbawah'></p>";
        echo "<table>";
        $no=$posisi+1;
        while ($r=mysqli_fetch_array($materi)){
        echo "<tr><td rowspan='5'>$no</td>";
             if (!empty($r[nama_file])){
             $pecah = explode(".", $r[nama_file]);
             $ekstensi = $pecah[1];
             if ($ekstensi == 'zip'){
                 echo "<td rowspan='5'><img src='images/zip.png'></td>";
             }
             elseif ($ekstensi == 'rar'){
                 echo "<td rowspan='5'><img src='images/rar.png'></td>";
             }
             elseif ($ekstensi == 'doc'){
                 echo "<td rowspan='5'><img src='images/doc.png'></td>";
             }
             elseif ($ekstensi == 'pdf'){
                 echo "<td rowspan='5'><img src='images/pdf.png'></td>";
             }
             elseif ($ekstensi == 'ppt'){
                 echo "<td rowspan='5'><img src='images/ppt.png'></td>";
             }
             elseif ($ekstensi == 'pptx'){
                 echo "<td rowspan='5'><img src='images/pptx.png'></td>";
             }
             elseif ($ekstensi == 'docx'){
                 echo "<td rowspan='5'><img src='images/doc.png'></td>";
             }
             }else{
                 echo "<td rowspan='5'><img src='images/kosong.png'></td>";
             }
             echo "<td>Judul</td><td>: $r[judul]</td></tr>
             <tr><td>Nama File</td><td>: $r[nama_file]</td></tr>
             <tr><td>Ukuran</td>";
                            if (!empty($r[nama_file])){
                            $file = "files_materi/$r[nama_file]";                            
                            echo "<td>: ". fsize($file)."</td></tr>";
                            }else{
                                echo "<td>: </td></tr>";
                            }
             echo"<tr><td>Tanggal Posting</td><td>: $r[tgl_posting]</td></tr>
             <tr><td colspan=2><input type=button class='tombol' value='Download File'
                       onclick=\"window.location.href='downlot.php?file=$r[nama_file]';\">
                       <b class='judul'>Di download : $r[hits] kali</b></td></tr>";
        $no++;
        }
        echo "</table>";
        $jmldata=mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM file_materi WHERE id_matapelajaran = '$_GET[id]'"));
        $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
        $linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);

        echo "<div id=paging>$linkHalaman</div><br>";

        echo "<p class='garisbawah'></p><input type=button class='tombol' value='Kembali'
          onclick=self.history.back()>";
    }
    else{
        echo "<script>window.alert('Tidak ada file materi di mata pelajaran ini?');
            window.location=(href='media.php?module=materi')</script>";
    }
    }
    break;

case "tambahmateri":
    if ($_SESSION[leveluser]=='admin'){
    echo "<form name='form_materi' method=POST action='$aksi?module=materi&act=input_materi' enctype='multipart/form-data'>
     <fieldset>
     <legend>Tambah Materi</legend>
     <dl class='inline'>
    <dt><label>Judul</label></dt>              <dd><input type=text name='judul' size=50></dd>
    <dt><label>Kelas</label></dt>              <dd><select name='id_kelas' onChange='showpel()'>
                                          <option value=''>-pilih-</option>";                                          
                                          $cari_kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas ORDER BY nama");
                                          while ($k=mysqli_fetch_array($cari_kelas)){
                                          echo"<option value='".$k[id_kelas]."'>".$k[nama]."</option>";
                                          }                                          
                                          echo"</select></dd>
    <dt><label>Pelajaran</label></dt>          <dd><div id='pelajaran'></div></dd>
    <dt><label>File</label></dt>               <dd><input type=file name='fupload' size=40></dd>
    </dl>
          
          <p align=center><input class='button blue' type=submit value=Simpan>
          <input class='button blue' type=button value=Batal onclick=self.history.back()></p>
          
          </fieldset></form>";
    }else{
    echo "
    <form name='form_materi_pengajar' method=POST action='$aksi?module=materi&act=input_materi' enctype='multipart/form-data'>
    <fieldset>
    <legend>Tambah Materi</legend>
    <dl class='inline'>
    <dt><label>Judul</label></dt>              <dd> <input type=text name='judul' size=50></dd>
    <dt><label>Kelas</label></dt>              <dd> <select name='id_kelas' onChange='showpel_pengajar()'>
                                          <option value='0' selected>-pilih-</option>";
                                          $pilih= mysqli_query($GLOBALS["___mysqli_ston"], "SELECT DISTINCT id_kelas FROM mata_pelajaran WHERE id_pengajar ='$_SESSION[idpengajar]'");
                                          while($row=mysqli_fetch_array($pilih)){
                                          $cari_kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas = '$row[id_kelas]'");
                                          while ($k=mysqli_fetch_array($cari_kelas)){
                                          echo"<option value='".$k[id_kelas]."'>".$k[nama]."</option>";
                                          }
                                          }
                                          echo"</select></dd>
    <dt><label>Pelajaran</label></dt>          <dd> <div id='pelajaran_pengajar'></div></dd>
    <dt><label>File</label></dt>              <dd> <input type=file name='fupload' size=35></dd>
    <p align=center><input class='button blue' type=submit value=Simpan>
                      <input class='button blue' type=button value=Batal onclick=\"window.location.href='?module=materi';\"></p>
    </dl></fieldset></form>";
    }
    break;

case "editmateri":
    if ($_SESSION[leveluser]=='admin'){
    $edit=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM file_materi WHERE id_file = '$_GET[id]'");
    $m=mysqli_fetch_array($edit);
    $isikelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas = '$m[id_kelas]'");
    $k=mysqli_fetch_array($isikelas);
    $pelajaran = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$m[id_matapelajaran]'");
    $p=mysqli_fetch_array($pelajaran);

    echo "
    <form name='form_materi' method=POST action='$aksi?module=materi&act=edit_materi' enctype='multipart/form-data'>
    <input type=hidden name=id value='$m[id_file]'>
    <fieldset>
     <legend>Edit Materi</legend>
     <dl class='inline'>
    <dt><label>Judul</label></dt>             <dd>: <input type=text name='judul' value='$m[judul]'></dd>
    <dt><label>Kelas</label></dt>               <dd>: <select name='id_kelas' onChange='showpel()'>
                                          <option value='".$k[id_kelas]."' selected>".$k[nama]."</option>";
                                          $pilih="SELECT * FROM kelas ORDER BY nama";
                                          $query=mysqli_query($GLOBALS["___mysqli_ston"], $pilih);
                                          while($row=mysqli_fetch_array($query)){
                                          echo"<option value='".$row[id_kelas]."'>".$row[nama]."</option>";
                                          }
                                          echo"</select></dd>
    <dt><label>Pelajaran</label></dt>           <dd>: <select id='pelajaran' name='id_matapelajaran'>
                                          <option value='".$p[id_matapelajaran]."' selected>".$p[nama]."</option>
                                          </select></dd>
    <dt><label>File</label></dt>                <dd>: $m[nama_file]</dd>
    <dt><label>Ganti File</label></dt>         <dd>: <input type=file name='fupload' size=40>
                                                     <small>Apabila file tidak diganti, di kosongkan saja</small></dd>
    </dl>

          <p align=center><input class='button blue' type=submit value=Update>
          <input class='button blue' type=button value=Batal onclick=self.history.back()></p>

          </fieldset></form>";
    }
    else{
    $edit=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM file_materi WHERE id_file = '$_GET[id]'");
    $m=mysqli_fetch_array($edit);
    $isikelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas = '$m[id_kelas]'");
    $k=mysqli_fetch_array($isikelas);
    $pelajaran = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$m[id_matapelajaran]'");
    $p=mysqli_fetch_array($pelajaran);

    echo "<form name='form_materi_pengajar' method=POST action='$aksi?module=materi&act=edit_materi' enctype='multipart/form-data'>
    <input type=hidden name=id value='$m[id_file]'>
    <fieldset>
    <legend>Edit Materi</legend>
    <dl class='inline'>
    <dt><label>Judul</label></dt>              <dd>: <input type=text name='judul' value='$m[judul]' size=50></dd>
    <dt><label>Kelas</label></dt>              <dd>: <select name='id_kelas' onChange='showpel_pengajar()'>
                                          <option value='".$k[id_kelas]."' selected>".$k[nama]."</option>";
                                          $pilih="SELECT * FROM kelas WHERE id_pengajar = '$_SESSION[idpengajar]'";
                                          $query=mysqli_query($GLOBALS["___mysqli_ston"], $pilih);
                                          while($row=mysqli_fetch_array($query)){
                                          echo"<option value='".$row[id_kelas]."'>".$row[nama]."</option>";
                                          }
                                          echo"</select></dd>
    <dt><label>Pelajaran</label></dt>          <dd>: <select id='pelajaran_pengajar' name='id_matapelajaran'>
                                          <option value='".$p[id_matapelajaran]."' selected>".$p[nama]."</option>
                                          </select></dd>
    <dt><label>File</label></dt>              <dd>: $m[nama_file]</dd>
    <dt><label>Ganti File</label></dt>        <dd>: <input type=file name='fupload' size=40>
    <small>Apabila file tidak diganti, di kosongkan saja</small></dd>
    <p align=center><input class='button blue' type=submit value=Simpan>
                      <input class='button blue' type=button value=Batal onclick=self.history.back()></p>
    </dl></fieldset></form>";
    }
    break;

}
}
?>
