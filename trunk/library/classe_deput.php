<?php


require("Classe_database.php");

class député {

public $nom_deputé;
public $prenom_deputé;
public $num_depart_deputé;
public $mail_deputé;
public $url_député;


// définition du constructeur 

public function député ($url) 

{

//$this->nom_deputé = $nom;
//$this->prenom_deputé = $prénom;
//$this->num_depart_deputé = $num_depart;
//$this->mail_deputé = $mail;
$this->url_deputé = $url;


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
  $sql = "INSERT INTO `depute` ( `id_député` , `nom_député` , `prénom_député` , `mail_député` , `départ_député` , `lien_AN_député` , `num_géoname` , `id_URL` ) VALUES ('', '$nom', '$prenom', '$mail', '$num_depart', '$lien_AN_deput', '', '')";     
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