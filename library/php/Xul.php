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
		
		$tree .= '<treechildren >'.EOL;
		$tree .= '<treeitem id="1" container="true" empty="false" >'.EOL;
		$tree .= '<treerow>'.EOL;
		$tree .= '<treecell label="France"/>'.EOL;
		$tree .= '</treerow>'.EOL;
		
		$tree .= $this->GetTreeChildren_load("departement",$id=-1);
		//$tree .= $this->GetTreeChildren_load();
		
		$tree .= '</treeitem>'.EOL;
		$tree .= '</treechildren>'.EOL;
		
		$tree .= '</tree>';
		//echo $tree;
		return $tree;
	}
	
	function GetTreeChildren_load($type,$id){
		
		
		
		$Xpath = "/XmlParams/XmlParam/Querys/Query[@fonction='GetTreeChildren_".$type."']/col";
		$Cols = $this->site->XmlParam->GetElements($Xpath);
		
		$Xpath = "/XmlParams/XmlParam/Querys/Query[@fonction='GetTreeChildren_".$type."']";
		$Q = $this->site->XmlParam->GetElements($Xpath);
		
		$Xpath = "/XmlParams/XmlParam/Querys/Query[@fonction='GetTreeChildren_".$type."']/from";
		$attrs =$this->site->XmlParam->GetElements($Xpath);
		
		if ($id==-1)
		{
		$where = $Q[0]->where;
		}
		else
		{
			
			$where = str_replace("-parent-", $id, $Q[0]->where);
			
		}
		
		
			$tree = '<treechildren >'.EOL;
			
			
			$sql = $Q[0]->select.$Q[0]->from.$where;
			$db=new mysql ('localhost','root','','evalactipol');
			$db->connect();
			$request = $db->query($sql);
			$db->close();
			$nb = mysql_num_rows($request);
			
			for ($i=0;$i<=$nb-1;$i++)
			{	
				
				$r = $db->fetch_row($request);
				
				
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
				
					if($type=="departement")
					$tree .= $this->GetTreeChildren_load("depute", $r[0]);
					if($type=="depute")
					$tree .= $this->GetTreeChildren_load("cantons", $r[3]);
					
					
					
				
				
					
				$tree .= '</treeitem>'.EOL;
						
			}

			$tree .= '</treechildren>'.EOL;
		
	return $tree;
	}
	
	/*function GetTreeChildren_load(){
	
		
		
		$tree = '<treechildren >'.EOL;
		$tree .= '<treeitem id="1" container="true" empty="false" >'.EOL;
		$tree .= '<treerow>'.EOL;
		$tree .= '<treecell label="France"/>'.EOL;
		$tree .= '</treerow>'.EOL;
			$tree .= '<treechildren >'.EOL;
			
			$sql_departement = "SELECT `id_geoname`,`nom_geoname`,`num_depart_geoname` FROM `geoname` WHERE `type_geoname`= \"Departement\" ";
			$db_departement=new mysql ('localhost','root','','evalactipol');
			$db_departement->connect();
			$request_departement = $db_departement->query($sql_departement);
			$db_departement->close();
			$nb_departement = mysql_num_rows($request_departement);
			
			for ($i=0;$i<=$nb_departement-1;$i++)
			{	
				
				$r_departement = $db_departement->fetch_array($request_departement);
				$id_geoname[$i] = $r_departement['id_geoname'];
				$nom_geoname[$i] = html_entity_decode($r_departement['nom_geoname']);
				$num_depart_geoname[$i] = $r_departement['num_depart_geoname'];
				
				$tree .= '<treeitem id="'.$id_geoname[$i].'" container="true" empty="false" >'.EOL;
				$tree .= '<treerow>'.EOL;
				$tree .= '<treecell label="'.$nom_geoname[$i].'"/>'.EOL;
				$tree .= '</treerow>'.EOL;
				
					$tree .= '<treechildren >'.EOL;
					
					$sql_depute = "SELECT `id_depute`,`nom_depute`,`prenom_depute`,`circonsc_depute` FROM `depute` WHERE `num_depart_depute`= \"$id_geoname[$i]\" ";
					$db_depute=new mysql ('localhost','root','','evalactipol');
					$db_depute->connect();
					$req_depute = $db_depute->query($sql_depute);
					$db_depute->close();
					$nb_depute = mysql_num_rows($req_depute);
					for ($j=0;$j<=$nb_depute-1;$j++)
					{
						$r_depute = $db_depute->fetch_array($req_depute);
						$id_depute[$j] = $r_depute['id_depute'];
						$nom_depute[$j] = html_entity_decode($r_depute['nom_depute']);
						$prenom_depute[$j] = html_entity_decode($r_depute['prenom_depute']);
						$circonsc_depute[$j] = html_entity_decode($r_depute['circonsc_depute']);
					
						$tree .= '<treeitem id="'.$id_depute[$j].'" container="true" empty="false" >'.EOL;
						$tree .= '<treerow>'.EOL;
						$tree .= '<treecell label="'.$nom_depute[$j].' '.$prenom_depute[$j].'"/>'.EOL;
						$tree .= '</treerow>'.EOL;
						$tree .= '</treeitem>'.EOL;
						
							/*$tree .= '<treechildren >'.EOL;
					
							$sql_canton = "SELECT `id_geoname`,`nom_geoname` FROM `geoname` WHERE `type_geoname`= \"Canton\" AND `circonscriptions_geoname`= \"$circonsc_depute[$j]\"  ";
							$db_canton=new mysql ('localhost','root','','evalactipol');
							$db_canton->connect();
							$req_canton = $db_canton->query($sql_canton);
							$db_canton->close();
							$nb_canton = mysql_num_rows($req_canton);
							for ($j=0;$j<=$nb_canton-1;$j++)
							{
								$r_canton = $db_canton->fetch_array($req_canton);
								$id_canton[$j] = $r_canton['id_geoname'];
								$nom_canton[$j] = html_entity_decode($r_canton['nom_geoname']);
										
								$tree .= '<treeitem id="'.$id_canton[$j].'" container="true" empty="false" >'.EOL;
								$tree .= '<treerow>'.EOL;
								$tree .= '<treecell label="'.$nom_canton[$j].'"/>'.EOL;
								$tree .= '</treerow>'.EOL;
								$tree .= '</treeitem>'.EOL;
								
							}
							$tree .= '</treechildren>'.EOL;
						$tree .= '</treeitem>'.EOL;	*/
										
				/*	}
					$tree .= '</treechildren>'.EOL;
				$tree .= '</treeitem>'.EOL;
						
			}

			$tree .= '</treechildren>'.EOL;
		$tree .= '</treeitem>'.EOL;
		$tree .= '</treechildren>'.EOL;
	return $tree;
	}*/
	
function extractBetweenDelimeters($inputstr,$delimeterLeft,$delimeterRight)
	{
	$posLeft  = stripos($inputstr,$delimeterLeft)+strlen($delimeterLeft);
	$posRight = stripos($inputstr,$delimeterRight,$posLeft+1);
	return  substr($inputstr,$posLeft,$posRight-$posLeft);
	}

/*function GetDepartement(){

	$db=new mysql ('localhost','root','','evalactipol');
	//$db = new mysql ($this->site->infos["SQL_HOST"], $this->site->infos["SQL_LOGIN"], $this->site->infos["SQL_PWD"], $this->site->infos["SQL_DB"], $dbOptions);
	$db->connect();
	$sql = "SELECT `id_geoname` `nom_geoname` FROM `geoname` WHERE `type_geoname`=Departement";
	$req = $db->query($sql);
	$nb = mysql_num_rows($req);
	for ($i=0;$i<=$nb-1;$i++)
		{
		$r = $db->fetch_array($req);
		$result1[$i] = $r['id_geoname'];
		$result2[$i] = $r['nom_geoname'];
		}
	
}*/

}
?>