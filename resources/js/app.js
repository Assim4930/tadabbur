// Instant, flicker-free SPA navigation & UI enhancements for Tadabbur
document.addEventListener('DOMContentLoaded', () => {
    initCharacterCounters();
    initCopyButtons();
});

// Intercept internal links and form submissions so the background image and layout stay 100% fixed
document.addEventListener('click', async (e) => {
    const link = e.target.closest('a[href]');
    if (!link) return;

    // Ignore modified clicks, external links, or downloads
    if (
        e.metaKey ||
        e.ctrlKey ||
        e.shiftKey ||
        e.altKey ||
        link.target === '_blank' ||
        link.hasAttribute('download')
    ) {
        return;
    }

    const url = new URL(link.href, window.location.origin);
    if (url.origin !== window.location.origin) return;

    e.preventDefault();
    await navigateSmoothly(url.href);
});

document.addEventListener('submit', async (e) => {
    const form = e.target;
    if (!(form instanceof HTMLFormElement)) return;

    const actionUrl = new URL(form.action || window.location.href, window.location.origin);
    if (actionUrl.origin !== window.location.origin) return;

    e.preventDefault();

    const submitBtn = form.querySelector('button[type="submit"]');
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-75', 'pointer-events-none');
    }

    try {
        const method = (form.method || 'GET').toUpperCase();
        const formData = new FormData(form);

        // Close open popover if submitting from inside one
        const openPopover = form.closest('[popover]');
        if (openPopover && typeof openPopover.hidePopover === 'function') {
            try {
                openPopover.hidePopover();
            } catch (_) {}
        }

        const response = await fetch(actionUrl.href, {
            method,
            body: method === 'GET' ? null : formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                Accept: 'text/html, application/xhtml+xml',
            },
            redirect: 'follow',
        });

        const html = await response.text();
        swapPageContent(html, response.url || actionUrl.href, true);
    } catch (err) {
        // Fallback to native form submission on network error
        form.submit();
    }
});

window.addEventListener('popstate', () => {
    navigateSmoothly(window.location.href, false);
});

async function navigateSmoothly(url, pushState = true) {
    try {
        const response = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                Accept: 'text/html, application/xhtml+xml',
            },
        });
        if (!response.ok) {
            window.location.href = url;
            return;
        }
        const html = await response.text();
        swapPageContent(html, response.url || url, pushState);
    } catch (_) {
        window.location.href = url;
    }
}

function swapPageContent(html, finalUrl, pushState = true) {
    const parser = new DOMParser();
    const doc = parser.parseFromString(html, 'text/html');

    const newMain = doc.querySelector('main');
    const newNav = doc.querySelector('nav');
    const currentMain = document.querySelector('main');
    const currentNav = document.querySelector('nav');

    const performSwap = () => {
        if (doc.title) {
            document.title = doc.title;
        }
        if (newNav && currentNav) {
            currentNav.replaceWith(newNav);
        }
        if (newMain && currentMain) {
            currentMain.replaceWith(newMain);
        }
        if (pushState && window.location.href !== finalUrl) {
            window.history.pushState({}, '', finalUrl);
        }
        initCharacterCounters();
        initCopyButtons();
    };

    if (document.startViewTransition) {
        document.startViewTransition(performSwap);
    } else {
        performSwap();
    }
}

function initCharacterCounters() {
    document.querySelectorAll('textarea[maxlength]').forEach((textarea) => {
        if (textarea.dataset.counterBound) return;
        textarea.dataset.counterBound = 'true';

        const max = textarea.getAttribute('maxlength') || 155;
        const helper = textarea.parentElement?.querySelector('[data-char-counter]');
        if (!helper) return;

        const update = () => {
            const len = textarea.value.length;
            helper.textContent = `${len} / ${max}`;
            helper.classList.toggle('text-[#f3d574]', len >= max - 20);
        };
        textarea.addEventListener('input', update);
        update();
    });
}

function initCopyButtons() {
    document.querySelectorAll('[data-copy-quote]').forEach((btn) => {
        if (btn.dataset.copyBound) return;
        btn.dataset.copyBound = 'true';

        btn.addEventListener('click', async () => {
            const text = btn.getAttribute('data-copy-quote');
            if (!text) return;
            try {
                await navigator.clipboard.writeText(`«${text}» — تدبّر`);
                const originalTitle = btn.getAttribute('title') || '';
                btn.classList.add('scale-110', 'ring-2', 'ring-[#d4af37]');
                btn.setAttribute('title', 'تم النسخ! / Copied!');
                showToast('تم نسخ الاقتباس بنجاح ✨');
                setTimeout(() => {
                    btn.classList.remove('scale-110', 'ring-2', 'ring-[#d4af37]');
                    btn.setAttribute('title', originalTitle);
                }, 1500);
            } catch (_) {}
        });
    });
}

function showToast(message) {
    const existing = document.getElementById('tadabbur-toast');
    if (existing) existing.remove();

    const toast = document.createElement('div');
    toast.id = 'tadabbur-toast';
    toast.className =
        'fixed bottom-8 left-1/2 -translate-x-1/2 z-50 flex items-center gap-2 rounded-full bg-[#0a1e16]/95 border border-[#d4af37]/60 px-5 py-2.5 text-sm font-semibold text-[#f3d574] shadow-2xl backdrop-blur-md transition-all duration-300';
    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 300);
    }, 2000);
}
