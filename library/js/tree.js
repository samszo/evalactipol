var start = new Object();
var end = new Object();

function GetTreeSelect(idTree,idTrace,colTrace){

  try {
	tree = document.getElementById(idTree);
	//pour g�rer la multis�lection
	var numRanges = tree.view.selection.getRangeCount();
	for (var t = 0; t < numRanges; t++){
		tree.view.selection.getRangeAt(t,start,end);
		for (var v = start.value; v <= end.value; v++){
			//alert("Item " + tree.view.getCellText(v,c) + " s�lectionn�.");
			for (var i = 0; i < idTrace.length; i++){
				dump("GetTreeSelect colTrace[i] "+colTrace[i]+"\n");
				dump("GetTreeSelect idTrace[i] "+idTrace[i]+"\n");
				c = tree.treeBoxObject.columns[colTrace[i]];
				document.getElementById(idTrace[i]).value=tree.view.getCellText(v,c);
			}
		}
	}
  } catch(ex2){ alert("::"+ex2); }
}



