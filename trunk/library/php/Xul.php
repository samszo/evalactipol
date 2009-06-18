<?php

/**
* Cette classe permet de construire, avec php, le code Xul pour les trees et les listbox
* 
* Cette classe permet de construire à partir des variables Ajax 
* le contenu de l'interface Xul. Elle calcule la valeur des 
* variables qui s'affichent dans l'interface de gestion de l'application. 
* Ceci se fait en consultatnt la base de données pour extraire les informations,
* les construire selon le format Xul et les faire retourner sous format Xul pour
* l'affichage par la suite.
*
* @package Evalactipol_libraries
* @version $Id: Xul.php,v 1 2009/05/10 16:03:55
* @author Mehdi TOUIBI <touibimehdi@yahoo.fr>
*/

class Xul{
    /**
    * L'ientifiant de la branche sélectionnée de la tree dans l'interface principale
    *
	* @access public
    * @var string $id
    */

  public $id;
    /**
    * Le paramètre qui contient les traces
    *
	* @access public
    * @var string $trace
    */

  public $trace;
    /**
    * L'objet qui identifie le site sur lequel on travaille
    *
	* @access private
    * @param object $site
    */

  private $site;
 
    function __tostring() {
    return "Cette classe permet la création dynamique d'objet XUL.<br/>";
    }
 
	/**
    * Constructeur
    *
    * C'est le constructeur de l'objet Xul. Il prend essentiellement 
    * l'objet du site sur lequel on travaille ainsi que l'identifiant
    * de la branche sélectionnée de la tree dans l'interface de gestion de l'application.  
    * Ces paramètres sont transmises par Ajax et sont calculés dans la fonction ExeAjax.php. 
    *
    * @param object $site
    * @param string $id	
    * @access public
    */
    
	function __construct($site, $id=-1, $complet=true) {
	
  	$this->trace = TRACE;
	$this->site = $site;
    $this->id = $id;
	
	}
	
	/**
    * Cette fonction permet de construire le code des trees en Xul. 
	*
    * @param string $type 
    * @param array $infosCantons contient des informations sur les cantons
	* @param array $infosDepartement contient des informations sur les départements
	* @param array $htmlDept le lien duquel on va extraire les informations sur les députés
	* @param array $result_deput le résultat des informations sur les députés à partir de la base de données
    * @param string $titreTree le titre de la tree ( tree des départements, des députés ou des cantons )
    * @access public
	* @return string $tree contient le code qui permet de construire la tree en Xul
    */
	
	//GetTree($type,$infosCantons, $infosDepartement,$htmlDept,$x);
    //function GetTree(){
	function GetTree($type,$infosCantons,$infosDepartement,$htmlDept,$result_deput,$titreTree){
		
		$id = "1";
		$Xpath = "/XmlParams/XmlParam/GetTreeChildrens/GetTreeChildren[@fonction='GetTreeChildren_".$type."']/js";
		$js = $this->site->GetJs($Xpath, array($type,$id));
		
		$tree = "<tree flex=\"1\" 
			id=\"tree1\"
			seltype='multiple'
			".$js."

			>";
	
		$tree .= '<treecols>';
		$tree .= '<treecol  id="id" label = "Geonames" primary="true" flex="1" persist="width ordinal hidden"/>';
		$tree .= '<splitter class="tree-splitter"/>';
		$tree .= '</treecols>';
		
		$tree .= '<treechildren >'.EOL;
		$tree .= '<treeitem id="1" container="true" open="true" >'.EOL;
		$tree .= '<treerow>'.EOL;
		$tree .= '<treecell label="'.$titreTree.'"/>'.EOL;
		$tree .= '</treerow>'.EOL;
		
		//$tree .= $this->GetTreeChildren("departement","","","","");
		$tree .= $this->GetTreeChildren($type,$infosCantons,$infosDepartement,$htmlDept,$result_deput);
		
		$tree .= '</treeitem>'.EOL;
		$tree .= '</treechildren>'.EOL;
		
		$tree .= '</tree>';
		
		return $tree;
		
	}
	
	/**
    * Cette fonction est appelée par GetTree () pour construire la balise <treechildren> du code des trees.
	*
    * @param string $type 
    * @param array $infosCantons contient des informations sur les cantons
	* @param array $infosDepartement contient des informations sur les départements
	* @param array $htmlDept le lien duquel on va extraire les informations sur les députés
	* @param array $result_deput le résultat des informations sur les députés à partir de la base de données
    * @access public
	* @return string $tree contient le code qui permet de construire la balise <treechildren>.
    */
	
	function GetTreeChildren($type,$infosCantons,$infosDepartement,$htmlDept,$result_deput)
	{	
		
		$Xpath = "/XmlParams/XmlParam/GetTreeChildrens/GetTreeChildren[@fonction='GetTreeChildren_".$type."']";
		$Q = $this->site->XmlParam->GetElements($Xpath);
		
		$cl_Output = new Cache_Lite_Function(array('cacheDir' => CACHEPATH,'lifeTime' => LIFETIME));
		
		$baseUrl =$Q[0]->baseUrl;
		$baseUrlHtml = $baseUrl.$Q[0]->baseUrlHtml;
		
		if ($type == "departement")
        {
        	$html = file_get_html ($baseUrlHtml);
            $retours = $html->find($Q[0]->find."");
		}elseif($type == "depute"){
			
			$html = $htmlDept;
			$retours = $html->find($Q[0]->find."");
			
			
        }else{
			$retours = $result_deput[2];
		}
		
 				
		$tree = '<treechildren >'.EOL;
		foreach($retours as $dept)
		{	
			
			switch ($type) {
				case "departement":
					$urlDept = $dept->attr["href"];
					$nom = $Q[0]->nom;
					$url =$baseUrl.$urlDept;
					$htmlDept = $cl_Output->call('file_get_html',$url);
					$infosCantons = extract::extract_canton ($htmlDept,$urlDept);
					$infosDepartement = extract::extract_departement ($urlDept,$dept,$infosCantons[3]);
					$idXul = $infosDepartement[3];
					$valXul = $infosDepartement[1];
					break;
				case "depute":
					
					$urlDept = $dept->attr["href"];
					$nom = substr($urlDept,6,7);
					
					if($nom!="Deputes")
					{
						$url =$baseUrl.$urlDept;
						$htmlDept = $cl_Output->call('file_get_html',$url);
						$oDepute = new depute ($htmlDept,$dept,'',$infosDepartement[0],$cl_Output,$this->site,'');
						$result_deput = $oDepute->extrac_infos_depute ($infosCantons[7],$infosCantons[8]);
						$idXul = $result_deput[0];
						$valXul = $result_deput[1];
					}
					break;
				case "cantons":
					$nom = $Q[0]->nom;
					$result_canton = extract::SetGeoname($dept,"Canton",$result_deput[3],$result_deput[4]);
					$idXul = $result_canton;
					$valXul = $dept;
					break;
			}
							
			if($nom!="Deputes")
			{
				$tree .= '<treeitem id="'.$type."_".$idXul.'" container="true" open="false" >'.EOL;
				$tree .= '<treerow>'.EOL;
				$tree .= '<treecell label="'.$valXul.'"/>'.EOL;
				$tree .= '</treerow>'.EOL;
	
				//if ($type == "departement")
					//$tree .= $this->GetTreeChildren($Q[0]->nextfct."",$infosCantons, $infosDepartement,$htmlDept,"");
				//if ($type == "depute")
					//$tree .= $this->GetTreeChildren($Q[0]->nextfct."","", "","",$result_deput);
		
				$tree .= '</treeitem>'.EOL;
			}
		}	
		$tree .= '</treechildren>'.EOL;
			
		return $tree;	
	}
	
	/**
    * Cette fonction permet de construire le code des trees, avec la syntaxe de Xul, pour 
	* l'interface de gestion de l'appliation. Le Xul est construit au chargement 
	* de la page et en cliquant sur n'importe quelle branche dans les trees existantes
	* pour créer d'autres trees	
	*
    * @param string $type le type de la tree à construire  
    * @param string $niv présente quelle tree à construire. Selon chaque niveau, il y a un traitement à faire. 
	* @param string $val1 le numéro du département du député extrait de la BDD
	* @param string $val2 le numéro du département extrait de la BDD des cantons d'un député  
	* @param string $contexteTree 
    * @param string $titreTree le titre de la tree ( tree des départements, des députés ou des cantons )
    * @access public
	* @return string $tree contient le code qui permet de construire la tree en Xul
    */
	
	function GetTree_load($type,$niv=-1,$val1=-1,$val2=-1,$contexteTree,$titreTree){
		
		$id = "1";
		$Xpath = "/XmlParams/XmlParam/Querys/Query[@fonction='GetTreeChildren_".$type."']/js";
		$js = $this->site->GetJs($Xpath, array($type,$id));
		
		if ($type =="departement")
		{
		$tree = "<tree flex=\"1\" 
			id=\"tree1\"
			seltype='multiple'
			".$js."
			
			>";
		}
		else if 
		($type =="depute")
		{
		$tree = "<tree flex=\"1\" 
			id=\"tree2\"
			seltype='multiple'
			".$js."
			
			>";
		}
		else
		{
		$tree = "<tree flex=\"1\" 
			id=\"tree\"
			seltype='multiple'
			".$js."
			
			>";
		}
		$tree .= '<treecols>';
		$tree .= '<treecol  id="id" label = "'.$contexteTree.'" primary="true" flex="1" persist="width ordinal hidden"/>';
		$tree .= '<splitter class="tree-splitter"/>';
		$tree .= '</treecols>';
		
		
		$tree .= $this->GetTreeChildren_load($type,$niv=-1,$val1,$val2,$titreTree);
		
			$tree .= '</tree>';
		
		return $tree;
	}
	
	/**
    * Cette fonction est appelée par GetTree() pour construire la balise
	* <treechildren> du code des trees.
	*
    * @param string $type 
    * @param string $niv 
	* @param string $val1 
	* @param string $val2 
	* @param string $titreTree 
    * @access public
	* @return string $tree contient le code qui permet de construire la balise <treechildren>.
    */
	
	function GetTreeChildren_load($type,$niv=-1,$val1=-1,$val2=-1,$titreTree){
		
		$Xpath = "/XmlParams/XmlParam/Querys/Query[@fonction='GetTreeChildren_".$type."']";
		$Q = $this->site->XmlParam->GetElements($Xpath);
		
		if ($niv==-1){
			$tree = '<treechildren >'.EOL;
		
			$tree .= '<treeitem id="1" container="true" empty="false" open="true">'.EOL;
			$tree .= '<treerow>'.EOL;
			$tree .= '<treecell label="'.$titreTree.'"/>'.EOL;
			$tree .= '</treerow>'.EOL;
			
			$tree .= $this->GetTreeChildren_load($Q[0]->nextfct."",$niv+1,$val1,$val2,"");
		
			$tree .= '</treeitem>'.EOL;
			$tree .= '</treechildren>'.EOL;
		}else{
			$where = str_replace("-parent-", $val1, $Q[0]->where);
			$where = str_replace("-parent_depart-", $val2, $where);
			
			$tree = '<treechildren >'.EOL;
			
			$sql = $Q[0]->select.$Q[0]->from.$where;
			$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
			$db->connect();
			$request = $db->query($sql);
			$db->close();
			$nb = mysql_num_rows($request);
				
			while($r = $db->fetch_row($request))
			{	
				$valXul = html_entity_decode($r[1]);
				
				if ($type == "departement")
				{
				//$tree .= '<treeitem id="'.$type."_".$r[3].'" container="true" open="false" lat="-1" lng="-1" zoom="10">'.EOL;
					if ($r[5] == "0.0000000000" && $r[6] == "0.0000000000")
					{
					$tree .= '<treeitem id="'.$type."_".$r[3].'" container="true" open="false" lat="-1" lng="-1" zoom="10">'.EOL;
					}
					else
					{
					$tree .= '<treeitem id="'.$type."_".$r[3].'" container="true" open="false" lat="'.$r[5].'" lng="'.$r[6].'" zoom= "10">'.EOL;
					}
				}
				
				else if ($type == "depute")
				{
				$tree .= '<treeitem id="'.$type."_".$r[0].'" container="true" open="false">'.EOL;	
				}
				
				else
				{
					
					if ($r[5] == "0.0000000000" && $r[6] == "0.0000000000")
					{
					$tree .= '<treeitem id="'.$type."_".$r[0].'" container="true" open="false" lat="-1" lng="-1" zoom="10">'.EOL;
					}
					else
					{
					$tree .= '<treeitem id="'.$type."_".$r[0].'" container="true" open="false" lat="'.$r[5].'" lng="'.$r[6].'" zoom= "10">'.EOL;
					}
				
				}
				
				$tree .= '<treerow>'.EOL;
				$tree .= '<treecell label="'.$valXul.'"/>'.EOL;
				$tree .= '</treerow>'.EOL;

				//if($Q[0]->nextfct)
					//$tree .= $this->GetTreeChildren_load($Q[0]->nextfct."",$niv+1, $r[3], $r[4]);
						
				$tree .= '</treeitem>'.EOL;
						
			}//while
			
			if($nb>0)
				$tree .= '</treechildren>'.EOL;
			else
				$tree = '';
		}
			
	return $tree;
	}
	
	/**
    * Cette fonction est appelée par la fonction ExeAjax.php. Elle permet
	* de calculer les valeurs qui permettrent de construire les trees en xul.
	*
    * @param string $id l'identifiant de la branche de la tree en cours
    * @param string $type le type de la tree en cours 
	* @return string $listbox  le code xul écrit en php permettant de construire les trees 
    * @access public
    */
	
	//function Getlist($id,$type){
	function GetTrees($id,$type){
        
		$Xpath = "/XmlParams/XmlParam/GetTreeChildrens/GetTreeChildren[@fonction='GetTreeChildren_".$type."']";
		$Q = $this->site->XmlParam->GetElements($Xpath);
		$GetSqlInfos = new GetSqlInfos ($this->site);
		if ($type == "France")
		{
			$num = substr($id,12);
			$result_depart_sql = $GetSqlInfos->GetGeoname($num);
			$contexteTree = "Deputes de ".html_entity_decode($result_depart_sql[1]);
			$titreTree = html_entity_decode($result_depart_sql[1]);
		
			$tree = $this->GetTree_load($Q[0]->nextfct."",'',$num,'',$contexteTree,$titreTree);
			$listbox = $tree;
			//$listbox .= $this->GetListbox($result_depart_sql,$type,$Q);
		}
		else
		{
			$num = substr($id,7);
			$result_depute_sql = $GetSqlInfos->Getdepute($num);
			$result_Quests_Depute = $GetSqlInfos->GetQuestsDepute($num);
			$result_MC_Depute = $GetSqlInfos->GetMCDepute($num);
			$result_Rubr_Depute = $GetSqlInfos->GetRubDepute($num);
		
			$contexteTree = "Cantons de ".html_entity_decode($result_depute_sql[1])." ".html_entity_decode($result_depute_sql[2]);
			$titreTree = html_entity_decode($result_depute_sql[1])." ".html_entity_decode($result_depute_sql[2]);
			$tree = $this->GetTree_load($Q[0]->nextfct."",'',$result_depute_sql[7],$result_depute_sql[6],$contexteTree,$titreTree);
			$listbox = $tree;
			//$listbox .= $this->GetListbox($result_depute_sql,$type,$Q);
		
			
			//$listbox .= $this->GetListboxSimple($result_Quests_Depute,$Q[0]->questions."");
			//$listbox .= $this->GetListboxSimple($result_MC_Depute,$Q[0]->mots."");
			//$listbox .= $this->GetListboxSimple($result_Rubr_Depute,$Q[0]->rubriques."");
		}
		return $listbox;
	}
	
	/**
    * Cette fonction est appelée par la fonction ExeAjax.php. Elle permet
	* de calculer les valeurs qui permettrent de construire les listbox en xul.
	*
    * @param string $id l'identifiant de la branche de la tree en cours
    * @param string $type le type de la tree en cours 
	* @return string $listbox  le code xul écrit en php permettant de construire les listbox 
    * @access public
    */
	
	function GetListes($id,$type){
        
		$Xpath = "/XmlParams/XmlParam/GetTreeChildrens/GetTreeChildren[@fonction='GetTreeChildren_".$type."']";
		$Q = $this->site->XmlParam->GetElements($Xpath);
		$GetSqlInfos = new GetSqlInfos ($this->site);
		
			$num = substr($id,7);
			$result_depute_sql = $GetSqlInfos->Getdepute($num);
			$listbox = $this->GetListbox($result_depute_sql,$type,$Q);
			
		
		return $listbox;
	}
	
	/**
    * Cette fonction est appelée par la fonction GetListes(). Elle permet
	* de construire en php le code en xul des listbox.
	*
    * @param array $result_sql les informations sur les député extraites de la BDD
    * @param string $type le type de la tree en cours
	* @param object $Q le contenu extrait du fichier evalactipol.xml contenant les constantes et les requêtes sql pour traiter les députés.	
	* @return string listbox le code xul écrit en php permettant de construire les listbox 
    * @access public
    */
function GetListbox($result_sql,$type,$Q)
	{	
		//$listbox = '<listbox width="450px" height="5px">';
		$listbox = '<listbox flex="1">';
			$listbox .= '<listhead>';
				$listbox .= '<listheader label="Informations"></listheader>';
				$listbox .= '<listheader label="Valeurs"></listheader>';
			$listbox .= '</listhead>';
		
			$listbox .= '<listcols>';
				$listbox .= '<listcol flex="1"></listcol>';
				$listbox .= '<listcol flex="1"></listcol>';
			$listbox .= '</listcols>';
		
		if ($type =="France")
		{
				$listbox .= $this->GetListItem($result_sql[1],$Q[0]->NomGeoname."");
				$listbox .= $this->GetListItem($result_sql[2],$Q[0]->Type."");
				$listbox .= $this->GetListItem($result_sql[3],$Q[0]->Numeros."");
				$listbox .= $this->GetListItem($result_sql[4],$Q[0]->Circonscriptions."");
		}
		else
		{
				$listbox .= $this->GetListItem($result_sql[1]." ".$result_sql[2],$Q[0]->NomPrenom."");
				$listbox .= $this->GetListItem($result_sql[3],$Q[0]->Mail."");
				$listbox .= $this->GetListItem($result_sql[4],$Q[0]->NumeroPhone."");
				$listbox .= $this->GetListItem($result_sql[5],$Q[0]->LienAN."");
				$listbox .= $this->GetListItem($result_sql[6],$Q[0]->NumDepartement."");
				$listbox .= $this->GetListItem($result_sql[7],$Q[0]->Circonscription."");
		}
		$listbox .= '</listbox>';
	return $listbox;
	}
function GetListboxSimple($result_sql,$titreListe)
	{	
		$GetSqlInfos = new GetSqlInfos ($this->site);
		$listbox = '<listbox rows="3" width="10px">';
		$listbox .= '<listhead>';
		$listbox .= '<listheader label="'.$titreListe.'"/>';
		$listbox .= '</listhead>';
		$listbox .= '<listcols>';
		$listbox .= '<listcol/>';
		$listbox .= '</listcols>';
		
		if ($result_sql != NULL)
		{	
			foreach ($result_sql as $valeur)
			{	
				//$y = $GetSqlInfos->toASCII($valeur);
				$valeur2 = $GetSqlInfos->NoASCII($valeur);
				//echo $valeur1;
				//$valeur2 = htmlspecialchars($valeur);
				//$valeur2 = htmlentities($valeur1,ENT_QUOTES,'UTF-8'); 
				//$valeur2 = htmlspecialchars($valeur1,ENT_QUOTES,'UTF-8'); 
				//$listbox .= '<listitem label="'.html_entity_decode($valeur).'"/>';
				//$valeur2 = html_entity_decode($valeur);
				//echo $valeur2;
				$listbox .= '<listitem label="'.$valeur2.'"/>';
			}
		}
		else
		{
			$listbox .= '<listitem label="Pas de '.$titreListe.'"/>';
		}
		$listbox .= '</listbox>';
		return $listbox; 
	}
	/**
    * Cette fonction est appelée par la fonction GetListebox(). Elle permet
	* de construire les balises <listitem> des listbox.
	*
    * @param string $result_sql le contenu de la balise <listcell>
    * @param string $titreListe le titre de la balise <listcell>
	* @return string $listbox le code xul écrit en php des balises <listitem> des listbox 
    * @access public
    */
function GetListItem($result_sql,$titreListe)
	{
		$listbox = '<listitem>';
			$listbox .= '<listcell label="'.$titreListe.'"></listcell>';
			$listbox .= '<listcell label="'.html_entity_decode($result_sql).'"></listcell>';
		$listbox .= '</listitem>';
	return $listbox;
	}

	
}
?>