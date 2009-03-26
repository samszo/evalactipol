
var fichierCourant;
var numFic = 0;
var DELIM = "*";

function ChargeTreeFromAjax(fonction,idDst)
{
  try {
	
	var doc = document.getElementById(idDst);
	var url = urlExeAjax+"?f="+fonction;
	
	AppendResult(url,doc);
	//AppendResult(url);
	
	dump("ChargeTreeFromAjax OUT\n");
   
   } catch(ex2){alert(":ChargeTreeFromAjax:"+ex2+" url="+url);dump("::"+ex2);}
	
}


