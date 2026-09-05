<?php

if (!wp_documentation_is_pro()) {
    return;
}

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

?>
<div 
    x-data="docsCard"
    class="group flex flex-col border border-frost-200 bg-frost-0 p-8 hover:border-frost-1000 transition-colors h-full x-rounded-2xl overflow-hidden">
    <h3 class="font-bold font-primary text-lg text-frost-900 mb-3">
        <a href="<?php echo esc_url($document['permalink']); ?>" rel="bookmark" class="focus:outline-none">
            <?php echo esc_html($document['title']); ?>
        </a>
    </h3>

    <?php 
        $excerpt = get_post_field('post_excerpt', $document['ID']);
    ?>
    <?php if (!empty($excerpt)): ?>
        <p class="text-sm text-frost-600 leading-relaxed mb-6">
            <?php echo esc_html($excerpt); ?>
        </p>
    <?php endif; ?>
    
    <?php if(!empty($document['children'])): ?>
        <ul class="mt-auto flex flex-col gap-2">
            <?php foreach ($document['children'] as $index => $children): ?>
                <li>
                    <a 
                        class="text-xs font-medium text-frost-500 hover:text-frost-1000 transition-colors block hover:underline"
                        href="<?php echo esc_attr($children['permalink']); ?>">
                        <?php echo esc_html($children['title']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>