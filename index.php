<?php
session_start();
$title=$msg='';
if($_SESSION["permission"] == 'yes') {
	$title="فضاء الشكايات";
	$msg.=" مرحبا بك ";
}
else {
	$title='Redirecting';
	header('Location: login.php');
}
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>
	<style type="text/css">
		td {
			border:2px solid #660000;
			border-radius: 10px;
			padding: 40px;
		}
		tr {

			width: 200px;
		}
		body {
			background-color: #e9eaeb;
		}
	</style>
	<script type="text/javascript">
		var x_position=0,text,the_timer;
		function set_timer(){
			text=document.getElementById("welcomeM");
			x_position=x_position+1;
			text.style.left=x_position+"px";
			the_timer=setTimeout(set_timer,20);

		}
		function pathcat() {
			var pathname = window.location.pathname;
			
			if(pathname.indexOf("stage") != -1) {
				document.getElementById("t5").style.color="#04B431";
			}
		}
	</script>
</head>
<body onload="set_timer(); pathcat();">
	<?php include('includes/header.php'); ?>
 <div style="display: flex; flex-direction: column;" align="center">
	<div>
			<p id="welcomeM" style="position: absolute;left:0px; font-size:1.5em;"><?php echo $msg; ?></p>
	</div>
	<div style="margin-top: 80px;" >
		<table>
			<?php
				addImages();
			 ?>
		</table>
	</div>
 </div>	
	
		
</body>
</html>