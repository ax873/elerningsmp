<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../../configurasi/koneksi.php";
include "../../../configurasi/library.php";
include "../../../configurasi/fungsi_thumb.php";

$module=$_GET['module'];
$act=$_GET['act'];

if ($module=='quiz' AND $act=='input_topikquiz'){
    $pelajaran = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$_POST[id_matapelajaran]'");
    $data = mysqli_fetch_array($pelajaran);
    $pengajar = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM pengajar WHERE id_pengajar = '$data[id_pengajar]'");
    $cek_pengajar_pelajaran = mysqli_num_rows($pengajar);
    if (!empty($cek_pengajar_pelajaran)){
    
    $wpengerjaan = $_POST['waktu'] * 60;
    mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO topik_quiz(
                                    judul,
                                    id_kelas,
                                    id_matapelajaran,
                                    tgl_buat,
                                    pembuat,
                                    waktu_pengerjaan,
                                    info,
                                    terbit)
                            VALUES('$_POST[judul]',
                                   '$_POST[id_kelas]',
                                   '$_POST[id_matapelajaran]',
                                   '$tgl_sekarang',
                                   '$data[id_pengajar]',
                                   '$wpengerjaan',
                                   '$_POST[info]',
                                   '$_POST[terbit]')");
    }else{
        $wpengerjaan = $_POST['waktu'] * 60;
        mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO topik_quiz(
                                    judul,
                                    id_kelas,
                                    id_matapelajaran,
                                    tgl_buat,
                                    pembuat,
                                    waktu_pengerjaan,
                                    info,
                                    terbit)
                            VALUES('$_POST[judul]',
                                   '$_POST[id_kelas]',
                                   '$_POST[id_matapelajaran]',
                                   '$tgl_sekarang',
                                   '$_SESSION[leveluser]',
                                   '$wpengerjaan',
                                   '$_POST[info]',
                                   '$_POST[terbit]')");
    }
  header('location:../../media_admin.php?module='.$module);
}

elseif($module=='quiz' AND $act=='inputnilai'){
    mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE siswa_sudah_mengerjakan SET dikoreksi = 'S'
                                                WHERE id_tq ='$_POST[id_tq]' AND id_siswa = '$_POST[id_siswa]'");
    mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO nilai_soal_esay (id_tq,id_siswa,nilai)
                                   VALUES ('$_POST[id_tq]','$_POST[id_siswa]','$_POST[nilai]')");
    header('location:../../media_admin.php?module=quiz&act=daftarsiswayangtelahmengerjakan&id='.$_POST[id_tq]);
}

elseif($module=='quiz' AND $act=='inputeditnilai'){
    mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE nilai_soal_esay SET nilai = '$_POST[nilai]' WHERE id_tq ='$_POST[id_tq]' AND id_siswa = '$_POST[id_siswa]' ");
    header('location:../../media_admin.php?module=quiz&act=daftarsiswayangtelahmengerjakan&id='.$_POST[id_tq]);
}


elseif($module=='quiz' AND $act=='edit_topikquiz'){
    $pelajaran = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM mata_pelajaran WHERE id_matapelajaran = '$_POST[id_matapelajaran]'");
    $data = mysqli_fetch_array($pelajaran);
    $pengajar = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM pengajar WHERE id_pengajar = '$data[id_pengajar]'");
    $cek_pengajar_pelajaran = mysqli_num_rows($pengajar);
    if (!empty($cek_pengajar_pelajaran)){
    $waktu = $_POST['waktu'] * 60;
    mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE topik_quiz SET judul = '$_POST[judul]',
                                        id_kelas = '$_POST[id_kelas]',
                                        id_matapelajaran = '$_POST[id_matapelajaran]',
                                        tgl_buat = '$tgl_sekarang',
                                        pembuat = '$data[id_pengajar]',
                                        waktu_pengerjaan = '$waktu',
                                        info = '$_POST[info]',
                                        terbit = '$_POST[terbit]'
                             WHERE id_tq = '$_POST[id]'");
    }else{
        $waktu = $_POST['waktu'] * 60;
        mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE topik_quiz SET judul = '$_POST[judul]',
                                        id_kelas = '$_POST[id_kelas]',
                                        id_matapelajaran = '$_POST[id_matapelajaran]',
                                        tgl_buat = '$tgl_sekarang',
                                        pembuat = '$_SESSION[leveluser]',
                                        waktu_pengerjaan = '$waktu',
                                        info = '$_POST[info]',
                                        terbit = '$_POST[terbit]'
                             WHERE id_tq = '$_POST[id]'");
    }
header('location:../../media_admin.php?module='.$module);
}

elseif($module=='quiz' AND $act=='editsiswayangtelahmengerjakan'){
    mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM siswa_sudah_mengerjakan WHERE id_siswa='$_GET[id_siswa]' AND id = '$_GET[id]'");
    mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM nilai_soal_esay WHERE id_tq='$_GET[id_tq]' AND id_siswa='$_GET[id_siswa]'");
    mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM nilai WHERE id_tq='$_GET[id_tq]' AND id_siswa='$_GET[id_siswa]'");
    mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM jawaban WHERE id_tq='$_GET[id_tq]' AND id_siswa ='$_GET[id_siswa]'");
    header('location:../../media_admin.php?module='.$module);

}

elseif($module=='quiz' AND $act=='hapustopikquiz'){
    //hapus topik
  mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM topik_quiz WHERE id_tq = '$_GET[id]'");
  //hapus kuiz esay
  $cek = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_esay WHERE id_tq = '$_GET[id]'");
     $r = mysqli_fetch_array($cek);
     if(empty($r[gambar])){
        mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM quiz_esay WHERE id_tq = '$_GET[id]'");
     }else{
         $img = "../../../foto_soal/$r[gambar]";
         unlink($img);
         $img2 = "../../../foto_soal/medium_$r[gambar]";
         unlink($img2);
         mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM quiz_esay WHERE id_tq = '$_GET[id]'");
     }
  //hapus kuiz pilihan ganda
  $cek2 = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_pilganda WHERE id_tq = '$_GET[id]'");
     $r2 = mysqli_fetch_array($cek2);
     if(empty($r2[gambar])){
        mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM quiz_pilganda WHERE id_tq = '$_GET[id]'");
     }else{
         $img = "../../../foto_soal_pilganda/$r2[gambar]";
         unlink($img);
         $img2 = "../../../foto_soal_pilganda/medium_$r2[gambar]";
         unlink($img2);
         mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM quiz_pilganda WHERE id_tq = '$_GET[id]'");
     }
  header('location:../../media_admin.php?module='.$module);
}

elseif($module=='quiz' AND $act=='input_quizesay'){
  $lokasi_file = $_FILES['fupload']['tmp_name'];
  $nama_file   = $_FILES['fupload']['name'];
  $direktori_file = "../../../foto_soal/$nama_file";
  $tipe_file = $_FILES['fupload']['type'];
  
  // Apabila ada gambar yang diupload
  if (!empty($lokasi_file)){
        if (file_exists($direktori_file)){
            echo "<script>window.alert('Nama file sudah ada, mohon diganti dulu');
            window.location=(href='../../media_admin.php?module=quiz&&act=buatquizesay&id=$_POST[id]')</script>";
        }else{
            if($tipe_file != "image/jpeg" AND
               $tipe_file != "image/jpg"             
            ){
                echo "<script>window.alert('Tipe File tidak di ijinkan.');
                window.location=(href='../../media_admin.php?module=quiz&act=buatquizesay&id=$_POST[id]')</script>";
            }else{
                UploadImage_soal($nama_file);
                mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO quiz_esay(id_tq,pertanyaan,gambar,tgl_buat)
                   VALUES('$_POST[id]','$_POST[pertanyaan]','$nama_file','$tgl_sekarang')");
            }
        }     
    }else{
        mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO quiz_esay(id_tq,pertanyaan,tgl_buat)
                   VALUES('$_POST[id]','$_POST[pertanyaan]','$tgl_sekarang')");
    }
header('location:../../media_admin.php?module=daftarquizesay&act=daftarquizesay&id='.$_POST[id]);
}

elseif($module=='quiz' AND $act=='input_quizpilganda'){
    $lokasi_file = $_FILES['fupload']['tmp_name'];
    $nama_file   = $_FILES['fupload']['name'];
    $direktori_file = "../../../foto_soal_pilganda/$nama_file";
    $tipe_file = $_FILES['fupload']['type'];

     // Apabila ada gambar yang diupload
  if (!empty($lokasi_file)){
      if (file_exists($direktori_file)){
            echo "<script>window.alert('Nama file sudah ada, mohon diganti dulu');
            window.location=(href='../../media_admin.php?module=buatquizpilganda&&act=buatquizpilganda&id=$_POST[id]')</script>";
        }else{
            if($tipe_file != "image/jpeg" AND
               $tipe_file != "image/jpg"
            ){
                echo "<script>window.alert('Tipe File tidak di ijinkan.');
                window.location=(href='../../media_admin.php?module=buatquizpilganda&act=buatquizpilganda&id=$_POST[id]')</script>";
            }else{
                UploadImage_soal_pilganda($nama_file);
                mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO quiz_pilganda(id_tq,pertanyaan,gambar,pil_a,pil_b,pil_c,pil_d,kunci,tgl_buat)
                   VALUES('$_POST[id]','$_POST[pertanyaan]','$nama_file','$_POST[pila]','$_POST[pilb]','$_POST[pilc]','$_POST[pild]','$_POST[kunci]','$tgl_sekarang')");
            }
        }
    }else{
        mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO quiz_pilganda(id_tq,pertanyaan,pil_a,pil_b,pil_c,pil_d,kunci,tgl_buat)
                   VALUES('$_POST[id]','$_POST[pertanyaan]','$_POST[pila]','$_POST[pilb]','$_POST[pilc]','$_POST[pild]','$_POST[kunci]','$tgl_sekarang')");
    }          
    header('location:../../media_admin.php?module=daftarquizpilganda&act=daftarquizpilganda&id='.$_POST[id]);
}

elseif($module=='quiz' AND $act=='edit_quizesay'){
  $lokasi_file = $_FILES['fupload']['tmp_name'];
  $nama_file   = $_FILES['fupload']['name'];
  $direktori_file = "../../../foto_soal/$nama_file";
  $tipe_file = $_FILES['fupload']['type'];

  // Apabila ada gambar yang diupload
  if (!empty($lokasi_file)){
        if (file_exists($direktori_file)){
            echo "<script>window.alert('Nama file sudah ada, mohon diganti dulu');
            window.location=(href='../../media_admin.php?module=daftarquizesay&act=daftarquizesay&id=$_POST[topik]')</script>";
        }else{
            if($tipe_file != "image/jpeg" AND
               $tipe_file != "image/jpg"               
            ){
                echo "<script>window.alert('Tipe File tidak di ijinkan.');
                window.location=(href='?module=quiz&act=daftarquizesay&id=$_POST[topik]')</script>";
            }else{
                $cek = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_esay WHERE id_quiz = '$_POST[id]'");
                $r = mysqli_fetch_array($cek);
                if(!empty($r[gambar])){
                $img = "../../../foto_soal/$r[gambar]";
                unlink($img);
                $img2 = "../../../foto_soal/medium_$r[gambar]";
                unlink($img2);
                UploadImage_soal($nama_file);
                mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE quiz_esay SET pertanyaan = '$_POST[pertanyaan]',
                                                  gambar     = '$nama_file',
                                                  tgl_buat   = '$tgl_sekarang'
                                            WHERE id_quiz = '$_POST[id]'");
                }else{
                    UploadImage_soal($nama_file);
                    mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE quiz_esay SET pertanyaan = '$_POST[pertanyaan]',
                                                  gambar     = '$nama_file',
                                                  tgl_buat   = '$tgl_sekarang'
                                            WHERE id_quiz = '$_POST[id]'");
                }
            }
        }
    }else{
        mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE quiz_esay SET pertanyaan = '$_POST[pertanyaan]',
                                          tgl_buat   = '$tgl_sekarang'
                                       WHERE id_quiz = '$_POST[id]'");
    }
    header('location:../../media_admin.php?module=daftarquizesay&act=daftarquizesay&id='.$_POST[topik]);
}

elseif($module=='quiz' AND $act=='hapusquizesay'){
     $cek = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_esay WHERE id_quiz = '$_GET[id]'");
     $r = mysqli_fetch_array($cek);
     if(empty($r[gambar])){
        mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM quiz_esay WHERE id_quiz = '$_GET[id]'");
     }else{
         $img = "../../../foto_soal/$r[gambar]";
         unlink($img);
         $img2 = "../../../foto_soal/medium_$r[gambar]";
         unlink($img2);
         mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM quiz_esay WHERE id_quiz = '$_GET[id]'");
     }
     header('location:../../media_admin.php?module=daftarquizesay&act=daftarquizesay&id='.$_GET[id_topik]);
}

elseif($module=='quiz' AND $act=='edit_quizpilganda'){
    $lokasi_file = $_FILES['fupload']['tmp_name'];
    $nama_file   = $_FILES['fupload']['name'];
    $direktori_file = "../../../foto_soal_pilganda/$nama_file";
    $tipe_file = $_FILES['fupload']['type'];

    // Apabila ada gambar yang diupload
  if (!empty($lokasi_file)){
      if (file_exists($direktori_file)){
            echo "<script>window.alert('Nama file sudah ada, mohon diganti dulu');
            window.location=(href='../../media_admin.php?module=daftarquizpilganda&act=daftarquizpilganda&id=$_POST[topik]')</script>";
        }else{
            if($tipe_file != "image/jpeg" AND
               $tipe_file != "image/jpg"
            ){
                echo "<script>window.alert('Tipe File tidak di ijinkan.');
                window.location=(href='../../media_admin.php?module=daftarquizpilganda&act=daftarquizpilganda&id=$_POST[topik]')</script>";
            }else{
                $cek = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_pilganda WHERE id_quiz = '$_POST[id]'");
                $r = mysqli_fetch_array($cek);
                if(!empty($r[gambar])){
                $img = "../../../foto_soal_pilganda/$r[gambar]";
                unlink($img);
                $img2 = "../../../foto_soal_pilganda/medium_$r[gambar]";
                unlink($img2);
                UploadImage_soal_pilganda($nama_file);
                mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE quiz_pilganda SET pertanyaan = '$_POST[pertanyaan]',
                                           gambar     = '$nama_file',
                                           pil_a      = '$_POST[pila]',
                                           pil_b      = '$_POST[pilb]',
                                           pil_c      = '$_POST[pilc]',
                                           pil_d      = '$_POST[pild]',
                                           kunci      = '$_POST[kunci]',
                                           tgl_buat   = '$tgl_sekarang'
                                        WHERE id_quiz = '$_POST[id]'");
                }else{
                    UploadImage_soal_pilganda($nama_file);
                    mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE quiz_pilganda SET pertanyaan = '$_POST[pertanyaan]',
                                           gambar     = '$nama_file',
                                           pil_a      = '$_POST[pila]',
                                           pil_b      = '$_POST[pilb]',
                                           pil_c      = '$_POST[pilc]',
                                           pil_d      = '$_POST[pild]',
                                           kunci      = '$_POST[kunci]',
                                           tgl_buat   = '$tgl_sekarang'
                                        WHERE id_quiz = '$_POST[id]'");
                }
            }
        }
    }else{
        mysqli_query($GLOBALS["___mysqli_ston"], "UPDATE quiz_pilganda SET pertanyaan = '$_POST[pertanyaan]',
                                           pil_a      = '$_POST[pila]',
                                           pil_b      = '$_POST[pilb]',
                                           pil_c      = '$_POST[pilc]',
                                           pil_d      = '$_POST[pild]',
                                           kunci      = '$_POST[kunci]',
                                           tgl_buat   = '$tgl_sekarang'
                                        WHERE id_quiz = '$_POST[id]'");
    }
     header('location:../../media_admin.php?module=daftarquizpilganda&act=daftarquizpilganda&id='.$_POST[topik]);
}

elseif($module=='quiz' AND $act=='hapusquizpilganda'){
    $cek = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_pilganda WHERE id_quiz = '$_GET[id]'");
     $r = mysqli_fetch_array($cek);
     if(empty($r[gambar])){
        mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM quiz_pilganda WHERE id_quiz = '$_GET[id]'");
     }else{
         $img = "../../../foto_soal_pilganda/$r[gambar]";
         unlink($img);
         $img2 = "../../../foto_soal_pilganda/medium_$r[gambar]";
         unlink($img2);
         mysqli_query($GLOBALS["___mysqli_ston"], "DELETE FROM quiz_pilganda WHERE id_quiz = '$_GET[id]'");
     }
     header('location:../../media_admin.php?module=daftarquizpilganda&act=daftarquizpilganda&id='.$_GET[id_topik]);
}

}
?>
