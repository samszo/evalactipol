<?php

require_once ("param/ParamPage.php");
require_once ("library/php/AllClass.php");

$baseUrl ="http://www.laquadrature.net";
$extract_object=new extract ($baseUrl);
$result=$extract_object->extract_site ($baseUrl);
				
?>