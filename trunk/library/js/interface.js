
var fichierCourant;
var numFic = 0;
var DELIM = "*";

function ChargeTreeFromAjax(fonction,idDst,type)
{
  try {
	
	var doc = document.getElementById(idDst);
	//var num_depart = document.getElementById(idSrc).value;
	var url = urlExeAjax+"?f="+fonction+"&type="+type;
	AppendResult(url,doc);
	dump("ChargeTreeFromAjax OUT\n");
   
   } catch(ex2){alert(":ChargeTreeFromAjax:"+ex2+" url="+url);dump("::"+ex2);}
	
}

function ChargelistFromAjax(idDst,type)
{

try {
	
	var doc = document.getElementById(idDst);
	var id = document.getElementById(idDst).value;
	
	//if (type == "departement")
	//if (type == "France")
	//{
	var url = urlExeAjax2+"?f=Getlist&id="+id+"&type="+type;
	//}
	//else
	//{
	//var url = urlExeAjax2+"?f=Getlist_depute&id="+id+"&type="+type;
	//}
	
	AppendResult(url,doc);
	dump("ChargelistFromAjax OUT\n");
   
   } catch(ex2){alert(":ChargelistFromAjax:"+ex2+" url="+url);dump("::"+ex2);}	
	
}




