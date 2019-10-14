<?
include("connect.php");
?>

<?php
$dsn = 'mysql:host=35.195.188.161;dbname=devgeops;charset=utf8';
$user = 'AdminGeOPS';
$pass = '3jczLxbgXYAmhT';
$bdd = new PDO($dsn, $user , $pass);
?>

<html>
    <head>
        <title>Devis</title>
 		<link rel="stylesheet" href="style8.css" type="text/css">
		<meta name="viewport" content="initial-scale=1.0">
        <meta charset="utf-8">
    </head>
    <body class="bodyblanc" onload="AfficheDevis();"/>
		<table width="100%">
			<tr> 
				<td>
					<select class="selectdevis" name="SelDevis" id="SelDevis" onchange="AfficheDevis();"/>
						<option value="1">Mes devis</option>
						<option value="2">Tout les devis</option>
					</select>
					<input type="button" class="button1" id="NouveauDevis" value="Nouveau devis" onclick="window.location.href='nouveaudevis.php';"/>
				</td>
			</tr>
		</table>	
		<br />
	
		<table id="ListeDevis" class="tableau" cellspacing="0" cellpadding="8">
			<thead><tr>
				<th width="20%" class="tableauet14" data-sort="string">Annonceur</th>
				<th width="20%" class="tableauet14" data-sort="string">Thème de l'opération</th>
				<th width="10%" class="tableauet14" data-sort="string">Type d'opération</th>
				<th width="10%" class="tableauet14" data-sort="int">Quantité</th>
				<th width="10%" class="tableauet14" data-sort="string">Date de l'opération</th>
				<th width="10%" class="tableauet14" data-sort="string">Statut</th>
				<th width="10%" class="tableauet14" data-sort="string">Crée par</th>
				<th width="10%" class="tableauet14" data-sort="string">Date de création</th>
			</tr></thead>
			<tbody>
				<tr><td class="tableau0">0</td><td class="tableau0">0</td><td class="tableau0">0</td><td class="tableau0">0</td>
				<td class="tableau0">0</td><td class="tableau0">0</td><td class="tableau0">0</td><td class="tableau0">0</td></tr>
			</tbody>
		</table>
		
		<script src="jquery-3.4.1.min.js"></script>
		<script src="stupidtable.min.js"></script>
		<script>
			$(function(){
				$("#ListeDevis").stupidtable();
			});
		</script>

		<script>
							
			function AfficheDevis() {
						
				var tableau = document.getElementById('ListeDevis');
				var nb = document.getElementById('ListeDevis').rows.length;

				for (var j = 2; j < nb; j++) 	
				{
					tableau.deleteRow(-1);
				}			
				
				var mySel=document.getElementById('SelDevis').value;
				
				<?php $user=1; ?>
				<?php
				$devis1 = $bdd->query('SELECT * FROM utilisateurs,devis WHERE utilisateurs.ID_User = '.$user.' AND devis.ID_User = utilisateurs.ID_User ORDER BY devis.DateCreation DESC');
				$devis2 = $bdd->query('SELECT * FROM utilisateurs,devis WHERE devis.ID_User = utilisateurs.ID_User ORDER BY devis.DateCreation');
				?>
					
								
				if (mySel=="1") {
					<?php
					while ($donnees = $devis1->fetch())
					{
					?>
						var myAnnonceur = <?php echo json_encode($donnees['Annonceur']); ?>;
						var myTheme = <?php echo json_encode($donnees['Theme']); ?>;
						var myType = <?php echo json_encode($donnees['Type']); ?>;
						var myQuantite = <?php echo json_encode($donnees['Quantite']); ?>;
						var myDateOpe = <?php echo json_encode($donnees['DateOpe']); ?>;
						var myStatut = <?php echo json_encode($donnees['Statut']); ?>;
						var myCommerce = <?php echo json_encode($donnees['Nom']); ?>;
						var myDateCreation = <?php echo json_encode($donnees['DateCreation']); ?>;

						var ligne = tableau.insertRow(-1);
						ligne.className = "tableaur13";
						var colonne1 = ligne.insertCell(0);
						colonne1.className = "tableaucells";
						colonne1.innerHTML += myAnnonceur;
						var colonne2 = ligne.insertCell(1);
						colonne2.className = "tableaucells";
						colonne2.innerHTML += myTheme;
						var colonne3 = ligne.insertCell(2);
						colonne3.className = "tableaucells";
						colonne3.innerHTML += myType;
						var colonne4 = ligne.insertCell(3);
						colonne4.className = "tableaucells";
						colonne4.innerHTML += myQuantite;
						var colonne5 = ligne.insertCell(4);
						colonne5.className = "tableaucells";
						colonne5.innerHTML += myDateOpe;
						var colonne6 = ligne.insertCell(5);
						colonne6.className = "tableaucells";
						colonne6.innerHTML += myStatut;
						var colonne7 = ligne.insertCell(6);
						colonne7.className = "tableaucells";
						colonne7.innerHTML += myCommerce;
						var colonne8 = ligne.insertCell(7);
						colonne8.className = "tableaucells";
						colonne8.innerHTML += myDateCreation;
					<?php
					}
					?>
				}
				else {
					<?php
					while ($donnees = $devis2->fetch())
					{
					?>
						var myAnnonceur = <?php echo json_encode($donnees['Annonceur']); ?>;
						var myTheme = <?php echo json_encode($donnees['Theme']); ?>;
						var myType = <?php echo json_encode($donnees['Type']); ?>;
						var myQuantite = <?php echo json_encode($donnees['Quantite']); ?>;
						var myDateOpe = <?php echo json_encode($donnees['DateOpe']); ?>;
						var myStatut = <?php echo json_encode($donnees['Statut']); ?>;
						var myCommerce = <?php echo json_encode($donnees['Nom']); ?>;
						var myDateCreation = <?php echo json_encode($donnees['DateCreation']); ?>;

						var ligne = tableau.insertRow(-1);
						ligne.className = "tableaur13";
						var colonne1 = ligne.insertCell(0);
						colonne1.className = "tableaucells";
						colonne1.innerHTML += myAnnonceur;
						var colonne2 = ligne.insertCell(1);
						colonne2.className = "tableaucells";
						colonne2.innerHTML += myTheme;
						var colonne3 = ligne.insertCell(2);
						colonne3.className = "tableaucells";
						colonne3.innerHTML += myType;
						var colonne4 = ligne.insertCell(3);
						colonne4.className = "tableaucells";
						colonne4.innerHTML += myQuantite;
						var colonne5 = ligne.insertCell(4);
						colonne5.className = "tableaucells";
						colonne5.innerHTML += myDateOpe;
						var colonne6 = ligne.insertCell(5);
						colonne6.className = "tableaucells";
						colonne6.innerHTML += myStatut;
						var colonne7 = ligne.insertCell(6);
						colonne7.className = "tableaucells";
						colonne7.innerHTML += myCommerce;
						var colonne8 = ligne.insertCell(7);
						colonne8.className = "tableaucells";
						colonne8.innerHTML += myDateCreation;
					<?php
					}
					?>
				}
				
			}
						
		</script>		
		
	</body>
</html>