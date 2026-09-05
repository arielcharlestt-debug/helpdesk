<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function wp_documentation_register_settings_framework($page_title, $menu_title, $option_name) {
    $fields = [];

    return function($field) use (&$fields) {
        $fields[] = $field;
    };
}

function wp_documentation_render_settings_page() {
    ?>
    <div class="wrap">
        <header class="wp-sync-plugin-header flex items-center justify-between bg-white border-b border-gray-300 -mx-2 px-6 py-4">
            <div class="wp-sync-plugin-header-brand flex items-center gap-2 mr-2">
                <span class="wp-sync-plugin-header-icon flex items-center justify-center w-6 h-6 text-[#2271b1]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                    </svg>
                </span>
            </div>

            <h1 class="wp-sync-plugin-header-title !m-0 !p-0 !mr-auto text-base font-semibold text-gray-900">
                <?php echo esc_html__('WP Documentation', 'wp-documentation'); ?>
            </h1>

            <?php if(wp_documentation_is_pro()): ?>
                <div class="pt-[9px] ml-4">
                    <span class="inline-flex px-4 py-2 bg-green-50 border border-green-400 rounded-full text-green-700 font-bold">
                        <?php esc_html_e('Pro is Activated', 'wp-documentation'); ?>
                    </span>
                </div>
            <?php endif; ?>
        </header>

        <?php get_template_part('template-parts/admin/upgrade'); ?>
        <?php get_template_part('template-parts/admin/plugins'); ?>
        <?php get_template_part('template-parts/admin/onboarding'); ?>
    </div>
    <?php
}

// Register the menu early (priority 5) so Freemius can add its submenu items under it
add_action('admin_menu', function() {
    add_menu_page(
        __('WP Documentation', 'wp-documentation'),
        __('WP Documentation', 'wp-documentation'),
        'manage_options',
        'wp_documentation_options',
        'wp_documentation_render_settings_page',
        'dashicons-media-document',
    );
});
