
/* Made by Sofox - Feb 2014
   http://forums.2007rshelp.com/topic/1603114-2007rshelp-image-mouseover/ 
   */

 function initImage ( url ) {
var img = $('.popUpImage');
img.attr('src', url);
img.show();
}

function killImage ( ) {
var img = $('.popUpImage');
img.attr('src', "https://i.imgur.com/ulym44H.png");
$('.popUpImage').hide();
}


// on hover of link
$('a').hover(function(e){
var pic = $(this).text();
// make sure its a (Picture) tag
if (pic == "Picture"){
var width = $(window).width();
$(this).attr('title', "");
var url = $(this).attr('href'); // get the url of image
initImage(url); // show the image
if (e.pageX+$('.popUpImage').outerWidth() > width){
// if overflow will happen
$('.popUpImage').offset({
top: e.pageY - $(this).outerHeight()+30,
left: e.pageX-$('.popUpImage').outerWidth()
});
}else{
// do normal
$('.popUpImage').offset({
top: e.pageY - $(this).outerHeight()+30,
left: e.pageX - ($(this).outerWidth()/2 -30)
});
}
}
},function(){
var pic = $(this).text();
// make sure its a (Picture) tag
if (pic == "Picture"){
killImage(); // hide the image
}
});

