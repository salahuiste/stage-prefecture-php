<?php
	session_start();
	if(!isset($_SESSION["permission"]))
	 {
		header("Location: ../login.php");
	}
	include "../includes/reclamation_class.php";
	$plainte= new plainte();
?>
<!DOCTYPE html>
<html>
<head>
	<title>تسجيل شكاية</title>
	<style type="text/css">
	option {
			font-size: 0.9em;
			width: 500px;
			height: 40px;
		}
		.continue {
			color:#004d26;
			border-radius: 10px;
			border:2px solid #660000;
			width: 100px;
			background-color: white;

			font-size: 1.2em;
		}
		body {
			background-color: #e9eaeb;
		}
	</style>
	<script type="text/javascript">
		function pathcat() {
			var pathname = window.location.pathname;
			
			if(pathname.indexOf("reclamation") != -1) {
				document.getElementById("t1").style.color="#04B431";
			}
		}
	</script>
</head>
<body onload="pathcat()">
<div>
	<div>
		<?php
			include ("../includes/header.php")
		 ?>
	</div>
	<div align="center">
	<form method="post" action="step2.php">
		<table style="margin-top: 10px; border:2px solid #660000; font-size: 1.5em; width: 700px; height: 200px;  text-align: center">
			<tr >
				<td >
					<?php $plainte->naturePlainte(); ?>
				</td>
				<td>
					المشتكي
				</td>
				
			</tr>
			<tr>
				<td>
				<?php	$plainte->sourcePlainte(); ?>
				</td>
				<td>
					مصدر الشكاية
				</td>
				
			</tr>
			<tr>
				<td colspan="2">
					<input type="submit" class="continue" name="continue" value="تابع">
				</td>
			</tr>
		</table>
	</form>
		
	</div>
</div>
</body>
</html>