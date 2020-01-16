

function Kelvin_u_Farenheit(kelvina){
	var Fahrenheita = (kelvina * (9/5)) - 459.67;
	return Math.round(Fahrenheita);
}

function zamjenaikona(ikona){
	// ikone koje dobinamo u json odgovoru 
	var MoguceIkone = ['01d', '02d', '03d', '04dg', '09d', '10d', '11d', '13d', '50d' ,'01n', '02n', '03n', '04n', '09n', '10n', '11n', '13n', '50n'];
	
	// naše ikone koje će zamijeniti dobivene
	var NoveIkone = ['far fa-bell','fas fa-address-card','fab fa-algolia','fas fa-allergies','fas fa-ambulance','far fa-angry','fas fa-atom','fas fa-balance-scale','fas fa-bath','fas fa-bell','fas fa-address-book','fab fa-bitcoin','fab fa-bluetooth','fas fa-bone','fas fa-book','fas fa-bong','fas fa-border-all','fas fa-box'];
	
	var DobivenaIkona = MoguceIkone.indexOf(ikona); // index u arrayu dobivene ikone
		
	var ZamjenjenaIkona=NoveIkone[DobivenaIkona]; // nova ikona
	return ZamjenjenaIkona;
}

//posebna funckija dajAjax() jer ju možemo pozivati klikom na gumb ili preko pretraživača
function dajAjax(grad){
	
	//očistiti stare rezultate:
	$('#prikazpodataka').html('');
	
	$.ajax({
		  type: "GET",
		  url: "main_appi.php",
		  data: "grad="+grad,
		  cache: false,
		  success: 
			function(results){
				//console.log(results)
				//s rezultatima u novu funckiju radi boljeg pregleda
				rezultati(results);
			}
	  });
	
	
}


function postaviOnKlik(){
	//kao posebna fukcija jer nakon dodavanja novog favorita ne radi onclick na taj gumb!
	
	
	
	$('.gumbgrad').unbind('click'); 			// prvo mičemo click event ako ga ima
	$('.gumbgrad').on('click', function(){ 		// pa ga onda postavljamo
		$('.loader').css("display","block");
		
	$('#sidebar').collapse('hide'); // i zatvaramo izbornik gradova ako je otvoren

		
			var grad = $(this).attr('data'); 	// koji grad je kliknuit

			dajAjax(grad); // idemo po podatke :)
	});
}
	
postaviOnKlik(); // aktiviraj onclick event, 

$('.searchform').on('submit', function(e){  
		$('.loader').css("display","block");
		e.preventDefault();	
		var grad = $('#kojigrad').val(); //koji grad je upisan u pretraživač
		
		dajAjax(grad); // idemo po podatke :)
	
		
	
});


function rezultati(results){
	
	obj = $.parseJSON(results);
	
	var grad = obj.grad;
	var temperaturaK = obj.temperatura; //ovo je u Kelvinima
	var temperaturaF = Kelvin_u_Farenheit(temperaturaK); //ovo je u Fahrenheitima
	var tlak = obj.tlak;
	var vlaga = obj.vlaga;
	var ikona = obj.ikona; //od ovoga će ikonica; ide kroz fukciju zamjenaIkona!
	var vrijeme = obj.vrijeme; //kakvo je vrijeme;
	
	//prvo mičemo loader
	$('.loader').css("display","none");
	
	//prikaz podataka
	$('#prikazpodataka').append("<h2 class='velikaslova'>"+grad+"</h2><hr>");
	$('#prikazpodataka').append("<p>"+vrijeme+" <i class='"+zamjenaikona(ikona)+"'></p>");
	$('#prikazpodataka').append("<p>Temperatura: <strong>"+temperaturaF+"°F</strong></p");
	$('#prikazpodataka').append("<p>Tlak:<strong> "+tlak+" hPa</strong></p");
	$('#prikazpodataka').append("<p>Vlaga:<strong> "+vlaga+" %</strong></p");
	
	//dodajemo gumb ako taj grad ne postoji u favoritima!
	var dodajemo = true; // u startu dodajemo gumb

	$('.gumbgrad').each(function() {
		var taj = $(this).attr('data');
		
		if(taj==grad){
			dodajemo = false;//našli smo taj grad već u favoritima po ne dodajemo gumb
		}
	});
	
	if( dodajemo == true){
		$('#prikazpodataka').append("<p><a href='#' class='btn btn-danger dodajgradufavorite' data='"+grad+"'>Dodaj grad u favorite</a></p");
			
			//gumbu dodajemo fukcionalnost
			$('.dodajgradufavorite').on('click',function(){
				$('#gradoviholder').append('<li><a class="btn btn-primary gumbgrad velikaslova" href="#" data="'+grad.toLowerCase()+'">'+grad+'</a></li>');
				
				//kod novih favorita ubacujemo i favorita u hidden polje koje možemo spremiti u bazu
				$('#favoriti').val($('#favoriti').val()+grad+",");
				$('#favoritipopup').val($('#favoritipopup').val()+grad+","); //u popup za logiranje tako da odmah i dodamo novog favorita novom korisnku :)
				
				//nakon dodavanja novogo gumba ne radi onclick pa moramo ga moramo opet inicijalizirati!
				postaviOnKlik();
				
				//i nakon dodavanja maknuti gumb dodaj grad u favorite jer nam više ne treba
				$('.dodajgradufavorite').remove();
				
				//gumb za spremanje favorita sada postaje vidljiv
				$('.spremanjefavorita').css("display","block");
				
				//i moramo spremiti u bazu novog favorita, samo submitamo formu ;) sve je već napravljeno
				if(logiran==1){
					$('#formaSpremanjeFavorita').submit()
				}else{
					//nije logiran pa ćemo mu pokazati da se može logirati/registrati
					$('#blokzaspremanje').css("display","block");
				}
				
				
				
			});
			
	}

}




