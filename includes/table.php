<?php
  echo "<table class='table'>";
  echo "<tr>";
  for($i = 0; $i <= sizeof($table_titles)-1; $i++){
    echo "<th>".$table_titles[$i]."</th>";
  }
  echo "</tr>";
  for($i = 0; $i <= sizeof($history_data)-1; $i++){
    echo "<tr>";
    for($j = 0; $j <= sizeof($table_titles)-1; $j++){
      echo "<td>".$history_data[$i][$j]."</td>";
    }
    echo "</tr>";
  }
  echo "</table>";
?>
