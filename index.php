<?php
	
require_once ("param/ParamPage.php");

// Fonction qui récupère une chaine inconnue entre deux chaines connues

function extractBetweenDelimeters($inputstr,$delimeterLeft,$delimeterRight) {
    $posLeft  = stripos($inputstr,$delimeterLeft)+strlen($delimeterLeft);
    $posRight = stripos($inputstr,$delimeterRight,$posLeft+1);
    return  substr($inputstr,$posLeft,$posRight-$posLeft);
 }
 
 
	$baseUrl ="http://www.laquadrature.net";
	$html = file_get_html($baseUrl."/wiki/Deputes_par_departement");
	//$ret = $html->find('a[title]');
	$retours = $html->find('li a[title^=Deputes]');

	//boucle sur les départements
	foreach($retours as $dept){
		$urlDept = $dept->attr["href"];	
		//extraction des infos des députées
		$url =$baseUrl.$urlDept;
		$htmlDept = file_get_html($url);
		//$ret = $html->find('a[title]');
   		$rsDept = $htmlDept->find('td a[href^=/wiki/]');
        //boucle sur les députés 	
  	foreach($rsDept as $depu){
			$urlDepu = $depu->attr["href"];	
			//vérifie qu'on traite un député
			$nom = substr($urlDepu,6,7);
			if($nom!="Deputes"){
				//extraction des info du député
			//	echo $depu;
			$urlDepute=$baseUrl.$urlDepu;
 			$htmllienDepu = file_get_html($urlDepute);
		        //Récupération du lien vers les questions d'un député
                 	$rslienQuest = $htmllienDepu->find('li a[href$=Questions]');
			
			foreach($rslienQuest as $quest){
                        $urlQuestion = $quest->attr["href"];
                        $urlQuestionResult = str_replace("&amp;", "&", $urlQuestion);
      //      echo $urlQuestionResult;
            
            
            $htmlLienQuestion = file_get_html($urlQuestionResult);
			
            // Récupérer les inforamations existantes dans tous les lignes 
            // du tableux questions, chaque ligne contien des informations sur une question
            
            $rsQuest = $htmlLienQuestion->find('tbody tr[valign=top]');
            //supprimer la première ligne qui représente le nom des colonnes
            $rsQuest1 = array_shift($rsQuest);
      //            $rsQuest = $htmlLienQuestion->find('tbody tr[bgcolor!=#a5cafe]');
            
            //Boucler sur les questions
            foreach($rsQuest as $info){
            $infosChildren = $info->children;
            
            $Chaine = implode(";", $infosChildren);
            $NewChaine = str_replace("", "é", $Chaine);
            
            $lienQuest = extractBetweenDelimeters($NewChaine,"href=","class");
            
           //Extraction des informations sur une question, les mots clés et les  rubriques
            $numLegislature = extractBetweenDelimeters($lienQuest,".fr/q","/");
            $numQuestion = extractBetweenDelimeters($lienQuest,$numLegislature."-","Q");
            $rubrique = extractBetweenDelimeters($NewChaine,"Rubrique :","<br>");
            $motclef = extractBetweenDelimeters($NewChaine,"Mots clés :","</td>");
            
            $chemindatePubliQuestion = extractBetweenDelimeters($NewChaine,"$motclef","</td>;<td");
            $datePubliQuestion1 = substr($chemindatePubliQuestion,31);
            $datePubliQuestion = trim($datePubliQuestion1);
            
            $dateRepQuestion1 = extractBetweenDelimeters($NewChaine,"$datePubliQuestion1</td>;<td class='TexteColonne'>","</td>");
            $dateRepQuestion = trim($dateRepQuestion1);
                       
            
            }
            
            
            
           }
	}
			
			
			}
		}
				
				
	
	
?>