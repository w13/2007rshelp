function changeimage(towhat,url){
if (document.images){
document.images.targetimage.src=towhat.src
gotolink=url
}
}
function warp(){
window.location=gotolink
}