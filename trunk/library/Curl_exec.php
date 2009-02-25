<?php

function Curl ($url)
        {
		
	  $Curl = curl_init($url);
	  curl_setopt($Curl, CURLOPT_RETURNTRANSFER, 1);
	  $Result = curl_exec($Curl);
	  curl_close($Curl);
          return $Result;
		
	}
?>