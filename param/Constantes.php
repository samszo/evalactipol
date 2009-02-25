<?php
  //
  // Fichier contenant les definitions de constantes
  //define ("PathRoot",$_SERVER["DOCUMENT_ROOT"]."/Evalactisem.V1");
  //pour le débubbage
  define ("PathRoot","C:/wamp/www/evalactipol");

  // *** chemin de toutes les bases et les spip en service ***
  define("CLASS_BASE", PathRoot."/library/php/");
  // Include the class files.
  require_once(CLASS_BASE."AllClass.php");

  define ("DEFSITE", "local");
  //define ("DEFSITE", "mundi");
  
  $dbOptions = array (
		'ERROR_DISPLAY' => true
		);
  
  define('EOL', "\r\n");
  $Site = array(
	"PATH_WEB" => "http://localhost/evalactipol/", 
	"SQL_LOGIN" => "root", 
	"SQL_PWD" => "", 
	"SQL_HOST" => "localhost",
	"SQL_DB" => "evalactipol",
	"NOM" => "EvalActiPol",//je sais pas
	"SITE_PARENT" => -1,//je sais pas
	"SITE_ENFANT" => -1
	); 	
	
  $SITES = array(
	"local" => $Site
    );

  
?>