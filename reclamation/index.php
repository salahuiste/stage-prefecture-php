<?php

session_start();
if(!isset($_SESSION["permission"]))
{
	echo "dekhlte";
	header("Location: ../login.php");
}
header("Location:step1.php");

?>