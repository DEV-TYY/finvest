<?php
/**
 * Template Name: Products
 */

get_header();

$raw_products = get_option('custom_product_cards', '[]');
$custom_products = json_decode($raw_products, true);
if (!is_array($custom_products)) $custom_products = array();

$product_groups = array('Software' => array());
foreach ($custom_products as $card) {
    if (($card['type'] ?? '') === 'Hardware') continue;
    $group = in_array($card['type'] ?? '', array('Software', 'Contact'), true) ? 'Software' : 'Software';
    $product_groups[$group][] = $card;
}
?>

<main>

    <!-- Products Section -->
    <?php if (!empty($custom_products)) : ?>
    <section class="section">
        <div class="container">
            <?php $current_lang = futuristic_it_get_current_lang();
            foreach ($product_groups as $group_name => $group_cards) :
                if (empty($group_cards)) continue; ?>
            <h2 class="product-group-title" data-anim="fade-up"><?php echo esc_html(futuristic_it_t('custom_products_group_' . strtolower($group_name)) ?: $group_name); ?></h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-7">
                <?php $pr_idx = 0;
                foreach ($group_cards as $card) :
                    $type = $card['type'] ?? 'Hardware';
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
                    $card_badge = ($current_lang === 'km' && !empty($card['badge_km'])) ? $card['badge_km'] : ($card['badge'] ?? '');
                    $card_link_text = ($current_lang === 'km' && !empty($card['link_text_km'])) ? $card['link_text_km'] : ($card['link_text'] ?: 'Learn More');
                ?>
                    <?php if ($type === 'Add') : ?>
                        <a href="<?php echo esc_url( $product_link ); ?>" class="product-card product-card-add bg-white rounded-[var(--radius)] overflow-hidden border border-[var(--border-color)] transition-all duration-250 hover:-translate-y-1.5 hover:shadow-[var(--shadow-lg)] hover:border-transparent flex flex-col" data-anim="scale-up" data-anim-delay="<?php echo ($pr_idx * 100); ?>">
                            <div class="relative">
                                <?php if ( ! empty( $card['image'] ) ) : ?>
                                    <img src="<?php echo esc_url( $card['image'] ); ?>" alt="<?php echo esc_attr( $card_title ); ?>" class="w-full h-[210px] object-cover bg-[var(--cream-dark)]">
                                <?php else : ?>
                                    <div class="w-full h-[210px] object-cover" style="background: linear-gradient(135deg, var(--dark-green) 0%, var(--green-700) 100%);"></div>
                                <?php endif; ?>
                            </div>
                            <div class="px-[22px] pt-[22px] pb-[26px] flex flex-col flex-1">
                                <h3 class="text-lg sm:text-xl mb-2.5 font-bold text-[var(--text-dark)]"><?php echo esc_html( $card_title ); ?></h3>
                                <p class="card-desc text-sm sm:text-base mb-4 leading-6 text-[var(--text-gray)]"><?php echo esc_html( $card_desc ); ?></p>
                                <div class="flex items-center justify-start mt-auto pt-3.5">
                                    <span class="inline-flex items-center gap-2.5 py-2.5 px-6 rounded-full text-xs sm:text-sm font-bold text-white transition-all duration-300 hover:scale-105 hover:shadow-lg cursor-pointer" style="background: linear-gradient(135deg, var(--dark-green) 0%, var(--green-700) 100%);">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                        <?php echo esc_html( $card_link_text ); ?>
                                    </span>
                                </div>
                            </div>
                        </a>
                    <?php else : ?>
                        <div class="bg-white rounded-[var(--radius)] overflow-hidden border border-[var(--border-color)] transition-all duration-250 hover:-translate-y-1.5 hover:shadow-[var(--shadow-lg)] hover:border-transparent flex flex-col" data-anim="scale-up" data-anim-delay="<?php echo ($pr_idx * 100); ?>">
                            <div class="relative">
                                <?php if (!empty($card['image'])) : ?>
                                    <img src="<?php echo esc_url($card['image']); ?>" alt="<?php echo esc_attr($card_title); ?>" class="w-full h-[210px] object-cover" style="background-color:var(--cream-dark);">
                                <?php else : ?>
                                    <div class="w-full h-[210px] object-cover" style="background: linear-gradient(135deg, var(--dark-green) 0%, var(--green-700) 100%);"></div>
                                <?php endif; ?>
                                <?php if (!empty($card_badge)) : ?>
                                    <span class="absolute top-3 left-3 bg-[var(--dark-green)] text-white py-1 px-3 rounded-[20px] text-xs font-bold"><?php echo esc_html($card_badge); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="px-[22px] pt-[22px] pb-[26px] flex flex-col flex-1">
                                <h3 class="text-[1.1rem] mb-2.5 font-bold text-[var(--text-dark)]"><?php echo esc_html($card_title); ?></h3>
                                <p class="card-desc text-[0.92rem] mb-4 leading-6 text-[var(--text-gray)]"><?php echo esc_html( $card_desc ); ?></p>
                                <div class="flex items-center justify-between mt-auto pt-3.5">
                                    <?php if ($type !== 'Software' && $type !== 'Contact' && !empty($card['price'])) : ?>
                                        <span class="text-lg sm:text-xl font-extrabold text-[var(--dark-green)]"> $<?php echo esc_html($card['price']); ?></span>
                                    <?php endif; ?>
                                    <?php if ($type === 'Contact') : ?>
                                        <a href="<?php echo esc_url($product_link); ?>" class="w-full btn btn-gold"><?php echo esc_html($card_link_text); ?> →</a>
                                    <?php else : ?>
                                        <a href="<?php echo esc_url($product_link); ?>" class="text-dark-green hover:text-gold-dark duration-300 inline-flex items-center gap-1.5 font-bold text-sm sm:text-base"><?php echo esc_html($card_link_text); ?> →</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php $pr_idx++; endforeach; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
