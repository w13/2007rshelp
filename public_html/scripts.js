// Beat Email Harvesters
function SendMail(name, company, domain) {
   link = 'm' + 'a' + 'i' + 'l' + 't' + 'o:' + name + '@' + company + '.' + domain;
   window.location.replace(link);
} 

// Skin Cookie and Changing Stuff
var tothis = get_cookie( "zybezskin" );
if(tothis=='darkblue')
	changeStyle('bluelight');
else if(tothis=='blackblue')
	changeStyle('bluedark');
else if(tothis=='darkgreen')
	changeStyle('greenlight');
else if(tothis=='redblack')
	changeStyle('reddark');
else if(tothis=='redgray')
	changeStyle('redlight');
else if(tothis=='yellowblue')
	changeStyle('bluelight');
else if(tothis != null || tothis != undefined)
	changeStyle(tothis);
else
	changeStyle('bluelight');

function changeStyle(towhat) {
	document.getElementById('ourstylesheet').href = '/css/' + escape(towhat) + '.css';
	document.cookie = "zybezskin=" + towhat + "; expires=13/12/2036 00:00:00; path=/";
}

function get_cookie ( cookie_name ) {
  var results = document.cookie.match ( cookie_name + '=(.*?)(;|$)' );
  if ( results )
    return ( unescape ( results[1] ) );
  else
    return null;
}

// ADVERTISING:
var myDate = new Date();
var sa = "true";
var ca = document.cookie.split('; ');
for(var i=0;i<ca.length;i++) {
  if (ca[i].indexOf('sa=') == 0) {
  sa = ca[i].substring(3,ca[i].length);
  }
}
	
function advert_top(){
	if(sa == "true") {
			//document.writeln('<scr'+'ipt type="text/javascript" src="http://ad2games.com/slave.php?w=540_195855342"></scr'+'ipt>');
			/* AdSense */ /* document.writeln('<scr'+'ipt type="text/javascript">google_ad_client = "pub-0109004644664993";google_ad_slot = "3343294075";google_ad_width = 728;google_ad_height = 90; </sc'+'ript><sc'+'ript type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></sc'+'ript>'); */
			
			// Curse ad
			document.writeln('<scr'+'ipt type="text/javascript"> sas_pageid="9168/69696"; sas_formatid=2210; sas_target=""; SmartAdServer(sas_pageid,sas_formatid,sas_target);</sc'+'ript><nosc'+'ript><a href="http://ww38.smartadserver.com/call/pubjumpi/9168/69696/2210/S/[timestamp]/?"><img src="http://ww38.smartadserver.com/call/pubi/9168/69696/2210/S/[timestamp]/?" border="0"></a></nos'+'cript>');
		
		
	}
}

function advert_top_quests(){
	if(sa == "true") {
		/*
		document.writeln('<scr'+'ipt type="text/javascript">');
		document.writeln('google_ad_client = "pub-0109004644664993";google_ad_slot = "1727176874";google_ad_width = 728;google_ad_height = 90;');
		document.writeln('</scr'+'ipt>');
		document.writeln('<scr'+'ipt type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></scr'+'ipt>');		
		*/

	}
}

function advert_side(){
	if(sa == "true") {
		//160x600, ZYBEZ SKY 1  (GOOGLE)
		/*
			document.writeln('<scr'+'ipt type="text/javascript">');
			document.writeln('google_ad_client = "pub-0109004644664993";google_ad_slot = "7290884724"; google_ad_width = 160; google_ad_height = 600;');
			document.writeln('</scr'+'ipt>');
			document.writeln('<scr'+'ipt type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></scr'+'ipt>');				
*/
		//ZYBEZ SKY 2   (GOOGLE)
		//document.writeln('<br /><scr'+'ipt type="text/javascript">'); document.writeln('google_ad_client = "pub-0109004644664993";google_ad_slot = "5554687715"; google_ad_width = 160; google_ad_height = 600;');		document.writeln('</scr'+'ipt>');		document.writeln('<scr'+'ipt type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></scr'+'ipt>');
		//document.writeln('<br /><br /><scr'+'ipt type="text/javascript" src="http://ad2games.com/slave.php?w=523_303313329"></scr'+'ipt>');
	
	// Curse Ad:
	document.writeln('<sc'+'ript type="text/javascript"> sas_pageid="9168/69696"; sas_formatid=4662; sas_target=""; SmartAdServer(sas_pageid,sas_formatid,sas_target);</sc'+'ript><nosc'+'ript><a href="http://ww38.smartadserver.com/call/pubjumpi/9168/69696/4662/S/[timestamp]/?"><img src="http://ww38.smartadserver.com/call/pubi/9168/69696/4662/S/[timestamp]/?" border="0"></a></nos'+'cript>');
	
	
	}
}
