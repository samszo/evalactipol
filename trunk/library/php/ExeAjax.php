<?php
        
        require_once ("../../param/ParamPage.php");
        
        //charge le fichier de paramètrage
        
		$objSite->XmlParam = new XmlParam(PathRoot."/param/Evalactipol.xml");
		


        $resultat = "";
        
        if(isset($_POST['f'])){
              $fonction = $_POST['f'];
            
        }
		else
        if(isset($_GET['f']))
            $fonction = $_GET['f'];
        else 
        	$fonction ='';
		
		if(isset($_GET['id']))
			$id = $_GET['id'];
		else
			$id = -1;
		
		if(isset($_GET['type']))
			$type = $_GET['type'];
		else
			$type = -1;
        
       
		switch ($fonction) {
			
				
				case 'GetTree':
                	    $resultat= GetTree();
                	    break;
				case 'GetTree_load':
						$resultat= GetTree_load($type,'','','','Departements','France');
						break;
				case 'Getlist':
                	    $resultat= Getlist($id,$type);
                	    break;
				case 'Getlist_depute':
                	    $resultat= Getlist_depute($id,$type);
                	    break;
		}
        
        echo $resultat;  

	function GetTree(){
        global $objSite;
        $xul = new Xul($objSite);
		
		return $xul->GetTree();
	}
	
	function GetTree_load($type,$niv=-1,$val1=-1,$val2=-1,$contexteTree,$titreTree){
        global $objSite;
        $xul = new Xul($objSite);
		
		return $xul->GetTree_load($type,$niv=-1,$val1=-1,$val2=-1,$contexteTree,$titreTree);
	}
	
	function Getlist($id,$type){
		
		global $objSite;
        $xul = new Xul($objSite);
		
		return $xul->Getlist($id,$type);
	}
	function Getlist_depute($id,$type){
		
		global $objSite;
        $xul = new Xul($objSite);
		
		return $xul->Getlist_depute($id,$type);
	}
	
?>
