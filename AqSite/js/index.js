// Alexey Masyuk & Yulia Berkovich Aquarium Monitoring Site.
// Scripts handling connection form, revealing and hidding.

// Display varibles
var b="block";
var h="hidden";
var n="none";
var v="visible";

// Containers name
var sif="signInForm";
var h="heading";
var bt="signInForm";


function openForm() {
  document.getElementById(sif).style.display = b;
  document.getElementById(g).style.visibility=h;
   document.getElementById(bt).style.display=n;
}

function closeForm() {
  document.getElementById(sif).style.display = n;
   document.getElementById(h).style.visibility=v;
   document.getElementById(b).style.display=b;
}