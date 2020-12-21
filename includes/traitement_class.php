<?php

	class traitement {
		private $db ;
		private $id_traitement;
		public function __construct() {
			try {
				$this->db=new PDO("mysql:host=localhost;dbname=prefecture;charset=utf8","root","");
			}
			catch (Exception $e) {
				die("Erreur:".$e->getMessage());
			}
		}
		public function reclamationNonTraite($nb)
		{

			$profil=new profil($_SESSION["user_info"]);
			$requete="";
			$tabaal=$profil->reclamationAal();
			if($tabaal=="all") {
				$requete='select * from plainte where date_clot is null and id_plainte not in(select id_plainte from traitement where id_type_tr!=1 and id_type_tr!=3)';
			}
			else {
				$condition="";
				for($i=0;$i<sizeof($tabaal);$i++) {
					if($i==0)
						$condition="where (id_aal=".$tabaal[$i];
					else if($i==sizeof($tabaal)-1)
						$condition.=" or id_aal=".$tabaal[$i].")";
					else
						$condition.=" or id_aal=".$tabaal[$i];
						}
				$requete='select * from plainte '.$condition.' and date_clot is null and id_plainte not in(select id_plainte from traitement where id_type_tr!=1 and id_type_tr!=3)';
			}
			$statement=$this->db->query($requete);
			echo '<table class="tab">';
			echo '<tr>' ;
			echo '<th>الرقم التسلسلي</th>';
			echo '<th>موضوع الشكاية</th>';
			echo '<th>اسم المشتكي </th>';
			echo '<th>المرفقات </th>';
			echo '<th>المعلومات </th>';
			echo '<th>المعالجة</th>';
			echo '</tr>';
			while($donnees=$statement->fetch()){
				$nom=$this->plaignantNom($donnees['id_plaignant']);
				echo '<tr>';
					echo "<td>".$donnees['num_plainte']."</td>";
					echo "<td>".$donnees['objet']."</td>";
					echo "<td>".$nom."</td>";
					if($donnees['piece_jointe']=='')
						echo "<td>لا يوجد مرفق</td>";
					else
						echo "<td><a href='../".$donnees['piece_jointe']."'><img src='../images/pdf.png' width='10%'></a></td>";
					echo "<td><a href='./view_reclamation.php?id=".$donnees['num_plainte']."'>انظر إلى المعلومات</a></td>";
					echo "<td><a href='./traiter/step1.php?id=".$donnees['num_plainte']."'>بدء المعالجة</a></td>";
				echo '</tr>';
			} 
			echo '</table>';
		}
		public function changePage($type) {
			if($type==2)
				$getnm=$this->db->query('SELECT count(*)as nb_page FROM plainte where date_clot is null and num_plainte not in(select id_plainte from traitement) ');
			else if($type==1)
				$getnm=$this->db->query('SELECT count(*)as nb_page FROM plainte where num_plainte in(select id_plainte from traitement) ');
		$nb_pagea=$getnm->fetch();
		if($nb_pagea['nb_page']==0)
			return;
		$p=0;
		$p=$nb_pagea['nb_page']/6;
		if($nb_pagea['nb_page']%6) $p++;

		echo "<tr>";
		echo "<td>";
		if($type==2)
			echo "<form method='get' action='reclamations2.php'>";
		else if($type==1)
			echo "<form method='get' action='reclamations1.php'>";
		echo"<select class='select' name='page'>";
				for($i=1;$i<=$p;$i++) {
					echo"<option value='".$i."'>";
					echo $i;
					echo "</option>";
				}

			echo "</select>";
		echo "<input type='submit' class='but' value='>>'>";	
		echo "</form>";
		echo "</td>";
				echo "</tr>";

				echo "</table>";
		}
		public function plaignantNom($id) {
			$requete=$this->db->query("select nom from plaignant where id_plaignant=".$id);
			$nom='';
			while($donnees=$requete->fetch()) {
				$nom=$donnees['nom'];
			}
			return $nom;
		}
		public function reclamationTraite($nb) 
		{
			$profil=new profil($_SESSION["user_info"]);
			$requete="";
			$tabaal=$profil->reclamationAal();
			if($tabaal=="all") {
				$requete='select * from plainte where date_clot is null and id_plainte in(select distinct(id_plainte) from traitement where id_type_tr!=1 and id_type_tr!=3)';
			}
			else {
				$condition="";
				for($i=0;$i<sizeof($tabaal);$i++) {
					if($i==0)
						$condition="where (id_aal=".$tabaal[$i];
					else if($i==sizeof($tabaal)-1)
						$condition.=" or id_aal=".$tabaal[$i].")";
					else
						$condition.=" or id_aal=".$tabaal[$i];
						}
				$requete='select * from plainte '.$condition.' and date_clot is null and id_plainte in(select distinct(id_plainte) from traitement where id_type_tr!=1 and id_type_tr!=3)';
			}
			$statement=$this->db->query($requete);
			echo '<table class="tab">';
			echo '<tr>' ;
			echo '<th>الرقم التسلسلي</th>';
			echo '<th>موضوع الشكاية</th>';
			echo '<th>اسم المشتكي </th>';
			echo '<th>المرفقات </th>';
			echo '<th>المعلومات </th>';
			echo '</tr>';
			while($donnees=$statement->fetch()){
				$nom=$this->plaignantNom($donnees['id_plaignant']);
				$piece_joite=$this->getPieceJointe($donnees['id_plainte']);
				echo '<tr>';
					echo "<td>".$donnees['num_plainte']."</td>";
					echo "<td>".$donnees['objet']."</td>";
					echo "<td>".$nom."</td>";
					if($piece_joite=='')
						echo "<td>لا يوجد مرفق</td>";
					else
						echo "<td><a href='../uploads/traitement/".$piece_joite."'><img src='../images/pdf.png' width='10%'></a></td>";
					echo "<td><a href='./view_reclamation.php?id=".$donnees['num_plainte']."'>انظر إلى المعلومات</a></td>";
				echo '</tr>';
			} 
			echo '</table>';
		}
		public function getPieceJointe($idp) {
			$requete="select * from traitement where (id_type_tr!=1 and id_type_tr!=3) and id_plainte=".$idp;
			$statement=$this->db->query($requete);
			$piece="";
			while($donnees=$statement->fetch()) {
				if($donnees['piece_jointe']!=NULL)
					$piece=$donnees['piece_jointe'];
			}
			return $piece;
		}
		public function getIdPlainte($numplainte) {
			$requete=$this->db->query("select * from plainte where num_plainte='".$numplainte."'");
			$idplainte='';
			while($donnees=$requete->fetch()) {
				$idplainte=$donnees['id_plainte'];
			}

				return $idplainte;
		}
		public function ajouterTraitement2($tab) {
			$commune=NULL;
			$idaal=NULL;
			$idserex=NULL;
			$idserin=NULL;
			$typetraitement=$tab['typetraitement'];
			$requete="insert into traitement(date_traitement,piece_jointe,num_bo,contenu,id_plainte,id_type_tr,id_aal,id_commun,id_user,id_service_ext,id_service_int) values(:datetr,:piece_jointe,:numb,:cont,:idp,:idty,:idaal,:idcom,:iduser,:idserex,:idserin)";
			if(isset($tab['commune'])) {
				$commune=$tab['commune'];
				//$typetraitement=2;
			}
			else if(isset($tab['services'])) {
				$idserin=$tab['services'];
				//$typetraitement=2;
			}
			else if(isset($tab['serviceext'])) {
				$idserex=$tab['serviceext'];
				//$typetraitement=2;
			}
			else if(isset($tab['cercleannexe'])) {
				$idaal=$tab['cercleannexe'];
				//$typetraitement=2;
			}
			$date=date("Y/m/d");
			$iduser=$_SESSION['user_info']['id_user'];
			$numbo=$tab['numbo'];
			$idplainte=$this->getIdPlainte($tab['id']);
			$prepare=$this->db->prepare($requete);

			$prepare->execute(array(
				'datetr' =>$date,
				'piece_jointe' =>NULL,
				'numb' => $numbo,
				'cont' => $tab['contenu'],
				'idp' => $idplainte,
				'idty' => $typetraitement,
				'idaal' => $idaal,
				'idcom' => $commune,
				'iduser' => $iduser,
				'idserex' => $idserex,
				'idserin' => $idserin,
			));
			$this->id_traitement=$this->db->lastInsertId();

			return $this->id_traitement;
		}
		public function uploadfile($idtraitement) {
			$namefile=$idtraitement.".pdf";
			$update=$this->db->prepare("update traitement set piece_jointe=:piece where id_traitement=:idtraitement");
			$update->execute(array(
				'piece' =>$namefile,
				'idtraitement' =>$idtraitement
			)
			) or die("erreur");
		}
	}


?>