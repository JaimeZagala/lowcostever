<?php 
$username ='webapp';
$password = 'webapp1234';
try{
	$db = new PDO('mysql:host=localhost;dbname=lowcostever', $username, $password);
}catch(PDOException $error){
    print "Error: " . $error->getMessage() . '<br>';
    die();
}
?>