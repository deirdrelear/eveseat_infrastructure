$(document).ready(function() {
    console.log('Infrastructure menu script загружен');

    // Получаем текущий URL
    var currentUrl = window.location.pathname;

    // Функция для установки активного пункта меню
    function setActiveMenu(menuSelector, submenuSelector) {
        // Убираем классы active и menu-open с остальных пунктов меню
        $('.nav-sidebar .nav-item').removeClass('menu-open');
        $('.nav-sidebar .nav-link').removeClass('active');

        // Находим и активируем нужный пункт меню
        var menuItem = $(menuSelector).closest('.nav-item');
        menuItem.addClass('menu-open');
        menuItem.find('> a.nav-link').addClass('active');

        // Активируем подменю, если оно есть
        if (submenuSelector) {
            menuItem.find(submenuSelector).addClass('active');
        }
    }

    // Определяем, находимся ли мы в разделе Infrastructure
    if (currentUrl.startsWith('/infrastructure/')) {
        // Устанавливаем активным главный пункт меню Infrastructure
        setActiveMenu('a[href*="/infrastructure"]', null);

        // Определяем активное подменю
        if (currentUrl.includes('/ihubs')) {
            setActiveMenu('a[href*="/infrastructure"]', 'a[href*="ihubs"]');
        } else if (currentUrl.includes('/navstructures')) {
            setActiveMenu('a[href*="/infrastructure"]', 'a[href*="navstructures"]');
        } else if (currentUrl.includes('/dockstructures')) {
            setActiveMenu('a[href*="/infrastructure"]', 'a[href*="dockstructures"]');
        } else if (currentUrl.includes('/miningstructures')) {
            setActiveMenu('a[href*="/infrastructure"]', 'a[href*="miningstructures"]');
        }
    }
});