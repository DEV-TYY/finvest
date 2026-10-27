<?php
/**
 * Template Name: Services
 */

get_header();

$hero_img = get_option('services_hero_image', '');
$raw_services = get_option('custom_service_cards', '[]');
$custom_services = json_decode($raw_services, true);
if (!is_array($custom_services)) $custom_services = array();
$stats = json_decode(get_option('custom_services_stats', '[]'), true);
if (!is_array($stats)) $stats = array();
?>

<main>
    <!-- 1. HERO -->
    <section class="relative bg-[var(--dark-green)] text-white flex items-center mb-[50px] bg-cover bg-center max-md:py-[100px] max-md:pb-[60px] max-md:min-h-[50vh] max-md:h-auto max-[576px]:py-20 max-[576px]:pb-10" style="padding:160px 0;height:85vh;<?php echo !empty($hero_img) ? 'background-image: linear-gradient(135deg, rgba(20,46,31,0.8) 0%, rgba(20,46,31,0.5) 100%), url(' . esc_url($hero_img) . ');' : ''; ?>">
        <div class="container">
            <div class="max-w-[700px] relative z-[1] max-md:max-w-full">
                <span class="inline-block text-xs sm:text-sm font-bold mb-[18px] rounded py-1.5 px-3.5 text-[var(--gold)] bg-[rgba(212,168,67,0.15)]" data-anim="fade-down"><?php echo esc_html(futuristic_it_t('custom_services_hero_tagline')); ?></span>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-[22px] leading-[1.15] text-white" data-anim="fade-up" data-anim-delay="100"><?php echo wp_kses(futuristic_it_t('custom_services_hero_title'), array('em' => array())); ?></h1>
                <p class="text-sm sm:text-base lg:text-lg mb-[34px] max-w-[560px] leading-[1.8] text-[var(--text-on-dark-soft)]" data-anim="fade-up" data-anim-delay="200"><?php echo esc_html(futuristic_it_t('custom_services_hero_subtitle')); ?></p>
            </div>
        </div>
    </section>

    <!-- 2. SERVICE CARDS -->
    <?php if (!empty(get_option('custom_services_cards_title')) || !empty($custom_services)) : ?>
    <section class="section py-[90px] px-0 bg-[var(--cream)]" id="services-grid">
        <div class="container">
            <?php if (!empty(futuristic_it_t('custom_services_cards_tagline'))) : ?>
                <span class="section-eyebrow" data-anim="fade-up"><?php echo esc_html(futuristic_it_t('custom_services_cards_tagline')); ?></span>
            <?php endif; ?>
            <?php if (!empty(futuristic_it_t('custom_services_cards_title'))) : ?>
                <h2 class="section-title" data-anim="fade-up" data-anim-delay="100"><?php echo esc_html(futuristic_it_t('custom_services_cards_title')); ?></h2>
            <?php endif; ?>
            <?php if (!empty(futuristic_it_t('custom_services_cards_desc'))) : ?>
                <p class="section-subtitle" data-anim="fade-up" data-anim-delay="200"><?php echo esc_html(futuristic_it_t('custom_services_cards_desc')); ?></p>
            <?php endif; ?>

            <?php if (!empty($custom_services)) : ?>
            <div class="w-full grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-3 grid-cols-1 gap-5">
                <?php $s_idx = 0; $current_lang = futuristic_it_get_current_lang();
                foreach ($custom_services as $card) :
                    $svc_type = $card['type'] ?? 'Detail';
                    $features = isset($card['features']) && is_array($card['features']) ? $card['features'] : array();
                    $svc_key = 'svc_' . md5($card['title'] ?? '');
                    $has_courses = !empty($card['courses']) || ($svc_type === 'Course');
                    $has_details = !empty($features) || !empty($card['packages']) || !empty($card['sections']) || !empty($card['images']) || $has_courses;
                    $custom_link = $card['link'] ?? '';
                    // Checked before the custom-link branch on purpose: the
                    // Procurement card carries a link to the contact page, so
                    // without this the new detail page is unreachable from it.
                    $override = futuristic_it_service_detail_override($card['title'] ?? '');
                    if (!empty($override)) {
                        $svc_link = $override;
                    } elseif ($svc_type === 'Contact') {
                        $svc_link = (!empty($custom_link) && $custom_link !== '#') ? $custom_link : home_url('/contact/');
                    } elseif (!empty($custom_link) && $custom_link !== '#') {
                        $svc_link = $custom_link;
                    } else {
                        $svc_url = add_query_arg('service_key', $svc_key, home_url('/service-detail/'));
                        if ($svc_type === 'Course' || $has_courses) {
                            $svc_url .= '#related-courses';
                        }
                        $svc_link = $has_details ? $svc_url : '#';
                    }
                    $card_title = ($current_lang === 'km' && !empty($card['title_km'])) ? $card['title_km'] : ($card['title'] ?? '');
                    $card_desc = ($current_lang === 'km' && !empty($card['desc_km'])) ? $card['desc_km'] : ($card['desc'] ?? '');
                    $card_link_text = ($current_lang === 'km' && !empty($card['link_text_km'])) ? $card['link_text_km'] : ($card['link_text'] ?? 'Learn More');
                ?>
                <div class="service-detail-card bg-white border border-black/6 rounded-2xl text-left transition-all duration-[0.4s] relative overflow-hidden flex flex-col" data-anim="scale-up" data-anim-delay="<?php echo ($s_idx * 100); ?>">
                    <?php if (!empty($card['image'])) : ?>
                        <div class="service-detail-icon w-full h-[200px] flex items-center justify-center overflow-hidden" style="background:linear-gradient(135deg, var(--cream, #f7f6f1) 0%, #ede9e0 100%);"><img src="<?php echo esc_url($card['image']); ?>" alt="<?php echo esc_attr($card_title); ?>" class="w-full h-[200px] object-cover"></div>
                    <?php else : ?>
                        <div class="service-detail-icon w-full h-[200px] flex items-center justify-center overflow-hidden" style="background:linear-gradient(135deg, var(--cream, #f7f6f1) 0%, #ede9e0 100%);">●</div>
                    <?php endif; ?>
                    <div class="service-detail-body p-6 flex flex-col flex-1">
                        <h3 class="service-detail-title text-lg sm:text-xl font-bold m-0 mb-2.5 leading-[1.3] text-[var(--text-dark)]"><?php echo esc_html($card_title); ?></h3>
                        <p class="service-detail-desc text-sm sm:text-base leading-[1.65] m-0 text-[#6b7280]"><?php echo esc_html($card_desc); ?></p>
                        <?php if (!empty($features)) : ?>
                            <ul class="service-card-features list-none p-0 mb-[18px]">
                                <?php foreach ($features as $feat) :
                                    $feat_title = is_array($feat) ? ($feat['title'] ?? $feat['text'] ?? '') : $feat;
                                    if ($current_lang === 'km' && is_array($feat) && !empty($feat['title_km'])) {
                                        $feat_title = $feat['title_km'];
                                    }
                                ?>
                                <li class="flex items-center gap-2.5 py-1.5 text-sm sm:text-base text-[var(--text-body)]">
                                    <span class="check-icon w-5 h-5 rounded-full border-2 flex items-center justify-center text-xs shrink-0 border-[var(--dark-green)] text-[var(--dark-green)]">✓</span>
                                    <?php echo esc_html($feat_title); ?>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <div class="mt-auto pt-4">
                            <?php if ($svc_type === 'Contact') : ?>
                                <a href="<?php echo esc_url($svc_link); ?>" class="w-full btn btn-gold"><?php echo esc_html($card_link_text); ?> →</a>
                            <?php else : ?>
                                <a href="<?php echo esc_url($svc_link); ?>" class="text-dark-green hover:text-gold-dark duration-300 inline-flex items-center gap-1.5 font-bold text-sm sm:text-base"><?php echo esc_html($card_link_text); ?> →</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php $s_idx++; endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- 4. STATS SECTION -->
    <?php if (!empty(get_option('custom_services_stability_title')) || !empty($stats)) : ?>
    <section class="section section-dark">
        <div class="container">
            <div class="grid lg:grid-cols-2 grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                <div class="stability-content" data-anim="fade-right">
                    <span class="dependable-eyebrow"><?php echo esc_html(futuristic_it_t('custom_services_stability_tagline')); ?></span>
                    <h2><?php echo esc_html(futuristic_it_t('custom_services_stability_title')); ?></h2>
                    <?php if (!empty($stats)) : ?>
                        <?php $current_lang = futuristic_it_get_current_lang(); ?>
                        <div class="grid grid-cols-1">
                            <?php foreach ($stats as $stat) : ?>
                                <?php
                                $stat_label = ($current_lang === 'km' && !empty($stat['label_km'])) ? $stat['label_km'] : ($stat['label'] ?? '');
                                $stat_desc = ($current_lang === 'km' && !empty($stat['desc_km'])) ? $stat['desc_km'] : ($stat['desc'] ?? '');
                                ?>
                                <div class="stat-item">
                                    <?php if (!empty($stat['icon'])) : ?>
                                        <div class="stat-icon"><img src="<?php echo esc_url($stat['icon']); ?>" style="width:24px;height:24px;object-fit:contain;" alt=""></div>
                                    <?php else : ?>
                                        <div class="stat-icon">●</div>
                                    <?php endif; ?>
                                    <div class="stat-content">
                                        <div class="stat-label"><?php echo esc_html($stat_label); ?></div>
                                        <div class="stat-desc"><?php echo esc_html($stat_desc); ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="stability-image" data-anim="fade-left">
                    <?php $stability_img = get_option('custom_services_stability_image', ''); ?>
                    <?php if (!empty($stability_img)) : ?>
                        <div class="stability-image-frame">
                            <img src="<?php echo esc_url($stability_img); ?>" alt="Our Team">
                        </div>
                    <?php endif; ?>
                    <?php $badge_value = get_option('custom_services_badge_value', ''); ?>
                    <?php $badge_label = futuristic_it_t('custom_services_badge_label'); ?>
                    <?php if (!empty($badge_value)) : ?>
                        <div class="stability-badge">
                            <span class="badge-value"><?php echo esc_html($badge_value); ?></span>
                            <span class="badge-label"><?php echo esc_html($badge_label); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- 5. CTA SECTION -->
    <?php if (!empty(get_option('custom_services_cta_title'))) : ?>
    <section class="py-[100px] px-0 text-center bg-[var(--cream)] text-[var(--text-dark)]">
        <div class="container" data-anim="scale-up">
            <h2 class="text-2xl sm:text-3xl mb-[18px] font-bold text-[var(--dark-green)]"><?php echo esc_html(futuristic_it_t('custom_services_cta_title')); ?></h2>
            <p class="text-sm sm:text-base mb-9 max-w-[600px] mx-auto leading-7 text-[var(--text-gray)]"><?php echo esc_html(futuristic_it_t('custom_services_cta_desc')); ?></p>
            <a href="<?php echo esc_url(get_option('custom_services_cta_btn_link', '#')); ?>" class="btn btn-gold"><?php echo esc_html(futuristic_it_t('custom_services_cta_btn_text')); ?></a>
        </div>
    </section>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
