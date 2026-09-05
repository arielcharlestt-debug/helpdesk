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
    class="group flex flex-col border border-frost-200 bg-frost-0 transition-all x-rounded-2xl overflow-hidden duration-300 hover:border-<?php echo esc_attr($color); ?>-700">
    <div class="p-8 h-full flex flex-col">
        <div class="flex items-start justify-between mb-4">
            <div>
                <h3 class="text-xl font-primary font-bold text-frost-900 group-hover:text-<?php echo esc_attr($color); ?>-700 transition-colors">
                    <a href="<?php echo esc_url($document['permalink']); ?>" rel="bookmark" class="focus:outline-none">
                        <?php echo esc_html($document['title']); ?>
                    </a>
                </h3>

                <?php
                    $labels = get_the_terms($document['ID'], 'doc_label');  
                ?>

                <?php if ($labels && !is_wp_error($labels)): ?>
                    <div class="mt-2 font-mono text-[0.65rem] font-bold uppercase tracking-wider text-primary">
                        <?php
                        $first = true;
                        foreach ($labels as $label_term) {
                            $label = (array) $label_term;
                            if (!$first) echo ' · ';
                            echo esc_html($label['name']);
                            $first = false;
                        }
                        ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php get_template_part('template-parts/docs-card--icon', null, array('icon' => $icon, 'color' => $color, 'icon_size' => 'large', 'icon_variant' => 'pastel')); ?>
        </div>

        <?php 
            $excerpt = get_post_field('post_excerpt', $document['ID']);
        ?>
        <?php if (!empty($excerpt)): ?>
            <p class="text-sm leading-relaxed text-frost-600 font-normal">
                <?php echo esc_html($excerpt); ?>
            </p>
        <?php endif; ?>
     
        <?php if(!empty($document['children'])): ?>
            <div class="mt-8 space-y-3">
                <?php foreach ($document['children'] as $index => $children): ?>
                    <?php $icon = function_exists('get_field') ? get_field('icon', $children['ID']) : null;?>
                    <a 
                        class="flex items-center gap-3 text-sm font-medium text-frost-600 hover:underline hover:text-<?php echo esc_attr($color); ?>-700 transition-colors group/link"
                        href="<?php echo esc_url($children['permalink']); ?>">
                        <?php 
                            get_template_part('template-parts/docs-card--icon', null, array(
                                'icon' => $icon,
                                'color' => $color,
                                'icon_size' => 'x-small',
                                'icon_variant' => 'mono'
                            )); 
                        ?>
                        <span>
                            <?php echo esc_html($children['title']); ?>
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</article>