<?php
	session_start();
	if(!isset($_SESSION["permission"]))
	{
	session_destroy();
	header("Location:../login.php");
	}
	else if ($_SERVER["REQUEST_METHOD"]=="POST") {
		include "../includes/reclamation_class.php";
		$_SESSION["plainte"]["cin"]=$_POST["cin"];
		$_SESSION["plainte"]["nature"]=$_POST["nature"];
		$_SESSION["plainte"]["fullname"]=$_POST["fullname"];
		$_SESSION["plainte"]["address"]=$_POST["address"];
		$_SESSION["plainte"]["phone"]=$_POST["phone"];
		$_SESSION["plainte"]["objet"]=$_POST["objet"];
		$_SESSION["plainte"]["commune"]=$_POST["commune"];
		$_SESSION["plainte"]["cercleannexe"]=$_POST["cercleannexe"];
		$_SESSION["plainte"]["services"]=$_POST["services"];
		$_SESSION["plainte"]["numbo"]=$_POST["numbo"];
		$plainte=new plainte();
		$plainte->ajouterPlaignant($_SESSION['plainte']);
		$tab=$plainte->ajouterPlainte($_SESSION['plainte']);
		$_SESSION["plainte"]["numcal"]=$tab[0];
		if (isset($_FILES['piece']) AND $_FILES['piece']['error'] == 0)

			{

        // Testons si le fichier n'est pas trop gros

	        if ($_FILES['piece']['size'] <= 1000000)

	        {

	                // Testons si l'extension est autorisée

	                $infosfichier = pathinfo($_FILES['piece']['name']);

	                $extension_upload = $infosfichier['extension'];

	                $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png','pdf','doc','docx');

	                if (in_array($extension_upload, $extensions_autorisees))

	                {

	                        // On peut valider le fichier et le stocker définitivement

	                        move_uploaded_file($_FILES['piece']['tmp_name'], '../uploads/reclamations/' . $tab[1]);

							$_SESSION["plainte"]["piece"]='uploads/reclamations/' . $tab[1];
							$plainte->uploadfile($_SESSION["plainte"]["numcal"],$_SESSION["plainte"]["piece"]);	                        

	                }

        }

	}
		
	}
	else {
		header("Location: step1.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
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
			
			if(pathname.indexOf("reclamation") != -1) {
				document.getElementById("t1").style.color="#04B431";
			}
		}
	</script>
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
				<td>الرقم التسلسلي </td>
				<td><?php echo $_SESSION["plainte"]["numcal"]; ?></td>
			</tr>
			<tr>
				<td>موضوع الشكاية</td>
				<td><?php echo $_SESSION["plainte"]["objet"]; ?></td>
			</tr>
			<tr>
				<td>تاريخ الشكاية</td>
				<td><?php echo date("Y/m/d"); ?></td>
			</tr>
			<tr>
				<td>وضع الشكاية</td>
				<td><?php if($_SESSION["plainte"]["numcal"]!='') echo "مسجلة"; ?></td>
			</tr>
			<tr>
				<td>مصدر الشكاية</td>
				<td><?php echo $plainte->nature_plainte($_SESSION["plainte"]["plaignant"]); ?></td>
			</tr>
			<tr>
				<td>الجماعة</td>
				<td><?php echo $plainte->getCommune($_SESSION["plainte"]["commune"]); ?></td>
			</tr>
			<tr>
				<td>الدائرة أو الملحقة</td>
				<td><?php echo $plainte->getAal($_SESSION["plainte"]["cercleannexe"]); ?></td>
			</tr>
			<tr>
				<td>اسم المشتكي</td>
				<td><?php echo $plainte->plaignantNom(); ?></td>
			</tr>
			<tr>
				<td>طبيعة المشتكي</td>
				<td><?php echo $plainte->getnaturePlaignant($_SESSION["plainte"]["nature"]); ?></td>
			</tr>
			<tr>
				<td>المرفقات</td>
				<td><?php echo "<a href='../".$_SESSION["plainte"]["piece"]."'><img src='../images/pdf.png' width='20%'></a>";?></td>
			</tr>
		</table>
	</div>
</div>
</body>
</html>