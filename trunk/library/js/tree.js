var start = new Object();
var end = new Object();

/*function GetTreeSelect(idTree,idTrace,colTrace){

  try {
	tree = document.getElementById(idTree);
	//pour gérer la multisélection
	var numRanges = tree.view.selection.getRangeCount();
	
	//c = tree.treeBoxObject.columns[colTrace[0]];
	//var x = tree.view.getCellText(numRanges,c);
	//alert("Item " + x + " sélectionné.");
	
	for (var t = 0; t < numRanges; t++){
		tree.view.selection.getRangeAt(t,start,end);
		
		
		
		for (var v = start.value; v <= end.value; v++){
			
			
			//c = tree.treeBoxObject.columns[colTrace[0]];
			//var x = tree.view.getCellText(v,c);
			//alert("Item " + x + " sélectionné.");
			
			for (var i = 0; i < idTrace.length; i++){
				dump("GetTreeSelect colTrace[i] "+colTrace[i]+"\n");
				dump("GetTreeSelect idTrace[i] "+idTrace[i]+"\n");
				//c = tree.treeBoxObject.columns[colTrace[i]];
				c = tree.treeBoxObject.columns[colTrace[0]];
				//document.getElementById(idTrace[i]).value=tree.view.getCellText(v,c);
				document.getElementById(idTrace[i]).value=tree.view.getCellText(v,c);
				
				var y = tree.view.getItemAtIndex(v).id;
				alert("Item " + y + " sélectionné.");
				
				//alert("Item " + document.getElementById(idTrace[i]).value + " sélectionné.");
			}
		}
	}
  } catch(ex2){ alert("::"+ex2); }
}*/

function GetTreeSelect(idTree,idTrace,colTrace){

  try {
	tree = document.getElementById(idTree);
	//pour gérer la multisélection
	var numRanges = tree.view.selection.getRangeCount();
	
	//c = tree.treeBoxObject.columns[colTrace[0]];
	//var x = tree.view.getCellText(numRanges,c);
	//alert("Item " + x + " sélectionné.");
	
	for (var t = 0; t < numRanges; t++){
		tree.view.selection.getRangeAt(t,start,end);
		
		
		
		for (var v = start.value; v <= end.value; v++){
			
				dump("GetTreeSelect colTrace[0] "+colTrace[0]+"\n");
				dump("GetTreeSelect idTrace "+idTrace+"\n");
				//c = tree.treeBoxObject.columns[colTrace[i]];
				c = tree.treeBoxObject.columns[colTrace[0]];
				
				//document.getElementById(idTrace).value=tree.view.getCellText(v,c);
				document.getElementById(idTrace).value = tree.view.getItemAtIndex(v).id;
				
				var y = tree.view.getItemAtIndex(v).id;
				//var z = document.getElementById('libRub');
				//alert("Item " + y + " sélectionné.");
				
				//alert("Item " + document.getElementById(idTrace[i]).value + " sélectionné.");
			
		}
	}
  } catch(ex2){ alert("::"+ex2); }
}


