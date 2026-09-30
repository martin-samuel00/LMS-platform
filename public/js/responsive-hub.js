/**
 * Classroom Hub - Mobile & Responsive UI Enhancements
 */
document.addEventListener('DOMContentLoaded', function () {
    // 1. Mobile Navigation Toggle Helper
    var toggleBtns = document.querySelectorAll('.mobile-nav-toggle');
    toggleBtns.forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            btn.classList.toggle('open');
            var nav = document.querySelector('.nav-links') || document.querySelector('.navbar-actions');
            if (nav) {
                nav.classList.toggle('show');
            }
        });
    });

    // Close mobile menu if clicked outside
    document.addEventListener('click', function (e) {
        var nav = document.querySelector('.nav-links.show') || document.querySelector('.navbar-actions.show');
        var toggle = document.querySelector('.mobile-nav-toggle.open');
        if (nav && !nav.contains(e.target) && (!toggle || !toggle.contains(e.target))) {
            nav.classList.remove('show');
            if (toggle) toggle.classList.remove('open');
        }
    });

    // Close menu when pressing Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            var nav = document.querySelector('.nav-links.show') || document.querySelector('.navbar-actions.show');
            var toggle = document.querySelector('.mobile-nav-toggle.open');
            if (nav) nav.classList.remove('show');
            if (toggle) toggle.classList.remove('open');
        }
    });

    // Automatically wrap any standard <table> in a responsive container if not already wrapped
    var tables = document.querySelectorAll('table');
    tables.forEach(function (table) {
        if (!table.parentElement.classList.contains('table-responsive')) {
            var wrapper = document.createElement('div');
            wrapper.className = 'table-responsive';
            table.parentNode.insertBefore(wrapper, table);
            wrapper.appendChild(table);
        }
    });
});
