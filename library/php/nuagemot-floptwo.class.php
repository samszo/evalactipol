<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * 
  * Nuage de mot ou tag cloud - floptwo :
  *
  * Selon Wikipédia ( http://fr.wikipedia.org/wiki/Nuage_de_mots ) :
  * Le nuage de mots-clés (tag cloud en anglais) est une réprésentation visuelle 
  *	des mots-clés (tag) les plus utilisés sur un site web ou utilisés pour classer 
  *	des objets numériques.
  * Généralement, les mots les plus utilisés s'affichent dans des polices plus grandes. 
  * Le classement des mots est alphabétique facilitant le répérage des mots les plus populaires. 
  * Cliquer sur un mot sur l'image vous amènera vers les pages associées à ce mot.
  * 
  * J'ai donc réaliser cette classe afin de générer un nuage de mot aisément.
  *
  * Script réalisépar floptwo (floptwo@gmail.com)
  * http://www.floptwo.com
  * * * * * * * * * * * * * * * * * * * * * * * * * * */
  
class classe_nuagemot
{
	var $taillepolice_min; // La plus petite taille de police
	var $taillepolice_max; // La plus grande taille de police

	// function classe_nuagemot initialise la classe
	// Par  défaut la plus petite taille de police sera 8 et la plus grand 20
	function classe_nuagemot ($taillepolice_min = 10, $taillepolice_max = 18)
	{
		$this -> taillepolice_min = $taillepolice_min;
		$this -> taillepolice_max = $taillepolice_max;
	}
	
	function element_ajout($element_nom, $element_score)
	{
		// Ajout de données au tableau
		$this -> element_liste [$element_nom] = $element_score;
	}
	
	function execute ()
	{
		// Calcul du coefficent de proportionalité
		$element_max = max ($this -> element_liste);
		$element_min = min ($this -> element_liste);
		$calcul_element = $element_max - $element_min;
		
		$taillepolice_min = $this -> taillepolice_min;
		$taillepolice_max = $this -> taillepolice_max;
		$calcul_taillepolice = $taillepolice_max - $taillepolice_min;	
		
		$calcul_div = $calcul_element / $calcul_taillepolice;
		
		// On parcours la liste des donées entrées
		foreach ($this -> element_liste as $element_nom => $element_score)
		{
			// Calcul me permettant d'obtenir la taille de police de chaque élément
			$element_taillepolice = $taillepolice_min + round ($element_score / $calcul_div);
			
			// On place les résultats dans un tableau 
			// $element_liste_result [ nom de l'élément ][ 0 ] : Score 
			// $element_liste_result [ nom de l'élément ][ 1 ] : Taille de la police
			$element_liste_result [$element_nom] = array ($element_score, $element_taillepolice);
		}
		
		return $element_liste_result;
	}
}

/* * * * * * * * * * * * * * * * * * * * * * * * * * * 
 * script réalisé par floptwo (floptwo@gmail.com)
 * http://www.floptwo.com
 * * * * * * * * * * * * * * * * * * * * * * * * * * */
?>