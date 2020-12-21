<?php
	//ankhdem b session
	session_start();
if ($_SERVER["REQUEST_METHOD"]=="POST") {
	include "../includes/reclamation_class.php";
	$plainte= new plainte();
	$_SESSION["plainte"]=array(
		'plaignant' => $_POST['plaignant'],
		'source' => $_POST['source'],
		'nature' => '',
		'cin' => '',
		'fullname' => '',
		'address' => '',
		'phone' => '',
		'commune' => '',
		'cercleannexe' => '',
		'objet' => '',
		'piece' => '',
		'services' => '',
		'numcal'=>''
	);
}
else if(!isset($_SESSION["permission"]))
	{
	session_destroy();
	header("Location:../login.php");
	}
else 
	header("Location: step1.php")

?>
<!DOCTYPE html>
<html>
<head>
	<title>تسجيل شكاية</title>
	<style type="text/css">
		fieldset {
			border-radius: 10px;
			border:2px solid #660000;
		}
		select,option,td {
			font-size: 1.1em;
			width: 500px;
			height: 40px;
			
		}
		table {
			text-align: right;
		}
		legend {
			font-size: 1.4em;
			font-weight: bold;
			color:#660000;
		}
		.btn{
			margin-top: 10px;
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
<div align="center">
	<div>
		<?php
			include ("../includes/header.php")
		 ?>
	</div>
	<div lang="AR" dir=rtl charset=UTF-8 >
	<form action="step3.php" method="post" enctype="multipart/form-data">
		<fieldset >
			<legend lang="ar">معلومات المشتكي</legend>
				<table>
					<tr>
						<td>
							طبيعة المشتكي
						</td>
						<td>
							<?php
								$plainte->naturePlaignant();
							?>
						</td>
					</tr>
					<tr>
						<td>
							رقم البطاقة الوطنية
						</td>
						<td>
							<input style="width: 100px;" type="text" name="cin" required>
						</td>
					</tr>
					<tr>
						<td>
							الاسم الكامل
						</td>
						<td>
							<input style="width: 300px;" type="text" name="fullname" required>
						</td>
					</tr>
					<tr>
						<td>
							العنوان
						</td>
						<td>
							<input style="width: 500px;" type="text" name="address" required>
						</td>
					</tr>
					<tr>
						<td>
							رقم الهاتف
						</td>
						<td>
							<input type="tel" name="phone" required>
						</td>
					</tr>
				</table>
		</fieldset>
		<fieldset>
			<legend>مضمون الشكاية</legend>
			<table>
					<tr>
						<td>
							الجماعة						
						</td>
						<td>
							<?php $plainte->commune(); ?>
						</td>
					</tr>
					<tr>
						<td>
							الدائرة أو الملحقة
						</td>
						<td>
							<?php $plainte->cercleannexe(); ?>
						</td>
					</tr>
					<tr>
						<td>
							الموضوع
						</td>
						<td >
							<input style="width: 600px;" type="text" name="objet" required>
						</td>
					</tr>
					<tr>
						<td>
							المرفقات
						</td>
						<td>
							<input type="file" name="piece" >
						</td>
					</tr>
					<tr>
						<td>
							المصلحة المعنية 
						</td>
						<td>
							<?php $plainte->services(); ?>
						</td>
					</tr>
					<tr>
						<td>
							رقم BO 
						</td>
						<td>
							<input style="width: 200px;" type="text" name="numbo" required>
						</td>
					</tr>
			</table>
		</fieldset>
	    <input type="submit" name="sub" class="btn" align="center" value="تسجيل">
		</form>
	</div>
</div>
</body>
</html>