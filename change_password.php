<?php
	$msg='';
	session_start();
	if(empty($_SESSION['permission']) OR $_SESSION['permission']=='non' ) {
	$title='Redirecting';
	header('Location: login.php');
}
else {
	if($_SERVER["REQUEST_METHOD"] == "POST") {
 	try {
			$bdd=new PDO("mysql:host=localhost;dbname=prefecture;charset=utf8","root","");
		}
		catch(Exception $e)
			{
        die('Erreur : '.$e->getMessage());
		}
 	$donnes=$bdd->query("SELECT password FROM utilisateur where username='".$_SESSION["user"]."'");
 	$thepass=$donnes->fetch();
 	$thepass_entred=md5($_POST['oldpass']);
 	if(strlen($_POST['newpassword1'])<5) {
 		$msg='<span style="color:red">كلمة المرور يجب أن تحتوي على 6 حروف على الأقل</span>';
 	}
 	else {

 		if($thepass['password']!=$thepass_entred OR strlen($thepass_entred)<5) {
 		$msg='<span style="color:red">كلمة المرور غير صحيحة</span>';
 	}
 	else {
 		if($_POST['newpassword1']!=$_POST['newpassword2']) {
 			$msg='كلمة المرور غير متطابقة';
 		}
 		else {
 			$thenew_pass=md5($_POST['newpassword1']);
 			$req = $bdd->prepare('UPDATE utilisateur set password=:pass WHERE username=:username');

			$req->execute(array(
				    'pass' => $thenew_pass,
				    'username' =>$_SESSION["user"] 
				    ));
 			$msg='<span style="color:green">تم تغيير كلمة المرور بنجاح</span>';
 		}
 	}
 	}
 	
 	}
}
 
?>

<!DOCTYPE html>
<html>
<head>
	<title>تغيير كلمة المرور</title>
	<style type="text/css">
		table {
			width: 500px;
			height: 300px;
			border:2px solid #660000;
			border-radius: 10px;
			color: black;
		}
		div table {
			margin: auto;
			text-align: center;
			margin-top: 60px;
		}
		.ps {
			border: 1.6px solid #96999a;
			border-radius: 10px;
			width: 250px;
		}
		#btt {
			border: 1.6px solid #660000;
			width: 100px;
			color:black;
			font-weight: bold;
			border-radius: 10px;
		}
		td {
			font-size: 1em;
			font-weight: bold;
		}
		body {
			background-color: #e9eaeb;
		}
	</style>
</head>
<body>
<?php include('includes/header.php') ?>
<div>
	<form action="change_password.php" method="post">
	<table lang="AR" dir=rtl charset=UTF-8>
		<tr>
			<td colspan="2">
				<?php echo $msg; ?>
			</td>
		</tr>
		<tr>
			<td>
				كلمة المرور الحالية
			</td>
			<td>
				<input class="ps" type="Password" name="oldpass">
			</td>
		</tr>
		<tr>
			<td>
				كلمة المرور الجديدة
			</td>
			<td>
				<input class="ps" type="Password" name="newpassword1">
			</td>
		</tr>
		<tr>
			<td>
				تأكيد كلمة المرور الجديدة
			</td>
			<td>
				<input class="ps" type="Password" name="newpassword2">
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input id="btt" type="submit" value="تغيير">
			</td>
		</tr>
	</table>
	</form>

</div>
</body>
</html>