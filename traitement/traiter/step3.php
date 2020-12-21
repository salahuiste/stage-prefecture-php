<?php
	session_start();
	if($_SERVER["REQUEST_METHOD"]=="POST") {
	$typetr="";
	$contenu="";
	$result="";
	include "../../includes/traitement_class.php";
	include "../../includes/reclamation_class.php";
	if(!isset($_SESSION["permission"]))
	 {
		header("Location: ../../login.php");
	}

	$traitement = new traitement();
	$idpdf=$traitement->ajouterTraitement2($_POST); 
	$contenu="الشكاية في طور المعالجة";
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

	                        move_uploaded_file($_FILES['piece']['tmp_name'], '../../uploads/traitement/' . $idpdf.".pdf");

							$traitement->uploadfile($idpdf);	                        

	                }

        }

	}
	header( "refresh:4;url=../reclamations1.php" );
	}
	else 
		header("Location: step1.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
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
</head>
<body onload="pathcat()">
	<div align="center">
		<div>
			<?php
			include ("../../includes/header.php")
			 ?>
		</div>
		<div align="center">
			<h3 style="color:green;" ><?php echo $contenu; ?></h3>
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