<?php
function extract_departement ($urlDept,$dept)

{
        
        $numDepart = substr($urlDept,14);
        $numDepartDepute = (int)$numDepart;   
    
        //Extraction du nom de département  
        $NomDepart = $dept->nodes;
        $ChaineNomDepart = implode(";", $NomDepart);
        $nomGeo_Depart = extractBetweenDelimeters($ChaineNomDepart,""," ");
    //    $nomGeo_Depart = filter ($nomGeo_Depart1);  
        $type_geoname = "Departement";  
        return array ($numDepartDepute,$nomGeo_Depart,$type_geoname);
}
?>