<?php

require_once ("param/ParamPage.php");
require_once ("library/php/extract_depute.php");
require_once ("library/php/extract_canton.php");
require_once ("library/php/extract_infos_question.php");
require_once ("library/php/extract_departement.php");

//require_once("library/php/simple_html_dom.php");

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
  $db=new mysql ('localhost','root','','evalactipol');
  $link=$db->connect();
  $sql = "INSERT INTO `geoname` ( `id_geoname` , `nom_geoname`, `type_geoname`, `circonscriptions_geoname`, `lat_geoname`, `lng_geoname`, `alt_geoname`, `kml_geoname` ) VALUES ('', '$nomGeo', '$typeGeo', '$circonscGeo', '', '', '', '')";     
  $result = $db->query($sql);
  $db->close($link);
   }
 function insert_table_depute ($nom,$prenom,$mail,$numphone,$lien_AN_deput,$num_depart)
  {
  $db=new mysql ('localhost','root','','evalactipol');
  $link=$db->connect();
  $sql = "INSERT INTO `depute` ( `id_depute` , `nom_depute` , `prenom_depute` , `mail_depute` , `numphone_depute` , `lien_AN_depute` , `num_depart_depute` ) VALUES ('', '$nom', '$prenom', '$mail', '$numphone', '$lien_AN_deput', '$num_depart')";     
  $result = $db->query($sql);
  $db->close($link);
}

 function insert_table_questions ($num_question,$date_publication,$date_reponse,$num_legislature)
   {
  $db=new mysql ('localhost','root','','evalactipol');
  $link=$db->connect();
  $sql = "INSERT INTO `questions` ( `id_question` , `num_question` , `date_publication` , `date_reponse` , `num_legislature` , `id_depute`, `id_URL` ) VALUES ('', '$num_question', '$date_publication', '$date_reponse', '$num_legislature', '', '')";     
  $result = $db->query($sql);
  $db->close($link);
   }
   
   function insert_table_motclef ($valeur_MC)
    {
  $db=new mysql ('localhost','root','','evalactipol');
  $link=$db->connect();
  $sql = "INSERT INTO `mot-clef` ( `id_motclef` , `valeur_motclef` ) VALUES ('', '$valeur_MC')";     
  $result = $db->query($sql);
  $db->close($link);
   }
   function insert_table_rubrique ($valeurRubrique)
    {
  $db=new mysql ('localhost','root','','evalactipol');
  $link=$db->connect();
  $sql = "INSERT INTO `rubrique` ( `id_rubrique` , `valeur_rubrique` ) VALUES ('', '$valeurRubrique')";     
  $result = $db->query($sql);
  $db->close($link);
   }
       	
   $baseUrl ="http://www.laquadrature.net";
	$html = file_get_html($baseUrl."/wiki/Deputes_par_departement");
	//$ret = $html->find('a[title]');
	$retours = $html->find('li a[title^=Deputes]');
	
	//boucle sur les départements
	foreach($retours as $dept){
        
	    $urlDept = $dept->attr["href"];
        $url =$baseUrl.$urlDept;
        $htmlDept = file_get_html($url);       
        
        //Extraction des noms des cantons
        //et insertion des cantons dans la table geoname 
        extract_canton ($htmlDept); 
        list ($nom_cantons,$circonscription_cantons,$circonscriptions_depart,$type_geoname,$tabNomGeonameCantons) = extract_canton ($htmlDept);

        //Extraction des infos sur les départements
        extract_departement ($urlDept,$dept);
        list ($numDepartDepute,$nomGeo_Depart,$type_geoname) = extract_departement ($urlDept,$dept);
        //Insertion dans la table geoname
        insert_table_geoname ($nomGeo_Depart,$type_geoname,$circonscriptions_depart);
                
        //extraction des liens des infos des députées
        
        $rsDept = $htmlDept->find('td a[href^=/wiki/]');

        //Boucle sur les députés
        foreach($rsDept as $depu){
            
            $urlDepu = $depu->attr["href"]; 
            //vérifie qu'on traite un député
            $nom = substr($urlDepu,6,7);
            if($nom!="Deputes"){
           
            $urlDepute=$baseUrl.$urlDepu;
            $htmllienDepu = file_get_html($urlDepute);	  
	  //extraction des info du député
	       extract_deput ($htmllienDepu,$depu);	  
	  
list ($rslienQuest,$NomDepute,$PrenomDepute,$mailDepute,$numPhoneDepute,$lienANDepute) = extract_deput ($htmllienDepu,$depu);
// Insertion dans la table depute      	  
insert_table_depute ($NomDepute,$PrenomDepute,$mailDepute,$numPhoneDepute,$lienANDepute,$numDepartDepute);           	
 			  
		
	foreach($rslienQuest as $quest){
            $urlQuestion = $quest->attr["href"];
            $urlQuestionResult = str_replace("&amp;", "&", $urlQuestion);
                        
            $htmlLienQuestion = file_get_html($urlQuestionResult);
			
            // Récupérer les inforamations existantes dans tous les lignes 
            // du tableux questions, chaque ligne contien des informations sur une question
            
            $rsQuest = $htmlLienQuestion->find('tbody tr[valign=top]');
            //supprimer la première ligne qui représente le nom des colonnes
            $rsQuest1 = array_shift($rsQuest);
                  
            //Boucler sur les questions
            foreach($rsQuest as $info){
            //Extraction des informations d'une question, des mots-clefs et des rubriques
              extract_infos_question ($info);
            
            list ($numLegislature,$numQuestion,$rubrique,$motclef,$datePubliQuestion,$dateRepQuestion) = extract_infos_question ($info);
                   
            insert_table_questions ($numQuestion,$datePubliQuestion,$dateRepQuestion,$numLegislature);
            insert_table_motclef ($motclef);
            insert_table_rubrique ($rubrique);
                    
            }
           }
	      }
	     }
	    }				
?>