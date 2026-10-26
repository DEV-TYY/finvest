<?php
/**
 * Template Name: Procurement Support
 *
 * Detail page for the Software Procurement Support service. The copy and the
 * software grid are both admin-controlled (Software Procurement module), so
 * everything below falls back to the module's own defaults rather than to
 * hardcoded markup — an untouched install still renders the full page.
 */

get_header();

$current_lang = futuristic_it_get_current_lang();

// --- Hero copy -------------------------------------------------------------
// futuristic_it_procurement_text() resolves each field the same way: saved
// value in the current language, else the shipped default in that language,
// else English. The defaults live in functions.php so the admin form and this
// template cannot disagree about them.
$badge      = futuristic_it_procurement_text('procurement_badge', $current_lang);
$heading    = futuristic_it_procurement_text('procurement_heading', $current_lang);
$highlight  = futuristic_it_procurement_text('procurement_heading_highlight', $current_lang);
$paragraph  = futuristic_it_procurement_text('procurement_paragraph', $current_lang);
$panel_note = futuristic_it_procurement_text('procurement_panel_note', $current_lang);

// --- Software grid ---------------------------------------------------------
// Seeded only when never saved — an admin who deletes every row gets an empty
// grid, not the defaults back. See futuristic_it_procurement_cards().
$cards = futuristic_it_procurement_cards();

$software = array();
foreach ($cards as $card) {
    $name_en = trim($card['name'] ?? '');
    $name_km = trim($card['name_km'] ?? '');
    if ($name_en === '' && $name_km === '') continue;
    $software[] = array(
        'icon' => trim($card['icon'] ?? ''),
        'name' => ($current_lang === 'km' && $name_km !== '') ? $name_km : $name_en,
    );
}

// --- Panel heading ---------------------------------------------------------
$panel_title = futuristic_it_procurement_text('procurement_panel_title', $current_lang);

// --- Our process -----------------------------------------------------------
// Seeded only when never saved, like the software grid. Steps with no title in
// either language are dropped rather than rendered as an empty row.
$process_eyebrow = futuristic_it_procurement_text('procurement_process_eyebrow', $current_lang);
$process_heading = futuristic_it_procurement_text('procurement_process_heading', $current_lang);

$steps = array();
foreach (futuristic_it_procurement_steps() as $step) {
    $title_en = trim($step['title'] ?? '');
    $title_km = trim($step['title_km'] ?? '');
    if ($title_en === '' && $title_km === '') continue;

    $desc_en = trim($step['desc'] ?? '');
    $desc_km = trim($step['desc_km'] ?? '');
    $meta_en = trim($step['meta'] ?? '');
    $meta_km = trim($step['meta_km'] ?? '');

    $km = ($current_lang === 'km');
    $steps[] = array(
        'title' => ($km && $title_km !== '') ? $title_km : $title_en,
        'desc'  => ($km && $desc_km !== '') ? $desc_km : $desc_en,
        'meta'  => ($km && $meta_km !== '') ? $meta_km : $meta_en,
    );
}
?>

<main>
    <section class="py-[90px] max-md:py-[60px] max-[576px]:py-[50px]">
        <div class="container">
            <div class="flex flex-wrap gap-[60px] items-start max-lg:gap-[40px] max-md:gap-[36px]">

                <!-- LEFT: copy -->
                <div class="flex-1 min-w-[320px] max-md:min-w-full">
                    <?php if (!empty($badge)) : ?>
                        <span class="inline-block text-xs sm:text-sm font-bold mb-[22px] rounded-full py-1.5 px-4 text-[var(--gold-dark)] bg-[rgba(212,168,67,0.12)] border border-[rgba(212,168,67,0.35)]" data-anim="fade-down"><?php echo esc_html($badge); ?></span>
                    <?php endif; ?>

                    <?php if (!empty($heading)) : ?>
                        <h1 class="text-3xl sm:text-4xl md:text-[42px] font-bold mb-[26px] leading-[1.2] text-[var(--text-dark)] max-w-[620px]" data-anim="fade-up" data-anim-delay="100"><?php
                            // The highlight word is admin-typed text, not markup:
                            // futuristic_it_highlight_word() escapes every piece
                            // and only wraps the match, so no HTML is trusted.
                            echo futuristic_it_highlight_word($heading, $highlight, 'text-[var(--gold)]');
                        ?></h1>
                    <?php endif; ?>

                    <?php if (!empty($paragraph)) : ?>
                        <p class="text-sm sm:text-base leading-[1.9] text-[var(--text-body)] max-w-[600px] mb-[36px]" data-anim="fade-up" data-anim-delay="200"><?php echo esc_html($paragraph); ?></p>
                    <?php endif; ?>

                    <?php
                    // Use the admin-configured URL if set; fall back to the
                    // Contact Us page.
                    $cta_url = trim(futuristic_it_procurement_text('procurement_cta_url', $current_lang));
                    if ($cta_url === '') {
                        $cta_url = futuristic_it_get_contact_url();
                    }
                    if (!empty($cta_url)) :
                    ?>
                        <a href="<?php echo esc_url($cta_url); ?>" class="btn btn-gold" data-anim="fade-up" data-anim-delay="300">
                            <?php echo esc_html(futuristic_it_procurement_text('procurement_cta_text', $current_lang)); ?>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </a>
                    <?php endif; ?>
                </div>

                <!-- RIGHT: software panel -->
                <?php if (!empty($software)) : ?>
                <div class="flex-1 min-w-[320px] max-md:min-w-full" data-anim="fade-up" data-anim-delay="200">
                    <div class="rounded-[var(--radius)] p-[30px] max-[576px]:p-[20px] bg-[var(--cream)] border border-[var(--border-color)]">

                        <?php if (!empty($panel_title)) : ?>
                            <h2 class="text-base sm:text-lg font-bold text-[var(--text-dark)] mb-[22px]"><?php echo esc_html($panel_title); ?></h2>
                        <?php endif; ?>

                        <?php
                        // Two columns, four tiles on show. From the fifth tile
                        // on the grid stops growing and scrolls instead — see
                        // .proc-grid, which caps it at two rows. Two columns is
                        // also the only count that works at every width: the
                        // panel does not track the viewport (below md the
                        // columns stack and it is full-width, so it is wider at
                        // 576px than at 768px, where the two columns sit side by
                        // side and it drops to ~333px). Three columns there left
                        // ~83px tiles; two leaves ~160px everywhere.
                        ?>
                        <div class="proc-grid grid grid-cols-2 gap-[12px]">
                            <?php foreach ($software as $item) : ?>
                                <?php
                                // Icon centred above the label, as on the reference
                                // panel. The tile's height comes from the grid's
                                // --proc-tile-h (see .proc-grid), so a card with no
                                // uploaded logo still lines up with one that has an
                                // icon, and two rows measure exactly one screenful of
                                // the scroller. The label clamps to two lines for the
                                // same reason — an over-long name would otherwise
                                // grow the row past the cap and be clipped.
                                // The icon is sized in step with --proc-tile-h: it
                                // has to leave room for a two-line label plus the
                                // tile's own padding inside that fixed height.
                                //
                                // The logo sits in a fixed 56px box rather than
                                // being sized directly, so the hover can scale the
                                // box (and put a glow behind it) without changing
                                // the tile's height. The box is exactly the icon's
                                // size, so the row height is unaffected.
                                //
                                // Only properties Tailwind does not already set on
                                // these elements are changed from CSS (see
                                // .proc-tile in src/input.css) — anything the
                                // utilities own is switched with a hover: utility
                                // here instead, because the utilities layer wins
                                // over the components layer whatever the
                                // specificity.
                                // transition-[...] rather than transition-colors:
                                // the tile also animates its inset box-shadow on
                                // hover, which transition-colors does not cover,
                                // and the utilities layer would win over anything
                                // set from .proc-tile in the stylesheet.
                                ?>
                                <div class="proc-tile flex flex-col items-center justify-center gap-[12px] text-center rounded-[var(--radius-sm)] py-[24px] px-[14px] bg-white border border-[var(--border-color)]">
                                    <?php if (!empty($item['icon'])) : ?>
                                        <span class="proc-tile-icon">
                                            <img src="<?php echo esc_url($item['icon']); ?>" alt="" class="w-[56px] h-[56px] object-contain" loading="lazy" decoding="async">
                                        </span>
                                    <?php endif; ?>
                                    <span class="proc-tile-label text-[13px] sm:text-sm font-medium text-[var(--text-dark)] leading-[1.4]"><?php echo esc_html($item['name']); ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <?php if (!empty($panel_note)) : ?>
                            <p class="mt-[24px] text-sm sm:text-base font-semibold text-[var(--gold-dark)] flex items-center justify-center gap-2 text-center">
                                <span aria-hidden="true">+</span><?php echo esc_html($panel_note); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </section>

    <?php if (!empty($steps)) : ?>
    <!-- OUR PROCESS -->
    <section class="section-dark py-[90px] max-md:py-[60px] max-[576px]:py-[50px]">
        <div class="container">

            <?php if (!empty($process_eyebrow)) : ?>
                <p class="text-xs sm:text-sm font-bold tracking-[0.14em] uppercase text-[var(--gold)] mb-[14px]" data-anim="fade-up"><?php echo esc_html($process_eyebrow); ?></p>
            <?php endif; ?>

            <?php if (!empty($process_heading)) : ?>
                <h2 class="text-2xl sm:text-3xl md:text-[34px] font-bold leading-[1.25] text-white max-w-[760px] mb-[46px] max-md:mb-[34px]" data-anim="fade-up" data-anim-delay="100"><?php echo esc_html($process_heading); ?></h2>
            <?php endif; ?>

            <ol class="flex flex-col list-none m-0 p-0">
                <?php foreach ($steps as $i => $step) : ?>
                    <?php
                    // The last step drops its rule so the list does not end on a
                    // divider with nothing under it.
                    $is_last = ($i === count($steps) - 1);
                    ?>
                    <li class="relative flex gap-[24px] max-[576px]:gap-[16px] pb-[34px] max-[576px]:pb-[26px] <?php echo $is_last ? '' : 'border-b border-[rgba(255,255,255,0.10)] mb-[34px] max-[576px]:mb-[26px]'; ?>" data-anim="fade-up" data-anim-delay="<?php echo esc_attr(100 + ($i * 60)); ?>">

                        <span class="shrink-0 w-[46px] h-[46px] max-[576px]:w-[38px] max-[576px]:h-[38px] rounded-full flex items-center justify-center text-[15px] max-[576px]:text-[13px] font-bold text-[var(--gold)] bg-[rgba(212,168,67,0.14)] border border-[rgba(212,168,67,0.35)]" aria-hidden="true"><?php echo esc_html($i + 1); ?></span>

                        <div class="flex-1 min-w-0">
                            <h3 class="text-base sm:text-lg font-bold text-white mb-[8px] leading-[1.35]"><?php echo esc_html($step['title']); ?></h3>

                            <?php if (!empty($step['desc'])) : ?>
                                <p class="text-sm sm:text-base leading-[1.75] text-[var(--text-on-dark-soft)] max-w-[860px] mb-0"><?php echo esc_html($step['desc']); ?></p>
                            <?php endif; ?>

                            <?php if (!empty($step['meta'])) : ?>
                                <span class="inline-flex items-center gap-[7px] mt-[14px] rounded-full py-[5px] px-[12px] text-xs sm:text-[13px] font-semibold text-[var(--gold)] bg-[rgba(212,168,67,0.12)] border border-[rgba(212,168,67,0.28)]">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                                    <?php echo esc_html($step['meta']); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ol>

        </div>
    </section>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
