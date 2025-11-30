$(document).ready(function() {
 //activeMainMenu();
});



/*************************
PopUp
**************************/
function PopUpWindow(URL, N, W, H, S) { // name, width, height, scrollbars
	var winleft	=	(screen.width - W) / 2;
	var winup	=	(screen.height - H) / 2;
	winProp		=	'width='+W+',height='+H+',left='+winleft+',top='+winup+',scrollbars='+S+',resizable' + ',status=yes'
	Win			=	window.open(URL, N, winProp)
	if (parseInt(navigator.appVersion) >= 4) { Win.window.focus(); }
}


function Box1(strUrl) {
	PopUpWindow(strUrl,'SHConfirmBox',500,150,'no');
}

/*************************
Set  Input
**************************/
function setFormValue(objName,strValue){
	var arrObj = document.getElementsByName(objName);
	for(i=0;i<arrObj.length;i++){
		arrObjCheck = arrObj[i];
		if(arrObjCheck.type == "text" || arrObjCheck.type == "textarea" || arrObjCheck.type == "hidden") arrObjCheck.value = strValue;
		if(arrObjCheck.type == "select-one") for(j=0;j<arrObjCheck.length;j++) if(arrObjCheck.options[j].value == strValue) arrObjCheck.options[j].selected = true;
		if(arrObjCheck.type == "select-multiple") for(j=0;j<arrObjCheck.length;j++) if(strValue.indexOf("|"+arrObjCheck.options[j].value+"|")  > -1) arrObjCheck.options[j].selected = true;
		if(arrObjCheck.type == "radio") if(arrObjCheck.value == strValue) arrObjCheck.checked = true;
		if(arrObjCheck.type == "checkbox") if(arrObjCheck.value == strValue) arrObjCheck.checked = true;
	}
}

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}




function addCommaCore(nStr){
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}
function addComma(obj){
	num = obj.value.replace(/\,/g, "");
	name = obj.name;
	if(num){num = addCommaCore(num);}
	$('#'+name).val(num);
}
