<?php

require("classe_deput.php");
require("Curl_exec.php");
//require("Classe_database.php");
//require("insert_table_geoname.php");
//require("insert_table_villes.php");
//require("insert_table_URLs.php");
//require("insert_table_motclef.php");
//require("insert_table_questions.php");
//require("insert_table_rubrique.php");


  $link_page="http://www.laquadrature.net/wiki/Deputes_par_departement";

  $result = Curl ($link_page);

for ($i = 11; $i <= 988; $i++) 
 {

 $url="/wiki/Deputes_$i";
 preg_match ("|<[aA] (.+?)".$url."(.+?)>(.+?)<\/[aA]>|i", $result, $matches);

  if (count($matches)>0)
   {
    $link_page1="http://www.laquadrature.net$url";

    $depute=new député ($link_page1);
    
    $result1=$depute->recup_fiche_deput ($link_page1);

    $nom1=$depute->recup_nom_deput ($result1);
    $prenom1=$depute->recup_nom_deput ($result1);
    $num_depart1=$depute->recup_num_depart_deput ($result1);
    $mail1=$depute->recup_mail_deput ($result1);
    $lien_AN_deput1=$depute->recup_lien_AN_deput ($result1);
    
    $result_insert_deput=$depute->insert_table_depute ($nom1,$prenom1,$mail1,$num_depart1,$lien_AN_deput1);
       

    $url1="/wiki/RolandBlum";
    preg_match ("|<[aA] (.+?)".$url1."(.+?)>(.+?)<\/[aA]>|i", $result1, $matches);

    if (count($matches)>0)

     {
      
      $link_page2="http://www.laquadrature.net/wiki/RolandBlum";
      $result2=Curl ($link_page2);
       
      
      $url2="http://recherche2.assemblee-nationale.fr/resultats_tribun.jsp?id_auteur=Blum%20Roland&nom_auteur=Roland%20Blum&legislature=13&typedoc=Questions";
      preg_match ("|<[aA] (.+?)".$url1."(.+?)>(.+?)<\/[aA]>|i", $result2, $matches);

          if (count($matches)>0)
           {

            $link_page3="http://recherche2.assemblee-nationale.fr/resultats_tribun.jsp?id_auteur=Blum%20Roland&nom_auteur=Roland%20Blum&legislature=13&typedoc=Questions";
            $result3=Curl ($link_page3);
            echo $result3; 

           }

          else

           {
            echo "The link does not exist on the target website";
           }

     }

    else

     {
//     echo "The link does not exist on the target website";
     }

 }

  else
   {
    echo "The link does not exist on the target website";
   }

} // fin fe la boucle for


?>