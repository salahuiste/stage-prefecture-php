<?php
  $user=$_SESSION["user_info"];
  include "C:\wampp\www\stage\includes\profil_class.php";
  function addBar() {
    $account=new profil($_SESSION["user_info"]);
    $menu=$account->getPrivilage();
    $nbMenu=5;
    $added[]='';
    ajouterQuitter();
    for($i=0;$i<$nbMenu;$i++) {
      if (in_array("Statistiques", $menu) &&  !in_array("Statistiques", $added)) {
        ajouterStatistique();
        $added[]="Statistiques";
      }
      else if (in_array("Repondre", $menu) &&  !in_array("Repondre", $added)) {
        ajouterRepondre();
        $added[]="Repondre";
      }
      else if (in_array("Traiter", $menu) &&  !in_array("Traiter", $added)) {
        ajouterTraitement();
        $added[]="Traiter";
      }
      else if(in_array("Saisir", $menu) &&  !in_array("Saisir", $added)) {
        ajouterPlainte();
        $added[]="Saisir";
      }
    }
    ajouterAccueil();
  }
  function addImages() {
    $account=new profil($_SESSION["user_info"]);
    $menu=$account->getPrivilage();
    $added[]='';
    echo "<tr>";
    for($i=0;$i<sizeof($menu);$i++) {
      if (in_array("Saisir", $menu) &&  !in_array("Saisir", $added)) {
        echo '<td><a href="./reclamation" title="تسجيل شكاية"><img src="http://localhost/stage/images/46395.png" width="90px"></a></td>';
        $added[]="Saisir";
      }
      else if (in_array("Traiter", $menu) &&  !in_array("Traiter", $added)) {
        echo '<td><a href="./traitement" title="معالجة شكاية"><img src="http://www.localhost/stage/images/traitement.png" width="90px"></a></td>';
        $added[]="Traiter";
      }
      else if (in_array("Repondre", $menu) &&  !in_array("Repondre", $added)) {
        echo '<td><a href="./repondre" title="جواب المشتكي"><img src="http://localhost/stage/images/Check-256.png" width="90px"></a></td>';
        $added[]="Repondre";
      }
      else if(in_array("Statistiques", $menu) &&  !in_array("Statistiques", $added)) {
        echo '<td><a href="./statistique" title="احصائيات"><img src="http://www.localhost/stage/images/statics.png" width="90px"></a></td>';
        $added[]="Statistiques";
      }
    }
      if((sizeof($menu)-1)>=2)
        echo"</tr>";
        echo '<td><a href="account.php" title="حسابك"><img src="http://localhost/stage/images/account.png" width="90px"></a></td>';
        echo '<td><a href="logout.php" title="خروج"><img src="http://localhost/stage/images/exit.png" width="90px"></a></td>';


  }
  function ajouterPlainte() {
    echo "<li><a href='http://localhost/stage/reclamation/' id='t1' >تسجيل الشكاية</a></li>";
  }
  function ajouterQuitter() {
    echo "<li><a href='http://localhost/stage/logout.php'>خروج</a></li>";
  }
  function ajouterAccueil() {
    echo "<li><a href='http://localhost/stage/index.php' id='t5' >الرئيسية</a></li>";
  }
  function ajouterTraitement(){
    echo '<li><a href="http://localhost/stage/traitement/" id="t2">معالجة الشكاية</a></li>';
  }
  function ajouterRepondre() {
    echo '<li><a href="http://localhost/stage/repondre/" id="t3">جواب المشتكي</a></li>';
  }
  function ajouterStatistique() {
    echo '<li><a href="http://localhost/./statistique/" id="t4">احصائيات</a></li>';
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>The headre</title>
  <link rel="stylesheet" type="text/css" href="http://localhost/stage/includes/style.css">
</head>
<body >
  <header id="head">
    <div id="imadesc">
      <img src="http://localhost/stage/images/logo_53b5592aee78d.png">
    </div>
    <div id="barremenu">
          <nav>
           <ul>
            <?php 
              addBar();
            ?>
          </ul>
       </nav>
       </div>      
  </header>
</body>
</html>

