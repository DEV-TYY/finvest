<?php
/**
 * Template Name: Service Detail
 */

$service_key = isset($_GET['service_key']) ? sanitize_text_field($_GET['service_key']) : '';
$service = null;

if ($service_key) {
    $raw = get_option('custom_service_cards', '[]');
    $cards = json_decode($raw, true);
    if (is_array($cards)) {
        foreach ($cards as $card) {
            if (('svc_' . md5($card['title'] ?? '')) === $service_key) {
                $service = $card;
                break;
            }
        }
    }
}

if (!$service) {
    get_header();
    echo '<main><div class="container" style="padding:100px 0;text-align:center;"><h1>Service not found</h1><a href="' . esc_url(home_url('/our-service/')) . '" class="btn btn-gold">Back to Services</a></div></main>';
    get_footer();
    return;
}

get_header();

$current_lang = futuristic_it_get_current_lang();

// Apply Khmer translations to service data
if ($current_lang === 'km') {
    if (!empty($service['title_km'])) $service['title'] = $service['title_km'];
    if (!empty($service['desc_km'])) $service['desc'] = $service['desc_km'];
    if (!empty($service['features_title_km'])) $service['features_title'] = $service['features_title_km'];
    if (!empty($service['features_desc_km'])) $service['features_desc'] = $service['features_desc_km'];
    if (!empty($service['packages_title_km'])) $service['packages_title'] = $service['packages_title_km'];
    if (!empty($service['packages_desc_km'])) $service['packages_desc'] = $service['packages_desc_km'];
    if (!empty($service['course_main_title_kh'])) $service['course_main_title_en'] = $service['course_main_title_kh'];
    if (!empty($service['course_main_description_kh'])) $service['course_main_description_en'] = $service['course_main_description_kh'];
    if (!empty($service['why_learn_title_km'])) $service['why_learn_title'] = $service['why_learn_title_km'];
    if (!empty($service['why_learn_cta_title_km'])) $service['why_learn_cta_title'] = $service['why_learn_cta_title_km'];
    if (!empty($service['why_learn_cta_desc_km'])) $service['why_learn_cta_desc'] = $service['why_learn_cta_desc_km'];
    if (!empty($service['why_learn_cta_btn_text_km'])) $service['why_learn_cta_btn_text'] = $service['why_learn_cta_btn_text_km'];
    if (!empty($service['faq_title_km'])) $service['faq_title'] = $service['faq_title_km'];
    if (!empty($service['faq_subtitle_km'])) $service['faq_subtitle'] = $service['faq_subtitle_km'];
    if (!empty($service['faqs']) && is_array($service['faqs'])) {
        foreach ($service['faqs'] as &$fq) {
            if (!empty($fq['q_km'])) $fq['q'] = $fq['q_km'];
            if (!empty($fq['a_km'])) $fq['a'] = $fq['a_km'];
        }
        unset($fq);
    }
    if (!empty($service['why_learn']) && is_array($service['why_learn'])) {
        foreach ($service['why_learn'] as &$wl) {
            if (!empty($wl['title_km'])) $wl['title'] = $wl['title_km'];
            if (!empty($wl['desc_km'])) $wl['desc'] = $wl['desc_km'];
        }
        unset($wl);
    }
    if (!empty($service['courses'])) {
        foreach ($service['courses'] as &$crs) {
            if (!empty($crs['title_kh'])) $crs['title_en'] = $crs['title_kh'];
            elseif (!empty($crs['title_km'])) $crs['title_en'] = $crs['title_km'];
            if (!empty($crs['instructor_km'])) $crs['instructor'] = $crs['instructor_km'];
            if (!empty($crs['badge_km'])) $crs['badge'] = $crs['badge_km'];
            if (!empty($crs['description_kh'])) $crs['description_en'] = $crs['description_kh'];
            elseif (!empty($crs['description_km'])) $crs['description_en'] = $crs['description_km'];
            if (!empty($crs['audience_km'])) $crs['audience'] = $crs['audience_km'];
            if (!empty($crs['audience_title_km'])) $crs['audience_title'] = $crs['audience_title_km'];
            if (!empty($crs['features_km'])) $crs['features'] = $crs['features_km'];
            if (!empty($crs['features_title_km'])) $crs['features_title'] = $crs['features_title_km'];
            if (!empty($crs['feature_text_km'])) $crs['feature_text'] = $crs['feature_text_km'];
            if (!empty($crs['btn_text_km'])) $crs['btn_text'] = $crs['btn_text_km'];
        }
        unset($crs);
    }

    // Translate packages
    $packages_raw = $service['packages'] ?? array();
    $packages = array();
    foreach ($packages_raw as $pkg) {
        $p = $pkg;
        if (!empty($p['title_km'])) $p['title'] = $p['title_km'];
        if (!empty($p['badge_km'])) $p['badge'] = $p['badge_km'];
        if (!empty($p['btn_text_km'])) $p['btn_text'] = $p['btn_text_km'];
        if (!empty($p['features_km']) && is_array($p['features_km'])) $p['features'] = $p['features_km'];
        $packages[] = $p;
    }

    // Translate sections
    $sections_raw = $service['sections'] ?? array();
    $detail_sections = array();
    foreach ($sections_raw as $sec) {
        $s = $sec;
        if (!empty($s['title_km'])) $s['title'] = $s['title_km'];
        if (!empty($s['desc_km'])) $s['desc'] = $s['desc_km'];
        if (!empty($s['items']) && is_array($s['items'])) {
            $translated_items = array();
            foreach ($s['items'] as $item) {
                $i = $item;
                if (!empty($i['title_km'])) $i['title'] = $i['title_km'];
                if (!empty($i['desc_km'])) $i['desc'] = $i['desc_km'];
                $translated_items[] = $i;
            }
            $s['items'] = $translated_items;
        }
        $detail_sections[] = $s;
    }
} else {
    $packages = $service['packages'] ?? array();
    $detail_sections = $service['sections'] ?? array();
}

$features_text = futuristic_it_service_features_text($service);
if ($current_lang === 'km') {
    $km_text = futuristic_it_service_features_text_km($service);
    if (trim($km_text) !== '') $features_text = $km_text;
}

$images = $service['images'] ?? array();$image_list = array();
for ($i = 1; $i <= 6; $i++) {
    if (!empty($images[$i])) $image_list[] = $images[$i];
}
if (empty($image_list) && !empty($service['image'])) $image_list[] = $service['image'];

$is_short_course = stripos($service['title'] ?? '', 'short course') !== false;

?>
<main>
    <?php if ($is_short_course) :
        $hero_tagline   = futuristic_it_t('custom_services_hero_tagline');
        $hero_title     = futuristic_it_t('custom_services_hero_title');
        $hero_subtitle  = futuristic_it_t('custom_services_hero_subtitle');
        $hero_btn_text  = futuristic_it_t('custom_services_hero_btn_text');
        if (!empty($hero_title)) :
    ?>
    <section class="py-[90px] bg-dark-green max-md:py-[60px] max-[576px]:py-[50px]">
        <div class="container">
            <div class="flex flex-wrap gap-[60px] items-start max-lg:gap-[40px] max-md:gap-[36px]">
                <div class="flex-1 min-w-[320px] max-md:min-w-full">
                    <?php if (!empty($hero_tagline)) : ?>
                        <span class="inline-block text-xs sm:text-sm font-bold mb-[22px] rounded-full py-1.5 px-4 text-[var(--gold-dark)] bg-[rgba(212,168,67,0.12)] border border-[rgba(212,168,67,0.35)]" data-anim="fade-down"><?php echo esc_html($hero_tagline); ?></span>
                    <?php endif; ?>

                    <h1 class="text-3xl sm:text-4xl md:text-[42px] font-bold mb-[26px] leading-[1.2] text-gold-dark max-w-[620px]" data-anim="fade-up" data-anim-delay="100"><?php echo esc_html($hero_title); ?></h1>

                    <?php if (!empty($hero_subtitle)) : ?>
                        <p class="text-sm sm:text-base leading-[1.9] text-white max-w-[600px] mb-[36px]" data-anim="fade-up" data-anim-delay="200"><?php echo esc_html($hero_subtitle); ?></p>
                    <?php endif; ?>

                    <?php if (!empty($hero_btn_text)) :
                        $hero_btn_url = futuristic_it_get_contact_url();
                    ?>
                        <a href="<?php echo esc_url($hero_btn_url); ?>" class="btn btn-gold" data-anim="fade-up" data-anim-delay="300">
                            <?php echo esc_html($hero_btn_text); ?>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </a>
                    <?php endif; ?>
                </div>

                <?php if (!empty($image_list)) : ?>
                <div class="flex-1 min-w-[320px] max-md:min-w-full" data-anim="fade-up" data-anim-delay="200">
                    <img src="<?php echo esc_url($image_list[0]); ?>" alt="<?php echo esc_attr($service['title']); ?>" class="w-full h-[380px] max-md:h-[280px] object-cover rounded-[var(--radius)] bg-[var(--cream-dark)]">
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; endif; ?>

    <?php if (!empty($image_list) || !empty($features_text)) : ?>
    <section class="section pt-[50px]">
        <div class="container">
            <?php if (!empty($service['features_title'])) : ?>
                <h2 class="section-title text-center" data-anim="fade-up"><?php echo esc_html($service['features_title']); ?></h2>
            <?php endif; ?>
            <?php if (!empty($service['features_desc'])) : ?>
                <p class="section-subtitle text-center" data-anim="fade-up" data-anim-delay="100"><?php echo esc_html($service['features_desc']); ?></p>
            <?php endif; ?>

            <div class="service-detail-wrapper grid grid-cols-1 md:grid-cols-2 gap-[60px] mb-[60px] max-md:flex max-md:flex-col max-md:gap-[30px]">
                <?php if (!empty($image_list)) : ?>
                <div class="grid gap-4" data-anim="fade-right">
                    <img src="<?php echo esc_url($image_list[0]); ?>" alt="<?php echo esc_attr($service['title']); ?>" class="service-main-image w-full h-[420px] max-md:h-[320px] max-[576px]:h-[260px] object-cover rounded-[var(--radius)] bg-[var(--cream-dark)]" id="mainServiceImage">
                    <?php if (count($image_list) > 1) : ?>
                    <div class="service-thumbnails grid grid-cols-5 max-[576px]:grid-cols-3 gap-2.5">
                        <?php foreach ($image_list as $idx => $img) : ?>
                            <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($service['title']); ?> <?php echo $idx + 1; ?>" class="service-thumbnail w-full h-16 object-cover rounded-[var(--radius-sm)] cursor-pointer opacity-60 border-2 border-transparent transition-all duration-[0.25s] hover:opacity-100 hover:border-[var(--gold)] <?php echo $idx === 0 ? 'opacity-100 border-[var(--gold)]' : ''; ?>" onclick="changeServiceImage(this)">
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <?php if (!empty($features_text)) : ?>
                <div class="py-2.5" data-anim="fade-left">
                    <h2 class="text-2xl sm:text-3xl text-[var(--text-dark)] mb-[22px]"><?php echo esc_html($service['title']); ?></h2>
                    <ul class="list-none p-0 mb-[26px]">
                        <?php foreach (explode("\n", $features_text) as $line) :
                            if (trim($line) === '') continue;
                            $parts = explode(':', $line, 2);
                        ?>
                            <li class="py-2.5 border-b border-[var(--border-color)] text-sm sm:text-base text-[var(--text-body)]">
                                <?php if (count($parts) === 2) : ?>
                                    <strong class="text-[var(--text-dark)] font-bold"><?php echo esc_html(trim($parts[0])); ?>:</strong> <?php echo esc_html(trim($parts[1])); ?>
                                <?php else : ?>
                                    <?php echo esc_html(trim($line)); ?>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>


    <?php  if (($service['type']) === 'Course' && !empty($service['courses'])) : ?>
        <!-- RELATED COURSES / TRAINING SECTION -->
        <section class="section bg-white" id="related-courses">
            <div class="container">
                <?php
                $course_main_title = $service['course_main_title_en'] ?? '';
                $course_main_desc = $service['course_main_description_en'] ?? '';
                if (!empty($course_main_title) || !empty($course_main_desc)) :
                ?>
                <div class="courses-header" style="text-align:center;margin-bottom:40px;" data-anim="fade-up">
                    <?php if (!empty($course_main_title)) : ?>
                        <h2 style="font-size:1.75rem;font-weight:800;color:var(--text-dark);margin-bottom:12px;"><?php echo esc_html($course_main_title); ?></h2>
                    <?php endif; ?>
                    <?php if (!empty($course_main_desc)) : ?>
                        <p style="font-size:1rem;color:var(--text-gray);max-width:700px;margin:0 auto;line-height:1.7;"><?php echo esc_html($course_main_desc); ?></p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                <?php
                $course_badges = array();
                foreach ($service['courses'] as $crs) {
                    $badge = strtolower(trim($crs['badge'] ?? ''));
                    if (!empty($badge) && !in_array($badge, $course_badges)) {
                        $course_badges[] = $badge;
                    }
                }
                if (count($course_badges) > 1) :
                ?>
                <div class="course-filter-tabs" style="display:flex;gap:10px;justify-content:center;margin-bottom:30px;flex-wrap:wrap;" data-anim="fade-up" data-anim-delay="150">
                    <button class="course-filter-tab active" data-filter="all" style="padding:8px 20px;border-radius:20px;border:1.5px solid var(--dark-green);background:var(--dark-green);color:#fff;font-size:0.875rem;font-weight:600;cursor:pointer;transition:all 0.3s;">All</button>
                    <?php foreach ($course_badges as $badge) : ?>
                    <button class="course-filter-tab" data-filter="<?php echo esc_attr($badge); ?>" style="padding:8px 20px;border-radius:20px;border:1.5px solid var(--border-color);background:#fff;color:var(--text-dark);font-size:0.875rem;font-weight:600;cursor:pointer;transition:all 0.3s;"><?php echo esc_html(ucfirst($badge)); ?></button>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                <div class="courses-carousel relative" id="coursesCarousel">
                    <div class="courses-track w-full flex gap-0 sm:gap-5 scroll-snap-x snap-x snap-mandatory" id="coursesTrack">
                    <?php foreach ($service['courses'] as $ci => $crs) : ?>
                    <div class="courses-card min-w-full sm:min-w-[calc(25%-15px)] max-w-full sm:max-w-[calc(25%-15px)] snap-start flex-shrink-0" data-course-index="<?php echo $ci; ?>" data-badge="<?php echo esc_attr(strtolower(trim($crs['badge'] ?? ''))); ?>">
                        <div class="courses-card-image">
                            <img src="<?php echo esc_url($crs['image'] ?? ''); ?>" alt="<?php echo esc_attr($crs['title_en'] ?? $crs['title'] ?? ''); ?>">
                        </div>
                        <div class="courses-card-body">
                            <h3 class="courses-card-title"><?php echo esc_html($crs['title_en'] ?? $crs['title'] ?? ''); ?></h3>
                            <p class="courses-card-instructor"><?php echo esc_html($crs['instructor'] ?? ''); ?></p>
                            <div class="courses-card-rating">
                                <?php if (!empty($crs['badge'])) : ?>
                                <span class="courses-badge <?php echo strtolower($crs['badge']) === 'bestseller' ? 'courses-badge-bestseller' : 'courses-badge-premium'; ?>"><?php echo esc_html($crs['badge']); ?></span>
                                <?php endif; ?>
                                <?php if (!empty($crs['updated'])) : ?>
                                <span style="font-size:0.75rem;color:var(--text-gray);">Updated <?php echo esc_html($crs['updated']); ?></span>
                                <?php endif; ?>
                            </div>
                            <?php
                            $meta_parts = array();
                            if (!empty($crs['hours'])) $meta_parts[] = esc_html($crs['hours']) . ' total hours';
                            if (!empty($crs['level'])) $meta_parts[] = esc_html($crs['level']);
                            if (!empty($crs['subtitles'])) $meta_parts[] = esc_html($crs['subtitles']);
                            if (!empty($meta_parts)) : ?>
                            <p style="font-size:0.75rem;color:var(--text-gray);margin-bottom:8px;"><?php echo implode(' · ', $meta_parts); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($crs['rating'])) : ?>
                            <div>
                                <span class="courses-stars" style="font-size:0.875rem;font-weight:700;">★ <?php echo esc_html($crs['rating']); ?></span>
                                <?php if (!empty($crs['reviews'])) : ?>
                                <span style="font-size:0.75rem;color:var(--text-gray);">(<?php echo esc_html($crs['reviews']); ?>)</span>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                            <div class="courses-card-price" style="font-size:1.25rem;font-weight:800;">$<?php echo esc_html($crs['price'] ?? ''); ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    </div>
                    <button class="courses-nav-btn courses-nav-prev flex" id="coursesPrev" aria-label="Previous">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                    </button>
                    <button class="courses-nav-btn courses-nav-next flex" id="coursesNext" aria-label="Next">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </button>
                </div>
                <!-- Course Detail Panel (appears below carousel on card click) -->
                <div class="course-detail-wrapper" id="courseDetailWrapper">
                    <div class="course-detail-arrow" id="courseDetailArrow"></div>
                    <div class="course-detail-panel" id="courseDetailPanel">
                        <div class="container">
                            <div class="course-detail-inner">
                                <button class="course-detail-close" id="courseDetailClose" aria-label="Close">✕</button>
                                <div class="course-detail-info">
                                    <h3 class="course-detail-title" id="courseDetailTitle"></h3>
                                    <p class="course-detail-instructor" id="courseDetailInstructor"></p>
                                    <div class="course-detail-rating" id="courseDetailRating"></div>
                                    <div class="course-detail-meta" id="courseDetailMeta"></div>
                                    <p class="course-detail-desc" id="courseDetailDesc"></p>
                                    <div class="course-detail-audience" id="courseDetailAudience" hidden>
                                        <p class="course-detail-audience-title" id="courseDetailAudienceTitle"><?php echo esc_html($current_lang === 'km' ? 'អ្នកដែលសមស្រប' : 'Who this course is for'); ?></p>
                                        <ul class="course-detail-audience-list" id="courseDetailAudienceList"></ul>
                                    </div>
                                    <div class="course-detail-feature-text" id="courseDetailFeatureText" hidden></div>
                                    <div class="course-detail-learn" id="courseDetailLearn" hidden>
                                        <p class="course-detail-learn-title" id="courseDetailLearnTitle"><?php echo esc_html($current_lang === 'km' ? 'អ្វីដែលអ្នកនឹងរៀន' : "What you'll learn"); ?></p>
                                        <ul class="course-detail-features" id="courseDetailFeatures"></ul>
                                    </div>
                                    <a href="<?php echo esc_url(futuristic_it_get_contact_url()); ?>" class="btn btn-gold course-detail-btn" id="courseDetailBtn" data-register-url="<?php echo esc_url(futuristic_it_get_contact_url()); ?>">Add to cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <!-- Course data for JS -->
    <script>
    var courseData = <?php echo wp_json_encode($service['courses'] ?? array()); ?>;
    // Title of this service as the contact form lists it, already resolved to
    // the current language, so a Register click can preselect it there.
    var courseServiceTitle = <?php echo wp_json_encode($service['title'] ?? ''); ?>;
    </script>

    <?php endif; ?>

    <?php
    // "Why Learn With Us" — dark section under the course cards. Gated on the
    // Course type so stale data on a service later switched to Default cannot
    // render an orphan section.
    $why_items = ($service['type'] ?? '') === 'Course' && isset($service['why_learn']) && is_array($service['why_learn']) ? $service['why_learn'] : array();
    // Drop rows that are empty after translation, so a blank admin row never
    // renders an empty card.
    $why_items = array_values(array_filter($why_items, function($w) {
        return trim($w['title'] ?? '') !== '' || trim($w['desc'] ?? '') !== '';
    }));
    // The group-training banner shares this section, so it renders when either
    // the cards or the banner have content.
    $why_cta_has_content = trim($service['why_learn_cta_title'] ?? '') !== '' || trim($service['why_learn_cta_desc'] ?? '') !== '';
    if (!empty($why_items) || $why_cta_has_content) :
    ?>
    <section class="section why-learn-section" id="why-learn">
        <div class="container">
            <?php if (!empty($service['why_learn_title'])) : ?>
                <h2 class="why-learn-title" data-anim="fade-up"><?php echo esc_html($service['why_learn_title']); ?></h2>
            <?php endif; ?>
            <?php if (!empty($why_items)) : ?>
            <div class="why-learn-grid" data-anim="fade-up" data-anim-delay="120">
                <?php foreach ($why_items as $w) : ?>
                <div class="why-learn-card">
                    <span class="why-learn-icon why-learn-icon-<?php echo esc_attr(futuristic_it_why_learn_icon_name($w['icon'] ?? 'instructor')); ?>">
                        <?php
                        // Icon is an inline SVG built from a fixed allow-list in PHP,
                        // so this is safe to echo unescaped.
                        echo futuristic_it_why_learn_icon($w['icon'] ?? 'instructor');
                        ?>
                    </span>
                    <div class="why-learn-body">
                        <?php if (trim($w['title'] ?? '') !== '') : ?>
                            <h3 class="why-learn-card-title"><?php echo esc_html($w['title']); ?></h3>
                        <?php endif; ?>
                        <?php if (trim($w['desc'] ?? '') !== '') : ?>
                            <p class="why-learn-card-desc"><?php echo esc_html($w['desc']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <?php if ($why_cta_has_content) : ?>
            <div class="why-learn-cta" data-anim="fade-up" data-anim-delay="180">
                <div class="why-learn-cta-text">
                    <?php if (trim($service['why_learn_cta_title'] ?? '') !== '') : ?>
                        <h3 class="why-learn-cta-title"><?php echo esc_html($service['why_learn_cta_title']); ?></h3>
                    <?php endif; ?>
                    <?php if (trim($service['why_learn_cta_desc'] ?? '') !== '') : ?>
                        <p class="why-learn-cta-desc"><?php echo esc_html($service['why_learn_cta_desc']); ?></p>
                    <?php endif; ?>
                </div>
                <?php
                $cta_btn_text = trim($service['why_learn_cta_btn_text'] ?? '');
                // Fall back to the contact page so the button is never a dead link.
                $cta_btn_link = trim($service['why_learn_cta_btn_link'] ?? '');
                if ($cta_btn_link === '') $cta_btn_link = home_url('/contact/');
                if ($cta_btn_text !== '') :
                ?>
                    <a href="<?php echo esc_url($cta_btn_link); ?>" class="btn btn-outline why-learn-cta-btn"><?php echo esc_html($cta_btn_text); ?></a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php
    // FAQ — light section under the group-training banner. Same .faq-* hooks as
    // the contact page so the shared accordion handler in js/main.js drives it.
    $faq_items = ($service['type'] ?? '') === 'Course' && isset($service['faqs']) && is_array($service['faqs']) ? $service['faqs'] : array();
    $faq_items = array_values(array_filter($faq_items, function($f) {
        return trim($f['q'] ?? '') !== '';
    }));
    if (!empty($faq_items)) :
    ?>
    <section class="section faq-section-service" id="service-faq">
        <div class="container">
            <?php if (!empty($service['faq_title'])) : ?>
                <h2 class="section-title faq-service-title" data-anim="fade-up"><?php echo esc_html($service['faq_title']); ?></h2>
                <span class="faq-service-rule" aria-hidden="true"></span>
            <?php endif; ?>
            <?php if (!empty($service['faq_subtitle'])) : ?>
                <p class="section-subtitle" data-anim="fade-up"><?php echo esc_html($service['faq_subtitle']); ?></p>
            <?php endif; ?>
            <div class="faq-container" data-anim="fade-up" data-anim-delay="120">
                <?php foreach ($faq_items as $fq) : ?>
                <div class="faq-item">
                    <div class="faq-question">
                        <span class="faq-question-text"><?php echo esc_html($fq['q'] ?? ''); ?></span>
                        <span class="faq-toggle" aria-hidden="true"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></span>
                    </div>
                    <div class="faq-answer">
                        <p><?php echo esc_html($fq['a'] ?? ''); ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php
    $stats = json_decode(get_option('custom_services_stats', '[]'), true);
    if (!is_array($stats)) $stats = array();
    ?>

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

    <?php
    $cta_title = get_option('custom_services_cta_title');
    if (!empty($cta_title) && !$is_short_course) :
    ?>
    <section class="py-[100px] px-0 text-center bg-[var(--cream)] text-[var(--text-dark)]">
        <div class="container" data-anim="scale-up">
            <h2 class="text-2xl sm:text-3xl mb-[18px] font-bold text-[var(--dark-green)]"><?php echo esc_html(futuristic_it_t('custom_services_cta_title')); ?></h2>
            <p class="text-sm sm:text-base mb-9 max-w-[600px] mx-auto leading-7 text-[var(--text-gray)]"><?php echo esc_html(futuristic_it_t('custom_services_cta_desc')); ?></p>
            <a href="<?php echo esc_url(get_option('custom_services_cta_btn_link', '#')); ?>" class="btn btn-gold"><?php echo esc_html(futuristic_it_t('custom_services_cta_btn_text')); ?></a>
        </div>
    </section>
    <?php endif; ?>

    <script>
    (function(){
        var track = document.getElementById('coursesTrack');
        var carousel = document.getElementById('coursesCarousel');
        var prevBtn = document.getElementById('coursesPrev');
        var nextBtn = document.getElementById('coursesNext');
        if (!track || !prevBtn || !nextBtn) return;

        var cards = track.querySelectorAll('.courses-card');
        var cardCount = cards.length;
        if (cardCount === 0) return;

        // Course filter tabs
        var filterTabs = document.querySelectorAll('.course-filter-tab');
        filterTabs.forEach(function(tab) {
            tab.addEventListener('click', function() {
                var filter = this.getAttribute('data-filter');

                // Update active tab
                filterTabs.forEach(function(t) {
                    t.style.background = '#fff';
                    t.style.color = 'var(--text-dark)';
                    t.style.borderColor = 'var(--border-color)';
                });
                this.style.background = 'var(--dark-green)';
                this.style.color = '#fff';
                this.style.borderColor = 'var(--dark-green)';

                // Filter cards
                cards.forEach(function(card) {
                    var badge = card.getAttribute('data-badge');
                    if (filter === 'all' || badge === filter) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Reset scroll
                track.scrollLeft = 0;

                // Update button visibility
                updateButtons();
            });
        });

        function getVisibleCards() {
            return window.innerWidth < 640 ? 1 : 4;
        }

        // Course detail panel
        var panel = document.getElementById('courseDetailPanel');
        var panelWrapper = document.getElementById('courseDetailWrapper');
        var detailArrow = document.getElementById('courseDetailArrow');
        var panelClose = document.getElementById('courseDetailClose');
        var panelTitle = document.getElementById('courseDetailTitle');
        var panelInstructor = document.getElementById('courseDetailInstructor');
        var panelRating = document.getElementById('courseDetailRating');
        var panelMeta = document.getElementById('courseDetailMeta');
        var panelDesc = document.getElementById('courseDetailDesc');
        var panelAudience = document.getElementById('courseDetailAudience');
        var panelAudienceTitle = document.getElementById('courseDetailAudienceTitle');
        var panelAudienceList = document.getElementById('courseDetailAudienceList');
        // Server-rendered default heading (already localised) — used when a course
        // has no custom heading of its own.
        var defaultAudienceTitle = panelAudienceTitle ? panelAudienceTitle.textContent : '';
        var panelLearn = document.getElementById('courseDetailLearn');
        var panelLearnTitle = document.getElementById('courseDetailLearnTitle');
        var panelFeatures = document.getElementById('courseDetailFeatures');
        var panelFeatureText = document.getElementById('courseDetailFeatureText');
        // Server-rendered default heading (already localised) — used when a course
        // has no custom features heading of its own.
        var defaultLearnTitle = panelLearnTitle ? panelLearnTitle.textContent : '';
        var panelBtn = document.getElementById('courseDetailBtn');

        // Course button links are one language-neutral URL. The admin save
        // sanitises them, but this side must not rely on that alone: a value
        // edited straight into the database would otherwise be able to turn
        // this anchor into a script vector.
        function safeCourseLink(url) {
            var raw = String(url == null ? '' : url).trim();
            if (raw === '') return '';
            // Browsers ignore control characters and whitespace inside a
            // scheme, so "java\tscript:" still runs — strip them before the
            // test rather than trusting the raw spelling.
            var probe = raw.replace(/[\u0000- ]/g, '').toLowerCase();
            if (/^(?:javascript|data|vbscript):/.test(probe)) return '';
            return raw;
        }

        // The contact page reads ?svc= and ?course= to preselect its two
        // dropdowns. The names avoid "service", which is the public query var
        // of the `service` post type — using it would send WordPress looking
        // for a CPT post and 404 the contact page.
        function buildRegisterUrl(crs) {
            var base = panelBtn.getAttribute('data-register-url') || '';
            if (base === '') return '#';
            var title = crs ? (crs.title_en || crs.title || '') : '';
            var params = [];
            if (courseServiceTitle) params.push('svc=' + encodeURIComponent(courseServiceTitle));
            if (title) params.push('course=' + encodeURIComponent(title));
            if (!params.length) return base;
            return base + (base.indexOf('?') === -1 ? '?' : '&') + params.join('&');
        }
        var activeCard = null;

        function positionArrow(card) {
            if (!card || !detailArrow) return;
            var cardRect = card.getBoundingClientRect();
            var carouselRect = carousel.getBoundingClientRect();
            // Hide arrow when the card scrolls out of the carousel viewport
            if (cardRect.right < carouselRect.left || cardRect.left > carouselRect.right) {
                detailArrow.style.opacity = '0';
                return;
            }
            var wrapperRect = panelWrapper.getBoundingClientRect();
            var centerX = cardRect.left + cardRect.width / 2 - wrapperRect.left;
            detailArrow.style.left = centerX + 'px';
            detailArrow.style.opacity = '';
        }

        // Animate the panel open to its exact content height, so tall panels
        // (feature text + What you'll learn) are never clipped by the CSS ceiling.
        function openPanel() {
            panel.style.maxHeight = 'none';
            var fullHeight = panel.scrollHeight;
            panel.style.maxHeight = '';
            // Force a reflow so the browser animates from 0 to fullHeight rather
            // than jumping straight to the measured value.
            void panel.offsetHeight;
            panel.style.maxHeight = fullHeight + 'px';
            panel.classList.add('active');
            panelWrapper.classList.add('active');
        }

        function closePanel() {
            // Clear the inline height so the CSS max-height:0 collapse still animates.
            panel.style.maxHeight = '';
            panel.classList.remove('active');
            panelWrapper.classList.remove('active');
        }

        cards.forEach(function(card) {
            card.addEventListener('click', function() {
                var idx = parseInt(card.getAttribute('data-course-index'));
                var crs = window.courseData ? window.courseData[idx] : null;
                if (!crs) return;

                // If same card clicked, close panel
                if (activeCard === card) {
                    closePanel();
                    card.classList.remove('selected');
                    activeCard = null;
                    return;
                }

                // Remove previous selection
                if (activeCard) activeCard.classList.remove('selected');
                activeCard = card;
                card.classList.add('selected');
                positionArrow(card);

                // Populate panel
                panelTitle.textContent = crs.title_en || crs.title || '';
                panelInstructor.textContent = crs.instructor || '';

                var ratingHtml = '';
                if (crs.badge) ratingHtml += '<span class="courses-badge ' + (crs.badge.toLowerCase() === 'bestseller' ? 'courses-badge-bestseller' : 'courses-badge-premium') + '">' + crs.badge + '</span>';
                if (crs.rating) ratingHtml += '<span class="courses-stars">★ ' + crs.rating + '</span>';
                if (crs.reviews) ratingHtml += '<span class="courses-rating-count">(' + crs.reviews + ')</span>';
                panelRating.innerHTML = ratingHtml;

                var metaParts = [];
                if (crs.hours) metaParts.push(crs.hours + ' total hours');
                if (crs.level) metaParts.push(crs.level);
                if (crs.subtitles) metaParts.push(crs.subtitles);
                if (crs.updated) metaParts.push('Updated ' + crs.updated);
                panelMeta.textContent = metaParts.join(' · ');

                panelDesc.textContent = crs.description_en || crs.description || '';

                // Target audience (one per line) — hidden when the course has none
                var audienceLines = (crs.audience || '').split('\n').filter(function(l){ return l.trim(); });
                panelAudienceList.innerHTML = '';
                if (audienceLines.length) {
                    // Per-course heading, falling back to the template default.
                    // Always assign so a course without a custom heading does not
                    // inherit the previous course's heading.
                    panelAudienceTitle.textContent = crs.audience_title || defaultAudienceTitle;
                    audienceLines.forEach(function(a) {
                        var li = document.createElement('li');
                        li.textContent = a.trim();
                        panelAudienceList.appendChild(li);
                    });
                    panelAudience.hidden = false;
                } else {
                    panelAudience.hidden = true;
                }

                // Feature text (free text, one paragraph per line) — sits directly
                // above "What you'll learn" and is hidden when the course has none.
                var featTextLines = (crs.feature_text || '').split('\n').filter(function(l){ return l.trim(); });
                panelFeatureText.innerHTML = '';
                if (featTextLines.length) {
                    featTextLines.forEach(function(t) {
                        var p = document.createElement('p');
                        p.className = 'course-detail-feature-text-line';
                        p.textContent = t.trim();
                        panelFeatureText.appendChild(p);
                    });
                    panelFeatureText.hidden = false;
                } else {
                    panelFeatureText.hidden = true;
                }

                // What you'll learn (one per line) — hidden when the course has none
                var featLines = (crs.features || '').split('\n').filter(function(l){ return l.trim(); });
                panelFeatures.innerHTML = '';
                if (featLines.length) {
                    // Always assign so a course without a custom heading does not
                    // inherit the previous course's heading.
                    panelLearnTitle.textContent = crs.features_title || defaultLearnTitle;
                    featLines.forEach(function(f) {
                        var li = document.createElement('li');
                        var mark = document.createElement('span');
                        mark.className = 'course-detail-check';
                        mark.setAttribute('aria-hidden', 'true');
                        var txt = document.createElement('span');
                        txt.className = 'course-detail-check-text';
                        txt.textContent = f.trim();
                        li.appendChild(mark);
                        li.appendChild(txt);
                        panelFeatures.appendChild(li);
                    });
                    panelLearn.hidden = false;
                } else {
                    panelLearn.hidden = true;
                }

                panelBtn.textContent = crs.btn_text || 'Add to cart';

                // A course may carry its own link; with none, the button
                // registers for this course by sending the visitor to the
                // contact page with the service and course preselected.
                // "#" counts as none — it is the theme's placeholder for an
                // unset link elsewhere, and as an href it goes nowhere.
                var courseLink = safeCourseLink(crs.btn_link);
                if (courseLink === '' || courseLink === '#') {
                    courseLink = buildRegisterUrl(crs);
                }
                panelBtn.setAttribute('href', courseLink);

                openPanel();
            });
        });

        if (panelClose) {
            panelClose.addEventListener('click', function() {
                closePanel();
                if (activeCard) activeCard.classList.remove('selected');
                activeCard = null;
            });
        }

        track.addEventListener('scroll', function() {
            if (activeCard) positionArrow(activeCard);
        });

        function getScrollAmount() {
            var visibleCards = getVisibleCards();
            var visibleCount = getVisibleCardCount();
            if (visibleCount <= visibleCards) return 0;
            var card = cards[0];
            var cardWidth = card.offsetWidth;
            var gap = window.innerWidth < 640 ? 0 : 20;
            return (cardWidth + gap) * visibleCards;
        }

        function getVisibleCardCount() {
            var count = 0;
            cards.forEach(function(card) {
                if (card.style.display !== 'none') count++;
            });
            return count;
        }

        function updateButtons() {
            var visibleCards = getVisibleCards();
            var visibleCount = getVisibleCardCount();
            if (visibleCount <= visibleCards) {
                prevBtn.style.display = 'none';
                nextBtn.style.display = 'none';
                return;
            }
            var maxScroll = track.scrollWidth - track.clientWidth;
            if (track.scrollLeft <= 5) {
                prevBtn.style.display = 'none';
            } else {
                prevBtn.style.display = 'flex';
            }
            if (track.scrollLeft >= maxScroll - 5) {
                nextBtn.style.display = 'none';
            } else {
                nextBtn.style.display = 'flex';
            }
        }

        nextBtn.addEventListener('click', function() {
            track.scrollBy({ left: getScrollAmount(), behavior: 'smooth' });
        });

        prevBtn.addEventListener('click', function() {
            track.scrollBy({ left: -getScrollAmount(), behavior: 'smooth' });
        });

        track.addEventListener('scroll', updateButtons);
        window.addEventListener('resize', updateButtons);

        // Re-measure on resize while open: text re-wraps and the panel height changes.
        window.addEventListener('resize', function() {
            if (panel.classList.contains('active')) {
                panel.style.maxHeight = 'none';
                var h = panel.scrollHeight;
                panel.style.maxHeight = '';
                panel.style.maxHeight = h + 'px';
            }
        });

        updateButtons();
    })();
    </script>
</main>

<script>
function changeServiceImage(thumb) {
    var main = document.getElementById('mainServiceImage');
    if (!main) return;
    document.querySelectorAll('.service-thumbnail').forEach(function (t) {
        t.classList.remove('opacity-100', 'border-[var(--gold)]');
    });
    thumb.classList.add('opacity-100', 'border-[var(--gold)]');
    main.src = thumb.src;
}
</script>

<?php get_footer(); ?>
