// Beat Email Harvesters
function SendMail(name, company, domain)

{
   link = 'm' + 'a' + 'i' + 'l' + 't' + 'o:' + name + '@' + company + '.' + domain;
   window.location.replace(link);
} 


// Skin Cookie and Changing Stuff
var tothis = get_cookie( "zybezskin" );
if(tothis != null || tothis != undefined){
	changeStyle(tothis);
}else{
	changeStyle('darkblue');
}

function changeStyle(towhat) {
	
	document.getElementById('ourstylesheet').href = '/css/' + escape(towhat) + '.css';
	document.cookie = "zybezskin=" + towhat + "; expires=13/12/2036 00:00:00; path=/";
}

function get_cookie ( cookie_name )
{
  var results = document.cookie.match ( cookie_name + '=(.*?)(;|$)' );
  if ( results )
    return ( unescape ( results[1] ) );
  else
    return null;
}

function set_cookie(c_name,value,expiredays)
{
var exdate=new Date();
exdate.setDate(exdate.getDate()+expiredays);
document.cookie=c_name+ "=" +escape(value)+
((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
}

//if(!get_cookie('editor_tab')) var current_tab = 'wizards';
//else var current_tab = get_cookie('editor_tab');

var current_tab = 'wizards';
//if (get_cookie('tab') !== null) current_tab = get_cookie('tab');
function show(i) {
   var el = document.getElementById(i);
   var ch = document.getElementById(current_tab);
   var bg1 = document.getElementById(i + 'l');
   var bg2 = document.getElementById(current_tab + 'l');
   if (el.style.display=="none") {
      el.style.display="table-row";
      ch.style.display = "none";
      current_tab = i;//issue would have been here
      bg1.style.backgroundColor = '#3C3C3C';
      bg2.style.backgroundColor = '#1F1F1F';
      //set_tab(i);
   }
   set_cookie('tab',i,365);
}
//alert(get_cookie('tab')+'-Ignore this popup.  Jeremy is enhancing something and will be done shortly!');
//if (get_cookie('tab')!==null) show(get_cookie('tab'));

/*function set_tab(tab) {
		document.cookie = "editor_tab=" + escape(tab) + "; expires=13/12/2036 00:00:00; path=/editor/";
}

function get_cookie (tabname) {
  var results = document.cookie.match ( tabname + '=(.*?)(;|$)' );
  if ( results )
    return ( unescape ( results[1] ) );
  else
    return null;
}*/