<?php


require("Classe_database.php");

class d�put� {

public $nom_deput�;
public $prenom_deput�;
public $num_depart_deput�;
public $mail_deput�;
public $url_d�put�;


// d�finition du constructeur 

public function d�put� ($url) 

{

//$this->nom_deput� = $nom;
//$this->prenom_deput� = $pr�nom;
//$this->num_depart_deput� = $num_depart;
//$this->mail_deput� = $mail;
$this->url_deput� = $url;


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

public function insert_table_depute ($nom,$prenom,$mail,$num_depart,$lien_AN_deput)
{


  $db=new mysql ('localhost','root','','evalactipol');
  $link=$db->connect();
  $sql = "INSERT INTO `depute` ( `id_d�put�` , `nom_d�put�` , `pr�nom_d�put�` , `mail_d�put�` , `d�part_d�put�` , `lien_AN_d�put�` , `num_g�oname` , `id_URL` ) VALUES ('', '$nom', '$prenom', '$mail', '$num_depart', '$lien_AN_deput', '', '')";     
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

public function GetCurl ($url)
        {
		
	  $Curl = curl_init($url);
	  curl_setopt($Curl, CURLOPT_RETURNTRANSFER, 1);
	  $Result = curl_exec($Curl);
	  curl_close($Curl);
          return $Result;
		
	}

}

?>