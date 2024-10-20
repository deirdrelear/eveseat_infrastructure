$(document).ready(function() {
    console.log('Infrastructure menu script загружен');

    var currentUrl = window.location.pathname;

    function setActiveMenu(menuSelector, submenuSelector) {
        $('.nav-sidebar .nav-item').removeClass('menu-open');
        $('.nav-sidebar .nav-link').removeClass('active');

        var menuItem = $(menuSelector).closest('.nav-item');
        menuItem.addClass('menu-open');
        menuItem.find('> a.nav-link').addClass('active');

        if (submenuSelector) {
            menuItem.find(submenuSelector).addClass('active');
        }

        // Сохраняем состояние в localStorage
        localStorage.setItem('activeMenu', menuSelector);
        localStorage.setItem('activeSubmenu', submenuSelector);
    }

    function restoreMenuState() {
        var activeMenu = localStorage.getItem('activeMenu');
        var activeSubmenu = localStorage.getItem('activeSubmenu');
        if (activeMenu) {
            setActiveMenu(activeMenu, activeSubmenu);
        }
    }

    if (currentUrl.startsWith('/infrastructure/')) {
        var submenuSelector = null;
        if (currentUrl.includes('/ihubs')) {
            submenuSelector = 'a[href*="ihubs"]';
        } else if (currentUrl.includes('/navstructures')) {
            submenuSelector = 'a[href*="navstructures"]';
        } else if (currentUrl.includes('/dockstructures')) {
            submenuSelector = 'a[href*="dockstructures"]';
        } else if (currentUrl.includes('/miningstructures')) {
            submenuSelector = 'a[href*="miningstructures"]';
        }
        setActiveMenu('a[href*="/infrastructure"]', submenuSelector);
    } else {
        restoreMenuState();
    }
});