<?php

require_once ("param/ParamPage.php");
//require_once("library/php/simple_html_dom.php");


// Fonction qui r�cup�re une chaine inconnue entre deux chaines connues

 function extractBetweenDelimeters($inputstr,$delimeterLeft,$delimeterRight) {
    $posLeft  = stripos($inputstr,$delimeterLeft)+strlen($delimeterLeft);
    $posRight = stripos($inputstr,$delimeterRight,$posLeft+1);
    return  substr($inputstr,$posLeft,$posRight-$posLeft);
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
  
	$baseUrl ="http://www.laquadrature.net";
	$html = file_get_html($baseUrl."/wiki/Deputes_par_departement");
	//$ret = $html->find('a[title]');
	$retours = $html->find('li a[title^=Deputes]');

	//boucle sur les d�partements
	foreach($retours as $dept){
		$urlDept = $dept->attr["href"];
		$url =$baseUrl.$urlDept;
        $htmlDept = file_get_html($url);
		
        //Extraction du num�ro du d�partement
		$numDepart = substr($urlDept,14);	
	
		//Extraction du nom de d�partement 	
		$NomDepart = $dept->nodes;
        $ChaineNomDepart = implode(";", $NomDepart);
        $nomGeo_Depart = extractBetweenDelimeters($ChaineNomDepart,""," ");
    		
		//Extraction des noms des cantons
			        
            $rsCantons = $htmlDept->find('tbody tr');
            //supprimer la premi�re ligne qui repr�sente le nom des colonnes
            $rsCantons1 = array_shift($rsCantons);
                  
            //Boucler sur les Cantons
            $x = "";
            foreach($rsCantons as $cantons){
            $infosCantons = $cantons->children;
            
            $ChaineCantons = implode(";", $infosCantons);
            
            //Extraction des noms des cantons dans une chaine de caract�res
            $nom_geoname_cantons = extractBetweenDelimeters($ChaineCantons,"(cantons de ",")");
            //Insertion des noms des cantons dans un tableau
            $tabNomGeonameCantons = explode (",",$nom_geoname_cantons);
            foreach ($tabNomGeonameCantons as $value)
            {
            //Pr�ciser que le type de geoname d'un canton est canton
            // avant d'ins�rer le canton dans la table geoname
            $type_geoname_canton = "canton";    
            }
           //Extraction du num�ro de circonscription du canton
            $circonscription_cantons = substr($ChaineCantons,5,1);
            $x = $x.",".$circonscription_cantons;
            }
            //Les num�ros de circonscriptions qui existent dans un d�partement
            $circonscriptions_depart = $x;		
				
   		
		//extraction des infos des d�put�es
		$rsDept = $htmlDept->find('td a[href^=/wiki/]');
        //boucle sur les d�put�s 	
  	     foreach($rsDept as $depu){
 			$urlDepu = $depu->attr["href"];	
			//v�rifie qu'on traite un d�put�
			$nom = substr($urlDepu,6,7);
			if($nom!="Deputes"){
				//extraction des info du d�put�
			//	echo $depu;
			$urlDepute=$baseUrl.$urlDepu;
 			$htmllienDepu = file_get_html($urlDepute);
		        //R�cup�ration du lien vers les questions d'un d�put�
		      
 			  $rslienQuest = $htmllienDepu->find('li a[href$=Questions]');   			  
 	//		  $rslienNomPrenom = $htmllienDepu->find('h2 span[class=mw-headline]');
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
                 //    if ($numPhoneValue2 != $numPhoneValue1)                  
                 //    {
                     $numPhoneDepute2 = substr($numPhoneValue2,9);
                 //    }           
                     }
                  else
                  {
                    
                  $numPhoneValue1 = $numPhone->attr["href"];
                  $numPhoneDepute1 = substr($numPhoneValue1,9);
                  $numPhoneDepute1 = $numPhoneDepute1;
                  }			    
 	            }
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

            //    foreach($depu as $NomPrenomValue){
                  
                $NomPrenom = $depu->nodes;
                $ChaineNomPrenom = implode(";", $NomPrenom);
                $NomDepute = extractBetweenDelimeters($ChaineNomPrenom,""," ");
                $pos = strpos ($ChaineNomPrenom," ");
                $PrenomDepute = substr($ChaineNomPrenom,$pos+1);
             //   $PrenomDepute = extractBetweenDelimeters($ChaineNomPrenom," ","n");
            //    }

                foreach($rslienLienANDepute as $lienANValue){
 			    $lienANDepute = $lienANValue->attr["href"];
                }    		  
 			  
 		        $numDepartDepute = $numDepart;
 		      	  
                 	
 			  
			
			foreach($rslienQuest as $quest){
                        $urlQuestion = $quest->attr["href"];
                        $urlQuestionResult = str_replace("&amp;", "&", $urlQuestion);
      //      echo $urlQuestionResult;
            
            
            $htmlLienQuestion = file_get_html($urlQuestionResult);
			
            // R�cup�rer les inforamations existantes dans tous les lignes 
            // du tableux questions, chaque ligne contien des informations sur une question
            
            $rsQuest = $htmlLienQuestion->find('tbody tr[valign=top]');
            //supprimer la premi�re ligne qui repr�sente le nom des colonnes
            $rsQuest1 = array_shift($rsQuest);
      //            $rsQuest = $htmlLienQuestion->find('tbody tr[bgcolor!=#a5cafe]');
            
            //Boucler sur les questions
            foreach($rsQuest as $info){
            $infosChildren = $info->children;
            $Chaine = implode(";", $infosChildren);
            $NewChaine = str_replace("", "�", $Chaine);
            
            $lienQuest = extractBetweenDelimeters($NewChaine,"href=","class");
            
           //Extraction des informations sur une question, les mots cl�s et les  rubriques
            $numLegislature = extractBetweenDelimeters($lienQuest,".fr/q","/");
            $numQuestion = extractBetweenDelimeters($lienQuest,$numLegislature."-","Q");
            $rubrique = extractBetweenDelimeters($NewChaine,"Rubrique :","<br>");
            $motclef = extractBetweenDelimeters($NewChaine,"Mots cl�s :","</td>");
            
            $chemindatePubliQuestion = extractBetweenDelimeters($NewChaine,"$motclef","</td>;<td");
            $datePubliQuestion1 = substr($chemindatePubliQuestion,31);
            $datePubliQuestion = trim($datePubliQuestion1);
            
            $dateRepQuestion1 = extractBetweenDelimeters($NewChaine,"$datePubliQuestion1</td>;<td class='TexteColonne'>","</td>");
            $dateRepQuestion = trim($dateRepQuestion1);
            insert_table_motclef ($motclef);
//            insert_table_questions ($numQuestion,$datePubliQuestion,$dateRepQuestion,$numLegislature);
            
            }
            
            
            
           }
	}
			
			
			}
		}
				
				

	
?>