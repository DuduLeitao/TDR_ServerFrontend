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
  if(mysqli_connect_errno()){
  	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
  }
  // Take the history values from the database.
  if($_SESSION['usertype'] == "admin") { // Check if the typeuser is admin to show privileged data
    $stmt = $con->prepare('SELECT username, time, action FROM history, users WHERE history.id_history=users.id_user ORDER BY time DESC');
    // $stmt = $con->prepare('SELECT username, time, action FROM history, users WHERE history.id_history=users.id_user AND time>="2012-06-21 00:00:00" AND time<"2022-12-21 00:00:00" ORDER BY time DESC LIMIT 10');
    $stmt->execute();
    $stmt->bind_result($username, $time, $action);
    $history_data = array();
    while($stmt->fetch()){
      $day_hour = explode(" ",$time);
      array_push($history_data, array($username, $day_hour[0], $day_hour[1], $action));
    }
    $table_titles = array("Usuario","Dia","Hora","Ação");
  }else {
    $stmt = $con->prepare('SELECT time, action FROM history WHERE id_history = ?');
    // In this case we can use the account ID to get the account info.
    $stmt->bind_param('i', $_SESSION['id']);
    $stmt->execute();
    $stmt->bind_result($time, $action);
    $history_data = array();
    while($stmt->fetch()){
      $day_hour = explode(" ",$time);
      array_push($history_data, array($day_hour[0], $day_hour[1], $action));
    }
    $table_titles = array("Dia","Hora","Ação");
  }
  $stmt->fetch();
  $stmt->close();
?>

<!DOCTYPE html>
<html>
  <?php
    $pageTitle = "Historial";
    include("includes/head.php");
  ?>
	<body class="loggedin">
    <?php include("includes/navigation.php");?>
		<div class="content">
			<h2>Historial pessoal</h2>
			<div>
				<p>Historial de ações sobre o portão:</p>
        <?php
          if(!empty($history_data)){
            include("includes/table.php");
          }else{
            echo "Não ha dados no historial.";
          }
        ?>
			</div>
		</div>
	</body>
</html>
