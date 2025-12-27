// Beat Email Harvesters
function SendMail(name, company, domain) {
    const link = 'mailto:' + name + '@' + company + '.' + domain;
    window.location.replace(link);
}

// Theme management using localStorage for better persistence and performance
(function() {
    const DEFAULT_THEME = 'bluelight';
    const THEME_KEY = 'rshelp_theme';

    // Apply theme immediately if possible to avoid flash
    function getStoredTheme() {
        try {
            return localStorage.getItem(THEME_KEY) || DEFAULT_THEME;
        } catch (e) {
            return DEFAULT_THEME;
        }
    }

    window.changeStyle = function(themeName) {
        const themeLink = document.getElementById('ourstylesheet');
        if (themeLink) {
            themeLink.href = '/css/' + encodeURIComponent(themeName) + '.css';
        }
        try {
            localStorage.setItem(THEME_KEY, themeName);
        } catch (e) {}
    };

    // Initial application (in case layout.inc didn't handle it or for SPA-like transitions)
    const currentTheme = getStoredTheme();
    document.addEventListener('DOMContentLoaded', () => {
        const themeLink = document.getElementById('ourstylesheet');
        if (themeLink && !themeLink.href.includes(currentTheme)) {
            changeStyle(currentTheme);
        }
    });
})();

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
		// Curse ad
		document.writeln('<scr'+'ipt type="text/javascript"> sas_pageid="9168/69696"; sas_formatid=2210; sas_target=""; SmartAdServer(sas_pageid,sas_formatid,sas_target);</sc'+'ript><nosc'+'ript><a href="http://ww38.smartadserver.com/call/pubjumpi/9168/69696/2210/S/[timestamp]/?"><img src="http://ww38.smartadserver.com/call/pubi/9168/69696/2210/S/[timestamp]/?" border="0"></a></nos'+'cript>');
	}
}

function advert_side(){
	if(sa == "true") {
		// Curse Ad:
		document.writeln('<sc'+'ript type="text/javascript"> sas_pageid="9168/69696"; sas_formatid=4662; sas_target=""; SmartAdServer(sas_pageid,sas_formatid,sas_target);</sc'+'ript><nosc'+'ript><a href="http://ww38.smartadserver.com/call/pubjumpi/9168/69696/4662/S/[timestamp]/?"><img src="http://ww38.smartadserver.com/call/pubi/9168/69696/4662/S/[timestamp]/?" border="0"></a></nos'+'cript>');
	}
}
