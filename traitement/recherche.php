<?php
	session_start();
	$msg='';
	include "../includes/reclamation_class.php";
	$plainte= new plainte();
	if($_SERVER["REQUEST_METHOD"]=="POST") 
		if(empty($_POST["cin"]) && empty($_POST["numplainte"])) 
			$msg="المرجوا إدخال معلومات البحث";
?>
<!DOCTYPE html>
<html>
<head>


	<title>البحث</title>
	<style type="text/css">
		body {
			background-color: #e9eaeb;
		}
		select,option,td {
			font-size: 1.1em;
			width: 400px;
			height: 40px;
			
		}
		.tab {
			margin-top: 20px;
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
		.tab a {
			text-decoration: none;
		}
		.btn {
			 background-color:#0099ff;
			 border-radius: 5px;
			 color:white;
			 font-size: 1em;
			 width: 80px;
			 height: 30px;
		}
		.btn:hover {
			background-color:#007acc;
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
<div align="center">
	<div>
		<?php
			include '../includes/header.php';
		?>
	</div>
	<div>
		<div>
			<h2>بحث</h2>
		</div>
		<div lang="AR" dir=rtl charset=UTF-8 align="center" style="border:2px solid #660000; width: 400px; border-radius: 5px;">
			<form action="recherche.php" method="post">
				<table style="text-align: center; ">
					<tr>
						<td>
							رقم البطاقة الوطنية
						</td>
						<td>
							<input type="text" name="cin" value=<?php if(isset($_POST["cin"])) echo "'".trim($_POST["cin"])."'"; ?> >
						</td>
					</tr>
					<tr>
						<td>
							الرقم التسلسلي  
						</td>
						<td>
							<input type="text" name="numplainte" value=<?php if(isset($_POST["cin"])) echo "'".trim($_POST["numplainte"])."'"; ?>>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="submit" value="البحث" class="btn" >
						</td>
					</tr>
				</table>
			</form>
		</div>
		<div lang="AR" dir=rtl charset=UTF-8 align="center">
			<?php
				if($_SERVER["REQUEST_METHOD"]=="POST") {
					if(!empty($_POST["cin"]) || !empty($_POST["numplainte"])) {
					include "../includes/recherche_class.php";
					$recherche=new recherche($_POST["cin"],$_POST["numplainte"]);
					if(!$recherche->recherche()) {
						$msg="لم يتم العثور على أي شكاية بهذه المعلومات";
					}
					}
						
				}

			?>
		</div>
		<div>
			<p style="color:red; font-size: 1.2em;"><?php echo $msg; ?></p>
		</div>
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
	else if(!in_array('Traiter',$tab )) {
		header("Location: ../index.php");
	}
?>