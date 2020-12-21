<?php
$msg="";

	if($_SERVER["REQUEST_METHOD"]=="POST")
	{
		require("includes/login_class.php");
		$login = new login($_POST["username"],$_POST["password"]);
		$login->isCorrect();
		if($login->getStatus()) {
			header('Location: index.php');
		}
		else 
		{
			$msg="هناك خطأ ، تأكد من البيانات التي أدخلتها";
		}
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	 <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style type="text/css">
		.butt{
			border-radius: 4px;
			width: 200px;
			height: 30px;
			border:1px solid #cdc9c2;
		}
		.butt1{
			width: 100px;
			height: 30px;
			color: black;
			font-weight: bold;
			border: 1px solid #006633;
			background-color:white;
			border-radius: 6px;
		}
		.butt1:hover{
			color:#9c9ea0;
		}
		
		.err {
			color: red;
		}
	</style>

</head>
<body>

<div id="log" align="center">  
	<p style="font-size: 1.5em; font-weight: bold; color: #0782c8;color: black; background-color: #ffe6e6; ">تسجيل الدخول</p>
	<form action="login.php" method="post">
		<table style="border:2px solid #660000; border-radius: 10px; background-color: #ffe6e6; text-align: center;">
			<tr>
				<td style="color:red; font-weight: bold;" colspan="2">
					<?php echo $msg; ?>
				</td>
			</tr>
			<tr>
				<td><input class="butt" type="text" name="username" required></td>
				<td><strong>اسم المستخدم</strong></td>
			</tr>
			<tr>
				<td><input class="butt" type="password" name="password" required></td>
				<td><strong>كلمة المرور</strong></td>
			</tr>
			<tr>
				<td rowspan="2"><input class="butt1" type="submit" name="login" value="دخول"></td>
			</tr>
		</table>
	</form>
</div>
</body>
</html>