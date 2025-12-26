//---------------------------------------------------
// D2-Shoutbox Javascript Library Function File
// File: dgsbjs.js
//---------------------------------------------------
// © 2004 - Dean (deaner225@gmail.com)
// http://www.dscripting.com
//---------------------------------------------------

//-------------------------
// Smilies PopUp Window
//-------------------------
function emo_gpoper(doc, field)
{
	if (doc)
	{
		var f = "";
		if (field != undefined)
		{
			f = "&field="+field;
		}
		var left = 0;
		if (popup_sb)
		{
			left = (screen.width) ? (screen.width-252) : 0;
		}
		var ewin = window.open(ipb_var_base_url+'act=Shoutbox&view=extra&type=smilies&doc='+doc+f, 'Smilies', 'width=250,height=500,resizable=yes,scrollbars=yes,top=0,left='+left+'');
	}
}

//-------------------------
//  BBCodes PopUp Window
//-------------------------
function bbc_gpoper()
{
	var left = 0;
	if (popup_sb)
	{
		left = (screen.width) ? (screen.width-700) : 0;
	}
	var cwin = window.open(ipb_var_base_url+'act=Shoutbox&view=extra&type=bbcodes', 'BBCodes', 'width=700,height=500,resizable=yes,scrollbars=yes,top=0,left='+left+'');
}

//-------------------------
// Global Shouts
//-------------------------
function global_shouts()
{
	var src = ipb_var_base_url+'act=Shoutbox&view=globalshouts';
	parent.dsb_giframe.location.href = src;
}

//-------------------------
// Check Shout
//-------------------------
function shout_check(i, f)
{
	if (i)
	{
		var field = 'my_shout';
		if (f != '' && f != undefined)
		{
			var field = f;
		}
		var obj = document.forms[i];
		if (obj.elements[field].value == '')
		{
			return false;
		}
		else
		{
			return true;
		}
	}
}

//-------------------------
// Clear Shout Message
//-------------------------
function clearshout(fm, f)
{
	if (fm)
	{
		if (fm.form.name == 'REPLIER_EDIT')
		{
			fm.form.elements['my_shout_edit'].value = '';
		}
		else
		{
			fm.form.elements['my_shout'].value = '';
		}
	}
}

//-------------------------
// View Profile
//-------------------------
function view_popup_profile(id, p)
{
	if (id)
	{
		if (p == 1)
		{
			parent.opener.location = ipb_var_base_url+'act=Profile&CODE=03&MID='+id;
		}
		else
		{
			parent.location = ipb_var_base_url+'act=Profile&CODE=03&MID='+id;
		}
	}
}

//--------------------------
// Updated Global Shoutbox
//--------------------------
function upgsb(fm)
{
	if (typeof(fm.form.elements['has_refreshed']) != 'undefined')
	{
		fm.form.elements['has_refreshed'].value = 0;
	}
}

//-------------------------
// GSbox Fading Effect
//-------------------------
//var delay = 2000;
var fadescheme = 0;
var fadelinks = 1;
var hex = (fadescheme == 0) ? 255 : 0;
var startcolor = (fadescheme==0) ? 'rgb(255,255,255)' : 'rgb(0,0,0)';
var endcolor = (fadescheme==0) ? 'rgb(0,0,0)' : 'rgb(255,255,255)';
var ie = document.all && !document.getElementById;
var ns = document.layers;
var dm = document.getElementById;
var faderdelay = 0;
var index = 1;
var frame = 20;

if (dm)
{
	faderdelay = 2000;
}

function rotate_shouts()
{
	if (index > gsnum || index > (gsb_shouts.length-1))
	{
		index = 1;
	}

	if (dm)
	{
		document.getElementById('dsb_globalsb').style.color = startcolor;
		document.getElementById('dsb_globalsb').innerHTML = gsb_shouts[index];
		lo = document.getElementById('dsb_globalsb').getElementsByTagName('A');
		if (fadelinks)
		{
			change_color(lo);
			fade_color();
		}
	}
	else if (ie)
	{
		document.all.dsb_globalsb.innerHTML = gsb_shouts[index];
	}
	else if (ns)
	{
		document.dsb_globals_lay.document.dsb_globals_laysub.document.write(gsb_shouts[index]);
		document.dsb_globals_lay.document.dsb_globals_laysub.document.close();
	}

	index++;
	setTimeout('rotate_shouts()', delay+faderdelay);
}

function change_color(obj)
{
	if (obj.length>0)
	{
		for (i=0;i<obj.length;i++)
		{
			obj[i].style.color = 'rgb('+hex+','+hex+','+hex+')';
		}
	}
}

function fade_color()
{
	if (frame > 0)
	{
		hex = (fadescheme==0) ? hex-12 : hex+12;
		document.getElementById('dsb_globalsb').style.color = 'rgb('+hex+','+hex+','+hex+')';
		if (fadelinks)
		{
			change_color(lo);
			frame--;
			setTimeout('fade_color()', 20);
		}
	}
	else
	{
		document.getElementById('dsb_globalsb').style.color = endcolor;
		frame = 20;
		hex = (fadescheme==0) ? 255 : 0;
	}
}

//-------------------------
// Gsbox Scrolling Effect
//-------------------------
//var scrollerdelay = '2000';
var scrollerwidth = '100%';
var scrollerclass = 'row2';
var scrollerheight = '65px';
var scrollerbgcolor = '';
var scrollerbackground = '';
var ie = document.all;
var dm = document.getElementById;
var i = 1;

function move1(whichlayer)
{
	if (i > gsnum)
	{
		i = 1;
	}

	tlayer = eval(whichlayer);
	if (tlayer.top > 0 && tlayer.top <= 5)
	{
		tlayer.top = 0;
		setTimeout('move1(tlayer)', scrollerdelay);
		setTimeout('move2(document.main.document.second)', scrollerdelay);
		return;
	}

	if (tlayer.top >= tlayer.document.height*-1)
	{
		tlayer.top -= 5;
		setTimeout('move1(tlayer)', 50);
	}
	else
	{
		tlayer.top = parseInt(scrollerheight);
		tlayer.document.write(gsb_shouts[i]);
		tlayer.document.close();

		if (i == gsb_shouts.length-1)
		{
			i = 1;
		}
		else
		{
			i++;
		}
	}
}

function move2(whichlayer)
{
	if (i > gsnum)
	{
		i = 1;
	}

	tlayer2 = eval(whichlayer);
	if (tlayer2.top > 0 && tlayer2.top <= 5)
	{
		tlayer2.top = 0;
		setTimeout('move2(tlayer2)', scrollerdelay);
		setTimeout('move1(document.main.document.first)', scrollerdelay);
		return;
	}

	if (tlayer2.top >= tlayer2.document.height*-1)
	{
		tlayer2.top -= 5;
		setTimeout('move2(tlayer2)', 50);
	}
	else
	{
		tlayer2.top = parseInt(scrollerheight);
		tlayer2.document.write(gsb_shouts[i]);
		tlayer2.document.close();

		if (i == gsb_shouts.length-1)
		{
			i = 1;
		}
		else
		{
			i++;
		}
	}
}

function move3(whichdiv)
{
	if (i > gsnum)
	{
		i = 1;
	}

	tdiv = eval(whichdiv);
	if (parseInt(tdiv.style.top) > 0 && parseInt(tdiv.style.top) <= 5)
	{
		tdiv.style.top = 0+'px';
		setTimeout('move3(tdiv)', scrollerdelay);
		setTimeout('move4(second2_obj)', scrollerdelay);
		return;
	}

	if (parseInt(tdiv.style.top) >= tdiv.offsetHeight*-1)
	{
		tdiv.style.top = parseInt(tdiv.style.top)-5+'px';
		setTimeout('move3(tdiv)', 50);
	}
	else
	{
		tdiv.style.top = parseInt(scrollerheight);
		tdiv.innerHTML = gsb_shouts[i];

		if (i == gsb_shouts.length-1)
		{
			i = 1;
		}
		else
		{
			i++;
		}
	}
}

function move4(whichdiv)
{
	if (i > gsnum)
	{
		i = 1;
	}

	tdiv2 = eval(whichdiv);
	if (parseInt(tdiv2.style.top) > 0 && parseInt(tdiv2.style.top) <= 5)
	{
		tdiv2.style.top = 0+'px';
		setTimeout('move4(tdiv2)', scrollerdelay);
		setTimeout('move3(first2_obj)', scrollerdelay);
		return;
	}

	if (parseInt(tdiv2.style.top) >= tdiv2.offsetHeight*-1)
	{
		tdiv2.style.top = parseInt(tdiv2.style.top)-5+'px';
		setTimeout('move4(second2_obj)', 50);
	}
	else
	{
		tdiv2.style.top = parseInt(scrollerheight);
		tdiv2.innerHTML = gsb_shouts[i];

		if (i == gsb_shouts.length-1)
		{
			i = 1;
		}
		else
		{
			i++;
		}
	}
}

function faster()
{
	scrollerdelay = (scrollerdelay - 500);
	if (scrollerdelay <= 0)
	{
		scrollerdelay = 500;
	}
}

function slower()
{
	scrollerdelay = (scrollerdelay + 500);
}

function start_scroll()
{
	if (ie || dm)
	{
		first2_obj = ie ? first2 : document.getElementById('first2');
		second2_obj = ie ? second2 : document.getElementById('second2');
		move3(first2_obj);
		second2_obj.style.top = scrollerheight;
		second2_obj.style.visibility = 'visible';
	}
	else if (document.layers)
	{
		document.main.visibility = 'show';
		move1(document.main.document.first);
		document.main.document.second.top = parseInt(scrollerheight)+5;
		document.main.document.second.visibility = 'show';
	}
}

//-------------------------
// Gsbox Translucent Effect
//-------------------------
//var pause = '3000';
var ie4 = document.all;
var dom = document.getElementById && navigator.userAgent.indexOf("Opera") == -1;
var curpos = 70*(1);
var degree = 10;
var curcanvas = "canvas0";
var curindex = 1;
var nextindex = 2;

function move_5_shout()
{
	if (curpos > 0)
	{
		curpos = Math.max(curpos-degree, 0);
		tempobj.style.top = curpos+"px";
	}
	else
	{
		clearInterval(dropslide);
		if (crossobj.filters)
		{
			crossobj.filters.alpha.opacity = 100;
		}
		else if (crossobj.style.MozOpacity)
		{
			crossobj.style.MozOpacity = 1;
		}

		nextcanvas = (curcanvas == "canvas0") ? "canvas0" : "canvas1";
		tempobj = (ie4) ? eval("document.all."+nextcanvas) : document.getElementById(nextcanvas);
		tempobj.innerHTML = gsb_shouts[curindex];
		nextindex = (nextindex < gsb_shouts.length-1) ? nextindex+1 : 1;
		setTimeout("effect_5_shout()", pause);
	}
}

function effect_5_shout()
{
	if (ie4 || dom)
	{
		reset_5_shout(curcanvas);
		crossobj = tempobj = (ie4) ? eval("document.all."+curcanvas) : document.getElementById(curcanvas);
		crossobj.style.zIndex++;

		if (crossobj.filters)
		{
			document.all.canvas0.filters.alpha.opacity = document.all.canvas1.filters.alpha.opacity = 20;
		}
		else if (crossobj.style.MozOpacity)
		{
			document.getElementById("canvas0").style.MozOpacity = document.getElementById("canvas1").style.MozOpacity  = 0.2;
		}

		var temp = 'setInterval("move_5_shout()", 50)';
		dropslide = eval(temp);
		curcanvas = (curcanvas == "canvas0") ? "canvas1" : "canvas0";
	}
	else if (document.layers)
	{
		crossobj.document.write(gsb_shouts[curindex]);
		crossobj.document.close();
	}

	curindex = (curindex < gsb_shouts.length-1) ? curindex+1 : 1;
}

function reset_5_shout(what)
{
	curpos = parseInt('70px')*(1);
	var crossobj = (ie4) ? eval("document.all."+what) : document.getElementById(what);
	crossobj.style.top = curpos+"px";
}

function start_effect_5()
{
	crossobj = (ie4) ? eval("document.all."+curcanvas) : (dom) ? document.getElementById(curcanvas) : document.tickernsmain.document.tickernssub;
	if (ie4 || dom)
	{
		crossobj.innerHTML = gsb_shouts[curindex];
		effect_5_shout();
	}
	else
	{
		document.tickernsmain.visibility = 'show';
		curindex++;
		setInterval("effect_5_shout()", pause);
	}
}