function currentSettings(){
    var settings=localStorage.getItem("settings");
    alert(settings);
    settings=personalDataCrop(settings);
    var p=document.getElementsByClassName('userSettigs')
    for(var i=0;i<settings.length;i++){
        if(typeof p[i]!="undefined"){
            p[i].innerHTML+=settings[i];
        }
    }
}

function alertFreq(personalData){
    var spliteDate=personalData.split(',');
    var splitAlert=spliteDate[spliteDate.length-1].split(' ');
    
    if(splitAlert[1]=='2'){
        spliteDate[spliteDate.length-1]="Every Two Days"; 
        return spliteDate;
    }
    spliteDate[spliteDate.length-1]="Every Day";
    return spliteDate;
}

function personalDataCrop(personalData){
    personalData=personalData.replace('}',',');
    personalData=personalData.replace('personal:','');
    personalData=alertFreq(personalData);
    return personalData;
    
}

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