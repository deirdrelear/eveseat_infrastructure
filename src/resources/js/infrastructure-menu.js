$(document).ready(function() {
    console.log('Script loaded');

    // Проверяем состояние меню при загрузке страницы
    var menuState = localStorage.getItem('menuState');
    console.log('Initial menu state:', menuState);

    if (menuState === null) {
        // Если состояние не сохранено, используем текущее состояние body
        menuState = $('body').hasClass('sidebar-collapse') ? 'collapsed' : 'expanded';
        localStorage.setItem('menuState', menuState);
    }

    // Устанавливаем начальное состояние меню
    if (menuState === 'expanded') {
        $('body').removeClass('sidebar-collapse');
    } else {
        $('body').addClass('sidebar-collapse');
    }

    // Обработчик клика по кнопке сворачивания/разворачивания меню
    $('[data-widget="pushmenu"]').on('click', function() {
        console.log('Menu clicked');
        menuState = $('body').hasClass('sidebar-collapse') ? 'expanded' : 'collapsed';
        localStorage.setItem('menuState', menuState);
        console.log('New menu state:', menuState);
    });
});