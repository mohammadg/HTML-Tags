<?php
include_once('_php/_session.php');
$tripID = htmlspecialchars($_GET["trip"]);

$query = 'select privacy, owner_id from trips where trip_id = $1';
$result = $pg->_pg_query($query, $trip_id);

$num = $pg->_pg_num_rows($result);
if($num == 0) print 100;
$row = pg_fetch_assoc($result);
print $row['privacy'];
print $row['owner_id'];

print_r($row);
if(strcmp($row['privacy'], 'onlyme') == 0) {
    if(!isset($_SESSION['user_id'])) print 1;
    else if(!($_SESSION['user_id'] == $row['owner_id'])) print 2;
}

?>
