<?php
        
        require_once ("../../param/ParamPage.php");
        
        //charge le fichier de param�trage
        
		$objSite->XmlParam = new XmlParam(PathRoot."/param/Evalactipol.xml");


        $resultat = "";
        
        if(isset($_POST['f'])){
              $fonction = $_POST['f'];
            
        }else
        if(isset($_GET['f']))
                $fonction = $_GET['f'];
        else 
        		$fonction ='';
        
       
		switch ($fonction) {
			
				
				case 'GetTree':
                	    $resultat= GetTree();
                	    break;
				case 'GetTree_load':
                	    $resultat= GetTree_load();
                	    break;
		}
        
        echo $resultat;  

	function GetTree(){
        global $objSite;
        $xul = new Xul($objSite);
		
		return $xul->GetTree();
	}
	
	function GetTree_load(){
        global $objSite;
        $xul = new Xul($objSite);
		
		return $xul->GetTree_load();
	}
	
?>
