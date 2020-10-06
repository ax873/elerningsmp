<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href=../css/style.css rel=stylesheet type=text/css>";
  echo "<div class='error msg'>Untuk mengakses Modul anda harus login.</div>";
}
else{

include "../../../configurasi/class_paging.php";

$aksi="modul/mod_siswa/aksi_siswa.php";
$aksi_siswa = "administrator/modul/mod_siswa/aksi_siswa.php";
switch($_GET[act]){
  // Tampil Siswa
  default:
    if ($_SESSION[leveluser]=='admin'){

     $p      = new paging_paging;
     $batas  = 20;
     $posisi = $p->cariPosisi($batas);

      $tampil_siswa = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa ORDER BY id_kelas LIMIT $posisi,$batas");
      echo "<h2>Manajemen Siswa</h2><hr>
          <input class='button blue' type=button value='Tambah Siswa' onclick=\"window.location.href='?module=siswa&act=tambahsiswa';\">";
      echo "<br><br><div class='information msg'>Siswa tidak bisa di hapus, tapi bisa di non aktifkan.</div>";
      echo "<br><table id='table1' class='gtable sortable'><thead>
          <tr><th>No</th><th>Nis</th><th>Nama</th><th>Kelas</th><th>Jenis Kelamin</th>
            <th>Blokir</th><th>Aksi</th></tr></thead>";
      $no = $posisi+1;
    while ($r=mysqli_fetch_array($tampil_siswa)){
       echo "<tr><td>$no</td>
             <td>$r[nis]</td>
             <td>$r[nama_lengkap]</td>";
             $kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas = '$r[id_kelas]'");
             while($k=mysqli_fetch_array($kelas)){
             echo"<td><a href=?module=kelas&act=detailkelas&id=$r[id_kelas] title='Detail Kelas'>$k[nama]</a></td>";
             }
             echo"<td><p align='center'>$r[jenis_kelamin]</p></td>             
             <td><p align='center'>$r[blokir]</p></td>
             <td><a href='?module=siswa&act=editsiswa&id=$r[id_siswa]' title='Edit'><img src='images/icons/edit.png' alt='Edit' /></a> |
                 <a href=?module=detailsiswa&act=detailsiswa&id=$r[id_siswa]>Detail</a></td></tr>";
      $no++;
    }
    echo "</table>";
    $jmldata=mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa"));
    $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
    $linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);

    echo "<br><div id=paging>$linkHalaman</div><br>";
    }
    break;

case "lihatmurid":
    if ($_SESSION[leveluser]=='admin'){
    $p      = new paging_lihatmurid;
    $batas  = 20;
    $posisi = $p->cariPosisi($batas);

    $tampil = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa WHERE id_kelas = '$_GET[id]' ORDER BY nama_lengkap LIMIT $posisi,$batas");
    $cek_siswa = mysqli_num_rows($tampil);
    if(!empty($cek_siswa)){
    echo "<div class='information msg'>Daftar Siswa</div>
          <br><table id='table1' class='gtable sortable'><thead>
          <tr><th>No</th><th>Nis</th><th>Nama</th><th>Kelas</th><th>Jenis Kelamin</th>
            <th>Blokir</th><th>Aksi</th></tr></thead>";
     $no=$posisi+1;
    while ($r=mysqli_fetch_array($tampil)){
       echo "<tr><td>$no</td>
             <td>$r[nis]</td>
             <td>$r[nama_lengkap]</td>
             ";
             $kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas = '$r[id_kelas]'");
             while($k=mysqli_fetch_array($kelas)){
             echo"<td><a href=?module=kelas&act=detailkelas&id=$k[id_kelas]>$k[nama]</a></td>";
             }
             echo "<td><p align='center'>$r[jenis_kelamin]</p></td>             
             <td><p align='center'>$r[blokir]</p></td>
             <td><a href='?module=siswa&act=editsiswa&id=$r[id_siswa]' title='Edit'><img src='images/icons/edit.png' alt='Edit' /></a> |
                 <a href=?module=detailsiswa&act=detailsiswa&id=$r[id_siswa]>Detail Siswa</a></td></tr>";
      $no++;
    }
    echo "</table>";
    
    $jmldata=mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa"));
    $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
    $linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);

    echo "<br><div id=paging>$linkHalaman</div><br>";
    echo "<div class='buttons'><input class='button blue' type=button value=Kembali onclick=self.history.back()></div>";
    }else{
        echo "<script>window.alert('Tidak ada siswa dikelas ini');
            window.location=(href='?module=kelas')</script>";
    }
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
    $p      = new paging_lihatmurid;
    $batas  = 20;
    $posisi = $p->cariPosisi($batas);

    $tampil = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa WHERE id_kelas = '$_GET[id]' ORDER BY nama_lengkap LIMIT $posisi,$batas");
    $cek_siswa = mysqli_num_rows($tampil);
    if(!empty($cek_siswa)){
    echo "<form>
          <fieldset>
          <legend>Daftar Siswa</legend>
          <dl class='inline'>";
    echo "<table id='table1' class='gtable sortable'><thead>
          <tr><th>No</th><th>Nis</th><th>Nama</th><th>Kelas</th><th>Jenis Kelamin</th>
           <th>Aksi</th></tr></thead>";
     $no=1;
    while ($r=mysqli_fetch_array($tampil)){
       echo "<tr><td>$no</td>
             <td>$r[nis]</td>
             <td>$r[nama_lengkap]</td>";
             $kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas = '$r[id_kelas]'");
             while($k=mysqli_fetch_array($kelas)){
             echo"<td><a href=?module=kelas&act=detailkelas&id=$k[id_kelas]>$k[nama]</a></td>";
             }
             echo "<td><p align='center'>$r[jenis_kelamin]</p></td>                       
             <td><input type=button class='button small white' value='Detail Siswa' onclick=\"window.location.href='?module=detailsiswapengajar&act=detailsiswa&id=$r[id_siswa]';\">";
      $no++;
    }
    echo "</table>";
    $jmldata=mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa"));
    $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
    $linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);

    echo "<br><div id=paging>$linkHalaman</div><br>
    <input type=button class='button blue' value=Kembali onclick=self.history.back()>";
    }else{
        echo "<script>window.alert('Tidak ada siswa dikelas ini');
            window.location=(href='?module=kelas')</script>";
    }
    }
    else{
    $p      = new paging_lihatmurid;
    $batas  = 20;
    $posisi = $p->cariPosisi($batas);

    $tampil = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa WHERE id_kelas = '$_GET[id]' ORDER BY nama_lengkap LIMIT $posisi,$batas");
    $cek_siswa = mysqli_num_rows($tampil);
    if(!empty($cek_siswa)){
    echo"<br><b class='judul'>Daftar Teman</b><br><p class='garisbawah'></p>";
    echo "<table>
          <tr><th>No</th><th>Nis</th><th>Nama</th><th>Jenis Kelamin</th><th>Th Masuk</th>
           <th>Aksi</th></tr>";
     $no=1;
    while ($r=mysqli_fetch_array($tampil)){
       echo "<tr><td>$no</td>
             <td>$r[nis]</td>
             <td>$r[nama_lengkap]</td>             
             <td>$r[jenis_kelamin]</td>
             <td>$r[th_masuk]</td>
             <td><input type=button class='tombol' value='Detail Siswa'
                 onclick=\"window.location.href='?module=siswa&act=detailsiswa&id=$r[id_siswa]';\">";
      $no++;
    }
    echo "</table>";
    $jmldata=mysqli_num_rows(mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa"));
    $jmlhalaman  = $p->jumlahHalaman($jmldata, $batas);
    $linkHalaman = $p->navHalaman($_GET[halaman], $jmlhalaman);

    echo "<div id=paging>$linkHalaman</div><br>
          <p class='garisbawah'></p>
          <input type=button class='tombol' value='Kembali'
          onclick=self.history.back()>";
    }else{
        echo "<script>window.alert('Tidak ada siswa dikelas ini');
            window.location=(href='?module=kelas')</script>";
    }
    }
    break;

case "tambahsiswa":
    if ($_SESSION[leveluser]=='admin'){
        $tampil = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa WHERE id_siswa = '$_GET[id]'");
       
        echo "
          <form method=POST action='$aksi?module=siswa&act=input_siswa' enctype='multipart/form-data'>
          <fieldset>
          <legend>Tambah Siswa</legend>
          <dl class='inline'>
          <dt><label>Nis</label></dt>          <dd> : <input type=text name='nis'></dd>
          <dt><label>Nama Lengkap</label></dt> <dd> : <input type=text name='nama_lengkap' size=30></dd>
          <dt><label>Username Login</label></dt>     <dd> : <input type=text name='username'></dd>
          <dt><label>Password Login</label></dt>     <dd> : <input type=text name='password'></dd>
          <dt><label>Kelas</label></dt>        <dd> : <select name='id_kelas'>
                                           <option value=0 selected>--pilih--</option>";
                                           $tampil=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas ORDER BY id_kelas");
                                           while($r=mysqli_fetch_array($tampil)){
                                           echo "<option value=$r[id_kelas]>$r[nama]</option>";
                                           }echo "</select></dd>
          <dt><label>Jabatan </label></dt>     <dd> : <input type=text name='jabatan' size=50></dd>
          <dt><label>Alamat</label></dt>       <dd> : <input type=text name='alamat' size=70></dd>
          <dt><label>Tempat Lahir</label></dt> <dd> : <input type=text name='tempat_lahir' size=50></dd>
          <dt><label>Tanggal Lahir</label></dt><dd> : ";
          combotgl(1,31,'tgl',$tgl_skrg);
          combonamabln(1,12,'bln',$bln_sekarang);
          combothn(1950,$thn_sekarang,'thn',$thn_sekarang);

    echo "</dd>
          <dt><label>Jenis Kelamin</label></dt><dd> : <label><input type=radio name='jk' value='L'>Laki - Laki</input></label>
                                           <label><input type=radio name='jk' value='P'>Perempuan</input></label></dd>
          <dt><label>Agama</label></dt>        <dd> : <select name=agama>
                                           <option value='0' selected>--pilih--</option>
                                           <option value='Islam'>Islam</option>
                                           <option value='Kristen'>Kristen</option>
                                           <option value='Katolik'>Katolik</option>
                                           <option value='Hindu'>Hindu</option>
                                           <option value='Buddha'>Buddha</option>
                                           </select></dd>
          <dt><label>Nama Ayah/Wali</label></dt> <dd> : <input type=text name='nama_ayah' size=30></dd>
          <dt><label>Nama Ibu</label></dt>     <dd> : <input type=text name='nama_ibu' size=30></dd>
          <dt><label>Tahun Masuk</label></dt>  <dd> : <input type=text name='th_masuk' size=10></dd>
          <dt><label>Email</label></dt>        <dd> : <input type=text name='email' size=30></dd>
          <dt><label>No Telp/HP</label></dt>   <dd> : <input type=text name='no_telp' size=20></dd>
          <dt><label>Foto</label></dt>       <dd> : <input type=file name='fupload' size=40>
                                           <small>Tipe foto harus JPG/JPEG dan ukuran lebar maks: 400 px</small></dd>
          <dt><label>Blokir</label></dt>       <dd> : <label><input type=radio name='blokir' value='Y'> Y</label>
                                           <label><input type=radio name='blokir' value='N' checked> N </label></dd>
          </dl>
          <div class='buttons'>
          <input class='button blue' type=submit value=Simpan>
          <input class='button blue' type=button value=Batal onclick=self.history.back()>
          </div>
          </fieldset></form>";
    }
    break;

  case "nis_ada":
     if ($_SESSION[leveluser]=='admin'){
         echo "<span class='judulhead'><p class='garisbawah'>NIS SUDAH PERNAH DIGUNAKAN<br>
               <input type=button value=Kembali onclick=self.history.back()></p></span>";
     }
     break;

  case "editsiswa":
    $edit=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa WHERE id_siswa='$_GET[id]'");
    $r=mysqli_fetch_array($edit);
    $get_kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas = '$r[id_kelas]'");
    $kelas = mysqli_fetch_array($get_kelas);

    if ($_SESSION[leveluser]=='admin'){
    echo "<form method=POST action=$aksi?module=siswa&act=update_siswa enctype='multipart/form-data'>
          <input type=hidden name=id value='$r[id_siswa]'>
          <fieldset>
          <legend>Edit Siswa</legend>
          <dl class='inline'>
          <dt><label>Nis</label></dt>     <dd> : <input type=text name=nis value='$r[nis]'></dd>
          <dt><label>Nama</label></dt>     <dd> : <input type=text name='nama' value='$r[nama_lengkap]' size=70></dd>
          <dt><label>Username Login</label></dt>     <dd> : <input type=text name='username' value='$r[username_login]'></dd>
          <dt><label>Password Login</label></dt> <dd> : <input type=text name='password' size=30><small>Apabila password tidak diubah, dikosongkan saja</small></dd>
          <dt><label>Kelas</label></dt>        <dd> : <select name='id_kelas'>
                                           <option value=$kelas[id_kelas] selected>$kelas[nama]</option>";
                                           $tampil=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas ORDER BY nama");
                                           while($k=mysqli_fetch_array($tampil)){
                                           echo "<option value=$k[id_kelas]>$k[nama]</option>";
                                           }echo "</select></dd>
          <dt><label>Jabatan</label></dt>      <dd> : <input type=text name='jabatan' size=50 value='$r[jabatan]'></dd>
          <dt><label>Alamat</label></dt>       <dd> : <input type=text name='alamat' size=70 value='$r[alamat]'></dd>
          <dt><label>Tempat Lahir</label></dt> <dd> : <input type=text name='tempat_lahir' size=50 value='$r[tempat_lahir]'></dd>
          <dt><label>Tanggal Lahir</label></dt><dd> : ";
          $get_tgl=substr("$r[tgl_lahir]",8,2);
          combotgl(1,31,'tgl',$get_tgl);
          $get_bln=substr("$r[tgl_lahir]",5,2);
          combonamabln(1,12,'bln',$get_bln);
          $get_thn=substr("$r[tgl_lahir]",0,4);
          combothn(1950,$thn_sekarang,'thn',$get_thn);

    echo "</dd>";
          if ($r[jenis_kelamin]=='L'){
              echo "<dt><label>Jenis Kelamin</label></dt><dd> : <label><input type=radio name='jk' value='L' checked>Laki - Laki</label>
                                           <label><input type=radio name='jk' value='P'>Perempuan</label></dd>";
          }else{
              echo "<dt><label>Jenis Kelamin</label></dt><dd> : <label><input type=radio name='jk' value='L'>Laki - Laki</label>
                                           <label><input type=radio name='jk' value='P' checked>Perempuan</label></dd>";
          }      
          echo "<dt><label>Agama</label></dt>        <dd> : <select name=agama>
                                           <option value='$r[agama]' selected>$r[agama]</option>
                                           <option value='Islam'>Islam</option>
                                           <option value='Kristen'>Kristen</option>
                                           <option value='Katolik'>Katolik</option>
                                           <option value='Hindu'>Hindu</option>
                                           <option value='Buddha'>Buddha</option>
                                           </select></dd>
          <dt><label>Nama Ayah/Wali</label></dt> <dd> : <input type=text name='nama_ayah' size=30 value='$r[nama_ayah]'></dd>
          <dt><label>Nama Ibu</label></dt>     <dd> : <input type=text name='nama_ibu' size=30 value='$r[nama_ibu]'></dd>
          <dt><label>Tahun Masuk</label></dt>  <dd> : <input type=text name='th_masuk' size=10 value='$r[th_masuk]'></dd>
          <dt><label>Email</label></dt>        <dd> : <input type=text name='email' size=30 value='$r[email]'></dd>
          <dt><label>No Telp/HP</label></dt>   <dd> : <input type=text name='no_telp' size=20 value='$r[no_telp]'></dd>
          <dt><label>Foto</label></dt>   <dd> : ";
            if ($r[foto]!=''){
              echo "<ul class='photos sortable'>
                    <li>
                    <img src='../foto_siswa/medium_$r[foto]'>
                    <div class='links'>
                    <a href='../foto_siswa/medium_$r[foto]' rel='facebox'>View</a>
		    <div>
                    </li>
                    </ul>";
          }echo "</dd>
          <dt><label>Ganti Foto</label></dt>       <dd> : <input type=file name='fupload' size=40>
                                                <small>Tipe foto harus JPG/JPEG dan ukuran lebar maks: 400 px</small>
                                                <small>Apabila foto tidak diganti, dikosongkan saja</small></dd>";
    if ($r[blokir]=='N'){
      echo "<dt><label>Blokir</label></dt>     <dd> : <label><input type=radio name='blokir' value='Y'> Y</label>
                                           <label><input type=radio name='blokir' value='N' checked> N </label></tr>";
    }
    else{
      echo "<dt><label>Blokir</label></dt>     <dd> : <label><input type=radio name='blokir' value='Y' checked> Y</label>
                                          <label><input type=radio name='blokir' value='N'> N </label></tr>";
    }

    echo "</dl>
          <div class='buttons'>
          <input class='button blue' type=submit value=Update>
          <input class='button blue' type=button value=Batal onclick=self.history.back()>
          </div>
          </fieldset></form>";
    }
    elseif ($_SESSION[leveluser]=='siswa') {
     echo"<br><b class='judul'>Edit Profil</b><br><p class='garisbawah'></p>";
     echo"<form method=POST action=$aksi_siswa?module=siswa&act=update_profil_siswa enctype='multipart/form-data'>
          <input type=hidden name=id value='$r[id_siswa]'>
          <table>
          <tr><td>Nis</td>     <td> : <input type=text name=nis value='$r[nis]' ></td></tr>
          <tr><td>Nama</td>     <td> : <input type=text name='nama' value='$r[nama_lengkap]' size=40></td></tr>          
          <tr><td>Alamat</td>       <td> : <input type=text name='alamat' size=80 value='$r[alamat]'></td></tr>
          <tr><td>Tempat Lahir</td> <td> : <input type=text name='tempat_lahir' size=60 value='$r[tempat_lahir]'></td></tr>
          <tr><td>Tanggal Lahir</td><td> : ";
          $get_tgl=substr("$r[tgl_lahir]",8,2);
          combotgl(1,31,'tgl',$get_tgl);
          $get_bln=substr("$r[tgl_lahir]",5,2);
          combonamabln(1,12,'bln',$get_bln);
          $get_thn=substr("$r[tgl_lahir]",0,4);
          combothn(1950,$thn_sekarang,'thn',$get_thn);

    echo "</td></tr>";
          if ($r[jenis_kelamin]=='L'){
              echo "<tr><td>Jenis Kelamin</td><td> : <input type=radio name='jk' value='L' checked>Laki - Laki
                                           <input type=radio name='jk' value='P'>Perempuan</tr></tr>";
          }else{
              echo "<tr><td>Jenis Kelamin</td><td> : <input type=radio name='jk' value='L'>Laki - Laki
                                           <input type=radio name='jk' value='P' checked>Perempuan</tr></tr>";
          }
          echo "<tr><td>Agama</td>        <td> : <select name=agama>
                                           <option value='$r[agama]' selected>$r[agama]</option>
                                           <option value='Islam'>Islam</option>
                                           <option value='Kristen'>Kristen</option>
                                           <option value='Katolik'>Katolik</option>
                                           <option value='Hindu'>Hindu</option>
                                           <option value='Buddha'>Buddha</option>
                                           </select></td></tr>
          <tr><td>Nama Ayah/Wali</td> <td> : <input type=text name='nama_ayah' size=40 value='$r[nama_ayah]'></td></tr>
          <tr><td>Nama Ibu</td>     <td> : <input type=text name='nama_ibu' size=40 value='$r[nama_ibu]'></td></tr>
          <tr><td>Tahun Masuk</td>  <td> : <input type=text name='th_masuk' size=5 value='$r[th_masuk]'> *) Harus Angka</td></tr>
          <tr><td>Email</td>        <td> : <input type=text name='email' size=30 value='$r[email]'></td></tr>
          <tr><td>No Telp/HP</td>   <td> : <input type=text name='no_telp' size=20 value='$r[no_telp]'></td></tr>
          <tr><td>Foto</td>   <td> : ";
            if ($r[foto]!=''){
              echo "<img src='foto_siswa/medium_$r[foto]'>";
          }echo "</td></tr>
          <tr><td>Ganti Foto</td>       <td> : <input type=file name='fupload' size=40>
                                           <br>**) Tipe foto harus JPG/JPEG dan ukuran lebar maks: 400 px<br>
                                                ***) Apabila foto tidak diganti, dikosongkan saja</td></tr>";   

    echo "<tr><td>Jabatan</td>      <td> : <input type=text name='jabatan' size=70 value='$r[jabatan]'></td></tr>
          <tr><td colspan=2><input type=submit class='tombol' value='Update'>
                            <input type=button class='tombol' value='Batal'
                            onclick=self.history.back()>
                            </td></tr>
          </table></form>";
    }
    break;

    
 case "detailsiswa":
    if ($_SESSION[leveluser]=='admin'){
       $detail=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa WHERE id_siswa='$_GET[id]'");
       $siswa=mysqli_fetch_array($detail);
       $tgl_lahir   = tgl_indo($siswa[tgl_lahir]);

       $get_kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas = '$siswa[id_kelas]'");
       $kelas = mysqli_fetch_array($get_kelas);
       
       echo "<form><fieldset>
          <legend>Detail Siswa</legend>
          <dl class='inline'>
          <dt><label>Nis</label></dt>        <dd> : $siswa[nis]</dd>
          <dt><label>Nama</label></dt>               <dd> : $siswa[nama_lengkap]</dd>
          <dt><label>Username Login</label></dt>     <dd> : $siswa[username_login]</dd>
          <dt><label>Kelas</label></dt>              <dd> : <a href=?module=kelas&act=detailkelas&id=$siswa[id_kelas]>$kelas[nama]</a></dd>
          <dt><label>Alamat</label></dt>             <dd> : $siswa[alamat]</dd>
          <dt><label>Jabatan</label></dt>            <dd> : $siswa[jabatan]</dd>
          <dt><label>Tempat Lahir</label></dt> <dd> : $siswa[tempat_lahir]</dd>
          <dt><label>Tanggal Lahir</label></dt><dd> : $tgl_lahir</dd>";
          if ($siswa[jenis_kelamin]=='P'){
           echo "<dt><label>Jenis Kelamin</label></dt>     <dd>  : Perempuan</dd>";
            }
            else{
           echo "<dt><label>Jenis kelamin</label></dt>     <dd> :  Laki - Laki </dd>";
            }echo"
          <dt><label>Agama</label></dt>             <dd> : $siswa[agama]</dd>
          <dt><label>Nama Ayah/Wali</label></dt>     <dd> : $siswa[nama_ayah]</dd>
          <dt><label>Nama Ibu</label></dt>           <dd> : $siswa[nama_ibu]</dd>
          <dt><label>Tahun Masuk</label></dt>        <dd> : $siswa[th_masuk]</dd>
          <dt><label>E-Mail</label></dt>             <dd> : <a href=mailto:$siswa[email]>$siswa[email]</a></dd>
          <dt><label>No.Telp/Hp</label></dt>         <dd> : $siswa[no_telp]</dd>
          <dt><label>Blokir</label></dt>             <dd> : $siswa[blokir]</dd>
          <dt><label>Foto</label></dt>             <dd> :
          <ul class='photos sortable'>
              <li>";if ($siswa[foto]!=''){
              echo "<img src='../foto_siswa/medium_$siswa[foto]'>
              <div class='links'>
                    <a href='../foto_siswa/medium_$siswa[foto]' rel='facebox'>View</a>
              <div>
              </li>
              </ul></dd>";
          }
          echo "</dl>
          <div class='buttons'>
          <input class='button blue' type=button value=Kembali onclick=self.history.back()>
          </div>
          </fieldset></form>";
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
       $detail=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa WHERE id_siswa='$_GET[id]'");
       $siswa=mysqli_fetch_array($detail);
       $tgl_lahir   = tgl_indo($siswa[tgl_lahir]);

       $get_kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas = '$siswa[id_kelas]'");
       $kelas = mysqli_fetch_array($get_kelas);

       echo "<form><fieldset>
             <legend>Detail Siswa</legend>
             <dl class='inline'>
       <table id='table1' class='gtable sortable'>
          <tr><td rowspan='15'>";if ($siswa[foto]!=''){
              echo "<ul class='photos sortable'>
                    <li>
                    <img src='../foto_siswa/medium_$siswa[foto]'>
                    <div class='links'>
                    <a href='../foto_siswa/medium_$siswa[foto]' rel='facebox'>View</a>
                    <div>
                    </li>
                    </ul>";
          }echo "</td><td>Nis</td>        <td> : $siswa[nis]</td></tr>
          <tr><td>Nama</td>               <td> : $siswa[nama_lengkap]</td></tr>          
          <tr><td>Kelas</td>              <td> : <a href=?module=kelas&act=detailkelas&id=$siswa[id_kelas]>$kelas[nama]</td></tr>
          <tr><td>Jabatan</td>            <td> : $siswa[jabatan]</td></tr>
          <tr><td>alamat</td>             <td> : $siswa[alamat]</td></tr>
          <tr><td>Tempat Lahir</td> <td> : $siswa[tempat_lahir]</td></tr>
          <tr><td>Tanggal Lahir</td><td> : $tgl_lahir</td></tr>";
          if ($siswa[jenis_kelamin]=='P'){
           echo "<tr><td>Jenis Kelamin</td>     <td>  : Perempuan</td></tr>";
            }
            else{
           echo "<tr><td>Jenis kelamin</td>     <td> :  Laki - Laki </td></tr>";
            }echo"
          <tr><td>Agama</td>              <td> : $siswa[agama]</td></tr>
          <tr><td>Nama Ayah/Wali</td>     <td> : $siswa[nama_ayah]</td></tr>
          <tr><td>Nama Ibu</td>           <td> : $siswa[nama_ibu]</td></tr>
          <tr><td>Tahun Masuk</td>        <td> : $siswa[th_masuk]</td></tr>
          <tr><td>E-Mail</td>             <td> : <a href=mailto:$siswa[email]>$siswa[email]</a></td></tr>
          <tr><td>No.Telp/Hp</td>         <td> : $siswa[no_telp]</td></tr>
          <tr><td>Aksi</td>               <td> : <input type=button class='button small white' value=Kembali onclick=self.history.back()></td></tr>";
          echo"</table></dl></fieldset</form>";
    }
    elseif ($_SESSION[leveluser]=='siswa'){
       $detail=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa WHERE id_siswa='$_GET[id]'");
       $siswa=mysqli_fetch_array($detail);
       $tgl_lahir   = tgl_indo($siswa[tgl_lahir]);

       $get_kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas = '$siswa[id_kelas]'");
       $kelas = mysqli_fetch_array($get_kelas);

      echo"<br><b class='judul'>Detail Siswa</b><br><p class='garisbawah'></p>
       <table>
             <tr><td rowspan='14'>";if ($siswa[foto]!=''){
              echo "<img src='foto_siswa/medium_$siswa[foto]'>";
          }echo "</td><td>Nis</td>        <td> : $siswa[nis]</td></tr>
          <tr><td>Nama</td>               <td> : $siswa[nama_lengkap]</td></tr>          
          <tr><td>Kelas</td>              <td> : $kelas[nama]</td></tr>
          <tr><td>alamat</td>             <td> : $siswa[alamat]</td></tr>
          <tr><td>Tempat Lahir</td> <td> : $siswa[tempat_lahir]</td></tr>
          <tr><td>Tanggal Lahir</td><td> : $tgl_lahir</td></tr>";
          if ($siswa[jenis_kelamin]=='P'){
           echo "<tr><td>Jenis Kelamin</td>     <td>  : Perempuan</td></tr>";
            }
            else{
           echo "<tr><td>Jenis kelamin</td>     <td> :  Laki - Laki </td></tr>";
            }echo"
          <tr><td>Agama</td>              <td> : $siswa[agama]</td></tr>
          <tr><td>Nama Ayah/Wali</td>     <td> : $siswa[nama_ayah]</td></tr>
          <tr><td>Nama Ibu</td>           <td> : $siswa[nama_ibu]</td></tr>
          <tr><td>Tahun Masuk</td>        <td> : $siswa[th_masuk]</td></tr>
          <tr><td>E-Mail</td>             <td> : <a href=mailto:$siswa[email]>$siswa[email]</a></td></tr>
          <tr><td>No.Telp/Hp</td>         <td> : $siswa[no_telp]</td></tr>
          <tr><Td>Jabatan</td>            <td> : $siswa[jabatan]</td></tr>";
          echo"<tr><td colspan='3'><input type=button class='tombol' value='Kembali'
          onclick=self.history.back()></td></tr></table>";

    }
    break;

case "detailprofilsiswa":
    if ($_SESSION[leveluser]=='siswa'){
       $detail=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa WHERE id_siswa='$_GET[id]'");
       $siswa=mysqli_fetch_array($detail);
       $tgl_lahir   = tgl_indo($siswa[tgl_lahir]);

       $get_kelas = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM kelas WHERE id_kelas = '$siswa[id_kelas]'");
       $kelas = mysqli_fetch_array($get_kelas);

      echo"<br><b class='judul'>Detail Siswa</b><br><p class='garisbawah'></p>
       <table>
             <tr><td rowspan='14'>";if ($siswa[foto]!=''){
              echo "<img src='foto_siswa/medium_$siswa[foto]'>";
          }echo "</td><td>Nis</td>        <td> : $siswa[nis]</td></tr>
          <tr><td>Nama</td>               <td> : $siswa[nama_lengkap]</td></tr>
          <tr><td>Kelas</td>              <td> : $kelas[nama]</td></tr>
          <tr><td>alamat</td>             <td> : $siswa[alamat]</td></tr>
          <tr><td>Tempat Lahir</td> <td> : $siswa[tempat_lahir]</td></tr>
          <tr><td>Tanggal Lahir</td><td> : $tgl_lahir</td></tr>";
          if ($siswa[jenis_kelamin]=='P'){
           echo "<tr><td>Jenis Kelamin</td>     <td>  : Perempuan</td></tr>";
            }
            else{
           echo "<tr><td>Jenis kelamin</td>     <td> :  Laki - Laki </td></tr>";
            }echo"
          <tr><td>Agama</td>              <td> : $siswa[agama]</td></tr>
          <tr><td>Nama Ayah/Wali</td>     <td> : $siswa[nama_ayah]</td></tr>
          <tr><td>Nama Ibu</td>           <td> : $siswa[nama_ibu]</td></tr>
          <tr><td>Tahun Masuk</td>        <td> : $siswa[th_masuk]</td></tr>
          <tr><td>E-Mail</td>             <td> : <a href=mailto:$siswa[email]>$siswa[email]</a></td></tr>
          <tr><td>No.Telp/Hp</td>         <td> : $siswa[no_telp]</td></tr>
          <tr><td>Jabatan</td>            <td> : $siswa[jabatan]</td></tr>";
          echo"<tr><td colspan='3'><input type=button class='tombol' value='Edit Profil' onclick=\"window.location.href='?module=siswa&act=editsiswa&id=$siswa[id_siswa]';\"></td></tr></table>";
    }
    break;

case "detailaccount":
    if ($_SESSION[leveluser]=='siswa'){
        $detail=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa WHERE id_siswa='$_GET[id]'");
        $siswa=mysqli_fetch_array($detail);
        echo"<form method=POST action=$aksi_siswa?module=siswa&act=update_account_siswa>";
        echo"<br><b class='judul'>Edit Account Login</b><br><p class='garisbawah'></p>
        <table>
        <tr><td>Username</td><td>:<input type=text name='username' size='40'></td></tr>
        <tr><td>Password</td><td>:<input type=password name='password' size='40'></td></tr>
        <tr><td colspan=2>*) Apabila Username tidak diubah di kosongkan saja.</td></tr>
        <tr><td colspan=2>**) Apabila Password tidak diubah di kosongkan saja.</td></tr>
        <tr><td colspan=2><input type=submit class='tombol' value='Update'></td></tr>
        </table>";
    }
    break;
}
}
?>
