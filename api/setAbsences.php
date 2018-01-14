<?php

if(isset($_GET['absents'])){
	if(empty($_GET['absents'])){
		// Il n'y a aucun absent
		return;
	}
	$idAbsents = explode("+",$_GET['absents']);
	var_dump($idAbsents);
} else {
	http_response_code(400);
	return;
}