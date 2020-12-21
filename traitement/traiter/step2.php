<?php
	session_start();
	$typetr="";
	include "../../includes/plainteinfo_class.php";
	include "../../includes/reclamation_class.php";
	if(!isset($_SESSION["permission"]))
	 {
		header("Location: ../../login.php");
	}
	else if(empty($_GET["id"])) {
		header("Location: ../../index.php");
	}
	$plainte=new plainteinfo($_GET['id']);
	$objet="موضوع الشكاية:".$plainte->getObjet();
	$pla=new plainte();
	switch($_GET["typetraitement"]) {
		case 4:
			$typetr="المصالح الداخلية";
			break;
		case 5:
			$typetr="السلطة المحلية";
			break;
		case 9:
			$typetr="المصالح الخارجية";
			break;
		case 10:
			$typetr="الجماعات";
			break;

									}
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
				<form action="step3.php" method="post" enctype="multipart/form-data">
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
								<select name="typetraitement" >
									<option value="4" <?php if($_GET["typetraitement"]==4) echo "selected"; ?> >الاحالة الداخلية من أجل الإفادة بالمعطيات أو اعداد جواب للمشتكي </option>
									<option value="5" <?php if($_GET["typetraitement"]==5) echo "selected"; ?> >الاحالة على السلطة المحلية </option>
									<option value="6" <?php if($_GET["typetraitement"]==6) echo "selected"; ?> >الاحالة على القضاء للاختصاص</option>
									<option value="7" <?php if($_GET["typetraitement"]==7) echo "selected"; ?> >الاحالة على العمالات والأقاليم </option>
									<option value="8" <?php if($_GET["typetraitement"]==8) echo "selected"; ?> >الاحالة على المصالح الأمنية</option>
									<option value="9" <?php if($_GET["typetraitement"]==9) echo "selected"; ?> >الاحالة على المصالح الخارجية</option>
									<option value="10" <?php if($_GET["typetraitement"]==10) echo "selected"; ?> >الاحالة على الجماعات الترابية</option>
									<option value="11" <?php if($_GET["typetraitement"]==11) echo "selected"; ?> >المطالبة بمعطيات اضافية من المشتكي</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>
								<?php echo $typetr; ?>
							</td>
							<td>
								<?php
									switch($_GET["typetraitement"]) {
										case 4:
											$pla->servicesi();
											break;
										case 5:
											$pla->cercleannexe();
											break;
										case 9:
											$pla->service_ext();
											break;
										case 10:
											$pla->commune();
											break;

									}
								?>
							</td>
						</tr>
						<tr>
							<td>
								ملاحظات
							</td>
							<td>
								<textarea cols="40" rows="10" name="contenu" required></textarea>
							</td>
						</tr>
						<tr>
							<td>
								المرفق
							</td>
							<td>
								<input type="file" name="piece">
							</td>
						</tr>
						<tr>
							<td>
								رقم BO
							</td>
							<td>
								<input type="text" name="numbo" required>
							</td>
						</tr>
						<tr style="text-align: center;">
							<td colspan="2">
								<input type="submit" class="continue" name="continue" value="تسجيل" >
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