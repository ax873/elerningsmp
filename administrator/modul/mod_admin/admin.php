
<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href=../css/style.css rel=stylesheet type=text/css>";
  echo "<div class='error msg'>Untuk mengakses Modul anda harus login.</div>";
}
else{

$aksi="modul/mod_admin/aksi_admin.php";
switch($_GET[act]){
  // Tampil User
  default:
    if ($_SESSION[leveluser]=='admin'){
      $tampil_admin = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM admin ORDER BY username");      
      echo "<h2>Manajemen Administrator</h2><hr>
          <input class='button blue' type=button value='Tambah Administrator' onclick=\"window.location.href='?module=admin&act=tambahadmin';\">";
          echo "<br><br><div class='information msg'>Account administrator tidak bisa di hapus, tapi bisa di non aktifkan.</div>";
          echo "<br><table  id='table1' class='gtable sortable'><thead>
          <tr><th>No</th><th>Username</th><th>Nama</th><th>Alamat</th><th>Email</th><th>Telp/HP</th><th>Blokir</th><th>Aksi</th></tr></thead>";
    $no=1;
    while ($r=mysqli_fetch_array($tampil_admin)){
       echo "<tr><td>$no</td>
             <td>$r[username]</td>
             <td>$r[nama_lengkap]</td>
             <td>$r[alamat]</td>
		         <td><a href=mailto:$r[email]>$r[email]</a></td>
		         <td>$r[no_telp]</td>
		         <td align=center>$r[blokir]</td>
             <td><a href='?module=admin&act=editadmin&id=$r[id_session]' title='Edit'><img src='images/icons/edit.png' alt='Edit' /></a></td></tr>";
      $no++;
    }
    echo "</table>";
    }
    else{
      echo "<link href=../css/style.css rel=stylesheet type=text/css>";
      echo "<div class='error msg'>Anda tidak berhak mengakses halaman ini.</div>";
    }
    break;

  case "pengajar":
  if ($_SESSION[leveluser]=='admin'){
      $tampil_pengajar = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM pengajar ORDER BY username_login");
    echo "<h2>Manajemen Pengajar</h2><hr>
          <input class='button blue' type=button value='Tambah Pengajar' onclick=\"window.location.href='?module=admin&act=tambahpengajar';\">";
          echo "<br><br><table id='table1' class='gtable sortable'><thead>
          <tr><th>No</th><th>Nip</th><th>Username</th><th>Nama</th><th>Blokir</th><th>Aksi</th></tr></thead>";
    $no=1;
    while ($r=mysqli_fetch_array($tampil_pengajar)){
       echo "<tr><td>$no</td>
             <td>$r[nip]</td>
             <td>$r[username_login]</td>
             <td>$r[nama_lengkap]</td>             
		         <td align=center>$r[blokir]</td>
             <td><a href='?module=admin&act=editpengajar&id=$r[id_pengajar]' title='Edit'><img src='images/icons/edit.png' alt='Edit' /></a> |
                 <a href=?module=detailpengajar&act=detailpengajar&id=$r[id_pengajar]>Detail</a></td></tr>";
      $no++;
    }
    echo "</table>";
  }else{
        echo "<link href=../css/style.css rel=stylesheet type=text/css>";
        echo "<div class='error msg'>Anda tidak berhak mengakses halaman ini.</div>";
  }
  break;

  case "tambahadmin":
    if ($_SESSION[leveluser]=='admin'){
    echo "<form class='uniform' method=POST action='$aksi?module=admin&act=input_admin'>
          <fieldset>
          <legend>Tambah Administrator</legend>
          <dl class='inline'>
          <dt><label>Username</label></dt>     <dd> : <input type=text name='username'></dd>
          <dt><label>Password</label></dt>     <dd> : <input type=text name='password'></dd>
          <dt><label>Nama</label></dt> <dd> : <input type=text name='nama_lengkap' size=30></dd>
          <dt><label>Alamat</label></dt>        <dd> : <input type=text name='alamat' size=70></dd>
          <dt><label>E-mail</label></dt>       <dd> : <input type=text name='email' size=30></dd>
          <dt><label>No.Telp/HP</label></dt>   <dd> : <input type=text name='no_telp' size=20></dd>
          <dt><label>Blokir</label></dt>       <dd> : <input type=radio name='blokir' value='Y'> Y
                                           <input type=radio name='blokir' value='N' checked> N </dd>
          </dl>
          <div class='buttons'>
          <input class='button blue' type=submit value=Simpan>
          <input class='button blue' type=button value=Batal onclick=self.history.back()>
          </div>
          </fieldset></form>";
    }
    else{
      echo "<link href=../css/style.css rel=stylesheet type=text/css>";
      echo "<div class='error msg'>Anda tidak berhak mengakses halaman ini.</div>";
    }
     break;

  case "tambahpengajar":
    if ($_SESSION[leveluser]=='admin'){
    echo "<form method=POST action='$aksi?module=admin&act=input_pengajar' enctype='multipart/form-data'>
          <fieldset>
          <legend>Tambah Penajar</legend>
          <dl class='inline'>
          <dt><label>Nip</label></dt>          <dd> : <input type=text name='nip'></dd>
          <dt><label>Nama Lengkap</label></dt>    <dd> : <input type=text name='nama_lengkap' size=30></dd>
          <dt><label>Username</label></dt>     <dd> : <input type=text name='username'></dd>
          <dt><label>Password</label></dt>     <dd> : <input type=text name='password'></dd>
          <dt><label>Alamat</label></dt>      <dd> : <input type=text name='alamat' size=70></dd>
          <dt><label>Tempat lahir</label></dt>      <dd> : <input type=text name='tempat_lahir' size=50></dd>
          <dt><label>Tanggal Lahir</label></dt><dd> : ";
          combotgl(1,31,'tgl',$tgl_skrg);
          combonamabln(1,12,'bln',$bln_sekarang);
          combothn(1950,$thn_sekarang,'thn',$thn_sekarang);
          echo "</dd>";
    echo "
          <dt><label>Jenis Kelamin</label></dt> <dd> : <label><input type=radio name='jk' value=L>Laki-laki</input></label>
                                             <label><input type=radio name='jk' value=P>Perempuan</input></label></dd>
          <dt><label>Agama</label></dt>        <dd> : <select name='agama' id='select1' class='medium required' size='1'>
                                                           <option value='0' selected>-- Pilih --</option>
                                                           <option value='Islam'>Islam</option>
                                                           <option value='Kristen'>Kristen</option>
                                                           <option value='Katolik'>Katolik</option>
                                                           <option value='Hindu'>Hindu</option>
                                                           <option value='Buddha'>Buddha</option>
                                                           </select></dd>
          <dt><label>Telp/HP</label></dt>   <dd> : <input type=text name='no_telp' size=20></dd>
          <dt><label>E-mail</label></dt>       <dd> : <input type=text name='email' size=30></dd>
          <dt><label>Website</label></dt>      <dd> : <input type=text name='website' size=30 value='http://'></dd>
          <dt><label>Foto</label></dt>      <dd> : <input type='file' name='fupload' id='upload'>
                                                      <small>Tipe foto harus JPG/JPEG dan ukuran lebar maks: 400 px</small></dd>
          <dt><label>Jabatan</label></dt>      <dd> : <input type=text name='jabatan' size=30></dd>
          <dt><label>Blokir</label></dt>       <dd> : <label><input type=radio name='blokir' value='Y'> Y</label>
                                                      <label><input type=radio name='blokir' value='N' checked> N </label></dd>
          
          </dl>
          <div class='buttons'>
          <input class='button blue' type=submit value=Simpan>
          <input class='button blue' type=button value=Batal onclick=self.history.back()>
          </div>
          </fieldset></form>";
    }
    else{
      echo "<link href=../css/style.css rel=stylesheet type=text/css>";
      echo "<div class='error msg'>Anda tidak berhak mengakses halaman ini.</div>";
    }
     break;

  case "editadmin":
    $edit=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM admin WHERE id_session='$_GET[id]'");
    $r=mysqli_fetch_array($edit);

    if ($_SESSION[leveluser]=='admin'){
    echo "<form method=POST action=$aksi?module=admin&act=update_admin>
          <input type=hidden name=id value='$r[id_session]'>
          <fieldset>
          <legend>Edit Administrator</legend>
          <dl class='inline'>
          <dt><label>Username</label></dt>     <dd> : <input type=text name='username' value='$r[username]'></dd>
          <dt><label>Password</label></dt>     <dd> : <input type=text name='password'>
                                                      <small>Apabila password tidak diubah, dikosongkan saja.</small>
                                               </dd>
          <dt><label>Nama</label></dt> <dd> : <input type=text name='nama_lengkap' size=30  value='$r[nama_lengkap]'></dd>
          <dt><label>Alamat</label></dt>       <dd> : <input type=text name='alamat' size=70  value='$r[alamat]'></dd>
          <dt><label>E-mail</label></dt>       <dd> : <input type=text name='email' size=30 value='$r[email]'></dd>
          <dt><label>No.Telp/HP</label></dt>   <dd> : <input type=text name='no_telp' size=30 value='$r[no_telp]'></dd>";

    if ($r[blokir]=='N'){
      echo "<dt><label>Blokir</label></dt>     <dd> : <input type=radio name='blokir' value='Y'> Y
                                                      <input type=radio name='blokir' value='N' checked> N </dd>";
    }
    else{
       echo "<dt><label>Blokir</label></dt>     <dd> : <input type=radio name='blokir' value='Y' checked> Y
                                                       <input type=radio name='blokir' value='N'> N </dd>";
    }
    
    echo "</dl>
          <div class='buttons'>
          <input class='button blue' type=submit value=Update>
          <input class='button blue' type=button value=Batal onclick=self.history.back()>
          </div>
          </fieldset></form>";
    }
    else{
      echo "<link href=../css/style.css rel=stylesheet type=text/css>";
      echo "<div class='error msg'>Anda tidak berhak mengakses halaman ini.</div>";
    }
    break;

 case "editpengajar":
    $edit=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM pengajar WHERE id_pengajar='$_GET[id]'");
    $r=mysqli_fetch_array($edit);

    if ($_SESSION[leveluser]=='admin'){
    echo "<form method=POST action=$aksi?module=admin&act=update_pengajar enctype='multipart/form-data'>
          <input type=hidden name=id value='$r[id_pengajar]'>
          <fieldset>
          <legend>Edit Pengajar</legend>
          <dl class='inline'>
          <dt><label>Nip</label></dt>          <dd> : <input type=text name='nip' value='$r[nip]'></dd>
          <dt><label>Nama Lengkap</label></dt> <dd> : <input type=text name='nama_lengkap' size=30 value='$r[nama_lengkap]'></dd>
          <dt><label>Username</label></dt>     <dd> : <input type=text name='username' value='$r[username_login]'></dd>
          <dt><label>Password</label></dt>     <dd> : <input type=text name='password'> 
                                                      <small>Apabila password tidak diubah, dikosongkan saja</small>
                                               </dd>
          <dt><label>Alamat</label></dt>       <dd> : <input type=text name='alamat' size=70 value='$r[alamat]'></dd>
          <dt><label>Tempat Lahir</label></dt> <dd> : <input type=text name='tempat_lahir' size=60 value='$r[tempat_lahir]'></dd>
          <dt><label>Tanggal Lahir</label></dt><dd> : ";
          $get_tgl=substr("$r[tgl_lahir]",8,2);
          combotgl(1,31,'tgl',$get_tgl);
          $get_bln=substr("$r[tgl_lahir]",5,2);
          combonamabln(1,12,'bln',$get_bln);
          $get_thn=substr("$r[tgl_lahir]",0,4);
          combothn(1950,$thn_sekarang,'thn',$get_thn);

    echo "</dd>";
          if ($r[jenis_kelamin]=='L'){
              echo "<dt><label>Jenis Kelamin</label></dt>  <dd> : <label><input type=radio name='jk' value='L' checked>Laki - Laki</label>
                                                                <label><input type=radio name='jk' value='P'>Perempuan</label></dd>";
          }else{
              echo "<dt><label>Jenis Kelamin<</label></dt> <dd> : <label><input type=radio name='jk' value='L'>Laki - Laki</label>
                                           <label><input type=radio name='jk' value='P' checked>Perempuan</label></dd>";
          }
     echo"<dt><label>Agama</label></dt>        <dd> : <select name=agama>
                                           <option value='$r[agama]' selected>$r[agama]</option>
                                           <option value='Islam'>Islam</option>
                                           <option value='Kristen'>Kristen</option>
                                           <option value='Katolik'>Katolik</option>
                                           <option value='Hindu'>Hindu</option>
                                           <option value='Buddha'>Buddha</option>
                                           </select></dd>
          <dt><label>No.Telp/HP</label></dt>   <dd> : <input type=text name='no_telp' size=20 value='$r[no_telp]'></dd>
          <dt><label>E-mail</label></dt>       <dd> : <input type=text name='email' size=30 value='$r[email]'></dd>
          <dt><label>Website</label></dt>      <dd> : <input type=text name='website' size=30 value='$r[website]'></dd>
          <dt><label>Foto</label></dt>         <dd> : ";
                                if ($r[foto]!=''){
              echo "<ul class='photos sortable'>
                    <li>
                    <img src='../foto_pengajar/medium_$r[foto]'>
                    <div class='links'>
                    <a href='../foto_pengajar/medium_$r[foto]' rel='facebox'>View</a>
		    <div>
                    </li>
                    </ul>";
          }echo "</dd>
          <dt><label>Jabatan</label></dt>          <dd> : <input type=text name='jabatan' value='$r[jabatan]' size=50></dd>
          <dt><label>Ganti Foto</label></dt>       <dd> : <input type=file name='fupload' size=40>
                                           <small>Tipe foto harus JPG/JPEG dan ukuran lebar maks: 400 px</small>
                                           <small>Apabila foto tidak diubah, dikosongkan saja</small></dd>";
          if ($r[blokir]=='N'){

           echo "<dt><label>Blokir</label></dt>     <dd> : <label><input type=radio name='blokir' value='Y'> Y<label>
                                           <label><input type=radio name='blokir' value='N' checked> N <label></dd>";
            }
            else{
           echo "<dt><label>Blokir</label></dt>     <dd> : <label><input type=radio name='blokir' value='Y' checked> Y<label>
                                          <label><input type=radio name='blokir' value='N'> N <label></dd>";
            }
          echo "</dl>
          <div class='buttons'>
          <input class='button blue' type=submit value=Update>
          <input class='button blue' type=button value=Batal onclick=self.history.back()>
          </div>
          </fieldset></form>";
    }
    elseif ($_SESSION[leveluser]=='pengajar'){
        $edit=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM pengajar WHERE id_pengajar='$_SESSION[idpengajar]'");
        $r=mysqli_fetch_array($edit);
     echo "<form method=POST action=$aksi?module=admin&act=update_pengajar2 enctype='multipart/form-data'>
          <input type=hidden name=id value='$r[id_pengajar]'>          
          <fieldset>
          <legend>Edit Profil</legend>
          <dl class='inline'>
          <dt><label>Nip</label></dt>          <dd> : <input type=text name='nip' value='$r[nip]'></dd>
          <dt><label>Nama Lengkap</label></dt> <dd> : <input type=text name='nama_lengkap' size=30 value='$r[nama_lengkap]'></dd>
          <dt><label>Username</label></dt>     <dd> : <input type=text name='username' value='$r[username_login]'></dd>
          <dt><label>Password</label></dt>     <dd> : <input type=text name='password'>
                                                      <small>Apabila password tidak diubah, dikosongkan saja</small>
                                               </dd>
          <dt><label>Alamat</label></dt>       <dd> : <input type=text name='alamat' size=70 value='$r[alamat]'></dd>
          <dt><label>Tempat Lahir</label></dt> <dd> : <input type=text name='tempat_lahir' size=60 value='$r[tempat_lahir]'></dd>
          <dt><label>Tanggal Lahir</label></dt><dd> : ";
          $get_tgl=substr("$r[tgl_lahir]",8,2);
          combotgl(1,31,'tgl',$get_tgl);
          $get_bln=substr("$r[tgl_lahir]",5,2);
          combonamabln(1,12,'bln',$get_bln);
          $get_thn=substr("$r[tgl_lahir]",0,4);
          combothn(1950,$thn_sekarang,'thn',$get_thn);

    echo "</dd>";
          if ($r[jenis_kelamin]=='L'){
              echo "<dt><label>Jenis Kelamin</label></dt>  <dd> : <label><input type=radio name='jk' value='L' checked>Laki - Laki</label>
                                                                <label><input type=radio name='jk' value='P'>Perempuan</label></dd>";
          }else{
              echo "<dt><label>Jenis Kelamin<</label></dt> <dd> : <label><input type=radio name='jk' value='L'>Laki - Laki</label>
                                           <label><input type=radio name='jk' value='P' checked>Perempuan</label></dd>";
          }
     echo"<dt><label>Agama</label></dt>        <dd> : <select name=agama>
                                           <option value='$r[agama]' selected>$r[agama]</option>
                                           <option value='Islam'>Islam</option>
                                           <option value='Kristen'>Kristen</option>
                                           <option value='Katolik'>Katolik</option>
                                           <option value='Hindu'>Hindu</option>
                                           <option value='Buddha'>Buddha</option>
                                           </select></dd>
          <dt><label>No.Telp/HP</label></dt>   <dd> : <input type=text name='no_telp' size=20 value='$r[no_telp]'></dd>
          <dt><label>E-mail</label></dt>       <dd> : <input type=text name='email' size=30 value='$r[email]'></dd>
          <dt><label>Website</label></dt>      <dd> : <input type=text name='website' size=30 value='$r[website]'></dd>
          <dt><label>Foto</label></dt>         <dd> : ";
                                if ($r[foto]!=''){
              echo "<ul class='photos sortable'>
                    <li>
                    <img src='../foto_pengajar/medium_$r[foto]'>
                    <div class='links'>
                    <a href='../foto_pengajar/medium_$r[foto]' rel='facebox'>View</a>
		    <div>
                    </li>
                    </ul>";
          }echo "</dd>
          <dt><label>Jabatan</label></dt>          <dd> : <input type=text name='jabatan' value='$r[jabatan]' size=50></dd>
          <dt><label>Ganti Foto</label></dt>       <dd> : <input type=file name='fupload' size=40>
                                           <small>Tipe foto harus JPG/JPEG dan ukuran lebar maks: 400 px</small>
                                           <small>Apabila foto tidak diubah, dikosongkan saja</small></dd>";
          if ($r[blokir]=='N'){

           echo "<dt><label>Blokir</label></dt>     <dd> : <label><input type=radio name='blokir' value='Y'> Y<label>
                                           <label><input type=radio name='blokir' value='N' checked> N <label></dd>";
            }
            else{
           echo "<dt><label>Blokir</label></dt>     <dd> : <label><input type=radio name='blokir' value='Y' checked> Y<label>
                                          <label><input type=radio name='blokir' value='N'> N <label></dd>";
            }
          echo "</dl>
          <div class='buttons'>
          <input class='button blue' type=submit value=Update>
          <input class='button blue' type=button value=Batal onclick=self.history.back()>
          </div>
          </fieldset></form>";
    }
    break;

case "detailpengajar":
    $detail=mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM pengajar WHERE id_pengajar='$_GET[id]'");
    $r=mysqli_fetch_array($detail);
    $tgl_lahir   = tgl_indo($r[tgl_lahir]);

    if ($_SESSION[leveluser]=='admin'){
    echo "<form><fieldset>
          <legend>Detail Pengajar</legend>
          <dl class='inline'>
          <dt><label>Nip</label></dt>   <dd> : $r[nip]</dd>
          <dt><label>Nama Lengkap</label></dt> <dd> : $r[nama_lengkap]</dd>
          <dt><label>Username</label></dt>     <dd> : $r[username_login]</dd>
          <dt><label>Alamat</label></dt>       <dd> : $r[alamat]</dd>
          <dt><label>Tempat Lahir</label></dt> <dd> : $r[tempat_lahir]</dd>
          <dt><label>Tanggal Lahir</label></dt><dd> : $tgl_lahir</dd>";
          if ($r[jenis_kelamin]=='P'){
           echo "<dt><label>Jenis Kelamin</label></dt>     <dd>  : Perempuan</dd>";
            }
            else{
           echo "<dt><label>Jenis kelamin</label></dt>     <dd> :  Laki - Laki </dd>";
            }echo"
          <dt><label>Agama</label></dt>       <dd> : $r[agama]</dd>
          <dt><label>No.Telp/HP</label></dt>   <dd> : $r[no_telp]</dd>
          <dt><label>E-mail</label></dt>       <dd> : <a href=mailto:$r[email]>$r[email]</a></dd>
          <dt><label>Website</label></dt>      <dd> : <a href=http://$r[website] target=_blank>$r[website]</a></dd>
          <dt><label>Jabatan</label></dt>     <dd> : $r[jabatan]</dd>";
          if ($r[blokir]=='N'){
           echo "<dt><label>Blokir</label></dt>     <dd> :  N </dd>";
            }
            else{
           echo "<dt><label>Blokir</label></dt>     <dd> :  Y </dd>";
            }
          echo "<dt><label>Foto</label></dt>  <dd> :
          <ul class='photos sortable'>
                    <li>";if ($r[foto]!=''){
              echo "<img src='../foto_pengajar/medium_$r[foto]'>
              <div class='links'>
                    <a href='../foto_pengajar/medium_$r[foto]' rel='facebox'>View</a>
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
        echo "<form><fieldset>
          <legend>Detail Pengajar</legend>
          <dl class='inline'>
          <table id='table1' class='gtable sortable'>
          <tr><td rowspan='13'>";if ($r[foto]!=''){
              echo "<ul class='photos sortable'>
                    <li>
                    <img src='../foto_pengajar/medium_$r[foto]'>
                    <div class='links'>
                    <a href='../foto_pengajar/medium_$r[foto]' rel='facebox'>View</a>
                    <div>
                    </li>
                    </ul>";
          }echo "</td><td>Nip</td>  <td> : $r[nip]</td><tr>
          <tr><td>Nama Lengkap</td> <td> : $r[nama_lengkap]</td></tr>          
          <tr><td>Alamat</td>       <td> : $r[alamat]</td></tr>
          <tr><td>Tempat Lahir</td> <td> : $r[tempat_lahir]</td></tr>
          <tr><td>Tanggal Lahir</td><td> : $tgl_lahir</td></tr>";
          if ($r[jenis_kelamin]=='P'){
           echo "<tr><td>Jenis Kelamin</td>     <td>  : Perempuan</td></tr>";
            }
            else{
           echo "<tr><td>Jenis kelamin</td>     <td> :  Laki - Laki </td></tr>";
            }echo"
          <tr><td>Agama</td>        <td> : $r[agama]</td></tr>
          <tr><td>No.Telp/HP</td>   <td> : $r[no_telp]</td></tr>
          <tr><td>E-mail</td>       <td> : <a href=mailto:$r[email]>$r[email]</a></td></tr>
          <tr><td>Website</td>      <td> : <a href=http://$r[website] target=_blank>$r[website]</a></td></tr>
          <tr><td>Jabatan</td>      <td> : $r[jabatan]</td></tr>
          <tr><td>Aksi</td>         <td> : <input class='button small white' type=button value=Kembali onclick=self.history.back()></td></tr>";
           echo"</table></dl></fieldset</form>";
    }else{
        echo"<br><b class='judul'>Detail Guru</b><br><p class='garisbawah'></p>";
        echo "<table>
          <tr><td rowspan='12'>";if ($r[foto]!=''){
              echo "<img src='foto_pengajar/medium_$r[foto]'>";
          }echo "</td><td>Nip</td>  <td> : $r[nip]</td><tr>
          <tr><td>Nama Lengkap</td> <td> : $r[nama_lengkap]</td></tr>          
          <tr><td>Alamat</td>       <td> : $r[alamat]</td></tr>
          <tr><td>Tempat Lahir</td> <td> : $r[tempat_lahir]</td></tr>
          <tr><td>Tanggal Lahir</td><td> : $tgl_lahir</td></tr>";
          if ($r[jenis_kelamin]=='P'){
           echo "<tr><td>Jenis Kelamin</td>     <td>  : Perempuan</td></tr>";
            }
            else{
           echo "<tr><td>Jenis kelamin</td>     <td> :  Laki - Laki </td></tr>";
            }echo"
          <tr><td>Agama</td>        <td> : $r[agama]</td></tr>
          <tr><td>No.Telp/HP</td>   <td> : $r[no_telp]</td></tr>
          <tr><td>E-mail</td>       <td> : <a href=mailto:$r[email]>$r[email]</a></td></tr>
          <tr><td>Website</td>      <td> : <a href=http://$r[website] target=_blank>$r[website]</a></td></tr>
          <tr><td>Jabatan</td>      <td> : $r[jabatan]</td></tr>
          <tr><td colspan='3'><input type=button class='tombol' value='Kembali'
                              onclick=self.history.back()></td></tr></table>";
    }
    break;
}
}
?>
