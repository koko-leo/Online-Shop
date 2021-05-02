<?php
	require_once('model.php');
	
    session_start();
	
	function getPlanetsAsTable() {
		return json_encode(getAll());
	}
	
	function getAPlanet($name) {
		return json_encode(getPlanet($name));
	}
	function addAPlanet($form) {
		//we want the data as an associative array
		$planet = json_decode($form, true);
		return json_encode(addPlanet($planet['nom'], $planet['carac']));
	}
	function deleteAPlanet($name) {
		return json_encode(deletePlanet($name));
	}