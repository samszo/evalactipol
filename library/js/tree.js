var start = new Object();
var end = new Object();


function GetTreeSelect(idTree,idTrace,colTrace){

  try {
	tree = document.getElementById(idTree);
	//pour gérer la multisélection
	var numRanges = tree.view.selection.getRangeCount();
	
	for (var t = 0; t < numRanges; t++){
		tree.view.selection.getRangeAt(t,start,end);
		
		
		
		for (var v = start.value; v <= end.value; v++){
			
				dump("GetTreeSelect colTrace[0] "+colTrace[0]+"\n");
				dump("GetTreeSelect idTrace "+idTrace+"\n");
				c = tree.treeBoxObject.columns[colTrace[0]];
				
				//document.getElementById(idTrace).value=tree.view.getCellText(v,c);
				document.getElementById(idTrace).value = tree.view.getItemAtIndex(v).id;
				
				var y = tree.view.getItemAtIndex(v).id;
				
				//alert("Item " + y + " sélectionné.");
		}
	}
  } catch(ex2){ alert("::"+ex2); }
}


