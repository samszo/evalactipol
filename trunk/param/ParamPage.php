<?php
session_start();

	require_once ("Constantes.php");
	
	//Début de la parie ajoutée pour TagCloud
	
	if(isset($_SESSION['loginSess'])){
		$login = $_SESSION['loginSess'];
		$mdp = $_SESSION['mdpSess'];
	}else{
		$login = "evalactisem";
		$mdp = "delcious09";
		$_SESSION['loginSess']=$login;
		$_SESSION['mdpSess']=$mdp;
	}
	
	$oDelicious = new PhpDelicious($_SESSION['loginSess'],$_SESSION['mdpSess'],CACHETIME);
	$_SESSION['Delicious']= $oDelicious;
		

	if(isset($_GET['lang'])){
		$_SESSION['lang']=$_GET['lang'];
		$lang = $_GET['lang'];
	}else{
		$_SESSION['lang']='fr';
	}
	
	if(isset($_GET['TempsVide']))
		if($_GET['TempsVide']=="true")
			$TempsVide = true;
		else
			$TempsVide = false;
	else
		$TempsVide = true;
	
	if(isset($_GET['ShowAll']))
		if($_GET['ShowAll']=="true")
			$ShowAll = true;
		else
			$ShowAll = false;
	else
		$ShowAll = false;
	
	if(isset($_GET['DateDeb']))
		$DateDeb = $_GET['DateDeb'];
	else
		$DateDeb = false;
		
	if(isset($_GET['DateFin']))
		$DateFin = $_GET['DateFin'];
	else
		$DateFin = false;

	if(isset($_GET['NbDeb']))
		$NbDeb = $_GET['NbDeb'];
	else
		$NbDeb = 0;
		
	if(isset($_GET['NbFin']))
		$NbFin = $_GET['NbFin'];
	else
		$NbFin = 1000000000000;
	
	if(isset($_GET['TC']))
		$TC = $_GET['TC'];
	else
		$TC = "posts";
	//Fin de la partie ajoutée pour TagCloud


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
