<?
include("connect.php");
?>

<html>
	<head>
		<title>20 minutes</title>
		<link rel="stylesheet" href="style8.css" type="text/css">
		<meta name="viewport" content="initial-scale=1.0">
        <meta charset="utf-8">
	</head>
	
	<body>
		<br />
		<form id="form1" runat="server">
			<div>
				<center><table width="270" style="background-color:rgb(255,255,255);border-radius:10px;">
					<tr> 
						<td height="50" align="center"><label class="titre"><br />Bienvenue sur Géops<br /><br /></label>
					</tr>
					<tr>
						<td height="50" align="center"><a href="main.php"><input type="button" class="button1" id="Connect" value="Se connecter avec Google" onclick="main.php?user=1"></a></td>
					</tr>
					<tr>
						<td height="5" align="center"><br /></td>
					</tr>
					
				</table></center>
			</div>
		</form>
		
		<script type="text/javascript">
					
			function Connecte() {
				
				var myUser1 = document.getElementById('login').value;
				var myPassword1 = document.getElementById('password').value;
				var myConnexion = 0;		
							
				<?php
				$users = $bdd->query('SELECT * FROM `utilisateurs`');
				while ($donnees = $users->fetch())
				{
				?>
					var myUser2 = <?php echo json_encode($donnees['User']); ?>;
					var myPassword2 = <?php echo json_encode($donnees['Password']); ?>;
					if (myUser1==myUser2) {
						if (myPassword1==myPassword2) {
							myConnexion=1
						}
					}
							
				<?php
				}
				?>
							
				if (myConnexion==1) {
					alert("Connecté !");
				}
				else {
					alert("Utilisateur ou mot de passe incorrect !");
				} 
			}
					
		</script>
		
	</body>
</html>