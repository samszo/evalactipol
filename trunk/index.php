<?php
	
require_once ("param/ParamPage.php");

// Fonction qui r�cup�re une chaine inconnue entre deux chaines connues

function extractBetweenDelimeters($inputstr,$delimeterLeft,$delimeterRight) {
    $posLeft  = stripos($inputstr,$delimeterLeft)+strlen($delimeterLeft);
    $posRight = stripos($inputstr,$delimeterRight,$posLeft+1);
    return  substr($inputstr,$posLeft,$posRight-$posLeft);
 }
 
 
	$baseUrl ="http://www.laquadrature.net";
	$html = file_get_html($baseUrl."/wiki/Deputes_par_departement");
	//$ret = $html->find('a[title]');
	$retours = $html->find('li a[title^=Deputes]');

	//boucle sur les d�partements
	foreach($retours as $dept){
		$urlDept = $dept->attr["href"];	
		//extraction des infos des d�put�es
		$url =$baseUrl.$urlDept;
		$htmlDept = file_get_html($url);
		//$ret = $html->find('a[title]');
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
                       
            
            }
            
            
            
           }
	}
			
			
			}
		}
				
				
	
	
?>