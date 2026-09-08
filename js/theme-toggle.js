/**
 * SIMIT - Theme Toggle Engine (Dark Mode / Light Mode)
 * Manages theme state, persistence via localStorage & cookie, and UI synchronization.
 */
(function () {
    'use strict';

    var STORAGE_KEY = 'simit_theme';

    /**
     * Get current theme ('dark' | 'light')
     */
    function getStoredTheme() {
        var theme = localStorage.getItem(STORAGE_KEY);
        if (!theme) {
            var m = document.cookie.match(new RegExp('(?:^|; )' + STORAGE_KEY + '=([^;]*)'));
            if (m) {
                theme = decodeURIComponent(m[1]);
            }
        }
        if (theme === 'dark' || theme === 'light') {
            return theme;
        }
        // Default awal selalu 'light' (Light Mode)
        return 'light';
    }

    /**
     * Apply theme to DOM and sync controls
     */
    function applyTheme(theme, animate) {
        var isDark = theme === 'dark';
        var root = document.documentElement;
        var body = document.body;

        if (animate) {
            root.classList.add('theme-transition');
        }

        if (isDark) {
            root.classList.add('dark-mode');
            if (body) body.classList.add('dark-mode');
        } else {
            root.classList.remove('dark-mode');
            if (body) body.classList.remove('dark-mode');
        }

        // Sync Navbar Icon & Tooltip
        var navIcon = document.getElementById('icon-theme-toggle');
        var navBtn = document.getElementById('btn-theme-toggle');
        if (navIcon) {
            navIcon.textContent = isDark ? 'wb_sunny' : 'brightness_2';
        }
        if (navBtn) {
            navBtn.setAttribute('title', isDark ? 'Ganti ke Mode Terang (Light Mode)' : 'Ganti ke Mode Gelap (Dark Mode)');
        }

        // Sync Sidebar Checkbox & Label
        var sidebarCheckbox = document.getElementById('theme-toggle-checkbox');
        var sidebarIcon = document.getElementById('sidebar-theme-icon');
        var sidebarText = document.getElementById('sidebar-theme-text');
        if (sidebarCheckbox) {
            sidebarCheckbox.checked = isDark;
        }
        if (sidebarIcon) {
            sidebarIcon.textContent = isDark ? 'wb_sunny' : 'brightness_2';
        }
        if (sidebarText) {
            sidebarText.textContent = isDark ? 'Mode Terang' : 'Mode Gelap';
        }

        if (animate) {
            setTimeout(function () {
                root.classList.remove('theme-transition');
            }, 300);
        }
    }

    /**
     * Set theme and persist to localStorage + cookie
     */
    function setTheme(theme, animate) {
        localStorage.setItem(STORAGE_KEY, theme);
        document.cookie = STORAGE_KEY + "=" + encodeURIComponent(theme) + "; path=/; max-age=31536000; SameSite=Lax";
        applyTheme(theme, animate);
    }

    /**
     * Toggle between dark and light
     */
    function toggleTheme() {
        var current = getStoredTheme();
        var next = current === 'dark' ? 'light' : 'dark';
        setTheme(next, true);
    }

    // Expose API globally
    window.SimitTheme = {
        get: getStoredTheme,
        set: setTheme,
        toggle: toggleTheme
    };

    // Initialize as soon as DOM is ready
    function init() {
        var initialTheme = getStoredTheme();
        // Keep cookie in sync so server gets it on every request
        document.cookie = STORAGE_KEY + "=" + encodeURIComponent(initialTheme) + "; path=/; max-age=31536000; SameSite=Lax";
        applyTheme(initialTheme, false);

        // Navbar toggle click handler
        var navBtn = document.getElementById('btn-theme-toggle');
        if (navBtn) {
            navBtn.addEventListener('click', function (e) {
                e.preventDefault();
                toggleTheme();
            });
        }

        // Sidebar item link click handler (allows clicking anywhere on the item)
        var sidebarLinks = document.querySelectorAll('.sidebar-theme-toggle, .theme-toggle-link');
        sidebarLinks.forEach(function (link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                toggleTheme();
            });
        });

        // Listen for storage changes across tabs
        window.addEventListener('storage', function (e) {
            if (e.key === STORAGE_KEY && (e.newValue === 'dark' || e.newValue === 'light')) {
                applyTheme(e.newValue, true);
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
