<?php
	class repondre {
		private $db;
		public function __construct() {
			try {
				$this->db=new PDO("mysql:host=localhost;dbname=prefecture;charset=utf8","root","");
			}
			catch (Exception $e) {
				die("Erreur:".$e->getMessage());
			}
		}
		public function afficher() {
			$profil=new profil($_SESSION["user_info"]);
			$requete="";
			$tabaal=$profil->reclamationAal();
			if($tabaal=="all") {
				$requete='select * from plainte where date_clot is null and id_rep is null';
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
				$requete='select * from plainte '.$condition.' and date_clot is null and id_rep is null';
			}
			$statement=$this->db->query($requete);
			echo '<table class="tab">';
			echo '<tr>' ;
			echo '<th></th>';
			echo '<th>الرقم التسلسلي</th>';
			echo '<th>موضوع الشكاية</th>';
			echo '<th>اسم المشتكي </th>';
			echo '<th>المرفقات </th>';
			echo '<th>المعلومات </th>';
			echo '</tr>';
			while($donnees=$statement->fetch()){
				$nom=$this->plaignantNom($donnees['id_plaignant']);
				echo '<tr>';
					echo "<td><input type='checkbox' name='plaintetab[]' value='".$donnees['id_plainte']."''></td>";
					echo "<td>".$donnees['num_plainte']."</td>";
					echo "<td>".$donnees['objet']."</td>";
					echo "<td>".$nom."</td>";
					if($donnees['piece_jointe']=='')
						echo "<td>لا يوجد مرفق</td>";
					else
						echo "<td><a href='../".$donnees['piece_jointe']."'><img src='../images/pdf.png' width='10%'></a></td>";
					echo "<td><a href='../traitement/view_reclamation.php?id=".$donnees['num_plainte']."'>انظر إلى المعلومات</a></td>";
					
				echo '</tr>';
			} 
			echo '</table>';
		}
		public function afficher2() {
			$profil=new profil($_SESSION["user_info"]);
			$requete="";
			$tabaal=$profil->reclamationAal();
			if($tabaal=="all") {
				$requete='select * from plainte where date_clot is null ';
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
				$requete='select * from plainte '.$condition.' and date_clot is null';
			}
			$statement=$this->db->query($requete);
			echo '<table class="tab" align="center">';
			echo '<tr>' ;
			echo '<th></th>';
			echo '<th>الرقم التسلسلي</th>';
			echo '<th>موضوع الشكاية</th>';
			echo '<th>اسم المشتكي </th>';
			echo '<th>المرفقات </th>';
			echo '<th>المعلومات </th>';
			echo '</tr>';
			while($donnees=$statement->fetch()){
				$nom=$this->plaignantNom($donnees['id_plaignant']);
				echo '<tr>';
					echo "<td><input type='checkbox' name='plaintetab[]' value='".$donnees['id_plainte']."''></td>";
					echo "<td>".$donnees['num_plainte']."</td>";
					echo "<td>".$donnees['objet']."</td>";
					echo "<td>".$nom."</td>";
					if($donnees['piece_jointe']=='')
						echo "<td>لا يوجد مرفق</td>";
					else
						echo "<td><a href='../".$donnees['piece_jointe']."'><img src='../images/pdf.png' width='10%'></a></td>";
					echo "<td><a href='../traitement/view_reclamation.php?id=".$donnees['num_plainte']."'>انظر إلى المعلومات</a></td>";
					
				echo '</tr>';
			} 
			echo '</table>';
		}
		
		public function plaignantNom($id) {
			$requete=$this->db->query("select nom from plaignant where id_plaignant=".$id);
			$nom='';
			while($donnees=$requete->fetch()) {
				$nom=$donnees['nom'];
			}
			return $nom;
		}
		public function ajouterReponse($tab,$file) 
		{
			//ajouter la reponse dans sa table
			$idrep=$this->insertReponse($tab,$file);
			//l'affectation de la valeur dans la table plainte
			for($i=0;$i<sizeof($tab["plaintetab"]);$i++) {
				$this->updateIdRep($tab["plaintetab"][$i],$idrep);
			}

		}
		public function insertReponse($tab,$file) 
		{	
			$requete="insert into reponse(description,piece_jointe,num_bo) values(:desc,:piece,:numbo)";
			$insert=$this->db->prepare($requete);

			$insert->execute(array(
				"desc" => $tab['rep'],
				"piece" => $file,
				"numbo" => $tab['numbo']
			));

				return $this->db->lastInsertId();
		}
		public function updateIdRep($idplainte,$idrep) 
		{
			$requete="update plainte set id_rep=:rep where id_plainte=:idplainte";
			$insert=$this->db->prepare($requete);

			$insert->execute(array(
				"rep" => $idrep,
				"idplainte" => $idplainte
			));
		}
		public function nbFiles(){
			$donnees=$this->db->query("select count(*) as nb from reponse");
			$nb=$donnees["nb"];

				return $nb+1;
		}
		public function cloture($tab) {
			for($i=0;$i<sizeof($tab["plaintetab"]);$i++) {
				$this->Close($tab["plaintetab"][$i]);
			}
		}
		public function Close($idplainte){
			$idtraitement=$this->getIdCloture();
			$requete="insert into traitement(date_traitement,piece_jointe,num_bo,contenu,id_plainte,id_type_tr,id_aal,id_commun,id_user,id_service_ext,id_service_int) values(:datetr,:piece_jointe,:numb,:cont,:idp,:idty,:idaal,:idcom,:iduser,:idserex,:idserin)";
			$prepare=$this->db->prepare($requete);
			$prepare->execute(array(
			  "datetr" => date("Y/m/d"),
			  "piece_jointe" => NULL,
			  "numb" => NULL,
			  "cont" => NULL,
			  "idp" => $idplainte,
			  "idty" => $idtraitement,
			  "idaal" => NULL,
			  "idcom" => NULL,
			  "iduser" => $_SESSION['user_info']['id_user'],
			  "idserex" => NULL,
			  "idserin" => NULL
			));
			$this->updateDateClot($idplainte);

		}
		public function updateDateClot($idplainte){
			$date=date("Y/m/d");
			$requete="update plainte set date_clot='".$date."' where id_plainte=".$idplainte;
			$this->db->exec($requete);
		}
		public function getIdCloture() {
			$requete="select * from traitement_type where nom='مقفلة'";
			$res=$this->db->query($requete);
			$id=$res->fetch();
				return $id["id_type_trait"];
		}
	}

?>