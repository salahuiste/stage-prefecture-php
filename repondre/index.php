<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>جواب المشتكي</title>
	<style type="text/css">
		body {
			background-color: #e9eaeb;
		}
		td {
			border:2px solid #660000;
			border-radius: 10px;
			padding: 40px;
		}
		tr {
			width: 100px;
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
			<table style="margin-top: 80px; text-align: center;">
				<tr>
					<td>
						<a href="answer_reclamation.php" title="جواب المشتكي"><img src="http://localhost/stage/images/traitement_1.png" width="60%"></a>
					</td>
					<td>
						<a href="cloture.php" title="قفل الشكاية"><img src="http://localhost/stage/images/lock.png" width="60%"></a>
					</td>

				</tr>
			</table>
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