<?php
	require_once ("param/ParamPage.php");

	$baseUrl ="http://www.laquadrature.net";
	$html = file_get_html($baseUrl."/wiki/Deputes_par_departement");
	//$ret = $html->find('a[title]');
	$retours = $html->find('li a[title^=Deputes]');

	//boucle sur les d�partements
	foreach($retours as $dept){
		$urlDept = $dept->attr["href"];	
		//extraction des infos des d�put�es
		$url =$baseUrl.$urlDept;
		$htmlDept = file_get_html($url);
		//$ret = $html->find('a[title]');
		$rsDept = $htmlDept->find('td a[href^=/wiki/]');
		foreach($rsDept as $depu){
			$urlDepu = $depu->attr["href"];	
			//v�rifie qu'on traite un d�put�
			$nom = substr($urlDepu,6,7);
			if($nom!="Deputes"){
				//extraction des info du d�put�
				echo $depu;			
			}
		}
				//extraction des question du d�put�s
				
	}
	
?>