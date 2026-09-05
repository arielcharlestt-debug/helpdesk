<?php

/**
 * Template Name: Docs (Home)
 *
 */

get_header(); 

$theme_options = function_exists('get_field') ? get_field('wp_documentation_options', 'option') : wp_documentation_get_default_options();

if(empty($theme_options)) {
  $theme_options = wp_documentation_get_default_options();
};

$document_args = [
  'post_type'      => 'docs',
  'posts_per_page' => 10000,
  'orderby'        => 'menu_order',
  'order' => 'ASC',
];

if(!empty($parent)) {
  $document_args['post_parent'] = $parent->ID;
};

$documents = wp_documentation_get_document_hierarchy($document_args);
$colors = wp_documentation_get_palette_colors($theme_options);

$hero_layout = !empty($theme_options['docs_home_hero_layout']) ? $theme_options['docs_home_hero_layout'] : 'searchbar';
$grid_card = !empty($theme_options['docs_home_grid_card']) ? $theme_options['docs_home_grid_card'] : 'informative';
$faq_layout = !empty($theme_options['docs_home_faq_layout']) ? $theme_options['docs_home_faq_layout'] : 'default';

$subtitle = !empty($theme_options['docs_home_hero_content']['subtitle']) ? $theme_options['docs_home_hero_content']['subtitle'] : null;
$title = !empty($theme_options['docs_home_hero_content']['title']) ? $theme_options['docs_home_hero_content']['title'] : null;
$description = !empty($theme_options['docs_home_hero_content']['description']) ? $theme_options['docs_home_hero_content']['description'] : null;
$commmand = !empty($theme_options['docs_home_hero_content']['command']) ? $theme_options['docs_home_hero_content']['command'] : null;
$link = !empty($theme_options['docs_home_hero_content']['link']) ? $theme_options['docs_home_hero_content']['link'] : null;
$link_secondary = !empty($theme_options['docs_home_hero_content']['link_secondary']) ? $theme_options['docs_home_hero_content']['link_secondary'] : null;
$background_image = !empty($theme_options['docs_home_hero_content']['background_image']) ? $theme_options['docs_home_hero_content']['background_image'] : null;
?>

<div id="content">
  <?php 
    get_template_part('template-parts/docs-hero', $hero_layout, [
      'subtitle' => $subtitle,
      'title' => $title,
      'description' => $description,
      'command' => !empty($commmand) ? $commmand : null,
      'link' => !empty($link) ? $link : [],
      'link_secondary' => !empty($link_secondary) ? $link_secondary : [],
	  'background_image' => $background_image
    ]);
  ?>

  <?php 
    get_template_part('template-parts/docs-grid', $grid_card, [
      'documents' => $documents,
      'colors' => $colors,
    ]); 
  ?>
  <?php get_template_part('template-parts/docs-faq', $faq_layout); ?>
</div>


<?php
get_footer();
