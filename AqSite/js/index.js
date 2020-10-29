menu.onclick=function myFunction_name(){
    var x=document.getElementById("myTopnav");
    if(x.className === "topnav"){
        x.className += " responsive";
    }else{
        x.className="topnav";
    }
}

function openForm() {
  document.getElementById("signInForm").style.display = "block";
  document.getElementById("heading").style.visibility="hidden";
   document.getElementById("button").style.display="none";
}

function closeForm() {
  document.getElementById("signInForm").style.display = "none";
   document.getElementById("heading").style.visibility="visible";
   document.getElementById("button").style.display="block";
}