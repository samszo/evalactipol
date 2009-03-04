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
			,"FicXml" => PathRoot."/param/Param.xml"
	);	
	
	$objSite = new Site($SITES, $site, $scope, false);

	// création de l'objet de cache
	$cl_Output = new Cache_Lite_Function(array('cacheDir' => CACHEPATH,'lifeTime' => LIFETIME));
	//fonction utilisées pour le cache
	/*
	function cl_file_get_html($url){
		return file_get_html($url);
	}
	*/
	
?>
