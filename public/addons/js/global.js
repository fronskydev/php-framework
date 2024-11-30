document.addEventListener('DOMContentLoaded', function () {
    var navbarToggler = document.querySelector('.navbar-toggler');
    var menuOpenIcon = document.getElementById('menu-open-icon');
    var menuCloseIcon = document.getElementById('menu-close-icon');

    navbarToggler.addEventListener('click', function () {
        if (menuOpenIcon.classList.contains('d-none')) {
            menuOpenIcon.classList.remove('d-none');
            menuCloseIcon.classList.add('d-none');
        } else {
            menuOpenIcon.classList.add('d-none');
            menuCloseIcon.classList.remove('d-none');
        }
    });
});