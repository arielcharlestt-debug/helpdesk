<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
};

if (!empty($args)) {
    extract($args);
};

$labels = get_the_terms($document['ID'], 'doc_label');

$theme_options = function_exists('get_field') ? get_field('wp_documentation_options', 'option') : [];
if (empty($theme_options)) {
    $theme_options = wp_documentation_get_default_options();
}
$color_style = isset($theme_options['color_style']) ? $theme_options['color_style'] : 'colorful';

?>


<?php if ($labels && !is_wp_error($labels)): ?>
    <?php
        $label = (array) $labels[0];
        $label_color = get_field('color', 'doc_label_' . $label['term_id']);
        $label_icon = get_field('icon', 'doc_label_' . $label['term_id']);

        // Resolve the label background per color_style:
        //   colorful  -> per-label custom color (falls back to primary)
        //   neutral   -> gray (bg-gray-700)
        //   branded   -> primary
        if ($color_style === 'neutral') {
            $label_class = 'bg-gray-700 text-white';
        } elseif ($color_style === 'colorful' && !empty($label_color)) {
            $label_class = 'bg-[' . esc_attr($label_color) . '] text-white';
        } else {
            $label_class = 'bg-primary text-white';
        }
    ?>

    <span class="<?php echo $label_class; ?> text-[0.625rem] leading-none !font-bold px-1.5 py-1 rounded !no-underline ml-1 inline-flex justify-center items-center gap-1">
        <?php if (!empty($label_icon) && 'dashicons' === $label_icon['type']): ?>
            <i class="dashicons <?php echo esc_attr($label_icon['value']); ?> !text-[0.625rem] !w-auto !h-auto"></i>
        <?php endif; ?>

        <?php echo esc_html($label['name']); ?>
    </span>
<?php endif; ?>