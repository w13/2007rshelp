/*** PRELOAD ***/
  pickImg = new Image();
  pickImg.src = "/img/equipimg/pick.gif";

/*** GLOBAL VARIABLES ***/
  //var imgArray = new Array("", "url(/img/equipimg/blank_helm.gif)", "", "url(/img/equipimg/blank_cape.gif)", "url(/img/equipimg/blank_amulet.gif)", "url(/img/equipimg/blank_ammo.gif)", "url(/img/equipimg/blank_weap.gif)", "url(/img/equipimg/blank_body.gif)", "url(/img/equipimg/blank_shield.gif)", "", "url(/img/equipimg/blank_legs.gif)", "", "url(/img/equipimg/blank_gloves.gif)", "url(/img/equipimg/blank_boots.gif)", "url(/img/equipimg/blank_ring.gif)");
  //var nameArray = new Array("", "00Helmets", "", "02Capes", "01Amulets", "03Ammo", "04Weapons", "06Bodies", "05Shields", "", "07Legs", "", "09Gloves", "08Boots", "10Rings");
  var slotid = 0;
  var slotnum = 0;
  var itemList = new Array();
  var equipType;
  var equipArray = new Array(11); // TODO: make it be the list of blank-item's indexes.
  var bids = new Array(5350,5344,5351,5345,5352,5353,5346,5354,5347,5348,5349);
 
  for(var i=0;i<11;i++) {
    equipArray[i] = 0;
    itemList[i] = new Array();
    itemList[i][0] = new Array();
    itemList[i][0][0] = bids[equipType];
    getInfo(i, 0);
    //alert(i+", "+itemList[i][0][3]);
  }

/*** FORMAT PRICES ***/
  function comma(num) {
      num += '';
      var parts = num.split('.'), reg = /(\d+)(\d{3})/;
      while (reg.test(parts[0])) {
          parts[0] = parts[0].replace(reg, '$1' + ',' + '$2');
      }
      return parts[0] + (parts[1] ? parts[1] : '');
  }

/*** ABUSE PREVENTION ***/

  function readCookie() {
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
      var c = ca[i];
      while (c.charAt(0)==' ') { c = c.substring(1); }
      if (c.indexOf("clicker=") === 0) { return c.substring(8,c.length); }
    }
    return null;
  }
 
  var clicks = readCookie() ? 20 : 0;
  if (!clicks) { clicks = 0; }


/*** I'm about 98% sure that the new version won't put enough load on to be a problem */
//If people are going to abuse it, they'd just disable the clickCounter anyway.
//typing "javascript:clicks=-9999999;" in the address bar will turn it off.
  function clickCounter(func, param1) {
    func(param1);
    /*if (clicks == 20) {
      alert("Sorry, to reduce abuse only 20 clicks are allowed per minute.");
      if (!readCookie()) {
        var date = new Date();
        date.setTime(date.getTime() + 60000);
        document.cookie = 'clicker' + "=" + 'no' + ";expires=" + date.toGMTString() + ";path=/";
      }
      clicks++;
    }
    if (clicks > 20) {
      if (!readCookie()) {
        clicks = 0;
        func(param1);
      }
      else {
        alert("Sorry, to reduce abuse only 20 clicks are allowed per minute.");
      }
    }
    else {
      clicks++;
      func(param1);
    }*/
  }

//this thing is fine.
/*** AJAX ***/
  function GetXmlHttpObject()
  {
    var xmlHttp=null;
      try {   // Firefox, Opera 8.0+, Safari
        xmlHttp=new XMLHttpRequest();   }
      catch(e)     {   // Internet Explorer
        try     {
         xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");     }
      catch(e)       {
        xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");     }
                }
  return xmlHttp;
  }

/*** UPDATE LIST.  IT UPDATES THE LIST */
  function updateList(eType) {
    equipType = eType;
    var opts = document.getElementById('results');
    opts.options.length = 0;
    if(itemList[equipType][1] == null) {
      xmlHttp=new GetXmlHttpObject();
      url = '/equipmentprofile.php?setbuilder&equip_type='+equipType;
      xmlHttp.open("GET",url,true);
      xmlHttp.onreadystatechange=function() {
        if(xmlHttp.readyState == 4) {
          allresults = xmlHttp.responseText;
          if(allresults !== '') {
            var spResults = allresults.split(";");
            var NumP = 0;
            for (i=1;i<=spResults.length;i++) {
              try {
                itemList[equipType][i] = spResults[i-1].split(",");
                itemList[equipType][i][2] = itemList[equipType][i][1].toLowerCase()+" "+itemList[equipType][i][2].toLowerCase();
                opts.options[NumP] = new Option(itemList[equipType][i][1], itemList[equipType][i][0]);
                Func = "addItem(" + i + ", " + equipType + ")"; //Func = "addItem(" + itemList[equipType][i][0] + ", " + equipType + ")"
                opts.options[NumP].setAttribute('ondblclick', Func);
                NumP++;
              } catch(e) {  }
            }
          }
        }
      };
      xmlHttp.send(null);
    } else {
      var NumP = 0;
      opts.options.length = 0;
      for (i=1;i<=itemList[equipType].length;i++)
      {
        try {
          itemList[equipType][i][2] = itemList[equipType][i][1].toLowerCase()+" "+itemList[equipType][i][2].toLowerCase();
          opts.options[NumP] = new Option(itemList[equipType][i][1], itemList[equipType][i][0]);
          Func = "addItem(" + i + ", " + equipType + ")"; //Func = "addItem(" + itemList[equipType][i][0] + ", " + equipType + ")"
          opts.options[NumP].setAttribute('ondblclick', Func);
         NumP++;
        } catch(e) {  }
      }
    }
  }
 



//works.  Since blank-items are still items, they should work right.
function addItem(listid, type) {
  equipArray[type] = listid;
  if(itemList[type][listid][3] == null) {
      getInfo(type, listid);
    } else {
    updateInfo();
  }
  //DONE??: DO THE IMAGES.
  rli = itemList[type][equipArray[type]][3].split(";");
  document.getElementById("i"+type).style.backgroundImage = "url('/img/idbimg/"+ rli[5] + "')";
}

//works.
function getInfo(type, listID) {
  var dbID = itemList[type][listID][0];
  xmlHttp=new GetXmlHttpObject();
  url = '/equipmentprofile.php?setbuilder&item='+dbID;
  xmlHttp.open("GET",url,true);
  xmlHttp.onreadystatechange=function() {
    if(xmlHttp.readyState == 4) {
      itemList[type][listID][3] = xmlHttp.responseText;
      document.getElementById("holder").innerHTML = itemList[type][listID][3];
      updateInfo();
    }
  };
  xmlHttp.send(null);
}

function updateInfo() {

  var att_stab   = 0;
  var att_slash  = 0;
  var att_crush  = 0;
  var att_range  = 0;
  var att_mage   = 0;
  var def_stab   = 0;
  var def_slash  = 0;
  var def_crush  = 0;
  var def_range  = 0;
  var def_mage   = 0;
  var def_summo  = 0;
  var oth_str    = 0;
  var oth_pray   = 0;
  var names      = '';
  var weights    = 0;
  var members    = 0;
  var price_low  = 0;
  var price_high = 0;
  var ids        = '';
 

  for(var i=0;i<11;i++) {
    if(equipArray[i] != null && itemList[i][equipArray[i]][3] != null) {
      var data = itemList[i][equipArray[i]][3];
      var iresults = data.split(";");
      names      += ", " + iresults[0];
      if(iresults[1].substring(0,1) == '.') iresults[1] = 0 + iresults[1];
      else if(iresults[1] == '-21') iresults[1] = 0;
      weights    += parseInt(iresults[1]);
      members    += parseInt(iresults[2]);
      price_low  += parseInt(iresults[3]);
      price_high += parseInt(iresults[4]);
      var attArray   = iresults[6].split("|");
      var defArray   = iresults[7].split("|");
      var othArray   = iresults[8].split("|");
      if(attArray[0] == '') attArray[0] = 0;
      att_stab  += parseInt(attArray[0]);
      att_slash  += parseInt(attArray[1]);
      att_crush  += parseInt(attArray[2]);
      att_range  += parseInt(attArray[3]);
      att_mage   += parseInt(attArray[4]);
      if(defArray[0] == '') defArray[0] = 0;
      def_stab  += parseInt(defArray[0]);
      def_slash  += parseInt(defArray[1]);
      def_crush  += parseInt(defArray[2]);
      def_range  += parseInt(defArray[3]);
      def_mage   += parseInt(defArray[4]);
      if( defArray[5] == '' || isNaN(defArray[5]) ) defArray[5] = 0;
      def_summo  += parseInt(defArray[5]);
      if(othArray[0] == '') othArray[0] = 0;
      oth_str    += parseInt(othArray[0]);
      oth_pray   += parseInt(othArray[1]);
      ids        += ',' + iresults[9];
    }
  }
  var idList        = document.getElementById("ids");
  var nameList      = document.getElementById("names");
  var weightList    = document.getElementById("weights");
  var memberList    = document.getElementById("members");
  var price_lowList  = document.getElementById("price_low");
  var price_highList = document.getElementById("price_high");
  var att_stabList   = document.getElementById("att_stab");
  var att_slashList  = document.getElementById("att_slash");
  var att_crushList  = document.getElementById("att_crush");
  var att_rangeList  = document.getElementById("att_range");
  var att_mageList   = document.getElementById("att_mage");
  var def_stabList   = document.getElementById("def_stab");
  var def_slashList  = document.getElementById("def_slash");
  var def_crushList  = document.getElementById("def_crush");
  var def_rangeList  = document.getElementById("def_range");
  var def_mageList   = document.getElementById("def_mage");
  var def_summoList  = document.getElementById("def_summo");
  var oth_strList    = document.getElementById("oth_str");
  var oth_prayList   = document.getElementById("oth_pray");
 
  ids = ids.substr(1,ids.length);
  names = names.substr(2,names.length);
  idList.value   = ids;
  nameList.innerHTML = names;
  weightList.innerHTML     = weights;
  price_lowList.innerHTML  = comma(price_low);
  price_highList.innerHTML = comma(price_high);
  memberList.innerHTML     = members;
  att_stabList.innerHTML   = att_stab;
  att_slashList.innerHTML  = att_slash;
  att_crushList.innerHTML  = att_crush;
  att_rangeList.innerHTML  = att_range;
  att_mageList.innerHTML   = att_mage;
  def_stabList.innerHTML   = def_stab;
  def_slashList.innerHTML  = def_slash;
  def_crushList.innerHTML  = def_crush;
  def_rangeList.innerHTML  = def_range;
  def_mageList.innerHTML   = def_mage;
  def_summoList.innerHTML  = def_summo;
  oth_strList.innerHTML    = oth_str;
  oth_prayList.innerHTML   = oth_pray;
}

/*** MISC FUNCTIONS ***/
//if(top != self) top.location.href = location.href; // shove in later
//top.window.onbeforeunload = function() { return 'Clicking \'OK\' will cause you to lose your set.'; }

  function blankItem(type) {
      if(equipType != null) {
        //alert(equipType+", "+equipArray[equipType]+", "+itemList[equipType][equipArray[equipType]][3]);
        rli = itemList[equipType][equipArray[equipType]][3].split(";");
        document.getElementById("i"+equipType).style.backgroundImage = "url('/img/idbimg/"+ rli[5] + "')";
      }
      equipType = type;
      //alert("i"+equipType);
      document.getElementById("i"+equipType).style.backgroundImage = "url(/img/equipimg/pick.gif)";
      document.getElementById("ds").value = 'Refine your search...';
      updateList(equipType);
  }

 
 function removeItem() {
     addItem(equipType, 0);
}

//I haven't touched this.
  function addDescr() {
  var row = document.getElementById("description");
  var textarea = document.createElement("textarea");
  row.innerHTML = '';
  textarea.style.fontSize = '9px';
  textarea.style.fontFamily = 'Verdana';
  textarea.style.width = '98%';
  textarea.style.cursorType = '';
  textarea.setAttribute('name','description');
  row.setAttribute('onclick', '');
  row.appendChild(textarea);
  }

//nor have I touched this over this
  function doSearch(sVar) {
   var opts = document.getElementById('results');
   var NumP = 0;
    opts.options.length = 0;
    for(var i=0;i<itemList[equipType].length;i++) {
      try {
        if(itemList[equipType][i][2].indexOf(sVar) != -1) {
          opts.options[NumP] = new Option(itemList[equipType][i][1], itemList[equipType][i][0]);
          opts.options[NumP].setAttribute('ondblclick', "addItem(" + i + ", "+ equipType +")");
          NumP++;
          }
       } catch(e) {}
     }
  }