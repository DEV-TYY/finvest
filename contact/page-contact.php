<?php
/**
 * Template Name: Contact Us
 */

get_header(); ?>




<main>

    <!-- CONTACT FORM SECTION -->
    <section class="section">
        <div class="container">
            <div class="grid grid-cols-1 md:grid-cols-[1fr_1.2fr] gap-[50px] items-start">
                <div data-anim="fade-right">
                    <h3 class="text-2xl sm:text-3xl font-extrabold mb-[18px] leading-tight text-[var(--text-dark)]"><?php echo esc_html(futuristic_it_t('custom_contact_heading')); ?></h3>
                    <p class="lead text-[#6b7280] text-sm sm:text-base leading-relaxed mb-9"><?php echo esc_html(futuristic_it_t('custom_contact_lead')); ?></p>

                    <?php if (!empty(get_option('custom_contact_email', ''))) : ?>
                    <div class="contact-item flex items-center gap-4 px-5 py-[18px] rounded-xl mb-3.5 bg-[var(--cream)] border border-[rgba(13,61,47,0.06)]" data-anim="fade-right" data-anim-delay="100">
                        <div class="contact-icon w-[44px] h-[44px] rounded-[10px] flex items-center justify-center shrink-0 text-white bg-[var(--dark-green)]">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                        </div>
                        <div class="contact-text">
                            <h4 class="text-xs sm:text-sm font-bold mb-0.5 text-[var(--text-dark)]"><?php echo esc_html(futuristic_it_t('custom_contact_email_label')); ?></h4>
                            <p class="text-[#6b7280] text-sm sm:text-base"><?php echo esc_html(get_option('custom_contact_email', '')); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty(get_option('custom_contact_phone', ''))) : ?>
                    <div class="contact-item flex items-center gap-4 px-5 py-[18px] rounded-xl mb-3.5 bg-[var(--cream)] border border-[rgba(13,61,47,0.06)]" data-anim="fade-right" data-anim-delay="200">
                        <div class="contact-icon w-[44px] h-[44px] rounded-[10px] flex items-center justify-center shrink-0 text-white bg-[var(--dark-green)]">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                        </div>
                        <div class="contact-text">
                            <h4 class="text-xs sm:text-sm font-bold mb-0.5 text-[var(--text-dark)]"><?php echo esc_html(futuristic_it_t('custom_contact_phone_label')); ?></h4>
                            <p class="text-[#6b7280] text-sm sm:text-base"><?php echo esc_html(get_option('custom_contact_phone', '')); ?></p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php
                    $social_links = json_decode(get_option('custom_footer_social_links', '[]'), true);
                    if (!is_array($social_links)) $social_links = array();
                    $social_icons = array(
                        'facebook'  => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
                        'linkedin'  => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.647H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
                        'twitter'   => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>',
                        'instagram' => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.197-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>',
                        'youtube'   => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
                        'whatsapp'  => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>',
                        'tiktok'    => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-2.88 2.5 2.89 2.89 0 0 1-2.89-2.89 2.89 2.89 0 0 1 2.89-2.89c.28 0 .54.04.79.1v-3.5a6.37 6.37 0 0 0-1-.08A6.34 6.34 0 0 0 3.15 15.9a6.34 6.34 0 0 0 10.86 4.43l.01-.01a6.32 6.32 0 0 0 1.87-4.43c0-1.16-.32-2.25-.87-3.18.61.77 1.5 1.29 2.5 1.29V9.4a4.83 4.83 0 0 1-2.5-1.29l.01-.01c.62.8 1 1.77 1 2.81 0 2.52-2.04 4.56-4.56 4.56S3.15 14.26 3.15 11.74c0-.79.18-1.54.5-2.2V6.69A6.33 6.33 0 0 0 3.15 11.74c0 3.51 2.84 6.35 6.35 6.35s6.35-2.84 6.35-6.35c0-.78-.18-1.53-.5-2.2l.01-.01A6.34 6.34 0 0 0 15.85 11.74c0 1.84-.75 3.51-1.97 4.73"/></svg>',
                        'telegram'  => '<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>',
                    );
                    $current_lang = futuristic_it_get_current_lang();
                    $social_title = ($current_lang === 'km') ? get_option('custom_social_title_km', '') : get_option('custom_social_title_en', 'Follow Us');
                    if (!empty($social_links)) :
                    ?>
                    <div class="contact-social-links mt-5" data-anim="fade-right" data-anim-delay="300">
                        <?php if (!empty($social_title)) : ?>
                            <h4 class="text-xs sm:text-sm font-bold mb-3 text-[var(--text-dark)]"><?php echo esc_html($social_title); ?></h4>
                        <?php endif; ?>
                        <div class="social-icons flex gap-3 flex-wrap">
                            <?php foreach ($social_links as $sl) :
                                $icon_key = $sl['icon'] ?? '';
                                $icon_svg = $social_icons[$icon_key] ?? '';
                                $platform_name = ucfirst($icon_key);
                            ?>
                                <a href="<?php echo esc_url($sl['url'] ?? '#'); ?>" aria-label="<?php echo esc_attr($platform_name); ?>" target="_blank" class="social-icon-link w-[44px] h-[44px] flex items-center justify-center rounded-[10px] text-white transition-all duration-300 bg-[var(--dark-green)]" title="<?php echo esc_attr($platform_name); ?>">
                                    <?php if ($icon_svg) : ?>
                                        <?php echo $icon_svg; ?>
                                    <?php else : ?>
                                        <?php echo esc_html(substr($platform_name, 0, 2)); ?>
                                    <?php endif; ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="contact-form bg-white p-10 rounded-2xl shadow-[0_8px_32px_rgba(0,0,0,0.08)] border border-[rgba(13,61,47,0.06)]" data-anim="fade-left">
                    <?php
                    $current_lang = futuristic_it_get_current_lang();
                    $form_fullname = $current_lang === 'km' && !empty(get_option('contact_form_fullname_km')) ? get_option('contact_form_fullname_km') : get_option('contact_form_fullname', 'Full Name');
                    $form_phone = $current_lang === 'km' && !empty(get_option('contact_form_phone_km')) ? get_option('contact_form_phone_km') : get_option('contact_form_phone', 'Phone Number');
                    $form_email = $current_lang === 'km' && !empty(get_option('contact_form_email_km')) ? get_option('contact_form_email_km') : get_option('contact_form_email', 'Email');
                    $form_service = $current_lang === 'km' && !empty(get_option('contact_form_service_km')) ? get_option('contact_form_service_km') : get_option('contact_form_service', 'Service Interest');
                    $form_date = $current_lang === 'km' && !empty(get_option('contact_form_date_km')) ? get_option('contact_form_date_km') : get_option('contact_form_date', 'Date');
                    $form_course_name = $current_lang === 'km' && !empty(get_option('contact_form_course_name_km')) ? get_option('contact_form_course_name_km') : get_option('contact_form_course_name', 'Course Name');
                    $form_location = $current_lang === 'km' && !empty(get_option('contact_form_location_km')) ? get_option('contact_form_location_km') : get_option('contact_form_location', 'Location');
                    $form_mode = $current_lang === 'km' && !empty(get_option('contact_form_mode_km')) ? get_option('contact_form_mode_km') : get_option('contact_form_mode', 'Mode');
                    $opt_online = $current_lang === 'km' && !empty(get_option('contact_option_online_km')) ? get_option('contact_option_online_km') : get_option('contact_option_online', 'Online');
                    $opt_inperson = $current_lang === 'km' && !empty(get_option('contact_option_inperson_km')) ? get_option('contact_option_inperson_km') : get_option('contact_option_inperson', 'In-Person Learning');
                    $form_register = $current_lang === 'km' && !empty(get_option('contact_form_register_km')) ? get_option('contact_form_register_km') : get_option('contact_form_register', 'Register as');
                    $opt_group = $current_lang === 'km' && !empty(get_option('contact_option_group_km')) ? get_option('contact_option_group_km') : get_option('contact_option_group', 'Group');
                    $opt_single = $current_lang === 'km' && !empty(get_option('contact_option_single_km')) ? get_option('contact_option_single_km') : get_option('contact_option_single', 'Single');
                    $form_message = $current_lang === 'km' && !empty(get_option('contact_form_message_km')) ? get_option('contact_form_message_km') : get_option('contact_form_message', 'Message');
                    $form_submit = $current_lang === 'km' && !empty(get_option('contact_form_submit_km')) ? get_option('contact_form_submit_km') : get_option('contact_form_submit', 'Submit');
                    $ph_fullname = $current_lang === 'km' && !empty(get_option('contact_placeholder_fullname_km')) ? get_option('contact_placeholder_fullname_km') : get_option('contact_placeholder_fullname', 'Please enter full name');
                    $ph_phone = $current_lang === 'km' && !empty(get_option('contact_placeholder_phone_km')) ? get_option('contact_placeholder_phone_km') : get_option('contact_placeholder_phone', 'Please enter phone number');
                    $ph_email = $current_lang === 'km' && !empty(get_option('contact_placeholder_email_km')) ? get_option('contact_placeholder_email_km') : get_option('contact_placeholder_email', 'Please enter email address');
                    $ph_location = $current_lang === 'km' && !empty(get_option('contact_placeholder_location_km')) ? get_option('contact_placeholder_location_km') : get_option('contact_placeholder_location', 'Please enter location');
                    $ph_message = $current_lang === 'km' && !empty(get_option('contact_placeholder_message_km')) ? get_option('contact_placeholder_message_km') : get_option('contact_placeholder_message', 'Please enter your message');
                    $form_licence = $current_lang === 'km' && !empty(get_option('contact_form_licence_km')) ? get_option('contact_form_licence_km') : get_option('contact_form_licence', 'Licence');
                    $ph_licence = $current_lang === 'km' && !empty(get_option('contact_placeholder_licence_km')) ? get_option('contact_placeholder_licence_km') : get_option('contact_placeholder_licence', 'Select a licence');
                    $form_customer_type = $current_lang === 'km' && !empty(get_option('contact_form_customer_type_km')) ? get_option('contact_form_customer_type_km') : get_option('contact_form_customer_type', 'Customer Type');
                    $ph_customer_type = $current_lang === 'km' && !empty(get_option('contact_placeholder_customer_type_km')) ? get_option('contact_placeholder_customer_type_km') : get_option('contact_placeholder_customer_type', 'Select a customer type');

                    // A course "Register" button links here with ?svc= and
                    // ?course=. Marking the matching <option> selected is all
                    // that is needed: the searchable-select widget adopts the
                    // native select's value when it builds, so the preselect
                    // works with JS disabled as well.
                    // "svc" rather than "service" because the latter is the
                    // public query var of the `service` post type, and using it
                    // makes WordPress 404 this page.
                    $preselect_service = isset($_GET['svc']) ? sanitize_text_field(wp_unslash($_GET['svc'])) : '';
                    $preselect_course = isset($_GET['course']) ? sanitize_text_field(wp_unslash($_GET['course'])) : '';

                    // Collect every course from the Course-type services, using the
                    // same title resolution as services/service-detail.php so the
                    // dropdown matches the cards on the course pages.
                    $contact_courses = array();
                    $contact_services = json_decode(get_option('custom_service_cards', '[]'), true);
                    if (is_array($contact_services)) {
                        foreach ($contact_services as $contact_svc) {
                            if (($contact_svc['type'] ?? '') !== 'Course') continue;
                            if (empty($contact_svc['courses']) || !is_array($contact_svc['courses'])) continue;
                            foreach ($contact_svc['courses'] as $contact_crs) {
                                $crs_title = $contact_crs['title_en'] ?? ($contact_crs['title'] ?? '');
                                if ($current_lang === 'km') {
                                    if (!empty($contact_crs['title_kh'])) $crs_title = $contact_crs['title_kh'];
                                    elseif (!empty($contact_crs['title_km'])) $crs_title = $contact_crs['title_km'];
                                }
                                $crs_title = trim($crs_title);
                                // Dedupe: the same course can appear on several services.
                                if ($crs_title !== '' && !in_array($crs_title, $contact_courses, true)) {
                                    $contact_courses[] = $crs_title;
                                }
                            }
                        }
                    }

                    // Licence choices, managed in the admin "Licence" module.
                    // The Khmer name falls back to the English one so a
                    // half-translated list never shows blank options.
                    $contact_licences = array();
                    $licence_options = json_decode(get_option('custom_licence_options', '[]'), true);
                    if (is_array($licence_options)) {
                        foreach ($licence_options as $licence_opt) {
                            $licence_name = $licence_opt['name'] ?? '';
                            if ($current_lang === 'km' && !empty($licence_opt['name_km'])) {
                                $licence_name = $licence_opt['name_km'];
                            }
                            $licence_name = trim($licence_name);
                            if ($licence_name !== '' && !in_array($licence_name, $contact_licences, true)) {
                                $contact_licences[] = $licence_name;
                            }
                        }
                    }

                    // A field can be revealed by more than one service, so each
                    // of these resolves to a LIST of titles, joined for the
                    // data-service attribute that js/main.js reads. The toggles
                    // there match on the <option>'s value, so the titles have to
                    // be the ones resolved for the current language — in Khmer
                    // the dropdown shows translated titles, not the English
                    // ones. Each card is matched on its English title so the
                    // lookup keeps working in Khmer, where the resolved title no
                    // longer contains the English word at all.
                    //
                    // A stored title that matches no card (renamed or deleted
                    // since it was saved) is passed through untranslated, so the
                    // field keeps working rather than silently going dark.
                    $resolve_trigger_titles = function ($option_name) use ($contact_services, $current_lang) {
                        $resolved = array();
                        foreach (futuristict_trigger_services($option_name) as $trigger_en) {
                            $title = $trigger_en;
                            if (is_array($contact_services)) {
                                foreach ($contact_services as $svc) {
                                    if (($svc['title'] ?? '') !== $trigger_en) continue;
                                    $title = ($current_lang === 'km' && !empty($svc['title_km'])) ? $svc['title_km'] : $svc['title'];
                                    break;
                                }
                            }
                            if (trim($title) !== '' && !in_array($title, $resolved, true)) $resolved[] = $title;
                        }
                        return $resolved;
                    };
                    // json_encode rather than a hand-rolled delimiter: a service
                    // title can contain any punctuation, and JSON is what the
                    // matching JS already parses.
                    $licence_service_title = wp_json_encode($resolve_trigger_titles('contact_licence_service'));
                    $customer_type_service_title = wp_json_encode($resolve_trigger_titles('contact_customer_type_service'));

                    // Customer Type choices, managed in the admin "Customer Type"
                    // module. The Khmer name falls back to the English one so a
                    // half-translated list never shows blank options.
                    $contact_customer_types = array();
                    $customer_type_options = json_decode(get_option('custom_customer_type_options', ''), true);
                    if (!is_array($customer_type_options) || empty($customer_type_options)) {
                        // Same seed as the admin page, so the field is useful on
                        // a fresh install where nothing has been saved yet.
                        $customer_type_options = array(
                            array('name' => 'Personal',     'name_km' => 'ផ្ទាល់ខ្លួន'),
                            array('name' => 'Organization', 'name_km' => 'អង្គការ'),
                            array('name' => 'Other',        'name_km' => 'ផ្សេងៗ'),
                        );
                    }
                    foreach ($customer_type_options as $ct_opt) {
                        $ct_name = $ct_opt['name'] ?? '';
                        if ($current_lang === 'km' && !empty($ct_opt['name_km'])) {
                            $ct_name = $ct_opt['name_km'];
                        }
                        $ct_name = trim($ct_name);
                        if ($ct_name !== '' && !in_array($ct_name, $contact_customer_types, true)) {
                            $contact_customer_types[] = $ct_name;
                        }
                    }
                    ?>
                    <form id="contact-form" data-to-email="<?php echo esc_attr(get_option('custom_contact_form_email', '')); ?>">
                        <div class="form-group mb-5">
                            <label class="block mb-2 font-semibold text-xs sm:text-sm text-[var(--text-dark)]" for="name"><?php echo esc_html($form_fullname); ?> *</label>
                            <input type="text" id="name" name="from_name" class="w-full px-4 py-3.5 rounded-lg text-sm sm:text-base font-[inherit] border-[1.5px] transition-colors duration-[0.25s] focus:outline-none focus:border-[var(--gold)] focus:bg-white border-[var(--border-color)] bg-[var(--cream)]" placeholder="<?php echo esc_attr($ph_fullname); ?>" required>
                        </div>
                        <div class="form-group mb-5">
                            <label class="block mb-2 font-semibold text-xs sm:text-sm text-[var(--text-dark)]" for="phone"><?php echo esc_html($form_phone); ?> *</label>
                            <input type="tel" id="phone" name="from_phone" class="w-full px-4 py-3.5 rounded-lg text-sm sm:text-base font-[inherit] border-[1.5px] transition-colors duration-[0.25s] focus:outline-none focus:border-[var(--gold)] focus:bg-white border-[var(--border-color)] bg-[var(--cream)]" placeholder="<?php echo esc_attr($ph_phone); ?>" required>
                        </div>
                        <div class="form-group mb-5">
                            <label class="block mb-2 font-semibold text-xs sm:text-sm text-[var(--text-dark)]" for="email"><?php echo esc_html($form_email); ?> *</label>
                            <input type="email" id="email" name="from_email" class="w-full px-4 py-3.5 rounded-lg text-sm sm:text-base font-[inherit] border-[1.5px] transition-colors duration-[0.25s] focus:outline-none focus:border-[var(--gold)] focus:bg-white border-[var(--border-color)] bg-[var(--cream)]" placeholder="<?php echo esc_attr($ph_email); ?>" required>
                        </div>
                        <div class="form-group mb-5">
                            <label class="block mb-2 font-semibold text-xs sm:text-sm text-[var(--text-dark)]" for="service"><?php echo esc_html($form_service); ?> *</label>
                            <select id="service" name="service" class="hidden-select" data-required="1">
                                <option value=""><?php echo $current_lang === 'km' ? 'ជ្រើសរើសសេវាកម្ម' : 'Select a service'; ?></option>
                                <?php
                                $raw_services = get_option('custom_service_cards', '[]');
                                $all_services = json_decode($raw_services, true);
                                if (is_array($all_services)) {
                                    foreach ($all_services as $svc) {
                                        $svc_title = ($current_lang === 'km' && !empty($svc['title_km'])) ? $svc['title_km'] : ($svc['title'] ?? '');
                                        if (!empty($svc_title)) {
                                            echo '<option value="' . esc_attr($svc_title) . '"' . selected($preselect_service, $svc_title, false) . '>' . esc_html($svc_title) . '</option>';
                                        }
                                    }
                                }
                                $raw_products = get_option('custom_product_cards', '[]');
                                $all_products = json_decode($raw_products, true);
                                if (is_array($all_products)) {
                                    foreach ($all_products as $prod) {
                                        $prod_title = ($current_lang === 'km' && !empty($prod['title_km'])) ? $prod['title_km'] : ($prod['title'] ?? '');
                                        if (!empty($prod_title) && ($prod['type'] ?? '') !== 'Add') {
                                            echo '<option value="' . esc_attr($prod_title) . '">' . esc_html($prod_title) . '</option>';
                                        }
                                    }
                                }
                                ?>
                                <option value="Other"><?php echo $current_lang === 'km' ? 'ផ្សេងទៀត' : 'Other'; ?></option>
                            </select>
                            <div class="searchable-select" id="service-select">
                                <div class="searchable-select-trigger">
                                    <span class="searchable-select-value"><?php echo $current_lang === 'km' ? 'ជ្រើសរើសសេវាកម្ម' : 'Select a service'; ?></span>
                                    <svg class="searchable-select-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                </div>
                                <div class="searchable-select-dropdown">
                                    <div class="searchable-select-search">
                                        <svg class="searchable-select-search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                        <input type="text" class="searchable-select-search-input" placeholder="<?php echo $current_lang === 'km' ? 'ស្វែងរក...' : 'Search...'; ?>">
                                    </div>
                                    <div class="searchable-select-options"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-5" id="licence-group" style="display:none;" data-service="<?php echo esc_attr($licence_service_title); ?>">
                            <label class="block mb-2 font-semibold text-xs sm:text-sm text-[var(--text-dark)]" for="licence"><?php echo esc_html($form_licence); ?></label>
                            <select id="licence" name="licence" class="hidden-select">
                                <option value=""><?php echo esc_html($ph_licence); ?></option>
                                <?php foreach ($contact_licences as $contact_licence) : ?>
                                    <option value="<?php echo esc_attr($contact_licence); ?>"><?php echo esc_html($contact_licence); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="searchable-select" id="licence-select">
                                <div class="searchable-select-trigger">
                                    <span class="searchable-select-value"><?php echo esc_html($ph_licence); ?></span>
                                    <svg class="searchable-select-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                </div>
                                <div class="searchable-select-dropdown">
                                    <div class="searchable-select-search">
                                        <svg class="searchable-select-search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                        <input type="text" class="searchable-select-search-input" placeholder="<?php echo $current_lang === 'km' ? 'ស្វែងរក...' : 'Search...'; ?>">
                                    </div>
                                    <div class="searchable-select-options"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-5" id="customer-type-group" style="display:none;" data-service="<?php echo esc_attr($customer_type_service_title); ?>">
                            <label class="block mb-2 font-semibold text-xs sm:text-sm text-[var(--text-dark)]" for="customer_type"><?php echo esc_html($form_customer_type); ?></label>
                            <select id="customer_type" name="customer_type" class="hidden-select">
                                <option value=""><?php echo esc_html($ph_customer_type); ?></option>
                                <?php foreach ($contact_customer_types as $contact_customer_type) : ?>
                                    <option value="<?php echo esc_attr($contact_customer_type); ?>"><?php echo esc_html($contact_customer_type); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="searchable-select" id="customer-type-select">
                                <div class="searchable-select-trigger">
                                    <span class="searchable-select-value"><?php echo esc_html($ph_customer_type); ?></span>
                                    <svg class="searchable-select-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                </div>
                                <div class="searchable-select-dropdown">
                                    <div class="searchable-select-search">
                                        <svg class="searchable-select-search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                        <input type="text" class="searchable-select-search-input" placeholder="<?php echo $current_lang === 'km' ? 'ស្វែងរក...' : 'Search...'; ?>">
                                    </div>
                                    <div class="searchable-select-options"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-5" id="course-name-group" style="display:none;">
                            <label class="block mb-2 font-semibold text-xs sm:text-sm text-[var(--text-dark)]" for="course_name"><?php echo esc_html($form_course_name); ?> *</label>
                            <select id="course_name" name="course_name" class="hidden-select" data-required="1">
                                <option value=""><?php echo $current_lang === 'km' ? 'ជ្រើសរើសវគ្គសិក្សា' : 'Select a course'; ?></option>
                                <?php foreach ($contact_courses as $contact_course) : ?>
                                    <option value="<?php echo esc_attr($contact_course); ?>" <?php selected($preselect_course, $contact_course); ?>><?php echo esc_html($contact_course); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="searchable-select" id="course-name-select">
                                <div class="searchable-select-trigger">
                                    <span class="searchable-select-value"><?php echo $current_lang === 'km' ? 'ជ្រើសរើសវគ្គសិក្សា' : 'Select a course'; ?></span>
                                    <svg class="searchable-select-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                </div>
                                <div class="searchable-select-dropdown">
                                    <div class="searchable-select-search">
                                        <svg class="searchable-select-search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                        <input type="text" class="searchable-select-search-input" placeholder="<?php echo $current_lang === 'km' ? 'ស្វែងរក...' : 'Search...'; ?>">
                                    </div>
                                    <div class="searchable-select-options"></div>
                                </div>
                            </div>
                            <label class="block mb-2 mt-5 font-semibold text-xs sm:text-sm text-[var(--text-dark)]" for="location"><?php echo esc_html($form_location); ?> *</label>
                            <input type="text" id="location" name="location" class="w-full px-4 py-3.5 rounded-lg text-sm sm:text-base font-[inherit] border-[1.5px] transition-colors duration-[0.25s] focus:outline-none focus:border-[var(--gold)] focus:bg-white border-[var(--border-color)] bg-[var(--cream)]" placeholder="<?php echo esc_attr($ph_location); ?>">
                            <div class="course-opt-row" id="course-mode-group">
                                <span class="course-opt-label"><?php echo esc_html($form_mode); ?></span>
                                <label class="course-opt-pill" for="mode_online">
                                    <input type="checkbox" id="mode_online" name="course_mode[]" value="Online">
                                    <span><?php echo esc_html($opt_online); ?></span>
                                </label>
                                <label class="course-opt-pill" for="mode_inperson">
                                    <input type="checkbox" id="mode_inperson" name="course_mode[]" value="In-Person Learning">
                                    <span><?php echo esc_html($opt_inperson); ?></span>
                                </label>
                            </div>
                            <div class="course-opt-row" id="course-register-group">
                                <span class="course-opt-label"><?php echo esc_html($form_register); ?></span>
                                <label class="course-opt-pill" for="register_group">
                                    <input type="checkbox" id="register_group" name="course_register[]" value="Group">
                                    <span><?php echo esc_html($opt_group); ?></span>
                                </label>
                                <label class="course-opt-pill" for="register_single">
                                    <input type="checkbox" id="register_single" name="course_register[]" value="Single">
                                    <span><?php echo esc_html($opt_single); ?></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group mb-5">
                            <label class="block mb-2 font-semibold text-xs sm:text-sm text-[var(--text-dark)]" for="message"><?php echo esc_html($form_message); ?> *</label>
                            <textarea id="message" name="message" rows="4" class="w-full px-4 py-3.5 rounded-lg text-sm sm:text-base font-[inherit] border-[1.5px] transition-colors duration-[0.25s] focus:outline-none focus:border-[var(--gold)] focus:bg-white min-h-[140px] resize-y border-[var(--border-color)] bg-[var(--cream)]" placeholder="<?php echo esc_attr($ph_message); ?>" required></textarea>
                        </div>
                        <div class="form-group mb-5">
                            <label class="block mb-2 font-semibold text-xs sm:text-sm text-[var(--text-dark)]" for="contact_date"><?php echo esc_html($form_date); ?> *</label>
                            <div class="picker-wrapper" id="date-wrapper">
                                <button type="button" class="display-field" id="displayField">
                                    <span id="displayText"><?php echo $current_lang === 'km' ? 'ជ្រើសរើសកាលបរិច្ឆេទ' : 'Select date'; ?></span>
                                    <svg class="calendar-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                </button>
                                <input type="hidden" id="contact_date" name="contact_date" value="" data-required="1">
                                <div class="picker-panel" id="pickerPanel">
                                    <div class="dropdown-row">
                                        <div class="dropdown" id="monthDropdown">
                                            <button type="button" class="dropdown-button" data-dropdown="month">
                                                <span id="monthLabel"></span>
                                            </button>
                                            <div class="dropdown-list" id="monthList"></div>
                                        </div>
                                        <div class="dropdown" id="yearDropdown">
                                            <button type="button" class="dropdown-button" data-dropdown="year">
                                                <span id="yearLabel"></span>
                                            </button>
                                            <div class="dropdown-list" id="yearList"></div>
                                        </div>
                                        <div class="dropdown" id="timeDropdown">
                                            <button type="button" class="dropdown-button" data-dropdown="time">
                                                <span id="timeLabel">00:00</span>
                                            </button>
                                            <div class="dropdown-list" id="timeList"></div>
                                        </div>
                                    </div>
                                    <div class="weekday-row">
                                        <div class="weekday-cell">Su</div>
                                        <div class="weekday-cell">Mo</div>
                                        <div class="weekday-cell">Tu</div>
                                        <div class="weekday-cell">We</div>
                                        <div class="weekday-cell">Th</div>
                                        <div class="weekday-cell">Fr</div>
                                        <div class="weekday-cell">Sa</div>
                                    </div>
                                    <div class="days-grid" id="daysGrid"></div>
                                </div>
                            </div>
                        </div>
                        <div id="form-status" style="display:none;margin-bottom:16px;padding:12px;border-radius:8px;font-size:0.9rem;"></div>
                        <div class="flex justify-center">
                           <button type="submit" class="btn btn-gold"><?php echo esc_html($form_submit); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ + MAP -->
    <?php
    $faqs = json_decode(get_option('custom_contact_faqs', '[]'), true);
    if (!is_array($faqs)) $faqs = array();
    $current_lang = futuristic_it_get_current_lang();
    $map_lat = get_option('custom_contact_lat', '11.5564');
    $map_lng = get_option('custom_contact_lng', '104.9282');
    if (!empty($faqs)) :
    ?>
    <section class="section py-[90px] px-0 bg-[var(--cream)]">
        <div class="container">
            <!-- Map Top -->
            <div class="mb-[50px]" data-anim="fade-up">
                <div class="rounded-2xl overflow-hidden border border-[rgba(13,61,47,0.06)] shadow-[0_8px_32px_rgba(0,0,0,0.08)]" style="height:450px;">
                    <iframe
                        src="https://maps.google.com/maps?q=<?php echo esc_attr($map_lat); ?>,<?php echo esc_attr($map_lng); ?>&z=15&output=embed"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>

            <!-- FAQ Bottom -->
            <div data-anim="fade-up" data-anim-delay="100">
                <span class="dependable-eyebrow"><?php echo esc_html(futuristic_it_t('custom_faq_tagline')); ?></span>
                <h2 class="section-title mb-2 relative pb-4 text-left"><?php echo esc_html(futuristic_it_t('custom_faq_title')); ?><span class="absolute bottom-0 left-0 w-[50px] h-[3px] rounded-[2px] bg-[var(--gold)]"></span></h2>
                <p class="section-subtitle text-left mb-[30px]"><?php echo esc_html(futuristic_it_t('custom_faq_subtitle')); ?></p>
                <div class="faq-container flex flex-col gap-3">
                    <?php foreach ($faqs as $faq) : ?>
                    <?php
                        $faq_q = ($current_lang === 'km' && !empty($faq['q_km'])) ? $faq['q_km'] : ($faq['q'] ?? '');
                        $faq_a = ($current_lang === 'km' && !empty($faq['a_km'])) ? $faq['a_km'] : ($faq['a'] ?? '');
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

<script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script>
    (function() {
        emailjs.init({ publicKey: 'rwd1dIEfQIl-hzTEG' });

        var form = document.getElementById('contact-form');
        var submitBtn = form ? form.querySelector('button[type="submit"]') : null;

        // The Service and Date controls are custom widgets whose real inputs are
        // hidden (a display:none <select> and a type="hidden" input). Browsers
        // cannot show a validation bubble for those, so they are checked here.
        var widgetFields = [
            {
                input: document.getElementById('service'),
                visible: document.querySelector('#service-select .searchable-select-trigger'),
                msgEn: 'Please select a service.',
                msgKm: 'សូមជ្រើសរើសសេវាកម្ម។'
            },
            {
                // Only enforced while the course group is visible; see the
                // `skip` check in firstInvalidWidget.
                input: document.getElementById('course_name'),
                visible: document.querySelector('#course-name-select .searchable-select-trigger'),
                required: function () {
                    var g = document.getElementById('course-name-group');
                    return !!g && g.style.display !== 'none';
                },
                msgEn: 'Please select a course.',
                msgKm: 'សូមជ្រើសរើសវគ្គសិក្សា។'
            },
            {
                // Only enforced while the licence group is visible; see the
                // `skip` check in firstInvalidWidget.
                input: document.getElementById('licence'),
                visible: document.querySelector('#licence-select .searchable-select-trigger'),
                required: function () {
                    var g = document.getElementById('licence-group');
                    return !!g && g.style.display !== 'none';
                },
                msgEn: 'Please select a licence.',
                msgKm: 'សូមជ្រើសរើសអាជ្ញាបណ្ណ។'
            },
            {
                // Only enforced while the customer type group is visible.
                input: document.getElementById('customer_type'),
                visible: document.querySelector('#customer-type-select .searchable-select-trigger'),
                required: function () {
                    var g = document.getElementById('customer-type-group');
                    return !!g && g.style.display !== 'none';
                },
                msgEn: 'Please select a customer type.',
                msgKm: 'សូមជ្រើសរើសប្រភេទអតិថិជន។'
            },
            {
                input: document.getElementById('contact_date'),
                visible: document.getElementById('displayField'),
                msgEn: 'Please select a date.',
                msgKm: 'សូមជ្រើសរើសកាលបរិច្ឆេទ។'
            }
        ];

        function flagInvalid(field) {
            if (!field.visible) return;
            field.visible.style.borderColor = '#dc3545';
            field.visible.style.boxShadow = '0 0 0 3px rgba(220,53,69,0.12)';
            field.visible.addEventListener('click', function clear() {
                field.visible.style.borderColor = '';
                field.visible.style.boxShadow = '';
                field.visible.removeEventListener('click', clear);
            });
        }

        function firstInvalidWidget(isKm) {
            for (var i = 0; i < widgetFields.length; i++) {
                var f = widgetFields[i];
                // A field inside the collapsed course group is not applicable,
                // so it must not block submission.
                if (f.required && !f.required()) continue;
                if (f.input && String(f.input.value || '').trim() === '') {
                    flagInvalid(f);
                    return isKm ? f.msgKm : f.msgEn;
                }
            }
            return null;
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            var isKm = document.cookie.indexOf('site_lang=km') !== -1 || window.location.search.indexOf('site_lang=km') !== -1;

            var widgetError = firstInvalidWidget(isKm);
            if (widgetError) {
                Swal.fire({
                    icon: 'warning',
                    title: isKm ? 'សូមបំពេញព័ត៌មាន' : 'Please complete the form',
                    text: widgetError,
                    showConfirmButton: false,
                    timer: 3000,
                    toast: true,
                    position: 'top-end'
                });
                return;
            }

            submitBtn.disabled = true;
            submitBtn.textContent = isKm ? 'កំពុងផ្ញើ...' : 'Sending...';

            // Collect the ticked boxes of one option row as a comma-joined string.
            function checkedValues(scope, selector) {
                var boxes = scope.querySelectorAll(selector + ' input[type="checkbox"]:checked');
                var out = [];
                for (var i = 0; i < boxes.length; i++) out.push(boxes[i].value);
                return out.join(', ');
            }

            var contactDateInput = document.getElementById('contact_date');
            var contactDateVal = contactDateInput ? contactDateInput.value : '';
            var templateParams = {
                contact_date: contactDateVal,
                from_name: form.from_name.value,
                from_email: form.from_email.value,
                from_phone: form.from_phone.value,
                service: form.service.value,
                course_name: form.course_name ? form.course_name.value : '',
                licence: form.licence ? form.licence.value : '',
                customer_type: form.customer_type ? form.customer_type.value : '',
                location: form.location ? form.location.value : '',
                course_mode: checkedValues(form, '#course-mode-group'),
                course_register: checkedValues(form, '#course-register-group'),
                message: form.message.value,
                to_email: form.dataset.toEmail
            };

            emailjs.send('service_y0h7irh', 'template_s1f4ehw', templateParams)
                .then(function() {
                    Swal.fire({
                        icon: 'success',
                        title: isKm ? 'បានផ្ញើសារជោគជ័យ!' : 'Message sent successfully!',
                        showConfirmButton: false,
                        timer: 3000,
                        toast: true,
                        position: 'top-end'
                    });
                    form.reset();
                    // form.reset() restores each native <select> to its placeholder
                    // option, but the custom widgets render their own label span,
                    // so reset those too or they keep showing the old choice.
                    ['#service-select', '#course-name-select', '#licence-select', '#customer-type-select'].forEach(function (sel) {
                        var wrap = document.querySelector(sel);
                        if (!wrap) return;
                        var value = wrap.querySelector('.searchable-select-value');
                        var ph = wrap.querySelector('.searchable-select-option.placeholder');
                        if (value && ph) { value.textContent = ph.textContent; value.classList.add('placeholder'); }
                    });
                    var cd = document.getElementById('contact_date');
                    if (cd) cd.value = '';
                    var dt = document.getElementById('displayText');
                    var isKmReset = document.cookie.indexOf('site_lang=km') !== -1 || window.location.search.indexOf('site_lang=km') !== -1;
                    if (dt) dt.textContent = isKmReset ? 'ជ្រើសរើសកាលបរិច្ឆេទ' : 'Select date';
                    var tl = document.getElementById('timeLabel');
                    if (tl) tl.textContent = '00:00';
                    var pp = document.getElementById('pickerPanel');
                    if (pp) pp.classList.remove('open');
                })
                .catch(function() {
                    Swal.fire({
                        icon: 'error',
                        title: isKm ? 'សូមអភ័យទោស...' : 'Oops...',
                        text: isKm ? 'មានកំហុស។ សូមព្យាយាមម្ដងទៀត។' : 'Something went wrong. Please try again later.',
                        showConfirmButton: false,
                        timer: 3000,
                        toast: true,
                        position: 'top-end'
                    });
                })
                .finally(function() {
                    submitBtn.disabled = false;
                    submitBtn.textContent = isKm ? 'ផ្ញើសារ' : '<?php _e('Submit', 'futuristic-it'); ?>';
                });
        });
    })();
</script>

<script>
(function() {
    const MONTH_NAMES = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    const KM_MONTH_NAMES = ['មករា','កុម្ភៈ','មីនា','មេសា','ឧសភា','មិថុនា','កក្កដា','សីហា','កញ្ញា','តុលា','វិច្ឆិកា','ធ្នូ'];
    const KM_DAYS = ['អាទិត្យ','ចន្ទ','អង្គារ','ពុធ','ព្រហស្បតិ៍','សុក្រ','សៅរ៍'];
    const KM_DAYS_SHORT = ['អា','ច','អ','ពុ','ព្រ','សក','ស'];

    function getLang() {
        return document.cookie.indexOf('site_lang=km') !== -1 || window.location.search.indexOf('site_lang=km') !== -1 ? 'km' : 'en';
    }

    function initDatePicker() {
        const wrapper = document.getElementById('date-wrapper');
        if (!wrapper) return;

        const display = document.getElementById('displayField');
        const displayText = document.getElementById('displayText');
        const panel = document.getElementById('pickerPanel');
        const hiddenInput = document.getElementById('contact_date');
        const monthLabel = document.getElementById('monthLabel');
        const yearLabel = document.getElementById('yearLabel');
        const timeLabel = document.getElementById('timeLabel');
        const monthList = document.getElementById('monthList');
        const yearList = document.getElementById('yearList');
        const timeList = document.getElementById('timeList');
        const daysGrid = document.getElementById('daysGrid');

        let selectedDate = null;
        let selectedTime = '00:00';
        let currentMonth, currentYear;

        function isOpen() { return panel.classList.contains('open'); }
        function openPicker() { renderAll(); panel.classList.add('open'); wrapper.classList.add('open'); }
        function closePicker() { panel.classList.remove('open'); wrapper.classList.remove('open'); }
        function togglePicker() { isOpen() ? closePicker() : openPicker(); }

        display.addEventListener('click', togglePicker);

        document.addEventListener('click', function(e) {
            if (!wrapper.contains(e.target)) closePicker();
        });

        function updateDisplay() {
            if (!selectedDate) return;
            const lang = getLang();
            const timeStr = selectedTime;
            if (lang === 'km') {
                const dayKhmer = selectedDate.getDate();
                const monthKhmer = KM_MONTH_NAMES[selectedDate.getMonth()];
                const yearKhmer = selectedDate.getFullYear();
                displayText.textContent = dayKhmer + ' ' + monthKhmer + ' ' + yearKhmer + ' ' + timeStr;
            } else {
                const months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
                displayText.textContent = selectedDate.getDate() + ' ' + months[selectedDate.getMonth()] + ' ' + selectedDate.getFullYear() + ' ' + timeStr;
            }
        }

        function setInitialMonthYear() {
            const now = new Date();
            currentMonth = selectedDate ? selectedDate.getMonth() : now.getMonth();
            currentYear = selectedDate ? selectedDate.getFullYear() : now.getFullYear();
        }

        setInitialMonthYear();

        function renderMonthDropdown() {
            monthList.innerHTML = '';
            const lang = getLang();
            const names = lang === 'km' ? KM_MONTH_NAMES : MONTH_NAMES;
            names.forEach(function(name, index) {
                const item = document.createElement('div');
                item.className = 'dropdown-item' + (index === currentMonth ? ' selected' : '');
                item.textContent = name;
                item.dataset.value = index;
                monthList.appendChild(item);
            });
            monthLabel.textContent = names[currentMonth];
        }

        function renderYearDropdown() {
            yearList.innerHTML = '';
            const currentYearVal = new Date().getFullYear();
            const startYear = 2000;
            const endYear = currentYearVal + 5;
            for (let i = startYear; i <= endYear; i++) {
                const item = document.createElement('div');
                item.className = 'dropdown-item' + (i === currentYear ? ' selected' : '');
                item.textContent = i;
                item.dataset.value = i;
                yearList.appendChild(item);
            }
            yearLabel.textContent = currentYear;
        }

        function renderDaysGrid() {
            daysGrid.innerHTML = '';
            const firstDay = new Date(currentYear, currentMonth, 1).getDay();
            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
            const daysInPrevMonth = new Date(currentYear, currentMonth, 0).getDate();
            const now = new Date();
            for (let i = firstDay - 1; i >= 0; i--) {
                const cell = document.createElement('div');
                cell.className = 'day-cell muted';
                cell.textContent = daysInPrevMonth - i;
                daysGrid.appendChild(cell);
            }
            for (let i = 1; i <= daysInMonth; i++) {
                const cell = document.createElement('div');
                cell.className = 'day-cell';
                if (selectedDate && selectedDate.getDate() === i && selectedDate.getMonth() === currentMonth && selectedDate.getFullYear() === currentYear) {
                    cell.classList.add('selected');
                }
                if (now.getDate() === i && now.getMonth() === currentMonth && now.getFullYear() === currentYear && !selectedDate) {
                    cell.classList.add('today');
                }
                cell.textContent = i;
                cell.dataset.day = i;
                daysGrid.appendChild(cell);
            }
            const totalCells = firstDay + daysInMonth;
            const remaining = totalCells % 7 === 0 ? 0 : 7 - (totalCells % 7);
            for (let i = 1; i <= remaining; i++) {
                const cell = document.createElement('div');
                cell.className = 'day-cell muted';
                cell.textContent = i;
                daysGrid.appendChild(cell);
            }
        }

        function renderTimeList() {
            timeList.innerHTML = '';
            for (let h = 0; h < 24; h++) {
                for (let m = 0; m < 60; m += 30) {
                    const hh = h < 10 ? '0' + h : '' + h;
                    const mm = m < 10 ? '0' + m : '' + m;
                    const val = hh + ':' + mm;
                    const item = document.createElement('div');
                    item.className = 'dropdown-item' + (val === selectedTime ? ' selected' : '');
                    item.textContent = val;
                    item.dataset.value = val;
                    timeList.appendChild(item);
                }
            }
            timeLabel.textContent = selectedTime;
        }

        function renderAll() { renderMonthDropdown(); renderYearDropdown(); renderTimeList(); renderDaysGrid(); }

        monthList.addEventListener('click', function(e) {
            const item = e.target.closest('.dropdown-item');
            if (item) { currentMonth = parseInt(item.dataset.value); renderAll(); }
        });

        yearList.addEventListener('click', function(e) {
            const item = e.target.closest('.dropdown-item');
            if (item) { currentYear = parseInt(item.dataset.value); renderAll(); }
        });

        timeList.addEventListener('click', function(e) {
            const item = e.target.closest('.dropdown-item');
            if (item) { selectedTime = item.dataset.value; renderAll(); updateDisplay(); updateHiddenValue(); }
        });

        daysGrid.addEventListener('click', function(e) {
            const cell = e.target.closest('.day-cell');
            if (cell && !cell.classList.contains('empty') && !cell.classList.contains('muted')) {
                const day = parseInt(cell.dataset.day);
                selectedDate = new Date(currentYear, currentMonth, day);
                updateHiddenValue();
                updateDisplay();
                closePicker();
            }
        });

        function updateHiddenValue() {
            if (selectedDate) {
                const pad = function(n) { return n < 10 ? '0' + n : '' + n; };
                hiddenInput.value = selectedDate.getFullYear() + '-' + pad(selectedDate.getMonth() + 1) + '-' + pad(selectedDate.getDate()) + ' ' + selectedTime;
            }
        }

        document.querySelectorAll('.dropdown-button').forEach(function(btn) {
            btn.addEventListener('click', function() {
                const dropdown = btn.closest('.dropdown');
                const isOpenDropdown = dropdown.classList.contains('open');
                document.querySelectorAll('.dropdown').forEach(function(d) { d.classList.remove('open'); });
                if (!isOpenDropdown) dropdown.classList.add('open');
            });
        });

        document.addEventListener('click', function(e) {
            document.querySelectorAll('.dropdown').forEach(function(d) {
                if (!d.contains(e.target)) d.classList.remove('open');
            });
        });

        renderAll();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initDatePicker);
    } else {
        initDatePicker();
    }
})();
</script>

<?php get_footer(); ?>
