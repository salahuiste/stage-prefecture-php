<?php
	session_start();
	include "../../includes/plainteinfo_class.php";
	include "../../includes/reclamation_class.php";
	if(!isset($_SESSION["permission"]))
	 {
		header("Location: ../../login.php");
	}
	else if(empty($_GET["id"])) {
		header("Location: ../reclamations2.php");
	}
	$pl=new plainte();
	$plainte=new plainteinfo($_GET['id']);
	$objet="موضوع الشكاية:".$plainte->getObjet();

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		body {
			background-color: #e9eaeb;
		}
		select,option,td {
			font-size: 1.1em;
			width: 500px;
			height: 40px;
			
		}
		table {
			width:800px;
			border-radius: 2px;
			text-align: right;
			border-collapse: collapse;
			border:2px solid #660000;
		}
		tr,td {
			width: 400px;
			padding: 5px;
		}
		.continue {
			color:#004d26;
			border-radius: 10px;
			border:2px solid #660000;
			width: 100px;
			background-color: white;

			font-size: 1.2em;
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
			include ("../../includes/header.php")
			 ?>
		</div>
		<div lang="AR" dir=rtl charset=UTF-8 align="center">
			<div align="right">
				<h4><?php echo $objet;?></h4>
			</div>
			<div>
				<form action="step2.php" method="get">
					<table>
						<tr>
							<td>
								الرقم التسلسلي
							</td>
							<td>
								<input type="text" readonly name="id" value=<?php echo "'".$_GET['id']."'";?>>
							</td>
						</tr>
						<tr>
							<td>
								المعالجة
							</td>
							<td>
								<?php
									$pl->getTraitementType();
								?>
							</td>
						</tr>
						<tr style="text-align: center;">
							<td colspan="2">
								<input type="submit" class="continue" name="continue" value="تابع" >
							</td>
						</tr>
					</table>
					

				</form>
				
			</div>
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