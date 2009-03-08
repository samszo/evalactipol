<?php

require_once(CLASS_BASE."AllClass.php");


class depute extends site{

public $nom_depute;
public $prenom_depute;
public $num_depart_depute;
public $mail_depute;
public $url_depute;
public $url_html_depute;
public $id_url_depute;

// définition du constructeur 

public function depute ($htmllienDepu,$depu,$result_id_url_Deput,$numDepartDepute) 

{

$this->url_depute = $htmllienDepu;
$this->url_html_depute = $depu;
$this->id_url_depute = $result_id_url_Deput;
$this->num_depart_depute = $numDepartDepute;
}
public function recup_lien_questions ($htmllienDepu)
{

  $rslienQuest = $htmllienDepu->find('li a[href$=Questions]');
  return $rslienQuest;

}
public function recup_nom_deput ($depu)
{

  $NomPrenom = $depu->nodes;
  $ChaineNomPrenom = implode(";", $NomPrenom);
  $NomDepute = $this->extractBetweenDelimeters($ChaineNomPrenom,""," ");
  return $NomDepute;
}
public function recup_prenom_deput ($depu)
{

  $NomPrenom = $depu->nodes;
  $ChaineNomPrenom = implode(";", $NomPrenom);
  $NomDepute = $this->extractBetweenDelimeters($ChaineNomPrenom,""," ");
            //    $NomDepute = $this->filter ($NomDepute1);
  $pos = strpos ($ChaineNomPrenom," ");
  $PrenomDepute = substr($ChaineNomPrenom,$pos+1);
  return $PrenomDepute;
}

public function recup_lien_AN_deput ($htmllienDepu)
{
  $rslienLienANDepute = $htmllienDepu->find('li a[title^=http://www.assemblee-nationale.fr]');
foreach($rslienLienANDepute as $lienANValue){
 $lienANDepute = $lienANValue->attr["href"];
                
 $result_exist_url = $this->verif_exist_url ($lienANDepute,"find('li a[title^=http://www.assemblee-nationale.fr]')");
        if ($result_exist_url == NULL)
             {
             $this->insert_table_urls ($lienANDepute,"find('li a[title^=http://www.assemblee-nationale.fr]')");
              }                
               }
      return $lienANDepute; 
}


public function recup_mail_deput ($htmllienDepu)
{
  $rsMailDepute = $htmllienDepu->find('li a[title^=mailto]');
  $mailDepute2 = "";
  //$mailValue1 = "";
        foreach($rsMailDepute as $mail)
                {
                  $mailValue = trim ($mail->attr["href"]);
                  $mailDepute1 = substr($mailValue,7);
                  $mailDepute2 = $mailDepute2.",".$mailDepute1;   
                }
          $mailDepute = substr($mailDepute2,1);      
                
       return $mailDepute;
}


public function recup_Phone_deput ($htmllienDepu)
{
  $rsNumPhoneDepute = $htmllienDepu->find('li a[title^=callto]');
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

public function extrac_infos_depute ($htmllienDepu,$depu,$result_id_url_Deput,$numDepartDepute,$cl_Output)
{

$rslienQuest = $this->recup_lien_questions($htmllienDepu);
$NomDepute = $this->recup_nom_deput ($depu);
$PrenomDepute = $this->recup_prenom_deput ($depu);
$mailDepute = $this->recup_mail_deput ($htmllienDepu);
$numPhoneDepute = $this->recup_Phone_deput ($htmllienDepu);
$lienANDepute = $this->recup_lien_AN_deput ($htmllienDepu);

$result_exist_depu = $this->verif_exist_depu ($NomDepute,$PrenomDepute,$lienANDepute);
if ($result_exist_depu == NULL)
{         
$this->insert_table_depute ($NomDepute,$PrenomDepute,$mailDepute,$numPhoneDepute,$lienANDepute,$numDepartDepute);              
}
$result_id_deput = $this->extract_id_depu ($NomDepute,$PrenomDepute,$lienANDepute);

$result_exist_depuUrl = $this->verif_exist_deputUrl ($result_id_deput,$result_id_url_Deput);
if ($result_exist_depu == NULL)
{         
$this->insert_table_depute_url($result_id_deput,$result_id_url_Deput);
}


// Fin La partie ajoutée pour testet l'objet député

    foreach($rslienQuest as $quest){
            
            
            $urlQuestionResult = $this->extract_contenu_lienQuest ($quest);
            $htmlLienQuestion = $cl_Output->call('file_get_html',$urlQuestionResult);         
            
            $result_exist_url = $this->verif_exist_url ($urlQuestionResult,"find('li a[href$=Questions]')");
            if ($result_exist_url == NULL)
            {    
            $this->insert_table_urls ($urlQuestionResult,"find('li a[href$=Questions]')");
            }
            $result_id_url_Questions = $this->extract_id_url ($urlQuestionResult,"find('li a[href$=Questions]')");
            
            // Récupérer les inforamations existantes dans tous les lignes 
            // du tableux questions, chaque ligne contien des informations sur une question
            
            $rsQuest = $htmlLienQuestion->find('tbody tr[valign=top]');
            //supprimer la première ligne qui représente le nom des colonnes
            $rsQuest1 = array_shift($rsQuest);
                  
            //Boucler sur les questions
            

            foreach($rsQuest as $info){
            //Extraction des informations d'une question, des mots-clefs et des rubriques
              
            $infosChildren = $info->children;
            $Chaine = implode(";", $infosChildren);
            $NewChaine = str_replace("", "é", $Chaine);
            $lienQuest = $this->extractBetweenDelimeters($NewChaine,"href=","class");

//Debut ajouté

     $this->insert_infos_questions ($lienQuest,$NewChaine,$result_id_deput,$result_id_url_Questions);
//Fin ajouté
                                     
            }
           }

}

public function insert_infos_questions ($lienQuest,$NewChaine,$result_id_deput,$result_id_url_Questions)
{
        $numLegislature = $this->extract_numlegis_question ($lienQuest);
	$numQuestion = $this->extract_num_question ($lienQuest,$numLegislature);
	$tab_rubrique = $this->extract_tabRubr_question ($NewChaine);
	$tab_motclef = $this->extract_tabMC_question ($NewChaine);
	$datePubliQuestion = $this->extract_datePubli_question ($NewChaine);
	$dateRepQuestion = $this->extract_dateRep_question ($NewChaine);


        $result_exist_question = $this->verif_exist_question ($numQuestion,$datePubliQuestion);
                if ($result_exist_question == NULL)
                  {  
          //  $this->insert_table_questions ($numQuestion,$datePubliQuestion,$dateRepQuestion,$numLegislature);
          $this->insert_table_questions ($numQuestion,$datePubliQuestion,$dateRepQuestion,$numLegislature,$result_id_deput,$result_id_url_Questions);         
                  }
             $result_id_question = $this->extract_id_question ($numQuestion,$datePubliQuestion);
            
             foreach ($tab_motclef as $mot_clef1)
             {
             $mot_clef = $this->filter ($mot_clef1);
             $this->insert_table_motclef ($mot_clef);
             $result_id_mc = $this->extract_id_mc ($mot_clef);
             foreach ($result_id_mc as $id_mc)
              {
               
               $result_exist_deputMC = $this->verif_exist_deptMC ($result_id_deput,$id_mc);
	       $result_exist_questMC = $this->verif_exist_questMC ($result_id_question,$id_mc);	
                if ($result_exist_deputMC == NULL)
                  {  
              
               $this->insert_table_depute_mc ($result_id_deput,$id_mc);
                  }
               
                if ($result_exist_questMC == NULL)
                  {  

               $this->insert_table_quest_mc ($result_id_question,$id_mc); 
                  }
              }  
             }
            
            foreach ($tab_rubrique as $rubrique1)
             {
		$rubrique = $this->filter ($rubrique1);
             $this->insert_table_rubrique ($rubrique);
             $result_id_rubrique = $this->extract_id_rubrique ($rubrique);
             foreach ($result_id_rubrique as $id_rubrique)
              {

               $result_exist_deputRubr = $this->verif_exist_deptRubr ($result_id_deput,$id_rubrique);
	       $result_exist_questRubr = $this->verif_exist_questRubr ($result_id_question,$id_rubrique);	
                if ($result_exist_deputRubr == NULL)
                  {
               $this->insert_table_depute_rubr ($result_id_deput,$id_rubrique); 
                  }
                if ($result_exist_questRubr == NULL)
                  {  
               $this->insert_table_quest_rubr ($result_id_question,$id_rubrique);
                
		  }

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


public function verif_exist_depu ($nom_depu,$prenom_depu,$lien_AN_depu)
    {
  $db=new mysql ('localhost','root','','evalactipol');
  //$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//  $objSite = new Site($SITES, $site, $scope, false);
//  $db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
  $link=$db->connect();
  $sql = "SELECT * FROM `depute` WHERE `nom_depute`=\"$nom_depu\" AND `prenom_depute`=\"$prenom_depu\" AND `lien_AN_depute`=\"$lien_AN_depu\" ";     
  $result = $db->query(utf8_decode($sql));
  $db->close($link);
  return ($result1 = mysql_fetch_array( $result));
   
   }

public function insert_table_depute ($nom,$prenom,$mail,$numphone,$lien_AN_deput,$num_depart)
  {
  $db=new mysql ('localhost','root','','evalactipol');
  //$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//  $objSite = new Site($SITES, $site, $scope, false);
//  $db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
  $link=$db->connect();
  $sql = "INSERT INTO `depute` ( `id_depute` , `nom_depute` , `prenom_depute` , `mail_depute` , `numphone_depute` , `lien_AN_depute` , `num_depart_depute` ) VALUES ('', \"$nom\", \"$prenom\", \"$mail\", \"$numphone\", \"$lien_AN_deput\", \"$num_depart\")";     
  $result = $db->query(utf8_decode($sql));
  $db->close($link);
}

public function extract_id_depu ($nom_depu,$prenom_depu,$lien_AN_depu)
    {
  $db=new mysql ('localhost','root','','evalactipol');
  //$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//  $objSite = new Site($SITES, $site, $scope, false);
//  $db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
  $link=$db->connect();
  $sql = "SELECT `id_depute` FROM `depute` WHERE `nom_depute`=\"$nom_depu\" AND `prenom_depute`=\"$prenom_depu\" AND `lien_AN_depute`=\"$lien_AN_depu\" ";     
  $result = $db->query(utf8_decode($sql));
  $db->close($link);
  $result1 = mysql_fetch_row( $result);
  return $result2 = $result1[0];
   }

public function verif_exist_url ($valeurURL,$codeExtractURL)
    {
  $db=new mysql ('localhost','root','','evalactipol');
  //$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//  $objSite = new Site($SITES, $site, $scope, false);
//  $db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
  $link=$db->connect();
  $sql = "SELECT * FROM `urls` WHERE `valeur_URL`=\"$valeurURL\" AND `code_extract_URL`=\"$codeExtractURL\" ";     
  $result = $db->query(utf8_decode($sql));
  $db->close($link);
  return ($result1 = mysql_fetch_array( $result));
   }

public function insert_table_urls ($valeurURL,$codeExtractURL)
    {
  $db=new mysql ('localhost','root','','evalactipol');
  //$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//  $objSite = new Site($SITES, $site, $scope, false);
//  $db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
  $link=$db->connect();
  $sql = "INSERT INTO `urls` ( `id_URL` , `valeur_url`, `code_extract_URL` ) VALUES ('', \"$valeurURL\", \"$codeExtractURL\")";     
  $result = $db->query(utf8_decode($sql));
  $db->close($link);
   }

public function verif_exist_question ($num_quest,$date_publi)
    {
  $db=new mysql ('localhost','root','','evalactipol');
  //$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//  $objSite = new Site($SITES, $site, $scope, false);
//  $db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
  $link=$db->connect();
  $sql = "SELECT * FROM `questions` WHERE `num_question`=\"$num_quest\" AND `date_publication`=\"$date_publi\" ";     
  $result = $db->query(utf8_decode($sql));
  $db->close($link);
  return ($result1 = mysql_fetch_array( $result));
   }

public function insert_table_questions ($num_question,$date_publication,$date_reponse,$num_legislature,$id_deput,$id_url)
   {
  $db=new mysql ('localhost','root','','evalactipol');
  //$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//  $objSite = new Site($SITES, $site, $scope, false);
//  $db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
  $link=$db->connect();
 // $sql = "INSERT INTO `questions` ( `id_question` , `num_question` , `date_publication` , `date_reponse` , `num_legislature` , `id_depute`, `id_URL` ) VALUES ('', \"$num_question\", \"$date_publication\", \"$date_reponse\", \"$num_legislature\", '', '')";
 $sql = "INSERT INTO `questions` ( `id_question` , `num_question` , `date_publication` , `date_reponse` , `num_legislature` , `id_depute`, `id_URL` ) VALUES ('', \"$num_question\", \"$date_publication\", \"$date_reponse\", \"$num_legislature\", \"$id_deput\", \"$id_url\")";     
  $result = $db->query(utf8_decode($sql));
  $db->close($link);
   }

public function insert_table_motclef ($valeur_MC)
    {
  $db=new mysql ('localhost','root','','evalactipol');
  //$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//  $objSite = new Site($SITES, $site, $scope, false);
//  $db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
  $link=$db->connect();
  $sql = "INSERT INTO `mot-clef` ( `id_motclef` , `valeur_motclef` ) VALUES ('', \"$valeur_MC\")";     
  $result = $db->query(utf8_decode($sql));
  $db->close($link);
   }

public function extract_id_question ($num_quest,$date_publi)
    {
  $db=new mysql ('localhost','root','','evalactipol');
  //$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//  $objSite = new Site($SITES, $site, $scope, false);
//  $db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
  $link=$db->connect();
  $sql = "SELECT `id_question` FROM `questions` WHERE `num_question`=\"$num_quest\" AND `date_publication`=\"$date_publi\" ";     
  $result = $db->query(utf8_decode($sql));
  $db->close($link);
  $result1 = mysql_fetch_row( $result);
  return $result2 = $result1[0];
   }

public function extract_id_mc ($valeur_mc)
    {
  $db=new mysql ('localhost','root','','evalactipol');
  //$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//  $objSite = new Site($SITES, $site, $scope, false);
//  $db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
  $link=$db->connect();
  $sql = "SELECT `id_motclef` FROM `mot-clef` WHERE `valeur_motclef`=\"$valeur_mc\" ";     
  $result = $db->query(utf8_decode($sql));
  $db->close($link);
  return $result1 = mysql_fetch_row( $result);
   
   }

public function insert_table_rubrique ($valeurRubrique)
    {
  $db=new mysql ('localhost','root','','evalactipol');
  //$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//  $objSite = new Site($SITES, $site, $scope, false);
//  $db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
  $link=$db->connect();
  $sql = "INSERT INTO `rubrique` ( `id_rubrique` , `valeur_rubrique` ) VALUES ('', \"$valeurRubrique\")";     
  $result = $db->query(utf8_decode($sql));
  $db->close($link);
   }

public function extract_id_rubrique ($valeur_rubr)
    {
  $db=new mysql ('localhost','root','','evalactipol');
  //$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//  $objSite = new Site($SITES, $site, $scope, false);
//  $db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
  $link=$db->connect();
  $sql = "SELECT `id_rubrique` FROM `rubrique` WHERE `valeur_rubrique`=\"$valeur_rubr\" ";     
  $result = $db->query(utf8_decode($sql));
  $db->close($link);
  return $result1 = mysql_fetch_row( $result);
  
   }
// Fonctions en doute 

public function filter($in) { 
    $search = array ('@[éèêëÊË]@i','@[áãàâäÂÄ]@i','@[ìíiiîïÎÏ]@i','@[úûùüÛÜ]@i','@[òóõôöÔÖ]@i','@[ñÑ]@i','@[ýÿÝ]@i','@[ç]@i');    
    $replace = array ('e','a','i','u','o','n','y','c');
    return preg_replace($search, $replace, $in);  
    }
public function verif_exist_deptMC ($id_deput,$id_MC)
    {
  $db=new mysql ('localhost','root','','evalactipol');
  //$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//  $objSite = new Site($SITES, $site, $scope, false);
//  $db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
  $link=$db->connect();
  $sql = "SELECT * FROM `depute-mc` WHERE `id_depute`=\"$id_deput\" AND `id_motclef`=\"$id_MC\" ";     
  $result = $db->query(utf8_decode($sql));
  $db->close($link);
  return ($result1 = mysql_fetch_array( $result));
   }

public function verif_exist_questMC ($id_quest,$id_MC)
    {
  $db=new mysql ('localhost','root','','evalactipol');
  //$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//  $objSite = new Site($SITES, $site, $scope, false);
//  $db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
  $link=$db->connect();
  $sql = "SELECT * FROM `quest-mc` WHERE `id_question`=\"$id_quest\" AND `id_motclef`=\"$id_MC\" ";     
  $result = $db->query(utf8_decode($sql));
  $db->close($link);
  return ($result1 = mysql_fetch_array( $result));
   }

public function verif_exist_deptRubr ($id_deput,$id_rubr)
    {
  $db=new mysql ('localhost','root','','evalactipol');
  //$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//  $objSite = new Site($SITES, $site, $scope, false);
//  $db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
  $link=$db->connect();
  $sql = "SELECT * FROM `depute-rubr` WHERE `id_depute`=\"$id_deput\" AND `id_rubrique`=\"$id_rubr\" ";     
  $result = $db->query(utf8_decode($sql));
  $db->close($link);
  return ($result1 = mysql_fetch_array( $result));
   }

public function verif_exist_questRubr ($id_quest,$id_rubr)
    {
  $db=new mysql ('localhost','root','','evalactipol');
  //$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//  $objSite = new Site($SITES, $site, $scope, false);
//  $db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
  $link=$db->connect();
  $sql = "SELECT * FROM `quest-rubr` WHERE `id_question`=\"$id_quest\" AND `id_rubrique`=\"$id_rubr\" ";     
  $result = $db->query(utf8_decode($sql));
  $db->close($link);
  return ($result1 = mysql_fetch_array( $result));
   }
public function insert_table_depute_mc ($id_deput,$id_mc)
    {
  $db=new mysql ('localhost','root','','evalactipol');
  //$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//  $objSite = new Site($SITES, $site, $scope, false);
//  $db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
  $link=$db->connect();
  $sql = "INSERT INTO `depute-mc` ( `id_depute` , `id_motclef` ) VALUES (\"$id_deput\", \"$id_mc\")";     
  $result = $db->query(utf8_decode($sql));
  $db->close($link);
   }
public function insert_table_depute_rubr ($id_deput,$id_rubr)
    {
  $db=new mysql ('localhost','root','','evalactipol');
  //$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//  $objSite = new Site($SITES, $site, $scope, false);
//  $db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
  $link=$db->connect();
  $sql = "INSERT INTO `depute-rubr` ( `id_depute` , `id_rubrique` ) VALUES (\"$id_deput\", \"$id_rubr\")";     
  $result = $db->query(utf8_decode($sql));
  $db->close($link);
   }

public function insert_table_quest_mc ($id_quest,$id_mc)
    {
  $db=new mysql ('localhost','root','','evalactipol');
  //$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//  $objSite = new Site($SITES, $site, $scope, false);
//  $db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
  $link=$db->connect();
  $sql = "INSERT INTO `quest-mc` ( `id_question` , `id_motclef` ) VALUES (\"$id_quest\", \"$id_mc\")";     
  $result = $db->query(utf8_decode($sql));
  $db->close($link);
   }
   
public function insert_table_quest_rubr ($id_quest,$id_rubr)
    {
  $db=new mysql ('localhost','root','','evalactipol');
  //$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//  $objSite = new Site($SITES, $site, $scope, false);
//  $db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
  $link=$db->connect();
  $sql = "INSERT INTO `quest-rubr` ( `id_question` , `id_rubrique` ) VALUES (\"$id_quest\", \"$id_rubr\")";     
  $result = $db->query(utf8_decode($sql));
  $db->close($link);
   }

public function verif_exist_deputUrl ($id_deput,$id_url)
    {
  $db=new mysql ('localhost','root','','evalactipol');
  //$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//  $objSite = new Site($SITES, $site, $scope, false);
//  $db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
  $link=$db->connect();
  $sql = "SELECT * FROM `depute-url` WHERE `id_depute`=\"$id_deput\" AND `id_URL`=\"$id_url\" ";     
  $result = $db->query(utf8_decode($sql));
  $db->close($link);
  return ($result1 = mysql_fetch_array( $result));
   }

public function insert_table_depute_url ($id_deput,$id_url)
    {
  $db=new mysql ('localhost','root','','evalactipol');
  //$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//  $objSite = new Site($SITES, $site, $scope, false);
//  $db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
  $link=$db->connect();
  $sql = "INSERT INTO `depute-url` ( `id_depute` , `id_URL` ) VALUES (\"$id_deput\", \"$id_url\")";     
  $result = $db->query(utf8_decode($sql));
  $db->close($link);
   }


public function extract_id_url ($valeurURL,$codeExtractURL)
    {
  $db=new mysql ('localhost','root','','evalactipol');
  //$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//  $objSite = new Site($SITES, $site, $scope, false);
//  $db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
  $link=$db->connect();
  $sql = "SELECT `id_URL` FROM `urls` WHERE `valeur_URL`=\"$valeurURL\" AND `code_extract_URL`=\"$codeExtractURL\" ";     
  $result = $db->query(utf8_decode($sql));
  $db->close($link);
  $result1 = mysql_fetch_row( $result);
  return $result2 = $result1[0];
   }



}
	

?>