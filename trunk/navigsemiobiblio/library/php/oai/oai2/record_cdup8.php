<?php
/*
* +----------------------------------------------------------------------+
* | PHP Version 4                                                        |
* +----------------------------------------------------------------------+
* | Copyright (c) 2002-2005 Heinrich Stamerjohanns                       |
* |                                                                      |
* | dc_record.php -- Utilities for the OAI Data Provider                 |
* |                                                                      |
* | This is free software; you can redistribute it and/or modify it under|
* | the terms of the GNU General Public License as published by the      |
* | Free Software Foundation; either version 2 of the License, or (at    |
* | your option) any later version.                                      |
* | This software is distributed in the hope that it will be useful, but |
* | WITHOUT  ANY WARRANTY; without even the implied warranty of          |
* | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the         |
* | GNU General Public License for more details.                         |
* | You should have received a copy of the GNU General Public License    |
* | along with  software; if not, write to the Free Software Foundation, |
* | Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA         |
* |                                                                      |
* +----------------------------------------------------------------------+
* | Derived from work by U. Müller, HUB Berlin, 2002                     |
* |                                                                      |
* | Written by Mehdi Touibi, December 2008                          |
* /            touibimehdi@yahoo.fr                                   |
* +----------------------------------------------------------------------+
*/
//
// $Id: record_cdup8.php,v 1.02 2008/12/08 14:32:07 stamer Exp $
//

// this handles unqualified DC records, but can be also used as a sample
// for other formats.
// just specify the next variable according to your own metadata prefix
// change output your metadata records further below.

// please change to the according metadata prefix you use 
$prefix = 'oai_cdup8';

// you do need to change anything in the namespace and schema stuff
// the correct headers should be created automatically

$output .= 
'   <metadata>'."\n";

$output .= metadataHeader($prefix);

// please change according to your metadata format
$indent = 6;
$output .= xmlrecord($record['cdu'], 'cdu', '', $indent);
$output .= xmlrecord($record['ieml'], 'ieml', '', $indent);
$output .= "<timeline>".$record['timeline']."</timeline>\n";
$output .= "".$record['kml']."\n";


// Here, no changes need to be done
$output .=           
'     </'.$prefix;
if (isset($METADATAFORMATS[$prefix]['record_prefix'])) {
    $output .= ':'.$METADATAFORMATS[$prefix]['record_prefix'];
}
$output .= ">\n";
$output .= 
'   </metadata>'."\n";
?>