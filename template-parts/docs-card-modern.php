<?php

if ($args) {
	extract($args);
}

$icon = function_exists('get_field') ? get_field('icon', $document['ID']) : null;
$excerpt = get_post_field('post_excerpt', $document['ID']);
$labels = get_the_terms($document['ID'], 'doc_label');

?>

<article
    class="group flex flex-col x-rounded-2xl overflow-hidden bg-frost-0 border border-<?php echo esc_attr($color); ?>-200 transition-all duration-300 hover:border-<?php echo esc_attr($color); ?>-700">
    <div class="bg-<?php echo esc_attr($color); ?>-50 colorful:bg-<?php echo esc_attr($color); ?>-900/10 p-8 border-b border-<?php echo esc_attr($color); ?>-100">
        <div class="flex items-center gap-3 mb-3">
            <?php get_template_part('template-parts/docs-card--icon', null, array('icon' => $icon, 'color' => $color, 'icon_size' => 'small', 'icon_variant' => 'colored')); ?>
            <h3 class="text-lg font-primary font-bold text-frost-900 group-hover:text-<?php echo esc_attr($color); ?>-900 dark:group-hover:text-<?php echo esc_attr($color); ?>-200 transition-colors"><a href="<?php echo esc_url($document['permalink']); ?>" rel="bookmark" class="focus:outline-none"><?php echo esc_html($document['title']); ?></a></h3>
        </div>
        <?php if (!empty($excerpt)): ?>
            <p class="text-sm text-frost-600 leading-relaxed">
                <?php echo esc_html($excerpt); ?>
            </p>
        <?php endif; ?>
    </div>
    <div class="p-8 flex flex-col gap-4">
        <?php if (!empty($document['children'])): ?>
            <?php foreach (array_slice($document['children'], 0, 3) as $index => $children): ?>
            <?php $child_icon = function_exists('get_field') ? get_field('icon', $children['ID']) : null;?>
            <a class="flex items-center gap-4 p-4 x-rounded-2xl border border-frost-200 hover:border-<?php echo esc_attr($color); ?>-500 hover:bg-<?php echo esc_attr($color); ?>-50/30 dark:hover:bg-<?php echo esc_attr($color); ?>-900/30 transition-all group/item bg-frost-50"
                href="<?php echo esc_url($children['permalink']); ?>">
                <div
                    class="flex h-8 w-8 shrink-0 x-rounded-2xl items-center justify-center bg-frost-0 border border-frost-200 text-<?php echo esc_attr($color); ?>-600">
                    <?php get_template_part('template-parts/docs-card--icon', null, array('icon' => $child_icon, 'color' => $color, 'icon_size' => 'x-small', 'icon_variant' => 'colored')); ?>
                </div>
                <div class="flex-1">
                    <div class="text-sm font-bold text-frost-900"><?php echo esc_html($children['title']); ?></div>
                </div>
                <?php echo wp_documentation_svg('chevron-right', 'inline-block w-4 h-4 text-' . esc_attr($color) . '-400 group-hover:text-' . esc_attr($color) . '-600'); ?>
            </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</article>