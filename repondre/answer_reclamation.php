<?php
session_start();
include ("../includes/repondre_class.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>جواب المشتكي</title>
	<style type="text/css">
		body {
			background-color: #e9eaeb;
		}
		.tab2 {
			margin-top: 90px;
			margin-left: 190px;
			text-align: center;
			width: 40%;
			height: 10%;
			font-size: 1.3em;
			border:2px solid #660000;
			border-radius: 5px;
		}

		.tab {
			margin-top: 20px;
			margin-left: 190px;
			text-align: center;
			width: 80%;
			height: 60%;
			border-radius: 2px;
			font-size: 1.3em;
			border-collapse: collapse;
		}
		.tab tr {
			border:2px solid #660000;

		}
		.tab td {
			border:2px solid #660000;

		}
		.tab th {
			border:2px solid #660000;
			color:white;
			background-color: #660000;
		}
		.tab a {
			text-decoration: none;
		}
		.btn {
			 background-color:#0099ff;
			 border-radius: 5px;
			 color:white;
			 font-size: 1em;
			 width: 120px;
			 height: 30px;
		}
		.btn:hover {
			background-color:#007acc;
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
		<form action="repondre.php" method="post" enctype="multipart/form-data">
			<div style="display: flex;" align="center" >

			<div lang="AR" dir=rtl charset=UTF-8 align="center">

				<?php 
					$answer=new repondre();
					$answer->afficher();
				?>
			</div>
			<div lang="AR" dir=rtl charset=UTF-8 align="right">
				<table class="tab2">
					<tr>
						<td>الجواب</td>
						<td><textarea name="rep" cols="75" rows="15" required></textarea></td>
					</tr>
					<tr>
						<td>رقم BO</td>
						<td><input type="text" name="numbo" required></td>
					</tr>
					<tr>
						<td>المرفق</td>
						<td><input type="file" name="piece" ></td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" class="btn" value="تسجيل الجواب"></td>
					</tr>
				</table>
			</div>
		</div>
		</form>
		
		
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