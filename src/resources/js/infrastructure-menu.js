$(document).ready(function() {
    console.log('Infrastructure menu script загружен');

    // Получаем текущий URL
    var currentUrl = window.location.pathname;

    // Проверяем, находится ли пользователь на странице плагина Infrastructure
    if (currentUrl.includes('/infrastructure/')) { // Замените '/infrastructure/' на актуальную часть URL, если отличается
        // Находим элемент меню Infrastructure по ссылке
        var infrastructureMenu = $('a[href*="infrastructure"]').closest('.nav-item');

        // Добавляем классы для открытия секции меню
        infrastructureMenu.addClass('menu-open');
        infrastructureMenu.find('a.nav-link').addClass('active');

        // Устанавливаем активным соответствующий пункт подменю
        if (currentUrl.includes('/infrastructure/ihubs')) {
            infrastructureMenu.find('a[href*="ihubs"]').addClass('active');
        } else if (currentUrl.includes('/infrastructure/navstructures')) {
            infrastructureMenu.find('a[href*="navstructures"]').addClass('active');
        } else if (currentUrl.includes('/infrastructure/dockstructures')) {
            infrastructureMenu.find('a[href*="dockstructures"]').addClass('active');
        } else if (currentUrl.includes('/infrastructure/miningstructures')) {
            infrastructureMenu.find('a[href*="miningstructures"]').addClass('active');
        }
    }

    // Убедитесь, что не выполняется сворачивание бокового меню
});