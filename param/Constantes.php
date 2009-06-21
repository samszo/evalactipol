<?php
  //
  // Fichier contenant les definitions de constantes
  
  //pour le débubbage
	//define ("PathRoot","C:/wamp/www/evalactipol");
	define ("PathRoot","C:/Program Files/EasyPHP 2.0b1/www/evalactipol");


  // *** chemin de toutes les bases et les spip en service ***
	define("CLASS_BASE", PathRoot."/library/php/");
  // *** Define the path to the SVG class dir. ***
	define("SVG_CLASS_BASE", PathRoot."/library/svg/");
  // Include the class files.
  require_once(CLASS_BASE."AllClass.php");
  

  define("LIFETIME",10000);
  define("CACHEPATH",PathRoot."/bdd/extract/");
  
  define ("DEFSITE", "local");
  define ("CACHETIME", 100000000);
  define('CACHE_PATH', PathRoot.'/bdd/extract/');   
  define ("TRACE", false);
  
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