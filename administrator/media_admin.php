<?php
session_start();
error_reporting(0);
include "timeout.php";

if($_SESSION[login]==1){
	if(!cek_login()){
		$_SESSION[login] = 0;
	}
}
if($_SESSION[login]==0){
  header('location:logout.php');
}
else{
if (empty($_SESSION['username']) AND empty($_SESSION['passuser']) AND $_SESSION['login']==0){
  echo "<link href=css/style.css rel=stylesheet type=text/css>";
  echo "<div class='error msg'>Untuk mengakses Modul anda harus login.</div>";
}
else{
    if ($_SESSION['leveluser']=='siswa'){
     echo "<link href=css/style.css rel=stylesheet type=text/css>";
     echo "<div class='error msg'>Anda tidak diperkenankan mengakses halaman ini.</div>";
    }
    else{

?>
<html>
<head>
<title>Admin SMP Muh 04 Kertanegara</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/skins/blue.css" title="blue">

<link rel="alternate stylesheet" type="text/css" href="css/skins/orange.css" title="orange">
<link rel="alternate stylesheet" type="text/css" href="css/skins/red.css" title="red">
<link rel="alternate stylesheet" type="text/css" href="css/skins/green.css" title="green">
<link rel="alternate stylesheet" type="text/css" href="css/skins/purple.css" title="purple">
<link rel="alternate stylesheet" type="text/css" href="css/skins/yellow.css" title="yellow">
<link rel="alternate stylesheet" type="text/css" href="css/skins/black.css" title="black">
<link rel="alternate stylesheet" type="text/css" href="css/skins/gray.css" title="gray">

<link rel="stylesheet" type="text/css" href="css/superfish.css">
<link rel="stylesheet" type="text/css" href="css/uniform.default.css">
<link rel="stylesheet" type="text/css" href="css/jquery.wysiwyg.css">
<link rel="stylesheet" type="text/css" href="css/facebox.css">
<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.8.8.custom.css">

<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.8.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/jquery.uniform.min.js"></script>
<script type="text/javascript" src="js/jquery.wysiwyg.js"></script>
<script type="text/javascript" src="js/superfish.js"></script>
<script type="text/javascript" src="js/cufon-yui.js"></script>
<script type="text/javascript" src="js/Delicious_500.font.js"></script>
<script type="text/javascript" src="js/jquery.flot.min.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript" src="js/facebox.js"></script>
<script type="text/javascript" src="../js/clock.js"></script>

<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/switcher.js"></script>

<link rel="shortcut icon" type="image/x-icon" href="images/logo.png">
</head>
<body onload="startclock()">
<header id="top">
	<div class="container_12 clearfix">
		<div id="logo" class="grid_5">
			<!-- replace with your website title or logo -->
			<a id="site-title" href="dashboard.html"><span>ADMINISTRATOR</span><br><span>Pembelajaran Online SMP Muhammadiyah 04 Kertanegara</span></a>
		</div>

		<div class="grid_4" id="colorstyle">
			<div>Change Color</div>
			<a href="#" rel="blue"></a>
			<a href="#" rel="green"></a>
			<a href="#" rel="red"></a>
			<a href="#" rel="purple"></a>
			<a href="#" rel="orange"></a>
			<a href="#" rel="yellow"></a>
			<a href="#" rel="black"></a>
			<a href="#" rel="gray"></a>
		</div>

		<div id="userinfo" class="grid_3">
                    <?php
                    if ($_SESSION[leveluser]=='admin'){
			echo "Welcome, <a href='#'>Administrator</a>";
                    }
                    elseif ($_SESSION[leveluser]=='pengajar'){
                        echo "Welcome, <a href='#'>Teacher</a>";
                    }
                    ?>
		</div>
	</div>
</header>
<?php
if ($_SESSION[leveluser]=='admin'){
?>
<nav id="topmenu">
	<div class="container_12 clearfix">
		<div class="grid_12">
			<ul id="mainmenu" class="sf-menu">
				<li class="current"><a href="media_admin.php?module=home">Beranda</a></li>
				<li><a href="#">Manajemen Users</a>
					<ul>
						<li><a href="?module=admin">Administrator</a></li>
						<li><a href="?module=admin&act=pengajar">Pengajar</a></li>
					</ul>
				</li>
                                <li><a href="#">Setting</a>
					<ul>
						<li><a href="?module=modul">Modules</a></li>
					</ul>
				</li>
				<li><a href="#">Setting Ukuran</a>
					<ul id="layoutwidth">
						<li><a href="#" rel="fixed">Kecil</a></li>
						<li><a href="#" rel="fluid">Besar</a></li>
					</ul>
				</li>
			</ul>
			<ul id="usermenu">				
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</div>
	</div>
</nav>
<?php
}
elseif ($_SESSION[leveluser]=='pengajar'){
?>
<nav id="topmenu">
	<div class="container_12 clearfix">
		<div class="grid_12">
			<ul id="mainmenu" class="sf-menu">
				<li class="current"><a href="media_admin.php?module=home">Beranda</a></li>				
				<li><a href="#">Setting Ukuran</a>
					<ul id="layoutwidth">
						<li><a href="#" rel="fixed">Kecil</a></li>
						<li><a href="#" rel="fluid">Besar</a></li>
					</ul>
				</li>
			</ul>
			<ul id="usermenu">				
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</div>
	</div>
</nav>
<?php
}
?>

<section id="content">
	<section class="container_12 clearfix">
		<section id="main" class="grid_9 push_3">
			<article id="dashboard">
                           <?php include "content_admin.php"; ?>
		        </article>
		</section>

                            <aside id="sidebar" class="grid_3 pull_9">
                        <div class="box info">
				<h2>Assalamuallaikum</h2>
				<section>
                                    <SCRIPT language=JavaScript>var d = new Date();
                                    var h = d.getHours();
                                    if (h < 11) { document.write('Selamat Pagi, Pengunjung...'); }
                                    else { if (h < 15) { document.write('Selamat Siang, Pengunjung..'); }
                                    else { if (h < 19) { document.write('Selamat Sore, Pengunjung..'); }
                                    else { if (h <= 23) { document.write('Selamat Malam, Pengunjung..'); }
                                    }}}</SCRIPT>
                                </section>
			</div>			
			<div class="box menu">
				<h2>Menu Utama</h2>
				<section>
					<ul>
						<?php
                                                include "menu.php";
                                                ?>
					</ul>
				</section>
			</div>
                        <div class="box">
				<h2>Informasi</h2>
				<section>
					<?php
                                        if ($_SESSION[leveluser]=='admin'){
                                            echo "Anda masih dalam keadaan login sebagai : <b>Administrator</b>. <br>";
                                            echo "Jangan lupa untuk <a href=logout.php><b>Logout</b></a> sebelum meninggalkan website ini.";

                                        }
                                        elseif ($_SESSION[leveluser]=='pengajar'){
                                            echo "Anda masih dalam keadaan login sebagai : <b>Pengajar</b>. <br>";
                                            echo "Jangan lupa untuk <a href=logout.php><b>Logout</b></a> sebelum meninggalkan website ini.";
                                        }
                                        ?>
				</section>
			</div>
			
		</aside>
                </section>
        </section>
    


<footer id="bottom">
	<section class="container_12 clearfix">
		
		<div class="grid_6 aligncenter">
			Copyright &copy; 2020 <a href="#">SMP Muhammadiyah 04 Kertanegara</a>
		</div>
	</section>
</footer>

</body>
</html>
<?php
}
}
}
?>