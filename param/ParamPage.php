<?php
session_start();
//set_time_limit(3000);

	require_once ("Constantes.php");



	// vérification du site en cours
	if(isset($_GET['site'])){
		$site = $_GET['site'];
	}else{
		if(!session_is_registered("Site"))
			$site = DEFSITE;
	}
			
	$scope = array(
			"site" => $site
			);	
	
	$objSite = new Site($SITES, $site, $scope, false);
	

?>
