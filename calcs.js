/*
 *	Javascripted Runescape Calculator
 *	Created by Ryan Hoerr, December 2008
 *	(c) 2008 Zybez Corporation
 */
 
function reCalculate() {
	var XPs		= getElementsById('xp');
	var NUMs	= getElementsById('num');
	var LVLs	= getElementsById('level');
	var IMGs	= getElementsById('image');
	var status	= document.getElementById('status_inner');
	var current	= document.getElementById('currentxp').value-0;
	var goal	= document.getElementById('goalxp').value-0;
	
	if(rev_Mode == 0) {
		if(goal <= current) {
			setTimeout('checkGoal('+goal.toString().length+')', 2300);
			run_check = 1;
		}
		else if(goal > 200000000) {
			goal = findXp(99);
			document.getElementById('goalxp').value = goal;
			document.getElementById('goallvl').value = 99;
		}
		
		var needed	= goal - current;
		
		if(needed > 0) {
			status.innerHTML = 'Calculating...';
			
			for(var i=0;i<XPs.length;i++) {
				if(LVLs[i].innerHTML <= findLevel(current))
					IMGs[i].src = '/img/calcimg/a_green.PNG';
				else if(LVLs[i].innerHTML <= findLevel(goal))
					IMGs[i].src = '/img/calcimg/a_yellow.PNG';
				else
					IMGs[i].src = '/img/calcimg/a_red.PNG';
				NUMs[i].innerHTML = numberFormat(Math.ceil(needed / XPs[i].innerHTML));
			}
			
			var pct = round((1 - (needed/(goal - startXp(current)))) * 100, 2);
			
			status.innerHTML = 'You need <b>'+numberFormat(needed)+' XP</b> to reach your target. You&nbsp;are&nbsp;<b>'+pct+'%</b>&nbsp;of&nbsp;the&nbsp;way&nbsp;there.';
			status.innerHTML +='<div id="progress_bar"><table cellspacing="0" style="width: 100%"><tr><td style="background-color: #191; width: '+pct+'%"></td><td style="background-color: #911; width: '+(100-pct)+'%"></td></tr></table></div>';
		}
	}
	else { // Calculate backwards
		var acts = document.getElementById('numacts').value-0;
		for(var i=0;i<XPs.length;i++) {
			if((LVLs[i].innerHTML-0) <= findLevel(current))
				IMGs[i].src = '/img/calcimg/a_green.PNG';
			else
				IMGs[i].src = '/img/calcimg/a_red.PNG';
			
			// We're increasing the accuracy here... yeah, that's it.
			var cxp = current + (acts * (XPs[i].innerHTML-0));
			var last = findLevel(cxp);
			var lxp = findXp(last);
			last += round((cxp - lxp)/(findXp(last + 1) - lxp), 1);
			
			NUMs[i].innerHTML = 'Level '+last;
		}
	}
}

function sync(Col, Row, Val) {
	if(Row == 'xp')
		document.getElementById(Col+Row).value = findXp(Val);
	else
		document.getElementById(Col+Row).value = findLevel(Val);
}

function startXp(current) {
	if(document.getElementById('goalst').checked == true)
		return findXp(findLevel(current));
	else
		return document.getElementById('startxp').value-0;
}

var run_check = 0;
function checkGoal(len) {
	var current	= document.getElementById('currentxp').value;
	var goal	= document.getElementById('goalxp').value;
		
	if(run_check == 1 && (goal-0) <= (current-0) && goal.length >= len) {
		goal = findXp(findLevel(current) + 1);
		document.getElementById('goalxp').value = goal;
		document.getElementById('goallvl').value = findLevel(goal);
		run_check = 0;
		reCalculate();
	}
	else run_check = 0;
}

function filter(type) {
	var rows = getElementsById('tr');
	var memb = document.getElementById('memb') ? document.getElementById('memb').checked : false;
	for(var i=0;i<rows.length;i++) {
		if(type == '*' && memb == false) {
			rows[i].style.display = '';
		}
		else if(type == '*' && memb == true) {
			rows[i].style.display = rows[i].className.indexOf('memb') != -1 ? 'none' : '';
		}
		else {
			if(rows[i].className.indexOf(type) == -1 || (memb && rows[i].className.indexOf('memb') != -1))
				rows[i].style.display = 'none';
			else
				rows[i].style.display = '';
		}
	}
}

function hideMember(dot) {
	if(document.getElementById('filterBy')) {
		filter(document.getElementById('filterBy').value);
	}
	else {
		var membs	= getElementsById('tr');
		var disp	= dot == true ? 'none' : '';
		for(var i=0;i<membs.length;i++) {
			if(membs[i].className.indexOf('memb') != -1)
				membs[i].style.display = disp;
		}
	}
	document.cookie = "calc_hidemembers="+dot;
}

var prevBonus = '*=1';
function addRadioBonus(multiple) {
	var XPs = getElementsById('xp');
	var multiples = makeArray(multiple);
	var prevBoni = makeArray(prevBonus);
	for(var i=0;i<XPs.length;i++) {
		var indx = document.getElementById('tr'+i).className.indexOf(' ');
		if(indx != -1)
			var type = document.getElementById('tr'+i).className.slice(0, indx);
		else
			var type = document.getElementById('tr'+i).className;
		var prev = prevBoni['*'] ? prevBoni['*'] : prevBoni[type];
		var next = multiples['*'] ? multiples['*'] : multiples[type];
		XPs[i].innerHTML = round((XPs[i].innerHTML / prev) * next, 3);
	}
	prevBonus = multiple;
	reCalculate();
}

function addCheckBonus(multiple, checked) {
	var XPs = getElementsById('xp');
	var multiples = makeArray(multiple);
	for(var i=0;i<XPs.length;i++) {
		var indx = document.getElementById('tr'+i).className.indexOf(' ');
		if(indx != -1)
			var type = document.getElementById('tr'+i).className.slice(0, indx);
		else
			var type = document.getElementById('tr'+i).className;
		var mult = multiples['*'] ? multiples['*'] : multiples[type];
		
		XPs[i].innerHTML = checked == true ? round(XPs[i].innerHTML * mult, 3) : round(XPs[i].innerHTML / mult, 3);
	}
	reCalculate();
}

var rev_Mode = 0;
function reverseMode(dot) {
	var goal	= document.getElementById('goalxp');
	var goallv	= document.getElementById('goallvl');
	
	if(dot == true) {
		document.getElementById('last_th').innerHTML = 'Achieved';
		document.getElementById('status_inner').innerHTML = 'Enter the number of actions to perform: <input type="text" size="8" id="numacts" onkeyup="reCalculate()" value="1" />';
		document.getElementById('target_t').style.display = 'none';
		document.getElementById('target_f').style.display = 'none';
		document.getElementById('start_t').style.display = 'none';
		document.getElementById('start_f').style.display = 'none';
	}
	else {
		document.getElementById('last_th').innerHTML = 'Number';
		goal.value = findXp(findLevel(document.getElementById('currentxp').value) + 1);
		goallv.value = findLevel(goal.value);
		document.getElementById('target_t').style.display = '';
		document.getElementById('target_f').style.display = '';
		if(document.getElementById('goalst').checked == false) {
			document.getElementById('start_t').style.display = '';
			document.getElementById('start_f').style.display = '';
		}
	}

	rev_Mode = dot == true ? 1 : 0;
	document.cookie	= "calc_reversemode="+dot;
	reCalculate();
}

function goalStart(dot) {
	if(dot == true) {
		document.getElementById('start_t').style.display = 'none';
		document.getElementById('start_f').style.display = 'none';
	}
	else if(document.getElementById('reverse').checked == false) {
		document.getElementById('start_t').style.display = '';
		document.getElementById('start_f').style.display = '';
	}
	
	document.cookie = 'calc_goalstart='+dot;
	reCalculate();
}

function changeUser() {
	var usr = prompt("Please enter a character to grab levels from:", '');
	if(usr) {
		if(window.location.href.indexOf('?') == -1)
			window.location.href += '?user='+usr;
		else
			window.location.href += '&user='+usr;
	}
}

function findXp(level) {
	level--;
	var xp = 0;
	var num = 1;
	while(level > 0) {
		var a = num / 7;
		xp = xp + Math.floor(num + 300 * Math.pow(2, a));
		num++;
		level--;
	}
	xp = Math.floor(xp / 4);
	return xp;
}

function findLevel(xp) {
	if(xp >= 200000000)
		var level = 126;
	else {
		var level = 0;
		var points = 0;
		var check = 0;
		var num = 1;
		while(check <= xp) {
			var a = num / 7;
			points = points + Math.floor(num + 300 * Math.pow(2, a));
			check = Math.floor(points / 4);
			num++;
			level++;
		}
	}
	return level;
}

function numberFormat(nStr) {
	if(nStr > 999999) {
		nStr += '';
		nStr = nStr.slice(0, -6)+','+nStr.slice(-6, -3)+','+nStr.slice(-3);
	}
	else if(nStr > 999) {
		nStr += '';
		nStr = nStr.slice(0, -3)+','+nStr.slice(-3);
	}
	return nStr;
}

function round(num, mult) {
	mult = Math.pow(10, mult);
	return Math.round(num * mult) / mult;
}

function makeArray(str) {
	var array = str.split(',');
	var array2 = Array();
	for(var i=0;i<array.length;i++) {
		array[i] = array[i].split('=');
		array2[array[i][0]] = array[i][1]-0;
	}
	return array2;
}

function crement(e, value) {
	if(!e)
		var e = event;
	var key = e.which ? e.which : e.keyCode;

	if(key == 38 || key == 39) {
		if(parseInt(value) < 99)
			value++;
	}
	else if(key == 40 || key == 37) {
		if(parseInt(value) > 1)
			value--;
	}
	return value;
}

//----------------------------------
// Table sorting
// Original code by Eric Pascarello
//----------------------------------

function sortableTable(tableIDx,intDef,sortProps){
  var tableID = tableIDx;
  var intCol = 0;
  var intDir = 1;
  var strMethod;
  var arrHead = null;
  var arrMethods = sortProps.split(",");

  this.init = function(){
    arrHead = document.getElementById(tableID).getElementsByTagName('thead')[0].getElementsByTagName('th');
    for(var i=0;i<arrHead.length;i++){
	  arrHead[i].onclick = new Function(tableIDx + ".sortTable(" + i + ",'" + arrMethods[i] + "');");
    }
    this.sortTable(intDef,arrMethods[intDef]);
  }

  this.sortTable = function(intColx,strMethodx){ 

    intCol = intColx;
	strMethod = strMethodx;

	var arrRows = document.getElementById(tableID).getElementsByTagName('tbody')[0].getElementsByTagName('tr');

    intDir = (arrHead[intCol].className=="tabletop asc")?-1:1;
    arrHead[intCol].className = (arrHead[intCol].className=="tabletop asc")?"tabletop des":"tabletop asc";
	for(var i=0;i<arrHead.length;i++){
      if(i!=intCol){arrHead[i].className="tabletop";}
	}
	  
	var arrRowsSort = new Array(); 
	for(var i=0;i<arrRows.length;i++){ 
      arrRowsSort[i]=arrRows[i].cloneNode(true); 
    }
    arrRowsSort.sort(sort2dFnc);
	      
	for(var i=0;i<arrRows.length;i++){   
	  arrRows[i].parentNode.replaceChild(arrRowsSort[i],arrRows[i]);
	} 

  } 

  function sort2dFnc(a,b){
    var col = intCol;
    var dir = intDir;
    var aCell = a.getElementsByTagName("td")[col].innerHTML;
    var bCell = b.getElementsByTagName("td")[col].innerHTML;
	   
    switch (strMethod){
    case "int":
      aCell = parseInt(aCell);
      bCell = parseInt(bCell);			 
	  break;
	case "float":
      aCell = parseFloat(aCell.replace(',', "").replace(',', "").replace("Level ", ""));
      bCell = parseFloat(bCell.replace(',', "").replace(',', "").replace("Level ", ""));
	  break;
	}
    return (aCell>bCell)?dir:(aCell<bCell)?-dir:0;
  }
}