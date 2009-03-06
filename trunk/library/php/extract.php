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
    $this->insert_table_urls ($baseUrlHtml,"Url de d�part");  
    $cl_Output = new Cache_Lite_Function(array('cacheDir' => CACHEPATH,'lifeTime' => LIFETIME));
    $html = $cl_Output->call('file_get_html',$baseUrl."/wiki/Deputes_par_departement");
   // $this->insert_table_urls ($baseUrlHtml,"file_get_html('$baseUrlHtml')");
    //$ret = $html->find('a[title]');
    $retours = $html->find('li a[title^=Deputes]');
    
    //boucle sur les d�partements
    foreach($retours as $dept){
        
        $urlDept = $dept->attr["href"];
      //  $this->insert_table_urls ($urlDept,"find('li a[title^=Deputes]')");
        
        $url =$baseUrl.$urlDept;
        $htmlDept = $cl_Output->call('file_get_html',$url);       
     //   $this->insert_table_urls ($url,"file_get_html('$url')");
     
        $this->insert_table_urls ($url,"find('li a[title^=Deputes]')");
        //Extraction des noms des cantons
        //et insertion des cantons dans la table geoname 
      //  $this->extract_canton ($htmlDept); 
        list ($nom_cantons,$circonscription_cantons,$circonscriptions_depart,$type_geoname,$tabNomGeonameCantons) = $this->extract_canton ($htmlDept);

        //Extraction des infos sur les d�partements
       // $this->extract_departement ($urlDept,$dept);
        list ($numDepartDepute,$nomGeo_Depart,$type_geoname) = $this->extract_departement ($urlDept,$dept);
        //Insertion dans la table geoname
        $this->insert_table_geoname ($nomGeo_Depart,$type_geoname,$circonscriptions_depart);
                
        //extraction des liens des infos des d�put�es
        
        $rsDept = $htmlDept->find('td a[href^=/wiki/]');

        //Boucle sur les d�put�s
        foreach($rsDept as $depu){
            
            $urlDepu = $depu->attr["href"]; 
        //    $this->insert_table_urls ($urlDepu,"find('td a[href^=/wiki/]')");
            //v�rifie qu'on traite un d�put�
            $nom = substr($urlDepu,6,7);
            if($nom!="Deputes"){
           
            $urlDepute=$baseUrl.$urlDepu;
        //    $htmllienDepu = file_get_html($urlDepute);

            $htmllienDepu = $cl_Output->call('file_get_html',$urlDepute);
        //    $this->insert_table_urls ($urlDepute,"file_get_html('$urlDepute')");
        $this->insert_table_urls ($urlDepute,"find('td a[href^=/wiki/]')");
      //extraction des info du d�put�
//           $this->extract_deput ($htmllienDepu,$depu);   
      
list ($rslienQuest,$NomDepute,$PrenomDepute,$mailDepute,$numPhoneDepute,$lienANDepute) = $this->extract_deput ($htmllienDepu,$depu);
// Insertion dans la table depute         
$this->insert_table_depute ($NomDepute,$PrenomDepute,$mailDepute,$numPhoneDepute,$lienANDepute,$numDepartDepute);              
      
    foreach($rslienQuest as $quest){
            $urlQuestion = $quest->attr["href"];
            $urlQuestionResult = str_replace("&amp;", "&", $urlQuestion);
                        
          //  $htmlLienQuestion = file_get_html($urlQuestionResult);
            
            $htmlLienQuestion = $cl_Output->call('file_get_html',$urlQuestionResult);
         //   $this->insert_table_urls ($urlQuestionResult,"file_get_html('$urlQuestionResult')");
            $this->insert_table_urls ($urlQuestionResult,"find('li a[href$=Questions]')");
            
            // R�cup�rer les inforamations existantes dans tous les lignes 
            // du tableux questions, chaque ligne contien des informations sur une question
            
            $rsQuest = $htmlLienQuestion->find('tbody tr[valign=top]');
            //supprimer la premi�re ligne qui repr�sente le nom des colonnes
            $rsQuest1 = array_shift($rsQuest);
                  
            //Boucler sur les questions
            foreach($rsQuest as $info){
            //Extraction des informations d'une question, des mots-clefs et des rubriques
              $this->extract_infos_question ($info);
              list ($numLegislature,$numQuestion,$rubrique,$motclef,$datePubliQuestion,$dateRepQuestion) = $this->extract_infos_question ($info);
                   
            $this->insert_table_questions ($numQuestion,$datePubliQuestion,$dateRepQuestion,$numLegislature);
            $this->insert_table_motclef ($motclef);
            $this->insert_table_rubrique ($rubrique);
                    
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
    
        //Extraction du nom de d�partement  
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
            //supprimer la premi�re ligne qui repr�sente le nom des colonnes
            $rsCantons1 = array_shift($rsCantons);
                  
            //Boucler sur les Cantons
            $x = "";
            foreach($rsCantons as $cantons){
            $infosCantons = $cantons->children;
            
            $ChaineCantons = implode(";", $infosCantons);
            
            //Extraction des noms des cantons dans une chaine de caract�res
            $nom_cantons = $this->extractBetweenDelimeters($ChaineCantons,"(cantons de ",")");
           // $nom_cantons = filter ($nom_cantons1);
            //Insertion des noms des cantons dans un tableau
            $tabNomGeonameCantons = explode (",",$nom_cantons);
            
            foreach ($tabNomGeonameCantons as $value)
            {
            //Pr�ciser que le type de geoname d'un canton est canton
            // avant d'ins�rer le canton dans la table geoname
          //  $nom_geoname_canton = $this->filter ($value);
          $nom_geoname_canton = $value;
           // $nom_geoname_canton = $value;
            $type_geoname_canton = "canton";
            //Extraction du num�ro de circonscription du canton
            $circonscription_cantons = substr($ChaineCantons,5,1);    
            $this->insert_table_geoname ($nom_geoname_canton,$type_geoname_canton,$circonscription_cantons);
           
            
            $x = $x.",".$circonscription_cantons;
            }
            }
            //Les num�ros de circonscriptions qui existent dans un d�partement
            $circonscriptions_depart1 = substr($x,1);
            $circonscriptions_depart2 = explode (",",$circonscriptions_depart1);
            $circonscriptions_depart3 = array_unique ($circonscriptions_depart2);
            $circonscriptions_depart = implode(",", $circonscriptions_depart3);
            
            $type_geoname = "Ville";
         return array  ($nom_cantons,$circonscription_cantons,$circonscriptions_depart,$type_geoname,$tabNomGeonameCantons);   
            
        }

    function extract_deput ($htmllienDepu,$depu)
        {
       //boucle sur les d�put�s             
           //R�cup�ration du lien vers les questions d'un d�put�
              
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
                $this->insert_table_urls ($lienANDepute,"find('li a[title^=http://www.assemblee-nationale.fr]')");                
                }             
      //          insert_table_depute ($NomDepute,$PrenomDepute,$mailDepute,$numPhoneDepute,$lienANDepute,$numDepartDepute);
                
                return array  ($rslienQuest,$NomDepute,$PrenomDepute,$mailDepute,$numPhoneDepute,$lienANDepute);
 
              }
  
function extract_infos_question ($info)

{
            $infosChildren = $info->children;
            $Chaine = implode(";", $infosChildren);
            $NewChaine = str_replace("", "�", $Chaine);
            
            $lienQuest = $this->extractBetweenDelimeters($NewChaine,"href=","class");
            
           //Extraction des informations sur une question, les mots cl�s et les  rubriques
            $numLegislature1 = $this->extractBetweenDelimeters($lienQuest,".fr/q","/");
            $numLegislature = (int)$numLegislature1;
            
            $numQuestion1 = $this->extractBetweenDelimeters($lienQuest,$numLegislature."-","Q");
            $numQuestion = (int)$numQuestion1;
            
            $rubrique = $this->extractBetweenDelimeters($NewChaine,"Rubrique :","<br>");
       //     $rubrique = $this->filter ($rubrique1);
            
            $motclef = $this->extractBetweenDelimeters($NewChaine,"Mots cl�s :","</td>");
        //    $motclef = $this->filter ($motclef1);
                
        //    $chemindatePubliQuestion = $this->extractBetweenDelimeters($NewChaine,"$motclef1","</td>;<td");
        $chemindatePubliQuestion = $this->extractBetweenDelimeters($NewChaine,"$motclef","</td>;<td");
            
            $datePubliQuestion1 = substr($chemindatePubliQuestion,31);
            $datePubliQuestion2 = trim($datePubliQuestion1);
            $datePubliQuestion = $this->convertToDateFormat($datePubliQuestion2);
            
            $dateRepQuestion1 = $this->extractBetweenDelimeters($NewChaine,"$datePubliQuestion1</td>;<td class='TexteColonne'>","</td>");
            $dateRepQuestion2 = trim($dateRepQuestion1);
            $dateRepQuestion = $this->convertToDateFormat($dateRepQuestion2);
            
      return array ($numLegislature,$numQuestion,$rubrique,$motclef,$datePubliQuestion,$dateRepQuestion);
            
       }
  
       
 // Fonction qui r�cup�re une chaine inconnue entre deux chaines connues
 function extractBetweenDelimeters($inputstr,$delimeterLeft,$delimeterRight) {
    $posLeft  = stripos($inputstr,$delimeterLeft)+strlen($delimeterLeft);
    $posRight = stripos($inputstr,$delimeterRight,$posLeft+1);
    return  substr($inputstr,$posLeft,$posRight-$posLeft);
 }
 
 // Fnction qui supprime les caract�res sp�ciaux
 function filter($in) { 
    $search = array ('@[������]@i','@[�������]@i','@[��ii����]@i','@[������]@i','@[�������]@i','@[��]@i','@[���]@i','@[�]@i','@[ ]@i','@[^a-zA-Z0-9_]@');    
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

 function insert_table_questions ($num_question,$date_publication,$date_reponse,$num_legislature)
   {
  $db=new mysql ('localhost','root','','evalactipol');
  //$db=new mysql ($this->infos["SQL_HOST"],$this->infos["SQL_LOGIN"],'',$this->infos["SQL_DB"]);
//  $objSite = new Site($SITES, $site, $scope, false);
//  $db=new mysql ($objSite->infos["SQL_HOST"],$objSite->infos["SQL_LOGIN"],'',$objSite->infos["SQL_DB"]);
  $link=$db->connect();
  $sql = "INSERT INTO `questions` ( `id_question` , `num_question` , `date_publication` , `date_reponse` , `num_legislature` , `id_depute`, `id_URL` ) VALUES ('', \"$num_question\", \"$date_publication\", \"$date_reponse\", \"$num_legislature\", '', '')";     
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
      } //Fin de la classe extract

?>