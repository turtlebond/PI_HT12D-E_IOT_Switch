<!DOCTYPE html>

<html lang="en"> 
<head>
<title>Home Automation</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="tab.css" />
<link rel="stylesheet" href="switch.css" />
<!--link rel="stylesheet" href="switch2.css" /-->


<div class="tabs">
    <ul class="tab-links">
        <li><a href="index.php">Camera</a></li>
        <li class="active"><a href="index_switch.php">Switch</a></li>
	<li><a href="index_automate.php">Switch Automation</a></li>
	<li><a href="index_rgb.php">RGB Light</a></li>
	<li><a href="index_rgb_auto.php">RGB Light Automation</a></li>
    </ul>
</div>

<style>
.relative {
    position: relative;
    left: 50px;
    top: 30px;
    border: 3px solid #73AD21;
    font-size:12pt;
}
</style>

<script type="text/javascript">

var id_off = [0,1,2,3];
var id_on = [4,5];
var i_on=0;
var i_off=0;
var arg="id,value,description,enable";

function myLoop(arr,num,value)
{

var ajax_update1;
var val=value;

if(window.XMLHttpRequest) ajax_update1= new XMLHttpRequest();
else  ajax_update1= new ActiveXObject("Microsoft.XMLHTTP");

 setTimeout(function () {    
     ajax_update1.open("GET","status_switch_update.php?val=" +val +"&id=" + arr[num] , false);
     ajax_update1.send();
      if (num < arr.length){           
        num++;
         myLoop(arr,num,val);             
      }
   }, 1000)

return 0;
}


function good_night(){

var ajaxDisplay = document.getElementById('ajaxDiv');

//myLoop(id_off,0,0).then(myLoop(id_on,0,1));
myLoop(id_off,0,0).then(setTimeout(myLoop(id_on,0,1),5000));

setTimeout(reload_page,1000);
}


function good_night_off(){

var ajaxDisplay = document.getElementById('ajaxDiv');
var ajax_update2;

if(window.XMLHttpRequest) ajax_update2= new XMLHttpRequest();
else  ajax_update2= new ActiveXObject("Microsoft.XMLHTTP");

setTimeout(function () {    
      if (i_off < id_off.length){           
        ajax_update2.open("GET","status_switch_update.php?val=0"+"&id=" + id_off[i_off] , true);
        ajax_update2.send();
        i_off++;
         good_night_off(); 
      }
   }, 1000)



setTimeout(reload_page,1000);
}


function good_night_on(){

var ajaxDisplay = document.getElementById('ajaxDiv');
var ajax_update3;

if(window.XMLHttpRequest) ajax_update3= new XMLHttpRequest();
else  ajax_update3= new ActiveXObject("Microsoft.XMLHTTP");


setTimeout(function () {    
      ajax_update3.open("GET","status_switch_update.php?val=1" +"&id=" + id_on[i_on] , true);
      ajax_update3.send();
      if (i_on < id_on.length){           
        i_on++;
         good_night_on(); 
      }
   }, 1000)


setTimeout(reload_page,1000);
}

function onclick_btn(id) {

var ajax_update;
if(window.XMLHttpRequest) ajax_update= new XMLHttpRequest();
else  ajax_update= new ActiveXObject("Microsoft.XMLHTTP");

var ajaxDisplay = document.getElementById('ajaxDiv');
//ajaxDisplay.innerHTML = id;
var elem = document.getElementById(id);

	if (elem.checked == true) {
		ajax_update.open("GET","status_switch_update.php?val=1"+"&id=" + id , true);	
  		ajax_update.send();
	}

 	else if ( elem.checked == false) {
		ajax_update.open("GET","status_switch_update.php?val=0"+"&id=" + id , true);	
  		ajax_update.send();
	}


	ajax_update.onreadystatechange = function() {
	    if(ajax_update.readyState == 4 && ajax_update.status == 200){ 	

//		ajaxDisplay.innerHTML = ajax_update.responseText;
	}
	}

}


function create_button(table){

var ajaxDisplay = document.getElementById('ajaxDiv');

var ajax_btn;


if(window.XMLHttpRequest) ajax_btn = new XMLHttpRequest();
else  ajax_btn = new ActiveXObject("Microsoft.XMLHTTP");

  ajax_btn.open("GET","status_switch.php?val=" + arg ,true);
  ajax_btn.send();

 ajax_btn.onreadystatechange = function() {
    if(ajax_btn.readyState == 4 && ajax_btn.status == 200){ 

//	ajaxDisplay.innerHTML=ajax_btn.responseText;
	var jsonStr = JSON.parse(ajax_btn.responseText);

	var elements=jsonStr[0];

	var table = document.createElement("TABLE");
	table.setAttribute("id","myTable");
    	table.border = "1";
	
	var x=["Area","Status","Action"];
	var header_tr= document.createElement('tr'); 

	for (var k=0; k<3; k++){
		var header_text=x[k];
		var header_td = document.createElement('td');
		header_td.appendChild(document.createTextNode(header_text));
		header_tr.appendChild(header_td);
	}

	table.appendChild(header_tr);

	for (var i=1; i< elements+1; i++) {
		var j=(i-1)*4+1;
	
		var id=jsonStr[j];
		var enable=jsonStr[j+3];
		var value=jsonStr[j+1];
		var title=jsonStr[j+2];

  
		var itemLabel = document.createElement("Label");
              itemLabel.setAttribute("class","switch");



		var element = document.createElement("input");
		element.setAttribute("type","checkbox");
		element.setAttribute("id", id);	
		element.setAttribute("onclick", 'onclick_btn(id);');

		var div = document.createElement("div");
		div.setAttribute("class","slider");
	
		if(enable == 0) {
			element.setAttribute("disabled", true);
//			element.setAttribute("hidden", true);
//			continue;
		}
	
		itemLabel.appendChild(element);
		itemLabel.appendChild(div);

		var tr = document.createElement('tr'); 
		
		for (var k=0; k<3; k++){
		   var td = document.createElement('td');
		   td.height='40';
		
			if(k==0) {
			td.width='290';
			var text= document.createTextNode(title);
		   	td.appendChild(text);
			}

			if(k==1) {
				td.width='100';
				if (enable==0) td.appendChild(document.createTextNode("Disabled"));
				else  {
					if (value == 1){
						element.checked= true;
						td.appendChild(document.createTextNode("ON"));
					}
					else {
                                                element.checked= false;
                                                td.appendChild(document.createTextNode("OFF"));
					}
				}
			}
			

			if (k==2) {
				td.width='100';
				td.appendChild(itemLabel);
			}
			tr.appendChild(td);
	       	} 

		table.appendChild(tr);
			
	}
	ajaxDisplay.appendChild(table);
}

}


}
function reload_page() {

var ajaxDisplay = document.getElementById('ajaxDiv');

var ajax_btn;

if(window.XMLHttpRequest) ajax_btn = new XMLHttpRequest();
else  ajax_btn = new ActiveXObject("Microsoft.XMLHTTP");



  ajax_btn.open("GET","status_switch.php?val=" + arg ,true);	
  ajax_btn.send();

  ajax_btn.onreadystatechange = function() {
    if(ajax_btn.readyState == 4 && ajax_btn.status == 200){ 	

	//ajaxDisplay.innerHTML=ajax_btn.responseText;

    	var jsonStr = JSON.parse(ajax_btn.responseText);

	var elements=jsonStr[0];



	for (var i=1; i< elements+1; i++) {
		var j=(i-1)*4+1;

		
		var id=jsonStr[j];
		var value=jsonStr[j+1];
		var enable=jsonStr[j+3];

		var x=document.getElementById('myTable').rows[i];

		if( enable == 1 ){
			if( value == 1) {
				x.cells[1].innerHTML="ON";
				document.getElementById(id).checked= true;
			}
			else {
				x.cells[1].innerHTML="OFF";
				document.getElementById(id).checked=false;
			}
		}
		else {
			x.cells[1].innerHTML="DISABLED";
			}
	

	}

	reload_page();
  };
}

}

function init(){

create_button();
reload_page();
}


</script>

</head>
<body onload="setTimeout('init();', 100);">


<p>

<div id='ajaxDiv'> </div>

<div id='profileButton'  > 
<input class="relative" style="display: none;" id="gdnt" type="button" onclick="good_night()" value="Good Night">
<input class="relative" style="display: none;" id="gdnt_off" type="button" onclick="good_night_off()" value="Good Night-OFF">
<input class="relative" style="display: none;" id="gdnt_on" type="button" onclick="good_night_on()" value="Good Night-ON">
</div>



</p>
</body>
</html>


