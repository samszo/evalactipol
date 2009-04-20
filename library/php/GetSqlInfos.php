<?php
class GetSqlInfos{
  
  private $site;
 
    function __tostring() {
    return "Cette classe permet d'extraire les informations de la base de données.<br/>";
    }

    function __construct($site) {
	
	$this->site = $site;
	}
	
function GetSqlDepute($num_departement)
{	
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db->connect();
	$sql = "SELECT * FROM `depute` WHERE `num_depart_depute`=\"$num_departement\" ";     
	$result = $db->query(utf8_decode($sql));
	
	$num1 = $db->num_rows($result);
	$result2 = NULL;
	for ($i=0;$i<=$num1-1;$i++)
	{
		$result1 = $db->fetch_row($result);
		$result2[$i] = $result1;
	}
	$db->close();
	return $result2;
}

function GetSqlDepartement($num_departement)
{	
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db->connect();
	$sql = "SELECT * FROM `geoname` WHERE `num_depart_geoname`=\"$num_departement\" AND `type_geoname` = \"Departement\"  ";     
	$result = $db->query(utf8_decode($sql));
	$db->close();
	return ($result1 = mysql_fetch_row( $result));

}

function GetSqlNbQuestionsMC($id_depute,$date1,$date2)
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

function GetDepute($id)
{	
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db->connect();
	$sql = "SELECT * FROM `depute` WHERE `id_depute`=\"$id\" ";     
	$result = $db->query(utf8_decode($sql));
	$db->close();
	return ($result1 = mysql_fetch_row( $result));
}

function GetGeoname($num_depart)
{	
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db->connect();
	$sql = "SELECT * FROM `geoname` WHERE `num_depart_geoname`=\"$num_depart\" ";     
	$result = $db->query(utf8_decode($sql));
	$db->close();
	return ($result1 = mysql_fetch_row( $result));
}

function GetQuestsDepute($num)
{	
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db->connect();
	
	$sql = "SELECT num_question FROM `questions` WHERE `id_depute`=\"$num\" ";     
	$result = $db->query(utf8_decode($sql));
	$num1 = $db->num_rows($result);
	$result3 = NULL;
	for ($i=0;$i<=$num1-1;$i++)
	{
		$result2 = $db->fetch_row($result);
		$result3[$i] = $result2[0];
	}
	$db->close();
	return $result3;
	
}
function GetMCDepute($num)
{	
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db->connect();
	$sql = "SELECT id_motclef FROM `depute-mc` WHERE `id_depute`=\"$num\" ";     
	$result = $db->query(utf8_decode($sql));
	
	$num1 = $db->num_rows($result);
	$result4 = NULL;
	for ($i=0;$i<=$num1-1;$i++)
	{
		$result1 = $db->fetch_row($result);
		$sql = "SELECT valeur_motclef FROM `mot-clef` WHERE `id_motclef`=\"$result1[0]\" ";     
		$result2 = $db->query(utf8_decode($sql));
		$result3 = $db->fetch_row($result2);
		$result4[$i] = $result3[0];
	}
	$db->close();
	return $result4;
}

function GetRubDepute($num)
{	
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db->connect();
	
	$sql = "SELECT id_rubrique FROM `depute-rubr` WHERE `id_depute`=\"$num\" ";     
	$result = $db->query(utf8_decode($sql));
	
	$num1 = $db->num_rows($result);
	$result4 = NULL;
	for ($i=0;$i<=$num1-1;$i++)
	{
		$result1 = $db->fetch_row($result);
		$sql = "SELECT valeur_rubrique FROM `rubrique` WHERE `id_rubrique`=\"$result1[0]\" ";     
		$result2 = $db->query(utf8_decode($sql));
		$result3 = $db->fetch_row($result2);
		$result4[$i] = $result3[0];
	}
	$db->close();
	return $result4;
}

}	
?>