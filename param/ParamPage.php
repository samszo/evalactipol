<?php
session_start();

	require_once ("Constantes.php");



	// vérification du site en cours
	if(isset($_GET['site'])){
		$idSite = $_GET['site'];
	}else{
		if(!session_is_registered("Site"))
			$idSite = DEFSITE;
	}
			
	$scope = array(
			"site" => $idSite
		//	,"FicXml" => PathRoot."/param/Param.xml"
		,"FicXml" => PathRoot."/param/ParamXul.xml"
	
	);	
	
	$objSite = new Site($SITES, $idSite, $scope, false);

	// création de l'objet de cache
	$cl_Output = new Cache_Lite_Function(array('cacheDir' => CACHEPATH,'lifeTime' => LIFETIME));
	
	
?>
