<?php
$theme_options = function_exists('get_field') ? get_field('wp_documentation_options', 'option') : [];
if (empty($theme_options)) {
    $theme_options = wp_documentation_get_default_options();
}
$color_style = isset($theme_options['color_style']) ? $theme_options['color_style'] : 'colorful';

$dot_color = wp_documentation_get_hero_dot_color($theme_options);

$color = $color_style === 'branded' ? 'primary' : 'frost';

// Subtitle pulse dot
$pulse_class = $color_style === 'neutral' ? 'bg-frost-1000' : 'bg-primary border-primary-200';


// Description left border
$desc_border_class = $color_style === 'branded' ? 'border-primary' : 'border-frost-1000';

// Background color
$bg_color_class = $color_style === 'branded' ? 'border-primary-200 bg-frost-0' : 'border-frost-200 bg-frost-0';

// Optional custom background image
$bg_image = !empty($args['background_image']['url']) ? $args['background_image'] : null;

// Primary CTA button
$primary_btn_class = 'group/btn inline-flex items-center border border-transparent x-rounded-2xl ' .
    ($color_style === 'neutral' ? 'bg-frost-1000 text-frost-0 hover:bg-frost-800' : 'bg-primary hover:bg-primary-800') .
    ' px-8 py-4 text-sm font-bold text-frost-0 transition-all hover:gap-3';
?>

<div class="x-container my-4">
    <div class="border <?php echo esc_attr($bg_color_class); ?> p-8 md:p-12 lg:p-14 relative overflow-hidden group x-rounded-2xl">
        <?php if ($bg_image): ?>
            <img
                src="<?php echo esc_url($bg_image['url']); ?>"
                alt="<?php echo esc_attr(!empty($bg_image['alt']) ? $bg_image['alt'] : ''); ?>"
                class="absolute inset-0 w-full h-full object-cover pointer-events-none" />
            <div class="absolute inset-0 pointer-events-none" style="background-color: var(--color-frost-0); opacity: 0;"></div>
        <?php else: ?>
            <div class="absolute inset-0 opacity-[0.02] pointer-events-none"
                style="background-image: radial-gradient(<?php echo esc_attr($dot_color); ?> 1px, transparent 1px); background-size: 24px 24px;">
            </div>
        <?php endif; ?>

        <div class="relative z-10 max-w-4xl">
            <?php if(!empty($args['subtitle'])): ?>
                <div
                    class="mb-6 inline-flex items-center gap-2 border border-frost-200 bg-transparent px-3 py-1 text-[11px] font-bold uppercase tracking-widest text-frost-0">
                    <?php echo esc_html(!empty($args['subtitle']) ? $args['subtitle'] : 'Version 1.5'); ?>
                </div>
            <?php endif; ?>

            <h1
                class="mb-6 font-secondary text-4xl md:text-5xl lg:text-6xl font-medium tracking-tight text-frost-0 leading-[1.1]">
                <?php echo !empty( $args["title"] ) ? esc_html( $args["title"] ) : esc_html__('Build better docs, 10x faster', 'wp-documentation'); ?>
            </h1>

            <div
                class="mb-10 max-w-2xl border-l-2 <?php echo esc_attr($desc_border_class); ?> pl-6 text-lg leading-relaxed text-frost-0">
                <?php echo !empty( $args["description"] ) ? wp_kses_post( $args["description"] ) : esc_html__('Comprehensive guides, API references, and tutorials to help you build amazing WordPress experiences.', 'wp-documentation'); ?>
            </div>

            <div class="flex flex-wrap gap-4">
                <?php if(!empty($args['link'])): ?>
                    <a
                        class="<?php echo esc_attr($primary_btn_class); ?> "
                        target="<?php echo esc_attr(!empty($args['link']['target']) ? $args['link']['target'] : '_self'); ?>"
                        href="<?php echo esc_url($args['link']['url']); ?>">
                        <?php echo esc_html(!empty($args['link']['title']) ? $args['link']['title'] : ''); ?>
                        <?php echo wp_documentation_svg('arrow-right', 'w-4 h-auto ml-4'); ?>
                    </a>
                <?php endif; ?>

                <?php if(!empty($args['link_secondary'])): ?>
                    <a
                        class="inline-flex items-center x-rounded-2xl border border-<?php echo esc_attr($color) ?>-300 bg-<?php echo esc_attr($color) ?>-0 px-8 py-4 text-sm font-bold text-<?php echo esc_attr($color) ?>-900 transition-colors hover:border-<?php echo esc_attr($color) ?>-900 hover:bg-<?php echo esc_attr($color) ?>-50"
                        target="<?php echo esc_attr(!empty($args['link_secondary']['target']) ? $args['link_secondary']['target'] : '_self'); ?>"
                        href="<?php echo esc_url($args['link_secondary']['url']); ?>">
                        <?php echo esc_html(!empty($args['link_secondary']['title']) ? $args['link_secondary']['title'] : ''); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>