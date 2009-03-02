<?php

require_once ("param/ParamPage.php");
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
 
  function insert_table_geoname ($nomGeo,$typeGeo,$circonscGeo,$latGeo,$lngGeo,$altGeo,$kmlGeo)
    {
  $db=new mysql ('localhost','root','','evalactipol');
  $link=$db->connect();
  $sql = "INSERT INTO `geoname` ( `id_geoname` , `nom_geoname`, `typt_geoname`, `circonscriptions_geoname`, `lat_geoname`, `lng_geoname`, `alt_geoname`, `kml_geoname` ) VALUES ('$nomGeo', '$typeGeo', '$circonscGeo', '$latGeo', '$lngGeo', '$altGeo', '$kmlGeo')";     
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
		
        //Extraction du numéro du département
		$numDepart = substr($urlDept,14);	
	
		//Extraction du nom de département 	
		$NomDepart = $dept->nodes;
        $ChaineNomDepart = implode(";", $NomDepart);
        $nomGeo_Depart = extractBetweenDelimeters($ChaineNomDepart,""," ");
    		
		//Extraction des noms des cantons
			        
            $rsCantons = $htmlDept->find('tbody tr');
            //supprimer la première ligne qui représente le nom des colonnes
            $rsCantons1 = array_shift($rsCantons);
                  
            //Boucler sur les Cantons
            $x = "";
            foreach($rsCantons as $cantons){
            $infosCantons = $cantons->children;
            
            $ChaineCantons = implode(";", $infosCantons);
            
            //Extraction des noms des cantons dans une chaine de caractères
            $nom_geoname_cantons = extractBetweenDelimeters($ChaineCantons,"(cantons de ",")");
            //Insertion des noms des cantons dans un tableau
            $tabNomGeonameCantons = explode (",",$nom_geoname_cantons);
          //  foreach ($tabNomGeonameCantons as $value)
         //   {
            //Préciser que le type de geoname d'un canton est canton
            // avant d'insérer le canton dans la table geoname
         //   $type_geoname_canton = "canton";    
         //   }
           //Extraction du numéro de circonscription du canton
            $circonscription_cantons = substr($ChaineCantons,5,1);
            $x = $x.",".$circonscription_cantons;
            }
            //Les numéros de circonscriptions qui existent dans un département
            $circonscriptions_depart = substr($x,2);	
				
		//extraction des infos des députées
		$rsDept = $htmlDept->find('td a[href^=/wiki/]');
        //boucle sur les députés 	
  	     foreach($rsDept as $depu){
 			$urlDepu = $depu->attr["href"];	
			//vérifie qu'on traite un député
			$nom = substr($urlDepu,6,7);
			if($nom!="Deputes"){
		   //extraction des info du député
			$urlDepute=$baseUrl.$urlDepu;
 			$htmllienDepu = file_get_html($urlDepute);
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
                $NomDepute1 = extractBetweenDelimeters($ChaineNomPrenom,""," ");
                $NomDepute = filter ($NomDepute1);
                $pos = strpos ($ChaineNomPrenom," ");
                $PrenomDepute1 = substr($ChaineNomPrenom,$pos+1);
                $PrenomDepute = filter ($PrenomDepute1);

                foreach($rslienLienANDepute as $lienANValue){
 			    $lienANDepute = $lienANValue->attr["href"];
                }    		  
                	  
 		        $numDepartDepute = (int)$numDepart;
 		      	  
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
            $infosChildren = $info->children;
            $Chaine = implode(";", $infosChildren);
            $NewChaine = str_replace("", "é", $Chaine);
            
            $lienQuest = extractBetweenDelimeters($NewChaine,"href=","class");
            
           //Extraction des informations sur une question, les mots clés et les  rubriques
            $numLegislature1 = extractBetweenDelimeters($lienQuest,".fr/q","/");
            $numLegislature = (int)$numLegislature1;
            
            $numQuestion1 = extractBetweenDelimeters($lienQuest,$numLegislature."-","Q");
            $numQuestion = (int)$numQuestion1;
            
            $rubrique1 = extractBetweenDelimeters($NewChaine,"Rubrique :","<br>");
            $rubrique = filter ($rubrique1);
            
            $motclef1 = extractBetweenDelimeters($NewChaine,"Mots clés :","</td>");
            $motclef = filter ($motclef1);
                
            $chemindatePubliQuestion = extractBetweenDelimeters($NewChaine,"$motclef1","</td>;<td");
            
            $datePubliQuestion1 = substr($chemindatePubliQuestion,31);
            $datePubliQuestion2 = trim($datePubliQuestion1);
            $datePubliQuestion = convertToDateFormat($datePubliQuestion2);
            
            $dateRepQuestion1 = extractBetweenDelimeters($NewChaine,"$datePubliQuestion1</td>;<td class='TexteColonne'>","</td>");
            $dateRepQuestion2 = trim($dateRepQuestion1);
            $dateRepQuestion = convertToDateFormat($dateRepQuestion2);
                   
            insert_table_questions ($numQuestion,$datePubliQuestion,$dateRepQuestion,$numLegislature);
            insert_table_motclef ($motclef);
            insert_table_rubrique ($rubrique);
                    
            }
           }
	      }
	     }
	    }
				
?>