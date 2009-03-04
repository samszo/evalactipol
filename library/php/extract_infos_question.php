<?php

function extract_infos_question ($info)

{
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
            
      return array ($numLegislature,$numQuestion,$rubrique,$motclef,$datePubliQuestion,$dateRepQuestion);
            
}
?>