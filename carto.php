<?
include("connect.php");
?>

<?php
$dsn = 'mysql:host=35.195.188.161;dbname=devgeops;charset=utf8';
$user = 'AdminGeOPS';
$pass = '3jczLxbgXYAmhT';
$bdd = new PDO($dsn, $user , $pass);
$points = $bdd->query('SELECT * FROM `points` ORDER BY Edition, Ville');
?>

<html>
	<head>
        <title>Carto</title>
 		<link rel="stylesheet" href="style8.css" type="text/css">
		<meta name="viewport" content="initial-scale=1.0">
        <meta charset="utf-8">
		<script type="text/javascript" src="https://cdn.rawgit.com/googlemaps/js-marker-clusterer/gh-pages/src/markerclusterer.js"></script>
        <script type="text/javascript" src="https://jawj.github.com/OverlappingMarkerSpiderfier/bin/oms.min.js"></script>
		<style>
			#map {
				height: 800px;
				width: 100%;
			}
		</style>
	</head>
	<body class="bodyblanc">
		<form id="form1" runat="server">
			<div id="map" style="display:inline-block;width:66%;vertical-align:top;">
			</div>
			<div style="display:inline-block;width:0.25%;vertical-align:top;">
			</div>
			<div style="display:inline-block;width:32.75%;vertical-align:top;overflow: auto;">
				<table width="100%">
					<tr> 
						<td colspan=4 class="titre" style="font-size: 14px;background-color:rgb(230, 230, 230);padding: 5px 10px;border-radius:6px;" width="100%">Options cartographiques</td>
					</tr>
					<tr height="30px">
						<td width="2%"></td>
						<td colspan=2 width="96%"><input type="checkbox" id="CheckTransit" onchange="MapTransit();"/><label class="texte12black" for="CheckTransit">Afficher le reseau de transports en commun</label></td>
						<td width="2%"></td>
					</tr>
				</table>

				<table width="100%">
					<tr height="38px">
						<td width="2%"></td>
						<td width="81%"><label class="texte10">Géocodage d'une adresse</label><br/><input name="address" type="text" id="address" style="width:100%;" class="texte12"></td>
						<td width="15%" align="right"><input type="button" class="button3" id="Geocode" value="Geocoder" onclick="Geocodage();"/></td>
						<td width="2%"></td>
					</tr>
				</table>
	
				<table width="100%">
					<tr height="38px">
						<td width="2%"></td>
						<td width="81%">
							<label class="texte10">Isochrone autour de l'adresse</label><br/>
							<label class="texte12black">Temps :</label>
							<input type="number" value="10" id="Iso_Duree" name="drone" min="1" max="60" style="width:40px;">
							<label class="texte12black"> minutes  /  Mode de transport :</label>
							<input type="radio" id="Voiture" name="drone" value="Voiture" checked><label class="texte12black" for="Voiture">voiture</label>
							<input type="radio" id="Piéton" name="drone" value="Piéton" checked><label class="texte12black" for="Piéton">à pieds</label>
						</td>
						<td width="15%" align="right"><input type="button" class="button3" id="Isochrone" value="Isochrone" onclick="Isochronage1();"/></td>
						<td width="2%"></td>
					</tr>
				</table>
				<br/>
				
				<table width="100%">
					<tr> 
						<td colspan=4 class="titre" style="font-size: 14px;background-color:rgb(230, 230, 230);padding: 5px 10px;border-radius:6px;" width="100%">Points de distributions</td>
					</tr>
					<tr height="35px">
						<td width="2%"></td>
						<td width="48%"><input type="button" class="button3" id="SelIso" value="Sélectionner les points dans l'isochrone" onclick="SelPtsIso();"/></td>
						<td width="48%" align="right"><input type="button" class="button3" id="SelIso" value="Ajouter un point de distribution" onclick="AjoutePts();"/>
						<td width="2%"></td>
					</tr>
				</table>
				<table width="100%">
					<tr>
						<td width="2%"></td>
						<td width="96%"><label class="texte10">Points de distribution sélectionnées</label>
							<div style="height:201px; border: 1px solid rgb(11, 72, 146); overflow: auto;"><table id="ListePoints" class="tableau" cellspacing="0" cellpadding="4">
								<tr height="15px">
									<th width="12%" id="IDPts" height="15px" class="tableauet12">ID</th>
									<th width="18%" height="15px" class="tableauet12">Edition</th>
									<th width="18%" height="15px" class="tableauet12">Ville</th>
									<th width="34%" height="15px" class="tableauet12">Position</th>
									<th width="10%" height="15px" class="tableauet12">Tournée</th>
									<th width="8%" height="15px" class="tableauet12">Max</th>
								</tr>
							</table></div>
						</td>
						<td width="2%"></td>
					</tr>
				</table>
				<br/>
				<table width="100%">
					<tr>
						<td width="2%"></td>
						<td width="96%"><label class="texte10">Points de distribution crées</label>
							<div style="height:101px; border: 1px solid rgb(11, 72, 146); overflow: auto;"><table id="ListeCrees" class="tableau" cellspacing="0" cellpadding="4">
								<tr height="15px">
									<th width="100%" height="15px" class="tableauet12">Adresse</th>
								</tr>
							</table></div>
						</td>
						<td width="2%"></td>
					</tr>
				</table>
				<br/>
				<table width="100%">
					<tr> 
						<td colspan=4 class="titre" style="font-size: 14px;background-color:rgb(230, 230, 230);padding: 5px 10px;border-radius:6px;" width="100%">Projet</td>
					<tr>
				</table>
				<table width="100%">
					<tr>
						<td width="2%"></td>
						<td width="96%"><label class="texte10">Quantités</label>
							<div style="height:101px; border: 1px solid rgb(11, 72, 146); overflow: auto;"><table id="Quantite" class="tableau" cellspacing="0" cellpadding="4">
								<tr height="15px">
									<th width="22%" height="15px" class="tableauet12">Edition</th>
									<th width="19%" height="15px" class="tableauet12">Ville</th>
									<th width="5%" height="15px" class="tableauet12">Pts</th>
									<th width="10%" height="15px" class="tableauet12">Qté ville</th>
									<th width="10%" height="15px" class="tableauet12">Qté edt.</th>
									<th width="10%" height="15px" class="tableauet12">Encartage</th>
									<th width="13%" class="tableauet12">Brochage</th>
									<th width="11%" height="15px" class="tableauet12">Type</th>
								</tr>
							</table></div>
						</td>
						<td width="2%"></td>
					</tr>
				</table>
				<br/>
				<table width="100%">
					<tr> 
						<td align="right"><input type="button" class="button2" align="right" id="Connect" value="Annuler" onclick="window.location.href='devis.php';"/>
						<input type="button" class="button1" align="right" id="Connect" value="Valider" onclick="window.location.href='devis.php';"/></td>
					</tr>
				</table>
				
			</div>

		
				
			<script>
				var iconBase ='Icons/';
				var map;
				var geocoder;
				var latitude = 0;
				var longitude = 0;
				var Destlatitude1=[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
				var Destlongitude1 = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
				var Destlatitude2 = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
				var Destlongitude2 = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
				var Dist1 = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
				var Dist2 = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
				var Iso1 = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
				var Iso2 = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
				var MarkersAdress= [];
				var MarkersPoints= [];
				var MarkersCrees= [];
				var Isochrone;

				function InitMap() {
					
					geocoder = new google.maps.Geocoder();
					map = new google.maps.Map(document.getElementById('map'), {
						center: { lat: 46.8566667, lng: 2.3509871 },
						zoom: 6
					});
					map.setOptions({draggableCursor:'default'});
					var transitLayer = new google.maps.TransitLayer();
					transitLayer.setMap(map);

					var foo = [{
						featureType: "transit",
						stylers: [{
							visibility: "off"
						}]
					}];

					map.setOptions({
						styles: foo
					});
						
					Points();

				}


				function wait(ms) {
					var d = new Date();
					var d2 = null;
					do { d2 = new Date(); }
					while(d2-d < ms);
				}
			
			
				function MapTransit() {
						
					if (document.getElementById('CheckTransit').checked) {
						var foo = [{
							featureType: "transit",
							stylers: [{
								visibility: "on"
							}]
						}];
					}
					else {
						var foo = [{
							featureType: "transit",
							stylers: [{
								visibility: "off"
							}]
						}];
					}

					map.setOptions({
						styles: foo
					});

				}


				function Points() {
					
					var oms = new OverlappingMarkerSpiderfier(map);	
					var iconin1 = {
						url: iconBase + 'Icon_Bleue2.png',
						scaledSize: new google.maps.Size(35, 35)
					};
					var iconout1 = {
						url: iconBase + 'Icon_Bleue.png',
						scaledSize: new google.maps.Size(25, 25)
					};
					var iconin2 = {
						url: iconBase + 'Icon_Verte2.png',
						scaledSize: new google.maps.Size(35, 35)
					};
					var iconout2 = {
						url: iconBase + 'Icon_Verte.png',
						scaledSize: new google.maps.Size(25, 25)
					};
						
					<?php
					while ($donnees = $points->fetch())
					{
					?>
						var myCat = <?php echo json_encode($donnees['Categorie']); ?>;
						var myID = <?php echo json_encode($donnees['Position']); ?>;
						var myLat = <?php echo json_encode($donnees['Lat']); ?>;
						var myLong = <?php echo json_encode($donnees['Long']); ?>;
						var myPosition = <?php echo json_encode($donnees['PositionName']); ?>;
						var myQuantite = <?php echo json_encode($donnees['Max']); ?>;
						var point = new google.maps.LatLng(parseFloat(myLat),parseFloat(myLong));
						
							
						if (myCat=='Domaine Public Opé') {
							var marker = new google.maps.Marker({
								id: myID,
								position: point,
								title: myPosition+" (Q="+myQuantite+")",
								icon: iconout2
							});
							google.maps.event.addListener(marker, 'click', (function(marker, myID) {
								return function() {
									if (marker.getIcon().url==iconin2.url) {
										marker.setIcon(iconout2);
										AffichePts()
									}
									else {
										marker.setIcon(iconin2);
										AffichePts()
									}
								}
							})(marker, myID));
						}
						else {
							var marker = new google.maps.Marker({
								id: myID,
								position: point,
								title: myPosition+" (Q="+myQuantite+")",
								icon: iconout1
							});
							google.maps.event.addListener(marker, 'click', (function(marker, myID) {
								return function() {
									if (marker.getIcon().url==iconin1.url) {
										marker.setIcon(iconout1);
										AffichePts()
									}
									else {
										marker.setIcon(iconin1);
										AffichePts()
									}
								}
							})(marker, myID));
						}
							
						MarkersPoints.push(marker);
						oms.addMarker(marker);
								
					<?php
					}
					?>
					
					var markerClusterer = new MarkerClusterer(map, MarkersPoints, {
						maxZoom: 12,
						imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
					

				}
					

				function Geocodage() {
					
					var iconA = {
						url: iconBase + 'Icon_A.png',
						scaledSize: new google.maps.Size(45, 45)
					};
					
					for (var i = 0; i < MarkersAdress.length; i++) {
						MarkersAdress[i].setMap(null);
					}
					MarkersAdress = [];
					
					var address = document.getElementById('address').value;
					geocoder.geocode({ 'address': address }, function (results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							map.zoom = 15;
							map.setCenter(results[0].geometry.location);
							latitude = results[0].geometry.location.lat();
							longitude = results[0].geometry.location.lng();
							var marker = new google.maps.Marker({
								map: map,
								position: results[0].geometry.location,
								draggable: true,
								icon: iconA,
								title: results[0].formatted_address
							});
							MarkersAdress.push(marker);
						} else {
							alert('Geocodage impossible :' + status);
						}
					});
					
					for (var i = 0; i < MarkersPoints.length; i++) {
						MarkersPoints[i].setMap(map);
					}
					
				}


				function Isochronage1() {

					var npoints = 25;
					var origin = latitude + ',' + longitude;
					var destP1 = ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''];

					for (var i = 0; i < 25; i++) {
						if (document.getElementById('Voiture').checked) {
							Dist1[i] = document.getElementById('Iso_Duree').value * 500 / 935 * 0.01;   /* 30 km/h à vol d'oiseau */
							var mode='DRIVING'
						}
						else {
							Dist1[i] = document.getElementById('Iso_Duree').value * 50 / 935 * 0.01;   /* 3 km/h à vol d'oiseau */
							var mode = 'WALKING'
						}
						Destlatitude1[i] = latitude + Dist1[i] * Math.cos((i * 360 / npoints) * (Math.PI / 180))
						Destlongitude1[i] = longitude + Dist1[i] * Math.sin((i * 360 / npoints) * (Math.PI / 180))
						destP1[i] = Destlatitude1[i] + ',' + Destlongitude1[i]
					}
					
					var service = new google.maps.DistanceMatrixService();
					service.getDistanceMatrix( {
						origins: [origin],
						destinations: [destP1[0], destP1[1], destP1[2], destP1[3], destP1[4], destP1[5], destP1[6], destP1[7], destP1[8], destP1[9], destP1[10], destP1[11], destP1[12], destP1[13], destP1[14], destP1[15], destP1[16], destP1[17], destP1[18], destP1[19], destP1[20], destP1[21], destP1[22], destP1[23], destP1[24]],
						travelMode: mode,
						unitSystem: google.maps.UnitSystem.METRIC,
						avoidHighways: false,
						avoidTolls: false
					}, Isoch1_callback);
						
				}


				function Isoch1_callback(response, status) {
					var results = response.rows[0].elements;
					var TimeIso = document.getElementById('Iso_Duree').value * 60;
					for (var i = 0; i < 25; i++) {
						Iso1[i] = results[i].duration.value
						Dist2[i] = Dist1[i] * TimeIso / Iso1[i]
					}
					Isochronage2();
				}
					
					
				function Isochronage2() {
						
					var npoints = 25;
					var origin = latitude + ',' + longitude;
					var destP2 = ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''];
						
					if (Destlatitude2[0]==0) {
					}	
					else {	
						Isochrone.setMap(null);
					}	
						
					for (var i = 0; i < 25; i++) {
						if (document.getElementById('Voiture').checked) {
							 var mode='DRIVING'
						}
						else {
							var mode = 'WALKING'
						}
						Destlatitude2[i] = latitude + Dist2[i] * Math.cos((i * 360 / npoints) * (Math.PI / 180))
						Destlongitude2[i] = longitude + Dist2[i] * Math.sin((i * 360 / npoints) * (Math.PI / 180))
						destP2[i] = Destlatitude2[i] + ',' + Destlongitude2[i]
					}
											
					var service = new google.maps.DistanceMatrixService();
					service.getDistanceMatrix({
						origins: [origin],
						destinations: [destP2[0], destP2[1], destP2[2], destP2[3], destP2[4], destP2[5], destP2[6], destP2[7], destP2[8], destP2[9], destP2[10], destP2[11], destP2[12], destP2[13], destP2[14], destP2[15], destP2[16], destP2[17], destP2[18], destP2[19], destP2[20], destP2[21], destP2[22], destP2[23], destP2[24]],
						travelMode: mode,
						unitSystem: google.maps.UnitSystem.METRIC,
						avoidHighways: false,
						avoidTolls: false
					}, Isoch2_callback);

				} 


				function Isoch2_callback(response, status) {

					var results = response.rows[0].elements;
					for (var i = 0; i < 25; i++) {
						Iso2[i] = results[i].duration.value
					}
				
					var TimeIso = document.getElementById('Iso_Duree').value * 60;
					var latEC = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
					var lonEC = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

					for (var i = 0; i < 25; i++) {
						latEC[i] = latitude + (Destlatitude2[i] - latitude) * TimeIso / Iso2[i]
						lonEC[i] = longitude + (Destlongitude2[i] - longitude) * TimeIso / Iso2[i]
					}

					var PointsIsochrone = [
						new google.maps.LatLng(latEC[0], lonEC[0]),
						new google.maps.LatLng(latEC[1], lonEC[1]),
						new google.maps.LatLng(latEC[2], lonEC[2]),
						new google.maps.LatLng(latEC[3], lonEC[3]),
						new google.maps.LatLng(latEC[4], lonEC[4]),
						new google.maps.LatLng(latEC[5], lonEC[5]),
						new google.maps.LatLng(latEC[6], lonEC[6]),
						new google.maps.LatLng(latEC[7], lonEC[7]),
						new google.maps.LatLng(latEC[8], lonEC[8]),
						new google.maps.LatLng(latEC[9], lonEC[9]),
						new google.maps.LatLng(latEC[10], lonEC[10]),
						new google.maps.LatLng(latEC[11], lonEC[11]),							
						new google.maps.LatLng(latEC[12], lonEC[12]),
						new google.maps.LatLng(latEC[13], lonEC[13]),
						new google.maps.LatLng(latEC[14], lonEC[14]),
						new google.maps.LatLng(latEC[15], lonEC[15]),
						new google.maps.LatLng(latEC[16], lonEC[16]),
						new google.maps.LatLng(latEC[17], lonEC[17]),
						new google.maps.LatLng(latEC[18], lonEC[18]),
						new google.maps.LatLng(latEC[19], lonEC[19]),
						new google.maps.LatLng(latEC[20], lonEC[20]),
						new google.maps.LatLng(latEC[21], lonEC[21]),
						new google.maps.LatLng(latEC[22], lonEC[22]),
						new google.maps.LatLng(latEC[23], lonEC[23]),
						new google.maps.LatLng(latEC[24], lonEC[24])
					];

					var OptionsIsochrone = {
						map: map,
						paths: PointsIsochrone,
						strokeColor: '#FF0000',
						strokeOpacity: 0.6,
						strokeWeight: 3,
						fillColor: '#FF0000',
						fillOpacity: 0.2,
						clickable: false
					};

					Isochrone = new google.maps.Polygon(OptionsIsochrone);
					Isochrone.setMap(map);

				}
					
					
				function SelPtsIso() {
						
					var iconin1 = {
						url: iconBase + 'Icon_Bleue2.png',
						scaledSize: new google.maps.Size(35, 35)
					};
					var iconout1 = {
						url: iconBase + 'Icon_Bleue.png',
						scaledSize: new google.maps.Size(25, 25)
					};
					var iconin2 = {
						url: iconBase + 'Icon_Verte2.png',
						scaledSize: new google.maps.Size(35, 35)
					};
					var iconout2 = {
						url: iconBase + 'Icon_Verte.png',
						scaledSize: new google.maps.Size(25, 25)
					};
											
					for (var i = 0; i < MarkersPoints.length; i++) {
							
						var point = new google.maps.LatLng(MarkersPoints[i].getPosition().lat(), MarkersPoints[i].getPosition().lng())
						var Test = google.maps.geometry.poly.containsLocation(point, Isochrone)
							
						if (Test==true){
							if (MarkersPoints[i].getIcon().url==iconout1.url) {
								MarkersPoints[i].setIcon(iconin1);
							}
							if (MarkersPoints[i].getIcon().url==iconout2.url) {
								MarkersPoints[i].setIcon(iconin2);
							}
						}						
					}
					
					AffichePts()
				
				}
					
					
				function AffichePts() {
						
					var tableau1 = document.getElementById('ListePoints');
					var tableau2 = document.getElementById('ListeCrees');
					var tableau3 = document.getElementById('Quantite');
					var nb1 = document.getElementById('ListePoints').rows.length;
					var nb2 = document.getElementById('ListeCrees').rows.length;
					var nb3 = document.getElementById('Quantite').rows.length;
											
					var iconin1 = {
						url: iconBase + 'Icon_Bleue2.png',
						scaledSize: new google.maps.Size(35, 35)
					};
					var iconin2 = {
						url: iconBase + 'Icon_Verte2.png',
						scaledSize: new google.maps.Size(35, 35)
					};
						

					for (var j = 1; j < nb1; j++) 	
					{
						tableau1.deleteRow(-1);
					}
						
					for (var j = 1; j < nb2; j++) 	
					{
						tableau2.deleteRow(-1);
					}
					
					for (var j = 1; j < nb3; j++) 	
					{
						tableau3.deleteRow(-1);
					}
						
					
					var QuantiteV= [];
					var QuantiteE= [];
					var NbV= [];
					var Editions= [];
					var Villes= [];
					var EditionsV= [];
									
					for (var i = 0; i < MarkersPoints.length; i++) {
							
						if (MarkersPoints[i].getIcon().url==iconin1.url || MarkersPoints[i].getIcon().url==iconin2.url) {
													
							<?php
							$points = $bdd->query('SELECT * FROM `points` ORDER BY Edition, Ville');

							while ($donnees = $points->fetch())
							{
								?>
								var myID = <?php echo json_encode($donnees['Position']); ?>;
									
								if (MarkersPoints[i].id==myID) {
									var myEdition = <?php echo json_encode($donnees['Edition']); ?>;
									var myVille = <?php echo json_encode($donnees['Ville']); ?>;
									var myPosition = <?php echo json_encode($donnees['PositionName']); ?>;
									var myTournees = <?php echo json_encode($donnees['Tournees']); ?>;
									var myMax = <?php echo json_encode($donnees['Max']); ?>;
									var MyMaxNumber = new Number(myMax);
									var ligne = tableau1.insertRow(-1);
									ligne.className = "tableaur11";
									var colonne1 = ligne.insertCell(0);
									colonne1.className = "tableaucells2";
									colonne1.innerHTML += myID
									var colonne2 = ligne.insertCell(1);
									colonne2.className = "tableaucells2";
									colonne2.innerHTML += myEdition
									var colonne3 = ligne.insertCell(2);
									colonne3.className = "tableaucells2";
									colonne3.innerHTML += myVille;
									var colonne4 = ligne.insertCell(3);
									colonne4.className = "tableaucells2";
									colonne4.innerHTML += myPosition;
									var colonne5 = ligne.insertCell(4);
									colonne5.className = "tableaucells2";
									colonne5.innerHTML += myTournees;
									var colonne6 = ligne.insertCell(5);
									colonne6.className = "tableaucells2";
									colonne6.innerHTML += myMax;
									ligne.addEventListener("click", function(){FocusPoint(this.cells[0].innerHTML);});
									
									var NewVilles = true;
									for (var j = 0; j < Villes.length; j++) {
										if (Villes[j]==myVille) {
											QuantiteV[j] = QuantiteV[j] + MyMaxNumber;
											NbV[j] = NbV[j]+1;
											NewVilles = false;
											break;
										}
									}	
									if (NewVilles==true){
										Villes.push(myVille);
										EditionsV.push(myEdition);
										QuantiteV.push(MyMaxNumber);
										NbV.push(1);
									}
									var NewEdition = true;
									for (var j = 0; j < Editions.length; j++) {
										if (Editions[j]==myEdition) {
											QuantiteE[j] = QuantiteE[j] + MyMaxNumber
											NewEdition = false;
											break;
										}
									}	
									if (NewEdition==true){
										Editions.push(myEdition);
										QuantiteE.push(MyMaxNumber);
									}
								}
							<?php
							}
							?>	
						}
							
					}
						
					<?php
					$contr_cav = $bdd->query('SELECT * FROM `contraintes_cavaliers` ORDER BY EDITION, VILLE');
					?>							
						
						
					for (var k = 0; k < MarkersCrees.length; k++) {

						if (MarkersCrees[k].id == 0) {
						}
						else {
							var ligne = tableau2.insertRow(-1);
							ligne.className = "tableaur11";
							var colonne1 = ligne.insertCell(0);
							colonne1.className = "tableaucells2";
							colonne1.innerHTML += MarkersCrees[k].id;
							ligne.addEventListener("click", function(){FocusPointCree(this.cells[0].innerHTML);});
							
						}
					}

					var SumQuantite=0;
					var SumNbV=0;
					for (var j = 0; j < Villes.length; j++) {
						var myVille = Villes[j];
						var myEdition = EditionsV[j];
						var myNbV = NbV[j];
						var myQuantiteV = QuantiteV[j];
						for (var k = 0; k < Editions.length; k++) {
							if (Editions[k]==myEdition) {
								var myQuantiteE = QuantiteE[k];
							}	
						}
						var myType = "";
						var myMinE = 0;
						var myMaxE = 0;
						<?php
						while ($donnees = $contr_cav->fetch())
						{
						?>
							var myVille2 = <?php echo json_encode($donnees['VILLE']); ?>;
							var myEdition2 = <?php echo json_encode($donnees['EDITION']); ?>;
							if ((myVille2=="") && (myEdition==myEdition2)) {
								myMinE = <?php echo json_encode($donnees['MIN']); ?>;
								myMaxE = <?php echo json_encode($donnees['MAX']); ?>;	
							}	
							if (myVille==myVille2) {
								var myMinV = <?php echo json_encode($donnees['MIN']); ?>;
								var myMaxV = <?php echo json_encode($donnees['MAX']); ?>;
							}								
						<?php
						}
						?>
						
						if ((myQuantiteE >= myMinE) && (myQuantiteE <= myMaxE)) {
							myType="Brochage";
						} else if ((myQuantiteV >= myMinV) && (myQuantiteV <= myMaxV)) {
							myType="Encartage";
						} else {
							myType = "";
						}	
						
						var ligne = tableau3.insertRow(-1);
						ligne.className = "tableaur11";
						var colonne1 = ligne.insertCell(0);
						colonne1.className = "tableaucells2";
						colonne1.innerHTML += myEdition;
						var colonne2 = ligne.insertCell(1);
						colonne2.className = "tableaucells2";
						colonne2.innerHTML += myVille;
						var colonne3 = ligne.insertCell(2);
						colonne3.className = "tableaucells2";
						colonne3.innerHTML += myNbV;
						var colonne4 = ligne.insertCell(3);
						colonne4.className = "tableaucells2";
						colonne4.innerHTML += myQuantiteV;
						var colonne5 = ligne.insertCell(4);
						colonne5.className = "tableaucells2";
						colonne5.innerHTML += myQuantiteE;
						var colonne6 = ligne.insertCell(5);
						colonne6.className = "tableaucells2";
						colonne6.innerHTML += myMinV + "-" + myMaxV;
						var colonne7 = ligne.insertCell(6);
						colonne7.className = "tableaucells2";
						colonne7.innerHTML += myMinE + "-" + myMaxE;
						var colonne8 = ligne.insertCell(7);
						colonne8.className = "tableaucells2";
						colonne8.innerHTML += myType;
						SumQuantite = SumQuantite + myQuantiteV;
						SumNbV = SumNbV + myNbV;
												
						if (myType=="") {
							colonne1.className = "tableaucells3";
							colonne2.className = "tableaucells3";
							colonne3.className = "tableaucells3";
							colonne4.className = "tableaucells3";
							colonne5.className = "tableaucells3";
							colonne6.className = "tableaucells3";
							colonne7.className = "tableaucells3";
							colonne8.className = "tableaucells3";
						} else {
							colonne1.className = "tableaucells4";
							colonne2.className = "tableaucells4";
							colonne3.className = "tableaucells4";
							colonne4.className = "tableaucells4";
							colonne5.className = "tableaucells4";
							colonne6.className = "tableaucells4";
							colonne7.className = "tableaucells4";
							colonne8.className = "tableaucells4";
							
						}			
					}
					
					var myVille = 'TOTAL';
					var ligne = tableau3.insertRow(-1);
					ligne.className = "tableaur11";
					var colonne1 = ligne.insertCell(0);
					colonne1.className = "tableaucells2";
					colonne1.innerHTML += myVille;
					var colonne2 = ligne.insertCell(1);
					colonne2.className = "tableaucells2";
					colonne2.innerHTML += "";	
					var colonne3 = ligne.insertCell(2);
					colonne3.className = "tableaucells2";
					colonne3.innerHTML += SumNbV;
					var colonne4 = ligne.insertCell(3);
					colonne4.className = "tableaucells2";
					colonne4.innerHTML += SumQuantite;
					var colonne5 = ligne.insertCell(4);
					colonne5.className = "tableaucells2";
					colonne5.innerHTML += "";		
					var colonne6 = ligne.insertCell(5);
					colonne6.className = "tableaucells2";
					colonne6.innerHTML += "";
					var colonne7 = ligne.insertCell(6);
					colonne7.className = "tableaucells2";
					colonne7.innerHTML += "";	
					var colonne8 = ligne.insertCell(7);
					colonne8.className = "tableaucells2";
					colonne8.innerHTML += "";						
				}
					
						
				function AjoutePts() {
						
					map.addListener('click', function(e) {
						placeMarker(e.latLng, map);
					});
					map.setOptions({draggableCursor:'crosshair'});
						
				}
					
					
				function placeMarker(position, map) {
						
					var iconin = {
						url: iconBase + 'Icon_Jaune.png',
						scaledSize: new google.maps.Size(35, 35)
					};
					
					geocoder.geocode({latLng: position}, function(results, status) {
						var myIDCree = results[0].formatted_address;
						var marker = new google.maps.Marker({
							id: myIDCree,
							position: position,
							map: map,
							draggable: true,
							icon:iconin
						});
							
						google.maps.event.addListener(marker, 'click', (function(marker, position) {
							return function() {
								marker.setMap(null);
								for (var i = 0; i < MarkersCrees.length; i++) {
									if (MarkersCrees[i].id == marker.id) {
										MarkersCrees[i].id = 0;
									}
								}
								AffichePts()
							}
						})(marker, position));
							
						MarkersCrees.push(marker);
						map.setOptions({draggableCursor:'default'});
						google.maps.event.clearListeners(map, 'click');
						AffichePts()
					});

				}
				

				function FocusPoint(ID) {
					
					for (var i = 0; i < MarkersPoints.length; i++) {
						if (MarkersPoints[i].id==ID) {
							break;
						}
					}

					map.zoom = 16;	
					map.setCenter(MarkersPoints[i].getPosition());

				}
								

				function FocusPointCree(ID) {

					for (var i = 0; i < MarkersCrees.length; i++) {
						if (MarkersCrees[i].id==ID) {
							break;
						}
					}

					map.zoom = 16;	
					map.setCenter(MarkersCrees[i].getPosition());

				}

			</script>
			<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6nXqGYaQJYyblVmi0rYLqqtXMVD0bRNA&callback=InitMap"
			async defer></script>
		</form>
	</body>
</html>
