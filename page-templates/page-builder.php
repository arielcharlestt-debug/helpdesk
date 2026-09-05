<?php

/**
 * Template Name: Page Builder
 *
 */

if (!wp_documentation_is_pro()) {
    get_header();
    echo '<div class="x-container my-16 text-center"><h1 class="text-4xl mb-4">' . esc_html__('Premium Feature', 'wp-documentation') . '</h1><p>' . esc_html__('This template requires WP Documentation Pro.', 'wp-documentation') . '</p></div>';
    get_footer();
    return;
}

get_header(); 

$theme_options = function_exists('get_field') ? get_field('wp_documentation_options', 'option') : wp_documentation_get_default_options();

if(empty($theme_options)) {
  $theme_options = wp_documentation_get_default_options();
};

$colors = wp_documentation_get_palette_colors($theme_options);

$sections = get_field('sections');

?>

<div id="content">
  <?php if(!empty($sections)): ?>
        <?php foreach ($sections as $index => $section): ?>
            <?php if($section['acf_fc_layout'] === 'hero'): ?>
                <?php get_template_part('template-parts/docs-hero', $section['type'], $section); ?>
            <?php elseif($section['acf_fc_layout'] === 'grid'): ?>
                <?php get_template_part('template-parts/grid', !empty($section['type']) ? $section['type'] : 'default', $section); ?>
            <?php elseif($section['acf_fc_layout'] === 'callout'): ?>
                <?php get_template_part('template-parts/callout', null, $section); ?>
            <?php elseif($section['acf_fc_layout'] === 'posts'): ?>
                <?php get_template_part('template-parts/posts', null, $section); ?>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>


<?php
get_footer();
