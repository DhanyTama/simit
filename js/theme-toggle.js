/**
 * SIMIT - Theme & Skin Toggle Engine (Dark/Light Mode + Aesthetic Skins)
 * Manages theme state, color skins (Default, Cappuccino, Everforest, Tokyo),
 * persistence via localStorage & cookie, and UI synchronization.
 */
(function () {
    'use strict';

    var STORAGE_THEME_KEY = 'simit_theme';
    var STORAGE_SKIN_KEY = 'simit_skin';
    var VALID_SKINS = ['default', 'cappuccino', 'everforest', 'tokyo'];

    /**
     * Get current theme ('dark' | 'light')
     */
    function getStoredTheme() {
        var theme = localStorage.getItem(STORAGE_THEME_KEY);
        if (!theme) {
            var m = document.cookie.match(new RegExp('(?:^|; )' + STORAGE_THEME_KEY + '=([^;]*)'));
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
     * Get current skin ('default' | 'cappuccino' | 'everforest' | 'tokyo')
     */
    function getStoredSkin() {
        var skin = localStorage.getItem(STORAGE_SKIN_KEY);
        if (!skin) {
            var m = document.cookie.match(new RegExp('(?:^|; )' + STORAGE_SKIN_KEY + '=([^;]*)'));
            if (m) {
                skin = decodeURIComponent(m[1]);
            }
        }
        if (VALID_SKINS.indexOf(skin) !== -1) {
            return skin;
        }
        return 'default';
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
     * Apply skin class to DOM and sync buttons
     */
    function applySkin(skin, animate) {
        var root = document.documentElement;
        var body = document.body;

        if (animate) {
            root.classList.add('theme-transition');
        }

        VALID_SKINS.forEach(function (s) {
            root.classList.remove('skin-' + s);
            if (body) body.classList.remove('skin-' + s);
        });

        root.classList.add('skin-' + skin);
        if (body) body.classList.add('skin-' + skin);

        // Sync Skin Buttons
        var skinBtns = document.querySelectorAll('.skin-btn');
        skinBtns.forEach(function (btn) {
            if (btn.getAttribute('data-skin') === skin) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });

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
        localStorage.setItem(STORAGE_THEME_KEY, theme);
        document.cookie = STORAGE_THEME_KEY + "=" + encodeURIComponent(theme) + "; path=/; max-age=31536000; SameSite=Lax";
        applyTheme(theme, animate);
    }

    /**
     * Set skin and persist to localStorage + cookie
     */
    function setSkin(skin, animate) {
        if (VALID_SKINS.indexOf(skin) === -1) {
            skin = 'default';
        }
        localStorage.setItem(STORAGE_SKIN_KEY, skin);
        document.cookie = STORAGE_SKIN_KEY + "=" + encodeURIComponent(skin) + "; path=/; max-age=31536000; SameSite=Lax";
        applySkin(skin, animate);
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
        toggle: toggleTheme,
        getSkin: getStoredSkin,
        setSkin: setSkin
    };

    // Initialize as soon as DOM is ready
    function init() {
        var initialTheme = getStoredTheme();
        var initialSkin = getStoredSkin();

        // Keep cookies in sync
        document.cookie = STORAGE_THEME_KEY + "=" + encodeURIComponent(initialTheme) + "; path=/; max-age=31536000; SameSite=Lax";
        document.cookie = STORAGE_SKIN_KEY + "=" + encodeURIComponent(initialSkin) + "; path=/; max-age=31536000; SameSite=Lax";

        applyTheme(initialTheme, false);
        applySkin(initialSkin, false);

        // Navbar toggle click handler
        var navBtn = document.getElementById('btn-theme-toggle');
        if (navBtn) {
            navBtn.addEventListener('click', function (e) {
                e.preventDefault();
                toggleTheme();
            });
        }

        // Sidebar item link click handler
        var sidebarLinks = document.querySelectorAll('.sidebar-theme-toggle, .theme-toggle-link');
        sidebarLinks.forEach(function (link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                toggleTheme();
            });
        });

        // Skin buttons click handlers
        var skinBtns = document.querySelectorAll('.skin-btn');
        skinBtns.forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                var selectedSkin = this.getAttribute('data-skin');
                if (selectedSkin) {
                    setSkin(selectedSkin, true);
                }
            });
        });

        // Listen for storage changes across tabs
        window.addEventListener('storage', function (e) {
            if (e.key === STORAGE_THEME_KEY && (e.newValue === 'dark' || e.newValue === 'light')) {
                applyTheme(e.newValue, true);
            }
            if (e.key === STORAGE_SKIN_KEY && VALID_SKINS.indexOf(e.newValue) !== -1) {
                applySkin(e.newValue, true);
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
