$(document).ready(function() {
    console.log('Infrastructure menu script загружен');

    var currentUrl = window.location.pathname;

    function setActiveMenu() {
        // Удаляем все активные классы
        $('.nav-sidebar .nav-item').removeClass('menu-open');
        $('.nav-sidebar .nav-link').removeClass('active');

        // Находим текущий активный пункт меню
        var activeLink = $('.nav-sidebar .nav-link[href="' + currentUrl + '"]');
        
        if (activeLink.length) {
            // Активируем текущий пункт меню
            activeLink.addClass('active');
            
            // Активируем родительский пункт меню, если есть
            var parentItem = activeLink.closest('.nav-item.has-treeview');
            if (parentItem.length) {
                parentItem.addClass('menu-open');
                parentItem.find('> .nav-link').addClass('active');
            }
        }
    }

    setActiveMenu();
});