<?php
class depute extends site{

public $nom_depute;
public $prenom_depute;
public $num_depart_depute;
public $mail_depute;
public $url_depute;

// définition du constructeur 

public function depute ($url) 

{

//$this->nom_depute = $nom;
//$this->prenom_depute = $prénom;
//$this->num_depart_depute = $num_depart;
//$this->mail_depute = $mail;
$this->url_depute = $url;

}
public function recup_fiche_deput ($url)
{

  $result = $this->GetCurl ($url);
  return $result;

}
public function recup_nom_deput ($result)
{

  $nom = "touibi";
  return $nom;
}
public function recup_prenom_deput ($result)
{

  $prenom = "mehdi";
  return $prenom;
}
public function recup_mail_deput ($result)
{
  $mail = "xxxx";
  return $mail;
}
public function recup_lien_AN_deput ($result)
{
  $lien_AN_deput = "yyyy";
  return $lien_AN_deput;
}
public function recup_lien_questions_deput ($result)
{
}
public function recup_num_depart_deput ($url)
{
  $num_depart = "1";
  return $num_depart;
}
public function insert_table_depute ($nom,$prenom,$mail,$lien_AN_deput,$num_depart)
{
  $db=new mysql ('localhost','root','','evalactipol');
  $link=$db->connect();
  $sql = "INSERT INTO `depute` ( `id_depute` , `nom_depute` , `prenom_depute` , `mail_depute` , `lien_AN_depute` , `num_depart_depute` ) VALUES ('', '$nom', '$prenom', '$mail', '$lien_AN_deput', '$num_depart')";     
  $result = $db->query($sql);
  $db->close($link);
}
public function recup_questions_deput ($lien_questions_deput)
{
}
public function recup_date_publi_questions_deput ($result_question)
{
}
public function recup_date_rep_questions_deput ($result_question)
{
}
public function insert_questions_deput ($num,$date_pub,$date_rep)
{
}
public function recup_motsclefs_deput ($result_question)
{
}
public function insert_motsclefs_deput ($motclef)
{
}
public function recup_rubriques_deput ($result_question)
{
}
public function insert_rubriques_deput ($rubrique)
{
}



}
	

?>