$(document).ready(function() {
    console.log('Infrastructure menu script загружен');

    var currentUrl = window.location.pathname;

    function setActiveMenu(menuSelector, submenuSelector) {
        $('.nav-sidebar .nav-item').removeClass('menu-open');
        $('.nav-sidebar .nav-link').removeClass('active');

        var menuItem = $(menuSelector);
        menuItem.closest('.nav-item').addClass('menu-open');
        menuItem.addClass('active');

        if (submenuSelector) {
            $(submenuSelector).addClass('active');
        }

        localStorage.setItem('activeMenu', menuSelector);
        localStorage.setItem('activeSubmenu', submenuSelector);
    }

    function getSubmenuSelector(url) {
        if (url.includes('/ihubs')) {
            return 'a[href$="/ihubs"]';
        } else if (url.includes('/navstructures')) {
            return 'a[href$="/navstructures"]';
        } else if (url.includes('/dockstructures')) {
            return 'a[href$="/dockstructures"]';
        } else if (url.includes('/miningstructures')) {
            return 'a[href$="/miningstructures"]';
        }
        return null;
    }

    if (currentUrl.includes('/infrastructure/')) {
        var menuSelector = 'a[href*="/infrastructure"]';
        var submenuSelector = getSubmenuSelector(currentUrl);
        setActiveMenu(menuSelector, submenuSelector);
    } else {
        var activeMenu = localStorage.getItem('activeMenu');
        var activeSubmenu = localStorage.getItem('activeSubmenu');
        if (activeMenu) {
            setActiveMenu(activeMenu, activeSubmenu);
        }
    }
});