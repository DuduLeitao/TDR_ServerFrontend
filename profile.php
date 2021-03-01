<?php
  // We need to use sessions, so you should always start sessions using the below code.
  session_start();
  // If the user is not logged in redirect to the login page...
  if (!isset($_SESSION['loggedin'])) {
  	header('Location: index.html');
  	exit();
  }
  $DATABASE_HOST = 'localhost';
  $DATABASE_USER = 'dbuser';
  $DATABASE_PASS = 'dbpass';
  $DATABASE_NAME = 'TDR';
  $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
  if (mysqli_connect_errno()) {
  	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
  }
  // We don't have the password or email info stored in sessions so instead we can get the results from the database.
  $stmt = $con->prepare('SELECT password, username FROM users WHERE id_user = ?');
  // In this case we can use the account ID to get the account info.
  $stmt->bind_param('i', $_SESSION['id']);
  $stmt->execute();
  $stmt->bind_result($password, $email);
  $stmt->fetch();
  $stmt->close();
?>
<!DOCTYPE html>
<html>
<?php
  $pageTitle = "Perfil";
  include("includes/head.php");
?>
	<body class="loggedin">
    <?php include("includes/navigation.php");?>
		<div class="content">
			<h2>Perfil pessoal</h2>
			<div>
				<p>Detalles da sua conta de usuario:</p>
				<table>
					<tr>
						<td>Username:</td>
						<td><?=$_SESSION['name']?></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><?=$password?></td>
					</tr>
					<tr>
						<td>nick?:</td>
						<td><?=$email?></td>
					</tr>
				</table>
			</div>
		</div>
	</body>
</html>
