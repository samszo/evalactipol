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
  
class classe_nuagemot
{
	var $taillepolice_min; // La plus petite taille de police
	var $taillepolice_max; // La plus grande taille de police

	// function classe_nuagemot initialise la classe
	// Par  d�faut la plus petite taille de police sera 8 et la plus grand 20
	function classe_nuagemot ($taillepolice_min = 10, $taillepolice_max = 18)
	{
		$this -> taillepolice_min = $taillepolice_min;
		$this -> taillepolice_max = $taillepolice_max;
	}
	
	function element_ajout($element_nom, $element_score)
	{
		// Ajout de donn�es au tableau
		$this -> element_liste [$element_nom] = $element_score;
	}
	
	function execute ()
	{
		// Calcul du coefficent de proportionalit�
		$element_max = max ($this -> element_liste);
		$element_min = min ($this -> element_liste);
		$calcul_element = $element_max - $element_min;
		
		$taillepolice_min = $this -> taillepolice_min;
		$taillepolice_max = $this -> taillepolice_max;
		$calcul_taillepolice = $taillepolice_max - $taillepolice_min;	
		
		$calcul_div = $calcul_element / $calcul_taillepolice;
		
		// On parcours la liste des don�es entr�es
		foreach ($this -> element_liste as $element_nom => $element_score)
		{
			// Calcul me permettant d'obtenir la taille de police de chaque �l�ment
			$element_taillepolice = $taillepolice_min + round ($element_score / $calcul_div);
			
			// On place les r�sultats dans un tableau 
			// $element_liste_result [ nom de l'�l�ment ][ 0 ] : Score 
			// $element_liste_result [ nom de l'�l�ment ][ 1 ] : Taille de la police
			$element_liste_result [$element_nom] = array ($element_score, $element_taillepolice);
		}
		
		return $element_liste_result;
	}
}

/* * * * * * * * * * * * * * * * * * * * * * * * * * * 
 * script r�alis� par floptwo (floptwo@gmail.com)
 * http://www.floptwo.com
 * * * * * * * * * * * * * * * * * * * * * * * * * * */
?>