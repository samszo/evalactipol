<?php
require("Classe_database.php");

function insert_table_geoname ($nom_g�oname,$num_d�part,$id_URL)

{


  $db=new mysql ('localhost','root','','evalactipol');
  $link=$db->connect();
  $sql = "INSERT INTO `geoname` ( `num_g�oname` , `nom_g�oname` , `num_d�part` , `id_URL` ) VALUES ('', '$nom_g�oname', '$num_d�part', '$id_URL')";     
  $result = $db->query($sql);
  $db->close($link);


//  $base = mysql_connect ('localhost', 'root', '');  
//  mysql_select_db ('evalactipol', $base) ;
//  $sql = "INSERT INTO `depute` ( `id_d�put�` , `nom_d�put�` , `pr�nom_d�put�` , `mail_d�put�` , `d�part_d�put�` , `lien_AN_d�put�` , `num_g�oname` , `id_URL` ) VALUES ('', '$nom', '$prenom', '$mail', '$num_depart', '$lien_AN_deput', '', '')";  
//  mysql_query ($sql) or die ('Erreur SQL !'.$sql.'<br />'.mysql_error()); 
//  mysql_close();

}

?>