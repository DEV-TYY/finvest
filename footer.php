<footer class="bg-[var(--dark-green)] text-white py-0">

    <div class="container">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-[1.4fr_1fr_1.2fr] gap-[50px] py-[50px]">
            <div class="flex flex-col items-start">
                <div class="flex flex-col items-center gap-3.5 mb-[18px]">
                    <?php $footer_logo = get_option('custom_footer_logo_image', ''); ?>
                    <?php if (!empty($footer_logo)) : ?>
                        <div>
                           <img src="<?php echo esc_url($footer_logo); ?>" alt="<?php bloginfo('name'); ?>" class="h-24 w-auto rounded">
                        </div>
                        <?php else : ?>
                        <div class="w-[46px] h-[46px] rounded-full flex items-center justify-center font-extrabold text-lg shrink-0" style="background: radial-gradient(circle at 35% 30%, var(--gold-light), var(--gold-dark) 75%); color: var(--dark-green);"></div>
                    <?php endif; ?>
                    <span class="flex flex-wrap gap-1">
                        <span class="text-lg font-extrabold text-white"><?php echo esc_html(futuristic_it_t('custom_logo_title')); ?></span>
                    </span>
                </div>
                <p class="leading-7 text-sm sm:text-base max-w-[320px] text-[var(--text-on-dark-soft)]"><?php echo esc_html(futuristic_it_t('custom_footer_tagline')); ?></p>
            </div>

            <div class="footer-widget">
                <h4 class="text-sm sm:text-base mb-[22px] font-bold text-[var(--gold)]"><?php echo esc_html(futuristic_it_t('custom_footer_quicklinks_title')); ?></h4>
                <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'menu_class'     => '',
                        'fallback_cb'    => false,
                        'depth'          => 1,
                        'items_wrap'     => '<ul class="list-none p-0 m-0">%3$s</ul>',
                    ));
                ?>
            </div>

            <div>
                <h4 class="text-sm sm:text-base mb-[22px] font-bold text-[var(--gold)]"><?php echo esc_html(futuristic_it_t('custom_footer_contact_title')); ?></h4>

                <?php if (!empty(get_option('custom_footer_address', ''))) : ?>
                    <div class="flex items-start gap-2">
                        <span class="text-[var(--gold)] shrink-0">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                        </span>
                        <p class="text-sm sm:text-base text-[var(--text-on-dark-soft)]"><?php echo wp_kses(get_option('custom_footer_address', ''), array('br' => array())); ?></p>
                    </div>
                <?php endif; ?>

                <?php if (!empty(get_option('custom_footer_email', ''))) : ?>
                    <div class="flex items-center gap-2 mt-3">
                        <span class="text-[var(--gold)] shrink-0 mt-px">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                        </span>
                        <p class="text-sm sm:text-base leading-7 m-0 text-[var(--text-on-dark-soft)]"><a href="mailto:<?php echo esc_attr(get_option('custom_footer_email', '')); ?>" class="hover:text-[var(--gold)] transition-colors duration-300"><?php echo esc_html(get_option('custom_footer_email', '')); ?></a></p>
                    </div>
                <?php endif; ?>

                <?php
                    $social_links = json_decode(get_option('custom_footer_social_links', '[]'), true);
                    if (!is_array($social_links)) $social_links = array();
                    $social_icons = array(
                        'facebook'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
                        'linkedin'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.647H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
                        'twitter'   => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
                        'instagram' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.197-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>',
                        'youtube'   => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
                        'whatsapp'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>',
                        'tiktok'    => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1v-3.5a6.37 6.37 0 0 0-1-.08A6.34 6.34 0 0 0 3.15 15.9a6.34 6.34 0 0 0 10.86 4.43l.01-.01a6.32 6.32 0 0 0 1.87-4.43c0-1.16-.32-2.25-.87-3.18.61.77 1.5 1.29 2.5 1.29V9.4a4.83 4.83 0 0 1-2.5-1.29l.01-.01c.62.8 1 1.77 1 2.81 0 2.52-2.04 4.56-4.56 4.56S3.15 14.26 3.15 11.74c0-.79.18-1.54.5-2.2V6.69A6.33 6.33 0 0 0 3.15 11.74c0 3.51 2.84 6.35 6.35 6.35s6.35-2.84 6.35-6.35c0-.78-.18-1.53-.5-2.2l.01-.01A6.34 6.34 0 0 0 15.85 11.74c0 1.84-.75 3.51-1.97 4.73"/></svg>',
                        'telegram'  => '<svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>',
                    );
                    if (!empty($social_links)) :
                ?>
                <div class="flex gap-3.5 mt-4">
                    <?php foreach ($social_links as $sl) :
                        $icon_key = $sl['icon'] ?? '';
                        $icon_svg = $social_icons[$icon_key] ?? '';
                        $platform_name = ucfirst($icon_key);
                    ?>
                        <a href="<?php echo esc_url($sl['url'] ?? '#'); ?>" aria-label="<?php echo esc_attr($platform_name); ?>" target="_blank" class="w-9 h-9 rounded-full flex items-center justify-center text-white transition-all duration-300" style="background: rgba(255, 255, 255, 0.08);" onmouseover="this.style.background='var(--gold)';this.style.color='var(--dark-green)'" onmouseout="this.style.background='rgba(255,255,255,0.08)';this.style.color='var(--white)'">
                            <?php if ($icon_svg) : ?>
                                <?php echo $icon_svg; ?>
                            <?php else : ?>
                                <?php echo esc_html(substr($platform_name, 0, 2)); ?>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php if (!empty(get_option('custom_footer_copyright', ''))) : ?>
            <div class="border-t border-[var(--border-on-dark)] py-6 text-center">
                <p class="text-[0.75rem] font-semibold m-0 text-[var(--text-on-dark-soft)]">&copy; <?php echo esc_html(date('Y')); ?> <?php echo esc_html(futuristic_it_t('custom_footer_copyright')); ?></p>
            </div>
        <?php endif; ?>
    </div>
</footer>

<!-- Floating contact buttons + Back to Top (shared fixed dock) -->
<div class="fc-dock <?php echo esc_attr(futuristic_it_floating_dock_class()); ?>" style="<?php echo esc_attr(futuristic_it_floating_dock_style()); ?>">
    <button type="button" id="back-to-top">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 15l-6-6-6 6"/></svg>
    </button>
    <?php futuristic_it_render_floating_buttons(); ?>
</div>

<script>
    (function() {
        var btn = document.getElementById('back-to-top');
        if (!btn) return;
        window.addEventListener('scroll', function() {
            btn.classList.toggle('is-visible', window.pageYOffset > 300);
        });
        btn.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    })();
</script>

    <?php wp_footer(); ?>
</body>
</html>
