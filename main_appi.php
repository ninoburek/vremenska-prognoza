<? ob_start();

//// ovdje staviti API KEY
$api_key = "976e11af93f05f91ac1e6e6f1daa3d49";
//--------------------------------------------


function pocistiGet($var){
    //osnovno ćišćenje od 'neželjenih' karaktera
	$var = stripslashes($var);
    $var = strip_tags($var);
    $var = htmlentities($var);
    return $var;
}


$grad = pocistiGet($_GET['grad']);

$handle = curl_init();
 
//url za dohvaćanje prognoze:
$url = "http://api.openweathermap.org/data/2.5/weather?q=".$grad."&APPID=".$api_key;
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

//ovdje je povrat s openweathermap JSON
$output = curl_exec($handle); 
//----------------------

curl_close($handle);

//---------------------------

  // pretvorba json u array pa u stringove :)
  $ovojeArray = json_decode($output, true); // array
  
  $temperatura = $ovojeArray["main"]["temp"];   // kelvini
  $tlak = $ovojeArray["main"]["pressure"];		// hPa
  $vlaga = $ovojeArray["main"]["humidity"];  	// postotak
  $vrijeme = $ovojeArray["weather"][0]["main"]; // "kakvo je vrijeme?"
  $ikona = $ovojeArray["weather"][0]["icon"];   // ikona"

//povrat json u frontend
print ('{"grad":"'.$grad.'","temperatura":"'.$temperatura.'", "tlak":"'.$tlak.'", "vlaga":"'.$vlaga.'","vrijeme":"'.$vrijeme.'","ikona":"'.$ikona.'"}');
 
?>