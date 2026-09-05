<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($args) {
  extract($args);
}

$theme_options = function_exists('get_field') ? get_field('wp_documentation_options', 'option') : wp_documentation_get_default_options();

if(empty($theme_options)) {
    $theme_options = wp_documentation_get_default_options();
};

$color_style = isset($theme_options['color_style']) ? $theme_options['color_style'] : 'colorful';
$color = $color_style === 'branded' ? 'frost' : 'frost';

?>

<button
    x-data="fastFuzzySearchTrigger"
    x-on:click="showSearch"
    x-bind:disabled="isDisabled"
    x-on:keydown.window.prevent.ctrl.k="showSearch"
    class="lg:max-w-3xl h-12 shrink-0 grow mr-auto x-rounded-2xl bg-<?php echo esc_attr($color) ?>-100 text-<?php echo esc_attr($color) ?>-700 border-2 border-<?php echo esc_attr($color) ?>-200 p-4 border-solid justify-start items-center focus-within:outline-2 focus-within:border-<?php echo esc_attr($color) ?>-900 when-md:text-sm disabled:opacity-50 <?php echo !empty($classes) ? $classes : ''; ?>">
    <span x-cloak x-show="isNotLoading" class="inline-flex justify-center items-center w-5 h-5 mr-4">
        <?php echo wp_documentation_svg('search'); ?>
    </span>

    <span x-show="isLoading" class="inline-flex justify-center items-center w-5 h-5 mr-4">
        <?php echo wp_documentation_svg('spinner'); ?>
    </span>

    <span class="mr-4 text-sm">
        <?php esc_attr_e('Search for docs, posts, pages, etc', 'wp-documentation'); ?>
    </span>
    
    <span class="ml-auto text-xs font-semibold">
        <?php esc_attr_e('Ctrl + K', 'wp-documentation'); ?>
    </span>
</button>