
var fichierCourant;
var numFic = 0;
var DELIM = "*";

function ChargeTreeFromAjax(fonction,idDst,type)
{
  try {
	
	var doc = document.getElementById(idDst);
	//var id = document.getElementById(idDst).value;
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
	
	if (id != "1")
	{
		var url = urlExeAjax2+"?f=Getlist&id="+id+"&type="+type;
	
		AppendResult(url,doc);
		dump("ChargelistFromAjax OUT\n");
	}
	if (type =="departement")
	{
		setunhidden('libCanton');
	}
   
   } catch(ex2){alert(":ChargelistFromAjax:"+ex2+" url="+url);dump("::"+ex2);}	
	
}

function setunhidden(idDst)
{

try {
	
	
	document.getElementById(idDst).style.visibility='visible';
	
   
   } catch(ex2){alert(":ChargelistFromAjax:"+ex2+" url="+url);dump("::"+ex2);}	
	
}

function sethidden(idDst)
{

try {
	
	
	document.getElementById(idDst).style.visibility='hidden';
	
   
   } catch(ex2){alert(":ChargelistFromAjax:"+ex2+" url="+url);dump("::"+ex2);}	
	
}




