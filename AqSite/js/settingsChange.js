// Alexey Masyuk & Yulia Berkovich Aquarium Monitoring Site.
// Scripts handling settings change JS manipulation,
// Revealing and hidding relevant input fields and displaying personal and aquarium credential and limits.

var i="inline";
var n="none";

// Parameter name to be pollen from chart.js containing personal data and credentials.
var s="settings";

// user settings container class name
var us='userSettigs';
var u="undefined";

var cm=',';
var tw='2';
var bl=' ';
var ed="Every Day";
var etd="Every Two Days"; 

var br='}';
var per='personal:';

var sub="applyButton";
// pulling current user settings sended from chart.js
// displaying it in relevant container.
function currentSettings(){
    var settings=localStorage.getItem(s);
    var tmp = settings[settings-2];
    settings[settings-2]=settings[settings-1];
    settings[settings-1]=tmp;
    alert("after swich"+settings);
    settings=personalDataCrop(settings);
    var p=document.getElementsByClassName(us);
     alert(settings.length);
     console.log(settings);

    for(var i=0;i<p.length;i++){
        if(typeof p[i]!=u){
            if(i<settings.length){
                p[i].innerHTML+=settings[i];
            }
            else{
                p[i].innerHTML+="Not Defined";
            }             
        }
    }
}

// Function handling feeding alert data crop and adjustment,
// as displaying current settings
function alertFreq(personalData){
    var spliteDate=personalData.split(cm);
    alert("alertFreq "+spliteDate);
    var splitAlert=spliteDate[spliteDate.length-1].split(bl);
    alert("alertFreq 2"+splitAlert);
    if(splitAlert[1]==tw){
        spliteDate[spliteDate.length-1]=etd; 
        return spliteDate;
    }
    spliteDate[spliteDate.length-1]=ed;
    return spliteDate;
}

// Function handling personal data crop and adjustment,
// as displaying current settings
function personalDataCrop(personalData){
    personalData=personalData.replace(br,cm);
    personalData=personalData.replace('}',cm);
    personalData=personalData.replace(per,'');
    alert(personalData);
    
    personalData=alertFreq(personalData);
    return personalData;
    
}

// Function openning or closing input fields and handling checkbox status
// acording to elementsToChange,stateToChange parameters.
function changeCycle(elementsToChange,stateToChange){       
    for(var i=1;i<elementsToChange.length;i+=2)
        {
            elementsToChange[i].style.display=stateToChange;
            elementsToChange[i-1].checked=false;
			if(stateToChange==i)
				elementsToChange[i-1].checked=true;
        }
}

// Function open all personal or aquarium input.
// acording to idToCheck,nameToOpen parameters.
function openAllTextBox(idToCheck,nameToOpen){
    if(document.getElementById(idToCheck).checked==true){
        changeCycle(document.getElementsByClassName(nameToOpen),i);
    }                
   else{
    changeCycle(document.getElementsByClassName(nameToOpen),n);
    }
}

// Function controling button Personal,Aquarium click,
// to open checkboxes of input field control


   
   function openOrClose(name1,name2){                
   if(document.getElementById(name1).style.display==n){
       document.getElementById(name1).style.display = i;
	   document.getElementById(sub).style.display=i;
   }
   else{
       document.getElementById(name1).style.display=n;
       document.getElementById(name1).value="";
   }
  
  if((document.getElementById(name1).style.display==n)&&(document.getElementById(name2).style.display==n))
		document.getElementById(sub).style.display=n;
	
	
} 