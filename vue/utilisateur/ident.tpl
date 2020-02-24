<!doctype html>
<html lang="fr">
	<head>
	<meta charset="utf-8">
	<title>identification</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel="stylesheet" href="./vue/styleCSS/style.css">
		<script type="text/javascript">
			function show1(){
			  document.getElementById('cacher').style.display ='none';
			}
			function show2(){
			  document.getElementById('cacher').style.display = 'block';
			}
		</script>
	</head>
	<body>
		<div class="container-fluid">
			<form action="index.php?controle=utilisateur&action=ident" method="post">
			  <div class="form-group">
				<label for="login_text">Login</label>
				<input name="nom" type="Text" class="form-control" id="login_text"  placeholder="Enter login" value= "<?php echo $nom;?>">
			  </div>
			  <div class="form-group">
				<label for="exampleInputPassword1">Password</label>
				<input name="num" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" value= "<?php echo $num;?>">
			  </div>
			  <div class="form-group" id="cacher">
				<label for="testEtu">Test</label>
				<input name="test" type="text" class="form-control" id="testEtu" placeholder="Nom du test" value= "<?php echo $test;?>">
			  </div>
			  <br/>
			  <fieldset class="filet">
				<input id="etudiant" type="radio" name="mode" value="Etudiant" checked="checked" onclick="show2()"/>
				<label for="etudiant">Etudiant</label>
				<br>
				<input id="professeur" type="radio" name="mode" value="Professeur" onclick="show1()"/>
				<label for="professeur">Professeur</label>
			  </fieldset>
			  <button type="submit" class="btn btn-primary">Submit</button>
			</form>
			<div> 
				<?php echo $msg;?>
			</div> 
		</div>
	</body>
</html>
