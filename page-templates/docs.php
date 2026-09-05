<?php

/**
 * Template Name: Docs (Custom)
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
        <?php foreach ($sections as $key => $section): ?>
            <?php if($section['acf_fc_layout'] === 'hero'): ?>
                <?php get_template_part('template-parts/docs-hero', $section['type']['value'], $section); ?>
            <?php elseif($section['acf_fc_layout'] === 'grid'): ?>
                <?php
                    $document_args = [
                        'post_type'      => 'docs',
                        'posts_per_page' => 10000,
                        'orderby'        => 'menu_order',
                        'order' => 'ASC',
                    ];

                    if(!empty($section['parent'])) {
                        $document_args['post_parent'] = $section['parent']->ID;
                    };

                    $documents = wp_documentation_get_document_hierarchy($document_args); 
                ?>
                <?php 
                    get_template_part('template-parts/docs-grid', $section['type']['value'], [
                        'documents' => $documents,
                        'colors' => $colors,
                    ]); 
                ?>
            <?php elseif($section['acf_fc_layout'] === 'faqs'): ?>
                <?php get_template_part('template-parts/docs-faq-default', null, $section); ?>
            <?php elseif($section['acf_fc_layout'] === 'section_title'): ?>
                <?php get_template_part('template-parts/section-title', null, $section); ?>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</div>


<?php
get_footer();
