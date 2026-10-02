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

    // 2. Automatically convert existing session flash alerts to animated HubToasts
    var successAlert = document.querySelector('.alert-success');
    if (successAlert && successAlert.textContent.trim()) {
        window.HubToast.success(successAlert.textContent.trim());
    }

    var errorAlert = document.querySelector('.alert-error');
    if (errorAlert && errorAlert.textContent.trim()) {
        window.HubToast.error(errorAlert.textContent.trim());
    }
});

// Universal HubToast Notification Engine
window.HubToast = (function () {
    function getContainer() {
        var container = document.getElementById('hub-toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'hub-toast-container';
            document.body.appendChild(container);
        }
        return container;
    }

    function show(options) {
        var type = options.type || 'info';
        var title = options.title || (type.charAt(0).toUpperCase() + type.slice(1));
        var message = options.message || '';
        var duration = options.duration || 4200;

        var icons = {
            success: '✅',
            error: '❌',
            warning: '⚠️',
            info: '💡'
        };

        var container = getContainer();
        var toast = document.createElement('div');
        toast.className = 'hub-toast hub-toast-' + type;
        toast.innerHTML = 
            '<div class="hub-toast-icon">' + (icons[type] || '💡') + '</div>' +
            '<div class="hub-toast-content">' +
                '<div class="hub-toast-title">' + escapeText(title) + '</div>' +
                '<div class="hub-toast-message">' + escapeText(message) + '</div>' +
            '</div>' +
            '<button type="button" class="hub-toast-close" title="Dismiss">&times;</button>' +
            '<div class="hub-toast-progress"></div>';

        container.appendChild(toast);

        var closeBtn = toast.querySelector('.hub-toast-close');
        function dismiss() {
            toast.classList.add('hub-toast-hiding');
            setTimeout(function () {
                if (toast.parentNode) toast.parentNode.removeChild(toast);
            }, 300);
        }

        if (closeBtn) closeBtn.addEventListener('click', dismiss);

        if (duration > 0) {
            setTimeout(dismiss, duration);
        }
    }

    function escapeText(str) {
        var p = document.createElement('p');
        p.textContent = str || '';
        return p.innerHTML;
    }

    return {
        show: show,
        success: function (msg, title) { show({ type: 'success', message: msg, title: title || 'Success' }); },
        error: function (msg, title) { show({ type: 'error', message: msg, title: title || 'Error' }); },
        warning: function (msg, title) { show({ type: 'warning', message: msg, title: title || 'Notice' }); },
        info: function (msg, title) { show({ type: 'info', message: msg, title: title || 'Information' }); }
    };
})();

// 3. Instant Snappy Navigation & Link Prefetching Engine
(function () {
    var progressBar = document.createElement('div');
    progressBar.id = 'hub-nav-progress-bar';
    document.body.appendChild(progressBar);

    var progressTimer = null;
    var currentProgress = 0;

    function startProgress() {
        if (progressTimer) clearInterval(progressTimer);
        currentProgress = 15;
        progressBar.style.width = currentProgress + '%';
        progressBar.className = 'active';

        progressTimer = setInterval(function () {
            if (currentProgress < 75) {
                currentProgress += Math.random() * 12;
                progressBar.style.width = currentProgress + '%';
            }
        }, 120);
    }

    function completeProgress() {
        if (progressTimer) clearInterval(progressTimer);
        progressBar.className = 'active finishing';
        setTimeout(function () {
            progressBar.className = '';
            progressBar.style.width = '0%';
        }, 350);
    }

    // Prefetch cache map to avoid duplicate prefetch tags
    var prefetched = {};

    function prefetchUrl(url) {
        if (!url || prefetched[url]) return;
        prefetched[url] = true;
        var link = document.createElement('link');
        link.rel = 'prefetch';
        link.href = url;
        document.head.appendChild(link);
    }

    // Listen for hover & touchstart on internal links to prefetch
    document.addEventListener('mouseover', function (e) {
        var a = e.target.closest('a');
        if (!a || !a.href) return;
        if (a.origin === window.location.origin && !a.href.includes('#') && !a.hasAttribute('download')) {
            prefetchUrl(a.href);
        }
    });

    document.addEventListener('touchstart', function (e) {
        var a = e.target.closest('a');
        if (!a || !a.href) return;
        if (a.origin === window.location.origin && !a.href.includes('#') && !a.hasAttribute('download')) {
            prefetchUrl(a.href);
        }
    }, { passive: true });

    // Show instant progress on link click
    document.addEventListener('click', function (e) {
        var a = e.target.closest('a');
        if (!a || !a.href || a.target === '_blank' || a.hasAttribute('download')) return;
        if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
        if (a.origin === window.location.origin && !a.href.includes('#') && a.href !== window.location.href) {
            startProgress();
        }
    });

    // Show instant progress on form submissions
    document.addEventListener('submit', function (e) {
        var form = e.target;
        if (form && !form.target) {
            startProgress();
        }
    });

    window.addEventListener('pageshow', function () {
        completeProgress();
    });
})();


