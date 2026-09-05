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



<div 
    x-data="docsCard"
    class="group relative flex flex-col self-start border-frost-300 border-solid border bg-frost-0 x-rounded-lg overflow-hidden">
    <div class="p-8">
        <div class="flex items-start justify-between gap-4">
            <?php get_template_part('template-parts/docs-card--icon', null, array('icon' => $icon, 'color' => $color)); ?>
            <?php get_template_part('template-parts/docs-link-label', null, ['document' => $document]); ?>
        </div>

        <div class="mt-8">
            <h3 class="text-lg font-primary font-bold leading-6 text-frost-900">
                <a href="<?php echo esc_url($document['permalink']); ?>" rel="bookmark" class="focus:outline-none">
                    <?php echo esc_html($document['title']); ?>
                </a>
            </h3>

            <?php 
                $excerpt = get_post_field('post_excerpt', $document['ID']);
            ?>
            <?php if (!empty($excerpt)): ?>
                <p class="mt-4 text-base text-frost-700">
                    <?php echo esc_html($excerpt); ?>
                </p>
            <?php endif; ?>

            <?php if(has_post_thumbnail($document['ID'])): ?>
                <div class="mb-4 mt-4">
                    <a href="<?php echo esc_url($document['permalink']); ?>" class="block w-full h-auto overflow-hidden">
                        <?php echo get_the_post_thumbnail($document['ID'], 'medium_large', ['class' => 'w-full h-auto transition-transform group-hover:scale-105']); ?>
                    </a>
                </div>
            <?php endif; ?>

            <?php if (!empty($document['children'])): ?>
                <p class="mt-6 text-sm text-frost-700 font-semibold border-t border-frost-200 pt-4">
                    <?php echo count($document['children']); ?> <?php esc_html_e('Topics', 'wp-documentation'); ?>
                </p>
            <?php endif; ?>
        </div>
    </div>

    <div class="mt-auto">
        <?php if(!empty($document['children'])): ?>
            <ul class="text-base text-frost-700 flex flex-col border-t border-frost-200">
                <?php foreach ($document['children'] as $index => $children): ?>
                    <li 
                        data-index="<?php echo esc_attr($index); ?>"
                        x-show="isListItemVisible"
                        x-collapse>
                        <a class="flex justify-between items-center gap-4 w-full hover:underline hover:text-primary px-8 py-4 border-b border-frost-200 font-medium bg-frost-0 hover:bg-primary-50 transition-all" href="<?php echo esc_attr($children['permalink']); ?>">
                            <span>
                                <?php echo esc_html($children['title']); ?>
                                <?php get_template_part('template-parts/docs-link-label', null, ['document' => $children]); ?>    
                            </span>
                            <span class="ml-auto inline-flex self-stretch items-center">
                                <?php echo wp_documentation_svg('arrow-right', 'inline-block w-4 h-4 text-frost-400 group-hover:text-primary-600'); ?>
                            </span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

    <?php if (!empty($document['children']) && count($document['children']) > 5): ?>
        <button class="flex w-full items-center justify-center px-8 py-2 text-frost-600" x-on:click="toggleExpanded">
            <span x-show="isNotExpanded" aria-hidden="true"><?php echo wp_documentation_svg('chevron-down'); ?></span>
            <span x-cloak x-show="isExpanded" aria-hidden="true"><?php echo wp_documentation_svg('chevron-up'); ?></span>
        </button>
    <?php endif; ?>
</div>

