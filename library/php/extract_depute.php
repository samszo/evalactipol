<?php
//require_once ("extract_canton.php");

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
                $NomDepute1 = extractBetweenDelimeters($ChaineNomPrenom,""," ");
                $NomDepute = filter ($NomDepute1);
                $pos = strpos ($ChaineNomPrenom," ");
                $PrenomDepute1 = substr($ChaineNomPrenom,$pos+1);
                $PrenomDepute = filter ($PrenomDepute1);

                foreach($rslienLienANDepute as $lienANValue){
                $lienANDepute = $lienANValue->attr["href"];
                }             
                                  

      //          insert_table_depute ($NomDepute,$PrenomDepute,$mailDepute,$numPhoneDepute,$lienANDepute,$numDepartDepute);
                
                return array  ($rslienQuest,$NomDepute,$PrenomDepute,$mailDepute,$numPhoneDepute,$lienANDepute);

            
          
 }
?>