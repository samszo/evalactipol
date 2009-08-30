<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * 
  * Nuage de mot ou tag cloud - floptwo :
  *
  * Selon Wikip�dia ( http://fr.wikipedia.org/wiki/Nuage_de_mots ) :
  * Le nuage de mots-cl�s (tag cloud en anglais) est une r�pr�sentation visuelle 
  *	des mots-cl�s (tag) les plus utilis�s sur un site web ou utilis�s pour classer 
  *	des objets num�riques.
  * G�n�ralement, les mots les plus utilis�s s'affichent dans des polices plus grandes. 
  * Le classement des mots est alphab�tique facilitant le r�p�rage des mots les plus populaires. 
  * Cliquer sur un mot sur l'image vous am�nera vers les pages associ�es � ce mot.
  * 
  * J'ai donc r�aliser cette classe afin de g�n�rer un nuage de mot ais�ment.
  *
  * Script r�alis�par floptwo (floptwo@gmail.com)
  * http://www.floptwo.com
  * * * * * * * * * * * * * * * * * * * * * * * * * * */
if(isset($_GET['id']))
		{$id = $_GET['id'];}
		$id_depute = substr($id,7);
		
require ('nuagemot-floptwo.class.php');
require ('database.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" lang="fr" xml:lang="en">

	<head>
		<meta http-equiv="Content-Language" content="fr" />
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>Nuage de mots (ou tag cloud) - floptwo</title>
	</head>

	<body>
		<div style="margin : auto ; width : 400px ; text-align : center">
<?php
// On d�clare la classe classe_nuagemot
$classe_nuagemot = new classe_nuagemot();

$db=new mysql ('localhost','root','','evalactipol');
	$db->connect();
	$sql = "SELECT COUNT( * ) nb, mc.id_motclef, valeur_motclef, nom_depute, prenom_depute, num_question, date_publication FROM `mot-clef` mc INNER JOIN `quest-mc` qmc ON qmc.id_motclef = mc.id_motclef INNER JOIN `questions` q ON q.id_question = qmc.id_question INNER JOIN depute d ON d.id_depute = q.id_depute AND d.id_depute =".$id_depute." GROUP BY mc.id_motclef";  
	$result = $db->query(utf8_decode($sql));
			
// Ici tu saisi toutes les donn�es que tu veux :
// s'il s'agit d'une liste de visites par membres
// $classe_nuagemot -> element_ajout (nom du membres, nombre de visites)

	while ($r = $db->fetch_assoc($result)) {
	
		$classe_nuagemot -> element_ajout (utf8_decode($r["valeur_motclef"]), $r["nb"]);
		
		}
	$db->close();
// (Il faut faire attention a ce que deux elements ne portes pas le meme nom
// Sinon c'est la valeur du dernier entr� qui sera prise en compte.)

// On execute les calculs
$element_liste_result = $classe_nuagemot -> execute ();

// On parcours la liste de r�sultat des don�es entr�es
foreach ($element_liste_result as $element_nom => $element_result)
{
	//	$element_nom : Nom de la donn�e 
	// $element_liste_result[$element_nom][0] : Score
	// $element_liste_result[$element_nom][1] : Taille de la police
	//echo '<span style="font-size:' , $element_liste_result[$element_nom][1] , 'pt;">';
	//echo $element_nom , ', visites : ' ,  $element_liste_result[$element_nom][0] , ' (' , $element_liste_result[$element_nom][1] , 'pt)';
	echo '<span style="font-size:' , $element_liste_result[$element_nom][1] , 'pt; a:hover{background:transparent;}">';
	echo $element_nom;
	
	echo '</span>';
	//echo '<br/>';
	echo ' - ';
}

/* * * * * * * * * * * * * * * * * * * * * * * * * * * 
 * script r�alis� par floptwo (floptwo@gmail.com)
 * http://www.floptwo.com
 * * * * * * * * * * * * * * * * * * * * * * * * * * */
?>
		</div>
	</body>

</html>