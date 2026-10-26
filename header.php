<!DOCTYPE html>
<html <?php language_attributes(); ?> class="lang-<?php echo esc_attr(futuristic_it_get_current_lang()); ?>">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php
    $hero_bg = get_option('custom_hero_bg_image', '');
    if (!empty($hero_bg)) : ?>
    <link rel="preload" as="image" href="<?php echo esc_url($hero_bg); ?>">
    <?php endif;
    $logo_img = get_theme_mod('custom_logo');
    if ($logo_img) : ?>
    <link rel="preload" as="image" href="<?php echo esc_url(wp_get_attachment_url($logo_img)); ?>">
    <?php endif; ?>
    <script src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/js/three.min.js"></script>
    <script src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/js/vanta.globe.min.js"></script>
    <script src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/js/vanta.dots.min.js"></script>
    <?php wp_head(); ?>
    <style>
        .google-translate-wrapper {
            position: relative;
            display: inline-flex;
            align-items: center;
        }
        .google-translate-wrapper .goog-te-gadget {
            font-size: 0 !important;
            height: 0 !important;
            overflow: hidden;
        }
        .google-translate-wrapper .goog-te-gadget .goog-te-combo {
            display: none;
        }
        .lang-switch-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            background: var(--dark-green, #142e1f);
            border: 1px solid rgba(20, 46, 31, 0.2);
            border-radius: 6px;
            color: var(--white, #fff);
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .lang-switch-btn:hover {
            background: var(--primary-green, #1a3d27);
            border-color: rgba(20, 46, 31, 0.4);
        }
        .lang-switch-btn svg {
            width: 16px;
            height: 16px;
        }
        .lang-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background: var(--white, #fff);
            border: 1px solid var(--border-color, #e5e7eb);
            border-radius: 8px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            z-index: 10001;
            min-width: 140px;
            padding: 6px 0;
            margin-top: 4px;
        }
        .lang-dropdown.show {
            display: block;
        }
        .lang-dropdown a, .lang-dropdown button.lang-option {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            color: var(--text-dark, #1a1a1a);
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
            transition: background 0.2s;
        }
        .lang-dropdown a:hover, .lang-dropdown button.lang-option:hover {
            background: var(--cream, #f7f6f1);
        }
        .lang-dropdown a.active, .lang-dropdown button.lang-option.active {
            color: var(--dark-green, #142e1f);
            font-weight: 700;
        }
    </style>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="container">
        <div class="flex items-center justify-between">
            <div class="w-24 h-24">
                <?php
                if (has_custom_logo()) {
                    the_custom_logo();
                } else {
                    ?>
                        <a href="<?php echo esc_url(home_url('/')); ?>">
                            <span class="logo-badge">F</span>x
                            <span class="logo-text">
                                <span class="logo-title"><?php echo esc_html(futuristic_it_t('custom_logo_title', 'FUTURISTIC')); ?></span>
                                <span class="logo-subtitle"><?php echo esc_html(futuristic_it_t('custom_logo_subtitle', 'Investment Co., Ltd.')); ?></span>
                            </span>
                        </a>
                    <?php
                }
                ?>
            </div>

            <nav class="main-navigation" id="main-nav">
                <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'menu_class'     => '',
                        'fallback_cb'    => false,
                    ));
                ?>
            </nav>

            <div class="header-actions">
                <div class="google-translate-wrapper">
                    <?php $current_lang = futuristic_it_get_current_lang(); ?>
                    <button type="button" class="lang-switch-btn" id="lang-toggle" aria-expanded="false" aria-controls="lang-dropdown">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                        <span id="current-lang"><?php echo $current_lang === 'km' ? 'KH' : 'EN'; ?></span>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </button>
                    <div class="lang-dropdown" id="lang-dropdown">
                        <button type="button" data-lang="en" class="lang-option <?php echo $current_lang === 'en' ? 'active' : ''; ?>">
                            <span>🇬🇧</span> English
                        </button>
                        <button type="button" data-lang="km" class="lang-option <?php echo $current_lang === 'km' ? 'active' : ''; ?>">
                            <span>🇰🇭</span> Khmer
                        </button>
                    </div>
                </div>

                <button class="mobile-menu-toggle hidden max-md:flex items-center justify-center w-11 h-11 rounded-lg border border-[var(--border-color)] bg-white cursor-pointer flex-col gap-[5px] transition-colors duration-200 hover:bg-[var(--cream)]" id="mobile-menu-btn" aria-label="Toggle Menu" aria-expanded="false">
                    <span class="block w-[22px] h-[2px] bg-[var(--dark-green)] rounded-sm transition-all duration-300"></span>
                    <span class="block w-[22px] h-[2px] bg-[var(--dark-green)] rounded-sm transition-all duration-300"></span>
                    <span class="block w-[22px] h-[2px] bg-[var(--dark-green)] rounded-sm transition-all duration-300"></span>
                </button>
            </div>
        </div>
    </div>
</header>
<div class="mobile-menu-overlay" id="mobile-menu-overlay"></div>

<script>
function switchLang(lang) {
    document.cookie = 'site_lang=' + lang + ';path=/;max-age=31536000';
    var url = new URL(window.location.href);
    url.searchParams.set('site_lang', lang);
    url.searchParams.set('_nocache', Date.now());
    window.location.href = url.toString();
}

function propagateLang() {
    var lang = new URL(window.location.href).searchParams.get('site_lang');
    if (!lang) return;
    var links = document.querySelectorAll('a[href]');
    for (var i = 0; i < links.length; i++) {
        try {
            var linkUrl = new URL(links[i].href);
            if (linkUrl.hostname === window.location.hostname) {
                linkUrl.searchParams.set('site_lang', lang);
                links[i].href = linkUrl.toString();
            }
        } catch(e) {}
    }
    var observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            mutation.addedNodes.forEach(function(node) {
                if (node.nodeType === 1) {
                    var targets = node.matches && node.matches('a[href]') ? [node] : (node.querySelectorAll ? node.querySelectorAll('a[href]') : []);
                    for (var j = 0; j < targets.length; j++) {
                        try {
                            var u = new URL(targets[j].href);
                            if (u.hostname === window.location.hostname) {
                                u.searchParams.set('site_lang', lang);
                                targets[j].href = u.toString();
                            }
                        } catch(e) {}
                    }
                }
            });
        });
    });
    observer.observe(document.body, { childList: true, subtree: true });
}

document.addEventListener('DOMContentLoaded', function() {
    var langToggle = document.getElementById('lang-toggle');
    var langDropdown = document.getElementById('lang-dropdown');
    var mobileBtn = document.getElementById('mobile-menu-btn');
    var mainNav = document.getElementById('main-nav');
    var overlay = document.getElementById('mobile-menu-overlay');

    function closeMobileMenu() {
        if (mobileBtn) {
            mobileBtn.classList.remove('active');
            mobileBtn.setAttribute('aria-expanded', 'false');
        }
        if (mainNav) mainNav.classList.remove('active');
        if (overlay) overlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    function openMobileMenu() {
        if (mobileBtn) {
            mobileBtn.classList.add('active');
            mobileBtn.setAttribute('aria-expanded', 'true');
        }
        if (mainNav) mainNav.classList.add('active');
        if (overlay) overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    if (langToggle && langDropdown) {
        langToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            langDropdown.classList.toggle('show');
            this.setAttribute('aria-expanded', langDropdown.classList.contains('show'));
        });
    }

    if (langDropdown) {
        var langLinks = langDropdown.querySelectorAll('button[data-lang]');
        for (var i = 0; i < langLinks.length; i++) {
            langLinks[i].addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                var lang = this.getAttribute('data-lang');
                switchLang(lang);
            });
        }
    }

    if (mobileBtn && mainNav) {
        mobileBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            if (mainNav.classList.contains('active')) {
                closeMobileMenu();
            } else {
                openMobileMenu();
            }
        });
    }

    if (overlay) {
        overlay.addEventListener('click', function() {
            closeMobileMenu();
        });
    }

    var parentItems = mainNav ? mainNav.querySelectorAll('.menu-item-has-children') : [];
    for (var i = 0; i < parentItems.length; i++) {
        (function(parent) {
            var link = parent.querySelector(':scope > a');
            var subMenu = parent.querySelector(':scope > .sub-menu');
            if (!link) return;

            function updateView() {
                if (window.innerWidth <= 768) {
                    link.style.cursor = 'pointer';
                } else {
                    link.style.cursor = '';
                }
            }
            updateView();
            window.addEventListener('resize', updateView);

            link.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                var siblings = parent.parentElement ? parent.parentElement.querySelectorAll(':scope > .menu-item-has-children') : [];
                for (var s = 0; s < siblings.length; s++) {
                    if (siblings[s] !== parent) {
                        siblings[s].classList.remove('active');
                    }
                }
                parent.classList.toggle('active');
            });
        })(parentItems[i]);
    }

    document.addEventListener('click', function(e) {
        if (langDropdown && langToggle && !langDropdown.contains(e.target) && !langToggle.contains(e.target)) {
            langDropdown.classList.remove('show');
            langToggle.setAttribute('aria-expanded', 'false');
        }
    });

    var header = document.querySelector('.site-header');
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            closeMobileMenu();
        }
    });

    propagateLang();
});
</script>
