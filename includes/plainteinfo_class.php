<?php 
	class plainteinfo {
		private $num_p;
		private $db;

		public function __construct($nump) {
			$this->num_p=$nump;
			try {
				$this->db=new PDO("mysql:host=localhost;dbname=prefecture;charset=utf8","root","");
			}
			catch (Exception $e) {
				die("Erreur:".$e->getMessage());
			}
		}
		public function getNumP() {
			return $this->num_p;
		}
		public function getId() {
			$req=$this->db->query("select id_plainte from plainte where num_plainte='".$this->num_p."'");

			$id="";
			while($donnees=$req->fetch())
				$id=$donnees['id_plainte'];
			return $id;
		}
		public function getObjet() {
			$requete="select objet from plainte where num_plainte='".$this->num_p."'";
			$objet='';
			$res=$this->db->query($requete);
			while($donnees=$res->fetch()) {
				$objet=$donnees['objet'];
			}

				return $objet;
		}
		public function getDateEn() {
			$requete="select date_enrg from plainte where num_plainte='".$this->num_p."'";
			$date='';
			$res=$this->db->query($requete);
			while($donnees=$res->fetch()) {
				$date=$donnees['date_enrg'];
			}

				return $date;
		}
		public function getPlaignantNom() {
			$requete="select nom from plainte natural join plaignant where num_plainte='".$this->num_p."'";
			$nom='';
			$res=$this->db->query($requete);
			while($donnees=$res->fetch()) {
				$nom=$donnees['nom'];
			}

				return $nom;
		}
		public function getCommune() {
			$requete="select nom from plainte as p,commune as c where c.id=p.id_commune and num_plainte='".$this->num_p."'";
			$commune='';
			$res=$this->db->query($requete);
			while($donnees=$res->fetch()) {
				$commune=$donnees['nom'];
			}

				return $commune;
		}
		public function getAal() {
			$requete="select nom from plainte as p,aal as a where a.id=p.id_aal and num_plainte='".$this->num_p."'";
			$aal='';
			$res=$this->db->query($requete);
			while($donnees=$res->fetch()) {
				$aal=$donnees['nom'];
			}

				return $aal;
		}
		public function getPlaignantNature() {
			$requete="select nom from nature_plaignant where id=(select id_type from plainte natural join plaignant where num_plainte='".$this->num_p."')";
			$res=$this->db->query($requete);
			$nature='';
			while($donnees=$res->fetch()) {
				$nature=$donnees['nom'];
			}

				return $nature;
		}
		public function getPlainteNature() {
			$requete="select nom from nature_plainte where id=(select id_nature from plainte where num_plainte='".$this->num_p."')";
			$res=$this->db->query($requete);
			$nature='';
			while($donnees=$res->fetch()) {
				$nature=$donnees['nom'];
			}

				return $nature;
		}
		public function getPieceJointe() {
			$requete="select piece_jointe from plainte where num_plainte='".$this->num_p."'";
			$piece='';
			$res=$this->db->query($requete);
			while($donnees=$res->fetch()) {
				$piece=$donnees['piece_jointe'];
			}

				return $piece;
		}
		public function getStatus($id) {
			$requete="select * from traitement t, traitement_type tt where t.id_type_tr=tt.id_type_trait and t.id_plainte=".$id;
			$statement=$this->db->query($requete);
			$status="";
			while($donnees=$statement->fetch()) {
				if($donnees["nom"]=="الاحالة على الجماعات الترابية") {
					$status=$donnees["nom"].":<br>".$this->getCom($donnees["id_commun"]);
				}
				else if($donnees["nom"]=="الاحالة على المصالح الخارجية") {
					$status=$donnees["nom"].":<br>".$this->getServiceEx($donnees["id_service_ext"]);
				}
				else if($donnees["nom"]=="الاحالة الداخلية من أجل الإفادة بالمعطيات أو اعداد جواب للمشتكي") {
					$status=$donnees["nom"].":<br>".$this->getServiceIn($donnees["id_service_int"]);
				}
				else if($donnees["nom"]=="الاحالة على السلطة المحلية") {
					$status=$donnees["nom"].":<br>".$this->getAal2($donnees["id_aal"]);
				}
				else {
					$status=$donnees["nom"];
				}
			}
			return $status;
		}
		public function getCom($id) {
			$requete=$this->db->query('select * from commune where id='.$id);
			$commune='';
			while($donnees=$requete->fetch()) {
				$commune=$donnees['nom'];
			}
			
			return $commune;
		}
		public function getAal2($id) {
			$requete=$this->db->query('select * from aal where id='.$id);
			$aal='';
			while($donnees=$requete->fetch()) {
				$aal=$donnees['nom'];
			}
			
			return $aal;
		}
		public function getServiceEx($id) {
			$requete=$this->db->query('select * from service_exterieur where id_service_ext='.$id);
			$service='';
			while($donnees=$requete->fetch()) {
				$service=$donnees['nom'];
			}
			
			return $service;
		}
		public function getServiceIn($id) {
			$requete=$this->db->query('select * from service_interieur where id='.$id);
			$service='';
			while($donnees=$requete->fetch()) {
				$service=$donnees['nom'];
			}
			
			return $service;
		}
	}



?>