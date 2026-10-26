/**
 * Futuristic IT Theme - Customizer Live Preview
 */
(function($) {
    'use strict';

    // Homepage Hero
    wp.customize('custom_hero_tagline', function(value) {
        value.bind(function(to) {
            $('.hero-eyebrow').first().text(to);
        });
    });
    wp.customize('custom_hero_title_before', function(value) {
        value.bind(function(to) {
            $('.hero-title').first().contents().first().replaceWith(to + ' ');
        });
    });
    wp.customize('custom_hero_title_highlight', function(value) {
        value.bind(function(to) {
            $('.hero-title .accent').text(to);
        });
    });
    wp.customize('custom_hero_title_after', function(value) {
        value.bind(function(to) {
            var $title = $('.hero-title').first();
            $title.find('.accent').after(' ' + to);
        });
    });
    wp.customize('custom_hero_subtitle', function(value) {
        value.bind(function(to) {
            $('.hero-subtitle').first().text(to);
        });
    });
    wp.customize('custom_hero_btn_text', function(value) {
        value.bind(function(to) {
            $('.hero-actions .btn-gold').first().text(to);
        });
    });
    wp.customize('custom_hero_btn2_text', function(value) {
        value.bind(function(to) {
            $('.hero-actions .btn-outline').first().text(to);
        });
    });

    // Services Section
    wp.customize('custom_services_tagline', function(value) {
        value.bind(function(to) {
            $('#services .section-eyebrow').text(to);
        });
    });
    wp.customize('custom_services_title', function(value) {
        value.bind(function(to) {
            $('#services .section-title').text(to);
        });
    });
    wp.customize('custom_services_subtitle', function(value) {
        value.bind(function(to) {
            $('#services .section-subtitle').text(to);
        });
    });
    wp.customize('custom_services_cta_text', function(value) {
        value.bind(function(to) {
            $('#services .section-footnote').contents().first().replaceWith(to + ' ');
        });
    });
    wp.customize('custom_services_cta_link_text', function(value) {
        value.bind(function(to) {
            $('#services .section-footnote a').text(to + ' →');
        });
    });
    wp.customize('custom_service_cards', function(value) {
        value.bind(function(to) {
            location.reload();
        });
    });

    // Products Section
    wp.customize('custom_products_tagline', function(value) {
        value.bind(function(to) {
            $('#products .section-eyebrow').text(to);
        });
    });
    wp.customize('custom_products_title', function(value) {
        value.bind(function(to) {
            $('#products .section-title').text(to);
        });
    });
    wp.customize('custom_products_subtitle', function(value) {
        value.bind(function(to) {
            $('#products .section-subtitle').text(to);
        });
    });
    wp.customize('custom_products_cta_text', function(value) {
        value.bind(function(to) {
            $('#products .section-footnote').contents().first().replaceWith(to + ' ');
        });
    });
    wp.customize('custom_products_cta_link_text', function(value) {
        value.bind(function(to) {
            $('#products .section-footnote a').text(to + ' →');
        });
    });
    wp.customize('custom_product_cards', function(value) {
        value.bind(function(to) {
            location.reload();
        });
    });

    // Partners Section
    wp.customize('custom_partners_tagline', function(value) {
        value.bind(function(to) {
            $('#partners .section-eyebrow').text(to);
        });
    });
    wp.customize('custom_partners_title', function(value) {
        value.bind(function(to) {
            $('#partners .section-title').text(to);
        });
    });
    wp.customize('custom_partners_subtitle', function(value) {
        value.bind(function(to) {
            $('#partners .section-subtitle').text(to);
        });
    });

    // CTA / Assurance Section
    wp.customize('custom_cta_tagline', function(value) {
        value.bind(function(to) {
            $('#assurance .dependable-eyebrow').text(to);
        });
    });
    wp.customize('custom_cta_title', function(value) {
        value.bind(function(to) {
            $('#assurance h2').text(to);
        });
    });
    wp.customize('custom_cta_subtitle', function(value) {
        value.bind(function(to) {
            $('#assurance .dependable-text > p').text(to);
        });
    });
    wp.customize('custom_cta_box_title', function(value) {
        value.bind(function(to) {
            $('#assurance .dependable-card h3').text(to);
        });
    });
    wp.customize('custom_cta_box_btn_text', function(value) {
        value.bind(function(to) {
            $('#assurance .dependable-card .hero-btn').text(to);
        });
    });

    // Footer
    wp.customize('custom_footer_tagline', function(value) {
        value.bind(function(to) {
            $('.footer-widget p').first().text(to);
        });
    });
    wp.customize('custom_footer_email', function(value) {
        value.bind(function(to) {
            $('.footer-widget .contact-item').last().find('p').text(to);
        });
    });
    wp.customize('custom_footer_copyright', function(value) {
        value.bind(function(to) {
            $('.footer-bottom p').html('&copy; ' + new Date().getFullYear() + ' ' + to);
        });
    });
    wp.customize('custom_logo_subtitle', function(value) {
        value.bind(function(to) {
            $('.logo-subtitle').text(to);
        });
    });

})(jQuery);
