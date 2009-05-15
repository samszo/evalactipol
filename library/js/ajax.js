//--------------------------------------------
// AJAX Functions
//--------------------------------------------

function GetResult(url) {
  try {
	dump("GetResult IN "+url+"\n");
    response = "";
	p = new XMLHttpRequest();
	p.onload = null;
	//p.open("GET", urlExeAjax+"?f=GetCurl&url="+url, false);
	p.open("GET", url, false);
	p.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	p.send(null);

	if (p.status != "200" ){
	      alert("Réception erreur " + p.status);
		  
	}else{
	    response = p.responseText;
	}
	
	return response;
	dump("GetResult OUT \n");
   } catch(ex2){alert(ex2);dump("::"+ex2);}
}

function AppendResult(url,doc,ajoute,cont) {
  try {
  
  	if(!cont)
  		cont = "box";
	//dump("AppendResult IN "+url+"\n");
	document.documentElement.style.cursor = "wait";

	p = new XMLHttpRequest();
	p.onload = null;
	p.open("GET", url, false);
	p.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	p.send(null);

	if (p.status != "200" ){
		
		alert("Réception erreur " + p.status);
		  
	}else{
	    response = p.responseText;
		xulData="<"+cont+" id='dataBox' flex='1'  " +
	          "xmlns='http://www.mozilla.org/keymaster/gatekeeper/there.is.only.xul'>" +
	          response + "</"+cont+">";
		var parser=new DOMParser();
		var resultDoc=parser.parseFromString(xulData,"text/xml");
		if(!ajoute){
			//vide le conteneur
			while(doc.hasChildNodes())
				doc.removeChild(doc.firstChild);
		}
		//ajoute le résultat
		doc.appendChild(resultDoc.documentElement);
	}
	document.documentElement.style.cursor = "auto";
	
	return resultDoc ;
	//dump("AppendResult OUT \n");
   } catch(ex2){alert(ex2);}
}

