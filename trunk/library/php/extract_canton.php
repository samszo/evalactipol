<?php

function extract_canton ($htmlDept)

{
            $rsCantons = $htmlDept->find('tbody tr');
            //supprimer la premi�re ligne qui repr�sente le nom des colonnes
            $rsCantons1 = array_shift($rsCantons);
                  
            //Boucler sur les Cantons
            $x = "";
            foreach($rsCantons as $cantons){
            $infosCantons = $cantons->children;
            
            $ChaineCantons = implode(";", $infosCantons);
            
            //Extraction des noms des cantons dans une chaine de caract�res
            $nom_cantons = extractBetweenDelimeters($ChaineCantons,"(cantons de ",")");
           // $nom_cantons = filter ($nom_cantons1);
            //Insertion des noms des cantons dans un tableau
            $tabNomGeonameCantons = explode (",",$nom_cantons);
            
            foreach ($tabNomGeonameCantons as $value)
            {
            //Pr�ciser que le type de geoname d'un canton est canton
            // avant d'ins�rer le canton dans la table geoname
            $nom_geoname_canton = filter ($value);
            $nom_geoname_canton = $value;
            $type_geoname_canton = "canton";
            //Extraction du num�ro de circonscription du canton
            $circonscription_cantons = substr($ChaineCantons,5,1);    
            insert_table_geoname ($nom_geoname_canton,$type_geoname_canton,$circonscription_cantons);
           
            
            $x = $x.",".$circonscription_cantons;
            }
            }
            //Les num�ros de circonscriptions qui existent dans un d�partement
            $circonscriptions_depart1 = substr($x,1);
            $circonscriptions_depart2 = explode (",",$circonscriptions_depart1);
            $circonscriptions_depart3 = array_unique ($circonscriptions_depart2);
            $circonscriptions_depart = implode(",", $circonscriptions_depart3);
            
            $type_geoname = "Ville";
         return array  ($nom_cantons,$circonscription_cantons,$circonscriptions_depart,$type_geoname,$tabNomGeonameCantons);   
            
}
?>