<?php

$bdd = new PDO(/* identifiants de la BDD*/);


$ligneA = [
	'Lycée J. Monnet',
	'Stade Jean Bouin',
	'Rabière',
	'Rotière',
	'Joué Hotel de Ville',
	'République',
	'Pont Volant',
	'Heure Tranquille',
	'Suzanne Valadon',
	'Verdun',
	'Charcot',
	'Liberté',
	'Sanitas',
	'Palais des sports',
	'Gare de Tours',
	'Jean Jaurès',
	'Nationale',
	'Anatole France',
	'Place Choiseul',
	'Mi-côte',
	'Tranchée',
	'Christ Roi',
	'Trois Rivières',
	'Beffroi',
	'Coppée',
	'Marne'	,
	'Monconseil',
	'Vaucanson'
];

$jean_monnet = [];
$vaucanson = [];

$jean_monnet_tram = [];
$vaucanson_tram = [];

$req = $bdd->prepare('SELECT * FROM tram');
$req->execute();

while($data=$req->fetch()) {
	$jean_monnet[$data['id']] = $data['ljm1'];
	$vaucanson[$data['id']] = $data['v1'];
}

$last_time = 999;

for($i=0;$i<count($jean_monnet);$i++) {
	if ($last_time < $jean_monnet[$i]) {
		$jean_monnet_tram[] = $i;
	}
	$last_time = $jean_monnet[$i];
}

$last_time = 0;

for ($i=count($vaucanson)-1;$i>=0;$i--) {
	if ($last_time < $vaucanson[$i]) {
		$vaucanson_tram[] = $i;
	}
	$last_time = $vaucanson[$i];
}

?>

<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Tram Tourangeau</title>
		<style>
			table {
				border-spacing: 0px;
			}

			td {
				padding: 0px;
			}

			td .over {
				position: absolute;
				left: auto;
				display: none;
				width: 200px;
				height: 100px;
				border: 1px solid grey;
				background-color: white;
			}

			td:hover .over {
				display: block;
			}
		</style>
	</head>
	<body>
		<div align="center" style="padding-top: 200px;">
			<h1>Tram - Ligne A</h1>

			<h3>Direction Vaucanson</h3>
			<table>
				<tr>
				<?php
					for($i=0;$i<count($ligneA);$i++) {
						?>
						<td></td>
						<?php
						if (in_array($i,$vaucanson_tram)) {
							?>
								<td>
									<img src="tramway.png" alt="Tramway"/>
								</td>
							<?php
						} else {
							?>
							<td></td>
							<?php
						}
					}
				?>
				<tr/>
				<tr>
				<?php
					for($i=0;$i<count($ligneA);$i++) {
						?>
						<td>
							<a href="#">
								<img src="arret.png" alt="<?=$ligneA[$i]?>"/>
							</a>
							<div class="over">
								<strong>Arrêt <?=$ligneA[$i]?></strong><br/><br/>
								Prochain départ dans:<br/><br/>
								<?=$vaucanson[$i]?> minutes
							</div>
						</td>
						<?php
						//if ($i > 0) {
						if ($i < count($ligneA)-1) {
							if (in_array($i, $vaucanson_tram)) {
								?>
								<td>
									<img src="rail-tram.png" alt="rail"/>
								</td>
								<?php
							} else {
								?>
								<td>
									<img src="rail.png" alt="rail"/>
								</td>
								<?php
							}
						}
					}
				?>
				</tr>
				<tr>
					<td colspan="5"><strong>Lycée J. Monnet</strong></td>
					<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
					<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
					<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
					<td></td><td></td><td></td><td></td><td></td>
					<td colspan="3" align="right"><strong>Vaucanson</strong></td>
				</tr>
			</table>
			<br/><br/><br/><br/><br/><br/>
			<h3>Direction Lycée J. Monnet</h3>
			<table>
				<tr>
				<?php
					for($i=count($ligneA)-1;$i>=0;$i--) {
						?>
						<td></td>
						<?php
						if (in_array($i,$jean_monnet_tram)) {
							?>
								<td>
									<img src="tramway.png" alt="Tramway"/>
								</td>
							<?php
						} else {
							?>
							<td></td>
							<?php
						}
					}
				?>
				<tr/>
				<tr>
				<?php

					for($i=count($ligneA)-1;$i>=0;$i--) {
						?>
						<td>
							<a href="#">
								<img src="arret.png" alt="<?=$ligneA[$i]?>"/>
							</a>
							<div class="over">
								<strong>Arrêt <?=$ligneA[$i]?></strong><br/><br/>
								Prochain départ dans:<br/><br/>
								<?=$jean_monnet[$i]?> minutes
							</div>
						</td>
						<?php
						if ($i > 0) {
							if (in_array($i, $jean_monnet_tram)) {
								?>
								<td>
									<img src="rail-tram.png" alt="rail"/>
								</td>
								<?php
							} else {
								?>
								<td>
									<img src="rail.png" alt="rail"/>
								</td>
								<?php
							}
						}
					}
				?>
				</tr>
				<tr>
					<td colspan="3"><strong>Vaucanson</strong></td>
					<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
					<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
					<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
					<td></td><td></td><td></td><td></td><td></td>
					<td colspan="5" align="right"><strong>Lycée J. Monnet</strong></td>
				</tr>
			</table>
		</div>
	</body>
</html>