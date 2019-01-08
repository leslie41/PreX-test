function table1_1(){
	document.getElementById("table1").style.visibility="visible";
	document.getElementById("table2").style.visibility="hidden";
	document.getElementById("table3").style.visibility="hidden";
	document.getElementById("table4").style.visibility="hidden";	
}

function table1_2(){
	document.getElementById("table1").style.visibility="hidden";
	document.getElementById("table2").style.visibility="visible";
	document.getElementById("table3").style.visibility="hidden";
	document.getElementById("table4").style.visibility="hidden";	
}

function table2_1(){
	document.getElementById("table1").style.visibility="hidden";
	document.getElementById("table2").style.visibility="hidden";
	document.getElementById("table3").style.visibility="visible";
	document.getElementById("table4").style.visibility="hidden";	
}

function table2_2(){
	document.getElementById("table1").style.visibility="hidden";
	document.getElementById("table2").style.visibility="hidden";
	document.getElementById("table3").style.visibility="hidden";
	document.getElementById("table4").style.visibility="visible";	
}

function form1(){
  document.getElementById("form1").style.visibility="hidden"; 
  document.getElementById("form2").style.visibility="visible"; 
}

function form2(){
  document.getElementById("form1").style.visibility="visible"; 
  document.getElementById("form2").style.visibility="hidden"; 
}

function SetTableColor() {
  var tbl = document.getElementById("tbTopic");
  var trs = tbl.getElementsByTagName("tr");
  for (var i = 0; i < trs.length; i++) {
 var j = i + 1;
 if (j % 2 == 0) { //偶数行
   trs[i].style.background = "#444444";
 }
 else {
   trs[i].style.background = "#666666";
 }
  }

  var tbl1 = document.getElementById("table1");
  var trs1 = tbl1.getElementsByTagName("tr");
  for (var i = 0; i < trs1.length; i++) {
 var j = i + 1;
 if (j % 2 == 0) { //偶数行
   trs1[i].style.background = "#444444";
 }
 else {
   trs1[i].style.background = "#666666";
 }
  }

  var tbl2 = document.getElementById("table2");
  var trs2 = tbl2.getElementsByTagName("tr");
  for (var i = 0; i < trs2.length; i++) {
 var j = i + 1;
 if (j % 2 == 0) { //偶数行
   trs2[i].style.background = "#444444";
 }
 else {
   trs2[i].style.background = "#666666";
 }
  }

  var tbl3 = document.getElementById("table3");
  var trs3 = tbl3.getElementsByTagName("tr");
  for (var i = 0; i < trs3.length; i++) {
 var j = i + 1;
 if (j % 2 == 0) { //偶数行
   trs3[i].style.background = "#444444";
 }
 else {
   trs3[i].style.background = "#666666";
 }
  }

  var tbl4 = document.getElementById("table4");
  var trs4 = tbl4.getElementsByTagName("tr");
  for (var i = 0; i < trs4.length; i++) {
 var j = i + 1;
 if (j % 2 == 0) { //偶数行
   trs4[i].style.background = "#444444";
 }
 else {
   trs4[i].style.background = "#666666";
 }
  }
}

