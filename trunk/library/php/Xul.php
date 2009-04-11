<?php
class Xul{
  public $id;
  public $trace;
  private $site;
 
    function __tostring() {
    return "Cette classe permet la création dynamique d'objet XUL.<br/>";
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
	
	
	/*function GetTree_load($type){
		
		
		$id = "1";
		$Xpath = "/XmlParams/XmlParam/GetTreeChildrens/GetTreeChildren[@fonction='GetTreeChildren_".$type."']/js";
		$js = $this->site->GetJs($Xpath, array($type,$id));
		
		$tree = "<tree flex=\"1\" 
			id=\"tree\"
			seltype='multiple'
			".$js."
			
			>";
		
		$tree .= '<treecols>';
		$tree .= '<treecol  id="1" label = "Geonames" primary="true" flex="1" persist="width ordinal hidden"/>';
		$tree .= '<splitter class="tree-splitter"/>';

		
		$tree .= '</treecols>';
		
		$tree .= '<treechildren >'.EOL;
		$tree .= '<treeitem id="1" container="true" open="true" >'.EOL;
		$tree .= '<treerow>'.EOL;
		$tree .= '<treecell label="France"/>'.EOL;
		$tree .= '</treerow>'.EOL;
		
		$tree .= $this->GetTreeChildren_load("departement");
		
		$tree .= '</treeitem>'.EOL;
		$tree .= '</treechildren>'.EOL;
		
		$tree .= '</tree>';
		
		return $tree;
		
	}
	function GetTreeChildren_load($type)
	{	
		
		$Xpath = "/XmlParams/XmlParam/GetTreeChildrens/GetTreeChildren[@fonction='GetTreeChildren_".$type."']";
		$Q = $this->site->XmlParam->GetElements($Xpath);
		
		$cl_Output = new Cache_Lite_Function(array('cacheDir' => CACHEPATH,'lifeTime' => LIFETIME));
		
		$baseUrl =$Q[0]->baseUrl;
		$baseUrlHtml = $baseUrl.$Q[0]->baseUrlHtml;
		$html = file_get_html ($baseUrlHtml);
		$retours = $html->find($Q[0]->find."");
		
 		$tree = '<treechildren >'.EOL;
		foreach($retours as $dept)
		{	
			$urlDept = $dept->attr["href"];
			$url =$baseUrl.$urlDept;
			$htmlDept = $cl_Output->call('file_get_html',$url);
			$infosCantons = extract::extract_canton ($htmlDept,$urlDept);
			$infosDepartement = extract::extract_departement ($urlDept,$dept,$infosCantons[3]);
			//$infosDepartement = extract::extract_departement ($urlDept,$dept);
			//$idXul = $infosDepartement[3];
			$idXul = $infosDepartement[0];
			$valXul = $infosDepartement[1];
					
				
				$tree .= '<treeitem id="'.$type."_".$idXul.'" container="true" open="false">'.EOL;
				$tree .= '<treerow>'.EOL;
				$tree .= '<treecell label="'.$valXul.'" />'.EOL;
				$tree .= '</treerow>'.EOL;
	
				$tree .= '</treeitem>'.EOL;
				
		}	
		$tree .= '</treechildren>'.EOL;
			
		return $tree;	
	}*/
		
	function GetTree_load($type,$niv=-1,$val1,$val2=-1,$contexteTree,$titreTree){
		
		$id = "1";
		//$type = "France";
		$Xpath = "/XmlParams/XmlParam/Querys/Query[@fonction='GetTreeChildren_".$type."']/js";
		//$Xpath = "/XmlParams/XmlParam/GetTreeChildrens/GetTreeChildren[@fonction='GetTreeChildren_".$type."']/js";
		$js = $this->site->GetJs($Xpath, array($type,$id));
		
		$tree = "<tree flex=\"1\" 
			id=\"tree\"
			seltype='multiple'
			".$js."
			
			>";
	
		$tree .= '<treecols>';
		$tree .= '<treecol  id="id" label = "'.$contexteTree.'" primary="true" flex="1" persist="width ordinal hidden"/>';
		$tree .= '<splitter class="tree-splitter"/>';
		$tree .= '</treecols>';
		
		$tree .= $this->GetTreeChildren_load($type,$niv=-1,$val1,$val2=-1,$titreTree);
		$tree .= '</tree>';
		
		return $tree;
	}
	
	function GetTreeChildren_load($type,$niv=-1,$val1,$val2=-1,$titreTree){
		
		$Xpath = "/XmlParams/XmlParam/Querys/Query[@fonction='GetTreeChildren_".$type."']";
		$Q = $this->site->XmlParam->GetElements($Xpath);
		
		if ($niv==-1){
			$tree = '<treechildren >'.EOL;
		
			$tree .= '<treeitem id="1" container="true" empty="false" open="true">'.EOL;
			$tree .= '<treerow>'.EOL;
			$tree .= '<treecell label="'.$titreTree.'"/>'.EOL;
			$tree .= '</treerow>'.EOL;
		
			$tree .= $this->GetTreeChildren_load($Q[0]->nextfct."", $niv+1,$val1,$val2=-1,"");
		
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
        
		/*$num = substr($id,12);
		$result_depart_sql = $this->GetGeoname($num);
		$contexteTree = "Deputes de ".html_entity_decode($result_depart_sql[1]);
		$titreTree = html_entity_decode($result_depart_sql[1]);
		$tree = $this->GetTree_load('departement','',$num,'',$contexteTree,$titreTree);
			
		$listbox = $tree;
			
		$listbox .= '<listbox>';
		$listbox .= '<listitem label="'.html_entity_decode($result_depart_sql[1]).'"/>';
		$listbox .= '<listitem label="'.$result_depart_sql[2].'"/>';
		$listbox .= '<listitem label="'.$result_depart_sql[3].'"/>';
		$listbox .= '<listitem label="'.$result_depart_sql[4].'"/>';
		//$listbox .= '<listitem label="'.$infosDepartement[4].'"/>';
		$listbox .= '</listbox>';*/
		
		/* Debut de la partie utilisée pour insérer les departements et les cantons
		
		$Xpath = "/XmlParams/XmlParam/GetTreeChildrens/GetTreeChildren[@fonction='GetTreeChildren_".$type."']";
		$Q = $this->site->XmlParam->GetElements($Xpath);
		
		$cl_Output = new Cache_Lite_Function(array('cacheDir' => CACHEPATH,'lifeTime' => LIFETIME));
		$baseUrl =$Q[0]->baseUrl."";
		$baseUrlHtml = $baseUrl.$Q[0]->baseUrlHtml;
		$html = $cl_Output->call('file_get_html',$baseUrlHtml);
		
		$retours = $html->find('li a[title^=Deputes '.$num.']');
		$extract_object=new extract ($this->site,$baseUrl, $cl_Output);
		$result_id_url_ttDepart = $extract_object->SetUrl($baseUrlHtml,"Url de tous les départements");
		$infosDepartement = $extract_object->extract_site ($retours);
		
		Fin de cette partie*/
 			
			
			
		//return $listbox;
		
		
		
		$Xpath = "/XmlParams/XmlParam/GetTreeChildrens/GetTreeChildren[@fonction='GetTreeChildren_".$type."']";
		$Q = $this->site->XmlParam->GetElements($Xpath);
		
		$cl_Output = new Cache_Lite_Function(array('cacheDir' => CACHEPATH,'lifeTime' => LIFETIME));
		$baseUrl =$Q[0]->baseUrl."";
		$baseUrlHtml = $baseUrl.$Q[0]->baseUrlHtml;
		$html = $cl_Output->call('file_get_html',$baseUrlHtml);
		$num = substr($id,12);
		$result_depart_sql = $this->GetGeoname($num);
		$retours = $html->find('li a[title^=Deputes '.$num.']');
		$extract_object=new extract ($this->site,$baseUrl, $cl_Output);
		//$extract_object=new extract ($this->site,$baseUrl, $cl_Output);
		//$infosDepartement = $extract_object->extract_site ($retours);
 		
			foreach ($retours as $dept)
			{
			$urlDept = $dept->attr["href"];
			$url =$baseUrl.$urlDept;
			$htmlDept = $cl_Output->call('file_get_html',$url);
			
			$infosCantons = $extract_object->extract_canton ($htmlDept,$urlDept);
			$infosDepartement = $extract_object->extract_One_departement ($urlDept,$dept,$infosCantons[3]);
			
			$id_geo_departement = $result_depart_sql[0];
			$result_id_geoCanton = $extract_object->extract_id_geoCanton ($infosDepartement[0],$infosCantons[4]);
			$rsDept = $htmlDept->find('td a[href^=/wiki/]');

			//Boucle sur les députés
			$ids_deputes2 = ""; 
				foreach($rsDept as $depu)
				{
					$urlDepu = $depu->attr["href"]; 
					//vérifie qu'on traite un député
					$nom = substr($urlDepu,6,7);
					if($nom!="Deputes")
					{
						$urlDepute=$extract_object->baseUrl.$urlDepu;
						$htmllienDepu = $extract_object->cl_Output->call('file_get_html',$urlDepute);
						$result_id_url_Deput = $extract_object->SetUrl($urlDepute,"find('td a[href^=/wiki/]')");
						//extraction des info du député
						$oDepute = new depute ($htmllienDepu,$depu,$result_id_url_Deput,$infosDepartement[0],$extract_object->cl_Output,$extract_object->site,$result_id_geoCanton);
						$id_deput = $oDepute->extrac_infos_depute ($infosCantons[6],$infosCantons[8]);
						$ids_deputes1= (string)$id_deput[0];
						$ids_deputes2= $ids_deputes2.",".$ids_deputes1;
						$ids_deputes = substr($ids_deputes2,1);
					}
				}
				$result_exist_depuGeoDepart = $extract_object->verif_exist_deputGeo ($ids_deputes,$id_geo_departement);
				if ($result_exist_depuGeoDepart == NULL)
				{         
					$extract_object->insert_table_deput_Geo($ids_deputes,$id_geo_departement);
				}
			
			//$tree = $this->GetTree('depute',$infosCantons,$infosDepartement,$htmlDept,"","deputes");
			//GetTree($type,$infosCantons,$infosDepartement,$htmlDept,$result_deput,$titreTree)
			}
		//$listbox = $tree;
			
		$listbox = '<listbox>';
		$listbox .= '<listitem label="'.html_entity_decode($result_depart_sql[1]).'"/>';
		$listbox .= '<listitem label="'.$result_depart_sql[2].'"/>';
		$listbox .= '<listitem label="'.$result_depart_sql[3].'"/>';
		$listbox .= '<listitem label="'.$result_depart_sql[4].'"/>';
		//$listbox .= '<listitem label="'.$infosDepartement[4].'"/>';
		$listbox .= '</listbox>';
			
			
			
		return $listbox;
			
	}
	function Getlist_depute($id,$type){
		
		
		//$Xpath = "/XmlParams/XmlParam/GetTreeChildrens/GetTreeChildren[@fonction='GetTreeChildren_".$type."']";
		$Xpath = "/XmlParams/XmlParam/GetTreeChildrens/GetTreeChildren[@fonction='GetTreeChildren_departement']";
		$Q = $this->site->XmlParam->GetElements($Xpath);
		
		$cl_Output = new Cache_Lite_Function(array('cacheDir' => CACHEPATH,'lifeTime' => LIFETIME));
		$baseUrl =$Q[0]->baseUrl."";
		$baseUrlHtml = $baseUrl.$Q[0]->baseUrlHtml;
		$html = $cl_Output->call('file_get_html',$baseUrlHtml);
		//$type = $this->extractBetweenDelimeters($id,"","_");
		$num = substr($id,7);
		$result_deput_sql = $this->GetDepute($num);
		
		$retours = $html->find('li a[title^=Deputes '.$result_deput_sql[6].']');
		
 			foreach ($retours as $dept)
			{
			
			$urlDept = $dept->attr["href"];
			$url =$baseUrl.$urlDept;
			$htmlDept = $cl_Output->call('file_get_html',$url);
			
			$infosCantons = extract::extract_canton ($htmlDept,$urlDept);
			$infosDepartement = extract::extract_One_departement ($urlDept,$dept,$infosCantons[3]);
				
				$NomPrenomDepute = html_entity_decode($result_deput_sql[1]).html_entity_decode($result_deput_sql[2]);
				$NomPrenomDepute_separ = html_entity_decode($result_deput_sql[1])." ".html_entity_decode($result_deput_sql[2]);
				
				$rsDept = $htmlDept->find('td a[href^=/wiki/'.$NomPrenomDepute.']');
					
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
							
							$tree = $this->GetTree("cantons","","","",$result_deput,$NomPrenomDepute_separ);
							$listbox = $tree;
							$listbox .= '<listbox>';
							$listbox .= '<listitem label="'.$result_deput_sql[1].'"/>';
							$listbox .= '<listitem label="'.$result_deput_sql[2].'"/>';
							$listbox .= '<listitem label="'.$result_deput_sql[3].'"/>';
							$listbox .= '<listitem label="'.$result_deput_sql[4].'"/>';
							$listbox .= '<listitem label="'.$result_deput_sql[5].'"/>';
							$listbox .= '<listitem label="'.$result_deput_sql[6].'"/>';
							$listbox .= '<listitem label="'.$result_deput_sql[7].'"/>';
							$listbox .= '</listbox>';
							
						}
							
					}
			}
			
		return $listbox;
		
		}
							
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
	/*function GetTree_load(){
		
		$tree = "<tree flex=\"1\" 
			id=\"tree\"
			seltype='multiple'
			>";
	
		$tree .= '<treecols>';
		$tree .= '<treecol  id="id" label = "Geonames" primary="true" flex="1" persist="width ordinal hidden"/>';
		$tree .= '<splitter class="tree-splitter"/>';
		$tree .= '</treecols>';
		
		$tree .= $this->GetTreeChildren_load("france");
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
	
	function GetTreeChildren_load($type,$niv=-1,$val1=-1,$val2=-1){
		
		$Xpath = "/XmlParams/XmlParam/Querys/Query[@fonction='GetTreeChildren_".$type."']";
		$Q = $this->site->XmlParam->GetElements($Xpath);
		
		if ($niv==-1){
			$tree = '<treechildren >'.EOL;
		
			$tree .= '<treeitem id="1" container="true" empty="false" >'.EOL;
			$tree .= '<treerow>'.EOL;
			$tree .= '<treecell label="'.$type.'"/>'.EOL;
			$tree .= '</treerow>'.EOL;
		
			$tree .= $this->GetTreeChildren_load($Q[0]->nextfct."", $niv+1);
		
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
				
				$tree .= '<treeitem id="'.$type."_".$r[0].'" container="true" open="false" >'.EOL;
				$tree .= '<treerow>'.EOL;
				$tree .= '<treecell label="'.$valXul.'"/>'.EOL;
				$tree .= '</treerow>'.EOL;

				if($Q[0]->nextfct)
					$tree .= $this->GetTreeChildren_load($Q[0]->nextfct."",$niv+1, $r[3], $r[4]);
						
				$tree .= '</treeitem>'.EOL;
						
			}//while
			
			if($nb>0)
				$tree .= '</treechildren>'.EOL;
			else
				$tree = '';
		}
			
	return $tree;
	}*/
		
	
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
	//$id =  mysql_insert_id();
	$db->close();
	return ($result1 = mysql_fetch_row( $result));
}

function GetGeoname($num_depart)
{	
	$db=new mysql ($this->site->infos["SQL_HOST"],$this->site->infos["SQL_LOGIN"],$this->site->infos["SQL_PWD"],$this->site->infos["SQL_DB"]);
	$db->connect();
	$sql = "SELECT * FROM `geoname` WHERE `num_depart_geoname`=\"$num_depart\" ";     
	$result = $db->query(utf8_decode($sql));
	//$id =  mysql_insert_id();
	$db->close();
	return ($result1 = mysql_fetch_row( $result));
}


}
?>