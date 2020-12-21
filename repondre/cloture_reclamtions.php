<?php
session_start();
$msg="";
include ("../includes/repondre_class.php");
if($_SERVER['REQUEST_METHOD']=="POST") {
	$file=NULL;
	$reponse=new repondre();
	$reponse->cloture($_POST);
	$msg="تم غلق الشكايات بنجاح";
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>جواب المشتكي</title>
	<style type="text/css">
		body {
			background-color: #e9eaeb;
		}
	</style>
	<script type="text/javascript">
		function pathcat() {
			var pathname = window.location.pathname;
			
			if(pathname.indexOf("repondre") != -1) {
				document.getElementById("t3").style.color="#04B431";
			}
		}
	</script>
</head>
<body onload="pathcat();">
	<div align="center">
		<div>
			<?php
			include ("../includes/header.php")
		 ?>
		</div>
		<div>
			<?php
				echo "<span style='color:green;font-size:1.3em;'>".$msg."</span>";
			?>
		</div>
	</div>
</body>
</html>
<?php
	//include "../includes/profil_class.php";
	$prof=new profil($_SESSION["user_info"]);
	$tab=$prof->getPrivilage();
	if(!isset($_SESSION["permission"]))
	 {
		header("Location: ../login.php");
	}
	else if(!in_array('Repondre',$tab )) {
		header("Location: ../index.php");
	}
?>