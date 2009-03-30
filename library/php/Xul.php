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
		
		$tree .= '<treechildren >'.EOL;
		$tree .= '<treeitem id="1" container="true" open="true" >'.EOL;
		$tree .= '<treerow>'.EOL;
		$tree .= '<treecell label="France"/>'.EOL;
		$tree .= '</treerow>'.EOL;
		
		$tree .= $this->GetTreeChildren("departement","","","");
		
		$tree .= '</treeitem>'.EOL;
		$tree .= '</treechildren>'.EOL;
		
		$tree .= '</tree>';
		
		return $tree;
		
	}
	
	function GetTreeChildren($type,$infosCantons,$infosDepartement,$htmlDept)
	{	
		
	
		$cl_Output = new Cache_Lite_Function(array('cacheDir' => CACHEPATH,'lifeTime' => LIFETIME));
		$baseUrl ="http://www.laquadrature.net";
		
		$Xpath = "/XmlParams/XmlParam/GetTreeChildrens/GetTreeChildren[@fonction='GetTreeChildren_".$type."']";
		$Q = $this->site->XmlParam->GetElements($Xpath);
		
		//$baseUrlHtml = $baseUrl."/wiki/Deputes_par_departement";
		$baseUrlHtml = $baseUrl.$Q[0]->baseUrlHtml;
		//$html = $cl_Output->call('file_get_html',$baseUrl."/wiki/Deputes_par_departement");
		//$html = file_get_html ($baseUrl."/wiki/Deputes_par_departement");
		
		//$x = $Q[0]->find1;
		//echo $x; 
		//$retours = $html->find($x);
		if ($type == "departement")
		{
		$html = file_get_html ($baseUrlHtml);
		$retours = $html->find('li a[title^=Deputes]');
		}
		else 
		{
		$html = $htmlDept;
		$retours = $html->find('td a[href^=/wiki/]');
		}
			if ($type == "departement")
				{
				$infosDepartement[1] = "Ain";
				}
			else 
				{
				$infosDepartement[1] = $infosDepartement[1];
				}
			if ($infosDepartement[1] == "Ain")
			{
		
				$tree = '<treechildren >'.EOL;
				foreach($retours as $dept)
				{	
					$urlDept = $dept->attr["href"];
					if ($type == "departement")
					{
					$nom = "xxxx";
					}
					else 
					{
					$nom = substr($urlDept,6,7);
					}
					//$nom = substr($urlDept,6,7);
					if($nom!="Deputes")
					{
				
					$url =$baseUrl.$urlDept;
					$htmlDept = $cl_Output->call('file_get_html',$url);
						if ($type == "departement")
						{
						$infosCantons = extract::extract_canton ($htmlDept,$urlDept);
						$infosDepartement = extract::extract_departement ($urlDept,$dept,$infosCantons[3]);
						$idXul = $infosDepartement[3];
						$valXul = $infosDepartement[1];
						}
						else 
						{
						$oDepute = new depute ($htmlDept,$dept,'',$infosDepartement[0],$cl_Output,$this->site,'');
						$result_deput = $oDepute->extrac_infos_depute ($infosCantons[7],$infosCantons[8]);
						$idXul = $result_deput[0];
						$valXul = $result_deput[1];
						}
						
						$tree .= '<treeitem id="'.$idXul.'" container="true" open="false" >'.EOL;
						$tree .= '<treerow>'.EOL;
						$tree .= '<treecell label="'.$valXul.'"/>'.EOL;
						$tree .= '</treerow>'.EOL;
				
						if ($type == "departement")
						$tree .= $this->GetTreeChildren("depute",$infosCantons, $infosDepartement,$htmlDept);
				
				
						$tree .= '</treeitem>'.EOL;
				
					}
				}	
				$tree .= '</treechildren>'.EOL;
				
			return $tree;	
			}
			//else
			//{
			//$tree .= '</treeitem>'.EOL;
			//}
			//$tree .= '</treeitem>'.EOL;
			//$tree .= '</treechildren>'.EOL;
		
		//return $tree;

	}		
				
				
				
				
				/*if ($infosDepartement[1] == "Ain")
				{
					
					$tree .= '<treechildren >'.EOL;
					
					$rsDept = $htmlDept->find('td a[href^=/wiki/]');
					
					foreach($rsDept as $depu)
					{
						$urlDepu = $depu->attr["href"]; 
						$nom = substr($urlDepu,6,7);
						if($nom!="Deputes")
						{	
							$urlDepute=$baseUrl.$urlDepu;
							$htmllienDepu = $cl_Output->call('file_get_html',$urlDepute);
							
							$oDepute = new depute ($htmllienDepu,$depu,'',$infosDepartement[0],$cl_Output,$this->site,'');
							$result_deput = $oDepute->extrac_infos_depute ($infosCantons[7],$infosCantons[8]);
								
							
							
							$tree .= '<treeitem id="'.$result_deput[0].'" container="true" open="false" >'.EOL;
							//$tree .= '<treeitem id="1" container="true" open="false" >'.EOL;
							$tree .= '<treerow>'.EOL;
							$tree .= '<treecell label="'.$result_deput[1].'"/>'.EOL;
							$tree .= '</treerow>'.EOL;
							$tree .= '</treeitem>'.EOL;	
							
						}
							
					}
					$tree .= '</treechildren>'.EOL;
				$tree .= '</treeitem>'.EOL;
				
				}
				else
				{
				$tree .= '</treeitem>'.EOL;	
				}
				
				
				
			}
			$tree .= '</treechildren>'.EOL;
			
		
	return $tree;

	}*/
	/*function GetTreeChildren()
	{	
		$cl_Output = new Cache_Lite_Function(array('cacheDir' => CACHEPATH,'lifeTime' => LIFETIME));
		$baseUrl ="http://www.laquadrature.net";
		
		$baseUrlHtml = $baseUrl."/wiki/Deputes_par_departement";
		//$html = $cl_Output->call('file_get_html',$baseUrl."/wiki/Deputes_par_departement");
		$html = file_get_html ($baseUrl."/wiki/Deputes_par_departement");
		$retours = $html->find('li a[title^=Deputes]');
		
		$tree = '<treechildren >'.EOL;
		$tree .= '<treeitem id="1" container="true" open="true" >'.EOL;
		$tree .= '<treerow>'.EOL;
		$tree .= '<treecell label="France"/>'.EOL;
		$tree .= '</treerow>'.EOL;
					
			$tree .= '<treechildren >'.EOL;
			foreach($retours as $dept)
			{	
				$urlDept = $dept->attr["href"];
				$url =$baseUrl.$urlDept;
				$htmlDept = $cl_Output->call('file_get_html',$url);
				$infosCantons = extract::extract_canton ($htmlDept,$urlDept);
				$infosDepartement = extract::extract_departement ($urlDept,$dept,$infosCantons[3]);
				
				$tree .= '<treeitem id="'.$infosDepartement[3].'" container="true" open="false" >'.EOL;
				$tree .= '<treerow>'.EOL;
				$tree .= '<treecell label="'.$infosDepartement[1].'"/>'.EOL;
				$tree .= '</treerow>'.EOL;
				//$tree .= '</treeitem>'.EOL;
				
				if ($infosDepartement[1] == "Ain")
				{
					$tree .= '<treechildren >'.EOL;
					
					$rsDept = $htmlDept->find('td a[href^=/wiki/]');
					
					foreach($rsDept as $depu)
					{
						$urlDepu = $depu->attr["href"]; 
						$nom = substr($urlDepu,6,7);
						if($nom!="Deputes")
						{	
							$urlDepute=$baseUrl.$urlDepu;
							$htmllienDepu = $cl_Output->call('file_get_html',$urlDepute);
							
							$oDepute = new depute ($htmllienDepu,$depu,'',$infosDepartement[0],$cl_Output,$this->site,'');
							$result_deput = $oDepute->extrac_infos_depute ($infosCantons[7],$infosCantons[8]);
							
							$tree .= '<treeitem id="'.$result_deput[0].'" container="true" open="false" >'.EOL;
							$tree .= '<treerow>'.EOL;
							$tree .= '<treecell label="'.$result_deput[1].'"/>'.EOL;
							$tree .= '</treerow>'.EOL;
							//$tree .= '</treeitem>'.EOL;
							
							$tree .= '<treechildren >'.EOL;
								foreach ($result_deput[2] as $nom_canton)
								{	
									
									//$nom_canton = html_entity_decode($nom_canton1);
									
									$tree .= '<treeitem id="1" container="true" open="false" >'.EOL;
									$tree .= '<treerow>'.EOL;
									$tree .= '<treecell label="'.$nom_canton.'"/>'.EOL;
									$tree .= '</treerow>'.EOL;
									$tree .= '</treeitem>'.EOL;
								}
							$tree .= '</treechildren>'.EOL;
							$tree .= '</treeitem>'.EOL;	
							
						}
							
					}
					$tree .= '</treechildren>'.EOL;
				$tree .= '</treeitem>'.EOL;	
				}
				else
				{
				$tree .= '</treeitem>'.EOL;	
				}
				
			}
			$tree .= '</treechildren>'.EOL;
			
		$tree .= '</treeitem>'.EOL;
		$tree .= '</treechildren>'.EOL;
	return $tree;

	}*/
	function GetTree_load(){
		
		$tree = "<tree flex=\"1\" 
			id=\"tree\"
			seltype='multiple'
			>";
	
		$tree .= '<treecols>';
		$tree .= '<treecol  id="id" label = "Geonames" primary="true" flex="1" persist="width ordinal hidden"/>';
		$tree .= '<splitter class="tree-splitter"/>';
		$tree .= '</treecols>';
		
		$tree .= $this->GetTreeChildren_load("france",$niv=-1,$val1=-1,$val2=-1);
		$tree .= '</tree>';
		
		return $tree;
	}
	
	function GetTreeItem($idXul, $cells){
		$tree = '<treeitem id="'.$idXul.'">'.EOL;
		$tree .= '<treerow>'.EOL;
		foreach($cells as $cell)
			$tree .= '<treecell label="'.$cells.'"/>'.EOL;
		$tree .= '</treerow>'.EOL;
		$this->xul .= '<treechildren >'.EOL;		
		return $tree; 
	}
	
	function GetTreeChildren_load($type,$niv,$val1,$val2){
		
		if ($niv==-1)
		{
			$tree = '<treechildren >'.EOL;
		
			$tree .= '<treeitem id="1" container="true" empty="false" >'.EOL;
			$tree .= '<treerow>'.EOL;
			$tree .= '<treecell label="France"/>'.EOL;
			$tree .= '</treerow>'.EOL;
		
			//$tree .= $this->GetTreeItem("1","france");
			$tree .= $this->GetTreeChildren_load("departement", 1, -1,-1);
		
			$tree .= '</treeitem>'.EOL;
			$tree .= '</treechildren>'.EOL;
		}
		
		else
		{
			$Xpath = "/XmlParams/XmlParam/Querys/Query[@fonction='GetTreeChildren_".$type."']/col";
			$Cols = $this->site->XmlParam->GetElements($Xpath);
		
			$Xpath = "/XmlParams/XmlParam/Querys/Query[@fonction='GetTreeChildren_".$type."']";
			$Q = $this->site->XmlParam->GetElements($Xpath);
		
			$Xpath = "/XmlParams/XmlParam/Querys/Query[@fonction='GetTreeChildren_".$type."']/from";
			$attrs =$this->site->XmlParam->GetElements($Xpath);
			
			$where = str_replace("-parent-", $val1, $Q[0]->where);
			
			if ($val2!=-1)
			{
				$where = str_replace("-parent_depart-", $val2, $where);
			}
			
			$tree = '<treechildren >'.EOL;
			
			$sql = $Q[0]->select.$Q[0]->from.$where;
			$db=new mysql ('localhost','root','','evalactipol');
			$db->connect();
			$request = $db->query($sql);
			$db->close();
			$nb = mysql_num_rows($request);
				
			while($r = $db->fetch_row($request))
			{	
				switch ($type) {
					case "depute":
						$valXul = html_entity_decode($r[1])." ".html_entity_decode($r[2]);
					break;
					case "cantons":
						$valXul = html_entity_decode($r[1]);
					break;
					
					default:	
					$valXul = html_entity_decode($r[1]);
				}	
				
				$tree .= '<treeitem id="'.$r[0].'" container="true" empty="false" >'.EOL;
				$tree .= '<treerow>'.EOL;
				$tree .= '<treecell label="'.$valXul.'"/>'.EOL;
				$tree .= '</treerow>'.EOL;
				
				//$tree .= $this->GetTreeItem($r[0],$valXul);
				
					if($type=="departement")
					$tree .= $this->GetTreeChildren_load("depute",1, $r[0],-1);
					if($type=="depute")
					$tree .= $this->GetTreeChildren_load("cantons",1, $r[3],$r[4]);
					
				$tree .= '</treeitem>'.EOL;
						
			}//while
			
			if($nb>0)
			$tree .= '</treechildren>'.EOL;
			else
			$tree = '';
		}
			
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