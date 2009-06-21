<?php
	require('../../param/ParamPage.php');

	$oTC = new TagCloud($objSite,$oDelicious,$lang,$_GET['login']);
	//$oTC->SauveBookmarkNetwork("luckysemiosis","Samszo0");
  	
	header("Content-type: image/svg+xml");
	
	$TC=="posts";
		//$oTC->GetSvgPost($_GET['login'],$ShowAll,$TempsVide,$DateDeb,$DateFin,$NbDeb,$NbFin);
		$oTC->GetPosts('evalactisem');
		
	/*if($TC=="posts")
		//$oTC->GetSvgPost($_GET['login'],$ShowAll,$TempsVide,$DateDeb,$DateFin,$NbDeb,$NbFin);
		$oTC->GetPosts('evalactisem');
	if($TC=="tags")
		$oTC->GetSvgTag($_GET['login'],$ShowAll,$NbDeb,$NbFin);
	if($TC=="roots")
		$oTC->GetSvgRoot($_GET['login'],$ShowAll,$NbDeb,$NbFin);*/
		
?>