<?php

include_once('_session.php');

$trip_id = $_GET['trip'];

$longitude = array();
$latitude = array();
$group_id = array();
$images = array();

$query = "select group_id, longitude, latitude from image_groups where trip_id = $1";
$result = $pg->_pg_query($query, $trip_id);

$row = pg_fetch_all($result);
$row_nums = sizeof($result);

for($i = 0; $i != $row_nums; $i++) {
  array_push($group_id, $row[$i]['group_id']);
  array_push($longitude, $row[$i]['longitude']);
  array_push($latitude, $row[$i]['latitude']);

  //
  $query = "select path from images where group_id = $1";
  $result = $pg->_pg_query($query, $group_id[$i]);
  $row = pg_fetch_assoc($result);
  array_push($images, $row['path']);
}

// Array ( [0] => 1 ) Array ( [0] => 147.832 ) Array ( [0] => -21.7799 ) Array ( [0] => 6dce033bd40fee85beab8944143b144b.png )
print_r($group_id);
print_r($latitude);
print_r($longitude);
print_r($images);

?>
