<?php
/**
 * Futuristic IT Theme Functions
 */

// Theme Setup
function futuristic_it_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('customize-selective-refresh-widgets');
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'futuristic-it'),
        'footer' => __('Footer Menu', 'futuristic-it'),
    ));
}
add_action('after_setup_theme', 'futuristic_it_theme_setup');

// Load templates from subfolders
function futuristic_it_custom_templates($template) {
    if (is_front_page()) {
        $custom = get_template_directory() . '/home/front-page.php';
        if (file_exists($custom)) return $custom;
    }
    if (is_page_template('page-about.php')) {
        $custom = get_template_directory() . '/about/page-about.php';
        if (file_exists($custom)) return $custom;
    }
    if (is_page_template('page-contact.php')) {
        $custom = get_template_directory() . '/contact/page-contact.php';
        if (file_exists($custom)) return $custom;
    }
    if (is_page_template('page-products.php')) {
        $custom = get_template_directory() . '/products/page-products.php';
        if (file_exists($custom)) return $custom;
    }
    if (is_page_template('page-services.php')) {
        $custom = get_template_directory() . '/services/page-services.php';
        if (file_exists($custom)) return $custom;
    }
    if (is_page_template('services/page-procurement.php')) {
        $custom = get_template_directory() . '/services/page-procurement.php';
        if (file_exists($custom)) return $custom;
    }
    if (is_singular('product')) {
        $custom = get_template_directory() . '/product/single-product.php';
        if (file_exists($custom)) return $custom;
    }
    if (is_post_type_archive('product')) {
        $custom = get_template_directory() . '/products/archive-product.php';
        if (file_exists($custom)) return $custom;
    }
    return $template;
}
add_filter('template_include', 'futuristic_it_custom_templates');

// Enqueue Scripts and Styles
function futuristic_it_scripts() {
    wp_enqueue_style('futuristic-it-style', get_template_directory_uri() . '/style.css', array(), filemtime(get_template_directory() . '/style.css'));
    wp_enqueue_style('futuristic-it-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Noto+Sans+Khmer:wght@400;500;600;700&display=swap', array(), null);
    wp_enqueue_style('swiper-css', get_template_directory_uri() . '/vendor/swiper/swiper-bundle.min.css', array(), '11.0.0');
    wp_enqueue_style('futuristic-it-floating-contact', get_template_directory_uri() . '/assets/css/floating-contact.css', array(), filemtime(get_template_directory() . '/assets/css/floating-contact.css'));
    wp_enqueue_script('jquery');
    wp_enqueue_script('swiper-js', get_template_directory_uri() . '/vendor/swiper/swiper-bundle.min.js', array(), '11.0.0', true);
    // Versioned by modification time, like the stylesheets above. A fixed
    // version string left the URL unchanged across edits, and the host serves
    // this file `immutable, max-age=2592000` — so a browser that had loaded the
    // site once kept the old file for 30 days and never picked up a change.
    wp_enqueue_script('futuristic-it-js', get_template_directory_uri() . '/js/main.js', array('swiper-js'), filemtime(get_template_directory() . '/js/main.js'), true);
}
add_action('wp_enqueue_scripts', 'futuristic_it_scripts');

// Gutenberg Block Editor Support
function futuristic_it_gutenberg_support() {
    add_theme_support('editor-styles');
    add_theme_support('align-wide');
    add_theme_support('wp-block-styles');
    add_theme_support('responsive-embeds');
    add_theme_support('editor-color-palette', array(
        array('name' => 'Dark Green', 'slug' => 'dark-green', 'color' => '#142e1f'),
        array('name' => 'Primary Green', 'slug' => 'primary-green', 'color' => '#1a3d27'),
        array('name' => 'Gold', 'slug' => 'gold', 'color' => '#d4a843'),
        array('name' => 'Gold Dark', 'slug' => 'gold-dark', 'color' => '#b8892f'),
        array('name' => 'Cream', 'slug' => 'cream', 'color' => '#f7f6f1'),
        array('name' => 'White', 'slug' => 'white', 'color' => '#ffffff'),
    ));
    add_theme_support('editor-font-sizes', array(
        array('name' => 'Small', 'slug' => 'small', 'size' => 14),
        array('name' => 'Normal', 'slug' => 'normal', 'size' => 16),
        array('name' => 'Medium', 'slug' => 'medium', 'size' => 20),
        array('name' => 'Large', 'slug' => 'large', 'size' => 28),
        array('name' => 'Huge', 'slug' => 'huge', 'size' => 36),
    ));
}
add_action('after_setup_theme', 'futuristic_it_gutenberg_support');

function futuristic_it_editor_styles() {
    add_editor_style('editor-style.css');
}
add_action('after_setup_theme', 'futuristic_it_editor_styles');

function futuristic_it_register_block_patterns() {
    register_block_pattern_category('futuristic-it', array(
        'label' => __('Futuristic IT', 'futuristic-it'),
    ));
}
add_action('init', 'futuristic_it_register_block_patterns');

// Register Custom Post Types
function futuristic_it_register_services() {
    $labels = array(
        'name' => __('Services', 'futuristic-it'),
        'singular_name' => __('Service', 'futuristic-it'),
        'menu_name' => __('Services', 'futuristic-it'),
        'add_new' => __('Add New', 'futuristic-it'),
        'add_new_item' => __('Add New Service', 'futuristic-it'),
        'edit_item' => __('Edit Service', 'futuristic-it'),
        'new_item' => __('New Service', 'futuristic-it'),
        'view_item' => __('View Service', 'futuristic-it'),
        'search_items' => __('Search Services', 'futuristic-it'),
        'not_found' => __('No services found', 'futuristic-it'),
        'not_found_in_trash' => __('No services found in Trash', 'futuristic-it'),
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'publicly_queryable' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'services'),
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => 3,
        'menu_icon' => 'dashicons-admin-generic',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest' => true,
    );
    register_post_type('service', $args);
}
add_action('init', 'futuristic_it_register_services');

function futuristic_it_register_products() {
    $labels = array(
        'name' => __('Products', 'futuristic-it'),
        'singular_name' => __('Product', 'futuristic-it'),
        'menu_name' => __('Products', 'futuristic-it'),
        'add_new' => __('Add New', 'futuristic-it'),
        'add_new_item' => __('Add New Product', 'futuristic-it'),
        'edit_item' => __('Edit Product', 'futuristic-it'),
        'new_item' => __('New Product', 'futuristic-it'),
        'view_item' => __('View Product', 'futuristic-it'),
        'search_items' => __('Search Products', 'futuristic-it'),
        'not_found' => __('No products found', 'futuristic-it'),
        'not_found_in_trash' => __('No products found in Trash', 'futuristic-it'),
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'publicly_queryable' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'product-archive'),
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => 6,
        'menu_icon' => 'dashicons-cart',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest' => true,
    );
    register_post_type('product', $args);
}
add_action('init', 'futuristic_it_register_products');

function futuristic_it_register_product_categories() {
    $labels = array(
        'name' => __('Product Categories', 'futuristic-it'),
        'singular_name' => __('Product Category', 'futuristic-it'),
        'menu_name' => __('Categories', 'futuristic-it'),
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'rewrite' => array('slug' => 'product-category'),
        'show_in_rest' => true,
    );
    register_taxonomy('product_category', 'product', $args);
}
add_action('init', 'futuristic_it_register_product_categories');

function futuristic_it_register_team() {
    $labels = array(
        'name' => __('Team Members', 'futuristic-it'),
        'singular_name' => __('Team Member', 'futuristic-it'),
        'menu_name' => __('Team', 'futuristic-it'),
        'add_new' => __('Add New', 'futuristic-it'),
        'add_new_item' => __('Add New Team Member', 'futuristic-it'),
        'edit_item' => __('Edit Team Member', 'futuristic-it'),
        'new_item' => __('New Team Member', 'futuristic-it'),
        'view_item' => __('View Team Member', 'futuristic-it'),
        'search_items' => __('Search Team Members', 'futuristic-it'),
        'not_found' => __('No team members found', 'futuristic-it'),
        'not_found_in_trash' => __('No team members found in Trash', 'futuristic-it'),
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => false,
        'publicly_queryable' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'team'),
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => 7,
        'menu_icon' => 'dashicons-groups',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest' => true,
    );
    register_post_type('team', $args);
}
add_action('init', 'futuristic_it_register_team');

function futuristic_it_register_partners() {
    $labels = array(
        'name' => __('Partners', 'futuristic-it'),
        'singular_name' => __('Partner', 'futuristic-it'),
        'menu_name' => __('Partners', 'futuristic-it'),
        'add_new' => __('Add New', 'futuristic-it'),
        'add_new_item' => __('Add New Partner', 'futuristic-it'),
        'edit_item' => __('Edit Partner', 'futuristic-it'),
        'new_item' => __('New Partner', 'futuristic-it'),
        'view_item' => __('View Partner', 'futuristic-it'),
        'search_items' => __('Search Partners', 'futuristic-it'),
        'not_found' => __('No partners found', 'futuristic-it'),
        'not_found_in_trash' => __('No partners found in Trash', 'futuristic-it'),
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => false,
        'publicly_queryable' => false,
        'query_var' => false,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => 8,
        'menu_icon' => 'dashicons-businessperson',
        'supports' => array('title', 'thumbnail'),
        'show_in_rest' => true,
    );
    register_post_type('partner', $args);
}
add_action('init', 'futuristic_it_register_partners');

function futuristic_it_register_cta_features() {
    $labels = array(
        'name' => __('CTA Features', 'futuristic-it'),
        'singular_name' => __('CTA Feature', 'futuristic-it'),
        'menu_name' => __('CTA Features', 'futuristic-it'),
        'add_new' => __('Add New', 'futuristic-it'),
        'add_new_item' => __('Add New CTA Feature', 'futuristic-it'),
        'edit_item' => __('Edit CTA Feature', 'futuristic-it'),
        'new_item' => __('New CTA Feature', 'futuristic-it'),
        'view_item' => __('View CTA Feature', 'futuristic-it'),
        'search_items' => __('Search CTA Features', 'futuristic-it'),
        'not_found' => __('No CTA features found', 'futuristic-it'),
        'not_found_in_trash' => __('No CTA features found in Trash', 'futuristic-it'),
    );
    $args = array(
        'labels' => $labels,
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'publicly_queryable' => false,
        'query_var' => false,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => 9,
        'menu_icon' => 'dashicons-yes-alt',
        'supports' => array('title', 'editor', 'page-attributes'),
        'show_in_rest' => true,
    );
    register_post_type('cta_feature', $args);
}
add_action('init', 'futuristic_it_register_cta_features');

// Meta Boxes
function futuristic_it_add_product_meta_boxes() {
    add_meta_box('product_details', __('Product Details', 'futuristic-it'), 'futuristic_it_product_meta_box_callback', 'product', 'normal', 'high');
}
add_action('add_meta_boxes', 'futuristic_it_add_product_meta_boxes');

function futuristic_it_product_meta_box_callback($post) {
    wp_nonce_field('futuristic_it_product_meta_box', 'futuristic_it_product_meta_box_nonce');
    $price = get_post_meta($post->ID, '_product_price', true);
    $features = get_post_meta($post->ID, '_product_features', true);
    $specs = get_post_meta($post->ID, '_product_specs', true);
    ?>
    <style>
        .product-meta-row { display: flex; gap: 20px; margin-bottom: 15px; }
        .product-meta-row .meta-field { flex: 1; }
        .product-meta-row label { display: block; font-weight: 600; margin-bottom: 5px; }
    </style>
    <div class="product-meta-row">
        <div class="meta-field">
            <label><?php _e('Price', 'futuristic-it'); ?></label>
            <input type="text" name="product_price" value="<?php echo esc_attr($price); ?>" class="widefat" placeholder="$289.00">
        </div>
    </div>
    <div class="meta-field" style="margin-bottom:15px;">
        <label><?php _e('Features (one per line, format: Label: Value)', 'futuristic-it'); ?></label>
        <textarea name="product_features" class="widefat" rows="6" placeholder="Viewable Size: 27&quot;&#10;Resolution: QHD (2560×1440)&#10;Panel Technology: IPS"><?php echo esc_textarea($features); ?></textarea>
        <p class="description"><?php _e('Enter each feature on a new line. Use colon (:) to separate label from value.', 'futuristic-it'); ?></p>
    </div>
    <?php
}

function futuristic_it_save_product_meta($post_id) {
    if (!isset($_POST['futuristic_it_product_meta_box_nonce'])) return;
    if (!wp_verify_nonce($_POST['futuristic_it_product_meta_box_nonce'], 'futuristic_it_product_meta_box')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (isset($_POST['product_price'])) update_post_meta($post_id, '_product_price', sanitize_text_field($_POST['product_price']));
    if (isset($_POST['product_features'])) update_post_meta($post_id, '_product_features', sanitize_textarea_field($_POST['product_features']));
}
add_action('save_post', 'futuristic_it_save_product_meta');

function futuristic_it_add_team_meta_boxes() {
    add_meta_box('team_details', __('Team Member Details', 'futuristic-it'), 'futuristic_it_team_meta_box_callback', 'team', 'normal', 'high');
}
add_action('add_meta_boxes', 'futuristic_it_add_team_meta_boxes');

function futuristic_it_team_meta_box_callback($post) {
    wp_nonce_field('futuristic_it_team_meta_box', 'futuristic_it_team_meta_box_nonce');
    $role = get_post_meta($post->ID, '_team_role', true);
    echo '<label for="team_role">' . __('Role/Position:', 'futuristic-it') . '</label>';
    echo '<input type="text" id="team_role" name="team_role" value="' . esc_attr($role) . '" class="widefat">';
}

function futuristic_it_save_team_meta($post_id) {
    if (!isset($_POST['futuristic_it_team_meta_box_nonce'])) return;
    if (!wp_verify_nonce($_POST['futuristic_it_team_meta_box_nonce'], 'futuristic_it_team_meta_box')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (isset($_POST['team_role'])) update_post_meta($post_id, '_team_role', sanitize_text_field($_POST['team_role']));
}
add_action('save_post', 'futuristic_it_save_team_meta');

function futuristic_it_add_cta_feature_meta_boxes() {
    add_meta_box('cta_feature_icon', __('CTA Feature Icon', 'futuristic-it'), 'futuristic_it_cta_feature_meta_box_callback', 'cta_feature', 'normal', 'high');
}
add_action('add_meta_boxes', 'futuristic_it_add_cta_feature_meta_boxes');

function futuristic_it_cta_feature_meta_box_callback($post) {
    wp_nonce_field('futuristic_it_cta_feature_meta_box', 'futuristic_it_cta_feature_meta_box_nonce');
    $icon = get_post_meta($post->ID, '_cta_icon', true);
    echo '<label for="cta_icon">' . __('Icon (emoji or character):', 'futuristic-it') . '</label>';
    echo '<input type="text" id="cta_icon" name="cta_icon" value="' . esc_attr($icon) . '" class="widefat" placeholder="e.g., 🎧, 🎓, 🔄">';
}

function futuristic_it_save_cta_feature_meta($post_id) {
    if (!isset($_POST['futuristic_it_cta_feature_meta_box_nonce'])) return;
    if (!wp_verify_nonce($_POST['futuristic_it_cta_feature_meta_box_nonce'], 'futuristic_it_cta_feature_meta_box')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (isset($_POST['cta_icon'])) update_post_meta($post_id, '_cta_icon', sanitize_text_field($_POST['cta_icon']));
}
add_action('save_post', 'futuristic_it_save_cta_feature_meta');

// === Futuristict Website Admin Menu ===
function futuristic_it_admin_menu() {
    add_menu_page(
        __('Futuristict Website', 'futuristic-it'),
        __('Futuristict Website', 'futuristic-it'),
        'manage_options',
        'futuristict-website',
        'futuristict_homepage_page',
        'dashicons-admin-site',
        2
    );

    remove_submenu_page('futuristict-website', 'futuristict-website');

    // Home
    add_submenu_page('futuristict-website', __('Homepage', 'futuristic-it'), __('Home', 'futuristic-it'), 'manage_options', 'futuristict-homepage', 'futuristict_homepage_page');
    add_submenu_page('futuristict-homepage', __('Hero Section', 'futuristic-it'), __('Hero Section', 'futuristic-it'), 'manage_options', 'futuristict-homepage-hero', 'futuristict_homepage_hero_page');
    add_submenu_page('futuristict-homepage', __('Services Section', 'futuristic-it'), __('Services Section', 'futuristic-it'), 'manage_options', 'futuristict-homepage-services', 'futuristict_homepage_services_page');
    add_submenu_page('futuristict-homepage', __('Products Section', 'futuristic-it'), __('Products Section', 'futuristic-it'), 'manage_options', 'futuristict-homepage-products', 'futuristict_homepage_products_page');
    add_submenu_page('futuristict-homepage', __('Why Choose Us', 'futuristic-it'), __('Why Choose Us', 'futuristic-it'), 'manage_options', 'futuristict-homepage-partners', 'futuristict_homepage_partners_page');
    add_submenu_page('futuristict-homepage', __('CTA / Assurance', 'futuristic-it'), __('CTA / Assurance', 'futuristic-it'), 'manage_options', 'futuristict-homepage-cta', 'futuristict_homepage_cta_page');

    // About Page
    add_submenu_page('futuristict-website', __('About Page', 'futuristic-it'), __('About Us', 'futuristic-it'), 'manage_options', 'futuristict-about', 'futuristict_about_page');
    add_submenu_page('futuristict-about', __('Hero Section', 'futuristic-it'), __('Hero Section', 'futuristic-it'), 'manage_options', 'futuristict-about-hero', 'futuristict_about_hero_page');
    add_submenu_page('futuristict-about', __('Our Story', 'futuristic-it'), __('Our Story', 'futuristic-it'), 'manage_options', 'futuristict-about-story', 'futuristict_about_story_page');
    add_submenu_page('futuristict-about', __('Core Philosophy', 'futuristic-it'), __('Core Philosophy', 'futuristic-it'), 'manage_options', 'futuristict-about-philosophy', 'futuristict_about_philosophy_page');
    add_submenu_page('futuristict-about', __('Timeline', 'futuristic-it'), __('Timeline', 'futuristic-it'), 'manage_options', 'futuristict-about-timeline', 'futuristict_about_timeline_page');
    add_submenu_page('futuristict-about', __('FAQ', 'futuristic-it'), __('FAQ', 'futuristic-it'), 'manage_options', 'futuristict-about-faq', 'futuristict_about_faq_page');

    // Services Page
    add_submenu_page('futuristict-website', __('Services Page', 'futuristic-it'), __('Our Service', 'futuristic-it'), 'manage_options', 'futuristict-services', 'futuristict_services_page');
    add_submenu_page('futuristict-services', __('Hero Section', 'futuristic-it'), __('Hero Section', 'futuristic-it'), 'manage_options', 'futuristict-services-hero', 'futuristict_services_hero_page');
    add_submenu_page('futuristict-services', __('Service Cards', 'futuristic-it'), __('Service Cards', 'futuristic-it'), 'manage_options', 'futuristict-services-cards', 'futuristict_services_cards_page');
    add_submenu_page('futuristict-services', __('Stats Section', 'futuristic-it'), __('Stats Section', 'futuristic-it'), 'manage_options', 'futuristict-services-stats', 'futuristict_services_stats_page');
    add_submenu_page('futuristict-services', __('CTA Section', 'futuristic-it'), __('CTA Section', 'futuristic-it'), 'manage_options', 'futuristict-services-cta', 'futuristict_services_cta_page');

    // Service Details
    add_submenu_page('futuristict-website', __('Service Details', 'futuristic-it'), __('Service Details', 'futuristic-it'), 'manage_options', 'futuristict-service-detail', 'futuristict_service_detail_page');
    add_submenu_page('futuristict-website', __('Course Detail', 'futuristic-it'), __('Course Detail', 'futuristic-it'), 'manage_options', 'futuristict-course-detail', 'futuristict_course_detail_page');
    add_submenu_page('futuristict-website', __('Licence', 'futuristic-it'), __('Licence', 'futuristic-it'), 'manage_options', 'futuristict-licence', 'futuristict_licence_page');
    add_submenu_page('futuristict-website', __('Customer Type', 'futuristic-it'), __('Customer Type', 'futuristic-it'), 'manage_options', 'futuristict-customer-type', 'futuristict_customer_type_page');
    add_submenu_page('futuristict-website', __('Software Procurement', 'futuristic-it'), __('Software Procurement', 'futuristic-it'), 'manage_options', 'futuristict-procurement', 'futuristict_procurement_page');
    // Hidden from the sidebar: reached from the module's landing cards. The
    // parent slug is the hidden 'futuristict-procurement' page, so WordPress
    // does not add these to the menu while keeping them valid admin URLs.
    add_submenu_page('futuristict-procurement', __('Page Content', 'futuristic-it'), __('Page Content', 'futuristic-it'), 'manage_options', 'futuristict-procurement-content', 'futuristict_procurement_content_page');
    add_submenu_page('futuristict-procurement', __('Software Grid', 'futuristic-it'), __('Software Grid', 'futuristic-it'), 'manage_options', 'futuristict-procurement-grid', 'futuristict_procurement_grid_page');
    add_submenu_page('futuristict-procurement', __('Our Process', 'futuristic-it'), __('Our Process', 'futuristic-it'), 'manage_options', 'futuristict-procurement-process', 'futuristict_procurement_process_page');

    // Contact Page
    add_submenu_page('futuristict-website', __('Contact Page', 'futuristic-it'), __('Contact Us', 'futuristic-it'), 'manage_options', 'futuristict-contact', 'futuristict_contact_page');
    add_submenu_page('futuristict-contact', __('Hero Section', 'futuristic-it'), __('Hero Section', 'futuristic-it'), 'manage_options', 'futuristict-contact-hero', 'futuristict_contact_hero_page');
    add_submenu_page('futuristict-contact', __('Contact Details', 'futuristic-it'), __('Contact Details', 'futuristic-it'), 'manage_options', 'futuristict-contact-details', 'futuristict_contact_details_page');
    add_submenu_page('futuristict-contact', __('Map Location', 'futuristic-it'), __('Map Location', 'futuristic-it'), 'manage_options', 'futuristict-contact-map', 'futuristict_contact_map_location_page');
    add_submenu_page('futuristict-contact', __('FAQ Section', 'futuristic-it'), __('FAQ Section', 'futuristic-it'), 'manage_options', 'futuristict-contact-faq', 'futuristict_contact_faq_page');
    add_submenu_page('futuristict-contact', __('Form Fields', 'futuristic-it'), __('Form Fields', 'futuristic-it'), 'manage_options', 'futuristict-contact-form', 'futuristict_contact_form_page');
    add_submenu_page('futuristict-website', __('Product Details', 'futuristic-it'), __('Product Details', 'futuristic-it'), 'manage_options', 'futuristict-products', 'futuristict_products_page');

    // Footer
    add_submenu_page('futuristict-website', __('Footer', 'futuristic-it'), __('Footer', 'futuristic-it'), 'manage_options', 'futuristict-header-footer', 'futuristict_header_footer_page');
    add_submenu_page('futuristict-website', __('Menu Translation', 'futuristic-it'), __('Menu Translation', 'futuristic-it'), 'manage_options', 'futuristict-menu-translation', 'futuristict_menu_translation_page');
    add_submenu_page('futuristict-website', __('Social Media', 'futuristic-it'), __('Social Media', 'futuristic-it'), 'manage_options', 'futuristict-social-media', 'futuristict_social_media_page');
    add_submenu_page('futuristict-website', __('Floating Buttons', 'futuristic-it'), __('Floating Buttons', 'futuristic-it'), 'manage_options', 'futuristict-floating-buttons', 'futuristict_floating_buttons_page');
    add_submenu_page('futuristict-homepage', __('Slider Section', 'futuristic-it'), __('Slider Section', 'futuristic-it'), 'manage_options', 'futuristict-homepage-slider', 'futuristict_homepage_slider_page');
}
add_action('admin_menu', 'futuristic_it_admin_menu', 1);

function futuristic_it_hide_duplicate_submenu() {
    global $submenu;
    if (isset($submenu['futuristict-website'])) {
        foreach ($submenu['futuristict-website'] as $key => $item) {
            if ($item[2] === 'futuristict-website') {
                unset($submenu['futuristict-website'][$key]);
            }
        }
    }

    // The Procurement module's editing screens are reached from its landing
    // cards, not the sidebar, so drop them from the menu. The pages stay
    // registered (and therefore reachable by URL) — only the menu entry goes.
    $hidden = array(
        'futuristict-procurement-content',
        'futuristict-procurement-grid',
        'futuristict-procurement-process',
    );
    if (isset($submenu['futuristict-procurement'])) {
        foreach ($submenu['futuristict-procurement'] as $key => $item) {
            if (in_array($item[2], $hidden, true)) {
                unset($submenu['futuristict-procurement'][$key]);
            }
        }
    }
}
add_action('admin_menu', 'futuristic_it_hide_duplicate_submenu', 999);

// Helper functions
function futuristic_it_save_fields($fields, $group) {
    if (isset($_POST['futuristic_it_save_' . $group]) && check_admin_referer('futuristic_it_' . $group)) {
        foreach ($fields as $f) {
            if (isset($_POST[$f])) update_option($f, sanitize_text_field($_POST[$f]));
        }
        futuristic_it_toast('Settings saved successfully!');
    }
}

function futuristic_it_toast($message) {
    echo '<script>document.addEventListener("DOMContentLoaded",function(){var t=document.getElementById("fw-toast");if(t){document.getElementById("fw-toast-text").textContent="' . esc_js($message) . '";t.classList.add("show");setTimeout(function(){t.classList.remove("show");},3000);}});</script>';
}

function futuristic_it_render_fields($fields, $group) {
    ?>
    <form method="post" action="">
        <?php wp_nonce_field('futuristic_it_' . $group); ?>
        <table class="form-table">
            <?php foreach ($fields as $field) :
                $value = get_option($field['key'], $field['default'] ?? '');
                $is_textarea = ($field['type'] ?? 'text') === 'textarea';
            ?>
                <tr>
                    <th scope="row"><label for="<?php echo esc_attr($field['key']); ?>"><?php echo esc_html($field['label']); ?></label></th>
                    <td>
                        <?php if ($is_textarea) : ?>
                            <textarea class="large-text" id="<?php echo esc_attr($field['key']); ?>" name="<?php echo esc_attr($field['key']); ?>" rows="3"><?php echo esc_textarea($value); ?></textarea>
                        <?php else : ?>
                            <input type="text" class="regular-text" id="<?php echo esc_attr($field['key']); ?>" name="<?php echo esc_attr($field['key']); ?>" value="<?php echo esc_attr($value); ?>">
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <input type="submit" name="futuristic_it_save_<?php echo esc_attr($group); ?>" class="button button-primary" value="Save Changes">
    </form>
    <?php
}

// Admin Pages
function futuristict_website_page() {
    wp_redirect(admin_url('admin.php?page=futuristict-homepage'));
    exit;
}

function futuristict_homepage_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('Home', 'futuristic-it'); ?></h1>
        <p style="color:#666;margin-bottom:20px;"><?php _e('Select a section to edit:', 'futuristic-it'); ?></p>
        <div class="fw-cards">
            <a href="<?php echo admin_url('admin.php?page=futuristict-homepage-hero'); ?>" class="fw-card">
                <h3><?php _e('Hero Section', 'futuristic-it'); ?></h3>
                <p><?php _e('Edit title, subtitle, tagline and call-to-action buttons.', 'futuristic-it'); ?></p>
            </a>
            <a href="<?php echo admin_url('admin.php?page=futuristict-homepage-services'); ?>" class="fw-card">
                <h3><?php _e('Services Section', 'futuristic-it'); ?></h3>
                <p><?php _e('Edit section title, subtitle, CTA and service cards.', 'futuristic-it'); ?></p>
            </a>
            <a href="<?php echo admin_url('admin.php?page=futuristict-homepage-products'); ?>" class="fw-card">
                <h3><?php _e('Products Section', 'futuristic-it'); ?></h3>
                <p><?php _e('Edit section title, subtitle, CTA and product cards.', 'futuristic-it'); ?></p>
            </a>
            <a href="<?php echo admin_url('admin.php?page=futuristict-homepage-partners'); ?>" class="fw-card">
                <h3><?php _e('Why Choose Us', 'futuristic-it'); ?></h3>
                <p><?php _e('Edit section title, subtitle and feature cards with icons.', 'futuristic-it'); ?></p>
            </a>
            <a href="<?php echo admin_url('admin.php?page=futuristict-homepage-slider'); ?>" class="fw-card">
                <h3><?php _e('Slider Section', 'futuristic-it'); ?></h3>
                <p><?php _e('Add and manage slider images, titles and display order.', 'futuristic-it'); ?></p>
            </a>
            <a href="<?php echo admin_url('admin.php?page=futuristict-homepage-cta'); ?>" class="fw-card">
                <h3><?php _e('CTA / Assurance', 'futuristic-it'); ?></h3>
                <p><?php _e('Edit assurance box title, checklist features and button.', 'futuristic-it'); ?></p>
            </a>
        </div>
    </div>
    <?php
}

// Helper: Render Khmer field
function futuristic_it_km_input($name, $label, $value, $type = 'text') {
    $km_name = $name . '_km';
    $km_value = get_option($km_name, '');
    if ($type === 'textarea') {
        return '<tr><th><label>' . $label . ' (Khmer)</label></th><td><textarea class="large-text" name="' . esc_attr($km_name) . '" rows="2" dir="rtl" style="font-family: \'Noto Sans Khmer\', sans-serif;">' . esc_textarea($km_value) . '</textarea></td></tr>';
    }
    return '<tr><th><label>' . $label . ' (Khmer)</label></th><td><input type="text" class="regular-text" name="' . esc_attr($km_name) . '" value="' . esc_attr($km_value) . '" dir="rtl" style="font-family: \'Noto Sans Khmer\', sans-serif;"></td></tr>';
}

// Helper: Save Khmer fields
function futuristic_it_save_km_fields($fields) {
    foreach ($fields as $f) {
        $km_key = $f . '_km';
        if (isset($_POST[$km_key])) {
            update_option($km_key, sanitize_text_field($_POST[$km_key]));
        }
    }
}

// Helper: Get translated text
function futuristic_it_get_current_lang() {
    if (isset($_GET['site_lang']) && in_array($_GET['site_lang'], array('en', 'km'), true)) {
        return sanitize_key($_GET['site_lang']);
    }

    if (isset($_COOKIE['site_lang']) && in_array($_COOKIE['site_lang'], array('en', 'km'), true)) {
        return sanitize_key($_COOKIE['site_lang']);
    }

    return 'km';
}

/**
 * URL of the page using the Contact Us template.
 *
 * Resolved by template rather than a hardcoded slug so course "Register"
 * links keep working if the contact page is renamed or moved. The template
 * may be stored either as "contact/page-contact.php" or as the bare
 * filename, so both spellings are tried.
 */
function futuristic_it_get_contact_url() {
    $templates = array('contact/page-contact.php', 'page-contact.php');
    foreach ($templates as $template) {
        $found = get_posts(array(
            'post_type'      => 'page',
            'post_status'    => 'publish',
            'posts_per_page' => 1,
            'fields'         => 'ids',
            'meta_key'       => '_wp_page_template',
            'meta_value'     => $template,
        ));
        if (!empty($found)) {
            $url = get_permalink($found[0]);
            if (!empty($url)) return $url;
        }
    }

    return home_url('/contact-us/');
}

/**
 * URL of the Software Procurement detail page, or '' when it is unavailable.
 *
 * Returns '' rather than a fallback so callers can tell "no page" from "a page"
 * and keep their existing behaviour when there is nothing to link to.
 */
function futuristic_it_get_procurement_url() {
    $page = get_page_by_path('procurement-support');
    if ($page && $page->post_status === 'publish') {
        $url = get_permalink($page->ID);
        if (!empty($url)) return $url;
    }
    return '';
}

/**
 * The service card whose "Learn More" should open the Procurement page.
 *
 * Stored as the card's English title, which is what identifies a card
 * everywhere else in the theme (service_key is md5 of it).
 */
function futuristic_it_procurement_service_title() {
    return get_option('procurement_service', 'Software Procurement Support');
}

/**
 * Detail-page URL to use for a service card instead of its normal target.
 *
 * The Procurement card normally carries a custom link to the contact page, so
 * this has to be consulted *before* the custom-link branch for the new page to
 * be reachable at all. Returns '' for every other card, leaving the caller's
 * own resolution untouched.
 */
function futuristic_it_service_detail_override($card_title) {
    $card_title = (string) $card_title;
    if ($card_title === '') return '';

    $bound = futuristic_it_procurement_service_title();
    if ($bound === '' || $card_title !== $bound) return '';

    return futuristic_it_get_procurement_url();
}

/**
 * Default copy for the Procurement page, shared by the template and the admin.
 *
 * Both sides need the same defaults: the admin shows them as field values, and
 * the template needs them for an install where nothing has been saved yet. Kept
 * in one place so a Khmer default cannot drift out of sync with the English one
 * and leave the Khmer page falling back to English.
 */
function futuristic_it_procurement_defaults() {
    return array(
        'procurement_badge' => array(
            'en' => 'Licensed and verified procurement',
            'km' => 'ការទិញដែលមានអាជ្ញាបណ្ណ និងបានផ្ទៀងផ្ទាត់',
        ),
        'procurement_heading' => array(
            'en' => 'Software Procurement Support',
            'km' => 'ជំនួយការទិញកម្មវិធី',
        ),
        'procurement_heading_highlight' => array(
            'en' => 'Procurement',
            'km' => 'ការទិញ',
        ),
        'procurement_paragraph' => array(
            'en' => 'We source, license and deploy the software your team actually needs — with genuine licensing, transparent pricing and vendor-backed support from day one.',
            'km' => 'យើងខ្ញុំផ្គត់ផ្គង់ ផ្តល់អាជ្ញាបណ្ណ និងដំឡើងកម្មវិធីដែលក្រុមការងាររបស់អ្នកត្រូវការពិតប្រាកដ ដោយមានអាជ្ញាបណ្ណត្រឹមត្រូវ តម្លៃច្បាស់លាស់ និងការគាំទ្រពីអ្នកផលិត។',
        ),
        'procurement_cta_text' => array(
            'en' => 'Request a quote',
            'km' => 'ស្នើសុំតម្លៃ',
        ),
        'procurement_cta_url' => array(
            'en' => '',
            'km' => '',
        ),
        'procurement_panel_title' => array(
            'en' => 'Software we commonly procure',
            'km' => 'កម្មវិធីដែលយើងខ្ញុំទិញជូនជាញឹកញាប់',
        ),
        'procurement_panel_note' => array(
            'en' => '50 software categories available on request',
            'km' => 'មានប្រភេទកម្មវិធីជាង ៥០ តាមការស្នើសុំ',
        ),
        'procurement_process_eyebrow' => array(
            'en' => 'Our process',
            'km' => 'ដំណើរការរបស់យើង',
        ),
        'procurement_process_heading' => array(
            'en' => 'How software procurement support works',
            'km' => 'របៀបដែលជំនួយការទិញកម្មវិធីដំណើរការ',
        ),
    );
}

/**
 * Read one Procurement option in the current language, falling back to the
 * shared default. Used by the template for every field on the page.
 */
function futuristic_it_procurement_text($key, $lang = null) {
    $defaults = futuristic_it_procurement_defaults();
    $en = isset($defaults[$key]['en']) ? $defaults[$key]['en'] : '';
    $km = isset($defaults[$key]['km']) ? $defaults[$key]['km'] : '';

    if ($lang === null) $lang = futuristic_it_get_current_lang();

    $stored_en = get_option($key, '');
    if ($lang === 'km') {
        $stored_km = get_option($key . '_km', '');
        // A saved Khmer value wins, then the shipped Khmer default, and only
        // then English — so an untouched Khmer page is fully Khmer.
        if (!empty($stored_km)) return $stored_km;
        if (!empty($km)) return $km;
    }

    return !empty($stored_en) ? $stored_en : $en;
}

/**
 * Default cards for the Procurement page, shared by the template and the admin
 * so an untouched install renders the full layout rather than an empty grid.
 *
 * Icons are brand logos the site owner uploads; with none set each card shows
 * its name alone, which is how "Microsoft 365" appears by design.
 */
function futuristic_it_procurement_default_cards() {
    return array(
        array('icon' => '', 'name' => 'Microsoft 365',        'name_km' => ''),
        array('icon' => '', 'name' => 'Google Workspace',     'name_km' => ''),
        array('icon' => '', 'name' => 'Adobe Creative',       'name_km' => ''),
        array('icon' => '', 'name' => 'Antivirus / Security', 'name_km' => ''),
        array('icon' => '', 'name' => 'Accounting Tools',     'name_km' => ''),
        array('icon' => '', 'name' => 'And more...',          'name_km' => ''),
    );
}

/**
 * The Procurement software grid, seeded only when it has never been saved.
 *
 * The distinction matters: get_option() returns null for "never configured" but
 * '[]' for "configured as empty". Seeding on both would mean an admin who
 * deletes every row finds the six defaults back the next time they look, with
 * no way to actually empty the grid.
 */
function futuristic_it_procurement_cards() {
    $raw = get_option('custom_procurement_cards', null);

    // Never saved: show the shipped grid so the page is not blank on a fresh
    // install.
    if ($raw === null || $raw === false || $raw === '') {
        return futuristic_it_procurement_default_cards();
    }

    $cards = json_decode($raw, true);

    // Saved as empty, or corrupt: an empty array is a deliberate choice and is
    // honoured; anything unparseable falls back to the defaults rather than
    // rendering a broken page.
    if (is_array($cards)) return $cards;

    return futuristic_it_procurement_default_cards();
}

/**
 * Default steps for the "Our process" section, shared by the template and the
 * admin so an untouched install renders the whole timeline.
 *
 * Each step carries a title, body and a short meta line (the timing badge).
 * The meta is optional — a step saved without one renders title and body only.
 */
function futuristic_it_procurement_default_steps() {
    return array(
        array(
            'title' => 'You tell us what you need',
            'desc'  => 'Fill in our short request form or contact us directly. Tell us your business type, team size, and what problem you are trying to solve — not necessarily the software name. We will take it from there.',
            'meta'  => 'Takes 5 minutes',
        ),
        array(
            'title' => 'We assess and recommend',
            'desc'  => 'Our team reviews your needs and recommends the right software, the right plan tier, and the right number of licenses — with a clear explanation of why. If you already know what you want, we skip straight to procurement.',
            'meta'  => 'Within 1 business day',
        ),
        array(
            'title' => 'You approve and pay',
            'desc'  => 'We send you a clear quote showing the software cost plus our service fee. You approve it and pay via ABA, KHQR, Wing, or bank transfer. No foreign credit card required.',
            'meta'  => 'Transparent pricing — no hidden fees',
        ),
        array(
            'title' => 'We procure and set up',
            'desc'  => 'We purchase the verified license on your behalf and handle the complete setup and configuration. We deliver the software ready to use — with your accounts, users, and settings already configured.',
            'meta'  => 'Delivered within 1-3 business days',
        ),
        array(
            'title' => 'Ongoing renewal support',
            'desc'  => 'We track your subscription renewal dates and notify you 30 days before they are due. When you are ready to renew, we handle it for you — keeping your team running without interruption.',
            'meta'  => 'Proactive renewal reminders included',
        ),
    );
}

/**
 * The "Our process" steps, seeded only when they have never been saved.
 *
 * Same null-vs-'[]' distinction as the software grid: an admin who deletes every
 * step must not find the defaults back the next time they look.
 */
function futuristic_it_procurement_steps() {
    $raw = get_option('custom_procurement_steps', null);

    if ($raw === null || $raw === false || $raw === '') {
        return futuristic_it_procurement_default_steps();
    }

    $steps = json_decode($raw, true);

    if (is_array($steps)) return $steps;

    return futuristic_it_procurement_default_steps();
}

/**
 * Wrap the first occurrence of $word in $text with a styled span.
 *
 * Lets the admin highlight a word of the heading without typing HTML. The text
 * is escaped here rather than at the call site, so every piece that reaches the
 * page is escaped exactly once; a word that is absent leaves the text plain.
 */
function futuristic_it_highlight_word($text, $word, $class = '') {
    $text = (string) $text;
    $word = (string) $word;

    if ($word === '') return esc_html($text);

    $pos = function_exists('mb_stripos') ? mb_stripos($text, $word) : stripos($text, $word);
    if ($pos === false) return esc_html($text);

    $len    = function_exists('mb_strlen') ? mb_strlen($word) : strlen($word);
    $before = function_exists('mb_substr') ? mb_substr($text, 0, $pos) : substr($text, 0, $pos);
    $hit    = function_exists('mb_substr') ? mb_substr($text, $pos, $len) : substr($text, $pos, $len);
    $after  = function_exists('mb_substr') ? mb_substr($text, $pos + $len) : substr($text, $pos + $len);

    return esc_html($before)
        . '<span class="' . esc_attr($class) . '">' . esc_html($hit) . '</span>'
        . esc_html($after);
}

/**
 * Auto-create the Procurement page.
 *
 * Same pattern as the Service Detail page: created on theme activation and
 * re-created on init if it is ever deleted, so the card link never dead-ends.
 */
function futuristic_it_create_procurement_page() {
    $template = 'services/page-procurement.php';
    $page = get_page_by_path('procurement-support');

    if (!$page) {
        wp_insert_post(array(
            'post_title'    => 'Procurement Support',
            'post_name'     => 'procurement-support',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'page_template' => $template,
        ));
        return;
    }

    // wp_insert_post() silently stores "default" when the template file is not
    // on disk yet, so a page created before this template existed would render
    // the theme's generic page. Re-assert it rather than trusting the meta.
    if (get_post_meta($page->ID, '_wp_page_template', true) !== $template) {
        update_post_meta($page->ID, '_wp_page_template', $template);
    }
}
add_action('after_switch_theme', 'futuristic_it_create_procurement_page');
add_action('init', function () {
    $page = get_page_by_path('procurement-support');
    if (!$page) futuristic_it_create_procurement_page();
});

function futuristic_it_set_language_cookie() {
    if (!isset($_GET['site_lang']) || !in_array($_GET['site_lang'], array('en', 'km'), true)) {
        return;
    }

    $lang = sanitize_key($_GET['site_lang']);
    setcookie('site_lang', $lang, array(
        'expires'  => time() + YEAR_IN_SECONDS,
        'path'     => COOKIEPATH ? COOKIEPATH : '/',
        'domain'   => COOKIE_DOMAIN,
        'secure'   => is_ssl(),
        'httponly' => false,
        'samesite' => 'Lax',
    ));
    $_COOKIE['site_lang'] = $lang;
}
add_action('init', 'futuristic_it_set_language_cookie');

function futuristic_it_t($key, $default = '') {
    $lang = futuristic_it_get_current_lang();
    if ($lang === 'km') {
        $km_value = get_option($key . '_km', '');
        if (!empty($km_value)) return $km_value;
    }
    return get_option($key, $default);
}

// Menu Translation Filter
function futuristic_it_menu_translation($items, $args) {
    $lang = futuristic_it_get_current_lang();
    
    // Append site_lang to menu links server-side as backup
    if ($lang) {
        foreach ($items as &$item) {
            $item->url = add_query_arg('site_lang', $lang, $item->url);
        }
        unset($item);
    }

    if ($lang !== 'km') return $items;
    
    $menu_translations = json_decode(get_option('custom_menu_translations', '[]'), true);
    if (!is_array($menu_translations)) return $items;
    
    foreach ($items as &$item) {
        if (isset($menu_translations[$item->title]) && !empty($menu_translations[$item->title])) {
            $item->title = $menu_translations[$item->title];
        }
    }
    unset($item);
    
    return $items;
}
add_filter('wp_nav_menu_objects', 'futuristic_it_menu_translation', 10, 2);

// Resolve a service/product card image into a small thumbnail for the mega dropdown.
// Prefers the registered "thumbnail" size (150x150 crop, already generated for
// media-library images) so the header does not download a full-size JPEG.
function futuristic_it_mega_item_thumb($image_url) {
    $image_url = is_string($image_url) ? trim($image_url) : '';
    if ($image_url === '') return '';

    $attachment_id = attachment_url_to_postid($image_url);
    if ($attachment_id) {
        $thumb = wp_get_attachment_image_url($attachment_id, 'thumbnail');
        if ($thumb) return $thumb;
    }
    return $image_url;
}

// Inject service dropdown items under "Our Service" menu item
function futuristic_it_service_dropdown($items, $args) {
    if (empty($items)) return $items;

    $current_lang = futuristic_it_get_current_lang();
    $raw_services = get_option('custom_service_cards', '[]');
    $services = json_decode($raw_services, true);
    if (!is_array($services) || empty($services)) return $items;

    $service_parent = null;
    foreach ($items as $item) {
        if (stripos($item->title, 'Service') !== false || stripos($item->title, 'សេវា') !== false) {
            $service_parent = $item;
            break;
        }
    }
    if (!$service_parent) return $items;

    $service_parent->classes[] = 'menu-item-has-children';

    $children = array();
    $order = $service_parent->menu_order + 1;
    $idx = 0;
    foreach ($services as $card) {
        $type = $card['type'] ?? 'Detail';
        if ($type === 'Contact') continue;

        $title = ($current_lang === 'km' && !empty($card['title_km'])) ? $card['title_km'] : ($card['title'] ?? '');
        if (empty($title)) continue;

        $desc = ($current_lang === 'km' && !empty($card['desc_km'])) ? $card['desc_km'] : ($card['desc'] ?? '');
        $icon = futuristic_it_mega_item_thumb($card['image'] ?? '');

        $svc_key = 'svc_' . md5($card['title'] ?? '');
        $custom_link = $card['link'] ?? '';
        $has_courses = !empty($card['courses']) || ($type === 'Course');
        // Checked before the custom-link branch on purpose: the Procurement
        // card carries a link to the contact page, so without this the menu
        // entry would keep pointing at contact instead of the detail page.
        $override = futuristic_it_service_detail_override($card['title'] ?? '');
        if (!empty($override)) {
            $svc_link = $override;
        } elseif (!empty($custom_link) && $custom_link !== '#' && $custom_link !== '/contact-us/') {
            $svc_link = $custom_link;
        } else {
            $svc_link = add_query_arg('service_key', $svc_key, home_url('/service-detail/'));
        }
        $svc_link = add_query_arg('site_lang', $current_lang, $svc_link);
        if ($type === 'Course' || $has_courses) {
            $svc_link .= '#related-courses';
        }

        $child = new stdClass();
        $child->ID = 0;
        $child->title = esc_html($title);
        $child->url = $svc_link;
        $child->menu_order = $order;
        $child->menu_item_parent = $service_parent->db_id;
        $child->classes = array('menu-item', 'menu-item-type-custom', 'menu-item-object-custom', 'svc-mega-item');
        $child->type = 'custom';
        $child->object = 'custom';
        $child->db_id = -(++$idx);
        $child->mega_thumb = $icon;
        $children[] = $child;
        $order++;
    }

    if (empty($children)) return $items;

    $result = array();
    foreach ($items as $item) {
        $result[] = $item;
        if ($item->db_id === $service_parent->db_id) {
            foreach ($children as $child) {
                $result[] = $child;
            }
        }
    }
    return $result;
}
add_filter('wp_nav_menu_objects', 'futuristic_it_service_dropdown', 20, 2);

// Allow HTML in nav menu item titles
function futuristic_it_allow_html_in_menu_titles($title, $item, $args, $depth) {
    if (!empty($item->classes) && (in_array('svc-mega-item', (array)$item->classes) || in_array('svc-dropdown-header-item', (array)$item->classes))) {
        return $title;
    }
    return $title;
}
add_filter('wp_nav_menu_item_title', 'futuristic_it_allow_html_in_menu_titles', 10, 4);

function futuristic_it_mega_menu_link_filter($item_output, $item, $depth, $args) {
    if (!empty($item->classes) && (in_array('svc-mega-item', (array)$item->classes) || in_array('svc-dropdown-header-item', (array)$item->classes))) {
        $thumb = isset($item->mega_thumb) ? trim((string)$item->mega_thumb) : '';
        $image = '';
        if ($thumb !== '') {
            $image = '<img class="svc-mega-thumb" src="' . esc_url($thumb) . '" alt="' . esc_attr(wp_strip_all_tags($item->title)) . '" width="28" height="28" loading="lazy" decoding="async" />';
        }
        return '<a href="' . esc_url($item->url) . '">' . $image . '<span class="svc-mega-text">' . $item->title . '</span></a>';
    }
    return $item_output;
}
add_filter('walker_nav_menu_start_el', 'futuristic_it_mega_menu_link_filter', 10, 4);

// Inject product dropdown items under "Products" menu item
function futuristic_it_product_dropdown($items, $args) {
    if (empty($items)) return $items;

    $current_lang = futuristic_it_get_current_lang();
    $raw_products = get_option('custom_product_cards', '[]');
    $products = json_decode($raw_products, true);
    if (!is_array($products) || empty($products)) return $items;

    $product_parent = null;
    foreach ($items as $item) {
        if (stripos($item->title, 'Product') !== false || stripos($item->title, 'ផលិត') !== false) {
            $product_parent = $item;
            break;
        }
    }
    if (!$product_parent) return $items;

    $product_parent->classes[] = 'menu-item-has-children';

    $children = array();
    $order = $product_parent->menu_order + 1;
    $idx = 100;
    foreach ($products as $card) {
        $card_type = $card['type'] ?? 'Software';
        if ($card_type === 'Contact' || $card_type === 'Hardware') continue;

        $title = ($current_lang === 'km' && !empty($card['title_km'])) ? $card['title_km'] : ($card['title'] ?? '');
        if (empty($title)) continue;

        $product_key = 'home_' . md5($card['title'] ?? '');
        $has_details = !empty($card['features']) || !empty($card['specs']) || !empty($card['images']);
        $custom_link = $card['link'] ?? '';
        if (!empty($custom_link) && $custom_link !== '#') {
            $product_link = $custom_link;
        } else {
            $product_link = $has_details ? add_query_arg('product_key', $product_key, home_url('/product-detail/')) : '#';
        }
        $product_link = add_query_arg('site_lang', $current_lang, $product_link);
        $thumb = futuristic_it_mega_item_thumb($card['image'] ?? '');

        $child = new stdClass();
        $child->ID = 0;
        $child->title = esc_html($title);
        $child->url = $product_link;
        $child->menu_order = $order;
        $child->menu_item_parent = $product_parent->db_id;
        $child->classes = array('menu-item', 'menu-item-type-custom', 'menu-item-object-custom', 'svc-mega-item');
        $child->type = 'custom';
        $child->object = 'custom';
        $child->db_id = -(++$idx);
        $child->mega_thumb = $thumb;
        $children[] = $child;
        $order++;
    }

    if (empty($children)) return $items;

    $result = array();
    foreach ($items as $item) {
        $result[] = $item;
        if ($item->db_id === $product_parent->db_id) {
            foreach ($children as $child) {
                $result[] = $child;
            }
        }
    }
    return $result;
}
add_filter('wp_nav_menu_objects', 'futuristic_it_product_dropdown', 20, 2);

// Menu Translation Admin Page
function futuristict_menu_translation_page() {
    if (isset($_POST['futuristic_it_save_menu_translations']) && check_admin_referer('futuristic_it_menu_translations')) {
        $translations = array();
        if (isset($_POST['menu_translations']) && is_array($_POST['menu_translations'])) {
            foreach ($_POST['menu_translations'] as $en_title => $km_title) {
                $km_title = sanitize_text_field($km_title);
                if (!empty($km_title)) {
                    $translations[$en_title] = $km_title;
                }
            }
        }
        update_option('custom_menu_translations', wp_json_encode($translations));
        futuristic_it_toast('Menu translations saved!');
    }
    
    // Try to get menu items from 'primary' location first, then by menu name
    $menu_items = wp_get_nav_menu_items('primary');
    if (empty($menu_items)) {
        // Try to find menu by name
        $menus = wp_get_nav_menus();
        foreach ($menus as $menu) {
            if (stripos($menu->name, 'primary') !== false || stripos($menu->name, 'Primary') !== false) {
                $menu_items = wp_get_nav_menu_items($menu->term_id);
                break;
            }
        }
    }
    if (empty($menu_items)) {
        // Try to get the first available menu
        $menus = wp_get_nav_menus();
        if (!empty($menus)) {
            $first_menu = reset($menus);
            $menu_items = wp_get_nav_menu_items($first_menu->term_id);
        }
    }
    $translations = json_decode(get_option('custom_menu_translations', '[]'), true);
    if (!is_array($translations)) $translations = array();
    ?>
    <div class="wrap">
        <h1><?php _e('Menu Translation', 'futuristic-it'); ?></h1>
        <p><a href="<?php echo admin_url('admin.php?page=futuristict-website'); ?>">&larr; Back</a></p>
        <form method="post" action="">
            <?php wp_nonce_field('futuristic_it_menu_translations'); ?>
            <table class="widefat striped">
                <thead>
                    <tr>
                        <th><?php _e('English', 'futuristic-it'); ?></th>
                        <th style="color:#b8892f;"><?php _e('Khmer', 'futuristic-it'); ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($menu_items)) : ?>
                    <?php foreach ($menu_items as $item) : ?>
                        <tr>
                            <td><strong><?php echo esc_html($item->title); ?></strong></td>
                            <td><input type="text" name="menu_translations[<?php echo esc_attr($item->title); ?>]" value="<?php echo esc_attr($translations[$item->title] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;"></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr><td colspan="2"><?php _e('No menu items found. Please create a menu in Appearance > Menus.', 'futuristic-it'); ?></td></tr>
                <?php endif; ?>
                </tbody>
            </table>
            <input type="submit" name="futuristic_it_save_menu_translations" class="button button-primary" value="<?php _e('Save Translations', 'futuristic-it'); ?>">
        </form>
    </div>
    <?php
}

// Home Hero Page
function futuristict_homepage_hero_page() {
    if (isset($_POST['futuristic_it_save_hero']) && check_admin_referer('futuristic_it_hero')) {
        // Save static fields
        $static_fields = array('custom_hero_tagline', 'custom_hero_title_prefix', 'custom_hero_title_suffix', 'custom_hero_btn_text', 'custom_hero_btn_link', 'custom_hero_btn2_text', 'custom_hero_btn2_link');
        foreach ($static_fields as $f) {
            if (isset($_POST[$f])) update_option($f, sanitize_text_field($_POST[$f]));
            if (isset($_POST[$f . '_km'])) update_option($f . '_km', sanitize_text_field($_POST[$f . '_km']));
        }
        $textarea_fields = array('custom_hero_desc');
        foreach ($textarea_fields as $f) {
            if (isset($_POST[$f])) update_option($f, sanitize_textarea_field($_POST[$f]));
            if (isset($_POST[$f . '_km'])) update_option($f . '_km', sanitize_textarea_field($_POST[$f . '_km']));
        }
        // Save SVG
        if (isset($_POST['custom_hero_svg'])) update_option('custom_hero_svg', esc_url_raw($_POST['custom_hero_svg']));
        // Save sliding text slides
        if (isset($_POST['hero_slides']) && is_array($_POST['hero_slides'])) {
            $slides = array();
            foreach ($_POST['hero_slides'] as $sl) {
                $slides[] = array(
                    'title_before' => sanitize_text_field($sl['title_before'] ?? ''),
                    'title_before_km' => sanitize_text_field($sl['title_before_km'] ?? ''),
                    'title_highlight' => sanitize_text_field($sl['title_highlight'] ?? ''),
                    'title_highlight_km' => sanitize_text_field($sl['title_highlight_km'] ?? ''),
                    'title_after' => sanitize_text_field($sl['title_after'] ?? ''),
                    'title_after_km' => sanitize_text_field($sl['title_after_km'] ?? ''),
                    'subtitle' => sanitize_textarea_field($sl['subtitle'] ?? ''),
                    'subtitle_km' => sanitize_textarea_field($sl['subtitle_km'] ?? ''),
                    'order' => intval($sl['order'] ?? 0),
                );
            }
            usort($slides, function($a, $b) { return $a['order'] - $b['order']; });
            update_option('custom_hero_slides', wp_json_encode($slides));
        }
        futuristic_it_toast('Hero saved!');
    }
    $hero_slides = json_decode(get_option('custom_hero_slides', '[]'), true);
    if (!is_array($hero_slides)) $hero_slides = array();
    if (empty($hero_slides)) {
        $hero_slides = array(array(
            'title_before' => get_option('custom_hero_title_before', 'Transforming Ideas into'),
            'title_before_km' => get_option('custom_hero_title_before_km', ''),
            'title_highlight' => get_option('custom_hero_title_highlight', 'Intelligent'),
            'title_highlight_km' => get_option('custom_hero_title_highlight_km', ''),
            'title_after' => get_option('custom_hero_title_after', 'Solutions'),
            'title_after_km' => get_option('custom_hero_title_after_km', ''),
            'subtitle' => get_option('custom_hero_subtitle', ''),
            'subtitle_km' => get_option('custom_hero_subtitle_km', ''),
            'order' => 0,
        ));
    }
    ?>
    <div class="wrap">
        <h1><?php _e('Home – Hero Section', 'futuristic-it'); ?></h1>
        <p><a href="<?php echo admin_url('admin.php?page=futuristict-homepage'); ?>">&larr; Back</a></p>
        <form method="post" action="">
            <?php wp_nonce_field('futuristic_it_hero'); ?>

            <div style="background:#fff;padding:20px;border:1px solid #ddd;border-radius:8px;margin-bottom:20px;">
                <h3 style="margin:0 0 12px;"><?php _e('Static Content (always visible)', 'futuristic-it'); ?></h3>
                <table class="form-table" style="margin:0;">
                    <tr><th><label>Tagline (English)</label></th><td><input type="text" class="regular-text" name="custom_hero_tagline" value="<?php echo esc_attr(get_option('custom_hero_tagline', '')); ?>" style="width:100%;" placeholder="Welcome to Futuristic Investment"></td></tr>
                    <tr><th><label style="color:#b8892f;">Tagline (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_hero_tagline_km" value="<?php echo esc_attr(get_option('custom_hero_tagline_km', '')); ?>" style="width:100%;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                    <tr><th colspan="2"><hr style="border:0;border-top:1px solid #e0e0e0;margin:8px 0;"><span style="font-size:13px;color:#666;">Title wraps the rotating keyword: <strong>Prefix</strong> + <em style="color:#b8892f;">keyword</em> + <strong>Suffix</strong></span></th></tr>
                    <tr><th><label>Title Prefix (English)</label></th><td><input type="text" class="regular-text" name="custom_hero_title_prefix" value="<?php echo esc_attr(get_option('custom_hero_title_prefix', '')); ?>" style="width:100%;" placeholder="Transforming Ideas into Intelligent"></td></tr>
                    <tr><th><label style="color:#b8892f;">Title Prefix (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_hero_title_prefix_km" value="<?php echo esc_attr(get_option('custom_hero_title_prefix_km', '')); ?>" style="width:100%;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                    <tr><th><label>Title Suffix (English)</label></th><td><input type="text" class="regular-text" name="custom_hero_title_suffix" value="<?php echo esc_attr(get_option('custom_hero_title_suffix', '')); ?>" style="width:100%;" placeholder="(optional, e.g. &quot;for Cambodia&quot;)"></td></tr>
                    <tr><th><label style="color:#b8892f;">Title Suffix (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_hero_title_suffix_km" value="<?php echo esc_attr(get_option('custom_hero_title_suffix_km', '')); ?>" style="width:100%;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                    <tr><th><label>Description (English)</label></th><td><textarea class="large-text" name="custom_hero_desc" rows="3" style="width:100%;"><?php echo esc_textarea(get_option('custom_hero_desc', '')); ?></textarea></td></tr>
                    <tr><th><label style="color:#b8892f;">Description (Khmer)</label></th><td><textarea class="large-text" name="custom_hero_desc_km" rows="3" style="width:100%;font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea(get_option('custom_hero_desc_km', '')); ?></textarea></td></tr>
                    <tr><th colspan="2"><hr style="border:0;border-top:1px solid #e0e0e0;margin:8px 0;"></th></tr>
                    <tr><th><label>Button 1 Text (English)</label></th><td><input type="text" class="regular-text" name="custom_hero_btn_text" value="<?php echo esc_attr(get_option('custom_hero_btn_text', '')); ?>" style="width:300px;"></td></tr>
                    <tr><th><label style="color:#b8892f;">Button 1 Text (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_hero_btn_text_km" value="<?php echo esc_attr(get_option('custom_hero_btn_text_km', '')); ?>" style="width:300px;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                    <tr><th><label>Button 1 Link</label></th><td><input type="text" class="regular-text" name="custom_hero_btn_link" value="<?php echo esc_attr(get_option('custom_hero_btn_link', '#')); ?>" style="width:300px;"></td></tr>
                    <tr><th><label>Button 2 Text (English)</label></th><td><input type="text" class="regular-text" name="custom_hero_btn2_text" value="<?php echo esc_attr(get_option('custom_hero_btn2_text', '')); ?>" style="width:300px;"></td></tr>
                    <tr><th><label style="color:#b8892f;">Button 2 Text (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_hero_btn2_text_km" value="<?php echo esc_attr(get_option('custom_hero_btn2_text_km', '')); ?>" style="width:300px;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                    <tr><th><label>Button 2 Link</label></th><td><input type="text" class="regular-text" name="custom_hero_btn2_link" value="<?php echo esc_attr(get_option('custom_hero_btn2_link', '#')); ?>" style="width:300px;"></td></tr>
                    <tr><th colspan="2"><hr style="border:0;border-top:1px solid #e0e0e0;margin:8px 0;"></th></tr>
                    <tr>
                        <th><label>Hero SVG Image</label></th>
                        <td>
                            <?php $hero_svg = get_option('custom_hero_svg', ''); ?>
                            <input type="text" class="regular-text" name="custom_hero_svg" id="custom_hero_svg" value="<?php echo esc_attr($hero_svg); ?>" style="width:100%;" placeholder="Enter SVG URL or upload">
                            <button type="button" class="button" id="upload_hero_svg_btn">Upload SVG</button>
                            <?php if ($hero_svg) : ?>
                                <div style="margin-top:10px;"><img src="<?php echo esc_url($hero_svg); ?>" style="max-width:300px;max-height:150px;"></div>
                            <?php endif; ?>
                            <p class="description">Upload an SVG file or enter an SVG URL to display on the right side of the hero section.</p>
                        </td>
                    </tr>
                </table>
            </div>

            <div style="background:#fff;padding:20px;border:1px solid #ddd;border-radius:8px;margin-bottom:20px;">
                <h3 style="margin:0 0 12px;"><?php _e('Sliding Text Content', 'futuristic-it'); ?></h3>
                <p style="color:#999;margin:0 0 16px;"><?php _e('Only the Title Highlight rotates inline. Title Before / After / Description are optional per-slide overrides — leave them blank to use the static content above.', 'futuristic-it'); ?></p>
                <?php foreach ($hero_slides as $i => $sl) : ?>
                <div class="hero-slide-row" style="background:#f9f9f9;border:1px solid #ddd;border-radius:8px;padding:16px;margin-bottom:12px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                        <h4 style="margin:0;"><?php _e('Slide', 'futuristic-it'); ?> <?php echo $i + 1; ?></h4>
                        <div style="display:flex;gap:8px;align-items:center;">
                            <label style="font-size:12px;"><?php _e('Order:', 'futuristic-it'); ?></label>
                            <input type="number" name="hero_slides[<?php echo $i; ?>][order]" value="<?php echo esc_attr($sl['order'] ?? $i); ?>" style="width:60px;padding:4px 8px;" min="0">
                            <button type="button" class="button button-small" onclick="var row=this.closest('.hero-slide-row');var prev=row.previousElementSibling;if(prev && prev.classList.contains('hero-slide-row'))row.parentNode.insertBefore(row,prev);">↑</button>
                            <button type="button" class="button button-small" onclick="var row=this.closest('.hero-slide-row');var next=row.nextElementSibling;if(next && next.classList.contains('hero-slide-row'))row.parentNode.insertBefore(next,row);">↓</button>
                            <button type="button" class="button button-small" style="color:#dc3545;" onclick="this.closest('.hero-slide-row').remove();"><?php _e('Remove', 'futuristic-it'); ?></button>
                        </div>
                    </div>
                    <table class="form-table" style="margin:0;">
                        <tr><th><label>Title Before <em style="font-weight:400;color:#999;">(override)</em></label></th><td><input type="text" class="regular-text" name="hero_slides[<?php echo $i; ?>][title_before]" value="<?php echo esc_attr($sl['title_before'] ?? ''); ?>" style="width:100%;" placeholder="Transforming Ideas into"></td></tr>
                        <tr><th><label style="color:#b8892f;">Title Before (Khmer)</label></th><td><input type="text" class="regular-text" name="hero_slides[<?php echo $i; ?>][title_before_km]" value="<?php echo esc_attr($sl['title_before_km'] ?? ''); ?>" style="width:100%;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                        <tr><th><label style="color:#0073aa;">Rotating Keyword (English)</label></th><td><input type="text" class="regular-text" name="hero_slides[<?php echo $i; ?>][title_highlight]" value="<?php echo esc_attr($sl['title_highlight'] ?? ''); ?>" style="width:100%;" placeholder="Intelligent"></td></tr>
                        <tr><th><label style="color:#b8892f;">Rotating Keyword (Khmer)</label></th><td><input type="text" class="regular-text" name="hero_slides[<?php echo $i; ?>][title_highlight_km]" value="<?php echo esc_attr($sl['title_highlight_km'] ?? ''); ?>" style="width:100%;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                        <tr><th><label>Title After <em style="font-weight:400;color:#999;">(override)</em></label></th><td><input type="text" class="regular-text" name="hero_slides[<?php echo $i; ?>][title_after]" value="<?php echo esc_attr($sl['title_after'] ?? ''); ?>" style="width:100%;" placeholder="Solutions"></td></tr>
                        <tr><th><label style="color:#b8892f;">Title After (Khmer)</label></th><td><input type="text" class="regular-text" name="hero_slides[<?php echo $i; ?>][title_after_km]" value="<?php echo esc_attr($sl['title_after_km'] ?? ''); ?>" style="width:100%;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                        <tr><th><label>Description <em style="font-weight:400;color:#999;">(override)</em></label></th><td><textarea class="large-text" name="hero_slides[<?php echo $i; ?>][subtitle]" rows="3" style="width:100%;"><?php echo esc_textarea($sl['subtitle'] ?? ''); ?></textarea></td></tr>
                        <tr><th><label style="color:#b8892f;">Description (Khmer)</label></th><td><textarea class="large-text" name="hero_slides[<?php echo $i; ?>][subtitle_km]" rows="3" style="width:100%;font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea($sl['subtitle_km'] ?? ''); ?></textarea></td></tr>
                    </table>
                </div>
                <?php endforeach; ?>
                <p><button type="button" class="button" id="add-hero-slide">+ <?php _e('Add Slide', 'futuristic-it'); ?></button></p>
            </div>

            <input type="submit" name="futuristic_it_save_hero" class="button button-primary" value="<?php _e('Save Hero', 'futuristic-it'); ?>">
        </form>
        <script>
        var heroSlideCount = <?php echo count($hero_slides); ?>;
        document.getElementById('add-hero-slide').addEventListener('click', function() {
            var idx = heroSlideCount;
            var html = '<div class="hero-slide-row" style="background:#f9f9f9;border:1px solid #ddd;border-radius:8px;padding:16px;margin-bottom:12px;">' +
                '<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;"><h4 style="margin:0;">Slide ' + (idx+1) + '</h4>' +
                '<div style="display:flex;gap:8px;align-items:center;"><label style="font-size:12px;">Order:</label>' +
                '<input type="number" name="hero_slides[' + idx + '][order]" value="' + idx + '" style="width:60px;padding:4px 8px;" min="0">' +
                '<button type="button" class="button button-small" style="color:#dc3545;" onclick="this.closest(\'.hero-slide-row\').remove();">Remove</button></div></div>' +
                '<table class="form-table" style="margin:0;">' +
                '<tr><th><label>Title Before <em style="font-weight:400;color:#999;">(override)</em></label></th><td><input type="text" class="regular-text" name="hero_slides[' + idx + '][title_before]" value="" style="width:100%;" placeholder="Transforming Ideas into"></td></tr>' +
                '<tr><th><label style="color:#b8892f;">Title Before (Khmer)</label></th><td><input type="text" class="regular-text" name="hero_slides[' + idx + '][title_before_km]" value="" style="width:100%;font-family:\'Noto Sans Khmer\',sans-serif;"></td></tr>' +
                '<tr><th><label style="color:#0073aa;">Rotating Keyword (English)</label></th><td><input type="text" class="regular-text" name="hero_slides[' + idx + '][title_highlight]" value="" style="width:100%;" placeholder="Intelligent"></td></tr>' +
                '<tr><th><label style="color:#b8892f;">Rotating Keyword (Khmer)</label></th><td><input type="text" class="regular-text" name="hero_slides[' + idx + '][title_highlight_km]" value="" style="width:100%;font-family:\'Noto Sans Khmer\',sans-serif;"></td></tr>' +
                '<tr><th><label>Title After <em style="font-weight:400;color:#999;">(override)</em></label></th><td><input type="text" class="regular-text" name="hero_slides[' + idx + '][title_after]" value="" style="width:100%;" placeholder="Solutions"></td></tr>' +
                '<tr><th><label style="color:#b8892f;">Title After (Khmer)</label></th><td><input type="text" class="regular-text" name="hero_slides[' + idx + '][title_after_km]" value="" style="width:100%;font-family:\'Noto Sans Khmer\',sans-serif;"></td></tr>' +
                '<tr><th><label>Description <em style="font-weight:400;color:#999;">(override)</em></label></th><td><textarea class="large-text" name="hero_slides[' + idx + '][subtitle]" rows="3" style="width:100%;"></textarea></td></tr>' +
                '<tr><th><label style="color:#b8892f;">Description (Khmer)</label></th><td><textarea class="large-text" name="hero_slides[' + idx + '][subtitle_km]" rows="3" style="width:100%;font-family:\'Noto Sans Khmer\',sans-serif;"></textarea></td></tr>' +
                '</table></div>';
            var lastSlide = document.querySelectorAll('.hero-slide-row');
            if (lastSlide.length > 0) {
                lastSlide[lastSlide.length - 1].insertAdjacentHTML('afterend', html);
            } else {
                this.closest('p').insertAdjacentHTML('beforebegin', html);
            }
            heroSlideCount++;
        });

        // SVG Upload
        var uploadBtn = document.getElementById('upload_hero_svg_btn');
        if (uploadBtn) {
            uploadBtn.addEventListener('click', function(e) {
                e.preventDefault();
                var frame = wp.media({
                    title: 'Select SVG Image',
                    button: { text: 'Use this SVG' },
                    multiple: false,
                    library: { type: 'image/svg+xml' }
                });
                frame.on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    document.getElementById('custom_hero_svg').value = attachment.url;
                });
                frame.open();
            });
        }
        </script>
    </div>
    <?php
}

// Home Services Page
function futuristict_homepage_services_page() {
    if (isset($_POST['futuristic_it_save_services_section']) && check_admin_referer('futuristic_it_services_section')) {
        $fields = array('custom_services_tagline', 'custom_services_title', 'custom_services_subtitle', 'custom_services_cta_text', 'custom_services_cta_link_text', 'custom_services_cta_link');
        foreach ($fields as $f) {
            if (isset($_POST[$f])) update_option($f, sanitize_text_field($_POST[$f]));
            if (isset($_POST[$f . '_km'])) update_option($f . '_km', sanitize_text_field($_POST[$f . '_km']));
        }
        if (isset($_POST['custom_service_cards'])) {
            $cards = $_POST['custom_service_cards'];
            $existing = json_decode(get_option('custom_service_cards', '[]'), true);
            if (!is_array($existing)) $existing = array();
            foreach ($cards as $i => &$card) {
                if (isset($card['title_km'])) $card['title_km'] = sanitize_text_field($card['title_km']);
                if (isset($card['desc_km'])) $card['desc_km'] = sanitize_textarea_field($card['desc_km']);
                if (isset($card['link_text_km'])) $card['link_text_km'] = sanitize_text_field($card['link_text_km']);
                if (isset($existing[$i])) {
                    foreach (array('type', 'courses', 'course_main_title_en', 'course_main_title_kh', 'course_main_description_en', 'course_main_description_kh', 'why_learn', 'why_learn_title', 'why_learn_title_km', 'why_learn_cta_title', 'why_learn_cta_title_km', 'why_learn_cta_desc', 'why_learn_cta_desc_km', 'why_learn_cta_btn_text', 'why_learn_cta_btn_text_km', 'faqs', 'faq_title', 'faq_title_km', 'faq_subtitle', 'faq_subtitle_km', 'images', 'features', 'features_text', 'features_text_km', 'packages', 'sections', 'packages_title', 'packages_title_km', 'packages_desc', 'packages_desc_km', 'features_title', 'features_title_km', 'features_desc', 'features_desc_km') as $field) {
                        if (isset($existing[$i][$field]) && !isset($card[$field])) {
                            $card[$field] = $existing[$i][$field];
                        }
                    }
                }
            }
            unset($card);
            update_option('custom_service_cards', wp_json_encode($cards));
        }
        futuristic_it_toast('Services saved!');
    }
    $services = json_decode(get_option('custom_service_cards', '[]'), true);
    if (!is_array($services)) $services = array();
    ?>
    <div class="wrap">
        <h1><?php _e('Home – Services Section', 'futuristic-it'); ?></h1>
        <p><a href="<?php echo admin_url('admin.php?page=futuristict-homepage'); ?>">&larr; Back</a></p>
        <form method="post" action="">
            <?php wp_nonce_field('futuristic_it_services_section'); ?>
            <table class="form-table">
                <tr><th><label>Tagline (English)</label></th><td><input type="text" class="regular-text" name="custom_services_tagline" value="<?php echo esc_attr(get_option('custom_services_tagline', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Tagline (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_services_tagline_km" value="<?php echo esc_attr(get_option('custom_services_tagline_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>Section Title (English)</label></th><td><input type="text" class="regular-text" name="custom_services_title" value="<?php echo esc_attr(get_option('custom_services_title', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Section Title (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_services_title_km" value="<?php echo esc_attr(get_option('custom_services_title_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>Section Subtitle (English)</label></th><td><textarea class="large-text" name="custom_services_subtitle" rows="3"><?php echo esc_textarea(get_option('custom_services_subtitle', '')); ?></textarea></td></tr>
                <tr><th><label style="color:#b8892f;">Section Subtitle (Khmer)</label></th><td><textarea class="large-text" name="custom_services_subtitle_km" rows="3" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea(get_option('custom_services_subtitle_km', '')); ?></textarea></td></tr>
                <tr><th><label>CTA Text (English)</label></th><td><input type="text" class="regular-text" name="custom_services_cta_text" value="<?php echo esc_attr(get_option('custom_services_cta_text', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">CTA Text (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_services_cta_text_km" value="<?php echo esc_attr(get_option('custom_services_cta_text_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>CTA Link Text (English)</label></th><td><input type="text" class="regular-text" name="custom_services_cta_link_text" value="<?php echo esc_attr(get_option('custom_services_cta_link_text', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">CTA Link Text (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_services_cta_link_text_km" value="<?php echo esc_attr(get_option('custom_services_cta_link_text_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>CTA Link URL</label></th><td><input type="text" class="regular-text" name="custom_services_cta_link" value="<?php echo esc_attr(get_option('custom_services_cta_link', '')); ?>"></td></tr>
            </table>
            <h2><?php _e('Service Cards', 'futuristic-it'); ?></h2>
            <table class="widefat striped" id="svc-table">
                <thead><tr><th style="width:80px">Image</th><th>Title</th><th>Title (Khmer)</th><th>Description</th><th>Description (Khmer)</th><th>Link URL</th><th>Link Text</th><th>Link Text (Khmer)</th><th style="width:60px"></th></tr></thead>
                <tbody>
                <?php foreach ($services as $i => $s) : ?>
                    <tr data-saved="1">
                        <td><input type="hidden" name="custom_service_cards[<?php echo $i; ?>][image]" value="<?php echo esc_attr($s['image'] ?? ''); ?>"><?php if (!empty($s['image'])) : ?><img src="<?php echo esc_url($s['image']); ?>" style="width:50px;height:50px;object-fit:cover;border-radius:4px;"><?php endif; ?><br><a href="#" class="button button-small upload-btn" data-for="custom_service_cards[<?php echo $i; ?>][image]">Upload</a></td>
                        <td><input type="text" name="custom_service_cards[<?php echo $i; ?>][title]" value="<?php echo esc_attr($s['title'] ?? ''); ?>" class="widefat"></td>
                        <td><input type="text" name="custom_service_cards[<?php echo $i; ?>][title_km]" value="<?php echo esc_attr($s['title_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;"></td>
                        <td><textarea name="custom_service_cards[<?php echo $i; ?>][desc]" class="widefat" rows="2" style="resize:vertical;min-height:60px;"><?php echo esc_textarea($s['desc'] ?? ''); ?></textarea></td>
                        <td><textarea name="custom_service_cards[<?php echo $i; ?>][desc_km]" class="widefat" rows="2" style="resize:vertical;min-height:60px;font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea($s['desc_km'] ?? ''); ?></textarea></td>
                        <td><input type="text" name="custom_service_cards[<?php echo $i; ?>][link]" value="<?php echo esc_attr($s['link'] ?? ''); ?>" class="widefat"></td>
                        <td><input type="text" name="custom_service_cards[<?php echo $i; ?>][link_text]" value="<?php echo esc_attr($s['link_text'] ?? 'Learn More'); ?>" class="widefat"></td>
                        <td><input type="text" name="custom_service_cards[<?php echo $i; ?>][link_text_km]" value="<?php echo esc_attr($s['link_text_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;"></td>
                        <td><button type="button" class="button button-small del-row" style="color:#dc3545;">Delete</button></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <p><button type="button" class="button" id="add-svc">+ Add Service Card</button></p>
            <input type="submit" name="futuristic_it_save_services_section" class="button button-primary" value="Save Services">
        </form>
    </div>
    <?php
}

// Home Products Page
function futuristict_homepage_products_page() {
    if (isset($_POST['futuristic_it_save_products_section']) && check_admin_referer('futuristic_it_products_section')) {
        $fields = array('custom_products_tagline', 'custom_products_title', 'custom_products_subtitle', 'custom_products_cta_text', 'custom_products_cta_link_text', 'custom_products_cta_link', 'custom_products_group_hardware', 'custom_products_group_software');
        foreach ($fields as $f) {
            if (isset($_POST[$f])) update_option($f, sanitize_text_field($_POST[$f]));
            if (isset($_POST[$f . '_km'])) update_option($f . '_km', sanitize_text_field($_POST[$f . '_km']));
        }
        if (isset($_POST['custom_product_cards'])) {
            $cards = array_values($_POST['custom_product_cards']);
            $existing = json_decode(get_option('custom_product_cards', '[]'), true);
            if (!is_array($existing)) $existing = array();
            // Detail data (features/images/packages) is edited on a separate screen and must
            // follow the card when rows are reordered here, so match by title before index.
            $existing_by_title = array();
            foreach ($existing as $ex) {
                if (!empty($ex['title'])) $existing_by_title[$ex['title']] = $ex;
            }
            foreach ($cards as $i => &$card) {
                if (isset($card['title_km'])) $card['title_km'] = sanitize_text_field($card['title_km']);
                if (isset($card['desc_km'])) $card['desc_km'] = sanitize_textarea_field($card['desc_km']);
                if (isset($card['link_text_km'])) $card['link_text_km'] = sanitize_text_field($card['link_text_km']);
                if (isset($card['badge_km'])) $card['badge_km'] = sanitize_text_field($card['badge_km']);
                $card['type'] = sanitize_text_field($card['type'] ?? '');
                $prev = $existing_by_title[$card['title'] ?? ''] ?? ($existing[$i] ?? null);
                if (is_array($prev)) {
                    foreach (array('features', 'specs', 'images', 'packages', 'packages_title', 'packages_title_km', 'recommends') as $field) {
                        if (isset($prev[$field]) && !isset($card[$field])) {
                            $card[$field] = $prev[$field];
                        }
                    }
                }
            }
            unset($card);
            update_option('custom_product_cards', sanitize_text_field(wp_json_encode($cards)));
        }
        futuristic_it_toast('Products saved!');
    }
    $products = json_decode(get_option('custom_product_cards', '[]'), true);
    if (!is_array($products)) $products = array();
    ?>
    <div class="wrap">
        <h1><?php _e('Home – Products Section', 'futuristic-it'); ?></h1>
        <p><a href="<?php echo admin_url('admin.php?page=futuristict-homepage'); ?>">&larr; Back</a></p>
        <form method="post" action="">
            <?php wp_nonce_field('futuristic_it_products_section'); ?>
            <table class="form-table">
                <tr><th><label>Tagline (English)</label></th><td><input type="text" class="regular-text" name="custom_products_tagline" value="<?php echo esc_attr(get_option('custom_products_tagline', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Tagline (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_products_tagline_km" value="<?php echo esc_attr(get_option('custom_products_tagline_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>Section Title (English)</label></th><td><input type="text" class="regular-text" name="custom_products_title" value="<?php echo esc_attr(get_option('custom_products_title', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Section Title (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_products_title_km" value="<?php echo esc_attr(get_option('custom_products_title_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>Section Subtitle (English)</label></th><td><textarea class="large-text" name="custom_products_subtitle" rows="3"><?php echo esc_textarea(get_option('custom_products_subtitle', '')); ?></textarea></td></tr>
                <tr><th><label style="color:#b8892f;">Section Subtitle (Khmer)</label></th><td><textarea class="large-text" name="custom_products_subtitle_km" rows="3" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea(get_option('custom_products_subtitle_km', '')); ?></textarea></td></tr>
                <tr><th><label>CTA Text (English)</label></th><td><input type="text" class="regular-text" name="custom_products_cta_text" value="<?php echo esc_attr(get_option('custom_products_cta_text', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">CTA Text (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_products_cta_text_km" value="<?php echo esc_attr(get_option('custom_products_cta_text_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>CTA Link Text (English)</label></th><td><input type="text" class="regular-text" name="custom_products_cta_link_text" value="<?php echo esc_attr(get_option('custom_products_cta_link_text', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">CTA Link Text (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_products_cta_link_text_km" value="<?php echo esc_attr(get_option('custom_products_cta_link_text_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>CTA Link URL</label></th><td><input type="text" class="regular-text" name="custom_products_cta_link" value="<?php echo esc_attr(get_option('custom_products_cta_link', '')); ?>"></td></tr>
                <tr><th><label>Hardware Heading (English)</label></th><td><input type="text" class="regular-text" name="custom_products_group_hardware" value="<?php echo esc_attr(get_option('custom_products_group_hardware', 'Hardware')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Hardware Heading (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_products_group_hardware_km" value="<?php echo esc_attr(get_option('custom_products_group_hardware_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>Software Heading (English)</label></th><td><input type="text" class="regular-text" name="custom_products_group_software" value="<?php echo esc_attr(get_option('custom_products_group_software', 'Software')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Software Heading (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_products_group_software_km" value="<?php echo esc_attr(get_option('custom_products_group_software_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
            </table>
            <h2><?php _e('Product Cards', 'futuristic-it'); ?></h2>
            <p style="color:#888;margin:0 0 12px;"><?php _e('Use ↑ / ↓ to change the order cards appear on the website. Cards are grouped by Type (Software first, then Hardware) and follow this order within each group.', 'futuristic-it'); ?></p>
            <table class="widefat striped" id="prod-table">
                <thead><tr><th style="width:60px">Order</th><th>Type</th><th style="width:80px">Image</th><th>Title</th><th>Title (Khmer)</th><th>Description</th><th>Description (Khmer)</th><th>Category</th><th>Badge</th><th>Badge (Khmer)</th><th>Price</th><th>Link URL</th><th>Link Text</th><th>Link Text (Khmer)</th><th style="width:60px"></th></tr></thead>
                <tbody>
                <?php foreach ($products as $i => $p) : ?>
                    <tr data-saved="1">
                        <td><button type="button" class="button button-small move-row-up" title="Move up">↑</button> <button type="button" class="button button-small move-row-down" title="Move down">↓</button></td>
                        <td><select name="custom_product_cards[<?php echo $i; ?>][type]" class="widefat"><option value="Software" <?php selected($p['type'] ?? '', 'Software'); ?>>Software</option><option value="Hardware" <?php selected($p['type'] ?? '', 'Hardware'); ?>>Hardware</option><option value="Add" <?php selected($p['type'] ?? '', 'Add'); ?>>Add</option></select></td>
                        <td><input type="hidden" name="custom_product_cards[<?php echo $i; ?>][image]" value="<?php echo esc_attr($p['image'] ?? ''); ?>"><?php if (!empty($p['image'])) : ?><img src="<?php echo esc_url($p['image']); ?>" style="width:50px;height:50px;object-fit:cover;border-radius:4px;"><?php endif; ?><br><a href="#" class="button button-small upload-btn" data-for="custom_product_cards[<?php echo $i; ?>][image]">Upload</a></td>
                        <td><input type="text" name="custom_product_cards[<?php echo $i; ?>][title]" value="<?php echo esc_attr($p['title'] ?? ''); ?>" class="widefat"></td>
                        <td><input type="text" name="custom_product_cards[<?php echo $i; ?>][title_km]" value="<?php echo esc_attr($p['title_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;"></td>
                        <td><textarea name="custom_product_cards[<?php echo $i; ?>][desc]" class="widefat" rows="2"><?php echo esc_textarea($p['desc'] ?? ''); ?></textarea></td>
                        <td><textarea name="custom_product_cards[<?php echo $i; ?>][desc_km]" class="widefat" rows="2" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea($p['desc_km'] ?? ''); ?></textarea></td>
                        <td><input type="text" name="custom_product_cards[<?php echo $i; ?>][category]" value="<?php echo esc_attr($p['category'] ?? ''); ?>" class="widefat" placeholder="e.g., 4K Series"></td>
                        <td><input type="text" name="custom_product_cards[<?php echo $i; ?>][badge]" value="<?php echo esc_attr($p['badge'] ?? ''); ?>" class="widefat" placeholder="e.g., NEW"></td>
                        <td><input type="text" name="custom_product_cards[<?php echo $i; ?>][badge_km]" value="<?php echo esc_attr($p['badge_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;"></td>
                        <td><input type="text" name="custom_product_cards[<?php echo $i; ?>][price]" value="<?php echo esc_attr($p['price'] ?? ''); ?>" class="widefat" placeholder="$999"></td>
                        <td><input type="text" name="custom_product_cards[<?php echo $i; ?>][link]" value="<?php echo esc_attr($p['link'] ?? ''); ?>" class="widefat"></td>
                        <td><input type="text" name="custom_product_cards[<?php echo $i; ?>][link_text]" value="<?php echo esc_attr($p['link_text'] ?? 'Learn More'); ?>" class="widefat"></td>
                        <td><input type="text" name="custom_product_cards[<?php echo $i; ?>][link_text_km]" value="<?php echo esc_attr($p['link_text_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;"></td>
                        <td><button type="button" class="button button-small del-row" style="color:#dc3545;">Delete</button></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <p><button type="button" class="button" id="add-prod">+ Add Product Card</button></p>
            <input type="submit" name="futuristic_it_save_products_section" class="button button-primary" value="Save Products">
        </form>
    </div>
    <?php
}

// Home Why Choose Us Page
function futuristict_homepage_partners_page() {
    if (isset($_POST['futuristic_it_save_partners_section']) && check_admin_referer('futuristic_it_partners_section')) {
        $fields = array('custom_partners_title', 'custom_partners_subtitle');
        foreach ($fields as $f) {
            if (isset($_POST[$f])) update_option($f, sanitize_text_field($_POST[$f]));
            if (isset($_POST[$f . '_km'])) update_option($f . '_km', sanitize_text_field($_POST[$f . '_km']));
        }
        if (isset($_POST['custom_partner_cards'])) {
            $cards = $_POST['custom_partner_cards'];
            foreach ($cards as &$card) {
                if (isset($card['title_km'])) $card['title_km'] = sanitize_text_field($card['title_km']);
                if (isset($card['desc_km'])) $card['desc_km'] = sanitize_textarea_field($card['desc_km']);
            }
            unset($card);
            update_option('custom_partner_cards', sanitize_text_field(wp_json_encode($cards)));
        }
        futuristic_it_toast('Why Choose Us saved!');
    }
    $partners = json_decode(get_option('custom_partner_cards', '[]'), true);
    if (!is_array($partners)) $partners = array();
    ?>
    <div class="wrap">
        <h1><?php _e('Home – Why Choose Us', 'futuristic-it'); ?></h1>
        <p><a href="<?php echo admin_url('admin.php?page=futuristict-homepage'); ?>">&larr; Back</a></p>
        <form method="post" action="">
            <?php wp_nonce_field('futuristic_it_partners_section'); ?>
            <table class="form-table">
                <tr><th><label>Section Title (English)</label></th><td><input type="text" class="regular-text" name="custom_partners_title" value="<?php echo esc_attr(get_option('custom_partners_title', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Section Title (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_partners_title_km" value="<?php echo esc_attr(get_option('custom_partners_title_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>Section Subtitle (English)</label></th><td><textarea class="large-text" name="custom_partners_subtitle" rows="3"><?php echo esc_textarea(get_option('custom_partners_subtitle', '')); ?></textarea></td></tr>
                <tr><th><label style="color:#b8892f;">Section Subtitle (Khmer)</label></th><td><textarea class="large-text" name="custom_partners_subtitle_km" rows="3" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea(get_option('custom_partners_subtitle_km', '')); ?></textarea></td></tr>
            </table>
            <h2><?php _e('Feature Cards', 'futuristic-it'); ?></h2>
            <table class="widefat striped" id="partner-table">
                <thead><tr><th style="width:120px">Image</th><th>Title</th><th>Title (Khmer)</th><th>Description</th><th>Description (Khmer)</th><th style="width:60px"></th></tr></thead>
                <tbody>
                <?php foreach ($partners as $i => $p) : ?>
                    <tr data-saved="1">
                        <td>
                            <input type="hidden" name="custom_partner_cards[<?php echo $i; ?>][image]" value="<?php echo esc_attr($p['image'] ?? ''); ?>">
                            <?php if (!empty($p['image'])) : ?>
                                <img src="<?php echo esc_url($p['image']); ?>" style="width:50px;height:50px;object-fit:contain;border-radius:4px;background:#fff;padding:4px;margin-bottom:4px;display:block;">
                            <?php endif; ?>
                            <button type="button" class="button button-small upload-btn" data-for="custom_partner_cards[<?php echo $i; ?>][image]">Upload</button>
                        </td>
                        <td><input type="text" name="custom_partner_cards[<?php echo $i; ?>][title]" value="<?php echo esc_attr($p['title'] ?? ''); ?>" class="widefat"></td>
                        <td><input type="text" name="custom_partner_cards[<?php echo $i; ?>][title_km]" value="<?php echo esc_attr($p['title_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;"></td>
                        <td><textarea name="custom_partner_cards[<?php echo $i; ?>][desc]" class="widefat" rows="2"><?php echo esc_textarea($p['desc'] ?? ''); ?></textarea></td>
                        <td><textarea name="custom_partner_cards[<?php echo $i; ?>][desc_km]" class="widefat" rows="2" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea($p['desc_km'] ?? ''); ?></textarea></td>
                        <td><button type="button" class="button button-small del-row" style="color:#dc3545;">Delete</button></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <p><button type="button" class="button" id="add-partner">+ Add Feature</button></p>
            <input type="submit" name="futuristic_it_save_partners_section" class="button button-primary" value="Save Why Choose Us">
        </form>
    </div>
    <?php
}

// Home CTA Page
function futuristict_homepage_cta_page() {
    if (isset($_POST['futuristic_it_save_cta_section']) && check_admin_referer('futuristic_it_cta_section')) {
        $fields = array('custom_cta_tagline', 'custom_cta_title', 'custom_cta_subtitle', 'custom_cta_tags', 'custom_cta_box_title', 'custom_cta_box_btn_text', 'custom_cta_box_btn_link');
        foreach ($fields as $f) {
            if (isset($_POST[$f])) update_option($f, sanitize_text_field($_POST[$f]));
            if (isset($_POST[$f . '_km'])) update_option($f . '_km', sanitize_text_field($_POST[$f . '_km']));
        }
        if (isset($_POST['cta_features'])) {
            $features = $_POST['cta_features'];
            foreach ($features as &$feat) {
                if (isset($feat['title_km'])) $feat['title_km'] = sanitize_text_field($feat['title_km']);
                if (isset($feat['desc_km'])) $feat['desc_km'] = sanitize_textarea_field($feat['desc_km']);
            }
            unset($feat);
            update_option('custom_cta_features', sanitize_text_field(wp_json_encode($features)));
        }
        futuristic_it_toast('CTA saved!');
    }
    $features = json_decode(get_option('custom_cta_features', '[]'), true);
    if (!is_array($features)) $features = array();
    ?>
    <div class="wrap">
        <h1><?php _e('Home – CTA / Assurance', 'futuristic-it'); ?></h1>
        <p><a href="<?php echo admin_url('admin.php?page=futuristict-homepage'); ?>">&larr; Back</a></p>
        <form method="post" action="">
            <?php wp_nonce_field('futuristic_it_cta_section'); ?>
            <table class="form-table">
                <tr><th><label>Tagline (English)</label></th><td><input type="text" class="regular-text" name="custom_cta_tagline" value="<?php echo esc_attr(get_option('custom_cta_tagline', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Tagline (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_cta_tagline_km" value="<?php echo esc_attr(get_option('custom_cta_tagline_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>Section Title (English)</label></th><td><input type="text" class="regular-text" name="custom_cta_title" value="<?php echo esc_attr(get_option('custom_cta_title', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Section Title (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_cta_title_km" value="<?php echo esc_attr(get_option('custom_cta_title_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>Section Subtitle (English)</label></th><td><textarea class="large-text" name="custom_cta_subtitle" rows="3"><?php echo esc_textarea(get_option('custom_cta_subtitle', '')); ?></textarea></td></tr>
                <tr><th><label style="color:#b8892f;">Section Subtitle (Khmer)</label></th><td><textarea class="large-text" name="custom_cta_subtitle_km" rows="3" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea(get_option('custom_cta_subtitle_km', '')); ?></textarea></td></tr>
                <tr><th><label>Tag Pills (English, comma separated)</label></th><td><textarea class="large-text" name="custom_cta_tags" rows="2"><?php echo esc_textarea(get_option('custom_cta_tags', '')); ?></textarea></td></tr>
                <tr><th><label style="color:#b8892f;">Tag Pills (Khmer)</label></th><td><textarea class="large-text" name="custom_cta_tags_km" rows="2" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea(get_option('custom_cta_tags_km', '')); ?></textarea></td></tr>
                <tr><th><label>Box Title (English)</label></th><td><input type="text" class="regular-text" name="custom_cta_box_title" value="<?php echo esc_attr(get_option('custom_cta_box_title', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Box Title (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_cta_box_title_km" value="<?php echo esc_attr(get_option('custom_cta_box_title_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>Box Button Text (English)</label></th><td><input type="text" class="regular-text" name="custom_cta_box_btn_text" value="<?php echo esc_attr(get_option('custom_cta_box_btn_text', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Box Button Text (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_cta_box_btn_text_km" value="<?php echo esc_attr(get_option('custom_cta_box_btn_text_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>Box Button Link</label></th><td><input type="text" class="regular-text" name="custom_cta_box_btn_link" value="<?php echo esc_attr(get_option('custom_cta_box_btn_link', '')); ?>"></td></tr>
            </table>
            <h2><?php _e('Checklist Features', 'futuristic-it'); ?></h2>
            <table class="widefat striped" id="cta-features-table">
                <thead><tr><th style="width:80px">Image</th><th>Title</th><th>Title (Khmer)</th><th>Description</th><th>Description (Khmer)</th><th style="width:60px"></th></tr></thead>
                <tbody>
                <?php foreach ($features as $i => $f) : ?>
                    <tr data-saved="1">
                        <td><input type="hidden" name="cta_features[<?php echo $i; ?>][icon]" value="<?php echo esc_attr($f['icon'] ?? ''); ?>"><?php if (!empty($f['icon'])) : ?><img src="<?php echo esc_url($f['icon']); ?>" style="width:40px;height:40px;object-fit:contain;border-radius:4px;background:#fff;padding:2px;"><?php endif; ?><br><a href="#" class="button button-small upload-btn" data-for="cta_features[<?php echo $i; ?>][icon]">Upload</a></td>
                        <td><input type="text" name="cta_features[<?php echo $i; ?>][title]" value="<?php echo esc_attr($f['title'] ?? ''); ?>" class="widefat"></td>
                        <td><input type="text" name="cta_features[<?php echo $i; ?>][title_km]" value="<?php echo esc_attr($f['title_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;"></td>
                        <td><textarea name="cta_features[<?php echo $i; ?>][desc]" class="widefat" rows="2"><?php echo esc_textarea($f['desc'] ?? ''); ?></textarea></td>
                        <td><textarea name="cta_features[<?php echo $i; ?>][desc_km]" class="widefat" rows="2" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea($f['desc_km'] ?? ''); ?></textarea></td>
                        <td><button type="button" class="button button-small del-row" style="color:#dc3545;">Delete</button></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <p><button type="button" class="button" id="add-cta-feature">+ Add Feature</button></p>
            <input type="submit" name="futuristic_it_save_cta_section" class="button button-primary" value="Save CTA">
        </form>
    </div>
    <?php
}

// About Us Page
function futuristict_about_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('About Us', 'futuristic-it'); ?></h1>
        <p style="color:#666;margin-bottom:20px;"><?php _e('Select a section to edit:', 'futuristic-it'); ?></p>
        <div class="fw-cards">
            <a href="<?php echo admin_url('admin.php?page=futuristict-about-hero'); ?>" class="fw-card">
                <h3><?php _e('Hero Section', 'futuristic-it'); ?></h3>
                <p><?php _e('Edit hero image, title, subtitle and button.', 'futuristic-it'); ?></p>
            </a>
            <a href="<?php echo admin_url('admin.php?page=futuristict-about-story'); ?>" class="fw-card">
                <h3><?php _e('Our Story', 'futuristic-it'); ?></h3>
                <p><?php _e('Edit story image, title and paragraphs.', 'futuristic-it'); ?></p>
            </a>
            <a href="<?php echo admin_url('admin.php?page=futuristict-about-philosophy'); ?>" class="fw-card">
                <h3><?php _e('Core Philosophy', 'futuristic-it'); ?></h3>
                <p><?php _e('Edit vision and mission statements.', 'futuristic-it'); ?></p>
            </a>
            <a href="<?php echo admin_url('admin.php?page=futuristict-about-timeline'); ?>" class="fw-card">
                <h3><?php _e('Timeline', 'futuristic-it'); ?></h3>
                <p><?php _e('Edit milestones and years.', 'futuristic-it'); ?></p>
            </a>
            <a href="<?php echo admin_url('admin.php?page=futuristict-about-faq'); ?>" class="fw-card">
                <h3><?php _e('FAQ', 'futuristic-it'); ?></h3>
                <p><?php _e('Add, edit or remove frequently asked questions.', 'futuristic-it'); ?></p>
            </a>
        </div>
    </div>
    <?php
}

// Our Service Page
function futuristict_services_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('Our Service', 'futuristic-it'); ?></h1>
        <p style="color:#666;margin-bottom:20px;"><?php _e('Select a section to edit:', 'futuristic-it'); ?></p>
        <div class="fw-cards">
            <a href="<?php echo admin_url('admin.php?page=futuristict-services-hero'); ?>" class="fw-card">
                <h3><?php _e('Hero Section', 'futuristic-it'); ?></h3>
                <p><?php _e('Edit hero image, title, subtitle and button.', 'futuristic-it'); ?></p>
            </a>
            <a href="<?php echo admin_url('admin.php?page=futuristict-services-cards'); ?>" class="fw-card">
                <h3><?php _e('Service Cards', 'futuristic-it'); ?></h3>
                <p><?php _e('Add, edit or remove service detail cards with features.', 'futuristic-it'); ?></p>
            </a>
            <a href="<?php echo admin_url('admin.php?page=futuristict-services-stats'); ?>" class="fw-card">
                <h3><?php _e('Stats Section', 'futuristic-it'); ?></h3>
                <p><?php _e('Edit stability stats and team image.', 'futuristic-it'); ?></p>
            </a>
            <a href="<?php echo admin_url('admin.php?page=futuristict-services-cta'); ?>" class="fw-card">
                <h3><?php _e('CTA Section', 'futuristic-it'); ?></h3>
                <p><?php _e('Edit call-to-action title, description and button.', 'futuristic-it'); ?></p>
            </a>
            <a href="<?php echo admin_url('admin.php?page=futuristict-service-detail'); ?>" class="fw-card">
                <h3><?php _e('Service Details', 'futuristic-it'); ?></h3>
                <p><?php _e('Add features, packages and detail sections to services.', 'futuristic-it'); ?></p>
            </a>
        </div>
    </div>
    <?php
}

// Helper to fix media URLs pointing to localhost
function futuristic_it_media_url($url) {
    if (empty($url) || !is_string($url)) return '';
    if (strpos($url, 'localhost') !== false || strpos($url, '127.0.0.1') !== false) {
        $parsed = parse_url($url);
        $path = $parsed['path'] ?? '';
        if (!empty($path)) {
            return home_url($path);
        }
    }
    return $url;
}

// Auto-create Service Detail page & sync default services
function futuristic_it_create_service_detail_page() {
    $page = get_page_by_path('service-detail');
    if (!$page) {
        $id = wp_insert_post(array(
            'post_title'    => 'Service Detail',
            'post_name'     => 'service-detail',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'page_template' => 'services/service-detail.php',
        ));
        if ($id && !is_wp_error($id)) {
            update_post_meta($id, '_wp_page_template', 'services/service-detail.php');
        }
    } else {
        $tpl = get_post_meta($page->ID, '_wp_page_template', true);
        if ($tpl !== 'services/service-detail.php') {
            update_post_meta($page->ID, '_wp_page_template', 'services/service-detail.php');
        }
    }

    // Auto-seed Course service / services if missing from DB
    $json_file = get_template_directory() . '/services-default.json';
    if (file_exists($json_file)) {
        $raw = get_option('custom_service_cards', '[]');
        $cards = json_decode($raw, true);
        $defaults = json_decode(file_get_contents($json_file), true);

        if (empty($cards) || !is_array($cards)) {
            if (is_array($defaults) && !empty($defaults)) {
                update_option('custom_service_cards', wp_json_encode($defaults));
            }
        } elseif (is_array($defaults)) {
            $has_course = false;
            foreach ($cards as $c) {
                if (($c['type'] ?? '') === 'Course' || !empty($c['courses'])) {
                    $has_course = true;
                    break;
                }
            }
            if (!$has_course) {
                foreach ($defaults as $dc) {
                    if (($dc['type'] ?? '') === 'Course' || !empty($dc['courses'])) {
                        $cards[] = $dc;
                    }
                }
                update_option('custom_service_cards', wp_json_encode($cards));
            }
        }
    }
}
add_action('after_switch_theme', 'futuristic_it_create_service_detail_page');
add_action('init', function() {
    $page = get_page_by_path('service-detail');
    if (!$page) futuristic_it_create_service_detail_page();
});

// Service Detail Admin Page
// Service features moved from a title/desc repeater to a "Label: Value" textarea.
// Cards saved before that change have no features_text key, so fall back to the old
// rows; once the key exists an empty value means the user cleared it deliberately.
function futuristic_it_service_features_text($service) {
    if (isset($service['features_text'])) return $service['features_text'];
    $lines = array();
    foreach ($service['features'] ?? array() as $feat) {
        if (!is_array($feat)) {
            if (trim($feat) !== '') $lines[] = trim($feat);
            continue;
        }
        $title = trim($feat['title'] ?? '');
        $desc = trim($feat['desc'] ?? '');
        if ($title !== '' && $desc !== '') $lines[] = $title . ': ' . $desc;
        elseif ($title !== '' || $desc !== '') $lines[] = $title !== '' ? $title : $desc;
    }
    return implode("\n", $lines);
}

function futuristic_it_service_features_text_km($service) {
    if (isset($service['features_text_km'])) return $service['features_text_km'];
    $lines = array();
    foreach ($service['features'] ?? array() as $feat) {
        if (!is_array($feat)) continue;
        $title = trim($feat['title_km'] ?? '');
        $desc = trim($feat['desc_km'] ?? '');
        if ($title !== '' && $desc !== '') $lines[] = $title . ': ' . $desc;
        elseif ($title !== '' || $desc !== '') $lines[] = $title !== '' ? $title : $desc;
    }
    return implode("\n", $lines);
}

/**
 * Inline SVG for a "Why Learn With Us" card icon.
 * The admin stores an icon *name* (not markup), so nothing user-supplied is
 * ever echoed as HTML — an unknown name falls back to the default glyph.
 */
function futuristic_it_why_learn_icon($name) {
    $name = futuristic_it_why_learn_icon_name($name);
    $paths = array(
        'instructor' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
        'location'   => '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>',
        'certificate'=> '<rect x="3" y="4" width="18" height="14" rx="2"/><path d="M7 8h10M7 12h6"/><circle cx="17" cy="18" r="2.5"/><path d="M15.5 20.2 14 23l3-1 3 1-1.5-2.8"/>',
        'support'    => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
        'clock'      => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
        'star'       => '<path d="m12 2 3.1 6.3 6.9 1-5 4.9 1.2 6.8L12 17.8 5.8 21l1.2-6.8-5-4.9 6.9-1z"/>',
        'briefcase'  => '<rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>',
        'book'       => '<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>',
    );
    if (!isset($paths[$name])) $name = 'instructor';
    return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $paths[$name] . '</svg>';
}

/**
 * Resolve an icon name to a known choice, falling back to the default.
 * Used for both the SVG glyph and the tint class, so an unknown name never
 * renders a card with an unstyled (invisible) icon tile.
 */
function futuristic_it_why_learn_icon_name($name) {
    $name = sanitize_key($name);
    $known = array_keys(futuristic_it_why_learn_icon_choices());
    return in_array($name, $known, true) ? $name : 'instructor';
}

/**
 * Icon choices for the "Why Learn With Us" admin dropdown.
 */
function futuristic_it_why_learn_icon_choices() {
    return array(
        'instructor'  => __('Instructor / people', 'futuristic-it'),
        'location'    => __('Location pin', 'futuristic-it'),
        'certificate' => __('Certificate', 'futuristic-it'),
        'support'     => __('Support / chat', 'futuristic-it'),
        'clock'       => __('Clock / time', 'futuristic-it'),
        'star'        => __('Star / quality', 'futuristic-it'),
        'briefcase'   => __('Briefcase / career', 'futuristic-it'),
        'book'        => __('Book / learning', 'futuristic-it'),
    );
}

function futuristict_service_detail_page() {
    $raw_services = get_option('custom_service_cards', '[]');
    $all_services = json_decode($raw_services, true);
    if (!is_array($all_services)) $all_services = array();

    $selected_key = isset($_GET['service_key']) ? sanitize_text_field($_GET['service_key']) : '';
    $view = isset($_GET['view']) ? sanitize_text_field($_GET['view']) : 'list';

    // Handle save
    if (isset($_POST['futuristic_it_save_service_detail']) && check_admin_referer('futuristic_it_service_detail')) {
        $post_key = sanitize_text_field($_POST['service_key']);
        foreach ($all_services as &$svc) {
            if (('svc_' . md5($svc['title'] ?? '')) === $post_key) {
                $svc['service_type'] = sanitize_text_field($_POST['service_type'] ?? 'Default');

                // Save course card fields if type is Course
                if ($svc['service_type'] === 'Course') {
                    $raw_courses = isset($_POST['svc_courses']) && is_array($_POST['svc_courses']) ? $_POST['svc_courses'] : array();
                    $existing_courses = isset($svc['courses']) && is_array($svc['courses']) ? $svc['courses'] : array();
                    $processed_courses = array();
                    foreach ($raw_courses as $ci => $c) {
                        $title = sanitize_text_field($c['title_en'] ?? $c['title'] ?? '');
                        if (!empty($title)) {
                            // Start with existing course data to preserve Course Detail fields
                            $existing = isset($existing_courses[$ci]) ? $existing_courses[$ci] : array();
                            $processed = array_merge($existing, array(
                                'image' => sanitize_text_field($c['image'] ?? ''),
                                'title_en' => sanitize_text_field($c['title_en'] ?? $c['title'] ?? ''),
                                'title_kh' => sanitize_text_field($c['title_kh'] ?? $c['title_km'] ?? ''),
                                'description_en' => sanitize_textarea_field($c['description_en'] ?? $c['description'] ?? ''),
                                'description_kh' => sanitize_textarea_field($c['description_kh'] ?? $c['description_km'] ?? ''),
                                'instructor' => sanitize_text_field($c['instructor'] ?? ''),
                                'instructor_km' => sanitize_text_field($c['instructor_km'] ?? ''),
                                'badge' => sanitize_text_field($c['badge'] ?? ''),
                                'badge_km' => sanitize_text_field($c['badge_km'] ?? ''),
                                'rating' => sanitize_text_field($c['rating'] ?? ''),
                                'reviews' => sanitize_text_field($c['reviews'] ?? ''),
                                'price' => sanitize_text_field($c['price'] ?? ''),
                            ));
                            $processed_courses[] = $processed;
                        }
                    }
                    $svc['courses'] = $processed_courses;
                }

                $svc['images'] = array();
                $img_idx = 1;
                for ($si = 1; $si <= 6; $si++) {
                    $clean = sanitize_text_field($_POST['service_image_' . $si] ?? '');
                    if (!empty($clean)) {
                        $svc['images'][$img_idx] = $clean;
                        $img_idx++;
                    }
                }
                for ($si = $img_idx; $si <= 6; $si++) {
                    $svc['images'][$si] = '';
                }

                $svc['features_title'] = sanitize_text_field($_POST['features_title'] ?? '');
                $svc['features_title_km'] = sanitize_text_field($_POST['features_title_km'] ?? '');
                $svc['features_desc'] = sanitize_textarea_field($_POST['features_desc'] ?? '');
                $svc['features_desc_km'] = sanitize_textarea_field($_POST['features_desc_km'] ?? '');
                $svc['features_text'] = sanitize_textarea_field($_POST['svc_features_text'] ?? '');
                $svc['features_text_km'] = sanitize_textarea_field($_POST['svc_features_text_km'] ?? '');
                $svc['packages_title'] = sanitize_text_field($_POST['packages_title'] ?? '');
                $svc['packages_title_km'] = sanitize_text_field($_POST['packages_title_km'] ?? '');
                $svc['packages_desc'] = sanitize_textarea_field($_POST['packages_desc'] ?? '');
                $svc['packages_desc_km'] = sanitize_textarea_field($_POST['packages_desc_km'] ?? '');

                // Save course main title and description fields
                $svc['course_main_title_en'] = sanitize_text_field($_POST['course_main_title_en'] ?? '');
                $svc['course_main_title_kh'] = sanitize_text_field($_POST['course_main_title_kh'] ?? '');
                $svc['course_main_description_en'] = sanitize_textarea_field($_POST['course_main_description_en'] ?? '');
                $svc['course_main_description_kh'] = sanitize_textarea_field($_POST['course_main_description_kh'] ?? '');

                // Process packages
                $raw_packages = isset($_POST['svc_packages']) && is_array($_POST['svc_packages']) ? $_POST['svc_packages'] : array();
                $processed_packages = array();
                foreach ($raw_packages as $pkg) {
                    $title = sanitize_text_field($pkg['title'] ?? '');
                    $price = sanitize_text_field($pkg['price'] ?? '');
                    if (!empty($title) || !empty($price)) {
                        $features_text = isset($pkg['features_text']) ? $pkg['features_text'] : '';
                        $features_text_km = isset($pkg['features_text_km']) ? $pkg['features_text_km'] : '';
                        $processed_packages[] = array(
                            'title' => $title,
                            'title_km' => sanitize_text_field($pkg['title_km'] ?? ''),
                            'price' => $price,
                            'badge' => sanitize_text_field($pkg['badge'] ?? ''),
                            'badge_km' => sanitize_text_field($pkg['badge_km'] ?? ''),
                            'btn_text' => sanitize_text_field($pkg['btn_text'] ?? ''),
                            'btn_text_km' => sanitize_text_field($pkg['btn_text_km'] ?? ''),
                            'btn_link' => sanitize_text_field($pkg['btn_link'] ?? ''),
                            'order' => intval($pkg['order'] ?? 999),
                            'features' => array_values(array_filter(array_map('trim', explode("\n", $features_text)))),
                            'features_km' => array_values(array_filter(array_map('trim', explode("\n", $features_text_km)))),
                        );
                    }
                }
                // Sort by order
                if (count($processed_packages) > 1) {
                    usort($processed_packages, function($a, $b) {
                        return $a['order'] - $b['order'];
                    });
                }
                $svc['packages'] = $processed_packages;

                // Process "Why Learn With Us" cards
                $svc['why_learn_title'] = sanitize_text_field($_POST['why_learn_title'] ?? '');
                $svc['why_learn_title_km'] = sanitize_text_field($_POST['why_learn_title_km'] ?? '');
                $raw_why = isset($_POST['svc_why_learn']) && is_array($_POST['svc_why_learn']) ? $_POST['svc_why_learn'] : array();
                $processed_why = array();
                foreach ($raw_why as $w) {
                    $w_title = sanitize_text_field($w['title'] ?? '');
                    $w_desc = sanitize_textarea_field($w['desc'] ?? '');
                    if ($w_title !== '' || $w_desc !== '') {
                        $processed_why[] = array(
                            'icon'     => sanitize_key($w['icon'] ?? 'instructor'),
                            'title'    => $w_title,
                            'title_km' => sanitize_text_field($w['title_km'] ?? ''),
                            'desc'     => $w_desc,
                            'desc_km'  => sanitize_textarea_field($w['desc_km'] ?? ''),
                        );
                    }
                }
                $svc['why_learn'] = $processed_why;

                // "Training your whole team?" CTA banner under the cards
                $svc['why_learn_cta_title'] = sanitize_text_field($_POST['why_learn_cta_title'] ?? '');
                $svc['why_learn_cta_title_km'] = sanitize_text_field($_POST['why_learn_cta_title_km'] ?? '');
                $svc['why_learn_cta_desc'] = sanitize_textarea_field($_POST['why_learn_cta_desc'] ?? '');
                $svc['why_learn_cta_desc_km'] = sanitize_textarea_field($_POST['why_learn_cta_desc_km'] ?? '');
                $svc['why_learn_cta_btn_text'] = sanitize_text_field($_POST['why_learn_cta_btn_text'] ?? '');
                $svc['why_learn_cta_btn_text_km'] = sanitize_text_field($_POST['why_learn_cta_btn_text_km'] ?? '');
                $svc['why_learn_cta_btn_link'] = esc_url_raw($_POST['why_learn_cta_btn_link'] ?? '');

                // FAQ section under the group-training banner
                $svc['faq_title'] = sanitize_text_field($_POST['faq_title'] ?? '');
                $svc['faq_title_km'] = sanitize_text_field($_POST['faq_title_km'] ?? '');
                $svc['faq_subtitle'] = sanitize_textarea_field($_POST['faq_subtitle'] ?? '');
                $svc['faq_subtitle_km'] = sanitize_textarea_field($_POST['faq_subtitle_km'] ?? '');
                $raw_faqs = isset($_POST['svc_faqs']) && is_array($_POST['svc_faqs']) ? $_POST['svc_faqs'] : array();
                $processed_faqs = array();
                foreach ($raw_faqs as $fq) {
                    $fq_q = sanitize_text_field($fq['q'] ?? '');
                    $fq_a = sanitize_textarea_field($fq['a'] ?? '');
                    if ($fq_q !== '' || $fq_a !== '') {
                        $processed_faqs[] = array(
                            'q'    => $fq_q,
                            'a'    => $fq_a,
                            'q_km' => sanitize_text_field($fq['q_km'] ?? ''),
                            'a_km' => sanitize_textarea_field($fq['a_km'] ?? ''),
                        );
                    }
                }
                $svc['faqs'] = $processed_faqs;

                // Preserve existing fields from Services Cards admin
                // (image, title, desc, link, link_text are already in $svc)
                
                break;
            }
        }
        unset($svc);
        update_option('custom_service_cards', wp_json_encode($all_services));
        $selected_key = $post_key;
        $view = 'edit';
        futuristic_it_toast('Service details saved!');
    }

    // Handle product selection from dropdown
    if (isset($_GET['select_service']) && !empty($_GET['select_service'])) {
        $selected_key = sanitize_text_field($_GET['select_service']);
        $view = 'edit';
    }

    // Get selected service data
    $selected_service = null;
    if ($view === 'edit' && $selected_key) {
        foreach ($all_services as $svc) {
            if (('svc_' . md5($svc['title'] ?? '')) === $selected_key) {
                $selected_service = $svc;
                break;
            }
        }
    }
    ?>
    <div class="wrap">
        <h1><?php _e('Service Details', 'futuristic-it'); ?></h1>

        <!-- Dropdown Selector -->
        <div style="background:#fff;padding:20px;border:1px solid #ccc;border-radius:8px;margin-bottom:24px;">
            <h3 style="margin:0 0 12px;"><?php _e('Select a Service to Add Details', 'futuristic-it'); ?></h3>
            <form method="get" action="" style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
                <input type="hidden" name="page" value="futuristict-service-detail">
                <input type="hidden" name="view" value="edit">
                <select name="select_service" style="min-width:350px;padding:8px;">
                    <option value=""><?php _e('— Choose a service —', 'futuristic-it'); ?></option>
                    <?php foreach ($all_services as $svc) :
                        $key = 'svc_' . md5($svc['title'] ?? '');
                    ?>
                        <option value="<?php echo esc_attr($key); ?>" <?php selected($selected_key, $key); ?>><?php echo esc_html($svc['title'] ?? ''); ?></option>
                    <?php endforeach; ?>
                </select>
                <select name="service_type" id="serviceTypeSelect" style="min-width:200px;padding:8px;">
                    <option value="Default" <?php selected($selected_service['service_type'] ?? 'Default', 'Default'); ?>><?php _e('Default', 'futuristic-it'); ?></option>
                    <option value="Course" <?php selected($selected_service['service_type'] ?? '', 'Course'); ?>><?php _e('Course', 'futuristic-it'); ?></option>
                </select>
                <button type="submit" class="button button-primary"><?php _e('Add Details', 'futuristic-it'); ?></button>
            </form>
            <p style="color:#888;margin:8px 0 0;font-size:12px;"><?php _e('Select "Course" to show course card fields instead of the default detail layout.', 'futuristic-it'); ?></p>
        </div>

        <!-- Edit Form -->
        <?php if ($view === 'edit' && $selected_service) : ?>
            <div style="background:#fff;padding:24px;border:1px solid #ccc;border-radius:8px;margin-bottom:24px;">
                <h2 style="margin:0 0 16px;"><?php _e('Edit:', 'futuristic-it'); ?> <?php echo esc_html($selected_service['title'] ?? ''); ?></h2>
                <form method="post" action="">
                    <?php wp_nonce_field('futuristic_it_service_detail'); ?>
                    <input type="hidden" name="service_key" value="<?php echo esc_attr($selected_key); ?>">
                    <input type="hidden" name="service_type" id="serviceTypeHidden" value="<?php echo esc_attr($selected_service['service_type'] ?? 'Default'); ?>">

                    <!-- DETAIL FIELDS (Images, Features, Packages) -->
                    <div id="detailFields" style="<?php echo ($selected_service['service_type'] ?? 'Default') === 'Course' ? 'display:none;' : ''; ?>">
                    <h3><?php _e('Service Images', 'futuristic-it'); ?></h3>
                    <p style="color:#999;margin:0 0 12px;"><?php _e('Image 1 is the main image shown on the detail page.', 'futuristic-it'); ?></p>
                    <div id="service-images-container">
                        <?php
                        $svc_images = $selected_service['images'] ?? array();
                        $img_count = 0;
                        for ($i = 1; $i <= 6; $i++) {
                            if (!empty($svc_images[$i])) $img_count++;
                        }
                        $shown = 0;
                        for ($i = 1; $i <= 6; $i++) :
                            $img_val = $svc_images[$i] ?? '';
                            if (empty($img_val) && $shown >= max($img_count, 1)) continue;
                            $shown++;
                        ?>
                        <div class="service-image-row" style="display:flex;align-items:center;gap:12px;margin-bottom:12px;padding:12px;background:#f9f9f9;border-radius:8px;">
                            <div style="min-width:100px;">
                                <?php if ($i === 1) : ?>
                                    <span style="display:inline-block;background:#1a3d27;color:#fff;padding:3px 10px;border-radius:4px;font-size:11px;font-weight:700;"><?php _e('MAIN IMAGE', 'futuristic-it'); ?></span>
                                <?php else : ?>
                                    <span style="color:#999;font-size:12px;"><?php _e('Image', 'futuristic-it'); ?> <?php echo $i; ?></span>
                                <?php endif; ?>
                            </div>
                            <input type="hidden" name="service_image_<?php echo $i; ?>" value="<?php echo esc_attr($img_val); ?>">
                            <img src="<?php echo esc_url($img_val); ?>" style="max-height:80px;border-radius:4px;<?php echo empty($img_val) ? 'display:none;' : ''; ?>">
                            <button type="button" class="button upload-btn" data-for="service_image_<?php echo $i; ?>"><?php _e('Upload', 'futuristic-it'); ?></button>
                            <button type="button" class="button button-small" style="color:#dc3545;" onclick="this.closest('.service-image-row').remove();"><?php _e('Remove', 'futuristic-it'); ?></button>
                        </div>
                        <?php endfor; ?>
                    </div>

                    <h3><?php _e('Features', 'futuristic-it'); ?></h3>
                    <div style="margin-bottom:16px;">
                        <div style="margin-bottom:12px;"><label style="font-weight:600;font-size:12px;"><?php _e('Section Title (English)', 'futuristic-it'); ?></label><input type="text" name="features_title" value="<?php echo esc_attr($selected_service['features_title'] ?? ''); ?>" class="widefat" placeholder="Advanced Ecosystem Components"></div>
                        <div style="margin-bottom:12px;"><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Section Title (Khmer)', 'futuristic-it'); ?></label><input type="text" name="features_title_km" value="<?php echo esc_attr($selected_service['features_title_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;"></div>
                        <div style="margin-bottom:12px;"><label style="font-weight:600;font-size:12px;"><?php _e('Section Description (English)', 'futuristic-it'); ?></label><input type="text" name="features_desc" value="<?php echo esc_attr($selected_service['features_desc'] ?? ''); ?>" class="widefat" placeholder="Scalable architectures built with modern technological stacks."></div>
                        <div><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Section Description (Khmer)', 'futuristic-it'); ?></label><input type="text" name="features_desc_km" value="<?php echo esc_attr($selected_service['features_desc_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;"></div>
                    </div>
                    <div style="margin-bottom:16px;">
                        <div style="margin-bottom:12px;"><label style="font-weight:600;font-size:12px;"><?php _e('Features (English, one per line, format: Label: Value)', 'futuristic-it'); ?></label><textarea name="svc_features_text" class="widefat" rows="8" placeholder="Delivery Time: 4–6 weeks&#10;Team Size: 3 specialists&#10;Support: 12 months included"><?php echo esc_textarea(futuristic_it_service_features_text($selected_service)); ?></textarea></div>
                        <div><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Features (Khmer)', 'futuristic-it'); ?></label><textarea name="svc_features_text_km" class="widefat" rows="8" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea(futuristic_it_service_features_text_km($selected_service)); ?></textarea></div>
                    </div>

                    <h3><?php _e('Packages', 'futuristic-it'); ?></h3>
                    <div style="margin-bottom:16px;">
                        <div style="margin-bottom:12px;"><label style="font-weight:600;font-size:12px;"><?php _e('Section Title (English)', 'futuristic-it'); ?></label><input type="text" name="packages_title" value="<?php echo esc_attr($selected_service['packages_title'] ?? ''); ?>" class="widefat" placeholder="Consulting Packages"></div>
                        <div style="margin-bottom:12px;"><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Section Title (Khmer)', 'futuristic-it'); ?></label><input type="text" name="packages_title_km" value="<?php echo esc_attr($selected_service['packages_title_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;"></div>
                        <div style="margin-bottom:12px;"><label style="font-weight:600;font-size:12px;"><?php _e('Section Description (English)', 'futuristic-it'); ?></label><input type="text" name="packages_desc" value="<?php echo esc_attr($selected_service['packages_desc'] ?? ''); ?>" class="widefat" placeholder="Tailored engagement models designed for institutional scale."></div>
                        <div><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Section Description (Khmer)', 'futuristic-it'); ?></label><input type="text" name="packages_desc_km" value="<?php echo esc_attr($selected_service['packages_desc_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;"></div>
                    </div>
                    <?php
                    $packages = $selected_service['packages'] ?? array();
                    if (empty($packages)) $packages = array(array('title' => '', 'price' => '', 'badge' => '', 'features_text' => '', 'btn_text' => '', 'btn_link' => ''));
                    ?>
                    <div id="packages-container">
                        <?php foreach ($packages as $pi => $pkg) : ?>
                        <div class="package-row" style="background:#f9f9f9;border:1px solid #ddd;border-radius:8px;padding:16px;margin-bottom:16px;">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                                <label style="font-weight:600;font-size:14px;"><?php _e('Package', 'futuristic-it'); ?> <?php echo $pi + 1; ?></label>
                                <div style="display:flex;gap:8px;align-items:center;">
                                    <label style="font-size:12px;"><?php _e('Order:', 'futuristic-it'); ?></label>
                                    <input type="number" name="svc_packages[<?php echo $pi; ?>][order]" value="<?php echo esc_attr($pkg['order'] ?? ($pi + 1)); ?>" style="width:60px;padding:4px 8px;" min="1">
                                    <button type="button" class="button button-small" onclick="var row=this.closest('.package-row');var prev=row.previousElementSibling;if(prev)row.parentNode.insertBefore(row,prev);">↑</button>
                                    <button type="button" class="button button-small" onclick="var row=this.closest('.package-row');var next=row.nextElementSibling;if(next)row.parentNode.insertBefore(next,row);">↓</button>
                                    <button type="button" class="button button-small" style="color:#dc3545;" onclick="this.closest('.package-row').remove();"><?php _e('Remove', 'futuristic-it'); ?></button>
                                </div>
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;margin-bottom:12px;">
                                <div><label style="font-weight:600;font-size:12px;"><?php _e('Package Title (English)', 'futuristic-it'); ?></label><input type="text" name="svc_packages[<?php echo $pi; ?>][title]" value="<?php echo esc_attr($pkg['title'] ?? ''); ?>" class="widefat"></div>
                                <div><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Package Title (Khmer)', 'futuristic-it'); ?></label><input type="text" name="svc_packages[<?php echo $pi; ?>][title_km]" value="<?php echo esc_attr($pkg['title_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;"></div>
                                <div><label style="font-weight:600;font-size:12px;"><?php _e('Price', 'futuristic-it'); ?></label><input type="text" name="svc_packages[<?php echo $pi; ?>][price]" value="<?php echo esc_attr($pkg['price'] ?? ''); ?>" class="widefat" placeholder="$5,000 / Engagement"></div>
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;margin-bottom:12px;">
                                <div><label style="font-weight:600;font-size:12px;"><?php _e('Badge (English)', 'futuristic-it'); ?></label><input type="text" name="svc_packages[<?php echo $pi; ?>][badge]" value="<?php echo esc_attr($pkg['badge'] ?? ''); ?>" class="widefat" placeholder="Most Popular"></div>
                                <div><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Badge (Khmer)', 'futuristic-it'); ?></label><input type="text" name="svc_packages[<?php echo $pi; ?>][badge_km]" value="<?php echo esc_attr($pkg['badge_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;"></div>
                                <div></div>
                            </div>
                            <div style="margin-bottom:12px;"><label style="font-weight:600;font-size:12px;"><?php _e('Features (English, one per line)', 'futuristic-it'); ?></label><textarea name="svc_packages[<?php echo $pi; ?>][features_text]" class="widefat" rows="3"><?php echo esc_textarea(implode("\n", $pkg['features'] ?? array())); ?></textarea></div>
                            <div style="margin-bottom:12px;"><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Features (Khmer)', 'futuristic-it'); ?></label><textarea name="svc_packages[<?php echo $pi; ?>][features_text_km]" class="widefat" rows="3" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea(implode("\n", $pkg['features_km'] ?? array())); ?></textarea></div>
                            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
                                <div><label style="font-weight:600;font-size:12px;"><?php _e('Button Text (English)', 'futuristic-it'); ?></label><input type="text" name="svc_packages[<?php echo $pi; ?>][btn_text]" value="<?php echo esc_attr($pkg['btn_text'] ?? ''); ?>" class="widefat"></div>
                                <div><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Button Text (Khmer)', 'futuristic-it'); ?></label><input type="text" name="svc_packages[<?php echo $pi; ?>][btn_text_km]" value="<?php echo esc_attr($pkg['btn_text_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;"></div>
                                <div><label style="font-weight:600;font-size:12px;"><?php _e('Button Link', 'futuristic-it'); ?></label><input type="text" name="svc_packages[<?php echo $pi; ?>][btn_link]" value="<?php echo esc_attr($pkg['btn_link'] ?? home_url('/contact/')); ?>" class="widefat" placeholder="<?php echo esc_attr(home_url('/contact/')); ?>"></div>
                            </div>
                            <button type="button" class="button button-small" style="color:#dc3545;margin-top:8px;" onclick="this.closest('.package-row').remove();">Remove Package</button>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <p><button type="button" class="button" id="add-package">+ Add Package</button></p>
                    </div><!-- /detailFields -->

                    <!-- COURSE FIELDS -->
                    <div id="courseFields" style="<?php echo ($selected_service['service_type'] ?? 'Default') !== 'Course' ? 'display:none;' : ''; ?>">
                    <h3><?php _e('Course Section Header', 'futuristic-it'); ?></h3>
                    <p style="color:#999;margin:0 0 16px;"><?php _e('Set the main title and description for the course section.', 'futuristic-it'); ?></p>
                    <div style="background:#f0f7f4;border:1px solid #d1e8dc;border-radius:8px;padding:16px;margin-bottom:20px;">
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                            <div><label style="font-weight:600;font-size:12px;"><?php _e('Main Title (English)', 'futuristic-it'); ?></label><input type="text" name="course_main_title_en" value="<?php echo esc_attr($selected_service['course_main_title_en'] ?? ''); ?>" class="widefat" placeholder="Please enter main title in English"></div>
                            <div><label style="font-weight:600;font-size:12px;"><?php _e('Main Title (Khmer)', 'futuristic-it'); ?></label><input type="text" name="course_main_title_kh" value="<?php echo esc_attr($selected_service['course_main_title_kh'] ?? ''); ?>" class="widefat" placeholder="សូមបញ្ចូលចំណងជើងរងជាភាសាខ្មែរ"></div>
                        </div>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                            <div><label style="font-weight:600;font-size:12px;"><?php _e('Main Description (English)', 'futuristic-it'); ?></label><textarea name="course_main_description_en" class="widefat" rows="3" placeholder="Please enter main description in English"><?php echo esc_textarea($selected_service['course_main_description_en'] ?? ''); ?></textarea></div>
                            <div><label style="font-weight:600;font-size:12px;"><?php _e('Main Description (Khmer)', 'futuristic-it'); ?></label><textarea name="course_main_description_kh" class="widefat" rows="3" placeholder="សូមបញ្ចូលការពិពណ៌នារងជាភាសាខ្មែរ"><?php echo esc_textarea($selected_service['course_main_description_kh'] ?? ''); ?></textarea></div>
                        </div>
                    </div>

                    <h3><?php _e('Course Cards', 'futuristic-it'); ?></h3>
                    <p style="color:#999;margin:0 0 16px;"><?php _e('Add course cards to display in the courses carousel.', 'futuristic-it'); ?></p>
                    <?php
                    $courses = $selected_service['courses'] ?? array();
                    if (empty($courses)) $courses = array(array('image' => '', 'title_en' => '', 'title_kh' => '', 'description_en' => '', 'description_kh' => '', 'instructor' => '', 'badge' => '', 'rating' => '', 'reviews' => '', 'price' => ''));
                    ?>
                    <div id="courses-container">
                        <?php foreach ($courses as $ci => $crs) : ?>
                        <div class="course-row" style="background:#f9f9f9;border:1px solid #ddd;border-radius:8px;padding:16px;margin-bottom:16px;">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                                <label style="font-weight:600;font-size:14px;"><?php _e('Course Card', 'futuristic-it'); ?> <?php echo $ci + 1; ?></label>
                                <button type="button" class="button button-small" style="color:#dc3545;" onclick="this.closest('.course-row').remove();"><?php _e('Remove', 'futuristic-it'); ?></button>
                            </div>
                            <div style="display:grid;grid-template-columns:200px 1fr;gap:16px;margin-bottom:12px;">
                                <div>
                                    <label style="font-weight:600;font-size:12px;"><?php _e('Course Image', 'futuristic-it'); ?></label><br>
                                    <input type="hidden" name="svc_courses[<?php echo $ci; ?>][image]" class="course-img-input" value="<?php echo esc_attr($crs['image'] ?? ''); ?>">
                                    <img src="<?php echo esc_url($crs['image'] ?? ''); ?>" style="width:100%;max-height:120px;object-fit:cover;border-radius:8px;margin-bottom:8px;<?php echo empty($crs['image'] ?? '') ? 'display:none;' : ''; ?>">
                                    <br><button type="button" class="button button-small upload-btn" data-for="svc_courses[<?php echo $ci; ?>][image]"><?php _e('Upload', 'futuristic-it'); ?></button>
                                </div>
                                <div>
                                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                                        <div><label style="font-weight:600;font-size:12px;"><?php _e('Title (English)', 'futuristic-it'); ?></label><input type="text" name="svc_courses[<?php echo $ci; ?>][title_en]" value="<?php echo esc_attr($crs['title_en'] ?? $crs['title'] ?? ''); ?>" class="widefat" placeholder="Enter course title in English"></div>
                                        <div><label style="font-weight:600;font-size:12px;"><?php _e('Title (Khmer)', 'futuristic-it'); ?></label><input type="text" name="svc_courses[<?php echo $ci; ?>][title_kh]" value="<?php echo esc_attr($crs['title_kh'] ?? $crs['title_km'] ?? ''); ?>" class="widefat" placeholder="បញ្ចូលចំណងជើងវគ្គសិក្សាជាភាសាខ្មែរ"></div>
                                    </div>
                                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                                        <div><label style="font-weight:600;font-size:12px;"><?php _e('Description (English)', 'futuristic-it'); ?></label><textarea name="svc_courses[<?php echo $ci; ?>][description_en]" class="widefat" rows="2" placeholder="Enter course description in English"><?php echo esc_textarea($crs['description_en'] ?? $crs['description'] ?? ''); ?></textarea></div>
                                        <div><label style="font-weight:600;font-size:12px;"><?php _e('Description (Khmer)', 'futuristic-it'); ?></label><textarea name="svc_courses[<?php echo $ci; ?>][description_kh]" class="widefat" rows="2" placeholder="បញ្ចូលការពិពណ៌នាវគ្គសិក្សាជាភាសាខ្មែរ"><?php echo esc_textarea($crs['description_kh'] ?? $crs['description_km'] ?? ''); ?></textarea></div>
                                    </div>
                                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                                        <div><label style="font-weight:600;font-size:12px;"><?php _e('Instructor (English)', 'futuristic-it'); ?></label><input type="text" name="svc_courses[<?php echo $ci; ?>][instructor]" value="<?php echo esc_attr($crs['instructor'] ?? ''); ?>" class="widefat" placeholder="Enter instructor name in English"></div>
                                        <div><label style="font-weight:600;font-size:12px;"><?php _e('Instructor (Khmer)', 'futuristic-it'); ?></label><input type="text" name="svc_courses[<?php echo $ci; ?>][instructor_km]" value="<?php echo esc_attr($crs['instructor_km'] ?? ''); ?>" class="widefat" placeholder="បញ្ចូលឈ្មោះគ្រូបង្រៀនជាភាសាខ្មែរ"></div>
                                    </div>
                                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr 1fr;gap:12px;">
                                        <div><label style="font-weight:600;font-size:12px;"><?php _e('Badge (English)', 'futuristic-it'); ?></label><input type="text" name="svc_courses[<?php echo $ci; ?>][badge]" value="<?php echo esc_attr($crs['badge'] ?? ''); ?>" class="widefat" placeholder="e.g. Bestseller, Premium"></div>
                                        <div><label style="font-weight:600;font-size:12px;"><?php _e('Badge (Khmer)', 'futuristic-it'); ?></label><input type="text" name="svc_courses[<?php echo $ci; ?>][badge_km]" value="<?php echo esc_attr($crs['badge_km'] ?? ''); ?>" class="widefat" placeholder="ឧ. លក់ដាច់បំផុត, ប្រណិត"></div>
                                        <div><label style="font-weight:600;font-size:12px;"><?php _e('Rating', 'futuristic-it'); ?></label><input type="text" name="svc_courses[<?php echo $ci; ?>][rating]" value="<?php echo esc_attr($crs['rating'] ?? ''); ?>" class="widefat" placeholder="e.g. 4.5"></div>
                                        <div><label style="font-weight:600;font-size:12px;"><?php _e('Reviews', 'futuristic-it'); ?></label><input type="text" name="svc_courses[<?php echo $ci; ?>][reviews]" value="<?php echo esc_attr($crs['reviews'] ?? ''); ?>" class="widefat" placeholder="e.g. 1,094"></div>
                                        <div><label style="font-weight:600;font-size:12px;"><?php _e('Price', 'futuristic-it'); ?></label><input type="text" name="svc_courses[<?php echo $ci; ?>][price]" value="<?php echo esc_attr($crs['price'] ?? ''); ?>" class="widefat" placeholder="e.g. 10.00"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <p><button type="button" class="button" id="add-course">+ <?php _e('Add Course Card', 'futuristic-it'); ?></button></p>

                    <hr style="margin:24px 0;">
                    <h3><?php _e('Why Learn With Us', 'futuristic-it'); ?></h3>
                    <p style="color:#999;margin:0 0 16px;"><?php _e('Cards shown under the course cards. Leave empty to hide the section.', 'futuristic-it'); ?></p>
                    <div style="background:#f0f7f4;border:1px solid #d1e8dc;border-radius:8px;padding:16px;margin-bottom:20px;">
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                            <div><label style="font-weight:600;font-size:12px;"><?php _e('Section Title (English)', 'futuristic-it'); ?></label><input type="text" name="why_learn_title" value="<?php echo esc_attr($selected_service['why_learn_title'] ?? ''); ?>" class="widefat" placeholder="Why learn with us"></div>
                            <div><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Section Title (Khmer)', 'futuristic-it'); ?></label><input type="text" name="why_learn_title_km" value="<?php echo esc_attr($selected_service['why_learn_title_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;" placeholder="ហេតុអ្វីត្រូវរៀនជាមួយយើង"></div>
                        </div>
                    </div>
                    <?php $why_items = $selected_service['why_learn'] ?? array(); ?>
                    <div id="why-learn-container">
                        <?php foreach ($why_items as $wi => $w) : ?>
                        <div class="why-learn-row" style="background:#f9f9f9;border:1px solid #ddd;border-radius:8px;padding:16px;margin-bottom:16px;">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                                <label style="font-weight:600;font-size:14px;"><?php _e('Card', 'futuristic-it'); ?> <?php echo $wi + 1; ?></label>
                                <button type="button" class="button button-small" style="color:#dc3545;" onclick="this.closest('.why-learn-row').remove();"><?php _e('Remove', 'futuristic-it'); ?></button>
                            </div>
                            <div style="margin-bottom:12px;">
                                <label style="font-weight:600;font-size:12px;"><?php _e('Icon', 'futuristic-it'); ?></label>
                                <select name="svc_why_learn[<?php echo $wi; ?>][icon]" class="widefat" style="max-width:280px;">
                                    <?php foreach (futuristic_it_why_learn_icon_choices() as $icon_key => $icon_label) : ?>
                                        <option value="<?php echo esc_attr($icon_key); ?>" <?php selected($w['icon'] ?? 'instructor', $icon_key); ?>><?php echo esc_html($icon_label); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                                <div><label style="font-weight:600;font-size:12px;"><?php _e('Title (English)', 'futuristic-it'); ?></label><input type="text" name="svc_why_learn[<?php echo $wi; ?>][title]" value="<?php echo esc_attr($w['title'] ?? ''); ?>" class="widefat" placeholder="Real instructor, every session"></div>
                                <div><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Title (Khmer)', 'futuristic-it'); ?></label><input type="text" name="svc_why_learn[<?php echo $wi; ?>][title_km]" value="<?php echo esc_attr($w['title_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;" placeholder="គ្រូបង្រៀនពិតប្រាកដ"></div>
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                                <div><label style="font-weight:600;font-size:12px;"><?php _e('Description (English)', 'futuristic-it'); ?></label><textarea name="svc_why_learn[<?php echo $wi; ?>][desc]" class="widefat" rows="3" placeholder="No pre-recorded videos..."><?php echo esc_textarea($w['desc'] ?? ''); ?></textarea></div>
                                <div><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Description (Khmer)', 'futuristic-it'); ?></label><textarea name="svc_why_learn[<?php echo $wi; ?>][desc_km]" class="widefat" rows="3" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea($w['desc_km'] ?? ''); ?></textarea></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <p><button type="button" class="button" id="add-why-learn">+ <?php _e('Add Why Learn Card', 'futuristic-it'); ?></button></p>

                    <h4 style="margin:24px 0 6px;"><?php _e('Group Training Banner', 'futuristic-it'); ?></h4>
                    <p style="color:#999;margin:0 0 12px;"><?php _e('Shown under the Why Learn cards. Leave the title and description empty to hide the banner.', 'futuristic-it'); ?></p>
                    <div style="background:#f9f9f9;border:1px solid #ddd;border-radius:8px;padding:16px;margin-bottom:20px;">
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                            <div><label style="font-weight:600;font-size:12px;"><?php _e('Title (English)', 'futuristic-it'); ?></label><input type="text" name="why_learn_cta_title" value="<?php echo esc_attr($selected_service['why_learn_cta_title'] ?? ''); ?>" class="widefat" placeholder="Training your whole team?"></div>
                            <div><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Title (Khmer)', 'futuristic-it'); ?></label><input type="text" name="why_learn_cta_title_km" value="<?php echo esc_attr($selected_service['why_learn_cta_title_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;" placeholder="បណ្តុះបណ្តាលក្រុមការងាររបស់អ្នក?"></div>
                        </div>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                            <div><label style="font-weight:600;font-size:12px;"><?php _e('Description (English)', 'futuristic-it'); ?></label><textarea name="why_learn_cta_desc" class="widefat" rows="3" placeholder="We offer group rates, custom course content, and on-site training at your office for teams of 5 or more."><?php echo esc_textarea($selected_service['why_learn_cta_desc'] ?? ''); ?></textarea></div>
                            <div><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Description (Khmer)', 'futuristic-it'); ?></label><textarea name="why_learn_cta_desc_km" class="widefat" rows="3" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea($selected_service['why_learn_cta_desc_km'] ?? ''); ?></textarea></div>
                        </div>
                        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
                            <div><label style="font-weight:600;font-size:12px;"><?php _e('Button Text (English)', 'futuristic-it'); ?></label><input type="text" name="why_learn_cta_btn_text" value="<?php echo esc_attr($selected_service['why_learn_cta_btn_text'] ?? ''); ?>" class="widefat" placeholder="Request group training"></div>
                            <div><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Button Text (Khmer)', 'futuristic-it'); ?></label><input type="text" name="why_learn_cta_btn_text_km" value="<?php echo esc_attr($selected_service['why_learn_cta_btn_text_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;" placeholder="ស្នើសុំការបណ្តុះបណ្តាលជាក្រុម"></div>
                            <div><label style="font-weight:600;font-size:12px;"><?php _e('Button Link', 'futuristic-it'); ?></label><input type="text" name="why_learn_cta_btn_link" value="<?php echo esc_attr($selected_service['why_learn_cta_btn_link'] ?? ''); ?>" class="widefat" placeholder="<?php echo esc_attr(home_url('/contact/')); ?>"></div>
                        </div>
                    </div>

                    <h4 style="margin:24px 0 6px;"><?php _e('FAQ', 'futuristic-it'); ?></h4>
                    <p style="color:#999;margin:0 0 12px;"><?php _e('Shown under the group-training banner. Leave empty to hide the section.', 'futuristic-it'); ?></p>
                    <div style="background:#f0f7f4;border:1px solid #d1e8dc;border-radius:8px;padding:16px;margin-bottom:20px;">
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                            <div><label style="font-weight:600;font-size:12px;"><?php _e('Section Title (English)', 'futuristic-it'); ?></label><input type="text" name="faq_title" value="<?php echo esc_attr($selected_service['faq_title'] ?? ''); ?>" class="widefat" placeholder="Frequently Asked Questions"></div>
                            <div><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Section Title (Khmer)', 'futuristic-it'); ?></label><input type="text" name="faq_title_km" value="<?php echo esc_attr($selected_service['faq_title_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;" placeholder="សំណួរដែលសួរញឹកញាប់"></div>
                        </div>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                            <div><label style="font-weight:600;font-size:12px;"><?php _e('Section Subtitle (English)', 'futuristic-it'); ?></label><textarea name="faq_subtitle" class="widefat" rows="2" placeholder="Answers to common questions about getting started."><?php echo esc_textarea($selected_service['faq_subtitle'] ?? ''); ?></textarea></div>
                            <div><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Section Subtitle (Khmer)', 'futuristic-it'); ?></label><textarea name="faq_subtitle_km" class="widefat" rows="2" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea($selected_service['faq_subtitle_km'] ?? ''); ?></textarea></div>
                        </div>
                    </div>
                    <?php $faq_rows = $selected_service['faqs'] ?? array(); ?>
                    <div id="faq-container">
                        <?php foreach ($faq_rows as $fi => $fq) : ?>
                        <div class="faq-row" style="background:#f9f9f9;border:1px solid #ddd;border-radius:8px;padding:16px;margin-bottom:16px;">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                                <label style="font-weight:600;font-size:14px;"><?php _e('Question', 'futuristic-it'); ?> <?php echo $fi + 1; ?></label>
                                <button type="button" class="button button-small" style="color:#dc3545;" onclick="this.closest('.faq-row').remove();"><?php _e('Remove', 'futuristic-it'); ?></button>
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                                <div><label style="font-weight:600;font-size:12px;"><?php _e('Question (English)', 'futuristic-it'); ?></label><input type="text" name="svc_faqs[<?php echo $fi; ?>][q]" value="<?php echo esc_attr($fq['q'] ?? ''); ?>" class="widefat" placeholder="What industries do you serve?"></div>
                                <div><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Question (Khmer)', 'futuristic-it'); ?></label><input type="text" name="svc_faqs[<?php echo $fi; ?>][q_km]" value="<?php echo esc_attr($fq['q_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;"></div>
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                                <div><label style="font-weight:600;font-size:12px;"><?php _e('Answer (English)', 'futuristic-it'); ?></label><textarea name="svc_faqs[<?php echo $fi; ?>][a]" class="widefat" rows="3"><?php echo esc_textarea($fq['a'] ?? ''); ?></textarea></div>
                                <div><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Answer (Khmer)', 'futuristic-it'); ?></label><textarea name="svc_faqs[<?php echo $fi; ?>][a_km]" class="widefat" rows="3" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea($fq['a_km'] ?? ''); ?></textarea></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <p><button type="button" class="button" id="add-faq">+ <?php _e('Add FAQ', 'futuristic-it'); ?></button></p>
                    </div><!-- /courseFields -->

                    <hr style="margin:24px 0;">
                    <p class="submit" style="margin:0;">
                        <input type="submit" name="futuristic_it_save_service_detail" class="button button-primary" value="<?php _e('Save Service Details', 'futuristic-it'); ?>">
                    </p>
                </form>
            </div>

            <script>
            var addPackageBtn = document.getElementById('add-package');
            if (addPackageBtn) {
                addPackageBtn.addEventListener('click', function(){
                    var container = document.getElementById('packages-container');
                    var idx = container.querySelectorAll('.package-row').length;
                    var html = '<div class="package-row" style="background:#f9f9f9;border:1px solid #ddd;border-radius:8px;padding:16px;margin-bottom:16px;">' +
                        '<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">' +
                        '<label style="font-weight:600;font-size:14px;">Package ' + (idx + 1) + '</label>' +
                        '<div style="display:flex;gap:8px;align-items:center;">' +
                        '<label style="font-size:12px;">Order:</label>' +
                        '<input type="number" name="svc_packages[' + idx + '][order]" value="' + (idx + 1) + '" style="width:60px;padding:4px 8px;" min="1">' +
                        '<button type="button" class="button button-small" onclick="var row=this.closest(\'.package-row\');var prev=row.previousElementSibling;if(prev)row.parentNode.insertBefore(row,prev);">↑</button>' +
                        '<button type="button" class="button button-small" onclick="var row=this.closest(\'.package-row\');var next=row.nextElementSibling;if(next)row.parentNode.insertBefore(next,row);">↓</button>' +
                        '<button type="button" class="button button-small" style="color:#dc3545;" onclick="this.closest(\'.package-row\').remove();">Remove</button>' +
                        '</div></div>' +
                        '<div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;margin-bottom:12px;">' +
                        '<div><label style="font-weight:600;font-size:12px;">Package Title (English)</label><input type="text" name="svc_packages[' + idx + '][title]" value="" class="widefat"></div>' +
                        '<div><label style="font-weight:600;font-size:12px;color:#b8892f;">Package Title (Khmer)</label><input type="text" name="svc_packages[' + idx + '][title_km]" value="" class="widefat" style="font-family:\'Noto Sans Khmer\',sans-serif;"></div>' +
                        '<div><label style="font-weight:600;font-size:12px;">Price</label><input type="text" name="svc_packages[' + idx + '][price]" value="" class="widefat" placeholder="$5,000"></div>' +
                        '</div>' +
                        '<div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;margin-bottom:12px;">' +
                        '<div><label style="font-weight:600;font-size:12px;">Badge (English)</label><input type="text" name="svc_packages[' + idx + '][badge]" value="" class="widefat" placeholder="Most Popular"></div>' +
                        '<div><label style="font-weight:600;font-size:12px;color:#b8892f;">Badge (Khmer)</label><input type="text" name="svc_packages[' + idx + '][badge_km]" value="" class="widefat" style="font-family:\'Noto Sans Khmer\',sans-serif;"></div>' +
                        '<div></div>' +
                        '</div>' +
                        '<div style="margin-bottom:12px;"><label style="font-weight:600;font-size:12px;">Features (English, one per line)</label><textarea name="svc_packages[' + idx + '][features_text]" class="widefat" rows="3"></textarea></div>' +
                        '<div style="margin-bottom:12px;"><label style="font-weight:600;font-size:12px;color:#b8892f;">Features (Khmer)</label><textarea name="svc_packages[' + idx + '][features_text_km]" class="widefat" rows="3" style="font-family:\'Noto Sans Khmer\',sans-serif;"></textarea></div>' +
                        '<div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">' +
                        '<div><label style="font-weight:600;font-size:12px;">Button Text (English)</label><input type="text" name="svc_packages[' + idx + '][btn_text]" value="" class="widefat"></div>' +
                        '<div><label style="font-weight:600;font-size:12px;color:#b8892f;">Button Text (Khmer)</label><input type="text" name="svc_packages[' + idx + '][btn_text_km]" value="" class="widefat" style="font-family:\'Noto Sans Khmer\',sans-serif;"></div>' +
                        '<div><label style="font-weight:600;font-size:12px;">Button Link</label><input type="text" name="svc_packages[' + idx + '][btn_link]" value="" class="widefat" placeholder="<?php echo esc_attr(home_url("/contact/")); ?>"></div>' +
                        '</div></div>';
                container.insertAdjacentHTML('beforeend', html);
            });
        }

        // Toggle Service Type fields
        var typeSelect = document.getElementById('serviceTypeSelect');
        var typeHidden = document.getElementById('serviceTypeHidden');
        var detailFields = document.getElementById('detailFields');
        var courseFields = document.getElementById('courseFields');
        if (typeSelect) {
            // Sync hidden field on change
            typeSelect.addEventListener('change', function() {
                if (typeHidden) typeHidden.value = this.value;
                if (this.value === 'Course') {
                    if (detailFields) detailFields.style.display = 'none';
                    if (courseFields) courseFields.style.display = 'block';
                } else {
                    if (detailFields) detailFields.style.display = 'block';
                    if (courseFields) courseFields.style.display = 'none';
                }
            });
            // Set initial state
            if (typeHidden) typeHidden.value = typeSelect.value;
            // Trigger initial toggle on page load
            if (typeSelect.value === 'Course') {
                if (detailFields) detailFields.style.display = 'none';
                if (courseFields) courseFields.style.display = 'block';
            }
        }

        // Add Course Card
        var addCourseBtn = document.getElementById('add-course');
        if (addCourseBtn) {
            addCourseBtn.addEventListener('click', function(){
                var container = document.getElementById('courses-container');
                var idx = container.querySelectorAll('.course-row').length;
                var html = '<div class="course-row" style="background:#f9f9f9;border:1px solid #ddd;border-radius:8px;padding:16px;margin-bottom:16px;">' +
                    '<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">' +
                    '<label style="font-weight:600;font-size:14px;">Course Card ' + (idx + 1) + '</label>' +
                    '<button type="button" class="button button-small" style="color:#dc3545;" onclick="this.closest(\'.course-row\').remove();">Remove</button>' +
                    '</div>' +
                    '<div style="display:grid;grid-template-columns:200px 1fr;gap:16px;margin-bottom:12px;">' +
                    '<div>' +
                    '<label style="font-weight:600;font-size:12px;">Course Image</label><br>' +
                    '<input type="hidden" name="svc_courses[' + idx + '][image]" class="course-img-input" value="">' +
                    '<img src="" style="width:100%;max-height:120px;object-fit:cover;border-radius:8px;margin-bottom:8px;display:none;">' +
                    '<br><button type="button" class="button button-small upload-btn" data-for="svc_courses[' + idx + '][image]">Upload</button>' +
                    '</div>' +
                    '<div>' +
                    '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">' +
                    '<div><label style="font-weight:600;font-size:12px;">Title (English)</label><input type="text" name="svc_courses[' + idx + '][title_en]" value="" class="widefat" placeholder="Enter course title in English"></div>' +
                    '<div><label style="font-weight:600;font-size:12px;">Title (Khmer)</label><input type="text" name="svc_courses[' + idx + '][title_kh]" value="" class="widefat" placeholder="បញ្ចូលចំណងជើងវគ្គសិក្សាជាភាសាខ្មែរ"></div>' +
                    '</div>' +
                    '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">' +
                    '<div><label style="font-weight:600;font-size:12px;">Description (English)</label><textarea name="svc_courses[' + idx + '][description_en]" class="widefat" rows="2" placeholder="Enter course description in English"></textarea></div>' +
                    '<div><label style="font-weight:600;font-size:12px;">Description (Khmer)</label><textarea name="svc_courses[' + idx + '][description_kh]" class="widefat" rows="2" placeholder="បញ្ចូលការពិពណ៌នាវគ្គសិក្សាជាភាសាខ្មែរ"></textarea></div>' +
                    '</div>' +
                    '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">' +
                    '<div><label style="font-weight:600;font-size:12px;">Instructor (English)</label><input type="text" name="svc_courses[' + idx + '][instructor]" value="" class="widefat" placeholder="Enter instructor name in English"></div>' +
                    '<div><label style="font-weight:600;font-size:12px;">Instructor (Khmer)</label><input type="text" name="svc_courses[' + idx + '][instructor_km]" value="" class="widefat" placeholder="បញ្ចូលឈ្មោះគ្រូបង្រៀនជាភាសាខ្មែរ"></div>' +
                    '</div>' +
                    '<div style="display:grid;grid-template-columns:1fr 1fr 1fr 1fr 1fr;gap:12px;">' +
                    '<div><label style="font-weight:600;font-size:12px;">Badge (English)</label><input type="text" name="svc_courses[' + idx + '][badge]" value="" class="widefat" placeholder="e.g. Bestseller, Premium"></div>' +
                    '<div><label style="font-weight:600;font-size:12px;">Badge (Khmer)</label><input type="text" name="svc_courses[' + idx + '][badge_km]" value="" class="widefat" placeholder="ឧ. លក់ដាច់បំផុត, ប្រណិត"></div>' +
                    '<div><label style="font-weight:600;font-size:12px;">Rating</label><input type="text" name="svc_courses[' + idx + '][rating]" value="" class="widefat" placeholder="e.g. 4.5"></div>' +
                    '<div><label style="font-weight:600;font-size:12px;">Reviews</label><input type="text" name="svc_courses[' + idx + '][reviews]" value="" class="widefat" placeholder="e.g. 1,094"></div>' +
                    '<div><label style="font-weight:600;font-size:12px;">Price</label><input type="text" name="svc_courses[' + idx + '][price]" value="" class="widefat" placeholder="e.g. 10.00"></div>' +
                    '</div></div></div></div>';
                container.insertAdjacentHTML('beforeend', html);
            });
        }

        var addWhyBtn = document.getElementById('add-why-learn');
        if (addWhyBtn) {
            var whyIcons = <?php echo wp_json_encode(futuristic_it_why_learn_icon_choices()); ?>;
            // Monotonic counter, not row count: removing a row would otherwise let a
            // new row reuse an existing index and overwrite its data on save.
            var whyNext = <?php echo (int) count($selected_service['why_learn'] ?? array()); ?>;
            addWhyBtn.addEventListener('click', function(){
                var container = document.getElementById('why-learn-container');
                var idx = whyNext++;
                var opts = '';
                for (var k in whyIcons) {
                    opts += '<option value="' + k + '"' + (k === 'instructor' ? ' selected' : '') + '>' + whyIcons[k] + '</option>';
                }
                var html = '<div class="why-learn-row" style="background:#f9f9f9;border:1px solid #ddd;border-radius:8px;padding:16px;margin-bottom:16px;">' +
                    '<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">' +
                    '<label style="font-weight:600;font-size:14px;">Card ' + (idx + 1) + '</label>' +
                    '<button type="button" class="button button-small" style="color:#dc3545;" onclick="this.closest(\'.why-learn-row\').remove();">Remove</button>' +
                    '</div>' +
                    '<div style="margin-bottom:12px;">' +
                    '<label style="font-weight:600;font-size:12px;">Icon</label>' +
                    '<select name="svc_why_learn[' + idx + '][icon]" class="widefat" style="max-width:280px;">' + opts + '</select>' +
                    '</div>' +
                    '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">' +
                    '<div><label style="font-weight:600;font-size:12px;">Title (English)</label><input type="text" name="svc_why_learn[' + idx + '][title]" value="" class="widefat" placeholder="Real instructor, every session"></div>' +
                    '<div><label style="font-weight:600;font-size:12px;color:#b8892f;">Title (Khmer)</label><input type="text" name="svc_why_learn[' + idx + '][title_km]" value="" class="widefat" style="font-family:\'Noto Sans Khmer\',sans-serif;" placeholder="គ្រូបង្រៀនពិតប្រាកដ"></div>' +
                    '</div>' +
                    '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">' +
                    '<div><label style="font-weight:600;font-size:12px;">Description (English)</label><textarea name="svc_why_learn[' + idx + '][desc]" class="widefat" rows="3" placeholder="No pre-recorded videos..."></textarea></div>' +
                    '<div><label style="font-weight:600;font-size:12px;color:#b8892f;">Description (Khmer)</label><textarea name="svc_why_learn[' + idx + '][desc_km]" class="widefat" rows="3" style="font-family:\'Noto Sans Khmer\',sans-serif;"></textarea></div>' +
                    '</div></div>';
                container.insertAdjacentHTML('beforeend', html);
            });
        }

        var addFaqBtn = document.getElementById('add-faq');
        if (addFaqBtn) {
            // Monotonic counter, not row count: removing a row would otherwise let a
            // new row reuse an existing index and overwrite its data on save.
            var faqNext = <?php echo (int) count($selected_service['faqs'] ?? array()); ?>;
            addFaqBtn.addEventListener('click', function(){
                var container = document.getElementById('faq-container');
                var idx = faqNext++;
                var html = '<div class="faq-row" style="background:#f9f9f9;border:1px solid #ddd;border-radius:8px;padding:16px;margin-bottom:16px;">' +
                    '<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">' +
                    '<label style="font-weight:600;font-size:14px;">Question ' + (idx + 1) + '</label>' +
                    '<button type="button" class="button button-small" style="color:#dc3545;" onclick="this.closest(\'.faq-row\').remove();">Remove</button>' +
                    '</div>' +
                    '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">' +
                    '<div><label style="font-weight:600;font-size:12px;">Question (English)</label><input type="text" name="svc_faqs[' + idx + '][q]" value="" class="widefat" placeholder="What industries do you serve?"></div>' +
                    '<div><label style="font-weight:600;font-size:12px;color:#b8892f;">Question (Khmer)</label><input type="text" name="svc_faqs[' + idx + '][q_km]" value="" class="widefat" style="font-family:\'Noto Sans Khmer\',sans-serif;"></div>' +
                    '</div>' +
                    '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">' +
                    '<div><label style="font-weight:600;font-size:12px;">Answer (English)</label><textarea name="svc_faqs[' + idx + '][a]" class="widefat" rows="3"></textarea></div>' +
                    '<div><label style="font-weight:600;font-size:12px;color:#b8892f;">Answer (Khmer)</label><textarea name="svc_faqs[' + idx + '][a_km]" class="widefat" rows="3" style="font-family:\'Noto Sans Khmer\',sans-serif;"></textarea></div>' +
                    '</div></div>';
                container.insertAdjacentHTML('beforeend', html);
            });
        }
            </script>
        <?php endif; ?>

        <!-- Service List -->
        <h2><?php _e('All Services', 'futuristic-it'); ?></h2>
        <?php if (!empty($all_services)) : ?>
        <table class="widefat striped">
            <thead>
                <tr>
                    <th style="width:60px;"><?php _e('Image', 'futuristic-it'); ?></th>
                    <th><?php _e('Title', 'futuristic-it'); ?></th>
                    <th style="width:100px;"><?php _e('Features', 'futuristic-it'); ?></th>
                    <th style="width:100px;"><?php _e('Packages', 'futuristic-it'); ?></th>
                    <th style="width:180px;"><?php _e('Actions', 'futuristic-it'); ?></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($all_services as $svc) :
                $key = 'svc_' . md5($svc['title'] ?? '');
                $feat_count = !empty($svc['features']) ? count($svc['features']) : 0;
                $pkg_count = !empty($svc['packages']) ? count($svc['packages']) : 0;
            ?>
                <tr>
                    <td><?php if (!empty($svc['image'])) : ?><img src="<?php echo esc_url($svc['image']); ?>" style="width:50px;height:50px;object-fit:cover;border-radius:4px;"><?php endif; ?></td>
                    <td><strong><?php echo esc_html($svc['title'] ?? ''); ?></strong></td>
                    <td><?php echo $feat_count ? '<span style="color:green;">' . $feat_count . ' items</span>' : '<span style="color:#999;">—</span>'; ?></td>
                    <td><?php echo $pkg_count ? '<span style="color:green;">' . $pkg_count . ' packages</span>' : '<span style="color:#999;">—</span>'; ?></td>
                    <td>
                        <a href="<?php echo admin_url('admin.php?page=futuristict-service-detail&view=edit&service_key=' . urlencode($key)); ?>" class="button button-small"><?php _e('Add / Edit', 'futuristic-it'); ?></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php else : ?>
            <div class="notice notice-info"><p><?php _e('No services found. Add services in the Services Section admin.', 'futuristic-it'); ?></p></div>
        <?php endif; ?>
    </div>
    <?php
}

// Course Detail Admin Page
function futuristict_course_detail_page() {
    $raw_services = get_option('custom_service_cards', '[]');
    $all_services = json_decode($raw_services, true);
    if (!is_array($all_services)) $all_services = array();

    $selected_key = isset($_GET['service_key']) ? sanitize_text_field($_GET['service_key']) : '';
    $selected_course_idx = isset($_GET['course_idx']) ? intval($_GET['course_idx']) : -1;

    // Handle save
    if (isset($_POST['futuristic_it_save_course_detail']) && check_admin_referer('futuristic_it_course_detail')) {
        $post_key = sanitize_text_field($_POST['service_key']);
        $post_course_idx = intval($_POST['course_idx'] ?? -1);
        foreach ($all_services as &$svc) {
            if (('svc_' . md5($svc['title'] ?? '')) === $post_key) {
                $svc['type'] = 'Course';

                // Save course main title and description fields (service level)
                $svc['course_main_title_en'] = sanitize_text_field($_POST['course_main_title_en'] ?? '');
                $svc['course_main_title_kh'] = sanitize_text_field($_POST['course_main_title_kh'] ?? '');
                $svc['course_main_description_en'] = sanitize_textarea_field($_POST['course_main_description_en'] ?? '');
                $svc['course_main_description_kh'] = sanitize_textarea_field($_POST['course_main_description_kh'] ?? '');

                // Only update course data if course_title_en is present (i.e., saving from course edit form)
                if (isset($_POST['course_title_en'])) {
                    $raw_courses = isset($svc['courses']) && is_array($svc['courses']) ? $svc['courses'] : array();
                    // Update the specific course or add new
                    $new_course = array(
                        'image' => sanitize_text_field($_POST['course_image'] ?? ''),
                        'title_en' => sanitize_text_field($_POST['course_title_en'] ?? ''),
                        'title_kh' => sanitize_text_field($_POST['course_title_kh'] ?? ''),
                        'instructor' => sanitize_text_field($_POST['course_instructor'] ?? ''),
                        'instructor_km' => sanitize_text_field($_POST['course_instructor_km'] ?? ''),
                        'badge' => sanitize_text_field($_POST['course_badge'] ?? ''),
                        'badge_km' => sanitize_text_field($_POST['course_badge_km'] ?? ''),
                        'updated' => sanitize_text_field($_POST['course_updated'] ?? ''),
                        'hours' => sanitize_text_field($_POST['course_hours'] ?? ''),
                        'level' => sanitize_text_field($_POST['course_level'] ?? ''),
                        'subtitles' => sanitize_text_field($_POST['course_subtitles'] ?? ''),
                        'description_en' => sanitize_textarea_field($_POST['course_description_en'] ?? ''),
                        'description_kh' => sanitize_textarea_field($_POST['course_description_kh'] ?? ''),
                        'audience' => sanitize_textarea_field($_POST['course_audience'] ?? ''),
                        'audience_km' => sanitize_textarea_field($_POST['course_audience_km'] ?? ''),
                        'audience_title' => sanitize_text_field($_POST['course_audience_title'] ?? ''),
                        'audience_title_km' => sanitize_text_field($_POST['course_audience_title_km'] ?? ''),
                        'features' => sanitize_textarea_field($_POST['course_features'] ?? ''),
                        'features_km' => sanitize_textarea_field($_POST['course_features_km'] ?? ''),
                        'features_title' => sanitize_text_field($_POST['course_features_title'] ?? ''),
                        'features_title_km' => sanitize_text_field($_POST['course_features_title_km'] ?? ''),
                        'feature_text' => sanitize_textarea_field($_POST['course_feature_text'] ?? ''),
                        'feature_text_km' => sanitize_textarea_field($_POST['course_feature_text_km'] ?? ''),
                        'rating' => sanitize_text_field($_POST['course_rating'] ?? ''),
                        'reviews' => sanitize_text_field($_POST['course_reviews'] ?? ''),
                        'price' => sanitize_text_field($_POST['course_price'] ?? ''),
                        'btn_text' => sanitize_text_field($_POST['course_btn_text'] ?? 'Add to cart'),
                        'btn_text_km' => sanitize_text_field($_POST['course_btn_text_km'] ?? ''),
                        // A URL is language-neutral, so one link covers both.
                        // esc_url_raw drops non-web schemes such as javascript:.
                        'btn_link' => esc_url_raw($_POST['course_btn_link'] ?? ''),
                    );
                    if ($post_course_idx >= 0 && isset($raw_courses[$post_course_idx])) {
                        $raw_courses[$post_course_idx] = $new_course;
                    } else {
                        $raw_courses[] = $new_course;
                    }
                    $svc['courses'] = $raw_courses;
                }
                break;
            }
        }
        unset($svc);
        update_option('custom_service_cards', wp_json_encode($all_services));
        $selected_key = $post_key;
        futuristic_it_toast('Course saved!');
    }

    // Handle selection
    if (isset($_GET['select_service']) && !empty($_GET['select_service'])) {
        $selected_key = sanitize_text_field($_GET['select_service']);
        $selected_course_idx = -1;
    }
    if (isset($_GET['select_course']) && $_GET['select_course'] !== '') {
        $selected_course_idx = intval($_GET['select_course']);
    }

    // Get selected service
    $selected_service = null;
    if ($selected_key) {
        foreach ($all_services as $svc) {
            if (('svc_' . md5($svc['title'] ?? '')) === $selected_key) {
                $selected_service = $svc;
                break;
            }
        }
    }

    // Get selected course
    $selected_course = null;
    if ($selected_service && $selected_course_idx >= 0 && !empty($selected_service['courses'][$selected_course_idx])) {
        $selected_course = $selected_service['courses'][$selected_course_idx];
    }
    ?>
    <div class="wrap">
        <h1><?php _e('Course Detail', 'futuristic-it'); ?></h1>

        <!-- Selectors -->
        <div style="background:#fff;padding:20px;border:1px solid #ccc;border-radius:8px;margin-bottom:24px;">
            <h3 style="margin:0 0 12px;"><?php _e('Select a Course to Edit', 'futuristic-it'); ?></h3>
            <p style="margin:0 0 12px;color:#666;font-size:13px;">
                <?php _e('Step 1: choose a service. Step 2: choose a course, then click Edit to open its fields.', 'futuristic-it'); ?>
            </p>
            <form method="get" action="" style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
                <input type="hidden" name="page" value="futuristict-course-detail">
                <select name="select_service" id="courseServiceSelect" style="min-width:300px;padding:8px;">
                    <option value=""><?php _e('— Choose a service —', 'futuristic-it'); ?></option>
                    <?php foreach ($all_services as $svc) :
                        $key = 'svc_' . md5($svc['title'] ?? '');
                        $type = $svc['type'] ?? 'Detail';
                    ?>
                        <option value="<?php echo esc_attr($key); ?>" <?php selected($selected_key, $key); ?>><?php echo esc_html($svc['title'] ?? ''); ?> (<?php echo esc_html($type); ?>)</option>
                    <?php endforeach; ?>
                </select>
                <select name="select_course" id="courseTitleSelect" style="min-width:300px;padding:8px;<?php echo !$selected_service ? 'display:none;' : ''; ?>">
                    <option value=""><?php _e('— Choose a course —', 'futuristic-it'); ?></option>
                    <?php if ($selected_service && !empty($selected_service['courses'])) :
                        foreach ($selected_service['courses'] as $ci => $crs) : ?>
                        <option value="<?php echo $ci; ?>" <?php selected($selected_course_idx, $ci); ?>><?php echo esc_html($crs['title_en'] ?? $crs['title'] ?? 'Untitled Course ' . ($ci + 1)); ?></option>
                    <?php endforeach; endif; ?>
                </select>
                <button type="submit" class="button button-primary"><?php _e('Edit', 'futuristic-it'); ?></button>
            </form>
        </div>

        <!-- Edit Form -->
        <?php if ($selected_course) : ?>
            <div style="background:#fff;padding:24px;border:1px solid #ccc;border-radius:8px;margin-bottom:24px;">
                <h2 style="margin:0 0 16px;"><?php _e('Edit Course:', 'futuristic-it'); ?> <?php echo esc_html($selected_course['title_en'] ?? $selected_course['title'] ?? ''); ?></h2>
                <form method="post" action="">
                    <?php wp_nonce_field('futuristic_it_course_detail'); ?>
                    <input type="hidden" name="service_key" value="<?php echo esc_attr($selected_key); ?>">
                    <input type="hidden" name="course_idx" value="<?php echo esc_attr($selected_course_idx); ?>">

                    <div style="display:grid;grid-template-columns:250px 1fr;gap:24px;">
                        <div>
                            <label style="font-weight:600;font-size:12px;"><?php _e('Course Image', 'futuristic-it'); ?></label><br>
                            <input type="hidden" name="course_image" id="courseImageInput" value="<?php echo esc_attr($selected_course['image'] ?? ''); ?>">
                            <img id="courseImagePreview" src="<?php echo esc_url($selected_course['image'] ?? ''); ?>" style="width:100%;max-height:180px;object-fit:cover;border-radius:8px;margin-bottom:8px;<?php echo empty($selected_course['image'] ?? '') ? 'display:none;' : ''; ?>">
                            <br><button type="button" class="button upload-btn" data-for="courseImageInput"><?php _e('Upload Image', 'futuristic-it'); ?></button>
                        </div>
                        <div>
                            <div style="margin-bottom:12px;"><label style="font-weight:600;font-size:12px;"><?php _e('Course Title (English)', 'futuristic-it'); ?></label><input type="text" name="course_title_en" value="<?php echo esc_attr($selected_course['title_en'] ?? $selected_course['title'] ?? ''); ?>" class="widefat" placeholder="Enter course title in English"></div>
                            <div style="margin-bottom:12px;"><label style="font-weight:600;font-size:12px;"><?php _e('Course Title (Khmer)', 'futuristic-it'); ?></label><input type="text" name="course_title_kh" value="<?php echo esc_attr($selected_course['title_kh'] ?? $selected_course['title_km'] ?? ''); ?>" class="widefat" placeholder="បញ្ចូលចំណងជើងវគ្គសិក្សាជាភាសាខ្មែរ"></div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                                <div><label style="font-weight:600;font-size:12px;"><?php _e('Instructor (English)', 'futuristic-it'); ?></label><input type="text" name="course_instructor" value="<?php echo esc_attr($selected_course['instructor'] ?? ''); ?>" class="widefat" placeholder="Enter instructor name in English"></div>
                                <div><label style="font-weight:600;font-size:12px;"><?php _e('Instructor (Khmer)', 'futuristic-it'); ?></label><input type="text" name="course_instructor_km" value="<?php echo esc_attr($selected_course['instructor_km'] ?? ''); ?>" class="widefat" placeholder="បញ្ចូលឈ្មោះគ្រូបង្រៀនជាភាសាខ្មែរ"></div>
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                                <div><label style="font-weight:600;font-size:12px;"><?php _e('Badge (English)', 'futuristic-it'); ?></label><input type="text" name="course_badge" value="<?php echo esc_attr($selected_course['badge'] ?? ''); ?>" class="widefat" placeholder="e.g. Bestseller, Premium"></div>
                                <div><label style="font-weight:600;font-size:12px;"><?php _e('Badge (Khmer)', 'futuristic-it'); ?></label><input type="text" name="course_badge_km" value="<?php echo esc_attr($selected_course['badge_km'] ?? ''); ?>" class="widefat" placeholder="ឧ. លក់ដាច់បំផុត, ប្រណិត"></div>
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                                <div><label style="font-weight:600;font-size:12px;"><?php _e('Updated (e.g. June 2026)', 'futuristic-it'); ?></label><input type="text" name="course_updated" value="<?php echo esc_attr($selected_course['updated'] ?? ''); ?>" class="widefat" placeholder="e.g. June 2026"></div>
                                <div><label style="font-weight:600;font-size:12px;"><?php _e('Total Hours (e.g. 17.5)', 'futuristic-it'); ?></label><input type="text" name="course_hours" value="<?php echo esc_attr($selected_course['hours'] ?? ''); ?>" class="widefat" placeholder="e.g. 17.5"></div>
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                                <div><label style="font-weight:600;font-size:12px;"><?php _e('Level (e.g. All Levels)', 'futuristic-it'); ?></label><input type="text" name="course_level" value="<?php echo esc_attr($selected_course['level'] ?? ''); ?>" class="widefat" placeholder="e.g. All Levels, Beginner, Intermediate"></div>
                                <div><label style="font-weight:600;font-size:12px;"><?php _e('Subtitles (e.g. Subtitles, CC)', 'futuristic-it'); ?></label><input type="text" name="course_subtitles" value="<?php echo esc_attr($selected_course['subtitles'] ?? ''); ?>" class="widefat" placeholder="e.g. Subtitles, CC"></div>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top:16px;margin-bottom:16px;"><label style="font-weight:600;font-size:12px;"><?php _e('Description (English)', 'futuristic-it'); ?></label><textarea name="course_description_en" class="widefat" rows="3" placeholder="Enter course description in English"><?php echo esc_textarea($selected_course['description_en'] ?? $selected_course['description'] ?? ''); ?></textarea></div>

                    <div style="margin-bottom:16px;"><label style="font-weight:600;font-size:12px;"><?php _e('Description (Khmer)', 'futuristic-it'); ?></label><textarea name="course_description_kh" class="widefat" rows="3" placeholder="បញ្ចូលការពិពណ៌នាវគ្គសិក្សាជាភាសាខ្មែរ"><?php echo esc_textarea($selected_course['description_kh'] ?? $selected_course['description_km'] ?? ''); ?></textarea></div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                        <div><label style="font-weight:600;font-size:12px;"><?php _e('Audience Heading (English)', 'futuristic-it'); ?></label><input type="text" name="course_audience_title" value="<?php echo esc_attr($selected_course['audience_title'] ?? ''); ?>" class="widefat" placeholder="Who this course is for"></div>
                        <div><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Audience Heading (Khmer)', 'futuristic-it'); ?></label><input type="text" name="course_audience_title_km" value="<?php echo esc_attr($selected_course['audience_title_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;" placeholder="អ្នកដែលសមស្រប"></div>
                    </div>

                    <div style="margin-bottom:16px;"><label style="font-weight:600;font-size:12px;"><?php _e('Target Audience (English, one per line)', 'futuristic-it'); ?></label><textarea name="course_audience" class="widefat" rows="3" placeholder="Enter who the course is for in English, one per line"><?php echo esc_textarea($selected_course['audience'] ?? ''); ?></textarea></div>

                    <div style="margin-bottom:16px;"><label style="font-weight:600;font-size:12px;"><?php _e('Target Audience (Khmer, one per line)', 'futuristic-it'); ?></label><textarea name="course_audience_km" class="widefat" rows="3" placeholder="បញ្ចូលអ្នកដែលសមស្របសម្រាប់វគ្គសិក្សាជាភាសាខ្មែរ មួយបន្ទាត់មួយ"><?php echo esc_textarea($selected_course['audience_km'] ?? ''); ?></textarea></div>

                    <div style="margin-bottom:16px;"><label style="font-weight:600;font-size:12px;"><?php _e('Feature Text (English, one paragraph per line) — shows above "What You\'ll Learn"', 'futuristic-it'); ?></label><textarea name="course_feature_text" class="widefat" rows="3" placeholder="Enter an intro paragraph in English, one paragraph per line"><?php echo esc_textarea($selected_course['feature_text'] ?? ''); ?></textarea></div>

                    <div style="margin-bottom:16px;"><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Feature Text (Khmer, one paragraph per line) — shows above "What You\'ll Learn"', 'futuristic-it'); ?></label><textarea name="course_feature_text_km" class="widefat" rows="3" style="font-family:'Noto Sans Khmer',sans-serif;" placeholder="បញ្ចូលកថាខណ្ឌផ្ដើមជាភាសាខ្មែរ មួយបន្ទាត់មួយកថាខណ្ឌ"><?php echo esc_textarea($selected_course['feature_text_km'] ?? ''); ?></textarea></div>

                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                        <div><label style="font-weight:600;font-size:12px;"><?php _e('Features Heading (English)', 'futuristic-it'); ?></label><input type="text" name="course_features_title" value="<?php echo esc_attr($selected_course['features_title'] ?? ''); ?>" class="widefat" placeholder="What you'll learn"></div>
                        <div><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Features Heading (Khmer)', 'futuristic-it'); ?></label><input type="text" name="course_features_title_km" value="<?php echo esc_attr($selected_course['features_title_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;" placeholder="អ្វីដែលអ្នកនឹងរៀន"></div>
                    </div>

                    <div style="margin-bottom:16px;"><label style="font-weight:600;font-size:12px;"><?php _e('What You\'ll Learn — Features (English, one per line)', 'futuristic-it'); ?></label><textarea name="course_features" class="widefat" rows="4" placeholder="Enter what students will learn in English, one per line"><?php echo esc_textarea($selected_course['features'] ?? ''); ?></textarea></div>

                    <div style="margin-bottom:16px;"><label style="font-weight:600;font-size:12px;"><?php _e('What You\'ll Learn — Features (Khmer, one per line)', 'futuristic-it'); ?></label><textarea name="course_features_km" class="widefat" rows="4" placeholder="បញ្ចូលអ្វីដែលអ្នកនឹងរៀនជាភាសាខ្មែរ មួយបន្ទាត់មួយ"><?php echo esc_textarea($selected_course['features_km'] ?? ''); ?></textarea></div>

                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
                        <div><label style="font-weight:600;font-size:12px;"><?php _e('Rating', 'futuristic-it'); ?></label><input type="text" name="course_rating" value="<?php echo esc_attr($selected_course['rating'] ?? ''); ?>" class="widefat" placeholder="e.g. 4.5"></div>
                        <div><label style="font-weight:600;font-size:12px;"><?php _e('Reviews', 'futuristic-it'); ?></label><input type="text" name="course_reviews" value="<?php echo esc_attr($selected_course['reviews'] ?? ''); ?>" class="widefat" placeholder="e.g. 1,094"></div>
                        <div><label style="font-weight:600;font-size:12px;"><?php _e('Price', 'futuristic-it'); ?></label><input type="text" name="course_price" value="<?php echo esc_attr($selected_course['price'] ?? ''); ?>" class="widefat" placeholder="e.g. 10.00"></div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;margin-top:12px;">
                        <div><label style="font-weight:600;font-size:12px;"><?php _e('Button Text (English)', 'futuristic-it'); ?></label><input type="text" name="course_btn_text" value="<?php echo esc_attr($selected_course['btn_text'] ?? 'Add to cart'); ?>" class="widefat" placeholder="e.g. Add to cart, Enroll Now"></div>
                        <div><label style="font-weight:600;font-size:12px;"><?php _e('Button Text (Khmer)', 'futuristic-it'); ?></label><input type="text" name="course_btn_text_km" value="<?php echo esc_attr($selected_course['btn_text_km'] ?? ''); ?>" class="widefat" placeholder="ឧ. បន្ថែមទៅរទេះ, ចុះឈ្មោះឥឡូវនេះ"></div>
                        <div><label style="font-weight:600;font-size:12px;"><?php _e('Button Link', 'futuristic-it'); ?></label><input type="text" name="course_btn_link" value="<?php echo esc_attr($selected_course['btn_link'] ?? ''); ?>" class="widefat" placeholder="<?php echo esc_attr(home_url('/contact/')); ?>"></div>
                    </div>

                    <hr style="margin:24px 0;">
                    <p class="submit" style="margin:0;">
                        <input type="submit" name="futuristic_it_save_course_detail" class="button button-primary" value="<?php _e('Save Course', 'futuristic-it'); ?>">
                    </p>
                </form>
            </div>

            <script>
            var courseImgInput = document.getElementById('courseImageInput');
            var courseImgPreview = document.getElementById('courseImagePreview');
            if (courseImgInput && courseImgPreview) {
                var obs = new MutationObserver(function() {
                    if (courseImgInput.value) {
                        courseImgPreview.src = courseImgInput.value;
                        courseImgPreview.style.display = 'block';
                    } else {
                        courseImgPreview.style.display = 'none';
                    }
                });
                obs.observe(courseImgInput, {attributes: true, attributeFilter: ['value']});
            }
            </script>
        <?php elseif ($selected_service) : ?>
            <div style="background:#fff;padding:24px;border:1px solid #ccc;border-radius:8px;margin-bottom:24px;">
                <p style="color:#888;margin:0;"><?php _e('Select a course from the dropdown above and click Edit to open its fields (including What You\'ll Learn), or add a new course in the Service Details admin.', 'futuristic-it'); ?></p>
            </div>
        <?php endif; ?>

        <!-- Course List -->
        <?php if ($selected_service && !empty($selected_service['courses'])) : ?>
        <div style="background:#fff;padding:24px;border:1px solid #ccc;border-radius:8px;">
            <h2 style="margin:0 0 16px;"><?php _e('All Courses in', 'futuristic-it'); ?> <?php echo esc_html($selected_service['title'] ?? ''); ?></h2>
            <table class="widefat striped">
                <thead>
                    <tr>
                        <th style="width:60px;"><?php _e('Image', 'futuristic-it'); ?></th>
                        <th><?php _e('Title', 'futuristic-it'); ?></th>
                        <th><?php _e('Instructor', 'futuristic-it'); ?></th>
                        <th><?php _e('Hours', 'futuristic-it'); ?></th>
                        <th><?php _e('Level', 'futuristic-it'); ?></th>
                        <th><?php _e('Price', 'futuristic-it'); ?></th>
                        <th><?php _e('Actions', 'futuristic-it'); ?></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($selected_service['courses'] as $ci => $crs) : ?>
                    <tr>
                        <td><?php if (!empty($crs['image'])) : ?><img src="<?php echo esc_url($crs['image']); ?>" style="width:50px;height:50px;object-fit:cover;border-radius:4px;"><?php endif; ?></td>
                        <td><strong><?php echo esc_html($crs['title_en'] ?? $crs['title'] ?? ''); ?></strong></td>
                        <td><?php echo esc_html($crs['instructor'] ?? ''); ?></td>
                        <td><?php echo esc_html($crs['hours'] ?? ''); ?></td>
                        <td><?php echo esc_html($crs['level'] ?? ''); ?></td>
                        <td><?php echo esc_html($crs['price'] ?? ''); ?></td>
                        <td><a href="<?php echo admin_url('admin.php?page=futuristict-course-detail&select_service=' . urlencode($selected_key) . '&select_course=' . $ci); ?>" class="button button-small"><?php _e('Edit', 'futuristic-it'); ?></a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
    <?php
}

// About Hero Page
function futuristict_about_hero_page() {
    if (isset($_POST['futuristic_it_save_about_hero']) && check_admin_referer('futuristic_it_about_hero')) {
        update_option('custom_about_hero_image', sanitize_text_field($_POST['custom_about_hero_image']));
        $fields = array('custom_about_tagline', 'custom_about_title', 'custom_about_subtitle', 'custom_about_btn_text', 'custom_about_btn_link');
        foreach ($fields as $f) {
            if (isset($_POST[$f])) update_option($f, sanitize_text_field($_POST[$f]));
            if (isset($_POST[$f . '_km'])) update_option($f . '_km', sanitize_text_field($_POST[$f . '_km']));
        }
        futuristic_it_toast('Hero saved!');
    }
    ?>
    <div class="wrap">
        <h1><?php _e('About – Hero Section', 'futuristic-it'); ?></h1>
        <p><a href="<?php echo admin_url('admin.php?page=futuristict-about'); ?>">&larr; Back</a></p>
        <form method="post" action="">
            <?php wp_nonce_field('futuristic_it_about_hero'); ?>
            <table class="form-table">
                <tr><th><label>Hero Image</label></th><td>
                    <input type="hidden" name="custom_about_hero_image" value="<?php echo esc_attr(get_option('custom_about_hero_image', '')); ?>">
                    <?php $img = get_option('custom_about_hero_image', ''); if (!empty($img)) : ?><img src="<?php echo esc_url($img); ?>" style="max-height:100px;margin-bottom:10px;display:block;"><br><?php endif; ?>
                    <button type="button" class="button upload-btn" data-for="custom_about_hero_image">Upload Image</button>
                </td></tr>
                <tr><th><label>Tagline (English)</label></th><td><input type="text" class="regular-text" name="custom_about_tagline" value="<?php echo esc_attr(get_option('custom_about_tagline', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Tagline (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_about_tagline_km" value="<?php echo esc_attr(get_option('custom_about_tagline_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>Title (English)</label></th><td><input type="text" class="regular-text" name="custom_about_title" value="<?php echo esc_attr(get_option('custom_about_title', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Title (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_about_title_km" value="<?php echo esc_attr(get_option('custom_about_title_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>Subtitle (English)</label></th><td><textarea class="large-text" name="custom_about_subtitle" rows="3"><?php echo esc_textarea(get_option('custom_about_subtitle', '')); ?></textarea></td></tr>
                <tr><th><label style="color:#b8892f;">Subtitle (Khmer)</label></th><td><textarea class="large-text" name="custom_about_subtitle_km" rows="3" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea(get_option('custom_about_subtitle_km', '')); ?></textarea></td></tr>
                <tr><th><label>Button Text (English)</label></th><td><input type="text" class="regular-text" name="custom_about_btn_text" value="<?php echo esc_attr(get_option('custom_about_btn_text', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Button Text (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_about_btn_text_km" value="<?php echo esc_attr(get_option('custom_about_btn_text_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>Button Link</label></th><td><input type="text" class="regular-text" name="custom_about_btn_link" value="<?php echo esc_attr(get_option('custom_about_btn_link', '')); ?>" placeholder="/our-service/ or https://..."></td></tr>
            </table>
            <input type="submit" name="futuristic_it_save_about_hero" class="button button-primary" value="Save Hero">
        </form>
    </div>
    <?php
}

// About Story Page
function futuristict_about_story_page() {
    if (isset($_POST['futuristic_it_save_about_story']) && check_admin_referer('futuristic_it_about_story')) {
        update_option('custom_about_story_image', sanitize_text_field($_POST['custom_about_story_image']));
        $fields = array('custom_about_story_tagline', 'custom_about_our_story', 'custom_about_mission', 'custom_about_vision', 'custom_about_paragraph3');
        foreach ($fields as $f) {
            if (isset($_POST[$f])) update_option($f, sanitize_text_field($_POST[$f]));
            if (isset($_POST[$f . '_km'])) update_option($f . '_km', sanitize_text_field($_POST[$f . '_km']));
        }
        futuristic_it_toast('Story saved!');
    }
    ?>
    <div class="wrap">
        <h1><?php _e('About – Our Story', 'futuristic-it'); ?></h1>
        <p><a href="<?php echo admin_url('admin.php?page=futuristict-about'); ?>">&larr; Back</a></p>
        <form method="post" action="">
            <?php wp_nonce_field('futuristic_it_about_story'); ?>
            <table class="form-table">
                <tr><th><label>Story Image</label></th><td>
                    <input type="hidden" name="custom_about_story_image" value="<?php echo esc_attr(get_option('custom_about_story_image', '')); ?>">
                    <?php $img = get_option('custom_about_story_image', ''); if (!empty($img)) : ?><img src="<?php echo esc_url($img); ?>" style="max-height:100px;margin-bottom:10px;display:block;"><br><?php endif; ?>
                    <button type="button" class="button upload-btn" data-for="custom_about_story_image">Upload Image</button>
                </td></tr>
                <tr><th><label>Tagline (English)</label></th><td><input type="text" class="regular-text" name="custom_about_story_tagline" value="<?php echo esc_attr(get_option('custom_about_story_tagline', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Tagline (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_about_story_tagline_km" value="<?php echo esc_attr(get_option('custom_about_story_tagline_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>Title (English)</label></th><td><input type="text" class="regular-text" name="custom_about_our_story" value="<?php echo esc_attr(get_option('custom_about_our_story', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Title (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_about_our_story_km" value="<?php echo esc_attr(get_option('custom_about_our_story_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>Paragraph 1 (English)</label></th><td><textarea class="large-text" name="custom_about_mission" rows="3"><?php echo esc_textarea(get_option('custom_about_mission', '')); ?></textarea></td></tr>
                <tr><th><label style="color:#b8892f;">Paragraph 1 (Khmer)</label></th><td><textarea class="large-text" name="custom_about_mission_km" rows="3" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea(get_option('custom_about_mission_km', '')); ?></textarea></td></tr>
                <tr><th><label>Paragraph 2 (English)</label></th><td><textarea class="large-text" name="custom_about_vision" rows="3"><?php echo esc_textarea(get_option('custom_about_vision', '')); ?></textarea></td></tr>
                <tr><th><label style="color:#b8892f;">Paragraph 2 (Khmer)</label></th><td><textarea class="large-text" name="custom_about_vision_km" rows="3" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea(get_option('custom_about_vision_km', '')); ?></textarea></td></tr>
                <tr><th><label>Paragraph 3 (English)</label></th><td><textarea class="large-text" name="custom_about_paragraph3" rows="3"><?php echo esc_textarea(get_option('custom_about_paragraph3', '')); ?></textarea></td></tr>
                <tr><th><label style="color:#b8892f;">Paragraph 3 (Khmer)</label></th><td><textarea class="large-text" name="custom_about_paragraph3_km" rows="3" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea(get_option('custom_about_paragraph3_km', '')); ?></textarea></td></tr>
            </table>
            <input type="submit" name="futuristic_it_save_about_story" class="button button-primary" value="Save Story">
        </form>
    </div>
    <?php
}

// About Philosophy Page
function futuristict_about_philosophy_page() {
    if (isset($_POST['futuristic_it_save_about_philosophy']) && check_admin_referer('futuristic_it_about_philosophy')) {
        $fields = array('custom_about_philosophy_tagline', 'custom_about_philosophy_title');
        foreach ($fields as $f) {
            if (isset($_POST[$f])) update_option($f, sanitize_text_field($_POST[$f]));
            if (isset($_POST[$f . '_km'])) update_option($f . '_km', sanitize_text_field($_POST[$f . '_km']));
        }
        if (isset($_POST['philosophy_cards'])) {
            $cards = $_POST['philosophy_cards'];
            foreach ($cards as &$card) {
                if (isset($card['title_km'])) $card['title_km'] = sanitize_text_field($card['title_km']);
                if (isset($card['desc_km'])) $card['desc_km'] = sanitize_textarea_field($card['desc_km']);
            }
            unset($card);
            update_option('custom_about_philosophy_cards', sanitize_text_field(wp_json_encode($cards)));
        }
        futuristic_it_toast('Philosophy saved!');
    }
    $cards = json_decode(get_option('custom_about_philosophy_cards', '[]'), true);
    if (!is_array($cards)) $cards = array();
    ?>
    <div class="wrap">
        <h1><?php _e('About – Core Philosophy', 'futuristic-it'); ?></h1>
        <p><a href="<?php echo admin_url('admin.php?page=futuristict-about'); ?>">&larr; Back</a></p>
        <form method="post" action="">
            <?php wp_nonce_field('futuristic_it_about_philosophy'); ?>
            <table class="form-table">
                <tr><th><label>Tagline (English)</label></th><td><input type="text" class="regular-text" name="custom_about_philosophy_tagline" value="<?php echo esc_attr(get_option('custom_about_philosophy_tagline', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Tagline (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_about_philosophy_tagline_km" value="<?php echo esc_attr(get_option('custom_about_philosophy_tagline_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>Title (English)</label></th><td><textarea class="large-text" name="custom_about_philosophy_title" rows="2"><?php echo esc_textarea(get_option('custom_about_philosophy_title', '')); ?></textarea></td></tr>
                <tr><th><label style="color:#b8892f;">Title (Khmer)</label></th><td><textarea class="large-text" name="custom_about_philosophy_title_km" rows="2" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea(get_option('custom_about_philosophy_title_km', '')); ?></textarea></td></tr>
            </table>
            <h2><?php _e('Philosophy Cards', 'futuristic-it'); ?></h2>
            <table class="widefat striped" id="philosophy-table">
                <thead><tr><th style="width:80px">Image</th><th>Title</th><th>Title (Khmer)</th><th>Description</th><th>Description (Khmer)</th><th style="width:60px"></th></tr></thead>
                <tbody>
                <?php foreach ($cards as $i => $c) : ?>
                    <tr data-saved="1">
                        <td><input type="hidden" name="philosophy_cards[<?php echo $i; ?>][icon]" value="<?php echo esc_attr($c['icon'] ?? ''); ?>"><?php if (!empty($c['icon'])) : ?><img src="<?php echo esc_url($c['icon']); ?>" style="width:50px;height:50px;object-fit:contain;border-radius:4px;background:#fff;padding:2px;"><?php endif; ?><br><a href="#" class="button button-small upload-btn" data-for="philosophy_cards[<?php echo $i; ?>][icon]">Upload</a></td>
                        <td><input type="text" name="philosophy_cards[<?php echo $i; ?>][title]" value="<?php echo esc_attr($c['title'] ?? ''); ?>" class="widefat"></td>
                        <td><input type="text" name="philosophy_cards[<?php echo $i; ?>][title_km]" value="<?php echo esc_attr($c['title_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;"></td>
                        <td><textarea name="philosophy_cards[<?php echo $i; ?>][desc]" class="widefat" rows="2"><?php echo esc_textarea($c['desc'] ?? ''); ?></textarea></td>
                        <td><textarea name="philosophy_cards[<?php echo $i; ?>][desc_km]" class="widefat" rows="2" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea($c['desc_km'] ?? ''); ?></textarea></td>
                        <td><button type="button" class="button button-small del-row" style="color:#dc3545;">Delete</button></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <p><button type="button" class="button" id="add-philosophy">+ Add Card</button></p>
            <br><input type="submit" name="futuristic_it_save_about_philosophy" class="button button-primary" value="Save Philosophy">
        </form>
    </div>
    <?php
}

// About Timeline Page
function futuristict_about_timeline_page() {
    if (isset($_POST['futuristic_it_save_about_timeline']) && check_admin_referer('futuristic_it_about_timeline')) {
        $fields = array('custom_about_journey_tagline', 'custom_about_journey_title', 'custom_about_journey_subtitle');
        foreach ($fields as $f) {
            if (isset($_POST[$f])) update_option($f, sanitize_text_field($_POST[$f]));
            if (isset($_POST[$f . '_km'])) update_option($f . '_km', sanitize_text_field($_POST[$f . '_km']));
        }
        if (isset($_POST['custom_about_timeline'])) {
            $items = $_POST['custom_about_timeline'];
            foreach ($items as &$item) {
                if (isset($item['title_km'])) $item['title_km'] = sanitize_text_field($item['title_km']);
                if (isset($item['desc_km'])) $item['desc_km'] = sanitize_textarea_field($item['desc_km']);
            }
            unset($item);
            update_option('custom_about_timeline', sanitize_text_field(wp_json_encode($items)));
        }
        futuristic_it_toast('Timeline saved!');
    }
    $timeline = json_decode(get_option('custom_about_timeline', '[]'), true);
    if (!is_array($timeline)) $timeline = array();
    ?>
    <div class="wrap">
        <h1><?php _e('About – Timeline', 'futuristic-it'); ?></h1>
        <p><a href="<?php echo admin_url('admin.php?page=futuristict-about'); ?>">&larr; Back</a></p>
        <form method="post" action="">
            <?php wp_nonce_field('futuristic_it_about_timeline'); ?>
            <table class="form-table">
                <tr><th><label>Tagline (English)</label></th><td><input type="text" class="regular-text" name="custom_about_journey_tagline" value="<?php echo esc_attr(get_option('custom_about_journey_tagline', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Tagline (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_about_journey_tagline_km" value="<?php echo esc_attr(get_option('custom_about_journey_tagline_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>Title (English)</label></th><td><input type="text" class="regular-text" name="custom_about_journey_title" value="<?php echo esc_attr(get_option('custom_about_journey_title', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Title (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_about_journey_title_km" value="<?php echo esc_attr(get_option('custom_about_journey_title_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>Subtitle (English)</label></th><td><input type="text" class="regular-text" name="custom_about_journey_subtitle" value="<?php echo esc_attr(get_option('custom_about_journey_subtitle', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Subtitle (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_about_journey_subtitle_km" value="<?php echo esc_attr(get_option('custom_about_journey_subtitle_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
            </table>
            <h2><?php _e('Timeline Items', 'futuristic-it'); ?></h2>
            <table class="widefat striped" id="timeline-table">
                <thead><tr><th style="width:80px">Year</th><th>Title</th><th>Title (Khmer)</th><th>Description</th><th>Description (Khmer)</th><th style="width:60px"></th></tr></thead>
                <tbody>
                <?php foreach ($timeline as $i => $t) : ?>
                    <tr data-saved="1">
                        <td><input type="text" name="custom_about_timeline[<?php echo $i; ?>][year]" value="<?php echo esc_attr($t['year'] ?? ''); ?>" style="width:80px"></td>
                        <td><input type="text" name="custom_about_timeline[<?php echo $i; ?>][title]" value="<?php echo esc_attr($t['title'] ?? ''); ?>" class="widefat"></td>
                        <td><input type="text" name="custom_about_timeline[<?php echo $i; ?>][title_km]" value="<?php echo esc_attr($t['title_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;"></td>
                        <td><textarea name="custom_about_timeline[<?php echo $i; ?>][desc]" class="widefat" rows="2"><?php echo esc_textarea($t['desc'] ?? ''); ?></textarea></td>
                        <td><textarea name="custom_about_timeline[<?php echo $i; ?>][desc_km]" class="widefat" rows="2" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea($t['desc_km'] ?? ''); ?></textarea></td>
                        <td><button type="button" class="button button-small del-row" style="color:#dc3545;">Delete</button></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <p><button type="button" class="button" id="add-timeline">+ Add Timeline Item</button></p>
            <br><input type="submit" name="futuristic_it_save_about_timeline" class="button button-primary" value="Save Timeline">
        </form>
    </div>
    <?php
}

// About FAQ Page
function futuristict_about_faq_page() {
    if (isset($_POST['futuristic_it_save_about_faq']) && check_admin_referer('futuristic_it_about_faq')) {
        $fields = array('custom_faq_title');
        foreach ($fields as $f) {
            if (isset($_POST[$f])) update_option($f, sanitize_text_field($_POST[$f]));
            if (isset($_POST[$f . '_km'])) update_option($f . '_km', sanitize_text_field($_POST[$f . '_km']));
        }
        if (isset($_POST['custom_about_faqs'])) {
            $faqs = $_POST['custom_about_faqs'];
            foreach ($faqs as &$faq) {
                if (isset($faq['q'])) $faq['q'] = sanitize_text_field($faq['q']);
                if (isset($faq['q_km'])) $faq['q_km'] = sanitize_text_field($faq['q_km']);
                if (isset($faq['a'])) $faq['a'] = sanitize_textarea_field($faq['a']);
                if (isset($faq['a_km'])) $faq['a_km'] = sanitize_textarea_field($faq['a_km']);
            }
            unset($faq);
            update_option('custom_about_faqs', wp_json_encode($faqs));
        }
        futuristic_it_toast('FAQ saved!');
    }
    $faqs = json_decode(get_option('custom_about_faqs', '[]'), true);
    if (!is_array($faqs)) $faqs = array();
    ?>
    <div class="wrap">
        <h1><?php _e('About – FAQ', 'futuristic-it'); ?></h1>
        <p><a href="<?php echo admin_url('admin.php?page=futuristict-about'); ?>">&larr; Back</a></p>
        <form method="post" action="">
            <?php wp_nonce_field('futuristic_it_about_faq'); ?>
            <table class="form-table">
                <tr><th><label>FAQ Section Title (English)</label></th><td><input type="text" class="regular-text" name="custom_faq_title" value="<?php echo esc_attr(get_option('custom_faq_title', 'FAQ')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">FAQ Section Title (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_faq_title_km" value="<?php echo esc_attr(get_option('custom_faq_title_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
            </table>
            <h2><?php _e('FAQ Items', 'futuristic-it'); ?></h2>
            <table class="widefat striped" id="faq-table">
                <thead><tr><th>Question (English)</th><th>Question (Khmer)</th><th>Answer (English)</th><th>Answer (Khmer)</th><th style="width:60px"></th></tr></thead>
                <tbody>
                <?php foreach ($faqs as $i => $f) : ?>
                    <tr data-saved="1">
                        <td><input type="text" name="custom_about_faqs[<?php echo $i; ?>][q]" value="<?php echo esc_attr($f['q'] ?? ''); ?>" class="widefat"></td>
                        <td><input type="text" name="custom_about_faqs[<?php echo $i; ?>][q_km]" value="<?php echo esc_attr($f['q_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;"></td>
                        <td><textarea name="custom_about_faqs[<?php echo $i; ?>][a]" class="widefat" rows="2"><?php echo esc_textarea($f['a'] ?? ''); ?></textarea></td>
                        <td><textarea name="custom_about_faqs[<?php echo $i; ?>][a_km]" class="widefat" rows="2" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea($f['a_km'] ?? ''); ?></textarea></td>
                        <td><button type="button" class="button button-small del-row" style="color:#dc3545;">Delete</button></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <p><button type="button" class="button" onclick="addFaq();">+ Add FAQ</button></p>
            <br><input type="submit" name="futuristic_it_save_about_faq" class="button button-primary" value="Save FAQ">
        </form>
    </div>
    <script>
    var faqCount = <?php echo count($faqs); ?>;
    function addFaq() {
        var idx = faqCount;
        var html = '<tr>' +
            '<td><input type="text" name="custom_about_faqs[' + idx + '][q]" value="" class="widefat"></td>' +
            '<td><input type="text" name="custom_about_faqs[' + idx + '][q_km]" value="" class="widefat" style="font-family:\'Noto Sans Khmer\',sans-serif;"></td>' +
            '<td><textarea name="custom_about_faqs[' + idx + '][a]" class="widefat" rows="2"></textarea></td>' +
            '<td><textarea name="custom_about_faqs[' + idx + '][a_km]" class="widefat" rows="2" style="font-family:\'Noto Sans Khmer\',sans-serif;"></textarea></td>' +
            '<td><button type="button" class="button button-small del-row" style="color:#dc3545;">Delete</button></td>' +
            '</tr>';
        document.querySelector('#faq-table tbody').insertAdjacentHTML('beforeend', html);
        faqCount++;
    }
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('del-row')) {
            var row = e.target.closest('tr');
            var table = row ? row.closest('table') : null;
            if (row) row.remove();
            // Deleting shifts every later row up, so the numbers and the
            // submitted indexes have to be rebuilt from what is left.
            fwReindexRows(table);
        }
    });
    </script>
    <?php
}

// Services Hero Page
function futuristict_services_hero_page() {
    if (isset($_POST['futuristic_it_save_svc_hero']) && check_admin_referer('futuristic_it_svc_hero')) {
        update_option('services_hero_image', sanitize_text_field($_POST['services_hero_image']));
        $fields = array('custom_services_hero_tagline', 'custom_services_hero_title', 'custom_services_hero_subtitle', 'custom_services_hero_btn_text');
        foreach ($fields as $f) {
            if (isset($_POST[$f])) update_option($f, sanitize_text_field($_POST[$f]));
            if (isset($_POST[$f . '_km'])) update_option($f . '_km', sanitize_text_field($_POST[$f . '_km']));
        }
        futuristic_it_toast('Hero saved!');
    }
    ?>
    <div class="wrap">
        <h1><?php _e('Services – Hero Section', 'futuristic-it'); ?></h1>
        <p><a href="<?php echo admin_url('admin.php?page=futuristict-services'); ?>">&larr; Back</a></p>
        <form method="post" action="">
            <?php wp_nonce_field('futuristic_it_svc_hero'); ?>
            <table class="form-table">
                <tr><th><label>Hero Image</label></th><td>
                    <input type="hidden" name="services_hero_image" value="<?php echo esc_attr(get_option('services_hero_image', '')); ?>">
                    <?php $img = get_option('services_hero_image', ''); if (!empty($img)) : ?><img src="<?php echo esc_url($img); ?>" style="max-height:100px;margin-bottom:10px;display:block;"><br><?php endif; ?>
                    <button type="button" class="button upload-btn" data-for="services_hero_image">Upload Image</button>
                </td></tr>
                <tr><th><label>Tagline (English)</label></th><td><input type="text" class="regular-text" name="custom_services_hero_tagline" value="<?php echo esc_attr(get_option('custom_services_hero_tagline', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Tagline (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_services_hero_tagline_km" value="<?php echo esc_attr(get_option('custom_services_hero_tagline_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>Title (English)</label></th><td><input type="text" class="regular-text" name="custom_services_hero_title" value="<?php echo esc_attr(get_option('custom_services_hero_title', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Title (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_services_hero_title_km" value="<?php echo esc_attr(get_option('custom_services_hero_title_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>Subtitle (English)</label></th><td><textarea class="large-text" name="custom_services_hero_subtitle" rows="3"><?php echo esc_textarea(get_option('custom_services_hero_subtitle', '')); ?></textarea></td></tr>
                <tr><th><label style="color:#b8892f;">Subtitle (Khmer)</label></th><td><textarea class="large-text" name="custom_services_hero_subtitle_km" rows="3" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea(get_option('custom_services_hero_subtitle_km', '')); ?></textarea></td></tr>
                <tr><th><label>Button Text (English)</label></th><td><input type="text" class="regular-text" name="custom_services_hero_btn_text" value="<?php echo esc_attr(get_option('custom_services_hero_btn_text', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Button Text (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_services_hero_btn_text_km" value="<?php echo esc_attr(get_option('custom_services_hero_btn_text_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
            </table>
            <input type="submit" name="futuristic_it_save_svc_hero" class="button button-primary" value="Save Hero">
        </form>
    </div>
    <?php
}

// Services Cards Page
function futuristict_services_cards_page() {
    if (isset($_POST['futuristic_it_save_svc_cards']) && check_admin_referer('futuristic_it_svc_cards')) {
        $fields = array('custom_services_cards_tagline', 'custom_services_cards_title', 'custom_services_cards_desc');
        foreach ($fields as $f) {
            if (isset($_POST[$f])) update_option($f, sanitize_text_field($_POST[$f]));
            if (isset($_POST[$f . '_km'])) update_option($f . '_km', sanitize_text_field($_POST[$f . '_km']));
        }
        // Process service cards with features
        $raw_cards = isset($_POST['custom_service_cards']) && is_array($_POST['custom_service_cards']) ? $_POST['custom_service_cards'] : array();
        $processed_cards = array();
        // Load existing data to preserve detail fields
        $existing_services = json_decode(get_option('custom_service_cards', '[]'), true);
        if (!is_array($existing_services)) $existing_services = array();
        
        foreach ($raw_cards as $i => $card) {
            $card_data = array(
                'image' => sanitize_text_field($card['image'] ?? ''),
                'title' => sanitize_text_field($card['title'] ?? ''),
                'title_km' => sanitize_text_field($card['title_km'] ?? ''),
                'desc' => sanitize_textarea_field($card['desc'] ?? ''),
                'desc_km' => sanitize_textarea_field($card['desc_km'] ?? ''),
                'type' => in_array(($card['type'] ?? ''), array('Contact', 'Course')) ? $card['type'] : 'Detail',
                'link' => sanitize_text_field($card['link'] ?? ''),
                'link_text' => sanitize_text_field($card['link_text'] ?? 'Learn More'),
                'link_text_km' => sanitize_text_field($card['link_text_km'] ?? ''),
            );
            // Process features from nested array
            $card_data['features'] = array();
            if (isset($card['features']) && is_array($card['features'])) {
                foreach ($card['features'] as $feat) {
                    $feat_title = sanitize_text_field($feat['title'] ?? '');
                    if (!empty($feat_title)) {
                        $card_data['features'][] = array(
                            'title' => $feat_title,
                            'title_km' => sanitize_text_field($feat['title_km'] ?? ''),
                        );
                    }
                }
            }
            // Preserve existing detail fields from Service Details admin
            if (isset($existing_services[$i])) {
                $existing = $existing_services[$i];
                foreach (array('packages', 'images', 'courses', 'course_main_title_en', 'course_main_title_kh', 'course_main_description_en', 'course_main_description_kh', 'why_learn', 'why_learn_title', 'why_learn_title_km', 'why_learn_cta_title', 'why_learn_cta_title_km', 'why_learn_cta_desc', 'why_learn_cta_desc_km', 'why_learn_cta_btn_text', 'why_learn_cta_btn_text_km', 'faqs', 'faq_title', 'faq_title_km', 'faq_subtitle', 'faq_subtitle_km', 'packages_title', 'packages_title_km', 'packages_desc', 'packages_desc_km', 'sections', 'features_title', 'features_title_km', 'features_desc', 'features_desc_km') as $field) {
                    if (isset($existing[$field])) $card_data[$field] = $existing[$field];
                }
            }
            $processed_cards[] = $card_data;
        }
        update_option('custom_service_cards', wp_json_encode($processed_cards));
        futuristic_it_toast('Service cards saved!');
    }
    $services = json_decode(get_option('custom_service_cards', '[]'), true);
    if (!is_array($services)) $services = array();
    ?>
    <div class="wrap">
        <h1><?php _e('Services – Service Cards', 'futuristic-it'); ?></h1>
        <p><a href="<?php echo admin_url('admin.php?page=futuristict-services'); ?>">&larr; Back</a></p>
        <form method="post" action="">
            <?php wp_nonce_field('futuristic_it_svc_cards'); ?>
            <table class="form-table">
                <tr><th><label>Tagline</label></th><td><input type="text" class="regular-text" name="custom_services_cards_tagline" value="<?php echo esc_attr(get_option('custom_services_cards_tagline', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Tagline (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_services_cards_tagline_km" value="<?php echo esc_attr(get_option('custom_services_cards_tagline_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>Title</label></th><td><input type="text" class="regular-text" name="custom_services_cards_title" value="<?php echo esc_attr(get_option('custom_services_cards_title', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Title (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_services_cards_title_km" value="<?php echo esc_attr(get_option('custom_services_cards_title_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>Description</label></th><td><textarea class="large-text" name="custom_services_cards_desc" rows="3"><?php echo esc_textarea(get_option('custom_services_cards_desc', '')); ?></textarea></td></tr>
                <tr><th><label style="color:#b8892f;">Description (Khmer)</label></th><td><textarea class="large-text" name="custom_services_cards_desc_km" rows="3" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea(get_option('custom_services_cards_desc_km', '')); ?></textarea></td></tr>
            </table>
            <h2><?php _e('Service Cards', 'futuristic-it'); ?></h2>
            <?php foreach ($services as $i => $s) :
                $features = $s['features'] ?? array();
                if (empty($features)) $features = array(array('title' => '', 'desc' => ''));
            ?>
            <div class="svc-card-box" data-saved="1" style="background:#fff;border:1px solid #ddd;border-radius:8px;padding:20px;margin-bottom:16px;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                    <h3 style="margin:0;">Card <?php echo $i + 1; ?></h3>
                    <button type="button" class="button button-small del-card" style="color:#dc3545;">Delete Card</button>
                </div>
                <table class="form-table" style="margin:0;">
                    <tr><th><label>Image</label></th><td>
                        <input type="hidden" name="custom_service_cards[<?php echo $i; ?>][image]" value="<?php echo esc_attr($s['image'] ?? ''); ?>">
                        <?php if (!empty($s['image'])) : ?><img src="<?php echo esc_url($s['image']); ?>" style="width:50px;height:50px;object-fit:contain;border-radius:4px;background:#fff;padding:2px;margin-bottom:5px;display:block;"><?php endif; ?>
                        <button type="button" class="button button-small upload-btn" data-for="custom_service_cards[<?php echo $i; ?>][image]">Upload Image</button>
                    </td></tr>
                    <tr><th><label>Title</label></th><td><input type="text" class="regular-text" name="custom_service_cards[<?php echo $i; ?>][title]" value="<?php echo esc_attr($s['title'] ?? ''); ?>" style="width:100%;"></td></tr>
                    <tr><th><label style="color:#b8892f;">Title (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_service_cards[<?php echo $i; ?>][title_km]" value="<?php echo esc_attr($s['title_km'] ?? ''); ?>" style="width:100%;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                    <tr><th><label>Description</label></th><td><textarea class="large-text" name="custom_service_cards[<?php echo $i; ?>][desc]" rows="3" style="width:100%;"><?php echo esc_textarea($s['desc'] ?? ''); ?></textarea></td></tr>
                    <tr><th><label style="color:#b8892f;">Description (Khmer)</label></th><td><textarea class="large-text" name="custom_service_cards[<?php echo $i; ?>][desc_km]" rows="3" style="width:100%;font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea($s['desc_km'] ?? ''); ?></textarea></td></tr>
                    <tr><th><label>Type</label></th><td>
                        <select name="custom_service_cards[<?php echo $i; ?>][type]" style="width:100%;max-width:300px;">
                            <option value="Detail" <?php selected($s['type'] ?? 'Detail', 'Detail'); ?>>Detail</option>
                            <option value="Contact" <?php selected($s['type'] ?? '', 'Contact'); ?>>Contact</option>
                            <option value="Course" <?php selected($s['type'] ?? '', 'Course'); ?>>Course</option>
                        </select>
                        <p style="color:#888;margin:6px 0 0;font-size:12px;"><?php _e('Contact cards show a gold button and link straight to the Link URL instead of the service detail page.', 'futuristic-it'); ?></p>
                    </td></tr>
                </table>
                <h4 style="margin:16px 0 8px;"><?php _e('Features', 'futuristic-it'); ?></h4>
                <div class="svc-features-container" id="svc-features-<?php echo $i; ?>">
                    <?php foreach ($features as $fi => $feat) :
                        $feat_title = is_array($feat) ? ($feat['title'] ?? $feat['text'] ?? '') : $feat;
                        $feat_desc = is_array($feat) ? ($feat['desc'] ?? '') : '';
                    ?>
                    <div class="svc-feature-row" style="display:flex;align-items:center;gap:12px;margin-bottom:8px;padding:10px;background:#f9f9f9;border-radius:6px;">
                        <input type="text" name="custom_service_cards[<?php echo $i; ?>][features][<?php echo $fi; ?>][title]" value="<?php echo esc_attr($feat_title); ?>" placeholder="Feature title" style="flex:1;">
                        <input type="text" name="custom_service_cards[<?php echo $i; ?>][features][<?php echo $fi; ?>][title_km]" value="<?php echo esc_attr($feat['title_km'] ?? ''); ?>" placeholder="Feature title (Khmer)" style="flex:1;font-family:'Noto Sans Khmer',sans-serif;">
                        <button type="button" class="button button-small" style="color:#dc3545;" onclick="this.closest('.svc-feature-row').remove();">Remove</button>
                    </div>
                    <?php endforeach; ?>
                </div>
                <p><button type="button" class="button button-small add-svc-feature" data-card="<?php echo $i; ?>">+ Add Feature</button></p>
                <table class="form-table" style="margin:0;">
                    <tr><th><label>Link URL</label></th><td><input type="text" class="regular-text" name="custom_service_cards[<?php echo $i; ?>][link]" value="<?php echo esc_attr($s['link'] ?? ''); ?>" style="width:100%;"></td></tr>
                    <tr><th><label>Link Text</label></th><td><input type="text" class="regular-text" name="custom_service_cards[<?php echo $i; ?>][link_text]" value="<?php echo esc_attr($s['link_text'] ?? 'Learn More'); ?>" style="width:100%;" placeholder="Learn More"></td></tr>
                    <tr><th><label style="color:#b8892f;">Link Text (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_service_cards[<?php echo $i; ?>][link_text_km]" value="<?php echo esc_attr($s['link_text_km'] ?? ''); ?>" style="width:100%;font-family:'Noto Sans Khmer',sans-serif;" placeholder="ស្វែងយល់បន្ថែម"></td></tr>
                </table>
            </div>
            <?php endforeach; ?>
            <p><button type="button" class="button" id="add-card">+ Add Service Card</button></p>
            <br><input type="submit" name="futuristic_it_save_svc_cards" class="button button-primary" value="Save Service Cards">
        </form>
        <script>
        document.querySelectorAll('.add-svc-feature').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var cardIdx = this.getAttribute('data-card');
                var container = document.getElementById('svc-features-' + cardIdx);
                var featIdx = container.querySelectorAll('.svc-feature-row').length;
                var prefix = 'custom_service_cards[' + cardIdx + '][features][' + featIdx + ']';
                var html = '<div class="svc-feature-row" style="display:flex;align-items:center;gap:12px;margin-bottom:8px;padding:10px;background:#f9f9f9;border-radius:6px;">' +
                    '<input type="text" name="' + prefix + '[title]" value="" placeholder="Feature title" style="flex:1;">' +
                    '<input type="text" name="' + prefix + '[title_km]" value="" placeholder="Feature title (Khmer)" style="flex:1;font-family:\'Noto Sans Khmer\',sans-serif;">' +
                    '<button type="button" class="button button-small" style="color:#dc3545;" onclick="this.closest(\'.svc-feature-row\').remove();">Remove</button>' +
                    '</div>';
                container.insertAdjacentHTML('beforeend', html);
            });
        });
        </script>
    </div>
    <?php
}

// Services Stats Page
function futuristict_services_stats_page() {
    if (isset($_POST['futuristic_it_save_svc_stats']) && check_admin_referer('futuristic_it_svc_stats')) {
        $fields = array('custom_services_stability_tagline', 'custom_services_stability_title', 'custom_services_badge_label');
        foreach ($fields as $f) {
            if (isset($_POST[$f])) update_option($f, sanitize_text_field($_POST[$f]));
            if (isset($_POST[$f . '_km'])) update_option($f . '_km', sanitize_text_field($_POST[$f . '_km']));
        }
        update_option('custom_services_stability_image', sanitize_text_field($_POST['custom_services_stability_image']));
        update_option('custom_services_badge_value', sanitize_text_field($_POST['custom_services_badge_value']));
        if (isset($_POST['custom_services_stats'])) {
            $stats = $_POST['custom_services_stats'];
            foreach ($stats as &$st) {
                if (isset($st['label_km'])) $st['label_km'] = sanitize_text_field($st['label_km']);
                if (isset($st['desc_km'])) $st['desc_km'] = sanitize_textarea_field($st['desc_km']);
            }
            unset($st);
            update_option('custom_services_stats', sanitize_text_field(wp_json_encode($stats)));
        } else {
            update_option('custom_services_stats', '[]');
        }
        futuristic_it_toast('Stats saved!');
    }
    $stats = json_decode(get_option('custom_services_stats', '[]'), true);
    if (!is_array($stats)) $stats = array();
    ?>
    <div class="wrap">
        <h1><?php _e('Services – Stats Section', 'futuristic-it'); ?></h1>
        <p><a href="<?php echo admin_url('admin.php?page=futuristict-services'); ?>">&larr; Back</a></p>
        <form method="post" action="">
            <?php wp_nonce_field('futuristic_it_svc_stats'); ?>
            <table class="form-table">
                <tr><th><label>Tagline</label></th><td><input type="text" class="regular-text" name="custom_services_stability_tagline" value="<?php echo esc_attr(get_option('custom_services_stability_tagline', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Tagline (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_services_stability_tagline_km" value="<?php echo esc_attr(get_option('custom_services_stability_tagline_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>Title</label></th><td><textarea class="large-text" name="custom_services_stability_title" rows="2"><?php echo esc_textarea(get_option('custom_services_stability_title', '')); ?></textarea></td></tr>
                <tr><th><label style="color:#b8892f;">Title (Khmer)</label></th><td><textarea class="large-text" name="custom_services_stability_title_km" rows="2" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea(get_option('custom_services_stability_title_km', '')); ?></textarea></td></tr>
                <tr><th><label>Team Image</label></th><td>
                    <input type="hidden" name="custom_services_stability_image" value="<?php echo esc_attr(get_option('custom_services_stability_image', '')); ?>">
                    <?php $img = get_option('custom_services_stability_image', ''); if (!empty($img)) : ?><img src="<?php echo esc_url($img); ?>" style="max-height:100px;margin-bottom:10px;display:block;"><br><?php endif; ?>
                    <button type="button" class="button upload-btn" data-for="custom_services_stability_image">Upload Image</button>
                </td></tr>
                <tr><th><label>Badge Value</label></th><td><input type="text" class="regular-text" name="custom_services_badge_value" value="<?php echo esc_attr(get_option('custom_services_badge_value', '')); ?>" placeholder="200+"></td></tr>
                <tr><th><label>Badge Label</label></th><td><input type="text" class="regular-text" name="custom_services_badge_label" value="<?php echo esc_attr(get_option('custom_services_badge_label', '')); ?>" placeholder="SYSTEMS DEPLOYED"></td></tr>
                <tr><th><label style="color:#b8892f;">Badge Label (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_services_badge_label_km" value="<?php echo esc_attr(get_option('custom_services_badge_label_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
            </table>
            <h2><?php _e('Stats', 'futuristic-it'); ?></h2>
            <table class="widefat striped" id="stats-table">
                <thead><tr><th style="width:80px">Image</th><th>Label</th><th>Label (Khmer)</th><th>Description</th><th>Description (Khmer)</th><th style="width:60px"></th></tr></thead>
                <tbody>
                <?php foreach ($stats as $i => $st) : ?>
                    <tr data-saved="1">
                        <td><input type="hidden" name="custom_services_stats[<?php echo $i; ?>][icon]" value="<?php echo esc_attr($st['icon'] ?? ''); ?>"><?php if (!empty($st['icon'])) : ?><img src="<?php echo esc_url($st['icon']); ?>" style="width:40px;height:40px;object-fit:contain;border-radius:4px;background:#fff;padding:2px;"><?php endif; ?><br><a href="#" class="button button-small upload-btn" data-for="custom_services_stats[<?php echo $i; ?>][icon]">Upload</a></td>
                        <td><input type="text" name="custom_services_stats[<?php echo $i; ?>][label]" value="<?php echo esc_attr($st['label'] ?? ''); ?>" class="widefat"></td>
                        <td><input type="text" name="custom_services_stats[<?php echo $i; ?>][label_km]" value="<?php echo esc_attr($st['label_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;"></td>
                        <td><textarea name="custom_services_stats[<?php echo $i; ?>][desc]" class="widefat" rows="2"><?php echo esc_textarea($st['desc'] ?? ''); ?></textarea></td>
                        <td><textarea name="custom_services_stats[<?php echo $i; ?>][desc_km]" class="widefat" rows="2" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea($st['desc_km'] ?? ''); ?></textarea></td>
                        <td><button type="button" class="button button-small del-row" style="color:#dc3545;">Delete</button></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <p><button type="button" class="button" id="add-stat">+ Add Stat</button></p>
            <br><input type="submit" name="futuristic_it_save_svc_stats" class="button button-primary" value="Save Stats">
        </form>
    </div>
    <?php
}

// Services CTA Page
function futuristict_services_cta_page() {
    if (isset($_POST['futuristic_it_save_svc_cta']) && check_admin_referer('futuristic_it_svc_cta')) {
        $fields = array('custom_services_cta_title', 'custom_services_cta_desc', 'custom_services_cta_btn_text', 'custom_services_cta_btn_link');
        foreach ($fields as $f) {
            if (isset($_POST[$f])) update_option($f, sanitize_text_field($_POST[$f]));
            if (isset($_POST[$f . '_km'])) update_option($f . '_km', sanitize_text_field($_POST[$f . '_km']));
        }
        futuristic_it_toast('CTA saved!');
    }
    ?>
    <div class="wrap">
        <h1><?php _e('Services – CTA Section', 'futuristic-it'); ?></h1>
        <p><a href="<?php echo admin_url('admin.php?page=futuristict-services'); ?>">&larr; Back</a></p>
        <form method="post" action="">
            <?php wp_nonce_field('futuristic_it_svc_cta'); ?>
            <table class="form-table">
                <tr><th><label>Title</label></th><td><input type="text" class="regular-text" name="custom_services_cta_title" value="<?php echo esc_attr(get_option('custom_services_cta_title', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Title (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_services_cta_title_km" value="<?php echo esc_attr(get_option('custom_services_cta_title_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>Description</label></th><td><textarea class="large-text" name="custom_services_cta_desc" rows="2"><?php echo esc_textarea(get_option('custom_services_cta_desc', '')); ?></textarea></td></tr>
                <tr><th><label style="color:#b8892f;">Description (Khmer)</label></th><td><textarea class="large-text" name="custom_services_cta_desc_km" rows="2" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea(get_option('custom_services_cta_desc_km', '')); ?></textarea></td></tr>
                <tr><th><label>Button Text</label></th><td><input type="text" class="regular-text" name="custom_services_cta_btn_text" value="<?php echo esc_attr(get_option('custom_services_cta_btn_text', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Button Text (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_services_cta_btn_text_km" value="<?php echo esc_attr(get_option('custom_services_cta_btn_text_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>Button Link</label></th><td><input type="text" class="regular-text" name="custom_services_cta_btn_link" value="<?php echo esc_attr(get_option('custom_services_cta_btn_link', '')); ?>"></td></tr>
            </table>
            <input type="submit" name="futuristic_it_save_svc_cta" class="button button-primary" value="Save CTA">
        </form>
    </div>
    <?php
}

// Contact Page
function futuristict_contact_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('Contact Us', 'futuristic-it'); ?></h1>
        <p style="color:#666;margin-bottom:20px;"><?php _e('Select a section to edit:', 'futuristic-it'); ?></p>
        <div class="fw-cards">
            <a href="<?php echo admin_url('admin.php?page=futuristict-contact-hero'); ?>" class="fw-card">
                <h3><?php _e('Hero Section', 'futuristic-it'); ?></h3>
                <p><?php _e('Edit hero title, subtitle and info cards.', 'futuristic-it'); ?></p>
            </a>
            <a href="<?php echo admin_url('admin.php?page=futuristict-contact-details'); ?>" class="fw-card">
                <h3><?php _e('Contact Details', 'futuristic-it'); ?></h3>
                <p><?php _e('Edit heading, lead text, phone, email and form.', 'futuristic-it'); ?></p>
            </a>
            <a href="<?php echo admin_url('admin.php?page=futuristict-contact-map'); ?>" class="fw-card">
                <h3><?php _e('Map Location', 'futuristic-it'); ?></h3>
                <p><?php _e('Edit latitude and longitude for Google Maps.', 'futuristic-it'); ?></p>
            </a>
            <a href="<?php echo admin_url('admin.php?page=futuristict-contact-faq'); ?>" class="fw-card">
                <h3><?php _e('FAQ Section', 'futuristic-it'); ?></h3>
                <p><?php _e('Edit FAQ title, subtitle and support link.', 'futuristic-it'); ?></p>
            </a>
            <a href="<?php echo admin_url('admin.php?page=futuristict-contact-form'); ?>" class="fw-card">
                <h3><?php _e('Form Fields', 'futuristic-it'); ?></h3>
                <p><?php _e('Edit form field labels and button text.', 'futuristic-it'); ?></p>
            </a>
        </div>
    </div>
    <?php
}

// Footer Page
// Contact Hero Page
function futuristict_contact_hero_page() {
    if (isset($_POST['futuristic_it_save_contact_hero']) && check_admin_referer('futuristic_it_contact_hero')) {
        update_option('custom_contact_tagline', sanitize_text_field($_POST['custom_contact_tagline']));
        update_option('custom_contact_title', sanitize_text_field($_POST['custom_contact_title']));
        update_option('custom_contact_subtitle', sanitize_text_field($_POST['custom_contact_subtitle']));
        if (isset($_POST['custom_contact_tagline_km'])) update_option('custom_contact_tagline_km', sanitize_text_field($_POST['custom_contact_tagline_km']));
        if (isset($_POST['custom_contact_title_km'])) update_option('custom_contact_title_km', sanitize_text_field($_POST['custom_contact_title_km']));
        if (isset($_POST['custom_contact_subtitle_km'])) update_option('custom_contact_subtitle_km', sanitize_text_field($_POST['custom_contact_subtitle_km']));
        futuristic_it_toast('Hero saved!');
    }
    ?>
    <div class="wrap">
        <h1><?php _e('Contact – Hero Section', 'futuristic-it'); ?></h1>
        <p><a href="<?php echo admin_url('admin.php?page=futuristict-contact'); ?>">&larr; Back</a></p>
        <form method="post" action="">
            <?php wp_nonce_field('futuristic_it_contact_hero'); ?>
            <table class="form-table">
                <tr><th><label>Tagline (English)</label></th><td><input type="text" class="regular-text" name="custom_contact_tagline" value="<?php echo esc_attr(get_option('custom_contact_tagline', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Tagline (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_contact_tagline_km" value="<?php echo esc_attr(get_option('custom_contact_tagline_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>Title (English)</label></th><td><input type="text" class="regular-text" name="custom_contact_title" value="<?php echo esc_attr(get_option('custom_contact_title', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Title (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_contact_title_km" value="<?php echo esc_attr(get_option('custom_contact_title_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>Subtitle (English)</label></th><td><textarea class="large-text" name="custom_contact_subtitle" rows="3"><?php echo esc_textarea(get_option('custom_contact_subtitle', '')); ?></textarea></td></tr>
                <tr><th><label style="color:#b8892f;">Subtitle (Khmer)</label></th><td><textarea class="large-text" name="custom_contact_subtitle_km" rows="3" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea(get_option('custom_contact_subtitle_km', '')); ?></textarea></td></tr>
            </table>
            <input type="submit" name="futuristic_it_save_contact_hero" class="button button-primary" value="Save All">
        </form>
    </div>
    <?php
}

// Contact Info Cards Page
// Contact Details Page
function futuristict_contact_details_page() {
    if (isset($_POST['futuristic_it_save_contact_details']) && check_admin_referer('futuristic_it_contact_details')) {
        $fields = array('custom_contact_heading', 'custom_contact_lead', 'custom_contact_phone', 'custom_contact_email', 'custom_contact_form_email');
        foreach ($fields as $f) {
            if (isset($_POST[$f])) update_option($f, sanitize_text_field($_POST[$f]));
            if (isset($_POST[$f . '_km'])) update_option($f . '_km', sanitize_text_field($_POST[$f . '_km']));
        }
        futuristic_it_toast('Contact Details saved!');
    }
    ?>
    <div class="wrap">
        <h1><?php _e('Contact – Contact Details', 'futuristic-it'); ?></h1>
        <p><a href="<?php echo admin_url('admin.php?page=futuristict-contact'); ?>">&larr; Back</a></p>
        <form method="post" action="">
            <?php wp_nonce_field('futuristic_it_contact_details'); ?>
            <table class="form-table">
                <tr><th><label>Heading</label></th><td><input type="text" class="regular-text" name="custom_contact_heading" value="<?php echo esc_attr(get_option('custom_contact_heading', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Heading (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_contact_heading_km" value="<?php echo esc_attr(get_option('custom_contact_heading_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>Lead Text</label></th><td><textarea class="large-text" name="custom_contact_lead" rows="3"><?php echo esc_textarea(get_option('custom_contact_lead', '')); ?></textarea></td></tr>
                <tr><th><label style="color:#b8892f;">Lead Text (Khmer)</label></th><td><textarea class="large-text" name="custom_contact_lead_km" rows="3" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea(get_option('custom_contact_lead_km', '')); ?></textarea></td></tr>
                <tr><th><label>Phone</label></th><td><input type="text" class="regular-text" name="custom_contact_phone" value="<?php echo esc_attr(get_option('custom_contact_phone', '')); ?>"></td></tr>
                <tr><th><label>Email</label></th><td><input type="text" class="regular-text" name="custom_contact_email" value="<?php echo esc_attr(get_option('custom_contact_email', '')); ?>"></td></tr>
                <tr><th><label>Form Recipient Email</label></th><td><input type="email" class="regular-text" name="custom_contact_form_email" value="<?php echo esc_attr(get_option('custom_contact_form_email', 'suontii2023@gmail.com')); ?>" placeholder="suontii2023@gmail.com"><p class="description">Email address where contact form submissions will be sent.</p></td></tr>
            </table>
            <input type="submit" name="futuristic_it_save_contact_details" class="button button-primary" value="Save Contact Details">
        </form>
    </div>
    <?php
}

// Contact Map Location Page
function futuristict_contact_map_location_page() {
    if (isset($_POST['futuristic_it_save_contact_map']) && check_admin_referer('futuristic_it_contact_map')) {
        if (isset($_POST['custom_contact_lat'])) update_option('custom_contact_lat', sanitize_text_field($_POST['custom_contact_lat']));
        if (isset($_POST['custom_contact_lng'])) update_option('custom_contact_lng', sanitize_text_field($_POST['custom_contact_lng']));
        futuristic_it_toast('Map Location saved!');
    }
    ?>
    <div class="wrap">
        <h1><?php _e('Contact – Map Location', 'futuristic-it'); ?></h1>
        <p><a href="<?php echo admin_url('admin.php?page=futuristict-contact'); ?>">&larr; Back</a></p>
        <form method="post" action="">
            <?php wp_nonce_field('futuristic_it_contact_map'); ?>
            <table class="form-table">
                <tr><th><label>Map Latitude</label></th><td><input type="text" class="regular-text" name="custom_contact_lat" value="<?php echo esc_attr(get_option('custom_contact_lat', '')); ?>" placeholder="11.5564"><p class="description">Google Maps latitude coordinate (e.g. 11.5564 for Phnom Penh).</p></td></tr>
                <tr><th><label>Map Longitude</label></th><td><input type="text" class="regular-text" name="custom_contact_lng" value="<?php echo esc_attr(get_option('custom_contact_lng', '')); ?>" placeholder="104.9282"><p class="description">Google Maps longitude coordinate (e.g. 104.9282 for Phnom Penh).</p></td></tr>
            </table>
            <input type="submit" name="futuristic_it_save_contact_map" class="button button-primary" value="Save Map Location">
        </form>
    </div>
    <?php
}

// Contact FAQ Page
function futuristict_contact_faq_page() {
    if (isset($_POST['futuristic_it_save_contact_faq']) && check_admin_referer('futuristic_it_contact_faq')) {
        $fields = array('custom_faq_title', 'custom_faq_subtitle', 'custom_contact_support_link', 'custom_contact_support_text');
        foreach ($fields as $f) {
            if (isset($_POST[$f])) update_option($f, sanitize_text_field($_POST[$f]));
            if (isset($_POST[$f . '_km'])) update_option($f . '_km', sanitize_text_field($_POST[$f . '_km']));
        }
        // Save FAQ items
        if (isset($_POST['contact_faqs']) && is_array($_POST['contact_faqs'])) {
            $sanitized = array();
            foreach ($_POST['contact_faqs'] as $faq) {
                $q = sanitize_text_field($faq['q'] ?? '');
                $a = sanitize_textarea_field($faq['a'] ?? '');
                $q_km = sanitize_text_field($faq['q_km'] ?? '');
                $a_km = sanitize_textarea_field($faq['a_km'] ?? '');
                if (!empty($q) || !empty($a)) {
                    $sanitized[] = array('q' => $q, 'a' => $a, 'q_km' => $q_km, 'a_km' => $a_km);
                }
            }
            update_option('custom_contact_faqs', wp_json_encode($sanitized));
        }
        futuristic_it_toast('FAQ saved!');
    }
    $faqs = json_decode(get_option('custom_contact_faqs', '[]'), true);
    if (!is_array($faqs)) $faqs = array();
    ?>
    <div class="wrap">
        <h1><?php _e('Contact – FAQ Section', 'futuristic-it'); ?></h1>
        <p><a href="<?php echo admin_url('admin.php?page=futuristict-contact'); ?>">&larr; Back</a></p>
        <form method="post" action="">
            <?php wp_nonce_field('futuristic_it_contact_faq'); ?>
            <table class="form-table">
                <tr><th><label>FAQ Title</label></th><td><input type="text" class="regular-text" name="custom_faq_title" value="<?php echo esc_attr(get_option('custom_faq_title', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">FAQ Title (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_faq_title_km" value="<?php echo esc_attr(get_option('custom_faq_title_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>FAQ Subtitle</label></th><td><textarea class="large-text" name="custom_faq_subtitle" rows="2"><?php echo esc_textarea(get_option('custom_faq_subtitle', '')); ?></textarea></td></tr>
                <tr><th><label style="color:#b8892f;">FAQ Subtitle (Khmer)</label></th><td><textarea class="large-text" name="custom_faq_subtitle_km" rows="2" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea(get_option('custom_faq_subtitle_km', '')); ?></textarea></td></tr>
                <tr><th><label>Support Link URL</label></th><td><input type="text" class="regular-text" name="custom_contact_support_link" value="<?php echo esc_attr(get_option('custom_contact_support_link', '')); ?>"></td></tr>
                <tr><th><label>Support Link Text</label></th><td><input type="text" class="regular-text" name="custom_contact_support_text" value="<?php echo esc_attr(get_option('custom_contact_support_text', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Support Link Text (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_contact_support_text_km" value="<?php echo esc_attr(get_option('custom_contact_support_text_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
            </table>
            <h2><?php _e('FAQ Items', 'futuristic-it'); ?></h2>
            <table class="widefat striped" id="contact-faq-table">
                <thead><tr><th>Question</th><th>Question (Khmer)</th><th>Answer</th><th>Answer (Khmer)</th><th style="width:60px"></th></tr></thead>
                <tbody>
                <?php foreach ($faqs as $i => $faq) : ?>
                    <tr data-saved="1">
                        <td><input type="text" name="contact_faqs[<?php echo $i; ?>][q]" value="<?php echo esc_attr($faq['q'] ?? ''); ?>" class="widefat"></td>
                        <td><input type="text" name="contact_faqs[<?php echo $i; ?>][q_km]" value="<?php echo esc_attr($faq['q_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;"></td>
                        <td><textarea name="contact_faqs[<?php echo $i; ?>][a]" class="widefat" rows="2"><?php echo esc_textarea($faq['a'] ?? ''); ?></textarea></td>
                        <td><textarea name="contact_faqs[<?php echo $i; ?>][a_km]" class="widefat" rows="2" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea($faq['a_km'] ?? ''); ?></textarea></td>
                        <td><button type="button" class="button button-small del-row" style="color:#dc3545;">Delete</button></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <p><button type="button" class="button" onclick="addContactFaq();">+ Add FAQ</button></p>
            <input type="submit" name="futuristic_it_save_contact_faq" class="button button-primary" value="Save FAQ">
        </form>
        <script>
        var contactFaqCount = <?php echo count($faqs); ?>;
        function addContactFaq() {
            var idx = contactFaqCount;
            var html = '<tr>' +
                '<td><input type="text" name="contact_faqs[' + idx + '][q]" value="" class="widefat"></td>' +
                '<td><input type="text" name="contact_faqs[' + idx + '][q_km]" value="" class="widefat" style="font-family:\'Noto Sans Khmer\',sans-serif;"></td>' +
                '<td><textarea name="contact_faqs[' + idx + '][a]" class="widefat" rows="2"></textarea></td>' +
                '<td><textarea name="contact_faqs[' + idx + '][a_km]" class="widefat" rows="2" style="font-family:\'Noto Sans Khmer\',sans-serif;"></textarea></td>' +
                '<td><button type="button" class="button button-small del-row" style="color:#dc3545;">Delete</button></td>' +
                '</tr>';
            document.querySelector('#contact-faq-table tbody').insertAdjacentHTML('beforeend', html);
            contactFaqCount++;
        }
        </script>
    </div>
    <?php
}

// Contact Form Fields Page
function futuristict_contact_form_page() {
    if (isset($_POST['futuristic_it_save_contact_form']) && check_admin_referer('futuristic_it_contact_form')) {
        $fields = array('fullname', 'phone', 'email', 'service', 'date', 'course_name', 'location', 'mode', 'register', 'message', 'submit');
        foreach ($fields as $f) {
            if (isset($_POST['contact_form_' . $f])) update_option('contact_form_' . $f, sanitize_text_field($_POST['contact_form_' . $f]));
            if (isset($_POST['contact_form_' . $f . '_km'])) update_option('contact_form_' . $f . '_km', sanitize_text_field($_POST['contact_form_' . $f . '_km']));
        }
        // These choices are plain label options, not a fixed pair of hardcoded
        // words, so they are saved independently of the checkboxes themselves.
        $mode_options = array('online', 'inperson', 'group', 'single');
        foreach ($mode_options as $mo) {
            if (isset($_POST['contact_option_' . $mo])) update_option('contact_option_' . $mo, sanitize_text_field($_POST['contact_option_' . $mo]));
            if (isset($_POST['contact_option_' . $mo . '_km'])) update_option('contact_option_' . $mo . '_km', sanitize_text_field($_POST['contact_option_' . $mo . '_km']));
        }
        $placeholders = array('fullname', 'phone', 'email', 'location', 'message');
        foreach ($placeholders as $p) {
            if (isset($_POST['contact_placeholder_' . $p])) update_option('contact_placeholder_' . $p, sanitize_text_field($_POST['contact_placeholder_' . $p]));
            if (isset($_POST['contact_placeholder_' . $p . '_km'])) update_option('contact_placeholder_' . $p . '_km', sanitize_text_field($_POST['contact_placeholder_' . $p . '_km']));
        }
        futuristic_it_toast('Form Fields saved!');
    }
    ?>
    <div class="wrap">
        <h1><?php _e('Contact – Form Fields', 'futuristic-it'); ?></h1>
        <p><a href="<?php echo admin_url('admin.php?page=futuristict-contact'); ?>">&larr; Back</a></p>
        <form method="post" action="">
            <?php wp_nonce_field('futuristic_it_contact_form'); ?>
            <div style="background:#fff;padding:24px;border:1px solid #ccc;border-radius:8px;margin-bottom:24px;">
                <h3 style="margin:0 0 16px;"><?php _e('Form Field Labels', 'futuristic-it'); ?></h3>
                <table class="form-table">
                    <tr><th><label><?php _e('Full Name (English)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_form_fullname" value="<?php echo esc_attr(get_option('contact_form_fullname', 'Full Name')); ?>" style="width:300px;"></td></tr>
                    <tr><th><label style="color:#b8892f;"><?php _e('Full Name (Khmer)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_form_fullname_km" value="<?php echo esc_attr(get_option('contact_form_fullname_km', '')); ?>" style="width:300px;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                    <tr><th><label><?php _e('Phone Number (English)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_form_phone" value="<?php echo esc_attr(get_option('contact_form_phone', 'Phone Number')); ?>" style="width:300px;"></td></tr>
                    <tr><th><label style="color:#b8892f;"><?php _e('Phone Number (Khmer)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_form_phone_km" value="<?php echo esc_attr(get_option('contact_form_phone_km', '')); ?>" style="width:300px;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                    <tr><th><label><?php _e('Email (English)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_form_email" value="<?php echo esc_attr(get_option('contact_form_email', 'Email')); ?>" style="width:300px;"></td></tr>
                    <tr><th><label style="color:#b8892f;"><?php _e('Email (Khmer)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_form_email_km" value="<?php echo esc_attr(get_option('contact_form_email_km', '')); ?>" style="width:300px;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                    <tr><th><label><?php _e('Service Interest (English)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_form_service" value="<?php echo esc_attr(get_option('contact_form_service', 'Service Interest')); ?>" style="width:300px;"></td></tr>
                    <tr><th><label style="color:#b8892f;"><?php _e('Service Interest (Khmer)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_form_service_km" value="<?php echo esc_attr(get_option('contact_form_service_km', '')); ?>" style="width:300px;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                    <tr><th><label><?php _e('Date (English)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_form_date" value="<?php echo esc_attr(get_option('contact_form_date', 'Date')); ?>" style="width:300px;"></td></tr>
                    <tr><th><label style="color:#b8892f;"><?php _e('Date (Khmer)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_form_date_km" value="<?php echo esc_attr(get_option('contact_form_date_km', '')); ?>" style="width:300px;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                    <tr><th><label><?php _e('Course Name (English)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_form_course_name" value="<?php echo esc_attr(get_option('contact_form_course_name', 'Course Name')); ?>" style="width:300px;"></td></tr>
                    <tr><th><label style="color:#b8892f;"><?php _e('Course Name (Khmer)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_form_course_name_km" value="<?php echo esc_attr(get_option('contact_form_course_name_km', '')); ?>" style="width:300px;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                    <tr><th><label><?php _e('Location (English)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_form_location" value="<?php echo esc_attr(get_option('contact_form_location', 'Location')); ?>" style="width:300px;"><p class="description"><?php _e('Shown under Course Name when Short Course Training is selected.', 'futuristic-it'); ?></p></td></tr>
                    <tr><th><label style="color:#b8892f;"><?php _e('Location (Khmer)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_form_location_km" value="<?php echo esc_attr(get_option('contact_form_location_km', '')); ?>" style="width:300px;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                    <tr><th><label><?php _e('Mode Label (English)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_form_mode" value="<?php echo esc_attr(get_option('contact_form_mode', 'Mode')); ?>" style="width:300px;"><p class="description"><?php _e('Heading above the Online / Home checkboxes.', 'futuristic-it'); ?></p></td></tr>
                    <tr><th><label style="color:#b8892f;"><?php _e('Mode Label (Khmer)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_form_mode_km" value="<?php echo esc_attr(get_option('contact_form_mode_km', '')); ?>" style="width:300px;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                    <tr><th><label><?php _e('Online Option (English)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_option_online" value="<?php echo esc_attr(get_option('contact_option_online', 'Online')); ?>" style="width:300px;"></td></tr>
                    <tr><th><label style="color:#b8892f;"><?php _e('Online Option (Khmer)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_option_online_km" value="<?php echo esc_attr(get_option('contact_option_online_km', '')); ?>" style="width:300px;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                    <tr><th><label><?php _e('In-Person Learning Option (English)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_option_inperson" value="<?php echo esc_attr(get_option('contact_option_inperson', 'In-Person Learning')); ?>" style="width:300px;"></td></tr>
                    <tr><th><label style="color:#b8892f;"><?php _e('In-Person Learning Option (Khmer)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_option_inperson_km" value="<?php echo esc_attr(get_option('contact_option_inperson_km', '')); ?>" style="width:300px;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                    <tr><th><label><?php _e('Register Label (English)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_form_register" value="<?php echo esc_attr(get_option('contact_form_register', 'Register as')); ?>" style="width:300px;"><p class="description"><?php _e('Heading above the Group / Single checkboxes.', 'futuristic-it'); ?></p></td></tr>
                    <tr><th><label style="color:#b8892f;"><?php _e('Register Label (Khmer)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_form_register_km" value="<?php echo esc_attr(get_option('contact_form_register_km', '')); ?>" style="width:300px;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                    <tr><th><label><?php _e('Group Option (English)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_option_group" value="<?php echo esc_attr(get_option('contact_option_group', 'Group')); ?>" style="width:300px;"></td></tr>
                    <tr><th><label style="color:#b8892f;"><?php _e('Group Option (Khmer)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_option_group_km" value="<?php echo esc_attr(get_option('contact_option_group_km', '')); ?>" style="width:300px;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                    <tr><th><label><?php _e('Single Option (English)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_option_single" value="<?php echo esc_attr(get_option('contact_option_single', 'Single')); ?>" style="width:300px;"></td></tr>
                    <tr><th><label style="color:#b8892f;"><?php _e('Single Option (Khmer)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_option_single_km" value="<?php echo esc_attr(get_option('contact_option_single_km', '')); ?>" style="width:300px;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                    <tr><th><label><?php _e('Message (English)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_form_message" value="<?php echo esc_attr(get_option('contact_form_message', 'Message')); ?>" style="width:300px;"></td></tr>
                    <tr><th><label style="color:#b8892f;"><?php _e('Message (Khmer)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_form_message_km" value="<?php echo esc_attr(get_option('contact_form_message_km', '')); ?>" style="width:300px;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                    <tr><th><label><?php _e('Submit Button (English)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_form_submit" value="<?php echo esc_attr(get_option('contact_form_submit', 'Submit')); ?>" style="width:300px;"></td></tr>
                    <tr><th><label style="color:#b8892f;"><?php _e('Submit Button (Khmer)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_form_submit_km" value="<?php echo esc_attr(get_option('contact_form_submit_km', '')); ?>" style="width:300px;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                </table>
            </div>
            <div style="background:#fff;padding:24px;border:1px solid #ccc;border-radius:8px;margin-bottom:24px;">
                <h3 style="margin:0 0 16px;"><?php _e('Form Field Placeholders', 'futuristic-it'); ?></h3>
                <table class="form-table">
                    <tr><th><label><?php _e('Full Name Placeholder (English)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_placeholder_fullname" value="<?php echo esc_attr(get_option('contact_placeholder_fullname', 'Please enter full name')); ?>" style="width:300px;"></td></tr>
                    <tr><th><label style="color:#b8892f;"><?php _e('Full Name Placeholder (Khmer)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_placeholder_fullname_km" value="<?php echo esc_attr(get_option('contact_placeholder_fullname_km', '')); ?>" style="width:300px;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                    <tr><th><label><?php _e('Phone Placeholder (English)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_placeholder_phone" value="<?php echo esc_attr(get_option('contact_placeholder_phone', 'Please enter phone number')); ?>" style="width:300px;"></td></tr>
                    <tr><th><label style="color:#b8892f;"><?php _e('Phone Placeholder (Khmer)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_placeholder_phone_km" value="<?php echo esc_attr(get_option('contact_placeholder_phone_km', '')); ?>" style="width:300px;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                    <tr><th><label><?php _e('Email Placeholder (English)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_placeholder_email" value="<?php echo esc_attr(get_option('contact_placeholder_email', 'Please enter email address')); ?>" style="width:300px;"></td></tr>
                    <tr><th><label style="color:#b8892f;"><?php _e('Email Placeholder (Khmer)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_placeholder_email_km" value="<?php echo esc_attr(get_option('contact_placeholder_email_km', '')); ?>" style="width:300px;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                    <tr><th><label><?php _e('Message Placeholder (English)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_placeholder_message" value="<?php echo esc_attr(get_option('contact_placeholder_message', 'Please enter your message')); ?>" style="width:400px;"></td></tr>
                    <tr><th><label style="color:#b8892f;"><?php _e('Message Placeholder (Khmer)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_placeholder_message_km" value="<?php echo esc_attr(get_option('contact_placeholder_message_km', '')); ?>" style="width:400px;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                    <tr><th><label><?php _e('Location Placeholder (English)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_placeholder_location" value="<?php echo esc_attr(get_option('contact_placeholder_location', 'Please enter location')); ?>" style="width:300px;"></td></tr>
                    <tr><th><label style="color:#b8892f;"><?php _e('Location Placeholder (Khmer)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_placeholder_location_km" value="<?php echo esc_attr(get_option('contact_placeholder_location_km', '')); ?>" style="width:300px;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                </table>
            </div>
            <input type="submit" name="futuristic_it_save_contact_form" class="button button-primary" value="<?php _e('Save Form Fields', 'futuristic-it'); ?>">
        </form>
    </div>
    <?php
}

/**
 * The services a gated contact field is shown for when nothing is saved.
 *
 * A software purchase needs to say whether the customer is an individual or an
 * organisation; a course booking does not, so only the purchase service is
 * listed. Ticking another service in the admin still adds it.
 *
 * @return array Service titles (English).
 */
function futuristict_trigger_defaults() {
    return array('Software Procurement Support');
}

/**
 * The service titles a gated contact field should appear for.
 *
 * A field can be shown for several services at once, so this always returns a
 * LIST, even though the shipped default and most installs only ever set one.
 *
 * Three stored shapes are supported, because the option has been through two
 * changes of format and old rows are still out there:
 *   - absent            -> the shipped default (one service)
 *   - a plain string    -> a single service (the original format)
 *   - a JSON array      -> the current format, and '[]' means "never show"
 *
 * A blank string is deliberately treated as unset rather than as "never show":
 * that is the value the old single-value <select> wrote when it rendered with no
 * options, and it silently hid the field with nothing in the admin to explain
 * why. '[]' is the honest way to say "no service", since only the checkbox UI
 * can produce it.
 *
 * @param string $option_name Option holding the trigger service title(s).
 * @return array List of English service titles (possibly empty).
 */
function futuristict_trigger_services($option_name) {
    $raw = get_option($option_name, null);

    // Never saved: fall back to the services this field was built for.
    if ($raw === null || $raw === false) {
        return futuristict_trigger_defaults();
    }

    if (is_string($raw) && substr(trim($raw), 0, 1) === '[') {
        $decoded = json_decode($raw, true);
        if (!is_array($decoded)) return array();
        return futuristict_clean_trigger_list($decoded);
    }

    // Legacy single string. Blank counts as unset, not as "none".
    $single = is_string($raw) ? trim($raw) : '';
    if ($single === '') {
        return futuristict_trigger_defaults();
    }
    // A non-blank legacy value was a deliberate choice, and the one the old
    // control shipped preselected is also the default — so it needs no special
    // case. The next admin save stores a JSON array (even a one-element one),
    // which takes the array branch above.
    return array($single);
}

/**
 * Trim, drop blanks and de-duplicate a list of service titles.
 *
 * @param array $list Raw titles.
 * @return array Cleaned titles.
 */
function futuristict_clean_trigger_list($list) {
    $out = array();
    if (!is_array($list)) return $out;
    foreach ($list as $item) {
        if (!is_string($item)) continue;
        $item = trim($item);
        if ($item !== '' && !in_array($item, $out, true)) $out[] = $item;
    }
    return $out;
}

/**
 * Render the checkboxes for a "Show for Service" control.
 *
 * Checkboxes rather than a multi-select: the list is short, and a plain
 * multi-select needs a modifier key to add a second choice — which is exactly
 * the "show this for more than one service" case this exists to serve.
 *
 * Any saved title that no longer matches a service card is still listed, so a
 * renamed or deleted card leaves a visible, uncheckable leftover rather than a
 * setting that is silently still on.
 *
 * @param string $option_name Option to write to.
 * @param array  $selected    Titles currently saved.
 * @param array  $services    Decoded custom_service_cards.
 */
function futuristict_render_trigger_checkboxes($option_name, $selected, $services) {
    $selected = futuristict_clean_trigger_list($selected);
    $titles = array();
    if (is_array($services)) {
        foreach ($services as $svc) {
            $title = trim($svc['title'] ?? '');
            if ($title !== '' && !in_array($title, $titles, true)) $titles[] = $title;
        }
    }
    // Keep a stale saved title visible so it can be turned off.
    foreach ($selected as $s) {
        if (!in_array($s, $titles, true)) array_unshift($titles, $s);
    }

    if (empty($titles)) {
        echo '<p class="description">' . esc_html__('No services yet — add one under Services first.', 'futuristic-it') . '</p>';
        return;
    }
    foreach ($titles as $title) {
        printf(
            '<label style="display:block;margin-bottom:6px;"><input type="checkbox" name="%1$s[]" value="%2$s"%3$s> %4$s</label>',
            esc_attr($option_name),
            esc_attr($title),
            checked(in_array($title, $selected, true), true, false),
            esc_html($title)
        );
    }
}

/**
 * Licence admin page.
 *
 * Controls the Licence field the contact form shows when "Software Procurement
 * Support" is selected: the field's own label, its placeholder, and the list of
 * licence options offered in the dropdown.
 */
function futuristict_licence_page() {
    if (isset($_POST['futuristic_it_save_licence']) && check_admin_referer('futuristic_it_licence')) {
        // WordPress adds slashes to $_POST (wp_magic_quotes), so every value has
        // to be unslashed before sanitising or an apostrophe is stored escaped
        // and gains another backslash on each save.
        $fields = array('contact_form_licence', 'contact_placeholder_licence');
        foreach ($fields as $f) {
            if (isset($_POST[$f])) update_option($f, sanitize_text_field(wp_unslash($_POST[$f])));
            if (isset($_POST[$f . '_km'])) update_option($f . '_km', sanitize_text_field(wp_unslash($_POST[$f . '_km'])));
        }

        // Trigger services are a checkbox list now; see the note on the Customer
        // Type page for why an empty result is stored as '[]'.
        $licence_triggers = array();
        if (isset($_POST['contact_licence_service']) && is_array($_POST['contact_licence_service'])) {
            $licence_triggers = futuristict_clean_trigger_list(
                array_map(function ($v) { return sanitize_text_field(wp_unslash($v)); }, $_POST['contact_licence_service'])
            );
        }
        update_option('contact_licence_service', wp_json_encode($licence_triggers));

        // Licence options are a repeater. Rows arrive with a sparse index after
        // deletions, so rebuild the list sequentially and drop empty names.
        $options = array();
        if (isset($_POST['custom_licence_options']) && is_array($_POST['custom_licence_options'])) {
            foreach ($_POST['custom_licence_options'] as $row) {
                $name = sanitize_text_field(wp_unslash($row['name'] ?? ''));
                if ($name === '') continue;
                $options[] = array(
                    'name'    => $name,
                    'name_km' => sanitize_text_field(wp_unslash($row['name_km'] ?? '')),
                );
            }
        }
        update_option('custom_licence_options', wp_json_encode($options));

        futuristic_it_toast('Licence saved!');
    }

    $options = json_decode(get_option('custom_licence_options', '[]'), true);
    if (!is_array($options) || empty($options)) {
        // Seed a first row so the table is never blank on a fresh install.
        $options = array(array('name' => '', 'name_km' => ''));
    }
    ?>
    <div class="wrap">
        <h1><?php _e('Licence', 'futuristic-it'); ?></h1>
        <p style="color:#666;max-width:760px;">
            <?php _e('The Licence field appears on the contact form when "Software Procurement Support" is chosen as the Product / Service.', 'futuristic-it'); ?>
        </p>
        <form method="post" action="">
            <?php wp_nonce_field('futuristic_it_licence'); ?>

            <div style="background:#fff;padding:24px;border:1px solid #ccc;border-radius:8px;margin-bottom:24px;">
                <h3 style="margin:0 0 16px;"><?php _e('Field Label', 'futuristic-it'); ?></h3>
                <table class="form-table">
                    <tr><th><label><?php _e('Licence Label (English)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_form_licence" value="<?php echo esc_attr(get_option('contact_form_licence', 'Licence')); ?>" style="width:300px;"></td></tr>
                    <tr><th><label style="color:#b8892f;"><?php _e('Licence Label (Khmer)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_form_licence_km" value="<?php echo esc_attr(get_option('contact_form_licence_km', '')); ?>" style="width:300px;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                    <tr><th><label><?php _e('Licence Placeholder (English)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_placeholder_licence" value="<?php echo esc_attr(get_option('contact_placeholder_licence', 'Select a licence')); ?>" style="width:300px;"></td></tr>
                    <tr><th><label style="color:#b8892f;"><?php _e('Licence Placeholder (Khmer)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_placeholder_licence_km" value="<?php echo esc_attr(get_option('contact_placeholder_licence_km', '')); ?>" style="width:300px;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                    <tr>
                        <th><label><?php _e('Show for Service', 'futuristic-it'); ?></label></th>
                        <td>
                            <?php
                            $licence_services = json_decode(get_option('custom_service_cards', '[]'), true);
                            futuristict_render_trigger_checkboxes('contact_licence_service', futuristict_trigger_services('contact_licence_service'), $licence_services);
                            ?>
                            <p class="description"><?php _e('The Licence field appears on the contact form when any of these Product / Services is chosen. Leave all unticked to never show it.', 'futuristic-it'); ?></p>
                        </td>
                    </tr>
                </table>
            </div>

            <div style="background:#fff;padding:24px;border:1px solid #ccc;border-radius:8px;margin-bottom:24px;">
                <h3 style="margin:0 0 16px;"><?php _e('Licence Options', 'futuristic-it'); ?></h3>
                <p style="color:#999;margin:0 0 16px;"><?php _e('These are the choices shown in the Licence dropdown. Rows with an empty English name are not saved.', 'futuristic-it'); ?></p>
                <table class="widefat striped" id="licence-table">
                    <thead>
                        <tr>
                            <th><?php _e('Licence (English)', 'futuristic-it'); ?></th>
                            <th><?php _e('Licence (Khmer)', 'futuristic-it'); ?></th>
                            <th style="width:90px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($options as $i => $opt) : ?>
                        <tr>
                            <td><input type="text" name="custom_licence_options[<?php echo $i; ?>][name]" value="<?php echo esc_attr($opt['name'] ?? ''); ?>" class="widefat" placeholder="e.g. Microsoft 365 Business"></td>
                            <td><input type="text" name="custom_licence_options[<?php echo $i; ?>][name_km]" value="<?php echo esc_attr($opt['name_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;" placeholder="ឧ. Microsoft 365 Business"></td>
                            <td><button type="button" class="button button-small del-row" style="color:#dc3545;"><?php _e('Delete', 'futuristic-it'); ?></button></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <p><button type="button" class="button" id="add-licence">+ <?php _e('Add Licence', 'futuristic-it'); ?></button></p>
            </div>

            <input type="submit" name="futuristic_it_save_licence" class="button button-primary" value="<?php _e('Save Licence', 'futuristic-it'); ?>">
        </form>
    </div>
    <?php
}

/**
 * Customer Type admin page.
 *
 * Controls the Customer Type field the contact form shows when "Software
 * Procurement Support" is selected: the field's own label, its placeholder,
 * and the list of types offered (Personal / Organization / Other by default).
 */
function futuristict_customer_type_page() {
    if (isset($_POST['futuristic_it_save_customer_type']) && check_admin_referer('futuristic_it_customer_type')) {
        // WordPress adds slashes to $_POST (wp_magic_quotes), so every value has
        // to be unslashed before sanitising or an apostrophe is stored escaped
        // and gains another backslash on each save.
        $fields = array('contact_form_customer_type', 'contact_placeholder_customer_type');
        foreach ($fields as $f) {
            if (isset($_POST[$f])) update_option($f, sanitize_text_field(wp_unslash($_POST[$f])));
            if (isset($_POST[$f . '_km'])) update_option($f . '_km', sanitize_text_field(wp_unslash($_POST[$f . '_km'])));
        }

        // Trigger services are a checkbox list now. Unchecked boxes are simply
        // absent from $_POST, so an empty result is a real choice ("show for no
        // service") and is stored as '[]' — distinct from never having saved,
        // which still falls back to the default. See futuristict_trigger_services().
        $ct_triggers = array();
        if (isset($_POST['contact_customer_type_service']) && is_array($_POST['contact_customer_type_service'])) {
            $ct_triggers = futuristict_clean_trigger_list(
                array_map(function ($v) { return sanitize_text_field(wp_unslash($v)); }, $_POST['contact_customer_type_service'])
            );
        }
        update_option('contact_customer_type_service', wp_json_encode($ct_triggers));

        // Rows arrive with a sparse index after deletions, so rebuild the list
        // sequentially and drop empty names.
        $options = array();
        if (isset($_POST['custom_customer_type_options']) && is_array($_POST['custom_customer_type_options'])) {
            foreach ($_POST['custom_customer_type_options'] as $row) {
                $name = sanitize_text_field(wp_unslash($row['name'] ?? ''));
                if ($name === '') continue;
                $options[] = array(
                    'name'    => $name,
                    'name_km' => sanitize_text_field(wp_unslash($row['name_km'] ?? '')),
                );
            }
        }
        update_option('custom_customer_type_options', wp_json_encode($options));

        futuristic_it_toast('Customer Type saved!');
    }

    $options = json_decode(get_option('custom_customer_type_options', ''), true);
    if (!is_array($options) || empty($options)) {
        // Unlike Licence, this field has a fixed purpose, so the three types it
        // was built for are seeded rather than left blank: the contact form
        // works on a fresh install without a trip to the admin.
        $options = array(
            array('name' => 'Personal',     'name_km' => 'ផ្ទាល់ខ្លួន'),
            array('name' => 'Organization', 'name_km' => 'អង្គការ'),
            array('name' => 'Other',        'name_km' => 'ផ្សេងៗ'),
        );
    }
    ?>
    <div class="wrap">
        <h1><?php _e('Customer Type', 'futuristic-it'); ?></h1>
        <p style="color:#666;max-width:760px;">
            <?php _e('The Customer Type field appears on the contact form when "Software Procurement Support" is chosen as the Product / Service.', 'futuristic-it'); ?>
        </p>
        <form method="post" action="">
            <?php wp_nonce_field('futuristic_it_customer_type'); ?>

            <div style="background:#fff;padding:24px;border:1px solid #ccc;border-radius:8px;margin-bottom:24px;">
                <h3 style="margin:0 0 16px;"><?php _e('Field Label', 'futuristic-it'); ?></h3>
                <table class="form-table">
                    <tr><th><label><?php _e('Customer Type Label (English)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_form_customer_type" value="<?php echo esc_attr(get_option('contact_form_customer_type', 'Customer Type')); ?>" style="width:300px;"></td></tr>
                    <tr><th><label style="color:#b8892f;"><?php _e('Customer Type Label (Khmer)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_form_customer_type_km" value="<?php echo esc_attr(get_option('contact_form_customer_type_km', 'ប្រភេទអតិថិជន')); ?>" style="width:300px;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                    <tr><th><label><?php _e('Customer Type Placeholder (English)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_placeholder_customer_type" value="<?php echo esc_attr(get_option('contact_placeholder_customer_type', 'Select a customer type')); ?>" style="width:300px;"></td></tr>
                    <tr><th><label style="color:#b8892f;"><?php _e('Customer Type Placeholder (Khmer)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="contact_placeholder_customer_type_km" value="<?php echo esc_attr(get_option('contact_placeholder_customer_type_km', 'ជ្រើសរើសប្រភេទអតិថិជន')); ?>" style="width:300px;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                    <tr>
                        <th><label><?php _e('Show for Service', 'futuristic-it'); ?></label></th>
                        <td>
                            <?php
                            $ct_services = json_decode(get_option('custom_service_cards', '[]'), true);
                            futuristict_render_trigger_checkboxes('contact_customer_type_service', futuristict_trigger_services('contact_customer_type_service'), $ct_services);
                            ?>
                            <p class="description"><?php _e('The Customer Type field appears on the contact form when any of these Product / Services is chosen. Leave all unticked to never show it.', 'futuristic-it'); ?></p>
                        </td>
                    </tr>
                </table>
            </div>

            <div style="background:#fff;padding:24px;border:1px solid #ccc;border-radius:8px;margin-bottom:24px;">
                <h3 style="margin:0 0 16px;"><?php _e('Customer Types', 'futuristic-it'); ?></h3>
                <p style="color:#999;margin:0 0 16px;"><?php _e('These are the choices shown in the Customer Type dropdown. Rows with an empty English name are not saved.', 'futuristic-it'); ?></p>
                <table class="widefat striped" id="customer-type-table">
                    <thead>
                        <tr>
                            <th><?php _e('Customer Type (English)', 'futuristic-it'); ?></th>
                            <th><?php _e('Customer Type (Khmer)', 'futuristic-it'); ?></th>
                            <th style="width:90px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($options as $i => $opt) : ?>
                        <tr>
                            <td><input type="text" name="custom_customer_type_options[<?php echo $i; ?>][name]" value="<?php echo esc_attr($opt['name'] ?? ''); ?>" class="widefat" placeholder="e.g. Personal"></td>
                            <td><input type="text" name="custom_customer_type_options[<?php echo $i; ?>][name_km]" value="<?php echo esc_attr($opt['name_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;" placeholder="ឧ. ផ្ទាល់ខ្លួន"></td>
                            <td><button type="button" class="button button-small del-row" style="color:#dc3545;"><?php _e('Delete', 'futuristic-it'); ?></button></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <p><button type="button" class="button" id="add-customer-type">+ <?php _e('Add Customer Type', 'futuristic-it'); ?></button></p>
            </div>

            <input type="submit" name="futuristic_it_save_customer_type" class="button button-primary" value="<?php _e('Save Customer Type', 'futuristic-it'); ?>">
        </form>
    </div>
    <?php
}

/**
 * Save handler for the Procurement "Page Content" screen.
 *
 * Only the copy fields are written here. The software grid and the process
 * steps have their own screens and their own handlers, so saving this one
 * cannot blank the other two — each form posts only what it renders.
 */
function futuristict_procurement_content_save() {
    if (!isset($_POST['futuristic_it_save_procurement']) || !check_admin_referer('futuristic_it_procurement')) {
        return;
    }

    // WordPress adds slashes to $_POST (wp_magic_quotes), so every value has
    // to be unslashed before sanitising or an apostrophe is stored escaped
    // and gains another backslash on each save.
    $text_fields = array(
        'procurement_badge', 'procurement_heading', 'procurement_heading_highlight',
        'procurement_paragraph', 'procurement_panel_title', 'procurement_panel_note',
        'procurement_cta_text', 'procurement_cta_url', 'procurement_service',
        'procurement_process_eyebrow', 'procurement_process_heading',
    );
    foreach ($text_fields as $f) {
        if (isset($_POST[$f])) update_option($f, sanitize_text_field(wp_unslash($_POST[$f])));
        if (isset($_POST[$f . '_km'])) update_option($f . '_km', sanitize_text_field(wp_unslash($_POST[$f . '_km'])));
    }

    // The page is created on init, but saving the module is the moment the
    // admin expects the link to work, so make sure it exists right away.
    futuristic_it_create_procurement_page();

    futuristic_it_toast('Page content saved!');
}

/**
 * Save handler for the Procurement "Software Grid" screen.
 *
 * Rows arrive with a sparse index after deletions, so the list is rebuilt
 * sequentially and rows with no name in either language are dropped.
 */
function futuristict_procurement_grid_save() {
    if (!isset($_POST['futuristic_it_save_procurement_grid']) || !check_admin_referer('futuristic_it_procurement_grid')) {
        return;
    }

    $cards = array();
    if (isset($_POST['custom_procurement_cards']) && is_array($_POST['custom_procurement_cards'])) {
        foreach ($_POST['custom_procurement_cards'] as $row) {
            $name    = sanitize_text_field(wp_unslash($row['name'] ?? ''));
            $name_km = sanitize_text_field(wp_unslash($row['name_km'] ?? ''));
            if ($name === '' && $name_km === '') continue;
            $cards[] = array(
                'icon'    => esc_url_raw(wp_unslash($row['icon'] ?? '')),
                'name'    => $name,
                'name_km' => $name_km,
            );
        }
    }
    update_option('custom_procurement_cards', wp_json_encode($cards));

    futuristic_it_toast('Software grid saved!');
}

/**
 * Save handler for the Procurement "Our Process" screen.
 *
 * Same sparse-index rebuild as the grid. A step is dropped only when it has no
 * title in either language — a step with a title but no body is legitimate.
 */
function futuristict_procurement_process_save() {
    if (!isset($_POST['futuristic_it_save_procurement_process']) || !check_admin_referer('futuristic_it_procurement_process')) {
        return;
    }

    $steps = array();
    if (isset($_POST['custom_procurement_steps']) && is_array($_POST['custom_procurement_steps'])) {
        foreach ($_POST['custom_procurement_steps'] as $row) {
            $title    = sanitize_text_field(wp_unslash($row['title'] ?? ''));
            $title_km = sanitize_text_field(wp_unslash($row['title_km'] ?? ''));
            if ($title === '' && $title_km === '') continue;
            $steps[] = array(
                'title'    => $title,
                'title_km' => $title_km,
                'desc'     => sanitize_textarea_field(wp_unslash($row['desc'] ?? '')),
                'desc_km'  => sanitize_textarea_field(wp_unslash($row['desc_km'] ?? '')),
                'meta'     => sanitize_text_field(wp_unslash($row['meta'] ?? '')),
                'meta_km'  => sanitize_text_field(wp_unslash($row['meta_km'] ?? '')),
            );
        }
    }
    update_option('custom_procurement_steps', wp_json_encode($steps));

    futuristic_it_toast('Process steps saved!');
}

/**
 * Landing screen for the Software Procurement module.
 *
 * The module's three editing screens are reached from these cards rather than
 * from the sidebar, so the submenu stays short. Each card links to its own
 * screen, which is where the form and the save button live.
 */
function futuristict_procurement_page() {
    $procurement_url = futuristic_it_get_procurement_url();
    $cards = futuristic_it_procurement_cards();
    $steps = futuristic_it_procurement_steps();
    ?>
    <div class="wrap">
        <h1><?php _e('Software Procurement', 'futuristic-it'); ?></h1>
        <p style="color:#666;max-width:760px;">
            <?php _e('Controls the Software Procurement Support detail page — the page the service card opens when it is clicked.', 'futuristic-it'); ?>
            <?php if (!empty($procurement_url)) : ?>
                <br><a href="<?php echo esc_url($procurement_url); ?>" target="_blank"><?php echo esc_html($procurement_url); ?></a>
            <?php endif; ?>
        </p>

        <div class="fw-cards">
            <a href="<?php echo admin_url('admin.php?page=futuristict-procurement-content'); ?>" class="fw-card">
                <h3><?php _e('Page Content', 'futuristic-it'); ?></h3>
                <p><?php _e('Edit the badge, heading, paragraph, button text, panel heading and note.', 'futuristic-it'); ?></p>
                <span class="fw-card-count"><?php _e('Hero & panel copy', 'futuristic-it'); ?></span>
            </a>
            <a href="<?php echo admin_url('admin.php?page=futuristict-procurement-grid'); ?>" class="fw-card">
                <h3><?php _e('Software Grid', 'futuristic-it'); ?></h3>
                <p><?php _e('Add and manage the software tiles shown in the panel on the right.', 'futuristic-it'); ?></p>
                <span class="fw-card-count"><?php echo esc_html(sprintf(_n('%d software item', '%d software items', count($cards), 'futuristic-it'), count($cards))); ?></span>
            </a>
            <a href="<?php echo admin_url('admin.php?page=futuristict-procurement-process'); ?>" class="fw-card">
                <h3><?php _e('Our Process', 'futuristic-it'); ?></h3>
                <p><?php _e('Edit the numbered steps in the "How it works" section below the panel.', 'futuristic-it'); ?></p>
                <span class="fw-card-count"><?php echo esc_html(sprintf(_n('%d step', '%d steps', count($steps), 'futuristic-it'), count($steps))); ?></span>
            </a>
        </div>
    </div>
    <?php
}

/**
 * "Page Content" screen — the copy fields only.
 */
function futuristict_procurement_content_page() {
    futuristict_procurement_content_save();

    // Field values come from the shared defaults, so the placeholder shown here
    // is always the exact text the page would render unsaved.
    $d = futuristic_it_procurement_defaults();
    $val = function ($key, $lang) use ($d) {
        $stored = get_option($lang === 'km' ? $key . '_km' : $key, '');
        if (!empty($stored)) return $stored;
        return isset($d[$key][$lang]) ? $d[$key][$lang] : '';
    };
    ?>
    <div class="wrap">
        <h1><?php _e('Page Content', 'futuristic-it'); ?></h1>
        <p style="color:#666;max-width:760px;"><?php _e('The hero copy and the software panel heading on the Procurement page.', 'futuristic-it'); ?></p>
        <p><a href="<?php echo admin_url('admin.php?page=futuristict-procurement'); ?>">&larr; <?php _e('Back to Software Procurement', 'futuristic-it'); ?></a></p>
        <form method="post" action="">
            <?php wp_nonce_field('futuristic_it_procurement'); ?>

            <div style="background:#fff;padding:24px;border:1px solid #ccc;border-radius:8px;margin-bottom:24px;">
                <h3 style="margin:0 0 16px;"><?php _e('Page Content', 'futuristic-it'); ?></h3>
                <table class="form-table">
                    <tr>
                        <th><label><?php _e('Badge (English)', 'futuristic-it'); ?></label></th>
                        <td><input type="text" class="regular-text" name="procurement_badge" value="<?php echo esc_attr($val('procurement_badge', 'en')); ?>" style="width:420px;"></td>
                    </tr>
                    <tr>
                        <th><label style="color:#b8892f;"><?php _e('Badge (Khmer)', 'futuristic-it'); ?></label></th>
                        <td><input type="text" class="regular-text" name="procurement_badge_km" value="<?php echo esc_attr($val('procurement_badge', 'km')); ?>" style="width:420px;font-family:'Noto Sans Khmer',sans-serif;"></td>
                    </tr>
                    <tr>
                        <th><label><?php _e('Heading (English)', 'futuristic-it'); ?></label></th>
                        <td>
                            <input type="text" class="regular-text" name="procurement_heading" value="<?php echo esc_attr($val('procurement_heading', 'en')); ?>" style="width:420px;">
                            <p class="description"><?php _e('The main page heading.', 'futuristic-it'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th><label style="color:#b8892f;"><?php _e('Heading (Khmer)', 'futuristic-it'); ?></label></th>
                        <td><input type="text" class="regular-text" name="procurement_heading_km" value="<?php echo esc_attr($val('procurement_heading', 'km')); ?>" style="width:420px;font-family:'Noto Sans Khmer',sans-serif;"></td>
                    </tr>
                    <tr>
                        <th><label><?php _e('Highlighted Word', 'futuristic-it'); ?></label></th>
                        <td>
                            <input type="text" class="regular-text" name="procurement_heading_highlight" value="<?php echo esc_attr($val('procurement_heading_highlight', 'en')); ?>" style="width:220px;">
                            <p class="description"><?php _e('The first matching word in the heading is shown in gold. Leave empty for a plain heading.', 'futuristic-it'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th><label style="color:#b8892f;"><?php _e('Highlighted Word (Khmer)', 'futuristic-it'); ?></label></th>
                        <td><input type="text" class="regular-text" name="procurement_heading_highlight_km" value="<?php echo esc_attr($val('procurement_heading_highlight', 'km')); ?>" style="width:220px;font-family:'Noto Sans Khmer',sans-serif;"></td>
                    </tr>
                    <tr>
                        <th><label><?php _e('Paragraph (English)', 'futuristic-it'); ?></label></th>
                        <td><textarea class="large-text" name="procurement_paragraph" rows="3" style="width:560px;"><?php echo esc_textarea($val('procurement_paragraph', 'en')); ?></textarea></td>
                    </tr>
                    <tr>
                        <th><label style="color:#b8892f;"><?php _e('Paragraph (Khmer)', 'futuristic-it'); ?></label></th>
                        <td><textarea class="large-text" name="procurement_paragraph_km" rows="3" style="width:560px;font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea($val('procurement_paragraph', 'km')); ?></textarea></td>
                    </tr>
                    <tr>
                        <th><label><?php _e('Button Text (English)', 'futuristic-it'); ?></label></th>
                        <td><input type="text" class="regular-text" name="procurement_cta_text" value="<?php echo esc_attr($val('procurement_cta_text', 'en')); ?>" style="width:300px;"></td>
                    </tr>
                    <tr>
                        <th><label style="color:#b8892f;"><?php _e('Button Text (Khmer)', 'futuristic-it'); ?></label></th>
                        <td><input type="text" class="regular-text" name="procurement_cta_text_km" value="<?php echo esc_attr($val('procurement_cta_text', 'km')); ?>" style="width:300px;font-family:'Noto Sans Khmer',sans-serif;"></td>
                    </tr>
                    <tr>
                        <th><label><?php _e('Button URL', 'futuristic-it'); ?></label></th>
                        <td>
                            <input type="text" class="regular-text" name="procurement_cta_url" value="<?php echo esc_attr($val('procurement_cta_url', 'en')); ?>" placeholder="https://..." style="width:420px;">
                            <p class="description"><?php _e('Leave empty to default to the Contact Us page.', 'futuristic-it'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th><label><?php _e('Panel Heading (English)', 'futuristic-it'); ?></label></th>
                        <td><input type="text" class="regular-text" name="procurement_panel_title" value="<?php echo esc_attr($val('procurement_panel_title', 'en')); ?>" style="width:420px;"></td>
                    </tr>
                    <tr>
                        <th><label style="color:#b8892f;"><?php _e('Panel Heading (Khmer)', 'futuristic-it'); ?></label></th>
                        <td><input type="text" class="regular-text" name="procurement_panel_title_km" value="<?php echo esc_attr($val('procurement_panel_title', 'km')); ?>" style="width:420px;font-family:'Noto Sans Khmer',sans-serif;"></td>
                    </tr>
                    <tr>
                        <th><label><?php _e('Panel Note (English)', 'futuristic-it'); ?></label></th>
                        <td>
                            <input type="text" class="regular-text" name="procurement_panel_note" value="<?php echo esc_attr($val('procurement_panel_note', 'en')); ?>" style="width:420px;">
                            <p class="description"><?php _e('Shown in gold under the software grid. Leave empty to hide it.', 'futuristic-it'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th><label style="color:#b8892f;"><?php _e('Panel Note (Khmer)', 'futuristic-it'); ?></label></th>
                        <td><input type="text" class="regular-text" name="procurement_panel_note_km" value="<?php echo esc_attr($val('procurement_panel_note', 'km')); ?>" style="width:420px;font-family:'Noto Sans Khmer',sans-serif;"></td>
                    </tr>
                    <tr>
                        <th><label><?php _e('Open for Service', 'futuristic-it'); ?></label></th>
                        <td>
                            <select name="procurement_service" style="width:300px;">
                                <?php
                                $bound = futuristic_it_procurement_service_title();
                                $svc_list = json_decode(get_option('custom_service_cards', '[]'), true);
                                $found = false;
                                if (is_array($svc_list)) {
                                    foreach ($svc_list as $svc) {
                                        $svc_en = $svc['title'] ?? '';
                                        if ($svc_en === '') continue;
                                        if ($svc_en === $bound) $found = true;
                                        echo '<option value="' . esc_attr($svc_en) . '"' . selected($bound, $svc_en, false) . '>' . esc_html($svc_en) . '</option>';
                                    }
                                }
                                // Keep a saved title that no longer matches a card
                                // visible, so the admin can see why nothing links
                                // here instead of the select silently moving on.
                                if (!$found && $bound !== '') {
                                    echo '<option value="' . esc_attr($bound) . '" selected>' . esc_html($bound) . '</option>';
                                }
                                ?>
                            </select>
                            <p class="description"><?php _e('This service card opens the page above when clicked, instead of its own custom link.', 'futuristic-it'); ?></p>
                        </td>
                    </tr>
                </table>
            </div>

            <input type="submit" name="futuristic_it_save_procurement" class="button button-primary" value="<?php _e('Save Page Content', 'futuristic-it'); ?>">
        </form>
    </div>
    <?php
}

/**
 * "Software Grid" screen — the panel tiles only.
 */
function futuristict_procurement_grid_page() {
    futuristict_procurement_grid_save();

    $cards = futuristic_it_procurement_cards();
    if (empty($cards)) {
        // An empty table gives the admin nothing to type into, so show one
        // blank row to start from. This is display-only: saving it back with
        // the row still blank stores [] again, keeping the grid empty.
        $cards = array(array('icon' => '', 'name' => '', 'name_km' => ''));
    }
    ?>
    <div class="wrap">
        <h1><?php _e('Software Grid', 'futuristic-it'); ?></h1>
        <p><a href="<?php echo admin_url('admin.php?page=futuristict-procurement'); ?>">&larr; <?php _e('Back to Software Procurement', 'futuristic-it'); ?></a></p>
        <form method="post" action="">
            <?php wp_nonce_field('futuristic_it_procurement_grid'); ?>

            <div style="background:#fff;padding:24px;border:1px solid #ccc;border-radius:8px;margin-bottom:24px;">
                <h3 style="margin:0 0 16px;"><?php _e('Software Grid', 'futuristic-it'); ?></h3>
                <p style="color:#999;margin:0 0 16px;"><?php _e('The cards shown in the panel on the right of the page. Rows with no name in either language are not saved.', 'futuristic-it'); ?></p>
                <table class="widefat striped" id="procurement-table">
                    <thead>
                        <tr>
                            <th style="width:110px;"><?php _e('Icon', 'futuristic-it'); ?></th>
                            <th><?php _e('Software (English)', 'futuristic-it'); ?></th>
                            <th><?php _e('Software (Khmer)', 'futuristic-it'); ?></th>
                            <th style="width:90px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($cards as $i => $card) : ?>
                        <tr>
                            <td>
                                <input type="hidden" name="custom_procurement_cards[<?php echo $i; ?>][icon]" value="<?php echo esc_attr($card['icon'] ?? ''); ?>"><?php if (!empty($card['icon'])) : ?><img src="<?php echo esc_url($card['icon']); ?>" style="width:36px;height:36px;object-fit:contain;border-radius:4px;background:#fff;padding:2px;"><?php endif; ?>
                                <br><a href="#" class="button button-small upload-btn" data-for="custom_procurement_cards[<?php echo $i; ?>][icon]"><?php _e('Upload', 'futuristic-it'); ?></a>
                            </td>
                            <td><input type="text" name="custom_procurement_cards[<?php echo $i; ?>][name]" value="<?php echo esc_attr($card['name'] ?? ''); ?>" class="widefat" placeholder="e.g. Microsoft 365"></td>
                            <td><input type="text" name="custom_procurement_cards[<?php echo $i; ?>][name_km]" value="<?php echo esc_attr($card['name_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;" placeholder="ឧ. Microsoft 365"></td>
                            <td><button type="button" class="button button-small del-row" style="color:#dc3545;"><?php _e('Delete', 'futuristic-it'); ?></button></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <p><button type="button" class="button" id="add-procurement">+ <?php _e('Add Software', 'futuristic-it'); ?></button></p>
            </div>

            <input type="submit" name="futuristic_it_save_procurement_grid" class="button button-primary" value="<?php _e('Save Software Grid', 'futuristic-it'); ?>">
        </form>
    </div>
    <?php
}

/**
 * "Our Process" screen — the numbered steps and their section headings.
 */
function futuristict_procurement_process_page() {
    futuristict_procurement_process_save();

    $d = futuristic_it_procurement_defaults();
    $val = function ($key, $lang) use ($d) {
        $stored = get_option($lang === 'km' ? $key . '_km' : $key, '');
        if (!empty($stored)) return $stored;
        return isset($d[$key][$lang]) ? $d[$key][$lang] : '';
    };

    $steps = futuristic_it_procurement_steps();
    if (empty($steps)) {
        // Same reasoning as the software grid: an empty table is unusable, so
        // show one blank row. Saving it blank stores [] again.
        $steps = array(array('title' => '', 'title_km' => '', 'desc' => '', 'desc_km' => '', 'meta' => '', 'meta_km' => ''));
    }
    ?>
    <div class="wrap">
        <h1><?php _e('Our Process', 'futuristic-it'); ?></h1>
        <p style="color:#666;max-width:760px;"><?php _e('The numbered steps in the "How software procurement support works" section, shown below the hero on the Procurement page.', 'futuristic-it'); ?></p>
        <p><a href="<?php echo admin_url('admin.php?page=futuristict-procurement'); ?>">&larr; <?php _e('Back to Software Procurement', 'futuristic-it'); ?></a></p>
        <form method="post" action="">
            <?php wp_nonce_field('futuristic_it_procurement_process'); ?>

            <div style="background:#fff;padding:24px;border:1px solid #ccc;border-radius:8px;margin-bottom:24px;">
                <h3 style="margin:0 0 16px;"><?php _e('Section Heading', 'futuristic-it'); ?></h3>
                <table class="form-table">
                    <tr>
                        <th><label><?php _e('Eyebrow (English)', 'futuristic-it'); ?></label></th>
                        <td>
                            <input type="text" class="regular-text" name="procurement_process_eyebrow" value="<?php echo esc_attr($val('procurement_process_eyebrow', 'en')); ?>" style="width:320px;">
                            <p class="description"><?php _e('The small gold label above the heading. Leave empty to hide it.', 'futuristic-it'); ?></p>
                        </td>
                    </tr>
                    <tr>
                        <th><label style="color:#b8892f;"><?php _e('Eyebrow (Khmer)', 'futuristic-it'); ?></label></th>
                        <td><input type="text" class="regular-text" name="procurement_process_eyebrow_km" value="<?php echo esc_attr($val('procurement_process_eyebrow', 'km')); ?>" style="width:320px;font-family:'Noto Sans Khmer',sans-serif;"></td>
                    </tr>
                    <tr>
                        <th><label><?php _e('Heading (English)', 'futuristic-it'); ?></label></th>
                        <td><input type="text" class="regular-text" name="procurement_process_heading" value="<?php echo esc_attr($val('procurement_process_heading', 'en')); ?>" style="width:520px;"></td>
                    </tr>
                    <tr>
                        <th><label style="color:#b8892f;"><?php _e('Heading (Khmer)', 'futuristic-it'); ?></label></th>
                        <td><input type="text" class="regular-text" name="procurement_process_heading_km" value="<?php echo esc_attr($val('procurement_process_heading', 'km')); ?>" style="width:520px;font-family:'Noto Sans Khmer',sans-serif;"></td>
                    </tr>
                </table>
            </div>

            <div style="background:#fff;padding:24px;border:1px solid #ccc;border-radius:8px;margin-bottom:24px;">
                <h3 style="margin:0 0 16px;"><?php _e('Steps', 'futuristic-it'); ?></h3>
                <p style="color:#999;margin:0 0 16px;"><?php _e('Steps are numbered automatically in the order listed. The timing note is optional — leave it empty to hide the badge. Rows with no title in either language are not saved.', 'futuristic-it'); ?></p>
                <table class="widefat striped" id="process-table">
                    <thead>
                        <tr>
                            <th style="width:56px;"><?php _e('No.', 'futuristic-it'); ?></th>
                            <th><?php _e('Step (English)', 'futuristic-it'); ?></th>
                            <th><?php _e('Step (Khmer)', 'futuristic-it'); ?></th>
                            <th style="width:90px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($steps as $i => $step) : ?>
                        <tr>
                            <td><strong class="process-num"><?php echo esc_html($i + 1); ?></strong></td>
                            <td>
                                <input type="text" name="custom_procurement_steps[<?php echo $i; ?>][title]" value="<?php echo esc_attr($step['title'] ?? ''); ?>" class="widefat" placeholder="e.g. You tell us what you need" style="margin-bottom:6px;">
                                <textarea name="custom_procurement_steps[<?php echo $i; ?>][desc]" class="widefat" rows="3" placeholder="What happens at this step..."><?php echo esc_textarea($step['desc'] ?? ''); ?></textarea>
                                <input type="text" name="custom_procurement_steps[<?php echo $i; ?>][meta]" value="<?php echo esc_attr($step['meta'] ?? ''); ?>" class="widefat" placeholder="e.g. Takes 5 minutes (optional)" style="margin-top:6px;">
                            </td>
                            <td>
                                <input type="text" name="custom_procurement_steps[<?php echo $i; ?>][title_km]" value="<?php echo esc_attr($step['title_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;margin-bottom:6px;">
                                <textarea name="custom_procurement_steps[<?php echo $i; ?>][desc_km]" class="widefat" rows="3" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea($step['desc_km'] ?? ''); ?></textarea>
                                <input type="text" name="custom_procurement_steps[<?php echo $i; ?>][meta_km]" value="<?php echo esc_attr($step['meta_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;margin-top:6px;">
                            </td>
                            <td><button type="button" class="button button-small del-row" style="color:#dc3545;"><?php _e('Delete', 'futuristic-it'); ?></button></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <p><button type="button" class="button" id="add-process-step">+ <?php _e('Add Step', 'futuristic-it'); ?></button></p>
            </div>

            <input type="submit" name="futuristic_it_save_procurement_process" class="button button-primary" value="<?php _e('Save Process Steps', 'futuristic-it'); ?>">
        </form>
    </div>
    <?php
}

/**
 * Legacy screen kept for the old submenu slug.
 *
 * The module's screens are reached from the landing cards now; this forwards
 * any bookmark or cached link to the Page Content screen so it does not 404.
 */
function futuristict_procurement_legacy_page() {
    futuristict_procurement_content_page();
}


function futuristict_header_footer_page() {
    if (isset($_POST['futuristic_it_save_footer']) && check_admin_referer('futuristic_it_footer')) {
        $fields = array('custom_logo_title', 'custom_footer_logo_image', 'custom_footer_tagline', 'custom_footer_quicklinks_title', 'custom_footer_contact_title', 'custom_footer_address', 'custom_footer_email', 'custom_footer_copyright');
        foreach ($fields as $f) {
            if (isset($_POST[$f])) update_option($f, sanitize_text_field($_POST[$f]));
            if (isset($_POST[$f . '_km'])) update_option($f . '_km', sanitize_text_field($_POST[$f . '_km']));
        }
        if (isset($_POST['footer_social_links'])) {
            update_option('custom_footer_social_links', sanitize_text_field(wp_json_encode($_POST['footer_social_links'])));
        }
        futuristic_it_toast('Footer saved!');
    }
    ?>
    <div class="wrap">
        <h1><?php _e('Footer', 'futuristic-it'); ?></h1>
        <form method="post" action="">
            <?php wp_nonce_field('futuristic_it_footer'); ?>
            <h2><?php _e('Logo', 'futuristic-it'); ?></h2>
            <table class="form-table">
                <tr><th><label>Logo Image</label></th><td>
                    <input type="hidden" name="custom_footer_logo_image" id="custom_footer_logo_image" value="<?php echo esc_attr(get_option('custom_footer_logo_image', '')); ?>">
                    <?php $logo_img = get_option('custom_footer_logo_image', ''); ?>
                    <?php if (!empty($logo_img)) : ?><img src="<?php echo esc_url($logo_img); ?>" style="max-height:80px;margin-bottom:10px;display:block;"><?php endif; ?>
                    <button type="button" class="button upload-btn" data-for="custom_footer_logo_image">Upload Logo</button>
                    <button type="button" class="button button-link" id="remove-logo-btn" style="<?php echo empty($logo_img) ? 'display:none;' : ''; ?>">Remove</button>
                </td></tr>
                <tr><th><label>Logo Title</label></th><td><input type="text" class="regular-text" name="custom_logo_title" value="<?php echo esc_attr(get_option('custom_logo_title', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Logo Title (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_logo_title_km" value="<?php echo esc_attr(get_option('custom_logo_title_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
            </table>
            <h2><?php _e('Footer Content', 'futuristic-it'); ?></h2>
            <table class="form-table">
                <tr><th><label>Tagline</label></th><td><textarea class="large-text" name="custom_footer_tagline" rows="3"><?php echo esc_textarea(get_option('custom_footer_tagline', '')); ?></textarea></td></tr>
                <tr><th><label style="color:#b8892f;">Tagline (Khmer)</label></th><td><textarea class="large-text" name="custom_footer_tagline_km" rows="3" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea(get_option('custom_footer_tagline_km', '')); ?></textarea></td></tr>
                <tr><th><label>Quick Links Title</label></th><td><input type="text" class="regular-text" name="custom_footer_quicklinks_title" value="<?php echo esc_attr(get_option('custom_footer_quicklinks_title', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Quick Links Title (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_footer_quicklinks_title_km" value="<?php echo esc_attr(get_option('custom_footer_quicklinks_title_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>Contact Title</label></th><td><input type="text" class="regular-text" name="custom_footer_contact_title" value="<?php echo esc_attr(get_option('custom_footer_contact_title', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Contact Title (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_footer_contact_title_km" value="<?php echo esc_attr(get_option('custom_footer_contact_title_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                <tr><th><label>Address</label></th><td><textarea class="large-text" name="custom_footer_address" rows="2"><?php echo esc_textarea(get_option('custom_footer_address', '')); ?></textarea></td></tr>
                <tr><th><label>Email</label></th><td><input type="text" class="regular-text" name="custom_footer_email" value="<?php echo esc_attr(get_option('custom_footer_email', '')); ?>"></td></tr>
                <tr><th><label>Copyright</label></th><td><input type="text" class="regular-text" name="custom_footer_copyright" value="<?php echo esc_attr(get_option('custom_footer_copyright', '')); ?>"></td></tr>
                <tr><th><label style="color:#b8892f;">Copyright (Khmer)</label></th><td><input type="text" class="regular-text" name="custom_footer_copyright_km" value="<?php echo esc_attr(get_option('custom_footer_copyright_km', '')); ?>" style="font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
            </table>
            <input type="submit" name="futuristic_it_save_footer" class="button button-primary" value="Save Footer">
        </form>
    </div>
    <?php
}

// Social Media Admin Page
function futuristict_social_media_page() {
    if (isset($_POST['futuristic_it_save_social_media']) && check_admin_referer('futuristic_it_social_media')) {
        $social_title_en = sanitize_text_field($_POST['social_title_en'] ?? '');
        $social_title_km = sanitize_text_field($_POST['social_title_km'] ?? '');
        update_option('custom_social_title_en', $social_title_en);
        update_option('custom_social_title_km', $social_title_km);
        if (isset($_POST['social_links']) && is_array($_POST['social_links'])) {
            $sanitized = array();
            foreach ($_POST['social_links'] as $link) {
                $icon = sanitize_text_field($link['icon'] ?? '');
                $url = sanitize_text_field($link['url'] ?? '');
                if (!empty($icon)) {
                    $sanitized[] = array('icon' => $icon, 'url' => $url);
                }
            }
            update_option('custom_footer_social_links', wp_json_encode($sanitized));
        }
        futuristic_it_toast('Social media links saved!');
    }
    $social_links = json_decode(get_option('custom_footer_social_links', '[]'), true);
    if (!is_array($social_links) || empty($social_links)) {
        $social_links = array(array('icon' => 'facebook', 'url' => ''));
    }
    ?>
    <div class="wrap">
        <h1><?php _e('Social Media', 'futuristic-it'); ?></h1>
        <p><a href="<?php echo admin_url('admin.php?page=futuristict-website'); ?>">&larr; Back</a></p>
        <form method="post" action="">
            <?php wp_nonce_field('futuristic_it_social_media'); ?>
            <div style="background:#fff;padding:20px;border:1px solid #ddd;border-radius:8px;margin-bottom:20px;">
                <h3 style="margin:0 0 12px;"><?php _e('Social Section Title', 'futuristic-it'); ?></h3>
                <table class="form-table" style="margin:0;">
                    <tr><th><label>Title (English)</label></th><td><input type="text" class="regular-text" name="social_title_en" value="<?php echo esc_attr(get_option('custom_social_title_en', 'Follow Us')); ?>" style="width:300px;"></td></tr>
                    <tr><th><label style="color:#b8892f;">Title (Khmer)</label></th><td><input type="text" class="regular-text" name="social_title_km" value="<?php echo esc_attr(get_option('custom_social_title_km', '')); ?>" style="width:300px;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                </table>
            </div>
            <h2><?php _e('Social Links', 'futuristic-it'); ?></h2>
            <table class="widefat striped" id="social-media-table">
                <thead>
                    <tr>
                        <th style="width:150px;"><?php _e('Platform', 'futuristic-it'); ?></th>
                        <th><?php _e('URL', 'futuristic-it'); ?></th>
                        <th style="width:60px;"></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($social_links as $i => $sl) : ?>
                    <tr data-saved="1">
                        <td>
                            <select name="social_links[<?php echo $i; ?>][icon]" style="width:100%">
                                <option value="facebook" <?php selected($sl['icon'] ?? '', 'facebook'); ?>>Facebook</option>
                                <option value="linkedin" <?php selected($sl['icon'] ?? '', 'linkedin'); ?>>LinkedIn</option>
                                <option value="twitter" <?php selected($sl['icon'] ?? '', 'twitter'); ?>>Twitter / X</option>
                                <option value="instagram" <?php selected($sl['icon'] ?? '', 'instagram'); ?>>Instagram</option>
                                <option value="youtube" <?php selected($sl['icon'] ?? '', 'youtube'); ?>>YouTube</option>
                                <option value="whatsapp" <?php selected($sl['icon'] ?? '', 'whatsapp'); ?>>WhatsApp</option>
                                <option value="tiktok" <?php selected($sl['icon'] ?? '', 'tiktok'); ?>>TikTok</option>
                                <option value="telegram" <?php selected($sl['icon'] ?? '', 'telegram'); ?>>Telegram</option>
                            </select>
                        </td>
                        <td><input type="text" name="social_links[<?php echo $i; ?>][url]" value="<?php echo esc_attr($sl['url'] ?? ''); ?>" class="widefat" placeholder="https://..."></td>
                        <td><button type="button" class="button button-small del-social-row" style="color:#dc3545;"><?php _e('Remove', 'futuristic-it'); ?></button></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <p><button type="button" class="button" id="add-social-link">+ <?php _e('Add Social Link', 'futuristic-it'); ?></button></p>
            <input type="submit" name="futuristic_it_save_social_media" class="button button-primary" value="<?php _e('Save Social Media', 'futuristic-it'); ?>">
        </form>
        <script>
        var socialCount = <?php echo count($social_links); ?>;
        var socialAjaxUrl = '<?php echo admin_url('admin-ajax.php'); ?>';
        var socialNonce = '<?php echo wp_create_nonce('futuristic_it_social_media_ajax'); ?>';

        document.getElementById('add-social-link').addEventListener('click', function() {
            var idx = socialCount;
            var html = '<tr>' +
                '<td><select name="social_links[' + idx + '][icon]" style="width:100%">' +
                '<option value="facebook">Facebook</option>' +
                '<option value="linkedin">LinkedIn</option>' +
                '<option value="twitter">Twitter / X</option>' +
                '<option value="instagram">Instagram</option>' +
                '<option value="youtube">YouTube</option>' +
                '<option value="whatsapp">WhatsApp</option>' +
                '<option value="tiktok">TikTok</option>' +
                '<option value="telegram">Telegram</option>' +
                '</select></td>' +
                '<td><input type="text" name="social_links[' + idx + '][url]" value="" class="widefat" placeholder="https://..."></td>' +
                '<td><button type="button" class="button button-small del-social-row" style="color:#dc3545;">Remove</button></td>' +
                '</tr>';
            document.querySelector('#social-media-table tbody').insertAdjacentHTML('beforeend', html);
            socialCount++;
        });

        document.querySelector('#social-media-table tbody').addEventListener('click', function(e) {
            if (!e.target.classList.contains('del-social-row')) return;
            e.preventDefault();
            e.stopPropagation();
            var row = e.target.closest('tr');
            if (!row) return;
            if (row.hasAttribute('data-saved')) {
                fwConfirm('Delete Item?', 'Are you sure you want to delete this item?', function() {
                    row.remove();
                    saveCurrentSocialLinks();
                    fwToast('Social media deleted!');
                });
            } else {
                row.remove();
            }
        });

        function saveCurrentSocialLinks() {
            var rows = document.querySelectorAll('#social-media-table tbody tr');
            var data = [];
            for (var i = 0; i < rows.length; i++) {
                var sel = rows[i].querySelector('select');
                var inp = rows[i].querySelector('input[type="text"]');
                if (sel && inp) {
                    data.push(sel.value + '::' + inp.value);
                }
            }
            var xhr = new XMLHttpRequest();
            xhr.open('POST', socialAjaxUrl, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && typeof fwToast === 'function') {
                    fwToast('Social media deleted!');
                }
            };
            xhr.send('action=futuristict_save_social_media&nonce=' + encodeURIComponent(socialNonce) + '&links=' + encodeURIComponent(data.join('|||')));
        }
        </script>
    </div>
    <?php
}

function futuristict_save_social_media_ajax() {
    check_ajax_referer('futuristic_it_social_media_ajax', 'nonce');
    if (!current_user_can('manage_options')) wp_send_json_error();
    $raw = isset($_POST['links']) ? sanitize_text_field($_POST['links']) : '';
    $sanitized = array();
    if (!empty($raw)) {
        $items = explode('|||', $raw);
        foreach ($items as $item) {
            $parts = explode('::', $item, 2);
            if (count($parts) === 2 && !empty($parts[0])) {
                $sanitized[] = array('icon' => $parts[0], 'url' => $parts[1]);
            }
        }
    }
    update_option('custom_footer_social_links', wp_json_encode($sanitized));
    wp_send_json_success();
}
add_action('wp_ajax_futuristict_save_social_media', 'futuristict_save_social_media_ajax');

// ==========================================================================
// Floating Contact Buttons (Messenger / Telegram / ...)
// ==========================================================================

function futuristic_it_floating_button_platforms() {
    return array(
        'messenger' => __('Messenger', 'futuristic-it'),
        'telegram'  => __('Telegram', 'futuristic-it'),
        'whatsapp'  => __('WhatsApp', 'futuristic-it'),
        'zalo'      => __('Zalo', 'futuristic-it'),
        'line'      => __('LINE', 'futuristic-it'),
        'viber'     => __('Viber', 'futuristic-it'),
        'phone'     => __('Phone Call', 'futuristic-it'),
        'email'     => __('Email', 'futuristic-it'),
    );
}

function futuristic_it_floating_button_sizes() {
    return array(
        'small'  => 44,
        'medium' => 52,
        'large'  => 60,
    );
}

function futuristic_it_floating_button_icons() {
    return array(
        'messenger' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.36 2 2 6.13 2 11.7c0 2.91 1.19 5.44 3.14 7.17.16.14.26.35.27.57l.05 1.78c.02.57.6.94 1.12.71l1.99-.88c.17-.07.36-.09.54-.04 1.19.33 2.46.5 3.89.5 5.64 0 10-4.13 10-9.7S17.64 2 12 2zm6 7.46l-2.94 4.66c-.47.74-1.47.93-2.18.4l-2.34-1.75a.6.6 0 0 0-.72 0l-3.16 2.4c-.42.32-.97-.18-.69-.63l2.94-4.66c.47-.74 1.47-.93 2.18-.4l2.34 1.75c.21.16.51.16.72 0l3.16-2.4c.42-.32.97.18.69.63z"/></svg>',
        'telegram'  => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>',
        'whatsapp'  => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>',
        'zalo'      => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 5.94 2 10.8c0 2.77 1.44 5.24 3.7 6.87V22l3.4-1.87c.9.25 1.87.38 2.9.38 5.52 0 10-3.94 10-8.8S17.52 2 12 2zm1.5 12.3h-3.3v-1.4l2.4-3.3h-2.3V8.2h3.4v1.4l-2.4 3.3h2.2v1.4z"/></svg>',
        'line'      => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 5.7 2 10.25c0 4.08 3.63 7.5 8.53 8.15.33.07.79.22.9.5.1.26.07.66.03.92l-.14.87c-.04.26-.2 1.02.9.56 1.1-.46 5.9-3.48 8.05-5.96C21.7 13.9 22 12.1 22 10.25 22 5.7 17.52 2 12 2zM7.7 12.6H5.9c-.27 0-.5-.22-.5-.5V8.9c0-.28.23-.5.5-.5s.5.22.5.5v2.7h1.3c.28 0 .5.22.5.5s-.22.5-.5.5zm2-.5c0 .28-.22.5-.5.5s-.5-.22-.5-.5V8.9c0-.28.22-.5.5-.5s.5.22.5.5v3.2zm4.6 0c0 .21-.13.4-.33.47-.06.02-.11.03-.17.03-.15 0-.29-.07-.38-.18l-1.62-2.1v1.78c0 .28-.22.5-.5.5s-.5-.22-.5-.5V8.9c0-.21.13-.4.33-.47.06-.02.11-.03.17-.03.15 0 .29.07.38.18l1.62 2.1V8.9c0-.28.22-.5.5-.5s.5.22.5.5v3.2zm2.7-2.2c.28 0 .5.22.5.5s-.22.5-.5.5h-1.3v.7h1.3c.28 0 .5.22.5.5s-.22.5-.5.5h-1.8c-.28 0-.5-.22-.5-.5V8.9c0-.28.22-.5.5-.5h1.8c.28 0 .5.22.5.5s-.22.5-.5.5h-1.3v.7h1.3z"/></svg>',
        'viber'     => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 1C6.5 1 2 5.1 2 10.2c0 2.9 1.5 5.5 3.9 7.2v3.9c0 .5.6.8 1 .5l3.6-2.6c.5.1 1 .1 1.5.1 5.5 0 10-4.1 10-9.2S17.5 1 12 1zm-2.3 4.6c.3 0 .6.2.7.5l.6 1.6c.1.3 0 .6-.2.8l-.6.5c-.2.2-.2.4-.1.6.5.9 1.2 1.6 2.1 2.1.2.1.5.1.6-.1l.5-.6c.2-.2.5-.3.8-.2l1.6.6c.3.1.5.4.5.7v1c0 .5-.4.9-.9.9-3.9-.2-7.1-3.4-7.3-7.3 0-.6.4-1.1 1-1.1h.7z"/></svg>',
        'phone'     => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>',
        'email'     => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>',
    );
}

/**
 * Give a scheme-less destination an explicit https:// prefix.
 *
 * Without this, esc_url() would silently default a bare host like
 * "m.me/yourpage" to http://, and services such as m.me are https-only.
 * Applied on both save and render so values that reach the database by
 * another route (import, migration, older option) still link correctly.
 */
function futuristic_it_floating_normalize_scheme($url) {
    if ($url === '' || preg_match('#^[a-z][a-z0-9+.-]*:#i', $url)) return $url;
    return 'https://' . ltrim($url, '/');
}

/**
 * Normalize one repeater row into a storable shape.
 */
function futuristic_it_sanitize_floating_button_row($row) {
    $platforms = futuristic_it_floating_button_platforms();
    $platform  = sanitize_key($row['platform'] ?? '');
    if (!isset($platforms[$platform])) return null;

    $label = sanitize_text_field($row['label'] ?? '');
    $url   = trim((string) ($row['url'] ?? ''));

    // Phone / email get a raw value; everything else must be a real URL.
    if ($platform === 'phone') {
        $url = preg_replace('/[^0-9+*#,;]/', '', $url);
    } elseif ($platform === 'email') {
        $url = sanitize_email($url);
    } else {
        $url = esc_url_raw(futuristic_it_floating_normalize_scheme($url));
    }

    return array(
        'platform' => $platform,
        'label'    => $label,
        'url'      => $url,
    );
}

/**
 * Sanitize every row. Rows whose destination was non-empty but got stripped
 * (an unsupported scheme such as viber://, or a malformed address) are
 * collected so the admin can be told rather than silently losing a button.
 */
function futuristic_it_sanitize_floating_buttons($rows) {
    if (!is_array($rows)) return array();
    $clean = array();
    foreach ($rows as $row) {
        if (!is_array($row)) continue;
        $clean_row = futuristic_it_sanitize_floating_button_row($row);
        if ($clean_row === null) continue;

        $submitted = trim((string) ($row['url'] ?? ''));
        if ($submitted !== '' && $clean_row['url'] === '') {
            $GLOBALS['futuristic_it_floating_rejected'][] = $submitted;
        }
        $clean[] = $clean_row;
    }
    return $clean;
}

function futuristic_it_default_floating_buttons() {
    return array(
        array('platform' => 'messenger', 'label' => __('Chat with us', 'futuristic-it'), 'url' => ''),
    );
}

function futuristic_it_get_floating_buttons() {
    $stored = json_decode(get_option('custom_floating_buttons', ''), true);
    if (!is_array($stored)) return futuristic_it_default_floating_buttons();
    return $stored;
}

/**
 * Build the final href for a button, handling tel: / mailto: platforms.
 */
function futuristic_it_floating_button_href($button) {
    $url = $button['url'] ?? '';
    if ($url === '') return '';

    switch ($button['platform'] ?? '') {
        case 'phone':
            return 'tel:' . preg_replace('/[^0-9+*#,;]/', '', $url);
        case 'email':
            return 'mailto:' . $url;
        default:
            return futuristic_it_floating_normalize_scheme($url);
    }
}

/**
 * Class + inline CSS variables for the shared fixed dock in footer.php.
 * The dock holds both the floating buttons and the back-to-top button so
 * the two can never overlap, whatever the configured options are.
 */
function futuristic_it_floating_dock_class() {
    $position = get_option('custom_floating_position', 'right');
    if (!in_array($position, array('right', 'left'), true)) $position = 'right';
    return 'fc-pos-' . $position;
}

function futuristic_it_floating_dock_style() {
    $offset = absint(get_option('custom_floating_bottom', 30));
    if ($offset > 300) $offset = 300;

    $sizes    = futuristic_it_floating_button_sizes();
    $size_key = get_option('custom_floating_size', 'medium');
    $size     = isset($sizes[$size_key]) ? $sizes[$size_key] : 52;

    return sprintf('--fc-bottom:%dpx;--fc-side:%dpx;--fc-size:%dpx;', $offset, $offset, $size);
}

/**
 * Frontend output. Renders nothing when no button has a destination set yet.
 */
function futuristic_it_render_floating_buttons() {
    $buttons = futuristic_it_get_floating_buttons();
    if (empty($buttons)) return;

    $icons = futuristic_it_floating_button_icons();
    $platforms = futuristic_it_floating_button_platforms();

    $rendered = array();
    foreach ($buttons as $button) {
        // Guard against a platform that no longer exists in the list.
        if (!isset($platforms[$button['platform'] ?? ''])) continue;
        $href = futuristic_it_floating_button_href($button);
        if ($href === '') continue;
        $rendered[] = array('button' => $button, 'href' => $href);
    }
    if (empty($rendered)) return;

    $widget_class = 'fc-widget';
    ?>
    <div class="<?php echo esc_attr($widget_class); ?>">
        <?php foreach ($rendered as $item) :
            $button   = $item['button'];
            $platform = $button['platform'];
            $label    = $button['label'] !== '' ? $button['label'] : $platforms[$platform];
            $icon     = $icons[$platform] ?? '';
            $is_external = !in_array($platform, array('phone', 'email'), true);
        ?>
            <a class="fc-btn fc-<?php echo esc_attr($platform); ?>"
               href="<?php echo esc_url($item['href']); ?>"
               aria-label="<?php echo esc_attr($label); ?>"
               <?php if ($is_external) : ?>target="_blank" rel="noopener noreferrer"<?php endif; ?>>
                <?php echo $icon; ?>
                <span class="fc-label"><?php echo esc_html($label); ?></span>
            </a>
        <?php endforeach; ?>
    </div>
    <?php
}

// Floating Buttons Admin Page
function futuristict_floating_buttons_page() {
    if (isset($_POST['futuristic_it_save_floating_buttons']) && check_admin_referer('futuristic_it_floating_buttons')) {
        $GLOBALS['futuristic_it_floating_rejected'] = array();
        $buttons = futuristic_it_sanitize_floating_buttons($_POST['floating_buttons'] ?? array());
        update_option('custom_floating_buttons', wp_json_encode($buttons));

        futuristic_it_toast('Floating buttons saved!');
    }

    $buttons   = futuristic_it_get_floating_buttons();
    $platforms = futuristic_it_floating_button_platforms();
    $rejected  = $GLOBALS['futuristic_it_floating_rejected'] ?? array();
    ?>
    <div class="wrap">
        <h1><?php _e('Floating Buttons', 'futuristic-it'); ?></h1>
        <p><a href="<?php echo admin_url('admin.php?page=futuristict-website'); ?>">&larr; Back</a></p>
        <?php if (!empty($rejected)) : ?>
            <div class="notice notice-warning">
                <p>
                    <strong><?php _e('Some destinations were not saved because they are not valid links:', 'futuristic-it'); ?></strong>
                    <?php echo esc_html(implode(', ', array_unique($rejected))); ?>
                </p>
                <p>
                    <?php _e('Use a full web address (for example https://wa.me/85512345678). App deep links such as viber:// or zalo:// are not allowed for security reasons and are removed.', 'futuristic-it'); ?>
                </p>
            </div>
        <?php endif; ?>
        <p style="color:#666;max-width:760px;">
            <?php _e('Fixed contact buttons shown at the bottom corner of every page. They stack in the same column as the "Back to top" button, which moves up automatically so nothing overlaps.', 'futuristic-it'); ?>
        </p>
        <form method="post" action="">
            <?php wp_nonce_field('futuristic_it_floating_buttons'); ?>

            <h2><?php _e('Buttons', 'futuristic-it'); ?></h2>
            <p class="description" style="margin-bottom:10px;">
                <?php _e('A button only appears on the site once it has a destination filled in.', 'futuristic-it'); ?>
            </p>
            <table class="widefat striped" id="floating-buttons-table">
                <thead>
                    <tr>
                        <th style="width:150px;"><?php _e('Platform', 'futuristic-it'); ?></th>
                        <th style="width:190px;"><?php _e('Label', 'futuristic-it'); ?></th>
                        <th><?php _e('Destination', 'futuristic-it'); ?></th>
                        <th style="width:120px;"></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($buttons as $i => $b) : ?>
                    <tr data-saved="1">
                        <td>
                            <select name="floating_buttons[<?php echo $i; ?>][platform]" style="width:100%">
                                <?php foreach ($platforms as $key => $name) : ?>
                                    <option value="<?php echo esc_attr($key); ?>" <?php selected($b['platform'] ?? '', $key); ?>><?php echo esc_html($name); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td><input type="text" name="floating_buttons[<?php echo $i; ?>][label]" value="<?php echo esc_attr($b['label'] ?? ''); ?>" class="widefat" placeholder="<?php esc_attr_e('Chat with us', 'futuristic-it'); ?>"></td>
                        <td>
                            <input type="text" name="floating_buttons[<?php echo $i; ?>][url]" value="<?php echo esc_attr($b['url'] ?? ''); ?>" class="widefat" placeholder="https://m.me/yourpage">
                            <p class="description" style="margin:4px 0 0;"><?php _e('Phone Call: enter the number (e.g. +85512345678). Email: enter the address. Others: full URL.', 'futuristic-it'); ?></p>
                        </td>
                        <td>
                            <button type="button" class="button button-small move-floating-row" data-dir="-1" title="<?php esc_attr_e('Move up', 'futuristic-it'); ?>">&uarr;</button>
                            <button type="button" class="button button-small move-floating-row" data-dir="1" title="<?php esc_attr_e('Move down', 'futuristic-it'); ?>">&darr;</button>
                            <button type="button" class="button button-small del-floating-row" style="color:#dc3545;"><?php _e('Remove', 'futuristic-it'); ?></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <p><button type="button" class="button" id="add-floating-button">+ <?php _e('Add Button', 'futuristic-it'); ?></button></p>
            <input type="submit" name="futuristic_it_save_floating_buttons" class="button button-primary" value="<?php _e('Save Floating Buttons', 'futuristic-it'); ?>">
        </form>
        <script>
        var floatingCount = <?php echo count($buttons); ?>;
        var floatingAjaxUrl = '<?php echo admin_url('admin-ajax.php'); ?>';
        var floatingNonce = '<?php echo wp_create_nonce('futuristic_it_floating_buttons_ajax'); ?>';
        var floatingPlatforms = <?php echo wp_json_encode($platforms); ?>;

        function floatingRowHtml(idx) {
            var opts = '';
            for (var key in floatingPlatforms) {
                opts += '<option value="' + key + '">' + floatingPlatforms[key] + '</option>';
            }
            return '<tr>' +
                '<td><select name="floating_buttons[' + idx + '][platform]" style="width:100%">' + opts + '</select></td>' +
                '<td><input type="text" name="floating_buttons[' + idx + '][label]" value="" class="widefat" placeholder="Chat with us"></td>' +
                '<td><input type="text" name="floating_buttons[' + idx + '][url]" value="" class="widefat" placeholder="https://..."></td>' +
                '<td>' +
                    '<button type="button" class="button button-small move-floating-row" data-dir="-1" title="Move up">&uarr;</button> ' +
                    '<button type="button" class="button button-small move-floating-row" data-dir="1" title="Move down">&darr;</button> ' +
                    '<button type="button" class="button button-small del-floating-row" style="color:#dc3545;">Remove</button>' +
                '</td>' +
                '</tr>';
        }

        document.getElementById('add-floating-button').addEventListener('click', function() {
            document.querySelector('#floating-buttons-table tbody')
                .insertAdjacentHTML('beforeend', floatingRowHtml(floatingCount));
            floatingCount++;
        });

        function saveCurrentFloatingButtons() {
            var rows = document.querySelectorAll('#floating-buttons-table tbody tr');
            var data = [];
            for (var i = 0; i < rows.length; i++) {
                var sel = rows[i].querySelector('select');
                var inputs = rows[i].querySelectorAll('input[type="text"]');
                if (sel && inputs.length >= 2) {
                    data.push({
                        platform: sel.value,
                        label: inputs[0].value,
                        url: inputs[1].value
                    });
                }
            }
            var xhr = new XMLHttpRequest();
            xhr.open('POST', floatingAjaxUrl, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('action=futuristict_save_floating_buttons&nonce=' + encodeURIComponent(floatingNonce) +
                     '&links=' + encodeURIComponent(JSON.stringify(data)));
        }

        document.querySelector('#floating-buttons-table tbody').addEventListener('click', function(e) {
            var moveBtn = e.target.closest('.move-floating-row');
            if (moveBtn) {
                e.preventDefault();
                var row = moveBtn.closest('tr');
                var dir = parseInt(moveBtn.getAttribute('data-dir'), 10);
                if (dir === -1 && row.previousElementSibling) {
                    row.parentNode.insertBefore(row, row.previousElementSibling);
                } else if (dir === 1 && row.nextElementSibling) {
                    row.parentNode.insertBefore(row.nextElementSibling, row);
                }
                fwReindexRows(document.getElementById('floating-buttons-table'));
                return;
            }

            var delBtn = e.target.closest('.del-floating-row');
            if (!delBtn) return;
            e.preventDefault();
            var delRow = delBtn.closest('tr');
            if (!delRow) return;
            if (delRow.hasAttribute('data-saved')) {
                fwConfirm('Delete Button?', 'Are you sure you want to delete this button?', function() {
                    delRow.remove();
                    fwReindexRows(document.getElementById('floating-buttons-table'));
                    saveCurrentFloatingButtons();
                    fwToast('Floating button deleted!');
                });
            } else {
                delRow.remove();
                fwReindexRows(document.getElementById('floating-buttons-table'));
            }
        });
        </script>
    </div>
    <?php
}

function futuristict_save_floating_buttons_ajax() {
    check_ajax_referer('futuristic_it_floating_buttons_ajax', 'nonce');
    if (!current_user_can('manage_options')) wp_send_json_error();

    $raw = isset($_POST['links']) ? wp_unslash($_POST['links']) : '';
    $rows = json_decode($raw, true);
    if (!is_array($rows)) wp_send_json_error();

    update_option('custom_floating_buttons', wp_json_encode(futuristic_it_sanitize_floating_buttons($rows)));
    wp_send_json_success();
}
add_action('wp_ajax_futuristict_save_floating_buttons', 'futuristict_save_floating_buttons_ajax');

// Home Slider Admin Page
function futuristict_homepage_slider_page() {
    if (isset($_POST['futuristic_it_save_homepage_slider']) && check_admin_referer('futuristic_it_homepage_slider')) {
        if (isset($_POST['sliders']) && is_array($_POST['sliders'])) {
            $sanitized = array();
            foreach ($_POST['sliders'] as $sl) {
                $sanitized[] = array(
                    'image' => sanitize_text_field($sl['image'] ?? ''),
                    'order' => intval($sl['order'] ?? 0),
                );
            }
            usort($sanitized, function($a, $b) { return $a['order'] - $b['order']; });
            update_option('custom_homepage_sliders', wp_json_encode($sanitized));
        }
        futuristic_it_toast('Slider saved!');
    }
    $sliders = json_decode(get_option('custom_homepage_sliders', '[]'), true);
    if (!is_array($sliders)) $sliders = array();
    ?>
    <div class="wrap">
        <h1><?php _e('Home – Slider Section', 'futuristic-it'); ?></h1>
        <p><a href="<?php echo admin_url('admin.php?page=futuristict-homepage'); ?>">&larr; Back</a></p>
        <form method="post" action="">
            <?php wp_nonce_field('futuristic_it_homepage_slider'); ?>
            <table class="widefat striped" id="slider-table">
                <thead>
                    <tr>
                        <th style="width:80px"><?php _e('Order', 'futuristic-it'); ?></th>
                        <th><?php _e('Image', 'futuristic-it'); ?></th>
                        <th style="width:60px"></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($sliders as $i => $sl) : ?>
                    <tr data-saved="1">
                        <td><input type="number" name="sliders[<?php echo $i; ?>][order]" value="<?php echo esc_attr($sl['order'] ?? $i); ?>" style="width:60px;" min="0"></td>
                        <td>
                            <input type="hidden" name="sliders[<?php echo $i; ?>][image]" value="<?php echo esc_attr($sl['image'] ?? ''); ?>">
                            <?php if (!empty($sl['image'])) : ?>
                                <img src="<?php echo esc_url($sl['image']); ?>" style="width:150px;height:80px;object-fit:cover;border-radius:4px;">
                            <?php endif; ?>
                            <br><a href="#" class="button button-small upload-btn" data-for="sliders[<?php echo $i; ?>][image]">Upload</a>
                        </td>
                        <td><button type="button" class="button button-small del-row" style="color:#dc3545;">Delete</button></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <p><button type="button" class="button" id="add-slider">+ <?php _e('Add Slide', 'futuristic-it'); ?></button></p>
            <input type="submit" name="futuristic_it_save_homepage_slider" class="button button-primary" value="<?php _e('Save Slider', 'futuristic-it'); ?>">
        </form>
        <script>
        var sliderCount = <?php echo count($sliders); ?>;
        document.getElementById('add-slider').addEventListener('click', function() {
            var idx = sliderCount;
            var html = '<tr>' +
                '<td><input type="number" name="sliders[' + idx + '][order]" value="' + idx + '" style="width:60px;" min="0"></td>' +
                '<td><input type="hidden" name="sliders[' + idx + '][image]" value=""><a href="#" class="button button-small upload-btn" data-for="sliders[' + idx + '][image]">Upload</a></td>' +
                '<td><button type="button" class="button button-small del-row" style="color:#dc3545;">Delete</button></td>' +
                '</tr>';
            document.querySelector('#slider-table tbody').insertAdjacentHTML('beforeend', html);
            sliderCount++;
        });
        </script>
    </div>
    <?php
}

// Card Styles and Media Upload
function futuristic_it_admin_card_styles() {
    global $pagenow;
    if ($pagenow !== 'admin.php' || !isset($_GET['page']) || strpos($_GET['page'], 'futuristict') === false) return;
    ?>
    <style>
        .fw-cards { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; margin-top: 20px; }
        .fw-card { background: #fff; border: 1px solid #e0e0e0; border-radius: 12px; padding: 28px 24px; transition: all 0.3s cubic-bezier(0.4,0,0.2,1); text-decoration: none; color: inherit; display: block; position: relative; overflow: hidden; }
        .fw-card::before { content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 0; background: linear-gradient(135deg, #1a3d27, #285d38); transition: height 0.3s ease; }
        .fw-card:hover { border-color: #1a3d27; box-shadow: 0 8px 25px rgba(26,61,39,0.12); transform: translateY(-3px); }
        .fw-card:hover::before { height: 100%; }
        .fw-card h3 { margin: 0 0 8px; font-size: 17px; color: #1a2620; font-weight: 700; }
        .fw-card p { margin: 0; font-size: 13px; color: #888; line-height: 1.6; }
        .fw-card:hover h3 { color: #1a3d27; }
        /* Count chip on the module landing cards. Sits at the foot of the card
           so cards of different copy lengths still line up. */
        .fw-card-count { display: inline-block; margin-top: 14px; font-size: 11px; font-weight: 700; letter-spacing: 0.04em; text-transform: uppercase; color: #1a3d27; background: #eef3ef; border: 1px solid #dbe6de; border-radius: 999px; padding: 4px 12px; }
        .fw-card:hover .fw-card-count { background: #1a3d27; border-color: #1a3d27; color: #fff; }
        .fw-modal-overlay { position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:999999;display:flex;align-items:center;justify-content:center; }
        .fw-modal-box { background:#fff;border-radius:16px;padding:36px 40px;max-width:420px;width:90%;text-align:center;box-shadow:0 20px 60px rgba(0,0,0,0.3);animation:fwModalIn 0.25s ease; }
        .fw-modal-icon { width:56px;height:56px;border-radius:50%;background:#fee2e2;margin:0 auto 16px;display:flex;align-items:center;justify-content:center;font-size:26px; }
        .fw-modal-title { margin:0 0 8px;font-size:18px;color:#1a2620;font-weight:700; }
        .fw-modal-desc { margin:0 0 24px;color:#666;font-size:14px;line-height:1.5; }
        .fw-modal-btns { display:flex;gap:12px;justify-content:center; }
        .fw-modal-btn-no { padding:10px 28px;border-radius:8px;border:1px solid #ddd;background:#fff;color:#333;font-size:14px;font-weight:600;cursor:pointer;transition:all 0.2s; }
        .fw-modal-btn-no:hover { background:#f5f5f5; }
        .fw-modal-btn-yes { padding:10px 28px;border-radius:8px;border:none;background:#dc3545;color:#fff;font-size:14px;font-weight:600;cursor:pointer;transition:all 0.2s; }
        .fw-modal-btn-yes:hover { background:#a71d2a; }
        @keyframes fwModalIn { from{opacity:0;transform:scale(0.9)} to{opacity:1;transform:scale(1)} }
        .fw-toast { position:fixed;top:20px;right:-400px;background:#fff;border-left:4px solid #28a745;border-radius:8px;padding:16px 24px;box-shadow:0 8px 30px rgba(0,0,0,0.15);z-index:999999;transition:right 0.4s cubic-bezier(0.4,0,0.2,1);display:flex;align-items:center;gap:12px;min-width:300px;max-width:420px; }
        .fw-toast.show { right:20px; }
        .fw-toast-icon { width:36px;height:36px;border-radius:50%;background:#d4edda;color:#28a745;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0; }
        .fw-toast-text { font-size:14px;font-weight:600;color:#1a2620; }
    </style>
    <div id="fw-toast" class="fw-toast">
        <div class="fw-toast-icon">✓</div>
        <span class="fw-toast-text" id="fw-toast-text"></span>
    </div>
    <div id="fw-delete-modal" class="fw-modal-overlay" style="display:none;">
        <div class="fw-modal-box">
            <div class="fw-modal-icon">🗑️</div>
            <h3 class="fw-modal-title" id="fw-modal-title">Delete Item?</h3>
            <p class="fw-modal-desc" id="fw-modal-desc">Are you sure you want to delete this item? This action cannot be undone.</p>
            <div class="fw-modal-btns">
                <button class="fw-modal-btn-no" onclick="document.getElementById('fw-delete-modal').style.display='none';">No</button>
                <button class="fw-modal-btn-yes" onclick="document.getElementById('fw-delete-modal').style.display='none';if(window.fwDeleteCallback)window.fwDeleteCallback();">Yes</button>
            </div>
        </div>
    </div>
    <script>
    window.fwDeleteCallback = null;
    function fwConfirm(title, desc, callback) {
        document.getElementById('fw-modal-title').textContent = title;
        document.getElementById('fw-modal-desc').textContent = desc;
        window.fwDeleteCallback = callback;
        document.getElementById('fw-delete-modal').style.display = 'flex';
    }
    function fwToast(msg) {
        var t = document.getElementById('fw-toast');
        if (t) {
            document.getElementById('fw-toast-text').textContent = msg;
            t.classList.add('show');
            setTimeout(function() { t.classList.remove('show'); }, 3000);
        }
    }
    function fwReindexRows(table) {
        if (!table) return;
        table.querySelectorAll('tbody > tr').forEach(function(row, idx) {
            row.querySelectorAll('[name]').forEach(function(field) {
                field.name = field.name.replace(/^([^\[]+)\[\d+\]/, '$1[' + idx + ']');
            });
            row.querySelectorAll('[data-for]').forEach(function(btn) {
                btn.setAttribute('data-for', btn.getAttribute('data-for').replace(/^([^\[]+)\[\d+\]/, '$1[' + idx + ']'));
            });
            // The step number is rendered, not submitted, so it has to be
            // rewritten here or it keeps the number the row had on page load.
            var num = row.querySelector('.process-num');
            if (num) num.textContent = idx + 1;
        });
    }
    document.addEventListener('click', function(e) {
        // Upload image
        var btn = e.target.closest('.upload-btn');
        if (btn) {
            e.preventDefault();
            var name = btn.getAttribute('data-for');
            if (typeof wp === 'undefined' || typeof wp.media === 'undefined') {
                alert('Media library not loaded. Please refresh.');
                return;
            }
            var frame = wp.media({title: 'Select Image', button: {text: 'Use This Image'}, multiple: false});
            frame.on('select', function() {
                var url = frame.state().get('selection').first().toJSON().url;
                var input = document.querySelector('input[name="' + name + '"]');
                if (input) {
                    input.value = url;
                    var isFeatureCard = name.indexOf('prod_feature_cards') !== -1;
                    if (!isFeatureCard) {
                        var container = input.closest('td') || input.closest('.product-image-row') || input.parentElement;
                        if (container) {
                            var oldImg = container.querySelector('.product-image-preview, img');
                            if (oldImg) {
                                oldImg.src = url;
                                oldImg.style.display = 'block';
                            } else {
                                container.insertAdjacentHTML('afterbegin', '<img class="product-image-preview" src="' + url + '" style="max-height:80px;border-radius:4px;">');
                            }
                        }
                    }
                    var iconBox = input.closest('.prod-feature-card-row');
                    if (iconBox) {
                        var preview = iconBox.querySelector('.fc-icon-preview');
                        if (preview) {
                            var sp = preview.querySelector('span');
                            if (sp) sp.style.display = 'none';
                            var im = preview.querySelector('img');
                            if (im) { im.src = url; im.style.display = 'block'; }
                            else { preview.insertAdjacentHTML('beforeend', '<img src="' + url + '" style="width:100%;height:100%;object-fit:contain;">'); }
                        }
                    }
                }
            });
            frame.open();
            return;
        }
        // Upload video
        var vbtn = e.target.closest('.prod-upload-video');
        if (vbtn) {
            e.preventDefault();
            var vname = vbtn.getAttribute('data-for');
            if (typeof wp === 'undefined' || typeof wp.media === 'undefined') {
                alert('Media library not loaded. Please refresh.');
                return;
            }
            var vframe = wp.media({title: 'Select Video', button: {text: 'Use This Video'}, multiple: false, library: {type: 'video'}});
            vframe.on('select', function() {
                var attachment = vframe.state().get('selection').first().toJSON();
                var url = attachment.url;
                var input = document.getElementById(vname);
                if (input) {
                    input.value = url;
                    var preview = input.parentElement.querySelector('.prod-video-preview');
                    if (preview) preview.textContent = url;
                }
            });
            vframe.open();
            return;
        }
        function fwAutoSave(form) {
            var fd = new FormData(form);
            var btn = form.querySelector('input[type="submit"]');
            if (btn) fd.append(btn.name, btn.value);
            fetch(window.location.href, {method:'POST', body:fd, credentials:'same-origin'});
        }
        // Delete card
        if (e.target.classList.contains('del-card')) {
            e.preventDefault();
            var el = e.target;
            var cardBox = el.closest('.svc-card-box');
            var frm = el.closest('form');
            if (cardBox && cardBox.hasAttribute('data-saved')) {
                fwConfirm('Delete Card?', 'Are you sure you want to delete this card?', function(){
                    cardBox.remove();
                    fwToast('Card deleted!');
                    if (frm) fwAutoSave(frm);
                });
            } else {
                cardBox.remove();
                if (frm) fwAutoSave(frm);
            }
            return;
        }
        // Move row up/down
        if (e.target.classList.contains('move-row-up') || e.target.classList.contains('move-row-down')) {
            e.preventDefault();
            var mRow = e.target.closest('tr');
            if (!mRow) return;
            var up = e.target.classList.contains('move-row-up');
            var sibling = up ? mRow.previousElementSibling : mRow.nextElementSibling;
            if (!sibling) return;
            if (up) mRow.parentNode.insertBefore(mRow, sibling);
            else mRow.parentNode.insertBefore(sibling, mRow);
            fwReindexRows(mRow.closest('table'));
            var mForm = mRow.closest('form');
            if (mForm) fwAutoSave(mForm);
            return;
        }
        // Delete row
        if (e.target.classList.contains('del-row')) {
            e.preventDefault();
            var el2 = e.target;
            var row = el2.closest('tr');
            var frm = el2.closest('form');
            if (row) {
                row.remove();
                if (frm) fwAutoSave(frm);
            }
            return;
        }
        // Delete feature
        if (e.target.classList.contains('del-feature')) {
            e.preventDefault();
            e.target.closest('.feature-row').remove();
            return;
        }
        // Add service card
        if (e.target.id === 'add-card') {
            e.preventDefault();
            var idx = document.querySelectorAll('.svc-card-box').length;
            var prefix = 'custom_service_cards';
            var html = '<div class="svc-card-box" style="background:#fff;border:1px solid #ddd;border-radius:8px;padding:20px;margin-bottom:16px;">' +
                '<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">' +
                '<h3 style="margin:0;">Card ' + (idx + 1) + '</h3>' +
                '<button type="button" class="button button-small del-card" style="color:#dc3545;">Delete Card</button></div>' +
                '<table class="form-table" style="margin:0;">' +
                '<tr><th><label>Image</label></th><td><input type="hidden" name="custom_service_cards[' + idx + '][image]" value=""><a href="#" class="button button-small upload-btn" data-for="custom_service_cards[' + idx + '][image]">Upload Image</a></td></tr>' +
                '<tr><th><label>Title</label></th><td><input type="text" class="regular-text" name="custom_service_cards[' + idx + '][title]" value="" style="width:100%;"></td></tr>' +
                '<tr><th><label>Description</label></th><td><textarea class="large-text" name="custom_service_cards[' + idx + '][desc]" rows="3" style="width:100%;resize:vertical;min-height:60px;"></textarea></td></tr>' +
                '<tr><th><label>Type</label></th><td><select name="custom_service_cards[' + idx + '][type]" style="width:100%;max-width:300px;"><option value="Detail">Detail</option><option value="Contact">Contact</option><option value="Course">Course</option></select></td></tr>' +
                '</table>' +
                '<h4 style="margin:16px 0 8px;">Features</h4>' +
                '<div class="svc-features-container" id="svc-features-' + idx + '">' +
                '<div class="svc-feature-row" style="display:flex;align-items:center;gap:12px;margin-bottom:8px;padding:10px;background:#f9f9f9;border-radius:6px;">' +
                '<input type="text" name="custom_service_cards[' + idx + '][features][0][title]" value="" placeholder="Feature title" style="flex:1;">' +
                '<input type="text" name="custom_service_cards[' + idx + '][features][0][desc]" value="" placeholder="Feature description" style="flex:2;">' +
                '<button type="button" class="button button-small" style="color:#dc3545;" onclick="this.closest(\'.svc-feature-row\').remove();">Remove</button>' +
                '</div></div>' +
                '<p><button type="button" class="button button-small add-svc-feature" data-card="' + idx + '">+ Add Feature</button></p>' +
                '<table class="form-table" style="margin:0;">' +
                '<tr><th><label>Link URL</label></th><td><input type="text" class="regular-text" name="custom_service_cards[' + idx + '][link]" value="#" style="width:100%;"></td></tr>' +
                '</table></div>';
            e.target.insertAdjacentHTML('beforebegin', html);
            // Re-attach event listener for new add-svc-feature button
            var newBtn = e.target.previousElementSibling.querySelector('.add-svc-feature');
            if (newBtn) {
                newBtn.addEventListener('click', function() {
                    var cardIdx = this.getAttribute('data-card');
                    var container = document.getElementById('svc-features-' + cardIdx);
                    var featIdx = container.querySelectorAll('.svc-feature-row').length;
                    var featPrefix = 'custom_service_cards[' + cardIdx + '][features][' + featIdx + ']';
                    var featHtml = '<div class="svc-feature-row" style="display:flex;align-items:center;gap:12px;margin-bottom:8px;padding:10px;background:#f9f9f9;border-radius:6px;">' +
                        '<input type="text" name="' + featPrefix + '[title]" value="" placeholder="Feature title" style="flex:1;">' +
                        '<button type="button" class="button button-small" style="color:#dc3545;" onclick="this.closest(\'.svc-feature-row\').remove();">Remove</button>' +
                        '</div>';
                    container.insertAdjacentHTML('beforeend', featHtml);
                });
            }
            return;
        }
        // Add feature
        if (e.target.classList.contains('add-feature')) {
            e.preventDefault();
            var ci = e.target.getAttribute('data-card');
            var fi = e.target.closest('.features-repeater').querySelectorAll('.feature-row').length;
            var r = '<div class="feature-row" style="display:flex;gap:8px;margin-bottom:6px;align-items:center;">' +
                '<input type="hidden" name="custom_service_cards[' + ci + '][features][' + fi + '][icon]" value="✓">' +
                '<span style="width:22px;height:22px;border-radius:50%;border:2px solid #1a3d27;display:inline-flex;align-items:center;justify-content:center;font-size:12px;flex-shrink:0;color:#1a3d27;">✓</span>' +
                '<input type="text" name="custom_service_cards[' + ci + '][features][' + fi + '][text]" value="" class="regular-text" style="flex:1;">' +
                '<button type="button" class="button button-small del-feature" style="color:#dc3545;">×</button></div>';
            e.target.closest('.features-repeater').insertAdjacentHTML('beforeend', r);
            return;
        }
        // Delete feature
        if (e.target.classList.contains('del-feature')) {
            e.preventDefault();
            e.target.closest('.feature-row').remove();
            return;
        }
        // Process steps have a composite cell (title + description + timing in
        // one column), which the generic column builder below cannot express,
        // so this row is built on its own.
        if (e.target.id === 'add-process-step') {
            e.preventDefault();
            var stepBody = document.querySelector('#process-table tbody');
            if (!stepBody) return;
            var si = stepBody.querySelectorAll('tr').length;
            var pf = 'custom_procurement_steps[' + si + ']';
            var kmStyle = ' style="font-family:\'Noto Sans Khmer\',sans-serif;"';
            stepBody.insertAdjacentHTML('beforeend',
                '<tr>' +
                '<td><strong class="process-num">' + (si + 1) + '</strong></td>' +
                '<td>' +
                    '<input type="text" name="' + pf + '[title]" value="" class="widefat" style="margin-bottom:6px;">' +
                    '<textarea name="' + pf + '[desc]" class="widefat" rows="3"></textarea>' +
                    '<input type="text" name="' + pf + '[meta]" value="" class="widefat" style="margin-top:6px;">' +
                '</td>' +
                '<td>' +
                    '<input type="text" name="' + pf + '[title_km]" value="" class="widefat"' + kmStyle + ' style="font-family:\'Noto Sans Khmer\',sans-serif;margin-bottom:6px;">' +
                    '<textarea name="' + pf + '[desc_km]" class="widefat" rows="3"' + kmStyle + '></textarea>' +
                    '<input type="text" name="' + pf + '[meta_km]" value="" class="widefat" style="font-family:\'Noto Sans Khmer\',sans-serif;margin-top:6px;">' +
                '</td>' +
                '<td><button type="button" class="button button-small del-row" style="color:#dc3545;">Delete</button></td>' +
                '</tr>');
            return;
        }
        // Generic add buttons for tables
        var addIds = ['add-svc', 'add-prod', 'add-partner', 'add-cta-feature', 'add-philosophy', 'add-timeline', 'add-stat', 'add-licence', 'add-customer-type', 'add-procurement'];
        addIds.forEach(function(id) {
            if (e.target.id === id) {
                e.preventDefault();
                var map = {
                    'add-svc': {table: 'svc-table', prefix: 'custom_service_cards', cols: ['image','title','title_km','desc','desc_km','link','link_text','link_text_km']},
                    'add-prod': {table: 'prod-table', prefix: 'custom_product_cards', sortable: true, cols: ['type','image','title','title_km','desc','desc_km','category','badge','badge_km','price','link','link_text','link_text_km']},
                    'add-partner': {table: 'partner-table', prefix: 'custom_partner_cards', cols: ['image','title','title_km','desc','desc_km']},
                    'add-cta-feature': {table: 'cta-features-table', prefix: 'cta_features', cols: ['icon','title','title_km','desc','desc_km']},
                    'add-philosophy': {table: 'philosophy-table', prefix: 'philosophy_cards', cols: ['icon','title','title_km','desc','desc_km']},
                    'add-timeline': {table: 'timeline-table', prefix: 'custom_about_timeline', cols: ['year','title','title_km','desc','desc_km']},
                    'add-stat': {table: 'stats-table', prefix: 'custom_services_stats', cols: ['icon','label','label_km','desc','desc_km']},
                    'add-licence': {table: 'licence-table', prefix: 'custom_licence_options', cols: ['name','name_km']},
                    'add-customer-type': {table: 'customer-type-table', prefix: 'custom_customer_type_options', cols: ['name','name_km']},
                    'add-procurement': {table: 'procurement-table', prefix: 'custom_procurement_cards', cols: ['icon','name','name_km']}
                };
                var m = map[id];
                if (!m) return;
                var tbody = document.querySelector('#' + m.table + ' tbody');
                var si = tbody.querySelectorAll('tr').length;
                var r = '<tr>';
                if (m.sortable) {
                    r += '<td><button type="button" class="button button-small move-row-up" title="Move up">↑</button> <button type="button" class="button button-small move-row-down" title="Move down">↓</button></td>';
                }
                m.cols.forEach(function(c) {
                    if (c === 'image' || c === 'icon') {
                        r += '<td><input type="hidden" name="' + m.prefix + '[' + si + '][' + c + ']" value=""><a href="#" class="button button-small upload-btn" data-for="' + m.prefix + '[' + si + '][' + c + ']">Upload</a></td>';
                    } else if (c === 'desc' || c === 'text' || c === 'desc_km') {
                        var style = c === 'desc_km' ? ' style="font-family:\'Noto Sans Khmer\',sans-serif;"' : '';
                        r += '<td><textarea name="' + m.prefix + '[' + si + '][' + c + ']" class="widefat" rows="2"' + style + '></textarea></td>';
                    } else if (c === 'year') {
                        r += '<td><input type="text" name="' + m.prefix + '[' + si + '][' + c + ']" value="" style="width:80px"></td>';
                    } else if (c === 'price') {
                        r += '<td><input type="text" name="' + m.prefix + '[' + si + '][' + c + ']" value="$999" class="widefat"></td>';
                    } else if (c === 'type') {
                        r += '<td><select name="' + m.prefix + '[' + si + '][type]" class="widefat"><option value="Software">Software</option><option value="Hardware">Hardware</option><option value="Add">Add</option></select></td>';
                    } else if (c.indexOf('_km') !== -1) {
                        r += '<td><input type="text" name="' + m.prefix + '[' + si + '][' + c + ']" value="" class="widefat" style="font-family:\'Noto Sans Khmer\',sans-serif;"></td>';
                    } else {
                        r += '<td><input type="text" name="' + m.prefix + '[' + si + '][' + c + ']" value="" class="widefat"></td>';
                    }
                });
                r += '<td><button type="button" class="button button-small del-row" style="color:#dc3545;">Delete</button></td></tr>';
                tbody.insertAdjacentHTML('beforeend', r);
                handleAddType(tbody.lastElementChild);
            }
        });

        function handleAddType(row) {
            var typeSelect = row.querySelector('select[name$="[type]"]');
            if (!typeSelect) return;
            function toggleFields() {
                var isAdd = typeSelect.value === 'Add';
                var cells = row.querySelectorAll('td');
            }
            typeSelect.addEventListener('change', toggleFields);
            toggleFields();
        }
        document.querySelectorAll('#prod-table tbody tr').forEach(handleAddType);
        // Remove logo
        if (e.target.id === 'remove-logo-btn') {
            e.preventDefault();
            document.getElementById('custom_footer_logo_image').value = '';
            var preview = document.getElementById('logo-preview');
            if (preview) preview.remove();
            e.target.style.display = 'none';
        }
    });
    </script>
    <?php
}
add_action('admin_footer', 'futuristic_it_admin_card_styles');
add_action('admin_head', function() {
    global $pagenow;
    if ($pagenow === 'admin.php' && isset($_GET['page']) && strpos($_GET['page'], 'futuristict') !== false) {
        echo '<style>#wpfooter, #footer-left, #footer-upgrade { display: none !important; }</style>';
    }
});

// Enqueue media on futuristict admin pages
function futuristic_it_enqueue_media($hook) {
    if (strpos($hook, 'futuristict') !== false || strpos($hook, 'admin.php') !== false) {
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'futuristic_it_enqueue_media');

// Register widget area
function futuristic_it_widgets_init() {
    register_sidebar(array(
        'name'          => __('Footer Widget', 'futuristic-it'),
        'id'            => 'footer-widget',
        'description'   => __('Add widgets to footer.', 'futuristic-it'),
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4>',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'futuristic_it_widgets_init');

// Auto-create Product Detail page
function futuristic_it_create_product_detail_page() {
    $page = get_page_by_path('product-detail');
    if (!$page) {
        wp_insert_post(array(
            'post_title'   => 'Product Detail',
            'post_name'    => 'product-detail',
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'page_template' => 'products/product-detail.php',
        ));
    } else {
        $current_template = get_page_template_slug($page);
        if ($current_template !== 'products/product-detail.php') {
            update_post_meta($page->ID, '_wp_page_template', 'products/product-detail.php');
        }
    }
}
add_action('after_switch_theme', 'futuristic_it_create_product_detail_page');
add_action('init', function() {
    $page = get_page_by_path('product-detail');
    if (!$page) futuristic_it_create_product_detail_page();
});

// Product Details Admin Pages
function futuristict_products_page() {
    // Get products from homepage cards
    $raw_products = get_option('custom_product_cards', '[]');
    $home_products = json_decode($raw_products, true);
    if (!is_array($home_products)) $home_products = array();

    // Also get WordPress product posts
    $wp_products = get_posts(array('post_type' => 'product', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC'));

    // Merge: homepage cards first, then any WP products not in homepage
    $all_products = array();
    $home_titles = array();
    foreach ($home_products as $hp) {
        $title = $hp['title'] ?? '';
        if (!empty($title)) {
            $home_titles[] = $title;
            $all_products[] = array(
                'id' => 'home_' . md5($title),
                'title' => $title,
                'source' => 'homepage',
                'price' => $hp['price'] ?? '',
                'desc' => $hp['desc'] ?? '',
                'image' => $hp['image'] ?? '',
                'badge' => $hp['badge'] ?? '',
                'category' => $hp['category'] ?? '',
                'type' => $hp['type'] ?? 'Hardware',
            );
        }
    }
    foreach ($wp_products as $wp) {
        if (!in_array($wp->post_title, $home_titles)) {
            $all_products[] = array(
                'id' => $wp->ID,
                'title' => $wp->post_title,
                'source' => 'wp',
                'price' => get_post_meta($wp->ID, '_product_price', true),
                'desc' => $wp->post_content,
                'image' => has_post_thumbnail($wp->ID) ? get_the_post_thumbnail_url($wp->ID, 'thumbnail') : '',
                'badge' => '',
                'category' => '',
                'type' => 'Hardware',
            );
        }
    }

    $selected_key = isset($_GET['product_key']) ? sanitize_text_field($_GET['product_key']) : '';
    $view = isset($_GET['view']) ? sanitize_text_field($_GET['view']) : 'list';

    // Handle delete
    if ($view === 'delete' && $selected_key && isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'delete_product_' . md5($selected_key))) {
        $source = '';
        foreach ($all_products as $ap) { if ($ap['id'] === $selected_key) { $source = $ap['source']; break; } }
        if ($source === 'wp') {
            wp_delete_post(intval($selected_key), true);
        } elseif ($source === 'homepage') {
            $new_cards = array();
            foreach ($home_products as $hp) {
                if (('home_' . md5($hp['title'] ?? '')) !== $selected_key) {
                    $new_cards[] = $hp;
                }
            }
            update_option('custom_product_cards', wp_json_encode($new_cards));
        }
        futuristic_it_toast('Product deleted!');
        $selected_key = '';
        $view = 'list';
        // Refresh products
        $raw_products = get_option('custom_product_cards', '[]');
        $home_products = json_decode($raw_products, true);
        if (!is_array($home_products)) $home_products = array();
        $wp_products = get_posts(array('post_type' => 'product', 'posts_per_page' => -1, 'orderby' => 'title', 'order' => 'ASC'));
        $all_products = array();
        $home_titles = array();
        foreach ($home_products as $hp) {
            $title = $hp['title'] ?? '';
            if (!empty($title)) { $home_titles[] = $title; $all_products[] = array('id' => 'home_' . md5($title), 'title' => $title, 'source' => 'homepage', 'price' => $hp['price'] ?? '', 'desc' => $hp['desc'] ?? '', 'image' => $hp['image'] ?? '', 'badge' => $hp['badge'] ?? '', 'category' => $hp['category'] ?? '', 'type' => $hp['type'] ?? 'Hardware'); }
        }
        foreach ($wp_products as $wp) {
            if (!in_array($wp->post_title, $home_titles)) { $all_products[] = array('id' => $wp->ID, 'title' => $wp->post_title, 'source' => 'wp', 'price' => get_post_meta($wp->ID, '_product_price', true), 'desc' => $wp->post_content, 'image' => has_post_thumbnail($wp->ID) ? get_the_post_thumbnail_url($wp->ID, 'thumbnail') : '', 'badge' => '', 'category' => '', 'type' => 'Hardware'); }
        }
    }

    // Handle save
    if (isset($_POST['futuristic_it_save_product_detail']) && check_admin_referer('futuristic_it_product_detail')) {
        $post_key = sanitize_text_field($_POST['product_key']);
        $price = sanitize_text_field($_POST['product_price'] ?? '');
        $specs = sanitize_textarea_field($_POST['product_specs'] ?? '');
        $specs_km = sanitize_textarea_field($_POST['product_specs_km'] ?? '');
        $title_km = sanitize_text_field($_POST['product_title_km'] ?? '');
        $desc_km = sanitize_textarea_field($_POST['product_desc_km'] ?? '');
        $btn_text = sanitize_text_field($_POST['product_btn_text'] ?? 'Inquire Now');
        $btn_text_km = sanitize_text_field($_POST['product_btn_text_km'] ?? '');
        $btn_url = sanitize_text_field($_POST['product_btn_url'] ?? '#');

        // Collect all submitted images, skip empty, re-index sequentially
        $img_urls = array();
        $img_idx = 1;
        foreach ($_POST as $key => $val) {
            if (strpos($key, 'product_image_') === 0) {
                $clean = sanitize_text_field($val);
                if (!empty($clean)) {
                    $img_urls[$img_idx] = $clean;
                    $img_idx++;
                }
            }
        }
        // Pad to 6
        for ($i = $img_idx; $i <= 6; $i++) {
            $img_urls[$i] = '';
        }

        // Process packages for Software products
        $raw_packages = isset($_POST['prod_packages']) && is_array($_POST['prod_packages']) ? $_POST['prod_packages'] : array();
        $processed_packages = array();
        foreach ($raw_packages as $pkg) {
            $pkg_title = sanitize_text_field($pkg['title'] ?? '');
            $pkg_price = sanitize_text_field($pkg['price'] ?? '');
            if (!empty($pkg_title) || !empty($pkg_price)) {
                $features_text = isset($pkg['features_text']) ? $pkg['features_text'] : '';
                $features_text_km = isset($pkg['features_text_km']) ? $pkg['features_text_km'] : '';
                $processed_packages[] = array(
                    'image' => sanitize_text_field($pkg['image'] ?? ''),
                    'title' => $pkg_title,
                    'title_km' => sanitize_text_field($pkg['title_km'] ?? ''),
                    'price' => $pkg_price,
                    'badge' => sanitize_text_field($pkg['badge'] ?? ''),
                    'badge_km' => sanitize_text_field($pkg['badge_km'] ?? ''),
                    'btn_text' => sanitize_text_field($pkg['btn_text'] ?? ''),
                    'btn_text_km' => sanitize_text_field($pkg['btn_text_km'] ?? ''),
                    'btn_link' => sanitize_text_field($pkg['btn_link'] ?? ''),
                    'order' => intval($pkg['order'] ?? 999),
                    'features' => array_values(array_filter(array_map('trim', explode("\n", $features_text)))),
                    'features_km' => array_values(array_filter(array_map('trim', explode("\n", $features_text_km)))),
                );
            }
        }
        if (count($processed_packages) > 1) {
            usort($processed_packages, function($a, $b) { return $a['order'] - $b['order']; });
        }

        // Process product recommendations
        $recommended_ids = array();
        if (isset($_POST['prod_recommends']) && is_array($_POST['prod_recommends'])) {
            foreach ($_POST['prod_recommends'] as $rid) {
                $rid = sanitize_text_field($rid);
                if (!empty($rid)) $recommended_ids[] = $rid;
            }
        }

        // Process section title/description
        $recommends_section_title_en = sanitize_text_field($_POST['recommends_section_title_en'] ?? '');
        $recommends_section_title_km = sanitize_text_field($_POST['recommends_section_title_km'] ?? '');
        $recommends_section_desc_en = sanitize_textarea_field($_POST['recommends_section_desc_en'] ?? '');
        $recommends_section_desc_km = sanitize_textarea_field($_POST['recommends_section_desc_km'] ?? '');

        $prod_packages_title = sanitize_text_field($_POST['prod_packages_title'] ?? '');
        $prod_packages_title_km = sanitize_text_field($_POST['prod_packages_title_km'] ?? '');

        // Process video fields
        $video_url = esc_url_raw($_POST['prod_video_url'] ?? '');
        $video_url_km = esc_url_raw($_POST['prod_video_url_km'] ?? '');
        $video_title = sanitize_text_field($_POST['prod_video_title'] ?? '');
        $video_title_km = sanitize_text_field($_POST['prod_video_title_km'] ?? '');
        $video_desc = sanitize_textarea_field($_POST['prod_video_desc'] ?? '');
        $video_desc_km = sanitize_textarea_field($_POST['prod_video_desc_km'] ?? '');
        $video_btn_text = sanitize_text_field($_POST['prod_video_btn_text'] ?? '');
        $video_btn_text_km = sanitize_text_field($_POST['prod_video_btn_text_km'] ?? '');
        $video_btn_link = sanitize_text_field($_POST['prod_video_btn_link'] ?? '#');

        // Process feature cards
        $raw_fc = isset($_POST['prod_feature_cards']) && is_array($_POST['prod_feature_cards']) ? $_POST['prod_feature_cards'] : array();
        $processed_fc = array();
        foreach ($raw_fc as $fc) {
            $fc_title = sanitize_text_field($fc['title'] ?? '');
            if (!empty($fc_title)) {
                $processed_fc[] = array(
                    'icon' => sanitize_text_field($fc['icon'] ?? ''),
                    'title' => $fc_title,
                    'title_km' => sanitize_text_field($fc['title_km'] ?? ''),
                    'desc' => sanitize_textarea_field($fc['desc'] ?? ''),
                    'desc_km' => sanitize_textarea_field($fc['desc_km'] ?? ''),
                    'order' => intval($fc['order'] ?? 999),
                );
            }
        }
        if (count($processed_fc) > 1) {
            usort($processed_fc, function($a, $b) { return $a['order'] - $b['order']; });
        }

        $prod_features_title = sanitize_text_field($_POST['prod_features_title'] ?? '');
        $prod_features_title_km = sanitize_text_field($_POST['prod_features_title_km'] ?? '');

        // Find if it's a homepage card or WP product
        $source = '';
        foreach ($all_products as $ap) { if ($ap['id'] === $post_key) { $source = $ap['source']; break; } }

        if ($source === 'homepage') {
            foreach ($home_products as &$hp) {
                if (('home_' . md5($hp['title'] ?? '')) === $post_key) {
                    $hp['price'] = $price;
                    $hp['features'] = $features;
                    $hp['features_km'] = $features_km;
                    $hp['specs'] = $specs;
                    $hp['specs_km'] = $specs_km;
                    $hp['title_km'] = $title_km;
                    $hp['desc_km'] = $desc_km;
                    $hp['btn_text'] = $btn_text;
                    $hp['btn_text_km'] = $btn_text_km;
                    $hp['btn_url'] = $btn_url;
                    $hp['images'] = $img_urls;
                    $hp['packages'] = $processed_packages;
                    $hp['packages_title'] = $prod_packages_title;
                    $hp['packages_title_km'] = $prod_packages_title_km;
                    $hp['recommends'] = $recommended_ids;
                    $hp['recommends_section_title_en'] = $recommends_section_title_en;
                    $hp['recommends_section_title_km'] = $recommends_section_title_km;
                    $hp['recommends_section_desc_en'] = $recommends_section_desc_en;
                    $hp['recommends_section_desc_km'] = $recommends_section_desc_km;
                    $hp['video_url'] = $video_url;
                    $hp['video_url_km'] = $video_url_km;
                    $hp['video_title'] = $video_title;
                    $hp['video_title_km'] = $video_title_km;
                    $hp['video_desc'] = $video_desc;
                    $hp['video_desc_km'] = $video_desc_km;
                    $hp['video_btn_text'] = $video_btn_text;
                    $hp['video_btn_text_km'] = $video_btn_text_km;
                    $hp['video_btn_link'] = $video_btn_link;
                    $hp['feature_cards'] = $processed_fc;
                    $hp['features_title'] = $prod_features_title;
                    $hp['features_title_km'] = $prod_features_title_km;
                    break;
                }
            }
            unset($hp);
            update_option('custom_product_cards', wp_json_encode($home_products));
        } elseif ($source === 'wp') {
            $pid = intval($post_key);
            update_post_meta($pid, '_product_price', $price);
            update_post_meta($pid, '_product_specs', $specs);
            update_post_meta($pid, '_product_specs_km', $specs_km);
            update_post_meta($pid, '_product_type', $selected_product['type'] ?? 'Hardware');
            update_post_meta($pid, '_product_title_km', $title_km);
            update_post_meta($pid, '_product_desc_km', $desc_km);
            update_post_meta($pid, '_product_btn_text', $btn_text);
            update_post_meta($pid, '_product_btn_text_km', $btn_text_km);
            update_post_meta($pid, '_product_btn_url', $btn_url);
            for ($i = 1; $i <= 6; $i++) {
                update_post_meta($pid, '_product_image_' . $i, $img_urls[$i]);
            }
            update_post_meta($pid, '_product_packages', wp_json_encode($processed_packages));
            update_post_meta($pid, '_product_packages_title', $prod_packages_title);
            update_post_meta($pid, '_product_packages_title_km', $prod_packages_title_km);
            update_post_meta($pid, '_product_recommends', wp_json_encode($recommended_ids));
            update_post_meta($pid, '_recommends_section_title_en', $recommends_section_title_en);
            update_post_meta($pid, '_recommends_section_title_km', $recommends_section_title_km);
            update_post_meta($pid, '_recommends_section_desc_en', $recommends_section_desc_en);
            update_post_meta($pid, '_recommends_section_desc_km', $recommends_section_desc_km);
            update_post_meta($pid, '_product_video_url', $video_url);
            update_post_meta($pid, '_product_video_url_km', $video_url_km);
            update_post_meta($pid, '_product_video_title', $video_title);
            update_post_meta($pid, '_product_video_title_km', $video_title_km);
            update_post_meta($pid, '_product_video_desc', $video_desc);
            update_post_meta($pid, '_product_video_desc_km', $video_desc_km);
            update_post_meta($pid, '_product_video_btn_text', $video_btn_text);
            update_post_meta($pid, '_product_video_btn_text_km', $video_btn_text_km);
            update_post_meta($pid, '_product_video_btn_link', $video_btn_link);
            update_post_meta($pid, '_product_feature_cards', wp_json_encode($processed_fc));
            update_post_meta($pid, '_product_features_title', $prod_features_title);
            update_post_meta($pid, '_product_features_title_km', $prod_features_title_km);
        }
        // Save page labels from product detail form
        if (isset($_POST['product_detail_eyebrow'])) update_option('product_detail_eyebrow', sanitize_text_field($_POST['product_detail_eyebrow']));
        if (isset($_POST['product_detail_eyebrow_km'])) update_option('product_detail_eyebrow_km', sanitize_text_field($_POST['product_detail_eyebrow_km']));
        futuristic_it_toast('Product details saved!');
    }

    // Handle product selection from dropdown
    if (isset($_GET['select_product']) && !empty($_GET['select_product'])) {
        $selected_key = sanitize_text_field($_GET['select_product']);
        $view = 'edit';
    }

    // Get selected product data
    $selected_product = null;
    if ($view === 'edit' && $selected_key) {
        foreach ($all_products as $ap) {
            if ($ap['id'] === $selected_key) {
                $selected_product = $ap;
                break;
            }
        }
        // Load saved details
        if ($selected_product) {
            if ($selected_product['source'] === 'homepage') {
                foreach ($home_products as $hp) {
                    if (('home_' . md5($hp['title'] ?? '')) === $selected_key) {
                        $selected_product['features'] = $hp['features'] ?? '';
                        $selected_product['features_km'] = $hp['features_km'] ?? '';
                        $selected_product['title_km'] = $hp['title_km'] ?? '';
                        $selected_product['desc_km'] = $hp['desc_km'] ?? '';
                        $selected_product['btn_text'] = $hp['btn_text'] ?? 'Inquire Now';
                        $selected_product['btn_text_km'] = $hp['btn_text_km'] ?? '';
                        $selected_product['btn_url'] = $hp['btn_url'] ?? '#';
                        $selected_product['specs'] = $hp['specs'] ?? '';
                        $selected_product['specs_km'] = $hp['specs_km'] ?? '';
                        $selected_product['images'] = $hp['images'] ?? array_fill(1, 6, '');
                        $selected_product['type'] = $hp['type'] ?? 'Hardware';
                        $selected_product['packages'] = $hp['packages'] ?? array();
                        $selected_product['packages_title'] = $hp['packages_title'] ?? '';
                        $selected_product['packages_title_km'] = $hp['packages_title_km'] ?? '';
                        $selected_product['recommends'] = $hp['recommends'] ?? array();
                        $selected_product['recommends_section_title_en'] = $hp['recommends_section_title_en'] ?? '';
                        $selected_product['recommends_section_title_km'] = $hp['recommends_section_title_km'] ?? '';
                        $selected_product['recommends_section_desc_en'] = $hp['recommends_section_desc_en'] ?? '';
                        $selected_product['recommends_section_desc_km'] = $hp['recommends_section_desc_km'] ?? '';
                        $selected_product['video_url'] = $hp['video_url'] ?? '';
                        $selected_product['video_url_km'] = $hp['video_url_km'] ?? '';
                        $selected_product['video_title'] = $hp['video_title'] ?? '';
                        $selected_product['video_title_km'] = $hp['video_title_km'] ?? '';
                        $selected_product['video_desc'] = $hp['video_desc'] ?? '';
                        $selected_product['video_desc_km'] = $hp['video_desc_km'] ?? '';
                        $selected_product['video_btn_text'] = $hp['video_btn_text'] ?? '';
                        $selected_product['video_btn_text_km'] = $hp['video_btn_text_km'] ?? '';
                        $selected_product['video_btn_link'] = $hp['video_btn_link'] ?? '#';
                        $selected_product['feature_cards'] = $hp['feature_cards'] ?? array();
                        $selected_product['features_title'] = $hp['features_title'] ?? '';
                        $selected_product['features_title_km'] = $hp['features_title_km'] ?? '';
                        break;
                    }
                }
            } elseif ($selected_product['source'] === 'wp') {
                $pid = intval($selected_key);
                $selected_product['specs'] = get_post_meta($pid, '_product_specs', true);
                $selected_product['specs_km'] = get_post_meta($pid, '_product_specs_km', true);
                $selected_product['type'] = get_post_meta($pid, '_product_type', true) ?: 'Hardware';
                $selected_product['title_km'] = get_post_meta($pid, '_product_title_km', true);
                $selected_product['desc_km'] = get_post_meta($pid, '_product_desc_km', true);
                $selected_product['btn_text'] = get_post_meta($pid, '_product_btn_text', true) ?: 'Inquire Now';
                $selected_product['btn_text_km'] = get_post_meta($pid, '_product_btn_text_km', true);
                $selected_product['btn_url'] = get_post_meta($pid, '_product_btn_url', true) ?: '#';
                $selected_product['images'] = array();
                for ($i = 1; $i <= 6; $i++) {
                    $selected_product['images'][$i] = get_post_meta($pid, '_product_image_' . $i, true);
                }
                $pkg_raw = get_post_meta($pid, '_product_packages', true);
                $selected_product['packages'] = !empty($pkg_raw) ? json_decode($pkg_raw, true) : array();
                $selected_product['packages_title'] = get_post_meta($pid, '_product_packages_title', true);
                $selected_product['packages_title_km'] = get_post_meta($pid, '_product_packages_title_km', true);
                $rec_raw = get_post_meta($pid, '_product_recommends', true);
                $selected_product['recommends'] = !empty($rec_raw) ? json_decode($rec_raw, true) : array();
                $selected_product['recommends_section_title_en'] = get_post_meta($pid, '_recommends_section_title_en', true);
                $selected_product['recommends_section_title_km'] = get_post_meta($pid, '_recommends_section_title_km', true);
                $selected_product['recommends_section_desc_en'] = get_post_meta($pid, '_recommends_section_desc_en', true);
                $selected_product['recommends_section_desc_km'] = get_post_meta($pid, '_recommends_section_desc_km', true);
                $selected_product['video_url'] = get_post_meta($pid, '_product_video_url', true);
                $selected_product['video_url_km'] = get_post_meta($pid, '_product_video_url_km', true);
                $selected_product['video_title'] = get_post_meta($pid, '_product_video_title', true);
                $selected_product['video_title_km'] = get_post_meta($pid, '_product_video_title_km', true);
                $selected_product['video_desc'] = get_post_meta($pid, '_product_video_desc', true);
                $selected_product['video_desc_km'] = get_post_meta($pid, '_product_video_desc_km', true);
                $selected_product['video_btn_text'] = get_post_meta($pid, '_product_video_btn_text', true);
                $selected_product['video_btn_text_km'] = get_post_meta($pid, '_product_video_btn_text_km', true);
                $selected_product['video_btn_link'] = get_post_meta($pid, '_product_video_btn_link', true);
                $fc_raw = get_post_meta($pid, '_product_feature_cards', true);
                $selected_product['feature_cards'] = !empty($fc_raw) ? json_decode($fc_raw, true) : array();
                $selected_product['features_title'] = get_post_meta($pid, '_product_features_title', true);
                $selected_product['features_title_km'] = get_post_meta($pid, '_product_features_title_km', true);
                $selected_product['type'] = 'Hardware';
            }
            if (!isset($selected_product['specs'])) $selected_product['specs'] = '';
            if (!isset($selected_product['images'])) $selected_product['images'] = array_fill(1, 6, '');
            if (!isset($selected_product['packages'])) $selected_product['packages'] = array();
            if (!isset($selected_product['recommends'])) $selected_product['recommends'] = array();
            if (!isset($selected_product['type'])) $selected_product['type'] = 'Hardware';
            if (!isset($selected_product['video_url'])) $selected_product['video_url'] = '';
            if (!isset($selected_product['video_url_km'])) $selected_product['video_url_km'] = '';
            if (!isset($selected_product['video_title'])) $selected_product['video_title'] = '';
            if (!isset($selected_product['video_title_km'])) $selected_product['video_title_km'] = '';
            if (!isset($selected_product['video_desc'])) $selected_product['video_desc'] = '';
            if (!isset($selected_product['video_desc_km'])) $selected_product['video_desc_km'] = '';
            if (!isset($selected_product['video_btn_text'])) $selected_product['video_btn_text'] = '';
            if (!isset($selected_product['video_btn_text_km'])) $selected_product['video_btn_text_km'] = '';
            if (!isset($selected_product['video_btn_link'])) $selected_product['video_btn_link'] = '#';
            if (!isset($selected_product['feature_cards'])) $selected_product['feature_cards'] = array();
            if (!isset($selected_product['features_title'])) $selected_product['features_title'] = '';
            if (!isset($selected_product['features_title_km'])) $selected_product['features_title_km'] = '';
        }
    }

    // Handle save page labels
    if (isset($_POST['futuristic_it_save_product_labels']) && check_admin_referer('futuristic_it_product_labels')) {
        if (isset($_POST['product_detail_eyebrow'])) update_option('product_detail_eyebrow', sanitize_text_field($_POST['product_detail_eyebrow']));
        if (isset($_POST['product_detail_eyebrow_km'])) update_option('product_detail_eyebrow_km', sanitize_text_field($_POST['product_detail_eyebrow_km']));
        futuristic_it_toast('Labels saved!');
    }
    ?>
    <div class="wrap">
        <h1><?php _e('Product Details', 'futuristic-it'); ?></h1>

        <!-- Page Labels -->
        <div style="background:#fff;padding:20px;border:1px solid #ccc;border-radius:8px;margin-bottom:24px;">
            <h3 style="margin:0 0 12px;"><?php _e('Page Labels', 'futuristic-it'); ?></h3>
            <form method="post" action="">
                <?php wp_nonce_field('futuristic_it_product_labels'); ?>
                <table class="form-table">
                    <tr><th><label><?php _e('Hero Eyebrow', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="product_detail_eyebrow" value="<?php echo esc_attr(get_option('product_detail_eyebrow', 'Product Details')); ?>" style="width:300px;"></td></tr>
                    <tr><th><label style="color:#b8892f;"><?php _e('Hero Eyebrow (Khmer)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="product_detail_eyebrow_km" value="<?php echo esc_attr(get_option('product_detail_eyebrow_km', '')); ?>" style="width:300px;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                </table>
                <input type="submit" name="futuristic_it_save_product_labels" class="button button-primary" value="<?php _e('Save Labels', 'futuristic-it'); ?>">
            </form>
        </div>

        <!-- Dropdown Selector -->
        <div style="background:#fff;padding:20px;border:1px solid #ccc;border-radius:8px;margin-bottom:24px;">
            <h3 style="margin:0 0 12px;"><?php _e('Select a Product to Add Details', 'futuristic-it'); ?></h3>
            <form method="get" action="" style="display:flex;gap:12px;align-items:center;">
                <input type="hidden" name="page" value="futuristict-products">
                <input type="hidden" name="view" value="edit">
                <select name="select_product" style="min-width:350px;padding:8px;">
                    <option value=""><?php _e('— Choose a product —', 'futuristic-it'); ?></option>
                    <?php foreach ($all_products as $ap) : ?>
                        <option value="<?php echo esc_attr($ap['id']); ?>" <?php selected($selected_key, $ap['id']); ?>><?php echo esc_html($ap['title']); ?> <?php echo $ap['source'] === 'homepage' ? ' (Home)' : ' (WordPress)'; ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="button button-primary"><?php _e('Add Details', 'futuristic-it'); ?></button>
            </form>
        </div>

        <!-- Edit Form -->
        <?php if ($view === 'edit' && $selected_product) : ?>
            <div style="background:#fff;padding:24px;border:1px solid #ccc;border-radius:8px;margin-bottom:24px;">
                <h2 style="margin:0 0 16px;"><?php _e('Edit:', 'futuristic-it'); ?> <?php echo esc_html($selected_product['title']); ?></h2>
                <p style="color:#999;margin:0 0 16px;"><?php _e('Source:', 'futuristic-it'); ?> <?php echo $selected_product['source'] === 'homepage' ? 'Home Card' : 'WordPress Product'; ?></p>
                <form method="post" action="">
                    <?php wp_nonce_field('futuristic_it_product_detail'); ?>
                    <input type="hidden" name="product_key" value="<?php echo esc_attr($selected_key); ?>">
                    <table class="form-table">
                        <tr><th><label><?php _e('Product Name (English)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" value="<?php echo esc_attr($selected_product['title']); ?>" readonly style="width:100%;background:#f0f0f0;"></td></tr>
                        <tr><th><label style="color:#b8892f;"><?php _e('Product Name (Khmer)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="product_title_km" value="<?php echo esc_attr($selected_product['title_km'] ?? ''); ?>" style="width:100%;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                        <tr><th><label><?php _e('Hero Eyebrow (English)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="product_detail_eyebrow" value="<?php echo esc_attr(get_option('product_detail_eyebrow', 'Product Details')); ?>" style="width:300px;"></td></tr>
                        <tr><th><label style="color:#b8892f;"><?php _e('Hero Eyebrow (Khmer)', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="product_detail_eyebrow_km" value="<?php echo esc_attr(get_option('product_detail_eyebrow_km', '')); ?>" style="width:300px;font-family:'Noto Sans Khmer',sans-serif;"></td></tr>
                        <?php if (($selected_product['type'] ?? 'Hardware') !== 'Software') : ?>
                        <tr><th><label><?php _e('Price', 'futuristic-it'); ?></label></th><td><input type="text" class="regular-text" name="product_price" value="<?php echo esc_attr($selected_product['price']); ?>" placeholder="$289.00" style="width:200px;"></td></tr>
                        <?php endif; ?>
                        <tr><th><label><?php _e('Description (English)', 'futuristic-it'); ?></label></th><td><textarea class="large-text" rows="5" readonly style="background:#f0f0f0;"><?php echo esc_textarea($selected_product['desc']); ?></textarea></td></tr>
                        <tr><th><label style="color:#b8892f;"><?php _e('Description (Khmer)', 'futuristic-it'); ?></label></th><td><textarea class="large-text" name="product_desc_km" rows="5" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea($selected_product['desc_km'] ?? ''); ?></textarea></td></tr>
                        <tr>
                            <td colspan="3" style="padding:0;">
                                <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
                                    <div><label style="font-weight:600;font-size:12px;"><?php _e('Button Text (English)', 'futuristic-it'); ?></label><input type="text" name="product_btn_text" value="<?php echo esc_attr($selected_product['btn_text'] ?? 'Inquire Now'); ?>" placeholder="Inquire Now" style="width:100%;"></div>
                                    <div><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Button Text (Khmer)', 'futuristic-it'); ?></label><input type="text" name="product_btn_text_km" value="<?php echo esc_attr($selected_product['btn_text_km'] ?? ''); ?>" placeholder="សួរព័ត៌មាន" style="width:100%;font-family:'Noto Sans Khmer',sans-serif;"></div>
                                    <div><label style="font-weight:600;font-size:12px;"><?php _e('Button URL', 'futuristic-it'); ?></label><input type="text" name="product_btn_url" value="<?php echo esc_attr($selected_product['btn_url'] ?? '#'); ?>" placeholder="#" style="width:100%;"></div>
                                </div>
                            </td>
                        </tr>
                    </table>

                    <hr style="margin:24px 0;border:none;border-top:1px solid #ddd;">

                    <h2><?php _e('Product Feature Cards', 'futuristic-it'); ?></h2>
                    <p style="color:#999;margin:0 0 12px;"><?php _e('Add feature cards with icon, title, and description displayed in a grid.', 'futuristic-it'); ?></p>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px;">
                        <div><label style="font-weight:600;font-size:12px;"><?php _e('Section Title (English)', 'futuristic-it'); ?></label><input type="text" name="prod_features_title" value="<?php echo esc_attr($selected_product['features_title'] ?? ''); ?>" class="widefat" placeholder="Product Features"></div>
                        <div><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Section Title (Khmer)', 'futuristic-it'); ?></label><input type="text" name="prod_features_title_km" value="<?php echo esc_attr($selected_product['features_title_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;"></div>
                    </div>
                    <?php
                    $prod_feature_cards = $selected_product['feature_cards'] ?? array();
                    if (empty($prod_feature_cards)) $prod_feature_cards = array(array('icon' => '', 'title' => '', 'title_km' => '', 'desc' => '', 'desc_km' => ''));
                    ?>
                    <div id="prod-feature-cards-container">
                        <?php foreach ($prod_feature_cards as $fi => $fc) : ?>
                        <div class="prod-feature-card-row" style="background:#f9f9f9;border:1px solid #ddd;border-radius:8px;padding:16px;margin-bottom:16px;">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                                <label style="font-weight:600;font-size:14px;"><?php _e('Feature', 'futuristic-it'); ?> <?php echo $fi + 1; ?></label>
                                <div style="display:flex;gap:8px;align-items:center;">
                                    <label style="font-size:12px;"><?php _e('Order:', 'futuristic-it'); ?></label>
                                    <input type="number" name="prod_feature_cards[<?php echo $fi; ?>][order]" value="<?php echo esc_attr($fc['order'] ?? ($fi + 1)); ?>" style="width:60px;padding:4px 8px;" min="1">
                                    <button type="button" class="button button-small" onclick="var row=this.closest('.prod-feature-card-row');var prev=row.previousElementSibling;if(prev)row.parentNode.insertBefore(row,prev);">↑</button>
                                    <button type="button" class="button button-small" onclick="var row=this.closest('.prod-feature-card-row');var next=row.nextElementSibling;if(next)row.parentNode.insertBefore(next,row);">↓</button>
                                    <button type="button" class="button button-small" style="color:#dc3545;" onclick="this.closest('.prod-feature-card-row').remove();"><?php _e('Remove', 'futuristic-it'); ?></button>
                                </div>
                            </div>
                            <div style="display:grid;grid-template-columns:100px 1fr;gap:12px;align-items:start;margin-bottom:12px;">
                                <div>
                                    <input type="hidden" name="prod_feature_cards[<?php echo $fi; ?>][icon]" value="<?php echo esc_attr($fc['icon'] ?? ''); ?>">
                                    <div class="fc-icon-preview" style="width:80px;height:80px;overflow:hidden;display:flex;align-items:center;justify-content:center;border-radius:8px;background:#fff;border:1px solid #ddd;<?php echo empty($fc['icon'] ?? '') ? 'color:#ccc;font-size:28px;' : ''; ?>">
                                        <?php if (!empty($fc['icon'])) : ?><img src="<?php echo esc_url($fc['icon']); ?>" style="width:100%;height:100%;object-fit:contain;"><?php else : ?><span>?</span><?php endif; ?>
                                    </div>
                                    <button type="button" class="button button-small upload-btn" data-for="prod_feature_cards[<?php echo $fi; ?>][icon]" style="margin-top:6px;"><?php _e('Upload Icon', 'futuristic-it'); ?></button>
                                </div>
                                <div>
                                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                                        <div><label style="font-weight:600;font-size:12px;"><?php _e('Title (English)', 'futuristic-it'); ?></label><input type="text" name="prod_feature_cards[<?php echo $fi; ?>][title]" value="<?php echo esc_attr($fc['title'] ?? ''); ?>" class="widefat"></div>
                                        <div><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Title (Khmer)', 'futuristic-it'); ?></label><input type="text" name="prod_feature_cards[<?php echo $fi; ?>][title_km]" value="<?php echo esc_attr($fc['title_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;"></div>
                                    </div>
                                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                                        <div><label style="font-weight:600;font-size:12px;"><?php _e('Description (English)', 'futuristic-it'); ?></label><textarea name="prod_feature_cards[<?php echo $fi; ?>][desc]" class="widefat" rows="3"><?php echo esc_textarea($fc['desc'] ?? ''); ?></textarea></div>
                                        <div><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Description (Khmer)', 'futuristic-it'); ?></label><textarea name="prod_feature_cards[<?php echo $fi; ?>][desc_km]" class="widefat" rows="3" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea($fc['desc_km'] ?? ''); ?></textarea></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <p><button type="button" class="button" id="add-prod-feature-card">+ <?php _e('Add Feature Card', 'futuristic-it'); ?></button></p>

                    <h2><?php _e('Product Images', 'futuristic-it'); ?></h2>
                    <p style="color:#999;margin:0 0 12px;"><?php _e('Image 1 is the main product image.', 'futuristic-it'); ?></p>
                    <div id="product-images-container">
                        <?php
                        $img_count = 0;
                        for ($i = 1; $i <= 6; $i++) {
                            $img_val = $selected_product['images'][$i] ?? '';
                            if (!empty($img_val)) $img_count++;
                        }
                        $shown = 0;
                        for ($i = 1; $i <= 6; $i++) :
                            $img_val = $selected_product['images'][$i] ?? '';
                            if (empty($img_val) && $shown >= max($img_count, 1)) continue;
                            $shown++;
                        ?>
                        <div class="product-image-row" style="display:flex;align-items:center;gap:12px;margin-bottom:12px;padding:12px;background:#f9f9f9;border-radius:8px;">
                            <div style="min-width:100px;">
                                <?php if ($i === 1) : ?>
                                    <span style="display:inline-block;background:#1a3d27;color:#fff;padding:3px 10px;border-radius:4px;font-size:11px;font-weight:700;"><?php _e('MAIN IMAGE', 'futuristic-it'); ?></span>
                                <?php else : ?>
                                    <span style="color:#999;font-size:12px;"><?php _e('Image', 'futuristic-it'); ?> <?php echo $i; ?></span>
                                <?php endif; ?>
                            </div>
                            <input type="hidden" name="product_image_<?php echo $i; ?>" class="product-image-input" value="<?php echo esc_attr($img_val); ?>">
                            <img class="product-image-preview" src="<?php echo esc_url($img_val); ?>" style="max-height:80px;border-radius:4px;<?php echo empty($img_val) ? 'display:none;' : ''; ?>">
                            <button type="button" class="button upload-btn" data-for="product_image_<?php echo $i; ?>"><?php _e('Upload', 'futuristic-it'); ?></button>
                            <button type="button" class="button button-small fw-remove-image" style="color:#dc3545;" onclick="this.closest('.product-image-row').remove();"><?php _e('Remove', 'futuristic-it'); ?></button>
                        </div>
                        <?php endfor; ?>
                    </div>
                    <div style="margin-top:16px;">
                        <button type="button" class="button" id="add-product-image" style="margin-bottom:16px;">+ <?php _e('Add Image', 'futuristic-it'); ?></button>
                    </div>

                    <?php if (($selected_product['type'] ?? 'Hardware') === 'Software') : ?>
                    <hr style="margin:24px 0;border:none;border-top:1px solid #ddd;">

                    <h2><?php _e('Packages', 'futuristic-it'); ?></h2>
                    <p style="color:#999;margin:0 0 12px;"><?php _e('Add pricing packages for this software product.', 'futuristic-it'); ?></p>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px;">
                        <div><label style="font-weight:600;font-size:12px;"><?php _e('Packages Section Title (English)', 'futuristic-it'); ?></label><input type="text" name="prod_packages_title" value="<?php echo esc_attr($selected_product['packages_title'] ?? ''); ?>" class="widefat" placeholder="Pricing Packages"></div>
                        <div><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Packages Section Title (Khmer)', 'futuristic-it'); ?></label><input type="text" name="prod_packages_title_km" value="<?php echo esc_attr($selected_product['packages_title_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;"></div>
                    </div>
                    <?php
                    $prod_packages = $selected_product['packages'] ?? array();
                    if (empty($prod_packages)) $prod_packages = array(array('title' => '', 'price' => '', 'badge' => '', 'features_text' => '', 'btn_text' => '', 'btn_link' => ''));
                    ?>
                    <div id="prod-packages-container">
                        <?php foreach ($prod_packages as $pi => $pkg) : ?>
                        <div class="prod-package-row" style="background:#f9f9f9;border:1px solid #ddd;border-radius:8px;padding:16px;margin-bottom:16px;">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                                <label style="font-weight:600;font-size:14px;"><?php _e('Package', 'futuristic-it'); ?> <?php echo $pi + 1; ?></label>
                                <div style="display:flex;gap:8px;align-items:center;">
                                    <label style="font-size:12px;"><?php _e('Order:', 'futuristic-it'); ?></label>
                                    <input type="number" name="prod_packages[<?php echo $pi; ?>][order]" value="<?php echo esc_attr($pkg['order'] ?? ($pi + 1)); ?>" style="width:60px;padding:4px 8px;" min="1">
                                    <button type="button" class="button button-small" onclick="var row=this.closest('.prod-package-row');var prev=row.previousElementSibling;if(prev)row.parentNode.insertBefore(row,prev);">↑</button>
                                    <button type="button" class="button button-small" onclick="var row=this.closest('.prod-package-row');var next=row.nextElementSibling;if(next)row.parentNode.insertBefore(next,row);">↓</button>
                                    <button type="button" class="button button-small" style="color:#dc3545;" onclick="this.closest('.prod-package-row').remove();"><?php _e('Remove', 'futuristic-it'); ?></button>
                                </div>
                            </div>
                            <div style="display:grid;grid-template-columns:100px 1fr;gap:12px;align-items:start;margin-bottom:12px;">
                                <div>
                                    <input type="hidden" name="prod_packages[<?php echo $pi; ?>][image]" value="<?php echo esc_attr($pkg['image'] ?? ''); ?>">
                                    <img class="pkg-image-preview" src="<?php echo esc_url($pkg['image'] ?? ''); ?>" style="width:100px;height:80px;object-fit:contain;border-radius:4px;background:#fff;padding:4px;<?php echo empty($pkg['image'] ?? '') ? 'display:none;' : ''; ?>">
                                    <button type="button" class="button button-small upload-btn" data-for="prod_packages[<?php echo $pi; ?>][image]"><?php _e('Upload Image', 'futuristic-it'); ?></button>
                                </div>
                                <div>
                                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;margin-bottom:12px;">
                                        <div><label style="font-weight:600;font-size:12px;"><?php _e('Package Title (English)', 'futuristic-it'); ?></label><input type="text" name="prod_packages[<?php echo $pi; ?>][title]" value="<?php echo esc_attr($pkg['title'] ?? ''); ?>" class="widefat"></div>
                                        <div><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Package Title (Khmer)', 'futuristic-it'); ?></label><input type="text" name="prod_packages[<?php echo $pi; ?>][title_km]" value="<?php echo esc_attr($pkg['title_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;"></div>
                                        <div><label style="font-weight:600;font-size:12px;"><?php _e('Price', 'futuristic-it'); ?></label><input type="text" name="prod_packages[<?php echo $pi; ?>][price]" value="<?php echo esc_attr($pkg['price'] ?? ''); ?>" class="widefat" placeholder="$99/month"></div>
                                    </div>
                                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                                        <div><label style="font-weight:600;font-size:12px;"><?php _e('Badge (English)', 'futuristic-it'); ?></label><input type="text" name="prod_packages[<?php echo $pi; ?>][badge]" value="<?php echo esc_attr($pkg['badge'] ?? ''); ?>" class="widefat" placeholder="Most Popular"></div>
                                        <div><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Badge (Khmer)', 'futuristic-it'); ?></label><input type="text" name="prod_packages[<?php echo $pi; ?>][badge_km]" value="<?php echo esc_attr($pkg['badge_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;"></div>
                                    </div>
                                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                                        <div><label style="font-weight:600;font-size:12px;"><?php _e('Features (English, one per line)', 'futuristic-it'); ?></label><textarea name="prod_packages[<?php echo $pi; ?>][features_text]" class="widefat" rows="3"><?php echo esc_textarea(implode("\n", $pkg['features'] ?? array())); ?></textarea></div>
                                        <div><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Features (Khmer)', 'futuristic-it'); ?></label><textarea name="prod_packages[<?php echo $pi; ?>][features_text_km]" class="widefat" rows="3" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea(implode("\n", $pkg['features_km'] ?? array())); ?></textarea></div>
                                    </div>
                                    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">
                                        <div><label style="font-weight:600;font-size:12px;"><?php _e('Button Text (English)', 'futuristic-it'); ?></label><input type="text" name="prod_packages[<?php echo $pi; ?>][btn_text]" value="<?php echo esc_attr($pkg['btn_text'] ?? ''); ?>" class="widefat"></div>
                                        <div><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Button Text (Khmer)', 'futuristic-it'); ?></label><input type="text" name="prod_packages[<?php echo $pi; ?>][btn_text_km]" value="<?php echo esc_attr($pkg['btn_text_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;"></div>
                                        <div><label style="font-weight:600;font-size:12px;"><?php _e('Button Link', 'futuristic-it'); ?></label><input type="text" name="prod_packages[<?php echo $pi; ?>][btn_link]" value="<?php echo esc_attr($pkg['btn_link'] ?? home_url('/contact/')); ?>" class="widefat" placeholder="/contact/"></div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="button button-small" style="color:#dc3545;margin-top:8px;" onclick="this.closest('.prod-package-row').remove();"><?php _e('Remove Package', 'futuristic-it'); ?></button>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <p><button type="button" class="button" id="add-prod-package">+ <?php _e('Add Package', 'futuristic-it'); ?></button></p>

                    <hr style="margin:24px 0;border:none;border-top:1px solid #ddd;">

                    <h2><?php _e('Video Section', 'futuristic-it'); ?></h2>
                    <p style="color:#999;margin:0 0 12px;"><?php _e('Upload a demo or promotional video below the packages.', 'futuristic-it'); ?></p>
                    <div style="margin-bottom:12px;">
                        <div>
                            <label style="font-weight:600;font-size:12px;"><?php _e('Video File', 'futuristic-it'); ?></label>
                            <input type="hidden" name="prod_video_url" id="prod_video_url" value="<?php echo esc_attr($selected_product['video_url'] ?? ''); ?>">
                            <div style="display:flex;gap:8px;align-items:center;margin-top:4px;">
                                <span class="prod-video-preview" style="font-size:12px;color:#666;max-width:400px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?php echo !empty($selected_product['video_url']) ? esc_url($selected_product['video_url']) : ''; ?></span>
                                <button type="button" class="button prod-upload-video" data-for="prod_video_url"><?php _e('Upload Video', 'futuristic-it'); ?></button>
                                <button type="button" class="button button-small" style="color:#dc3545;" onclick="document.getElementById('prod_video_url').value='';this.previousElementSibling.previousElementSibling.textContent='';"><?php _e('Remove', 'futuristic-it'); ?></button>
                            </div>
                            <p style="color:#999;font-size:11px;margin-top:4px;"><?php _e('MP4, WebM, or OGG format.', 'futuristic-it'); ?></p>
                        </div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                        <div><label style="font-weight:600;font-size:12px;"><?php _e('Video Section Title (English)', 'futuristic-it'); ?></label><input type="text" name="prod_video_title" value="<?php echo esc_attr($selected_product['video_title'] ?? ''); ?>" class="widefat" placeholder="Watch Demo Video"></div>
                        <div><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Video Section Title (Khmer)', 'futuristic-it'); ?></label><input type="text" name="prod_video_title_km" value="<?php echo esc_attr($selected_product['video_title_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;"></div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                        <div><label style="font-weight:600;font-size:12px;"><?php _e('Video Description (English)', 'futuristic-it'); ?></label><textarea name="prod_video_desc" class="widefat" rows="2" placeholder="See how our product works"><?php echo esc_textarea($selected_product['video_desc'] ?? ''); ?></textarea></div>
                        <div><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Video Description (Khmer)', 'futuristic-it'); ?></label><textarea name="prod_video_desc_km" class="widefat" rows="2" style="font-family:'Noto Sans Khmer',sans-serif;"><?php echo esc_textarea($selected_product['video_desc_km'] ?? ''); ?></textarea></div>
                    </div>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                        <div><label style="font-weight:600;font-size:12px;"><?php _e('Button Text (English)', 'futuristic-it'); ?></label><input type="text" name="prod_video_btn_text" value="<?php echo esc_attr($selected_product['video_btn_text'] ?? ''); ?>" class="widefat" placeholder="Watch Now"></div>
                        <div><label style="font-weight:600;font-size:12px;color:#b8892f;"><?php _e('Button Text (Khmer)', 'futuristic-it'); ?></label><input type="text" name="prod_video_btn_text_km" value="<?php echo esc_attr($selected_product['video_btn_text_km'] ?? ''); ?>" class="widefat" style="font-family:'Noto Sans Khmer',sans-serif;"></div>
                    </div>
                    <div style="margin-top:12px;">
                        <label style="font-weight:600;font-size:12px;"><?php _e('Button Link', 'futuristic-it'); ?></label><input type="text" name="prod_video_btn_link" value="<?php echo esc_attr($selected_product['video_btn_link'] ?? '#'); ?>" class="widefat" placeholder="/contact/ or https://...">
                    </div>
                    <?php endif; ?>

                    <hr style="margin:16px 0;border:none;border-top:1px solid #ddd;">
                    <p class="submit" style="margin:0;">
                        <input type="submit" name="futuristic_it_save_product_detail" class="button button-primary" value="<?php _e('Save Product Details', 'futuristic-it'); ?>">
                    </p>
                </form>
            </div>
        <?php elseif ($view === 'edit' && $selected_key && !$selected_product) : ?>
            <div class="notice notice-error"><p><?php _e('Product not found.', 'futuristic-it'); ?></p></div>
        <?php endif; ?>

        <!-- Product List -->
        <h2><?php _e('All Products', 'futuristic-it'); ?></h2>
        <?php if (!empty($all_products)) : ?>
        <table class="widefat striped">
            <thead>
                <tr>
                    <th style="width:60px;"><?php _e('Image', 'futuristic-it'); ?></th>
                    <th><?php _e('Title', 'futuristic-it'); ?></th>
                    <th style="width:80px;"><?php _e('Type', 'futuristic-it'); ?></th>
                    <th style="width:100px;"><?php _e('Price', 'futuristic-it'); ?></th>
                    <th style="width:120px;"><?php _e('Source', 'futuristic-it'); ?></th>
                    <th style="width:100px;"><?php _e('Details', 'futuristic-it'); ?></th>
                    <th style="width:180px;"><?php _e('Actions', 'futuristic-it'); ?></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($all_products as $ap) :
                $has_details = !empty($ap['price']) || !empty($ap['features'] ?? '') || !empty($ap['specs'] ?? '');
            ?>
                <tr>
                    <td><?php if (!empty($ap['image'])) : ?><img src="<?php echo esc_url($ap['image']); ?>" style="width:50px;height:50px;object-fit:cover;border-radius:4px;"><?php endif; ?></td>
                    <td><strong><?php echo esc_html($ap['title']); ?></strong></td>
                    <td><?php echo !empty($ap['type']) ? '<span style="color:' . ($ap['type'] === 'Software' ? '#1a3d27' : '#b8892f') . ';font-weight:600;">' . esc_html($ap['type']) . '</span>' : '—'; ?></td>
                    <td><?php echo !empty($ap['price']) ? '$' . esc_html($ap['price']) : '—'; ?></td>
                    <td><span style="color:#999;font-size:12px;"><?php echo $ap['source'] === 'homepage' ? 'Home' : 'WordPress'; ?></span></td>
                    <td><?php echo $has_details ? '<span style="color:green;">✓</span>' : '<span style="color:#999;">—</span>'; ?></td>
                    <td>
                        <a href="<?php echo admin_url('admin.php?page=futuristict-products&view=edit&product_key=' . urlencode($ap['id'])); ?>" class="button button-small"><?php _e('Add / Edit', 'futuristic-it'); ?></a>
                        <button type="button" class="button button-small fw-delete-btn" data-url="<?php echo wp_nonce_url(admin_url('admin.php?page=futuristict-products&view=delete&product_key=' . urlencode($ap['id'])), 'delete_product_' . md5($ap['id'])); ?>" data-name="<?php echo esc_attr($ap['title']); ?>"><?php _e('Remove', 'futuristic-it'); ?></button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php else : ?>
            <div class="notice notice-info"><p><?php _e('No products found.', 'futuristic-it'); ?></p></div>
        <?php endif; ?>
    </div>

    <!-- Delete Modal -->
    <div id="fw-delete-overlay" style="display:none;position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.5);z-index:999999;justify-content:center;align-items:center;">
        <div style="background:#fff;border-radius:16px;padding:40px;text-align:center;max-width:400px;width:90%;box-shadow:0 20px 60px rgba(0,0,0,0.3);">
            <div style="width:72px;height:72px;background:#fee2e2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#dc3545" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
            </div>
            <h3 style="font-size:22px;font-weight:700;color:#1a1a1a;margin:0 0 8px;">Delete Item?</h3>
            <p style="color:#666;font-size:14px;margin:0 0 28px;">Are you sure you want to delete <strong id="fw-delete-name"></strong>?</p>
            <div style="display:flex;gap:12px;justify-content:center;">
                <button type="button" id="fw-delete-no" style="padding:10px 32px;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;border:1px solid #ddd;background:#fff;color:#333;">No</button>
                <a id="fw-delete-yes" href="#" style="padding:10px 32px;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;border:none;background:#dc3545;color:#fff;text-decoration:none;">Yes</a>
            </div>
        </div>
    </div>

    <script>
    (function(){
        var overlay = document.getElementById('fw-delete-overlay');
        var nameEl = document.getElementById('fw-delete-name');
        var yesBtn = document.getElementById('fw-delete-yes');
        var noBtn = document.getElementById('fw-delete-no');
        document.querySelectorAll('.fw-delete-btn').forEach(function(btn){
            btn.addEventListener('click', function(e){
                e.preventDefault();
                e.stopPropagation();
                nameEl.textContent = this.getAttribute('data-name');
                yesBtn.href = this.getAttribute('data-url');
                overlay.style.display = 'flex';
            });
        });
        noBtn.addEventListener('click', function(){ overlay.style.display = 'none'; });
        overlay.addEventListener('click', function(e){ if(e.target === overlay) overlay.style.display = 'none'; });

        // Add Image button
        var imgIdx = document.querySelectorAll('.product-image-row').length;
        var addBtn = document.getElementById('add-product-image');
        if (addBtn) {
            addBtn.addEventListener('click', function(){
                imgIdx++;
                var html = '<div class="product-image-row" style="display:flex;align-items:center;gap:12px;margin-bottom:12px;padding:12px;background:#f9f9f9;border-radius:8px;">' +
                    '<div style="min-width:100px;"><span style="color:#999;font-size:12px;">Image ' + imgIdx + '</span></div>' +
                    '<input type="hidden" name="product_image_' + imgIdx + '" class="product-image-input" value="">' +
                    '<img class="product-image-preview" src="" style="max-height:80px;border-radius:4px;display:none;">' +
                    '<button type="button" class="button upload-btn" data-for="product_image_' + imgIdx + '">Upload</button>' +
                    '<button type="button" class="button button-small fw-remove-image" style="color:#dc3545;" onclick="this.closest(\'.product-image-row\').remove();">Remove</button>' +
                    '</div>';
                document.getElementById('product-images-container').insertAdjacentHTML('beforeend', html);
            });
        }

        var addPkgBtn = document.getElementById('add-prod-package');
        if (addPkgBtn) {
            addPkgBtn.addEventListener('click', function(){
                var container = document.getElementById('prod-packages-container');
                var idx = container.querySelectorAll('.prod-package-row').length;
                var html = '<div class="prod-package-row" style="background:#f9f9f9;border:1px solid #ddd;border-radius:8px;padding:16px;margin-bottom:16px;">' +
                    '<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">' +
                    '<label style="font-weight:600;font-size:14px;">Package ' + (idx + 1) + '</label>' +
                    '<div style="display:flex;gap:8px;align-items:center;">' +
                    '<label style="font-size:12px;">Order:</label>' +
                    '<input type="number" name="prod_packages[' + idx + '][order]" value="' + (idx + 1) + '" style="width:60px;padding:4px 8px;" min="1">' +
                    '<button type="button" class="button button-small" onclick="var row=this.closest(\'.prod-package-row\');var prev=row.previousElementSibling;if(prev)row.parentNode.insertBefore(row,prev);">↑</button>' +
                    '<button type="button" class="button button-small" onclick="var row=this.closest(\'.prod-package-row\');var next=row.nextElementSibling;if(next)row.parentNode.insertBefore(next,row);">↓</button>' +
                    '<button type="button" class="button button-small" style="color:#dc3545;" onclick="this.closest(\'.prod-package-row\').remove();">Remove</button>' +
                    '</div></div>' +
                    '<div style="display:grid;grid-template-columns:100px 1fr;gap:12px;align-items:start;margin-bottom:12px;">' +
                    '<div>' +
                    '<input type="hidden" name="prod_packages[' + idx + '][image]" value="">' +
                    '<img class="pkg-image-preview" src="" style="width:100px;height:80px;object-fit:contain;border-radius:4px;background:#fff;padding:4px;display:none;">' +
                    '<button type="button" class="button button-small upload-btn" data-for="prod_packages[' + idx + '][image]">Upload Image</button>' +
                    '</div>' +
                    '<div>' +
                    '<div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;margin-bottom:12px;">' +
                    '<div><label style="font-weight:600;font-size:12px;">Package Title (English)</label><input type="text" name="prod_packages[' + idx + '][title]" value="" class="widefat"></div>' +
                    '<div><label style="font-weight:600;font-size:12px;color:#b8892f;">Package Title (Khmer)</label><input type="text" name="prod_packages[' + idx + '][title_km]" value="" class="widefat" style="font-family:\'Noto Sans Khmer\',sans-serif;"></div>' +
                    '<div><label style="font-weight:600;font-size:12px;">Price</label><input type="text" name="prod_packages[' + idx + '][price]" value="" class="widefat" placeholder="$99/month"></div>' +
                    '</div>' +
                    '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">' +
                    '<div><label style="font-weight:600;font-size:12px;">Badge (English)</label><input type="text" name="prod_packages[' + idx + '][badge]" value="" class="widefat" placeholder="Most Popular"></div>' +
                    '<div><label style="font-weight:600;font-size:12px;color:#b8892f;">Badge (Khmer)</label><input type="text" name="prod_packages[' + idx + '][badge_km]" value="" class="widefat" style="font-family:\'Noto Sans Khmer\',sans-serif;"></div>' +
                    '</div>' +
                    '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">' +
                    '<div><label style="font-weight:600;font-size:12px;">Features (English, one per line)</label><textarea name="prod_packages[' + idx + '][features_text]" class="widefat" rows="3"></textarea></div>' +
                    '<div><label style="font-weight:600;font-size:12px;color:#b8892f;">Features (Khmer)</label><textarea name="prod_packages[' + idx + '][features_text_km]" class="widefat" rows="3" style="font-family:\'Noto Sans Khmer\',sans-serif;"></textarea></div>' +
                    '</div>' +
                    '<div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:12px;">' +
                    '<div><label style="font-weight:600;font-size:12px;">Button Text (English)</label><input type="text" name="prod_packages[' + idx + '][btn_text]" value="" class="widefat"></div>' +
                    '<div><label style="font-weight:600;font-size:12px;color:#b8892f;">Button Text (Khmer)</label><input type="text" name="prod_packages[' + idx + '][btn_text_km]" value="" class="widefat" style="font-family:\'Noto Sans Khmer\',sans-serif;"></div>' +
                    '<div><label style="font-weight:600;font-size:12px;">Button Link</label><input type="text" name="prod_packages[' + idx + '][btn_link]" value="" class="widefat" placeholder="/contact/"></div>' +
                    '</div></div></div>' +
                    '<button type="button" class="button button-small" style="color:#dc3545;margin-top:8px;" onclick="this.closest(\'.prod-package-row\').remove();">Remove Package</button>' +
                    '</div>';
                container.insertAdjacentHTML('beforeend', html);
            });
        }

        var addFcBtn = document.getElementById('add-prod-feature-card');
        if (addFcBtn) {
            addFcBtn.addEventListener('click', function(){
                var container = document.getElementById('prod-feature-cards-container');
                var idx = container.querySelectorAll('.prod-feature-card-row').length;
                var html = '<div class="prod-feature-card-row" style="background:#f9f9f9;border:1px solid #ddd;border-radius:8px;padding:16px;margin-bottom:16px;">' +
                    '<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">' +
                    '<label style="font-weight:600;font-size:14px;">Feature ' + (idx + 1) + '</label>' +
                    '<div style="display:flex;gap:8px;align-items:center;">' +
                    '<label style="font-size:12px;">Order:</label>' +
                    '<input type="number" name="prod_feature_cards[' + idx + '][order]" value="' + (idx + 1) + '" style="width:60px;padding:4px 8px;" min="1">' +
                    '<button type="button" class="button button-small" onclick="var row=this.closest(\'.prod-feature-card-row\');var prev=row.previousElementSibling;if(prev)row.parentNode.insertBefore(row,prev);">↑</button>' +
                    '<button type="button" class="button button-small" onclick="var row=this.closest(\'.prod-feature-card-row\');var next=row.nextElementSibling;if(next)row.parentNode.insertBefore(next,row);">↓</button>' +
                    '<button type="button" class="button button-small" style="color:#dc3545;" onclick="this.closest(\'.prod-feature-card-row\').remove();">Remove</button>' +
                    '</div></div>' +
                    '<div style="display:grid;grid-template-columns:100px 1fr;gap:12px;align-items:start;margin-bottom:12px;">' +
                    '<div>' +
                    '<input type="hidden" name="prod_feature_cards[' + idx + '][icon]" value="">' +
                    '<div class="fc-icon-preview" style="width:80px;height:80px;overflow:hidden;display:flex;align-items:center;justify-content:center;border-radius:8px;background:#fff;border:1px solid #ddd;color:#ccc;font-size:28px;"><span>?</span></div>' +
                    '<button type="button" class="button button-small upload-btn" data-for="prod_feature_cards[' + idx + '][icon]" style="margin-top:6px;">Upload Icon</button>' +
                    '</div>' +
                    '<div>' +
                    '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">' +
                    '<div><label style="font-weight:600;font-size:12px;">Title (English)</label><input type="text" name="prod_feature_cards[' + idx + '][title]" value="" class="widefat"></div>' +
                    '<div><label style="font-weight:600;font-size:12px;color:#b8892f;">Title (Khmer)</label><input type="text" name="prod_feature_cards[' + idx + '][title_km]" value="" class="widefat" style="font-family:\'Noto Sans Khmer\',sans-serif;"></div>' +
                    '</div>' +
                    '<div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">' +
                    '<div><label style="font-weight:600;font-size:12px;">Description (English)</label><textarea name="prod_feature_cards[' + idx + '][desc]" class="widefat" rows="3"></textarea></div>' +
                    '<div><label style="font-weight:600;font-size:12px;color:#b8892f;">Description (Khmer)</label><textarea name="prod_feature_cards[' + idx + '][desc_km]" class="widefat" rows="3" style="font-family:\'Noto Sans Khmer\',sans-serif;"></textarea></div>' +
                    '</div></div></div></div>';
                container.insertAdjacentHTML('beforeend', html);
            });
        }
    })();
    </script>
    <?php
}
