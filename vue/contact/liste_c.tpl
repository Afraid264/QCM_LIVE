<!doctype html>
<html><head>
  <meta charset="utf-8">
  <title>Test mvc 21</title>
  <link rel="stylesheet" href="./vue/styleCSS/style.css"/>
</head>

<body>

	<nav> 	
		<?php  require ("./vue/menu.tpl"); ?>
	</nav> <!-- fin du menu nav -->

	<div id ="main"> 
		<h2> Vue </h2>
		<?php echo ("<br/>  IHM de la liste des contacts."); ?> 

		<?php 
			//essayer ces 2 possibilités d'affichage :
			/*
			echo ('<pre>');
			   print_r($L[0])
			echo ('</pre>');
			*/
			
			
			/*
				var_dump($L);
			*/
		
		/* $L est la liste des enregistrements, voir l'action liste_c() */		
		if ($L != false) {
			echo ("<h2 style='color:blue'> Voici vos contacts :</h2>");
			echo ('<table>');
			echo ('<tr><th> NOM </th> <th> PRENOM </th> <th> EMAIL </th></tr>'); 	
			foreach ($L as $c) {
				echo "<tr class='contact'>";
				echo ("<td>" . utf8_encode($c['nom']) . "</td>"); 
				echo ("<td>" . utf8_encode($c['prenom']) . "</td>"); 
				echo ("<td>" . utf8_encode($c['email']) . "</td>"); 
				echo "</tr>\n";
			}
			echo ('</table>');
		}
		else 
			echo ('pas de contact');
			
		?>
		
	</div>

</body></html>
