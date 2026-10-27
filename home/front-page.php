<?php
/**
 * Template Name: Front Page
 */

get_header();

$current_lang = futuristic_it_get_current_lang();

$tagline = futuristic_it_t('custom_hero_tagline');
$title_prefix = futuristic_it_t('custom_hero_title_prefix');
$title_suffix = futuristic_it_t('custom_hero_title_suffix');
$hero_desc = futuristic_it_t('custom_hero_desc');
$btn1_text = futuristic_it_t('custom_hero_btn_text');
$btn1_link = get_option('custom_hero_btn_link', '#');
$btn2_text = futuristic_it_t('custom_hero_btn2_text');
$btn2_link = get_option('custom_hero_btn2_link', '#');

$hero_slides = json_decode(get_option('custom_hero_slides', '[]'), true);
if (!is_array($hero_slides)) $hero_slides = array();

$keywords = array();
foreach ($hero_slides as $slide) {
    $kw = ($current_lang === 'km' && !empty($slide['title_highlight_km'])) ? $slide['title_highlight_km'] : ($slide['title_highlight'] ?? '');
    if ($kw !== '') $keywords[] = $kw;
}

$first = $hero_slides[0] ?? array();
$prefix_override = ($current_lang === 'km' && !empty($first['title_before_km'])) ? $first['title_before_km'] : ($first['title_before'] ?? '');
$suffix_override = ($current_lang === 'km' && !empty($first['title_after_km'])) ? $first['title_after_km'] : ($first['title_after'] ?? '');
$desc_override   = ($current_lang === 'km' && !empty($first['subtitle_km'])) ? $first['subtitle_km'] : ($first['subtitle'] ?? '');

if ($prefix_override !== '') $title_prefix = $prefix_override;
if ($suffix_override !== '') $title_suffix = $suffix_override;
if ($desc_override !== '')   $hero_desc = $desc_override;
?>

<main>
    <!-- ================= HERO ================= -->
    <section class="relative bg-[#083321] text-white overflow-hidden flex items-center lg:py-5 md:py-5 sm:py-5 py-4">
        <div class="container px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-[1fr_1.1fr] lg:grid-cols-[1fr_1.2fr] items-center">
                <!-- Hero Content -->
                <div class="relative z-[2] text-left" data-anim="fade-right" data-anim-delay="200">
                    <?php if (!empty($tagline)) : ?>
                    <span class="hero-eyebrow inline-flex items-center gap-2 text-xs sm:text-sm font-bold" data-anim="fade-up" data-anim-delay="400">
                        <span class="hero-eyebrow-dot"></span>
                        <?php echo esc_html($tagline); ?>
                    </span>
                    <?php endif; ?>

                    <h1 class="hero-title font-extrabold mb-4 sm:mb-5 md:mb-6 text-white leading-[1.4] tracking-tight text-3xl sm:text-4xl md:text-5xl lg:text-[3.5rem]" data-anim="fade-up" data-anim-delay="600">
                        <?php if ($title_prefix !== '') : ?><?php echo esc_html($title_prefix); ?><?php endif; ?><br>
                        <?php if ($current_lang === 'km') : ?>
                            <span class="inline items-center align-middle gap-2">
                            <?php if ($title_suffix !== '') : ?><?php echo esc_html($title_suffix); ?><?php endif; ?><br>
                            <?php if (!empty($keywords)) : ?>
                            <span class="hero-keyword-rotator" id="hero-keyword-rotator">
                                <?php foreach ($keywords as $ki => $kw) : ?>
                                <span class="accent hero-keyword"><?php echo esc_html($kw); ?></span>
                                <?php endforeach; ?>
                            </span>
                            <?php endif; ?>
                            </span>
                        <?php else : ?>
                            <span class="whitespace-nowrap inline-flex items-center align-middle gap-2">
                            <?php if (!empty($keywords)) : ?>
                            <span class="hero-keyword-rotator" id="hero-keyword-rotator">
                                <?php foreach ($keywords as $ki => $kw) : ?>
                                <span class="accent hero-keyword"><?php echo esc_html($kw); ?></span>
                                <?php endforeach; ?>
                            </span>
                            <?php endif; ?>
                            <?php if ($title_suffix !== '') : ?><?php echo esc_html($title_suffix); ?><?php endif; ?>
                            </span>
                        <?php endif; ?>
                    </h1>
                    <?php if ($hero_desc !== '') : ?>
                        <p class="text-sm lg:mt-8 mt-0 sm:text-base lg:text-lg mb-6 sm:mb-8 md:mb-10 text-white/85 max-w-[580px] leading-relaxed" data-anim="fade-up" data-anim-delay="800"><?php echo nl2br(esc_html($hero_desc)); ?></p>
                    <?php endif; ?>

                    <div class="mt-4 sm:mt-6 flex flex-col sm:flex-row gap-3 sm:gap-4 flex-wrap" data-anim="fade-up" data-anim-delay="1000">
                        <?php if (!empty($btn1_text)) : ?>
                        <a href="<?php echo esc_url($btn1_link); ?>" class="btn btn-gold w-full sm:w-auto text-center">
                            <?php echo esc_html($btn1_text); ?>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                        <?php endif; ?>
                        <?php if (!empty($btn2_text)) : ?>
                        <a href="<?php echo esc_url($btn2_link); ?>" class="btn btn-outline w-full sm:w-auto text-center">
                            <?php echo esc_html($btn2_text); ?>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Hero Image/Visual -->
                <?php $hero_svg = get_option('custom_hero_svg', ''); ?>
                <?php if (!empty($hero_svg)) : ?>
                <div class="relative flex items-center justify-center h-[280px] sm:h-[220px] md:h-[320px] lg:h-[400px] xl:h-[400px] 2xl:h-[500px] min-h-[180px]" data-anim="fade-left" data-anim-delay="400">
                    <img src="<?php echo esc_url($hero_svg); ?>" alt="Hero Image" class="max-w-full max-h-full w-auto h-auto object-contain">
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php if (count($keywords) > 1) : ?>
        <script>
        (function(){
            var container = document.getElementById('hero-keyword-rotator');
            if (!container) return;

            var words = <?php echo json_encode(array_values($keywords)); ?>;
            var total = words.length;
            if (total <= 1) return;

            var holdTime = 2500;
            var slideTime = 500;
            var current = 0;

            container.innerHTML = '';
            container.style.display = 'inline-block';
            container.style.verticalAlign = 'bottom';
            container.style.position = 'relative';
            container.style.overflow = 'visible';

            var box = document.createElement('span');
            box.style.display = 'block';
            box.style.position = 'relative';
            // box.style.overflow = 'hidden';
            container.appendChild(box);

            var items = [];
            words.forEach(function(txt, i) {
                var span = document.createElement('span');
                span.className = 'accent';
                span.textContent = txt;
                span.style.display = 'block';
                span.style.whiteSpace = 'nowrap';
                span.style.height = '1.4em';
                span.style.lineHeight = '1.4em';
                span.style.position = 'absolute';
                span.style.top = '0';
                span.style.left = '0';
                span.style.opacity = i === 0 ? '1' : '0';
                span.style.transform = i === 0 ? 'translateY(0)' : 'translateY(100%)';
                box.appendChild(span);
                items.push(span);
            });

            function fitWidth(idx) {
                var w = items[idx];
                box.style.height = '1.4em';
                box.style.width = w.scrollWidth + 'px';
                box.style.transition = 'width ' + slideTime + 'ms cubic-bezier(0.4,0,0.2,1)';
            }

            fitWidth(0);

            function slide() {
                var out = items[current];
                var nxt = (current + 1) % total;
                var inw = items[nxt];

                fitWidth(nxt);

                out.style.transition = 'transform ' + slideTime + 'ms cubic-bezier(0.4,0,0.2,1), opacity ' + slideTime + 'ms cubic-bezier(0.4,0,0.2,1)';
                out.style.transform = 'translateY(-100%)';
                out.style.opacity = '0';

                inw.style.transition = 'none';
                inw.style.transform = 'translateY(100%)';
                inw.style.opacity = '0';

                void inw.offsetHeight;

                inw.style.transition = 'transform ' + slideTime + 'ms cubic-bezier(0.4,0,0.2,1), opacity ' + slideTime + 'ms cubic-bezier(0.4,0,0.2,1)';
                inw.style.transform = 'translateY(0)';
                inw.style.opacity = '1';

                current = nxt;
            }

            setInterval(slide, holdTime + slideTime);
        })();
        </script>
    <?php endif; ?>

    <?php
        // ================= PRODUCTS =================
        $raw_products = get_option( 'custom_product_cards', '[]' );
        $custom_products = json_decode( $raw_products, true );
        if ( ! is_array( $custom_products ) ) $custom_products = array();

        $product_groups = array( 'Software' => array() );
        $add_cards = array();
        foreach ( $custom_products as $card ) {
            if ( ( $card['type'] ?? '' ) === 'Hardware' ) continue;
            if ( ( $card['type'] ?? '' ) === 'Add' ) {
                $add_cards[] = $card;
            } else {
                $product_groups[ 'Software' ][] = $card;
            }
        }
        $product_groups[ 'Software' ] = array_merge( $add_cards, $product_groups[ 'Software' ] );

        $wanted = array( 'More to Come', 'POS System', 'Healthcare Clinic System' );
        $ordered = array();
        foreach ( $wanted as $w ) {
            foreach ( $product_groups[ 'Software' ] as $k => $c ) {
                if ( strtolower( trim( $c['title'] ?? '' ) ) === strtolower( $w ) ) {
                    $ordered[] = $c;
                    unset( $product_groups[ 'Software' ][ $k ] );
                    break;
                }
            }
        }
        $product_groups[ 'Software' ] = array_merge( $ordered, array_values( $product_groups[ 'Software' ] ) );

        if ( ! empty( $custom_products ) ) :
        ?>
        <section class="section" id="products">
            <div class="container">
                <div class="flex justify-start">
                    <h2 class="section-title !text-gold-dark" data-anim="fade-up" data-anim-delay="100"><?php echo esc_html( futuristic_it_t('custom_products_tagline') ); ?></h2>
                </div>
                <h2 class="section-title" data-anim="fade-up" data-anim-delay="100"><?php echo esc_html( futuristic_it_t('custom_products_title') ); ?></h2>
                <p class="section-subtitle" data-anim="fade-up" data-anim-delay="200"><?php echo esc_html( futuristic_it_t('custom_products_subtitle') ); ?></p>

                <?php $current_lang = futuristic_it_get_current_lang();
                foreach ( $product_groups as $group_name => $group_cards ) :
                    if ( empty( $group_cards ) ) continue; ?>
                <h3 class="product-group-title" data-anim="fade-up" data-anim-delay="250"><?php echo esc_html( futuristic_it_t( 'custom_products_group_' . strtolower( $group_name ) ) ?: $group_name ); ?></h3>

                <div class="product-3d-carousel relative w-full py-10 pb-[70px] overflow-hidden" data-anim="fade-up" data-anim-delay="300">
                    <div class="product-3d-track relative w-full mx-auto h-[380px] md:h-[400px] lg:h-[480px] flex items-center justify-center" id="productTrack-<?php echo esc_attr( strtolower( $group_name ) ); ?>">
                    <?php $card_idx = 0;
                    $all_cards = array();
                    foreach ( $group_cards as $card ) :
                        $card_type = $card['type'] ?? '';
                        $product_key = 'home_' . md5($card['title'] ?? '');
                        $has_details = !empty($card['features']) || !empty($card['specs']) || !empty($card['images']);
                        $custom_link = $card['link'] ?? '';
                        if (!empty($custom_link) && $custom_link !== '#') {
                            $product_link = $custom_link;
                        } else {
                            $product_link = $has_details ? add_query_arg('product_key', $product_key, home_url('/product-detail/')) : '#';
                        }
                        $card_title = ($current_lang === 'km' && !empty($card['title_km'])) ? $card['title_km'] : $card['title'];
                        $card_desc = ($current_lang === 'km' && !empty($card['desc_km'])) ? $card['desc_km'] : $card['desc'];
                        $card_badge = ($current_lang === 'km' && !empty($card['badge_km'])) ? $card['badge_km'] : $card['badge'];
                        $card_link_text = ($current_lang === 'km' && !empty($card['link_text_km'])) ? $card['link_text_km'] : ($card['link_text'] ?: '');
                        $all_cards[] = compact('card_type', 'product_link', 'card_title', 'card_desc', 'card_badge', 'card_link_text', 'card');
                    endforeach;
                    foreach ( $all_cards as $ci => $c) :
                        extract($c);
                    ?>
                        <div class="product-3d-card absolute w-[85%] md:w-1/2 lg:w-1/3 px-1 md:px-1.5 lg:px-2 transition-all duration-500 ease-[cubic-bezier(0.4,0,0.2,1)] will-change-transform-opacity" data-index="<?php echo esc_attr( $ci ); ?>">
                            <?php if ($card_type === 'Add') : ?>
                                <a href="<?php echo esc_url( $product_link ); ?>" class="product-card product-card-add flex flex-col bg-white rounded-2xl overflow-hidden border border-[var(--border-color)] shadow-[0_4px_20px_rgba(0,0,0,0.06)] h-[360px] md:h-[380px] lg:h-[440px] transition-shadow duration-300">
                                    <div class="relative">
                                        <?php if ( ! empty( $card['image'] ) ) : ?>
                                            <img src="<?php echo esc_url( $card['image'] ); ?>" alt="<?php echo esc_attr( $card_title ); ?>" class="w-full h-[210px] object-cover bg-[var(--cream-dark)]">
                                        <?php else : ?>
                                            <div class="w-full h-[210px]" style="background: linear-gradient(135deg, var(--dark-green) 0%, var(--green-700) 100%);"></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="px-[22px] pt-[22px] pb-[26px] flex flex-col flex-1 items-center justify-center">
                                        <span class="product-card-add-btn">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                        </span>
                                    </div>
                                </a>
                            <?php else : ?>
                                <div class="product-card bg-white rounded-2xl overflow-hidden border border-[var(--border-color)] shadow-[0_4px_20px_rgba(0,0,0,0.06)] h-[360px] md:h-[380px] lg:h-[440px] flex flex-col transition-shadow duration-300 hover:shadow-[0_8px_30px_rgba(0,0,0,0.1)]">
                                    <div class="relative">
                                        <?php if ( ! empty( $card['image'] ) ) : ?>
                                            <img src="<?php echo esc_url( $card['image'] ); ?>" alt="<?php echo esc_attr( $card_title ); ?>" class="w-full h-[210px] object-cover" style="background-color:var(--cream-dark);">
                                        <?php else : ?>
                                            <div class="w-full h-[210px]" style="background: linear-gradient(135deg, var(--dark-green) 0%, var(--green-700) 100%);"></div>
                                        <?php endif; ?>
                                        <?php if ( ! empty( $card_badge ) ) : ?>
                                            <span class="absolute top-3 left-3 bg-[var(--dark-green)] text-white py-1 px-3 rounded-[20px] text-xs font-bold"><?php echo esc_html( $card_badge ); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="px-[22px] pt-[22px] pb-[26px] flex flex-col flex-1">
                                        <h3 class="text-lg sm:text-xl mb-2.5 font-bold" style="color:var(--text-dark);"><?php echo esc_html( $card_title ); ?></h3>
                                        <p class="card-desc text-sm sm:text-base mb-4 leading-6" style="color:var(--text-gray);"><?php echo esc_html( $card_desc ); ?></p>
                                        <div class="flex items-center justify-between mt-3.5">
                                            <?php if ( $card_type === 'Contact' ) : ?>
                                                <a href="<?php echo esc_url( $product_link ); ?>" class="w-full btn btn-gold"><?php echo esc_html( $card_link_text ); ?></a>
                                            <?php else : ?>
                                                <a href="<?php echo esc_url( $product_link ); ?>" class="text-dark-green hover:text-gold-dark duration-300 inline-flex items-center gap-1.5 font-bold text-sm sm:text-base"><?php echo esc_html( $card_link_text ); ?> →</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php $card_idx++; endforeach; ?>
                    </div>

                    <?php if (count($all_cards) > 1) : ?>
                    <button class="carousel-arrow carousel-arrow-prev absolute top-1/2 -translate-y-1/2 left-0 w-9 h-9 md:w-10 md:h-10 rounded-full bg-[#083321] border-none cursor-pointer flex items-center justify-center z-10 transition-all duration-300 shadow-[0_2px_12px_rgba(0,0,0,0.15)] text-white hover:bg-[#b8892f] hover:scale-105" aria-label="Previous">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="md:w-5 md:h-5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                    </button>
                    <button class="carousel-arrow carousel-arrow-next absolute top-1/2 -translate-y-1/2 right-0 w-9 h-9 md:w-10 md:h-10 rounded-full bg-[#083321] border-none cursor-pointer flex items-center justify-center z-10 transition-all duration-300 shadow-[0_2px_12px_rgba(0,0,0,0.15)] text-white hover:bg-[#b8892f] hover:scale-105" aria-label="Next">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="md:w-5 md:h-5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </button>
                    <button class="carousel-toggle absolute bottom-0 left-1/2 -translate-x-1/2 w-8 h-8 md:w-9 md:h-9 lg:w-10 lg:h-10 rounded-full bg-[var(--cream)] border border-[var(--border-color)] cursor-pointer flex items-center justify-center z-10 transition-all duration-300 color-[var(--dark-green)] mb-1.25 hover:bg-white hover:scale-105 hover:shadow-[0_4px_14px_rgba(0,0,0,0.15)]" id="carouselToggle-<?php echo esc_attr( strtolower( $group_name ) ); ?>" aria-label="Pause carousel">
                        <svg class="carousel-toggle-pause w-5 h-5 md:w-6 md:h-6" viewBox="0 0 24 24" fill="none">
                            <rect x="6" y="4" width="4" height="16" rx="1" fill="currentColor"/>
                            <rect x="14" y="4" width="4" height="16" rx="1" fill="currentColor"/>
                        </svg>
                        <svg class="carousel-toggle-play w-5 h-5 md:w-6 md:h-6" viewBox="0 0 24 24" fill="none">
                            <path d="M8 5.14v14a1 1 0 0 0 1.5.87l11-7a1 1 0 0 0 0-1.74l-11-7A1 1 0 0 0 8 5.14z" fill="currentColor"/>
                        </svg>
                    </button>
                    <?php endif; ?>
                </div>

                <?php endforeach; ?>

                <?php
                $products_cta_text  = futuristic_it_t('custom_products_cta_text');
                $products_cta_link  = get_option( 'custom_products_cta_link', '' );
                $products_cta_label = futuristic_it_t('custom_products_cta_link_text');
                if ( $products_cta_text ) : ?>
                    <p class="section-footnote">
                        <?php echo esc_html( $products_cta_text ); ?>
                        <?php if ( $products_cta_link ) : ?>
                            &nbsp;<a href="<?php echo esc_url( $products_cta_link ); ?>"><?php echo esc_html( $products_cta_label ); ?> →</a>
                        <?php endif; ?>
                    </p>
                <?php endif; ?>
            </div>
        </section>
    <?php endif; ?>

    <?php
    // ================= SERVICES =================
    $raw_services = get_option( 'custom_service_cards', '[]' );
    $custom_services = json_decode( $raw_services, true );
    if ( ! is_array( $custom_services ) ) $custom_services = array();

    if ( ! empty( $custom_services ) ) :
    ?>
    <section class="section section-light" id="services">
        <div class="container">
            <div class="services-layout grid grid-cols-1 md:grid-cols-[300px_1fr] gap-5 md:gap-10">
                <div class="services-content md:sticky md:top-28 md:self-start" data-anim="fade-up" data-anim-delay="100">
                    <h2 class="services-title text-2xl sm:text-3xl font-extrabold"><?php echo esc_html( futuristic_it_t('custom_services_title') ); ?></h2>
                    <p class="services-subtitle"><?php echo esc_html( futuristic_it_t('custom_services_subtitle') ); ?></p>
                </div>
                <div class="services-grid grid grid-cols-1 md:grid-cols-2 gap-5">
                    <?php $card_idx = 0; $current_lang = futuristic_it_get_current_lang();
                    foreach ( $custom_services as $card ) :
                        $svc_type = $card['type'] ?? 'Detail';
                        $svc_key = 'svc_' . md5($card['title'] ?? '');
                        $has_courses = !empty($card['courses']) || ($svc_type === 'Course');
                        $has_details = !empty($card['features']) || !empty($card['packages']) || !empty($card['sections']) || !empty($card['images']) || $has_courses;
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
                        $card_title = ($current_lang === 'km' && !empty($card['title_km'])) ? $card['title_km'] : $card['title'];
                        $card_desc = ($current_lang === 'km' && !empty($card['desc_km'])) ? $card['desc_km'] : $card['desc'];
                        $card_link_text = ($current_lang === 'km' && !empty($card['link_text_km'])) ? $card['link_text_km'] : ($card['link_text'] ?: 'Learn More');
                    ?>
                        <div class="service-card" data-anim="fade-up" data-anim-delay="<?php echo ($card_idx * 100); ?>">
                            <?php if ( ! empty( $card['image'] ) ) : ?>
                                <img src="<?php echo esc_url( $card['image'] ); ?>" alt="<?php echo esc_attr( $card_title ); ?>" class="service-card-bg">
                            <?php endif; ?>
                            <div class="service-card-overlay">
                                <h3 class="service-card-title"><?php echo esc_html( $card_title ); ?></h3>
                                <div class="service-card-desc">
                                    <p><?php echo esc_html( $card_desc ); ?></p>
                                </div>
                                <a href="<?php echo esc_url( $svc_link ); ?>" class="service-card-link"><?php echo esc_html( $card_link_text ); ?> →</a>
                            </div>
                        </div>
                    <?php $card_idx++; endforeach; ?>
                </div>
            </div>

            <?php
            $services_cta_text  = futuristic_it_t('custom_services_cta_text');
            $services_cta_link  = get_option( 'custom_services_cta_link', '' );
            $services_cta_label = futuristic_it_t('custom_services_cta_link_text');
            if ( $services_cta_text ) : ?>
                <p class="section-footnote">
                    <?php echo esc_html( $services_cta_text ); ?>
                    <?php if ( $services_cta_link ) : ?>
                        &nbsp;<a href="<?php echo esc_url( $services_cta_link ); ?>"><?php echo esc_html( $services_cta_label ); ?> →</a>
                    <?php endif; ?>
                </p>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php
    // ================= WHY CHOOSE US =================
    $raw_partners = get_option( 'custom_partner_cards', '[]' );
    $partner_cards = json_decode( $raw_partners, true );
    if ( ! is_array( $partner_cards ) ) $partner_cards = array();
    if ( ! empty( $partner_cards ) ) :
    ?>
    <section class="py-[90px] px-0 bg-[var(--cream)]" id="partners">
        <div class="container">
            <h2 class="section-title text-center text-2xl sm:text-3xl font-extrabold mb-4 text-[var(--dark-green)]" data-anim="fade-up" data-anim-delay="100"><?php echo esc_html( futuristic_it_t('custom_partners_title') ); ?></h2>
            <p class="section-subtitle text-center text-sm sm:text-base max-w-[600px] mx-auto mb-[50px] leading-7 text-[var(--text-gray)]" data-anim="fade-up" data-anim-delay="200"><?php echo esc_html( futuristic_it_t('custom_partners_subtitle') ); ?></p>
            <div class="why-choose-grid grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                <?php $pc_idx = 0; $current_lang = futuristic_it_get_current_lang();
                foreach ( $partner_cards as $pc ) :
                    $pc_title = ($current_lang === 'km' && !empty($pc['title_km'])) ? $pc['title_km'] : $pc['title'];
                    $pc_desc = ($current_lang === 'km' && !empty($pc['desc_km'])) ? $pc['desc_km'] : $pc['desc'];
                ?>
                    <div class="why-choose-card text-center py-9 px-5 rounded-2xl relative transition-all duration-400 bg-white border border-[#e8e8e8]" data-anim="fade-up" data-anim-delay="<?php echo ($pc_idx * 100); ?>">
                        <div class="why-choose-icon w-[72px] h-[72px] rounded-full flex items-center justify-center mx-auto mb-5 transition-all duration-400" style="border:2px solid #8cb89a;color:var(--gold-dark,#b8892f);background:linear-gradient(135deg,rgba(212,168,67,0.12) 0%,rgba(212,168,67,0.05) 100%);">
                            <?php if (!empty($pc['image'])) : ?>
                                <img src="<?php echo esc_url($pc['image']); ?>" alt="<?php echo esc_attr($pc_title); ?>" style="object-fit:contain;">
                            <?php else : ?>
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                            <?php endif; ?>
                        </div>
                        <h4 class="why-choose-title text-lg sm:text-xl font-bold m-0 mb-2.5 transition-colors duration-300 text-[var(--dark-green)]"><?php echo esc_html( $pc_title ); ?></h4>
                        <?php if (!empty($pc_desc)) : ?>
                            <p class="why-choose-desc text-sm sm:text-base leading-[1.65] m-0 text-[#6b7280]"><?php echo esc_html( $pc_desc ); ?></p>
                        <?php endif; ?>
                    </div>
                <?php $pc_idx++; endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php
    // ================= SLIDER =================
    $raw_sliders = get_option('custom_homepage_sliders', '[]');
    $sliders = json_decode($raw_sliders, true);
    if (!is_array($sliders)) $sliders = array();
    usort($sliders, function($a, $b) { return ($a['order'] ?? 0) - ($b['order'] ?? 0); });
    if (!empty($sliders)) :
    ?>
    <section class="slider-section" id="slider">
        <div class="slider-wrapper">
            <div class="slider-track" id="slider-track">
                <?php foreach ($sliders as $si => $sl) : ?>
                    <div class="slider-slide">
                        <?php if (!empty($sl['image'])) : ?>
                            <img src="<?php echo esc_url($sl['image']); ?>" alt="Slide" class="slider-slide-image w-full object-cover max-h-[600px] md:max-h-[700px] lg:max-h-[800px]" <?php echo $si === 0 ? 'fetchpriority="high"' : 'loading="lazy"'; ?>>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if (count($sliders) > 1) : ?>
            <div class="slider-dots" id="slider-dots">
                <?php foreach ($sliders as $si => $sl) : ?>
                    <span class="slider-dot <?php echo $si === 0 ? 'active' : ''; ?>" data-index="<?php echo $si; ?>"></span>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>
    <script>
    (function(){
        var track = document.getElementById('slider-track');
        if (!track) return;
        var slides = track.querySelectorAll('.slider-slide');
        var dots = document.querySelectorAll('.slider-dot');
        var current = 0;
        var total = slides.length;
        var timer;
        function goTo(i) {
            current = (i + total) % total;
            track.style.transform = 'translateX(-' + (current * 100) + '%)';
            dots.forEach(function(d, idx) { d.classList.toggle('active', idx === current); });
        }
        function startTimer() {
            clearInterval(timer);
            timer = setInterval(function() { goTo(current + 1); }, 8000);
        }
        dots.forEach(function(dot) {
            dot.addEventListener('click', function() {
                var idx = parseInt(this.getAttribute('data-index'));
                goTo(idx);
                startTimer();
            });
        });
        startTimer();
    })();
    </script>
    <?php endif; ?>

    <?php
        // ================= DEPENDABLE OPERATION / ASSURANCE =================
        $cta_features = json_decode(get_option('custom_cta_features', '[]'), true);
        if (!is_array($cta_features)) $cta_features = array();
        $current_lang = futuristic_it_get_current_lang();
    ?>
    <?php if ( ! empty( $cta_features ) ) : ?>
        <section class="dependable-sectio py-[60px] px-0 bg-white" id="assurance">
            <div class="container grid grid-cols-1 lg:grid-cols-[1.1fr_1fr] gap-[50px] items-stretch">
                <div data-anim="fade-right">
                    <h1 class="text-sm sm:text-base font-bold text-left !text-[var(--gold)]" data-anim="fade-up"><?php echo esc_html( futuristic_it_t('custom_cta_tagline') ); ?></h1>
                    <h2 class="text-2xl sm:text-3xl mb-[18px]"><?php echo esc_html( futuristic_it_t('custom_cta_title') ); ?></h2>
                    <p class="mb-[26px] max-w-[480px] text-[var(--text-gray)]"><?php echo esc_html( futuristic_it_t('custom_cta_subtitle') ); ?></p>

                    <?php
                    $cta_tags_raw = futuristic_it_t('custom_cta_tags');
                    $cta_tags = $cta_tags_raw ? array_map( 'trim', explode( ',', $cta_tags_raw ) ) : array();
                    if ( $cta_tags ) : ?>
                        <div class="flex flex-wrap gap-2.5">
                            <?php foreach ( $cta_tags as $tag ) : ?>
                                <span class="px-4 py-[9px] rounded-[30px] text-xs sm:text-sm font-semibold bg-[var(--cream-dark)] text-[var(--text-dark)]"><?php echo esc_html( $tag ); ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="bg-[var(--dark-green)] text-white rounded-[var(--radius)] px-9 py-[40px]" data-anim="fade-left">
                    <h3 class="text-xl sm:text-2xl text-white mb-6"><?php echo esc_html( futuristic_it_t('custom_cta_box_title') ); ?></h3>

                    <?php if ( ! empty( $cta_features ) ) : ?>
                        <ul class="mb-7 list-none p-0 m-0">
                            <?php foreach ( $cta_features as $feature ) :
                                $icon = $feature['icon'] ?? '';
                                $is_image = !empty($icon) && (strpos($icon, 'http') === 0 || strpos($icon, '/') === 0);
                                $feat_title = ($current_lang === 'km' && !empty($feature['title_km'])) ? $feature['title_km'] : ($feature['title'] ?? '');
                                $feat_desc = ($current_lang === 'km' && !empty($feature['desc_km'])) ? $feature['desc_km'] : ($feature['desc'] ?? '');
                            ?>
                                <li class="flex items-start gap-3.5 mb-5">
                                    <span class="w-7 h-7 rounded-full flex items-center justify-center shrink-0 text-xs sm:text-sm font-extrabold text-[var(--dark-green)]">
                                        <?php if ($is_image) : ?>
                                            <img src="<?php echo esc_url($icon); ?>" style="width:28px;height:28px;object-fit:contain;" alt="">
                                        <?php else : ?>
                                            <?php echo esc_html($icon ?: '✔'); ?>
                                        <?php endif; ?>
                                    </span>
                                    <div>
                                        <strong class="block text-sm sm:text-base mb-[3px]"><?php echo esc_html( $feat_title ); ?></strong>
                                        <span class="text-xs sm:text-sm text-[var(--text-on-dark-soft)]"><?php echo esc_html( $feat_desc ); ?></span>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <a href="<?php echo esc_url( get_option( 'custom_cta_box_btn_link', '#' ) ); ?>" class="btn btn-gold btn-full mt-1.5 w-full">
                        <?php echo esc_html( futuristic_it_t('custom_cta_box_btn_text') ); ?>
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>
</main>

<?php get_footer(); ?>