<?php

class depute {

public $NomDepute;
public $PrenomDepute;
public $mailDepute;
public $numPhoneDepute;
public $lienANDepute;
public $NomPrenonDepute;
public $circonscDepute;

public $url_depute;
public $url_html_depute;
public $id_url_depute;
public $cl_Output_depute;
public $site;
public $nums_geoname;

//définition du constructeur 

public function __construct ($htmllienDepu,$depu,$result_id_url_Deput,$numDepartDepute,$cl_Output_depute,$site,$result_id_geoCanton) 
{
	$this->url_depute = $htmllienDepu;
	$this->url_html_depute = $depu;
	$this->id_url_depute = $result_id_url_Deput;
	$this->num_depart_depute = $numDepartDepute;
	$this->cl_Output_depute = $cl_Output_depute;
	$this->site = $site;
	$this->nums_geoname = $result_id_geoCanton;
}
public function recup_lien_questions ($urldepute)
{
	$rslienQuest = $urldepute->find('li a[href$=Questions]');
	return $rslienQuest[0];
}

public function recup_nom_deput ($urlhtml)
{
	$NomPrenom = $urlhtml->nodes;
	$ChaineNomPrenom = implode(";", $NomPrenom);
	$NomDepute = $this->extractBetweenDelimeters($ChaineNomPrenom,""," ");
	return $NomDepute;
}

public function recup_prenom_deput ($urlhtml)
{
	$NomPrenom = $urlhtml->nodes;
	$ChaineNomPrenom = implode(";", $NomPrenom);
	$NomDepute = $this->extractBetweenDelimeters($ChaineNomPrenom,""," ");
	$pos = strpos ($ChaineNomPrenom," ");
	$PrenomDepute = substr($ChaineNomPrenom,$pos+1);
	return $PrenomDepute;
}

public function recup_lien_AN_deput ($urldepute)
{
	$rslienLienANDepute = $urldepute->find('li a[title^=http://www.assemblee-nationale.fr]');
	foreach($rslienLienANDepute as $lienANValue)
	{
		$lienANDepute = $lienANValue->attr["href"];
		$this->SetUrl($lienANDepute,"find('li a[title^=http://www.assemblee-nationale.fr]')");
	}
	return $lienANDepute; 
}

public function recup_mail_deput ($urldepute)
{
	$rsMailDepute = $urldepute->find('li a[title^=mailto]');
	$mailDepute2 = "";

	foreach($rsMailDepute as $mail)
	{
		$mailValue = trim ($mail->attr["href"]);
		$mailDepute1 = substr($mailValue,7);
		$mailDepute2 = $mailDepute2.",".$mailDepute1;   
	}
	$mailDepute = substr($mailDepute2,1);      
	return $mailDepute;
}

public function recup_Phone_deput ($urldepute)
{
	$rsNumPhoneDepute = $urldepute->find('li a[title^=callto]');
	$numPhoneDepute2_3 = "";
            
	foreach($rsNumPhoneDepute as $numPhone)
	{
		$numPhoneValue2 = $numPhone->attr["href"];
		$numPhoneDepute2_1 = substr($numPhoneValue2,9);
		$numPhoneDepute2_2 = str_replace("+", "00", $numPhoneDepute2_1);
		$numPhoneDepute2_3 = $numPhoneDepute2_3.",".$numPhoneDepute2_2;
	}
	$numPhoneDepute = substr($numPhoneDepute2_3,1);
	return $numPhoneDepute;
}

public function extract_contenu_lienQuest ($quest)
{
	$urlQuestion = $quest->attr["href"];
	$urlQuestionResult = str_replace("&amp;", "&", $urlQuestion);
	return $urlQuestionResult;
}

public function extract_numlegis_question ($lienQuest)
{
	//Extraction des informations sur une question, les mots clés et les  rubriques
	$numLegislature1 = $this->extractBetweenDelimeters($lienQuest,".fr/q","/");
	$numLegislature = (int)$numLegislature1;
	return $numLegislature;
}

public function extract_num_question ($lienQuest,$numLegislature)
{
	$numQuestion1 = $this->extractBetweenDelimeters($lienQuest,$numLegislature."-","Q");
	$numQuestion = (int)$numQuestion1;
	return $numQuestion;
}

public function extract_tabRubr_question ($NewChaine)
{             

	$rubrique = $this->extractBetweenDelimeters($NewChaine,"Rubrique :","<br>");
	$tab_rubrique = explode (",",$rubrique);
	return $tab_rubrique;
}

public function extract_tabMC_question ($NewChaine)
{
	$motclef = $this->extractBetweenDelimeters($NewChaine,"Mots clés :","</td>");
	$tab_motclef = explode (".",$motclef);            
	return $tab_motclef;
}

public function extract_datePubli_question ($NewChaine)
{           
	$motclef = $this->extractBetweenDelimeters($NewChaine,"Mots clés :","</td>");
	$chemindatePubliQuestion = $this->extractBetweenDelimeters($NewChaine,"$motclef","</td>;<td"); 
	$datePubliQuestion1 = substr($chemindatePubliQuestion,31);
	$datePubliQuestion2 = trim($datePubliQuestion1);
	$datePubliQuestion = $this->convertToDateFormat($datePubliQuestion2);
	return $datePubliQuestion;
}

public function extract_dateRep_question ($NewChaine)
{
	$motclef = $this->extractBetweenDelimeters($NewChaine,"Mots clés :","</td>");	    
	$chemindatePubliQuestion = $this->extractBetweenDelimeters($NewChaine,"$motclef","</td>;<td");
	$datePubliQuestion1 = substr($chemindatePubliQuestion,31);            

	$dateRepQuestion1 = $this->extractBetweenDelimeters($NewChaine,"$datePubliQuestion1</td>;<td class='TexteColonne'>","</td>");
	$dateRepQuestion2 = trim($dateRepQuestion1);
	$dateRepQuestion = $this->convertToDateFormat($dateRepQuestion2);
	return $dateRepQuestion;

}
public function recup_circonsc_deput ($tabCirconscDepute,$NomPrenonDepute)
{
	$circonsc_deput = $tabCirconscDepute[$NomPrenonDepute];
	return $circonsc_deput;

}

public function extrac_infos_depute ($infosCantonsDepute,$tabCirconscDepute)
{
	$rslienQuest = $this->recup_lien_questions($this->url_depute);
	$this->NomDepute = $this->recup_nom_deput ($this->url_html_depute);
	$this->PrenomDepute = $this->recup_prenom_deput ($this->url_html_depute);
	$this->mailDepute = $this->recup_mail_deput ($this->url_depute);
	$this->numPhoneDepute = $this->recup_Phone_deput ($this->url_depute);
	$this->lienANDepute = $this->recup_lien_AN_deput ($this->url_depute);
	$NomPrenonDepute = trim($this->NomDepute." ".$this->PrenomDepute);
	$this->circonscDepute = $this->recup_circonsc_deput ($tabCirconscDepute,$NomPrenonDepute);

	//$result_id_deput = $this->SetDepute1($this->NomDepute,$this->PrenomDepute,$this->mailDepute,$this->numPhoneDepute,$this->lienANDepute,$this->num_depart_depute);
	$result_id_deput = $this->SetDepute($this->NomDepute,$this->PrenomDepute,$this->mailDepute,$this->numPhoneDepute,$this->lienANDepute,$this->num_depart_depute,$this->circonscDepute);
	
	
	/*$result_exist_depuUrl = $this->verif_exist_deputUrl ($result_id_deput,$this->id_url_depute);
	if ($result_exist_depuUrl == NULL)
	{         
		$this->insert_table_depute_url($result_id_deput,$this->id_url_depute);
	}*/
	
	
	//$tab_ids_catons_depute = $this->ids_catons_depute ($infosCantonsDepute,$NomPrenonDepute);
	$tab_noms_catons_depute = $this->noms_catons_depute ($infosCantonsDepute,$NomPrenonDepute);
	
	
	/*foreach ($tab_ids_catons_depute as $id_geo)
	{
		$result_exist_depuGeo = $this->verif_exist_deputGeo ($result_id_deput,$id_geo);
			if ($result_exist_depuGeo == NULL)
			{         
				$this->insert_table_deput_Geo($result_id_deput,$id_geo);
			}
	}*/

	//$this->insert_infos_tous_questions ($rslienQuest,$result_id_deput);
	
	return array ($result_id_deput,$NomPrenonDepute,$tab_noms_catons_depute,$this->num_depart_depute,$this->circonscDepute);
	
}

public function ids_catons_depute ($infosCantonsDepute,$NomPrenonDepute)
{
	$Result_id_geo1 = "";
	foreach ($this->nums_geoname as $id_geo1)
	{
		$ResultnameGeo = $this->extract_name_geo ($id_geo1);
			foreach ($ResultnameGeo as $nameGeo)
			{	
				if ($infosCantonsDepute [$nameGeo] == $NomPrenonDepute)
				{
				$Result_id_geo1 = $Result_id_geo1.";".$id_geo1;
				}
			}
	}
	
	$Result_id_geo2 = substr($Result_id_geo1,1);
	$Result_id_geo3 = explode(";", $Result_id_geo2);
	
	return $Result_id_geo3;

}

public function noms_catons_depute ($infosCantonsDepute,$NomPrenonDepute)
{
	$tab_noms_catons_depute1 = "";
	foreach ($infosCantonsDepute as $canton => $value)
	{	
		if ($infosCantonsDepute [$canton] == $NomPrenonDepute)
		{
		$tab_noms_catons_depute1 = $tab_noms_catons_depute1.";".$canton;
		}
	}
	$tab_noms_catons_depute2 = substr($tab_noms_catons_depute1,1);
	$tab_noms_catons_depute = explode(";", $tab_noms_catons_depute2);
	
return $tab_noms_catons_depute;
}

public function insert_infos_tous_questions ($rslienQuest,$result_id_deput)
{
	$urlQuestionResult = $this->extract_contenu_lienQuest ($rslienQuest);
	$htmlLienQuestion = $this->cl_Output_depute->call('file_get_html',$urlQuestionResult);         
	$result_id_url_Questions = $this->SetUrl($urlQuestionResult,"find('li a[href$=Questions]')");
	$rsQuest = $htmlLienQuestion->find('tbody tr[valign=top]');
	$rsQuest1 = array_shift($rsQuest);
	
	foreach($rsQuest as $info)
	{
		$infosChildren = $info->children;
		$Chaine = implode(";", $infosChildren);
		$NewChaine = str_replace("", "é", $Chaine);
		$lienQuest = $this->extractBetweenDelimeters($NewChaine,"href=","class");
		$this->insert_infos_question ($lienQuest,$NewChaine,$result_id_deput,$result_id_url_Questions);

	}
}
public function result_ids_deputes ($id_deput)
{
	$result_ids_deputs1 = "";
	$result_ids_deputs1 = $result_ids_deputs1."".$id_deput;
	$result_ids_deputs = substr ($result_ids_deputs1,1);
	return $result_ids_deputs;

}

public function insert_infos_question ($lienQuest,$NewChaine,$result_id_deput,$result_id_url_Questions)
{
	$numLegislature = $this->extract_numlegis_question ($lienQuest);
	$numQuestion = $this->extract_num_question ($lienQuest,$numLegislature);
	$tab_rubrique = $this->extract_tabRubr_question ($NewChaine);
	$tab_motclef = $this->extract_tabMC_question ($NewChaine);
	$datePubliQuestion = $this->extract_datePubli_question ($NewChaine);
	$dateRepQuestion = $this->extract_dateRep_question ($NewChaine);

	$result_id_question = $this->SetQuestion($numQuestion,$datePubliQuestion,$dateRepQuestion,$numLegislature,$result_id_deput,$result_id_url_Questions);
            	
	foreach ($tab_motclef as $mot_clef)
	{
		$result_exist_mc = $this->verif_exist_mc ($mot_clef);
		if ($result_exist_mc == NULL)
		{
			$result_id_mc = $this->SetMotClef($mot_clef);
		}  
		else
		{
			$result_id_mc = $this->extract_id_mc ($mot_clef);		
		}
		
		$result_exist_deputMC = $this->verif_exist_deptMC ($result_id_deput,$result_id_mc);
		$result_exist_questMC = $this->verif_exist_questMC ($result_id_question,$result_id_mc);	
		if ($result_exist_deputMC == NULL)
		{  
			$this->insert_table_depute_mc ($result_id_deput,$result_id_mc);
		}

		if ($result_exist_questMC == NULL)
		{  
			$this->insert_table_quest_mc ($result_id_question,$result_id_mc); 
		}
			  
	}

	foreach ($tab_rubrique as $rubrique)
	{
		$result_exist_rubrique = $this->verif_exist_rubrique ($rubrique);
		if ($result_exist_rubrique == NULL)
		{
			$result_id_rubrique = $this->SetRubrique($rubrique);
		}
		else
		{
			$result_id_rubrique = $this->extract_id_rubrique ($rubrique);
		}
		$result_exist_deputRubr = $this->verif_exist_deptRubr ($result_id_deput,$result_id_rubrique);
		$result_exist_questRubr = $this->verif_exist_questRubr ($result_id_question,$result_id_rubrique);	
		if ($result_exist_deputRubr == NULL)
		{
			$this->insert_table_depute_rubr ($result_id_deput,$result_id_rubrique); 
		}
		if ($result_exist_questRubr == NULL)
		{  
			$this->insert_table_quest_rubr ($result_id_question,$result_id_rubrique);
		}
	}  
}

public function extractBetweenDelimeters($inputstr,$delimeterLeft,$delimeterRight) {
	$posLeft  = stripos($inputstr,$delimeterLeft)+strlen($delimeterLeft);
	$posRight = stripos($inputstr,$delimeterRight,$posLeft+1);
	return  substr($inputstr,$posLeft,$posRight-$posLeft);
}

//Fonction qui convertie une chaine en format date
public function convertToDateFormat ($inputStr)
{
	$jour = substr($inputStr, 0, 2);
	$mois = substr($inputStr, 3, 2);
	$annee = substr($inputStr, 6, 4);
	$result = $annee . '-' . $mois . '-' . $jour;
	return $result;
}

public function toASCII($ch) { 
	$tableau_caracts_html=get_html_translation_table(HTML_ENTITIES);
	$result=strtr($ch,$tableau_caracts_html);
	return $result;  
}

/*function SetDepute($nom,$prenom,$mail,$numphone,$lien_AN_deput,$num_depart,$circonscDepute)
{	
	$nom = $this->toASCII($nom);
	$prenom = $this->toASCII($prenom);
	$mail = $this->toASCII($mail);
	$lien_AN_deput = $this->toASCII($lien_AN_deput);
	
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db->connect();
	$sql = "DELETE FROM `depute` WHERE `nom_depute`=\"$nom\" AND `prenom_depute`=\"$prenom\" AND `lien_AN_depute`=\"$lien_AN_deput\" ";     
	$result = $db->query(utf8_decode($sql));
	$sql = "INSERT INTO `depute` ( `id_depute` , `nom_depute` , `prenom_depute` , `mail_depute` , `numphone_depute` , `lien_AN_depute` , `num_depart_depute` , `circonsc_depute` ) VALUES ('', \"$nom\", \"$prenom\", \"$mail\", \"$numphone\", \"$lien_AN_deput\", \"$num_depart\", \"$circonscDepute\" )";
	$result = $db->query(utf8_decode($sql));
	$id =  mysql_insert_id();
	$db->close();
	return $id;
}*/
function SetDepute($nom,$prenom,$mail,$numphone,$lien_AN_deput,$num_depart,$circonscDepute)
{	
	$nom = $this->toASCII($nom);
	$prenom = $this->toASCII($prenom);
	$mail = $this->toASCII($mail);
	$lien_AN_deput = $this->toASCII($lien_AN_deput);
	
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db->connect();
	
	$sql = "SELECT * FROM `depute` WHERE `nom_depute`=\"$nom\" AND `prenom_depute`=\"$prenom\" AND `lien_AN_depute`=\"$lien_AN_deput\" ";     
	
	$result = $db->query(utf8_decode($sql));
	$result1 = mysql_fetch_row( $result);
	//$db->close();
	if ($result1 == NULL)
	{
	$sql = "INSERT INTO `depute` ( `id_depute` , `nom_depute` , `prenom_depute` , `mail_depute` , `numphone_depute` , `lien_AN_depute` , `num_depart_depute` , `circonsc_depute` ) VALUES ('', \"$nom\", \"$prenom\", \"$mail\", \"$numphone\", \"$lien_AN_deput\", \"$num_depart\", \"$circonscDepute\" )";
	$result2 = $db->query(utf8_decode($sql));
	$id =  mysql_insert_id();
	//$db->close();
	//return $id;
	}
	else
	{
	$id = $result1[0]; 
	}
	$db->close();
	return $id;
}

function GetDepute($id)
{	
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db->connect();
	$sql = "SELECT * FROM `depute` WHERE `id_depute`=\"$id\" ";     
	$result = $db->query(utf8_decode($sql));
	//$id =  mysql_insert_id();
	$db->close();
	return $result;
}
/*function SetDepute1($nom,$prenom,$mail,$numphone,$lien_AN_deput,$num_depart)
{	
	$nom = $this->toASCII($nom);
	$prenom = $this->toASCII($prenom);
	$mail = $this->toASCII($mail);
	$lien_AN_deput = $this->toASCII($lien_AN_deput);
	
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db->connect();
	$sql = "DELETE FROM `depute` WHERE `nom_depute`=\"$nom\" AND `prenom_depute`=\"$prenom\" AND `lien_AN_depute`=\"$lien_AN_deput\" ";     
	$result = $db->query(utf8_decode($sql));
	$sql = "INSERT INTO `depute` ( `id_depute` , `nom_depute` , `prenom_depute` , `mail_depute` , `numphone_depute` , `lien_AN_depute` , `num_depart_depute` , `circonsc_depute` ) VALUES ('', \"$nom\", \"$prenom\", \"$mail\", \"$numphone\", \"$lien_AN_deput\", \"$num_depart\", '' )";
	$result = $db->query(utf8_decode($sql));
	$id =  mysql_insert_id();
	$db->close();
	return $id;
}*/
	
function SetDepute1($nom,$prenom,$mail,$numphone,$lien_AN_deput,$num_depart)
{	
	$nom = $this->toASCII($nom);
	$prenom = $this->toASCII($prenom);
	$mail = $this->toASCII($mail);
	$lien_AN_deput = $this->toASCII($lien_AN_deput);
	
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db->connect();
	
	$sql = "SELECT * FROM `depute` WHERE `nom_depute`=\"$nom\" AND `prenom_depute`=\"$prenom\" AND `lien_AN_depute`=\"$lien_AN_deput\" ";     
	
	$result = $db->query(utf8_decode($sql));
	$result1 = mysql_fetch_row( $result);
	//$db->close();
	if ($result1 == NULL)
	{
	$sql = "INSERT INTO `depute` ( `id_depute` , `nom_depute` , `prenom_depute` , `mail_depute` , `numphone_depute` , `lien_AN_depute` , `num_depart_depute` , `circonsc_depute` ) VALUES ('', \"$nom\", \"$prenom\", \"$mail\", \"$numphone\", \"$lien_AN_deput\", \"$num_depart\", \"$circonscDepute\" )";
	$result2 = $db->query(utf8_decode($sql));
	$id =  mysql_insert_id();
	//$db->close();
	//return $id;
	}
	else
	{
	$id = $result1[0]; 
	}
	$db->close();
	return $id;
}


/*function SetUrl($valeurURL, $codeExtractURL)
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
}*/

function SetUrl($valeurURL, $codeExtractURL)
{	
	$valeurURL = $this->toASCII($valeurURL);
	$codeExtractURL = $this->toASCII($codeExtractURL);
	
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db->connect();
	
	$sql = "SELECT * FROM `urls` WHERE `valeur_url` =\"$valeurURL\" AND code_extract_URL=\"$codeExtractURL\" ";     
	
	$result = $db->query(utf8_decode($sql));
	$result1 = mysql_fetch_row( $result);
	//$db->close();
	if ($result1 == NULL)
	{
	$sql = "INSERT INTO `urls` ( `id_URL` , `valeur_url`, `code_extract_URL` ) VALUES ('', \"$valeurURL\", \"$codeExtractURL\")";     
	$result2 = $db->query(utf8_decode($sql));
	$id =  mysql_insert_id();
	//$db->close();
	//return $id;
	}
	else
	{
	$id = $result1[0]; 
	}
	$db->close();
	return $id;
	
}

/*function SetQuestion($num_question,$date_publication,$date_reponse,$num_legislature,$id_deput,$id_url)
{
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db->connect();
	$sql = "DELETE FROM `questions` WHERE `num_question`=\"$num_question\" AND `date_publication`=\"$date_publication\" ";     
	$result = $db->query(utf8_decode($sql));
	$sql = "INSERT INTO `questions` ( `id_question` , `num_question` , `date_publication` , `date_reponse` , `num_legislature` , `id_depute`, `id_URL` ) VALUES ('', \"$num_question\", \"$date_publication\", \"$date_reponse\", \"$num_legislature\", \"$id_deput\", \"$id_url\")";
	$result = $db->query(utf8_decode($sql));
	$id =  mysql_insert_id();
	$db->close();
	return $id;
}*/
	
function SetQuestion($num_question,$date_publication,$date_reponse,$num_legislature,$id_deput,$id_url)
{	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db->connect();
	
	$sql = "SELECT * FROM `questions` WHERE `num_question`=\"$num_question\" AND `date_publication`=\"$date_publication\" ";     
	
	$result = $db->query(utf8_decode($sql));
	$result1 = mysql_fetch_row( $result);
	//$db->close();
	if ($result1 == NULL)
	{
	$sql = "INSERT INTO `questions` ( `id_question` , `num_question` , `date_publication` , `date_reponse` , `num_legislature` , `id_depute`, `id_URL` ) VALUES ('', \"$num_question\", \"$date_publication\", \"$date_reponse\", \"$num_legislature\", \"$id_deput\", \"$id_url\")";
	$result2 = $db->query(utf8_decode($sql));
	$id =  mysql_insert_id();
	//$db->close();
	//return $id;
	}
	else
	{
	$id = $result1[0]; 
	}
	$db->close();
	return $id;
	
}

function SetMotClef($valeur_MC)
{	
	$valeur_MC = $this->toASCII($valeur_MC);
	
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db->connect();
	$sql = "INSERT INTO `mot-clef` ( `id_motclef` , `valeur_motclef` ) VALUES ('', \"$valeur_MC\")";
	$result = $db->query(utf8_decode($sql));
	$id =  mysql_insert_id();
	$db->close();
	return $id;
}

function SetRubrique($valeurrubrique)
{	
	$valeurrubrique = $this->toASCII($valeurrubrique);
	
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db->connect();
	$sql = "INSERT INTO `rubrique` ( `id_rubrique` , `valeur_rubrique` ) VALUES ('', \"$valeurrubrique\")";
	$result = $db->query(utf8_decode($sql));
	$id =  mysql_insert_id();
	$db->close();
	return $id;
}

public function verif_exist_mc ($valeurmotclef)
{	
	$valeurmotclef = $this->toASCII($valeurmotclef);
	
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$link=$db->connect();
	$sql = "SELECT * FROM `mot-clef` WHERE `valeur_motclef`=\"$valeurmotclef\" ";     
	$result = $db->query(utf8_decode($sql));
	$db->close($link);
	return ($result1 = mysql_fetch_array( $result));
}

public function verif_exist_rubrique ($valeurrubrique)
{	
	$valeurrubrique = $this->toASCII($valeurrubrique);
	
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$link=$db->connect();
	$sql = "SELECT * FROM `rubrique` WHERE `valeur_rubrique`=\"$valeurrubrique\" ";     
	$result = $db->query(utf8_decode($sql));
	$db->close($link);
	return ($result1 = mysql_fetch_array( $result));
}
public function extract_id_mc ($valeur_mc)
{	
	$valeur_mc = $this->toASCII($valeur_mc);
	
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$link=$db->connect();
	$sql = "SELECT `id_motclef` FROM `mot-clef` WHERE `valeur_motclef`=\"$valeur_mc\" ";     
	$result = $db->query(utf8_decode($sql));
	$db->close($link);
	$result1 = mysql_fetch_row( $result);
	$result2 = $result1[0];
	return $result2;
}

public function extract_id_rubrique ($valeur_rubr)
{
	$valeur_rubr = $this->toASCII($valeur_rubr);

	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$link=$db->connect();
	$sql = "SELECT `id_rubrique` FROM `rubrique` WHERE `valeur_rubrique`=\"$valeur_rubr\" ";     
	$result = $db->query(utf8_decode($sql));
	$db->close($link);
	$result1 = mysql_fetch_row( $result);
	$result2 = $result1[0];
	return $result2;
}

public function verif_exist_deptMC ($id_deput,$id_MC)
{
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$link=$db->connect();
	$sql = "SELECT * FROM `depute-mc` WHERE `id_depute`=\"$id_deput\" AND `id_motclef`=\"$id_MC\" ";     
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

public function verif_exist_questMC ($id_quest,$id_MC)
{
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$link=$db->connect();
	$sql = "SELECT * FROM `quest-mc` WHERE `id_question`=\"$id_quest\" AND `id_motclef`=\"$id_MC\" ";     
	$result = $db->query(utf8_decode($sql));
	$db->close($link);
	return ($result1 = mysql_fetch_array( $result));
}

public function verif_exist_deptRubr ($id_deput,$id_rubr)
{
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$link=$db->connect();
	$sql = "SELECT * FROM `depute-rubr` WHERE `id_depute`=\"$id_deput\" AND `id_rubrique`=\"$id_rubr\" ";     
	$result = $db->query(utf8_decode($sql));
	$db->close($link);
	return ($result1 = mysql_fetch_array( $result));
}

public function verif_exist_questRubr ($id_quest,$id_rubr)
{
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$link=$db->connect();
	$sql = "SELECT * FROM `quest-rubr` WHERE `id_question`=\"$id_quest\" AND `id_rubrique`=\"$id_rubr\" ";     
	$result = $db->query(utf8_decode($sql));
	$db->close($link);
	return ($result1 = mysql_fetch_array( $result));
}

public function insert_table_depute_mc ($id_deput,$id_mc)
{
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$link=$db->connect();
	$sql = "INSERT INTO `depute-mc` ( `id_depute` , `id_motclef` ) VALUES (\"$id_deput\", \"$id_mc\")";     
	$result = $db->query(utf8_decode($sql));
	$db->close($link);
}

public function insert_table_depute_rubr ($id_deput,$id_rubr)
{
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$link=$db->connect();
	$sql = "INSERT INTO `depute-rubr` ( `id_depute` , `id_rubrique` ) VALUES (\"$id_deput\", \"$id_rubr\")";     
	$result = $db->query(utf8_decode($sql));
	$db->close($link);
}

public function insert_table_quest_mc ($id_quest,$id_mc)
{
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$link=$db->connect();
	$sql = "INSERT INTO `quest-mc` ( `id_question` , `id_motclef` ) VALUES (\"$id_quest\", \"$id_mc\")";     
	$result = $db->query(utf8_decode($sql));
	$db->close($link);
}
   
public function insert_table_quest_rubr ($id_quest,$id_rubr)
{
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$link=$db->connect();
	$sql = "INSERT INTO `quest-rubr` ( `id_question` , `id_rubrique` ) VALUES (\"$id_quest\", \"$id_rubr\")";     
	$result = $db->query(utf8_decode($sql));
	$db->close($link);
}

public function verif_exist_deputUrl ($id_deput,$id_url)
{
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$link=$db->connect();
	$sql = "SELECT * FROM `depute-url` WHERE `id_depute`=\"$id_deput\" AND `id_URL`=\"$id_url\" ";     
	$result = $db->query(utf8_decode($sql));
	$db->close($link);
	return ($result1 = mysql_fetch_array( $result));
}

public function insert_table_depute_url ($id_deput,$id_url)
{
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$link=$db->connect();
	$sql = "INSERT INTO `depute-url` ( `id_depute` , `id_URL` ) VALUES (\"$id_deput\", \"$id_url\")";     
	$result = $db->query(utf8_decode($sql));
	$db->close($link);
}

function extract_name_geo ($id_geo)
{
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$link=$db->connect();
	$sql = "SELECT `nom_geoname` FROM `geoname` WHERE `id_geoname`=\"$id_geo\" ";     
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


}

?>