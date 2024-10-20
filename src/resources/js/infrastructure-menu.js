$(document).ready(function() {
    console.log('Script loaded');

    // Проверяем состояние меню при загрузке страницы
    var menuState = localStorage.getItem('menuState');
    console.log('Initial menu state:', menuState);

    if (menuState === 'expanded') {
        $('body').removeClass('sidebar-collapse').addClass('sidebar-open');
    } else if (menuState === 'collapsed') {
        $('body').addClass('sidebar-collapse').removeClass('sidebar-open');
    }

    // Обработчик клика по кнопке сворачивания/разворачивания меню
    $('[data-widget="pushmenu"]').on('click', function() {
        console.log('Menu clicked');
        if ($('body').hasClass('sidebar-collapse')) {
            localStorage.setItem('menuState', 'expanded');
            console.log('Menu expanded');
        } else {
            localStorage.setItem('menuState', 'collapsed');
            console.log('Menu collapsed');
        }
    });

    // Проверяем, существует ли элемент с атрибутом data-widget="pushmenu"
    if ($('[data-widget="pushmenu"]').length === 0) {
        console.error('Element with data-widget="pushmenu" not found');
    }
});