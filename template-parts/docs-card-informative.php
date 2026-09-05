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

<article
    class="group flex flex-col border border-frost-200 bg-frost-0 p-6 hover:border-frost-800 transition-colors h-full x-rounded-xl overflow-hidden">

    <div class="mb-5 flex items-start justify-between gap-4">
        <?php get_template_part('template-parts/docs-card--icon', null, array('icon' => $icon, 'color' => $color)); ?>
        <?php get_template_part('template-parts/docs-link-label', null, ['document' => $document]); ?>
    </div>
    
    <h3 class="font-bold text-lg font-primary text-frost-900 mb-2">
        <a href="<?php echo esc_url($document['permalink']); ?>" rel="bookmark" class="focus:outline-none">
            <?php echo esc_html($document['title']); ?>
        </a>
    </h3>

    <p class="text-sm text-frost-500 leading-relaxed mb-4">
        <?php echo esc_html(get_post_field('post_excerpt', $document['ID'])); ?>
    </p>

    <?php if(has_post_thumbnail($document['ID'])): ?>
        <div class="mb-4">
            <a href="<?php echo esc_url($document['permalink']); ?>" class="block w-full h-auto overflow-hidden">
                <?php echo get_the_post_thumbnail($document['ID'], 'medium_large', ['class' => 'w-full h-auto transition-transform group-hover:scale-105']); ?>
            </a>
        </div>
    <?php endif; ?>

    <?php if(!empty($document['children'])): ?>
		<?php $topics_limit = 5; ?>
        <div class="mt-2 flex flex-col self-stretch grow">
            <h4 class="text-xs font-bold uppercase tracking-widest text-frost-400 mb-3">
                <?php echo esc_html__('Topics', 'wp-documentation'); ?>
            </h4>
            <ul class="mb-6 space-y-1.5">
                <?php foreach (array_slice($document['children'], 0, $topics_limit) as $child): ?>
                    <li class="flex items-center gap-2 text-sm font-medium text-frost-600">
                        <span class="h-1 w-1 bg-frost-300 rounded-full"></span>
                        <a class="hover:underline font-semibold" href="<?php echo esc_url($child['permalink']); ?>">
                            <?php echo esc_html($child['title']); ?>
                        </a>                      
                    </li>
                <?php endforeach; ?>
            </ul>
            <a class="inline-flex capitalize mt-auto items-center gap-2 text-sm font-bold text-frost-900 hover:gap-3 transition-all border-t border-frost-100 w-full pt-4"
                href="<?php echo esc_url($document['permalink']); ?>">
                Read more in <?php echo esc_html($document['title']); ?> 
                <?php echo wp_documentation_svg('arrow-right', 'w-4 h-4 text-frost-400 group-hover:text-frost-600'); ?>
            </a>
        </div>
    <?php endif; ?>
</article>