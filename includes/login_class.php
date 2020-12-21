<?php
	class login {
		private $username;
		private $password;
		private $db;
		private $status=false;
		public function __construct($username,$password){
			$this->username=$username;
			$this->password=md5($password);
			try {
				$this->db=new PDO("mysql:host=localhost;dbname=prefecture;charset=utf8","root","");
			}
			catch(Exception $e) {
				die("Erreur:".$e->getMessage());
			}
		}
		public function setUsername($username){
			$this->username=$username;
		}
		public function setPassword($password){
			$this->password=$password;
		}
		public function getUsername() {
			return $this->username;
		}
		public function getPassword() {
			return $this->password;
		}
		public function getStatus(){
			return $this->status;
		}
		public function isCorrect()
		{	
			$db=$this->db;
			$rep=$db->query('SELECT * FROM utilisateur');
		while($donnes=$rep->fetch()) {
			if($this->username==$donnes['login'] && $this->password==$donnes['mdp'] )
			{	
				session_start();
				$_SESSION['permission']='yes';
				$_SESSION['user_info']=array( "username" => $this->username,
					"idprofil" =>$donnes['id_profil'],
					"idaal" => $donnes['id_aal'],
					"id_user" => $donnes['id_user']
				);
				
				$this->status=true;
			}
			
			}
		}
	}



?>