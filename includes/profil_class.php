<?php 
	class profil {
		private $usertab;
		private $profil;
		private $aal;
		private $privilage;
		private $db;
		public function __construct($usertab) {
			$this->usertab=$usertab;
			try {
				$this->db=new PDO("mysql:host=localhost;dbname=prefecture;charset=utf8","root","");
			}
			catch (Exception $e) {
				die("Erreur:".$e->getMessage());
			}
		}
		public function getProfil(){
			$requete=$this->db->query("select * from profil where id_profil=".$this->usertab["idprofil"]);
			$donnees=$requete->fetch();
			return $donnees['nom'];
		}
		public function getPrivilage(){
			$requete=$this->db->query('select * from privilage natural join profilprive where id_profil='.$this->usertab["idprofil"]);
			$tabprivilage[]='';
			while($donnees=$requete->fetch()) {
				$tabprivilage[]=$donnees["nom"];
			}
			return $tabprivilage;
		}
		public function getAal(){
			$requete=$this->db->query('select * from aal where id='.$this->usertab["idaal"]);
			$all;
			while($donnees=$requete->fetch()) {
				$all=$donnees['nom'];
			}
			return $all;
		}
		public function getPrefixe($idaal) {
			$requete=$this->db->query('select * from aal natural join aal_type where id='.$idaal);
			$prefixe;
			while($donnees=$requete->fetch()) {
				$prefixe=$donnees['prefixe'];
			}
			return $prefixe;
		}
		public function reclamationAal() {
			$nom=$this->getAal($this->usertab["idaal"]);
			if($nom=="ولاية جهة سوس ماسة") {
				return "all";
			}
			else {
				$requete=$this->db->query('select * from aal where id='.$this->usertab["idaal"]);
				$aal=$this->usertab["idaal"];
				while($donnees=$requete->fetch()) {
					$aal.="-".$donnees['aal_childs'];
				}
				$tabaal=explode("-",$aal);
				return $tabaal;
			}
			
			
		}

	}


?>