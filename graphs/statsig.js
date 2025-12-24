var cnt = 7;
var fade = 75;
var cdown;
var cfade;
function countDown() {
	cnt = parseInt(cnt) - 1;
	
	if(cnt == 5) document.getElementById('countit').style.color = '#ffa500';
	if(cnt == 3) document.getElementById('countit').style.color = '#f00';
	if(cnt == 0) closeBox();
	
	document.getElementById('countit').innerHTML = cnt + 's';
}
function closeBox() {
	clearInterval(cdown);
	cfade = setInterval('doFade()', 12);
}
function doFade() {
	var floaty = document.getElementById('floaty');
	fade = parseInt(fade) - 1;
	floaty.style.opacity = fade * 0.015;
	floaty.style.filter = 'alpha(opacity = '+(fade*1.33)+')';
	if(fade == 0) {
		floaty.style.display = 'none';
		clearInterval(cfade);
	}
}
cdown = setInterval('countDown()', 1000);
