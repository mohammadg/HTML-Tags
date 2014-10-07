<?php

include_once('postgres.php');

$pg = new postgres();
if(!function_exists('pg_connect')) {
	return false;
}
$pg->_pg_connect($host, $username, $password, $database, $port);

if(!function_exists('pg_query')) {
	return false;
}
$pg->_pg_query('DROP TABLE IF EXISTS images');
$pg->_pg_query('DROP TABLE IF EXISTS image_groups');
$pg->_pg_query('DROP TABLE IF EXISTS trips');

$query = '
CREATE TABLE trips (
	trip_id varchar(10) PRIMARY KEY,
	name varchar(64) NOT NULL,
	description varchar(256)
)';
$pg->_pg_query($query);
$query = '
CREATE TABLE image_groups (
	group_id varchar(10) PRIMARY KEY, 
	trip_id varchar(10) REFERENCES trips(trip_id) NOT NULL,	
	name varchar(64) NOT NULL,
	longitude float(10) NOT NULL,
	latitude float(10) NOT NULL
)';
$pg->_pg_query($query);
$query = '
CREATE TABLE images (
	image_id varchar(10) PRIMARY KEY,
	group_id varchar(10) REFERENCES image_groups(group_id),
	description varchar(256)
)';
$pg->_pg_query($query);
$query = 'ALTER TABLE trips ADD COLUMN cover_image varchar(10) REFERENCES images(image_id)';
$pg->_pg_query($query);
$query = 'ALTER TABLE image_groups ADD COLUMN cover_image varchar(10) REFERENCES images(image_id)';
$pg->_pg_query($query);
$query = '
CREATE TABLE comments (
	comment_id varchar(10) PRIMARY KEY,
	image_id varchar(10) REFERENCES images(image_id)
)';
$pg->_pg_query($query);
?>