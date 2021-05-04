function FormDataRet(){
    var inp=document.getElementsByClassName("data");
    
    for(var i=0;i<inp.length;i++){
        inp[i].innerHTML=inp[i].value;
        alert(inp[i].value);
    }
    console.log(inp);
}