<?php 
include 'function.php';
$dbc = db_connect();

$query = "SELECT * FROM Events";
$result = mysqli_query($dbc,$query);
if ($result) {
  while ($one_event = $result -> fetch_array()) {
    echo "{";
    echo "title: '".$one_event['title']."',\n";
    echo "start: '".$one_event['time']."',\n";
    echo "end: '".$one_event['end_time']."',\n";
    echo "url: './org_events.php?org=".$one_event['org_name']."&event_id=".$one_event['event_id']."'\n";
    echo "},\n";
  }
}
mysqli_close($dbc);
?>