<?php 
	class plainte {

		private $db;
		private $id_plaignant;
		private $id_plainte;
		public function __construct(){

			try {
				$this->db=new PDO("mysql:host=localhost;dbname=prefecture;charset=utf8","root","");
			}
			catch(Exception $e){
				die($e->getMessage());
			}
		}
		public function sourcePlainte()
		{
			$requete=$this->db->query("select * from source");

			echo "<select name='source' style='width: 100px;' required>";
			while($source=$requete->fetch()) {
				echo "<option value='".$source["id"]."'>".$source["nom"]." </option>";	
			}
			echo "</select>";
		}
		public function naturePlaignant()
		{
			$requete=$this->db->query("select * from nature_plaignant");

			echo "<select name='nature' required>";
			while($nature=$requete->fetch()) {
				echo "<option value='".$nature["id"]."'>".$nature["nom"]." </option>";	
			}
			echo "</select>";
		}
		public function naturePlainte()
		{
			$requete=$this->db->query("select * from nature_plainte");

			echo "<select name='plaignant' style='width: 100px;' required>";
			while($nature=$requete->fetch()) {
				echo "<option value='".$nature["id"]."'>".$nature["nom"]." </option>";	
			}
			echo "</select>";
		}
		public function commune() {
			$requete=$this->db->query("select * from commune");

			echo "<select name='commune' required>";
			while($commune=$requete->fetch()) {
				echo "<option value='".$commune["id"]."'>".$commune["nom"]."</option>";	
			}
			echo "</select>";
		}
		public function service_ext() {
			$requete=$this->db->query("select * from service_exterieur");

			echo "<select name='serviceext' required>";
			while($services=$requete->fetch()) {
				echo "<option value='".$services["id_service_ext"]."'>جماعة ".$services["nom"]."</option>";	
			}
			echo "</select>";
		}
		public function cercleannexe() {
			$requete=$this->db->query("select * from aal where id_aal is null");
			$root=$requete->fetch();
			echo "<select name='cercleannexe' required>";
			echo "<option value='".$root["id"]."'>".$root["nom"]."</option>";	
			$requete1=$this->db->query("select * from aal where id_aal=".$root["id"]);
			while($donnes1=$requete1->fetch()) {
				
				$type=$this->db->query("select * from aal_type where id_aal_type=".$donnes1["id_aal_type"])->fetch();
				echo "<option value='".$donnes1["id"]."'>&nbsp;&nbsp;&nbsp;".$type["nom"]." ".$donnes1["nom"]."</option>";
				$requete2=$this->db->query("select * from aal where id_aal=".$donnes1["id"]);
				while($donnes2=$requete2->fetch()) {
					$type=$this->db->query("select * from aal_type where id_aal_type=".$donnes2["id_aal_type"])->fetch();
				echo "<option value='".$donnes2["id"]."'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$type["nom"]." ".$donnes2["nom"]."</option>";
			}
			}
			echo "</select>";

		}
		public function getaaltype($id_all_type) {
			$requete=$this->db->query("select * from aal_type where id_aal_type=".$id_all_type);
			$donnees=$requete->fetch();
			return $donnees["nom"];
		}
		public function getTraitementType() 
		{
			$requete=$this->db->query("select * from traitement_type where isStatus=0");

			echo "<select name='typetraitement' required>";
			while($traitement=$requete->fetch()) {
				echo "<option value='".$traitement["id_type_trait"]."'>".$traitement["nom"]."</option>";	
			}
			echo "</select>";
		}
		public function services() {
			$requete1=$this->db->query("select * from service_interieur where id_service_int is null");
			echo "<select name='services'  required>";
			while($donnees1=$requete1->fetch()) {
				if($donnees1['nom']=='الكتابة العامة') {
				echo "<option value='".$donnees1["id"]."' selected='selected'>".$donnees1["nom"]."</option>";
				}
				else
					echo "<option value='".$donnees1["id"]."' disabled='disabled'>".$donnees1["nom"]."</option>";
				$requete2=$this->db->query("select * from service_interieur where id_service_int=".$donnees1["id"]);
				while($donnees2=$requete2->fetch()) {
					echo "<option value='".$donnees2["id"]." ' disabled='disabled'>&nbsp;&nbsp;&nbsp;".$donnees2["nom"]."</option>";
				}

				
			}
			echo "</select";
		}
		public function servicesi() {
			$requete1=$this->db->query("select * from service_interieur where id_service_int is null");
			echo "<select name='services'  required>";
			while($donnees1=$requete1->fetch()) {
				echo "<option value='".$donnees1["id"]."'>".$donnees1["nom"]."</option>";
				$requete2=$this->db->query("select * from service_interieur where id_service_int=".$donnees1["id"]);
				while($donnees2=$requete2->fetch()) {
					echo "<option value='".$donnees2["id"]." ' >&nbsp;&nbsp;&nbsp;".$donnees2["nom"]."</option>";
				}

				
			}
			echo "</select";
		}
		public function ajouterPlaignant($plaignant) {
			$insert=$this->db->prepare("insert into plaignant(nom,cin,adresse,tel,id_type) values(:nom,:cin,:address,:tel,:type)");
			$insert->execute(array(
				'nom' => $plaignant['fullname'],
				'cin' => $plaignant['cin'],
				'address' => $plaignant['address'],
				'tel' => $plaignant['phone'],
				'type' => $plaignant['nature']
			)
			) or die("erreur");
			$this->id_plaignant=$this->db->lastInsertId();
		}
		public function ajouterplainte($plainte) {
			$insert=$this->db->prepare("insert into plainte(objet,date_enrg,date_clot,num_plainte,piece_jointe,id_status,id_nature,id_aal,id_source,id_plaignant,id_rep,id_commune,id_service_int) values(:objet,:dateen,:datecl,:nump,:piece,:idstatus,:idnature,:idaal,:idsource,:idplaignant,:idrep,:idcom,:idservicei)");

			$insert->execute(array(
				'objet' => $plainte['objet'],
				'dateen' => date("Y/m/d"),
				'datecl' => NULL,
				'nump' => NULL,
				'piece' => NULL,
				'idstatus' => 1,
				'idnature' => $plainte['nature'],
				'idaal' => $plainte['cercleannexe'],
				'idsource' => $plainte['source'],
				'idplaignant' => $this->id_plaignant,
				'idrep' => NULL,
				'idcom' => $plainte['commune'],
				'idservicei' => $plainte['services']
			)) or die("erreur");
			$this->id_plainte=$idplainte=$this->db->lastInsertId();
			$prefixe=$this->getPrefixe($plainte['cercleannexe']);
			$year=date("Y");
			$num_plainte= "$prefixe/$idplainte/$year";
			$piece="$prefixe-$idplainte-$year.pdf";
			//l'ajout num_plainte
			$update=$this->db->prepare("update plainte set num_plainte=:nump where id_plainte=:id_p");
			$update->execute(array(
				'nump' =>$num_plainte, 
				'id_p' => $idplainte
			)
			) or die("erreur");
			$this->ajoutertraitement($plainte["numbo"]);
			return array($num_plainte,$piece);

		}
		public function uploadfile($numplainte,$namefile) {
			$update=$this->db->prepare("update plainte set piece_jointe=:piece where num_plainte=:nump");
			$update->execute(array(
				'piece' =>$namefile,
				'nump' =>$numplainte
			)
			) or die("erreur");
		}
		public function ajoutertraitement($numbo) {
			$cmd="INSERT INTO traitement (date_traitement,piece_jointe,num_bo,contenu, id_plainte,id_type_tr, id_aal, id_commun,id_user,id_service_ext,id_service_int) VALUES ('".date("Y/m/d")."', NULL, '".$numbo."', NULL,".$this->id_plainte.", 1, NULL, NULL, ".$_SESSION['user_info']['id_user'].", NULL, NULL)";
			$this->db->exec($cmd);
		}
		public function getPrefixe($idaal) {

			$requete=$this->db->query('select * from aal as a,aal_type as b where a.id_aal_type=b.id_aal_type and id='.$idaal);
			$pref='';
			while($donnees=$requete->fetch()) {
				$pref=$donnees['prefixe'];
			}
			
			return $pref;
		}
		public function nature_plainte($id) {
			$requete=$this->db->query('select * from nature_plainte where id='.$id);
			$nom='';
			while($donnees=$requete->fetch()) {
				$nom=$donnees['nom'];
			}
			
			return $nom;
		}
		public function getCommune($id) {
			$requete=$this->db->query('select * from commune where id='.$id);
			$commune='';
			while($donnees=$requete->fetch()) {
				$commune=$donnees['nom'];
			}
			
			return $commune;
		}
		public function getAal($id) {
			$requete=$this->db->query('select * from aal where id='.$id);
			$aal='';
			while($donnees=$requete->fetch()) {
				$aal=$donnees['nom'];
			}
			
			return $aal;
		}
		public function plaignantNom() {
			$requete=$this->db->query('select * from plaignant where id_plaignant='.$this->id_plaignant);
			$nom='';
			while($donnees=$requete->fetch()) {
				$nom=$donnees['nom'];
			}
			
			return $nom;
		}
		public function getnaturePlaignant($id) {
			$requete=$this->db->query('select * from nature_plaignant where id='.$id);
			$nom='';
			while($donnees=$requete->fetch()) {
				$nom=$donnees['nom'];
			}
			
			return $nom;
		}
	}

?>