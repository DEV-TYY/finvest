<?php
/**
 * Single Product Template
 */

get_header(); ?>

<main>
    <?php while (have_posts()) : the_post(); ?>

    <!-- Product Hero -->
    <section class="relative bg-[var(--dark-green)] text-white flex items-center mb-[50px] bg-cover bg-center max-md:py-[100px] max-md:pb-[60px] max-md:min-h-[50vh] max-md:h-auto max-[576px]:py-20 max-[576px]:pb-10" style="padding:140px 0 80px;<?php echo has_post_thumbnail() ? 'background-image: linear-gradient(135deg, rgba(20,46,31,0.85) 0%, rgba(20,46,31,0.5) 100%), url(' . esc_url(get_the_post_thumbnail_url('full')) . ');' : ''; ?>">
        <div class="container">
            <div class="max-w-[700px] relative z-[1] max-md:max-w-full">
                <span class="inline-block text-xs sm:text-sm font-bold mb-[18px] rounded py-1.5 px-3.5 text-[var(--gold)] bg-[rgba(212,168,67,0.15)]" data-anim="fade-down"><?php echo esc_html(futuristic_it_t('product_detail_eyebrow', 'Product Details')); ?></span>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-[22px] leading-[1.15] text-white" data-anim="fade-up" data-anim-delay="100"><?php the_title(); ?></h1>
                <p class="text-sm sm:text-base lg:text-lg mb-[34px] max-w-[560px] leading-[1.8] text-[var(--text-on-dark-soft)]" data-anim="fade-up" data-anim-delay="200"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
            </div>
        </div>
    </section>

    <!-- Product Detail -->
    <section class="section" style="padding-top: 50px;">
        <div class="container">
            <?php
            $images = array();
            for ($i = 1; $i <= 6; $i++) {
                $img = get_post_meta(get_the_ID(), '_product_image_' . $i, true);
                if (!empty($img)) $images[] = $img;
            }
            ?>
            <div class="single-product-wrapper grid grid-cols-1 md:grid-cols-2 gap-[60px] max-md:flex max-md:flex-col max-md:gap-[30px]">
                <div class="product-gallery" data-anim="fade-right">
                    <?php if (!empty($images)) : ?>
                        <img src="<?php echo esc_url($images[0]); ?>" alt="<?php the_title(); ?>" class="product-main-image w-full h-[420px] max-md:h-[320px] max-[576px]:h-[260px] object-cover rounded-[var(--radius)]" id="mainProductImage">
                        <div class="product-thumbnails grid grid-cols-5 max-[576px]:grid-cols-3 gap-2.5">
                            <?php foreach ($images as $idx => $img) : ?>
                                <img src="<?php echo esc_url($img); ?>" alt="Thumbnail <?php echo $idx + 1; ?>" class="product-thumbnail <?php echo $idx === 0 ? 'active' : ''; ?>" onclick="changeImage(this)">
                            <?php endforeach; ?>
                        </div>
                    <?php elseif (has_post_thumbnail()) : ?>
                        <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>" class="product-main-image w-full h-[420px] max-md:h-[320px] max-[576px]:h-[260px] object-cover rounded-[var(--radius)]" id="mainProductImage">
                    <?php else : ?>
                        <div class="product-main-image w-full h-[420px] max-md:h-[320px] max-[576px]:h-[260px] flex items-center justify-center text-white text-[3rem] rounded-[var(--radius)]" style="background: linear-gradient(135deg, #1a3d27 0%, #285d38 100%);">
                            <?php echo esc_html(substr(get_the_title(), 0, 1)); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="product-details" data-anim="fade-left">
                    <h1><?php the_title(); ?></h1>

                    <div class="product-description-full">
                        <?php the_content(); ?>
                    </div>

                    <?php
                    $features = get_post_meta(get_the_ID(), '_product_features', true);
                    if ($features) :
                    ?>
                        <ul class="product-spec-list">
                            <?php
                            $feature_lines = explode("\n", $features);
                            foreach ($feature_lines as $feature) :
                                if (trim($feature)) :
                                    $parts = explode(':', $feature, 2);
                            ?>
                                <li>
                                    <?php if (count($parts) === 2) : ?>
                                        <strong><?php echo esc_html(trim($parts[0])); ?>:</strong> <?php echo esc_html(trim($parts[1])); ?>
                                    <?php else : ?>
                                        <?php echo esc_html(trim($feature)); ?>
                                    <?php endif; ?>
                                </li>
                            <?php
                                endif;
                            endforeach;
                            ?>
                        </ul>
                    <?php endif; ?>

                    <?php
                    $price = get_post_meta(get_the_ID(), '_product_price', true);
                    if ($price) :
                    ?>
                        <div class="single-product-price"><span><?php _e('Price:', 'futuristic-it'); ?></span>$<?php echo esc_html($price); ?></div>
                    <?php endif; ?>

                    <?php
                    $inquire_btn = get_post_meta(get_the_ID(), '_product_btn_text', true) ?: 'Inquire Now';
                    $inquire_btn_km = get_post_meta(get_the_ID(), '_product_btn_text_km', true);
                    $inquire_btn_url = get_post_meta(get_the_ID(), '_product_btn_url', true) ?: '#';
                    $current_lang_btn = futuristic_it_get_current_lang();
                    if ($current_lang_btn === 'km' && !empty($inquire_btn_km)) $inquire_btn = $inquire_btn_km;
                    $inquire_type = get_post_meta(get_the_ID(), '_product_type', true) ?: 'Hardware';
                    ?>
                    <?php if ($inquire_type !== 'Software') : ?>
                    <a href="<?php echo esc_url($inquire_btn_url); ?>" class="btn btn-gold"><?php echo esc_html($inquire_btn); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <?php
    $current_lang = futuristic_it_get_current_lang();
    $pid = get_the_ID();
    $rec_raw = get_post_meta($pid, '_product_recommends', true);
    $recommended_data = !empty($rec_raw) ? json_decode($rec_raw, true) : array();
    $recommends_section_title_en = get_post_meta($pid, '_recommends_section_title_en', true) ?: 'Recommended Products';
    $recommends_section_title_km = get_post_meta($pid, '_recommends_section_title_km', true);
    $recommends_section_desc_en = get_post_meta($pid, '_recommends_section_desc_en', true);
    $recommends_section_desc_km = get_post_meta($pid, '_recommends_section_desc_km', true);
    $recommends_section_title = $recommends_section_title_en;
    $recommends_section_desc = $recommends_section_desc_en;
    if ($current_lang === 'km') {
        if (!empty($recommends_section_title_km)) $recommends_section_title = $recommends_section_title_km;
        if (!empty($recommends_section_desc_km)) $recommends_section_desc = $recommends_section_desc_km;
    }

    $recommended_products = array();
    if (!empty($recommended_data)) {
        $all_cards = json_decode(get_option('custom_product_cards', '[]'), true);
        if (is_array($all_cards)) {
            foreach ($all_cards as $card) {
                $card_id = 'home_' . md5($card['title'] ?? '');
                foreach ($recommended_data as $rec_item) {
                    $rec_id = is_array($rec_item) ? ($rec_item['id'] ?? '') : $rec_item;
                    if ($card_id === $rec_id && $card_id !== ('home_' . md5(get_the_title()))) {
                        $recommended_products[] = $card;
                        break;
                    }
                }
            }
        }
    }

    if (!empty($recommended_products)) :
    ?>
    <section class="section section-light">
        <div class="container">
            <h2 class="section-title" data-anim="fade-up"><?php echo esc_html($recommends_section_title); ?></h2>
            <?php if (!empty($recommends_section_desc)) : ?>
                <p class="text-center text-[#666] mt-[-10px] mb-[30px]"><?php echo esc_html($recommends_section_desc); ?></p>
            <?php endif; ?>

            <div class="flex flex-wrap gap-[28px] justify-start">
                <?php foreach ($recommended_products as $rec) :
                    $rec_type = $rec['type'] ?? 'Hardware';
                    $rec_image = $rec['image'] ?? '';
                    if (empty($rec_image)) {
                        $rec_images = $rec['images'] ?? array();
                        for ($i = 1; $i <= 6; $i++) {
                            if (!empty($rec_images[$i])) { $rec_image = $rec_images[$i]; break; }
                        }
                    }
                    $rec_price = $rec['price'] ?? '';
                    $rec_key = 'home_' . md5($rec['title'] ?? '');
                    $rec_title = $rec['title'] ?? '';
                    $rec_desc = $rec['desc'] ?? '';
                    if ($current_lang === 'km') {
                        if (!empty($rec['title_km'])) $rec_title = $rec['title_km'];
                        if (!empty($rec['desc_km'])) $rec_desc = $rec['desc_km'];
                    }
                ?>
                <div class="bg-white rounded-[var(--radius)] overflow-hidden border border-[var(--border-color)] transition-all duration-250 hover:-translate-y-1.5 hover:shadow-[var(--shadow-lg)] hover:border-transparent w-[calc(33.333%-19px)] min-w-[280px]" data-anim="scale-up">
                    <div class="relative">
                        <?php if (!empty($rec_image)) : ?>
                            <img src="<?php echo esc_url($rec_image); ?>" alt="<?php echo esc_attr($rec_title); ?>" class="w-full h-[210px] object-cover bg-[var(--cream-dark)]">
                        <?php else : ?>
                            <div class="w-full h-[210px] object-cover" style="background: linear-gradient(135deg, #1a3d27 0%, #285d38 100%);"></div>
                        <?php endif; ?>
                        <span class="absolute top-3 right-3 bg-[var(--gold)] text-white py-1 px-3 rounded-[20px] text-xs font-bold"><?php echo esc_html($rec_type); ?></span>
                    </div>
                    <div class="px-[22px] pt-[22px] pb-[26px]">
                        <h3 class="text-lg sm:text-xl mb-2.5 font-bold text-[var(--text-dark)]"><?php echo esc_html($rec_title); ?></h3>
                        <p class="text-sm sm:text-base mb-4 leading-6 text-[var(--text-gray)]"><?php echo wp_trim_words(wp_strip_all_tags($rec_desc), 12); ?></p>
                        <div class="flex items-center justify-between mt-3.5">
                            <span class="text-lg sm:text-xl font-extrabold text-[var(--dark-green)]"><?php echo $rec_price ? '$' . esc_html($rec_price) : ''; ?></span>
                            <a href="<?php echo esc_url(home_url('/product-detail/?product_key=' . urlencode($rec_key))); ?>" class="inline-flex items-center gap-1.5 font-bold text-sm sm:text-base text-[var(--dark-green)]"><?php _e('Learn More', 'futuristic-it'); ?> &rarr;</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php endwhile; ?>
</main>

<script>
function changeImage(thumb) {
    var main = document.getElementById('mainProductImage');
    if (!main) return;
    document.querySelectorAll('.product-thumbnail').forEach(function (t) { t.classList.remove('active'); });
    thumb.classList.add('active');
    if (thumb.tagName === 'IMG') {
        main.src = thumb.src;
    }
}
</script>

<?php get_footer(); ?>
