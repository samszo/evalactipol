<?php
class GoogleVisualisation{
  
	private $site;

function __tostring() {
	return "Cette classe permet la création dynamique d'objet google visualisation.<br/>";
}

function __construct($site) {
	$this->site = $site;
}

function GetData()
{
	$Xpath_columns = "/XmlParams/XmlParam/columns/column";
	$Xpath_rows = "/XmlParams/XmlParam/rows/row";
	$Q = $this->site->XmlParam->GetElements($Xpath_columns);
	$Q1 = $this->site->XmlParam->GetElements($Xpath_rows);
	$GetSqlInfos = new GetSqlInfos ($this->site);
		
	$Data = 'data.addColumn('.$Q[0]->type."".','.$Q[0]->value."".');';
	$Data .= 'data.addColumn('.$Q[1]->type."".','.$Q[1]->value."".');';
	$Data .= 'data.addColumn('.$Q[2]->type."".','.$Q[2]->value."".');';
	$Data .= 'data.addColumn('.$Q[3]->type."".','.$Q[3]->value."".');';
	$Data .= 'data.addColumn('.$Q[4]->type."".','.$Q[4]->value."".');';
	$Data .= 'data.addColumn('.$Q[5]->type."".','.$Q[5]->value."".');';
	
	$infos_num_departements = $GetSqlInfos->GetSqlNumsDepartements ();
	
	$numColonne = 0;
	foreach ($infos_num_departements as $num_departement)
	{
		//$num_departement = "01";
		$infos_Departement = $GetSqlInfos->GetSqlDepartement ($num_departement);
		$infos_Deputes = $GetSqlInfos->GetSqlDepute ($num_departement);
	
		foreach ($infos_Deputes[0] as $depute)
		{	
			$type = 'PlageDate1';

			$resultGetDataChildren = $this->GetDataChildren($type,$depute,$infos_Departement,$numColonne);
			$Data .= $resultGetDataChildren[0];
			$numColonne = $resultGetDataChildren[1] + 1;
		}
		
	}
	
	$initData = 'var data = new google.visualization.DataTable();';
	$initData .= 'data.addRows('.$Q1[0]->numRows.');';
	
	$Data = $initData.$Data;
	
	return $Data;
	
}

function GetDataChildren($type,$depute,$infos_Departement,$numColonne)
{
	$Xpath = "/XmlParams/XmlParam/dates/date[@fonction='GetDate_".$type."']";
	$Q = $this->site->XmlParam->GetElements($Xpath);

	$GetSqlInfos = new GetSqlInfos ($this->site);
	$NomPrenomDepute = html_entity_decode($depute[1])." ".html_entity_decode($depute[2]);
	$nbQuestionsMC = $GetSqlInfos->GetSqlNbQuestionsMC ($depute[0],$Q[0]->date1."",$Q[0]->date2."");

	$Data = 'data.setValue('.$numColonne.', 0, "'.$NomPrenomDepute.'");';
	$Data .= 'data.setValue('.$numColonne.', 1, new Date ('.$Q[0]->LimiteDate."".'));';
	$Data .= 'data.setValue('.$numColonne.', 2, '.$nbQuestionsMC[0].');';
	$Data .= 'data.setValue('.$numColonne.', 3, '.$nbQuestionsMC[1].');';
	$Data .= 'data.setValue('.$numColonne.', 4, '.$nbQuestionsMC[2].');';
	$Data .= 'data.setValue('.$numColonne.', 5, "'.html_entity_decode($infos_Departement[1]).'");';

	if ($type == "PlageDate1")
	{	
		$numColonne = $numColonne + 1;
		$Data1 = $this->GetDataChildren($Q[0]->nextPlageDate."",$depute,$infos_Departement,$numColonne);
		$Data .= $Data1[0]; 
	}
	if ($type == "PlageDate2")
	{	
		$numColonne = $numColonne + 1;
		$Data2 = $this->GetDataChildren($Q[0]->nextPlageDate."",$depute,$infos_Departement,$numColonne);
		$Data .= $Data2[0];

	}
	$numColonne = $numColonne + 1;

	return array ($Data,$numColonne);
}

function GetJson()
{
	$json = "google.visualization.Query.setResponse({version:'0.5',reqId:'0',status:'ok',sig:'6700864051796921914',";
	$json .= "table:{cols:[";
	$json .= "{id:'A',label:'Release Date',type:'date',pattern:'M/d/yyyy'},";

	$json .= "{id:'1',label:'nb questions Xavier Breton',type:'number',pattern:'#0.###############'},";
	$json .= "{id:'1',label:'Xavier Breton',type:'string',pattern:''},";

	$json .= "{id:'F',label:'nb questionB',type:'number',pattern:'#0.###############'},";
	$json .= "{id:'G',label:'Nom Depute',type:'string',pattern:''}],";

	$json .= "rows:[{c:[{v:new Date(2008,10,1),f:'10/1/2008'},{v:10,f:'10'},{v:'Xavier Breton'},{v:15,f:'15'},{v:'Xavier Bertran'}]},{c:[{v:new Date(2008,11,1),f:'11/1/2008'},{v:13,f:'13'},,{v:23,f:'23'}]},{c:[{v:new Date(2008,12,1),f:'12/1/2008'},{v:11,f:'11'},,{v:31,f:'31'}]},{c:[{v:new Date(2009,1,1),f:'1/1/2009'},{v:8,f:'8'},,{v:18,f:'18'}]},{c:[{v:new Date(2009,2,1),f:'2/1/2009'},{v:18,f:'18'},,{v:8,f:'8'}]},{c:[{v:new Date(2009,3,1),f:'3/1/2009'},{v:2,f:'2'},,{v:12,f:'12'}]},{c:[{v:new Date(2009,4,1),f:'4/1/2009'},{v:22,f:'22'},,{v:20,f:'20'}]}]}});";


	return $json;
}

}	
?>