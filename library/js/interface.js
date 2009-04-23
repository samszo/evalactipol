
var fichierCourant;
var numFic = 0;
var DELIM = "*";

function ChargeTreeFromAjax(fonction,idDst,type)
{
	try 
	{

		var doc = document.getElementById(idDst);
		var url = urlExeAjax+"?f="+fonction+"&type="+type;
		AppendResult(url,doc);
		dump("ChargeTreeFromAjax OUT\n");

	} catch(ex2){alert(":ChargeTreeFromAjax:"+ex2+" url="+url);dump("::"+ex2);}

}

function ChargelistFromAjax(idDst,type)
{

	try 
	{
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

	try 
	{
		document.getElementById(idDst).style.visibility='visible';
	} catch(ex2){alert(":setunhidden:");dump("::"+ex2);}	

}

function sethidden(idDst)
{

	try 
	{
		document.getElementById(idDst).style.visibility='hidden';
	} catch(ex2){alert(":sethidden:");dump("::"+ex2);}	

}

function GetDataAllDepart() 
{
	try 
	{	
		var urlExeAjax = "http://localhost/evalactipol/library/php/ExeAjax.php";
		var url = urlExeAjax+"?f=GetDataAllDepart";
		
		var doc = document.getElementById('chart_div');
		var result = GetResult(url);
		
		return result; 
	}catch(ex2){alert(":GetDataAllDepart:");dump("::"+ex2);}	
}

function GetDataOneDepart(numDepartement) 
{
	try 
	{	
		var urlExeAjax = "http://localhost/evalactipol/library/php/ExeAjax.php";
		
		var url = urlExeAjax+"?f=GetDataOneDepart&numDepartement="+numDepartement;
		
		var doc = document.getElementById('chart_div');
		var result = GetResult(url);
		
		return result; 
	}catch(ex2){alert(":GetData:");dump("::"+ex2);}	
}

function GetGoogleVisualisation(idDst,idBox){
	var id = document.getElementById(idDst).value;
	var url = "library/php/graphe.php"+"?id="+id;
	GoUrl(url,idBox);

}

function GoUrl(url,idBox){
 
 box=document.getElementById(idBox);
 box.removeChild(box.firstChild);
 ifram=document.createElement("iframe");
 ifram.setAttribute("src",url);
 ifram.setAttribute("flex","1");
 box.appendChild(ifram);
 
}
