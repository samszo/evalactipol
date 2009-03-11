<?php

class extract {

public $nom_table;
public $chaine;
public $baseUrl;
public $cl_Output;
public $site;


function __tostring() {
	return "Cette classe permet d'extraire le contenu d'une collection de page HTML.<br/>";
}

public function __construct($site, $baseUrl, $cl_Output) {
	$this->baseUrl = $baseUrl;
	$this->cl_Output = $cl_Output;
	$this->site = $site;
}

function extract_site ()
{
	
$baseUrlHtml = $this->baseUrl."/wiki/Deputes_par_departement";
/*
$result_exist_url = $this->verif_exist_url ($baseUrlHtml,"Url de départ");
	if ($result_exist_url == NULL)
	{  
	$this->SetUrl($baseUrlHtml,"Url de départ");
	}
*/
$this->SetUrl($baseUrlHtml,"Url de départ");

$result_id_url_ttDepart = $this->extract_id_url ($baseUrlHtml,"Url de départ");

//$cl_Output = new Cache_Lite_Function(array('cacheDir' => CACHEPATH,'lifeTime' => LIFETIME));
$html = $this->cl_Output->call('file_get_html',$this->baseUrl."/wiki/Deputes_par_departement");

$retours = $html->find('li a[title^=Deputes]');

//boucle sur les départements
	foreach($retours as $dept)
	{
	$urlDept = $dept->attr["href"];
	$url =$this->baseUrl.$urlDept;
	$htmlDept = $this->cl_Output->call('file_get_html',$url);
//  $htmlDept = file_get_html($url);
	$result_exist_url = $this->verif_exist_url ($url,"find('li a[title^=Deputes]')");
		if ($result_exist_url == NULL)
		{    
		$this->insert_table_urls ($url,"find('li a[title^=Deputes]')");
		}
	$result_id_url_Depart = $this->extract_id_url ($url,"find('li a[title^=Deputes]')");
	//Extraction des noms des cantons
	//et insertion des cantons dans la table geoname 

	list ($nom_cantons,$circonscription_cantons,$numDepart_canton,$circonscriptions_depart,$type_geoname,$tabNomGeonameCantons) = $this->extract_canton ($htmlDept,$urlDept);

	//Extraction des infos sur les départements

	list ($numDepartDepute,$nomGeo_Depart,$type_geoname) = $this->extract_departement ($urlDept,$dept);
	//Insertion dans la table geoname

	$result_exist_geo = $this->verif_exist_geo ($nomGeo_Depart,$type_geoname);
		if ($result_exist_geo == NULL)
		{
		$this->insert_table_geoname ($nomGeo_Depart,$type_geoname,$numDepartDepute,$circonscriptions_depart);
		}

	//$result_id_geo = $this->extract_id_geo ($numDepartDepute);

	//extraction des liens des infos des députées

	$rsDept = $htmlDept->find('td a[href^=/wiki/]');

		//Boucle sur les députés
		foreach($rsDept as $depu)
		{
		$urlDepu = $depu->attr["href"]; 
		//vérifie qu'on traite un député
		$nom = substr($urlDepu,6,7);
			if($nom!="Deputes")
			{

			$urlDepute=$baseUrl.$urlDepu;
			//$htmllienDepu = file_get_html($urlDepute);
			$htmllienDepu = $cl_Output->call('file_get_html',$urlDepute);
			$result_exist_url = $this->verif_exist_url ($urlDepute,"find('td a[href^=/wiki/]')");
				if ($result_exist_url == NULL)
				{
				$this->insert_table_urls ($urlDepute,"find('td a[href^=/wiki/]')");
				}
			$result_id_url_Deput = $this->extract_id_url ($urlDepute,"find('td a[href^=/wiki/]')");
			//extraction des info du député

			/*foreach ($result_id_geo as $id_geo)
			{
			$this->insert_table_depute_geo ($result_id_deput,$id_geo); 
			$this->insert_table_geo_url ($id_geo,$result_id_url_Depart);
			}*/


		$oDepute = new depute ($htmllienDepu,$depu,$result_id_url_Deput,$numDepartDepute);
		$oDepute->extrac_infos_depute ($htmllienDepu,$depu,$result_id_url_Deput,$numDepartDepute,$cl_Output);

			}
		}
	}  
}    


function extract_departement ($urlDept,$dept)
{
$numDepart = substr($urlDept,14);
$numDepartDepute = (int)$numDepart;   
//Extraction du nom de département  
$NomDepart = $dept->nodes;
$ChaineNomDepart = implode(";", $NomDepart);
$nomGeo_Depart = $this->extractBetweenDelimeters($ChaineNomDepart,""," ");
$type_geoname = "Departement";  
return array ($numDepartDepute,$nomGeo_Depart,$type_geoname);
}

function extract_canton ($htmlDept,$urlDept)
{          
$numDepart_canton1 = substr($urlDept,14);
$numDepart_canton = (int)$numDepart_canton1;
$rsCantons = $htmlDept->find('tbody tr');
//supprimer la première ligne qui représente le nom des colonnes
$rsCantons1 = array_shift($rsCantons);

//Boucler sur les Cantons
$x = "";
	foreach($rsCantons as $cantons)
	{
	$infosCantons = $cantons->children;
	$ChaineCantons = implode(";", $infosCantons);
	//Extraction des noms des cantons dans une chaine de caractères
	$nom_cantons = $this->extractBetweenDelimeters($ChaineCantons,"(cantons de ",")");
	//Insertion des noms des cantons dans un tableau
	$tabNomGeonameCantons = explode (",",$nom_cantons);

		foreach ($tabNomGeonameCantons as $value)
		{
		//Préciser que le type de geoname d'un canton est canton
		// avant d'insérer le canton dans la table geoname
		$nom_geoname_canton = $value;
		//$nom_geoname_canton = $value;
		$type_geoname_canton = "canton";
		//Extraction du numéro de circonscription du canton
		$circonscription_cantons = substr($ChaineCantons,5,1);

		$result_exist_geo = $this->verif_exist_geo ($nom_geoname_canton,$type_geoname_canton);
			if ($result_exist_geo == NULL)
			{
			$this->insert_table_geoname ($nom_geoname_canton,$type_geoname_canton,$numDepart_canton,$circonscription_cantons);            
			}

		$x = $x.",".$circonscription_cantons;
		}
	}
//Les numéros de circonscriptions qui existent dans un département
$circonscriptions_depart1 = substr($x,1);
$circonscriptions_depart2 = explode (",",$circonscriptions_depart1);
$circonscriptions_depart3 = array_unique ($circonscriptions_depart2);
$circonscriptions_depart = implode(",", $circonscriptions_depart3);

$type_geoname = "Ville";
return array  ($nom_cantons,$circonscription_cantons,$numDepart_canton,$circonscriptions_depart,$type_geoname,$tabNomGeonameCantons);   

}

//Fonction qui récupère une chaine inconnue entre deux chaines connues
function extractBetweenDelimeters($inputstr,$delimeterLeft,$delimeterRight)
{
$posLeft  = stripos($inputstr,$delimeterLeft)+strlen($delimeterLeft);
$posRight = stripos($inputstr,$delimeterRight,$posLeft+1);
return  substr($inputstr,$posLeft,$posRight-$posLeft);
}

function insert_table_geoname ($nomGeo,$typeGeo,$numDepartgeo,$circonscGeo)
{
//$objSite = new Site($SITES, $site, $scope, false);
//$db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
$db=new mysql ('localhost','root','','evalactipol');
//$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);    
$link=$db->connect();
$sql = "INSERT INTO `geoname` ( `id_geoname` , `nom_geoname`, `type_geoname`, `num_depart_geoname`, `circonscriptions_geoname`, `lat_geoname`, `lng_geoname`, `alt_geoname`, `kml_geoname` ) VALUES ('', \"$nomGeo\", \"$typeGeo\", \"$numDepartgeo\", \"$circonscGeo\", '', '', '', '')";     
$result = $db->query(utf8_decode($sql));
$db->close($link);
}

function insert_table_urls ($valeurURL,$codeExtractURL)
{
//$db=new mysql ('localhost','root','','evalactipol');
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db->connect();
	$sql = "INSERT INTO `urls` ( `id_URL` , `valeur_url`, `code_extract_URL` ) VALUES ('', \"$valeurURL\", \"$codeExtractURL\")";     
	$result = $db->query(utf8_decode($sql));
	$db->close();
}

function SetUrl($valeurURL, $codeExtractURL)
{
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db->connect();
	$sql = "DELETE FROM `urls` WHERE `valeur_url` =\"$valeurURL\" AND code_extract_URL=\"$codeExtractURL\" ";     
	$result = $db->query(utf8_decode($sql));
	//$db->close();
	
	//$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	//$db->connect();
	$sql = "INSERT INTO `urls` ( `id_URL` , `valeur_url`, `code_extract_URL` ) VALUES ('', \"$valeurURL\", \"$codeExtractURL\")";     
	$result = $db->query(utf8_decode($sql));
	$id =  mysql_insert_id();
	$db->close();
	return $id;
}


function insert_table_depute_geo ($id_deput,$id_geo)
{
$db=new mysql ('localhost','root','','evalactipol');
//$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//$objSite = new Site($SITES, $site, $scope, false);
//$db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
$link=$db->connect();
$sql = "INSERT INTO `depute-geo` ( `id_depute` , `id_geoname` ) VALUES (\"$id_deput\", \"$id_geo\")";     
$result = $db->query(utf8_decode($sql));
$db->close($link);
}

function insert_table_geo_url ($id_geo,$id_url)
{
$db=new mysql ('localhost','root','','evalactipol');
//$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//$objSite = new Site($SITES, $site, $scope, false);
//$db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
$link=$db->connect();
$sql = "INSERT INTO `geo-url` ( `id_geoname` , `id_URL` ) VALUES (\"$id_geo\", \"$id_url\")";     
$result = $db->query(utf8_decode($sql));
$db->close($link);
}

function verif_exist_geo ($nom_geo,$type_geo)
{
$db=new mysql ('localhost','root','','evalactipol');
//$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//$objSite = new Site($SITES, $site, $scope, false);
//$db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
$link=$db->connect();
$sql = "SELECT * FROM `geoname` WHERE `nom_geoname`=\"$nom_geo\" AND `type_geoname`=\"$type_geo\" ";     
$result = $db->query(utf8_decode($sql));
$db->close($link);
return ($result1 = mysql_fetch_array( $result));
}   

function verif_exist_url ($valeurURL,$codeExtractURL)
{
$db=new mysql ('localhost','root','','evalactipol');

//$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//$objSite = new Site($SITES, $site, $scope, false);
//$db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
$link=$db->connect();
$sql = "SELECT * FROM `urls` WHERE `valeur_URL`=\"$valeurURL\" AND `code_extract_URL`=\"$codeExtractURL\" ";     
$result = $db->query(utf8_decode($sql));
$db->close($link);
return ($result1 = mysql_fetch_array( $result));
}

//function extract_id_geo ($nom_geo,$type_geo)
function extract_id_geo ($num_Depart_geo)
{
$db=new mysql ('localhost','root','','evalactipol');
//$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//$objSite = new Site($SITES, $site, $scope, false);
//$db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
$link=$db->connect();
//$sql = "SELECT `id_geoname` FROM `geoname` WHERE `nom_geoname`=\"$nom_geo\" AND `type_geoname`=\"$type_geo\" ";
$sql = "SELECT `id_geoname` FROM `geoname` WHERE `num_depart_geoname`=\"$num_Depart_geo\" ";     
$result = $db->query(utf8_decode($sql));
//$result1 = mysql_query ($sql);
$result1 = mysql_fetch_row($result);
//$result4 = "";
//while ($result1)
//{  
//$result2 = $result1[0];
//$result4 = $result4.",".$result3;
//}  
$db->close($link);
$result2 = $result1[0];  
return $result2; 
}   

function extract_id_url ($valeurURL,$codeExtractURL)
{
$db=new mysql ('localhost','root','','evalactipol');
//$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//$objSite = new Site($SITES, $site, $scope, false);
//$db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
$link=$db->connect();
$sql = "SELECT `id_URL` FROM `urls` WHERE `valeur_URL`=\"$valeurURL\" AND `code_extract_URL`=\"$codeExtractURL\" ";     
$result = $db->query(utf8_decode($sql));
$db->close($link);
$result1 = mysql_fetch_row( $result);
return $result2 = $result1[0];
}

}//Fin de la classe extract

?>