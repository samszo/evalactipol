<?php
class GoogleVisualisation{
  public $id;
  public $trace;
  private $site;
 
    function __tostring() {
    return "Cette classe permet la création dynamique d'objet XUL.<br/>";
    }

    function __construct($site, $id=-1, $complet=true) {
	
  	$this->trace = TRACE;
	$this->site = $site;
    $this->id = $id;
	
	}
	
	function GetData()
	{
		
	$Data = "var data = new google.visualization.DataTable();";
	$Data .= "data.addRows(12);";

	$Data .= "data.addColumn('string', 'Depute');";
	$Data .= "data.addColumn('date', 'Date');";
	$Data .= "data.addColumn('number', 'Questions');";
	$Data .= "data.addColumn('number', 'Mots-Clefs');";
	$Data .= "data.addColumn('string', 'Location');";
	
	
	$num_departement = "01";
	$infos_Departement = $this->GetDepartement ($num_departement);
	$infos_Deputes = $this->GetDepute ($num_departement);
	$numColonne = 0;
	foreach ($infos_Deputes as $depute)
	{	
		
		$type = 'PlageDate1';
		
		$Xpath = "/XmlParams/XmlParam/dates/date[@fonction='GetDate_".$type."']";
		$Q = $this->site->XmlParam->GetElements($Xpath);
		
		$NomPrenomDepute = html_entity_decode($depute[1])." ".html_entity_decode($depute[2]);
		$nbQuestionsMC = $this->GetNbQuestionsMC ($depute[0],$Q[0]->date1."",$Q[0]->date2."");
		$Data .= 'data.setValue('.$numColonne.', 0, "'.$NomPrenomDepute.'");';
		$Data .= 'data.setValue('.$numColonne.', 1, new Date ('.$Q[0]->LimiteDate."".'));';
		$Data .= 'data.setValue('.$numColonne.', 2, '.$nbQuestionsMC[0].');';
		$Data .= 'data.setValue('.$numColonne.', 3, '.$nbQuestionsMC[1].');';
		$Data .= 'data.setValue('.$numColonne.', 4, "'.$infos_Departement[1].'");';
		$numColonne++;
		
		$nbQuestionsMC1 = $this->GetNbQuestionsMC1 ($depute[0]);
		$Data .= 'data.setValue('.$numColonne.', 0, "'.$NomPrenomDepute.'");';
		$Data .= 'data.setValue('.$numColonne.', 1, new Date (2009,0,1));';
		$Data .= 'data.setValue('.$numColonne.', 2, '.$nbQuestionsMC1[0].');';
		$Data .= 'data.setValue('.$numColonne.', 3, '.$nbQuestionsMC1[1].');';
		$Data .= 'data.setValue('.$numColonne.', 4, "'.$infos_Departement[1].'");';
		$numColonne++;
		
		$nbQuestionsMC2 = $this->GetNbQuestionsMC2 ($depute[0]);
		$Data .= 'data.setValue('.$numColonne.', 0, "'.$NomPrenomDepute.'");';
		$Data .= 'data.setValue('.$numColonne.', 1, new Date (2009,4,1));';
		$Data .= 'data.setValue('.$numColonne.', 2, '.$nbQuestionsMC2[0].');';
		$Data .= 'data.setValue('.$numColonne.', 3, '.$nbQuestionsMC2[1].');';
		$Data .= 'data.setValue('.$numColonne.', 4, "'.$infos_Departement[1].'");';
		$numColonne++;
	}
	
	return $Data;
	}
	
	function GetDataChildren($type,$depute,$numColonne)
	{
		$Xpath = "/XmlParams/XmlParam/dates/date[@fonction='GetDate_".$type."']";
		$Q = $this->site->XmlParam->GetElements($Xpath);
		
		$NomPrenomDepute = html_entity_decode($depute[1])." ".html_entity_decode($depute[2]);
		$nbQuestionsMC = $this->GetNbQuestionsMC ($depute[0],$Q[0]->date1."",$Q[0]->date2."");
		
		$Data = 'data.setValue('.$numColonne.', 0, "'.$NomPrenomDepute.'");';
		$Data .= 'data.setValue('.$numColonne.', 1, new Date ('.$Q[0]->LimiteDate."".'));';
		$Data .= 'data.setValue('.$numColonne.', 2, '.$nbQuestionsMC[0].');';
		$Data .= 'data.setValue('.$numColonne.', 3, '.$nbQuestionsMC[1].');';
		$Data .= 'data.setValue('.$numColonne.', 4, "'.$infos_Departement[1].'");';
		$numColonne++;
	}
	
	function GetJson()
	{
		$json = "google.visualization.Query.setResponse({version:'0.5',reqId:'0',status:'ok',sig:'6700864051796921914',";
		$json .= "table:{cols:[";
		$json .= "{id:'A',label:'Release Date',type:'date',pattern:'M/d/yyyy'},";
		
		$json .= "{id:'1',label:'nb questions Xavier Breton',type:'number',pattern:'#0.###############'},";
		$json .= "{id:'1',label:'Xavier Breton',type:'string',pattern:''},";
		
		$json .= "{id:'F',label:'nb questionB',type:'number',pattern:'#0.###############'},";
		$json .= "{id:'G',label:'Nom Depute',type:'string',pattern:''}],";
		
		$json .= "rows:[{c:[{v:new Date(2008,10,1),f:'10/1/2008'},{v:10,f:'10'},{v:'Xavier Breton'},{v:15,f:'15'},{v:'Xavier Bertran'}]},{c:[{v:new Date(2008,11,1),f:'11/1/2008'},{v:13,f:'13'},,{v:23,f:'23'}]},{c:[{v:new Date(2008,12,1),f:'12/1/2008'},{v:11,f:'11'},,{v:31,f:'31'}]},{c:[{v:new Date(2009,1,1),f:'1/1/2009'},{v:8,f:'8'},,{v:18,f:'18'}]},{c:[{v:new Date(2009,2,1),f:'2/1/2009'},{v:18,f:'18'},,{v:8,f:'8'}]},{c:[{v:new Date(2009,3,1),f:'3/1/2009'},{v:2,f:'2'},,{v:12,f:'12'}]},{c:[{v:new Date(2009,4,1),f:'4/1/2009'},{v:22,f:'22'},,{v:20,f:'20'}]}]}});";
	
	
	return $json;
	}

function GetDepute($num_departement)
{	
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db->connect();
	$sql = "SELECT * FROM `depute` WHERE `num_depart_depute`=\"$num_departement\" ";     
	$result = $db->query(utf8_decode($sql));
	//$db->close();
	//return ($result1 = mysql_fetch_row( $result));
	
	$num1 = $db->num_rows($result);
	$result2 = NULL;
	for ($i=0;$i<=$num1-1;$i++)
	{
		$result1 = $db->fetch_row($result);
		//$sql = "SELECT valeur_rubrique FROM `rubrique` WHERE `id_rubrique`=\"$result1[0]\" ";     
		//$result2 = $db->query(utf8_decode($sql));
		//$result3 = $db->fetch_row($result2);
		$result2[$i] = $result1;
	}
	$db->close();
	return $result2;
}

function GetDepartement($num_departement)
{	
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db->connect();
	$sql = "SELECT * FROM `geoname` WHERE `num_depart_geoname`=\"$num_departement\" AND `type_geoname` = \"Departement\"  ";     
	$result = $db->query(utf8_decode($sql));
	$db->close();
	return ($result1 = mysql_fetch_row( $result));
	
	//$result1 = $db->fetch_row($result);
	//$db->close();
	//return $result2;
}
/*function GetNbQuestionsMC($id_depute)
{	
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db->connect();
	
	$sql = "SELECT * FROM `questions` WHERE `id_depute`=\"$id_depute\" AND `date_publication`BETWEEN \"2007-01-02\" AND \"2008-01-01\"  ";     
	$result = $db->query(utf8_decode($sql));
	$num1 = $db->num_rows($result);
	$num3 = 0;
	for ($i=0;$i<=$num1-1;$i++)
	{
		$result1 = $db->fetch_row($result);
		$sql = "SELECT * FROM `quest-mc` WHERE `id_question`=\"$result1[0]\" ";     
		$result2 = $db->query(utf8_decode($sql));
		$num2 = $db->num_rows($result2);
		$num3 = $num3+$num2;
	}
	
	$db->close();
	return array ($num1,$num3);
}*/

function GetNbQuestionsMC($id_depute,$date1,$date2)
{	
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db->connect();
	
	$sql = "SELECT * FROM `questions` WHERE `id_depute`=\"$id_depute\" AND `date_publication`BETWEEN \"$date1\" AND \"$date2\"  ";     
	$result = $db->query(utf8_decode($sql));
	$num1 = $db->num_rows($result);
	$num3 = 0;
	for ($i=0;$i<=$num1-1;$i++)
	{
		$result1 = $db->fetch_row($result);
		$sql = "SELECT * FROM `quest-mc` WHERE `id_question`=\"$result1[0]\" ";     
		$result2 = $db->query(utf8_decode($sql));
		$num2 = $db->num_rows($result2);
		$num3 = $num3+$num2;
	}
	
	$db->close();
	return array ($num1,$num3);
}

function GetNbQuestionsMC1($id_depute)
{	
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db->connect();
	//$sql = "SELECT * FROM `questions` WHERE `id_depute`=\"$id_depute\" ";
	$sql = "SELECT * FROM `questions` WHERE `id_depute`=\"$id_depute\" AND `date_publication`BETWEEN \"2008-01-02\" AND \"2009-01-01\" ";     
	$result = $db->query(utf8_decode($sql));
	//$db->close();
	//return ($result1 = mysql_fetch_row( $result));
	
	$num1 = $db->num_rows($result);
	$num3 = 0;
	//$result2 = NULL;
	for ($i=0;$i<=$num1-1;$i++)
	{
		$result1 = $db->fetch_row($result);
		
		$sql = "SELECT * FROM `quest-mc` WHERE `id_question`=\"$result1[0]\" ";     
		$result2 = $db->query(utf8_decode($sql));
		$num2 = $db->num_rows($result2);
		$num3 = $num3+$num2;
		//$result3 = $db->fetch_row($result2);
		//$result2[$i] = $result1;
	}
	
	$db->close();
	return array ($num1,$num3);
}
function GetNbQuestionsMC2($id_depute)
{	
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db->connect();
	//$sql = "SELECT * FROM `questions` WHERE `id_depute`=\"$id_depute\" ";
	$sql = "SELECT * FROM `questions` WHERE `id_depute`=\"$id_depute\" AND `date_publication`BETWEEN \"2009-01-02\" AND \"2009-05-01\" ";     
	$result = $db->query(utf8_decode($sql));
	//$db->close();
	//return ($result1 = mysql_fetch_row( $result));
	
	$num1 = $db->num_rows($result);
	$num3 = 0;
	//$result2 = NULL;
	for ($i=0;$i<=$num1-1;$i++)
	{
		$result1 = $db->fetch_row($result);
		
		$sql = "SELECT * FROM `quest-mc` WHERE `id_question`=\"$result1[0]\" ";     
		$result2 = $db->query(utf8_decode($sql));
		$num2 = $db->num_rows($result2);
		$num3 = $num3+$num2;
		//$result3 = $db->fetch_row($result2);
		//$result2[$i] = $result1;
	}
	
	$db->close();
	return array ($num1,$num3);
}


function GetNbMotsClefs($id_depute)
{	
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db->connect();
	$sql = "SELECT * FROM `depute-mc` WHERE `id_depute`=\"$id_depute\" ";     
	$result = $db->query(utf8_decode($sql));
	//$db->close();
	//return ($result1 = mysql_fetch_row( $result));
	
	$num1 = $db->num_rows($result);
	
	/*$result2 = NULL;
	for ($i=0;$i<=$num1-1;$i++)
	{
		$result1 = $db->fetch_row($result);
		$result2[$i] = $result1;
	}*/
	$db->close();
	return $num1;
	
}
}	
?>