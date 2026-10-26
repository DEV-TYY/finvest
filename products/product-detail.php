<?php
/**
 * Template Name: Product Detail
 */

$product_key = isset($_GET['product_key']) ? sanitize_text_field($_GET['product_key']) : '';
$product = null;

if ($product_key) {
    $raw = get_option('custom_product_cards', '[]');
    $cards = json_decode($raw, true);
    if (is_array($cards)) {
        foreach ($cards as $card) {
            if (('home_' . md5($card['title'] ?? '')) === $product_key) {
                $product = $card;
                break;
            }
        }
    }
}

if (!$product) {
    get_header();
    echo '<main><div class="container" style="padding:100px 0;text-align:center;"><h1>Product not found</h1><a href="' . esc_url(home_url('/products/')) . '" class="btn btn-gold">Back to Products</a></div></main>';
    get_footer();
    return;
}

get_header();

$product_type = $product['type'] ?? 'Hardware';
$images = $product['images'] ?? array();
$specs = $product['specs'] ?? '';
$specs_km = $product['specs_km'] ?? '';
$price = $product['price'] ?? '';
$image_list = array();
for ($i = 1; $i <= 6; $i++) {
    if (!empty($images[$i])) $image_list[] = $images[$i];
}

$current_lang = futuristic_it_get_current_lang();
if ($current_lang === 'km') {
    if (!empty($product['title_km'])) $product['title'] = $product['title_km'];
    if (!empty($product['desc_km'])) $product['desc'] = $product['desc_km'];
    if (!empty($specs_km)) $specs = $specs_km;
}

$feature_cards = $product['feature_cards'] ?? array();
$features_title = $product['features_title'] ?? '';
$features_title_km = $product['features_title_km'] ?? '';
if ($current_lang === 'km' && !empty($features_title_km)) $features_title = $features_title_km;

$packages = $product['packages'] ?? array();
$packages_title = $product['packages_title'] ?? '';
$packages_title_km = $product['packages_title_km'] ?? '';
if ($current_lang === 'km' && !empty($packages_title_km)) $packages_title = $packages_title_km;

$recommended_raw = $product['recommends'] ?? array();
$recommends_section_title = $product['recommends_section_title_en'] ?? 'Recommended Products';
$recommends_section_title_km = $product['recommends_section_title_km'] ?? '';
$recommends_section_desc = $product['recommends_section_desc_en'] ?? '';
$recommends_section_desc_km = $product['recommends_section_desc_km'] ?? '';
if ($current_lang === 'km') {
    if (!empty($recommends_section_title_km)) $recommends_section_title = $recommends_section_title_km;
    if (!empty($recommends_section_desc_km)) $recommends_section_desc = $recommends_section_desc_km;
}
$recommended_products = array();
if (!empty($recommended_raw)) {
    $all_cards = json_decode(get_option('custom_product_cards', '[]'), true);
    if (is_array($all_cards)) {
        foreach ($all_cards as $card) {
            $card_id = 'home_' . md5($card['title'] ?? '');
            foreach ($recommended_raw as $rec_item) {
                $rec_id = is_array($rec_item) ? ($rec_item['id'] ?? '') : $rec_item;
                if ($card_id === $rec_id && $card_id !== $product_key) {
                    $recommended_products[] = $card;
                    break;
                }
            }
        }
    }
}
?>

<main>
    <section class="pt-4 sm:pt-6 pb-4">
        <div class="container">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 lg:gap-16">
                <div class="flex flex-col" data-anim="fade-right">
                    <?php if (!empty($image_list)) : ?>
                        <img src="<?php echo esc_url($image_list[0]); ?>" alt="<?php echo esc_attr($product['title']); ?>" class="w-full h-[200px] sm:h-[280px] md:h-[350px] lg:h-[420px] object-cover rounded-[var(--radius)] mb-1" style="background:var(--cream-dark);" id="mainProductImage">
                        <?php if (count($image_list) > 1) : ?>
                        <div class="grid grid-cols-5 gap-1.5 sm:gap-2">
                            <?php foreach ($image_list as $idx => $img) : ?>
                                <img src="<?php echo esc_url($img); ?>" alt="Thumbnail <?php echo $idx + 1; ?>" class="product-thumbnail w-full h-12 sm:h-14 md:h-16 object-cover rounded-[var(--radius-sm)] cursor-pointer opacity-60 border-2 border-transparent transition-all duration-[0.25s] hover:opacity-100 hover:border-[var(--gold)] <?php echo $idx === 0 ? 'opacity-100 border-[var(--gold)]' : ''; ?>" onclick="changeImage(this)">
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    <?php else : ?>
                        <div class="w-full h-[200px] sm:h-[280px] md:h-[350px] lg:h-[420px] object-cover rounded-[var(--radius)] flex items-center justify-center text-white text-3xl" style="background:linear-gradient(135deg, #1a3d27 0%, #285d38 100%);">
                            <?php echo esc_html(substr($product['title'], 0, 1)); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="py-2.5" data-anim="fade-left">
                    <h1 class="text-xl sm:text-2xl md:text-3xl text-[var(--text-dark)] mb-4 md:mb-[22px]"><?php echo esc_html($product['title']); ?></h1>

                    <?php if (!empty($product['desc'])) : ?>
                        <div class="text-xs sm:text-sm md:text-base leading-[1.8] mb-4 md:mb-[22px] text-[var(--text-body)]"><?php echo wp_kses_post($product['desc']); ?></div>
                    <?php endif; ?>

                    <?php if (!empty($feature_cards)) : ?>
                        <div class="mb-4 md:mb-[22px]">
                            <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-5" data-anim="fade-up">
                                <?php foreach ($feature_cards as $fc) :
                                    $fc_title = $fc['title'] ?? '';
                                    $fc_desc = $fc['desc'] ?? '';
                                    if ($current_lang === 'km') {
                                        if (!empty($fc['title_km'])) $fc_title = $fc['title_km'];
                                        if (!empty($fc['desc_km'])) $fc_desc = $fc['desc_km'];
                                    }
                                 ?>
                                    <div class="feature-card h-full py-4 sm:py-5 px-4 sm:px-[18px] border-t border-[var(--border-color)] transition-colors duration-300 hover:bg-white/60 first:border-t-0 sm:border-l sm:border-b sm:border-t-0">
                                        <?php if (!empty($fc['icon'])) : ?>
                                            <div class="flex w-[36px] h-[36px] mb-[14px] items-center justify-center">
                                                <img class="w-full h-full object-contain" src="<?php echo esc_url($fc['icon']); ?>" alt="<?php echo esc_attr($fc_title); ?>">
                                            </div>
                                        <?php endif; ?>
                                        <h3 class="text-sm sm:text-base font-bold text-[var(--text-dark,#1a2620)] mb-2 leading-[1.4]"><?php echo esc_html($fc_title); ?></h3>
                                        <p class="feature-card-desc text-xs sm:text-sm text-[var(--text-gray,#6f7a74)] leading-[1.6]"><?php echo esc_html($fc_desc); ?></p>
                                        <span class="feature-card-tooltip"><?php echo esc_html($fc_desc); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($product_type !== 'Software' && !empty($price)) : ?>
                        <div class="text-lg sm:text-xl md:text-2xl text-[var(--dark-green)] font-extrabold mb-4 md:mb-6"><span class="text-[var(--text-gray)] font-medium text-xs sm:text-sm md:text-base mr-2"><?php _e('Price:', 'futuristic-it'); ?></span>$<?php echo esc_html($price); ?></div>
                    <?php endif; ?>

                    <?php if ($product_type !== 'Software') : ?>
                    <?php
                    $btn_text = $product['btn_text'] ?? 'Inquire Now';
                    $btn_text_km = $product['btn_text_km'] ?? '';
                    $btn_url = $product['btn_url'] ?? '#';
                    if ($current_lang === 'km' && !empty($btn_text_km)) $btn_text = $btn_text_km;
                    ?>
                    <a href="<?php echo esc_url($btn_url); ?>" class="btn btn-gold"><?php echo esc_html($btn_text); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <?php
        $video_url = $current_lang === 'km' && !empty($product['video_url_km']) ? $product['video_url_km'] : ($product['video_url'] ?? '');
        $video_title = $current_lang === 'km' && !empty($product['video_title_km']) ? $product['video_title_km'] : ($product['video_title'] ?? '');
        $video_desc = $current_lang === 'km' && !empty($product['video_desc_km']) ? $product['video_desc_km'] : ($product['video_desc'] ?? '');
        $video_btn_text = $current_lang === 'km' && !empty($product['video_btn_text_km']) ? $product['video_btn_text_km'] : ($product['video_btn_text'] ?? '');
        $video_btn_link = $product['video_btn_link'] ?? '#';
        if (!empty($video_url)) :
    ?>
    <section class="py-5 sm:py-8 relative overflow-hidden">
        <div class="container text-center mb-5 sm:mb-8">
            <?php if (!empty($video_title)) : ?>
                <p class="section-subtitle text-[var(--dark-green)] font-semibold text-xs sm:text-sm uppercase tracking-[0.15em] mb-2 sm:mb-3"><?php echo esc_html($video_title); ?></p>
            <?php endif; ?>
            <?php if (!empty($video_desc)) : ?>
                <p class="section-desc text-[var(--text-gray)] text-xs sm:text-sm md:text-base max-w-2xl mx-auto"><?php echo esc_html($video_desc); ?></p>
            <?php endif; ?>
        </div>
        <div class="container">
            <div class="relative w-full aspect-video max-h-[350px] sm:max-h-[450px] md:max-h-[550px] lg:max-h-[650px] rounded-xl overflow-hidden shadow-[0_8px_40px_rgba(0,0,0,0.1)] border border-[var(--border-color)] cursor-pointer" onclick="this.querySelector('video').play();this.querySelector('.play-overlay').style.display='none';">
                <video class="w-full" preload="metadata" playsinline poster="">
                    <source src="<?php echo esc_url($video_url); ?>" type="video/<?php echo pathinfo(parse_url($video_url, PHP_URL_PATH), PATHINFO_EXTENSION); ?>">
                    <?php _e('Your browser does not support the video tag.', 'futuristic-it'); ?>
                </video>
                <div class="play-overlay absolute inset-0 flex items-center justify-center bg-[rgba(0,0,0,0.25)] transition-all duration-300 hover:bg-[rgba(0,0,0,0.15)]">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 md:w-20 md:h-20 rounded-full bg-[var(--gold)] flex items-center justify-center shadow-[0_4px_24px_rgba(212,168,67,0.5)] transition-transform duration-300 hover:scale-110">
                        <svg width="24" height="24" sm:width="28" sm:height="28" md:width="32" md:height="32" viewBox="0 0 24 24" fill="var(--dark-green)" xmlns="http://www.w3.org/2000/svg"><path d="M8 5v14l11-7z"/></svg>
                    </div>
                </div>
            </div>
        </div>
        <?php if (!empty($video_btn_text)) : ?>
            <div class="text-center mt-6 sm:mt-8 md:mt-10">
                <a href="<?php echo esc_url($video_btn_link); ?>" class="btn btn-gold inline-block text-xs sm:text-sm md:text-base px-5 sm:px-6 md:px-7 py-2.5 sm:py-3 rounded-full font-semibold transition-all duration-300 hover:shadow-[0_0_16px_rgba(212,168,67,0.45)] hover:-translate-y-0.5">
                    <?php echo esc_html($video_btn_text); ?>
                </a>
            </div>
        <?php endif; ?>
    </section>
    <?php endif; ?>

    <?php if ($product_type === 'Software' && !empty($packages)) : ?>
    <section class="section bg-[#0A1A14] text-white overflow-hidden mt-6 sm:mt-8 md:mt-10 mb-6 sm:mb-8 md:mb-10">
        <div class="container min-w-0 py-5 sm:py-6 md:py-8">
            <?php if (!empty($packages_title)) : ?>
                <h2 class="section-title text-center text-xl sm:text-2xl md:text-3xl text-white mb-3 sm:mb-3.5 font-extrabold" data-anim="fade-up"><?php echo esc_html($packages_title); ?></h2>
            <?php endif; ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 mt-6 sm:mt-8 md:mt-10">
                <?php foreach ($packages as $pkg) :
                    $has_badge = !empty($pkg['badge']);
                    $pkg_features = $pkg['features'] ?? array();
                    if ($current_lang === 'km' && !empty($pkg['features_km'])) $pkg_features = $pkg['features_km'];
                    $pkg_title = $pkg['title'] ?? '';
                    if ($current_lang === 'km' && !empty($pkg['title_km'])) $pkg_title = $pkg['title_km'];
                    $pkg_badge = $pkg['badge'] ?? '';
                    if ($current_lang === 'km' && !empty($pkg['badge_km'])) $pkg_badge = $pkg['badge_km'];
                    $pkg_btn_text = $pkg['btn_text'] ?? '';
                    if ($current_lang === 'km' && !empty($pkg['btn_text_km'])) $pkg_btn_text = $pkg['btn_text_km'];
                ?>
                <div class="package-card relative bg-[rgba(255,255,255,0.05)] border border-[rgba(255,255,255,0.1)] rounded-xl px-5 sm:px-7 py-7 sm:py-9 text-left transition-all duration-300 hover:-translate-y-1 hover:border-[rgba(255,255,255,0.2)]<?php echo $has_badge ? ' border-[var(--gold)] bg-[rgba(255,255,255,0.08)]' : ''; ?>" data-anim="fade-up">
                    <?php if (!empty($pkg['image'])) : ?>
                        <div class="text-center mb-4">
                            <img src="<?php echo esc_url($pkg['image']); ?>" alt="<?php echo esc_attr($pkg_title); ?>" class="max-w-[120px] max-h-20 object-contain">
                        </div>
                    <?php endif; ?>
                    <?php if ($has_badge) : ?>
                        <span class="package-badge absolute -top-3.5 left-1/2 -translate-x-1/2 bg-[var(--gold)] text-[var(--dark-green)] py-[5px] px-4 rounded-[20px] text-xs font-bold whitespace-nowrap"><?php echo esc_html($pkg_badge); ?></span>
                    <?php endif; ?>
                    <h3 class="package-title text-white text-lg sm:text-xl md:text-2xl font-bold m-0 mb-2"><?php echo esc_html($pkg_title); ?></h3>
                    <div class="package-price text-[var(--gold)] text-xs sm:text-sm md:text-base font-semibold mb-5 sm:mb-6 pb-4 sm:pb-5 border-b border-[rgba(255,255,255,0.1)]"><?php echo esc_html($pkg['price'] ?? ''); ?></div>
                    <?php if (!empty($pkg_btn_text)) : ?>
                       <a href="<?php echo esc_url($pkg['btn_link'] ?? home_url('/contact/')); ?>" class="btn btn-gold block w-full text-center"><?php echo esc_html($pkg_btn_text); ?></a>
                    <?php endif; ?>
                    <?php if (!empty($pkg_features) && is_array($pkg_features)) : ?>
                    <ul class="package-features list-none p-0 my-2 sm:my-2.5 mb-5 sm:mb-7">
                        <?php foreach ($pkg_features as $pf) : ?>
                            <div class="package-feature-item flex items-center gap-2 sm:gap-2.5 text-xs sm:text-sm md:text-base">
                                <svg width="16" height="16" sm:width="18" sm:height="18" md:width="20" md:height="20" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.01667 8.51667L9.12917 4.40417L8.3125 3.5875L5.01667 6.88333L3.35417 5.22083L2.5375 6.0375L5.01667 8.51667ZM5.83333 11.6667C5.02639 11.6667 4.26806 11.5135 3.55833 11.2073C2.84861 10.901 2.23125 10.4854 1.70625 9.96042C1.18125 9.43542 0.765625 8.81806 0.459375 8.10833C0.153125 7.39861 0 6.64028 0 5.83333C0 5.02639 0.153125 4.26806 0.459375 3.55833C0.765625 2.84861 1.18125 2.23125 1.70625 1.70625C2.23125 1.18125 2.84861 0.765625 3.55833 0.459375C4.26806 0.153125 5.02639 0 5.83333 0C6.64028 0 7.39861 0.153125 8.10833 0.459375C8.81806 0.765625 9.43542 1.18125 9.96042 1.70625C10.4854 2.23125 10.901 2.84861 11.2073 3.55833C11.5135 4.26806 11.6667 5.02639 11.6667 5.83333C11.6667 6.64028 11.5135 7.39861 11.2073 8.10833C10.901 8.81806 10.4854 9.43542 9.96042 9.96042C9.43542 10.4854 8.81806 10.901 8.10833 11.2073C7.39861 11.5135 6.64028 11.6667 5.83333 11.6667ZM5.83333 10.5C7.13611 10.5 8.23958 10.0479 9.14375 9.14375C10.0479 8.23958 10.5 7.13611 10.5 5.83333C10.5 4.53056 10.0479 3.42708 9.14375 2.52292C8.23958 1.61875 7.13611 1.16667 5.83333 1.16667C4.53056 1.16667 3.42708 1.61875 2.52292 2.52292C1.61875 3.42708 1.16667 4.53056 1.16667 5.83333C1.16667 7.13611 1.61875 8.23958 2.52292 9.14375C3.42708 10.0479 4.53056 10.5 5.83333 10.5Z" fill="#735C00"/>
                                </svg>
                                <li class="text-[rgba(255,255,255,0.85)] py-2 sm:py-2.5 border-b border-[rgba(255,255,255,0.06)] last:border-b-0"><?php echo esc_html($pf); ?></li>
                            </div>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
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
