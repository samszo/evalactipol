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
	$result_id_url_ttDepart = $this->SetUrl($baseUrlHtml,"Url de départ");
	$html = $this->cl_Output->call('file_get_html',$this->baseUrl."/wiki/Deputes_par_departement");
	$retours = $html->find('li a[title^=Deputes]');

//boucle sur les départements
	foreach($retours as $dept)
	{
		$urlDept = $dept->attr["href"];
		$url =$this->baseUrl.$urlDept;
		$htmlDept = $this->cl_Output->call('file_get_html',$url);
		$result_id_url_Depart = $this->SetUrl($url,"find('li a[title^=Deputes]')");
		//Extraction des noms des cantons
		//et insertion des cantons dans la table geoname 
		$infosCantons = $this->extract_canton ($htmlDept,$urlDept);
		//Extraction des infos sur les départements
		$infosDepartement = $this->extract_departement ($urlDept,$dept);
		//Insertion dans la table geoname
		
		//$id_geo_departement = $this->SetGeoname($infosDepartement[1],$infosDepartement[2],$infosDepartement[0],$infosCantons[3]);
		$id_geo_departement = $infosDepartement[3];
		$result_id_geo = $this->extract_id_geo ($infosDepartement[0]);
	
		foreach ($result_id_geo as $id_geo)
		{
			$result_exist_GeoUrl = $this->verif_exist_GeoUrl ($id_geo,$result_id_url_Depart);
			if ($result_exist_GeoUrl == NULL)
			{	         
				$this->insert_table_geo_url($id_geo,$result_id_url_Depart);
			}
		}

		$result_id_geoCanton = $this->extract_id_geoCanton ($infosDepartement[0],$infosCantons[4]);
												
		//extraction des liens des infos des députées

		$rsDept = $htmlDept->find('td a[href^=/wiki/]');

		//Boucle sur les députés
		$ids_deputes2 = ""; 
		foreach($rsDept as $depu)
		{
			$urlDepu = $depu->attr["href"]; 
			//vérifie qu'on traite un député
			$nom = substr($urlDepu,6,7);
			if($nom!="Deputes")
			{
				$urlDepute=$this->baseUrl.$urlDepu;
				$htmllienDepu = $this->cl_Output->call('file_get_html',$urlDepute);
				$result_id_url_Deput = $this->SetUrl($urlDepute,"find('td a[href^=/wiki/]')");
				//extraction des info du député
				$oDepute = new depute ($htmllienDepu,$depu,$result_id_url_Deput,$infosDepartement[0],$this->cl_Output,$this->site,$result_id_geoCanton);
				$id_deput = $oDepute->extrac_infos_depute ($infosCantons[7],$infosCantons[8]);
				$ids_deputes1= (string)$id_deput;
				$ids_deputes2= $ids_deputes2.",".$ids_deputes1;
				$ids_deputes = substr($ids_deputes2,1);
			}
		}
		$result_exist_depuGeoDepart = $this->verif_exist_deputGeo ($ids_deputes,$id_geo_departement);
		if ($result_exist_depuGeoDepart == NULL)
		{         
			$this->insert_table_deput_Geo($ids_deputes,$id_geo_departement);
		}
	}  
}

//function Getlist(){
        
		//echo $id;
		//echo ('id');
		
		//return $id;
	//}

//function extract_departement ($urlDept,$dept,$circonscDepart)
function extract_departement ($urlDept,$dept)
{
	$numDepart = substr($urlDept,14);
	//$numDepartDepute = (int)$numDepart;
	$numDepartDepute = $numDepart;   
	//Extraction du nom de département  
	$NomDepart = $dept->nodes;
	$ChaineNomDepart = implode(";", $NomDepart);
	$nomGeo_Depart = $this->extractBetweenDelimeters($ChaineNomDepart,""," ");
	$type_geoname = "Departement";
	
	//$id_geo_departement = extract::SetGeoname($nomGeo_Depart,$type_geoname,$numDepartDepute,$circonscDepart);
	//return array ($numDepartDepute,$nomGeo_Depart,$type_geoname,$id_geo_departement);
	return array ($numDepartDepute,$nomGeo_Depart,$type_geoname);
}

function extract_One_departement ($urlDept,$dept,$circonscDepart)
{	
	$numDepart = substr($urlDept,14);
	//$numDepartDepute = (int)$numDepart;
	$numDepartDepute = $numDepart;   
	//Extraction du nom de département  
	$NomDepart = $dept->nodes;
	$ChaineNomDepart = implode(";", $NomDepart);
	$nomGeo_Depart = $this->extractBetweenDelimeters($ChaineNomDepart,""," ");
	$type_geoname = "Departement";
	
	$id_geo_departement = extract::SetGeoname($nomGeo_Depart,$type_geoname,$numDepartDepute,$circonscDepart);
	//$id_geo_departement = extract::SetGeoname($nomGeo_Depart,$type_geoname,$numDepartDepute,'');
	return array ($numDepartDepute,$nomGeo_Depart,$type_geoname,$id_geo_departement,$circonscDepart);
	//return array ($numDepartDepute,$nomGeo_Depart,$type_geoname,$circonscDepart);
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
	$tabNomGeonameCantonsResult = array();
	$tabNomCantonsDepute = array();
	$tabNomCantonsDepute_nohtml = array();
	$tabCirconscDepute = array();
	
	foreach($rsCantons as $cantons)
	{
		$infosCantons = $cantons->children;
		$ChaineCantons = implode(":;:", $infosCantons);
		//Extraction des noms des cantons dans une chaine de caractères
		$nom_cantons = $this->extractBetweenDelimeters($ChaineCantons,"(cantons de ",")");
		$test1 = $this->extractBetweenDelimeters($ChaineCantons,":;:",":;:");
		
		$test2 = $this->extractBetweenDelimeters($test1,"title=","/a>");
		$nomPrenom_depute_cantons = trim($this->extractBetweenDelimeters($test2,">","<"));
		
		//Insertion des noms des cantons dans un tableau
		$tabNomGeonameCantons = explode (",",$nom_cantons);
	
		foreach ($tabNomGeonameCantons as $value1_1)
		{
			$tableau_caracts_html=get_html_translation_table(HTML_ENTITIES);
			$value1=strtr($value1_1,$tableau_caracts_html);
			$tabNomGeonameCantons1 [$value1] = $nomPrenom_depute_cantons;
			$tabNomGeonameCantons2 [$value1_1] = $nomPrenom_depute_cantons;
		}
		$tabNomCantonsDepute = array_merge ($tabNomCantonsDepute,$tabNomGeonameCantons1);
		$tabNomCantonsDepute_nohtml = array_merge ($tabNomCantonsDepute_nohtml,$tabNomGeonameCantons2);
		
		foreach ($tabNomGeonameCantons as $value)
		{
			//Préciser que le type de geoname d'un canton est canton
			// avant d'insérer le canton dans la table geoname
			$nom_geoname_canton = $value;
			$type_geoname_canton = "canton";
			//Extraction du numéro de circonscription du canton
			$circonscription_cantons = substr($ChaineCantons,5,1);
			
			//extract::SetGeoname($nom_geoname_canton,$type_geoname_canton,$numDepart_canton,$circonscription_cantons);
			$x = $x.",".$circonscription_cantons;
		}
	
		$tabNomGeonameCantonsResult = array_merge ($tabNomGeonameCantonsResult,$tabNomGeonameCantons);
	
		$tabCirconscDepute1 [$nomPrenom_depute_cantons] = $circonscription_cantons;
		$tabCirconscDepute = array_merge ($tabCirconscDepute,$tabCirconscDepute1);
	
	}
	//Les numéros de circonscriptions qui existent dans un département
	$circonscriptions_depart1 = substr($x,1);
	$circonscriptions_depart2 = explode (",",$circonscriptions_depart1);
	$circonscriptions_depart3 = array_unique ($circonscriptions_depart2);
	$circonscriptions_depart = implode(",", $circonscriptions_depart3);
	$type_geoname = "Canton";
//return array ($nom_cantons,$circonscription_cantons,$numDepart_canton,$circonscriptions_depart,$type_geoname,$tabNomGeonameCantons,$tabNomCantonsDepute);   
return array ($nom_cantons,$circonscription_cantons,$numDepart_canton,$circonscriptions_depart,$type_geoname,$tabNomGeonameCantonsResult,$tabNomCantonsDepute,$tabNomCantonsDepute_nohtml,$tabCirconscDepute);
}

//Fonction qui récupère une chaine inconnue entre deux chaines connues
function extractBetweenDelimeters($inputstr,$delimeterLeft,$delimeterRight)
{
	$posLeft  = stripos($inputstr,$delimeterLeft)+strlen($delimeterLeft);
	$posRight = stripos($inputstr,$delimeterRight,$posLeft+1);
	return  substr($inputstr,$posLeft,$posRight-$posLeft);
}

public function toASCII($ch) { 
	$tableau_caracts_html=get_html_translation_table(HTML_ENTITIES);
	$result=strtr($ch,$tableau_caracts_html);
	return $result;  
}
function SetUrl($valeurURL, $codeExtractURL)
{	
	$valeurURL = $this->toASCII($valeurURL);
	$codeExtractURL = $this->toASCII($codeExtractURL);
	
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db->connect();
	$sql = "DELETE FROM `urls` WHERE `valeur_url` =\"$valeurURL\" AND code_extract_URL=\"$codeExtractURL\" ";     
	$result = $db->query(utf8_decode($sql));
	$sql = "INSERT INTO `urls` ( `id_URL` , `valeur_url`, `code_extract_URL` ) VALUES ('', \"$valeurURL\", \"$codeExtractURL\")";     
	$result = $db->query(utf8_decode($sql));
	$id =  mysql_insert_id();
	$db->close();
	return $id;
}

function SetGeoname($nomGeo,$typeGeo,$numDepartgeo,$circonscGeo)
{	
	/*$nomGeo = $this->toASCII($nomGeo);
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);*/
	
	$nomGeo = extract::toASCII($nomGeo);
	$db=new mysql ('localhost','root','','evalactipol');
	
	$db->connect();
	$sql = "DELETE FROM `geoname` WHERE `nom_geoname` =\"$nomGeo\" AND `type_geoname`=\"$typeGeo\" ";     
	$result = $db->query(utf8_decode($sql));
	$sql = "INSERT INTO `geoname` ( `id_geoname` , `nom_geoname`, `type_geoname`, `num_depart_geoname`, `circonscriptions_geoname`, `lat_geoname`, `lng_geoname`, `alt_geoname`, `kml_geoname` ) VALUES ('', \"$nomGeo\", \"$typeGeo\", \"$numDepartgeo\", \"$circonscGeo\", '', '', '', '')";     
	$result = $db->query(utf8_decode($sql));
	$id =  mysql_insert_id();
	$db->close();
	return $id;
}

//function extract_id_geo ($nom_geo,$type_geo)
function extract_id_geo ($num_Depart_geo)
{
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$link=$db->connect();
	$sql = "SELECT `id_geoname` FROM `geoname` WHERE `num_depart_geoname`=\"$num_Depart_geo\" ";     
	$result = $db->query(utf8_decode($sql));
	$num = $db->num_rows($result);

	for ($i=0;$i<=$num-1;$i++)
	{
		$result1 = $db->fetch_row($result);
		$result2[$i] = $result1[0];  
	}  
	$db->close($link);
	return $result2;
}

function extract_id_geoCanton ($num_Depart_geo,$type_geo)
{
	//$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db=new mysql ('localhost','root','','evalactipol');
	$link=$db->connect();
	$sql = "SELECT `id_geoname` FROM `geoname` WHERE `num_depart_geoname`=\"$num_Depart_geo\" AND `type_geoname`=\"$type_geo\"  ";     
	$result = $db->query(utf8_decode($sql));
	$num = $db->num_rows($result);

	for ($i=0;$i<=$num-1;$i++)
	{
		$result1 = $db->fetch_row($result);
		$result2[$i] = $result1[0];  
	}  
	$db->close($link);
	return $result2;
}

function insert_table_depute_geo ($id_deput,$id_geo)
{
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$link=$db->connect();
	$sql = "INSERT INTO `depute-geo` ( `id_depute` , `id_geoname` ) VALUES (\"$id_deput\", \"$id_geo\")";     
	$result = $db->query(utf8_decode($sql));
	$db->close($link);
}

function insert_table_geo_url ($id_geo,$id_url)
{
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$link=$db->connect();
	$sql = "INSERT INTO `geo-url` ( `id_geoname` , `id_URL` ) VALUES (\"$id_geo\", \"$id_url\")";     
	$result = $db->query(utf8_decode($sql));
	$db->close($link);
}

public function verif_exist_GeoUrl ($id_Geo,$id_url)
{
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$link=$db->connect();
	$sql = "SELECT * FROM `geo-url` WHERE `id_geoname`=\"$id_Geo\" AND `id_URL`=\"$id_url\" ";     
	$result = $db->query(utf8_decode($sql));
	$db->close($link);
	return ($result1 = mysql_fetch_array( $result));
}

public function verif_exist_deputGeo ($id_deput,$id_Geo)
{
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$link=$db->connect();
	$sql = "SELECT * FROM `depute-geo` WHERE `id_depute`=\"$id_deput\" AND `id_geoname`=\"$id_Geo\" ";     
	$result = $db->query(utf8_decode($sql));
	$db->close($link);
	return ($result1 = mysql_fetch_array( $result));
}

public function insert_table_deput_Geo ($id_deput,$id_Geo)
{
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$link=$db->connect();
	$sql = "INSERT INTO `depute-geo` ( `id_depute` , `id_geoname` ) VALUES (\"$id_deput\", \"$id_Geo\")";     
	$result = $db->query(utf8_decode($sql));
	$db->close($link);
}

}//Fin de la classe extract

?>