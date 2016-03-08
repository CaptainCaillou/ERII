<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
<?php

function curling($url, $postFields) {

	$useragent = 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.5; en-US; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'; // Setting useragent of a popular browser
		 
	$cookie = 'cookie.txt'; // Setting a cookie file to store cookie

	$ch = curl_init($url);

	curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);  // Setting cookiefile
	curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);   // Setting cookiejar
	curl_setopt($ch, CURLOPT_USERAGENT, $useragent);    // Setting useragent
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE); // Follow Location: headers
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Returning transfer as a string

	         
	return curl_exec($ch);  // Executing cURL session

}

$ligneA = [
	'terminus' => [
		'LJM' => 'Lycée J. Monnet',
		'V' => 'Vaucanson'
	],
	'arrets' => [
		'Lycée J. Monnet'   	=> ['LYJM-1T',		  ['986197047084' => 'V']],
		'Stade Jean Bouin'  	=> ['STJB-1T,STJB-2T',['986196947108' => 'LJM', '986197047109' => 'V']],
		'Rabière' 		    	=> ['RABI-1T,RABI-2T',['986196947100' => 'LJM', '986197047101' => 'V']],
		'Rotière'				=> ['ROTI-1T,ROTI-2T',['986196947104' => 'LJM', '986197047105' => 'V']],
		'Joué Hotel de Ville'	=> ['JHDV-1T,JHDV-2T',['986196947078' => 'LJM', '986197047079' => 'V']],
		'République'			=> ['REPB-1T,REPB-2T',['986196947102' => 'LJM', '986197047103' => 'V']],
		'Pont Volant'			=> ['POVO-1T,POVO-2T',['986196947098' => 'LJM', '986197047099' => 'V']],
		'Heure Tranquille'		=> ['HETR-1T,HETR-2T',['986196947076' => 'LJM', '986197047077' => 'V']],
		'Suzanne Valadon'		=> ['VALA-1T,VALA-2T',['986196947116' => 'LJM', '986197047117' => 'V']],
		'Verdun'				=> ['VERD-1T,VERD-2T',['986196947118' => 'LJM', '986197047119' => 'V']],
		'Charcot'				=> ['CHAR-1T,CHAR-2T',['986196947065' => 'LJM', '986197047066' => 'V']],
		'Liberté'				=> ['LIBE-1T,LIBE-2T',['986196947082' => 'LJM', '986197047083' => 'V']],
		'Sanitas'				=> ['SANI-1T,SANI-2T',['986196947106' => 'LJM', '986197047107' => 'V']],
		'Palais des sports'		=> ['PASP-1T,PASP-2T',['986196947096' => 'LJM', '986197047097' => 'V']],
		'Gare de Tours'			=> ['GATO-1T,GATO-2T',['986196947074' => 'LJM', '986197047075' => 'V']],
		'Jean Jaurès'			=> ['JJAU-1T,JJAU-2T',['986196947080' => 'LJM', '986197047081' => 'V']],
		'Nationale'				=> ['NATI-1T,NATI-2T',['986196947094' => 'LJM', '986197047095' => 'V']],
		'Anatole France'		=> ['ANFR-1T,ANFR-2T',['986196947061' => 'LJM', '986197047062' => 'V']],
		'Place Choiseul'		=> ['CHOI-1T,CHOI-2T',['986196947067' => 'LJM', '986197047068' => 'V']],
		'Mi-côte'				=> ['MICO-1T,MICO-2T',['986196947090' => 'LJM', '986197047091' => 'V']],
		'Tranchée'				=> ['TRAN-1T,TRAN-2T',['986196947110' => 'LJM', '986197047111' => 'V']],
		'Christ Roi'			=> ['CHRI-1T,CHRI-2T',['986196947069' => 'LJM', '986197047070' => 'V']],
		'Trois Rivières'		=> ['TRRI-1T,TRRI-2T',['986196947112' => 'LJM', '986197047113' => 'V']],
		'Beffroi'				=> ['BEFF-1T,BEFF-2T',['986196947063' => 'LJM', '986197047064' => 'V']],
		'Coppée'				=> ['COPP-1T,COPP-2T',['986196947071' => 'LJM', '986197047072' => 'V']],
		'Marne'					=> ['MARN-1T,MARN-2T',['986196947088' => 'LJM', '986197047089' => 'V']],
		'Monconseil'			=> ['MONC-1T,MONC-2T',['986196947092' => 'LJM', '986197047093' => 'V']],
		'Vaucanson'				=> ['LYVA-1T',		  ['986196947086' => 'LJM']],
	]
];

function getRawHtml($ligne, $arrets) {

	$arrets_id = [];

	foreach($arrets as $arret) {
		$arrets_id[] = $arret[0];
	}

	$str = implode('%2C',$arrets_id);

	$url = "https://www.filbleu.fr/horaires-et-trajet/horaires-temps-reel?id_ligne=".$ligne."&id_arret=" . $str . "&ordering=1&format=raw&task=tempsreel.refreshPassages";

	$html = curling($url);

	$html = str_replace(["\\n","\\t","\\"],[""],$html);

	return $html;
}

function pdfToArret($pdf,$arrets) {
	foreach($arrets as $nom => $arret) {
		foreach($arret[1] as $id => $direction) {
			if ($pdf == $id)
				return $nom;
		}
	}
	return 'NULL';
}

function extractData($raw, $arrets) {

	$pattern = '/<span class="headsign">(?:(?!>pdf).)*>/';

	$matches = [];

	preg_match_all($pattern,$raw,$matches);

	$data = [];

	foreach($matches[0] as $direction) {

		$d = [];

		// Trouve l'arret
		$pdf = [];
		preg_match_all('/\/[0-9]*.pdf/',$direction,$pdf);
		$d['arret'] = pdfToArret(substr($pdf[0][0],1,-4),$arrets);

		// Trouve la direction

		if (strpos($direction,'Vaucanson') !== false) {
			$d['direction'] = 'V';
		} else {
			$d['direction'] = 'LJM';
		}

		// Trouve les prochains départs

		$min = [];
		preg_match_all('/\d{1,2}\smin/', $direction, $min);

		$d['min'] = [substr($min[0][0],0,-4),substr($min[0][1],0,-4)];

		$data[] = $d;
	}

	return $data;
}

function sortData($data) {
	function cmp($a,$b) {
		return strcmp($a['arret'],$b['arret']);
	}

	usort($data,'cmp');

	return $data;
}

function findTime($data,$arret,$direction) {
	foreach($data as $line) {
		if ($line['arret'] == $arret && $line['direction'] == $direction) {
			return $line['min'];
		}
	}
	return ["",""];
}

$raw = getRawHtml('699',$ligneA['arrets']);

$data = extractData($raw,$ligneA['arrets']);


$bdd = new PDO(/*Identifiants de la BDD*/);

$i = 0;
foreach($ligneA['arrets'] as $nom => $arret) {
	$ljm_min = findTime($data,$nom,'LJM');
	$v_min = findTime($data,$nom,'V');

	$req = $bdd->prepare('UPDATE tram SET ljm1 = :ljm1, ljm2 = :ljm2, v1 = :v1, v2 = :v2 WHERE id = :id');
	$req->execute(array('ljm1' => $ljm_min[0], 'ljm2' => $ljm_min[1], 'v1' => $v_min[0], 'v2' => $v_min[1], 'id' => $i));

	$i++;
}

?>
		<p>Wokay, c'est dans la database!</p>
	</body>
</html>