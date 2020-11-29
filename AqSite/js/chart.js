function dataFilter(arr,wantedDate){
    var newArr="";
    var spitedArr=arr.split(',');
    for(i=0;i<spitedArr.length;i++){
        if(spitedArr[i].includes(wantedDate)){
            newArr+=(spitedArr[i++]+','+spitedArr[i]+',');
        }
    }
    return newArr;
}

function sort(arr){
    
    var wantedDate = document.getElementById("wantedDate").value;
    var newArr="";
                  
    if(wantedDate.length==0){
        newArr=arr;
    }else{           
        newArr=dataFilter(arr,wantedDate);
    }  
    return newArr;
}

function strToTableArr(arr,wantedChart){
    
    var newArr=arr.split(",");

    var data = new google.visualization.DataTable();
    data.addColumn('string', 'time');
    data.addColumn('number', wantedChart);
    for(i = 0; i < newArr.length-1; i++)
    {
        data.addRow([newArr[i], parseFloat(newArr[++i])]);
    }
    return data;
}

function dataToChartFormat(arr){
    var wantedChart = document.getElementById('chart').value;
    var data;
    if (wantedChart == 'PH') {
        data = strToTableArr(sort(arr[7]),wantedChart);
    }
    else if (wantedChart == 'temp') {
        data = strToTableArr(sort(arr[3]),wantedChart);
        
    }
    else if (wantedChart == 'level') {
        data = strToTableArr(sort(arr[11]),wantedChart);
    }
    return data;
}

function change(){
        var oReq = new XMLHttpRequest(); // New request object
        oReq.onload = function() {
    
        google.load("visualization", "1", {packages:["corechart"]});
        var arr = this.responseText.split('"');
            
        google.setOnLoadCallback(drawChart);
        function drawChart() {
            var options = {
                title: 'Aquarium',
                curveType: 'function',
                legend: { position: 'bottom' }
            };
    
             var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
             chart.draw(dataToChartFormat(arr), options);
        }
        var toDiv = document.getElementById('alarms_div');
        var alarmData = arr[15];
        toDiv.innerHTML = alarmData;
        };
        oReq.open("get", "js/chartData.php", true);
        oReq.send();
}

function closAll(){
    var toClose=document.getElementsByClassName("dayMonth");
    document.getElementById("wantedDate").value="";
    for(var i=0;i<toClose.length;i++){
        toClose[i].style.display="none";
    }
}

function openSelection(val){
    if(val=="all"){
        closAll();
        change();
    }else{
        dayMonth(val);
    }
}

function dayMonth(val){
    closAll();
    document.getElementById(val).style.display="inline";
    document.getElementById("dayMonthForm").style.display="inline"
}

function lineSeperatorsAndAmountCheck(wantedDate,wantedSeperator){
    var counterFlag=wantedSeperator;
    for(i=0;i<wantedDate.length;i++){
        if(wantedDate[i]=='-'){
            counterFlag--;
        }
    }
    if(counterFlag==0){
        return true
    }
    return false;
}

function dateNumbersValitation(wantedDate){
    for(i=0;i<wantedDate.length;i++){
        if(wantedDate[i]!='-'&&(wantedDate[i]<'0'||wantedDate[i]>'9')){
            return false;
        }
    }
    return true;
}

function ValidationExecution(wantedDate,wantedSeperator){
    if(lineSeperatorsAndAmountCheck(wantedDate,wantedSeperator)){
        if(dateNumbersValitation(wantedDate)){
            change();
            return false;
        }
    }
    return true;
}

function dateFormatValidation(){
    var DayOrMotnh=document.getElementById("chartFilter").value;    
    var wantedDate = document.getElementById("wantedDate").value;
    var ValidFlag=true;
    var wantedSeperator=1;
    if(DayOrMotnh=="day"){
        wantedSeperator=2;
    }
    if(wantedDate.length>0){
        if(DayOrMotnh=="day"&&wantedDate.length==10){
            ValidFlag=ValidationExecution(wantedDate,wantedSeperator);
        }
        else if(DayOrMotnh=="month"&&wantedDate.length==7){
            ValidFlag=ValidationExecution(wantedDate,wantedSeperator);
        }
    }
    if(ValidFlag){
        alert("Wrong date Format");
    }
}

function ContentSwich(){
    var DayOrMotnh=document.getElementById("chartFilter").value;
    if(DayOrMotnh!="all"){
        dateFormatValidation();
    }
    else{
        change();
    }
}