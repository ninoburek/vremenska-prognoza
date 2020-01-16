<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pocetna extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{	
		session_start();
		
		$this->load->database(); //klasa za spajanje na bazu će nam ovjde trebati
		
		//osnovne postavke aplikacije, title, h1...
		$varijable['title'] = "Vremenska prognoza";
		$varijable['h1'] = "Vremenska prognoza";

		$varijable['prijavljen'] = '';
		$varijable['LOG']=0; // u startu nije logiran, ali ćemo to provjeriti ;)
		$id=''; //id korisnika;
		$varijable['korisnikoviFavoriti']=''; //ovo ćemo popuniti iz baze ako je logiran i ako ima favorita;
		
		
		if(isset($_SESSION['username'])){
			$varijable['LOG']=1; //logiran je, onda uopće ne treba popup za registraciju ni login :)
			
			
						//koji je to korisnik
						$query = $this->db->query('SELECT id, username from users WHERE username='.$this->db->escape($_SESSION['username']).' LIMIT 1');

						// i trebamo njegov id
						$row = $query->row();
						$id=$row->id;
				
						$varijable['prijavljen']="<p>Prijavljeni ste kao <em>".$row->username."</em></p>";
			
		}else{
		
		
				//tu ćemo prvo provjeriti želi li se korisnik logirati ili registrirati
				if($this->input->post('username') and $this->input->post('password')){

					

					//provjera postoji li takav korisnik u bazi: 
					$query = $this->db->query('SELECT username from users WHERE username='.$this->db->escape($this->input->post('username')).' and password='.$this->db->escape($this->input->post('password')).' LIMIT 1');


					if($query->num_rows()==0){
						//nije pronađen kori{snik za logiranje, pa ćemo ga registrirati, tj dodati u bazu i odmah logirati
						$query = $this->db->query("INSERT INTO users (username,password) VALUES (
						".$this->db->escape($this->input->post('username')).", 
						".$this->db->escape($this->input->post('password')).")");

						$varijable['LOG']=1;
						$_SESSION['username'] = $this->input->post('username');
						
						
						//dodali smo ga, trebamo njegov id
							$query = $this->db->query("SELECT id FROM users ORDER by id DESC LIMIT 1"); //ovako dohvaćamo samo radi pojadnostavljenja!!!!
							$row = $query->row();
							$id=$row->id;
											

					}else{
						//pronađen je korisnik u bazi
						$query = $this->db->query('SELECT id, username from users WHERE username='.$this->db->escape($this->input->post('username')).' and password='.$this->db->escape($this->input->post('password')).' LIMIT 1');

						// i trebamo njegov id
						$row = $query->row();
						$id=$row->id;
						
						//onda ćemo ga logirati:
						$_SESSION['username'] = $this->input->post('username');
						$varijable['LOG']=1; 
						$varijable['prijavljen']="<p>Prijavljeni ste kao <em>".$_SESSION['username']."</em></p>";
						$varijable['prijavljen']="<hr>";
						
						
						

					}
					
				

				}

		}
		
		
		
		//sad još samo prije prikaza stranice da pokupimo njegove favorite iz baze ako je logiran:
		if(isset($_SESSION['username'])){
		
			//ako je usput dodao i favorite moramo ih dodati u bazu:
					if($this->input->post('favoriti')){
							//dodali smo ga, trebamo njegov ID da bi dodali favorite u bazu
							//sve ovo samo ako je poslao neke favorite
							
							

								$dijelovi = explode(",",$this->input->post('favoriti'));

								foreach($dijelovi as $dio){
									if($dio!=''){
										$query = $this->db->query("INSERT INTO favoriti (id_usera,grad) VALUES (".$id.",".$this->db->escape($dio).")");
									}
								}

						}
			
			
			
			
			
			$query = $this->db->query("SELECT grad FROM favoriti WHERE id_usera=".$id."");

			foreach ($query->result() as $row){
				//evo njegovih favorita
				$varijable['korisnikoviFavoriti'].= '<li><a class="btn btn-primary gumbgrad" href="#" data="'.$row->grad.'">'.$row->grad.'</a></li>';
					
			}
		}
		
		
		//postavljamo gumbe spremi favorite ili prijavi se
				$varijable['gumbiAkcije'] = '';
				$varijable['prijavljen']= '';
		
				if($varijable['LOG']==0){  // ako nijje logiran mu treba gumb za prijavu/registracijuu 
						$varijable['gumbiAkcije'] .=  '<div class="alert alert-warning" id="blokzaspremanje">';
						$varijable['gumbiAkcije'] .=  '<p>Trajno Spremanje favorita omogućeno je samo za prijavljene korisnike!</p>';
				  		$varijable['gumbiAkcije'] .=  '<a href="#" class="btn btn-danger" data-toggle="modal" data-target="#prijava">Prijavite se</a>';
						$varijable['gumbiAkcije'] .=  '</div>';
					
						$varijable['prijavljen'].="<p>Niste prijavljeni! <a href='#' data-toggle='modal' data-target='#prijava'>Prijavite se</a> i dohvatite svoje favorite :)</p>";
						$varijable['prijavljen'].="<hr>";
					
					
				 } 
		
		//konačno učitavamo View ;)
		$this->load->view('pocetna',$varijable); // prikaz stranice
		
	}
}
