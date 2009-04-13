<?php
class Xul{
  public $id;
  public $trace;
  private $site;
 
    function __tostring() {
    return "Cette classe permet la cr�ation dynamique d'objet XUL.<br/>";
    }

    function __construct($site, $id=-1, $complet=true) {
	
  	$this->trace = TRACE;
	$this->site = $site;
    $this->id = $id;
	
	}
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
				$tree .= '<treeitem id="'.$type."_".$r[3].'" container="true" open="false" >'.EOL;
				}
				else
				{
				
				$tree .= '<treeitem id="'.$type."_".$r[0].'" container="true" open="false" >'.EOL;	
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
	
	function Getlist($id,$type){
        
		$Xpath = "/XmlParams/XmlParam/GetTreeChildrens/GetTreeChildren[@fonction='GetTreeChildren_".$type."']";
		$Q = $this->site->XmlParam->GetElements($Xpath);
		
		if ($type == "France")
		{
			$num = substr($id,12);
			$result_depart_sql = $this->GetGeoname($num);
			$contexteTree = "Deputes de ".html_entity_decode($result_depart_sql[1]);
			$titreTree = html_entity_decode($result_depart_sql[1]);
		
			$tree = $this->GetTree_load($Q[0]->nextfct."",'',$num,'',$contexteTree,$titreTree);
			$listbox = $tree;
			$listbox .= $this->GetListbox($result_depart_sql,$type,$Q);
		}
		else
		{
			$num = substr($id,7);
			$result_depute_sql = $this->Getdepute($num);
			$result_Quests_Depute = $this->GetQuestsDepute($num);
			$result_MC_Depute = $this->GetMCDepute($num);
			$result_Rubr_Depute = $this->GetRubDepute($num);
		
			$contexteTree = "Cantons de ".html_entity_decode($result_depute_sql[1])." ".html_entity_decode($result_depute_sql[2]);
			$titreTree = html_entity_decode($result_depute_sql[1])." ".html_entity_decode($result_depute_sql[2]);
			$tree = $this->GetTree_load($Q[0]->nextfct."",'',$result_depute_sql[7],$result_depute_sql[6],$contexteTree,$titreTree);
			$listbox = $tree;
			$listbox .= $this->GetListbox($result_depute_sql,$type,$Q);
		
			$listbox .= $this->GetListboxSimple($result_Quests_Depute,$Q[0]->questions."");
			$listbox .= $this->GetListboxSimple($result_MC_Depute,$Q[0]->mots."");
			$listbox .= $this->GetListboxSimple($result_Rubr_Depute,$Q[0]->rubriques."");
		}
		return $listbox;
	}
	
function GetListbox($result_sql,$type,$Q)
	{	
		$listbox = '<listbox width="400px" height="5px">';
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
				$listbox .= '<listitem label="'.html_entity_decode($valeur).'"/>';
			}
		}
		else
		{
			$listbox .= '<listitem label="Pas de '.$titreListe.'"/>';
		}
		$listbox .= '</listbox>';
		return $listbox; 
	}
function GetListItem($result_sql,$titreListe)
	{
		$listbox = '<listitem>';
			$listbox .= '<listcell label="'.$titreListe.'"></listcell>';
			$listbox .= '<listcell label="'.html_entity_decode($result_sql).'"></listcell>';
		$listbox .= '</listitem>';
	return $listbox;
	}
	
function extractBetweenDelimeters($inputstr,$delimeterLeft,$delimeterRight)
	{
	$posLeft  = stripos($inputstr,$delimeterLeft)+strlen($delimeterLeft);
	$posRight = stripos($inputstr,$delimeterRight,$posLeft+1);
	return  substr($inputstr,$posLeft,$posRight-$posLeft);
	}
function GetDepute($id)
{	
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db->connect();
	$sql = "SELECT * FROM `depute` WHERE `id_depute`=\"$id\" ";     
	$result = $db->query(utf8_decode($sql));
	$db->close();
	return ($result1 = mysql_fetch_row( $result));
}

function GetGeoname($num_depart)
{	
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db->connect();
	$sql = "SELECT * FROM `geoname` WHERE `num_depart_geoname`=\"$num_depart\" ";     
	$result = $db->query(utf8_decode($sql));
	$db->close();
	return ($result1 = mysql_fetch_row( $result));
}

function GetQuestsDepute($num)
{	
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db->connect();
	
	$sql = "SELECT num_question FROM `questions` WHERE `id_depute`=\"$num\" ";     
	$result = $db->query(utf8_decode($sql));
	$num1 = $db->num_rows($result);
	$result3 = NULL;
	for ($i=0;$i<=$num1-1;$i++)
	{
		$result2 = $db->fetch_row($result);
		$result3[$i] = $result2[0];
	}
	$db->close();
	return $result3;
	
}
function GetMCDepute($num)
{	
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db->connect();
	$sql = "SELECT id_motclef FROM `depute-mc` WHERE `id_depute`=\"$num\" ";     
	$result = $db->query(utf8_decode($sql));
	
	$num1 = $db->num_rows($result);
	$result4 = NULL;
	for ($i=0;$i<=$num1-1;$i++)
	{
		$result1 = $db->fetch_row($result);
		$sql = "SELECT valeur_motclef FROM `mot-clef` WHERE `id_motclef`=\"$result1[0]\" ";     
		$result2 = $db->query(utf8_decode($sql));
		$result3 = $db->fetch_row($result2);
		$result4[$i] = $result3[0];
	}
	$db->close();
	return $result4;
}

function GetRubDepute($num)
{	
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db->connect();
	
	$sql = "SELECT id_rubrique FROM `depute-rubr` WHERE `id_depute`=\"$num\" ";     
	$result = $db->query(utf8_decode($sql));
	
	$num1 = $db->num_rows($result);
	$result4 = NULL;
	for ($i=0;$i<=$num1-1;$i++)
	{
		$result1 = $db->fetch_row($result);
		$sql = "SELECT valeur_rubrique FROM `rubrique` WHERE `id_rubrique`=\"$result1[0]\" ";     
		$result2 = $db->query(utf8_decode($sql));
		$result3 = $db->fetch_row($result2);
		$result4[$i] = $result3[0];
	}
	$db->close();
	return $result4;
}


}
?>