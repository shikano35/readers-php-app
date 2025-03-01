document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.getElementById('menu-toggle');
    const menu = document.querySelector('.menu');

    menuToggle.addEventListener('click', function () {
        menu.classList.toggle('active');
    });

    document.addEventListener('click', function (event) {
        if (!menu.contains(event.target) && !menuToggle.contains(event.target)) {
            menu.classList.remove('active');
        }
    });

    const menuItems = document.querySelectorAll('.menu-item');
    menuItems.forEach(function (item) {
        item.addEventListener('click', function (event) {
            event.preventDefault();
            const href = this.getAttribute('href');
            window.location.href = href;
        });
    });
});
