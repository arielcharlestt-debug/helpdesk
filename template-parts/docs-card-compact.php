<?php

/**
 * Template part for displaying content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package wp_documentation
 */

if ($args) {
	extract($args);
}

$icon = function_exists('get_field') ? get_field('icon', $document['ID']) : null;

?>

<div x-data="docsCard" class="w-full h-full">
    <a 
        href="<?php echo esc_url($document['permalink']); ?>"
        class="w-full h-full border border-frost-300 p-4 flex gap-4 justify-start items-center bg-frost-0 hover:border-frost-1000 x-rounded-2xl overflow-hidden">
        <?php get_template_part('template-parts/docs-card--icon', null, array('icon' => $icon, 'color' => $color)); ?>

        <span class="text-sm font-primary font-semibold"><?php echo esc_html($document['title']); ?></span>

        <span class="w-4 h-4 inline-flex justify-center items-center ml-auto"><?php echo wp_documentation_svg('chevron-right'); ?></span>
    </a>
</div>