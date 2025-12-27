var rememberadds = new Array();

function SetCookie(cookieName,cookieValue,nDays) {
	var today = new Date();
	var expire = new Date();
	if (nDays==null || nDays==0) nDays=1;
	expire.setTime(today.getTime() + 3600000*24*nDays);
	document.cookie = cookieName+"="+escape(cookieValue)+";expires="+expire.toGMTString();
}

function getCookie(c_name)
{
	if (document.cookie.length>0)
	{
		c_start=document.cookie.indexOf(c_name + "=");
		if (c_start!=-1)
		{ 
			c_start=c_start + c_name.length+1; 
			c_end=document.cookie.indexOf(";",c_start);
			if (c_end==-1) c_end=document.cookie.length;
			return unescape(document.cookie.substring(c_start,c_end));
		} 
	}
	return "";
}

function configureDropdowns() {
	tester = items_comp_queue.split(',');
	if (tester[0] == '') items_comp_queue = items_comp_queue.substring(1,items_comp_queue.length);
	items = items_comp_queue.split(',');
	
	item_list = new Array();
	
	for(i=0; i<items.length; i++) {
		holder = items[i].split("|");
		item_list[i] = new Array();
		item_list[i]["id"] = holder[0];
		item_list[i]["name"] = holder[1];
	}
	
	
	sel = document.getElementById('sel_1');
	sel.removeAttribute('disabled');
    if (sel.hasChildNodes()) {
        while(sel.childNodes.length >= 1 ) {
            sel.removeChild(sel.firstChild);       
        } 
    }
	
	
	var newoption = document.createElement('option');
	newoption.value = 'not-used';
	newoption.innerHTML = '--NONE--';
	sel.appendChild(newoption);
	
	if (items_comp_queue != '') {
		for (i=0; i<item_list.length; i++) {
			var newoption = document.createElement('option');
			newoption.setAttribute('value',item_list[i]["id"]);
			if (i == 0) newoption.setAttribute('selected','selected');
			newoption.innerHTML = item_list[i]["name"];
			sel.appendChild(newoption);
		}
	}
	
	for (i=2; i<=5; i++) {
		sel = document.getElementById('sel_'+i);
		sel.removeAttribute('disabled');
		if (sel.hasChildNodes()) {
			while(sel.childNodes.length >= 1 ) {
				sel.removeChild(sel.firstChild);       
			} 
		}
	
		var newoption = document.createElement('option');
		newoption.setAttribute('value','not-used');
		if (i > item_list.length) {
			sel.setAttribute('disabled','disabled');
			newoption.setAttribute('selected','selected');
		}
		newoption.innerHTML = '--NONE--';
		sel.appendChild(newoption);
	
		for (c=0; c<item_list.length; c++) {
			var newoption = document.createElement('option');
			newoption.setAttribute('value',item_list[c]["id"]);
			if (c == i-1 && i <= item_list.length) newoption.setAttribute('selected','selected');
			newoption.innerHTML = item_list[c]["name"];
			sel.appendChild(newoption);
		}
	}	
}
	
function queuedelete(id,search)
{
	//HIDES THE ROW IN THE QUEUE TABLE
	document.getElementById('queue'+id).className = 'noshow';
	
	if (document.getElementById('img'+id)) { //IF THE ITEM IS IN THE VISUAL SEARCH AREA, IT CHANGES THE DELETE SIGN TO AN ADD ONE
		document.getElementById('img'+id).src='/images/addtoqueue.gif';
		document.getElementById('img'+id).title='Add to comparison queue.';
		document.getElementById('img'+id).alt='Add to comparison queue.';
		document.getElementById('link'+id).onclick = function() { queueadd(rememberadds[id][0],rememberadds[id][1],rememberadds[id][2],rememberadds[id][3],rememberadds[id][4],rememberadds[id][5]); };
		//document.getElementById('link'+id).attributes["onclick"].value = "javascript:queueadd("+id+");";
	}
	
	//STRIPS FROM THE QUEUE
    queue = getCookie("item_comp_queue");
	if (queue.substring(queue.length-1,queue.length) != '|') queue+='|';
	strtoreplace = "|"+id+"|";
	queue = queue.replace(strtoreplace, "|");
	
	//RETURNS QUEUE TO #,#,#,# FORMAT
	if (queue.substring(0,1) == '|' && queue.substring(queue.length-1,queue.length) != '|') queue = queue.substring(1,queue.length);
	if (queue.substring(0,1) != '|' && queue.substring(queue.length-1,queue.length) == '|') queue = queue.substring(0,queue.length-1);
	if (queue.substring(0,1) == '|' && queue.substring(queue.length-1,queue.length) == '|') queue = queue.substring(0,queue.length-1);
	SetCookie("item_comp_queue",queue,365);
	
	//IF THE QUEUE IS EMPTY, THE "NO ITEMS" ROW SHOWS
	if (queue == 0 || queue == "" || queue === false) document.getElementById("noqueue").className = "tableshow";
	
	list = items_comp_queue.split(',');
	items_comp_queue = ','+items_comp_queue;
	for (i=0; i<list.length; i++) {
		splitter = list[i].split('|');
		if (splitter[0] == id) items_comp_queue = items_comp_queue.replace(','+splitter[0]+'|'+splitter[1],'');
	}
	configureDropdowns();
}

function queueadd(id,image,name,member,trade,quest)
{
	if (typeof image == 'undefined') {
		image = rememberadds[id][1];
		name = rememberadds[id][2];
		member = rememberadds[id][3];
		trade = rememberadds[id][4];
		quest = rememberadds[id][5];
	}
	//alert(id+'\n'+image+'\n'+name+'\n'+member+'\n'+trade+'\n'+quest);
	document.getElementById("noqueue").className = "noshow";
    SetCookie("item_comp_queue",getCookie("item_comp_queue")+"|"+id,365);
	
	if (document.getElementById('img'+id)) { //SEES IF THE NEWLY ADDED ITEM IS ON THE SEARCH LIST
		
		//WE STORE THE PARAMETERS TO ADD THE ITEM TO THE QUEUE SO THAT IF IT'S DELETED, WE CAN ADD IT AGAIN
		rememberadds[id] = new Array(id,image,name,member,trade,quest);
		
		document.getElementById('img'+id).src      = '/images/deletefromqueue.gif';
		document.getElementById('img'+id).title    = 'Remove from queue';
		document.getElementById('img'+id).alt      = 'Remove from queue';
		document.getElementById('link'+id).onclick = function () { queuedelete(id); };
	}
	
	if (document.getElementById('queue'+id)) { //IF THE ITEM WAS ON THE QUEUE BEFORE, WE DON'T WANT TO CREATE IT AGAIN, SO WE JUST MAKE IT VISIBLE AGAIN
		document.getElementById('queue'+id).className = "tableshow";
	} 
	else { //IF THE WASN'T ON THE QUEUE, WE HAVE TO CREATE THE ROW
		
		//ADDS NEW ROW TO QUEUE TABLE
		var table = document.getElementById('list_queue');
		var rowIdName = 'queue'+id;
		var newrow = document.createElement('tr');
		//newrow.setAttribute('id',rowIdName);
		newrow.id = rowIdName;
		table.appendChild(newrow);
	
		//ADDS IMAGE CELL
		var row = document.getElementById(rowIdName);
		var newcell =document.createElement('td');
		newcell.className = 'tablebottom';
		newcell.innerHTML = '<img src="/img/idbimg/'+image+'" alt="OSRS RuneScape Help\'s picture of '+name+'" />';
		row.appendChild(newcell);
	
		//ADDS NAME CELL
		var newcell =document.createElement('td');
		newcell.className = 'tablebottom';
		newcell.innerHTML = '<a href="/items.php?id='+id+'" title="OSRS RuneScape Help\'s '+name+' Item Database Entry">'+name+'</a>';
		row.appendChild(newcell);
		
		//ADDS MEMBER CELL
		var newcell =document.createElement('td');
		newcell.className = 'tablebottom';
		newcell.innerHTML = member;
		row.appendChild(newcell);
		
		//ADDS TRADE CELL
		var newcell =document.createElement('td');
		newcell.className = 'tablebottom';
		newcell.innerHTML = trade;
		row.appendChild(newcell);
		
		//ADDS QUEST CELL
		var newcell =document.createElement('td');
		newcell.className = 'tablebottom';
		newcell.innerHTML = quest;
		row.appendChild(newcell);
		
		//ADDS REMOVE CELL
		var newcell =document.createElement('td');
		newcell.className = 'tablebottom';
		newcell.innerHTML = '<a onclick="queuedelete('+id+');"><img src="/images/deletefromqueue.gif" alt="Remove from queue" title="Remove from queue" /></a>';
		row.appendChild(newcell);
	}
	
	items_comp_queue += ','+id+'|'+name;
	configureDropdowns();
}

function queuewipe()
{
	//DISPLAYS "NO ITEMS" ROW
	document.getElementById("noqueue").className = "tableshow";
	
	//SETS THE  Xs IN THE SEARCH BACK TO CHECKS FOR THE ITEMS THAT WERE ON THE QUEUE AND HIDES QUEUE ROWS
	cookie1 = getCookie('item_comp_queue');
	cookie = cookie1.split('|');
	i = 0;
	for (len=cookie.length; i<len; i++) {
		id = cookie[i];
		if (document.getElementById('img'+id)) {
			document.getElementById('img'+id).src = '/images/addtoqueue.gif';
			document.getElementById('img'+id).title = 'Add to comparison queue.';
			document.getElementById('img'+id).alt = 'Add to comparison queue.';
			//document.getElementById('link'+id).attributes["onclick"].value = "javascript:queueadd("+id+");";
			document.getElementById('link'+this.id).onclick = function() { queueadd(this.id); };
		}
		if (document.getElementById('queue'+id)) document.getElementById('queue'+id).className = 'noshow';
	}
	
	
	//CLEARS QUEUE COOKIE
	SetCookie("item_comp_queue",0,365);
	
	//DELETES ALL ROWS EXCEPT THE FIRST AND LAST (TITLE + "NO ITEMS")
	/*var table = document.getElementById("list_queue");
	for(var i = table.rows.length - 1; i > 1; i--) {
		table.deleteRow(i);
	}*/
	
	items_comp_queue = '';
	configureDropdowns();
}

function hide(i) //FOR TAB SELECTION
{
	var el = document.getElementById(i);
	
	var elother = new Array('',document.getElementById("1"),document.getElementById("2"),document.getElementById("3"),document.getElementById("4"));
	if (el.className == "noshow")
	{
		el.className = "divshow";
		for (c=1; c<=4; c++) 
		{
			if (elother[c] != el)
			{
				elother[c].className = "noshow";
			}
		}
	}
	else
	{
		el.className = "noshow";
		elother[1].className = "divshow";
	}
}