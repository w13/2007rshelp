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

// ADVERTISING placeholder - simplified and modernized
function advert_top() {
    // AdSense or other ad providers would be initialized here
    console.log('Top ad initialized');
}

function advert_side() {
    console.log('Side ad initialized');
}