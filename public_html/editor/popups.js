function go_parent(url) {
	window.opener.location.href = url;
}
function delay_close(url) {
	setTimeout('window.close();',200);
}