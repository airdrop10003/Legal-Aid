<?php

// Connect to the database
$db = new mysqli("localhost", "dbusername", "password", "legalaid_db");

// Create a table for legal aid requests
$sql ="CREATE TABLE IF NOT EXISTS legal_aid_requests (
	id INT UNIQUE NOT NULL AUTO_INCREMENT PRIMARY KEY,
	first_name VARCHAR(50) NOT NULL,
	last_name VARCHAR(50) NOT NULL,
	email VARCHAR(100) NOT NULL,
	phone_number VARCHAR(15) NOT NULL,
	date_requested DATE NOT NULL,
	request_type VARCHAR(50) NOT NULL,
	description TEXT
	);";
$db->query($sql);

// Create a table for legal aid resources
$sql ="CREATE TABLE IF NOT EXISTS legal_aid_resources (
	id INT UNIQUE NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(50) NOT NULL,
	url VARCHAR(255) NOT NULL,
	description TEXT
	);";
$db->query($sql);

// Create a table for legal aid resources users
$sql ="CREATE TABLE IF NOT EXISTS legal_aid_resources_users (
	user_id INT NOT NULL,
	resource_id INT NOT NULL,
	FOREIGN KEY (user_id) REFERENCES legal_aid_requests(id),
	FOREIGN KEY (resource_id) REFERENCES legal_aid_resources(id)
	);";
$db->query($sql);

// Add a legal aid resource
function add_resource($name, $url, $description) {
	global $db;
	$sql = "INSERT INTO legal_aid_resources (name, url, description)
			VALUES('$name', '$url', '$description')";
	$db->query($sql);
}

// Assign a legal aid resource to a user
function assign_resource($user_id, $resource_id) {
	global $db;
	$sql = "INSERT INTO legal_aid_resources_users (user_id, resource_id)
 			VALUES('$user_id', '$resource_id')";
	$db->query($sql);
}

// Retrieve a list of legal aid resources
function list_resources() {
	global $db;
	$sql = "SELECT * FROM legal_aid_resources";
	$result = $db->query($sql);
	if($result->num_rows > 0) {
		$resources = array();
		while($row = $result->fetch_assoc()) {
			$resources[] = $row;
		}
		return $resources;
	}
}

// Retrieve a list of resources assigned to a user
function list_user_resources($user_id) {
	global $db;
	$sql = "SELECT r.name, r.url, r.description
			FROM legal_aid_resources r
			INNER JOIN legal_aid_resources_users ru
				ON ru.resource_id = r.id
			WHERE ru.user_id = $user_id";
	$result = $db->query($sql);
	if($result->num_rows > 0) {
		$resources = array();
		while($row = $result->fetch_assoc()) {
			$resources[] = $row;
		}
		return $resources;
	}
}

// Submit a request for legal aid
function submit_request($first_name, $last_name, $email, $phone_number, $request_type, $description) {
	global $db;
	$date_requested = date('Y-m-d H:i:s');
	$sql = "INSERT INTO legal_aid_requests (first_name, last_name, email, phone_number, date_requested, request_type, description)
			VALUES('$first_name', '$last_name', '$email', '$phone_number', '$date_requested', '$request_type', '$description')";
	$db->query($sql);
}

// Retrieve a list of requests
function list_requests() {
	global $db;
	$sql = "SELECT * FROM legal_aid_requests";
	$result = $db->query($sql);
	if($result->num_rows > 0) {
		$requests = array();
		while($row = $result->fetch_assoc()) {
			$requests[] = $row;
		}
		return $requests;
	}
}

// Retrieve a request by id
function get_request($id) {
	global $db;
	$sql = "SELECT * FROM legal_aid_requests WHERE id = '$id'";
	$result = $db->query($sql);
	if($result->num_rows > 0) {
		$request = $result->fetch_assoc();
		return $request;
	}
}

// Update a request
function update_request($id, $first_name, $last_name, $email, $phone_number, $request_type, $description) {
	global $db;
	$sql = "UPDATE legal_aid_requests
			SET first_name = '$first_name', 
				last_name = '$last_name',
				email = '$email',
				phone_number = '$phone_number',
				request_type = '$request_type',
				description = '$description'
			WHERE id = '$id'";
	$db->query($sql);
}

// Delete a request
function delete_request($id) {
	global $db;
	$sql = "DELETE FROM legal_aid_requests WHERE id = '$id'";
	$db->query($sql);
}
?>