<?php

$theme_options = function_exists('get_field') ? get_field('wp_documentation_options', 'option') : wp_documentation_get_default_options();

if(empty($theme_options)) {
    $theme_options = wp_documentation_get_default_options();
}

get_template_part('page-templates/docs', 'home', [
    'title' => !empty($theme_options['docs_home_hero_content']['title']) ? $theme_options['docs_home_hero_content']['title'] : __('WP Documentation', 'wp-documentation'),
    'description' => !empty($theme_options['docs_home_hero_content']['description']) ? $theme_options['docs_home_hero_content']['description'] : __('Find the answers to your questions in our documentation.', 'wp-documentation'),
]);
 
?>