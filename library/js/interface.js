
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

function ChargeListTreesFromAjax(idDst,type)
{

	try 
	{
		var doc = document.getElementById(idDst);
		var id = document.getElementById(idDst).value;
		//alert (id);
		if (id != "1")
		{
			//var url = urlExeAjax2+"?f=Getlist&id="+id+"&type="+type;
			var url = urlExeAjax2+"?f=GetTrees&id="+id+"&type="+type;
			AppendResult(url,doc);
			dump("ChargeListTreesFromAjax OUT\n");
		}
		if (type =="departement")
		{
			setunhidden('libCanton');
			setunhidden('liste');
			setunhidden('tagcloud');
			
		}

	} catch(ex2){alert(":ChargeListTreesFromAjax:"+ex2+" url="+url);dump("::"+ex2);}	

}

function ChargeListBoxFromAjax(idDst,type)
{

	try 
	{
		var doc = document.getElementById(idDst);
		var id = document.getElementById(idDst).value;
		//alert (id);
		if (id != "1")
		{
			//var url = urlExeAjax2+"?f=Getlist&id="+id+"&type="+type;
			var url = urlExeAjax2+"?f=GetListes&id="+id+"&type="+type;
			AppendResult(url,doc);
			dump("ChargeListBoxFromAjax OUT\n");
		}
		//if (type =="departement")
		//{
		//	setunhidden('libCanton');
			
			
		//}

	} catch(ex2){alert(":ChargeListBoxFromAjax:"+ex2+" url="+url);dump("::"+ex2);}	

}
/*function ChargeTagcloudFromAjax(idDst,type)
{

	try 
	{
		var doc = document.getElementById(idDst);
		var id_depute = document.getElementById(idDst).value;
		
		var url = urlExeAjax2+"?f=GetTagcloud&id_depute="+id_depute;
		AppendResult(url,doc);
		dump("ChargeTagcloudFromAjax OUT\n");
		
		
	} catch(ex2){alert(":ChargeTagcloudFromAjax:"+ex2+" url="+url);dump("::"+ex2);}	

}*/

function ChargeTagcloudFromAjax(idDst,idBox)
{

	/*try 
	{
		var doc = document.getElementById(idDst);
		var id_depute = document.getElementById(idDst).value;
		
		var url = urlExeAjax2+"?f=GetTagcloud&id_depute="+id_depute;
		AppendResult(url,doc);
		dump("ChargeTagcloudFromAjax OUT\n");
		
		
	} catch(ex2){alert(":ChargeTagcloudFromAjax:"+ex2+" url="+url);dump("::"+ex2);}	*/
	
	//var url = "map.php?adresse="+dptname+",France&id="+id+"&lat="+latitude+"&lng="+longitude+"&zoom="+zoom; 
	var id = document.getElementById(idDst).value;
	
	//var url = "library/php/nuagemot-floptwo.php"; 
	var url = "library/php/nuagemot-floptwo.php"+"?id="+id;
	GoUrl(url,idBox);

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
	//var url = "library/php/graphe.php"+"?id="+id;
	var url = "graphe.php"+"?id="+id;
	GoUrl(url,idBox);

}

function GetMapVisualisation(idDst,idBox){
	
	
	tree = document.getElementById(idDst);
	var numRanges = tree.view.selection.getRangeCount();
	for (var t = 0; t < numRanges; t++){
		tree.view.selection.getRangeAt(t,start,end);
		for (var v = start.value; v <= end.value; v++){
			
			var id = tree.view.getItemAtIndex(v).id;
			var ElementTag = document.getElementById(id).getElementsByTagName("treecell")[0];
			var dptname = ElementTag.getAttribute("label");
			var latitude = document.getElementById(id).getAttribute("lat");
			var longitude = document.getElementById(id).getAttribute("lng");
			var zoom = document.getElementById(id).getAttribute("zoom");
			
		}
	}
	if (id != "1")
	{
	var url = "map.php?adresse="+dptname+",France&id="+id+"&lat="+latitude+"&lng="+longitude+"&zoom="+zoom; 
	GoUrl(url,idBox);
	}
}

function GoUrl(url,idBox){
 
 box=document.getElementById(idBox);
 box.removeChild(box.firstChild);
 ifram=document.createElement("iframe");
 ifram.setAttribute("src",url);
 ifram.setAttribute("flex","1");
 box.appendChild(ifram);
 
}
