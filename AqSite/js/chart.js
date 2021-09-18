// Alexey Masyuk & Yulia Berkovich Aquarium Monitoring Site.
/*
   JS functions all main page chart data manipulations and alarm div.
   All user data from sqlDB gathered in php 'chartData'.

   ** var settings and limitsToSettChngData()
      used for passing data to settings change page.
    
*/

//----------------------------------------------------------------------------//
// UserDataArr data location.
var levelData=11;
var temperatureData=3;
var phData=7;
var limitsData=19;

// CN - Container Name.
var alarmCN='alarms_div';
var wantedDateCN='wantedDate';
var chartCN="chart";
var dayMonthCN="dayMonth";
var wantedDateCN="wantedDate";
var chartfilterCN="chartFilter";
var chartCM='chart_div';
var dayMonthFormCN="dayMonthForm";

// Chart varibles
var v="visualization";
var c="corechart";
var o="1";
var str="string";
var t="time";
var n="number";
var T="Temp";
var P="PH";
var l="level";
var hl="HighLimit";
var ll="LowLimit";
var aq='Aquarium';
var f='function';
var btn='bottom';
var chartRefreshInterval = 30000

// filter options
var d="day";
var w="week";
var m="month";
var a="all";



// style display varibles
var no="none";
var i="inline";
var b="block";

// Navigation location
var ix="indexAq.php";

// comparisson and split signs
var s=' ';
var dt='.';
var cm=',';
var ap='"';
var z='0';
var nn='9';
var un = 'undefined';

// messages
var wdt="Wrong date Format";
var fe="Fatal error";

var sendVarName="settings";
var p="personal";

// Get data from php file varibles
var phpChartDataPath="PageActClasses/chartData.php";
var g="get";

// storing user personal and aquarium limits to be displayed settings change
var settings = ""; 

// Sending personal and aquarium limits to settings change page.
function limitsToSettChngData(){
    localStorage.setItem(sendVarName,settings);
}

// Function adjusting the data to settings change page use.
function dataCropToSettChng(UserDataArr){
    var found=false;
    var j=0;
    for(var i=0;i<UserDataArr.length;i++){
        if(UserDataArr[i]==p||found==true){
            found=true;
            settings+=UserDataArr[i];
        }
    }
    settings+=UserDataArr[limitsData];
}
//----------------------------------------------------------------------------//

// Function filtering chart data for 'last week' only
// * last 7 days recorded.
// using 2 inner fuctions for data reverce and records unite.
// Returning filtered array to be shown on chart.
function weekFilter(UserDataArr){
    function rev(arrToRev)
    {
        var str="";
    var arrLen=arrToRev.length;
    for(i=0;i<arrLen;i++) {str+=(arrToRev.pop());}
    return str;
}
    function Union(arrToUnite){
        var newArr=[];
        for(i=0;i<arrToUnite.length;i++){
            newArr.push(arrToUnite[i++]+cm+arrToUnite[i]);
        }
        return newArr;
    }
    
    var spitedArr=Union(UserDataArr.split(cm));
    var tmpArr=[];
    //alert(spitedArr);
    try{
    var daySplit=spitedArr[spitedArr.length-2].split(s)[0];
    

    for(i=spitedArr.length-2,j=0;j<7;j++){        
        for(;spitedArr[i].includes(daySplit);i--){           
            tmpArr.push(spitedArr[i]+cm);       
        }
        daySplit=spitedArr[i].split(s)[0];              
    }}catch(err){      
        return rev(tmpArr);
    }
    return rev(tmpArr);
}

// Function filtering data by day or mont given in wantedDate.
function DayOrMontDataFilter(UserDataArr,wantedDate){
    var newArr="";
    var spitedArr=UserDataArr.split(cm);
    for(i=0;i<spitedArr.length;i++){
        if(spitedArr[i].includes(wantedDate)){
            newArr+=(spitedArr[i++]+cm+spitedArr[i]+cm);
        }
    }
    return newArr;
}

// Function checking what filter user choosed and calling relevant data croping
function sort(UserDataArr,week){
    var wantedDate = document.getElementById(wantedDateCN).value;
    var newArr="";        
    if(wantedDate.length==0){ // no input filter ,all or week options
        if(week){
            newArr=weekFilter(UserDataArr);
        }else{
            newArr=UserDataArr;
        }
    }
    else{                   // filter by user input date
        newArr=DayOrMontDataFilter(UserDataArr,wantedDate);
    }  
    return newArr;
}

// Function adding alarms limit lines to the chart.
function limitToData(chartData,limitsStr,newArr,limitType){
    var wantedLimits=limitsStr.split(cm);
    var choosenLimits=Array(wantedLimits[0],wantedLimits[1])
    if(limitType==T){
        choosenLimits[0]=wantedLimits[2];
        choosenLimits[1]=wantedLimits[3];
    }
    for(i = 0; i < newArr.length-1; i++)
    {
        chartData.addRow([newArr[i], parseFloat(newArr[++i]),parseFloat(choosenLimits[0]),parseFloat(choosenLimits[1])]);
    }
    return chartData;
}

// Function creating data for no limits chart, water level
function noLimitsChart(chartData,newArr){
    for(i = 0; i < newArr.length-1; i++)
    {
        chartData.addRow([newArr[i], parseFloat(newArr[++i])]);
    }
    return chartData;
}

// Function creating DataTable for the chart,
// initializing relevant columns and adding limit lines if needed
function strToTableArr(UserDataArr,wantedChart,limitsArr){
    var newArr=UserDataArr.split(cm);

    var data = new google.visualization.DataTable();
    data.addColumn(str, t);
    data.addColumn(n, wantedChart);
    if(wantedChart==T||wantedChart==P){
        data.addColumn(n, wantedChart+hl);
        data.addColumn(n, wantedChart+ll);
        return limitToData(data,limitsArr,newArr,wantedChart);
    }
    return noLimitsChart(data,newArr);
}

// Function creating relevant data for the chart depending on kind of data chosen by the user.
function dataToChartFormat(UserDataArr,week){
    var wantedChart = document.getElementById(chartCN).value;
    var data;
    if (wantedChart == P) {
        data = strToTableArr(sort(UserDataArr[phData],week),wantedChart,UserDataArr[limitsData]);
    }
    else if (wantedChart == T) {
        data = strToTableArr(sort(UserDataArr[temperatureData],week),wantedChart,UserDataArr[limitsData]);
        
    }
    else if (wantedChart == l) {
        data = strToTableArr(sort(UserDataArr[levelData],week),wantedChart,UserDataArr[limitsData]);
    }
    return data;
}

// Function pushing data to alarm_div
function alarmsToDiv(UserDataArr){
    var toDiv = document.getElementById(alarmCN);
    var alarmData = UserDataArr[15];
    alarmDiv=alarmData.replace(/\\/g, "");

    toDiv.innerHTML = alarmDiv;
}

// Function loading needed data for chart from php 'chartData'.
// Cropping the data to needed format, Initializing chart varibles and objects
// and pushing needed data to alarm div.
function change(week=false){
        var oReq = new XMLHttpRequest(); // New request object
        oReq.onload = function() {
            
        google.load(v, o, {packages:[c]});
        var UserDataArr = this.responseText;
        // console.log(UserDataArr);
        
        if(UserDataArr.includes(fe)){
            window.location.replace(ix);
        }
        UserDataArr = this.responseText.split(ap);
        dataCropToSettChng(UserDataArr);
        google.setOnLoadCallback(drawChart);

        function drawChart() {
            var options = {
                title: aq,
                curveType: f,
                legend: { position: btn }
            };
    
             var chart = new google.visualization.LineChart(document.getElementById(chartCM));
             chart.draw(dataToChartFormat(UserDataArr,week), options);
        }
        alarmsToDiv(UserDataArr);
        };
        oReq.open(g, phpChartDataPath, true);
        oReq.send();
}

// Function hiding filtering forms for day and month.
function closAll(){
    var toClose=document.getElementsByClassName(dayMonthCN);
    document.getElementById(wantedDateCN).value="";
    for(var i=0;i<toClose.length;i++){
        toClose[i].style.display=no;
    }
}

var myVar = setInterval(ChartRefresh, chartRefreshInterval);
function ChartRefresh(){

    var timeFilter = document.getElementById(chartfilterCN).value;
    var mainFilter = document.getElementById(chartCN).value;
    if(timeFilter!=w && timeFilter!=a){
        var dayMonthForm = document.getElementById(wantedDateCN).value;
    }
    openSelection(timeFilter);

    document.getElementById(chartfilterCN).value = timeFilter;
    document.getElementById(chartCN).value = mainFilter
    if(typeof dayMonthForm !== un){
        document.getElementById(wantedDateCN).value = dayMonthForm;
    }
}

// Revealing filter input form if needed 
// and filtering chart depends on user select
function openSelection(val){
    if(val==w){
        closAll();
        change(true);
    }
    else if(val==a){
        closAll();
        change();
    }
    else{
        dayMonth(val);
    }
}

// Function revealing day and month filtering form
function dayMonth(val){
    closAll();
    document.getElementById(val).style.display=b;
    document.getElementById(dayMonthFormCN).style.display=b;
}

// Function validating day and month filtering form 
// valid amount of seperating chars, for day 3, month 2
function lineSeperatorsAndAmountCheck(wantedDate,wantedSeperator){
    var counterFlag=wantedSeperator;
    for(i=0;i<wantedDate.length;i++){
        if(wantedDate[i]==dt){
            counterFlag--;
        }
    }
    if(counterFlag==0){
        return true
    }
    return false;
}

// Function validating day and month filtering form 
// validating all input are valid numbers
function dateNumbersValitation(wantedDate){
    for(i=0;i<wantedDate.length;i++){
        if(wantedDate[i]!=dt&&(wantedDate[i]<z||wantedDate[i]>nn)){
            return false;
        }
    }
    return true;
}

// Function controlling validation for day and month filtering form input,
// changing the chart data according if user input are valid.
// returning true or false depends on validation
function ValidationExecution(wantedDate,wantedSeperator){
    if(lineSeperatorsAndAmountCheck(wantedDate,wantedSeperator)){
        if(dateNumbersValitation(wantedDate)){
            change();
            return false;
        }
    }
    return true;
}

// Function chosing validation for day or month input filter
// throwing relevant alert message if input invalid
function dateFormatValidation(){
    var DayOrMotnh=document.getElementById(chartfilterCN).value;    
    var wantedDate = document.getElementById(wantedDateCN).value;
    var ValidFlag=true;
    var wantedSeperator=1;
    if(DayOrMotnh==d){
        wantedSeperator=2;
    }
    if(wantedDate.length>0){
        if(DayOrMotnh==d&&wantedDate.length==8){
            ValidFlag=ValidationExecution(wantedDate,wantedSeperator);
        }
        else if(DayOrMotnh==m&&wantedDate.length==5){
            ValidFlag=ValidationExecution(wantedDate,wantedSeperator);
        }
    }
    if(ValidFlag){
        alert(wdt);
    }
}

// Function swiching chart content according to user selection
// week,day,month, all.
function ContentSwich(){
    var DayOrMotnh=document.getElementById(chartfilterCN).value;
    if(DayOrMotnh==a){
        change();
    }else if(DayOrMotnh==w){
        change(true);
    }
    else{
        dateFormatValidation();
    }
}