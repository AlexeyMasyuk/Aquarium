function changeCycle(elementsToChange,stateToChange){
            
    for(var i=1;i<elementsToChange.length;i+=2)
        {
            elementsToChange[i].style.display=stateToChange;
            elementsToChange[i-1].checked=false;
			if(stateToChange=="inline")
				elementsToChange[i-1].checked=true;
        }
}

function openAllTextBox(idToCheck,nameToOpen){
    if(document.getElementById(idToCheck).checked==true){
        changeCycle(document.getElementsByClassName(nameToOpen),"inline");
    }                
   else{
    changeCycle(document.getElementsByClassName(nameToOpen),"none");
    }
}

function openOrClose(name){                
   if(document.getElementById(name).style.display=="none"){
       document.getElementById(name).style.display = "inline";
   }
   else{
       document.getElementById(name).style.display="none";
       document.getElementById(name).value="";
   }
}