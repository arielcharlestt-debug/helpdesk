<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

$theme_options = function_exists('get_field') ? get_field('wp_documentation_options', 'option') : [];
if (empty($theme_options)) {
    $theme_options = wp_documentation_get_default_options();
}

$colors = wp_documentation_get_palette_colors($theme_options);

$grid_size_classes = [
    2 => 'grid-cols-1 lg:grid-cols-2',
    3 => 'grid-cols-1 lg:grid-cols-3',
    4 => 'grid-cols-1 lg:grid-cols-4',
    5 => 'grid-cols-1 lg:grid-cols-5',
];

?>

<section id="" class="x-container my-8"> 
  <div class="grid <?php echo $grid_size_classes[$args['grid_size']]; ?> gap-6">
    <?php foreach ($args['items'] as $index => $item): $color = $colors[$index % count($colors)]; ?>
        <div x-data="docsCard" class="w-full h-full">
            <a 
                href="<?php echo esc_url(!empty($item['link']['url']) ? $item['link']['url'] : '#'); ?>"
                target="<?php echo esc_attr(!empty($item['link']['target']) ? $item['link']['target'] : '_self'); ?>"
                class="w-full h-full border border-frost-300 p-6 flex flex-col gap-2 justify-start items-start bg-frost-0 hover:border-frost-1000 x-rounded-2xl">
                <?php get_template_part('template-parts/docs-card--icon', null, array('icon' => $item['icon'], 'color' => $color)); ?>

                <?php if(!empty($item['title'])): ?>
                    <span class="text-base font-primary font-semibold mt-4">
                        <?php echo esc_html($item['title']); ?>
                    </span>
                <?php endif; ?>
                
                <?php if(!empty($item['description'])): ?>
                    <span class=""><?php echo esc_html($item['description']); ?></span>
                <?php endif; ?>
                
                <?php if(!empty($item['link'])): ?>
                    <div class="flex justify-start items-center gap-2 text-sm text-frost-500 mt-auto pt-4">
                        <span class="text-frost-500 font-semibold">
                            <?php echo esc_html($item['link']['title']); ?>
                        </span>
                        <span class="w-4 h-4 inline-flex justify-center items-center"><?php echo wp_documentation_svg('external-link'); ?></span>
                    </div>
                <?php endif; ?>
            </a>
        </div>
    <?php endforeach; ?>
  </div>
</section>