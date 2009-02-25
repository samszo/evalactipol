<?php

require("Classe_database.php");

function insert_table_questions ($num_question,$date_publication,$date_réponse,$id_député,$id_URL)
{


  $db=new mysql ('localhost','root','','evalactipol');
  $link=$db->connect();
  $sql = "INSERT INTO `questions` ( `id_question` , `num_question` , `date_publication` , `date_réponse` , `id_député` , `id_URL` ) VALUES ('', '$num_question', '$date_publication', '$date_réponse', '$id_député', '$id_URL')";     
  $result = $db->query($sql);
  $db->close($link);


//  $base = mysql_connect ('localhost', 'root', '');  
//  mysql_select_db ('evalactipol', $base) ;
//  $sql = "INSERT INTO `depute` ( `id_député` , `nom_député` , `prénom_député` , `mail_député` , `départ_député` , `lien_AN_député` , `num_géoname` , `id_URL` ) VALUES ('', '$nom', '$prenom', '$mail', '$num_depart', '$lien_AN_deput', '', '')";  
//  mysql_query ($sql) or die ('Erreur SQL !'.$sql.'<br />'.mysql_error()); 
//  mysql_close();

}

?>