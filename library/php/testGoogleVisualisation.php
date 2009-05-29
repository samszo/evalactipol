<?php

require_once ("../../param/ParamPage.php");
require_once('simpletest/autorun.php');
require_once('GoogleVisualisation.php');

class TestOfGoogleVisualisation extends UnitTestCase {
 function testGoogleVisualisation() {
		global $objSite;
		$GoogleVisualisation = new GoogleVisualisation($objSite);
		$data = $GoogleVisualisation->GetDataOneDepart('01');
		//Echoue si $data n'est pas initialis� (est null)
		$this->assertNotNull($data);
		//Echoue si $data est initialis� (n'est pas null)
		//$this->assertNull($data);
    }

}
?>
