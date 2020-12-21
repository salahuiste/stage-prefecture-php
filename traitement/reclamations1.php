<?php
	session_start();
	include "../includes/traitement_class.php";
	$title="الشكايات المعالجة";
	$nb;
		if(empty($_GET['page']) or $_GET['page']==1)
			$nb=0;
		else 
			$nb=$_GET['page'];
		$nb*=3;
	if(!isset($_SESSION["permission"]))
		 {
		header("Location: ../login.php");
		}

?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>
	<style type="text/css">
		body {
			background-color: #e9eaeb;
		}
		.tab {
			margin-top: 20px;
			text-align: center;
			width: 80%;
			height: 60%;
			border-radius: 2px;
			font-size: 1.3em;
			border-collapse: collapse;
		}
		.tab tr,td,th {
			border:2px solid #660000;

		}
		.tab th {
			color:white;
			background-color: #660000;
		}
		.tab a {
			text-decoration: none;
		}
	</style>
	<script type="text/javascript">
		function pathcat() {
			var pathname = window.location.pathname;
			
			if(pathname.indexOf("traitement") != -1) {
				document.getElementById("t2").style.color="#04B431";
			}
		}
	</script>
</head>
<body onload="pathcat()">
	<div >
		<div>
			<?php
			include ("../includes/header.php")
			 ?>
		</div>
		<div lang="AR" dir=rtl charset=UTF-8 align="center">
			<?php
				$traitement=new traitement();
				$traitement->reclamationTraite($nb);
			?>
		</div>
		<div align="right">
			<?php
				//$traitement->changePage(1);
			?>
		</div>
	</div>
</body>
</html>

<?php
	//include "../includes/profil_class.php";
	$prof=new profil($_SESSION["user_info"]);
	$tab=$prof->getPrivilage();
	if(!in_array('Traiter',$tab )) {
		header("Location: ../index.php");
	}
?>