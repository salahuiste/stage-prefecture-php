<?php
session_start();
include ("../includes/repondre_class.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>جواب المشتكي</title>
	<style type="text/css">
		body {
			background-color: #e9eaeb;
		}
		.tab2 {
			margin-top: 90px;
			margin-left: 190px;
			text-align: center;
			width: 40%;
			height: 10%;
			font-size: 1.3em;
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
		.tab th {
			border:2px solid #660000;
			color:white;
			background-color: #660000;
		}
		.tab a {
			text-decoration: none;
		}
		.btn {
			 background-color:#0099ff;
			 border-radius: 5px;
			 color:white;
			 font-size: 1em;
			 width: 120px;
			 height: 30px;
		}
		.btn:hover {
			background-color:#007acc;
		}
		#myBtn {
		  display: block;
		  position: fixed;
		  top: 190px;
		  left: 10px;
		  z-index: 99;
		  font-size: 18px;
		  border: none;
		  outline: none;
		  background-color: red;
		  color: white;
		  cursor: pointer;
		  padding: 15px;
		  border-radius: 4px;
		  width: 150px;
		  height: 50px;
		}

		#myBtn:hover {
		  background-color: #555;
		}
	</style>
	<script type="text/javascript">
		function pathcat() {
			var pathname = window.location.pathname;
			
			if(pathname.indexOf("repondre") != -1) {
				document.getElementById("t3").style.color="#04B431";
			}
		}
		window.onscroll = function() {scrollFunction()};

		function scrollFunction() {
		    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
		        document.getElementById("myBtn").style.display = "block";
		    } else {
		        document.getElementById("myBtn").style.display = "block";
		    }
		}

		// When the user clicks on the button, scroll to the top of the document
		function topFunction() {
		    document.body.scrollTop = 0;
		    document.documentElement.scrollTop = 0;
		}
	</script>
</head>
<body onload="pathcat();">
	<form action="cloture_reclamtions.php" method="post">
		<div align="center">
			<div>
				<?php
				include ("../includes/header.php")
			 ?>
			</div>
			<div align="center" >

				<div lang="AR" dir=rtl charset=UTF-8 align="center">

					<?php 
						$answer=new repondre();
						$answer->afficher2();
					?>
				</div>
				
			</div>
			<div lang="AR" dir=rtl charset=UTF-8 align="right" >
					<table class="tab2">
						<tr>
							<button onclick="topFunction()" id="myBtn" title="غلق الشكاية">غلق الشكاية</button>
						</tr>
					</table>
				</div>
			
		</div>
	</form>
		

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
	else if(!in_array('Repondre',$tab )) {
		header("Location: ../index.php");
	}
?>