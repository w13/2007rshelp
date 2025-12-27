// Beat Email Harvesters
function SendMail(name, company, domain)

{
   link = 'm' + 'a' + 'i' + 'l' + 't' + 'o:' + name + '@' + company + '.' + domain;
   window.location.replace(link);
} 

// Skin Cookie and Changing Stuff
var tothis = get_cookie( "rshelpskin" );
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
	document.cookie = "rshelpskin=" + towhat + "; expires=13/12/2036 00:00:00; path=/";
}

function get_cookie ( cookie_name )
{
  var results = document.cookie.match ( cookie_name + '=(.*?)(;|$)' );
  if ( results )
    return ( unescape ( results[1] ) );
  else
    return null;
}

// ADVERTISING:
var sa = "true";
var ca = document.cookie.split('; ');
for(var i=0;i < ca.length;i++) if (ca[i].indexOf('sa=') == 0) sa = ca[i].substring(3,ca[i].length);
	
function advert_top(){
	if(sa == "true") {
	//document.writeln('<scr'+'ipt type="text/javascript" src="http://ad2games.com/slave.php?w=540_195855342"></scr'+'ipt>');
	/* AdSense */ //document.writeln('<scr'+'ipt type="text/javascript">google_ad_client = "pub-0109004644664993";google_ad_slot = "3343294075";google_ad_width = 728;google_ad_height = 90; </sc'+'ript><sc'+'ript type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></sc'+'ript>');
	/* Expiry: Feb 27, 2009 */ document.writeln('<a href="http://www.withgames.com/Affiliate/idevaffiliate.php?id=139_2_1_34" rel="nofollow" target="_blank"><img src="http://www.withgames.com/Affiliate/banners/newbanneronosrs_help03.jpg" width="728" height="90" border="0" /></a>');
	
	}
}

function advert_top_quests(){
	if(sa == "true") {
		//document.writeln('<scr'+'ipt type="text/javascript" src="http://2007rshelp.com/w13/ad4game_quests.js"></scr'+'ipt>');
		
		document.writeln('<scr'+'ipt type="text/javascript">');
		document.writeln('google_ad_client = "pub-0109004644664993";google_ad_slot = "1727176874";google_ad_width = 728;google_ad_height = 90;');
		document.writeln('</scr'+'ipt>');
		document.writeln('<scr'+'ipt type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></scr'+'ipt>');		

	}
}

function advert_side(){
	if(sa == "true") {
		//160x600, OSRS RUNE SCAPE HELP SKY 1  (GOOGLE)
		//document.writeln('<scr'+'ipt type="text/javascript">');
		//document.writeln('google_ad_client = "pub-0109004644664993";google_ad_slot = "7290884724"; google_ad_width = 160; google_ad_height = 600;');
		//document.writeln('</scr'+'ipt>');
		//document.writeln('<scr'+'ipt type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></scr'+'ipt>');				
		
		// US Fine until Feb 15
		document.writeln('<div align="center"><a href="http://www.usfine.com/runescape-c-68.html" target="_blank" rel="nofollow"><img src="http://www.usfine.com/ads/images/RS160.gif" alt="Runescape Gold" width="160" height="600" border="0" /></a></div>');
		
		//OSRS RUNE SCAPE HELP SKY 2   (GOOGLE)
		document.writeln('<br /><scr'+'ipt type="text/javascript">'); document.writeln('google_ad_client = "pub-0109004644664993";google_ad_slot = "5554687715"; google_ad_width = 160; google_ad_height = 600;');		document.writeln('</scr'+'ipt>');		document.writeln('<scr'+'ipt type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></scr'+'ipt>');
		//document.writeln('<br /><br /><scr'+'ipt type="text/javascript" src="http://ad2games.com/slave.php?w=523_303313329"></scr'+'ipt>');
	
	}
}