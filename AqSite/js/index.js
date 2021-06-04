// Alexey Masyuk & Yulia Berkovich Aquarium Monitoring Site.
// Scripts handling connection form, revealing and hidding.

// Display varibles
var b="block";
var h="hidden";
var n="none";
var v="visible";

// Containers name
var sif="signInForm";
var hd="heading";
var bt="button";


function openForm() {
  document.getElementById(sif).style.display = b;
  document.getElementById(hd).style.visibility=h;
   document.getElementById(bt).style.display=n;
}

function closeForm() {
  document.getElementById(sif).style.display = n;
   document.getElementById(hd).style.visibility=v;
   document.getElementById(bt).style.display=b;
}