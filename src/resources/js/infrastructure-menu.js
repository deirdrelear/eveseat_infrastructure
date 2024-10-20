$(document).ready(function() {
    // Проверяем состояние меню при загрузке страницы
    var menuState = localStorage.getItem('menuState');
    if (menuState === 'expanded') {
        $('body').removeClass('sidebar-collapse');
    } else if (menuState === 'collapsed') {
        $('body').addClass('sidebar-collapse');
    }

    // Обработчик клика по кнопке сворачивания/разворачивания меню
    $('.sidebar-toggle').on('click', function() {
        if ($('body').hasClass('sidebar-collapse')) {
            localStorage.setItem('menuState', 'expanded');
        } else {
            localStorage.setItem('menuState', 'collapsed');
        }
    });
});