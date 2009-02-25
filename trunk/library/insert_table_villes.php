<?php

require("Classe_database.php");

function insert_table_villes ($nom_ville,$num_géoname,$id_député)
{


  $db=new mysql ('localhost','root','','evalactipol');
  $link=$db->connect();
  $sql = "INSERT INTO `villes` ( `id_ville` , `nom_ville` , `num_géoname` , `id_député` ) VALUES ('', '$nom_ville', '$num_géoname', '$id_député')";     
  $result = $db->query($sql);
  $db->close($link);


//  $base = mysql_connect ('localhost', 'root', '');  
//  mysql_select_db ('evalactipol', $base) ;
//  $sql = "INSERT INTO `depute` ( `id_député` , `nom_député` , `prénom_député` , `mail_député` , `départ_député` , `lien_AN_député` , `num_géoname` , `id_URL` ) VALUES ('', '$nom', '$prenom', '$mail', '$num_depart', '$lien_AN_deput', '', '')";  
//  mysql_query ($sql) or die ('Erreur SQL !'.$sql.'<br />'.mysql_error()); 
//  mysql_close();

}

?>