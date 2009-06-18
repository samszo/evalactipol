<?php
        
	require_once ("../../param/ParamPage.php");

	//charge le fichier de paramètrage

	$objSite->XmlParam = new XmlParam(PathRoot."/param/Evalactipol.xml");

	$resultat = "";

	if(isset($_POST['f'])){
		$fonction = $_POST['f'];

	}
	else
	if(isset($_GET['f']))
		$fonction = $_GET['f'];
	else 
	$fonction ='';

	if(isset($_GET['id']))
		$id = $_GET['id'];
	else
		$id = -1;

	if(isset($_GET['type']))
		$type = $_GET['type'];
	else
		$type = -1;
	
	if(isset($_GET['numDepartement']))
		$numDepartement = $_GET['numDepartement'];
	else
		$numDepartement = -1;
	
	//Début Partie ajoutée par MTO	
	if(isset($_GET['lat']))
		$lat = $_GET['lat'];
	else
		$lat = -1;
	if(isset($_GET['lng']))
		$lng = $_GET['lng'];
	else
		$lng = -1;
	if(isset($_GET['zoom']))
		$zoom = $_GET['zoom'];
	else
		$zoom = -1;
	//Fin de la partie ajoutée par MTO

	switch ($fonction) {

		case 'GetTree':
			$resultat= GetTree();
		break;
		case 'GetTree_load':
			$resultat= GetTree_load($type,'','','','Departements','France');
		break;
		/*case 'Getlist':
			//$resultat= utf8_encode(Getlist($id,$type));
			$resultat= Getlist($id,$type);
		break;*/
		
		case 'GetTrees':
			//$resultat= utf8_encode(Getlist($id,$type));
			$resultat= GetTrees($id,$type);
		break;
		
		case 'GetListes':
			//$resultat= utf8_encode(Getlist($id,$type));
			$resultat= GetListes($id,$type);
		break;
		
		case 'Getlist_depute':
			$resultat= utf8_encode(Getlist_depute($id,$type));
		break;
		case 'GetJson':
			$resultat= GetJson();
		break;
		case 'GetDataOneDepart':
			$resultat= GetDataOneDepart($numDepartement);
		break;
		case 'GetDataAllDepart':
			$resultat= GetDataAllDepart();
		break;
		
		//Début Partie ajoutée par MTO	
		case 'GetLatLngZoom':
			$resultat= GetLatLngZoom($id,$lat,$lng,$zoom);
		break;
		//Fin Partie ajoutée par MTO	
		
	}

	echo $resultat;  

function GetTree(){
	global $objSite;
	$xul = new Xul($objSite);

	return $xul->GetTree();
}

function GetTree_load($type,$niv=-1,$val1=-1,$val2=-1,$contexteTree,$titreTree){
	global $objSite;
	$xul = new Xul($objSite);

	return $xul->GetTree_load($type,$niv=-1,$val1=-1,$val2=-1,$contexteTree,$titreTree);
}

/*function Getlist($id,$type){

	global $objSite;
	$xul = new Xul($objSite);

	return $xul->Getlist($id,$type);
}*/

function GetTrees($id,$type){

	global $objSite;
	$xul = new Xul($objSite);

	return $xul->GetTrees($id,$type);
}
function GetListes($id,$type){

	global $objSite;
	$xul = new Xul($objSite);

	return $xul->GetListes($id,$type);
}


function Getlist_depute($id,$type){

	global $objSite;
	$xul = new Xul($objSite);

	return $xul->Getlist_depute($id,$type);
}
function GetJson(){

	global $objSite;
	$xul = new Xul($objSite);

	return $xul->GetJson();
}
function GetDataOneDepart($numDepartement){

	global $objSite;
	$GoogleVisualisation = new GoogleVisualisation($objSite);

	return $GoogleVisualisation->GetDataOneDepart($numDepartement);
}
function GetDataAllDepart(){

	global $objSite;
	$GoogleVisualisation = new GoogleVisualisation($objSite);

	return $GoogleVisualisation->GetDataAllDepart();
}

//Début Partie ajoutée par MTO	
	function GetLatLngZoom($id,$lat,$lng,$zoom){
	
	global $objSite;
	$GetSqlInfos = new GetSqlInfos ($objSite);
	//Le type peut être de la forme departement_(num de département) ou cantons_(l'id du canton dans la BD).
	//Donc, il faut extraire le type.
	$type = $GetSqlInfos->extractBetweenDelimeters($id,"","_");
	if ($type == "departement")
	{
	//Si le type est departement, on extrait le num de département
	$identifiant = substr ($id,12);
	}
	else
	{
	//Si le type est un canton, on extrait le l'id du canton dans la BD
	$identifiant = substr ($id,8);
	}
	//On appelle la fct GetLatLngZoom qui va insérer la lat,lng et zoom selon le type
	return $GetSqlInfos->GetLatLngZoom($identifiant,$lat,$lng,$zoom,$type);
	/*$numDepartement = substr ($id,12);
	return $GetSqlInfos->GetLatLngZoom($numDepartement,$lat,$lng,$zoom);*/
}
//Fin Partie ajoutée par MTO	


?>
