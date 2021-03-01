<?php
  // We need to use sessions, so you should always start sessions using the below code.
  session_start();
  // If the user is not logged in redirect to the login page...
  if (!isset($_SESSION['loggedin'])){
  	header('Location: index.html');
  	exit();
  }
?>
<!DOCTYPE html>
<html>
  <?php
    $pageTitle = "Home";
    include("includes/head.php");
  ?>
	<body class="loggedin">
    <?php include("includes/navigation.php");?>

		<div class="content">
			<h2>Página principal</h2>
			<p>Benvindo de novo, <?=$_SESSION['name']?>!</p>
		</div>
	</body>
</html>
