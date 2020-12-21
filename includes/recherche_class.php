<?php 
	class recherche {
		private $cin;
		private $numplainte;
		private $db;
		public function __construct($cin,$numplainte) {
			$this->cin=$cin;
			$this->numplainte=$numplainte;
			try {
				$this->db=new PDO("mysql:host=localhost;dbname=prefecture;charset=utf8","root","");
			}
			catch (Exception $e) {
				die("Erreur:".$e->getMessage());
			}
		}
		public function recherche() {
			$requete="select * from plainte natural join plaignant where ";
			$flag=0;
			$drap=0;
			if($this->cin!=NULL) {
				$requete.="cin='".trim($this->cin)."'";
				$flag=1;
			}
			if($this->numplainte!=NULL) {
				if($flag==1)
					$requete.=" and ";
				$requete.="num_plainte='".trim($this->numplainte)."'";
			}
			$res=$this->db->query($requete);
			echo "<table class='tab'>";
			while($donnees=$res->fetch()){
				if($drap==0)
					$drap=1;
				echo "<tr>";
				echo "<td>".$donnees['num_plainte']."</td>";
					echo "<td>".$donnees['objet']."</td>";
					echo "<td>".$donnees['nom']."</td>";
					if($donnees['piece_jointe']=='')
						echo "<td>لا يوجد مرفق</td>";
					else
						echo "<td><a href='../".$donnees['piece_jointe']."'><img src='../images/pdf.png' width='10%'></a></td>";
					echo "<td><a href='./view_reclamation.php?id=".$donnees['num_plainte']."'>انظر إلى المعلومات</a></td>";
					echo "<td><a href='./historique.php?id=".$donnees['num_plainte']."'>السجل</a></td>";
				echo "</tr>";
			}
			echo "</table>";
			if($drap==1)
				return true;
			return false;
		}
		public function historique($num_plainte)
		{
			$id_plainte=$this->getId($num_plainte);
			$flag=0;
			if(!$id_plainte)
				return false;
			$requete="select * from traitement t, traitement_type tt where t.id_type_tr=tt.id_type_trait and id_plainte=".$id_plainte." order by id_traitement";
			$res=$this->db->query($requete);
			echo "<table>";
			echo "<tr>";
			echo "<th>التاريخ</th>";
			echo "<th>رقم BO</th>";
			echo "<th>وضع الشكاية</th>";
			echo "<th>المزيد</th>";
			echo "</tr>";
			while($donnees=$res->fetch()) {
				$flag=1;
				echo "<tr>";
					echo "<td>".$donnees["date_traitement"]."</td>";
					echo "<td>".$donnees["num_bo"]."</td>";
					echo "<td>".$donnees["nom"]."</td>";
					echo "<td><a href='".$this->showDetail($donnees["nom"]).$num_plainte."''>انظر إلى المعلومات</a></td>";
				echo "</tr>"; 
			}
			echo "</table>";
			return true;

		}

		public function getId($nump) {
			$res=$this->db->query("select id_plainte from plainte where num_plainte='".$nump."'");
			while($donnees=$res->fetch()) {
				return $donnees["id_plainte"];
			}
			return false;
		}	
		public function showDetail($nom) {
			switch($nom) {
				case 'مسجلة':
					return 'view_reclamation.php?id=';
				case 'إجابة':
					return 'view_reclamation2.php?type=1&id=';
				case 'مغلقة':
					return false;
				default :
					return 'view_reclamation2.php?type=2&id=';
			}
		}

	}

?>e