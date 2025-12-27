<!DOCTYPE html>
<html lang="en">
<head>
<title>[#SITE_NAME#]</title>
<link rel="shortcut icon" href="[#FAVICON#].ico" />
<link href="/css/bluelight.css" rel="stylesheet" type="text/css" id="ourstylesheet" />
<script>
    (function() {
        var theme = localStorage.getItem('rshelp_theme') || 'bluelight';
        document.getElementById('ourstylesheet').setAttribute('href', '/css/' + theme + '.css');
    })();
</script>
<link href="/css/global_new.css" rel="stylesheet" type="text/css" />
[#EXTRACSS#]
<!--
COPYRIGHT NOTICE:
RuneScape Help 2001 - onwards; All rights reserved.
All content is for use on 2007rshelp.com ONLY!
Runescape is registered trademark of Jagex Ltd. 
-->
<meta charset="UTF-8" />
<meta name="DESCRIPTION" content="[#METADESCR#]" />
<meta name="KEYWORDS" content="Runescape, 2007, oldschool, deadman, help, price, community, guide, items, monsters, quests, skills, database, tutorial, tips, hints, toolkit, video, pking" />
<meta name="ROBOTS" content="ALL" />

<meta property="fb:admins" content="511362465"/>
<meta property="og:site_name" content="2007RsHelp.com" />
<meta property="og:image" content="http://2007rshelp.com/img/news/07rshelp.png" />
<meta property="og:image:type" content="image/png" />
<meta property="og:image:width" content="640" />
<meta property="og:image:height" content="300" />


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script type="text/javascript" src="/scripts.js"></script>

<script>
function initImage ( url ) {
        img = $('.popUpImage');
        img.attr('src', url).ready(function(){
                img.show();
        });
}

function killImage ( ) {
        img = $('.popUpImage');
        img.attr('src', "https://i.imgur.com/ulym44H.png");
        $('.popUpImage').hide();
}

// on hover of link
$('a').hover(function(e){
                pic = $(this).text();   // get the value within the anchor tag (should be "Picture")
                if (pic == "Picture"){
                        $(this).attr('title', "");                      // remove title so nothing is blocking the image
                        width = $(window).width();                      // get window width
                        url = $(this).attr('href');                     // get the url of image
                        initImage(url);                                         // show the image
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
                pic = $(this).text();
                // make sure its a (Picture) tag
                if (pic == "Picture"){
                        killImage();    // hide the image
                }
        }
);
</head>
<body>

<div id="wrapper">
[#TOPBAR#]
<div id="banner"><a href="/index.php" title="Old-School RuneScape Help"></a></div>

<!-- Top Leaderboard -->
<div style="position:absolute;right:5px;top:37px;width:728px;height:90px;z-index:10">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 2007RsHelpTop -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-0109004644664993"
     data-ad-slot="3891980502"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</div>

[#BOTBAR#]
<div style="clear:both;"></div>
<div id="body">
<div id="sidebar">
[#LINKS#]
[#ADS#]

</div>
<div id="content">
[#CONTENT#]

<!-- bottom bar -->
<div style="clear:both;"></div>

<p style="text-align:center;">

<!-- Begin: Below the fold leaderboard -->
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- 2007RshelpBottom -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-0109004644664993"
     data-ad-slot="3708680501"
     data-ad-format="auto"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
<!-- End: Below the fold leaderboard -->

</p>

</div>
</div>
<br style="clear: both" />
<br />
<div id="footer">
	<div id="copyright">
		<!-- <a href="/sitemap.php" title="Site Map">Site Map</a> - --> 
		<span title="Please dont copy anything from this website without permission">&copy;</span> since 2001 - 
		<a href="https://runescapecommunity.com/forumdisplay.php?fid=15" title="Contact us on our forums">Contact</a>
	</div>
</div>
<!-- Queries: [#QUERIES#] // Execution Time: [#TIME#]-->
</div>

<img class="popUpImage" style="display:none;" src="https://i.imgur.com/ulym44H.png" alt="RuneScape Help's Screenshot" />
<script type="text/javascript" src="/imageautotooltip.js"></script>

<script src="https://www.google.com/cse/api/partner-pub-0109004644664993/cse/3478413701/queries/js?oe=UTF-8&amp;callback=(new+PopularQueryRenderer(document.getElementById(%22queries%22))).render"></script>


<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-Z60SEVLSGL"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-Z60SEVLSGL');
</script>

<img class="popUpImage" style="display:none;" src="https://i.imgur.com/ulym44H.png" alt="RuneScape
Help's Screenshot" />
</body>
</html>
