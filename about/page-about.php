<?php
/**
 * Template Name: About Us
 */

get_header();

$current_lang = futuristic_it_get_current_lang();
$hero_img = get_option('custom_about_hero_image', '');
$story_img = get_option('custom_about_story_image', '');
?>

<main>
    <!-- HERO -->
    <?php if (!empty(get_option('custom_about_title'))): ?>
        <section class="about-hero relative bg-[var(--dark-green)] text-white flex items-center mb-[50px] bg-cover bg-center py-[160px] min-h-[85vh] max-md:py-[100px] max-md:pb-[60px] max-md:min-h-[50vh] max-md:h-auto max-[576px]:py-20 max-[576px]:pb-10" style="<?php echo !empty($hero_img) ? 'background-image: linear-gradient(135deg, rgba(20,46,31,0.7) 0%, rgba(20,46,31,0.4) 100%), url(' . esc_url($hero_img) . ');' : ''; ?>">
            <div class="container">
                <div class="about-hero-content max-w-[700px] max-md:max-w-full relative z-[1]">
                    <span class="inline-block text-xs sm:text-sm font-bold mb-[18px] rounded py-1.5 px-3.5 text-[var(--gold)] bg-[rgba(212,168,67,0.15)]" data-anim="fade-down"><?php echo esc_html(futuristic_it_t('custom_about_tagline')); ?></span>
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-[22px] leading-[1.15] text-white" data-anim="fade-up" data-anim-delay="100"><?php echo wp_kses(futuristic_it_t('custom_about_title'), array('em' => array())); ?></h1>
                    <p class="text-sm sm:text-base lg:text-lg mb-[34px] leading-[1.8] max-w-[560px] text-[var(--text-on-dark-soft)]" data-anim="fade-up" data-anim-delay="200"><?php echo esc_html(futuristic_it_t('custom_about_subtitle')); ?></p>
                    <div class="flex gap-4 flex-wrap mt-2.5" data-anim="fade-up" data-anim-delay="300">
                        <a href="<?php echo esc_url(get_option('custom_about_btn_link', '#')); ?>" class="btn btn-gold"><?php echo esc_html(futuristic_it_t('custom_about_btn_text')); ?></a>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- OUR STORY -->
    <?php if (!empty(get_option('custom_about_our_story'))) : ?>
    <section class="section">
        <div class="container">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-[60px] items-center">
                <div data-anim="fade-right">
                    <span class="dependable-eyebrow text-center"><?php echo esc_html(futuristic_it_t('custom_about_story_tagline')); ?></span>
                    <h2 class="text-2xl sm:text-3xl mb-5"><?php echo esc_html(futuristic_it_t('custom_about_our_story')); ?></h2>
                    <?php if (!empty(futuristic_it_t('custom_about_mission'))) : ?>
                        <p class="mb-4 leading-[1.8] text-[var(--text-gray)]"><?php echo esc_html(futuristic_it_t('custom_about_mission')); ?></p>
                    <?php endif; ?>
                    <?php if (!empty(futuristic_it_t('custom_about_vision'))) : ?>
                        <p class="mb-4 leading-[1.8] text-[var(--text-gray)]"><?php echo esc_html(futuristic_it_t('custom_about_vision')); ?></p>
                    <?php endif; ?>
                    <?php if (!empty(futuristic_it_t('custom_about_paragraph3'))) : ?>
                        <p class="mb-4 leading-[1.8] text-[var(--text-gray)]"><?php echo esc_html(futuristic_it_t('custom_about_paragraph3')); ?></p>
                    <?php endif; ?>
                </div>
                <div data-anim="fade-left">
                    <?php if (!empty($story_img)) : ?>
                        <img src="<?php echo esc_url($story_img); ?>" alt="Our Team" class="w-full rounded-[var(--radius)] shadow-[var(--shadow-lg)]">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- CORE PHILOSOPHY -->
    <?php
    $philosophy_cards = json_decode(get_option('custom_about_philosophy_cards', '[]'), true);
    if (!is_array($philosophy_cards)) $philosophy_cards = array();
    if (!empty(get_option('custom_about_philosophy_title')) || !empty($philosophy_cards)) :
    ?>
    <section class="section bg-[var(--dark-green)] text-white">
        <div class="container min-w-0">
            <span class="section-eyebrow" data-anim="fade-up"><?php echo esc_html(futuristic_it_t('custom_about_philosophy_tagline')); ?></span>
            <h2 class="section-title text-white" data-anim="fade-up" data-anim-delay="100"><?php echo esc_html(futuristic_it_t('custom_about_philosophy_title')); ?></h2>
            <?php if (!empty($philosophy_cards)) : ?>
            <div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-6 md:gap-8">
                <?php $p_idx = 0; foreach ($philosophy_cards as $card) : ?>
                    <div class="rounded-[var(--radius)] px-8 py-9 min-w-0 overflow-wrap-anywhere border border-[var(--border-on-dark)] bg-[rgba(255,255,255,0.05)]" data-anim="scale-up" data-anim-delay="<?php echo ($p_idx * 100); ?>">
                        <?php if (!empty($card['icon'])) : ?>
                            <div class="w-[46px] h-[46px] rounded-full flex items-center justify-center text-xl mb-5 text-[var(--dark-green)]"><img src="<?php echo esc_url($card['icon']); ?>" style="width:40px;height:40px;object-fit:contain;" alt=""></div>
                        <?php else : ?>
                            <div class="w-[46px] h-[46px] rounded-full flex items-center justify-center text-xl mb-5 text-[var(--dark-green)]">●</div>
                        <?php endif; ?>
                        <?php
                        $card_title = $card['title'] ?? '';
                        $card_desc = $card['desc'] ?? '';
                        if ($current_lang === 'km') {
                            if (!empty($card['title_km'])) $card_title = $card['title_km'];
                            if (!empty($card['desc_km'])) $card_desc = $card['desc_km'];
                        }
                        ?>
                        <h3 class="text-lg sm:text-xl mb-3 text-[var(--gold)]"><?php echo esc_html($card_title); ?></h3>
                        <p class="text-sm sm:text-base leading-7 text-[var(--text-on-dark-soft)]"><?php echo esc_html($card_desc); ?></p>
                    </div>
                <?php $p_idx++; endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <!-- TIMELINE (hidden) -->

    <!-- FAQ -->
    <?php
    $faqs = json_decode(get_option('custom_about_faqs', '[]'), true);
    if (!is_array($faqs)) $faqs = array();
    if (!empty($faqs)) :
    ?>
    <section class="section px-0 bg-[var(--cream)]">
        <div class="container">
            <div class="faq-grid grid grid-cols-1 gap-0 max-w-[800px] mx-auto">
                <div data-anim="fade-right">
                    <h2 class="section-title text-center mb-2 relative pb-4"><?php echo esc_html(futuristic_it_t('custom_faq_title', 'FAQ')); ?><span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[50px] h-[3px] rounded-[2px] bg-[var(--gold)]"></span></h2>
                </div>
                <div class="faq-container flex flex-col gap-3" data-anim="fade-left">
                    <?php foreach ($faqs as $faq) :
                        $faq_q = $faq['q'] ?? '';
                        $faq_a = $faq['a'] ?? '';
                        if ($current_lang === 'km') {
                            if (!empty($faq['q_km'])) $faq_q = $faq['q_km'];
                            if (!empty($faq['a_km'])) $faq_a = $faq['a_km'];
                        }
                    ?>
                    <div class="faq-item bg-white border border-[var(--border-color)] rounded-[var(--radius-sm)] overflow-visible transition-all duration-300 relative">
                        <div class="faq-question px-6 py-[18px] cursor-pointer flex justify-between items-center gap-5 font-semibold text-sm sm:text-base transition-colors duration-200 text-[var(--text-dark)]">
                            <?php echo esc_html($faq_q); ?>
                            <span class="faq-toggle shrink-0 text-lg transition-transform duration-300 text-[var(--text-dark)]"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></span>
                        </div>
                        <div class="faq-answer px-6 text-sm sm:text-base leading-7 hidden absolute left-0 right-0 top-full bg-white border border-[var(--border-color)] border-t-0 rounded-b-[var(--radius-sm)] z-10 text-[var(--text-gray)] shadow-[0_8px_24px_rgba(0,0,0,0.1)]">
                            <p><?php echo esc_html($faq_a); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
