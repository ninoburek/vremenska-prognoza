<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="hr">
<head>
	<meta charset="utf-8">
	<title><?=$title?></title>
	
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
	
	<link rel="stylesheet" href="css/moj.css">
	
<body>

<div class="header">
	<div class="container">
	<div class="row">
		<div class="col-sm-12 col-md-7">
			<h1><i class="fas fa-cloud-sun-rain"></i> <?=$h1?></h1>
		</div>
		
		
		<div class="col-sm-12 col-md-5">
		<form class="form-inline searchform" style="margin-top:13px">

										
					<div class="input-group mb-4" style="padding:5px;width:100%">
					  <input type="text" id="kojigrad" required class="form-control velikaslova" placeholder="Traži grad" aria-label="Search" aria-describedby="basic-addon2">
					  <div class="input-group-append">
						<button type="submit" class="input-group-text" id="basic-addon2"><i class="fas fa-search"></i></button>
					  </div>
					</div>

			</form>
		</div>
		
	</div>
	</div>
</div>
	
<div class="container">	
		
	
	<div class="row">
		<div class="col-sm-12 col-md-3">
			
			<?=$prijavljen?>
			
			<p>Odaberi grad <a href="" data-target="#sidebar" data-toggle="collapse" class="d-md-none"><i class="fa fa-bars"></i></a></p>
			
			<form id="formaSpremanjeFavorita" method="post">
			
			<div id="sidebar"  class="collapse show  d-md-block">
			 
		
				<ul id="gradoviholder" class="list-group">
				
				<? // predefinirani gradovi ?>
				
				<li><a class="btn btn-primary gumbgrad" href="#" data="dubrovnik">Dubrovnik</a></li>
				<li><a class="btn btn-primary gumbgrad" href="#" data="osijek">Osijek</a></li>
				<li><a class="btn btn-primary gumbgrad" href="#" data="zagreb">Zagreb</a></li>
				<li><a class="btn btn-primary gumbgrad" href="#" data="las vegas">Las Vegas</a></li>
				
				<? // korisnikovi favoriti iz baze ?>
				<?=$korisnikoviFavoriti?>
				
				
			</ul>
				
				
			
				
				<input type="hidden" id="favoriti" name="favoriti" val=""> <? //ovdje se "skupljaju" novi favoriti koje ćemo spremiti u bazu ?>
				
				
	
			</form>	
		
			</div>
			
			
			
			<?=$gumbiAkcije?> <? //ovdje su gumbi spremi favorite ili prijavi se?>
				
		</div>	
		
		<div class="col">
			<div id="prikazpodataka"></div> <? //div za prikaz rezultata vremenske prognoze ?>
		</div>
		
		
	</div>
	
</div>


	<!-- popup za prijavu i registraciju korisnika -->
	<div class="modal fade" id="prijava" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Prijava / Registracija</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<p>Radi jednostavnosti koristimo istu formu za prijavu i registraciju :)</p>

			  <form action="" method="post">
				<div class="form-group row">
						<label for="inputEmail3" class="col-sm-2 col-form-label">Username</label>
						<div class="col-sm-10">
						  <input type="text" class="form-control" id="inputEmail3" placeholder="Username" name="username">
						</div>
					  </div>
					  <div class="form-group row">
						<label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
						<div class="col-sm-10">
						  <input type="password" class="form-control" id="inputPassword3" placeholder="Password" name="password">
						</div>
					  </div>

				  <div class="form-group row">
					<div class="col-sm-10">
					  <button type="submit" class="btn btn-primary">Prijava / registracija</button>
					</div>
				  </div>
						
				  	<input type="hidden" id="favoritipopup" name="favoriti" val="">
				  
			  </form>


		  </div>

		</div>
	  </div>
	</div>	

	
<script  src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<script>var logiran = <?=$LOG?></script> <? //je li korisnik logiran ili ne ?>
	
<script src="js/moj.js"></script>
	
	
</body>
</html>