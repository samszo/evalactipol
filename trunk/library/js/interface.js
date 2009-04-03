
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
function testHello(idSrc){
	var id = document.getElementById(idSrc).value;
	//var tree = document.getElementById(idSrc);
	//var items=tree.selectedItems;
	alert("Selection " + id);

}
/*function testHello(id)
{
  //var tree=document.getElementById('treeset');
	var tree=document.getElementById("tree");
  var items=tree.selectedItems;
  if (items.length==0) alert("No items are selected.");
  else {
    txt="You have selected:\n\n";
    for (t=0;t<items.length;t++){
      txt+=items[t].firstChild.firstChild.getAttribute('value')+'\n';
    }
    alert(txt);
  }
}*/




