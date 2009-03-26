<?php
class Xul{
  public $id;
  public $trace;
  private $site;
 
    function __tostring() {
    return "Cette classe permet la création dynamique d'objet XUL.<br/>";
    }

    function __construct($site, $id=-1, $complet=true) {
	//echo "new Site $sites, $id, $scope<br/>";
  	$this->trace = TRACE;

    $this->site = $site;
    $this->id = $id;
	
	}

    function GetTree(){
		
		$tree = "<tree flex=\"1\" 
			id=\"tree\"
			seltype='multiple'
			>";
	
		$tree .= '<treecols>';
		$tree .= '<treecol  id="id" label = "Geonames" primary="true" flex="1" persist="width ordinal hidden"/>';
		$tree .= '<splitter class="tree-splitter"/>';

		
		$tree .= '</treecols>';
		$tree .= $this->GetTreeChildren();
		$tree .= '</tree>';
		
		return $tree;
		
	}
	
	function GetTreeItem($idXul, $cells, $style){
		$this->xul .= '<treeitem id="'.$idXul.'" '.$style.' >'.EOL;
		$this->xul .= '<treerow>'.EOL;
		foreach($cells as $cell)
			$this->xul .= '<treecell label="'.$cell.'"/>'.EOL;
		$this->xul .= '</treerow>'.EOL;
		$this->xul .= '<treechildren >'.EOL;		
	}
	
	
	function GetTreeChildren()
	{
		
		$cl_Output = new Cache_Lite_Function(array('cacheDir' => CACHEPATH,'lifeTime' => LIFETIME));
		$baseUrl ="http://www.laquadrature.net";
		$baseUrlHtml = $baseUrl."/wiki/Deputes_par_departement";
		$html = $cl_Output->call('file_get_html',$baseUrl."/wiki/Deputes_par_departement");
		$retours = $html->find('li a[title^=Deputes]');
		
		$tree = '<treechildren >'.EOL;
		$tree .= '<treeitem id="1" container="true" empty="false" >'.EOL;
		$tree .= '<treerow>'.EOL;
		$tree .= '<treecell label="France"/>'.EOL;
		$tree .= '</treerow>'.EOL;
			$i = 1;
			$tree .= '<treechildren >'.EOL;
			foreach($retours as $dept)
			{	
				$urlDept = $dept->attr["href"];
				$url =$baseUrl.$urlDept;
				$htmlDept = $cl_Output->call('file_get_html',$url);
			
				$x = extract::extract_departement ($urlDept,$dept);
				
				$tree .= '<treeitem id="'.$i.'" container="true" empty="false" >'.EOL;
				$tree .= '<treerow>'.EOL;
				$tree .= '<treecell label="'.$x[1].'"/>'.EOL;
				$tree .= '</treerow>'.EOL;
				//$tree .= '</treeitem>'.EOL;
				
				if ($x[1] == "Ain")
				{	$y = extract::extract_canton ($htmlDept,$urlDept);
					$j = 1;
					$tree .= '<treechildren >'.EOL;
					//foreach($tabNomGeonameCantons as $Canton)
					foreach($y[5] as $Canton)
					{
					$tree .= '<treeitem id="'.$j.'" container="true" empty="false" >'.EOL;
					$tree .= '<treerow>'.EOL;
					$tree .= '<treecell label="'.$Canton.'"/>'.EOL;
					$tree .= '</treerow>'.EOL;
					$tree .= '</treeitem>'.EOL;
					$j ++;
					}
					$tree .= '</treechildren>'.EOL;
					$tree .= '</treeitem>'.EOL;
					
					extract::SetGeoname($x[1],$x[2],$x[0],$y[3]);
				}
				else
				{
					$tree .= '</treeitem>'.EOL;
				}
				$i ++;
			}
			$tree .= '</treechildren>'.EOL;
		$tree .= '</treeitem>'.EOL;
		$tree .= '</treechildren>'.EOL;
	return $tree;

	}
	function GetTree_load(){
		
		$tree = "<tree flex=\"1\" 
			id=\"tree\"
			seltype='multiple'
			>";
	
		$tree .= '<treecols>';
		$tree .= '<treecol  id="id" label = "Geonames" primary="true" flex="1" persist="width ordinal hidden"/>';
		$tree .= '<splitter class="tree-splitter"/>';
		$tree .= '</treecols>';
		$tree .= $this->GetTreeChildren_load();
		$tree .= '</tree>';
		//echo $tree;
		return $tree;
	}
	
	function GetTreeChildren_load(){
	
		$sql = "SELECT `nom_geoname` FROM `geoname` ";     
	
		$db=new mysql ('localhost','root','','evalactipol');
		//$db = new mysql ($this->site->infos["SQL_HOST"], $this->site->infos["SQL_LOGIN"], $this->site->infos["SQL_PWD"], $this->site->infos["SQL_DB"], $dbOptions);
		$db->connect();
		$req = $db->query($sql);
		$db->close();
		$nb = mysql_num_rows($req);
		
		$tree = '<treechildren >'.EOL;
		$tree .= '<treeitem id="1" container="true" empty="false" >'.EOL;
		$tree .= '<treerow>'.EOL;
		$tree .= '<treecell label="France"/>'.EOL;
		$tree .= '</treerow>'.EOL;
	
			$tree .= '<treechildren >'.EOL;
			$j = 1;	
			for ($i=0;$i<=$nb-1;$i++)
			{
				$tree .= '<treeitem id="'.$j.'" container="true" empty="false" >'.EOL;
				$tree .= '<treerow>'.EOL;
				$r = $db->fetch_array($req);
				$result2[$i] = $r['nom_geoname'];
				$result3 = html_entity_decode($result2[$i]);
				//$tree .= '<treecell label="'.$result2[$i].'"/>'.EOL;
				$tree .= '<treecell label="'.$result3.'"/>'.EOL;
				$tree .= '</treerow>'.EOL;
				$tree .= '</treeitem>'.EOL;
				$j ++;
			}

		$tree .= '</treechildren>'.EOL;
	$tree .= '</treeitem>'.EOL;
	$tree .= '</treechildren>'.EOL;
	return $tree;
	}
	
function extractBetweenDelimeters($inputstr,$delimeterLeft,$delimeterRight)
	{
	$posLeft  = stripos($inputstr,$delimeterLeft)+strlen($delimeterLeft);
	$posRight = stripos($inputstr,$delimeterRight,$posLeft+1);
	return  substr($inputstr,$posLeft,$posRight-$posLeft);
	}

}
?>