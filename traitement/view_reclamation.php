<?php
	session_start();
	if(!isset($_SESSION["permission"]))
	 {
		header("Location: ../login.php");
	}
	else if(empty($_GET["id"])) {
		header("Location: ../index.php");
	}
	include "../includes/plainteinfo_class.php";
	$plainte=new plainteinfo($_GET['id']);

?>

<!DOCTYPE html>
<html>
<head>
	<title>معلومات الشكاية</title>
	<style type="text/css">
	tr,td {
		border:2px solid black;
	}
		body {
			background-color: #e9eaeb;
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
	<style type="text/css">
		body {
			background-color: #e9eaeb;
			}
		table {
			margin-top: 20px;
			text-align: center;
			width: 80%;
			height: 60%;
			border-radius: 2px;
			font-size: 1.3em;
			border-collapse: collapse;
		}
		tr,td {
			border:2px solid #660000;
		}
	    .n {
			color:white;
			font-weight: bold;
			background-color: #660000;

		}

	</style>
</head>
<body onload="pathcat()">

<div align="center">
	<div>
		<?php
			include ("../includes/header.php")
		 ?>
	</div>
	<div>
		<h3 style="color:#e9eaeb;">معلومات خاصة بالشكاية</h3>
	</div>
	
	<div lang="AR" dir=rtl charset=UTF-8 align="center">
		<table style="border-collapse: collapse; margin-top: 10px; border:2px solid #660000; font-size: 1.5em; width: 700px; height: 200px;  text-align: center">
			<tr>
				<td class='n'>الرقم التسلسلي </td>
				<td><?php echo $plainte->getNumP(); ?></td>
			</tr>
			<tr>
				<td class='n'>موضوع الشكاية</td>
				<td><?php echo $plainte->getObjet(); ?></td>
			</tr>
			<tr>
				<td class='n'>تاريخ الشكاية</td>
				<td><?php echo $plainte->getDateEn(); ?></td>
			</tr>
			<tr>
				<td class='n'>وضع الشكاية</td>
				<td><?php echo $plainte->getStatus($plainte->getId()); ?></td>
			</tr>
			<tr>
				<td class='n'>مصدر الشكاية</td>
				<td><?php echo $plainte->getPlainteNature(); ?></td>
			</tr>
			<tr>
				<td class='n'>الجماعة</td>
				<td><?php echo $plainte->getCommune(); ?></td>
			</tr>
			<tr>
				<td class='n'>الدائرة أو الملحقة</td>
				<td><?php echo $plainte->getAal(); ?></td>
			</tr>
			<tr>
				<td class='n'>اسم المشتكي</td>
				<td><?php echo $plainte->getPlaignantNom(); ?></td>
			</tr>
			<tr>
				<td class='n'>طبيعة المشتكي</td>
				<td><?php echo $plainte->getPlaignantNature(); ?></td>
			</tr>
			<tr>
				<td class='n'>المرفقات</td>
				<td><?php if($plainte->getPieceJointe()!='')
							{
								echo "<a href='../".$plainte->getPieceJointe()."'><img src='../images/pdf.png' width='10%'></a>";
							}
				 ?></td>
			</tr>
		</table>
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