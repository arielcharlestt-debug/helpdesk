<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!empty($args)) {
    extract($args);
}

$cards = !empty($args['cards']) ? $args['cards'] : get_field('cards');

$theme_options = function_exists('get_field') ? get_field('wp_documentation_options', 'option') : [];
if (empty($theme_options)) {
    $theme_options = wp_documentation_get_default_options();
}

$colors = wp_documentation_get_palette_colors($theme_options);
$block_id = isset($block['id']) ? esc_attr($block['id']) : uniqid('cards-');
?>



<section id="<?php esc_attr($block_id); ?>" class="my-8 skip-prose"> 
  <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
    <?php foreach ($cards as $index => $card): $color = $colors[$index % count($colors)]; ?>
        <div x-data="docsCard" class="w-full h-full">
            <a 
                href="<?php echo esc_url(!empty($card['link']['url']) ? $card['link']['url'] : '#'); ?>"
                target="<?php echo esc_attr(!empty($card['link']['target']) ? $card['link']['target'] : '_self'); ?>"
                class="w-full h-full border border-frost-300 p-6 flex flex-col gap-4 justify-start items-start bg-frost-0 !text-frost-1000 !no-underline hover:border-frost-1000 x-rounded-2xl">
                <?php get_template_part('template-parts/docs-card--icon', null, array('icon' => $card['icon'], 'color' => $color)); ?>

                <span class="text-base font-primary font-semibold"><?php echo esc_html($card['title']); ?></span>
                <span class="text-sm"><?php echo esc_html($card['description']); ?></span>
                
                <div class="flex justify-start items-center gap-1 text-sm text-frost-500 mt-auto">
                    <span class="text-frost-500 font-semibold"><?php echo esc_html($card['link']['title']); ?></span>
                    <span class="w-4 h-4 inline-flex justify-center items-center"><?php echo wp_documentation_svg('chevron-right'); ?></span>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
  </div>
</section>