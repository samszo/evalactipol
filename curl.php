<?php

$link_page="http://www.laquadrature.net/wiki/Deputes_par_departement";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$link_page);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
$result=curl_exec ($ch);
curl_close ($ch);

for ($i = 11; $i <= 988; $i++) 
 {

 $url="/wiki/Deputes_$i";
 preg_match ("|<[aA] (.+?)".$url."(.+?)>(.+?)<\/[aA]>|i", $result, $matches);

  if (count($matches)>0)
   {
    //  echo "The link exists on the target website";
    //  print_r($matches);
    $link_page1="http://www.laquadrature.net$url";
    $ch1 = curl_init();
    // $timeout = 10;
    //curl_setopt($ch1, CURLOPT_TIMEOUT, 10);
    //curl_setopt($ch1, CURLOPT_MAXCONNECTS, 10);
    //curl_setopt($ch1, CURLOPT_CONNECTTIMEOUT, 0);
    curl_setopt($ch1, CURLOPT_URL,$link_page1);
    curl_setopt($ch1, CURLOPT_RETURNTRANSFER,1);
    $result1=curl_exec ($ch1);

    //curl_setopt($ch1, CURLOPT_TIMEOUT, $timeout);
    curl_close ($ch1);

    //echo $result1; 

    /*$ch1 = curl_init();
    $fp = fopen("example_midou0000.txt", "w");
    curl_setopt($ch1, CURLOPT_URL,$link_page1);
    curl_setopt($ch1, CURLOPT_FILE, $fp);
    curl_setopt($ch1, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch1, CURLOPT_HEADER, 0);
    curl_exec($ch1);
    curl_close($ch1);
    fclose($fp); */

    $url1="/wiki/RolandBlum";
    preg_match ("|<[aA] (.+?)".$url1."(.+?)>(.+?)<\/[aA]>|i", $result1, $matches);

    if (count($matches)>0)

     {
      $link_page2="http://www.laquadrature.net/wiki/RolandBlum";
      $ch2 = curl_init();
      curl_setopt($ch2, CURLOPT_URL,$link_page2);
      curl_setopt($ch2, CURLOPT_RETURNTRANSFER,1);
      $result2=curl_exec ($ch2);
      curl_close ($ch2);
//    echo $result2; 
      
      $url2="http://recherche2.assemblee-nationale.fr/resultats_tribun.jsp?id_auteur=Blum%20Roland&nom_auteur=Roland%20Blum&legislature=13&typedoc=Questions";
      preg_match ("|<[aA] (.+?)".$url1."(.+?)>(.+?)<\/[aA]>|i", $result2, $matches);

          if (count($matches)>0)
           {

            $link_page3="http://recherche2.assemblee-nationale.fr/resultats_tribun.jsp?id_auteur=Blum%20Roland&nom_auteur=Roland%20Blum&legislature=13&typedoc=Questions";
            $ch3 = curl_init();
            curl_setopt($ch3, CURLOPT_URL,$link_page3);
            curl_setopt($ch3, CURLOPT_RETURNTRANSFER,1);
            $result3=curl_exec ($ch3);
            curl_close ($ch3);
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