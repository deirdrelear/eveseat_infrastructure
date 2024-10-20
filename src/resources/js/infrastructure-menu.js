$(document).ready(function() {
    console.log('Script loaded');

    var menuState = localStorage.getItem('menuState');
    console.log('Initial menu state:', menuState);

    if (menuState === 'expanded') {
        $('body').removeClass('sidebar-collapse');
    } else if (menuState === 'collapsed') {
        $('body').addClass('sidebar-collapse');
    }

    $(document).on('collapsed.lte.pushmenu', function() {
        console.log('Menu collapsed');
        localStorage.setItem('menuState', 'collapsed');
    });

    $(document).on('expanded.lte.pushmenu', function() {
        console.log('Menu expanded');
        localStorage.setItem('menuState', 'expanded');
    });
});