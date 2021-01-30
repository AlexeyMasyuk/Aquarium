function currentSettings(){
    var settings=localStorage.getItem("settings");
    settings=personalDataCrop(settings);
    var p=document.getElementsByClassName('userSettigs')
    for(var i=0;i<settings.length;i++){
        console.log(p[i]);
        if(typeof p[i]!="undefined"){
            p[i].innerHTML+=settings[i];
        }
    }

    // var arr=settings.split(',');
    // document.getElementById("high").innerHTML=settings;
    // alert(settings);
    console.log(settings);

}

function personalDataCrop(personalData){
    personalData=personalData.replace('}',',');
    personalData=personalData.replace('personal:','');
    personalData=personalData.slice(0,personalData.length-2);
    // personalData=personalData.replace(personalData.length-1,'');
    console.log(personalData[personalData.length-1]);
    return personalData.split(',');
    
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