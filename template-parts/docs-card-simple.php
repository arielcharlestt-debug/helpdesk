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

<div x-data="docsCard" class="w-full">
    <a
        href="<?php echo esc_url($document['permalink']); ?>"
        class="w-full border-b border-frost-300 px-4 py-3 flex flex-row gap-3 justify-start items-center bg-frost-0 hover:bg-frost-50">
        <?php get_template_part('template-parts/docs-card--icon', null, array('icon' => $icon, 'color' => $color, 'icon_size' => 'medium', 'icon_variant' => 'default')); ?>

        <span class="text-sm font-primary font-bold grow">
            <?php echo esc_html($document['title']); ?>
        </span>

        <?php echo wp_documentation_svg('arrow-right', 'w-4 h-4 text-frost-400 shrink-0'); ?>
    </a>
</div>
