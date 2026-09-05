<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once get_template_directory() . '/includes/settings-framework.php';
require_once get_template_directory() . '/lib/class-tgm-plugin-activation.php';

if (!class_exists( 'BreadcrumbsTrail')) {
    require_once get_template_directory() . '/lib/BreadcrumbsTrail.php';
}

// <REMOVE_IN_PRO_VERSION>

// Composer autoload (Freemius SDK)
if ( file_exists( get_template_directory() . '/vendor/autoload.php' ) ) {
    require_once get_template_directory() . '/vendor/autoload.php';
}

// Freemius Integration
if ( ! function_exists( 'wd_fs' ) ) {
    function wd_fs() {
        global $wd_fs;

        if ( ! isset( $wd_fs ) ) {
            $wd_fs = fs_dynamic_init( array(
                'id'                  => '32974',
                'slug'                => 'wp-documentation',
                'premium_slug'        => 'wp-documentation-pro',
                'type'                => 'theme',
                'public_key'          => 'pk_bf888d2c00274da23a2a920807171',
                'is_premium'          => false,
                'premium_suffix'      => 'Pro',
                'has_premium_version' => true,
                'has_addons'          => false,
                'has_paid_plans'      => true,
                'is_org_compliant'    => true,
                'menu'                => array(
                    'slug'           => 'wp_documentation_options',
                    'account'        => true,
                    'contact'        => false,
                    'pricing'        => true,
                ),
            ) );
        }

        return $wd_fs;
    }

    wd_fs();
    do_action( 'wd_fs_loaded' );
}

// </REMOVE_IN_PRO_VERSION>

define('WP_DOCUMENTATION_VERSION', '2.0.4');
define('WP_DOCUMENTATION_JOIN_SYMBOL', ' / ');

// Actions
add_action("after_setup_theme", "wp_documentation_after_setup_theme");
add_action("wp_enqueue_scripts", "wp_documentation_enqueue_scripts");
add_action('tgmpa_register', 'wp_documentation_register_required_plugins');

remove_action('wp_body_open', 'fast_fuzzy_search_render_search_field');

// Filters
add_filter("script_loader_tag", "wp_documentation_add_defer_to_alpine_script", 10, 3);
add_filter('the_content', 'wp_documentation_add_ids_to_headings');

add_filter("acf/settings/save_json", function( $path ) {
    return get_template_directory() . '/acf-json';
});

add_filter('acf/settings/load_json', function( $paths ) {
    unset($paths[0]);

    $paths[] = get_template_directory() . '/acf-json';
    
    return $paths;
});

add_filter('excerpt_length', function($length) {
    if (is_post_type_archive('docs')) {
        return 10; 
    } else if (get_post_type() === 'post') {
        return 10; 
    } else {
        return $length;
    }
});

add_filter('fast_fuzzy_search_aesthetic', function() {
    return 'newspaper';
}, 10, 2);

add_filter('get_default_comment_status', function($status, $post_type) {
    if ($post_type === 'docs') {
        return 'closed';
    }

    return $status;
}, 10, 2);

add_filter('use_block_editor_for_post', function( $use_block_editor, $post ) {
    if ( ! $post ) {
        return $use_block_editor;
    }

    $disabled_templates = array(
        'page-templates/page-builder.php',
        'page-templates/docs.php',
        'page-templates/docs-home.php',
    );

    // Get the page template of the current post
    $template = get_page_template_slug( $post );

    if ( in_array( $template, $disabled_templates, true ) ) {
        return false; // Disable Gutenberg for these templates
    }

    return $use_block_editor;
}, 10, 2 );



// Note: admin menu is registered in includes/settings-framework.php
// at priority 5 (before Freemius) so submenu items nest correctly.


add_action('acf/init', function() {
    if (function_exists('acf_register_block_type')) {
        acf_register_block_type([
            'name' => 'callout',
            'title' => __('Callout', 'wp-documentation'),
            'description' => __('Callout block by WP Documentation.', 'wp-documentation'),
            'render_template' => get_template_directory() . '/template-parts/blocks/callout.php',
            'category' => 'formatting', // or 'layout'
            'icon' => 'megaphone', // dashicons
            'keywords' => ['callout', 'highlight', 'info'],
            'mode' => 'edit', // or 'preview'
            'supports' => [
                'align' => true,
                'anchor' => true,
            ],
        ]);

        acf_register_block_type([
            'name' => 'code_snippet',
            'title' => __('Code Snippet', 'wp-documentation'),
            'description' => __('Code Snippet block by WP Documentation.', 'wp-documentation'),
            'render_template' => get_template_directory() . '/template-parts/blocks/code-snippet.php',
            'category' => 'formatting', // or 'layout'
            'icon' => 'editor-code', // dashicons
            'keywords' => ['code', 'syntax', 'highlight'],
            'mode' => 'edit', // or 'preview'
            'supports' => [
                'align' => true,
                'anchor' => true,
            ],
        ]);

        acf_register_block_type([
            'name' => 'code_snippet_tabs',
            'title' => __('Code Snippet Tabs', 'wp-documentation'),
            'description' => __('Code Snippet Tabs block by WP Documentation.', 'wp-documentation'),
            'render_template' => get_template_directory() . '/template-parts/blocks/code-snippet-tabs.php',
            'category' => 'formatting', // or 'layout'
            'icon' => 'editor-code', // dashicons
            'keywords' => ['code', 'syntax', 'highlight'],
            'mode' => 'edit', // or 'preview'
            'supports' => [
                'align' => true,
                'anchor' => true,
            ],
        ]);

        acf_register_block_type([
            'name' => 'code_snippet_panels',
            'title' => __('Code Snippet Panels', 'wp-documentation'),
            'description' => __('Code Snippet Panels block by WP Documentation.', 'wp-documentation'),
            'render_template' => get_template_directory() . '/template-parts/blocks/code-snippet-panels.php',
            'category' => 'formatting', // or 'layout'
            'icon' => 'editor-code', // dashicons
            'keywords' => ['code', 'syntax', 'highlight'],
            'mode' => 'edit', // or 'preview'
            'supports' => [
                'align' => true,
                'anchor' => true,
            ],
        ]);

        acf_register_block_type([
            'name' => 'mermaid',
            'title' => __('Mermaid Diagram', 'wp-documentation'),
            'description' => __('Mermaid.js diagram block by WP Documentation.', 'wp-documentation'),
            'render_template' => get_template_directory() . '/template-parts/blocks/mermaid.php',
            'category' => 'formatting',
            'icon' => 'chart-bar',
            'keywords' => ['mermaid', 'diagram', 'flowchart', 'uml'],
            'mode' => 'edit',
            'supports' => [
                'align' => true,
                'anchor' => true,
            ],
        ]);

        acf_register_block_type([
            'name' => 'collapse',
            'title' => __('Collapse', 'wp-documentation'),
            'description' => __('Collapsible content block by WP Documentation.', 'wp-documentation'),
            'render_template' => get_template_directory() . '/template-parts/blocks/collapse.php',
            'category' => 'formatting',
            'icon' => 'arrow-down-alt2',
            'keywords' => ['collapse', 'accordion', 'toggle', 'expand'],
            'mode' => 'edit',
            'supports' => [
                'align' => true,
                'anchor' => true,
            ],
        ]);

        acf_register_block_type([
            'name' => 'cards',
            'title' => __('Cards', 'wp-documentation'),
            'description' => __('Cards block by WP Documentation.', 'wp-documentation'),
            'render_template' => get_template_directory() . '/template-parts/blocks/cards.php',
            'category' => 'formatting',
            'icon' => 'screenoptions',
            'keywords' => ['cards', 'list', 'grid', 'card'],
            'mode' => 'edit',
            'supports' => [
                'align' => true,
                'anchor' => true,
            ],
        ]);

        acf_register_block_type([
            'name' => 'steps',
            'title' => __('Steps', 'wp-documentation'),
            'description' => __('Steps block by WP Documentation.', 'wp-documentation'),
            'render_template' => get_template_directory() . '/template-parts/blocks/steps.php',
            'category' => 'formatting',
            'icon' => 'list-view',
            'keywords' => ['steps', 'process', 'guide', 'workflow'],
            'mode' => 'edit',
            'supports' => [
                'align' => true,
                'anchor' => true,
            ],
        ]);

    }
});



// <Helpers>

if(!function_exists('wp_documentation_get_default_options')) {
    function wp_documentation_get_default_options() {
        return [
            'docs_home_hero_layout' => 'searchbar',
            'docs_home_grid_card' => 'informative',
            'single_doc_layout' => 'default',
            'docs_home_faq_layout' => 'default',
            'primary_color' => '#31358A',
            'primary_color_dark_mode' => '#6f73cc',
            'base_color_light' => '#ffffff',
            'base_color_dark' => '#030712',
            'default_color_scheme' => 'auto',
            'color_style' => 'colorful',
            'font_style' => 'system',
            'roundedness' => 'none',
            'status_bar_enabled' => false,
            'status_bar_messages' => [],
            'status_bar_duration' => 5,
            'status_bar_dismissible' => true,
            'footer_copyright_notice' => '',
            'docs_home_hero_content' => [
                'title' => __('WP Documentation', 'wp-documentation'),
                'description' => __('Find the answers to your questions in our documentation.', 'wp-documentation'),
                'command' => __('npm install react', 'wp-documentation'),
                'link' => [
                    'url' => '#',
                    'title' => __('Get Started', 'wp-documentation'),
                ]
            ],
        ];
    };
}

if(!function_exists('wp_documentation_get_palette_colors')) {
    /**
     * Resolve the active color palette for cards, grids, and icons.
     *
     *   colorful (default) -> 11-color multicolor palette
     *   neutral            -> ['frost']
     *   branded            -> ['primary']
     *
     * @param array|null $theme_options  Optional theme options. Pulled automatically when null.
     * @return array  List of color names suitable for `bg-{name}-50` / `border-{name}-700` Twind classes.
     */
    function wp_documentation_get_palette_colors($theme_options = null) {
        if (empty($theme_options)) {
            $theme_options = function_exists('get_field') ? get_field('wp_documentation_options', 'option') : [];
        }
        if (empty($theme_options)) {
            $theme_options = wp_documentation_get_default_options();
        }

        $color_style = isset($theme_options['color_style']) ? $theme_options['color_style'] : 'colorful';

        switch ($color_style) {
            case 'neutral':
                return ['frost'];
            case 'branded':
                return ['primary'];
            case 'colorful':
            default:
                return [
                    'indigo',
                    'emerald',
                    'amber',
                    'violet',
                    'sky',
                    'rose',
                    'teal',
                    'yellow',
                    'purple',
                    'lime',
                    'pink',
                ];
        }
    }
}

if(!function_exists('wp_documentation_get_callout_color_map')) {
    /**
     * Map callout type keys (note, tip, info, warning, danger) to color names
     * based on the active color_style setting.
     *
     *   colorful  -> note=gray,  tip=green,  info=blue,  warning=orange, danger=red
     *   neutral   -> all gray
     *   branded   -> all primary
     *
     * @param array|null $theme_options Optional theme options. Pulled automatically when null.
     * @return array  Associative array of type_key => color_name.
     */
    function wp_documentation_get_callout_color_map($theme_options = null) {
        if (empty($theme_options)) {
            $theme_options = function_exists('get_field') ? get_field('wp_documentation_options', 'option') : [];
        }
        if (empty($theme_options)) {
            $theme_options = wp_documentation_get_default_options();
        }

        $colorful_map = [
            'note'    => 'gray',
            'tip'     => 'green',
            'info'    => 'blue',
            'warning' => 'orange',
            'danger'  => 'red',
        ];

        $color_style = isset($theme_options['color_style']) ? $theme_options['color_style'] : 'colorful';

        if ($color_style === 'neutral') {
            return array_map(static function () { return 'gray'; }, $colorful_map);
        }
        if ($color_style === 'branded') {
            return array_map(static function () { return 'primary'; }, $colorful_map);
        }

        return $colorful_map;
    }
}

if(!function_exists('wp_documentation_get_hero_dot_color')) {
    /**
     * Resolve the dot-grid color used in hero decorations.
     *
     *   colorful  -> #000
     *   neutral   -> #000
     *   branded   -> var(--color-primary)
     *
     * @param array|null $theme_options Optional theme options. Pulled automatically when null.
     * @return string  CSS color value (hex or var(...)).
     */
    function wp_documentation_get_hero_dot_color($theme_options = null) {
        if (empty($theme_options)) {
            $theme_options = function_exists('get_field') ? get_field('wp_documentation_options', 'option') : [];
        }
        if (empty($theme_options)) {
            $theme_options = wp_documentation_get_default_options();
        }

        $color_style = isset($theme_options['color_style']) ? $theme_options['color_style'] : 'colorful';

        return $color_style === 'branded' ? 'var(--color-primary)' : '#000';
    }
}

if(!function_exists('wp_documentation_get_footer_notice')) {
    function wp_documentation_get_footer_notice() {
        $theme_options = function_exists('get_field') ? get_field('wp_documentation_options', 'option') : [];
        
        if(empty($theme_options)) {
            $theme_options = wp_documentation_get_default_options();
        };

        $user_value = isset( $theme_options['footer_copyright_notice'] ) ? trim( $theme_options['footer_copyright_notice'] ) : '';

        // If user entered something → return it as-is
        if ( ! empty( $user_value ) ) {
            return wp_kses_post( $user_value );
        }

        $default_text = __('Made with ❤️ by RedOxbird', 'wp-documentation');

        if ( is_front_page() || is_home() ) {
            return __('Made with ❤️ by <a href="https://redoxbird.com/" rel="noopener">RedOxbird</a>', 'wp-documentation');
        }

        // Else, return plain text
        return esc_html( $default_text );
    }
};

if(!function_exists('wp_documentation_allowed_svg_tags')) {
    function wp_documentation_allowed_svg_tags() {
        return [
            'svg'    => ['xmlns' => true, 'width' => true, 'height' => true, 'viewbox' => true, 'fill' => true, 'class' => true, 'aria-hidden' => true, 'role' => true, 'stroke' => true, 'stroke-width' => true, 'stroke-linecap' => true, 'stroke-linejoin' => true],
            'g'      => ['fill' => true, 'stroke' => true, 'stroke-width' => true],
            'path'   => ['d' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true],
            'circle' => ['cx' => true, 'cy' => true, 'r' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true],
            'rect'   => ['x' => true, 'y' => true, 'width' => true, 'height' => true, 'fill' => true, 'stroke' => true],
            'line'   => ['x1' => true, 'y1' => true, 'x2' => true, 'y2' => true, 'stroke' => true, 'stroke-width' => true],
            'polyline' => ['points' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true],
            'polygon'  => ['points' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true],
            'title'  => [], // Allows adding a title inside SVG
            'desc'   => [], // Allows adding a description inside SVG
            'use'    => ['href' => true, 'x' => true, 'y' => true, 'width' => true, 'height' => true],
            'animatetransform' => [
                'attributename'  => true, 'attributetype' => true, 'type' => true, 
                'from' => true, 'to' => true, 'dur' => true, 'repeatcount' => true, 
                'calcmode' => true, 'values' => true, 'keytimes' => true, 
                'keysplines' => true, 'additive' => true, 'accumulate' => true, 
                'begin' => true, 'end' => true, 'restart' => true, 'fill' => true
            ],
        ];
    }
}


if(!function_exists('wp_documentation_is_local_environment')) {
    function wp_documentation_is_local_environment() {
        $whitelist = ['127.0.0.1', '::1', 'localhost'];

        if (isset($_SERVER['REMOTE_ADDR']) && in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
            return true;
        }

        if (isset($_SERVER['HTTP_HOST'])) {
            $local_domains = ['localhost', 'test.local', 'wp.local'];
            foreach ($local_domains as $domain) {
                if (strpos($_SERVER['HTTP_HOST'], $domain) !== false) {
                    return true;
                }
            }
        }

        return false;
    }
}

// <REMOVE_IN_PRO_VERSION>
if(!function_exists('wp_documentation_is_pro')) {
    if(wp_documentation_is_local_environment()) {
        function wp_documentation_is_pro() {
            return true;
        }
    } else {
        function wp_documentation_is_pro() {
            if ( function_exists( 'wd_fs' ) ) {
                return wd_fs()->can_use_premium_code();
            }

            return false;
        }
    }
}
// </REMOVE_IN_PRO_VERSION>



function wp_documentation_dd() {
    echo '<pre>';
    array_map(function ($x) {
        var_dump($x);
    }, func_get_args());
    echo '</pre>';
    die;
}

function wp_documentation_truncate($string, $length = 100, $append = "&hellip;") {
    $string = trim($string);

    if (strlen($string) > $length) {
        $string = wordwrap($string, $length);
        $string = explode("\n", $string, 2);
        $string = $string[0] . $append;
    }

    return $string;
}

function wp_documentation_assets($path) {
    if (!$path) {
        return;
    }

    return get_template_directory_uri() . '/assets/' . $path;
}

function wp_documentation_svg($filename, $class = "") {
    if (!$filename) {
        return;
    }

    $file_location = get_template_directory() . '/assets/icons/' . $filename . '.svg';

    if (!file_exists($file_location)) {
        return;
    }

    $svg_content = file_get_contents($file_location);

    if (!empty($class)) {
        // Check if the SVG has an opening <svg> tag
        if (strpos($svg_content, '<svg') !== false) {
            // Add the class to the opening <svg> tag
            $svg_content = str_replace('<svg', '<svg class="' . esc_attr($class) . '"', $svg_content);
        } else {
            // If the <svg> tag is missing, wrap the content with it and add the class
            $svg_content = '<svg class="' . esc_attr($class) . '">' . $svg_content . '</svg>';
        }
    }

    return $svg_content;
}

function wp_documentation_get_version() {
    $version = WP_DOCUMENTATION_VERSION;

    if (!function_exists('wp_get_environment_type')) {
        return $version;
    }

    switch (wp_get_environment_type()) {
        case 'local':
        case 'development':
            $version = time();
            break;
    }

    return $version;
}

// </Helpers>

// <Actions>

function wp_documentation_after_setup_theme() {
    /*
    * Default Theme Support options better have
    */
    add_theme_support('automatic-feed-links');
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('editor-styles');
    add_theme_support('wp-block-styles');

    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    /**
     * Add woocommerce support and woocommerce override
     */

    add_theme_support('woocommerce', array(
        'thumbnail_image_width' => 300,
        'single_image_width' => 1024,
        'product_grid' => array(
            'default_rows' => 3,
            'min_rows' => 3,
            'max_rows' => 3,
            'default_columns' => 4,
            'min_columns' => 4,
            'max_columns' => 4,
        ),
    ));

    $GLOBALS['content_width'] = apply_filters('content_width', 1920);

    register_nav_menus(array(
        'primary' => esc_html__('Primary', 'wp-documentation'),
        'secondary' => esc_html__('Secondary', 'wp-documentation'),
        'footer' => esc_html__('Footer', 'wp-documentation'),
    ));

    load_theme_textdomain('SLUG', get_template_directory() . '/languages' );
}


function wp_documentation_enqueue_scripts() {
    // Scripts
    wp_enqueue_script('alpine-focus', wp_documentation_assets('js/alpine-focus.min.js'), array(), wp_documentation_get_version(), false);
    wp_enqueue_script('alpine-persist', wp_documentation_assets('js/alpine-persist.min.js'), array(), wp_documentation_get_version(), false);
    wp_enqueue_script('alpine-collapse', wp_documentation_assets('js/alpine-collapse.min.js'), array(), wp_documentation_get_version(), false);
    wp_enqueue_script('alpine-intersect', wp_documentation_assets('js/alpine-intersect.min.js'), array(), wp_documentation_get_version(), false);
    wp_enqueue_script('alpine-csp', wp_documentation_assets('js/alpine-csp.min.js'), array(), wp_documentation_get_version(), false);
    wp_enqueue_script('simplebar', wp_documentation_assets('js/simplebar.min.js'), array(), wp_documentation_get_version(), false);
    wp_enqueue_script('twind', wp_documentation_assets('js/twind.min.js'), array(), wp_documentation_get_version(), false);

    wp_enqueue_script('floating-ui-core', wp_documentation_assets('js/floating-ui-core.js'), array(), '1.7.2', false);
    wp_enqueue_script('floating-ui-dom', wp_documentation_assets('js/floating-ui-dom.js'), array(), '1.7.2', false);
    wp_enqueue_script('embla', wp_documentation_assets('js/embla-carousel.umd.js'), array(), '8.6.0', false);

    wp_add_inline_script('twind', file_get_contents(get_template_directory(). "/assets/js/head.js"), "after");
    wp_register_script('highlightjs', wp_documentation_assets('js/highlight.min.js'), array(), wp_documentation_get_version(), false);

    if(has_block('acf/mermaid')) {
        wp_enqueue_script('mermaid', wp_documentation_assets('js/mermaid.min.js'), array(), wp_documentation_get_version(), true);
    }

    wp_enqueue_script('wp-documentation-icons', wp_documentation_assets('js/components/icons.js'), array(), wp_documentation_get_version(), true);
    wp_enqueue_script('wp-documentation-callout', wp_documentation_assets('js/components/wp-callout.js'), array('wp-documentation-icons'), wp_documentation_get_version(), true);

    wp_enqueue_script('wp-documentation-main', wp_documentation_assets('js/main.js'), array('jquery'), wp_documentation_get_version(), true);
   
    wp_enqueue_style('animxyz', wp_documentation_assets('css/animxyz.min.css'), array(), "0.6.7", 'all');
    wp_enqueue_style('simplebar', wp_documentation_assets('css/simplebar.css'), array(), wp_documentation_get_version(), 'all');
    wp_register_style('wp-documentation-prose', get_template_directory_uri(). '/assets/css/prose.css', array(), wp_documentation_get_version(), 'all');
    wp_enqueue_style('wp-documentation-style', wp_documentation_assets('css/style.css'), array(), wp_documentation_get_version(), 'all');
    wp_add_inline_style('wp-documentation-style', wp_documentation_inline_css());
    wp_enqueue_style('dashicons');
    
    // Font style enqueue
    $theme_options = function_exists('get_field') ? get_field('wp_documentation_options', 'option') : wp_documentation_get_default_options();
    if (empty($theme_options)) {
        $theme_options = wp_documentation_get_default_options();
    }
    $font_style = isset($theme_options['font_style']) ? $theme_options['font_style'] : 'system';
    if ($font_style !== 'system') {
        wp_enqueue_style(
            'wp-documentation-fonts-' . $font_style,
            wp_documentation_assets('css/fonts-' . $font_style . '.css'),
            array(),
            wp_documentation_get_version()
        );
    }
    
    // Localize
    wp_localize_script('wp-documentation-main', 'WPDocumentationData', [
        '_wpnonce' => wp_create_nonce('wp_documentation_ajax'),
        'home_url' => esc_url(home_url()),
        'assets_url' => wp_documentation_assets('/'),
        'ajax_url' => admin_url('admin-ajax.php')
    ]);

    // Extra
    if(is_singular() || is_archive('release-note')) {
        wp_enqueue_style('wp-documentation-prose');
        wp_enqueue_script('highlightjs');
    }

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}


add_action('admin_head', function() {
    $screen = get_current_screen();
    if (!$screen) return;

    $settings_page_slug = 'wp_documentation_options';
    if ($screen->id === 'toplevel_page_' . $settings_page_slug || $screen->id === 'wp-documentation_page_wp_documentation_options-pro') {
        remove_all_actions('admin_notices');
        remove_all_actions('all_admin_notices');
    }
}, 1);

add_action('admin_enqueue_scripts', function() {
    $settings_page_slug = 'wp_documentation_options';
    $screen = get_current_screen();

    if (isset($screen->id) && $screen->id === 'toplevel_page_'.$settings_page_slug || isset($screen->id) && $screen->id === 'wp-documentation_page_wp_documentation_options-pro') {
        wp_enqueue_script('alpine', wp_documentation_assets('js/alpine.min.js'), array(), wp_documentation_get_version(), false);
        wp_enqueue_script('twind', wp_documentation_assets('js/twind.min.js'), array(), wp_documentation_get_version(), false);
        wp_enqueue_script('wp-documentation-admin', wp_documentation_assets('js/admin.js'), array('jquery'), wp_documentation_get_version(), true);
        wp_enqueue_style('wp-documentation-admin', wp_documentation_assets('css/admin.css'), array(), wp_documentation_get_version(), 'all');

        wp_add_inline_script('twind', file_get_contents(get_template_directory(). "/assets/js/head.js"), "after");

        wp_localize_script('wp-documentation-admin', 'WPDocumentationData', array(
            '_wpnonce' => wp_create_nonce('wp_documentation_ajax'),
            'homeURL' => esc_url(home_url()),
            'ajax_url' => admin_url('admin-ajax.php'),
        ));
    }
});

add_action('acf/input/admin_enqueue_scripts', function () {
    wp_register_script('wp-documentation-acf', wp_documentation_assets('js/acf.js'), ['acf-input'], wp_documentation_get_version(), true);

    wp_localize_script('wp-documentation-acf', 'WPDocumentationData', array(
        'is_pro' => wp_documentation_is_pro() ? true : false,
    ));

    wp_enqueue_script('wp-documentation-acf');
});

if(!function_exists('wp_documentation_mix_colors')) {
    function wp_documentation_mix_colors($color1, $color2, $ratio) {
        $r1 = hexdec(substr($color1, 1, 2));
        $g1 = hexdec(substr($color1, 3, 2));
        $b1 = hexdec(substr($color1, 5, 2));
        $r2 = hexdec(substr($color2, 1, 2));
        $g2 = hexdec(substr($color2, 3, 2));
        $b2 = hexdec(substr($color2, 5, 2));
        $r = round($r1 + ($r2 - $r1) * $ratio);
        $g = round($g1 + ($g2 - $g1) * $ratio);
        $b = round($b1 + ($b2 - $b1) * $ratio);
        return sprintf("#%02x%02x%02x", max(0, min(255, $r)), max(0, min(255, $g)), max(0, min(255, $b)));
    }
}

function wp_documentation_inline_css() {
    $theme_options = function_exists('get_field') ? get_field('wp_documentation_options', 'option') : wp_documentation_get_default_options();
    
    if(empty($theme_options)) {
        $theme_options = wp_documentation_get_default_options();
    }

    $primary_color = !empty($theme_options['primary_color']) ? $theme_options['primary_color'] : "#31358A";
    $primary_color__dark_mode = !empty($theme_options['primary_color_dark_mode']) ? $theme_options['primary_color_dark_mode'] : '#6f73cc';
    $base_color_light = !empty($theme_options['base_color_light']) ? $theme_options['base_color_light'] : '#ffffff';
    $base_color_dark = !empty($theme_options['base_color_dark']) ? $theme_options['base_color_dark'] : '#030712';
    
    $frost_ratios = [
        0    => 0,
        50   => 0.025,
        100  => 0.05,
        200  => 0.10,
        300  => 0.18,
        400  => 0.38,
        500  => 0.58,
        600  => 0.73,
        700  => 0.82,
        800  => 0.90,
        900  => 0.96,
        1000 => 1,
    ];

    $frost_light = '';
    $frost_dark = '';

    foreach ($frost_ratios as $shade => $ratio) {
        $light = wp_documentation_mix_colors($base_color_light, '#000000', $ratio);
        $dark = wp_documentation_mix_colors($base_color_dark, '#ffffff', $ratio);
        $frost_light .= "            --color-frost-{$shade}: {$light};\n";
        $frost_dark  .= "            --color-frost-{$shade}: {$dark};\n";
    }
    
    return $css = "
        body {
            --color-primary: {$primary_color};
            --color-primary-50: {$primary_color}0d;
            --color-primary-100: {$primary_color}1a;
            --color-primary-200: {$primary_color}33;
            --color-primary-300: {$primary_color}4D;
            --color-primary-400: {$primary_color}66;
            --color-primary-500: {$primary_color}80;
            --color-primary-600: {$primary_color}B3;
            --color-primary-700: {$primary_color};
            --color-primary-800: {$primary_color}cc;
            --color-primary-900: {$primary_color}e6;
            --color-primary-foreground: #ffffff;
            --color-secondary: #A8DADC;
            --color-accent: #E63946;
            --color-dark: #21262c;
            --color-dark-green: #52821C;
            --color-red-400: #f87171;
            --color-red-300: #fca5a5;
            --color-red-700: #b91c1c;
{$frost_light}            --ease-out-expo: cubic-bezier(0.19, 1, 0.22, 1);
            --font-family: -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, Oxygen-Sans, Ubuntu, Cantarell, \"Helvetica Neue\", sans-serif;
            --line-height: 1.6;
        }
        body[data-color-scheme=\"dark\"] {
            --color-primary: {$primary_color__dark_mode};
            --color-primary-50: {$primary_color__dark_mode}0d;
            --color-primary-100: {$primary_color__dark_mode}1a;
            --color-primary-200: {$primary_color__dark_mode}33;
            --color-primary-300: {$primary_color__dark_mode}4D;
            --color-primary-400: {$primary_color__dark_mode}66;
            --color-primary-500: {$primary_color__dark_mode}80;
            --color-primary-600: {$primary_color__dark_mode}B3;
            --color-primary-700: {$primary_color__dark_mode};
            --color-primary-800: {$primary_color__dark_mode}cc;
            --color-primary-900: {$primary_color__dark_mode}e6;
            --color-primary-foreground: #030712;
{$frost_dark}        }
    ";
};


function wp_documentation_register_required_plugins() {
    $plugins = array(
        array(
            'name'      => 'Secure Custom Fields',
            'slug'      => 'secure-custom-fields',
            'required'  => false,
        ),
        array(
            'name'      => 'Fast Fuzzy Search - WordPress & WooCommerce Search Plugin',
            'slug'      => 'fast-fuzzy-search',
            'required'  => false,
        ),
        array(
            'name'      => 'Nested Pages',
            'slug'      => 'wp-nested-pages',
            'required'  => false,
        )
    );

    $config = array(
        'id'           => 'wp-documentation', // Unique ID for TGMPA
        'default_path' => '',
        'menu'         => 'tgmpa-install-plugins', // Menu slug
        'parent_slug'  => 'themes.php',
        'capability'   => 'edit_theme_options',
        'has_notices'  => true,
        'dismissable'  => true,
        'dismiss_msg'  => '', // Customize the dismissal message
        'is_automatic' => true,
        'message'      => '', // Customize the notice message
    );

    tgmpa($plugins, $config);
}

function wp_documentation_add_defer_to_alpine_script($tag, $handle, $src) {
    $defer_scripts = array('alpine', 'alpine-focus', 'alpine-collapse', 'alpine-persist', 'alpine-intersect', 'alpine-csp');

    if (in_array($handle, $defer_scripts)) {
        return str_replace(' src', ' defer src', $tag);
    }

    return $tag;
}


function wp_documentation_add_ids_to_headings($content) {
    if(get_post_type() == 'post' || get_post_type() == 'docs') {
        $content = preg_replace_callback('/<h([1-6])>(.*?)<\/h\1>/', 'wp_documentation_sanitize_heading_callback', $content);
    }

    return $content;
}

function wp_documentation_kses_ruleset() {
    $kses_defaults = wp_kses_allowed_html('post');

    $svg_args = array(
        'svg' => array(
            'class' => true,
            'aria-hidden' => true,
            'aria-labelledby' => true,
            'stroke-width' => true,
            'stroke' => true,
            'stroke-linecap' => true,
            'stroke-linejoin' => true,
            'fill' => true,
            'role' => true,
            'xmlns' => true,
            'width' => true,
            'height' => true,
            'viewbox' => true, // <= Must be lower case!
        ),
        'g' => array('fill' => true),
        'title' => array('title' => true),
        'path' => array(
            'd' => true,
            'fill' => true,
            'stroke' => true,
        ),
        'line' => array(
            "x1" => true,
            "y1" => true,
            "x2" => true,
            "y2" => true
        ),
        'polyline' => array(
            'points' => true
        )
    );

    return array_merge($kses_defaults, $svg_args);
}


function wp_documentation_get_document_hierarchy_recursive($posts, $post_map, $parent_id = 0) {
    $documents = array();

    foreach ($posts as $post) {
        $post_id = $post->ID;
        $current_parent_id = $post->post_parent;

        // If post has the specified parent, add it to the parent's children array
        if ($current_parent_id == $parent_id) {
            $children = wp_documentation_get_document_hierarchy_recursive($posts, $post_map, $post_id);

            $documents[] = array(
                'ID'       => $post_id,
                'title'    => get_the_title($post_id),
                'permalink' => get_the_permalink($post_id),
                'children' => $children,
                'headings' => wp_documentation_get_headings($post->post_content),
                // Add other fields you may need
            );
        }
    }

    return $documents;
};

function wp_documentation_get_document_hierarchy($args = array(
        'post_type'      => 'docs',
        'posts_per_page' => 10000,
        'orderby'        => 'menu_order',
        'order' => 'ASC',
    )) {

    $query = new WP_Query($args);

    if (!$query->have_posts()) {
        return array(); // No documents found
    }

    $posts = $query->posts;

    // Create a map to easily find posts by ID
    $post_map = array();
    foreach ($posts as $post) {
        $post_map[$post->ID] = $post;
    }

    // Determine parent_id: use passed post_parent or default to 0
    $parent_id = isset($args['post_parent']) ? intval($args['post_parent']) : 0;

    // Start the recursive process
    $document_hierarchy = wp_documentation_get_document_hierarchy_recursive($posts, $post_map, $parent_id);

    wp_reset_postdata();

    return $document_hierarchy;
};

function wp_documentation_get_level_2_headings($content) {
    preg_match_all('/<h2[^>]*>(.*?)<\/h2>/si', $content, $matches);

    $headings = array();
    foreach ($matches[1] as $heading) {
        $headings[] = strip_tags($heading);
    }

    return $headings;
};

function wp_documentation_get_toc($content) {
    // Match all heading elements (h1 to h6) in the content using a regular expression
    // $pattern = '/<(h[1-6])(.*?)>(.*?)<\/h[1-6]>/i';
    $pattern = '/<(h2)(.*?)>(.*?)<\/h[1-6]>/i';
    preg_match_all($pattern, $content, $headings);

    // Check if any headings were found
    if (!empty($headings[0])) {
        $toc_list = '<nav role="navigation" class="table-of-contents"><h2>On This Page</h2><ul>';
        $heading_stack = array();

        // Loop through each heading and add an ID attribute
        for ($i = 0; $i < count($headings[0]); $i++) {
            $tag = $headings[1][$i]; // The heading tag (e.g., 'h1', 'h2', etc.)
            $attributes = $headings[2][$i]; // Any additional attributes in the heading tag
            $heading_text = $headings[3][$i]; // The text inside the heading

            // Generate an ID using the sanitize_title() function
            $heading_id = sanitize_title(strip_tags(preg_replace('/[^\x00-\x7F]+/u', '', $heading_text)));

            // Get the heading level (e.g., 1, 2, etc.)
            $heading_level = intval(substr($tag, 1));

            while (count($heading_stack) > 0 && end($heading_stack) >= $heading_level) {
                $toc_list .= '</li></ul>';
                array_pop($heading_stack);
            }

            $toc_list .= '<li><a href="#' . $heading_id . '">' . strip_tags($heading_text) . '</a>';

            if (count($heading_stack) === 0 || end($heading_stack) < $heading_level) {
                $toc_list .= '<ul>';
                $heading_stack[] = $heading_level;
            }
        }

        // Close any remaining nested lists
        while (count($heading_stack) > 0) {
            $toc_list .= '</li></ul>';
            array_pop($heading_stack);
        }

        $toc_list .= '</ul></nav>';

        return $toc_list;
    }

    return false;
};

function wp_documentation_get_headings($content) {
    $headings = array();

    // Define the regex pattern for matching headings (h1 to h6)
    $pattern = '/<h([1-6])[^>]*>(.*?)<\/h\1>/i';

    // Perform the regex match
    preg_match_all($pattern, $content, $matches, PREG_SET_ORDER);

    // Iterate through the matches and add to the headings array
    foreach ($matches as $match) {
        $headingLevel = $match[1];
        $headingText = strip_tags($match[2]); // Remove HTML tags from heading text
        $sanitizedHeading = sanitize_title($headingText);
        $headings[] = "$headingText";
    }

    return $headings;
}

function wp_documentation_sanitize_heading_callback($matches) {
    // Extract the heading level and text
    $heading_level = $matches[1];
    $heading_text = strip_tags($matches[2]); // Strip HTML tags from heading text

    // Sanitize the heading text to create a valid ID
    $sanitized_heading_text = sanitize_title($heading_text);

    // Generate the ID by combining the heading level and sanitized text
    $heading_id = $sanitized_heading_text;

    // Return the original heading with the added ID
    return "<h$heading_level id=\"$heading_id\">$matches[2]</h$heading_level>";
}

function wp_documentation_flatten_pages_list($pages, $parent_title = null) {
    $titles = [];
    $paths = [];

    foreach ($pages as $i => $page) {
        $page_title = $page['title'];
        $page_path = $page['permalink'];

        if($parent_title != null) {
            $page_title = $parent_title . WP_DOCUMENTATION_JOIN_SYMBOL . $page['title'];
        }

        $titles[] = $page_title;
        $paths[] = $page_path;

        if (!empty($page['headings'])) {
            foreach ($page['headings'] as $j => $heading) {
                $titles[] = $page_title . WP_DOCUMENTATION_JOIN_SYMBOL . $heading;
                $paths[] = $page_path ."#". sanitize_title($heading);
            };
        };

        if (!empty($page['children'])) {
            $recursed = array_merge($titles, wp_documentation_flatten_pages_list($page['children'], $page_title));

            $titles = array_merge($titles, $recursed['titles']);
            $paths = array_merge($paths, $recursed['paths']);
        }
    }

    return [
        'titles' => $titles,
        'paths' => $paths
    ];
}


function wp_documentation_get_breadcrumb()
{
    $args = array(
        'container' => 'nav',
        'before' => '',
        'after' => '',
        'browse_tag' => 'h2',
        'list_tag' => 'ul',
        'item_tag' => 'li',
        'divider' => wp_documentation_svg('chevron-right'),
        'show_on_front' => true,
        'network' => false,
        'show_title' => true,
        'show_browse' => false,
        'labels' => array(
            'browse' => esc_html__('Browse:', 'wp-documentation'),
            'aria_label' => esc_attr_x('Breadcrumbs', 'breadcrumbs aria label', 'wp-documentation'),
            'aria_label_home' => esc_attr_x('Home', 'breadcrumbs aria label', 'wp-documentation'),
            'home' => esc_attr_x('Home', 'breadcrumbs aria label', 'wp-documentation'),
            'error_404' => esc_html__('404 Not Found', 'wp-documentation'),
            'archives' => esc_html__('Archives', 'wp-documentation'),
            'search' => esc_html__('Search results for: %s', 'wp-documentation'),
            'paged' => esc_html__('Page %s', 'wp-documentation'),
            'paged_comments' => esc_html__('Comment Page %s', 'wp-documentation'),
            'archive_minute' => esc_html__('Minute %s', 'wp-documentation'),
            'archive_week' => esc_html__('Week %s', 'wp-documentation'),
            'archive_minute_hour' => '%s',
            'archive_hour' => '%s',
            'archive_day' => '%s',
            'archive_month' => '%s',
            'archive_year' => '%s',
        ),
        'post_taxonomy' => array(
            'docs'  => 'category',
            'docs'  => 'doc_version',
            // 'book'  => 'genre',    // 'book' post type and 'genre' taxonomy
        ),
        'echo' => true,
    );

    $breadcrumb = new BreadcrumbsTrail;
    $breadcrumb->register($args);

    return $breadcrumb->trail();
}

function wp_documentation_recursive_array_search($needle, $haystack, $keyToSearch) {
    foreach ($haystack as $key => $value) {
        if ($key === $keyToSearch && $value === $needle) {
            return $haystack;
        } elseif (is_array($value)) {
            $result = wp_documentation_recursive_array_search($needle, $value, $keyToSearch);
            if ($result !== false) {
                return $result;
            }
        }
    }
    return false;
}

function wp_documentation_get_plugin_state_by_slug( $slug ) {
    // Load plugin-related functions if not already available
    if ( ! function_exists( 'get_plugins' ) ) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }

    $plugins = get_plugins();
    $plugin_path = '';

    // Match plugin path using slug
    foreach ( $plugins as $path => $details ) {
        if ( strpos( $path, $slug . '/' ) === 0 || $path === $slug . '.php' ) {
            $plugin_path = $path;
            break;
        }
    }

    // Not installed
    if ( empty( $plugin_path ) ) {
        return 'not installed';
    }

    // Load is_plugin_active() if needed
    if ( ! function_exists( 'is_plugin_active' ) ) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }

    // Check if active
    if ( is_plugin_active( $plugin_path ) ) {
        return 'active';
    }

    return 'inactive';
}


function wp_documentation_get_color_scheme() {
    $options = function_exists('get_field') ? get_field('wp_documentation_options', 'option') : wp_documentation_get_default_options();

    if (isset($options['default_color_scheme'])) {
        return $options['default_color_scheme'];
    } else {
        return 'light';
    }
}

function wp_documentation_render_html($html) {
    if (!$html) return '';

    // Remove any <script> tags
    $html = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $html);

    // Optional: Remove dangerous inline JS (onclick, onmouseover, etc.)
    // This will leave x-on:* attributes intact for Alpine
    $html = preg_replace('/\s(on\w+)=["\'].*?["\']/i', '', $html);

    echo $html;
}