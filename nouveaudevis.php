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
        <title>Nouveau devis</title>
 		<link rel="stylesheet" href="style.css" type="text/css">
		<meta name="viewport" content="initial-scale=1.0">
        <meta charset="utf-8">
    </head>
    <body class="bodyblanc">
		</br>
		<div style="display:inline-block;width:48%;vertical-align:top;">
			<table width="100%">
				<tr> 
					<td colspan=5 class="titre" style="font-size: 16px;background-color:rgb(230, 230, 230);height: 30px;padding: 8px 16px;border-radius:8px;" width="100%">Informations générales<br/></td>
				</tr>
				<tr>
					<td width="2%"></td>
					<td width="47%"></br><label class="texte12">Propriétaire</label></br>
					<label class="texte14">Guillaume PICHOFF</label></td>
					<td width="2%"></td>
					<td width="47%"></br><label class="texte12">Statut</label></br>
					<select style="width:100%;" class="texte14" name="statut">
						<option value="Brouillon">Brouillon</option>
						<option value="Proposition">Proposition</option>
						<option value="Validé">Validé</option>
					</select></td>
					<td width="2%"></td>
				</tr>
			</table>
			<br/><br/><br/>
			<table width="100%">
				<tr> 
					<td colspan=5 class="titre" style="font-size: 16px;background-color:rgb(230, 230, 230);height: 30px;padding: 8px 16px;border-radius:8px;" width="100%">Informations sur l'annonceur<br/></td>
				</tr>
				<tr>
					<td width="2%"></td>
					<td width="47%"></br><label class="texte12">* Annonceur</label></br>
					<input name="theme" type="text" id="theme" style="width:100%;" class="texte14"></td>
					<td width="2%"></td>
					<td width="47%"></br><label class="texte12">Contact</label></br>
					<input name="theme" type="text" id="theme" style="width:100%;" class="texte14"></td>
					<td width="2%"></td>
				</tr>
				<tr>
					<td width="2%"></td>
					<td width="47%"></br><label class="texte12">Mandataire</label></br>
					<input name="theme" type="text" id="theme" style="width:100%;" class="texte14"></td>
					<td width="2%"></td>
					<td width="47%"></br><label class="texte12">Télephone</label></br>
					<input name="theme" type="text" id="theme" style="width:100%;" class="texte14"></td>
					<td width="2%"></td>
				</tr>
				<tr>
					<td width="2%"></td>
					<td width="47%"></td>
					<td width="2%"></td>
					<td width="47%"></br><label class="texte12">Mail</label></br>
					<input name="theme" type="text" id="theme" style="width:100%;" class="texte14"></td>
					<td width="2%"></td>
				</tr>
			</table>
		</div>

		<div style="display:inline-block;width:3%;vertical-align:top;"></div>
		<div style="display:inline-block;width:48%;vertical-align:top;">
			<table width="100%">
				<tr> 
					<td colspan=5 class="titre" style="font-size: 16px;background-color:rgb(230, 230, 230);height: 30px;padding: 8px 16px;border-radius:8px;" width="100%">Informations sur l'opération</td>
				</tr>
				<tr>
					<td width="2%"></td>
					<td width="47%"></br><label class="texte12">* Type d'opération</label></br>
					<select style="width:100%;" class="texte14" name="type">
						<option value="catalogues">Catalogues - de 50g</option>
						<option value="echantillons">Echantillons - de 50g</option>
						<option value="leaflets">Leaflets - de 20g</option>
					</select></td>
					<td width="2%"></td>
					<td width="47%"></br><label class="texte12">Coupe-vent diffuseur</label></br>
					<select style="width:100%;" class="texte14" name="type">
						<option value="CVOui">Oui</option>
						<option value="CVNon">Non</option>
					</select></td>
					<td width="2%"></td>
				</tr>
				<tr>
					<td width="2%"></td>
					<td width="47%"></br><label class="texte12">* Thême de l'opération</label></br>
					<input name="theme" type="text" id="theme" style="width:100%;" class="texte14"></td>
					<td width="2%"></td>
					<td width="47%"></br><label class="texte12">Couleur coupe-vent</label></br>
					<select style="width:100%;" class="texte14" name="type">
						<option value="CVBlanc">Blanc</option>
						<option value="CVBleu">Bleu</option>
						<option value="CVJaune">Jaune</option>
						<option value="CVNoir">Noir</option>
						<option value="CVRouge">Rouge</option>
						<option value="CVVert">Vert</option>
					</select></td>
					<td width="2%"></td>
				</tr>
								<tr>
					<td width="2%"></td>
					<td width="47%"></br><label class="texte12">Date de l'opération</label></br>
					<input type="date" name="dateope" type="text" id="dateope" style="width:100%;" class="texte14"></td>
					<td width="2%"></td>
					<td width="47%"></td>
					<td width="2%"></td>
				</tr>
			</table>
		</div>
		<br/><br/>
		
		<table width="100%">
			<tr> 
				<td align="right"><input type="button" class="button2" align="right" id="Connect" value="Annuler" onclick="window.location.href='devis.php';"/>
				<input type="button" class="button1" align="right" id="Connect" value="Choisir les points de distribution" onclick="window.location.href='carto.php';"/></td>
			</tr>
		</table>
		<script type="text/javascript">
												
		</script>		
		
	</body>
</html>