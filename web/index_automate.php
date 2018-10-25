<!DOCTYPE html>

<html lang="en"> 
<head>
<title>Home Automation</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="tab.css" />

<div class="tabs">
    <ul class="tab-links">
        <li><a href="index.php">Camera</a></li>
        <li><a href="index_switch.php">Switch</a></li>
	<li class="active"><a href="index_automate.php">Switch Automation</a></li>
	<li><a href="index_rgb.php">RGB Light</a></li>
	<li><a href="index_rgb_auto.php">RGB Light Automation</a></li>
    </ul>
</div>
<style>

</style>
<script>


var arg="description,id,auto_en,auto_on,auto_off,auto_en2,auto_on2,auto_off2,auto_day,auto_day2";
var ARR_ON_old=new Array();
var ARR_OFF_old=new Array();
var ARR_ON2_old=new Array();
var ARR_OFF2_old=new Array();
var ARR_DAY_old=new Array();
var ARR_DAY2_old=new Array();


function IsValidTime(timeStr){

//ajaxDisplay.innerHTML = timeStr;

var timePat1 = /^(\d{1,2}):(\d{2}):(\d{2})?$/; 
var timePat2 = /^(\d{1,2}):(\d{2})?$/; 
var matchArray1 = timeStr.match(timePat1);


if( matchArray1==null){
		
	var matchArray2 = timeStr.match(timePat2);
	hour = matchArray2[1];
	minute = matchArray2[2] ;
}
else {
	hour = matchArray1[1];
	minute = matchArray1[2] ;
	second = matchArray1[3];
}


if (hour < 0  || hour > 23) {
	alert("Hour must be between 0 and 23.");
	return 0;
}

if (minute < 0 || minute > 59) {
	alert("Minute must be between 0 and 59.");
	return 0;
}

return 1;
}

function check_checkbox(id,ck){
	var ajaxDisplay = document.getElementById('ajaxDiv');
	var days_checked="";
	for(var k=0; k<7;k++) {
		//ajaxDisplay.innerHTML = "test";	
		var id_checkbox=id + "_"+ k +"_ck" +ck ;
		var day_ck=document.getElementById(id_checkbox).checked;
		switch(k) {
		    case 0:
			if(day_ck==true) {
			days_checked=days_checked.concat("Sun,");
			}
			break;
		    case 1:
			if(day_ck==true) {
			days_checked=days_checked.concat("Mon,");
			 }
			break;
		    case 2:
			if(day_ck==true) {
			days_checked=days_checked.concat("Tue,");
			 }
			break;
		    case 3:
			if(day_ck==true) {
			days_checked=days_checked.concat("Wed,");
			 }
			break;
		    case 4:
			if(day_ck==true) {
			days_checked=days_checked.concat("Thu,");
			 }
			break;
		    case 5:
			if(day_ck==true){
			days_checked=days_checked.concat("Fri,");
			 }
			break;
		    case 6:
			if(day_ck==true) {
			days_checked=days_checked.concat("Sat,");
			 }
			break;
		
		}
		
			
	}

	var days_checked=days_checked.slice(0, -1);	
	//ajaxDisplay.innerHTML = days_checked;	
	return days_checked;

}


function onclick_btn(_id) {

var ajax_update;
if(window.XMLHttpRequest) ajax_update= new XMLHttpRequest();
else  ajax_update= new ActiveXObject("Microsoft.XMLHTTP");

var ajax_fileupdate;
if(window.XMLHttpRequest) ajax_fileupdate= new XMLHttpRequest();
else  ajax_fileupdate= new ActiveXObject("Microsoft.XMLHTTP");

var ajaxDisplay = document.getElementById('ajaxDiv');
//ajaxDisplay.innerHTML = _id;

var val=_id;

val=val.slice(-1);
//ajaxDisplay.innerHTML = val;

var id= _id;
id=id.slice(0, -2);


var idTXon=id+"_tON1";
var idTXoff=id+"_tOF1";
var idTXon2=id+"_tON2";
var idTXoff2=id+"_tOF2";

var idDIVon2=id+"_dON2";
var idDIVoff2=id+"_dOF2";


var id_en=id+"_en";
var id_change= id +"_c";

var tONold= ARR_ON_old[id];;
var tOFFold=ARR_OFF_old[id];
var tON2old= ARR_ON2_old[id];;
var tOFF2old=ARR_OFF2_old[id];

var DAYold=ARR_DAY_old[id];
var DAY2old=ARR_DAY2_old[id];

var en= document.getElementById(id_en).textContent;
var btn=document.getElementById(_id);
var btnC=document.getElementById(id_change);
var divON2=document.getElementById(idDIVon2);
var divOFF2=document.getElementById(idDIVoff2);



switch(val){

case "d":
	ajax_update.open("GET","sql_auto_update.php?opt=4" + "&id=" + id,true);	
	ajax_update.send();
		
	divON2.style.display="none";			
	divOFF2.style.display="none";
//	document.getElementById(idTXon).value=null;
//	document.getElementById(idTXoff).value=null;
//	document.getElementById(idTXon2).value=null;
//	document.getElementById(idTXoff2).value=null;;
	btnC.value="+";
	for(k=0;k<7;k++) {
		var idDIVCK= id + "_" + k + "_dCk2";
		var idCK1=id +"_" + k + "_ck1";
		var idCK2=id +"_" + k + "_ck2";
		document.getElementById(idDIVCK).style.display="none";
//		document.getElementById(idCK1).checked=false;
//		document.getElementById(idCK2).checked=false;
	}			

	ajax_fileupdate.open("GET","update_file.php?opt=0" + "&tOnOLD=" + tONold +"&tOffOLD=" + tOFFold + "&tOn2OLD=" + tON2old +"&tOff2OLD=" + tOFF2old + "&DayOLD=" + DAYold + "&Day2OLD=" + DAY2old + "&id=" + id,true);	
	ajax_fileupdate.send();	
	
	break;

case "u": 
	var tON=document.getElementById(idTXon).value;
	var tOFF=document.getElementById(idTXoff).value;
	var tON2=document.getElementById(idTXon2).value;
	var tOFF2=document.getElementById(idTXoff2).value;
	
	var DAY2=check_checkbox(id,2);
	//ajaxDisplay.innerHTML = DAY2;

	if (btnC.value=="+") {
		var DAY=check_checkbox(id,1);
		if(DAY=="") alert("Please select day");
		else {
		if ( (IsValidTime(tON)==1) && (IsValidTime(tOFF) == 1) ){
			ajax_update.open("GET","sql_auto_update.php?opt=1" +"&tOn=" + tON +"&tOff=" + tOFF + "&Day=" + DAY + "&id=" + id,true);	
			ajax_update.send();
			ajax_fileupdate.open("GET","update_file.php?opt=1" + "&tOn="+ tON +"&tOff=" + tOFF + "&tOnOLD=" + tONold + "&tOffOLD=" + tOFFold + "&Day=" + DAY + "&DayOLD=" + DAYold + "&id=" + id,true);	
			ajax_fileupdate.send();
			ARR_ON_old[id]=tON;
			ARR_OFF_old[id]=tOFF;
			ARR_DAY_old[id]=DAY;
		}
		}
	}
	else if (btnC.value=="-"){
		var DAY=check_checkbox(id,1);
		var DAY2=check_checkbox(id,2);
		if(DAY=="" || DAY2 =="") alert("Please select day");
		else {
		if ( (IsValidTime(tON)==1) && (IsValidTime(tOFF) == 1) && (IsValidTime(tON2)==1) && (IsValidTime(tOFF2) == 1) ){
			ajax_update.open("GET","sql_auto_update.php?opt=2" +"&tOn=" + tON +"&tOff=" + tOFF + "&tOn2=" + tON2 +"&tOff2=" + tOFF2 + "&Day=" + DAY + "&Day2=" + DAY2 + "&id=" + id,true);	
			ajax_update.send();
			ajax_fileupdate.open("GET","update_file.php?opt=2" + "&tOn="+ tON +"&tOff=" + tOFF + "&tOnOLD=" + tONold +"&tOffOLD=" + tOFFold + "&tOn2=" + tON2 +"&tOff2=" + tOFF2 + "&tOn2OLD=" + tON2old +"&tOff2OLD=" + tOFF2old + "&Day=" + DAY + "&DayOLD=" + DAYold + "&Day2=" + DAY2 + "&Day2OLD=" + DAY2old + "&id=" + id,true);	
			ajax_fileupdate.send();
			ARR_ON_old[id]=tON;
			ARR_OFF_old[id]=tOFF;
			ARR_ON2_old[id]=tON2;
			ARR_OFF2_old[id]=tOFF2;
			ARR_DAY_old[id]=DAY;
			ARR_DAY2_old[id]=DAY2;
		}	
			
		}		
	}

	break;
	
case "c":
		
	if(btn.value=="+" && en=="ENABLED") {	
		btn.value="-";			
		divON2.style.display="inline";			
		divOFF2.style.display="inline";	
		for(k=0;k<7;k++) {
			var idDIV2CK= id + "_" + k + "_dCk2";
			document.getElementById(idDIV2CK).style.display="inline";
				
		}
	}
	else if (btn.value=="-") {		
		btn.value="+";			
		divON2.style.display="none";			
		divOFF2.style.display="none";
		for(k=0;k<7;k++) {
			var idDIV2CK= id + "_" + k + "_dCk2";
			document.getElementById(idDIV2CK).style.display="none";
				
		}	
		ajax_update.open("GET","sql_auto_update.php?opt=3" + "&id=" + id,true);	
		ajax_update.send();	
		ajax_fileupdate.open("GET","update_file.php?opt=3" + "&tOn2OLD="+ tON2old +"&tOff2OLD=" + tOFF2old + "&Day2OLD=" + DAY2old + "&id=" + id,true);	
		ajax_fileupdate.send();
	}
		
	break;
}


	ajax_update.onreadystatechange = function() {
	    if(ajax_update.readyState == 4 && ajax_update.status == 200){ 	

//	ajaxDisplay.innerHTML = ajax_update.responseText;
	}
	}

	ajax_fileupdate.onreadystatechange = function() {
	    if(ajax_fileupdate.readyState == 4 && ajax_fileupdate.status == 200){ 	

//	ajaxDisplay.innerHTML = ajax_fileupdate.responseText;
	}
	}

}

function element_button(id, value){
	var ajaxDisplay = document.getElementById('ajaxDiv');
	var element = document.createElement("input");
	element.setAttribute("type","button");
	element.setAttribute("value", value);
	element.setAttribute("id", id);	
	element.setAttribute("onclick", 'onclick_btn(id);');
	return element;
}


function element_text_input(d_id,t_id, value){
	var ajaxDisplay = document.getElementById('ajaxDiv');
	var div = document.createElement("div");
	div.setAttribute("id",d_id);

	var id=d_id;
	id=id.slice(0, -5);	

	var ARR=d_id;
	ARR=ARR.slice(-3);
	
	if(ARR=="ON1") ARR_ON_old[id]=value;
	else if ( ARR=="OF1") ARR_OFF_old[id]=value;
	else if (ARR=="ON2") ARR_ON2_old[id]=value;
	else if (ARR=="OF2") ARR_OFF2_old[id]=value;


	var element = document.createElement("input");
	element.setAttribute("type","text");
	element.setAttribute("value", value);
	element.setAttribute("id", t_id);
	div.appendChild(element);

	return div;

}

function element_checkbox(id,k,ck,day,en){

	var id_D= id + "_" + k + "_dCk" + ck;
	var div = document.createElement("div");
	div.setAttribute("id",id_D);
	
	var id_checkbox=id +"_" + k + "_ck"+ck ;

	var element = document.createElement("input");
	element.setAttribute("type","checkbox");
	element.setAttribute("id", id_checkbox);
	
	switch(k) {
	    case 0:
		var matches=day.match(/Sun/g);
		if(matches!=null) element.setAttribute("checked",true);
		break;
	    case 1:
		var matches=day.match(/Mon/g);
		if(matches!=null) element.setAttribute("checked",true);
		break;
	    case 2:
		var matches=day.match(/Tue/g);
		if(matches!=null) element.setAttribute("checked",true);
		break;	
	    case 3:
		var matches=day.match(/Wed/g);
		if(matches!=null) element.setAttribute("checked",true);
		break;		
	    case 4:
		var matches=day.match(/Thu/g);
		if(matches!=null) element.setAttribute("checked",true);
		break;	
	    case 5:
		var matches=day.match(/Fri/g);
		if(matches!=null) element.setAttribute("checked",true);
		break;	
	    case 6:
		var matches=day.match(/Sat/g);
		if(matches!=null) element.setAttribute("checked",true);
		break;		
	     default: break;
	}
	

	div.appendChild(element);
	return div;

}


function table(){

var display = document.getElementById('autoTab');
var ajaxDisplay = document.getElementById('ajaxDiv');

var ajax_btn;

if(window.XMLHttpRequest) ajax_btn = new XMLHttpRequest();
else  ajax_btn = new ActiveXObject("Microsoft.XMLHTTP");

var ajax_update;

if(window.XMLHttpRequest) ajax_update = new XMLHttpRequest();
else  ajax_update = new ActiveXObject("Microsoft.XMLHTTP");



//ajax_btn.open("GET","sql_switch_get_description.php?val=" + arg ,true);
ajax_btn.open("GET","status_switch.php?val=" + arg ,true);	
ajax_btn.send();

ajax_btn.onreadystatechange = function() {
    if(ajax_btn.readyState == 4 && ajax_btn.status == 200){ 
//	display.innerHTML=ajax_btn.responseText;
	var jsonStr = JSON.parse(ajax_btn.responseText);

	var elements=jsonStr[0];

	var table = document.createElement("TABLE");
	table.setAttribute("id","myTable");
    	table.border = "1";

	var x=["Area","ON","OFF","S","M","T","W","T","F","S","Automation","Action"];
	var header_tr= document.createElement('tr'); 

	for (var k=0; k<12; k++){
		var header_text=x[k];
		var header_td = document.createElement('td');
		header_td.appendChild(document.createTextNode(header_text));
		header_tr.appendChild(header_td);
	}

	table.appendChild(header_tr);


	for (var i=1; i< elements+1; i++) {
		var j=(i-1)*10+1;
	
		var nm=jsonStr[j];
		var id=jsonStr[j+1];
		var en=jsonStr[j+2];
		var on=jsonStr[j+3];
		var off=jsonStr[j+4];
		var en2=jsonStr[j+5];
		var on2=jsonStr[j+6];
		var off2=jsonStr[j+7];	
		var day=jsonStr[j+8];
		var day2=jsonStr[j+9];
	
//		ajaxDisplay.innerHTML=day2;	

		var idTXon= id +"_tON1";
		var idTXoff= id +"_tOF1";
		var idTXon2= id +"_tON2";
		var idTXoff2= id +"_tOF2";

		var idDIVon= id +"_dON1";
		var idDIVoff= id +"_dOF1";
		var idDIVon2= id +"_dON2";
		var idDIVoff2= id +"_dOF2";

		var id_en=id+"_en";

		var id_update= id +"_u";
		var id_disable= id +"_d";
		var id_change= id +"_c";

		var tr = document.createElement('tr'); 

		var td = document.createElement('td');
		td.appendChild(document.createTextNode(nm));
		tr.appendChild(td);

		var td = document.createElement('td');
		var div= element_text_input(idDIVon,idTXon,on);
		td.appendChild(div);
		
		var div2= element_text_input(idDIVon2,idTXon2,on2);
		td.appendChild(div2);

		tr.appendChild(td);

		var td = document.createElement('td');
		var div= element_text_input(idDIVoff,idTXoff,off);
		td.appendChild(div);

		var div3= element_text_input(idDIVoff2,idTXoff2,off2);
		td.appendChild(div3);
		
		if(en2!=1){
			div2.style.display="none";
			div3.style.display="none";
			
		}

		tr.appendChild(td);

		ARR_DAY_old[id]=day;
		ARR_DAY2_old[id]=day2;

		for(var k=0; k<7;k++) {
			var td = document.createElement('td');

			var div1= element_checkbox(id,k,1,day,en);
			var div2= element_checkbox(id,k,2,day2,en2);
			td.appendChild(div1);
			td.appendChild(div2);
			tr.appendChild(td);
//			if( en!=1){
//				var idCK1=id +"_" + k + "_ck1";
////				document.getElementById(idCK1).checked=false;
//			}
			if(en2!=1){
				div2.style.display="none";
//				var idCK2=id +"_" + k + "_ck2";
//				document.getElementById(idCK2).checked=false;
			}
		}	


		var td = document.createElement('td');	
		td.setAttribute("id",id_en);
		
		if(en==1) td.appendChild(document.createTextNode("ENABLED"));
		else td.appendChild(document.createTextNode("DISABLED"));

		tr.appendChild(td);
	
		var td = document.createElement('td');
		td.style.color="blue";

		var div1 = document.createElement("div");
		var div2 = document.createElement("div");


		var element = element_button(id_update,"Update");
		div1.appendChild(element);

		var element = element_button(id_disable,"Disable");	
		div1.appendChild(element);

		if(en2==1) 
			var element = element_button(id_change,"-");
		else
			var element = element_button(id_change,"+");	

		
		div2.appendChild(element);

		td.appendChild(div1);
	
		td.appendChild(div2);
		
		tr.appendChild(td);
			
		table.appendChild(tr);
		
	}
	
	

	display.appendChild(table);
}

}

}

function reload_page() {



if(window.XMLHttpRequest) ajax_btn = new XMLHttpRequest();
else  ajax_btn = new ActiveXObject("Microsoft.XMLHTTP");
var ajaxDisplay = document.getElementById('ajaxDiv');

  ajax_btn.open("GET","status_switch.php?val=" + arg ,true);	
  ajax_btn.send();

  ajax_btn.onreadystatechange = function() {
    if(ajax_btn.readyState == 4 && ajax_btn.status == 200){ 	

	//ajaxDisplay.innerHTML=ajax_btn.responseText;

    	var jsonStr = JSON.parse(ajax_btn.responseText);
	
	var elements=jsonStr[0];

	for (var i=1; i< elements+1; i++) {
	
		var j=(i-1)*10+1;
	
		var id=jsonStr[j+1];
		var en=jsonStr[j+2];
		var en2=jsonStr[j+5];


		var x=document.getElementById('myTable').rows[i];

		if( en == 1) {
			x.cells[10].innerHTML="ENABLED";
		}
		else {
			x.cells[10].innerHTML="DISABLED";
		}
		
	}

	reload_page();
  };
}

}

function init(){
table();
reload_page();
}

</script>

</head>


<body onload="setTimeout('init();', 100);">
<p>

<div id='ajaxDiv'></div>
<br>
<div id='autoTab'> </div>





</p>
</body>
</html>
