<?php

require_once ("param/ParamPage.php");

$baseUrl ="http://www.laquadrature.net";
$extract_object=new extract ($objSite, $baseUrl, $cl_Output);
$result=$extract_object->extract_site();

?>