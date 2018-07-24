<?php

$msg_error = "";

if(isset($_POST))
{
    $ok = true;
    
    if(isset($_POST['brand']) AND empty($_POST['brand']))
    {
       
        $ok = false;
        // display error
        $msg_error .= "<div class='alert alert-danger'>Enter a valid brand name</div>";
    }
    
    if(isset($_POST['model']) AND empty($_POST['model']))
    {

        $ok = false;
        // display error
        $msg_error .= "<div class='alert alert-danger'>Enter a valid model</div>";
    }
    
    if(isset($_POST['color']) AND empty($_POST['color']))
    {
        
        
        $ok = false;
        // display error
        $msg_error .= "<div class='alert alert-danger'>Enter a valid color</div>";
    }
    
    
	if(!$ok)
    {
        http_response_code(400);
    }
    
}
else
{
	
    // display error
    http_response_code(405);
	$msg_error .= "<div class='alert alert-danger'>Error 405, please input datas or contact your administrator</div>";
}

?>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="ISO-8859-1">
        <title>Add a new vehicle</title>
        <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>


    <body class="container">
	<h1>Automobile form</h1>
	<?= $msg_error ?>
    	<form method="post" action="">
    		<label for="firstname">Brand</label>
    		<input class="form-control" name="brand" type="text" />
    		<br/>
    		<label for="lastname">Model</label>
    		<input class="form-control" name="model" type="text" />
    		<br/>
    		<label for="email">Year</label>
    		<input class="form-control" type="number" min="1900" max="2099" step="1" value="2018"name="year" />
    		<br/>
    		<label for="address">Color</label>
    		<input class="form-control" name="color" type="text" />
    		<br/>
    		<button class="btn btn-success" name="submit" type="submit">submit</button>
    	</form>

        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </body>
</html>