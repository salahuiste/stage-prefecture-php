<?php
	session_start();
	if(!isset($_SESSION["permission"]))
	 {
		header("Location: ../login.php");
	}
	else if(empty($_GET["id"])) {
		header("Location: ../recherche.php");
	}
	include "../includes/recherche_class.php";

?>
<!DOCTYPE html>
<html>
<head>
	<title>سجل</title>
	<style type="text/css">
		body {
			background-color: #e9eaeb;
			}
		table {
			margin-top: 20px;
			text-align: center;

			border-radius: 2px;
			font-size: 1.3em;
			border-collapse: collapse;
		}
		 tr,td,th {
			border:2px solid #660000;

		}
		 th {
			color:white;
			background-color: #660000;
		}
		table  a {
			text-decoration: none;
		}
	</style>
</head>
<body onload="pathcat()">
	<div align="center" >
		<div>
			<?php
				include ("../includes/header.php")
		 	?>
		</div>
		<div lang="AR" dir=rtl charset=UTF-8 align="center">
			<?php 
				$historique=new recherche("","");
				if(!$historique->historique($_GET["id"]))
					echo "<h3>خطأ</h3>"

			?>
		</div>
	</div>
</body>
</html>
<?php
	$prof=new profil($_SESSION["user_info"]);
	$tab=$prof->getPrivilage();
	if(!in_array('Traiter',$tab )) {
		header("Location: ../index.php");
	}
?>