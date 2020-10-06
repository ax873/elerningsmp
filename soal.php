<?php
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
?>

<html>
<header>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="description"  content=""/>
<meta name="keywords" content=""/>
<meta name="robots" content="ALL,FOLLOW"/>
<meta name="Author" content="Rizal Faizal"/>
<meta http-equiv="imagetoolbar" content="no"/>
<title>.::Halaman Tugas / Quiz::.</title>
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
<link rel="stylesheet" href="css/reset.css" type="text/css"/>
<link rel="stylesheet" href="css/screen2.css" type="text/css"/>
<link rel="stylesheet" href="css/fancybox.css" type="text/css"/>
<link rel="stylesheet" href="css/jquery.wysiwyg.css" type="text/css"/>
<link rel="stylesheet" href="css/jquery.ui.css" type="text/css"/>
<link rel="stylesheet" href="css/visualize.css" type="text/css"/>
<link rel="stylesheet" href="css/visualize-light.css" type="text/css"/>


<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.visualize.js"></script>
<script type="text/javascript" src="js/jquery.wysiwyg.js"></script>
<script type="text/javascript" src="js/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript" src="js/jquery.fancybox.js"></script>
<script type="text/javascript" src="js/jquery.idtabs.js"></script>
<script type="text/javascript" src="js/jquery.datatables.js"></script>
<script type="text/javascript" src="js/jquery.jeditable.js"></script>
<script type="text/javascript" src="js/jquery.ui.js"></script>
<script type="text/javascript" src="js/clock.js"></script>

<script type="text/javascript" src="js/excanvas.js"></script>
<script type="text/javascript" src="js/cufon.js"></script>
<script type="text/javascript" src="js/Geometr231_Hv_BT_400.font.js"></script>

<script language="javascript" type="text/javascript">
    tinyMCE_GZ.init({
    plugins : 'style,layer,table,save,advhr,advimage, ...',
		themes  : 'simple,advanced',
		languages : 'en',
		disk_cache : true,
		debug : false
});
</script>
<script language="javascript" type="text/javascript"
src="../tinymcpuk/tiny_mce_src.js"></script>
<script type="text/javascript">
tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		plugins : "table,youtube,advhr,advimage,advlink,emotions,flash,searchreplace,paste,directionality,noneditable,contextmenu",
		theme_advanced_buttons1_add : "fontselect,fontsizeselect",
		theme_advanced_buttons2_add : "separator,preview,zoom,separator,forecolor,backcolor,liststyle",
		theme_advanced_buttons2_add_before: "cut,copy,paste,separator,search,replace,separator",
		theme_advanced_buttons3_add_before : "tablecontrols,separator,youtube,separator",
		theme_advanced_buttons3_add : "emotions,flash",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		extended_valid_elements : "hr[class|width|size|noshade]",
		file_browser_callback : "fileBrowserCallBack",
		paste_use_dialog : false,
		theme_advanced_resizing : true,
		theme_advanced_resize_horizontal : false,
		theme_advanced_link_targets : "_something=My somthing;_something2=My somthing2;_something3=My somthing3;",
		apply_source_formatting : true
});

	function fileBrowserCallBack(field_name, url, type, win) {
		var connector = "../../filemanager/browser.html?Connector=connectors/php/connector.php";
		var enableAutoTypeSelection = true;

		var cType;
		tinymcpuk_field = field_name;
		tinymcpuk = win;

		switch (type) {
			case "image":
				cType = "Image";
				break;
			case "flash":
				cType = "Flash";
				break;
			case "file":
				cType = "File";
				break;
		}

		if (enableAutoTypeSelection && cType) {
			connector += "&Type=" + cType;
		}

		window.open(connector, "tinymcpuk", "modal,width=600,height=400");
	}
</script>

<style type="text/css">
<!--
.style3 {
	color: #62A621;
	font-weight: bold;
}
.garisbawah {
	padding-bottom: 5px;
	border-bottom: 1px dotted #CCC;
}
-->
</style>
<script>
var waktunya;
waktunya = <?php echo "$_POST[waktu]"; ?>;
var waktu;
var jalan = 0;
var habis = 0;
function init(){
    checkCookie()
    mulai();
}
function keluar(){
    if(habis==0){
        setCookie('waktux',waktu,365);
    }else{
        setCookie('waktux',0,-1);
    }
}
function mulai(){
    jam = Math.floor(waktu/3600);
    sisa = waktu%3600;
    menit = Math.floor(sisa/60);
    sisa2 = sisa%60
    detik = sisa2%60;
    if(detik<10){
        detikx = "0"+detik;
    }else{
        detikx = detik;
    }
    if(menit<10){
        menitx = "0"+menit;
    }else{
        menitx = menit;
    }
    if(jam<10){
        jamx = "0"+jam;
    }else{
        jamx = jam;
    }
    document.getElementById("divwaktu").innerHTML = jamx+" H : "+menitx+" M : "+detikx +" S";
    waktu --;
    if(waktu>0){
        t = setTimeout("mulai()",1000);
        jalan = 1;
    }else{
        if(jalan==1){
            clearTimeout(t);
        }
        habis = 1;
        document.getElementById("formulir").submit();
    }
}
function selesai(){    
    if(jalan==1){
            clearTimeout(t);
        }
        habis = 1;
    document.getElementById("formulir").submit();
}
function getCookie(c_name){
    if (document.cookie.length>0){
        c_start=document.cookie.indexOf(c_name + "=");
        if (c_start!=-1){
            c_start=c_start + c_name.length+1;
            c_end=document.cookie.indexOf(";",c_start);
            if (c_end==-1) c_end=document.cookie.length;
            return unescape(document.cookie.substring(c_start,c_end));
        }
    }
    return "";
}

function setCookie(c_name,value,expiredays){
    var exdate=new Date();
    exdate.setDate(exdate.getDate()+expiredays);
    document.cookie=c_name+ "=" +escape(value)+((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
}

function checkCookie(){
    waktuy=getCookie('waktux');
    if (waktuy!=null && waktuy!=""){
        waktu = waktuy;
    }else{
        waktu = waktunya;
        setCookie('waktux',waktunya,7);
    }
}

</script>
<script type="text/javascript">
    window.history.forward();
    function noBack(){ window.history.forward(); }
</script>
<script type="text/javascript">
function tombol()
{
document.getElementById("tombol").innerHTML= "<input type=button value=Simpan onclick=selesai()>";
}
</script>
</header>
<body onload="init(),noBack();" onpageshow="if (event.persisted) noBack();" onunload="keluar()">
<div class="sidebar">
		<div class="logo2 clear"><img src="images/logo.png" alt="" width="185" height="200" /></div>
                    <div class="waktu">
		  <ul><li><a>Sisa Waktu Anda</a>
			  <ul>
				  <div id=divwaktu></div>
			  </ul>
			</li>
                  </ul></div>
</div>


	<div class="main"> <!-- *** mainpage layout *** -->
	<div class="main-wrap">
		<div class="header clear">
		</div>

		<div class="page clear">
			<!-- MODAL WINDOW -->
			<div id="modal" class="modal-window">
				<!-- <div class="modal-head clear"><a onclick="$.fancybox.close();" href="javascript:;" class="close-modal">Close</a></div> -->


			</div>

			<!-- CONTENT BOXES -->
			<!-- end of content-box -->
<div class="notification note-success">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="2%">&nbsp;</td>
      <td width="95%">

<form action=nilai.php method=post id=formulir>

<?php
include "configurasi/koneksi.php";
$cek_siswa = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM siswa_sudah_mengerjakan WHERE id_tq='$_POST[id]' AND id_siswa='$_SESSION[idsiswa]'");
$info_siswa = mysqli_fetch_array($cek_siswa);
if ($info_siswa[hits]<= 0){
    mysqli_query($GLOBALS["___mysqli_ston"], "INSERT INTO siswa_sudah_mengerjakan (id_tq,id_siswa,hits)
                                        VALUES ('$_POST[id]','$_SESSION[idsiswa]',hits+1)");
}
elseif ($info_siswa[hits] > 0){
}

$soal = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_pilganda where id_tq='$_POST[id]' ORDER BY rand()");
$pilganda = mysqli_num_rows($soal);
$soal_esay = mysqli_query($GLOBALS["___mysqli_ston"], "SELECT * FROM quiz_esay WHERE id_tq='$_POST[id]'");
$esay = mysqli_num_rows($soal_esay);
if (!empty($pilganda) AND !empty($esay)){
echo "<br><b class='judul'>Daftar Soal Pilihan Ganda</b><br><p class='garisbawah'></p>
    <table><input type=hidden name=id_topik value='$_POST[id]'>";

$no = 1;
while($s = mysqli_fetch_array($soal)){
    if ($s[gambar]!=''){
    echo "<tr><td rowspan=6><h3>$no.</h3></td><td><h3>".$s['pertanyaan']."</h3></td></tr>";
    echo "<tr><td><img src='foto_soal_pilganda/medium_$s[gambar]'></td></tr>";    
    echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='A'>A. ".$s['pil_a']."</td></tr>";
    echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='B'>B. ".$s['pil_b']."</td></tr>";
    echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='C'>C. ".$s['pil_c']."</td></tr>";
    echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='D'>D. ".$s['pil_d']."</td></tr>";
    }else{
        echo "<tr><td rowspan=5><h3>$no.</h3></td><td><h3>".$s['pertanyaan']."</h3></td></tr>";        
        echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='A'>A. ".$s['pil_a']."</td></tr>";
        echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='B'>B. ".$s['pil_b']."</td></tr>";
        echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='C'>C. ".$s['pil_c']."</td></tr>";
        echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='D'>D. ".$s['pil_d']."</td></tr>";
    }
    $no++;
}
echo "</table>";
echo "<br><b class='judul'>Daftar Soal Essay</b><br><p class='garisbawah'></p>
    <table>";
$no2=1;
while($e=  mysqli_fetch_array($soal_esay)){
    if (!empty($e[gambar])){
    echo "<tr><td rowspan=4><h3>$no2.</h3></td><td><h3>".$e['pertanyaan']."</h3></td></tr>";
    echo "<tr><td><img src='foto_soal/medium_$e[gambar]'></td></tr>";
    echo "<tr><td>Jawaban : </td></tr>";
    echo "<tr><td><textarea name=soal_esay[".$e['id_quiz']."] cols=95 rows=5></textarea></td></tr>";
    }else{
        echo "<tr><td rowspan=3><h3>$no2.</h3></td><td><h3>".$e['pertanyaan']."</h3></td></tr>";
        echo "<tr><td>Jawaban : </td></tr>";
        echo "<tr><td><textarea name=soal_esay[".$e['id_quiz']."] cols=95 rows=5></textarea></td></tr>";
    }
    $no2++;
}
echo "</table>";
$jumlahsoal = $no - 1;
echo "<input type=hidden name=jumlahsoalpilganda value=$jumlahsoal>";
}

elseif (!empty($pilganda) AND empty($esay)){
    echo "<br><b class='judul'>Daftar Soal Pilihan Ganda</b><br><p class='garisbawah'></p>
    <table><input type=hidden name=id_topik value='$_POST[id]'>";

$no = 1;
while($s = mysqli_fetch_array($soal)){
    if ($s[gambar]!=''){
    echo "<tr><td rowspan=6><h3>$no.</h3></td><td><h3>".$s['pertanyaan']."</h3></td></tr>";
    echo "<tr><td><img src='foto_soal_pilganda/medium_$s[gambar]'></td></tr>";
    echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='A'>A. ".$s['pil_a']."</td></tr>";
    echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='B'>B. ".$s['pil_b']."</td></tr>";
    echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='C'>C. ".$s['pil_c']."</td></tr>";
    echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='D'>D. ".$s['pil_d']."</td></tr>";
    }else{
        echo "<tr><td rowspan=5><h3>$no.</h3></td><td><h3>".$s['pertanyaan']."</h3></td></tr>";
        echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='A'>A. ".$s['pil_a']."</td></tr>";
        echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='B'>B. ".$s['pil_b']."</td></tr>";
        echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='C'>C. ".$s['pil_c']."</td></tr>";
        echo "<tr><td><input type=radio name=soal_pilganda[".$s['id_quiz']."] value='D'>D. ".$s['pil_d']."</td></tr>";
    }
    $no++;
}
echo "</table>";
$jumlahsoal = $no - 1;
echo "<input type=hidden name=jumlahsoalpilganda value=$jumlahsoal>";
}
elseif (empty($pilganda) AND !empty($esay)){
    echo "<br><b class='judul'>Daftar Soal Essay</b><br><p class='garisbawah'></p>
    <table><input type=hidden name=id_topik value='$_POST[id]'>";
$no2=1;
while($e=  mysqli_fetch_array($soal_esay)){
    if (!empty($e[gambar])){
    echo "<tr><td rowspan=4><h3>$no2.</h3></td><td><h3>".$e['pertanyaan']."</h3></td></tr>";
    echo "<tr><td><img src='foto_soal/medium_$e[gambar]'></td></tr>";
    echo "<tr><td>Jawaban : </td></tr>";
    echo "<tr><td><textarea name=soal_esay[".$e['id_quiz']."] cols=95 rows=10></textarea></td></tr>";
    }else{
        echo "<tr><td rowspan=3><h3>$no2.</h3></td><td><h3>".$e['pertanyaan']."</h3></td></tr>";
        echo "<tr><td>Jawaban : </td></tr>";
        echo "<tr><td><textarea name=soal_esay[".$e['id_quiz']."] cols=95 rows=10></textarea></td></tr>";
    }
    $no2++;
}
echo "</table>";
}
elseif (empty($pilganda) AND empty($esay)){
    echo "<script>window.alert('Maaf belum ada soal di Topik Ini.');
            window.location=(href='media.php?module=home')</script>";
}
?>
<br><p class='garisbawah'></p>
<h3>Apakah anda sudah yakin dengan jawaban anda dan ingin menyimpannya?  <button type=button onclick="tombol()">Ya</button></h3>
<h3 id="tombol"></h3>
</form>
</td>
      <td width="3%">&nbsp;</td>
    </tr>
  </table>
</div>
			<div class="clear">
				<!-- end of content-box -->

		</div><!-- end of page -->

		<div class="footer clear"></div>
	</div>
	</div>
</div>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-12958851-7']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>

<meta http-equiv="content-type" content="text/html;charset=UTF-8">
</body>
</html>
<?php
}
?>
