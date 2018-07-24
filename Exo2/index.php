<?php

	require_once 'connect.php';

	/*
	* Define the variable order to concatenate to the 
	* query depending on th get value received.
	*/

	$order = '';
	$column = '';

	if(isset($_GET['order']) && isset($_GET['columnn']))
	{

		/*
		* If a Get request is set, check is value
		* and give the value to order.
		*/

		if($_GET['column'] == 'lastname')
		{
		
			$order.= ' ORDER BY lastname';
		
		}
		elseif($_GET['column'] == 'firstname')
		{
			
			$order.= ' ORDER BY firstname';
		
		}
		elseif($_GET['column'] == 'birthdate')
		{
			
			$order.= ' ORDER BY birthdate';
		
		}

		//

		if($_GET['column'] == 'asc')
		{
			
			$column.= ' ASC';
		}
		elseif($_GET['order'] == 'desc')
		{
			
			$column.= ' DESC';

		}
	}

	/*
	* If there ise a value assigned the variable order
	* concatenate and make the request
	*/


	

		$queryUsers = $db->query('SELECT * FROM users' .$order . $column );

		/*
		* In case of execution, fecthall to 
		* to returns an array containing all of the result set rows
		*/

		$users = $queryUsers->fetchAll();

	
	

	/*
	* Define error variable to be concatenated
	*/

	$errors ="";

	if($_POST)
	{

		foreach($_POST as $key => $value)
		{

			$_POST[$key] = strip_tags(trim($value));
		
		}

		if(strlen($_POST['firstname']) < 3)
		{

			$errors.= '<div class="alert alert-warning">Le prénom doit comporter au moins 3 caractères</div>';
		}

		if(strlen($_POST['lastname']) < 3)
		{

			$errors.= '<div class="alert alert-warning">Le nom doit comporter au moins 3 caractères</div>';
		
		}
		
		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
		{

			$errors.= '<div class="alert alert-warning">L\'adresse email est invalide</div>';
	
		}

		if(empty($_POST['birthdate']))
		{

		$errors.= '<div class="alert alert-warning">La date de naissance doit être complétée</div>';
	
		}
		
		if(empty($_POST['city']))
		{
			
			$errors.= '<div class="alert alert-warning">La ville ne peut être vide</div>';
		
		}
		

		/*
		* In case of no errors
		* Prepare the query, bind the values and execute
		*/

		if(empty($errors))
		{ 

			$result = $db->prepare("SELECT email FROM users WHERE email = :email");

			$result->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
	
			$result->execute();
	
				if($result->rowCount() == 1)
				{
					$errors .= "<div class='alert alert-secondary'>The pseudo $_POST[email] is already taken, please choose another one.</div>";
				}
				else
				{
			
					$insertUser = $db->prepare('INSERT INTO users (gender, firstname, lastname, email, birthdate, city) VALUES (:gender, :firstname, :lastname, :email, :birthdate, :city)');
					
					$insertUser->bindValue(':gender', $_POST['gender'], PDO::PARAM_STR);
					$insertUser->bindValue(':firstname', $_POST['firstname'], PDO::PARAM_STR);
					$insertUser->bindValue(':lastname', $_POST['lastname'], PDO::PARAM_STR);
					$insertUser->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
					$insertUser->bindValue(':birthdate', date('Y-m-d', strtotime($_POST['birthdate'])));
					$insertUser->bindValue(':city', $_POST['city'], PDO::PARAM_STR);

				

					if($insertUser->execute())
					{
						
						$createUser = true;
						
					}
					else
					{
						
						$errors.= '<div class="alert alert-warning">SQL error, please contact your administrator</div>';
					
					}
				}
				
		}
	}
	
	
			
		

		
?>


	
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Exercice 1</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
</head>
<body>

	<div class="container">
		<h1>Liste des utilisateurs</h1>
		<ul>Trier par : 
			<li><a href="index.php?column=firstname&order=asc">Prénom (croissant)</a></li>
			<li><a href="index.php?column=firstname&order=desc">Prénom (décroissant)</a></li>
			<li><a href="index.php?column=lastname&order=asc">Nom (croissant)</a></li>
			<li><a href="index.php?column=lastname&order=desc">Nom (décroissant)</a></li>
			<li><a href="index.php?column=birthdate&order=asc">Âge (croissant)</a></li>
			<li><a href="index.php?column=birthdate&order=desc">Âge (décroissant)</a></li>
		</ul>
		
		<br>

		<div class="row">
			<?php

				if(isset($createUser) && $createUser == true)
				{

					echo '<div class="col-md-6 col-md-offset-3">';
					echo '<div class="alert alert-success">Le nouvel utilisateur a été ajouté avec succès.</div>';
					echo '</div><br>';
				
				}

				

			?>
			

			<div class="col-md-7">
				<table class="table">
					<thead>
						<tr>
							<th>Civilité</th>
							<th>Prénom</th>
							<th>Nom</th>
							<th>Email</th>
							<th>Age</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($users as $key => $value):?>
						<tr>
							<td><?php echo $value['gender'];?></td>
							<td><?php echo $value['firstname'];?></td>
							<td><?php echo $value['lastname'];?></td>
							<td><?php echo $value['email'];?></td>
							<td><?php echo DateTime::createFromFormat('Y-m-d', $value['birthdate'])->diff(new DateTime('now'))->y;?> ans</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>

			<div class="col-md-5">
				<form method="post" class="form-horizontal well well-sm">
					<fieldset>
					<!-- If error in the adding of user, error message to be displayed -->
					<?= $errors ?>
					<legend>Ajouter un utilisateur</legend>

						<div class="form-group">
							<label class="col-md-4 control-label" for="gender">Civilité</label>
							<div class="col-md-8">
								<select id="gender" name="gender" class="form-control input-md" required>
									<option value="Mlle">Mademoiselle</option>
									<option value="Mme">Madame</option><option value="M">Monsieur</option>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label" for="firstname">Prénom</label>
							<div class="col-md-8">
								<input id="firstname" name="firstname" type="text" class="form-control input-md" required>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label" for="lastname">Nom</label>  
							<div class="col-md-8">
								<input id="lastname" name="lastname" type="text" class="form-control input-md" required>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-4 control-label" for="email">Email</label>  
							<div class="col-md-8">
								<input id="email" name="email" type="email" class="form-control input-md" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label" for="city">Ville</label>  
							<div class="col-md-8">
								<input id="city" name="city" type="text" class="form-control input-md" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label" for="birthdate">Date de naissance</label>  
							<div class="col-md-8">
								<input id="birthdate" name="birthdate" type="text" placeholder="JJ-MM-AAAA" class="form-control input-md" required>
								<span class="help-block">au format JJ-MM-AAAA</span>  
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-4 col-md-offset-4">
								<button type="submit" class="btn btn-primary">Envoyer</button>
							</div>
						</div>

					</fieldset>
				</form>
			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
</body>
</html>