<?php

require_once(CLASS_BASE."AllClass.php");
require_once ("C:/Program Files/EasyPHP 2.0b1/www/evalactipol/param/Constantes.php");
require_once ("C:/Program Files/EasyPHP 2.0b1/www/evalactipol/param/ParamPage.php");
//require_once ("AllClass.php");

class extract extends site{
  public $nom_table;
  public $chaine;
  public $baseUrl;
//  public $cl_Output;
  
  function __tostring() {
    return "Cette classe permet d'extraire le contenu d'un site.<br/>";
    }

  public function __construct($baseUrl) {
    //echo "new Site $sites, $id, $scope<br/>";
//    $this->nom_table = $nom_table;
//    $this->chaine = $chaine;           
      $this->$baseUrl = $baseUrl;
      
  //    $this->$cl_Output = new Cache_Lite_Function(array('cacheDir' => CACHEPATH,'lifeTime' => LIFETIME)); 
    }

  function extract_site ($baseUrl)
    {
      $baseUrlHtml = $baseUrl."/wiki/Deputes_par_departement";
    $result_exist_url = $this->verif_exist_url ($baseUrlHtml,"Url de départ");
    if ($result_exist_url == NULL)
    {  
    $this->insert_table_urls ($baseUrlHtml,"Url de départ");
    }
    $result_id_url_ttDepart = $this->extract_id_url ($baseUrlHtml,"Url de départ");
    
    $cl_Output = new Cache_Lite_Function(array('cacheDir' => CACHEPATH,'lifeTime' => LIFETIME));
    $html = $cl_Output->call('file_get_html',$baseUrl."/wiki/Deputes_par_departement");
   // $this->insert_table_urls ($baseUrlHtml,"file_get_html('$baseUrlHtml')");
    //$ret = $html->find('a[title]');
    $retours = $html->find('li a[title^=Deputes]');
    
    //boucle sur les départements
    foreach($retours as $dept){
        
        $urlDept = $dept->attr["href"];
      //  $this->insert_table_urls ($urlDept,"find('li a[title^=Deputes]')");
        
        $url =$baseUrl.$urlDept;
        $htmlDept = $cl_Output->call('file_get_html',$url);       
     //   $this->insert_table_urls ($url,"file_get_html('$url')");
        $result_exist_url = $this->verif_exist_url ($url,"find('li a[title^=Deputes]')");
        if ($result_exist_url == NULL)
          {    
        $this->insert_table_urls ($url,"find('li a[title^=Deputes]')");
          }
        $result_id_url_Depart = $this->extract_id_url ($url,"find('li a[title^=Deputes]')");
        //Extraction des noms des cantons
        //et insertion des cantons dans la table geoname 
      //  $this->extract_canton ($htmlDept); 
        list ($nom_cantons,$circonscription_cantons,$circonscriptions_depart,$type_geoname,$tabNomGeonameCantons) = $this->extract_canton ($htmlDept);

        //Extraction des infos sur les départements
       // $this->extract_departement ($urlDept,$dept);
        list ($numDepartDepute,$nomGeo_Depart,$type_geoname) = $this->extract_departement ($urlDept,$dept);
        //Insertion dans la table geoname
        
        $result_exist_geo = $this->verif_exist_geo ($nomGeo_Depart,$type_geoname);
        if ($result_exist_geo == NULL)
           {
        $this->insert_table_geoname ($nomGeo_Depart,$type_geoname,$circonscriptions_depart);
           }
                
        //extraction des liens des infos des députées
        
        $rsDept = $htmlDept->find('td a[href^=/wiki/]');

        //Boucle sur les députés
        foreach($rsDept as $depu){
            
            $urlDepu = $depu->attr["href"]; 
        //    $this->insert_table_urls ($urlDepu,"find('td a[href^=/wiki/]')");
            //vérifie qu'on traite un député
            $nom = substr($urlDepu,6,7);
            if($nom!="Deputes"){
           
            $urlDepute=$baseUrl.$urlDepu;
        //    $htmllienDepu = file_get_html($urlDepute);

            $htmllienDepu = $cl_Output->call('file_get_html',$urlDepute);
        //    $this->insert_table_urls ($urlDepute,"file_get_html('$urlDepute')");
            $result_exist_url = $this->verif_exist_url ($urlDepute,"find('td a[href^=/wiki/]')");
            if ($result_exist_url == NULL)
            {
            $this->insert_table_urls ($urlDepute,"find('td a[href^=/wiki/]')");
            }
            $result_id_url_Deput = $this->extract_id_url ($urlDepute,"find('td a[href^=/wiki/]')");
      //extraction des info du député
//           $this->extract_deput ($htmllienDepu,$depu);   
      
list ($rslienQuest,$NomDepute,$PrenomDepute,$mailDepute,$numPhoneDepute,$lienANDepute) = $this->extract_deput ($htmllienDepu,$depu);
// Insertion dans la table depute
$result_exist_depu = $this->verif_exist_depu ($NomDepute,$PrenomDepute,$lienANDepute);
if ($result_exist_depu == NULL)
{         
$this->insert_table_depute ($NomDepute,$PrenomDepute,$mailDepute,$numPhoneDepute,$lienANDepute,$numDepartDepute);              
}
$result_id_deput = $this->extract_id_depu ($NomDepute,$PrenomDepute,$lienANDepute);
$this->insert_table_depute_url($result_id_deput,$result_id_url_Deput);

    foreach($rslienQuest as $quest){
            $urlQuestion = $quest->attr["href"];
            $urlQuestionResult = str_replace("&amp;", "&", $urlQuestion);
                        
          //  $htmlLienQuestion = file_get_html($urlQuestionResult);
            
            $htmlLienQuestion = $cl_Output->call('file_get_html',$urlQuestionResult);
         //   $this->insert_table_urls ($urlQuestionResult,"file_get_html('$urlQuestionResult')");
            
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
              $this->extract_infos_question ($info);
              list ($numLegislature,$numQuestion,$tab_rubrique,$tab_motclef,$datePubliQuestion,$dateRepQuestion) = $this->extract_infos_question ($info);

              $result_exist_question = $this->verif_exist_question ($numQuestion,$datePubliQuestion);
                if ($result_exist_question == NULL)
                  {  
          //  $this->insert_table_questions ($numQuestion,$datePubliQuestion,$dateRepQuestion,$numLegislature);
          $this->insert_table_questions ($numQuestion,$datePubliQuestion,$dateRepQuestion,$numLegislature,$result_id_deput,$result_id_url_Questions);         
                  }
             $result_id_question = $this->extract_id_question ($numQuestion,$datePubliQuestion);
            
             foreach ($tab_motclef as $mot_clef)
             {
             $this->insert_table_motclef ($mot_clef);
             $result_id_mc = $this->extract_id_mc ($mot_clef);
             foreach ($result_id_mc as $id_mc)
              {
               $this->insert_table_depute_mc ($result_id_deput,$id_mc);
               $this->insert_table_quest_mc ($result_id_question,$id_mc); 
              }  
             }
            
            foreach ($tab_rubrique as $rubrique)
             {
             $this->insert_table_rubrique ($rubrique);
             $result_id_rubrique = $this->extract_id_rubrique ($rubrique);
             foreach ($result_id_rubrique as $id_rubrique)
              {
               $this->insert_table_depute_rubr ($result_id_deput,$id_rubrique); 
               $this->insert_table_quest_rubr ($result_id_question,$id_rubrique);
              }  
             }
            
                    
            }
           }
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
    //    $nomGeo_Depart = filter ($nomGeo_Depart1);  
        $type_geoname = "Departement";  
        return array ($numDepartDepute,$nomGeo_Depart,$type_geoname);
}
    
function extract_canton ($htmlDept)

{
            $rsCantons = $htmlDept->find('tbody tr');
            //supprimer la première ligne qui représente le nom des colonnes
            $rsCantons1 = array_shift($rsCantons);
                  
            //Boucler sur les Cantons
            $x = "";
            foreach($rsCantons as $cantons){
            $infosCantons = $cantons->children;
            
            $ChaineCantons = implode(";", $infosCantons);
            
            //Extraction des noms des cantons dans une chaine de caractères
            $nom_cantons = $this->extractBetweenDelimeters($ChaineCantons,"(cantons de ",")");
           // $nom_cantons = filter ($nom_cantons1);
            //Insertion des noms des cantons dans un tableau
            $tabNomGeonameCantons = explode (",",$nom_cantons);
            
            foreach ($tabNomGeonameCantons as $value)
            {
            //Préciser que le type de geoname d'un canton est canton
            // avant d'insérer le canton dans la table geoname
          //  $nom_geoname_canton = $this->filter ($value);
          $nom_geoname_canton = $value;
           // $nom_geoname_canton = $value;
            $type_geoname_canton = "canton";
            //Extraction du numéro de circonscription du canton
            $circonscription_cantons = substr($ChaineCantons,5,1);
            
            $result_exist_geo = $this->verif_exist_geo ($nom_geoname_canton,$type_geoname_canton);
            if ($result_exist_geo == NULL)
                  {
                   $this->insert_table_geoname ($nom_geoname_canton,$type_geoname_canton,$circonscription_cantons);            
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
         return array  ($nom_cantons,$circonscription_cantons,$circonscriptions_depart,$type_geoname,$tabNomGeonameCantons);   
            
        }

    function extract_deput ($htmllienDepu,$depu)
        {
       //boucle sur les députés             
           //Récupération du lien vers les questions d'un député
              
            $rslienQuest = $htmllienDepu->find('li a[href$=Questions]');                
            $rslienLienANDepute = $htmllienDepu->find('li a[title^=http://www.assemblee-nationale.fr]');
            $rslienLienANDepute1 = array_shift($rslienLienANDepute);
            $rsNumPhoneDepute = $htmllienDepu->find('li a[title^=callto]');
            $rsMailDepute = $htmllienDepu->find('li a[title^=mailto]');

            $numPhoneValue = "";
            $numPhoneValue1 = "";
              foreach($rsNumPhoneDepute as $numPhone)
                {                 
                  if ($numPhoneValue != $numPhoneValue1)                  
                     {
                     $numPhoneValue2 = $numPhone->attr["href"];
                     $numPhoneDepute2_1 = substr($numPhoneValue2,9);
                     $numPhoneDepute2 = str_replace("+", "00", $numPhoneDepute2_1);           
                     }
                  else
                  {
                  $numPhoneValue1 = $numPhone->attr["href"];
                  $numPhoneDepute1_1 = substr($numPhoneValue1,9);
                  //$numPhoneDepute1_1 = $numPhoneDepute1_1;
                  $numPhoneDepute1 = str_replace("+", "00", $numPhoneDepute1_1);
                  }             
                }
                $numPhoneDepute = $numPhoneDepute1.",".$numPhoneDepute2;
            $mailValue = "";
            $mailValue1 = "";
                foreach($rsMailDepute as $mail)
                {
                  if ($mailValue != $mailValue1)                  
                     {
                  $mailValue2 = trim ($mail->attr["href"]);
                  $mailDepute2 = substr($mailValue2,7);
                     }
                  else
                  {                 
                  $mailValue1 = trim ($mail->attr["href"]);
                  $mailDepute1 = substr($mailValue1,7);
                  $mailDepute1 = $mailDepute1;
                  }  
                }
                $mailDepute = $mailDepute1.",".$mailDepute2; 

                  
                $NomPrenom = $depu->nodes;
                $ChaineNomPrenom = implode(";", $NomPrenom);
                $NomDepute = $this->extractBetweenDelimeters($ChaineNomPrenom,""," ");
            //    $NomDepute = $this->filter ($NomDepute1);
                $pos = strpos ($ChaineNomPrenom," ");
                $PrenomDepute = substr($ChaineNomPrenom,$pos+1);
           //     $PrenomDepute = $this->filter ($PrenomDepute1);

                foreach($rslienLienANDepute as $lienANValue){
                $lienANDepute = $lienANValue->attr["href"];
                
                $result_exist_url = $this->verif_exist_url ($lienANDepute,"find('li a[title^=http://www.assemblee-nationale.fr]')");
                 if ($result_exist_url == NULL)
                  {
                $this->insert_table_urls ($lienANDepute,"find('li a[title^=http://www.assemblee-nationale.fr]')");
                  }                
                }             
      //          insert_table_depute ($NomDepute,$PrenomDepute,$mailDepute,$numPhoneDepute,$lienANDepute,$numDepartDepute);
                
                return array  ($rslienQuest,$NomDepute,$PrenomDepute,$mailDepute,$numPhoneDepute,$lienANDepute);
 
              }
  
function extract_infos_question ($info)

{
            $infosChildren = $info->children;
            $Chaine = implode(";", $infosChildren);
            $NewChaine = str_replace("", "é", $Chaine);
            
            $lienQuest = $this->extractBetweenDelimeters($NewChaine,"href=","class");
            
           //Extraction des informations sur une question, les mots clés et les  rubriques
            $numLegislature1 = $this->extractBetweenDelimeters($lienQuest,".fr/q","/");
            $numLegislature = (int)$numLegislature1;
            
            $numQuestion1 = $this->extractBetweenDelimeters($lienQuest,$numLegislature."-","Q");
            $numQuestion = (int)$numQuestion1;
            
            $rubrique = $this->extractBetweenDelimeters($NewChaine,"Rubrique :","<br>");
       //     $rubrique = $this->filter ($rubrique1);
            $tab_rubrique = explode (",",$rubrique);
            
            $motclef = $this->extractBetweenDelimeters($NewChaine,"Mots clés :","</td>");
            $tab_motclef = explode (".",$motclef);
        //    $motclef = $this->filter ($motclef1);
                
        //    $chemindatePubliQuestion = $this->extractBetweenDelimeters($NewChaine,"$motclef1","</td>;<td");
        $chemindatePubliQuestion = $this->extractBetweenDelimeters($NewChaine,"$motclef","</td>;<td");
            
            $datePubliQuestion1 = substr($chemindatePubliQuestion,31);
            $datePubliQuestion2 = trim($datePubliQuestion1);
            $datePubliQuestion = $this->convertToDateFormat($datePubliQuestion2);
            
            $dateRepQuestion1 = $this->extractBetweenDelimeters($NewChaine,"$datePubliQuestion1</td>;<td class='TexteColonne'>","</td>");
            $dateRepQuestion2 = trim($dateRepQuestion1);
            $dateRepQuestion = $this->convertToDateFormat($dateRepQuestion2);
            
      return array ($numLegislature,$numQuestion,$tab_rubrique,$tab_motclef,$datePubliQuestion,$dateRepQuestion);
            
       }
  
       
 // Fonction qui récupère une chaine inconnue entre deux chaines connues
 function extractBetweenDelimeters($inputstr,$delimeterLeft,$delimeterRight) {
    $posLeft  = stripos($inputstr,$delimeterLeft)+strlen($delimeterLeft);
    $posRight = stripos($inputstr,$delimeterRight,$posLeft+1);
    return  substr($inputstr,$posLeft,$posRight-$posLeft);
 }
 
 // Fnction qui supprime les caractères spéciaux
 function filter($in) { 
    $search = array ('@[éèêëÊË]@i','@[áãàâäÂÄ]@i','@[ìíiiîïÎÏ]@i','@[úûùüÛÜ]@i','@[òóõôöÔÖ]@i','@[ñÑ]@i','@[ýÿÝ]@i','@[ç]@i','@[ ]@i','@[^a-zA-Z0-9_]@');    
    $replace = array ('e','a','i','u','o','n','y','c','_','');
    return preg_replace($search, $replace, $in);  
    }
    //Fonction qui convertie une chaine en format date
   function convertToDateFormat ($inputStr)
   {
    $jour = substr($inputStr, 0, 2);
    $mois = substr($inputStr, 3, 2);
    $annee = substr($inputStr, 6, 4);
    $result = $annee . '-' . $mois . '-' . $jour;
    return $result;
   }
   
   function insert_table_geoname ($nomGeo,$typeGeo,$circonscGeo)
    {
 // $objSite = new Site($SITES, $site, $scope, false);
 // $db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
  $db=new mysql ('localhost','root','','evalactipol');
  //$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);    
  $link=$db->connect();
  $sql = "INSERT INTO `geoname` ( `id_geoname` , `nom_geoname`, `type_geoname`, `circonscriptions_geoname`, `lat_geoname`, `lng_geoname`, `alt_geoname`, `kml_geoname` ) VALUES ('', \"$nomGeo\", \"$typeGeo\", \"$circonscGeo\", '', '', '', '')";     
  $result = $db->query(utf8_decode($sql));
  $db->close($link);
   }
 function insert_table_depute ($nom,$prenom,$mail,$numphone,$lien_AN_deput,$num_depart)
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

 function insert_table_questions ($num_question,$date_publication,$date_reponse,$num_legislature,$id_deput,$id_url)
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
   
   function insert_table_motclef ($valeur_MC)
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
   function insert_table_rubrique ($valeurRubrique)
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
   
function insert_table_urls ($valeurURL,$codeExtractURL)
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
   
function insert_table_depute_geo ($id_deput,$id_geo)
    {
  $db=new mysql ('localhost','root','','evalactipol');
  //$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//  $objSite = new Site($SITES, $site, $scope, false);
//  $db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
  $link=$db->connect();
  $sql = "INSERT INTO `depute-geo` ( `id_depute` , `id_geoname` ) VALUES (\"$id_deput\", \"$id_geo\")";     
  $result = $db->query(utf8_decode($sql));
  $db->close($link);
   }
function insert_table_depute_mc ($id_deput,$id_mc)
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
function insert_table_depute_rubr ($id_deput,$id_rubr)
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
function insert_table_depute_url ($id_deput,$id_url)
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
function insert_table_geo_url ($id_geo,$id_url)
    {
  $db=new mysql ('localhost','root','','evalactipol');
  //$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//  $objSite = new Site($SITES, $site, $scope, false);
//  $db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
  $link=$db->connect();
  $sql = "INSERT INTO `geo-url` ( `id_geoname` , `id_URL` ) VALUES (\"$id_geo\", \"$id_url\")";     
  $result = $db->query(utf8_decode($sql));
  $db->close($link);
   }
function insert_table_quest_mc ($id_quest,$id_mc)
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
   
function insert_table_quest_rubr ($id_quest,$id_rubr)
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
   
function verif_exist_depu ($nom_depu,$prenom_depu,$lien_AN_depu)
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
function verif_exist_geo ($nom_geo,$type_geo)
    {
  $db=new mysql ('localhost','root','','evalactipol');
  //$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//  $objSite = new Site($SITES, $site, $scope, false);
//  $db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
  $link=$db->connect();
  $sql = "SELECT * FROM `geoname` WHERE `nom_geoname`=\"$nom_geo\" AND `type_geoname`=\"$type_geo\" ";     
  $result = $db->query(utf8_decode($sql));
  $db->close($link);
  return ($result1 = mysql_fetch_array( $result));
   }   

   function verif_exist_question ($num_quest,$date_publi)
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

function verif_exist_url ($valeurURL,$codeExtractURL)
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

function extract_id_depu ($nom_depu,$prenom_depu,$lien_AN_depu)
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
function extract_id_geo ($nom_geo,$type_geo)
    {
  $db=new mysql ('localhost','root','','evalactipol');
  //$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//  $objSite = new Site($SITES, $site, $scope, false);
//  $db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
  $link=$db->connect();
  $sql = "SELECT `id_geoname` FROM `geoname` WHERE `nom_geoname`=\"$nom_geo\" AND `type_geoname`=\"$type_geo\" ";     
  $result = $db->query(utf8_decode($sql));
  $db->close($link);
  $result1 = mysql_fetch_row( $result);
  return $result2 = $result1[0];
   }   

   function extract_id_question ($num_quest,$date_publi)
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

function extract_id_mc ($valeur_mc)
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
   
function extract_id_rubrique ($valeur_rubr)
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
   
  function extract_id_url ($valeurURL,$codeExtractURL)
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
   
   
 
      } //Fin de la classe extract

?>