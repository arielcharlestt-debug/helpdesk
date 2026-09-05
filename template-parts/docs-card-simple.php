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
        class="w-full h-full border border-frost-300 p-6 flex flex-col gap-4 justify-start items-start bg-frost-0 hover:border-frost-1000 x-rounded-2xl overflow-hidden">
        <div class="flex justify-between items-start w-full">
            <?php get_template_part('template-parts/docs-card--icon', null, array('icon' => $icon, 'color' => $color, 'icon_size' => 'medium', 'icon_variant' => 'pastel')); ?>
            <?php echo wp_documentation_svg('arrow-right', 'w-4 h-4 text-frost-400'); ?>
        </div>

        <span class="text-base font-primary font-bold">
            <?php echo esc_html($document['title']); ?>
        </span>
        <?php 
            $excerpt = get_post_field('post_excerpt', $document['ID']);
        ?>
        <?php if (!empty($excerpt)): ?>
            <p class="text-sm leading-relaxed text-frost-600 font-normal">
                <?php echo esc_html($excerpt); ?>
            </p>
        <?php endif; ?>
    </a>
</div>
