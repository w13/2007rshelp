var current_boxdiv;
var just_open = true;

document.body.onclick = check_box

function move_box(an, box) {
  var cleft = 0;
  var ctop = 0;
  var obj = an;
  while (obj.offsetParent) {
    cleft += obj.offsetLeft;
    ctop += obj.offsetTop;
    obj = obj.offsetParent;
  }
  box.style.left = cleft + 'px';
  ctop += an.offsetHeight + 8;
  if (document.body.currentStyle &&
    document.body.currentStyle['marginTop']) {
    ctop += parseInt(
      document.body.currentStyle['marginTop']);
  }
  box.style.top = ctop + 'px';
}

function popup(an, width, height, borderStyle) {
  check_box();
  var href = an.href;
  var boxdiv = document.getElementById(href);

  if (boxdiv != null) {
    if (boxdiv.style.display=='none') {
      move_box(an, boxdiv);
      boxdiv.style.display='block';
    } else
      boxdiv.style.display='none';
    return false;
  }
  
  boxdiv = document.createElement('div');
  boxdiv.setAttribute('id', href);
  boxdiv.style.display = 'block';
  boxdiv.style.position = 'absolute';
  boxdiv.style.left = '50%';
  boxdiv.style.margin = '0 0 0 -266px';
  boxdiv.style.width = width + 'px';
  boxdiv.style.height = height + 'px';
  boxdiv.style.border = borderStyle;
  boxdiv.style.backgroundColor = '#242424';

  var contents = document.createElement('iframe');
  contents.scrolling = 'no';
  contents.frameBorder = '0';
  contents.style.width = width + 'px';
  contents.style.height = height + 'px';
  contents.src = href;

  boxdiv.appendChild(contents);
  current_boxdiv = document.body.appendChild(boxdiv);
  just_open = true;
  move_box(an, boxdiv);

  return false;
}

function check_box() {
    if (current_boxdiv) {
       if (!just_open) {
            if (current_boxdiv.style.display != 'none') {
                current_boxdiv.style.display = 'none';
            }
        }
        else {
            just_open = false;
        }
    }
}