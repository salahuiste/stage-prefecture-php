<?php 
	session_start();
	$user=$_SESSION["user_info"];
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>حسابك</title>
	<style type="text/css">
		table {
			width: 500px;
			height: 200px;
			border:2px solid #660000;
			border-radius: 10px;
			color: black;
		}
		body {
			background-color: #e9eaeb;
		}
	</style>
</head>
<body>
<?php
	include('includes/header.php');
	$account=new profil($_SESSION["user_info"]);	
 ?>
<div lang="AR" dir=rtl charset=UTF-8 align="center">
	<div>
		<h2>معلومات حسابك</h2>
	</div>
	<div>
		<table style="text-align: center; font-size: 1.2em;
		">
			<tr>
				<td>اسم المستخدم</td>
				<td><?php echo $_SESSION["user_info"]["username"]; ?></td>
			</tr>
			<tr>
				<td colspan="2"><a href="change_password.php" style="color:blue; text-decoration: none;">تغيير الرقم السري</a></td>
			</tr>
			<tr>
				<td>
					المركز
				</td>
				<td>
					<?php 
						echo $account->getAal();
					?>
				</td>
			</tr>
		</table>
	</div>
	
</div>
</body>
</html>
